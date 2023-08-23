<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Post;

use Illuminate\View\View;

use Illuminate\Http\RedirectResponse;

// edit "Storage"
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    public function index(): View
    {
        //get posts
        $posts = Post::latest()->paginate(5);

        //render view with posts
        return view('posts.index', compact('posts'));
    }


    // Create

    public function create(): View
    {
        return view('posts.create');
    }

    public function store(Request $request): RedirectResponse
    {
        //validate form
        $this->validate($request, [
            'gambar'     => 'required|image|mimes:jpeg,jpg,png|max:2048',
            'nama'     => 'required|min:5',
            'deskripsi'   => 'required|min:10'
        ]);

        //upload gamabr
        $gambar = $request->file('gambar');
        $gambar->storeAs('public/posts', $gambar->hashName());

        //create post
        Post::create([
            'gambar'     => $gambar->hashName(),
            'nama'     => $request->nama,
            'deskripsi'   => $request->deskripsi
        ]);

        //redirect to index
        return redirect()->route('posts.index')->with(['success' => 'Data Berhasil Disimpan!']);
    }

    // show
    public function show(string $id): View
    {
        //get post by ID
        $post = Post::findOrFail($id);

        //render view with post
        return view('posts.show', compact('post'));
    }

    //hapus
    public function edit(string $id): View
    {
        //get post by ID
        $post = Post::findOrFail($id);

        //render view with post
        return view('posts.edit', compact('post'));
    }

    /**
     * update
     *
     * @param  mixed $request
     * @param  mixed $id
     * @return RedirectResponse
     */
    public function update(Request $request, $id): RedirectResponse
    {
        //validate form
        $this->validate($request, [
            'gambar'     => 'image|mimes:jpeg,jpg,png|max:2048',
            'nama'     => 'required|min:5',
            'deskripsi'   => 'required|min:10'
        ]);

        //get post
        $post = Post::findOrFail($id);

        //cek gambar 
        if ($request->hasFile('gambar')) {

            //upload gambar baru
            $gambar = $request->file('gambar');
            $gambar->storeAs('public/posts', $gambar->hashName());

            //hapus gambar lama
            Storage::delete('public/posts/' . $post->gambar);

            //update gambar
            $post->update([
                'gambar'     => $gambar->hashName(),
                'nama'     => $request->nama,
                'deskripsi'   => $request->deskripsi
            ]);
        } else {

            //update post without image
            $post->update([
                'nama'          => $request->nama,
                'deskripsi'     => $request->deskripsi
            ]);
        }

        //mengarah ke index
        return redirect()->route('posts.index')->with(['success' => 'Data Berhasil Diubah!']);
    }

    // Hapus
    public function destroy($id): RedirectResponse
    {
        //get ID
        $post = Post::findOrFail($id);

        //delete gambar
        Storage::delete('public/posts/' . $post->image);

        //delete post
        $post->delete();

        //mengarah ke index
        return redirect()->route('posts.index')->with(['success' => 'Data Berhasil Dihapus!']);
    }
}
