<section class="blog-detail">
    <h1 class="blog-detail__title">{{$item->name}}</h1>
    {{-- <p class="blog-detail__description">{{$item->preview}}</p> --}}
    <div class="blog-detail__article">
        {!! $item->detail !!}
    </div>
</section>

<section class="blog-similar">
    <p class="blog-similar__title">
        more from the blog
    </p>

    <div class="blog__items blog-similar__items">

        @foreach($items as $item)
            <a href=" {{ $item->url }}" class="blog-item">
                <div class="blog-item__image">
                    @if (isset($item->image))
                        <img src="{{ $item?->image?->src ?? ''}}" js-module="parallax">
                    @endif
                </div>
                <div class="blog-item__title">{{ $item->name }}</div>
            </a>
        @endforeach

    </div>
    @if ($show_tour)
        <div class="blog__tour">
            <p class="blog__discover">Let’s discover Portugal together </p>
            <a href="/#catalog" class="button button--fill button--primary">Find a tour</a>
        </div>
    @endif
</section>

