class MainSlider {
    constructor(element) {
        this.element = element;
        this.start();

        this.calculate_dots();
        this.events();
    }

    start() {
        this.swiper = new window.Swiper(this.element, {
            loop: true,
            direction: 'horizontal',
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
            autoplay: {
                delay: 5000,
                disableOnInteraction: false,
            },
        });
    }

    events() {
        this.swiper.on('slideChange', () => {
            this.calculate_dots();
        });
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
        return new MainSlider(element);
    } else {
        console.warn('No Swiper vendor js library! ignored')
    }
}

export const PATH = 'main-slider';
