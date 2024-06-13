<template>
    <div>
        <label
            :for="id"
            class="text-label mb-1 block"
        >
            {{ label }}
        </label>
        <select
            :id="id"
            v-model="modelValue"
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
    }
})

const modelValue = defineModel({
    type: String,
    required: true
})
</script>
