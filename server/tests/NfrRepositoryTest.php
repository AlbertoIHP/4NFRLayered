<?php

use App\Models\Nfr;
use App\Repositories\NfrRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class NfrRepositoryTest extends TestCase
{
    use MakeNfrTrait, ApiTestTrait, DatabaseTransactions;

    /**
     * @var NfrRepository
     */
    protected $nfrRepo;

    public function setUp()
    {
        parent::setUp();
        $this->nfrRepo = App::make(NfrRepository::class);
    }

    /**
     * @test create
     */
    public function testCreateNfr()
    {
        $nfr = $this->fakeNfrData();
        $createdNfr = $this->nfrRepo->create($nfr);
        $createdNfr = $createdNfr->toArray();
        $this->assertArrayHasKey('id', $createdNfr);
        $this->assertNotNull($createdNfr['id'], 'Created Nfr must have id specified');
        $this->assertNotNull(Nfr::find($createdNfr['id']), 'Nfr with given id must be in DB');
        $this->assertModelData($nfr, $createdNfr);
    }

    /**
     * @test read
     */
    public function testReadNfr()
    {
        $nfr = $this->makeNfr();
        $dbNfr = $this->nfrRepo->find($nfr->id);
        $dbNfr = $dbNfr->toArray();
        $this->assertModelData($nfr->toArray(), $dbNfr);
    }

    /**
     * @test update
     */
    public function testUpdateNfr()
    {
        $nfr = $this->makeNfr();
        $fakeNfr = $this->fakeNfrData();
        $updatedNfr = $this->nfrRepo->update($fakeNfr, $nfr->id);
        $this->assertModelData($fakeNfr, $updatedNfr->toArray());
        $dbNfr = $this->nfrRepo->find($nfr->id);
        $this->assertModelData($fakeNfr, $dbNfr->toArray());
    }

    /**
     * @test delete
     */
    public function testDeleteNfr()
    {
        $nfr = $this->makeNfr();
        $resp = $this->nfrRepo->delete($nfr->id);
        $this->assertTrue($resp);
        $this->assertNull(Nfr::find($nfr->id), 'Nfr should not exist in DB');
    }
}
