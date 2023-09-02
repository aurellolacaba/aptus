<template>
    <div :style="{backgroundImage: `url(${src})`}" class=" w-10 h-10 rounded-full bg-slate-400 bg-cover aspect-square object-cover"></div>
</template>

<script setup>

    defineProps({
        src: {
            type: String,
            required: true,
        },
    });

</script>