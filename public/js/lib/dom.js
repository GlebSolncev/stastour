import {start} from '../bootstrap.js';

export function replaceHtml(parent, html) {
    parent.innerHTML = html;
    start(parent);
}

export function appendHtml(parent, html) {
    const tpl = document.createElement('template');
    tpl.innerHTML = html;

    parent.append(tpl.content);
    start(parent);
}
