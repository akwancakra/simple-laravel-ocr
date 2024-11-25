<script setup lang="ts">
import { Alert, AlertDescription, AlertTitle } from '@/Components/ui/alert';
import { Button } from '@/Components/ui/button';
import { Head } from '@inertiajs/vue3';
import { AlertCircle } from 'lucide-vue-next';
import { ref, onMounted, onUnmounted } from 'vue';

const imagePreviewUrl = ref<string | null>(null);
const selectedFile = ref<File | null>(null);
const ocrResult = ref('');
const error = ref('');
const scanning = ref(false);

const handleFileChange = (event: Event) => {
    const target = event.target as HTMLInputElement;
    if (target && target.files) {
        const file = target.files[0];

        if (file.size > 2 * 1024 * 1024) {
            error.value = 'File size must be less than 2MB';
            selectedFile.value = null;
            imagePreviewUrl.value = null;
            return;
        }

        selectedFile.value = file;

        if (imagePreviewUrl.value) {
            URL.revokeObjectURL(imagePreviewUrl.value);
        }

        imagePreviewUrl.value = URL.createObjectURL(selectedFile.value);
    }
    ocrResult.value = '';
    error.value = '';
};

const handlePaste = (event: ClipboardEvent) => {
    const items = event.clipboardData?.items;
    if (!items) return;

    for (let i = 0; i < items.length; i++) {
        if (items[i].type.indexOf('image') !== -1) {
            const file = items[i].getAsFile();
            if (file) {
                selectedFile.value = file;

                if (imagePreviewUrl.value) {
                    URL.revokeObjectURL(imagePreviewUrl.value);
                }

                imagePreviewUrl.value = URL.createObjectURL(file);
                ocrResult.value = '';
                error.value = '';
            }
        }
    }
};

const handleScan = async () => {
    if (!selectedFile.value) return;

    scanning.value = true;
    ocrResult.value = '';
    error.value = '';

    try {
        const formData = new FormData();
        formData.append('image', selectedFile.value);

        const response = await fetch('/api/ocr', {
            method: 'POST',
            body: formData,
        });

        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }

        const data = await response.json();
        ocrResult.value = data.text || 'No text detected';
    } catch (err) {
        if (err instanceof Error) {
            error.value = 'Error performing OCR: ' + err.message;
        } else {
            error.value = 'Error performing OCR';
        }
    } finally {
        scanning.value = false;
    }
};

onMounted(() => {
    window.addEventListener('paste', handlePaste);
});

onUnmounted(() => {
    window.removeEventListener('paste', handlePaste);
});
</script>


<template>

    <Head title="Text OCR" />
    <div class="min-h-screen bg-gray-100 flex items-center justify-center p-4">
        <div class="w-full max-w-md bg-white rounded-lg shadow-xl overflow-hidden">
            <div class="p-6">
                <div class="mb-6 text-center">
                    <h2 class="text-2xl font-bold text-gray-900">OCR Image Scanner</h2>
                    <p class="italic">by
                        <a href="https://github.com/akwancakra" target="_blank" class="text-violet-600">Akwan Cakra
                        </a>
                    </p>
                </div>

                <form @submit.prevent="handleScan" class="space-y-4">
                    <template v-if="error && error !== ''">
                        <Alert variant="destructive" class="col-span-2">
                            <AlertCircle class="w-4 h-4" />
                            <AlertTitle>Tolong perbaiki data berikut:</AlertTitle>
                            <AlertDescription>
                                <p>{{ error }}</p>
                            </AlertDescription>
                        </Alert>
                    </template>

                    <div>
                        <label for="image-upload" class="block text-sm font-medium text-gray-700 mb-2">
                            Upload Image or Paste from Clipboard
                        </label>
                        <input id="image-upload" type="file" accept="image/*" @change="handleFileChange"
                            class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-violet-50 file:text-violet-700 hover:file:bg-violet-100" />
                    </div>

                    <div v-if="imagePreviewUrl"
                        class="border border-neutral-300 dark:border-neutral-700 rounded-lg overflow-hidden">
                        <img :src="imagePreviewUrl" alt="Selected Image" class="w-full h-auto rounded-md" />
                    </div>

                    <Button type="submit" class="w-full" :disabled="!selectedFile">
                        Scan Image
                    </Button>
                </form>

                <div v-if="scanning" class="mt-6 text-center">
                    <div class="inline-block animate-spin rounded-full h-8 w-8 border-t-2 border-b-2 border-violet-600">
                    </div>
                    <p class="mt-2 text-sm text-gray-600">Scanning image...</p>
                </div>

                <div v-if="ocrResult" class="mt-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">OCR Result:</h3>
                    <div class="bg-gray-50 rounded-md p-3">
                        <p class="text-gray-700 whitespace-pre-wrap">{{ ocrResult }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
