<?php

namespace App\Models;

use App\QueryBuilders\ProductQueryBuilder;
use Database\Factories\ProductFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

/**
 * - Attributes.
 * @property int $id
 * @property string $name
 * @property float $price
 * @property integer $stock
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * - Relations.
 * @property Collection<int,Category> $category
 *  - Support.
 *
 * @method static ProductQueryBuilder query()
 */

class Product extends Model
{
    /** @use HasFactory<ProductFactory> */
    use HasFactory;

    public function category(): belongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function newEloquentBuilder($query): ProductQueryBuilder
    {
        return new ProductQueryBuilder($query);
    }
}
