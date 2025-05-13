<?php

namespace App\Models;

use App\Modules\Admin\Products\Services\Actions\InsertProductElasticSearch;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'sku',
        'url',
        'description',
        'cost',
        'price',
        'special_price',
        'type',
        'is_active',
        'team_id',
        'sizes_image',
        'gender',
        'season',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'price' => 'float',
        'special_price' => 'float',
        'is_active' => 'boolean',
    ];

    protected static function boot(): void
    {
        parent::boot();

        static::created(function ($model) {
            InsertProductElasticSearch::fromProduct($model)->execute();
        });

        static::updated(function ($model) {
            InsertProductElasticSearch::fromProduct($model)->execute();
        });

        static::saved(function ($model) {
            InsertProductElasticSearch::fromProduct($model)->execute();
        });

        static::deleted(function ($model) {
            InsertProductElasticSearch::fromProduct($model)->execute();
        });

    }

    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class)->orderBy('order');
    }

    public function sizes(): HasMany
    {
        return $this->hasMany(ProductSize::class);
    }

    public function getFinalPrice(): float
    {
        return $this->special_price ?? $this->price;
    }

    public function getStock(): int
    {
        return $this->sizes()->sum('stock');
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'product_categories');
    }
}
