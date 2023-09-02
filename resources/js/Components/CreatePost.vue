<template>
    <div class="p-6 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-l mb-5">
        <div class="flex gap-5">
            <Avatar class="shrink-0"></Avatar>

            <div class="grow">
                <h1 class=" text-gray-500 mb-3">What is Happening?</h1>
                <form @submit.prevent="submit">
                    <textarea class="w-full bg-transparent text-white mb-3" id="body"  cols="30" rows="3" v-model="form.body" required></textarea>

                    <FilePond
                        name="photos"
                        ref="pond"
                        instant-upload="false"
                        label-idle="Click to choose photos, or Drop files here..."
                        allow-image-preview="false"
                        allow-multiple="true"
                        allow-file-encode="true"
                        accepted-file-types="image/jpeg, image/jpg, image/png"
                        @init="handleFilePondInit"
                        @addfile="test"
                    />

                    <div class="flex gap-5 justify-between">
                        <PhotoIcon class="dark:text-gray-100 w-8"></PhotoIcon>
                        <PrimaryButton>post</PrimaryButton>
                    </div>
                </form>
            </div>
            
        </div>
        
        
    </div>
</template>

<script setup>
import PrimaryButton from './PrimaryButton.vue';
import Avatar from './Avatar.vue'
import { useForm } from '@inertiajs/vue3';
import { PhotoIcon } from '@heroicons/vue/24/solid'
import vueFilePond from 'vue-filepond'
import FilePondPluginFileValidateType from 'filepond-plugin-file-validate-type'
import FilePondPluginFileEncode from 'filepond-plugin-file-encode';
import FilePondPluginImagePreview from 'filepond-plugin-image-preview';
import 'filepond/dist/filepond.min.css'
import 'filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css';
import { ref } from 'vue';

const FilePond = vueFilePond(
    FilePondPluginFileValidateType, 
    FilePondPluginFileEncode, 
    FilePondPluginImagePreview
)

const pond = ref(null)
const form = useForm({
    body: '',
    photos: null
});

const test = () =>{
    form.photos = pond.value.getFiles()[0].file
}

const submit = () => {
    form.post(route('posts.create'), {
        onSuccess: () => {
            form.reset()
            pond.value.removeFiles()
        }
    });
};

const handleFilePondInit = () => {
    console.log('FilePond has initialized')
}


</script>