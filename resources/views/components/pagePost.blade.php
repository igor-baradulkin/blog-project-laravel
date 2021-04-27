<div class="mb-4">
    <a href="{{ route('user.posts', $post->user) }}" class="font-blod">{{ $post->user->name }}</a> <span class="text-gray-600 text-sm">{{ $post->user->created_at->diffForHumans() }}</span>

    <p class="mb-4">{{ $post->body }}</p>

    @if($post->image)
        <p><img src="{{ asset('storage/image/posts/thumbnail/' . $post->image) }}"></p>
    @endif
</div>
