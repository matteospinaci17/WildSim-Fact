<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FactorialController extends Controller
{
    public function CalculateFactorialWrapper(Request $request)
    {
        if ($request->ajax()) {
            $baseValue = $request->value;
            $factorial = FactorialController::CalculateFactorialRecursive($baseValue);
            return response()->json([
                'factorial' => $factorial
            ], 200);
        }
    }

    public function CalculateFactorialRecursive($v)
    {
        if ($v == 0) {
            return 1;
        } else {
            return ($v * FactorialController::CalculateFactorialRecursive($v - 1));
        }
    }
}
