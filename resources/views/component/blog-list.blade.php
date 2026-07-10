<section class="blog" js-module="blog-list">

    <div class="blog__image">
        <picture>
            <source srcset="/asset/tiles/blog-md.png" media="(min-width: 1260px)">
            <source srcset="/asset/tiles/blog-sm.png" media="(min-width: 360px)">
            <img src="/asset/tiles/blog.png" js-module="parallax">
        </picture>
    </div>

    <div class="blog__main">
        <div class="blog__author">
            <div class="blog__avatar"></div>
            <div class="blog__title">Portuguese blog</div>
            <div class="blog__description">Adventures tour with initial nature beauty and cultural herritage</div>
        </div>

        <div class="blog__sep"></div>

        <a href="{{ $main->url }}" class="blog-item--main blog-item blog-item--big">
            <div class="blog-item__image">
                <img src=" {{ $main->image->src }}" js-module="parallax">
            </div>
            <div class="blog-item__title">{{ $main->name }}</div>
        </a>
    </div>

    <div class="blog__items" js-element="grid">
        @include('component.partial.blog-page')
    </div>
    @if ($show_tour)
        <div class="blog__tour">
            <p class="blog__discover">Let’s discover Portugal together </p>
            <a href="/#catalog" class="button button--fill button--primary">Find a tour</a>
        </div>
    @endif
</section>
