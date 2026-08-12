<template>
  <div class="tour__time-slots-container" :style="{ opacity: opacity }">
    <div
        v-for="slot in slots"
        :key="slot.startTimeId"
        class="time-slot-item"
    >
      <input
          type="radio"
          :id="slot.startTimeId"
          name="start_time"
          :value="slot"
          :checked="modelValue?.startTimeId === slot.startTimeId"
          @change="$emit('update:modelValue', slot)"
          :disabled="slot.disabled"
      />

<!--      :disabled="errorStartTimes.includes(slot.startTimeId)"-->
      <label :for="slot.startTimeId">{{ slot.startTime }}</label>
    </div>
  </div>
</template>

<script setup>
const props = defineProps({
  slots: {
    type: Array,
    required: true
  },
  modelValue: {
    type: Object,
    default: null
  },
  opacity: {
    type: Number,
    default: 1
  }
});

defineEmits(['update:modelValue']);
</script>

<style scoped>
.tour__time-slots-container {
  transition: opacity 0.2s ease-in-out;
}
</style>