<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller

#controller erstellt mit 'php artisan make:controller UserController', im Controller werden Funktionen für den User gesammelt

{
    public function editUser(User $user) {
        if ( auth()->user()->id === $user['id'] ) {
            return view('users.edit', ['user' => $user] );
        }        
        abort(403, 'Access denied');
    }

    public function updateUser(Request $request, User $user) {

        // Check: Current password
        $pwcheck = Hash::check($request['password'], $user['password']);

        if ( auth()->user()->id === $user['id'] && $pwcheck) {
            $incomingFields = $request->validate([
                'name' => ['required','min:6','max:16', Rule::unique('users')->ignore($user->id)],
                'email' => ['required','email', Rule::unique('users')->ignore($user->id)],
                'newPassword' => ['nullable', 'min:8', 'max:99', 'confirmed'],
            ]);

            if ( $incomingFields['newPassword'] ) {
                $incomingFields['password'] = bcrypt($incomingFields['newPassword']);
            };

            $user->update($incomingFields);

            return redirect('/');            
        }        
        abort(403, 'Access denied');
    }

    public function showRegistrationWindow() {
        return view('users.register');
    }

    public function register(Request $request) { # (Request $request) speichert automatisch die Werte, welche mitgegeben werden in der Funktion in $request
        
        # Die Daten werden validiert und als assoziatives Array in $incomingFields gespeichert
        $incomingFields = $request->validate([
            'name' => 'required|min:6|max:16|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8|max:99'
        ]);

        # Das Passwort wird verschlüsselt
        $incomingFields['password'] = bcrypt($incomingFields['password']);

        # Ein User wird erstellt mit den Daten aus dem Formular und in der Datenbank gespeichert (database/databaase.sqlite) - er wird außerdem in der Variable gespeichert
        $user = User::create($incomingFields);

        auth()->login($user);

        return redirect('/'); 
    }

    public function logout() {
        
        # auth() ist eine globale Hilfsfunktion
        auth()->logout();
        
        return redirect('/');

    }

    public function login(Request $request) {

        // Validierung der Formulareingaben
        $incomingFields = $request->validate([
            'loginname' => 'required',
            'loginpassword' => 'required'
        ]);

        // Entschärfung der Eingaben
        $incomingFields['loginname'] =  strtolower(strip_tags($incomingFields['loginname']));
        $incomingFields['loginpassword'] = strip_tags($incomingFields['loginpassword']);

        // Einlog-Versuch
        if(auth()->attempt(['name' => $incomingFields['loginname'], 'password' => $incomingFields['loginpassword']])) {
            $request->session()->regenerate();
        }
        
        return redirect('/');
    }
}
