<template>
    <!-- Post Header -->
    <Link :href="route('posts.show', post.id)">
        <div class="flex gap-5 p-6"> 
            <Avatar class="shrink-0" :src="post.user.avatar"></Avatar>

            <div class="flex flex-col">
                <Link class=" text-gray-100 font-bold" :href="post.user.profile_url">{{ post.user.full_name }}</Link>
                <small class="text-gray-400">{{ post.diff_for_humans }}</small>
                   
            </div>
            
        </div>
        <div class=" text-gray-900 dark:text-gray-100 px-6">{{ post.body }}</div> 

        <template v-if="post.photos.length > 0">
            <img :style="{backgroundImage: `url(${photo.loading_photo})`}" class="bg-cover w-full aspect-square object-cover mt-6" style="" :src="photo.url" loading="lazy" v-for="photo in post.photos">
        </template>
        
        <div class="flex gap-3 p-6">
            <Link :class="post.is_liked ? 'text-blue-500' : 'text-gray-400'" :href="route('posts.like', {post: post.id})" method="post" as="button" preserve-scroll>{{ post.likes_count }} likes</Link>
            <button class="text-gray-400">{{ post.comments_count }} comments</button>
            <!-- <button class="text-gray-400">0 shares</button> -->
        </div>
    </Link>


    
</template>

<script setup>
import Avatar from './Avatar.vue';
import { Link } from '@inertiajs/vue3';

    defineProps({
        post: {
            type: Object,
            required: true,
        },
    });
</script>