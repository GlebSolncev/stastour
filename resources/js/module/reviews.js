import {refs} from "../module.js";

class Reviews {
    constructor(element) {
        this.element = element;
        this.start();

        //this.calculate_dots();
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
            slidesPerView: 1,
            slidesPerGroup: 1,

            breakpoints: {
                1200: {
                    slidesPerView: 2,
                    slidesPerGroup: 2,
                    spaceBetween: 60
                }
            }
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

    calculate_dots() {
        const dots = this.element.querySelector('.swiper-pagination');

        const activeSlideIndex = this.swiper.activeIndex;
        const activeSlide = Array.from(this.element.querySelectorAll('.swiper-slide'))[activeSlideIndex];

        const slideHeight = activeSlide.querySelector('.main-slider__background').clientHeight;

        dots.style.top = slideHeight + 'px';
    }
}

export function register(element) {
    if (window.Swiper) {
        return new Reviews(element);
    } else {
        console.warn('No Swiper vendor js library! ignored')
    }
}

export const PATH = 'reviews';
