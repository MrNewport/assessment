<template>
    <div v-if="form" class="flex flex-col min-h-screen font-sans text-gray-800">
        <div class="flex flex-grow">

            <!-- Left Column: Form (Always Present, Content Changes) -->
            <div class="w-1/2 bg-gray-50 p-8 flex flex-col">
                <h1 class="text-2xl font-bold mb-6">ePostCard.tech</h1>

                <!-- Form Fields on Front, Image Upload on Back -->
                <div v-if="!isBack">
                    <InputField label="Recipient Name" id="recipient" v-model="form.recipient" :error="serverErrors.recipient" :required="true" />
                    <InputField label="Street 1" id="street1" v-model="form.street1" :error="serverErrors.street1" :required="true" />
                    <InputField label="Street 2" id="street2" v-model="form.street2" :error="serverErrors.street2" :required="false" placeholder="Optional" />

                    <div class="grid grid-cols-3 gap-4">
                        <InputField label="City" id="city" v-model="form.city" :error="serverErrors.city" :required="true" />
                        <InputField label="State" id="state" v-model="form.state" :error="serverErrors.state" :required="true" />
                        <InputField label="Zip Code" id="zip" v-model="form.zip" :error="serverErrors.zip" :required="true" />
                    </div>

                    <WysiwygEditor label="Postcard Message" id="message" v-model="form.message" :error="serverErrors.message" :required="true" />
                </div>

                <!-- Image Upload on Back -->
                <div v-else>
                    <label class="block font-semibold mb-2">Upload Background Image</label>
                    <input type="file" @change="handleImageUpload" accept="image/*" class="mb-4" />
                    <p v-if="serverErrors.image" class="text-red-600 text-sm mt-1">{{ serverErrors.image }}</p>
                </div>
            </div>

            <!-- Right Column: Postcard Preview -->
            <div class="w-1/2 bg-blue-300 p-8 flex flex-col items-center relative">
                <h2 class="text-xl font-bold text-white mb-4">Preview</h2>

                <div class="aspect-[3/2] w-full max-w-lg p-4 shadow-md relative flex border bg-white"
                     :style="{ backgroundImage: isBack ? `url(${uploadedImage})` : 'none', backgroundSize: 'cover' }">

                    <template v-if="!isBack">
                        <div class="w-1/2 p-2 text-sm text-gray-700 break-words whitespace-pre-line">
                            <div v-html="form.message"></div>
                        </div>
                        <div class="w-[1px] bg-gray-400"></div>
                        <div class="w-1/2 p-2 flex flex-col text-gray-800 text-sm">
                            <p class="font-semibold">{{ form.recipient || 'Recipient Name' }}</p>
                            <p>{{ form.street1 || 'Street Address' }}</p>
                            <p v-if="form.street2">{{ form.street2 }}</p>
                            <p>{{ form.city || 'City' }}, {{ form.state || 'ST' }} {{ form.zip || '00000' }}</p>

                            <div class="absolute top-2 right-2 w-12 h-12 border border-gray-300 bg-gray-100">
                                <span class="block text-xs text-gray-500 text-center mt-4">STAMP</span>
                            </div>
                        </div>
                    </template>

                    <div v-else class="h-full w-full flex items-center justify-center text-white font-bold">
                        {{ uploadedImage ? '' : 'No Image Uploaded' }}
                    </div>
                </div>

                <div class="mt-4">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <span class="text-sm font-semibold">Front</span>
                        <input type="checkbox" class="sr-only peer" v-model="isBack" />
                        <div class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-blue-400 rounded-full peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-1 after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                        <span class="text-sm font-semibold">Back</span>
                    </label>
                </div>
            </div>
        </div>

        <div class="bg-gray-100 p-4 flex justify-end gap-2">
            <button class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md font-semibold" @click.prevent="handleSave"> Save </button>
            <button class="border border-blue-500 text-blue-500 px-4 py-2 rounded-md font-semibold hover:bg-blue-50" @click.prevent="handleCopyLink"> Copy Link </button>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted, watch, nextTick } from 'vue';
import { useRoute } from 'vue-router';
import InputField from './InputField.vue';
import WysiwygEditor from './WysiwygEditor.vue';

const route = useRoute();
const cardId = ref(route.params.id || null);
const isBack = ref(false);

const form = ref({
    recipient: '',
    street1: '',
    street2: '',
    city: '',
    state: '',
    zip: '',
    message: '',
    image: null,
});
const serverErrors = ref({});
const uploadedImage = ref(null);
const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

async function fetchCard() {
    if (!cardId.value) return;

    try {
        const response = await fetch(`/api/cards/${cardId.value}`);
        if (!response.ok) throw new Error('Failed to fetch card');

        const data = await response.json();
        await nextTick();
        form.value = { ...data.data };
        if (data.image) uploadedImage.value = data.image;
    } catch (error) {
        console.error('Error fetching card:', error);
    }
}

async function handleSave() {
    const formData = new FormData();
    formData.append('_token', csrfToken);
    Object.entries(form.value).forEach(([key, value]) => {
        if (value) formData.append(key, value);
    });

    try {
        const response = await fetch(cardId.value ? `/api/cards/${cardId.value}` : '/api/cards', {
            method: cardId.value ? 'PUT' : 'POST',
            headers: { 'Accept': 'application/json' },
            body: formData,
        });

        if (!response.ok) {
            const data = await response.json();
            serverErrors.value = data.errors || {};
        } else {
            window.alert('Card saved successfully!');
        }
    } catch (error) {
        console.error('Fetch error:', error);
    }
}

function handleImageUpload(event) {
    const file = event.target.files[0];
    if (file) {
        form.value.image = file;
        const reader = new FileReader();
        reader.onload = () => uploadedImage.value = reader.result;
        reader.readAsDataURL(file);
    }
}

function handleCopyLink() {
    const link = `${window.location.origin}/cards/${cardId.value}`;
    window.navigator.clipboard.writeText(link).then(() => window.alert('Link copied to clipboard!'));
}

onMounted(() => { if (cardId.value) fetchCard(); });
watch(() => route.params.id, (newId) => { cardId.value = newId; newId ? fetchCard() : Object.assign(form.value, {}); });
</script>
