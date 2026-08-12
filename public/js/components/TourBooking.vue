<template>
  <div class="tour-booking-container">

    <div v-if="currentStep === 'tickets'" class="tour-booking-tickets">
      <h3>Выберите билеты</h3>

      <div
          v-for="ticket in ticketCategories"
          :key="ticket.id"
          class="counter-wrapper"
      >
        <div class="ticket-info">
          <span class="ticket-name">{{ ticket.name }}</span>
          <span class="ticket-price">{{ ticket.basePrice }} €</span>
        </div>

        <div class="counter-controls">
          <button
              type="button"
              :disabled="getTicketCount(ticket.id) <= 0"
              @click="decrementTicket(ticket.id)"
          >
            -
          </button>
          <input
              type="number"
              :value="getTicketCount(ticket.id)"
              readonly
          />
          <button
              type="button"
              :disabled="getTicketCount(ticket.id) >= 99"
              @click="incrementTicket(ticket.id)"
          >
            +
          </button>
        </div>
      </div>

      <button
          class="btn-next"
          :disabled="totalTicketsCount === 0"
          @click="goToCalendar"
      >
        Далее: Выбор даты
      </button>
    </div>

    <div v-show="currentStep === 'calendar'" class="tour__calendar--wrapper">
      <div class="calendar-navigation">
        <button type="button" @click="goToTickets" class="back-to-counter">
          ← Назад к билетам
        </button>
      </div>

      <div class="tour__calendar">
        <div ref="calendarEl"></div>
      </div>

      <div v-if="selectedDateSlots.length > 0" class="time-slots-container">
        <h4>Доступное время:</h4>
        <div class="slots-grid">
          <div
              v-for="slot in selectedDateSlots"
              :key="slot.startTimeId"
              class="time-slot-option"
          >
            <input
                type="radio"
                :id="'time_' + slot.startTimeId"
                name="time_slot"
                :value="slot"
                v-model="selectedSlot"
            />
            <label :for="'time_' + slot.startTimeId">
              {{ slot.startTime }}
            </label>
          </div>
        </div>
      </div>

      <div class="booking-summary" v-if="selectedSlot">
        <div class="total-price">
          TOTAL PRICE: <span>{{ computedTotalPrice }} €</span>
        </div>
        <button
            class="btn-submit"
            :disabled="isSubmitting"
            @click="addToCart"
        >
          <span v-if="isSubmitting">Добавление...</span>
          <span v-else>Оформить заказ</span>
        </button>
      </div>
    </div>

  </div>
</template>

<script setup>
import { ref, reactive, computed, onMounted, onUnmounted, watch } from 'vue';

alert()

// Инициализируем пропсы (например, ID тура передается из Blade)
const props = defineProps({
  tourId: {
    type: [String, Number],
    required: true
  },
  // Категории билетов, пришедшие из Laravel
  initialCategories: {
    type: Array,
    default: () => [
      { id: 1083342, name: 'Взрослый', basePrice: 40 },
      { id: 999999, name: 'Детский', basePrice: 20 }
    ]
  }
});

// Состояние
const currentStep = ref('tickets'); // 'tickets' или 'calendar'
const ticketCategories = ref(props.initialCategories);
const selectedTickets = reactive({}); // Структура: { "1083342": 4 } [cite: 1936, 1937]
const isSubmitting = ref(false);

// Календарь
const calendarEl = ref(null);
let calendarInstance = null;
const calendarData = ref({}); // Хранит все данные о ценах и слотах от API

// Выбранные сущности
const selectedDateString = ref(''); // YYYY-MM-DD
const selectedSlot = ref(null);

// Вспомогательные методы для билетов
const getTicketCount = (id) => selectedTickets[id] || 0;

const incrementTicket = (id) => {
  if (!selectedTickets[id]) selectedTickets[id] = 0;
  if (selectedTickets[id] < 99) {
    selectedTickets[id]++;
    triggerDebouncedFetch();
  }
};

const decrementTicket = (id) => {
  if (selectedTickets[id] > 0) {
    selectedTickets[id]--;
    if (selectedTickets[id] === 0) {
      delete selectedTickets[id]; // Убираем пустые ключи, чтобы не плодить null [cite: 1822]
    }
    triggerDebouncedFetch();
  }
};

const totalTicketsCount = computed(() => {
  return Object.values(selectedTickets).reduce((acc, curr) => acc + curr, 0);
});

