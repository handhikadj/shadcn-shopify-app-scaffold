<template>
    <Popover>
        <PopoverTrigger as-child>
            <Button
                variant="outline"
                :class="cn(
                    'justify-start text-left font-normal border-gray-400 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2',
                    props.class
                )"
            >
                <CalendarIcon class="mr-2 h-4 w-4" />
                <span v-if="modelValue">{{ dayjs(modelValue).format(format) }}</span>
                <span
                    v-else
                    class="text-gray-500/60"
                >{{ placeholder }}</span>
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

const props = defineProps({
    placeholder: {
        type: String,
        default: 'Please select a date',
    },
    calendarProps: {
        type: Object,
        default: () => ({}),
    },
    format: {
        type: String,
        default: 'DD/MM/YYYY',
    },
    class: {
        type: String,
        default: '',
    }
})
</script>
