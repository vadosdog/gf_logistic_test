<?php

namespace App\Tests;

use App\Models\Delivery;
use Illuminate\Support\Facades\Event;

class DeliveryTest extends TestCase
{

    public ?Delivery $delivery = null;

    public function setUp(): void
    {
        parent::setUp();

        Event::fake();

        $this->delivery = Delivery::factory()->create(['status' => 'planned']);
    }

    public function testCorrectFlow()
    {
        // 1. Отгрузка (shipped)
        $response = $this->post('deliveries/' . $this->delivery->id . '/status-change', ['status' => 'shipped']);
        $response->assertOk();
        $this->assertDatabaseHas('deliveries', ['id' => $this->delivery->id, 'status' => 'shipped']);

        // 2. Доставлен (delivered)
        $response = $this->post('deliveries/' . $this->delivery->id . '/status-change', ['status' => 'delivered']);
        $response->assertOk();
        $this->assertDatabaseHas('deliveries', ['id' => $this->delivery->id, 'status' => 'delivered']);

    }

    public function testCannotChangeToPreviousStatus()
    {
        // 1. Отгрузка (shipped)
        $response = $this->post('deliveries/' . $this->delivery->id . '/status-change', ['status' => 'shipped']);
        $response->assertOk();
        $this->assertDatabaseHas('deliveries', ['id' => $this->delivery->id, 'status' => 'shipped']);

        // 2. Попытка вернуться на предыдущий статус (planned)
        $response = $this->post('deliveries/' . $this->delivery->id . '/status-change', ['status' => 'planned']);
        $response->assertStatus(400);
        $response->assertJson(['success' => false, 'message' => 'неверный статус для смены']);

        // Статус не должен измениться в базе данных
        $this->assertDatabaseHas('deliveries', ['id' => $this->delivery->id, 'status' => 'shipped']);
    }
}
