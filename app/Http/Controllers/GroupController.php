<?php

namespace App\Http\Controllers;

use App\Models\User;
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

        return redirect('/groups/overview');
    }

    // Ist einfach nur der Link
    public function showGroup(Group $group) {

        $posts = $group->posts()->latest()->get();

        return view('groups.show', [
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
        return view('groups.overview', ['groups' => $groups]);
    }

    public function deleteGroup(Group $group) {
        if (auth()->user()->id === $group['user_id']) {
            $group->delete();
        }
        return redirect('/');
    }

    public function inviteToGroup(Request $request, Group $group) {
        $incomingFields = $request->validate([
            'username' => 'required',
            'group_id' => 'required'
        ]);

        $user = User::where('name', $incomingFields['username'])->first();
        $group = Group::where('id', $incomingFields['group_id'])->first();

        if ( $user ) {
            $group->members()->syncWithoutDetaching($user['id']);
        }        

        return redirect()->route('groups.show.single', $incomingFields['group_id']);
    }

    public function deleteUserFromGroup(Group $group, User $user) {
        if ((auth()->user()->id === $group['user_id']) AND ($user['id'] !== $group['user_id'])) {
            $group->members()->detach($user->id);
        }
        return redirect()->route('groups.show.single', $group['id']);
    }

    public function editGroup(Group $group) {
        if ($group->members->contains(auth()->user()->id)) {
            return view('groups.edit', ['group' => $group]);
        }
        abort(403, "Access denied");
    }

    public function saveGroupChanges(Request $request, Group $group) {
        if($group->members->contains(auth()->user()->id)) {
            $incomingFields = $request->validate([
                'name' => 'required',
                'description' => 'max:200'
            ]);

            $incomingFields['name'] = strip_tags($request['name']);
            $incomingFields['description'] = strip_tags($request['description']);

            $group->update($incomingFields);
            $posts = $group->posts()->latest()->get();
            
            return view('groups.show', [
                'group' => $group,
                'posts' => $posts,
                ] );
        }
        abort(403, "Access denied");
    }
}
