<template>
  <div class="tour-booking-tickets">
    <div
        v-for="item in categories"
        :key="item.id"
        class="ticket-counter-item"
    >
      <label class="ticket-counter-label">
        <span>{{ item.title }}</span>
        <small v-if="ageLabel(item)" class="ticket-age">{{ ageLabel(item) }}</small>
      </label>

      <div class="ticket-counter-controls">
        <button
            type="button"
            class="counter-btn btn-minus"
            :disabled="getCount(item.id) <= 0"
            @click="decrement(item.id)"
        >
          —
        </button>
        <input
            type="number"
            class="counter-input"
            :value="getCount(item.id)"
            readonly
        >
        <button
            type="button"
            class="counter-btn btn-plus"
            :disabled="getCount(item.id) >= 99"
            @click="increment(item.id)"
        >
          +
        </button>
      </div>
    </div>
  </div>
</template>

<script setup>
const props = defineProps({
  modelValue: {
    type: Object,
    required: true
  },
  categories: {
    type: Array,
    required: true
  }
});

const emit = defineEmits(['update:modelValue', 'change']);

const ageLabel = (item) => {
  const min = item.minAge !== null && item.minAge !== '' && Number.isFinite(Number(item.minAge))
    ? Number(item.minAge) : null;
  const max = item.maxAge !== null && item.maxAge !== '' && Number.isFinite(Number(item.maxAge))
    ? Number(item.maxAge) : null;

  if (min !== null && max !== null) return `Age ${min}–${max}`;
  if (min !== null) return `Age ${min}+`;
  if (max !== null) return `Up to age ${max}`;
  return '';
};

const getCount = (id) => props.modelValue[id] || 0;

const increment = (id) => {
  const updated = { ...props.modelValue };
  updated[id] = (updated[id] || 0) + 1;
  changed(updated)
};

const decrement = (id) => {
  const updated = { ...props.modelValue };
  if (updated[id] > 0) {
    updated[id]--;
    if (updated[id] === 0) {
      delete updated[id];
    }
    changed(updated)
  }
};

const changed = (updated) => {
  emit('update:modelValue', updated);
  emit('change');
}

</script>

<style scoped>
.ticket-counter-label { display: flex; flex-direction: column; font-weight: 800; }
.ticket-age { margin-top: .15rem; font-size: .78rem; font-weight: 700; opacity: .8; }
</style>
