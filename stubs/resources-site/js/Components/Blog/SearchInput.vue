<template>
    <div class="relative bg-yellow-100">
        <div class="flex items-center align-middle">
            <div class="pointer-events-none absolute flex items-center pl-3">
                <i class="ri-search-line"></i>
            </div>
            <AppInputText
                id="post-search"
                v-model="searchTerm"
                placeholder="Search Posts..."
                name="search"
                class="py-2 pl-9"
                @keydown.enter="searchPosts"
            ></AppInputText>
        </div>
    </div>
</template>

<script setup>
import { ref } from 'vue'

const searchTerm = ref('')

const searchPosts = () => {
    if (searchTerm.value.length) {
        window.location.href = `/blog/search/${searchTerm.value}`
    }
}
</script>
