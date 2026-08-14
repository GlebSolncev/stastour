<template>
  <div class="tour__calendar--wrapper">
    <div class="tour__calendar">

      <TicketSelector
          v-model="listPricing"
          :categories="ticketCategories"
          @change="debounceRefreshCalendar"
      />


      <div class="booking-stage">
        <AvailabilityCalendar
            :min-date="minDate"
            :calendar-data="calendarData"
            :list-pricing="listPricing"
            :selected-month="currentMonth"
            :selected-year="currentYear"
            :is-refreshing="calendarLoading || calendarRefreshing"
            @date-selected="onDateSelected"
            @month-change="onMonthChange"
        />
      </div>

      <div v-if="selectedDate || slotsLoading" class="booking-stage">
        <Preloader :is-visible="slotsLoading" />
        <TimeSlotSelector
            v-if="!slotsLoading"
            v-model="currentSlot"
            :slots="startTimes"
        />
      </div>

      <div class="booking-stage">
        <Preloader :is-visible="quoteLoading" />
        <BookingSummary
            v-if="!quoteLoading"
            :total-price="totalPrice"
            :show-book-button="showBookButton"
            :is-submitting="isSubmitting"
            @book="bookNow"
            @discuss="openDiscuss"
        />
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
import {ref, computed, watch, onBeforeMount, onBeforeUnmount} from 'vue';

// Импортируем наши новые дочерние компоненты
import TicketSelector from './TicketSelector.vue';
import AvailabilityCalendar from './AvailabilityCalendar.vue';
import TimeSlotSelector from './TimeSlotSelector.vue';
import BookingSummary from './BookingSummary.vue';
import Preloader from "../Preloader.vue";

// Свойства из Blade
const props = defineProps({
  tourId: {
    type: [String, Number],
    required: true
  },
  initialCategories: {
    type: Array,
    required: true
  },
  minDate: {
    type: String,
    default: () => new Date().toISOString().split('T')[0]
  }
});

// Состояние
const ticketCategories = ref(props.initialCategories);
const currentMonth = ref(new Date().getMonth() + 1)
const currentYear = ref(new Date().getFullYear())
const calendarData = ref({});
const selectedDate = ref(null);
const errorStartTimes = ref([]);
const startTimes = ref({});
const totalPrice = ref(0);
const listPricing = ref({});
const calendarLoading = ref(false);
const calendarRefreshing = ref(false);
const slotsLoading = ref(false);
const quoteLoading = ref(false);



const currentSlot = ref(null);
const slotsOpacity = ref(1);

// Данные API бронирования
const totalDueAsText = ref('');
const sessionId = ref('0');
const showBookButton = ref(false);
const errorMessage = ref('');
const isSubmitting = ref(false);

const adultCategory = ticketCategories.value.find(
  item => String(item.title).trim().toLowerCase() === 'adult'
);
if (adultCategory) listPricing.value = { [adultCategory.id]: 1 };

const hasPassengers = computed(() => Object.values(listPricing.value).some(count => Number(count) > 0));

const resetAfterPassengersChange = () => {
  selectedDate.value = null;
  startTimes.value = [];
  currentSlot.value = null;
  totalPrice.value = 0;
  totalDueAsText.value = '';
  sessionId.value = '0';
  showBookButton.value = false;
  errorMessage.value = '';
};

const fetchCalendarData = async () => {
  const query = new URLSearchParams();
  Object.entries(listPricing.value).forEach(([id, count]) => query.set(`pricing[${id}]`, count));
  query.set('year', currentYear.value);
  const response = await fetch(`/api/show-calendar/${props.tourId}/${currentMonth.value}?${query}`);
  if (!response.ok) throw new Error('Failed to load availability');
  calendarData.value = await response.json();
}

const onMonthChange = async ({ month, year }) => {
  currentMonth.value = month;
  currentYear.value = year;
  resetAfterPassengersChange();
  calendarRefreshing.value = true;

  try {
    await fetchCalendarData();
  } catch (error) {
    errorMessage.value = 'Availability is temporarily unavailable. Please try again.';
    calendarData.value = {};
  } finally {
    calendarRefreshing.value = false;
  }
};

