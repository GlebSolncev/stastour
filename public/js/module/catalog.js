import {refs} from "../module.js";
import {route} from "../ajax.js";
import {appendHtml} from "../lib/dom.js";

class Catalog {
    constructor(container) {
        this.container = container;
    }

    applyFilter(filters) {

        route('catalog.fetch', filters).then((response) => {

            const sections = this.container.querySelectorAll('[js-element="section"]');
            sections.forEach((section) => {
                section.remove();
            })

            appendHtml(this.container, response);

        })

    }
}

export function register (element) {
    return new Catalog(element);
}

export const PATH = 'catalog';
