<?php

use App\Models\Relevance;
use App\Repositories\RelevanceRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class RelevanceRepositoryTest extends TestCase
{
    use MakeRelevanceTrait, ApiTestTrait, DatabaseTransactions;

    /**
     * @var RelevanceRepository
     */
    protected $relevanceRepo;

    public function setUp()
    {
        parent::setUp();
        $this->relevanceRepo = App::make(RelevanceRepository::class);
    }

    /**
     * @test create
     */
    public function testCreateRelevance()
    {
        $relevance = $this->fakeRelevanceData();
        $createdRelevance = $this->relevanceRepo->create($relevance);
        $createdRelevance = $createdRelevance->toArray();
        $this->assertArrayHasKey('id', $createdRelevance);
        $this->assertNotNull($createdRelevance['id'], 'Created Relevance must have id specified');
        $this->assertNotNull(Relevance::find($createdRelevance['id']), 'Relevance with given id must be in DB');
        $this->assertModelData($relevance, $createdRelevance);
    }

    /**
     * @test read
     */
    public function testReadRelevance()
    {
        $relevance = $this->makeRelevance();
        $dbRelevance = $this->relevanceRepo->find($relevance->id);
        $dbRelevance = $dbRelevance->toArray();
        $this->assertModelData($relevance->toArray(), $dbRelevance);
    }

    /**
     * @test update
     */
    public function testUpdateRelevance()
    {
        $relevance = $this->makeRelevance();
        $fakeRelevance = $this->fakeRelevanceData();
        $updatedRelevance = $this->relevanceRepo->update($fakeRelevance, $relevance->id);
        $this->assertModelData($fakeRelevance, $updatedRelevance->toArray());
        $dbRelevance = $this->relevanceRepo->find($relevance->id);
        $this->assertModelData($fakeRelevance, $dbRelevance->toArray());
    }

    /**
     * @test delete
     */
    public function testDeleteRelevance()
    {
        $relevance = $this->makeRelevance();
        $resp = $this->relevanceRepo->delete($relevance->id);
        $this->assertTrue($resp);
        $this->assertNull(Relevance::find($relevance->id), 'Relevance should not exist in DB');
    }
}
