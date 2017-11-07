<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class GoalApiTest extends TestCase
{
    use MakeGoalTrait, ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function testCreateGoal()
    {
        $goal = $this->fakeGoalData();
        $this->json('POST', '/api/v1/goals', $goal);

        $this->assertApiResponse($goal);
    }

    /**
     * @test
     */
    public function testReadGoal()
    {
        $goal = $this->makeGoal();
        $this->json('GET', '/api/v1/goals/'.$goal->id);

        $this->assertApiResponse($goal->toArray());
    }

    /**
     * @test
     */
    public function testUpdateGoal()
    {
        $goal = $this->makeGoal();
        $editedGoal = $this->fakeGoalData();

        $this->json('PUT', '/api/v1/goals/'.$goal->id, $editedGoal);

        $this->assertApiResponse($editedGoal);
    }

    /**
     * @test
     */
    public function testDeleteGoal()
    {
        $goal = $this->makeGoal();
        $this->json('DELETE', '/api/v1/goals/'.$goal->id);

        $this->assertApiSuccess();
        $this->json('GET', '/api/v1/goals/'.$goal->id);

        $this->assertResponseStatus(404);
    }
}
