<?php

namespace Tests\Unit\Services;

use App\Domains\Microsite\Models\Microsite;
use App\Domains\Microsite\Repositories\MicrositeRepository;
use App\Domains\Microsite\Services\MicrositeService;
use Database\Factories\MicrositeFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Mockery;
use Tests\TestCase;

class MicrositeServiceTest extends TestCase
{
    use RefreshDatabase;

    protected $micrositeRepositoryMock;

    protected $micrositeService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->micrositeRepositoryMock = Mockery::mock(MicrositeRepository::class);
        $this->micrositeService = new MicrositeService($this->micrositeRepositoryMock);
    }

    public function testCreateMicrosite()
    {
        Storage::fake('public');

        $data = [
            'name' => 'Test Microsite',
            'logo' => UploadedFile::fake()->image('logo.jpg'),
            'category_id' => 1,
            'currency' => 'USD',
            'payment_expiration' => 30,
            'type' => 'basic',
        ];

        $expectedPath = 'storage/microsites/logo.jpg';

        $this->micrositeRepositoryMock->shouldReceive('create')
            ->once()
            ->andReturnUsing(function ($arg) use ($expectedPath) {
                $this->assertEquals($expectedPath, $arg['logo']);

                return new Microsite($arg);
            });

        $result = $this->micrositeService->createMicrosite($data);

        $this->assertInstanceOf(Microsite::class, $result);
    }

    public function testGetMicrositeById()
    {
        $micrositeMock = Mockery::mock(Microsite::class);
        $this->micrositeRepositoryMock->shouldReceive('find')
            ->with(1)
            ->once()
            ->andReturn($micrositeMock);

        $result = $this->micrositeService->getMicrositeById(1);
        $this->assertInstanceOf(Microsite::class, $result);
    }

    public function testUpdateMicrosite()
    {
        Storage::fake('public');

        $oldMicrosite = MicrositeFactory::new()->create();

        $newData = [
            'name' => 'Updated Microsite',
            'logo' => UploadedFile::fake()->image('new_logo.jpg'),
        ];

        $this->micrositeRepositoryMock->shouldReceive('find')
            ->with($oldMicrosite->id)
            ->once()
            ->andReturn($oldMicrosite);

        $this->micrositeRepositoryMock->shouldReceive('update')
            ->with($oldMicrosite->id, Mockery::on(function ($data) use ($newData) {
                return $data['name'] === $newData['name'] && $data['logo'] === 'storage/microsites/new_logo.jpg';
            }))
            ->once()
            ->andReturn(true);

        $result = $this->micrositeService->updateMicrosite($oldMicrosite->id, $newData);
        $this->assertTrue($result);
    }

    public function testDeleteMicrosite()
    {
        Storage::fake('public');

        $microsite = MicrositeFactory::new()->create(['logo' => 'storage/microsites/logo.jpg']);

        $this->micrositeRepositoryMock->shouldReceive('find')
            ->with($microsite->id)
            ->once()
            ->andReturn($microsite);

        $this->micrositeRepositoryMock->shouldReceive('delete')
            ->with($microsite->id)
            ->once()
            ->andReturn(true);

        $result = $this->micrositeService->deleteMicrosite($microsite->id);
        $this->assertTrue($result);

        Storage::disk('public')->assertMissing('microsites/logo.jpg');
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}
