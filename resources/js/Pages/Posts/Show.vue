<template>
    <Head title="Post"></Head>
    <AuthenticatedLayout>
        <div class="py-12">
            <div class="max-w-[700px] mx-auto sm:px-6 lg:px-8 mt-16">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-l mb-5" >
                    <PostItem :post="post"></PostItem>
                </div>

                <!-- Comment List -->
                

                <!-- <div class="p-6 overflow-hidden shadow-sm sm:rounded-l mb-5 text-white" v-for="comment in comments">
                    <div class="flex gap-5">
                        <Avatar class="shrink-0"></Avatar>
                        <div>
                            <div>
                                <Link class=" text-gray-100 font-bold" :href="comment.user.profile_url">{{ comment.user.full_name }}</Link>
                            </div>

                            {{ comment.body }}
                        </div>
                    </div>
                </div> -->

                <article class="p-6 text-base bg-white rounded-lg dark:bg-gray-900" v-for="comment in comments">
                    <footer class="flex justify-between items-center mb-2">
                        <div class="flex items-center">
                            <p class="inline-flex items-center text-sm mr-3 text-gray-900 dark:text-white gap-5">
                                <Avatar :src="comment.user.avatar"></Avatar>
                                {{ comment.user.full_name }}
                            </p>
                        </div>
                    </footer>
                    <p class="text-gray-500 dark:text-gray-400">{{ comment.body }}</p>
                    <div class="flex items-center mt-4 space-x-4">
                        <Link  :class="comment.is_liked ? 'text-blue-500' : 'text-gray-400'" class="text-sm hover:underline" :href="route('comments.like', {comment: comment.id})" method="post" as="button" preserve-scroll>{{ comment.likes_count }} Likes</Link>

                        <button type="button"
                            class="flex items-center text-sm text-gray-500 hover:underline dark:text-gray-400">
                            <svg aria-hidden="true" class="mr-1 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                            Reply
                        </button>
                        <small class="text-gray-400">{{ comment.diff_for_humans }}</small>
                    </div>

                    <!-- Replies -->
                    <article class="p-6 lg:ml-12 text-base bg-white rounded-lg dark:bg-gray-900" v-for="reply in comment.replies">
                        <footer class="flex justify-between items-center mb-2">
                            <div class="flex items-center">
                                <p class="inline-flex items-center text-sm mr-3 text-gray-900 dark:text-white gap-5">
                                    <Avatar></Avatar>
                                    {{ reply.user.full_name }}
                                </p>
                            </div>
                        </footer>
                        <p class="text-gray-500 dark:text-gray-400">{{ reply.body }}</p>
                        <div class="flex items-center mt-4 space-x-4">
                            <Link  :class="reply.is_liked ? 'text-blue-500' : 'text-gray-400'" class="text-sm hover:underline" :href="route('comments.like', {comment: comment.id})" method="post" as="button" preserve-scroll>{{ reply.likes_count }} Likes</Link>

                            <small class="text-gray-400">{{ reply.diff_for_humans }}</small>
                        </div>
                    </article>
                </article>
        

                <div class="p-6 overflow-hidden shadow-sm sm:rounded-l mb-5" >
                    <div class="flex gap-5">
                        <Avatar class="shrink-0"></Avatar>

                        <div class="grow">
                            <form @submit.prevent="submit(post)">
                                <div class="flex gap-3">
                                    <input type="text" placeholder="Write your comment" class=" rounded-lg w-full bg-transparent text-white" name="" id=""  cols="30" rows="1" v-model="form.body" required>

                                    <PrimaryButton>Comment</PrimaryButton>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { Head, Link } from '@inertiajs/vue3';
import { PostItem, Avatar } from '@/Components'
import { useForm } from '@inertiajs/vue3';

defineProps({
    post: Object,
    comments: Object
})

const form = useForm({
    body: ''
});

const submit = (post) => {
    form.post(route('posts.comments.create', post.id), {
        onSuccess: () => form.reset('body'),
    });
};
</script>