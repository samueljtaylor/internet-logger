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
                        <div class="text-xl">Total Tests</div>
                        <div class="text-sm text-gray-300 mt-5">Last Updated: {{ timeSinceLastTest }}</div>
                    </div>

                    <div class="widget bg-red-500 text-white">
                        <div class="text-4xl">{{ fails.length }}</div>
                        <div class="text-lg">Failed Tests</div>
                        <div class="text-sm text-gray-100 mt-5">Last Failure: {{ timeSinceLastFailure }}</div>
                    </div>
                </div>

                <list-table class="mt-20" :tests="tests"/>
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
            tests: Array,
        },

        components: {
            ListTable,
            DialogModal,
            AppLayout,
            Welcome,
        },

        setup(props) {
            let fails = computed(() => {
                return props.tests.filter(test => test.up === 0)
            });

            let timeSinceLastTest = computed(() => {
                if(props.tests.length > 0) {
                    return moment(props.tests[0].created_at).fromNow();
                }
                return 'No tests performed today'
            });

            let timeSinceLastFailure = computed(() => {
                if(fails.value > 0) {
                    return moment(fails.value[0].created_at).fromNow();
                }
                return 'No failures today'
            })

            return {
                fails,
                timeSinceLastTest,
                timeSinceLastFailure,
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
