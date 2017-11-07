<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class SoftgoalApiTest extends TestCase
{
    use MakeSoftgoalTrait, ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function testCreateSoftgoal()
    {
        $softgoal = $this->fakeSoftgoalData();
        $this->json('POST', '/api/v1/softgoals', $softgoal);

        $this->assertApiResponse($softgoal);
    }

    /**
     * @test
     */
    public function testReadSoftgoal()
    {
        $softgoal = $this->makeSoftgoal();
        $this->json('GET', '/api/v1/softgoals/'.$softgoal->id);

        $this->assertApiResponse($softgoal->toArray());
    }

    /**
     * @test
     */
    public function testUpdateSoftgoal()
    {
        $softgoal = $this->makeSoftgoal();
        $editedSoftgoal = $this->fakeSoftgoalData();

        $this->json('PUT', '/api/v1/softgoals/'.$softgoal->id, $editedSoftgoal);

        $this->assertApiResponse($editedSoftgoal);
    }

    /**
     * @test
     */
    public function testDeleteSoftgoal()
    {
        $softgoal = $this->makeSoftgoal();
        $this->json('DELETE', '/api/v1/softgoals/'.$softgoal->id);

        $this->assertApiSuccess();
        $this->json('GET', '/api/v1/softgoals/'.$softgoal->id);

        $this->assertResponseStatus(404);
    }
}
