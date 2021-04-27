<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::with(['user', 'likes'])->paginate(20);
        $users = User::all();

        return view('posts.index', [
            'posts' => $posts,
            'users' => $users,
        ]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'body' => 'required',
        ]);

        if($request->image) {
            $imageFileName = $request->all()['image']->getClientOriginalName();

            $request->image->move(Storage::path('/public/image/posts/') . 'origin', $imageFileName);

            $thumbnail = Image::make(Storage::path('/public/image/posts/') . 'origin/' . $imageFileName);
            $thumbnail->fit(500, 500);
            $thumbnail->save(Storage::path('/public/image/posts/') . 'thumbnail/' . $imageFileName);
        }

        $request->user()->posts()->create([
            'body' => $request->body,
            'image' => $request->image ? $imageFileName : null
        ]);

        return back();
    }

    public function destroy(Post $post)
    {
        $this->authorize('delete', $post);

        $imageName = $post->image;

        unlink(storage_path('app/public/image/posts/origin/' . $imageName));
        unlink(storage_path('app/public/image/posts/thumbnail/' . $imageName));

        $post->delete();

        return back();
    }
}
