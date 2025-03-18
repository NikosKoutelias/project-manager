<template>
    <TransitionRoot as="template" :show="open">
        <Dialog class="relative z-10" @close="open = false">
            <TransitionChild as="template" enter="ease-out duration-300" enter-from="opacity-0" enter-to="opacity-100"
                             leave="ease-in duration-200" leave-from="opacity-100" leave-to="opacity-0">
                <div class="fixed inset-0 bg-gray-500/75 transition-opacity"/>
            </TransitionChild>

            <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
                <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                    <TransitionChild as="template" enter="ease-out duration-300"
                                     enter-from="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                                     enter-to="opacity-100 translate-y-0 sm:scale-100" leave="ease-in duration-200"
                                     leave-from="opacity-100 translate-y-0 sm:scale-100"
                                     leave-to="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
                        <DialogPanel
                            class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-2xl">
                            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                <div class="sm:flex sm:items-start">
                                    <div
                                        class="mx-auto flex size-12 shrink-0 items-center justify-center rounded-full bg-green-50 sm:mx-0 sm:size-10">
                                        <CubeIcon class="size-6 text-green-500" aria-hidden="true"/>
                                    </div>
                                    <div class="mt-3 text-center w-full sm:mt-0 sm:ml-4 sm:text-left">
                                        <DialogTitle as="h3" class="text-center font-semibold text-gray-900">Create
                                            {{ props.label }}
                                        </DialogTitle>
                                        <hr class="border-t border-gray-200" />
                                        <div class="mt-2">
                                            <form>
                                                <div class="space-y-12">
                                                    <div class="border-b border-gray-900/10 pb-12">
                                                        <div
                                                            class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                                                            <div class="sm:col-span-4">
                                                                <label for="name"
                                                                       class="block text-sm/6 font-medium text-gray-900">Name</label>
                                                                <div class="mt-2">
                                                                    <div
                                                                        class="flex items-center rounded-md bg-white pl-3 outline-1 -outline-offset-1 outline-gray-300 focus-within:outline-2 focus-within:-outline-offset-2 focus-within:outline-indigo-600">
                                                                        <input type="text" name="name" id="name"
                                                                               class="block min-w-0 grow py-1.5 pr-3 pl-1 text-base text-gray-900 placeholder:text-gray-400 focus:outline-none sm:text-sm/6"
                                                                               placeholder="Awesome company Inc."/>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-span-full">
                                                                <label for="about"
                                                                       class="block text-sm/6 font-medium text-gray-900">Description</label>
                                                                <div class="mt-2">
                                                                    <textarea name="description" id="description" rows="3"
                                                                              class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6"/>
                                                                </div>
                                                                <p class="my-3 text-sm/6 text-gray-500">Description of {{props.label}}.</p>
                                                            </div>
                                                        </div>
                                                        <div class="sm:col-span-2 sm:col-start-1">
                                                            <label for="city"
                                                                   class="block text-sm/6 font-medium text-gray-900">City</label>
                                                            <div class="mt-2">
                                                                <input type="text" name="city" id="city"
                                                                       autocomplete="address-level2"
                                                                       class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6"/>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                                <button type="button"
                                        class="inline-flex w-full justify-center rounded-md bg-indigo-400 px-3 py-2 text-sm font-semibold text-white shadow-xs hover:bg-indigo-500 sm:ml-3 sm:w-auto transition duration-300 ease-in-out"
                                        @click="open = false">Create
                                </button>
                                <button type="button"
                                        class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 ring-1 shadow-xs ring-gray-300 ring-inset hover:bg-gray-100 transition duration-300 ease-in-out sm:mt-0 sm:w-auto"
                                        @click="open = false" ref="cancelButtonRef">Cancel
                                </button>
                            </div>
                        </DialogPanel>
                    </TransitionChild>
                </div>
            </div>
        </Dialog>
    </TransitionRoot>
</template>

<script setup>
import {ref} from 'vue'
import {Dialog, DialogPanel, DialogTitle, TransitionChild, TransitionRoot} from '@headlessui/vue'
import {ChevronDownIcon} from '@heroicons/vue/16/solid'
import {CubeIcon} from '@heroicons/vue/24/outline'

const open = ref(true)
const props = defineProps({label: String});

</script>
