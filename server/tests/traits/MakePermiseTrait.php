<?php

use Faker\Factory as Faker;
use App\Models\Permise;
use App\Repositories\PermiseRepository;

trait MakePermiseTrait
{
    /**
     * Create fake instance of Permise and save it in database
     *
     * @param array $permiseFields
     * @return Permise
     */
    public function makePermise($permiseFields = [])
    {
        /** @var PermiseRepository $permiseRepo */
        $permiseRepo = App::make(PermiseRepository::class);
        $theme = $this->fakePermiseData($permiseFields);
        return $permiseRepo->create($theme);
    }

    /**
     * Get fake instance of Permise
     *
     * @param array $permiseFields
     * @return Permise
     */
    public function fakePermise($permiseFields = [])
    {
        return new Permise($this->fakePermiseData($permiseFields));
    }

    /**
     * Get fake data of Permise
     *
     * @param array $postFields
     * @return array
     */
    public function fakePermiseData($permiseFields = [])
    {
        $fake = Faker::create();

        return array_merge([
            'roles_id' => $fake->randomDigitNotNull,
            'functionalities_id' => $fake->randomDigitNotNull,
            'write' => $fake->word,
            'erase' => $fake->word,
            'update' => $fake->word,
            'view' => $fake->word
        ], $permiseFields);
    }
}
