<template>
    <Head title="Search"></Head>
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">User</h2>
        </template>
        <div class="py-12">
            <div class="mx-auto sm:px-6 lg:px-8 max-w-[700px]">
                <div class="p-6 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-l mb-5" v-for="result in results.data">
                    <div class="flex gap-5"> 
                        <Avatar class="shrink-0"></Avatar>

                        <div>
                            <Link class=" text-gray-100 font-bold" :href="result.profile_url">{{result.full_name}}</Link>
                            <div class=" text-gray-900 dark:text-gray-400">{{ result.followings_count }} Following - {{ result.followers_count }} Followers</div>    
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </AuthenticatedLayout>
    
</template>

<script setup>
import { Head, Link } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Avatar } from '@/Components';


defineProps({
    results: {
        type: Object,
        required: true,
    },
});

</script>