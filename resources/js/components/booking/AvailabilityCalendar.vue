<template>
  <div class="calendar-wrapper">
    <div
        ref="calendarContainer"
        class="calendar-container"
    ></div>
    <div v-if="isRefreshing" class="calendar-refresh-overlay">
      <span class="calendar-refresh-spinner"></span>
    </div>
  </div>
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
  },
  selectedMonth: {
    type: Number,
    required: true
  },
  selectedYear: {
    type: Number,
    required: true
  },
  isRefreshing: {
    type: Boolean,
    default: false
  }
});

const emit = defineEmits(['date-selected', 'month-change']);
const calendarContainer = ref(null);
let calendarInstance = null;

let debounceTimeout = null;
watch(() => props.calendarData, (n, o) => {
  if (calendarInstance && o) {
    clearTimeout(debounceTimeout);
    debounceTimeout = setTimeout(() => {
      calendarInstance.update();
    }, 0);
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
      selected: {
        month: props.selectedMonth - 1,
        year: props.selectedYear
      },
      selection: {
        day: 'single'
      }
    },
    actions: {
      clickArrow(event, self) {
        emit('month-change', {
          month: self.selectedMonth + 1,
          year: self.selectedYear
        });
      },
      clickMonth(event, self) {
        emit('month-change', {
          month: self.selectedMonth + 1,
          year: self.selectedYear
        });
      },
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
.calendar-wrapper {
  position: relative;
}
.calendar-refresh-overlay {
  position: absolute;
  inset: 0;
  z-index: 10;
  display: flex;
  align-items: center;
  justify-content: center;
  background: rgba(255, 255, 255, 0.45);
}
.calendar-refresh-spinner {
  width: 36px;
  height: 36px;
  border: 4px solid rgba(0, 0, 0, 0.18);
  border-top-color: #000;
  border-radius: 50%;
  animation: calendar-refresh-spin 0.8s linear infinite;
}
@keyframes calendar-refresh-spin {
  to {
    transform: rotate(360deg);
  }
}
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
