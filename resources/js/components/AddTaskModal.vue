<script setup>
import { ref, useTemplateRef } from 'vue';
import Modal from './Modal.vue'

const props = defineProps({
  show: Boolean
})

const emit = defineEmits(["close"]);
const textarea = useTemplateRef("textarea");
const textarea_error = useTemplateRef("textarea-error");

function addTask() {

    console.log(task.value.title)

    if (!task.value.title) {
        textarea.value.classList.add("border-rose-500");
        textarea_error.value.innerText = "Field cannot be empty.";
        return;
    }

    axios.post("/api/tasks", task.value)
        .then(function (response) {
            console.log(response)
        })
        .catch(function (error) {
            console.log(error);
        })
        .finally(function () {
            task.value.title = undefined;
            emit("close");
        });
}

const task = ref({
    title: undefined,
    status_id: 1
});

function clearErrors() {
    textarea.value.classList.remove("border-rose-500");
    textarea_error.value.innerText = "";
}

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
                <textarea ref="textarea" @keyup="clearErrors" id="title" v-model="task.title" class="border w-max"></textarea>
                <br />
                <span ref="textarea-error" class="text-rose-500"></span>
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