@props(['post' => $post])

<div class="mb-4">
    <a href="{{ route('user.profile', $post->user->username) }}" class="font-blod">{{ $post->user->username }}</a> <span class="text-gray-600 text-sm">{{ $post->user->created_at->diffForHumans() }}</span>

    <p class="mb-4">{{ $post->body }}</p>

    @if($post->image)
        <p><img src="{{ asset('storage/image/posts/thumbnail/' . $post->image) }}"></p>
    @endif
    <div class="flex items-center">
        @auth()
            @if(!$post->likedBy(auth()->user()))
                <form action="{{ route('posts.likes', $post)}}" method="post" class="mr-1">
                    @csrf
                    <button type="submit" class="text-blue-500">Like</button>
                </form>
            @else
                <form action="{{ route('posts.likes', $post) }}" method="post" class="mr-1">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-blue-500">Unlike</button>
                </form>
            @endif

            @can('delete', $post)
                <form action="{{ route('post.delete', $post) }}" method="post" class="mr-1">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-blue-500">Delete</button>
                </form>
            @endcan

        @endauth
        <span>{{ $post->likes->count() }} {{ Str::plural('like', $post->likes->count()) }}</span>
    </div>
</div>
