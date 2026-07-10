import {Modal} from "../lib/modal.js";

export function register(element) {
    Modal.container = element;
    return Modal;
}
