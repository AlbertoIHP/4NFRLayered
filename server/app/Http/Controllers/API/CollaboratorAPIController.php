<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateCollaboratorAPIRequest;
use App\Http\Requests\API\UpdateCollaboratorAPIRequest;
use App\Models\Collaborator;
use App\Repositories\CollaboratorRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

/**
 * Class CollaboratorController
 * @package App\Http\Controllers\API
 */

class CollaboratorAPIController extends AppBaseController
{
    /** @var  CollaboratorRepository */
    private $collaboratorRepository;

    public function __construct(CollaboratorRepository $collaboratorRepo)
    {
        $this->collaboratorRepository = $collaboratorRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/collaborators",
     *      summary="Get a listing of the Collaborators.",
     *      tags={"Collaborator"},
     *      description="Get all Collaborators",
     *      produces={"application/json"},
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  type="array",
     *                  @SWG\Items(ref="#/definitions/Collaborator")
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function index(Request $request)
    {
        $this->collaboratorRepository->pushCriteria(new RequestCriteria($request));
        $this->collaboratorRepository->pushCriteria(new LimitOffsetCriteria($request));
        $collaborators = $this->collaboratorRepository->all();

        return $this->sendResponse($collaborators->toArray(), 'Collaborators retrieved successfully');
    }

    /**
     * @param CreateCollaboratorAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/collaborators",
     *      summary="Store a newly created Collaborator in storage",
     *      tags={"Collaborator"},
     *      description="Store Collaborator",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Collaborator that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Collaborator")
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  ref="#/definitions/Collaborator"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateCollaboratorAPIRequest $request)
    {
        $input = $request->all();

        $collaborators = $this->collaboratorRepository->create($input);

        return $this->sendResponse($collaborators->toArray(), 'Collaborator saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/collaborators/{id}",
     *      summary="Display the specified Collaborator",
     *      tags={"Collaborator"},
     *      description="Get Collaborator",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Collaborator",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  ref="#/definitions/Collaborator"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function show($id)
    {
        /** @var Collaborator $collaborator */
        $collaborator = $this->collaboratorRepository->findWithoutFail($id);

        if (empty($collaborator)) {
            return $this->sendError('Collaborator not found');
        }

        return $this->sendResponse($collaborator->toArray(), 'Collaborator retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateCollaboratorAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/collaborators/{id}",
     *      summary="Update the specified Collaborator in storage",
     *      tags={"Collaborator"},
     *      description="Update Collaborator",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Collaborator",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Collaborator that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Collaborator")
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  ref="#/definitions/Collaborator"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateCollaboratorAPIRequest $request)
    {
        $input = $request->all();

        /** @var Collaborator $collaborator */
        $collaborator = $this->collaboratorRepository->findWithoutFail($id);

        if (empty($collaborator)) {
            return $this->sendError('Collaborator not found');
        }

        $collaborator = $this->collaboratorRepository->update($input, $id);

        return $this->sendResponse($collaborator->toArray(), 'Collaborator updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/collaborators/{id}",
     *      summary="Remove the specified Collaborator from storage",
     *      tags={"Collaborator"},
     *      description="Delete Collaborator",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Collaborator",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  type="string"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function destroy($id)
    {
        /** @var Collaborator $collaborator */
        $collaborator = $this->collaboratorRepository->findWithoutFail($id);

        if (empty($collaborator)) {
            return $this->sendError('Collaborator not found');
        }

        $collaborator->delete();

        return $this->sendResponse($id, 'Collaborator deleted successfully');
    }
}
