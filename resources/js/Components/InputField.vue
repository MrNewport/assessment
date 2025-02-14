<template>
    <div class="mb-4">
        <label :for="id" class="block font-semibold mb-1">
            {{ label }}
        </label>
        <div class="relative">
            <input
                :id="id"
                :type="type"
                :placeholder="placeholder"
                :value="modelValue"
                @input="$emit('update:modelValue', $event.target.value)"
                class="w-full px-3 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500 border-gray-300"
            />
            <span v-if="!required" class="absolute right-3 top-2 text-gray-400 text-sm">
                (Optional)
              </span>
        </div>

        <!-- Display error if present -->
        <p v-if="hasError" class="text-red-600 text-sm mt-1">
            {{ firstError }}
        </p>
    </div>
</template>

<script setup>
import {computed} from 'vue';

/**
 * Props definition
 */
const props = defineProps({
    label: {type: String, default: ''},
    id: {type: String, default: ''},
    modelValue: {type: String, default: ''},
    error: {type: [String, Array], default: ''},
    placeholder: {type: String, default: ''},
    type: {type: String, default: 'text'},
    required: {type: Boolean, default: false},
});

/**
 * If `error` is an array from Laravel (e.g. ["The field is required."]),
 * get the first string. Otherwise, treat `error` as a plain string.
 */
const hasError = computed(() => {
    return Array.isArray(props.error)
        ? props.error.length > 0
        : !!props.error;
});

const firstError = computed(() => {
    if (Array.isArray(props.error)) {
        return props.error[0];
    }
    return props.error;
});
</script>
