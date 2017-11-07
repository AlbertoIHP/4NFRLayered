<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateGoalAPIRequest;
use App\Http\Requests\API\UpdateGoalAPIRequest;
use App\Models\Goal;
use App\Repositories\GoalRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

/**
 * Class GoalController
 * @package App\Http\Controllers\API
 */

class GoalAPIController extends AppBaseController
{
    /** @var  GoalRepository */
    private $goalRepository;

    public function __construct(GoalRepository $goalRepo)
    {
        $this->goalRepository = $goalRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/goals",
     *      summary="Get a listing of the Goals.",
     *      tags={"Goal"},
     *      description="Get all Goals",
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
     *                  @SWG\Items(ref="#/definitions/Goal")
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
        $this->goalRepository->pushCriteria(new RequestCriteria($request));
        $this->goalRepository->pushCriteria(new LimitOffsetCriteria($request));
        $goals = $this->goalRepository->all();

        return $this->sendResponse($goals->toArray(), 'Goals retrieved successfully');
    }

    /**
     * @param CreateGoalAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/goals",
     *      summary="Store a newly created Goal in storage",
     *      tags={"Goal"},
     *      description="Store Goal",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Goal that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Goal")
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
     *                  ref="#/definitions/Goal"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateGoalAPIRequest $request)
    {
        $input = $request->all();

        $goals = $this->goalRepository->create($input);

        return $this->sendResponse($goals->toArray(), 'Goal saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/goals/{id}",
     *      summary="Display the specified Goal",
     *      tags={"Goal"},
     *      description="Get Goal",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Goal",
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
     *                  ref="#/definitions/Goal"
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
        /** @var Goal $goal */
        $goal = $this->goalRepository->findWithoutFail($id);

        if (empty($goal)) {
            return $this->sendError('Goal not found');
        }

        return $this->sendResponse($goal->toArray(), 'Goal retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateGoalAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/goals/{id}",
     *      summary="Update the specified Goal in storage",
     *      tags={"Goal"},
     *      description="Update Goal",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Goal",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Goal that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Goal")
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
     *                  ref="#/definitions/Goal"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateGoalAPIRequest $request)
    {
        $input = $request->all();

        /** @var Goal $goal */
        $goal = $this->goalRepository->findWithoutFail($id);

        if (empty($goal)) {
            return $this->sendError('Goal not found');
        }

        $goal = $this->goalRepository->update($input, $id);

        return $this->sendResponse($goal->toArray(), 'Goal updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/goals/{id}",
     *      summary="Remove the specified Goal from storage",
     *      tags={"Goal"},
     *      description="Delete Goal",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Goal",
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
        /** @var Goal $goal */
        $goal = $this->goalRepository->findWithoutFail($id);

        if (empty($goal)) {
            return $this->sendError('Goal not found');
        }

        $goal->delete();

        return $this->sendResponse($id, 'Goal deleted successfully');
    }
}
