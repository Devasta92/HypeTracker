<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller

#controller erstellt mit 'php artisan make:controller UserController', im Controller werden Funktionen für den User gesammelt

{
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
