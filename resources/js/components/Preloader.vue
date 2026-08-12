<script setup>
defineProps({
  isVisible: {
    type: Boolean,
    required: true
  }
});
</script>

<template>
  <div class="inline-preloader" v-show="isVisible">
    <svg class="spinner" viewBox="0 0 50 50">
      <circle class="path" cx="25" cy="25" r="20" fill="none" stroke-width="5"></circle>
    </svg>
  </div>
</template>

<style scoped>
/* Контейнер для центрирования */
.inline-preloader {
  display: flex;
  justify-content: center;
  align-items: center;
  padding: 1rem;
}

/* Настройки самого круга */
.spinner {
  width: 40px; /* Меняй размер здесь */
  height: 40px;
  animation: rotate 2s linear infinite;
}

/* Настройки линии */
.path {
  stroke: #3b82f6; /* Цвет спиннера (сейчас синий) */
  stroke-linecap: round;
  animation: dash 1.5s ease-in-out infinite;
}

/* Анимация вращения всего SVG */
@keyframes rotate {
  100% {
    transform: rotate(360deg);
  }
}

/* Анимация длины линии (эффект "догоняющего" хвоста) */
@keyframes dash {
  0% {
    stroke-dasharray: 1, 150;
    stroke-dashoffset: 0;
  }
  50% {
    stroke-dasharray: 90, 150;
    stroke-dashoffset: -35;
  }
  100% {
    stroke-dasharray: 90, 150;
    stroke-dashoffset: -124;
  }
}
</style>