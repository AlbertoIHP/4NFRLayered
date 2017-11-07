<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ProfessionApiTest extends TestCase
{
    use MakeProfessionTrait, ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function testCreateProfession()
    {
        $profession = $this->fakeProfessionData();
        $this->json('POST', '/api/v1/professions', $profession);

        $this->assertApiResponse($profession);
    }

    /**
     * @test
     */
    public function testReadProfession()
    {
        $profession = $this->makeProfession();
        $this->json('GET', '/api/v1/professions/'.$profession->id);

        $this->assertApiResponse($profession->toArray());
    }

    /**
     * @test
     */
    public function testUpdateProfession()
    {
        $profession = $this->makeProfession();
        $editedProfession = $this->fakeProfessionData();

        $this->json('PUT', '/api/v1/professions/'.$profession->id, $editedProfession);

        $this->assertApiResponse($editedProfession);
    }

    /**
     * @test
     */
    public function testDeleteProfession()
    {
        $profession = $this->makeProfession();
        $this->json('DELETE', '/api/v1/professions/'.$profession->id);

        $this->assertApiSuccess();
        $this->json('GET', '/api/v1/professions/'.$profession->id);

        $this->assertResponseStatus(404);
    }
}
