<?php

namespace App\Modules\Admin\Teams\Services\Actions;

use App\Models\Team;
use App\Modules\Admin\Teams\DTO\ListTeamsDTO;
use Illuminate\Http\Request;

readonly class ListTeams
{
    public function __construct(
        private ?int    $id,
        private ?string $name,
        private ?string $country,
        private ?string $league,
        private int     $page = 1,
        private int     $limit = 50
    )
    {
    }

    public function execute(): ListTeamsDTO
    {
        $teams = Team::query()
            ->when($this->id, fn($query) => $query->where('id', $this->id))
            ->when($this->name, fn($query) => $query->where('name', 'like', '%' . $this->name . '%'))
            ->when($this->country, fn($query) => $query->where('country', $this->country))
            ->when($this->league, fn($query) => $query->where('league', $this->league))
            ->orderByDesc('id')
            ->paginate($this->limit, ['*'], 'page', $this->page);


        return new ListTeamsDTO(
            $teams->items(),
            $teams->total(),
            $teams->currentPage(),
            $teams->lastPage(),
            $this->limit
        );

    }

    public static function fromRequest(Request $request): self
    {
        return new self(
            $request->get('id'),
            $request->get('name'),
            $request->get('country'),
            $request->get('league'),
            $request->get('page'),
            $request->get('limit')
        );
    }
}
