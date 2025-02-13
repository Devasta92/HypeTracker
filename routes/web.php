<?php

use Inertia\Inertia;
use App\Models\Group;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
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
Route::post('/createGroup', [GroupController::class, 'createGroup']);





















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