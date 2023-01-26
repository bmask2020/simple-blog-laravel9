<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Posts;
use App\Models\Comments;
use Carbon\Carbon;

class FrontendController extends Controller
{
    
    public function home() {

        $posts = Posts::all();
        return view('welcome', compact('posts'));

    }


    public function post_view($id) {

        $post = Posts::find($id);
        $comments = Comments::where('post_id', '=', $post->id)->get();
        return view('post', compact('post', 'comments'));

    }


    public function post_comment_store(Request $request) {

        $validated = $request->validate([
            'post_id'       => 'required',
            'comment'       => 'required',
            
        ]);


        if (Auth::check()) {

            $user_id = auth()->user()->id;

            Comments::insert([

                'post_id'       => $request->post_id,
                'user_id'       => auth()->user()->id,
                'comment'       => $request->comment,
                'created_at'    => Carbon::now()

            ]);

            return redirect()->back();
           
            
        } else {

            return redirect()->route('login');

        }
    }


    public function post_comment_delete($id) {

        Comments::find($id)->delete();

        return redirect()->back();
    }
}
