<?php

use App\Models\Softgoal;
use App\Repositories\SoftgoalRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class SoftgoalRepositoryTest extends TestCase
{
    use MakeSoftgoalTrait, ApiTestTrait, DatabaseTransactions;

    /**
     * @var SoftgoalRepository
     */
    protected $softgoalRepo;

    public function setUp()
    {
        parent::setUp();
        $this->softgoalRepo = App::make(SoftgoalRepository::class);
    }

    /**
     * @test create
     */
    public function testCreateSoftgoal()
    {
        $softgoal = $this->fakeSoftgoalData();
        $createdSoftgoal = $this->softgoalRepo->create($softgoal);
        $createdSoftgoal = $createdSoftgoal->toArray();
        $this->assertArrayHasKey('id', $createdSoftgoal);
        $this->assertNotNull($createdSoftgoal['id'], 'Created Softgoal must have id specified');
        $this->assertNotNull(Softgoal::find($createdSoftgoal['id']), 'Softgoal with given id must be in DB');
        $this->assertModelData($softgoal, $createdSoftgoal);
    }

    /**
     * @test read
     */
    public function testReadSoftgoal()
    {
        $softgoal = $this->makeSoftgoal();
        $dbSoftgoal = $this->softgoalRepo->find($softgoal->id);
        $dbSoftgoal = $dbSoftgoal->toArray();
        $this->assertModelData($softgoal->toArray(), $dbSoftgoal);
    }

    /**
     * @test update
     */
    public function testUpdateSoftgoal()
    {
        $softgoal = $this->makeSoftgoal();
        $fakeSoftgoal = $this->fakeSoftgoalData();
        $updatedSoftgoal = $this->softgoalRepo->update($fakeSoftgoal, $softgoal->id);
        $this->assertModelData($fakeSoftgoal, $updatedSoftgoal->toArray());
        $dbSoftgoal = $this->softgoalRepo->find($softgoal->id);
        $this->assertModelData($fakeSoftgoal, $dbSoftgoal->toArray());
    }

    /**
     * @test delete
     */
    public function testDeleteSoftgoal()
    {
        $softgoal = $this->makeSoftgoal();
        $resp = $this->softgoalRepo->delete($softgoal->id);
        $this->assertTrue($resp);
        $this->assertNull(Softgoal::find($softgoal->id), 'Softgoal should not exist in DB');
    }
}
