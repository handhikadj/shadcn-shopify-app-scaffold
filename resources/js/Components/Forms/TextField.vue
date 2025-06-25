<template>
    <div
        :class="{
            'relative': type === 'password',
        }"
    >
        <label class="text-label block mb-1">{{ label }}<span
            v-if="required"
            class="text-red-600"
        >*</span></label>
        <input
            :id="id"
            v-model="modelValue"
            :type="inputType"
            class="border border-gray-400 input-spacing w-full rounded-xl"
            :placeholder="placeholder"
            :disabled="disabled"
            :class="inputClass"
        >

        <div
            v-if="type === 'password'"
            class="absolute top-[35px] right-0 flex items-center pr-3"
        >
            <button
                type="button"
                class="focus:outline-none"
                @click="showPassword = !showPassword"
            >
                <template v-if="!showPassword">
                    <EyeIcon class="h-5 w-5" />
                </template>
                <template v-else>
                    <EyeOffIcon class="h-5 w-5" />
                </template>
            </button>
        </div>
    </div>
</template>

<script setup>
import { computed, ref } from "vue";
import { EyeIcon, EyeOffIcon } from "lucide-vue-next";

const props = defineProps({
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
    type: {
        type: String,
        default: 'text',
    },
    disabled: {
        type: Boolean,
        default: false,
    },
    inputClass: {
        type: String,
        default: '',
    },
    required: {
        type: Boolean,
        default: false,
    },
})

const modelValue = defineModel({
    type: [String, Number],
    required: true,
})

const showPassword = ref(false)

const inputType = computed(() => {
    if (props.type !== 'password') return props.type

    return showPassword.value ? 'text' : 'password'
})
</script>
