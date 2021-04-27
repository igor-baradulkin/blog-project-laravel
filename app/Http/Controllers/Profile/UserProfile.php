<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use App\Models\PageInfo;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;


class UserProfile extends Controller
{
    public function index(Request $request){
        //dd($request->image);
        $user = User::where('username', $request->username)->first();
        $userPosts = $user->pagePosts();

        $username = $user->useranme;
        $id = $user->id;
        $profileImage = PageInfo::where('user_id', $id)->get()[0]['profile_image'];

        //dd($request->username);

        return view('userprofile', [
            'user' => $user,
            'profileImage' => $profileImage
        ]);
    }

    public function store(Request $request)
    {
        $imageFileName = $request->image->getClientOriginalName();

        $request->image->move(Storage::path('/public/image/profilephoto/origin/'), $imageFileName);

        $thumbnail = Image::make(Storage::path('/public/image/profilephoto/') . 'origin/' . $imageFileName);
        $thumbnail->fit(350, 350);
        $thumbnail->save(Storage::path('/public/image/profilephoto/thumbnail/') . $imageFileName);

        $userId = User::where('username', $request->username)->get()[0]['id'];

        $currentProfileImage = PageInfo::where('user_id', $userId)->value('profile_image');
        if($currentProfileImage !== 'default_image.png'){
            unlink(storage_path('app/public/image/profilephoto/origin/' . $currentProfileImage));
            unlink(storage_path('app/public/image/profilephoto/thumbnail/' . $currentProfileImage));
        }

        PageInfo::where('user_id', $userId)->update(['profile_image' => $imageFileName]);

        return back();
    }
}
