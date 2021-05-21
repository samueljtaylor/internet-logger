<template>
    <div class="w-full bg-white shadow-lg">
        <div class="p-5 text-center text-gray-400" v-if="!items.data.length">
            No Items
        </div>
        <table class="w-full border-collapse hidden md:table" v-if="items.data.length">
            <tr>
                <th>ID</th>
                <th>Date</th>
                <th>Time</th>
                <th>Status</th>
                <th>Details</th>
            </tr>
            <tr v-for="(item, index) in items.data" :key="index" :class="index % 2 !== 0 ? 'bg-gray-50' : ''">
                <td>{{ item.id }}</td>
                <td>{{ $helpers.formatDate(item.created_at) }}</td>
                <td>{{ $helpers.formatTime(item.created_at) }}</td>
                <td class="">
                    <div class="bg-red-500 text-white tracking-wider text-center rounded-lg w-1/2 px-3 mx-auto" v-if="!item.up">Fail</div>
                    <div class="bg-green-500 text-white tracking-wider text-center rounded-lg w-1/2 px-3 mx-auto" v-if="item.up">Success</div>
                </td>
                <td>
                    <button type="button" class="button" @click="openModal(item)">Details</button>
                </td>
            </tr>
        </table>

        <div class="flex flex-col md:hidden w-full p-5 space-y-5" v-if="items.data.length">
            <div class="flex flex-col space-y-2 items-center pb-5 border-b border-gray-500" v-for="item in items.data">
                <div class="text-lg">
                    {{ $helpers.formatDate(item.created_at) }} at {{ $helpers.formatTime(item.created_at) }}
                </div>
                <div class="bg-red-500 text-white tracking-wider text-center rounded-lg w-1/2 px-3" v-if="!item.up">Fail</div>
                <div class="bg-green-500 text-white tracking-wider text-center rounded-lg w-1/2 px-3" v-if="item.up">Success</div>
                <div>
                    <button type="button" class="button" @click="openModal(item)">Details</button>
                </div>
            </div>
        </div>

        <div class="flex flex-row w-full justify-center px-5" v-if="items.links.length && items.data.length">
            <inertia-link class="p-4 hidden md:flex" v-for="link in items.links" :href="link.url || '#'" :active="link.active" v-html="link.label"/>

            <inertia-link class="p-4 md:hidden" :href="items.prev_page_url || '#'">&laquo; Previous</inertia-link>
            <dropdown class="md:hidden pt-1">
                <template #trigger>
                    <button type="button" class="inline-flex p-4 items-center border border-transparent leading-4 font-medium rounded-md bg-white hover:bg-gray-50 hover:text-gray-700 focus:outline-none focus:bg-gray-50 active:bg-gray-50 transition">
                        {{ items.current_page }}

                        <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 3a1 1 0 01.707.293l3 3a1 1 0 01-1.414 1.414L10 5.414 7.707 7.707a1 1 0 01-1.414-1.414l3-3A1 1 0 0110 3zm-3.707 9.293a1 1 0 011.414 0L10 14.586l2.293-2.293a1 1 0 011.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </button>
                </template>

                <template #content>
                    <div class="flex flex-col" v-for="link in items.links">
                        <inertia-link v-if="!isNaN(link.label)"
                                       as="a"
                                       :href="link.url || '#'"
                                       v-html="link.label"
                                       class="p-4"/>
                    </div>
                </template>
            </dropdown>

            <inertia-link class="p-4 md:hidden" :href="items.next_page_url || '#'">Next &raquo;</inertia-link>
        </div>

        <dialog-modal :show="showModal" @close="closeModal" max-width="7xl">
            <template #title>Item Details</template>

            <template #content>
                <pre>{{ selectedItem.output }}</pre>
            </template>

            <template #footer>
                <button type="button" class="button" @click="closeModal">Close</button>
            </template>
        </dialog-modal>
    </div>
</template>

<script>
import DialogModal from "@/Jetstream/DialogModal";
import {ref} from "vue";
import Dropdown from "@/Jetstream/Dropdown";
import DropdownLink from "@/Jetstream/DropdownLink";
export default {
    components: {DropdownLink, Dropdown, DialogModal},
    props: {
        items: Object
    },

    setup(props) {
        let showModal = ref(false);
        let selectedItem = ref(null);

        function openModal(item) {
            selectedItem.value = item;
            showModal.value = true;
        }

        function closeModal() {
            selectedItem.value = null;
            showModal.value = false;
        }

        return {
            showModal,
            selectedItem,
            openModal,
            closeModal,
        }
    }
}
</script>

<style scoped>
    td,th {
        @apply
        p-5
        border
        border-gray-300
        text-center
    }

    .button {
        @apply
        inline-flex
        items-center
        px-4
        py-2
        bg-gray-800
        border
        border-transparent
        rounded-md
        font-semibold
        text-xs
        text-white
        uppercase
        tracking-widest
        hover:bg-gray-700
        focus:outline-none
        focus:border-gray-900
        focus:ring
        focus:ring-gray-300
        disabled:opacity-25
        transition
    }
</style>
