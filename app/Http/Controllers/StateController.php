<?php


namespace App\Http\Controllers;


class StateController extends Controller
{
    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $filePath = storage_path('logs'.DIRECTORY_SEPARATOR.'laravel-'.date("Y-m-d").'.log');

        if (!file_exists($filePath)) {
            return response()->json(['message' => 'Log not found']);
        }

        return response()->json(['message' => file_get_contents($filePath)]);
    }
}