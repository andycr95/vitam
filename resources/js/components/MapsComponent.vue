<template>
    <div style="width:100%;  height: 100%;">
        <gmap-map :center="center" :zoom="zoom" :options="{
            zoomControl: true,
            mapTypeControl: false,
            scaleControl: false,
            streetViewControl: false,
            rotateControl: false,
            fullscreenControl: true,
            disableDefaultUi: false
            }" style="width:100%;  height: 100%;">
                <directionsRenderer/>
                <gmap-custom-marker
                    :key="index"
                    v-for="(m, index) in markers"
                    :marker="m.position"
                    @click="onCenter(m)">
                    <img style="marker-img" src="/img/marker-icon.png" />
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
    props: ['markers','onCenter','center',"zoom"],
    components: {
      'gmap-custom-marker': GmapCustomMarker,
      'directionsRenderer': DirectionRenderer
    },
    sockets:{
        connect: function () {
            console.log('socket connected')
        },
    }
};
</script>
