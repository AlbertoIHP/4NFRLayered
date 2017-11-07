<?php

use Faker\Factory as Faker;
use App\Models\Functionality;
use App\Repositories\FunctionalityRepository;

trait MakeFunctionalityTrait
{
    /**
     * Create fake instance of Functionality and save it in database
     *
     * @param array $functionalityFields
     * @return Functionality
     */
    public function makeFunctionality($functionalityFields = [])
    {
        /** @var FunctionalityRepository $functionalityRepo */
        $functionalityRepo = App::make(FunctionalityRepository::class);
        $theme = $this->fakeFunctionalityData($functionalityFields);
        return $functionalityRepo->create($theme);
    }

    /**
     * Get fake instance of Functionality
     *
     * @param array $functionalityFields
     * @return Functionality
     */
    public function fakeFunctionality($functionalityFields = [])
    {
        return new Functionality($this->fakeFunctionalityData($functionalityFields));
    }

    /**
     * Get fake data of Functionality
     *
     * @param array $postFields
     * @return array
     */
    public function fakeFunctionalityData($functionalityFields = [])
    {
        $fake = Faker::create();

        return array_merge([
            'name' => $fake->word
        ], $functionalityFields);
    }
}
