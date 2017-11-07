<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class PermiseApiTest extends TestCase
{
    use MakePermiseTrait, ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function testCreatePermise()
    {
        $permise = $this->fakePermiseData();
        $this->json('POST', '/api/v1/permises', $permise);

        $this->assertApiResponse($permise);
    }

    /**
     * @test
     */
    public function testReadPermise()
    {
        $permise = $this->makePermise();
        $this->json('GET', '/api/v1/permises/'.$permise->id);

        $this->assertApiResponse($permise->toArray());
    }

    /**
     * @test
     */
    public function testUpdatePermise()
    {
        $permise = $this->makePermise();
        $editedPermise = $this->fakePermiseData();

        $this->json('PUT', '/api/v1/permises/'.$permise->id, $editedPermise);

        $this->assertApiResponse($editedPermise);
    }

    /**
     * @test
     */
    public function testDeletePermise()
    {
        $permise = $this->makePermise();
        $this->json('DELETE', '/api/v1/permises/'.$permise->id);

        $this->assertApiSuccess();
        $this->json('GET', '/api/v1/permises/'.$permise->id);

        $this->assertResponseStatus(404);
    }
}
