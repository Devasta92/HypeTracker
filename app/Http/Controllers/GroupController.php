<?php

namespace App\Http\Controllers;

use App\Models\Group;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    public function createGroup(Request $request) {

        // Formulareingaben werden validiert
        $incomingFields = $request->validate([
            'groupName' => 'required'
        ]);

        // Eingaben werden entschärft
        $incomingFields['name'] = strip_tags($incomingFields['groupName']);

        // als userId wird der eingeloggte User übergeben
        $incomingFields['user_id'] = auth()->id();
        
        Group::create($incomingFields);

        return redirect('/');
    }

    // Ist einfach nur der Link
    public function showGroup(Group $group) {

        $posts = $group->posts;

        return view('group', [
            'group' => $group,
            'posts' => $posts,
        ]);   
    }

    public function deleteGroup(Group $group) {
        if (auth()->user()->id === $group['user_id']) {
            $group->delete();
        }
        return redirect('/');
    }
}
