<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Post_group;
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
            'description' => 'nullable|string',
            'imagePath'=> 'nullable|string', 
            'group_id' => 'required|integer'
        ]);

        // Eingaben werden entschärft
        $incomingFields['title'] = strip_tags($incomingFields['title']);
        $incomingFields['description'] = strip_tags($incomingFields['description']);
        // $incomingFields['imagePath'] = strip_tags($incomingFields['imagePath']);
        $incomingFields['imagePath'] = '';

        // weitere Infos werden in das Array gespeichert
        $incomingFields['user_id'] = auth()->id();
        $incomingFields['group_id'] = strip_tags($incomingFields['group_id']);
        

        $post = Post::create($incomingFields);

        
        Post_group::create([
            'post_id' => $post['id'], 
            'group_id' => $incomingFields['group_id']]);

        return redirect()->route('groups.showGroup', $incomingFields['group_id']);
    }
}
