<script setup>
import { ref } from 'vue';
import Modal from './Modal.vue'

const props = defineProps({
  show: Boolean
})

const emit = defineEmits(["close"]);

function addTask() {
    axios.post("/api/tasks", task.value)
        .then(function (response) {
            console.log(response)
        })
        .catch(function (error) {
            console.log(error);
        })
        .finally(function () {
            emit("close");
        });
}

const task = ref({
    title: undefined,
    status_id: 1
});

</script>

<template>
    <Teleport to="body">
        <!-- use the modal component, pass in the prop -->
        <Modal :show="show" @close="$emit('close')">
            <template #header>
                <h3 class="float-left">New Task</h3>
                <button
                    class="modal-default-button"
                    @click="$emit('close')"
                >X</button>
            </template>
            <template #body>
                <br>
                <label for="title">Title:</label>
                <textarea id="title" v-model="task.title" class="border w-max"></textarea>
            </template>
            <template #footer>
                <button
                    class="modal-default-button"
                    @click="addTask"
                >Add</button>
            </template>
        </Modal>
    </Teleport>
</template>