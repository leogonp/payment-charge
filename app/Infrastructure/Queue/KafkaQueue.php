<?php

declare(strict_types=1);

namespace App\Infrastructure\Queue;

use App\Application\Services\ProcessPaymentService;
use App\Domain\Queue\QueueInterface;
use RdKafka\KafkaConsumer;
use RdKafka\Message as RDKafkaMessage;

class KafkaQueue implements QueueInterface
{
    public function __construct(
        private KafkaConsumer $consumer,
        private string $topic,
        private int $timeout,
    ) {
    }

    public function bootstrap(): void
    {
        $this->consumer->subscribe([$this->topic]);
    }

    public function run(): void
    {
        $this->bootstrap();

        echo "Consumindo mensagens do tópico $this->topic\n";

        while (true) {
            $message = $this->consumer->consume($this->timeout);

            if ($message !== null) {
                echo match ($message->err) {
                    RD_KAFKA_RESP_ERR_NO_ERROR => $this->handleMessage($message),
                    RD_KAFKA_RESP_ERR__PARTITION_EOF => "Fim da partição, não há mais mensagens.\n",
                    RD_KAFKA_RESP_ERR__TIMED_OUT => "Tempo limite de espera atingido.\n",
                    default => "Erro ao consumir mensagem: {$message->errstr()}.\n",
                };
            }
        }
    }

    private function handleMessage(RDKafkaMessage $message): string
    {
        $messageEntity = $this->parseMessage($message);

        app(ProcessPaymentService::class)($messageEntity->getPayload());

        return 'Nova mensagem: ' . $message->payload . "\n";
    }

    private function parseMessage(RDKafkaMessage $message): Message
    {
        $payload = json_decode($message->payload, true);

        return new Message($payload, $message);
    }
}
