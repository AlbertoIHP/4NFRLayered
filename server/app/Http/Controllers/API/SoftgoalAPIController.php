<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateSoftgoalAPIRequest;
use App\Http\Requests\API\UpdateSoftgoalAPIRequest;
use App\Models\Softgoal;
use App\Repositories\SoftgoalRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

/**
 * Class SoftgoalController
 * @package App\Http\Controllers\API
 */

class SoftgoalAPIController extends AppBaseController
{
    /** @var  SoftgoalRepository */
    private $softgoalRepository;

    public function __construct(SoftgoalRepository $softgoalRepo)
    {
        $this->softgoalRepository = $softgoalRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/softgoals",
     *      summary="Get a listing of the Softgoals.",
     *      tags={"Softgoal"},
     *      description="Get all Softgoals",
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
     *                  @SWG\Items(ref="#/definitions/Softgoal")
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
        $this->softgoalRepository->pushCriteria(new RequestCriteria($request));
        $this->softgoalRepository->pushCriteria(new LimitOffsetCriteria($request));
        $softgoals = $this->softgoalRepository->all();

        return $this->sendResponse($softgoals->toArray(), 'Softgoals retrieved successfully');
    }

    /**
     * @param CreateSoftgoalAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/softgoals",
     *      summary="Store a newly created Softgoal in storage",
     *      tags={"Softgoal"},
     *      description="Store Softgoal",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Softgoal that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Softgoal")
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
     *                  ref="#/definitions/Softgoal"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateSoftgoalAPIRequest $request)
    {
        $input = $request->all();

        $softgoals = $this->softgoalRepository->create($input);

        return $this->sendResponse($softgoals->toArray(), 'Softgoal saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/softgoals/{id}",
     *      summary="Display the specified Softgoal",
     *      tags={"Softgoal"},
     *      description="Get Softgoal",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Softgoal",
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
     *                  ref="#/definitions/Softgoal"
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
        /** @var Softgoal $softgoal */
        $softgoal = $this->softgoalRepository->findWithoutFail($id);

        if (empty($softgoal)) {
            return $this->sendError('Softgoal not found');
        }

        return $this->sendResponse($softgoal->toArray(), 'Softgoal retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateSoftgoalAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/softgoals/{id}",
     *      summary="Update the specified Softgoal in storage",
     *      tags={"Softgoal"},
     *      description="Update Softgoal",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Softgoal",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Softgoal that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Softgoal")
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
     *                  ref="#/definitions/Softgoal"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateSoftgoalAPIRequest $request)
    {
        $input = $request->all();

        /** @var Softgoal $softgoal */
        $softgoal = $this->softgoalRepository->findWithoutFail($id);

        if (empty($softgoal)) {
            return $this->sendError('Softgoal not found');
        }

        $softgoal = $this->softgoalRepository->update($input, $id);

        return $this->sendResponse($softgoal->toArray(), 'Softgoal updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/softgoals/{id}",
     *      summary="Remove the specified Softgoal from storage",
     *      tags={"Softgoal"},
     *      description="Delete Softgoal",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Softgoal",
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
        /** @var Softgoal $softgoal */
        $softgoal = $this->softgoalRepository->findWithoutFail($id);

        if (empty($softgoal)) {
            return $this->sendError('Softgoal not found');
        }

        $softgoal->delete();

        return $this->sendResponse($id, 'Softgoal deleted successfully');
    }
}
