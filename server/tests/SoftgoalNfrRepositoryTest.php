<?php

use App\Models\SoftgoalNfr;
use App\Repositories\SoftgoalNfrRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class SoftgoalNfrRepositoryTest extends TestCase
{
    use MakeSoftgoalNfrTrait, ApiTestTrait, DatabaseTransactions;

    /**
     * @var SoftgoalNfrRepository
     */
    protected $softgoalNfrRepo;

    public function setUp()
    {
        parent::setUp();
        $this->softgoalNfrRepo = App::make(SoftgoalNfrRepository::class);
    }

    /**
     * @test create
     */
    public function testCreateSoftgoalNfr()
    {
        $softgoalNfr = $this->fakeSoftgoalNfrData();
        $createdSoftgoalNfr = $this->softgoalNfrRepo->create($softgoalNfr);
        $createdSoftgoalNfr = $createdSoftgoalNfr->toArray();
        $this->assertArrayHasKey('id', $createdSoftgoalNfr);
        $this->assertNotNull($createdSoftgoalNfr['id'], 'Created SoftgoalNfr must have id specified');
        $this->assertNotNull(SoftgoalNfr::find($createdSoftgoalNfr['id']), 'SoftgoalNfr with given id must be in DB');
        $this->assertModelData($softgoalNfr, $createdSoftgoalNfr);
    }

    /**
     * @test read
     */
    public function testReadSoftgoalNfr()
    {
        $softgoalNfr = $this->makeSoftgoalNfr();
        $dbSoftgoalNfr = $this->softgoalNfrRepo->find($softgoalNfr->id);
        $dbSoftgoalNfr = $dbSoftgoalNfr->toArray();
        $this->assertModelData($softgoalNfr->toArray(), $dbSoftgoalNfr);
    }

    /**
     * @test update
     */
    public function testUpdateSoftgoalNfr()
    {
        $softgoalNfr = $this->makeSoftgoalNfr();
        $fakeSoftgoalNfr = $this->fakeSoftgoalNfrData();
        $updatedSoftgoalNfr = $this->softgoalNfrRepo->update($fakeSoftgoalNfr, $softgoalNfr->id);
        $this->assertModelData($fakeSoftgoalNfr, $updatedSoftgoalNfr->toArray());
        $dbSoftgoalNfr = $this->softgoalNfrRepo->find($softgoalNfr->id);
        $this->assertModelData($fakeSoftgoalNfr, $dbSoftgoalNfr->toArray());
    }

    /**
     * @test delete
     */
    public function testDeleteSoftgoalNfr()
    {
        $softgoalNfr = $this->makeSoftgoalNfr();
        $resp = $this->softgoalNfrRepo->delete($softgoalNfr->id);
        $this->assertTrue($resp);
        $this->assertNull(SoftgoalNfr::find($softgoalNfr->id), 'SoftgoalNfr should not exist in DB');
    }
}
