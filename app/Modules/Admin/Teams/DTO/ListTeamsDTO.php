<?php

namespace App\Modules\Admin\Teams\DTO;

use App\Models\Team;

class ListTeamsDTO
{
    /**
     * @var TeamDetailDTO[]
     */
    public array $teams;

    /**
     * @param Team[] $teams
     * @param int $total
     * @param int $currentPage
     * @param int $lastPage
     * @param int $limit
     */
    public function __construct(
        array      $teams,
        public int $total,
        public int $currentPage,
        public int $lastPage,
        public int $limit,
    )
    {
        $this->teams = array_map(fn(Team $team) => TeamDetailDTO::fromTeam($team), $teams);
    }
}
