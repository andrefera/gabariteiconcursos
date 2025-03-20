<?php

namespace App\Modules\Admin\Teams\Services\Actions;

use App\Models\Team;
use Illuminate\Database\Eloquent\Collection;

readonly class GetFilterTeam
{
    public function __construct()
    {
    }

    public function execute(): Collection
    {
        return Team::query()
            ->select('id as value', 'name as label')
            ->orderBy('name')
            ->get();
    }

    public static function instantiate(): self
    {
        return new self();
    }
}
