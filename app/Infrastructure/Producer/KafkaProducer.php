<?php

declare(strict_types=1);

namespace App\Infrastructure\Producer;

use App\Domain\Producer\Producer;
use RdKafka\Conf;
use RdKafka\Producer as KProducer;
use RuntimeException;

class KafkaProducer extends KProducer implements Producer
{
    public function __construct(
        private Conf $config,
        private string $topicName,
        private int $millisecondsToWait = 1000
    ) {
        parent::__construct($config);
    }

    /**
     * @throws RuntimeException
     */
    public function produce(string $message): void
    {
        $topic = $this->newTopic($this->topicName);
        $topic->produce(RD_KAFKA_PARTITION_UA, 0, $message);

        for ($flushRetries = 0; $flushRetries < 3; $flushRetries++) {
            $result = $this->flush($this->millisecondsToWait);
            if (RD_KAFKA_RESP_ERR_NO_ERROR === $result) {
                break;
            }
        }

        if (RD_KAFKA_RESP_ERR_NO_ERROR !== $result) {
            throw new RuntimeException('Was unable to flush, messages might be lost!');
        }
    }
}
