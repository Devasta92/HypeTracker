<?php

namespace App\Http\Controllers;

use App\Models\Group;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    public function createGroup(Request $request) {

        $requests['name'] = $request['groupName'];

        // Formulareingaben werden validiert
        $incomingFields = $request->validate([
            'name' => 'required|unique:groups'
        ]);

        // Eingaben werden entschärft
        $incomingFields['name'] = strip_tags($incomingFields['groupName']);

        // als userId wird der eingeloggte User übergeben
        $incomingFields['user_id'] = auth()->id();
        
        Group::create($incomingFields);

        return redirect('/');
    }

    public function showGroup(Group $group) {
        return view('group', ['group' => $group]);   
    }
}
