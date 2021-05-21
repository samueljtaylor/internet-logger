<template>
    <div class="w-full bg-white shadow-lg">
        <div class="p-5 text-center text-gray-400" v-if="!items.length">
            No Items
        </div>
        <table class="table w-full border-collapse hidden md:flex" v-if="items.length">
            <tr>
                <th>ID</th>
                <th>Date</th>
                <th>Status</th>
                <th>Details</th>
            </tr>
            <tr v-for="(item, index) in items" :key="index" :class="index % 2 !== 0 ? 'bg-gray-50' : ''">
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

        <div class="flex flex-col md:hidden w-full p-5 space-y-5" v-if="items.length">
            <div class="flex flex-col space-y-2 items-center pb-5 border-b border-gray-500" v-for="item in items">
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

        <div class="flex flex-row w-full justify-center px-5 max-w-full" v-if="paginationLinks.length && items.length">
            <inertia-link class="p-4" v-for="link in paginationLinks" :href="link.url || '#'" :active="link.active" v-html="link.label"></inertia-link>
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
export default {
    components: {DialogModal},
    props: {
        items: Array,
        paginationLinks: {type: Array, default: []},
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
