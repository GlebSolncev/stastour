@foreach($items as $item)
    <a href=" {{ $item->url }}" class="blog-item {{$item->is_big ? 'blog-item--big' : ''}}">
        <div class="blog-item__image">
            @if (isset($item->image))
                <img src="{{ $item?->image?->src ?? ''}}" js-module="parallax">
            @endif
        </div>
        <div class="blog-item__title">{{ $item->name }}</div>
    </a>
@endforeach
