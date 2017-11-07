<?php

use Faker\Factory as Faker;
use App\Models\Goal;
use App\Repositories\GoalRepository;

trait MakeGoalTrait
{
    /**
     * Create fake instance of Goal and save it in database
     *
     * @param array $goalFields
     * @return Goal
     */
    public function makeGoal($goalFields = [])
    {
        /** @var GoalRepository $goalRepo */
        $goalRepo = App::make(GoalRepository::class);
        $theme = $this->fakeGoalData($goalFields);
        return $goalRepo->create($theme);
    }

    /**
     * Get fake instance of Goal
     *
     * @param array $goalFields
     * @return Goal
     */
    public function fakeGoal($goalFields = [])
    {
        return new Goal($this->fakeGoalData($goalFields));
    }

    /**
     * Get fake data of Goal
     *
     * @param array $postFields
     * @return array
     */
    public function fakeGoalData($goalFields = [])
    {
        $fake = Faker::create();

        return array_merge([
            'name' => $fake->word,
            'description' => $fake->text,
            'stakeholders_id' => $fake->randomDigitNotNull,
            'relevances_id' => $fake->randomDigitNotNull,
            'date' => $fake->word,
            'time' => $fake->word
        ], $goalFields);
    }
}
