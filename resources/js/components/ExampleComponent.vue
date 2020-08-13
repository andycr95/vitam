<template>
    <nav class="navbar navbar-light align-items-start sidebar sidebar-light bg-light" style="width: 400px !important; padding: 0%">
        <div class="container-fluid d-flex flex-column p-0">
            <div class="search-container bg-primary"></div>
            <ul class="list-group" >
                <li v-for="item in markers" :key="item.id" class="list-group-item d-flex justify-content-between align-items-center">
                    <label @click="onCenter(item)" >{{ item.title }}</label>
                    <i class="fas fa-ellipsis-v"></i>
                </li>
            </ul>
        </div>
    </nav>
</template>
<style scoped>
    .list-group{
        width: 100%;
        margin-top: 5px;
    }
</style>
<script>
    export default {
        props: ['markers','onCenter'],
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
