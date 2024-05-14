<?php

namespace App\Infrastructure\Providers;

use App\Domain\Producer\Producer;
use App\Domain\Repositories\ImportedFilesRepositoryInterface;
use App\Infrastructure\Producer\KafkaProducer;
use App\Infrastructure\Repositories\EloquentImportedFilesRepository;
use Illuminate\Support\ServiceProvider;
use RdKafka\Conf;

class AppServiceProvider extends ServiceProvider
{

    public function register(): void
    {
        $this->registerRepositories();
        $this->registerProducers();
    }

    public function boot(): void
    {
        //
    }

    private function registerRepositories(): void
    {
        $this->app->bind(ImportedFilesRepositoryInterface::class, EloquentImportedFilesRepository::class);
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
                topicName: config('kafka.transaction_topic_name'),
                millisecondsToWait: 2000
            );
        });
    }
}
