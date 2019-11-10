<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Hash;
use App\User;
use App\Order;

class OrderTest extends TestCase
{

    use DatabaseMigrations;

    private $api_auth = '/api/auth';
    private $api_Order = '/api/Order';
    private $Order = [
        'value' => 'Example Order.',
        'status' => 'new'
    ];

    /** @test */
    public function unregisteredUserCannotStoreOrder()
    {
        $response = $this->json('POST', $this->api_Order, $this->Order);
        $response->assertStatus(401);
    }

    /** @test */
    public function registeredUserCanStoreOrder()
    {

        $user = factory(User::class)->create();
        $response = $this->actingAs($user)->json('POST', $this->api_Order, $this->Order);
        $response->assertStatus(201);

        $this->assertDatabaseHas('Orders', [
            'id' => $response->getData()->id,
        ]);
    }

    /** @test */
    public function userCanDeleteTheirOrder()
    {
        $user = factory(User::class)->create();
        $Order = factory(Order::class)->create(['user_id' => $user->id]);

        $endpoint = $this->api_Order . '/' . $Order->id;

        $response = $this->actingAs($user)->json('DELETE', $endpoint);
        $response->assertStatus(204);

        $this->assertDatabaseMissing('Orders', [
            'id' => $Order->id,
        ]);
    }

    /** @test */
    public function userCannotDeleteDifferentUserOrder()
    {
        $user = factory(User::class)->create();
        $author = factory(User::class)->create();
        $Order = factory(Order::class)->create(['user_id' => $author->id]);

        $endpoint = $this->api_Order . '/' . $Order->id;

        $response = $this->actingAs($user)->json('DELETE', $endpoint);
        $response->assertStatus(401);

        $this->assertDatabaseHas('Orders', [
            'id' => $Order->id,
        ]);
    }

    /** @test */
    public function userCanPatchTheirOrder()
    {
        $user = factory(User::class)->create();
        $Order = factory(Order::class)->create([
            'user_id' => $user->id,
            'status' => 'new'
        ]);

        $endpoint = $this->api_Order . '/' . $Order->id;

        $response = $this->actingAs($user)->json('PATCH', $endpoint, ['status' => 'delivered']);
        $response->assertStatus(200);

        $this->assertDatabaseHas('Orders', [
            'id' => $Order->id,
            'status' => 'delivered'
        ]);
    }

    /** @test */
    public function userCannotPatchDifferentUserOrder()
    {
        $user = factory(User::class)->create();
        $author = factory(User::class)->create();
        $Order = factory(Order::class)->create([
            'user_id' => $author->id,
            'status' => 'new'
        ]);

        $endpoint = $this->api_Order . '/' . $Order->id;

        $response = $this->actingAs($user)->json('PATCH', $endpoint, ['status' => 'delivered']);
        $response->assertStatus(401);

        $this->assertDatabaseHas('Orders', [
            'id' => $Order->id,
            'status' => 'new'
        ]);
    }

    /** @test */
    public function userCanGetTheirOrders()
    {
        $user = factory(User::class)->create();
        $Order = factory(Order::class, 20)->create([
            'user_id' => $user->id,
            'status' => 'new'
        ]);
        $Order = factory(Order::class, 30)->create([
            'user_id' => $user->id,
            'status' => 'delivered'
        ]);

        // Verifies Order count is correct at /Orders endpoints.
        $response = $this->actingAs($user)->json('GET', $this->api_Order);
        $response->assertStatus(200);
        $this->assertEquals(50, $response->getData()->meta->total);

        // Verifies Order count is when 'new' query string is set.
        $response = $this->actingAs($user)->json('GET', $this->api_Order . '?status=new');
        $response->assertStatus(200);

        // Verifies pagination is working correctly with query string.
        $this->assertEquals(20, $response->getData()->meta->total);
        $this->assertStringContainsString('status=new&page=2', $response->getData()->links->next);

        // Verifies Order count is when 'delivered' query string is set.
        $response = $this->actingAs($user)->json('GET', $this->api_Order . '?status=delivered');
        $response->assertStatus(200);

        // Verifies pagination is working correctly with query string.
        $this->assertEquals(30, $response->getData()->meta->total);
        $this->assertStringContainsString('status=delivered&page=2', $response->getData()->links->next);
    }
}
