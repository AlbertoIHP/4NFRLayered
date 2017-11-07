<?php

use Faker\Factory as Faker;
use App\Models\Softgoal;
use App\Repositories\SoftgoalRepository;

trait MakeSoftgoalTrait
{
    /**
     * Create fake instance of Softgoal and save it in database
     *
     * @param array $softgoalFields
     * @return Softgoal
     */
    public function makeSoftgoal($softgoalFields = [])
    {
        /** @var SoftgoalRepository $softgoalRepo */
        $softgoalRepo = App::make(SoftgoalRepository::class);
        $theme = $this->fakeSoftgoalData($softgoalFields);
        return $softgoalRepo->create($theme);
    }

    /**
     * Get fake instance of Softgoal
     *
     * @param array $softgoalFields
     * @return Softgoal
     */
    public function fakeSoftgoal($softgoalFields = [])
    {
        return new Softgoal($this->fakeSoftgoalData($softgoalFields));
    }

    /**
     * Get fake data of Softgoal
     *
     * @param array $postFields
     * @return array
     */
    public function fakeSoftgoalData($softgoalFields = [])
    {
        $fake = Faker::create();

        return array_merge([
            'name' => $fake->word,
            'description' => $fake->text,
            'goals_id' => $fake->randomDigitNotNull,
            'relevances_id' => $fake->randomDigitNotNull,
            'date' => $fake->word,
            'time' => $fake->word
        ], $softgoalFields);
    }
}
