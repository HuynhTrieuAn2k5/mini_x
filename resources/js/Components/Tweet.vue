<script setup>
import { ref } from 'vue';
import { Link } from '@inertiajs/vue3';
import HeartOutline from 'vue-material-design-icons/HeartOutline.vue'
import ChartBar from 'vue-material-design-icons/ChartBar.vue'
import MessageOutline from 'vue-material-design-icons/MessageOutline.vue'
import Sync from 'vue-material-design-icons/Sync.vue'
import DotsHorizontal from 'vue-material-design-icons/DotsHorizontal.vue'
import TrashCanOutline from 'vue-material-design-icons/TrashCanOutline.vue'

// Nhận object tweet từ component cha truyền vào
defineProps({ tweet: Object });

// Trạng thái bật/tắt menu tùy chọn (xóa tweet)
let openOptions = ref(false);
</script>

<template>
    <div class="min-w-[60px]">
        <img class="rounded-full m-2 mt-3" width="50" :src="tweet.image">
    </div>
    <div class="p-2 w-full">
        <!-- Header bài viết: Tên tác giả, @handle và nút 3 chấm tùy chọn -->
        <div class="font-extrabold flex items-center justify-between mt-0.5 mb-1.5">
            <div class="flex items-center">
                <div>{{ tweet.name }}</div>
                <span class="font-[300] text-[15px] text-gray-500 pl-2">{{ tweet.handle }}</span>
            </div>

            <!-- Menu 3 chấm và nút xóa -->
            <div class="hover:bg-gray-800 rounded-full cursor-pointer relative">
                <button type="button" class="block p-2" @click="openOptions = !openOptions">
                    <DotsHorizontal />
                </button>
                <div v-if="openOptions" class="absolute mt-1 right-0 w-[200px] bg-black border border-gray-700 rounded-lg shadow-lg z-20">
                    <ul class="p-3">
                        <Link
                            as="button"
                            method="delete"
                            :href="route('tweets.destroy', { id: tweet.id })"
                            class="flex items-center cursor-pointer w-full"
                        >
                            <TrashCanOutline class="pr-3" fillColor="#DC2626" :size="18"/>
                            <span class="text-red-600 font-extrabold">Delete</span>
                        </Link>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Nội dung văn bản của Tweet -->
        <div class="pb-3 text-white break-words">{{ tweet.tweet }}</div>

        <!-- File đính kèm (ảnh hoặc video) -->
        <div v-if="tweet.file">
            <div v-if="!tweet.is_video" class="rounded-xl">
                <img :src="tweet.file" class="mt-2 object-fill rounded-xl w-full">
            </div>
            <div v-else>
                <video class="rounded-xl w-full" :src="tweet.file" controls></video>
            </div>
        </div>

        <!-- Thanh các nút tương tác (Bình luận, Retweet, Like, View) -->
        <div class="flex items-center justify-between mt-4 w-4/5">
            <div class="flex items-center">
                <MessageOutline fillColor="#5e5c5c" :size="18" />
                <span class="text-xs font-extrabold text-[#5e5c5c] ml-3">{{ tweet.comments }}</span>
            </div>
            <div class="flex items-center">
                <Sync fillColor="#5e5c5c" :size="18" />
                <span class="text-xs font-extrabold text-[#5e5c5c] ml-3">{{ tweet.retweets }}</span>
            </div>
            <div class="flex items-center">
                <HeartOutline fillColor="#5e5c5c" :size="18" />
                <span class="text-xs font-extrabold text-[#5e5c5c] ml-3">{{ tweet.likes }}</span>
            </div>
            <div class="flex items-center">
                <ChartBar fillColor="#5e5c5c" :size="18" />
                <span class="text-xs font-extrabold text-[#5e5c5c] ml-3">{{ tweet.analytics }}</span>
            </div>
        </div>
    </div>
</template>