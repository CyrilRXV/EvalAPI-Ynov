<?php

namespace App\Dto;

use Illuminate\Http\Request;

class ProductFilterDto
{
    public ?string $include;
    public ?string $category;
    public ?float $minPrice;
    public ?float $maxPrice;
    public ?string $sort;
    public ?string $direction;
    public ?int $limit;

    public function __construct(Request $request)
    {
        $this->include   = $request->string('include')->toString();
        $this->category  = $request->string('category')->toString();
        $this->minPrice = is_numeric($request->query('min_price'))
            ? (float) $request->float('min_price')
            : null;
        $this->maxPrice = is_numeric($request->query('max_price'))
            ? (float) $request->float('max_price')
            : null;
        $this->sort      = $request->string('sort')->toString();
        $this->direction = $request->string('direction')->toString('asc');
        $this->limit     = $request->integer('limit') ?? 20;
    }
}
