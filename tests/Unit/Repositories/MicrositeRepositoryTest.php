<?php

namespace Tests\Unit\Infrastructure\Persistence;

use App\Domains\Microsite\Models\Microsite;
use App\Infrastructure\Persistence\MicrositeRepositoryEloquent;
use Database\Factories\MicrositeFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MicrositeRepositoryTest extends TestCase
{
    use RefreshDatabase;

    protected MicrositeRepositoryEloquent $repository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repository = new MicrositeRepositoryEloquent();
    }

    public function testAll()
    {
        MicrositeFactory::new()->count(3)->create();

        $result = $this->repository->all();

        $this->assertCount(3, $result);
        $this->assertInstanceOf(Microsite::class, $result->first());
    }

    public function testFind()
    {
        $microsite = MicrositeFactory::new()->create();

        $result = $this->repository->find($microsite->id);

        $this->assertInstanceOf(Microsite::class, $result);
        $this->assertEquals($microsite->id, $result->id);
    }

    public function testCreate()
    {
        $data = MicrositeFactory::new()->raw();

        $result = $this->repository->create($data);

        $this->assertInstanceOf(Microsite::class, $result);
        $this->assertDatabaseHas('microsites', $data);
    }

    public function testUpdate()
    {
        $microsite = MicrositeFactory::new()->create();
        $newData = ['name' => 'Updated Microsite'];

        $result = $this->repository->update($microsite->id, $newData);

        $this->assertTrue($result);
        $this->assertDatabaseHas('microsites', ['id' => $microsite->id, 'name' => 'Updated Microsite']);
    }

    public function testDelete()
    {
        $microsite = MicrositeFactory::new()->create();

        $result = $this->repository->delete($microsite->id);

        $this->assertTrue($result);
        $this->assertDatabaseMissing('microsites', ['id' => $microsite->id]);
    }

    public function testPaginate()
    {
        MicrositeFactory::new()->count(20)->create();

        $result = $this->repository->paginate(10);

        $this->assertInstanceOf(\Illuminate\Pagination\LengthAwarePaginator::class, $result);
        $this->assertCount(10, $result->items());
        $this->assertEquals(20, $result->total());
    }
}
