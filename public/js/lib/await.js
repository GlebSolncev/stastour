class Await {

    #waiters = {};
    #skip = [];

    constructor()
    {
        window.await.forEach((name) => {
            this.push(name);
        })
    }

    push(name) {
        console.log("[ready]", name)
        this.#skip.push(name);

        if(this.#waiters[name]) {
            this.#waiters[name]();
        }
    }

    async wait(name) {

        if(this.#skip.includes(name)) return;

        const waiter = new Promise((resolve) => {
            this.#waiters[name] = resolve;
        });

        await waiter;
    }
}

window.await = new Await();
