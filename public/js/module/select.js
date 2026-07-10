
class Select {
    constructor(element) {
        this.element = element
        this.start();
    }

    start() {
        this.choices = new Choices(this.element, {
            searchEnabled: false,
            searchChoices: false,
        });
    }

    update(values) {
        this.choices.setChoices(values, 'value', 'label', true);
        console.log(values)
    }

    getValue() {
        return this.element.value;
    }
}

export function register(element) {
    if (window.Choices) {
        return new Select(element);
    } else {
        console.warn('No VanillaCalendar vendor js library! ignored')
    }
}
