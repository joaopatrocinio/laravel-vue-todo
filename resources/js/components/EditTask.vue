<script setup>
import axios from 'axios';
import Button from './Button.vue';
import { ref, useTemplateRef } from 'vue';
import Loading from './Loading.vue';

const props = defineProps({
    id: Number
});

const loading = ref(true);
const title = ref("");
const status_id = ref(null);
const textarea = useTemplateRef("textarea");
const textarea_error = useTemplateRef("textarea-error");
const emit = defineEmits(["close"]);

getTask(props.id);

function getTask() {
    axios.get(`/api/tasks/${props.id}`)
        .then(function (response) {
            title.value = response.data.payload.title;
            status_id.value = response.data.payload.status_id;
        })
        .catch(function (error) {
            console.log(error)
        })
        .finally(function () {
            loading.value = false;
        });
}

function updateTask() {

    if (!title.value) {
        textarea.value.classList.add("border-rose-500");
        textarea_error.value.innerText = "Field cannot be empty.";
        return;
    }

    loading.value = true;
    axios.put(`/api/tasks/${props.id}`, {
            title: title.value,
            status_id: status_id.value
        })
        .then(function (response) {
            console.log(response);
        })
        .catch(function (error) {
            console.log(error)
        })
        .finally(function () {
            emit("close");
        });
}

function clearErrors() {
    textarea.value.classList.remove("border-rose-500");
    textarea_error.value.innerText = "";
}
</script>

<template>
    <div class="border border-black bg-white my-4 p-4">
        <div v-if="!loading">
            <h1 class="font-bold float-left">Edit task</h1>
            <button
                class="float-right"
                @click="$emit('close')"
            >X</button>
            <br />
            <div class="flex flex-col my-4">
                <label for="title">Title:</label>
                <textarea ref="textarea" @keyup="clearErrors" id="title" v-model="title" class="border w-max"></textarea>
                <span ref="textarea-error" class="text-rose-500"></span>
            </div>
            <Button
                class="float-right"
                color="green"
                @click="updateTask"
            >Update</Button>
        </div>
        <Loading v-else />
        <br>
    </div>
</template>