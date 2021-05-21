<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ title }}
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 flex flex-col">
                <list-table :items="tests.data" :pagination-links="tests.links"/>
            </div>
        </div>
    </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout";
import ListTable from "@/Components/ListTable";
export default {
    components: {ListTable, AppLayout},
    props: {
        tests: Object,
        title: {type: String, default: 'All Tests'},
    },

    setup(props) {

    },
}
</script>

<style scoped>

</style>
