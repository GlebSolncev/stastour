class Callback {
    #buffer = {};

    register (name) {
        return new Promise ((resolve) => {
            this.#buffer[name] = () => {
                delete this.#buffer[name];
                resolve();
            }
        });
    }

    trigger (name) {
        const callback = this.#buffer[name];
        if(callback) {
            callback();
        } else {
            console.warn(`Callback '${name}' triggered but not handled`);
        }
    }
}

export const callback = new Callback();
window.callback = callback;
