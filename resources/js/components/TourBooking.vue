<template>
  <div class="tour__calendar--wrapper">
    <div class="tour__calendar">

      <div class="tour-booking-tickets">
        <div
            v-for="item in ticketCategories"
            :key="item.id"
            class="ticket-counter-item"
        >
          <label class="ticket-counter-label">{{ item.title }}</label>

          <div class="ticket-counter-controls">
            <button
                type="button"
                class="counter-btn btn-minus"
                :disabled="getTicketCount(item.id) <= 0"
                @click="decrementTicket(item.id)"
            >
              —
            </button>
            <input
                type="number"
                class="counter-input"
                :value="getTicketCount(item.id)"
                readonly
            >
            <button
                type="button"
                class="counter-btn btn-plus"
                :disabled="getTicketCount(item.id) >= 99"
                @click="incrementTicket(item.id)"
            >
              +
            </button>
          </div>
        </div>
      </div>

      <div
          ref="calendarContainer"
          class="calendar-container"
      ></div>

      <div class="tour__time-slots-container" :style="{ opacity: slotsOpacity }">
        <div
            v-for="slot in activeDateSlots"
            :key="slot.startTimeId"
            class="time-slot-item"
        >
          <input
              type="radio"
              :id="slot.startTimeId"
              name="start_time"
              :value="slot"
              v-model="currentSlot"
          />
          <label :for="slot.startTimeId">{{ slot.startTime }}</label>
        </div>
      </div>

      <div class="tour__total" v-show="showTotalSection">
        <p class="tour__total--price">
          TOTAL PRICE: <span class="total-price">{{ computedTotalPrice }}</span>
        </p>
        <p class="tour__total--hint">Price depends from the number of people</p>
        <p class="tour__total--discuss">
          Need a special tour? <a href="#" @click.prevent="openDiscuss">Let’s discuss!</a>
        </p>
        <button
            v-show="showBookButton"
            class="button button--fill tour__total--buy"
            :disabled="isSubmitting"
            @click="bookNow"
        >
          <span v-if="isSubmitting">Booking...</span>
          <span v-else>Book now</span>
        </button>
      </div>

      <p
          class="error-booking"
          style="color:red; font-weight: 800;"
          v-show="errorMessage"
      >
        {{ errorMessage }}
      </p>

    </div>
  </div>
</template>

<script setup>
import { ref, reactive, computed, onMounted, onUnmounted, watch } from 'vue';

// Определяем входные параметры из Blade-шаблона
const props = defineProps({
  tourId: {
    type: [String, Number],
    required: true
  },
  // Список категорий билетов из Laravel: $tour->pricingCategory
  initialCategories: {
    type: Array,
    required: true
  },
  // Минимальная дата (обычно текущий день)
  minDate: {
    type: String,
    default: () => new Date().toISOString().split('T')[0]
  }
});

// Реактивное состояние
const ticketCategories = ref(props.initialCategories);
const calendarContainer = ref(null);

// Инициализируем listPricing, выставляя Adult в 1 по умолчанию, как в исходном коде
const listPricing = reactive({});
const initPricing = () => {
  ticketCategories.value.forEach(item => {
    if (item.title === 'Adult') {
      listPricing[item.id] = 1;
    }
  });
};
initPricing();

// Получение количества выбранных билетов
const getTicketCount = (id) => listPricing[id] || 0;

// Календарь
let calendarInstance = null;
const calendarData = ref({}); // Сюда подгружаются цены и слоты
const selectedDate = ref(null);
const currentSlot = ref(null);
const slotsOpacity = ref(1);

// Данные корзины от API
const totalDueAsText = ref('');
const sessionId = ref('0');
const showBookButton = ref(false);
const errorMessage = ref('');
const isSubmitting = ref(false);

// Вспомогательное реактивное вычисление слотов для выбранного дня
const activeDateSlots = computed(() => {
  if (!selectedDate.value) return [];
  const timestampMs = new Date(`${selectedDate.value}T00:00:00Z`).getTime();
  return calendarData.value[timestampMs] || [];
});

// Динамический локальный подсчет стоимости (как в calculateTotal)
const computedTotalPrice = computed(() => {
  let total = 0;
  const selectedKeys = Object.keys(listPricing);

  if (selectedKeys.length > 0 && currentSlot.value) {
    currentSlot.value.pricesByRate.forEach(item => {
      selectedKeys.forEach(key => {
        if (parseInt(item.id) === parseInt(key)) {
          const quantity = listPricing[key];
          total += item.amount.amount * quantity;
        }
      });
    });
  }
  return total;
});

// Управление видимостью секции итогов
const showTotalSection = computed(() => {
  return Object.keys(listPricing).length > 0 && currentSlot.value !== null;
});

// Наблюдатели (Watchers) за действиями пользователя
watch(currentSlot, (newSlot) => {
  changeInputData(newSlot);
});

// Изменение количества билетов (ПЛЮС / МИНУС)
const incrementTicket = (id) => {
  if (!listPricing[id]) listPricing[id] = 0;
  if (listPricing[id] < 99) {
    listPricing[id]++;
    debounceRefreshCalendar();
  }
};

const decrementTicket = (id) => {
  if (listPricing[id] > 0) {
    listPricing[id]--;
    if (listPricing[id] === 0) {
      delete listPricing[id];
    }
    debounceRefreshCalendar();
  }
};

