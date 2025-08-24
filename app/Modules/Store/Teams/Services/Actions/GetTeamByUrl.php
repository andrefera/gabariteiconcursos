<?php

namespace App\Modules\Store\Teams\Services\Actions;

use App\Models\Team;
use App\Modules\Store\Teams\DTO\TeamDTO;
use App\Support\Util\UrlUtil;

class GetTeamByUrl
{
    public function __construct(
        private string $teamUrl
    ) {}

    public function execute(): ?array
    {
        // Buscar o time pelo nome que gera a URL correspondente
        $teams = Team::all();
        
        foreach ($teams as $team) {
            $teamUrl = UrlUtil::formatUrlKey($team->name);
            if ($teamUrl === $this->teamUrl) {
                return TeamDTO::fromModel($team)->toArray();
            }
        }

        return null;
    }
} 