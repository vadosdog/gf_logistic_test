<?php

namespace App\Tests;

use App\Events\DeliveryDelivered;
use App\Models\Delivery;
use Illuminate\Support\Facades\Event;

/**
 * @group Delivery
 */
class DeliveryTest extends TestCase
{
    public ?Delivery $delivery = null;

    public function setUp(): void
    {
        parent::setUp();

        Event::fake([
            DeliveryDelivered::class,
        ]);
    }

    public function testCorrectFlow()
    {
        $delivery = Delivery::factory()->create();

        // Отгрузка
        $response = $this->post('deliveries/' . $delivery->id . '/status-change', ['status' => 'shipped']);
        $response->assertOk();
        $this->assertDatabaseHas('deliveries', ['id' => $delivery->id, 'status' => 'shipped']);

        // Доставлен
        $response = $this->post('deliveries/' . $delivery->id . '/status-change', ['status' => 'delivered']);
        $response->assertOk();
        $this->assertDatabaseHas('deliveries', ['id' => $delivery->id, 'status' => 'delivered']);
        Event::assertDispatched(DeliveryDelivered::class);

        // Отменен
        $delivery = Delivery::factory()->create();
        $response = $this->post('deliveries/' . $delivery->id . '/status-change', ['status' => 'cancelled', 'reason' => 'test'], ['Accept' => 'application/json']);
        $response->assertOk();
        $this->assertDatabaseHas('deliveries', ['id' => $delivery->id, 'status' => 'cancelled']);

    }

    public function testIncorrectFlow()
    {
        $delivery = Delivery::factory()->create();
        $response = $this->post('deliveries/' . $delivery->id . '/status-change', ['status' => 'delivered']);
        $response->assertBadRequest();
        $this->assertDatabaseHas('deliveries', ['id' => $delivery->id, 'status' => 'planned']);

        $delivery->status = 'delivered';
        $delivery->save();

        $response = $this->post('deliveries/' . $delivery->id . '/status-change', ['status' => 'shipped']);
        $response->assertBadRequest();
        $this->assertDatabaseHas('deliveries', ['id' => $delivery->id, 'status' => 'delivered']);
    }

    public function testValidationErrors()
    {
        $delivery = Delivery::factory()->create();
        $response = $this->post('deliveries/' . $delivery->id . '/status-change', ['status' => 'fake'], ['Accept' => 'application/json']);
        $response->assertJsonValidationErrors('status');
    }

    public function testAdditionalFields()
    {
        $delivery = Delivery::factory()->create();

        $response = $this->post('deliveries/' . $delivery->id . '/status-change', ['status' => 'cancelled', 'reason' => 'test']);
        $response->assertOk();

        $response = $this->post('deliveries/' . $delivery->id . '/status-change', ['status' => 'cancelled'], ['Accept' => 'application/json']);
        $response->assertUnprocessable();
    }
}
