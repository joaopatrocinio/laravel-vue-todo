<template>
    <div class="table-auto m-auto" v-if="data">
        <p v-if="data.length == 0">
            No tasks.
        </p>
        <div class="flex gap-2 my-1 items-center" v-for="row in data" :key="row.id">
            <input type="checkbox" @click="updateTaskStatus" :checked="checkedTasks.includes(row.id)" :value="row.id" v-model="checkedTasks">
            <div class="text-pretty" :class="{ 'line-through': checkedTasks.includes(row.id) }">{{ row.title }}</div>
            <div class="flex gap-1 ml-2 items-center">
                <Button @click="$emit('edit', row.id)" color="blue">✏️</Button>
                <Button @click="deleteTask(row.id)" color="red">🗑️</Button>
            </div>
        </div>
    </div>
    <Loading v-else />
</template>

<script setup>

import { ref, watch } from 'vue';
import Button from './Button.vue';
import Loading from './Loading.vue';

const props = defineProps({
    refresh: Boolean
})
const data = ref(null);
const checkedTasks = ref([]);
const emit = defineEmits(["doneRefresh"]);

watch(() => props.refresh, () => getTasks(), { deep: true });

getTasks();

function getTasks() {
    axios.get("/api/tasks")
        .then(function (response) {
            data.value = response.data.payload;
            checkedTasks.value = response.data.payload.map(row => {
                return row.status_id == 2 ? row.id : null;
            });
        })
        .catch(function (error) {
            console.log(error);
        })
        .finally(function () {
            emit("doneRefresh");
        });
}

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

function deleteTask(id) {
    axios.delete(`/api/tasks/${id}`)
        .then(function (response) {
            console.log(response)
        })
        .catch(function (error) {
            console.log(error);
        })
        .finally(function () {
            getTasks();
        });
}
</script>
