<section class="main-blog">
    @if (isset($blog))
        <div class="main-blog__title">{{__('blog.title')}}</div>
        <div class="main-blog__image">
            <img src="{{$blog->image->src}}" js-module="parallax">
        </div>
        <div class="main-blog__content">
            <div class="main-blog__avatar">
                <img src="/asset/images/avatar.png">
            </div>

            <div class="main-blog__name">{{$blog->name}}</div>

            <div class="main-blog__description">{{$blog->preview}}</div>
            <div class="main-blog__footer">
                <div class="main-blog__actions">
                    <a class="button button--tiny button--secondary main-blog__full"
                       href="{{$blog->url}}"> {{__('blog.full')}}</a>
                    <a class="button button--tiny button--primary main-blog__items"
                       href="/blog/">{{__('blog.to-blog')}}</a>
                </div>
            </div>
        </div>
    @endif
</section>
