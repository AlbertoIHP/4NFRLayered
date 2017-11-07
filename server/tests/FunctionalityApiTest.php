<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class FunctionalityApiTest extends TestCase
{
    use MakeFunctionalityTrait, ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function testCreateFunctionality()
    {
        $functionality = $this->fakeFunctionalityData();
        $this->json('POST', '/api/v1/functionalities', $functionality);

        $this->assertApiResponse($functionality);
    }

    /**
     * @test
     */
    public function testReadFunctionality()
    {
        $functionality = $this->makeFunctionality();
        $this->json('GET', '/api/v1/functionalities/'.$functionality->id);

        $this->assertApiResponse($functionality->toArray());
    }

    /**
     * @test
     */
    public function testUpdateFunctionality()
    {
        $functionality = $this->makeFunctionality();
        $editedFunctionality = $this->fakeFunctionalityData();

        $this->json('PUT', '/api/v1/functionalities/'.$functionality->id, $editedFunctionality);

        $this->assertApiResponse($editedFunctionality);
    }

    /**
     * @test
     */
    public function testDeleteFunctionality()
    {
        $functionality = $this->makeFunctionality();
        $this->json('DELETE', '/api/v1/functionalities/'.$functionality->id);

        $this->assertApiSuccess();
        $this->json('GET', '/api/v1/functionalities/'.$functionality->id);

        $this->assertResponseStatus(404);
    }
}
