import {refs} from '../module.js';
import {extract} from '../ajax.js';
import {Overlay} from "./overlay.js";

export class Choose {
    constructor (element) {
        const {active, overlay, item} = refs(element);

        this.element = element;
        this.active = active;
        this.overlay = overlay;
        this.items = item;

        this.events();
    }

    choose(item) {
        const overlay = new Overlay();
        overlay.bound(extract(item));
    }

    expand() {
        this.element.classList.add('choose--expanded');
    }

    collapse() {
        this.element.classList.remove('choose--expanded');
    }

    events() {
        this.active.addEventListener('click', (e) => {
            e.preventDefault();
            if(this.element.classList.contains('choose--expanded')) {
                this.collapse()
            } else {
                this.expand()
            }
        });

        this.items.forEach((item) => {
            item.addEventListener('click', (e) => {
                e.preventDefault();
                this.choose(item);
                this.collapse();
            })
        })
    }
}

export function register (element) {
    return new Choose(element);
}

export const PATH = 'choose';
