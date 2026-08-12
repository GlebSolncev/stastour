import {String} from "../lib/string.js";
import {gmdate, strtotime, Datetime} from "../lib/datetime.js";

class Calendar {
    calendarData = []
    tourId = 0

    constructor(element) {
        this.element = element
        this.tourId = this.element.dataset.id
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

    async start() {
        const now = new Date();
        // const year = now.getFullYear();
        const month = now.getMonth() + 1;//.padStart(2, '0');

        this.refreshCalendarData(month)
        // const response = await fetch('/api/show-calendar/' + this.element.dataset.id + '/' + month);
        // this.calendarData = await response.json()


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
                clickDay: (event, self) => {
                    if (self.selectedDates.length > 0) {
                        const selectedDate = self.selectedDates[0];

                        // Получаем данные для этого дня из сохраненных данных (this.month или из data-calendar)
                        // Нам нужно перевести YYYY-MM-DD в таймстамп миллисекунд, как у вас в структуре
                        const dayTimestamp = Datetime.parseUTC(selectedDate, 'YYYY-MM-DD').timestamp() * 1000;
                        const dayData = self.month && self.month[dayTimestamp];

                        // Создаем кастомное событие и передаем туда все данные дня
                        const changeEvent = new CustomEvent('calendar:change', {
                            detail: {
                                date: selectedDate,
                                timestamp: dayTimestamp,
                                info: dayData // Тут будет ваша цена, слоты и т.д.
                            },
                            bubbles: true // Позволяет событию подниматься выше по DOM
                        });

                        // Генерируем событие на корневом элементе календаря
                        self.HTMLElement.dispatchEvent(changeEvent);
                    }

                    this.changeDay()
                },

                // ✅ ИСПРАВЛЕННЫЙ ХУК ОТРЕСОВКИ ЦЕНЫ
                getDays: (day, date, HTMLElement) => {
                    // Переводим дату дня (YYYY-MM-DD) в UTC Timestamp (в секундах)
                    const dayTimestamp = Datetime.parseUTC(date, 'YYYY-MM-DD').timestamp();
                    const dayData = this.month[dayTimestamp];



                    const data = this.calendarData[dayTimestamp*1000]
                    // const pricing = this.element.dataset.pricing;
                    const pricing = this.element.dataset.pricing ? JSON.parse(this.element.dataset.pricing) : {};

                    let totalPrice = 0;
                    const selected = Object.keys(pricing)

                    if (data && data.length > 0) {
                        for(const item of data[0].pricesByRate) {
                            let itemTotal = 0;

                            if(!selected.length) {
                                totalPrice = item.amount.amount;
                                break;
                            }

                            selected.forEach(rateId => {
                                if(item.id === parseInt(rateId)) {
                                    itemTotal += item.amount.amount * (pricing[rateId] || 1)
                                }
                            })

                            totalPrice += itemTotal
                        }

                        const minPrice = parseFloat(totalPrice);

                        // Находим внутреннюю кнопку дня
                        const btn = HTMLElement.querySelector('.vanilla-calendar-day__btn');

                        if (btn) {
                            btn.removeAttribute('disabled');
                            btn.classList.remove('vanilla-calendar-day__btn_disabled');

                            // Удаляем старый спан с ценой, если он был (чтобы избежать дублирования при перерисовке)
                            const oldPrice = btn.querySelector('.calendar-day-price');
                            if (oldPrice) oldPrice.remove();

                            // let priceElement = btn.querySelector('.calendar-day-price');
                            // if (!priceElement) {
                            // priceElement = document.createElement('span');
                            // priceElement.className = 'calendar-day-price';
                            // btn.appendChild(priceElement);
                            // }
                            // Выводим цену
                            // priceElement.textContent = `${minPrice}€`;
                        } else {
                            // Если цены нет — жестко деактивируем кнопку дня
                            btn.setAttribute('disabled', 'disabled');
                            btn.classList.add('vanilla-calendar-day__btn_disabled');

                            // На всякий случай очищаем блок от старых цен
                            const oldPrice = btn.querySelector('.calendar-day-price');
                            if (oldPrice) oldPrice.remove();

                        }
                    }




                    // Проверяем, что для этого дня есть данные и в них задана цена
                    // if (dayData && dayData.price !== undefined) {
                    //     const minPrice = parseFloat(dayData.price);
                    //
                    //     if (!isNaN(minPrice)) {
                    //         // Находим внутреннюю кнопку дня
                    //         const btn = HTMLElement.querySelector('.vanilla-calendar-day__btn');
                    //
                    //         if (btn) {
                    //             // Создаем или обновляем элемент цены
                    //             let priceElement = btn.querySelector('.calendar-day-price');
                    //             if (!priceElement) {
                    //                 priceElement = document.createElement('span');
                    //                 priceElement.className = 'calendar-day-price';
                    //                 btn.appendChild(priceElement);
                    //             }
                    //             // Выводим цену
                    //             priceElement.textContent = `${minPrice}€`;
                    //         }
                    //     }
                    // }
                }
            },
        });
        this.calendar.init();
    }

    refreshCalendarData(month = null) {
        const calendarEl = this.element;
        if (!calendarEl) return;

        if(!month) {
            const now = new Date();
            month = now.getMonth() + 1
        }

        calendarEl.style.opacity = '0.5'; // Визуальный индикатор загрузки

        fetch(`/api/show-calendar/${this.tourId}/${month}`)
            .then(response => response.json())
            .then(newData => {
                calendarEl.setAttribute('data-calendar', JSON.stringify(newData));

                this.month = newData;
                if (this.calendarData) {
                    this.calendarData = newData;
                }

                if (this.calendar && typeof this.calendar.update === 'function') {
                    this.calendar.update();
                } else if (this.calendar) {
                    this.calendar.init();
                }

                calendarEl.style.opacity = '1';
            })
            .catch(error => {
                console.error('Ошибка при обновлении цен календаря:', error);
                calendarEl.style.opacity = '1';
            });
    }

    changeDay() {
        const day = this.getSelectedDate();
        const dayTimestamp = Datetime.parseUTC(day, 'YYYY-MM-DD').timestamp();
        this.element.dispatchEvent(new CustomEvent('changeDay', {detail: {timeslots: this.month[dayTimestamp]}}));
    }

    changeMonth() {
        const month = this.calendar.selectedMonth+1
        refreshCalendarData(month)
        this.element.dispatchEvent(new CustomEvent('changeMonth', {detail: {month}}));
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
