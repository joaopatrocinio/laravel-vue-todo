<script setup>

import { ref } from 'vue';
import TaskList from '../components/TaskList.vue';
import AddTaskModal from '../components/AddTaskModal.vue';
import EditTask from '../components/EditTask.vue';
import Button from '../components/Button.vue';

const showAdd = ref(false);
const showEdit = ref(false);
const refresh = ref(false);
const editId = ref(null);

function onClose() {
    showAdd.value = false;
    showEdit.value = false;
    refresh.value = true;
}

function onEdit(id) {
    editId.value = id;
    showEdit.value = true;
}

function onDoneRefresh() {
    refresh.value = false;
}

</script>

<template>
    <main class="border border-black bg-white my-4 p-4">
        <div class="flex justify-between">
            <h1 class="text-xl font-bold">To-do List</h1>
            <Button @click="showAdd = true" color="green">New Task</Button>
        </div>
        <TaskList :refresh @edit="onEdit" @done-refresh="onDoneRefresh" />
    </main>
    <AddTaskModal :show="showAdd" @close="onClose" />
    <EditTask v-if="showEdit" :id="editId" @close="onClose" />
</template>

