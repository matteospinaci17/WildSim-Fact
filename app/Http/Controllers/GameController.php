<?php

namespace App\Http\Controllers;

use App\Models\GameSession;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class GameController extends Controller
{

    function LoadHomepage()
    {
        $savedSessions = GameSession::get();
        return view('wilderness-simulator')->with('savedSessions', $savedSessions);
    }

    public function NextStep(Request $request)
    {
        if ($request->ajax()) {
            //Check the stepCounter to determinate if a simulation is currently running
            if (Session::get('stepCounter', -1) != -1) {
                //Retrieve current board step from the session
                $gameBoardState = Session::get('gameBoardState');
                foreach ($gameBoardState as $gameBoardSlot) {
                    //case PREY
                    if ($gameBoardSlot['token'] == config('grid.tokens.prey')) {
                        $currentPosition = $gameBoardSlot['coordinate'];
                        $nextMove = GameController::GetNextMove($currentPosition);
                        $nextSlotOccupant = $gameBoardState[GameController::GetIndexByCoordinate($nextMove)]['token'];
                        //If prey meets a vegetable the vegetable disappears
                        if ($nextSlotOccupant == config('grid.tokens.vegetable') || $nextSlotOccupant == config('grid.tokens.empty')) {
                            $gameBoardState[GameController::GetIndexByCoordinate($currentPosition)]['token'] = config(('grid.tokens.empty'));
                            $gameBoardState[GameController::GetIndexByCoordinate($nextMove)]['token'] = config('grid.tokens.prey');
                        }
                        //If the prey meets a predator the prey disappears
                        else if ($nextSlotOccupant == config('grid.tokens.predator')) {
                            $gameBoardState[GameController::GetIndexByCoordinate($currentPosition)]['token'] = config(('grid.tokens.empty'));
                        }
                        //case PREDATOR
                        //Predator meets predator behavior undefined, i assume that they ignore each other
                    } else if ($gameBoardSlot['token'] == config('grid.tokens.predator')) {
                        $currentPosition = $gameBoardSlot['coordinate'];
                        $nextMove = GameController::GetNextMove($currentPosition);
                        $nextSlotOccupant = $gameBoardState[GameController::GetIndexByCoordinate($nextMove)]['token'];
                        //If predator meets a prey the prey disappears
                        if ($nextSlotOccupant == config('grid.tokens.prey') || $nextSlotOccupant == config('grid.tokens.empty')) {
                            $gameBoardState[GameController::GetIndexByCoordinate($currentPosition)]['token'] = config(('grid.tokens.empty'));
                            $gameBoardState[GameController::GetIndexByCoordinate($nextMove)]['token'] = config('grid.tokens.predator');
                        }
                    }
                }
                //Update step counter
                $currentStep = Session::get('stepCounter');
                $currentStep += 1;
                Session::put('stepCounter', $currentStep);
                //Every 20 steps spawn new prey, predator, vegetable
                $spawnRate = 20;
                if ($currentStep % $spawnRate == 0) {
                    $gameBoardState = GameController::SpawnNewCharacters($gameBoardState);
                }
                //Save new board state
                Session::put('gameBoardState', $gameBoardState);

                return response()->json([
                    'boardState' => $gameBoardState,
                    'stepCounter' => Session::get('stepCounter')
                ], 200);
            }
            //If the simulation is not running return Error
            else {
                return response()->json([], 403);
            }
        }
    }

    public function StartSession(Request $request)
    {
        if ($request->ajax()) {
            //Create the board state json with empty slots
            $gameBoardState = [];
            foreach (config('grid.coordinates') as $coordinate) {
                $gameBoardState[] = [
                    'coordinate' => $coordinate,
                    'token' => config('grid.tokens.empty')
                ];
            }
            //Choose 8 slots as Stones
            $numberOfStones = 8;
            $stonesCoordinates = Arr::random(range(0, 80), $numberOfStones);
            foreach ($stonesCoordinates as $stoneCoordinate) {
                $gameBoardState[$stoneCoordinate]['token'] = config('grid.tokens.stone');
            }

            $gameBoardState = GameController::SpawnNewCharacters($gameBoardState);

            //Info about items placement for the current simulation will be saved in the browser session
            Session::put('gameBoardState', $gameBoardState);
            Session::put('stepCounter', 0);

            return response()->json([
                'boardState' => $gameBoardState,
                'stepCounter' => Session::get('stepCounter')
            ], 200);
        }
    }

    public function StopSession(Request $request)
    {
        if ($request->ajax()) {
            //Check if the session has started
            if (Session::get('stepCounter', -1) != -1) {
                //Save the current session to the DB
                $gameState = new GameSession();
                $gameState->step_number = Session::get('stepCounter');
                $gameState->current_board_state = json_encode(Session::get('gameBoardState'));
                $savedSessionCounter = DB::table('game_sessions')->count();
                $gameState->session_name = "Life" . $savedSessionCounter;
                $gameState->save();
                //End session
                Session::put('stepCounter', -1);
                //Send to the frond-end the saved session id
                return response()->json([
                    'savedSessionId' => $gameState->session_name,
                ], 200);
            }
            //If the simulation is not running return Error
            else {
                return response()->json([], 403);
            }
        }
    }

    public function RestoreSession(Request $request)
    {
        if ($request->ajax()) {
            //Retrieve session info from DB by id
            $gameState = GameSession::where('session_name', $request->sessionName)->first();
            //Save them in the session
            Session::put('stepCounter', $gameState->step_number);
            Session::put('gameBoardState', json_decode($gameState->current_board_state, true));
            //Send the new state to the frontend
            return response()->json([
                'boardState' => Session::get('gameBoardState'),
                'stepCounter' => Session::get('stepCounter')
            ], 200);
        }
    }

    private function GetNextMove($currentPosition)
    {
        //Check if the movement would go out of grid borders
        while (true) {
            $movement = rand(0, 3);
            switch ($movement) {
                    //North
                case 0:
                    if ($currentPosition[0] != 'a') {
                        $nextChar = chr(ord($currentPosition[0]) - 1);
                        return $nextChar . $currentPosition[1];
                    }
                    break;
                    //East
                case 1:
                    if ($currentPosition[1] != '9') {
                        $nextIndex = $currentPosition[1] + 1;
                        return $currentPosition[0] . $nextIndex;
                    }
                    break;
                    //South
                case 2:
                    if ($currentPosition[0] != 'h') {
                        $previousChar = chr(ord($currentPosition[0]) + 1);
                        return $previousChar . $currentPosition[1];
                    }
                    break;
                    //West
                case 3:
                    if ($currentPosition[1] != '0') {
                        $nextIndex = $currentPosition[1] - 1;
                        return $currentPosition[0] . $nextIndex;
                    }
                    break;
            }
        }
    }

    private function GetIndexByCoordinate($coordinate)
    {
        $literals = ['a', 'b', 'c', 'd', 'e', 'f', 'g', 'h'];
        $literal = $coordinate[0];
        $index = $coordinate[1];

        $literalIndex = array_search($literal, $literals);

        return $literalIndex * 10 + $index;
    }

    private function SpawnNewCharacters($currentBoardState)
    {
        //Collect free slots index
        $freeSlotsIndex = array();
        foreach ($currentBoardState as $gameBoardSlot) {
            if ($gameBoardSlot['token'] == config('grid.tokens.empty')) {
                array_push($freeSlotsIndex, GameController::GetIndexByCoordinate($gameBoardSlot['coordinate']));
            }
        }
        //if free slots are less then 3 skip this generation
        if (count($freeSlotsIndex) > 2) {
            $characterCoordinates = Arr::random($freeSlotsIndex, 3);
            //Choose 1 slot as Prey
            $currentBoardState[$characterCoordinates[0]]['token'] = config('grid.tokens.prey');
            //Choose 1 slot as Predator
            $currentBoardState[$characterCoordinates[1]]['token'] = config('grid.tokens.predator');
            //Choose 1 slot as Vegetable
            $currentBoardState[$characterCoordinates[2]]['token'] = config('grid.tokens.vegetable');
        }

        return $currentBoardState;
    }
}
