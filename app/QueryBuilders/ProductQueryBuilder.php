<?php

namespace App\QueryBuilders;

use Illuminate\Database\Eloquent\Builder;

class productQueryBuilder extends Builder
{
    protected array $sortable = ['name', 'price', 'created_at'];
    public function sortBy(?string $sort, string $direction): self
    {
        if (!is_string($sort)  || !in_array($sort, $this->sortable, true)) {
            return $this;
        }

        return $this->orderBy($sort, $direction);
    }

    public function filterByCategory(?string $category): self
    {
        return $this->when($category, function ($query, $category) {
            $query->whereRelation('category', 'name', $category);
        });
    }

    public function filterByMinOrMaxPrice(?float $min, ?float $max): self
    {
        if (is_float($min)) {
            $this->where('price', '>=', $min);
        }

        if (is_float($max)) {
            $this->where('price', '<=', $max);
        }
        return $this;
    }
}

