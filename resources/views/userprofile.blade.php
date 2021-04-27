@extends('layouts.app')
@section('content')
    <div class="flex justify-center">
        <div class="w-2/12">
            <div class="bg-white p-6 rounded-lg">
                <div>
                    <img src="{{ asset('storage/image/profilephoto/thumbnail/' . $profileImage) }}">
                    @if(auth()->user()->id === $user->id)
                    <form action="{{ route('user.photo', $user->username) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <p><input type="file" class="py-2" id="image" name="image"></p>
                        <p><button type="submit" class="bg-green-500 text-white px-4 py-2 rounded font-medium">Update profile photo</button></p>
                    </form>
                    @endif
                </div>
            </div>

            <div class="py-3">
                <div class="bg-white rounded-lg px-6">
                    friends
                </div>
            </div>
        </div>

        <div class="px-4 w-4/12">
            <div class="bg-white rounded-lg p-6">
                <div class="">
                    {{ $user->username  }}
                </div>
            </div>

            <div class="py-5">
                <div class="bg-white rounded-lg p-6">
                    @if(auth()->user()->id === $user->id)
                    <form action="{{ route('user.page.post', $user->username) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="">
                            <textarea name="body" id="body" cols="30" rows="1" class="bg-gray-100 border-2 w-full p-2 rounded-lg @error('body') border-red-500 @enderror" placeholder="What's new in your life?"></textarea>
                        </div>

                        <div>
                            <input type="file" class="py-2" id="image" name="image">
                        </div>

                        <div class="py-2">
                            <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded font-medium">Post</button>
                        </div>
                    </form>
                    @else
                    <div>
                        Posts
                    </div>
                    @endif
                </div>
            </div>

            <div class="bg-white rounded-lg px-6">
             @foreach($user->pagePosts as $post)
                   <div class="py-2">
                       <a href="{{ route('user.profile', $post->user->username) }}" class="font-blod">{{ $post->user->name }}</a> <span class="text-gray-600 text-sm">{{ $post->user->created_at->diffForHumans() }}</span>
                       <p class="mb-4">{{ $post->body }}</p>
                       @if($post->image)
                            <p><img src="{{ asset('storage/image/profileposts/thumbnail/' . $post->image) }}"></p>
                       @endif
                   </div>
            @endforeach
            </div>
        </div>
    </div>
@endsection


