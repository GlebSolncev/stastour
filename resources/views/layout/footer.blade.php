<script>
    window.await = [];
    window.delay = {
        initGoogleMap: () => {window.await.push('google_map')}
    }
    window.csrf_token = '{{ csrf_token() }}';
</script>

<script type="module" src="/js/app.js"></script>
<script type="text/javascript" src="/js/vendor/swiper.js"></script>
<script type="text/javascript" src="/js/vendor/simpleParallax.min.js"></script>
<script type="text/javascript" src="/js/vendor/wow.min.js"></script>
<script type="text/javascript" src="/js/vendor/vanilla-calendar.min.js"></script>
<script type="text/javascript" src="/js/vendor/moment.js"></script>
<script type="text/javascript" src="/js/vendor/choices.min.js"></script>
<script async src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCBlrQXrqLLgNqovHO6Cj4oUgRjhRgoYU8&callback=window.delay.initGoogleMap"></script>
