<?php

namespace App\Http\Controllers;

use App\DataTables\ShareDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateShareRequest;
use App\Http\Requests\UpdateShareRequest;
use App\Repositories\ShareRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;

class ShareController extends AppBaseController
{
    /** @var  ShareRepository */
    private $shareRepository;

    public function __construct(ShareRepository $shareRepo)
    {
        $this->shareRepository = $shareRepo;
    }

    /**
     * Display a listing of the Share.
     *
     * @param ShareDataTable $shareDataTable
     * @return Response
     */
    public function index(ShareDataTable $shareDataTable)
    {
        return $shareDataTable->render('shares.index');
    }

    /**
     * Show the form for creating a new Share.
     *
     * @return Response
     */
    public function create()
    {
        return view('shares.create');
    }

    /**
     * Store a newly created Share in storage.
     *
     * @param CreateShareRequest $request
     *
     * @return Response
     */
    public function store(CreateShareRequest $request)
    {
        $input = $request->all();

        $share = $this->shareRepository->create($input);

        Flash::success('Share saved successfully.');

        return redirect(route('shares.index'));
    }

    /**
     * Display the specified Share.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $share = $this->shareRepository->findWithoutFail($id);

        if (empty($share)) {
            Flash::error('Share not found');

            return redirect(route('shares.index'));
        }

        return view('shares.show')->with('share', $share);
    }

    /**
     * Show the form for editing the specified Share.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $share = $this->shareRepository->findWithoutFail($id);

        if (empty($share)) {
            Flash::error('Share not found');

            return redirect(route('shares.index'));
        }

        return view('shares.edit')->with('share', $share);
    }

    /**
     * Update the specified Share in storage.
     *
     * @param  int              $id
     * @param UpdateShareRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateShareRequest $request)
    {
        $share = $this->shareRepository->findWithoutFail($id);

        if (empty($share)) {
            Flash::error('Share not found');

            return redirect(route('shares.index'));
        }

        $share = $this->shareRepository->update($request->all(), $id);

        Flash::success('Share updated successfully.');

        return redirect(route('shares.index'));
    }

    /**
     * Remove the specified Share from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $share = $this->shareRepository->findWithoutFail($id);

        if (empty($share)) {
            Flash::error('Share not found');

            return redirect(route('shares.index'));
        }

        $this->shareRepository->delete($id);

        Flash::success('Share deleted successfully.');

        return redirect(route('shares.index'));
    }
}
