<template>
    <div id="wrapper" style="width:100%;  height: 100%;">
        <el-drawer
            :visible.sync="drawer"
            :with-header="false"
            :direction="direction">
            <example-component :onSearch="onSearch" :onAddGps="showModal" :markers="markers" :onCenter="onCenter" ></example-component>
        </el-drawer>
        <el-drawer
            :visible.sync="drawerD"
            :with-header="false"
            :direction="direction">
            <nav class="navbar navbar-light align-items-start sidebar sidebar-light bg-light" style="width: 100% !important; padding: 0%">
                <div class="container-fluid d-flex flex-column p-0">
                    <div class="search-container bg-primary">
                        <div style="height: 40px; width: 100%">
                            <span class="actions">
                                <ul style="margin-bottom: 0; margin-right:5px;margin-top: 10px;text-align: center;">
                                    <li style="float: left;margin-top: 5px;">
                                        {{marker.title}}
                                    </li>
                                    <li>
                                        <span v-if="marker.device_state=='active'" class="badge badge-success">Activo</span>
                                        <span v-else class="badge badge-success">Inactivo</span>
                                    </li>
                                </ul>
                            </span>
                        </div>
                    </div>
                    <ul class="list-group" >
                        <li>
                            <img v-if="marker.photo != null" style="width:100%;" :src="marker.photo">
                            <img v-else src="/img/moto.jpeg" style="width:100%;">
                        </li>
                        <li v-if="marker.sale != null">
                            <div class="card text-left">
                              <div class="card-body">
                                <h5 class="card-title" style="color:black">Cliente: {{marker.sale.client.name}} {{marker.sale.client.last_name}}</h5>
                                    <el-row>
                                        <el-col :span="12">
                                            <div class="grid-content bg-purple">
                                                <el-row>
                                                    <el-col :span="24" class="d-flex justify-content-center">
                                                        <el-button type="primary" icon="el-icon-location-information" circle></el-button>
                                                    </el-col>
                                                    <el-col :span="24" class="d-flex justify-content-center">
                                                        <span>Como llegar</span>
                                                    </el-col>
                                                </el-row>
                                            </div>
                                        </el-col>
                                        <el-col :span="12">
                                            <el-row>
                                                    <el-col :span="24" class="d-flex justify-content-center">
                                                        <el-button type="danger" icon="fas fa-cut" @click="directions" circle></el-button>
                                                    </el-col>
                                                    <el-col :span="24" class="d-flex justify-content-center">
                                                        <span>Apagar vehiculo</span>
                                                    </el-col>
                                            </el-row>
                                        </el-col>
                                    </el-row>
                              </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>
        </el-drawer>
        <div class="d-flex flex-column" style="width:100%;  height: 100%;" id="content-wrapper">
            <div id="content" style="width:100%;  height: 100%;">
                <maps-component ref="gmapComp" :drawerD="drawerCh" :zoom="zoom" :markers="markers" :center="center" :onCenter="onCenter"></maps-component>
            </div>
        </div>
        <a @click="drawer = true" class="fab-gps"><i class="fa fa-arrow-right" style="color:#ffffff; margin-top: 10px;margin-right: 10px;width: 20px;" aria-hidden="true"></i></a>
        <add-gps name="example" :width="350" :height="350" :adaptive="true">
            <div class="card">
                <div class="card-header">
                    Agregar dispositivo
                </div>
                <div class="card-body">
                    <el-form ref="formDevice" :rules="rules" :model="form">
                        <el-form-item prop="id" label="Identificador" required>
                            <el-input v-model="form.id"></el-input>
                        </el-form-item>
                        <el-form-item prop="vehicle" label="Vehiculo" required>
                            <el-select sixe="large" style="width: 300px" v-model="form.vehicle" filterable placeholder="Select">
                                <el-option
                                v-for="item in vehicles"
                                :key="item.id"
                                :label="item.placa"
                                :value="item.placa">
                                </el-option>
                            </el-select>
                        </el-form-item>
                        <el-form-item>
                            <el-button type="primary" @click="onSubmit">Agregar</el-button>
                            <el-button @click="showModal(0)" >Cancelar</el-button>
                        </el-form-item>
                    </el-form>
                </div>
            </div>
        </add-gps>
    </div>
</template>

