<?php

declare(strict_types=1);

return [
    'brokers' => env('KAFKA_BROKERS', 'kafka:9092'),
    'payment_charge_topic_name' => env('PAYMENT_CHARGE_TOPIC_NAME', 'payment-charge.events'),
    'payment_charge_consumer_name' => env('PAYMENT_CHARGE_CONSUMER_NAME', 'payment-charge-consumer'),
    'payment_charge_timeout' => env('PAYMENT_CHARGE_TIMEOUT', 1000),
];
