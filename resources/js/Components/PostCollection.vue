<template>
    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-l mb-5" v-for="post in posts">
        <PostItem :post="post"></PostItem>
    </div>
    <div v-if="!canLoadMoreItems" class="text-gray-100 text-center">END OF RESULT</div>
    <div ref="landmark"></div>
</template>

<script setup>
    import { ref, onMounted } from 'vue';
    import PostItem from './PostItem.vue';
    import { useInfiniteScroll } from '@/Composables/useInfiniteScroll'

    const props = defineProps({
        posts: {
            type: Object,
            required: true,
        },
    });

    const landmark = ref(null)

    const { items:posts, loadMoreItems, canLoadMoreItems } = useInfiniteScroll('posts', landmark);

</script>