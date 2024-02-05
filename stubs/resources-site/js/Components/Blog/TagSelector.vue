<template>
    <div class="bg-skin-neutral-1 relative">
        <AppCombobox
            v-model="selectedTagOption"
            :options="tagOptions"
            :use-search="false"
            combo-label="Tags"
            class="!absolute !z-50 w-full"
        />
    </div>
</template>

<script setup>
import { onMounted, ref, watch } from 'vue'

const props = defineProps({
    tags: {
        type: Array,
        default: () => []
    }
})

const tagOptions = ref([])

onMounted(() => {
    props.tags.forEach((tag) => {
        tagOptions.value.push({
            value: tag.slug,
            label: tag.name
        })
    })
})

const selectedTagOption = ref(null)

watch(selectedTagOption, (value) => {
    if (value && value.value) {
        window.location.href = `/blog/tag/${value.value}`
    }
})
</script>
