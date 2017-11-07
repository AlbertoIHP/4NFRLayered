<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreatePermiseAPIRequest;
use App\Http\Requests\API\UpdatePermiseAPIRequest;
use App\Models\Permise;
use App\Repositories\PermiseRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

/**
 * Class PermiseController
 * @package App\Http\Controllers\API
 */

class PermiseAPIController extends AppBaseController
{
    /** @var  PermiseRepository */
    private $permiseRepository;

    public function __construct(PermiseRepository $permiseRepo)
    {
        $this->permiseRepository = $permiseRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/permises",
     *      summary="Get a listing of the Permises.",
     *      tags={"Permise"},
     *      description="Get all Permises",
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
     *                  @SWG\Items(ref="#/definitions/Permise")
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
        $this->permiseRepository->pushCriteria(new RequestCriteria($request));
        $this->permiseRepository->pushCriteria(new LimitOffsetCriteria($request));
        $permises = $this->permiseRepository->all();

        return $this->sendResponse($permises->toArray(), 'Permises retrieved successfully');
    }

    /**
     * @param CreatePermiseAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/permises",
     *      summary="Store a newly created Permise in storage",
     *      tags={"Permise"},
     *      description="Store Permise",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Permise that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Permise")
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
     *                  ref="#/definitions/Permise"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreatePermiseAPIRequest $request)
    {
        $input = $request->all();

        $permises = $this->permiseRepository->create($input);

        return $this->sendResponse($permises->toArray(), 'Permise saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/permises/{id}",
     *      summary="Display the specified Permise",
     *      tags={"Permise"},
     *      description="Get Permise",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Permise",
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
     *                  ref="#/definitions/Permise"
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
        /** @var Permise $permise */
        $permise = $this->permiseRepository->findWithoutFail($id);

        if (empty($permise)) {
            return $this->sendError('Permise not found');
        }

        return $this->sendResponse($permise->toArray(), 'Permise retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdatePermiseAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/permises/{id}",
     *      summary="Update the specified Permise in storage",
     *      tags={"Permise"},
     *      description="Update Permise",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Permise",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Permise that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Permise")
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
     *                  ref="#/definitions/Permise"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdatePermiseAPIRequest $request)
    {
        $input = $request->all();

        /** @var Permise $permise */
        $permise = $this->permiseRepository->findWithoutFail($id);

        if (empty($permise)) {
            return $this->sendError('Permise not found');
        }

        $permise = $this->permiseRepository->update($input, $id);

        return $this->sendResponse($permise->toArray(), 'Permise updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/permises/{id}",
     *      summary="Remove the specified Permise from storage",
     *      tags={"Permise"},
     *      description="Delete Permise",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Permise",
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
        /** @var Permise $permise */
        $permise = $this->permiseRepository->findWithoutFail($id);

        if (empty($permise)) {
            return $this->sendError('Permise not found');
        }

        $permise->delete();

        return $this->sendResponse($id, 'Permise deleted successfully');
    }
}
