<?php

namespace App\Http\Controllers;

use Throwable;
use Illuminate\Http\Request;
use App\Http\Services\PeruConsult;

class ApiController extends Controller
{
    public function query(Request $request)
    {
        try {

            $type = $request->type;
            $number = $request->number;
            $data = PeruConsult::service($type, $number);

            return response()->json([
                $data
            ]);

        } catch (Throwable $e) {
            return response()->json(['error' => $e], 422);
        }


    }
}
