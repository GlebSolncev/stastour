import {route} from "../ajax.js";
import {refs} from "../module.js";
import {appendHtml} from "../lib/dom.js";

class BlogList {
    constructor(container) {
        this.container = container;
        this.page = 1;
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

        route('blog.page', {page: ++this.page})
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
    return new BlogList(element);
}
