<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PostController extends Controller
{
    public function createPost(Request $request) {
        $request['title'] = $request['postTitle'];
        $request['description'] = $request['postDescription'];
        $request['imagePath'] = $request['postImage'];

        // Formulareingaben werden validiert
        $incomingFields = $request->validate([
            'title' => 'required|min:3|max:30',
            'description',
            'imagePath' 
        ]);

        // Eingaben werden entschärft
        $incomingFields['title'] = strip_tags($incomingFields['title']);
        $incomingFields['description'] = strip_tags($incomingFields['description']);
        $incomingFields['imagePath'] = strip_tags($incomingFields['imagePath']);

        // weitere Infos werden in das Array gespeichert
        $incomingFields['user_id'] = auth()->id();
        $incomingFields['group_id'] = 'aktuelle Gruppe amk';




    }
}
