<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 flex flex-col">
                <div class="flex flex-col md:flex-row md:space-x-20">
                    <div class="widget bg-gray-700 text-white">
                        <div class="text-4xl">{{ tests.length }}</div>
                        <div class="text-lg">Total Tests</div>
                    </div>

                    <div class="widget bg-red-500 text-white">
                        <div class="text-4xl">{{ fails.length }}</div>
                        <div class="text-lg">Failed Tests</div>
                    </div>
                </div>

                <div class="w-full mt-32 bg-white shadow-lg">
                    <table class="table w-full border-collapse">
                        <tr>
                            <th>ID</th>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Status</th>
                            <th>Details</th>
                        </tr>
                        <tr v-for="(test, index) in tests" :key="index" :class="index % 2 !== 0 ? 'bg-gray-50' : ''">
                            <td>{{ test.id }}</td>
                            <td>{{ formatDate(test.created_at) }}</td>
                            <td>{{ formatTime(test.created_at) }}</td>
                            <td class="">
                                <div class="bg-red-500 text-white tracking-wider text-center rounded-lg w-1/2 px-3 mx-auto" v-if="!test.up">Fail</div>
                                <div class="bg-green-500 text-white tracking-wider text-center rounded-lg w-1/2 px-3 mx-auto" v-if="test.up">Success</div>
                            </td>
                            <td>
                                <button type="button" class="button" @click="showDetail(test)">Details</button>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <dialog-modal :show="showDetails" @close="showDetails = false" max-width="7xl">
            <template #title>Test Details</template>

            <template #content>
                <pre>{{ selectedTest.output }}</pre>
            </template>

            <template #footer>
                <button type="button" class="button" @click="showDetails = false">Close</button>
            </template>
        </dialog-modal>
    </app-layout>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout'
    import Welcome from '@/Jetstream/Welcome'
    import {computed, ref} from "vue";
    import moment from 'moment';
    import DialogModal from "@/Jetstream/DialogModal";

    export default {
        props: {
            tests: Array,
        },

        components: {
            DialogModal,
            AppLayout,
            Welcome,
        },

        setup(props) {
            let fails = computed(() => {
                return props.tests.filter(test => test.up === 0)
            });

            let showDetails = ref(false);

            let selectedTest = ref({});

            function formatTime(date) {
                return moment(date).format('h:mm a')
            }

            function formatDate(date) {
                return moment(date).format('MMMM Do YYYY')
            }

            function showDetail(test) {
                selectedTest.value = test;
                showDetails.value = true;
            }

            return {
                fails,
                showDetails,
                selectedTest,
                formatTime,
                formatDate,
                showDetail
            }
        },
    }
</script>

<style scoped>
    .widget {
        @apply
        shadow-lg
        p-10
        flex-1
        flex
        flex-col
    }

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
