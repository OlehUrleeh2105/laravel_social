<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

use App\Models\Posts;
use App\Models\Comments;
use App\Models\PostLikes;

class UserController extends Controller
{
    public function onAddPost() {
        return view('add_post');
    }

    public function onAddedPost(Request $request) {
        if ($request->isMethod('post')) {
            $request->validate([
                'content' => 'required|string',
                'images.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            ]);

            $product = Posts::create([
                'content' => $request->input('content'),
                'created_by' => Auth::id(),
            ]);

            $productImageFolder = public_path('assets/' . $product->id);
            if (!file_exists($productImageFolder)) {
                mkdir($productImageFolder, 0755, true);
            }

            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $imageName = Str::random(20) . '.' . $image->getClientOriginalExtension();
                    $image->move($productImageFolder, $imageName);
                }
            }
        }

        return redirect()->route('welcome');
    }

    public function onAddComment(Request $request) {
        if (!Auth::user()) {
            return redirect()->back();
        }

        if ($request->isMethod('post')) {
            $request->validate([
                'content' => 'required|string',
            ]);

            $product = Comments::create([
                'content' => $request->input('content'),
                'user_id' => Auth::user()->id,
                'post_id' => $request->route('id'),
            ]);

            return redirect()->back();
        }

        return redirect()->back();
    }

    public function onAddLike(Request $request) {
        $user_id = Auth::user()->id;
        $post_id = $request->id;
        
        $liked = PostLikes::where([
            'user_id' => $user_id, 
            'post_id' => $post_id,
        ])->first();

        if($liked) {
            $liked->delete();
        } else {
            PostLikes::create([
                'user_id' => $user_id,
                'post_id' => $post_id,
            ]);
        }

        return redirect()->back();
    }

    public function onComments(Request $request) {
        $comments = Comments::where('post_id', $request->id)
            ->orderBy('created_at', 'DESC')
            ->get();
            
        return view('comments', ['comments' => $comments]);
    }

    public function onUserLikedPosts() {
        $posts = [];

        $likes = PostLikes::where('user_id', Auth::user()->id)->get();
        foreach($likes as $like) {
            $posts[] = Posts::find($like->post_id);
        }

        return view('liked', ['posts' => $posts]);
    }
}
