<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class RelevanceApiTest extends TestCase
{
    use MakeRelevanceTrait, ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function testCreateRelevance()
    {
        $relevance = $this->fakeRelevanceData();
        $this->json('POST', '/api/v1/relevances', $relevance);

        $this->assertApiResponse($relevance);
    }

    /**
     * @test
     */
    public function testReadRelevance()
    {
        $relevance = $this->makeRelevance();
        $this->json('GET', '/api/v1/relevances/'.$relevance->id);

        $this->assertApiResponse($relevance->toArray());
    }

    /**
     * @test
     */
    public function testUpdateRelevance()
    {
        $relevance = $this->makeRelevance();
        $editedRelevance = $this->fakeRelevanceData();

        $this->json('PUT', '/api/v1/relevances/'.$relevance->id, $editedRelevance);

        $this->assertApiResponse($editedRelevance);
    }

    /**
     * @test
     */
    public function testDeleteRelevance()
    {
        $relevance = $this->makeRelevance();
        $this->json('DELETE', '/api/v1/relevances/'.$relevance->id);

        $this->assertApiSuccess();
        $this->json('GET', '/api/v1/relevances/'.$relevance->id);

        $this->assertResponseStatus(404);
    }
}
