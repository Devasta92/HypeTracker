<?php

use App\Models\Post;
use App\Models\Group;
use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\ProfileController;

Route::get('/', function() {
    
    // Dieser Weg: Alle Gruppen werden durchsucht und geschaut, wo die user_id mit dem eingeloggten User übereinstimmt. Dann wird es in $groups gespeichert und an denn view übergeben
    // $groups = Group::where('user_id', auth()->id())->get();
    $posts = [];
    if(auth()->check()) {
        $groupIds = auth()->user()->memberOfGroups()->pluck('id');

        $posts = Post::whereIn('group_id', $groupIds)->latest()->get();
    }

    // die Daten im Array können durch ein blade template genutzt werden
    return view('home', ['posts' => $posts]);
});

# Um eine route mit einem controller zu erstellen, gibt man erst den "Weg an" (route::post, weil ein formular abgeschickt wurde bswp.), 
# dann im Array [Controller::class, 'nameDerFunktion'])
Route::post('/logout', [UserController::class, 'logout'])->name('users.logout');
Route::post('/login', [UserController::class, 'login'])->name('users.login');
Route::get('/register', [UserController::class, 'showRegistrationWindow'])->name('users.register.form');
Route::post('/register', [UserController::class, 'register'])->name('users.register.submit');
Route::get('/profile', function() {
    return view('profile');
});


// Group related routes
// Route::get('groups/{group}', [GroupController::class, 'show'])-name('groups.show');
Route::get('group/{group}', [GroupController::class, 'showGroup'])->name('groups.showSingle');
Route::get('group-overview', [GroupController::class, 'showGroupOverview'])->name('groups.showAll');

Route::post('/create-group', [GroupController::class, 'createGroup'])->name('groups.create');
Route::delete('delete-group/{group}', [GroupController::class, 'deleteGroup'])->name('groups.delete');

Route::post('/group/{group}/invite-user', [GroupController::class, 'inviteToGroup'])->name('groups.inviteUser');
Route::delete('/group/{group}/delete-user/{user}', [GroupController::class, 'deleteUserFromGroup'])->name('groups.deleteUser');

// Post related routes
Route::post('/group/{group}/create-post', [PostController::class, 'createPost'])->name('posts.create');
Route::get('/group/{group}/edit-post/{post}', [PostController::class, 'editPost'])->name('posts.edit');
Route::put('/group/{group}/edit-post/{post}', [PostController::class, 'savePostChanges'])->name('posts.update');
Route::delete('/group/{group}/delete-post/{post}', [PostController::class, 'deletePost'])->name('posts.delete');


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