<template>
    <div id="wrapper" style="width:100%;  height: 100%;">
        <example-component :markers="markers" :onCenter="onCenter" ></example-component>
        <div class="d-flex flex-column" style="width:100%;  height: 100%;" id="content-wrapper">
            <div id="content" style="width:100%;  height: 100%;">
                <maps-component :zoom="zoom" :markers="markers" :center="center" :onCenter="onCenter"></maps-component>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            center: { lat: 3.882815, lng: -77.022750 },
            markers: [
                {
                    position:{lat: 3.8764544,lng: -77.0244602},
                    title: "G05"
                },
                {
                    position:{lat: 3.882815,lng: -77.022750},
                    title: "G0493"
                },
                {
                    position:{lat: 3.874446,lng: -77.001574},
                    title: "G0456"
                }
            ],
            zoom: 13
        };
    },
    methods: {
        onCenter(marker){
            this.center = marker.position;
            this.zoom = 16;
        },
    }
}
</script>

<style>

</style>
