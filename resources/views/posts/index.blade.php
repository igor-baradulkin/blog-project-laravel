@extends('layouts.app')
@section('content')
    <div class="flex justify-center">
        <div class="w-4/12 bg-white p-6 rounded-lg">
            <form action="{{ route('posts') }}" method="post" enctype="multipart/form-data" class="mb-4">
                @csrf
                <div class="mb-4">
                    <label for="body" class="sr-only">Body</label>
                    <textarea name="body" id="body" cols="30" rows="4" class="bg-gray-100 border-2 w-full p-4 rounded-lg @error('body') border-red-500 @enderror" placeholder="What's new in your life?"></textarea>

                    @error('body')
                        <div class="text-red-500 mt-2 text-sm">
                            {{ $message }}
                        </div>
                    @enderror

                </div>

                <div>
                    <input type="file" class="py-2" id="image" name="image">
                </div>

                <div>
                    <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded font-medium">Post</button>
                </div>
            </form>

            @if ($posts->count())
                @foreach($posts as $post)
                    <x-post :post="$post" />
                @endforeach
            @else
                <p>In your blog no posts yet</p>
            @endif

            {{ $posts->links() }}
        </div>

        <div class="pl-5 w-2/12">
            <div class="bg-white p-6 rounded-lg">
                All authors
                @if($users->count())
                <div>
                    @foreach($users as $user)
                        <div>
                           <a href="{{ route('user.profile', $user->username) }}">{{ $user->username }}</a>
                        </div>
                    @endforeach
                </div>
                @else
                    No registered users yet
                @endif
            </div>
        </div>
    </div>
@endsection
