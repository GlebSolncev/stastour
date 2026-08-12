<div class="tour__calendar--wrapper" js-module="tour-checkout" data-id="{{$tour->bokun_id}}">

    <div class="tour__calendar">
        <div class="tour-booking-tickets">
            @foreach($tour->pricingCategory as $id => $item)
                <div class="ticket-counter-item" js-element="counter-wrapper">
                    <label class="ticket-counter-label">{{ $item['title'] }}</label>

                    <div class="ticket-counter-controls">
                        <button type="button" class="counter-btn btn-minus" js-element="counter-minus" disabled>—</button>
                        <input type="number"
                               data-id="{{ $item['id'] }}"
                               name="tickets[{{$item['title']}}]"
                               class="counter-input"
                               value="{{ $item['title'] === 'Adult' ? 1 : 0 }}"
                               min="0"
                               max="99"
                               readonly
                               js-element="counter-input">
                        <button type="button" class="counter-btn btn-plus" js-element="counter-plus">+</button>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="calendar-container"
             js-module="calendar"
             js-element="calendar"
             data-id='{{ $tour->bokun_id }}'
             data-pricing="{{ json_encode([Arr::get(collect($tour->pricingCategory)->where('title', 'Adult')->first(), 'id') => 1]) }}"
             data-calendar='{}'
             data-min="{{ now()->format('Y-m-d') }}">
        </div>

        <div class="tour__time-slots-container"></div>

        <div class="tour__total">
            <p class="tour__total--price">TOTAL PRICE: <span class="total-price">-</span></p>
            <p class="tour__total--hint">Price depends from the number of people</p>
            <p class="tour__total--discuss">Need a special tour? <a href="#" js-module="discuss">Let’s discuss!</a></p>
            <button class="button button--fill tour__total--buy" js-element="book"  style="display:none">Book now</button>
        </div>
        <p class="error-booking" style="color:red;font-weight: 800;display: none"></p>

    </div>
</div>



