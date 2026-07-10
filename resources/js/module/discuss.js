import {modal} from "../lib/modal.js";

class Discuss {
    constructor(element) {
        this.element = element;
        this.events();
    }

    events() {
        this.element.addEventListener('click', (e) => {
            e.preventDefault();
            modal.show('discuss', {}, {
                'send' : () => {
                    window?.discuss_form?.js_controller?.submit().then(() => {
                        callback.trigger('modal.close');

                        modal.show('discuss-success', {}, {});
                    })
                }
            });
        })
    }
}


export function register(element) {
    return new Discuss(element);
}
