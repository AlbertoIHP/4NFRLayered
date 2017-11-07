<?php

use Faker\Factory as Faker;
use App\Models\Stakeholder;
use App\Repositories\StakeholderRepository;

trait MakeStakeholderTrait
{
    /**
     * Create fake instance of Stakeholder and save it in database
     *
     * @param array $stakeholderFields
     * @return Stakeholder
     */
    public function makeStakeholder($stakeholderFields = [])
    {
        /** @var StakeholderRepository $stakeholderRepo */
        $stakeholderRepo = App::make(StakeholderRepository::class);
        $theme = $this->fakeStakeholderData($stakeholderFields);
        return $stakeholderRepo->create($theme);
    }

    /**
     * Get fake instance of Stakeholder
     *
     * @param array $stakeholderFields
     * @return Stakeholder
     */
    public function fakeStakeholder($stakeholderFields = [])
    {
        return new Stakeholder($this->fakeStakeholderData($stakeholderFields));
    }

    /**
     * Get fake data of Stakeholder
     *
     * @param array $postFields
     * @return array
     */
    public function fakeStakeholderData($stakeholderFields = [])
    {
        $fake = Faker::create();

        return array_merge([
            'name' => $fake->word,
            'decription' => $fake->text,
            'function' => $fake->word,
            'projects_id' => $fake->randomDigitNotNull,
            'professions_id' => $fake->randomDigitNotNull,
            'date' => $fake->word,
            'time' => $fake->word
        ], $stakeholderFields);
    }
}
