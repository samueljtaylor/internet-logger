<?php


namespace App\Http\Controllers;


use App\Models\ConnectionTest;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ConnectionTestController extends Controller
{
    public function index(Request $request)
    {
        $query = ConnectionTest::query();

        if($request->filter) {
            $filters = explode(',', $request->filter);
            foreach($filters as $filter) {
                try {
                    $query->$filter();
                } catch(\Exception $e) {
                    //
                }
            }
        }

        return Inertia::render('ConnectionTest/AllTests', [
            'tests' => $query->desc()->paginate(),
        ]);
    }


}
