import {refs} from "../module.js";
import {route} from "../ajax.js";
import {modal} from "../lib/modal.js";

class Checkout {
    constructor(element) {
        this.element = element
        this.init();
    }

    init() {
        const references = refs(this.element);

        this.autoDetectFieldValues(references);
        this.initForm(references)
        this.formatPhone(references);
    }

    initForm(references) {

        const form_element = references['form'];
        const submit = references['submit'];

        submit.addEventListener('click', (e) => {
            if (!form_element.checkValidity()) {
                form_element.reportValidity();
                return;
            }

            route('checkout.confirm', new FormData(form_element)).then((response) => {
                if (response.done) {

                    route('payment.process', response.data.id).then((payment) => {
                        if (payment.url) {
                            window.location.href = payment.url;
                        } else {
                            modal.show('order-success', {id: response.data.id}, {
                                'done': () => {
                                    location.href = '/'
                                }
                            });
                        }
                    })
                }
            })

        })
    }

    async fetchJson(url) {
        const response = await fetch(url);
        return await response.json();
    }

    formatPhone(references) {
        const form_phone_country = references['form-phone-country'];
        const form_phone_tail = references['form-phone-tail'];
        const form_phone = references['form-phone'];

        Array.from([form_phone_country, form_phone_tail]).forEach((input) => {
            input.addEventListener('change', () => {
                form_phone.value = form_phone_country.value + form_phone_tail.value;
            })
        })
    }

    async autoDetectFieldValues(references) {
        const dials = await this.fetchJson('/asset/json/dial.json');
        const geoip = await this.fetchJson('https://get.geojs.io/v1/ip/geo.json');

        if (references['form-country']) {
            references['form-country'].value = geoip.country;
        }

        if (references['form-country']) {
            references['form-city'].value = geoip.city;
        }

        dials.forEach((dial) => {
            if (dial.code === geoip.country_code) {
                if (references['form-phone-country']) {
                    references['form-phone-country'].value = dial.dial_code;
                }
            }
        })
    }
}

export function register(element) {
    return new Checkout(element);
}
