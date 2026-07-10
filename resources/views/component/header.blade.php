<header class="header">
    <div class="header__left">


        <div class="choose header_choose" js-module="choose" js-api="language.choose">
            <div class="choose__active" js-element="active">
                <div class="choose__item">
                    <img src="/asset/images/lang_eu.png">
                </div>
            </div>
            {{--
            <div class="choose__overlay" js-element="overlay">
                <div class="choose__item" js-element="item" js-api-data=" {{ json_encode(['code' => 'pt']) }}">
                    <img src="/asset/images/lang_pt.svg">
                </div>
                <div class="choose__item" js-element="item" js-api-data=" {{ json_encode(['code' => 'ru']) }}">
                    <img src="/asset/images/lang_ru.svg">
                </div>
                <div class="choose__item" js-element="item" js-api-data=" {{ json_encode(['code' => 'es']) }}">
                    <img src="/asset/images/lang_es.svg">
                </div>
            </div>
            --}}
        </div>

        <div class="nav-menu header_nav-menu">
            <a href="/#catalog" class="nav-menu__item">TRAVEL</a>
            <a href="/blog/" class="nav-menu__item">BLOG</a>
            {{-- <a href="/" class="nav-menu__item">SHOP</a> --}}
        </div>

    </div>
    <div class="header__center">
        <div class="logo header_logo">
            <a href="/">
                <img src="/asset/images/logo.png">
            </a>

        </div>
    </div>
    <div class="header__right">
        <div class="menu-open" js-module="aside" data-target-id="aside-menu"><img src="/asset/icon/menu.svg"></div>

        <div class="header__data">
            <a class="header__phone" href="tel:+351964002296">+351 964 002 296</a>
            <div class="header__socnet">
                <a class="header__whatsapp" href="https://wa.me/351964002296"></a>
                <a class="header__instagram" href="https://www.instagram.com/stas_tours"></a>
                <a class="header__facebook" href="https://www.facebook.com/share/98uznc9vB9tzXVKA/"></a>
            </div>
        </div>
    </div>
</header>
@if (isset($theme))
    <section class="header-curtain header-curtain--{{$theme}}"></section>
@endif
