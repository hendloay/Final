<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; 

class PostController extends Controller
{
    public function index()
    {
        $posts = DB::table('posts as post')
            ->orderBy('post.id', 'desc')
            ->get();

        return view('posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new post.
     */
    public function create()
    {
        return view('posts.create');
    }

    public function store(Request $request)
    {
        DB::table('posts')->insert([
            'title'      => 'Midterm Exam',  
            'content'    => 'Laravel Project Implementation', 
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('posts.index')->with('status', 'Post created with static data');
    }

    /**
     * Display the specified post.
     */
    public function show($id)
    {
        $singlePost = DB::table('posts as post')
            ->where('post.id', $id)
            ->first();

        return view('posts.show', ['post' => $singlePost]);
    }

    /**
     * Show the form for editing.
     */
    public function edit($id)
    {
        $post = DB::table('posts as post')
            ->where('post.id', $id)
            ->first();

        return view('posts.edit', compact('post'));
    }

    
    public function update(Request $request, $id)
    {
        DB::table('posts as post')
            ->where('post.id', $id)
            ->update([
                'title'      => 'Updated Exam Title',
                'content'    => 'Updated Content successfully', 
                'updated_at' => now(),
            ]);

        return redirect()->route('posts.index')->with('status', 'Post updated with static data');
    }

    /**
     * Remove the specified post.
     */
    public function destroy($id)
    {
        DB::table('posts as post')
            ->where('post.id', $id)
            ->delete();

        return redirect()->route('posts.index')->with('status', 'Post has been deleted');
    }
}