// Слоты для выбранного дня
const selectedDateSlots = computed(() => {
  if (!selectedDateString.value) return [];
  // Переводим локальную дату YYYY-MM-DD в UTC-полночь (таймстамп в ms), как в Laravel/Bokun [cite: 1854, 1856, 1945]
  const utcDate = new Date(selectedDateString.value + 'T00:00:00Z');
  const timestampMs = utcDate.getTime();

  return calendarData.value[timestampMs] || [];
});

// Автоматический подсчет стоимости на клиенте [cite: 2005]
const computedTotalPrice = computed(() => {
  if (!selectedSlot.value) return 0;

  let total = 0;
  // Проходим по выбранным билетам [cite: 1933]
  Object.keys(selectedTickets).forEach(ticketId => {
    const count = selectedTickets[ticketId];
    // Ищем цену этой категории внутри выбранного временного слота [cite: 1934]
    const rate = selectedSlot.value.pricesByRate.find(
        r => String(r.rateId || r.id) === String(ticketId) // Приведение типов [cite: 1942]
    );
    if (rate) {
      total += rate.price * count; // Суммируем [cite: 1935]
    }
  });
  return total;
});

// Сброс слота при смене выбранного дня
watch(selectedDateString, () => {
  selectedSlot.value = null;
});

// Навигация
const goToCalendar = () => {
  currentStep.value = 'calendar';
  // Инициализируем календарь только при переходе на экран, чтобы избежать багов с размерами скрытого контейнера [cite: 1864, 1865]
  if (!calendarInstance) {
    initCalendar();
  }
};

const goToTickets = () => {
  currentStep.value = 'tickets';
};

// --- РАБОТА С API И DEBOUNCE ---
let debounceTimeout = null;

const triggerDebouncedFetch = () => {
  // Если мы уже на шаге календаря, делаем плавный запрос с задержкой в 500мс [cite: 1994, 2001, 2008]
  if (currentStep.value === 'calendar') {
    if (debounceTimeout) clearTimeout(debounceTimeout);
    debounceTimeout = setTimeout(() => {
      fetchCalendarData();
    }, 500);
  }
};

const fetchCalendarData = async () => {
  try {
    // Отправляем текущие выбранные билеты, чтобы получить валидные слоты/цены под этот состав [cite: 1889]
    const response = await fetch(`/api/tours/${props.tourId}/availability`, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
      },
      body: JSON.stringify({
        pricing: selectedTickets
      })
    });

    if (!response.ok) throw new Error('Ошибка сети');

    // Получаем JSON, где ключи — таймстампы в миллисекундах [cite: 1852, 1899]
    calendarData.value = await response.json();

    // Перерисовываем календарь, чтобы обновить доступность дней [cite: 1892, 1901]
    if (calendarInstance) {
      calendarInstance.update();
    }
  } catch (error) {
    console.error('Ошибка загрузки данных календаря:', error);
  }
};

// --- ИНИЦИАЛИЗАЦИЯ VANILLA CALENDAR ---
const initCalendar = () => {
  if (!window.VanillaCalendar) {
    console.warn('VanillaCalendar библиотека не найдена на глобальном уровне window!');
    return;
  }

  calendarInstance = new window.VanillaCalendar(calendarEl.value, {
    settings: {
      lang: 'ru',
      range: {
        min: new Date().toISOString().split('T')[0] // Ограничение: только будущие даты [cite: 2074]
      },
      selection: {
        day: 'single'
      }
    },
    actions: {
      clickDay(event, self) {
        // Записываем выбранную дату [cite: 1959, 1964]
        selectedDateString.value = self.HTMLValues.date;
      },
      // Вызывается при перерисовке дней (здесь вешаем цены и disabled) [cite: 1751, 1944]
      getDays(day, date, self) {
        // Вычисляем UTC-таймстамп начала дня в ms [cite: 1854, 1856, 1945]
        const utcDate = new Date(date + 'T00:00:00Z');
        const timestampMs = utcDate.getTime();

        const daySlots = calendarData.value[timestampMs];

        // Очищаем старые кастомные элементы, чтобы верстка не дублировалась при смене месяцев [cite: 1949]
        const oldPriceSpan = day.element.querySelector('.calendar-day-price');
        if (oldPriceSpan) oldPriceSpan.remove();

        // Если слоты с ценами на этот день есть — активируем кнопку [cite: 1944, 1946]
        if (daySlots && daySlots.length > 0) {
          day.element.classList.remove('vanilla-calendar-day__btn_disabled');
          day.element.removeAttribute('disabled'); // [cite: 1947]

          // Находим минимальную цену среди всех слотов этого дня
          const minPrice = Math.min(...daySlots.map(slot => {
            // Считаем стоимость слота на текущий состав билетов
            return slot.pricesByRate.reduce((acc, rate) => {
              const count = selectedTickets[rate.rateId || r.id] || 0;
              return acc + (rate.price * count);
            }, 0);
          }).filter(p => p > 0));

          if (minPrice && minPrice !== Infinity) {
            // Добавляем красивый тег цены вниз кнопки дня [cite: 1751, 1951, 1952]
            const priceSpan = document.createElement('span');
            priceSpan.className = 'calendar-day-price';
            priceSpan.innerText = `${minPrice} €`;
            day.element.appendChild(priceSpan);
          }
        } else {
          // Если тарифов на день нет, полностью гасим кнопку [cite: 1946, 1947]
          day.element.classList.add('vanilla-calendar-day__btn_disabled');
          day.element.setAttribute('disabled', 'true'); // [cite: 1947, 1948]
        }
      }
    }
  });

  calendarInstance.init();
  // Сразу загружаем данные под выбранные билеты
  fetchCalendarData();
};

