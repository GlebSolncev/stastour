

export class ModalAutorun
{
    constructor(element)
    {
        this.element = element;
        this.show();
    }

    show() {

    }
}

export function register(element) {
    new ModalAutorun(element);
}
