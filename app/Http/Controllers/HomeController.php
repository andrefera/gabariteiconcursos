<?php

namespace App\Http\Controllers;

use App\Modules\Store\Teams\Services\Actions\GetTeams;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function getTeams()
    {
        $getTeamsAction = new GetTeams();
        $teams = $getTeamsAction->execute();
        
        return response()->json($teams);
    }
}
