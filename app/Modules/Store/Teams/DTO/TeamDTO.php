<?php

namespace App\Modules\Store\Teams\DTO;

use App\Support\Util\UrlUtil;

class TeamDTO
{
    public function __construct(
        public readonly int $id,
        public readonly string $name,
        public readonly string $url,
        public readonly ?string $abbreviation,
        public readonly ?string $logo,
        public readonly ?string $country,
        public readonly ?string $state,
        public readonly ?string $league,
    ) {
    }

    public static function fromModel($team): self
    {
        return new self(
            id: $team->id,
            name: $team->name,
            url: UrlUtil::formatUrlKey($team->name),
            abbreviation: $team->abbreviation,
            logo: $team->logo,
            country: $team->country,
            state: $team->state,
            league: $team->league,
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'url' => $this->url,
            'abbreviation' => $this->abbreviation,
            'logo' => $this->logo,
            'country' => $this->country,
            'state' => $this->state,
            'league' => $this->league,
        ];
    }
} 