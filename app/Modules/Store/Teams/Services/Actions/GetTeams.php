<?php

namespace App\Modules\Store\Teams\Services\Actions;

use App\Models\Team;
use App\Modules\Store\Teams\DTO\TeamDTO;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class GetTeams
{
    public function __construct()
    {
        // Construtor vazio conforme solicitado
    }

    public function execute(): array
    {
        $teamIds = DB::table('teams')
            ->select('teams.id')
            ->join('products', 'teams.id', '=', 'products.team_id')
            ->join('product_sizes', 'products.id', '=', 'product_sizes.product_id')
            ->where('products.is_active', true)
            ->where('product_sizes.stock', '>', 0)
            ->whereNull('teams.deleted_at')
            ->whereNull('products.deleted_at')
            ->distinct()
            ->pluck('teams.id');

        $teams = Team::whereIn('id', $teamIds)
            ->orderBy('name')
            ->get();

        return $teams->map(fn($team) => TeamDTO::fromModel($team)->toArray())->toArray();
    }
} 