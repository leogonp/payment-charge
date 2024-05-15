<?php

declare(strict_types=1);

namespace Tests\Unit\Domain\Entities;

use App\Domain\Entities\PaymentEntity;
use App\Domain\ValueObjects\UUID;
use DateTimeImmutable;
use Tests\TestCase;

class PaymentEntityTest extends TestCase
{
    public function testWillBuildFromArray(): void
    {
        $data = [
            'name' => 'dsadsadsa',
            'government_id' => '1234567',
            'email' => 'dsadsadsa@gmail.com',
            'debt_amount' => 233,
            'debt_due_date' => '2024-05-14',
            'debt_id' => '6286601a-3412-4cc2-be93-fd1f093740c6',
        ];

        $entity = PaymentEntity::fromArray($data);

        $this->assertEquals($data['name'], $entity->name);
        $this->assertEquals($data['government_id'], $entity->governmentId);
        $this->assertEquals($data['email'], $entity->email);
        $this->assertEquals($data['debt_amount'], $entity->debtAmount);
        $this->assertEquals($data['debt_due_date'], $entity->debtDueDate->format('Y-m-d'));
        $this->assertEquals($data['debt_id'], (string) $entity->debtId);
    }

    public function testWillConvertToArray(): void
    {
        $entity = new PaymentEntity(
            name: 'dsadsadsa',
            governmentId: '1234567',
            email: 'dsadsadsa@gmail.com',
            debtAmount: 233,
            debtDueDate: new DateTimeImmutable('2024-05-14'),
            debtId: new UUID('6286601a-3412-4cc2-be93-fd1f093740c6'),
        );

        $dataArray = $entity->toArray();

        $this->assertEquals($entity->name, $dataArray['name']);
        $this->assertEquals($entity->governmentId, $dataArray['government_id']);
        $this->assertEquals($entity->email, $dataArray['email']);
        $this->assertEquals($entity->debtAmount, $dataArray['debt_amount']);
        $this->assertEquals($entity->debtDueDate->format('Y-m-d'), $dataArray['debt_due_date']);
        $this->assertEquals((string) $entity->debtId, $dataArray['debt_id']);
    }
}
