export function strtotime(formatted, format = 'DD.MM.YYYY HH:mm:ss') {
    return moment(formatted, format).unix()
}

export function gmdate(timestamp, format = 'DD.MM.YYYY HH:mm:ss') {
    return moment.unix(timestamp).format(format)
}

export class Datetime {

    #dt

    constructor(timestamp, useUtcOffset = true) {
        this.#dt = moment.unix(timestamp)

        if(useUtcOffset) {
            this.#dt.utcOffset(0);
        }
    }

    addYears(years = 1) {
        return this.#add(years, 'y');
    }

    addMonths(months = 1) {
        return this.#add(months, 'M');
    }

    addDays(days = 1) {
        return this.#add(days, 'd');
    }

    #add(count, mask) {
        return new Datetime(this.#dt.clone().add(count, mask).unix(), false)
    }

    format(format = 'DD.MM.YYYY HH:mm:ss') {
        return this.#dt.format(format);
    }

    timestamp() {
        return this.#dt.unix();
    }

    static parse(string, format = 'DD.MM.YYYY HH:mm:ss') {
        return new Datetime(strtotime(string, format), false)
    }

    static parseUTC(string, format = 'DD.MM.YYYY HH:mm:ss') {
        return new Datetime(moment(string, format).utc(true).unix(), false)
    }

    static now() {
        return new Datetime(moment().unix());
    }
}
