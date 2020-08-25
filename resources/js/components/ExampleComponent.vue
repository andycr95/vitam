<template>
    <nav class="navbar navbar-light align-items-start sidebar sidebar-light bg-light" style="width: 100% !important; padding: 0%">
        <div class="container-fluid d-flex flex-column p-0">
            <div class="search-container bg-primary">
                <div style="height: 40px; width: 100%">
                    <span class="actions">
                        <ul style="margin-bottom: 0; margin-right:5px">
                            <li style="float: left;margin-top: 5px;">
                               Vitam GPS
                            </li>
                            <li>
                                <button @click="onAddGps(1)" style="float: right;margin-top: 5px;" class="bnt btn-sm btn-light">
                                    <i style="color:#4e73df" class="fa fa-plus"></i>
                                </button>
                            </li>
                        </ul>
                    </span>
                </div>
                <input
                    placeholder="Buscar por placa"
                    v-model="search"
                    class="form-control"
                    @keyup="onSearch(search)"/>
            </div>
            <ul class="list-group" >
                <li v-for="item in markers" :key="item.id" class="list-group-item d-flex justify-content-between align-items-center">
                    <label @click="onCenter(item)" >{{ item.title }}</label>
                       <el-popover
                            placement="bottom"
                            title="Title"
                            width="200"
                            trigger="click"
                            content="this is content, this is content, this is content">
                        <el-button type="text" slot="reference"><i class="fas fa-ellipsis-v"></i></el-button>
                      </el-popover>
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
    .actions li {
        display: inline;
        list-style-type: none;
        padding-right: 5px;
        color: white;
        font-size: 1.2em;
    }
    .search-container {
        height: 85px;
        width: 100%;
    }

</style>
<script>
    export default {
        props: ['markers','onCenter','onAddGps','onSearch'],
        data(){
            return{
                search:''
            }
        },
    }
</script>
