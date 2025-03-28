<?php

namespace App\Http\Controllers;

use App\Models\Test;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function index() {
        $tests = Test::query()->all();

        return response()->json($tests);
    }

    public function test($id) {
        
    }

    public function store(Request $request) {

    }

    public function destroy($id) {

    }

    public function update($id) {

    }
}
