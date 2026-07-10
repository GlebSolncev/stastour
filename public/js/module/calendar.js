import {String} from "../lib/string.js";
import {gmdate, strtotime, Datetime} from "../lib/datetime.js";

class Calendar {
    constructor(element) {
        this.element = element
        this.start();
    }

    getDisabledMonthDays() {

        const days = Object.keys(this.month);
        const daysLocated = days.map((day) => {
            return Datetime.parse(new Datetime(day).format()).timestamp()
        })
        let result = [];

        let firstDayInMonth = Datetime.parse(new Datetime(days[0]).format('YYYY-MM') + '-01', 'YYYY-MM-DD');
        let iterate = firstDayInMonth;
        let month = firstDayInMonth.format('MM');

        while (iterate.format('MM') === month) {
            if (!daysLocated.includes(iterate.timestamp())) {
                result.push(iterate.format('YYYY-MM-DD'));
            }
            iterate = iterate.addDays();
        }

        return result;
    }

    start() {
        this.month = JSON.parse(this.element.dataset.calendar);
        const min = new Datetime(this.element.dataset.min);

        this.calendar = new VanillaCalendar(this.element, {
            type: 'default',
            date: {
                min: min.format('YYYY-MM-DD'),
                max: min.addMonths(6).format('YYYY-MM-DD')
            },
            settings: {
                selection: {
                    cancelableDay: false,
                },
                selected: {
                    dates: [min.format('YYYY-MM-DD')]
                },
                visibility: {
                    weekNumbers: true,
                },
                range: {
                    disabled: this.getDisabledMonthDays()
                },
                lang: 'define',
            },
            locale: {
                months: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
                weekday: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'],
            },
            actions: {
                clickMonth: () => {
                    this.changeMonth()
                },
                clickArrow: () => {
                    this.changeMonth()
                },
                clickDay: () => {
                    this.changeDay()
                }
            },
        });
        this.calendar.init();
    }

    changeDay() {
        const day = this.getSelectedDate();
        const dayTimestamp = Datetime.parseUTC(day, 'YYYY-MM-DD').timestamp();
        this.element.dispatchEvent(new CustomEvent('changeDay', {detail: {timeslots: this.month[dayTimestamp]}}));
    }

    changeMonth() {
        this.element.dispatchEvent(new CustomEvent('changeMonth', {detail: {month: this.calendar.selectedMonth+1}}));
    }

    update(month, selected = false) {
        this.month = month;
        this.calendar.settings.range.disabled = this.getDisabledMonthDays();

        if(selected) {
            this.calendar.settings.selected.dates = selected;
        }

        this.calendar.update({dates: true});
    }

    reset(month) {
        this.update(month, [new Datetime(Object.keys(month)[0]).format('YYYY-MM-DD')]);
        this.changeDay();
    }

    getSelectedDate() {
        return this.calendar.selectedDates[0];
    }

    getSelectedDateInfo() {
        const day = this.getSelectedDate();
        const dayTimestamp = Datetime.parseUTC(day, 'YYYY-MM-DD').timestamp();
        return this.month[dayTimestamp];
    }
}

export function register(element) {
    if (window.VanillaCalendar) {
        return new Calendar(element);
    } else {
        console.warn('No VanillaCalendar vendor js library! ignored')
    }
}
