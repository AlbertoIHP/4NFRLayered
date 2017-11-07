<?php

use Faker\Factory as Faker;
use App\Models\Relevance;
use App\Repositories\RelevanceRepository;

trait MakeRelevanceTrait
{
    /**
     * Create fake instance of Relevance and save it in database
     *
     * @param array $relevanceFields
     * @return Relevance
     */
    public function makeRelevance($relevanceFields = [])
    {
        /** @var RelevanceRepository $relevanceRepo */
        $relevanceRepo = App::make(RelevanceRepository::class);
        $theme = $this->fakeRelevanceData($relevanceFields);
        return $relevanceRepo->create($theme);
    }

    /**
     * Get fake instance of Relevance
     *
     * @param array $relevanceFields
     * @return Relevance
     */
    public function fakeRelevance($relevanceFields = [])
    {
        return new Relevance($this->fakeRelevanceData($relevanceFields));
    }

    /**
     * Get fake data of Relevance
     *
     * @param array $postFields
     * @return array
     */
    public function fakeRelevanceData($relevanceFields = [])
    {
        $fake = Faker::create();

        return array_merge([
            'name' => $fake->word,
            'description' => $fake->text,
            'weigth' => $fake->randomDigitNotNull
        ], $relevanceFields);
    }
}