onBeforeMount(async () => {
  try {
    calendarLoading.value = true;
    await fetchCalendarData();
  } catch (error) {
    errorMessage.value = 'Availability is temporarily unavailable. Please try again.';
  } finally {
    calendarLoading.value = false;
  }
});

let slotsTimeout = null;
const onDateSelected = async (data, date) => {
  if (!hasPassengers.value) return;
  selectedDate.value = date;
  startTimes.value = [];
  currentSlot.value = null
  totalPrice.value = 0
  showBookButton.value = false;
  sessionId.value = '0';
  errorMessage.value = '';
  slotsLoading.value = true;
  clearTimeout(slotsTimeout);
  slotsTimeout = setTimeout(() => {
    startTimes.value = data;
    slotsLoading.value = false;
  }, 200);
};

const fetchBookData = async () => {
  if(!currentSlot.value || !selectedDate.value || !listPricing.value) return;
  totalPrice.value = 0
  quoteLoading.value = true

  const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
  const requestPayload = {
    tour_id: props.tourId,
    date: selectedDate.value,
    start_time_id: currentSlot.value.startTimeId,
    pricing: listPricing.value
  };

  const response = await fetch('/api/cart', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
      'Accept': 'application/json',
      'X-CSRF-TOKEN': csrfToken
    },
    body: JSON.stringify(requestPayload)
  });

  const json = await response.json();
  if (!response.ok) throw new Error(json.message || 'Failed to calculate price');

  totalPrice.value = json.totalDueAsText;
  sessionId.value = json.sessionId || '0';
  showBookButton.value = Boolean(json.totalDueAsText);
  errorMessage.value = '';
};

let quoteTimeout = null;
watch(currentSlot, () => {
  clearTimeout(quoteTimeout);
  showBookButton.value = false;
  if (!currentSlot.value) return;

  quoteLoading.value = true;
  quoteTimeout = setTimeout(async () => {
    try {
      await fetchBookData();
    } catch (error) {
      errorMessage.value = error.message;
      totalPrice.value = 0;
      sessionId.value = '0';
      showBookButton.value = false;
    } finally {
      quoteLoading.value = false;
    }
  }, 300);
});

// watch(listPricing, async () => {
//   console.log('[T] TB>>>', listPricing)
// });
let debounceTimeout = null;
const debounceRefreshCalendar = () => {
  clearTimeout(debounceTimeout);
  resetAfterPassengersChange();
  slotsLoading.value = false;
  quoteLoading.value = false;

  if (!hasPassengers.value) {
    calendarData.value = {};
    calendarLoading.value = false;
    return;
  }

  calendarLoading.value = true;
  debounceTimeout = setTimeout(async () => {
    try {
      await fetchCalendarData();
    } catch (error) {
      errorMessage.value = error.message;
      calendarData.value = {};
    } finally {
      calendarLoading.value = false;
    }
  }, 500);
};




















// Активные тайм-слоты под выбранный день
const activeDateSlots = computed(() => {
  if (!selectedDate.value) return [];
  const timestampMs = new Date(`${selectedDate.value}T00:00:00Z`).getTime();
  const item =  calendarData.value[timestampMs] || [];

  if(errorStartTimes.value) {
    for (const inx in item) {
      console.log(' ', item[inx])
      item[inx].disabled = errorStartTimes.value.includes(item[inx].startTimeId)
    }
  }

  return item
});

// Динамический расчёт полной стоимости на фронтенде
const computedTotalPrice = computed(() => {
console.log('>>> ', totalDueAsText.value)
  return totalDueAsText.value;
});

// Слушаем выбор нового слота, чтобы сразу синхронизировать корзину
// watch(currentSlot, (newSlot) => {
//   changeInputData(newSlot);
// });

