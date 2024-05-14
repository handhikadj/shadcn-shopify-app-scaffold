<script setup>
import { cn } from "@/lib/shadcn/utils";

const props = defineProps({
    class: { type: null, required: false },
});
</script>

<template>
    <tr
        :class="
            cn(
                'border-b transition-colors',
                props.class
            )
        "
    >
        <slot />
    </tr>
</template>