<script>
    document.addEventListener('DOMContentLoaded', () => {
        const wrapper = document.querySelector('.tour__calendar--wrapper')
        const counterWrappers = document.querySelectorAll('[js-element="counter-wrapper"]');
        const calendarContainer = document.querySelector('.calendar-container');
        const timeSlots = document.querySelector('.tour__time-slots-container');
        const calendarEl = document.querySelector('[js-module="calendar"]');
        const totalPriceEl = document.querySelector('.total-price');
        const tourTotalEl = document.querySelector('.tour__total');
        const buttonBookNow = document.querySelector('.tour__total--buy');
        const errorBooking = document.querySelector('.error-booking');

        let listPricing = {};
        let calendar = null;
        let selectedDate = null;
        let debounceTimeout = null;
        let currentSlot = null;
        let timeTarget = null;

        if (timeSlots) {
            timeSlots.addEventListener('change', (event) => {
                timeTarget = event.target
                currentSlot = JSON.parse(timeTarget.dataset.info);
                timeTarget.selected = true;
                changeInputData();
            });
        }

        const changeInputData = () => {
            if(!currentSlot) {
                totalPriceEl.innerText = '';
                buttonBookNow.dataset.sessionId = '0';
                buttonBookNow.style.display = 'none';
                tourTotalEl.style.display = 'none';

                return;
            }

            // 4. Получаем CSRF токен для защиты Laravel
            const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
            const tourId = wrapper.dataset.id;
            const requestPayload = {
                tour_id: tourId,
                date: selectedDate,
                start_time_id: currentSlot.startTimeId,
                pricing: listPricing
            };


            fetch('/api/cart', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify(requestPayload)
            })
                .then(response => {
                    if (!response.ok) {
                        return response.json().then(errData => {
                            throw new Error(errData.message || 'Ошибка сервера при добавлении в корзину');
                        });
                    }

                    return response.json();
                })
                .then(data => {
                    totalPriceEl.innerText = data.totalDueAsText
                    buttonBookNow.dataset.sessionId = data.sessionId;

                    buttonBookNow.style.display = 'block'
                    tourTotalEl.style.display = 'block'
                    errorBooking.style.display = 'none'
                }).catch(error => {
                    console.error('Ошибка API:', error);
                    timeTarget.disabled = true;
                    timeTarget.selected = false;
                    timeTarget.changed = false;

                    errorBooking.style.display = 'block'
                    errorBooking.innerText = `This time doesn't available. Please change another time`;
                    buttonBookNow.style.display = 'none'
                    tourTotalEl.style.display = 'none'
                })


            calculateTotal();
        }

        const calculateTotal = () => {
            let total = 0;
            const obj = Object.keys(listPricing)

            if(obj.length > 0 && currentSlot) {
                for (const item of currentSlot.pricesByRate) {
                    obj.forEach(inx => {
                        if (parseInt(item.id) === parseInt(inx)) {
                            const quantity = listPricing[inx];
                            total += item.amount.amount * quantity
                        }
                    })
                }
            }

            document.querySelector('.total-price').innerText = total;
        }

        // 1. Слушатель кастомного события смены даты
        if (calendarEl) {
            calendarEl.addEventListener('calendar:change', (event) => {
                const { date, timestamp, info } = event.detail;
                selectedDate = date

                getTimeSlots()
            });
        }

        const getTimeSlots = () => {

            timeSlots.style.opacity = '0.5'

            setTimeout(() => {
                const timestampMs = new Date(`${selectedDate}T00:00:00Z`).getTime();
                const calendarDate = JSON.parse(calendarContainer.dataset.calendar);
                console.log('>>>> ', calendarDate)
                const dateSelected = calendarDate[timestampMs];
                timeSlots.innerHTML = '';

                if (dateSelected) {
                    dateSelected.forEach((item, index) => {
                        const wrapper = document.createElement('div');
                        wrapper.className = 'time-slot-item';

                        const radio = document.createElement('input');
                        radio.dataset.info = JSON.stringify(item)
                        radio.type = 'radio';
                        radio.id = item.startTimeId;
                        radio.name = 'start_time';
                        radio.value = item.startTime;

                        const label = document.createElement('label');
                        label.htmlFor = item.startTimeId;
                        label.innerText = item.startTime;

                        wrapper.appendChild(radio);
                        wrapper.appendChild(label);
                        timeSlots.appendChild(wrapper);

                        currentSlot = null
                        changeInputData();
                        timeSlots.style.opacity = 1
                    });
                }
            }, 1000)
        }

        // Функция обновления календаря с дебаунсом (задержкой)
        const debounceRefreshCalendar = () => {
            // Очищаем предыдущий таймер, если пользователь нажал кнопку снова до истечения 500мс
            clearTimeout(debounceTimeout);

            // Устанавливаем новый таймер
            debounceTimeout = setTimeout(() => {
                const currentCalendarEl = document.querySelector('[js-module="calendar"]');
                if (currentCalendarEl && currentCalendarEl.js_controller) {
                    calendar = currentCalendarEl.js_controller;
                    calendar.refreshCalendarData();
                    getTimeSlots()
                }
            }, 500); // Задержка в 500 миллисекунд (можете настроить под себя)
        };

        // 2. Логика счетчиков билетов
        counterWrappers.forEach(wrapper => {
            const input = wrapper.querySelector('[js-element="counter-input"]');
            const btnMinus = wrapper.querySelector('[js-element="counter-minus"]');
            const btnPlus = wrapper.querySelector('[js-element="counter-plus"]');
            listPricing = JSON.parse(calendarContainer.dataset.pricing)

            const MIN_VALUE = 0;
            const MAX_VALUE = 99;

            const updateButtonState = (value) => {
                btnMinus.disabled = value <= MIN_VALUE;
                btnPlus.disabled = value >= MAX_VALUE;
            };

            const updateDatasetPricing = (inputEl) => {
                const inputId = inputEl.dataset.id;
                const inputValue = parseInt(inputEl.value, 10) || 0;

                if (inputValue > 0) {
                    listPricing[inputId] = inputValue;
                } else {
                    delete listPricing[inputId];
                }

                calendarContainer.dataset.pricing = JSON.stringify(listPricing);
                changeInputData();
            };

            // Обработчик клика на ПЛЮС
            btnPlus.addEventListener('click', () => {
                let currentValue = parseInt(input.value, 10) || 0;
                if (currentValue < MAX_VALUE) {
                    currentValue++;
                    input.value = currentValue;
                    updateButtonState(currentValue);
                    updateDatasetPricing(input);

                    // Триггерим отложенное обновление календаря
                    debounceRefreshCalendar();
                    // calculateTotal();

                    input.dispatchEvent(new Event('change', { bubbles: true }));
                }
            });

            // Обработчик клика на МИНУС
            btnMinus.addEventListener('click', () => {
                let currentValue = parseInt(input.value, 10) || 0;
                if (currentValue > MIN_VALUE) {
                    currentValue--;
                    input.value = currentValue;
                    updateButtonState(currentValue);
                    updateDatasetPricing(input);

                    // Триггерим отложенное обновление календаря
                    debounceRefreshCalendar();
                    // calculateTotal();

                    input.dispatchEvent(new Event('change', { bubbles: true }));
                }
            });
        });
    });
</script>