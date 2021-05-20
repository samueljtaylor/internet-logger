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
                        <div class="text-4xl">{{ tests.total }}</div>
                        <div class="text-xl">Tests Today</div>
                        <div class="text-sm text-gray-300 mt-5">Last Updated: {{ timeSinceLastTest }}</div>
                    </div>

                    <div class="widget bg-red-500 text-white">
                        <div class="text-4xl">{{ failedTests.total }}</div>
                        <div class="text-lg">Failed Tests</div>
                        <div class="text-sm text-gray-100 mt-5">Last Failure: {{ lastFailure }}</div>
                    </div>
                </div>

                <div class="text-2xl mt-20 mb-5">Today's Failed Tests</div>
                <list-table :items="failedTests.data" :pagination-links="tests.links"/>
            </div>
        </div>
    </app-layout>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout'
    import Welcome from '@/Jetstream/Welcome'
    import {computed, ref} from "vue";
    import moment from 'moment';
    import DialogModal from "@/Jetstream/DialogModal";
    import ListTable from "@/Components/ListTable";

    export default {
        props: {
            tests: Object,
            failedTests: Object,
        },

        components: {
            ListTable,
            DialogModal,
            AppLayout,
            Welcome,
        },

        setup(props) {
            let timeSinceLastTest = computed(() => {
                if(props.tests.data.length > 0) {
                    return moment(props.tests.data[0].created_at).fromNow();
                }
                return 'No tests today'
            });

            let lastFailure = computed(() => {
                if(props.failedTests.data.length > 0) {
                    return moment(props.failedTests.data[0].created_at).format('h:mm a');
                }
                return 'No failures today'
            })

            return {
                timeSinceLastTest,
                lastFailure,
            }
        },
    }
</script>

<style scoped>
    .widget {
        @apply
        shadow-lg
        pt-10
        px-10
        pb-3
        flex-1
        flex
        flex-col
        text-center
    }
</style>
