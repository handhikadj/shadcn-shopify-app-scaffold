<template>
    <div
        :class="[inline ? 'flex items-center' : '']"
    >
        <label
            :for="id"
            class="text-label whitespace-pre"
            :class="[!inline ? 'mb-1' : '']"
        >
            {{ label }}
        </label>
        <select
            :id="id"
            v-model="modelValue"
            class="text-sm py-2 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2"
        >
            <option
                v-for="(option, index) in options"
                :key="index"
                :value="option.value"
            >
                {{ option.label }}
            </option>
        </select>
    </div>
</template>

<script setup>
defineProps({
    id: {
        type: String,
        required: true
    },
    label: {
        type: String,
        required: true
    },
    options: {
        type: Array,
        required: true
    },
    inline: {
        type: Boolean,
        default: false
    }
})

const modelValue = defineModel({
    type: String,
    required: true
})
</script>
