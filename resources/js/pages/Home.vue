<template>
    <main class="border border-black bg-white my-4 p-4">
        <div class="flex justify-between">
            <h1 class="text-xl font-bold">To-do List</h1>
            <button class="rounded-lg bg-green-500 p-1 text-white font-bold hover:scale-110 transition">Adicionar</button>
        </div>
        <TaskList />
    </main>
    <EditTask v-if="editing" @edit="openEdit"/>
</template>

<script setup>

import { ref } from 'vue';
import EditTask from '../components/EditTask.vue';
import TaskList from '../components/TaskList.vue';

const editing = ref(false);

function openEdit() {
    console.log("openEdit")
    editing.value = true;
}
</script>
