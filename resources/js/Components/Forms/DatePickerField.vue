<template>
    <Popover>
        <PopoverTrigger as-child>
            <Button
                variant="outline"
                :class="cn(
                    'w-[280px] justify-start text-left font-normal',
                )"
            >
                <CalendarIcon class="mr-2 h-4 w-4" />
                {{ modelValue ? dayjs(modelValue).format('DD/MM/YYYY') : placeholder }}
            </Button>
        </PopoverTrigger>
        <PopoverContent class="w-auto p-0">
            <Calendar
                v-model="modelValue"
                v-bind="calendarProps"
            />
        </PopoverContent>
    </Popover>
</template>

<script setup>
import Button from "@/Components/Shadcn/ui/button/Button.vue";
import Popover from "@/Components/Shadcn/ui/popover/Popover.vue";
import PopoverTrigger from "@/Components/Shadcn/ui/popover/PopoverTrigger.vue";
import { cn } from "@/lib/shadcn/utils.js";
import PopoverContent from "@/Components/Shadcn/ui/popover/PopoverContent.vue";
import { Calendar as CalendarIcon } from 'lucide-vue-next'
import { Calendar } from "@/Components/Shadcn/ui/v-calendar";
import dayjs from "dayjs";

const modelValue = defineModel({
    type: [String, Date],
    required: true,
})

defineProps({
    placeholder: {
        type: String,
        default: 'Please select a date',
    },
    calendarProps: {
        type: Object,
        default: () => ({}),
    },
})
</script>
