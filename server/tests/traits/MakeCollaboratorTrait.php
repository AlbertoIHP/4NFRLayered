<?php

use Faker\Factory as Faker;
use App\Models\Collaborator;
use App\Repositories\CollaboratorRepository;

trait MakeCollaboratorTrait
{
    /**
     * Create fake instance of Collaborator and save it in database
     *
     * @param array $collaboratorFields
     * @return Collaborator
     */
    public function makeCollaborator($collaboratorFields = [])
    {
        /** @var CollaboratorRepository $collaboratorRepo */
        $collaboratorRepo = App::make(CollaboratorRepository::class);
        $theme = $this->fakeCollaboratorData($collaboratorFields);
        return $collaboratorRepo->create($theme);
    }

    /**
     * Get fake instance of Collaborator
     *
     * @param array $collaboratorFields
     * @return Collaborator
     */
    public function fakeCollaborator($collaboratorFields = [])
    {
        return new Collaborator($this->fakeCollaboratorData($collaboratorFields));
    }

    /**
     * Get fake data of Collaborator
     *
     * @param array $postFields
     * @return array
     */
    public function fakeCollaboratorData($collaboratorFields = [])
    {
        $fake = Faker::create();

        return array_merge([
            'users_id' => $fake->randomDigitNotNull,
            'projects_id' => $fake->randomDigitNotNull
        ], $collaboratorFields);
    }
}
