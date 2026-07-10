import {getModules} from './module.js';

export async function start(container) {
    const modules = await getModules();

    Object.keys(modules).forEach((path) => {

        const register = modules[path];
        container.querySelectorAll('[js-module='+path+']').forEach((element) => {

            if(element.js_controller) {
                console.debug('[bootstrap] Skipped, cause', element, 'already loaded as: ', element.js_controller)
                return;
            }

            if(!element.js_controller) {
                if(register) {
                    try {
                        element.js_controller = register(element) || true;
                    } catch (e) {
                        console.error('Error in module', path, e);
                    }
                } else {
                    console.warn('[bootstrap] Module `'+path+'` not found! ignored');
                }
            }

        })
    })
}
