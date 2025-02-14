<template>
    <div class="mb-4 flex flex-col h-full">
        <label :for="id" class="block font-semibold mb-1">
            {{ label }}
        </label>

        <!-- Quill Editor Container -->
        <div ref="editorRef" class="quill-container border rounded border-gray-300 flex-grow"></div>

        <!-- Error Display -->
        <p v-if="hasError" class="text-red-600 text-sm mt-1">
            {{ firstError }}
        </p>
    </div>
</template>

<script setup>
import { ref, onMounted, watch, computed } from 'vue';
import Quill from 'quill';
import 'quill/dist/quill.snow.css';

const props = defineProps({
    label: { type: String, default: '' },
    id: { type: String, default: '' },
    modelValue: { type: String, default: '' },
    error: { type: [String, Array], default: '' },
    required: { type: Boolean, default: false },
});

const emits = defineEmits(['update:modelValue']);

const editorRef = ref(null);
let quillInstance = null;

const hasError = computed(() => {
    return Array.isArray(props.error) ? props.error.length > 0 : !!props.error;
});

const firstError = computed(() => {
    return Array.isArray(props.error) ? props.error[0] : props.error;
});

onMounted(() => {
    if (!editorRef.value) return;

    quillInstance = new Quill(editorRef.value, {
        theme: 'snow',
        modules: {
            toolbar: [
                ['bold', 'italic', 'underline', 'strike'],
                ['link'],
                [{ list: 'ordered' }, { list: 'bullet' }],
                ['clean'],
            ],
        },
    });

    quillInstance.root.innerHTML = props.modelValue || '';

    quillInstance.on('text-change', () => {
        const html = quillInstance.root.innerHTML;
        emits('update:modelValue', html);
    });
});

watch(
    () => props.modelValue,
    (newVal) => {
        if (quillInstance && quillInstance.root.innerHTML !== newVal) {
            quillInstance.root.innerHTML = newVal || '';
        }
    }
);
</script>

<style>
/* Fix: Make .ql-editor take full height of the parent */
.quill-container {
    min-height: 100%;
    display: flex;
    flex-direction: column;
}

.ql-container {
    flex-grow: 1;
    min-height: 100%;
    display: flex;
    flex-direction: column;
}

.ql-editor {
    flex-grow: 1;
    min-height: 100%;
}
</style>
