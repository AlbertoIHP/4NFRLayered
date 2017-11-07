<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class StakeholderApiTest extends TestCase
{
    use MakeStakeholderTrait, ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function testCreateStakeholder()
    {
        $stakeholder = $this->fakeStakeholderData();
        $this->json('POST', '/api/v1/stakeholders', $stakeholder);

        $this->assertApiResponse($stakeholder);
    }

    /**
     * @test
     */
    public function testReadStakeholder()
    {
        $stakeholder = $this->makeStakeholder();
        $this->json('GET', '/api/v1/stakeholders/'.$stakeholder->id);

        $this->assertApiResponse($stakeholder->toArray());
    }

    /**
     * @test
     */
    public function testUpdateStakeholder()
    {
        $stakeholder = $this->makeStakeholder();
        $editedStakeholder = $this->fakeStakeholderData();

        $this->json('PUT', '/api/v1/stakeholders/'.$stakeholder->id, $editedStakeholder);

        $this->assertApiResponse($editedStakeholder);
    }

    /**
     * @test
     */
    public function testDeleteStakeholder()
    {
        $stakeholder = $this->makeStakeholder();
        $this->json('DELETE', '/api/v1/stakeholders/'.$stakeholder->id);

        $this->assertApiSuccess();
        $this->json('GET', '/api/v1/stakeholders/'.$stakeholder->id);

        $this->assertResponseStatus(404);
    }
}
