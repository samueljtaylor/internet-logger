<template>
    <div class="w-full bg-white shadow-lg">
        <div class="p-5 text-center text-gray-400" v-if="!tests.length">
            No Tests
        </div>
        <table class="table w-full border-collapse" v-if="tests.length">
            <tr>
                <th>ID</th>
                <th>Date</th>
                <th>Time</th>
                <th>Status</th>
                <th>Details</th>
            </tr>
            <tr v-for="(test, index) in tests" :key="index" :class="index % 2 !== 0 ? 'bg-gray-50' : ''">
                <td>{{ test.id }}</td>
                <td>{{ $helpers.formatDate(test.created_at) }}</td>
                <td>{{ $helpers.formatTime(test.created_at) }}</td>
                <td class="">
                    <div class="bg-red-500 text-white tracking-wider text-center rounded-lg w-1/2 px-3 mx-auto" v-if="!test.up">Fail</div>
                    <div class="bg-green-500 text-white tracking-wider text-center rounded-lg w-1/2 px-3 mx-auto" v-if="test.up">Success</div>
                </td>
                <td>
                    <button type="button" class="button" @click="openModal(test)">Details</button>
                </td>
            </tr>
        </table>
        <dialog-modal :show="showModal" @close="closeModal" max-width="7xl">
            <template #title>Test Details</template>

            <template #content>
                <pre>{{ selectedTest.output }}</pre>
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
        tests: Array,
    },

    setup(props) {
        let showModal = ref(false);
        let selectedTest = ref(null);

        function openModal(test) {
            selectedTest.value = test;
            showModal.value = true;
        }

        function closeModal() {
            selectedTest.value = null;
            showModal.value = false;
        }

        return {
            showModal,
            selectedTest,
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
