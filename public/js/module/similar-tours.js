import {refs} from "../module.js";

class SimilarTours{
    constructor(element) {
        this.element = element;
        this.init()
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
                    disable: true
                }
            }
        });
    }

    destroy() {
        this.swiper.destroy();
    }

    #getMatchMedia() {
        return window.matchMedia('(max-width: 1200px)');
    }

    init() {
        if(this.#getMatchMedia().matches) {
            this.start();
        }
    }

    events() {
        this.#getMatchMedia()
            .addEventListener('change', (event) => {
                if (event.matches) {
                    this.start();
                } else {
                    this.destroy();
                }
            })

        const ref = refs(this.element);

        ref?.next.addEventListener('click', (e) => {
            this.swiper.slideNext()
        })

        ref?.prev.addEventListener('click', (e) => {
            this.swiper.slidePrev()
        })

        let next_row = 1;
        const max_row = Math.max(...ref?.item?.map((item) => {return parseInt(item.dataset.row)}) || 0);

        ref?.more?.addEventListener('click', (e) => {
            e.preventDefault();

            console.log("[more]", next_row, max_row)

            if(next_row <= max_row) {
                ref?.item
                    ?.filter((item) => {return parseInt(item.dataset.row) === next_row})
                    .forEach((item) => {item.classList.add('is-visible')})

                next_row++;
            }

            if(next_row > max_row) {
                ref.more.remove();
            }
        })
    }
}

export function register(element) {
    return new SimilarTours(element)
}
