<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateNfrAPIRequest;
use App\Http\Requests\API\UpdateNfrAPIRequest;
use App\Models\Nfr;
use App\Repositories\NfrRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

/**
 * Class NfrController
 * @package App\Http\Controllers\API
 */

class NfrAPIController extends AppBaseController
{
    /** @var  NfrRepository */
    private $nfrRepository;

    public function __construct(NfrRepository $nfrRepo)
    {
        $this->nfrRepository = $nfrRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/nfrs",
     *      summary="Get a listing of the Nfrs.",
     *      tags={"Nfr"},
     *      description="Get all Nfrs",
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
     *                  @SWG\Items(ref="#/definitions/Nfr")
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
        $this->nfrRepository->pushCriteria(new RequestCriteria($request));
        $this->nfrRepository->pushCriteria(new LimitOffsetCriteria($request));
        $nfrs = $this->nfrRepository->all();

        return $this->sendResponse($nfrs->toArray(), 'Nfrs retrieved successfully');
    }

    /**
     * @param CreateNfrAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/nfrs",
     *      summary="Store a newly created Nfr in storage",
     *      tags={"Nfr"},
     *      description="Store Nfr",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Nfr that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Nfr")
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
     *                  ref="#/definitions/Nfr"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateNfrAPIRequest $request)
    {
        $input = $request->all();

        $nfrs = $this->nfrRepository->create($input);

        return $this->sendResponse($nfrs->toArray(), 'Nfr saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/nfrs/{id}",
     *      summary="Display the specified Nfr",
     *      tags={"Nfr"},
     *      description="Get Nfr",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Nfr",
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
     *                  ref="#/definitions/Nfr"
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
        /** @var Nfr $nfr */
        $nfr = $this->nfrRepository->findWithoutFail($id);

        if (empty($nfr)) {
            return $this->sendError('Nfr not found');
        }

        return $this->sendResponse($nfr->toArray(), 'Nfr retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateNfrAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/nfrs/{id}",
     *      summary="Update the specified Nfr in storage",
     *      tags={"Nfr"},
     *      description="Update Nfr",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Nfr",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Nfr that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Nfr")
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
     *                  ref="#/definitions/Nfr"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateNfrAPIRequest $request)
    {
        $input = $request->all();

        /** @var Nfr $nfr */
        $nfr = $this->nfrRepository->findWithoutFail($id);

        if (empty($nfr)) {
            return $this->sendError('Nfr not found');
        }

        $nfr = $this->nfrRepository->update($input, $id);

        return $this->sendResponse($nfr->toArray(), 'Nfr updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/nfrs/{id}",
     *      summary="Remove the specified Nfr from storage",
     *      tags={"Nfr"},
     *      description="Delete Nfr",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Nfr",
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
        /** @var Nfr $nfr */
        $nfr = $this->nfrRepository->findWithoutFail($id);

        if (empty($nfr)) {
            return $this->sendError('Nfr not found');
        }

        $nfr->delete();

        return $this->sendResponse($id, 'Nfr deleted successfully');
    }
}
