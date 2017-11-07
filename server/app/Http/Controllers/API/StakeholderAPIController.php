<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateStakeholderAPIRequest;
use App\Http\Requests\API\UpdateStakeholderAPIRequest;
use App\Models\Stakeholder;
use App\Repositories\StakeholderRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

/**
 * Class StakeholderController
 * @package App\Http\Controllers\API
 */

class StakeholderAPIController extends AppBaseController
{
    /** @var  StakeholderRepository */
    private $stakeholderRepository;

    public function __construct(StakeholderRepository $stakeholderRepo)
    {
        $this->stakeholderRepository = $stakeholderRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/stakeholders",
     *      summary="Get a listing of the Stakeholders.",
     *      tags={"Stakeholder"},
     *      description="Get all Stakeholders",
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
     *                  @SWG\Items(ref="#/definitions/Stakeholder")
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
        $this->stakeholderRepository->pushCriteria(new RequestCriteria($request));
        $this->stakeholderRepository->pushCriteria(new LimitOffsetCriteria($request));
        $stakeholders = $this->stakeholderRepository->all();

        return $this->sendResponse($stakeholders->toArray(), 'Stakeholders retrieved successfully');
    }

    /**
     * @param CreateStakeholderAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/stakeholders",
     *      summary="Store a newly created Stakeholder in storage",
     *      tags={"Stakeholder"},
     *      description="Store Stakeholder",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Stakeholder that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Stakeholder")
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
     *                  ref="#/definitions/Stakeholder"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateStakeholderAPIRequest $request)
    {
        $input = $request->all();

        $stakeholders = $this->stakeholderRepository->create($input);

        return $this->sendResponse($stakeholders->toArray(), 'Stakeholder saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/stakeholders/{id}",
     *      summary="Display the specified Stakeholder",
     *      tags={"Stakeholder"},
     *      description="Get Stakeholder",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Stakeholder",
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
     *                  ref="#/definitions/Stakeholder"
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
        /** @var Stakeholder $stakeholder */
        $stakeholder = $this->stakeholderRepository->findWithoutFail($id);

        if (empty($stakeholder)) {
            return $this->sendError('Stakeholder not found');
        }

        return $this->sendResponse($stakeholder->toArray(), 'Stakeholder retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateStakeholderAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/stakeholders/{id}",
     *      summary="Update the specified Stakeholder in storage",
     *      tags={"Stakeholder"},
     *      description="Update Stakeholder",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Stakeholder",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Stakeholder that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Stakeholder")
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
     *                  ref="#/definitions/Stakeholder"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateStakeholderAPIRequest $request)
    {
        $input = $request->all();

        /** @var Stakeholder $stakeholder */
        $stakeholder = $this->stakeholderRepository->findWithoutFail($id);

        if (empty($stakeholder)) {
            return $this->sendError('Stakeholder not found');
        }

        $stakeholder = $this->stakeholderRepository->update($input, $id);

        return $this->sendResponse($stakeholder->toArray(), 'Stakeholder updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/stakeholders/{id}",
     *      summary="Remove the specified Stakeholder from storage",
     *      tags={"Stakeholder"},
     *      description="Delete Stakeholder",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Stakeholder",
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
        /** @var Stakeholder $stakeholder */
        $stakeholder = $this->stakeholderRepository->findWithoutFail($id);

        if (empty($stakeholder)) {
            return $this->sendError('Stakeholder not found');
        }

        $stakeholder->delete();

        return $this->sendResponse($id, 'Stakeholder deleted successfully');
    }
}
