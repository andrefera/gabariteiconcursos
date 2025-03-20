<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Team;
use App\Modules\Admin\Teams\DTO\EditTeamDTO;
use App\Modules\Admin\Teams\Services\Actions\CreateOrUpdateTeam;
use App\Modules\Admin\Teams\Services\Actions\GetFilterTeam;
use App\Modules\Admin\Teams\Services\Actions\ListTeams;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TeamController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        return response()->json(ListTeams::fromRequest($request)->execute());
    }

    public function edit(Team $team): JsonResponse
    {
        return response()->json(EditTeamDTO::fromTeam($team));
    }

    public function createOrUpdate(Request $request): JsonResponse
    {
        return response()->json(CreateOrUpdateTeam::fromRequest($request)->execute());
    }

    public function destroy(Team $team): JsonResponse
    {
        try {
            if ($team->products()->count() > 0) {
                throw new Exception("O time possui produtos atrelados.");
            }

            $team->delete();

            return response()->json(['success' => true]);
        } catch (Exception $exception) {
            return response()->json(['success' => false, 'msg' => $exception->getMessage()]);
        }
    }

    public function filter(): JsonResponse
    {
        return response()->json(GetFilterTeam::instantiate()->execute());
    }
}
