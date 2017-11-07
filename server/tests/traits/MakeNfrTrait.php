<?php

use Faker\Factory as Faker;
use App\Models\Nfr;
use App\Repositories\NfrRepository;

trait MakeNfrTrait
{
    /**
     * Create fake instance of Nfr and save it in database
     *
     * @param array $nfrFields
     * @return Nfr
     */
    public function makeNfr($nfrFields = [])
    {
        /** @var NfrRepository $nfrRepo */
        $nfrRepo = App::make(NfrRepository::class);
        $theme = $this->fakeNfrData($nfrFields);
        return $nfrRepo->create($theme);
    }

    /**
     * Get fake instance of Nfr
     *
     * @param array $nfrFields
     * @return Nfr
     */
    public function fakeNfr($nfrFields = [])
    {
        return new Nfr($this->fakeNfrData($nfrFields));
    }

    /**
     * Get fake data of Nfr
     *
     * @param array $postFields
     * @return array
     */
    public function fakeNfrData($nfrFields = [])
    {
        $fake = Faker::create();

        return array_merge([
            'name' => $fake->word,
            'description' => $fake->word,
            'categories_id' => $fake->randomDigitNotNull
        ], $nfrFields);
    }
}
