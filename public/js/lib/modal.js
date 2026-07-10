import {Overlay} from "../module/overlay.js";
import {callback} from "./callback.js";
import {appendHtml} from "./dom.js";
import {route} from "../ajax.js";

export class Modal {
    static container = null;
    static handlers = {};

    static create(code, html) {
        if (Modal.container) {
            appendHtml(Modal.container, html);
            return new Modal(code);
        }
    }

    constructor(code) {
        this.code = code;
    }

    #createWaiters(handlers) {
        Object.keys(handlers).forEach((key) => {
            Modal.handlers[this.code+'.'+key] = handlers[key];
        })

        Modal.handlers[this.code+'.modal.close'] = () => {
            callback.trigger('modal.close');
        }
    }

    #removeWaiters(handlers) {
        delete Modal.handlers[this.code+'.modal.close'];
        Object.keys(handlers).forEach((key) => {
            delete Modal.handlers[this.code+'.'+key];
        })
    }

    show(handlers) {
        const element = document.querySelector('[data-modal="' + this.code + '"]');
        if (element) {

            this.#createWaiters(handlers);

            const overlay = new Overlay();
            overlay.start();
            element.classList.add('is-visible')

            overlay.bound(callback.register('modal.close')).then(() => {
                element.classList.remove('is-visible')
                element.remove();
                this.#removeWaiters(handlers);
            })
        }
    }
}

function _fetchModal(code, data) {
    return new Promise((resolve) => {
        route('modal.create', {code, data}).then((html) => {
            resolve(Modal.create(code, html))
        })
    })
}

function _showModal(code, data, handlers) {
    _fetchModal(code, data).then((modal) => {
        modal.show(handlers);
    })
}

export const modal = {
    create: _fetchModal,
    show: _showModal
};

window.modal = (name) => {
    if(Modal.handlers[name]) {
        Modal.handlers[name]();
    }
}
