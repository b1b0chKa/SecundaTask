<?php

namespace Tests\Feature;

use App\Http\Middleware\ApiKeyMiddleware;
use App\Models\Building;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BuildingControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->withMiddleware(ApiKeyMiddleware::class);
    }


    public function index_returns_buildings_successfully()
    {
        Building::factory()->count(2)->create();

        $response = $this->getJson('/api/buildings');

        $response->assertStatus(200)
                 ->assertJson([
                     'status' => true,
                     'message' => 'Все здания найдены',
                 ]);

        $this->assertCount(2, $response->json('data'));
    }


    public function index_returns_error_when_no_buildings()
    {
        $response = $this->getJson('/api/buildings');

        $response->assertStatus(404)
                 ->assertJson([
                     'status' => false,
                     'error'  => ['message' => 'Данные не найдены'],
                 ]);
    }
}
