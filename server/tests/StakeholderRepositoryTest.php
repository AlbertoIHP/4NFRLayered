<?php

use App\Models\Stakeholder;
use App\Repositories\StakeholderRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class StakeholderRepositoryTest extends TestCase
{
    use MakeStakeholderTrait, ApiTestTrait, DatabaseTransactions;

    /**
     * @var StakeholderRepository
     */
    protected $stakeholderRepo;

    public function setUp()
    {
        parent::setUp();
        $this->stakeholderRepo = App::make(StakeholderRepository::class);
    }

    /**
     * @test create
     */
    public function testCreateStakeholder()
    {
        $stakeholder = $this->fakeStakeholderData();
        $createdStakeholder = $this->stakeholderRepo->create($stakeholder);
        $createdStakeholder = $createdStakeholder->toArray();
        $this->assertArrayHasKey('id', $createdStakeholder);
        $this->assertNotNull($createdStakeholder['id'], 'Created Stakeholder must have id specified');
        $this->assertNotNull(Stakeholder::find($createdStakeholder['id']), 'Stakeholder with given id must be in DB');
        $this->assertModelData($stakeholder, $createdStakeholder);
    }

    /**
     * @test read
     */
    public function testReadStakeholder()
    {
        $stakeholder = $this->makeStakeholder();
        $dbStakeholder = $this->stakeholderRepo->find($stakeholder->id);
        $dbStakeholder = $dbStakeholder->toArray();
        $this->assertModelData($stakeholder->toArray(), $dbStakeholder);
    }

    /**
     * @test update
     */
    public function testUpdateStakeholder()
    {
        $stakeholder = $this->makeStakeholder();
        $fakeStakeholder = $this->fakeStakeholderData();
        $updatedStakeholder = $this->stakeholderRepo->update($fakeStakeholder, $stakeholder->id);
        $this->assertModelData($fakeStakeholder, $updatedStakeholder->toArray());
        $dbStakeholder = $this->stakeholderRepo->find($stakeholder->id);
        $this->assertModelData($fakeStakeholder, $dbStakeholder->toArray());
    }

    /**
     * @test delete
     */
    public function testDeleteStakeholder()
    {
        $stakeholder = $this->makeStakeholder();
        $resp = $this->stakeholderRepo->delete($stakeholder->id);
        $this->assertTrue($resp);
        $this->assertNull(Stakeholder::find($stakeholder->id), 'Stakeholder should not exist in DB');
    }
}
