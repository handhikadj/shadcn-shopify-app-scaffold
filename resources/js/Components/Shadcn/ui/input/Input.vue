<script setup>
import { useVModel } from "@vueuse/core";
import { cn } from "@/lib/shadcn/utils";
import { ref } from "vue";

const props = defineProps({
    defaultValue: { type: [String, Number], required: false },
    modelValue: { type: [String, Number], required: false },
    class: { type: null, required: false },
});

const emits = defineEmits(["update:modelValue"]);

const modelValue = useVModel(props, "modelValue", emits, {
    passive: true,
    defaultValue: props.defaultValue,
});

const inputRef = ref(null);

defineExpose({
    inputRef,
})
</script>

<template>
    <input
        ref="inputRef"
        v-model="modelValue"
        :class="
            cn(
                'border-gray-400 rounded flex w-full border bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50',
                props.class,
            )
        "
    >
</template>