<script>
import axios from "axios";
import { gmapApi } from 'vue2-google-maps'
export default {
    data() {
        return {
            center: { lat: 3.882815, lng: -77.022750 },
            markers: [],
            actual: {lat:3.877698, lng: -77.021617},
            vehicles: [],
            zoom: 13,
            form: {
                id: '',
                vehicle: ''
            },
            rules: {
                id: [
                    { required: true, message: 'Este campo es requerido', trigger: 'blur' },
                    { min: 15, max: 16, message: 'El id debe ser mayor o igual a 15', trigger: 'blur' }
                ],
                vehicle: [
                    { required: true, message: 'Este campo es requerido', trigger: 'change' }
                ]
            },
            drawer: false,
            drawerD: false,
            direction: 'ltr',
            marker:{
                position:{lat: 0,lng: 0},
                title: '',
                state:'',
                device_id:'',
                amount:null,
                branchoffice: null,
                branchoffice_id: null,
                chasis: null,
                color: null,
                created_at: null,
                fee: null,
                id: null,
                investor_id: null,
                model: null,
                motor: null,
                photo: null,
                photo1: null,
                photo2: null,
                photo3: null,
                placa: null,
                sale: null,
                state: null,
                status: null,
                type_id: null,
                updated_at:null
            }
        };
    },
    mounted() {
        axios.get('/api/vehicles',{headers: {'Accept':'application/json'}}).then((res) => {
            this.vehicles = res.data;
        });
        this.getDevices();
    },
    computed: {
        google: gmapApi
    },
    sockets:{
        devices: function(data) {
            for (let i = 0; i < this.markers.length; i++) {
                const e = this.markers[i];
                for (let j = 0; j < data.length; j++) {
                    const f = data[j];
                    if (e.title == f.placa) {
                        var lng = 0;
                        var lat = 0;
                        if (f.state == "active") {
                            lng = f.coordinates[0].longitude;
                            lat = f.coordinates[0].latitude;
                        }
                        e.position = {lat,lng};
                    }
                }
            }
            console.log(data);
        },
        add_device: function(data) {
            var lng = 0;
            var lat = 0;
            if (data.state == "active") {
                lng = data.coordinates[0].longitude;
                lat = data.coordinates[0].latitude;
            }
            this.markers.push({position:{lat: lat,lng: lng},title: data.placa, state:data.state, device_id:data.device_id});
        }
    },
    methods: {
        onCenter(marker){
            this.center = marker.position;
            this.zoom = 16;
            this.drawer = false;
        },
        showModal(type){
            if (type==1) {
                this.$modal.show('example');
            } else {
                this.$modal.hide('example');
            }
            this.drawer = false;
        },
        getDevices(){
            axios.get('https://solinter.tech/device',{headers: {'Accept':'application/json'}}).then((res) => {
                const marks = [];
                for (let i = 0; i < res.data.devices.length; i++) {
                    const e = res.data.devices[i];
                    var lng = 0;
                    var lat = 0;
                    if (e.state == "active") {
                        lng = e.coordinates[0].longitude;
                        lat = e.coordinates[0].latitude;
                    }
                    marks.push({position:{lat: lat,lng: lng},title: e.placa, state:e.state, device_id:e.device_id});
                }
                this.markers = marks;
            });
        },
        onSearch(value){
            if (value.length > 0) {
                axios.get(`https://solinter.tech/device/search?query=${value}`,{headers: {'Accept':'application/json'}}).then((res) => {
                    const marks = [];
                    for (let i = 0; i < res.data.devices.length; i++) {
                        const e = res.data.devices[i];
                        var lng = 0;
                        var lat = 0;
                        if (e.state == "active") {
                            lng = e.coordinates[0].longitude;
                            lat = e.coordinates[0].latitude;
                        }
                        marks.push({position:{lat: lat,lng: lng},title: e.placa, state:e.state, device_id:e.device_id});
                    }
                    this.markers = marks;
                });
            } else {
                this.getDevices();
            }
        },
        onSubmit(){
            const device = {
                "device_id":this.form.id,
                "placa":this.form.vehicle
            }
            this.$refs["formDevice"].validate((valid) => {
                if (valid) {
                    this.$socket.emit('add_device', device);
                    this.$modal.hide('example');
                }
            });
        },
        async drawerCh(value){
            await axios.get(`/api/vehicles/${value.title}`,{headers: {'Accept':'application/json'}}).then((res) => {
                this.marker = {
                    position:{
                        lat:value.position.lat,
                        lng:value.position.lng
                    },
                    title: value.title,
                    device_state:value.state,
                    device_id:value.device_id,
                    amount:res.data[0].amount,
                    branchoffice: res.data[0].branchoffice,
                    branchoffice_id: res.data[0].branchoffice_id,
                    chasis: res.data[0].chasis,
                    color: res.data[0].color,
                    created_at: res.data[0].created_at,
                    fee: res.data[0].fee,
                    id: res.data[0].id,
                    investor_id: res.data[0].investor_id,
                    model: res.data[0].model,
                    motor: res.data[0].motor,
                    photo: res.data[0].photo,
                    photo1: res.data[0].photo1,
                    photo2: res.data[0].photo2,
                    photo3: res.data[0].photo3,
                    placa: res.data[0].placa,
                    sale: res.data[0].sales,
                    state: res.data[0].state,
                    status: res.data[0].status,
                    type_id: res.data[0].type_id,
                    updated_at: res.data[0].updated_at,
                }
            });
            this.drawerD = !this.drawerD;
            console.log(this.marker);
        },
        directions(){
            var google = this.google;
            var directionsService = new google.maps.DirectionsService;
            var directionsDisplay = new google.maps.DirectionsRenderer;
            directionsDisplay.setMap(this.$refs.gmapComp.$refs.map.$mapObject, {
                zoom: 7,
                center: { lat: this.marker.position.lat, lng: this.marker.position.lng }
            });

            //google maps API's direction service
            function calculateAndDisplayRoute(directionsService, directionsDisplay, start, destination) {
                directionsService.route({
                    origin: start,
                    destination: destination,
                    travelMode: google.maps.TravelMode.DRIVING,

                }, function(response, status) {
                if (status === 'OK') {
                    directionsDisplay.setDirections(response);
                } else {
                    window.alert('Directions request failed due to ' + status);
                }
                });
            }
            calculateAndDisplayRoute(directionsService, directionsDisplay, this.actual, this.marker.position);
        }
    }
}
</script>

<style>
    .fab-gps{
        background: #4e73df;
        width: 64px;
        height: 64px;
        border-radius: 50%;
        text-align:center;
        box-shadow:0px 0px 3px rgba(0,0,0,0.5),3px 3px 3px rgba(0,0,0,0.25);
        position: fixed;
        bottom: 100px;
        left: 50px;
        font-size: 2.6667em;
        display: inline-block;
        cursor: default;
    }
    .list-group{
        width: 100%;
    }
    .actions li {
        display: inline;
        list-style-type: none;
        padding-right: 5px;
        color: white;
        font-size: 1.2em;
    }
    .search-container {
        height: 65px;
        width: 100%;
    }
</style>
