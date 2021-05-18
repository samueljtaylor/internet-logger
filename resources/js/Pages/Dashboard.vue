<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
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
            </div>
        </div>
    </app-layout>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout'
    import Welcome from '@/Jetstream/Welcome'
    import {computed} from "vue";

    export default {
        props: {
            tests: Array,
        },

        components: {
            AppLayout,
            Welcome,
        },

        setup(props) {
            let fails = computed(() => {
                return props.tests.filter(test => test.up === 0)
            });

            return {
                fails,
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
</style>
