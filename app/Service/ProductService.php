<?php

namespace App\Service;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;

class ProductService
{
    public function list(Request $request): LengthAwarePaginator
    {
        $limit = $request->query('limit', 20);

        return Product::query()
            ->with('category')
            ->filterByCategory($request->query('category'))
            ->filterByMinOrMaxPrice(
                $request->query('min_price'),
                $request->query('max_price'),
            )
            ->sortBy(
                $request->query('sort'),
                $request->query('direction', 'asc'),
            )
            ->paginate($limit);
    }
}

