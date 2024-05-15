<?php

declare(strict_types=1);

namespace App\Infrastructure\Providers;

use App\Domain\Producer\Producer;
use App\Domain\Queue\QueueInterface;
use App\Domain\Repositories\FailedPaymentRepositoryInterface;
use App\Domain\Repositories\ImportedFilesRepositoryInterface;
use App\Domain\Repositories\ProcessedPaymentRepositoryInterface;
use App\Infrastructure\Producer\KafkaProducer;
use App\Infrastructure\Queue\KafkaQueue;
use App\Infrastructure\Repositories\EloquentFailedPaymentRepository;
use App\Infrastructure\Repositories\EloquentImportedFilesRepository;
use App\Infrastructure\Repositories\EloquentProcessedPaymentRepository;
use Illuminate\Support\ServiceProvider;
use RdKafka\Conf;
use RdKafka\KafkaConsumer;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->registerRepositories();
        $this->registerConsumers();
        $this->registerProducers();
    }

    public function boot(): void
    {
        //
    }

    private function registerRepositories(): void
    {
        $this->app->bind(ImportedFilesRepositoryInterface::class, EloquentImportedFilesRepository::class);
        $this->app->bind(ProcessedPaymentRepositoryInterface::class, EloquentProcessedPaymentRepository::class);
        $this->app->bind(FailedPaymentRepositoryInterface::class, EloquentFailedPaymentRepository::class);
    }

    private function registerConsumers(): void
    {
        $this->app->bind(QueueInterface::class, function () {
            $consumerName = config('kafka.payment_charge_consumer_name');

            $config = new Conf();
            $config->set('metadata.broker.list', config('kafka.brokers'));
            $config->set('enable.auto.commit', 'false');
            $config->set('enable.partition.eof', '1');
            $config->set('auto.offset.reset', 'earliest');
            $config->set('group.id', $consumerName);

            $consumer = new KafkaConsumer($config);

            return new KafkaQueue(
                $consumer,
                config('kafka.payment_charge_topic_name'),
                config('kafka.payment_charge_timeout')
            );
        });
    }

    private function registerProducers(): void
    {
        $this->app->bind(Producer::class, function () {
            $conf = new Conf();

            $conf->set('request.required.acks', '1');
            $conf->set('delivery.timeout.ms', '500');
            $conf->set('request.timeout.ms', '500');
            $conf->set('metadata.broker.list', config('kafka.brokers'));

            return new KafkaProducer(
                config: $conf,
                topicName: config('kafka.payment_charge_topic_name'),
                millisecondsToWait: 2000
            );
        });
    }
}
