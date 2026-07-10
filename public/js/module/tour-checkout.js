import {refs} from "../module.js";
import {route} from "../ajax.js";
import {Datetime} from "../lib/datetime.js";
import {Overlay} from "./overlay.js";

class TourCheckout {
    constructor(element) {
        this.element = element;

        this.init();
        this.events();

    }

    init() {
        const references = refs(this.element);

        this.tour_price = this.element.dataset.price;
        this.tour_id = this.element.dataset.id;

        this.available_count_element = references.available_count;
        this.available_total_element = references.available_total;

        this.current_tour = references.current_tour;
        this.book_button = references.book;
        this.total_price_element = references.price;

        this.tour_adults = references.tour_adults;
        this.tour_kids = references.tour_kids;
        this.tour_kid_info = references.kid_info;

        this.calendar = references.calendar;
        this.timeslots = references['timeslots'];

        this.overlay = new Overlay(this.element);

    }

    events() {

        this.current_tour.js_controller.element.addEventListener('change', (e) => {
            this.changeCurrentTour(e.detail.value);
        });

        Array.from([this.tour_adults, this.tour_kids]).forEach((input) => {
            input.addEventListener('change', () => {

                this.book_button.setCustomValidity('');
                this.book_button.reportValidity();

                this.reCalcTourPrice();
            })
        })

        this.book_button.addEventListener('click', () => {
            this.book();
        })

        this.calendar.addEventListener('changeMonth', (e) => {
            this.fetchCalendarMonth(e.detail.month)
        })

        this.calendar.addEventListener('changeDay', (e) => {
            let timeslots = e.detail.timeslots;
            let selectedTimeslot = null;

            if(timeslots) {

                const sortable = Object.entries(timeslots).sort(([,a],[,b]) => a.sort-b.sort)
                sortable[0][1].selected = true;

                let values = [];

                sortable.forEach(([timeslotId, timeslot]) => {
                    let value = {
                        value: timeslotId,
                        label: timeslot.title
                    };

                    if(timeslot.selected) {
                        value.selected = true
                        selectedTimeslot = timeslot;
                    }

                    values.push(value);
                })


                this.timeslots.js_controller.update(values)
                this.onChangeTimeslot();
            }
        })

        this.timeslots.addEventListener('change', () => {
            this.onChangeTimeslot();
        })
    }

    onChangeTimeslot() {
        const timeslots = this.calendar.js_controller.getSelectedDateInfo();
        const id = this.timeslots.js_controller.getValue();

        if(this.available_count_element) {
            this.available_count_element.value = this.available_total_element.value - timeslots[id].booked;
        }

    }

    fetchCalendarMonth(month, reset = false) {
        this.overlay.start();
        route('calendar.month.fetch', {tour: this.tour_id, month: month}).then((json) => {

            if(reset) {
                this.calendar.js_controller.reset(json);
            } else {
                this.calendar.js_controller.update(json);
            }

            this.overlay.stop();

        })
    }

    getAdultQuantity() {
        return parseInt(this.tour_adults.value);
    }

    getKidsQuantity() {
        return parseInt(this.tour_kids.value);
    }

    reCalcTourPrice() {
        this.total_price_element.innerText = this.tour_price * (this.getAdultQuantity() + this.getKidsQuantity());
    }

    changeCurrentTour(tour_id) {
        route('catalog.checkout', tour_id).then((response) => {
            if(response.done) {
                this.apply(response.data)
            }
        })
    }

    apply(data) {
        this.tour_price = data.price;
        this.tour_id = data.id;

        this.reCalcTourPrice();
        this.fetchCalendarMonth(Datetime.now().format('MM'), true)
    }

    collectData() {
        return {
            id: this.tour_id,
            qty: {
                adults: this.getAdultQuantity(),
                kids: this.getKidsQuantity()
            },
            info: {
                kids_info: this.tour_kid_info.value
            },
            timeslot: {
                id: this.timeslots.js_controller.getValue(),
                date: this.calendar.js_controller.getSelectedDate()
            }
        }
    }

    book() {

        const data = this.collectData();

        if(this.available_total_element) {
            const available = this.available_count_element.value;
            const quantity = data.qty.adults + data.qty.kids;

            if(quantity > available) {
                this.book_button.setCustomValidity('Available for selected date: ' + available);
                this.book_button.reportValidity();

                return;
            }
        }

        this.overlay.start();
        route('basket.add.tour', this.collectData()).then((response) => {
            if(response.done) {
                window.location.href = '/checkout/';
            } else {
                this.overlay.stop();
            }
        })
    }
}

export function register(element) {
    return new TourCheckout(element);
}
