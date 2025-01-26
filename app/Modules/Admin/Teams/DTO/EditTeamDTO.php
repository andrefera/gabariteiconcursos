<?php

namespace App\Modules\Admin\Teams\DTO;

use App\Models\Team;
use App\Modules\Admin\Teams\Mappers\CountryMapper;

readonly class EditTeamDTO
{
    public function __construct(
        public int     $id,
        public string  $name,
        public ?string $abbreviation,
        public ?string $logo,
        public ?string $country,
        public ?string $country_name,
        public ?string $league
    )
    {
    }

    public static function fromTeam(Team $team): self
    {
        return new self(
            $team->id,
            $team->name,
            $team->abbreviation,
            $team->logo,
            $team->country,
            $team->country ? (new CountryMapper())($team->country) : null,
            $team->league
        );
    }
}
