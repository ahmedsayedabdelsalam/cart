<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\CartStoreRequest;
use App\Http\Requests\Api\CartUpdateRequest;
use App\Models\ProductVariation;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CartStoreRequest $request, \App\Cart\Cart $cart)
    {
        $cart->add($request->products);
    }

    /**
     * Display the specified resource.
     *
     * @param  ProductVariation $productVariation
     * @return \Illuminate\Http\Response
     */
    public function show(ProductVariation $productVariation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  ProductVariation $productVariation
     * @return \Illuminate\Http\Response
     */
    public function edit(ProductVariation $productVariation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  ProductVariation $productVariation
     * @return \Illuminate\Http\Response
     */
    public function update(CartUpdateRequest $request, ProductVariation $productVariation, \App\Cart\Cart $cart)
    {
        $cart->update($productVariation->id, $request->quantity);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  ProductVariation $productVariation
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProductVariation $productVariation, \App\Cart\Cart $cart)
    {
        $cart->delete($productVariation->id);
    }
}
