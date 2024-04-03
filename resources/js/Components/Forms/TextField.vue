<template>
    <div>
        <label class="text-label block mb-1">{{ label }}</label>
        <input
            :id="id"
            v-model="modelValue"
            type="text"
            class="border border-gray-400 input-spacing w-full rounded-xl"
            :placeholder="placeholder"
        >
    </div>
</template>

<script setup>
defineProps({
    id: {
        type: String,
        required: true,
    },
    label: {
        type: String,
        required: true,
    },
    placeholder: {
        type: String,
        default: '',
    },
})

const modelValue = defineModel({
    type: [String, Number],
    required: true,
})
</script>



<style scoped>

</style>
