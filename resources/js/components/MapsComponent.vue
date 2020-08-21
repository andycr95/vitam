<template>
    <div style="width:100%;  height: 100%;">
        <gmap-map :center="center" ref="map" :zoom="zoom" :options="{
            zoomControl: true,
            mapTypeControl: false,
            scaleControl: false,
            streetViewControl: false,
            rotateControl: true,
            fullscreenControl: true,
            }" style="width:100%;  height: 100%;">
                <directionsRenderer/>
                <gmap-custom-marker
                    :key="index"
                    v-for="(m, index) in markers"
                    alignment="bottomright"
                    :marker="m.position">
                        <img style="marker-img" @click="drawerD(m)" src="/img/marker-icon.png" />
                </gmap-custom-marker>
        </gmap-map>
    </div>
</template>
<style scoped>
    .marker-img{
        width: 40px;
    }
</style>
<script>
import GmapCustomMarker from 'vue2-gmap-custom-marker';
import { MapElementFactory } from 'vue2-google-maps';
import DirectionRenderer from '../directionRenderer';
export default {
    name: "GoogleMap",
    props: ['markers','onCenter','center',"zoom","drawerD"],
    components: {
      'gmap-custom-marker': GmapCustomMarker,
      'directionsRenderer': DirectionRenderer
    },
    sockets:{
        connect: function () {
            console.log('socket connected')
        }
    },
    methods:{
        directions(){
            console.log(this.$refs);
            // var directionsService = new this.google.maps.DirectionsService;
            // var directionsDisplay = new this.google.maps.DirectionsRenderer;
            // directionsDisplay.setMap(this.$refs.map.$mapObject);

            // //google maps API's direction service
            // function calculateAndDisplayRoute(directionsService, directionsDisplay, start, destination) {
            //     directionsService.route({
            //         origin: start,
            //         destination: destination,
            //         travelMode: 'DRIVING'
            //     }, function(response, status) {
            //     if (status === 'OK') {
            //         directionsDisplay.setDirections(response);
            //     } else {
            //         window.alert('Directions request failed due to ' + status);
            //     }
            //     });
            // }
            // calculateAndDisplayRoute(directionsService, directionsDisplay, this.actual, this.marker.position);
        }
    }
};
</script>
