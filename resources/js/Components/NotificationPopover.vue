<template>
    <Popover class="relative">
        <PopoverButton class="p-2 hover:bg-gray-700 rounded-full">
            <template v-if="$page.props.auth.unread_notification_count > 0">
                <span class="p-1 bg-red-500 rounded-full text-xs dark:text-white absolute top-0 -right-1 min-w-[20px]">
                    {{ $page.props.auth.unread_notification_count }}    
                </span>
            </template>
            
            <BellIcon class="h-6 w-6 text-gray-50"></BellIcon>
        </PopoverButton>

        <transition
            enter-active-class="transition duration-200 ease-out"
            enter-from-class="translate-y-1 opacity-0"
            enter-to-class="translate-y-0 opacity-100"
            leave-active-class="transition duration-150 ease-in"
            leave-from-class="translate-y-0 opacity-100"
            leave-to-class="translate-y-1 opacity-0"
        >
            <PopoverPanel class="absolute z-10 right-0">
                <div class="overflow-y-auto overscroll-contain shadow-lg rounded-md bg-white dark:bg-gray-700 max-h-[400px]">
                    <div class="relative flex flex-col w-[400px] space-y-5">
                        
                        <h1 class="dark:text-white text-lg font-bold mt-2 px-3">Notifications</h1>


                        <template v-if="$page.props.auth.notifications.length > 0">
                            <Link class=" hover:bg-gray-800 text-left" v-for="notification in $page.props.auth.notifications" 
                                :href="route('notifications.read', {notification: notification.id})"
                                method="post"
                                :data="{redirect_url: notification.data.post_url}"
                                as="button"
                            >
                                <div class="flex gap-3 p-3">
                                    <Avatar class="flex-shrink-0"></Avatar>
                                    <div>
                                        <template v-if="notification.read_at">
                                            <p class="dark:text-gray-400 line-clamp-2"><Link :href="notification.data.actor_url" class="font-bold">{{ notification.data.actor_fullname }}</Link> {{getHeader(notification.type)}} "{{ notification.data.post_body }}".</p>
                                        </template>
                                        <template v-else>
                                            <p class="dark:text-gray-50 line-clamp-2"><Link :href="notification.data.actor_url" class="font-bold">{{ notification.data.actor_fullname }}</Link> {{getHeader(notification.type)}} "{{ notification.data.post_body }}".</p>
                                        </template>
                                    </div>
                                </div>
                            </Link>
                        </template>
                        
                        <template v-else>
                            <div class="dark:text-white h-24 flex items-center justify-center">
                                <span>You have no notification.</span>
                            </div>
                        </template>
                        
                    </div>
                    <div class="flex items-center justify-center p-3">
                        <span class="dark:text-gray-100 text-sm font-bold">Mark all as read</span>
                    </div>
                </div>

            </PopoverPanel>
        </transition>
    </Popover>
    
</template>

<script setup>
import { Popover, PopoverButton, PopoverPanel } from '@headlessui/vue'
import { BellIcon } from '@heroicons/vue/24/solid'
import { Avatar } from '@/Components'
import { Link } from '@inertiajs/vue3';

const headerMap = {
    "App\\Notifications\\PostLiked": 'liked your post:',
    "App\\Notifications\\NewCommnentAdded": 'commented on your post:'
}

const getHeader = (notificationType) => {
    return headerMap[notificationType] || 'Invalid type'
}
</script>