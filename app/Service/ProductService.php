<?php

namespace App\Service;

use App\Dto\ProductFilterDto;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class ProductService
{
    public function list(Request $request): LengthAwarePaginator
    {
        $filters = new ProductFilterDTO($request);

        return Product::query()
            ->applyFilters($filters)
            ->paginate($filters->limit);
    }
}

