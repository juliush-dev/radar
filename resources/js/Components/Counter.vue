<template>
    <div class="">
        <div @click="count++" class="p-8 border border-teal-200">{{ count }}</div>
    </div>
</template>

<script setup>
import { ref } from "vue";

const count = ref(1);
</script>
