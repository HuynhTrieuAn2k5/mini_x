<script setup>
import { Head } from '@inertiajs/vue3';
import Tweet from '@/Components/Tweet.vue';
import TwitterLayout from '@/Layouts/TwitterLayout.vue';

// Nhận danh sách tweets được truyền từ TweetController@index
defineProps({ tweets: Array });
</script>

<template>
    <Head title="Twitter" />

    <TwitterLayout>
        <div class="text-white">
            <!-- Lặp qua danh sách các Tweet lấy từ database -->
            <div class="flex border-b border-gray-800 hover:bg-gray-900 transition" v-for="tweet in tweets" :key="tweet.id">
                <Tweet :tweet="tweet"/>
            </div>
        </div>
    </TwitterLayout>
</template>

<style>
body {
    background-color: black;
}
</style>