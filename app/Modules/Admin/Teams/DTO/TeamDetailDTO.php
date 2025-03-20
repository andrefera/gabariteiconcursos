<?php

namespace App\Modules\Admin\Teams\DTO;

use App\Models\Team;
use App\Modules\Admin\Teams\Mappers\CountryMapper;

readonly class TeamDetailDTO
{
    public function __construct(
        public int     $id,
        public string  $name,
        public ?string $abbreviation,
        public ?string $logo,
        public ?string $country,
        public ?string $league,
        public int     $products
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
            $team->country ? (new CountryMapper())($team->country) : null,
            $team->league,
            $team->products()->count()
        );
    }
}
