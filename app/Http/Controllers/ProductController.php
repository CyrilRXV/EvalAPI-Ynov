<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductResource;
use App\Service\ProductService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __construct(
        private readonly ProductService $productService,
    ){}

    public function index(Request $request)
    {
        return ProductResource::collection(
            $this->productService->list($request)
        )->response();
    }
}
