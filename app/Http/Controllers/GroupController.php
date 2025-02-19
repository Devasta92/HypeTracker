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
        
        // Gruppe wird erstellt und der neu angelegte Eintrag wird in der Variable $group angelegt.
        $group = Group::create($incomingFields);

        // Die Beziehung, dass der Ersteller auch ein Member der Gruppe ist wird hergestellt.
        $group->members()->attach(auth()->id());

        return redirect('/group-overview');
    }

    // Ist einfach nur der Link
    public function showGroup(Group $group) {

        $posts = $group->posts()->latest()->get();

        return view('group', [
            'group' => $group,
            'posts' => $posts,
        ]);   
    }

    public function showGroupOverview() {
    // array $groups wird leer initialisiert 
        $groups = [];

        // Wenn der User angemeldet ist, dann wird nach dem user gecheckt, die methode groups() ausgeführt (selbst erstellt) und dann noch sortiert nach dem neusten Eintrag.
        if(auth()->check()) {
            $groups = auth()->user()->memberOfGroups()->latest()->get();
        }

        // die Daten im Array können durch ein blade template genutzt werden
        return view('group-overview', ['groups' => $groups]);
    }

    public function deleteGroup(Group $group) {
        if (auth()->user()->id === $group['user_id']) {
            $group->delete();
        }
        return redirect('/');
    }
}
