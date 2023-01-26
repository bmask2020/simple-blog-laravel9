<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Posts;
use Carbon\Carbon;
use Image;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $Posts = Posts::latest()->paginate(10);
        return view('home', compact('Posts'));
        
    }


    public function trashed_post() {

        $trashed = Posts::onlyTrashed()->latest()->paginate(10);
        return view('backend.post.trashed', compact('trashed'));

    }

    public function post_add() {

        return view('backend.post.add');
        
    }

    public function post_store(Request $request) {

        $validated = $request->validate([
            'title'         => 'required|unique:Posts|regex:/^[\pL\s\-]+$/u',
            'content'       => 'required|min:20',
            'post_image'    => 'required|mimes:png,jpg,webp|max:2048'
        ]);


        $post_image = $request->file('post_image');

        $name_gen = hexdec(uniqid()).'.'.$post_image->getClientOriginalExtension();
        Image::make($post_image)->resize(300,300)->save('posts/'.$name_gen);

        $source = 'posts/'.$name_gen;

        Posts::insert([

            'title'         => $request->title,
            'author'        => auth()->user()->id,
            'content'       => $request->content,
            'image'         => $source,
            'created_at'    => Carbon::now()

        ]);

        return redirect()->route('dashboard');


        
    }


    public function post_edit($id) {

        $Posts = Posts::find($id);
        return view('backend.post.edit', compact('Posts'));
    }


    public function post_update(Request $request, $id) {

        $validated = $request->validate([
            'title'     => 'regex:/^[\pL\s\-]+$/u',
            'content'   => 'min:20',
            'image'     => 'mimes:png,jpg,webp|max:2048'
        ]);

        $image = $request->file('image');

        if($request->file('image')) {

            $image = $request->file('image');

            $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
            Image::make($image)->resize(250,250)->save('posts/'.$name_gen);
    
            $source = 'posts/'.$name_gen;

            unlink($request->old_img);

        } else {

            $source = $request->old_img;


        }


         Posts::where('id','=', $id)->update([

            'title'         => $request->title,
            'author'        => auth()->user()->id,
            'content'       => $request->content,
            'image'         => $source,
            'updated_at'    => Carbon::now()

        ]);

        return redirect()->route('dashboard');
        
    }


    public function post_soft_delete($id) {

        $del =  Posts::find($id)->delete();
        return redirect()->back();

    }


    public function post_restore($id) {

        $deleted = Posts::withTrashed()->find($id)->restore();

        return redirect()->back();
    }


    public function post_force_delete($id) {

        $get_img = Posts::find($id);
        $trashed = Posts::onlyTrashed()->find($id)->forceDelete();
        unlink($get_img->image);
        return redirect()->back();



    }
}