// --- ОТПРАВКА КОРЗИНЫ В LARAVEL ---
const addToCart = async () => {
  if (!selectedSlot.value || !selectedDateString.value) return;

  isSubmitting.value = ref(true);

  // Формируем плоский массив категорий (дублируем ID по количеству), как требует Bokun API [cite: 2087, 2091, 2102]
  const pricingCategoryBookings = [];
  Object.keys(selectedTickets).forEach(key => {
    const quantity = selectedTickets[key];
    for (let i = 0; i < quantity; i++) {
      pricingCategoryBookings.push({
        pricingCategoryId: Number(key), // Приводим к числу для Bokun [cite: 2108]
        extras: [] // Пустые допы [cite: 2109]
      });
    }
  });

  const payload = {
    tour_id: props.tourId,
    date: selectedDateString.value,
    start_time_id: selectedSlot.value.startTimeId,
    tickets: pricingCategoryBookings
  };

  try {
    const response = await fetch('/api/cart', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '' // [cite: 2096, 2097]
      },
      body: JSON.stringify(payload)
    });

    const result = await response.json();

    if (!response.ok) {
      throw new Error(result.message || 'Ошибка при добавлении в корзину');
    }

    // Редирект на оформление бронирования в Laravel
    window.location.href = '/checkout';
  } catch (error) {
    alert(`Ошибка бронирования: ${error.message}`);
  } finally {
    isSubmitting.value = false;
  }
};

onUnmounted(() => {
  if (calendarInstance) {
    // Чистим за собой инстансы
    calendarInstance = null;
  }
});
</script>

<style scoped>
/* Сюда переезжают ваши стили оформления календаря и кнопок */
.tour__calendar {
  padding: 20px 15px;
  margin: auto;
  max-width: 330px;
}
.tour__calendar--wrapper {
  background: var(--green, #28a745);
  border-radius: 8px;
  padding: 15px;
}
.calendar-navigation {
  margin-bottom: 15px;
}
.back-to-counter {
  background: none;
  border: none;
  color: #fff;
  cursor: pointer;
  font-weight: bold;
}

/* Стили для кастомных кнопок времени */
.slots-grid {
  display: flex;
  gap: 10px;
  flex-wrap: wrap;
  margin-top: 10px;
}
.time-slot-option input[type="radio"] {
  display: none; /* Скрываем стандартный кружок радио-кнопки [cite: 1978] */
}
.time-slot-option label {
  display: inline-block;
  padding: 8px 16px;
  background: #f8f9fa;
  border: 1px solid #ddd;
  border-radius: 6px;
  cursor: pointer;
  font-weight: bold;
  transition: all 0.2s ease;
}
.time-slot-option input[type="radio"]:checked + label {
  background: var(--blue, #17A1FA); /* Эффект активной кнопки [cite: 1982] */
  color: #fff;
  border-color: var(--blue, #17A1FA);
}

/* Стилизация цен прямо в календаре */
:deep(.calendar-day-price) {
  font-family: "Raleway", sans-serif;
  font-size: 9px;
  font-weight: 700;
  color: #28a745;
  margin-top: 2px;
  display: block;
}
:deep(.vanilla-calendar-day button) {
  height: 48px !important; /* Увеличиваем высоту кнопки дня под цену [cite: 1951, 1953] */
  display: flex !important;
  flex-direction: column !important;
  align-items: center !important;
  justify-content: center !important;
}
:deep(.vanilla-calendar-day__btn_disabled) {
  opacity: 0.5;
  cursor: not-allowed;
}
</style>