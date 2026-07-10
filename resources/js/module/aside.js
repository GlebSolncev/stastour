import {Overlay} from "./overlay.js";
import {callback} from '../lib/callback.js';

export class Aside {
    constructor (element) {

        element.addEventListener('click', (e) => {
            e.preventDefault();

            const target_id = element.dataset['targetId'];
            const target = document.getElementById(target_id);
            const overlay = new Overlay();

            if(target) {
                overlay.start();
                target.classList.add('visible')

                overlay.bound(callback.register('aside.close')).then(() => {
                    target.classList.remove('visible')
                })

            }
        })
    }
}

export function register (element) {
    return new Aside(element);
}

export const PATH = 'aside';
