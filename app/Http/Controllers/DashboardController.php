<?php


namespace App\Http\Controllers;


use App\Models\ConnectionTest;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {
        return Inertia::render('Dashboard', [
            'tests' => ConnectionTest::today()->desc()->paginate(),
            'failedTests' => ConnectionTest::today()->failed()->desc()->paginate(),
        ]);
    }
}
