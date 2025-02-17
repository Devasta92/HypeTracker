<?php

use Inertia\Inertia;
use App\Models\Group;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\ProfileController;

Route::get('/', function() {
    
    // Dieser Weg: Alle Gruppen werden durchsucht und geschaut, wo die user_id mit dem eingeloggten User übereinstimmt. Dann wird es in $groups gespeichert und an denn view übergeben
    // $groups = Group::where('user_id', auth()->id())->get();
    $groups = [];
    if(auth()->check()) {
        $groups = auth()->user()->groups()->latest()->get();
    }

    // die Daten im Array können durch ein blade template genutzt werden
    return view('home', ['groups' => $groups]);
});

# Um eine route mit einem controller zu erstellen, gibt man erst den "Weg an" (route::post, weil ein formular abgeschickt wurde bswp.), 
# dann im Array [Controller::class, 'nameDerFunktion'])
Route::post('/register', [UserController::class, 'register']);
Route::post('/logout', [UserController::class, 'logout']);
Route::post('/login', [UserController::class, 'login']);


// Group related routes
// Route::get('groups/{group}', [GroupController::class, 'show'])-name('groups.show');
Route::get('groups/{group}', [GroupController::class, 'showGroup'])->name('groups.showGroup');
Route::post('/createGroup', [GroupController::class, 'createGroup']);
Route::delete('delete-group/{group}', [GroupController::class, 'deleteGroup']);

// Post related routes
Route::post('/group/{group}/createPost', [PostController::class, 'createPost']);

// Rumspiel related routes
// Einfach in resources/views/random/rumspielen und Schabernack machen
Route::get('rumspielen', function() {
    return view('random.rumspielen');
});


# Stehen geblieben bei folgendem: Ich will die Funktion schreiben, dass man in einer Gruppe einen Post erstellen kann, welcher dem User und der Gruppe in 
# der er verfasst wird, zugeordnet wird. Problem: Keine Ahnung wie ich an die GruppenInfos komme oder auch nur die Gruppeninformationen anzeige
# Nächsten Schritte: Es hinbekommen, dass man von der Homepage aus mit Klick auf eine Gruppe die group.blade.php angezeigt bekommt.
# Hierbei sollten die infos der entsprechenden Gruppe abrufbar sein. Damit bspw. Titel und description passen.
# Siehe: https://laravel.com/docs/11.x/routing#route-model-binding




















/* Weil default routes, einfach auskommentiert, um von Scratch zu bauen. Lasse ich aber Mal drin, wenn wir anfangen Frontendwork zu machen /d
Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
*/