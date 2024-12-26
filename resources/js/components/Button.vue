<script setup>

const props = defineProps({
    color: String
});

</script>

<template>
    <button class="h-fit rounded-lg p-1 text-white text-sm font-bold hover:scale-110 transition"
        :class='{
            "bg-sky-500": color == "blue",
            "bg-rose-500": color == "red",
            "bg-green-500": color == "green",
        }'>
        <slot></slot>
    </button>
</template>