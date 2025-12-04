<?php

namespace App\QueryBuilders;

use App\Dto\ProductFilterDto;
use Illuminate\Database\Eloquent\Builder;

class productQueryBuilder extends Builder
{
    protected array $sortable = ['name', 'price', 'created_at'];

    public function applyFilters(ProductFilterDto $filters): self
    {
        return $this
            ->includeRelations($filters->include)
            ->filterByCategory($filters->category)
            ->filterByMinOrMaxPrice($filters->minPrice, $filters->maxPrice)
            ->sortBy($filters->sort, $filters->direction);
    }

    public function sortBy(?string $sort, ?string $direction): self
    {
        if (!is_string($sort) || !in_array($sort, $this->sortable, true)) {
            return $this;
        }

        $direction = strtolower($direction ?? 'asc');
        $direction = $direction === 'desc' ? 'desc' : 'asc';

        return $this->orderBy($sort, $direction);
    }

    public function filterByCategory(?string $category): self
    {
        return $this->when($category, function (Builder $query, $category) {
            $query->whereRelation('category', 'name', $category);
        });
    }

    public function filterByMinOrMaxPrice(?float $min, ?float $max): self
    {
        return $this
            ->when($min !== null, fn(Builder $query) => $query->where('price', '>=', $min))
            ->when($max !== null, fn(Builder $query) => $query->where('price', '<=', $max));
    }

    public function includeRelations(?string $include): self
    {
        return $this->when($include, function (Builder $query, $include) {
            $query->with($include);
        });
    }
}

