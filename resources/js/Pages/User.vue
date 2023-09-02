<template>
    <Head title="User"></Head>
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">User</h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="p-6 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-l mb-5" >
                    <form @submit.prevent="submit">
                        <input type="file" @input="form.avatar = $event.target.files[0]" />
                        <progress v-if="form.progress" :value="form.progress.percentage" max="100">
                        {{ form.progress.percentage }}%
                        </progress>
                        <button type="submit">Submit</button>
                    </form>
                    

                    <h1 class="text-white">{{user.full_name }}</h1>

                    <div class="flex gap-3">
                        <span class="text-gray-400">{{ followers_count }} Followers</span>
                        <span class="text-gray-400">{{ followings_count }} Following</span>
                        <Link v-if="is_following" class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-500 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 disabled:opacity-25 transition ease-in-out duration-150" :href="route('users.unfollow')" method="post" :data="{id: user.id}" as="button">Unfollow</Link>
                        <Link v-else class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150" :href="route('users.follow')" method="post" :data="{id: user.id}" as="button">Follow</Link>
                    </div>


                </div>
            </div>
        </div>
    </AuthenticatedLayout>
    
</template>

<script setup>
import { Head, Link } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { useForm } from '@inertiajs/vue3'

defineProps({
    user: Object,
    followers_count: Number,
    followings_count: Number,
    is_following: Boolean
})

const form = useForm({
  avatar: null,
})

function submit() {
  form.post(route('profile.upload'))
}
</script>