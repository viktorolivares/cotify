<template>
  <div class="fixed w-full h-full top-0 left-0 flex items-center justify-center z-10" v-if="openModal">
    <div class="absolute bg-black opacity-70 inset-0 z-0" @click="handleBackdropClick"></div>
    <div :class="['w-full p-4 relative mx-auto my-auto rounded-xl shadow-lg bg-white dark:bg-indigo-900', modalSizeClass]"
      role="dialog" aria-modal="true">
      <div class="mb-8 dark:text-gray-300 text-lg">
        <div class="flex justify-between items-center">
          <div>{{ title }}</div>
          <div class="cursor-pointer text-red-600" @click="closeModal">✕</div>
        </div>
      </div>
      <slot></slot>
    </div>
  </div>
</template>

<script>
import { ref, computed, onMounted, onUnmounted } from 'vue';

export default {
  props: {
    title: {
      type: String,
      default: "Title",
    },
    size: {
      type: String,
      default: "md",
      validator(value) {
        return ["sm", "md", "lg", "xl", "2xl", "3xl"].includes(value);
      },
    },
  },
  setup(props, { emit }) {
    const openModal = ref(true);

    const closeModal = () => {
      openModal.value = false;
      emit('close');
    };

    const handleBackdropClick = () => {
      closeModal();
    };

    const onEscape = (e) => {
      if (e.key === "Escape") {
        closeModal();
      }
    };

    const modalSizeClass = computed(() => {
      return {
        'max-w-sm': props.size === 'sm',
        'max-w-md': props.size === 'md',
        'max-w-lg': props.size === 'lg',
        'max-w-xl': props.size === 'xl',
        'max-w-2xl': props.size === '2xl',
        'max-w-3xl': props.size === '3xl',
      };
    });

    onMounted(() => {
      document.addEventListener("keydown", onEscape);
    });

    onUnmounted(() => {
      document.removeEventListener("keydown", onEscape);
    });

    return {
      openModal,
      closeModal,
      handleBackdropClick,
      modalSizeClass,
    };
  },
};
</script>
