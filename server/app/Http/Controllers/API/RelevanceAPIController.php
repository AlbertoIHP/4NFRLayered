<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateRelevanceAPIRequest;
use App\Http\Requests\API\UpdateRelevanceAPIRequest;
use App\Models\Relevance;
use App\Repositories\RelevanceRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

/**
 * Class RelevanceController
 * @package App\Http\Controllers\API
 */

class RelevanceAPIController extends AppBaseController
{
    /** @var  RelevanceRepository */
    private $relevanceRepository;

    public function __construct(RelevanceRepository $relevanceRepo)
    {
        $this->relevanceRepository = $relevanceRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/relevances",
     *      summary="Get a listing of the Relevances.",
     *      tags={"Relevance"},
     *      description="Get all Relevances",
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
     *                  @SWG\Items(ref="#/definitions/Relevance")
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
        $this->relevanceRepository->pushCriteria(new RequestCriteria($request));
        $this->relevanceRepository->pushCriteria(new LimitOffsetCriteria($request));
        $relevances = $this->relevanceRepository->all();

        return $this->sendResponse($relevances->toArray(), 'Relevances retrieved successfully');
    }

    /**
     * @param CreateRelevanceAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/relevances",
     *      summary="Store a newly created Relevance in storage",
     *      tags={"Relevance"},
     *      description="Store Relevance",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Relevance that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Relevance")
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
     *                  ref="#/definitions/Relevance"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateRelevanceAPIRequest $request)
    {
        $input = $request->all();

        $relevances = $this->relevanceRepository->create($input);

        return $this->sendResponse($relevances->toArray(), 'Relevance saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/relevances/{id}",
     *      summary="Display the specified Relevance",
     *      tags={"Relevance"},
     *      description="Get Relevance",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Relevance",
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
     *                  ref="#/definitions/Relevance"
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
        /** @var Relevance $relevance */
        $relevance = $this->relevanceRepository->findWithoutFail($id);

        if (empty($relevance)) {
            return $this->sendError('Relevance not found');
        }

        return $this->sendResponse($relevance->toArray(), 'Relevance retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateRelevanceAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/relevances/{id}",
     *      summary="Update the specified Relevance in storage",
     *      tags={"Relevance"},
     *      description="Update Relevance",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Relevance",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Relevance that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Relevance")
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
     *                  ref="#/definitions/Relevance"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateRelevanceAPIRequest $request)
    {
        $input = $request->all();

        /** @var Relevance $relevance */
        $relevance = $this->relevanceRepository->findWithoutFail($id);

        if (empty($relevance)) {
            return $this->sendError('Relevance not found');
        }

        $relevance = $this->relevanceRepository->update($input, $id);

        return $this->sendResponse($relevance->toArray(), 'Relevance updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/relevances/{id}",
     *      summary="Remove the specified Relevance from storage",
     *      tags={"Relevance"},
     *      description="Delete Relevance",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Relevance",
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
        /** @var Relevance $relevance */
        $relevance = $this->relevanceRepository->findWithoutFail($id);

        if (empty($relevance)) {
            return $this->sendError('Relevance not found');
        }

        $relevance->delete();

        return $this->sendResponse($id, 'Relevance deleted successfully');
    }
}
