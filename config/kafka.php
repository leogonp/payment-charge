<?php

declare(strict_types=1);

return [
    'brokers' => env('KAFKA_BROKERS', 'kafka:9092'),
    'transaction_topic_name' => env('TRANSACTION_TOPIC_NAME', 'payment-charge.events'),
];
