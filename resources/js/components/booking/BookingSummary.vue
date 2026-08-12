<template>
  <div class="tour__total">
    <p class="tour__total--price">
      TOTAL PRICE: <span class="total-price">{{ totalPrice || '—' }}</span>
    </p>
    <p class="tour__total--hint">Price depends from the number of people</p>
    <p class="tour__total--discuss">
      Need a special tour? <a href="#" @click.prevent="$emit('discuss')">Let’s discuss!</a>
    </p>
    <button
        v-if="isSubmitting || showBookButton"
        class="button button--fill tour__total--buy"
        style="margin-top:15px"
        :disabled="!showBookButton || isSubmitting"
        @click="$emit('book')"
    >
      <span v-if="isSubmitting">Booking...</span>
      <span v-else-if="showBookButton">Book now</span>
    </button>
  </div>
</template>

<script setup>
defineProps({
  totalPrice: {
    type: [Number, String],
    required: true
  },
  showBookButton: {
    type: Boolean,
    default: false
  },
  isSubmitting: {
    type: Boolean,
    default: false
  }
});

defineEmits(['book', 'discuss']);
</script>
