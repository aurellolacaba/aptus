<template>
    <Head title="Home" />

    <AuthenticatedLayout>
        <!-- <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Home</h2>
        </template> -->

        <div class="py-12">
            <div class="mx-auto sm:px-6 lg:px-8 max-w-[700px] mt-16">
                <CreatePost></CreatePost>
                <PostCollection :posts="posts"></PostCollection>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { Avatar, CreatePost, PostCollection } from '@/Components'

defineProps({
    posts: Object
})


</script>