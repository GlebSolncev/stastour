import {refs} from "../module.js";
import {route} from "../ajax.js";
import {appendHtml} from "../lib/dom.js";

class CatalogSection {
    constructor(container) {
        this.container = container;
        this.code = this.container.dataset['code'];
        this.page = 1;
        this.lock = false;

        this.events();
    }

    events() {

        this.scrollEvent = (e) => {
            const rect = this.container.getBoundingClientRect();
            const breakline = rect.top + rect.height - window.innerHeight
            if (window.scrollY >= breakline) {
                this.#fetchNextPage();
            }
        }

        window.addEventListener('scroll', this.scrollEvent)
    }

    #fetchNextPage() {
        if (this.lock) {
            return;
        }

        this.lock = true;

        route('catalog.page', {code: this.code, page: ++this.page})
            .then((response) => {
                if(response) {
                    const {grid} = refs(this.container);
                    appendHtml(grid, response)
                } else {
                    window.removeEventListener('scroll', this.scrollEvent)
                }
            })
            .finally(() => {
                this.lock = false;
            })
    }
}

export function register(element) {
    return new CatalogSection(element);
}

export const PATH = 'catalog-section';
