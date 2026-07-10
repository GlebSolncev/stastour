import {refs, parent} from "../module.js";

class CatalogFilter {
    constructor(container) {
        const references = refs(container);
        this.container = container;
        this.filter = references.button || [];

        this.events();
    }

    events() {
        Array.from(this.filter).forEach((button) => {
            button.addEventListener('click', (e) => {
                e.preventDefault();
                if(button.classList.contains('button--active')) {
                    button.classList.remove('button--active')
                } else {
                    button.classList.add('button--active')
                }

                this.#update();
            })

        })
    }

    #update() {
        let filters = Array.from(this.filter).filter((button) => {
            return button.classList.contains('button--active')
        }).map((button) => {
            return button.dataset['code'];
        })

        if(!filters.length) {
            filters = Array.from(this.filter).map((button) => {
                return button.dataset['code'];
            })
        }

        const catalog = parent(this.container);
        catalog?.applyFilter(filters);
    }
}

export function register (element) {
    return new CatalogFilter(element);
}

export const PATH = 'catalog-filter';
