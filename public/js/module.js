export function refs(element) {
    let refs = [];
    element.querySelectorAll('[js-element]').forEach((ref) => {
        const module = ref.parentElement.closest('[js-module]');
        if (module !== element) {
            return;
        }

        const name = ref.getAttribute('js-element');
        if (refs[name]) {
            let head = refs[name];
            if (!Array.isArray(head)) {
                head = [head, ref];
            } else {
                head.push(ref);
            }

            refs[name] = head;
        } else {
            refs[name] = ref;
        }

    })

    return refs;
}

export function parent(element, name) {
    const path = name ? '[js-module=' + name + ']' : '[js-module]';
    return element.parentElement.closest(path)?.js_controller || null;
}

export function children(element) {
    let refs = [];
    element.querySelectorAll('[js-element]').forEach((ref) => {
        const name = ref.getAttribute('js-module');
        if (refs[name]) {
            let head = refs[name];
            if (!Array.isArray(head)) {
                head = [head, ref.js_controller];
            } else {
                head.push(ref.js_controller);
            }

            refs[name] = head;
        } else {
            refs[name] = ref.js_controller;
        }

    })

    return refs;
}

export async function getModules() {

    if(Object.keys(moduleRepo).length) {
        console.log("[from buffer]")
        return moduleRepo;
    }

    let promises = [];

    moduleNames.forEach((module) => {
        promises.push(new Promise((resolve, reject) => {
            import('./module/'+module+'.js').then((exports) => {
                moduleRepo[module] = exports.register;
                resolve();
            })
        }));
    })

    await Promise.all(promises);

    console.debug('Registered js modules:', moduleRepo);
    return moduleRepo;
}


let moduleNames = [
    'choose',
    'main-slider',
    'reviews',
    'aside',
    'parallax',
    'catalog',
    'catalog-filter',
    'catalog-section',
    'tour-gallery',
    'calendar',
    'select',
    'tour-map',
    'similar-tours',
    'tour-checkout',
    'checkout',
    'modal-autorun',
    'modals',
    'blog-list',
    'discuss',
    'discuss-form'
];

let moduleRepo = {};

