<?php


namespace App\Http\Controllers;


use App\Models\ConnectionTest;
use Inertia\Inertia;

class MetricsController extends Controller
{
    public function index()
    {
        return Inertia::render('Metrics', [
            'tests' => ConnectionTest::desc()->paginate(),
            'failedTests' => ConnectionTest::failed()->desc()->paginate(),
        ]);
    }
}
