<?php

namespace App\Http\Controllers;

use App\DataTables\CollaboratorDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateCollaboratorRequest;
use App\Http\Requests\UpdateCollaboratorRequest;
use App\Repositories\CollaboratorRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;

class CollaboratorController extends AppBaseController
{
    /** @var  CollaboratorRepository */
    private $collaboratorRepository;

    public function __construct(CollaboratorRepository $collaboratorRepo)
    {
        $this->collaboratorRepository = $collaboratorRepo;
    }

    /**
     * Display a listing of the Collaborator.
     *
     * @param CollaboratorDataTable $collaboratorDataTable
     * @return Response
     */
    public function index(CollaboratorDataTable $collaboratorDataTable)
    {
        return $collaboratorDataTable->render('collaborators.index');
    }

    /**
     * Show the form for creating a new Collaborator.
     *
     * @return Response
     */
    public function create()
    {
        return view('collaborators.create');
    }

    /**
     * Store a newly created Collaborator in storage.
     *
     * @param CreateCollaboratorRequest $request
     *
     * @return Response
     */
    public function store(CreateCollaboratorRequest $request)
    {
        $input = $request->all();

        $collaborator = $this->collaboratorRepository->create($input);

        Flash::success('Collaborator saved successfully.');

        return redirect(route('collaborators.index'));
    }

    /**
     * Display the specified Collaborator.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $collaborator = $this->collaboratorRepository->findWithoutFail($id);

        if (empty($collaborator)) {
            Flash::error('Collaborator not found');

            return redirect(route('collaborators.index'));
        }

        return view('collaborators.show')->with('collaborator', $collaborator);
    }

    /**
     * Show the form for editing the specified Collaborator.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $collaborator = $this->collaboratorRepository->findWithoutFail($id);

        if (empty($collaborator)) {
            Flash::error('Collaborator not found');

            return redirect(route('collaborators.index'));
        }

        return view('collaborators.edit')->with('collaborator', $collaborator);
    }

    /**
     * Update the specified Collaborator in storage.
     *
     * @param  int              $id
     * @param UpdateCollaboratorRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateCollaboratorRequest $request)
    {
        $collaborator = $this->collaboratorRepository->findWithoutFail($id);

        if (empty($collaborator)) {
            Flash::error('Collaborator not found');

            return redirect(route('collaborators.index'));
        }

        $collaborator = $this->collaboratorRepository->update($request->all(), $id);

        Flash::success('Collaborator updated successfully.');

        return redirect(route('collaborators.index'));
    }

    /**
     * Remove the specified Collaborator from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $collaborator = $this->collaboratorRepository->findWithoutFail($id);

        if (empty($collaborator)) {
            Flash::error('Collaborator not found');

            return redirect(route('collaborators.index'));
        }

        $this->collaboratorRepository->delete($id);

        Flash::success('Collaborator deleted successfully.');

        return redirect(route('collaborators.index'));
    }
}
