<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class SoftgoalNfrApiTest extends TestCase
{
    use MakeSoftgoalNfrTrait, ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function testCreateSoftgoalNfr()
    {
        $softgoalNfr = $this->fakeSoftgoalNfrData();
        $this->json('POST', '/api/v1/softgoalNfrs', $softgoalNfr);

        $this->assertApiResponse($softgoalNfr);
    }

    /**
     * @test
     */
    public function testReadSoftgoalNfr()
    {
        $softgoalNfr = $this->makeSoftgoalNfr();
        $this->json('GET', '/api/v1/softgoalNfrs/'.$softgoalNfr->id);

        $this->assertApiResponse($softgoalNfr->toArray());
    }

    /**
     * @test
     */
    public function testUpdateSoftgoalNfr()
    {
        $softgoalNfr = $this->makeSoftgoalNfr();
        $editedSoftgoalNfr = $this->fakeSoftgoalNfrData();

        $this->json('PUT', '/api/v1/softgoalNfrs/'.$softgoalNfr->id, $editedSoftgoalNfr);

        $this->assertApiResponse($editedSoftgoalNfr);
    }

    /**
     * @test
     */
    public function testDeleteSoftgoalNfr()
    {
        $softgoalNfr = $this->makeSoftgoalNfr();
        $this->json('DELETE', '/api/v1/softgoalNfrs/'.$softgoalNfr->id);

        $this->assertApiSuccess();
        $this->json('GET', '/api/v1/softgoalNfrs/'.$softgoalNfr->id);

        $this->assertResponseStatus(404);
    }
}
