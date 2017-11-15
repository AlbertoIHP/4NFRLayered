<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CollaboratorApiTest extends TestCase
{
    use MakeCollaboratorTrait, ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function testCreateCollaborator()
    {
        $collaborator = $this->fakeCollaboratorData();
        $this->json('POST', '/api/v1/collaborators', $collaborator);

        $this->assertApiResponse($collaborator);
    }

    /**
     * @test
     */
    public function testReadCollaborator()
    {
        $collaborator = $this->makeCollaborator();
        $this->json('GET', '/api/v1/collaborators/'.$collaborator->id);

        $this->assertApiResponse($collaborator->toArray());
    }

    /**
     * @test
     */
    public function testUpdateCollaborator()
    {
        $collaborator = $this->makeCollaborator();
        $editedCollaborator = $this->fakeCollaboratorData();

        $this->json('PUT', '/api/v1/collaborators/'.$collaborator->id, $editedCollaborator);

        $this->assertApiResponse($editedCollaborator);
    }

    /**
     * @test
     */
    public function testDeleteCollaborator()
    {
        $collaborator = $this->makeCollaborator();
        $this->json('DELETE', '/api/v1/collaborators/'.$collaborator->id);

        $this->assertApiSuccess();
        $this->json('GET', '/api/v1/collaborators/'.$collaborator->id);

        $this->assertResponseStatus(404);
    }
}
