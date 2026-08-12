<template>
  <div
      ref="calendarContainer"
      class="calendar-container"
  ></div>
</template>

<script setup>
import { ref, onMounted, onUnmounted, watch } from 'vue';

const props = defineProps({
  minDate: {
    type: String,
    required: true
  },
  calendarData: {
    type: Object,
    required: true
  },
  listPricing: {
    type: Object,
    required: true
  }
});

const emit = defineEmits(['date-selected']);
const calendarContainer = ref(null);
let calendarInstance = null;

let debounceTimeout = null;
watch(() => props.calendarData, (n, o) => {
  if (calendarInstance && o) {
    calendarContainer.value.style.opacity = .5

    clearTimeout(debounceTimeout);
    debounceTimeout = setTimeout(() => {
      calendarInstance.update();
      calendarContainer.value.style.opacity = 1
    }, 1000);
  }
}, { deep: true });

const initCalendar = () => {
  if (!window.VanillaCalendar) {
    console.warn('VanillaCalendar не обнаружен в глобальной области видимости window!');
    return;
  }

  const maxDate = new Date(`${props.minDate}T00:00:00`);
  maxDate.setMonth(maxDate.getMonth() + 6);

  calendarInstance = new window.VanillaCalendar(calendarContainer.value, {
    date: {
      min: props.minDate,
      max: maxDate.toISOString().split('T')[0]
    },
    settings: {
      lang: 'en',
      selection: {
        day: 'single'
      }
    },
    actions: {
      clickDay(event, self) {
        const date = self.selectedDates[0]
        if (!date) return;
        const utcDate = new Date(date + 'T00:00:00Z');
        const timestampMs = utcDate.getTime();
        const daySlots = props.calendarData[timestampMs] ?? [];

        if (daySlots.length > 0) emit('date-selected', daySlots, date);
      },
      getDays(day, date, self) {
        const utcDate = new Date(date + 'T00:00:00Z');
        const timestampMs = utcDate.getTime();
        const daySlots = props.calendarData[timestampMs] ?? [];

        if(daySlots.length === 0) {
          const button = self.querySelector('button');
          if (button) {
            button.disabled = true;
            button.classList.add('vanilla-calendar-day__btn_disabled');
          }
        }
      }
    }
  });

  calendarInstance.init();
};

onMounted(() => {
  initCalendar();
});

onUnmounted(() => {
  clearTimeout(debounceTimeout);
  if (calendarInstance) {
    calendarInstance = null;
  }
});
</script>

<style scoped>
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
