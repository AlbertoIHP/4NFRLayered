<?php

use Faker\Factory as Faker;
use App\Models\Profession;
use App\Repositories\ProfessionRepository;

trait MakeProfessionTrait
{
    /**
     * Create fake instance of Profession and save it in database
     *
     * @param array $professionFields
     * @return Profession
     */
    public function makeProfession($professionFields = [])
    {
        /** @var ProfessionRepository $professionRepo */
        $professionRepo = App::make(ProfessionRepository::class);
        $theme = $this->fakeProfessionData($professionFields);
        return $professionRepo->create($theme);
    }

    /**
     * Get fake instance of Profession
     *
     * @param array $professionFields
     * @return Profession
     */
    public function fakeProfession($professionFields = [])
    {
        return new Profession($this->fakeProfessionData($professionFields));
    }

    /**
     * Get fake data of Profession
     *
     * @param array $postFields
     * @return array
     */
    public function fakeProfessionData($professionFields = [])
    {
        $fake = Faker::create();

        return array_merge([
            'name' => $fake->word,
            'description' => $fake->text
        ], $professionFields);
    }
}
