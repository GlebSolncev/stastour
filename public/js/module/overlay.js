export class Overlay {

    constructor(element = null) {
        this.element = element || document.querySelector('.static');
    }


    start () {
        document.body.classList.add('non-scroll');
        this.element.classList.add('overlay');
    }

    stop () {
        this.element.classList.remove('overlay');
        document.body.classList.remove('non-scroll');
    }

    bound (promise) {
        this.start();
        promise.finally(() => {this.stop();})
        return promise;
    }

}
