import {refs} from "../module.js";

class TourGallery {
    constructor(element) {
        this.element = element
        this.start();
        this.events();
    }

    start() {
        this.swiper = new window.Swiper(this.element, {
            loop: true,
            direction: 'horizontal',
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev"
            },
            slidesPerView: 'auto',
            centeredSlides: true,
            slideToClickedSlide: true,
            spaceBetween: 5,
        });
    }

    events() {

        const ref = refs(this.element);

        ref?.next.addEventListener('click', (e) => {
            this.swiper.slideNext()
        })

        ref?.prev.addEventListener('click', (e) => {
            this.swiper.slidePrev()
        })

    }
}

export function register(element) {
    if (window.Swiper) {
        return new TourGallery(element);
    } else {
        console.warn('No Swiper vendor js library! ignored')
    }
}
