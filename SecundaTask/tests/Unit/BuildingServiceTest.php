<?php

namespace Tests\Unit;

use App\Models\Building;
use App\Services\BuildingService;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Collection;
use Tests\TestCase;

class BuildingServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_get_returns_all_buildings()
    {
        Building::factory(3)->create();

        $service = new BuildingService;
        $buildings = $service->getAll();

        $this->assertCount(3, $buildings);
        $this->assertInstanceOf(Collection::class, $buildings);
        $this->assertInstanceOf(Building::class, $buildings->first());
    }


    public function test_get_returns_empty_collections_when_no_buildings()
    {
        $service = new BuildingService();
        $buildings = $service->getAll();

        $this->assertEmpty($buildings);
    }
}
