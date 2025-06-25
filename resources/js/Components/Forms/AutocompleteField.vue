<template>
    <Popover v-model:open="open">
        <PopoverTrigger as-child>
            <Button
                variant="outline"
                role="combobox"
                :aria-expanded="open"
                class="w-full justify-between border-gray-400 h-fit"
            >
                <template v-if="$slots['selected-value']">
                    <slot
                        v-if="modelValue"
                        name="selected-value"
                        :option="options.find((option) => option.value === modelValue)"
                    />
                    <span v-else>{{ placeholder }}</span>
                </template>
                <div v-else>
                    {{ modelValue ? options.find((option) => option.value === modelValue)?.label : placeholder }}
                </div>

                <ChevronsUpDown class="ml-2 h-4 w-4 shrink-0 opacity-50" />
            </Button>
        </PopoverTrigger>
        <PopoverContent class="w-[--radix-popover-trigger-width] p-0">
            <Command>
                <CommandInput
                    v-model="commandInputVModel"
                    placeholder="Search..."
                    v-bind="commandInputProps"
                />
                <CommandEmpty>
                    <div
                        v-if="loading"
                        class="w-full flex items-center justify-center"
                    >
                        <Loader2Icon
                            class="animate-spin w-8 h-8"
                        />
                    </div>
                    <div v-else>
                        No data found.
                    </div>
                </CommandEmpty>
                <CommandList v-if="!loading">
                    <CommandGroup>
                        <CommandItem
                            v-for="option in options"
                            :key="option.value"
                            :value="option.label"
                            class="cursor-pointer"
                            @select="(ev) => {
                                const currentValue = ev.detail.value
                                if (typeof currentValue === 'string') {
                                    modelValue = options.find(
                                        (option) => option.label === currentValue
                                    )?.value
                                }
                                open = false
                            }"
                        >
                            <Check
                                :class="cn(
                                    'mr-2 h-4 w-4',
                                    modelValue === option.value ? 'opacity-100' : 'opacity-0',
                                )"
                            />

                            <template v-if="$slots.label">
                                <slot
                                    name="label"
                                    :option="option"
                                />
                            </template>
                            <template v-else>
                                {{ option.label }}
                            </template>
                        </CommandItem>

                        <slot name="bottom-list" />
                    </CommandGroup>
                </CommandList>
            </Command>
        </PopoverContent>
    </Popover>
</template>

<script setup>
import Button from "@/Components/Shadcn/ui/button/Button.vue";
import { ChevronsUpDown, Check } from "lucide-vue-next";
import Command from "@/Components/Shadcn/ui/command/Command.vue";
import CommandInput from "@/Components/Shadcn/ui/command/CommandInput.vue";
import CommandEmpty from "@/Components/Shadcn/ui/command/CommandEmpty.vue";
import CommandList from "@/Components/Shadcn/ui/command/CommandList.vue";
import CommandGroup from "@/Components/Shadcn/ui/command/CommandGroup.vue";
import CommandItem from "@/Components/Shadcn/ui/command/CommandItem.vue";
import { Loader2Icon } from "lucide-vue-next";

import { cn } from "@/Helpers/Shadcn";
import { ref } from "vue";
import Popover from "@/Components/Shadcn/ui/popover/Popover.vue";
import PopoverTrigger from "@/Components/Shadcn/ui/popover/PopoverTrigger.vue";
import PopoverContent from "@/Components/Shadcn/ui/popover/PopoverContent.vue";

const modelValue = defineModel({
    type: [String, Number],
    required: true,
})

const commandInputVModel = defineModel('commandInput', {
    type: String,
    required: false,
})

const props = defineProps({
    options: {
        type: Array,
        required: true,
    },
    placeholder: {
        type: String,
        default: '---Please select---',
    },
    commandInputProps: {
        type: Object,
        default: () => ({}),
    },
    loading: {
        type: Boolean,
        default: false,
    },
})

const open = ref(false)
</script>
