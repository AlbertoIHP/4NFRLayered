<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateSoftgoalNfrAPIRequest;
use App\Http\Requests\API\UpdateSoftgoalNfrAPIRequest;
use App\Models\SoftgoalNfr;
use App\Repositories\SoftgoalNfrRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

/**
 * Class SoftgoalNfrController
 * @package App\Http\Controllers\API
 */

class SoftgoalNfrAPIController extends AppBaseController
{
    /** @var  SoftgoalNfrRepository */
    private $softgoalNfrRepository;

    public function __construct(SoftgoalNfrRepository $softgoalNfrRepo)
    {
        $this->softgoalNfrRepository = $softgoalNfrRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/softgoalNfrs",
     *      summary="Get a listing of the SoftgoalNfrs.",
     *      tags={"SoftgoalNfr"},
     *      description="Get all SoftgoalNfrs",
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
     *                  @SWG\Items(ref="#/definitions/SoftgoalNfr")
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
        $this->softgoalNfrRepository->pushCriteria(new RequestCriteria($request));
        $this->softgoalNfrRepository->pushCriteria(new LimitOffsetCriteria($request));
        $softgoalNfrs = $this->softgoalNfrRepository->all();

        return $this->sendResponse($softgoalNfrs->toArray(), 'Softgoal Nfrs retrieved successfully');
    }

    /**
     * @param CreateSoftgoalNfrAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/softgoalNfrs",
     *      summary="Store a newly created SoftgoalNfr in storage",
     *      tags={"SoftgoalNfr"},
     *      description="Store SoftgoalNfr",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="SoftgoalNfr that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/SoftgoalNfr")
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
     *                  ref="#/definitions/SoftgoalNfr"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateSoftgoalNfrAPIRequest $request)
    {
        $input = $request->all();

        $softgoalNfrs = $this->softgoalNfrRepository->create($input);

        return $this->sendResponse($softgoalNfrs->toArray(), 'Softgoal Nfr saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/softgoalNfrs/{id}",
     *      summary="Display the specified SoftgoalNfr",
     *      tags={"SoftgoalNfr"},
     *      description="Get SoftgoalNfr",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of SoftgoalNfr",
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
     *                  ref="#/definitions/SoftgoalNfr"
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
        /** @var SoftgoalNfr $softgoalNfr */
        $softgoalNfr = $this->softgoalNfrRepository->findWithoutFail($id);

        if (empty($softgoalNfr)) {
            return $this->sendError('Softgoal Nfr not found');
        }

        return $this->sendResponse($softgoalNfr->toArray(), 'Softgoal Nfr retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateSoftgoalNfrAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/softgoalNfrs/{id}",
     *      summary="Update the specified SoftgoalNfr in storage",
     *      tags={"SoftgoalNfr"},
     *      description="Update SoftgoalNfr",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of SoftgoalNfr",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="SoftgoalNfr that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/SoftgoalNfr")
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
     *                  ref="#/definitions/SoftgoalNfr"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateSoftgoalNfrAPIRequest $request)
    {
        $input = $request->all();

        /** @var SoftgoalNfr $softgoalNfr */
        $softgoalNfr = $this->softgoalNfrRepository->findWithoutFail($id);

        if (empty($softgoalNfr)) {
            return $this->sendError('Softgoal Nfr not found');
        }

        $softgoalNfr = $this->softgoalNfrRepository->update($input, $id);

        return $this->sendResponse($softgoalNfr->toArray(), 'SoftgoalNfr updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/softgoalNfrs/{id}",
     *      summary="Remove the specified SoftgoalNfr from storage",
     *      tags={"SoftgoalNfr"},
     *      description="Delete SoftgoalNfr",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of SoftgoalNfr",
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
        /** @var SoftgoalNfr $softgoalNfr */
        $softgoalNfr = $this->softgoalNfrRepository->findWithoutFail($id);

        if (empty($softgoalNfr)) {
            return $this->sendError('Softgoal Nfr not found');
        }

        $softgoalNfr->delete();

        return $this->sendResponse($id, 'Softgoal Nfr deleted successfully');
    }
}
