<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Group;
use Illuminate\Http\Request;

class PostController extends Controller
{

    public function savePostChanges(Group $group, Post $post, Request $request) {
        // Wenn der angemeldete User den Post erstellt hat, wird das edit-post-Fenster geöffnet, sonst abort
        if (auth()->user()->id === $post['user_id']) {

            $incomingFields = $request->validate([
                'title' => 'required|min:3|max:30',
                'description' => 'nullable|string',
                'imagePath'=> 'nullable|string', 
            ]); 

            // Eingaben werden entschärft
            $incomingFields['title'] = strip_tags($incomingFields['title']);
            $incomingFields['description'] = strip_tags($incomingFields['description']);
            // $incomingFields['imagePath'] = strip_tags($incomingFields['imagePath']);
            $incomingFields['imagePath'] = '';
            

            $post->update($incomingFields);

            return redirect()->route('groups.showGroup', $post['group_id']);
        }

        return abort(403, "Keine Berechtigung diesen Post zu verändern");
    }

    public function editPost(Group $group, Post $post) {
        // Wenn der angemeldete User den Post erstellt hat, wird das edit-post-Fenster geöffnet, sonst abort
        if (auth()->user()->id === $post['user_id']) {
            return view('edit-post', [
                'group'=> $group,
                'post'=> $post,
            ]);
        }

        return abort(403, "Keine Berechtigung diesen Post zu verändern");
    }

    public function deletePost(Group $group, Post $post) {
        if (auth()->user()->id === $post['user_id']) {
            $post->delete();
        }
        return redirect()->route('groups.showGroup', $post['group_id']);
    }

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

        return redirect()->route('groups.showGroup', $incomingFields['group_id']);
    }
}
