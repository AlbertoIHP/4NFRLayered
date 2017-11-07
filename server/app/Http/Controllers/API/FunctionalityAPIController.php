<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateFunctionalityAPIRequest;
use App\Http\Requests\API\UpdateFunctionalityAPIRequest;
use App\Models\Functionality;
use App\Repositories\FunctionalityRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

/**
 * Class FunctionalityController
 * @package App\Http\Controllers\API
 */

class FunctionalityAPIController extends AppBaseController
{
    /** @var  FunctionalityRepository */
    private $functionalityRepository;

    public function __construct(FunctionalityRepository $functionalityRepo)
    {
        $this->functionalityRepository = $functionalityRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/functionalities",
     *      summary="Get a listing of the Functionalities.",
     *      tags={"Functionality"},
     *      description="Get all Functionalities",
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
     *                  @SWG\Items(ref="#/definitions/Functionality")
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
        $this->functionalityRepository->pushCriteria(new RequestCriteria($request));
        $this->functionalityRepository->pushCriteria(new LimitOffsetCriteria($request));
        $functionalities = $this->functionalityRepository->all();

        return $this->sendResponse($functionalities->toArray(), 'Functionalities retrieved successfully');
    }

    /**
     * @param CreateFunctionalityAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/functionalities",
     *      summary="Store a newly created Functionality in storage",
     *      tags={"Functionality"},
     *      description="Store Functionality",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Functionality that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Functionality")
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
     *                  ref="#/definitions/Functionality"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateFunctionalityAPIRequest $request)
    {
        $input = $request->all();

        $functionalities = $this->functionalityRepository->create($input);

        return $this->sendResponse($functionalities->toArray(), 'Functionality saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/functionalities/{id}",
     *      summary="Display the specified Functionality",
     *      tags={"Functionality"},
     *      description="Get Functionality",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Functionality",
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
     *                  ref="#/definitions/Functionality"
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
        /** @var Functionality $functionality */
        $functionality = $this->functionalityRepository->findWithoutFail($id);

        if (empty($functionality)) {
            return $this->sendError('Functionality not found');
        }

        return $this->sendResponse($functionality->toArray(), 'Functionality retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateFunctionalityAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/functionalities/{id}",
     *      summary="Update the specified Functionality in storage",
     *      tags={"Functionality"},
     *      description="Update Functionality",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Functionality",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Functionality that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Functionality")
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
     *                  ref="#/definitions/Functionality"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateFunctionalityAPIRequest $request)
    {
        $input = $request->all();

        /** @var Functionality $functionality */
        $functionality = $this->functionalityRepository->findWithoutFail($id);

        if (empty($functionality)) {
            return $this->sendError('Functionality not found');
        }

        $functionality = $this->functionalityRepository->update($input, $id);

        return $this->sendResponse($functionality->toArray(), 'Functionality updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/functionalities/{id}",
     *      summary="Remove the specified Functionality from storage",
     *      tags={"Functionality"},
     *      description="Delete Functionality",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Functionality",
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
        /** @var Functionality $functionality */
        $functionality = $this->functionalityRepository->findWithoutFail($id);

        if (empty($functionality)) {
            return $this->sendError('Functionality not found');
        }

        $functionality->delete();

        return $this->sendResponse($id, 'Functionality deleted successfully');
    }
}
