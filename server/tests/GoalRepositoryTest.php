<?php

use App\Models\Goal;
use App\Repositories\GoalRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class GoalRepositoryTest extends TestCase
{
    use MakeGoalTrait, ApiTestTrait, DatabaseTransactions;

    /**
     * @var GoalRepository
     */
    protected $goalRepo;

    public function setUp()
    {
        parent::setUp();
        $this->goalRepo = App::make(GoalRepository::class);
    }

    /**
     * @test create
     */
    public function testCreateGoal()
    {
        $goal = $this->fakeGoalData();
        $createdGoal = $this->goalRepo->create($goal);
        $createdGoal = $createdGoal->toArray();
        $this->assertArrayHasKey('id', $createdGoal);
        $this->assertNotNull($createdGoal['id'], 'Created Goal must have id specified');
        $this->assertNotNull(Goal::find($createdGoal['id']), 'Goal with given id must be in DB');
        $this->assertModelData($goal, $createdGoal);
    }

    /**
     * @test read
     */
    public function testReadGoal()
    {
        $goal = $this->makeGoal();
        $dbGoal = $this->goalRepo->find($goal->id);
        $dbGoal = $dbGoal->toArray();
        $this->assertModelData($goal->toArray(), $dbGoal);
    }

    /**
     * @test update
     */
    public function testUpdateGoal()
    {
        $goal = $this->makeGoal();
        $fakeGoal = $this->fakeGoalData();
        $updatedGoal = $this->goalRepo->update($fakeGoal, $goal->id);
        $this->assertModelData($fakeGoal, $updatedGoal->toArray());
        $dbGoal = $this->goalRepo->find($goal->id);
        $this->assertModelData($fakeGoal, $dbGoal->toArray());
    }

    /**
     * @test delete
     */
    public function testDeleteGoal()
    {
        $goal = $this->makeGoal();
        $resp = $this->goalRepo->delete($goal->id);
        $this->assertTrue($resp);
        $this->assertNull(Goal::find($goal->id), 'Goal should not exist in DB');
    }
}