// Функция отправки параметров на сервер и обновления корзины
const changeInputData = (slot) => {
  if (!slot || !selectedDate.value) {
    totalDueAsText.value = '';
    sessionId.value = '0';
    showBookButton.value = false;
    return;
  }

  const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
  const requestPayload = {
    tour_id: props.tourId,
    date: selectedDate.value,
    start_time_id: slot.startTimeId,
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
        totalDueAsText.value = data.totalDueAsText;
        sessionId.value = data.sessionId;
        showBookButton.value = true;
        errorMessage.value = '';
      })
      .catch(error => {
        console.error('Ошибка API:', error);
        errorMessage.value = `This time doesn't available. Please change another time`;
        showBookButton.value = false;
      });
};

// Получение слотов времени (эмуляция getTimeSlots с плавным переходом)
const getTimeSlots = () => {
  slotsOpacity.value = 0.5;

  setTimeout(() => {
    currentSlot.value = null;
    slotsOpacity.value = 1;
    // Очищаем ошибку при смене даты
    errorMessage.value = '';
  }, 300); // 300мс вместо 1000мс для более плавного UX
};

// Дебаунс обновления календаря при кликах на счетчики
let debounceTimeout = null;
const debounceRefreshCalendar = () => {
  clearTimeout(debounceTimeout);
  debounceTimeout = setTimeout(() => {
    // Делаем AJAX-запрос к вашему контроллеру за новыми ценами для измененного состава билетов
    fetchUpdatedCalendarData();
  }, 500);
};

// Запрос актуальных цен в зависимости от выбранного состава билетов
const fetchUpdatedCalendarData = async () => {
  try {
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
    const response = await fetch(`/api/tours/${props.tourId}/availability`, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': csrfToken
      },
      body: JSON.stringify({
        pricing: listPricing
      })
    });

    if (!response.ok) throw new Error('Ошибка обновления данных календаря');

    const data = await response.json();
    calendarData.value = data;

    // Вызываем обновление у Vanilla Calendar, если он инициализирован
    if (calendarInstance) {
      calendarInstance.update();
    }

    // Обновляем слоты для уже выбранного дня, если он был выбран
    if (selectedDate.value) {
      getTimeSlots();
    }
  } catch (error) {
    console.error('Ошибка получения доступности:', error);
  }
};

// Инициализация календаря
const initCalendar = () => {
  if (!window.VanillaCalendar) {
    console.warn('VanillaCalendar не обнаружен во внешней области видимости window!');
    return;
  }

  calendarInstance = new window.VanillaCalendar(calendarContainer.value, {
    settings: {
      lang: 'en',
      range: {
        min: props.minDate
      },
      selection: {
        day: 'single'
      }
    },
    actions: {
      clickDay(event, self) {
        selectedDate.value = self.HTMLValues.date;
        getTimeSlots();
      },
      getDays(day, date, self) {
        // Логика отображения цен под днями (если она используется)
        const utcDate = new Date(date + 'T00:00:00Z');
        const timestampMs = utcDate.getTime();
        const daySlots = calendarData.value[timestampMs];

        const oldPriceSpan = day.element.querySelector('.calendar-day-price');
        if (oldPriceSpan) oldPriceSpan.remove();

        if (daySlots && daySlots.length > 0) {
          day.element.classList.remove('vanilla-calendar-day__btn_disabled');
          day.element.removeAttribute('disabled');

          // Минимальная цена для вывода
          const minPrice = Math.min(...daySlots.map(slot => {
            return slot.pricesByRate.reduce((acc, item) => {
              const quantity = listPricing[item.id] || 0;
              return acc + (item.amount.amount * quantity);
            }, 0);
          }).filter(p => p > 0));

          if (minPrice && minPrice !== Infinity) {
            const priceSpan = document.createElement('span');
            priceSpan.className = 'calendar-day-price';
            priceSpan.innerText = `${minPrice} €`;
            day.element.appendChild(priceSpan);
          }
        } else {
          day.element.classList.add('vanilla-calendar-day__btn_disabled');
          day.element.setAttribute('disabled', 'true');
        }
      }
    }
  });

  calendarInstance.init();
};

// Метод оформления заказа (Book Now)
const bookNow = () => {
  if (!currentSlot.value || isSubmitting.value) return;

  isSubmitting.value = true;
  // Перенаправляем на шаг оформления заказа в Laravel
  window.location.href = `/checkout?sessionId=${sessionId.value}`;
};

// Клик по ссылке обратной связи
const openDiscuss = () => {
  // Логика триггера формы обратной связи (ранее js-module="discuss")
  const discussEl = document.querySelector('[js-module="discuss"]');
  if (discussEl) {
    discussEl.click();
  } else {
    alert('Contact support to discuss a special tour!');
  }
};

// Жизненный цикл компонента
onMounted(() => {
  // Первоначальный запрос цен и инициализация Vanilla Calendar
  fetchUpdatedCalendarData().then(() => {
    initCalendar();
  });
});

onUnmounted(() => {
  if (calendarInstance) {
    calendarInstance = null;
  }
});
</script>

<style scoped>
/* Плавные переходы для слотов */
.tour__time-slots-container {
  transition: opacity 0.2s ease-in-out;
}
/* Стилизация цен Vanilla Calendar внутри ячеек */
:deep(.calendar-day-price) {
  font-family: sans-serif;
  font-size: 10px;
  font-weight: bold;
  color: #28a745;
  display: block;
  margin-top: 2px;
}
:deep(.vanilla-calendar-day button) {
  height: 48px !important;
  display: flex !important;
  flex-direction: column !important;
  align-items: center !important;
  justify-content: center !important;
}
:deep(.vanilla-calendar-day__btn_disabled) {
  opacity: 0.4;
  cursor: not-allowed;
}
</style>