<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Api\ApiController;
use App\Product;
use App\Order;
use App\Http\Requests\SortApiProductRequest;

class ProductController extends ApiController
{
    /**
     * Display a doc of the resource.
     *
     * @param \Illuminate\Http\Request $request request
     *
     * @return \Illuminate\Http\Response
     */
    public function index(SortApiProductRequest $request)
    {
        $product = Product::with('category', 'images')
                        ->when(isset($request->sort) && isset($request->sort_type), function ($query) use ($request) {
                            return $query->orderBy($request->sort, $request->sort_type);
                        })
                        ->when(isset($request->limit), function ($query) use ($request) {
                            return $query->limit($request->limit);
                        })
                        ->when(isset($request->category), function ($query) use ($request) {
                            return $query->whereHas('category', function ($query) use ($request) {
                                        $query->where('id', $request->category);
                            });
                        })->get();
        return $this->responseSuccess($product);
    }
}