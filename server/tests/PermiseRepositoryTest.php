<?php

use App\Models\Permise;
use App\Repositories\PermiseRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class PermiseRepositoryTest extends TestCase
{
    use MakePermiseTrait, ApiTestTrait, DatabaseTransactions;

    /**
     * @var PermiseRepository
     */
    protected $permiseRepo;

    public function setUp()
    {
        parent::setUp();
        $this->permiseRepo = App::make(PermiseRepository::class);
    }

    /**
     * @test create
     */
    public function testCreatePermise()
    {
        $permise = $this->fakePermiseData();
        $createdPermise = $this->permiseRepo->create($permise);
        $createdPermise = $createdPermise->toArray();
        $this->assertArrayHasKey('id', $createdPermise);
        $this->assertNotNull($createdPermise['id'], 'Created Permise must have id specified');
        $this->assertNotNull(Permise::find($createdPermise['id']), 'Permise with given id must be in DB');
        $this->assertModelData($permise, $createdPermise);
    }

    /**
     * @test read
     */
    public function testReadPermise()
    {
        $permise = $this->makePermise();
        $dbPermise = $this->permiseRepo->find($permise->id);
        $dbPermise = $dbPermise->toArray();
        $this->assertModelData($permise->toArray(), $dbPermise);
    }

    /**
     * @test update
     */
    public function testUpdatePermise()
    {
        $permise = $this->makePermise();
        $fakePermise = $this->fakePermiseData();
        $updatedPermise = $this->permiseRepo->update($fakePermise, $permise->id);
        $this->assertModelData($fakePermise, $updatedPermise->toArray());
        $dbPermise = $this->permiseRepo->find($permise->id);
        $this->assertModelData($fakePermise, $dbPermise->toArray());
    }

    /**
     * @test delete
     */
    public function testDeletePermise()
    {
        $permise = $this->makePermise();
        $resp = $this->permiseRepo->delete($permise->id);
        $this->assertTrue($resp);
        $this->assertNull(Permise::find($permise->id), 'Permise should not exist in DB');
    }
}
