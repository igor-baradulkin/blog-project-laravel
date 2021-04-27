<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class PagePostsController extends Controller
{
    public function store(Request $request){
        $this->validate($request, [
            'body' => 'required'
        ]);

        if($request->image){

            $imageFileName = $request->image->getClientOriginalName();

            $request->image->move(Storage::path('/public/image/profileposts/origin/'), $imageFileName);

            $thumbnail = Image::make(Storage::path('/public/image/profileposts/origin/') . $imageFileName);
            $thumbnail->fit(500, 500);
            $thumbnail->save(Storage::path('/public/image/profileposts/thumbnail/') . $imageFileName);

        }
        $request->user()->pagePosts()->create([
            'body' => $request->body,
            'image' => $request->image ? $imageFileName : null
        ]);

        return back();
    }
}
