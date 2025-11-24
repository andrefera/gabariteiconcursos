<?php

namespace App\Modules\Store\Teams\Services\Actions;

use App\Models\Team;
use App\Modules\Store\Teams\DTO\TeamDTO;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class GetTeams
{
    private const CACHE_KEY = 'teams_list';
    private const CACHE_TTL = 3600; 

    public function __construct()
    {
        // Construtor vazio conforme solicitado
    }

    public function execute(): array
    {
        $this->getTeamsFromDatabase();
    }

    private function getTeamsFromDatabase(): array
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