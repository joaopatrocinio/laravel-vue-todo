<template>
    <div class="table-auto m-auto" v-if="data">
        <div class="flex gap-2 align-center" v-for="row in data" :key="row.id">
            <input type="checkbox" @click="updateTaskStatus" :checked="checkedTasks.includes(row.id)" :value="row.id" v-model="checkedTasks">
            <div :class="{ 'line-through': checkedTasks.includes(row.id) }">{{ row.title }}</div>
            <div class="flex gap-1 ml-2">
                <button @click="$emit('edit')" class="rounded-lg bg-sky-500 p-1 text-white text-sm font-bold hover:scale-110 transition">✏️</button>
                <button class="rounded-lg bg-rose-500 p-1 text-white text-sm font-bold hover:scale-110 transition">🗑️</button>
            </div>
        </div>
    </div>
    <span v-else class="m-auto block w-fit">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-10" viewBox="0 0 200 200"><radialGradient id="a5" cx=".66" fx=".66" cy=".3125" fy=".3125" gradientTransform="scale(1.5)"><stop offset="0" stop-color="#778899"></stop><stop offset=".3" stop-color="#778899" stop-opacity=".9"></stop><stop offset=".6" stop-color="#778899" stop-opacity=".6"></stop><stop offset=".8" stop-color="#778899" stop-opacity=".3"></stop><stop offset="1" stop-color="#778899" stop-opacity="0"></stop></radialGradient><circle transform-origin="center" fill="none" stroke="url(#a5)" stroke-width="15" stroke-linecap="round" stroke-dasharray="200 1000" stroke-dashoffset="0" cx="100" cy="100" r="70"><animateTransform type="rotate" attributeName="transform" calcMode="spline" dur="2" values="360;0" keyTimes="0;1" keySplines="0 0 1 1" repeatCount="indefinite"></animateTransform></circle><circle transform-origin="center" fill="none" opacity=".2" stroke="#778899" stroke-width="15" stroke-linecap="round" cx="100" cy="100" r="70"></circle></svg>
    </span>
</template>

<script setup>

import { ref } from 'vue';

const data = ref(null);
const checkedTasks = ref([]);

axios.get("/api/tasks")
    .then(function (response) {
        data.value = response.data.payload;
        checkedTasks.value = response.data.payload.map(row => {
            return row.status_id == 2 ? row.id : null;
        });
    })
    .catch(function (error) {
        console.log(error);
    });

function updateTaskStatus(event) {
    
    const urls = {
        complete: "/api/tasks/markAsCompleted",
        pending: "/api/tasks/markAsPending",
    };

    const url = event.target.checked ? urls.complete : urls.pending;

    axios.post(url, {
            id: event.target.value
        })
        .then(function (response) {
            console.log(response)
        })
        .catch(function (error) {
            console.log(error);
        });
}
</script>