const onDateSelectedOld = async (data) => {
  // const timestampMs = Date.parse(date);
  //
  // let listStartTImeIds = []
  // for(const item of calendarData.value[timestampMs]) {
  //   listStartTImeIds.push(item.startTimeId)
  // }
  //
  // const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
  // const requestPayload = {
  //   tour_id: props.tourId,
  //   date: date,
  //   start_time_id: listStartTImeIds,
  //   pricing: listPricing.value
  // };
  // const response = await fetch('/api/cart', {
  //   method: 'POST',
  //   headers: {
  //     'Content-Type': 'application/json',
  //     'Accept': 'application/json',
  //     'X-CSRF-TOKEN': csrfToken
  //   },
  //   body: JSON.stringify(requestPayload)
  // });
  //
  // const data = await response.json();
  // errorStartTimes.value = data.errors;
  //
  // selectedDate.value = date;
  // getTimeSlots();
};

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
    pricing: listPricing.value
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
        totalDueAsText.value = data.items[0].totalAsText;
        console.log('!!!>>>> ', data.items[0], totalDueAsText.value)
        // sessionId.value = data.sessionId;
        showBookButton.value = true;
        errorMessage.value = '';
      })
      .catch(error => {
        console.error('Ошибка API:', error);
        errorMessage.value = `This time doesn't available. Please change another time`;
        showBookButton.value = false;
      });
};

const getTimeSlots = () => {
  slotsOpacity.value = 0.5;
  setTimeout(() => {
    currentSlot.value = null;
    slotsOpacity.value = 1;
    errorMessage.value = '';
  }, 300);
};

// Дебаунс обновления цен на календаре при кликах на счетчики
// let debounceTimeout = null;
// const debounceRefreshCalendar = () => {
//   clearTimeout(debounceTimeout);
//   debounceTimeout = setTimeout(() => {
//     fetchUpdatedCalendarData();
//     changeInputData();
//   }, 500);
// };

const fetchUpdatedCalendarData = async (month = null) => {
  try {
    if(!month) {
      month = new Date().getMonth() + 1
    }

    const response = await fetch(`/api/show-calendar/${props.tourId}/${month}`)
        // .then(response => response.json())
        // .then(newData => {
        //   calendarEl.setAttribute('data-calendar', JSON.stringify(newData));
        //
        //   this.month = newData;
        //   if (this.calendarData) {
        //     this.calendarData = newData;
        //   }
        //
        //   if (this.calendar && typeof this.calendar.update === 'function') {
        //     this.calendar.update();
        //   } else if (this.calendar) {
        //     this.calendar.init();
        //   }
        //
        //   calendarEl.style.opacity = '1';
        // })
        // .catch(error => {
        //   console.error('Ошибка при обновлении цен календаря:', error);
        //   calendarEl.style.opacity = '1';
        // });


    // const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
    // const response = await fetch(`/api/cart`, {
    //   method: 'POST',
    //   headers: {
    //     'Content-Type': 'application/json',
    //     'X-CSRF-TOKEN': csrfToken
    //   },
    //   body: JSON.stringify({
    //     // pricing: listPricing.value
    //     tour_id: tourId,
    //     date: selectedDate,
    //     start_time_id: currentSlot.startTimeId,
    //     pricing: listPricing
    //   })
    // });

    if (!response.ok) throw new Error('Ошибка обновления данных');

    const data = await response.json();
    calendarData.value = data;

    if (selectedDate.value) {
      getTimeSlots();
    }
  } catch (error) {
    console.error('Ошибка получения доступности:', error);
  }
};

const bookNow = async () => {
  if (!currentSlot.value || isSubmitting.value) return;
  isSubmitting.value = true;
  errorMessage.value = '';

  try {
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
    const response = await fetch('/api/bokun/checkout', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json',
        'X-CSRF-TOKEN': csrfToken
      },
      body: JSON.stringify({
        tour_id: props.tourId,
        date: selectedDate.value,
        start_time_id: currentSlot.value.startTimeId,
        pricing: listPricing.value
      })
    });
    const data = await response.json();
    if (!response.ok) throw new Error(data.message || 'Unable to start checkout');
    window.location.href = data.checkout_url;
  } catch (error) {
    errorMessage.value = error.message;
    isSubmitting.value = false;
  }
};

const openDiscuss = () => {
  const discussEl = document.querySelector('[js-module="discuss"]');
  if (discussEl) {
    discussEl.click();
  } else {
    alert('Contact support to discuss a special tour!');
  }
};

onBeforeUnmount(() => {
  clearTimeout(quoteTimeout);
  clearTimeout(debounceTimeout);
  clearTimeout(slotsTimeout);
});
</script>

<style scoped>
.booking-stage { min-height: 48px; }
</style>
