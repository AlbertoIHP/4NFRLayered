<?php

use App\Models\Collaborator;
use App\Repositories\CollaboratorRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CollaboratorRepositoryTest extends TestCase
{
    use MakeCollaboratorTrait, ApiTestTrait, DatabaseTransactions;

    /**
     * @var CollaboratorRepository
     */
    protected $collaboratorRepo;

    public function setUp()
    {
        parent::setUp();
        $this->collaboratorRepo = App::make(CollaboratorRepository::class);
    }

    /**
     * @test create
     */
    public function testCreateCollaborator()
    {
        $collaborator = $this->fakeCollaboratorData();
        $createdCollaborator = $this->collaboratorRepo->create($collaborator);
        $createdCollaborator = $createdCollaborator->toArray();
        $this->assertArrayHasKey('id', $createdCollaborator);
        $this->assertNotNull($createdCollaborator['id'], 'Created Collaborator must have id specified');
        $this->assertNotNull(Collaborator::find($createdCollaborator['id']), 'Collaborator with given id must be in DB');
        $this->assertModelData($collaborator, $createdCollaborator);
    }

    /**
     * @test read
     */
    public function testReadCollaborator()
    {
        $collaborator = $this->makeCollaborator();
        $dbCollaborator = $this->collaboratorRepo->find($collaborator->id);
        $dbCollaborator = $dbCollaborator->toArray();
        $this->assertModelData($collaborator->toArray(), $dbCollaborator);
    }

    /**
     * @test update
     */
    public function testUpdateCollaborator()
    {
        $collaborator = $this->makeCollaborator();
        $fakeCollaborator = $this->fakeCollaboratorData();
        $updatedCollaborator = $this->collaboratorRepo->update($fakeCollaborator, $collaborator->id);
        $this->assertModelData($fakeCollaborator, $updatedCollaborator->toArray());
        $dbCollaborator = $this->collaboratorRepo->find($collaborator->id);
        $this->assertModelData($fakeCollaborator, $dbCollaborator->toArray());
    }

    /**
     * @test delete
     */
    public function testDeleteCollaborator()
    {
        $collaborator = $this->makeCollaborator();
        $resp = $this->collaboratorRepo->delete($collaborator->id);
        $this->assertTrue($resp);
        $this->assertNull(Collaborator::find($collaborator->id), 'Collaborator should not exist in DB');
    }
}
