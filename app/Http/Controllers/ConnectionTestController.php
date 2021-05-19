<?php


namespace App\Http\Controllers;


use App\Models\ConnectionTest;
use Inertia\Inertia;

class ConnectionTestController extends Controller
{
    public function index()
    {
        return Inertia::render('ConnectionTest/AllTests', [
            'tests' => ConnectionTest::orderBy('created_at', 'desc')->get(),
        ]);
    }
}
