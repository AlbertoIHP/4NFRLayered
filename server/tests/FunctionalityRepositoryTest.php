<?php

use App\Models\Functionality;
use App\Repositories\FunctionalityRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class FunctionalityRepositoryTest extends TestCase
{
    use MakeFunctionalityTrait, ApiTestTrait, DatabaseTransactions;

    /**
     * @var FunctionalityRepository
     */
    protected $functionalityRepo;

    public function setUp()
    {
        parent::setUp();
        $this->functionalityRepo = App::make(FunctionalityRepository::class);
    }

    /**
     * @test create
     */
    public function testCreateFunctionality()
    {
        $functionality = $this->fakeFunctionalityData();
        $createdFunctionality = $this->functionalityRepo->create($functionality);
        $createdFunctionality = $createdFunctionality->toArray();
        $this->assertArrayHasKey('id', $createdFunctionality);
        $this->assertNotNull($createdFunctionality['id'], 'Created Functionality must have id specified');
        $this->assertNotNull(Functionality::find($createdFunctionality['id']), 'Functionality with given id must be in DB');
        $this->assertModelData($functionality, $createdFunctionality);
    }

    /**
     * @test read
     */
    public function testReadFunctionality()
    {
        $functionality = $this->makeFunctionality();
        $dbFunctionality = $this->functionalityRepo->find($functionality->id);
        $dbFunctionality = $dbFunctionality->toArray();
        $this->assertModelData($functionality->toArray(), $dbFunctionality);
    }

    /**
     * @test update
     */
    public function testUpdateFunctionality()
    {
        $functionality = $this->makeFunctionality();
        $fakeFunctionality = $this->fakeFunctionalityData();
        $updatedFunctionality = $this->functionalityRepo->update($fakeFunctionality, $functionality->id);
        $this->assertModelData($fakeFunctionality, $updatedFunctionality->toArray());
        $dbFunctionality = $this->functionalityRepo->find($functionality->id);
        $this->assertModelData($fakeFunctionality, $dbFunctionality->toArray());
    }

    /**
     * @test delete
     */
    public function testDeleteFunctionality()
    {
        $functionality = $this->makeFunctionality();
        $resp = $this->functionalityRepo->delete($functionality->id);
        $this->assertTrue($resp);
        $this->assertNull(Functionality::find($functionality->id), 'Functionality should not exist in DB');
    }
}
