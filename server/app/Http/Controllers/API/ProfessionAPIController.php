<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateProfessionAPIRequest;
use App\Http\Requests\API\UpdateProfessionAPIRequest;
use App\Models\Profession;
use App\Repositories\ProfessionRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

/**
 * Class ProfessionController
 * @package App\Http\Controllers\API
 */

class ProfessionAPIController extends AppBaseController
{
    /** @var  ProfessionRepository */
    private $professionRepository;

    public function __construct(ProfessionRepository $professionRepo)
    {
        $this->professionRepository = $professionRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/professions",
     *      summary="Get a listing of the Professions.",
     *      tags={"Profession"},
     *      description="Get all Professions",
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
     *                  @SWG\Items(ref="#/definitions/Profession")
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
        $this->professionRepository->pushCriteria(new RequestCriteria($request));
        $this->professionRepository->pushCriteria(new LimitOffsetCriteria($request));
        $professions = $this->professionRepository->all();

        return $this->sendResponse($professions->toArray(), 'Professions retrieved successfully');
    }

    /**
     * @param CreateProfessionAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/professions",
     *      summary="Store a newly created Profession in storage",
     *      tags={"Profession"},
     *      description="Store Profession",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Profession that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Profession")
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
     *                  ref="#/definitions/Profession"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateProfessionAPIRequest $request)
    {
        $input = $request->all();

        $professions = $this->professionRepository->create($input);

        return $this->sendResponse($professions->toArray(), 'Profession saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/professions/{id}",
     *      summary="Display the specified Profession",
     *      tags={"Profession"},
     *      description="Get Profession",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Profession",
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
     *                  ref="#/definitions/Profession"
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
        /** @var Profession $profession */
        $profession = $this->professionRepository->findWithoutFail($id);

        if (empty($profession)) {
            return $this->sendError('Profession not found');
        }

        return $this->sendResponse($profession->toArray(), 'Profession retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateProfessionAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/professions/{id}",
     *      summary="Update the specified Profession in storage",
     *      tags={"Profession"},
     *      description="Update Profession",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Profession",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Profession that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Profession")
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
     *                  ref="#/definitions/Profession"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateProfessionAPIRequest $request)
    {
        $input = $request->all();

        /** @var Profession $profession */
        $profession = $this->professionRepository->findWithoutFail($id);

        if (empty($profession)) {
            return $this->sendError('Profession not found');
        }

        $profession = $this->professionRepository->update($input, $id);

        return $this->sendResponse($profession->toArray(), 'Profession updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/professions/{id}",
     *      summary="Remove the specified Profession from storage",
     *      tags={"Profession"},
     *      description="Delete Profession",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Profession",
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
        /** @var Profession $profession */
        $profession = $this->professionRepository->findWithoutFail($id);

        if (empty($profession)) {
            return $this->sendError('Profession not found');
        }

        $profession->delete();

        return $this->sendResponse($id, 'Profession deleted successfully');
    }
}
