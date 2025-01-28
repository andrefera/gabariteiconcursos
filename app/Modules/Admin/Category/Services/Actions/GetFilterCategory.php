<?php

namespace App\Modules\Admin\Category\Services\Actions;

use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;

readonly class GetFilterCategory
{
    public function __construct()
    {
    }

    public function execute(): Collection
    {
        return Category::query()
            ->select('id as value', 'name as label')
            ->orderBy('name')
            ->get();
    }

    public static function instantiate(): self
    {
        return new self();
    }
}
