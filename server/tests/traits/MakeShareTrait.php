<?php

use Faker\Factory as Faker;
use App\Models\Share;
use App\Repositories\ShareRepository;

trait MakeShareTrait
{
    /**
     * Create fake instance of Share and save it in database
     *
     * @param array $shareFields
     * @return Share
     */
    public function makeShare($shareFields = [])
    {
        /** @var ShareRepository $shareRepo */
        $shareRepo = App::make(ShareRepository::class);
        $theme = $this->fakeShareData($shareFields);
        return $shareRepo->create($theme);
    }

    /**
     * Get fake instance of Share
     *
     * @param array $shareFields
     * @return Share
     */
    public function fakeShare($shareFields = [])
    {
        return new Share($this->fakeShareData($shareFields));
    }

    /**
     * Get fake data of Share
     *
     * @param array $postFields
     * @return array
     */
    public function fakeShareData($shareFields = [])
    {
        $fake = Faker::create();

        return array_merge([
            'users_id' => $fake->randomDigitNotNull,
            'projects_id' => $fake->randomDigitNotNull
        ], $shareFields);
    }
}
