<?php

namespace App\Http\Controllers\Api\Expenses;

use App\Http\Controllers\ApiController;
use App\Http\Requests\Expense\Vendor as Request;
use App\Http\Transformers\Expense\Vendor as Transformer;
use App\Models\Expense\Vendor;
use Dingo\Api\Routing\Helpers;

class Vendors extends ApiController
{
    use Helpers;

    /**
     * Display a listing of the resource.
     *
     * @return \Dingo\Api\Http\Response
     */
    public function index()
    {
        $vendors = Vendor::collect();

        return $this->response->paginator($vendors, new Transformer());
    }

    /**
     * Display the specified resource.
     *
     * @param  Vendor  $vendor
     * @return \Dingo\Api\Http\Response
     */
    public function show(Vendor $vendor)
    {
        return $this->response->item($vendor, new Transformer());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  $request
     * @return \Dingo\Api\Http\Response
     */
    public function store(Request $request)
    {
        $vendor = Vendor::create($request->all());

        return $this->response->created(url('api/vendors/'.$vendor->id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  $vendor
     * @param  $request
     * @return \Dingo\Api\Http\Response
     */
    public function update(Vendor $vendor, Request $request)
    {
        $vendor->update($request->all());

        return $this->response->item($vendor->fresh(), new Transformer());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Vendor  $vendor
     * @return \Dingo\Api\Http\Response
     */
    public function destroy(Vendor $vendor)
    {
        $vendor->delete();

        return $this->response->noContent();
    }
}
