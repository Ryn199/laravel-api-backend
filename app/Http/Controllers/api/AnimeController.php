<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\AnimeResource;
use App\Http\Resources\PostResource;
use App\Models\Anime;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class AnimeController extends Controller
{

 
    public function index(){
        $posts = Anime::latest()->paginate(5);

        return new AnimeResource(true, 'list Data Post', $posts);
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'image'  => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'judul'  => 'required',
            'deskripsi'  => 'required',
            'sinopsis'  => 'required',
            'rating'  => 'required',
        ]);

        // 'image',
        // 'judul',
        // 'deskripsi',
        // 'sinopsis',
        // 'rating',

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $image = $request->file('image');
        $image->storeAs('public/posts', $image->hashName());

        $post = Anime::create([
            'image' => $image->hashName(),
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'sinopsis' => $request->sinopsis,
            'rating' => $request->rating,
        ]);

        return new AnimeResource(true, 'Data Post Berhasil Ditambahkan!', $post);
    }


    public function show($id){
        $post = Anime::find($id);

        return new AnimeResource(true, 'Data Post', $post);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', 
            'judul' => 'required',
            'deskripsi' => 'required',
            'sinopsis' => 'required',
            'rating' => 'required',
        ]);
    
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
    
        $post = Anime::find($id);
    
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $image->storeAs('public/posts', $image->hashName());
    
            // Hapus gambar lama
            Storage::delete('public/posts/' . basename($post->image));
    
            $post->update([
                'image' => $image->hashName(),
                'judul' => $request->judul,
                'deskripsi' => $request->deskripsi,
                'sinopsis' => $request->sinopsis,
                'rating' => $request->rating
            ]);
        } else {
            $post->update([
                'judul' => $request->judul,
                'deskripsi' => $request->deskripsi,
                'sinopsis' => $request->sinopsis,
                'rating' => $request->rating
            ]);
        }
    
        return new AnimeResource(true, 'Data Post Berhasil Diupdate!', $post);
    }
    

    public function destroy($id){
        $post = Anime::find($id);

        //delete old image
        Storage::delete('public/posts/'. basename($post->image));

        $post->delete();

        return new AnimeResource(true, 'Data Post Berhasil Dihapus!', null);
    }
}

