<?php

use App\Models\Profession;
use App\Repositories\ProfessionRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ProfessionRepositoryTest extends TestCase
{
    use MakeProfessionTrait, ApiTestTrait, DatabaseTransactions;

    /**
     * @var ProfessionRepository
     */
    protected $professionRepo;

    public function setUp()
    {
        parent::setUp();
        $this->professionRepo = App::make(ProfessionRepository::class);
    }

    /**
     * @test create
     */
    public function testCreateProfession()
    {
        $profession = $this->fakeProfessionData();
        $createdProfession = $this->professionRepo->create($profession);
        $createdProfession = $createdProfession->toArray();
        $this->assertArrayHasKey('id', $createdProfession);
        $this->assertNotNull($createdProfession['id'], 'Created Profession must have id specified');
        $this->assertNotNull(Profession::find($createdProfession['id']), 'Profession with given id must be in DB');
        $this->assertModelData($profession, $createdProfession);
    }

    /**
     * @test read
     */
    public function testReadProfession()
    {
        $profession = $this->makeProfession();
        $dbProfession = $this->professionRepo->find($profession->id);
        $dbProfession = $dbProfession->toArray();
        $this->assertModelData($profession->toArray(), $dbProfession);
    }

    /**
     * @test update
     */
    public function testUpdateProfession()
    {
        $profession = $this->makeProfession();
        $fakeProfession = $this->fakeProfessionData();
        $updatedProfession = $this->professionRepo->update($fakeProfession, $profession->id);
        $this->assertModelData($fakeProfession, $updatedProfession->toArray());
        $dbProfession = $this->professionRepo->find($profession->id);
        $this->assertModelData($fakeProfession, $dbProfession->toArray());
    }

    /**
     * @test delete
     */
    public function testDeleteProfession()
    {
        $profession = $this->makeProfession();
        $resp = $this->professionRepo->delete($profession->id);
        $this->assertTrue($resp);
        $this->assertNull(Profession::find($profession->id), 'Profession should not exist in DB');
    }
}
