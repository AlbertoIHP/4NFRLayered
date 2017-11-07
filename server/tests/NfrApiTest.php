<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class NfrApiTest extends TestCase
{
    use MakeNfrTrait, ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function testCreateNfr()
    {
        $nfr = $this->fakeNfrData();
        $this->json('POST', '/api/v1/nfrs', $nfr);

        $this->assertApiResponse($nfr);
    }

    /**
     * @test
     */
    public function testReadNfr()
    {
        $nfr = $this->makeNfr();
        $this->json('GET', '/api/v1/nfrs/'.$nfr->id);

        $this->assertApiResponse($nfr->toArray());
    }

    /**
     * @test
     */
    public function testUpdateNfr()
    {
        $nfr = $this->makeNfr();
        $editedNfr = $this->fakeNfrData();

        $this->json('PUT', '/api/v1/nfrs/'.$nfr->id, $editedNfr);

        $this->assertApiResponse($editedNfr);
    }

    /**
     * @test
     */
    public function testDeleteNfr()
    {
        $nfr = $this->makeNfr();
        $this->json('DELETE', '/api/v1/nfrs/'.$nfr->id);

        $this->assertApiSuccess();
        $this->json('GET', '/api/v1/nfrs/'.$nfr->id);

        $this->assertResponseStatus(404);
    }
}
