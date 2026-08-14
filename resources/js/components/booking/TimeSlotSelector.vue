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

      <label :for="slot.startTimeId" class="time-slot-label">
        <span>{{ slot.startTime }}</span>
        <span v-if="slot.externalLabel" class="time-slot-external-label">{{ slot.externalLabel }}</span>
      </label>
    </div>
  </div>
</template>

<script setup>
defineProps({
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
.time-slot-label {
  box-sizing: border-box;
  max-width: 100%;
  white-space: normal;
}
.time-slot-external-label {
  margin-left: 4px;
}
.time-slot-item {
  max-width: 100%;
}
</style>
