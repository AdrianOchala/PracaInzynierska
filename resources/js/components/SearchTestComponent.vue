<template>
    <v-app>
        <h1>Wyszukaj warsztat</h1>
        <v-btn color="dark" @click="getLocation" class="mb-2">Moja lokalizacja</v-btn>
        <v-text-field v-model="searchLocation" label="Miasto" ></v-text-field>
        <v-btn color="dark" @click="searchForCity" class="mb-2">Szukaj miasta</v-btn>
        <v-btn @click="saveLocation">Zapisz lokalizację</v-btn>
        <template style="height: 200px">
            <gmaps-map :options="mapOptions">
                <gmaps-marker :visible="myLocation" :options="optionsA" :icon="'/images/userMarker.png'" />
            </gmaps-map>
        </template>

    </v-app>
</template>
<script>
    import { gmapsMap, gmapsMarker } from 'x5-gmaps';
    import {mapGetters} from 'vuex';
    export default {
        components: { gmapsMap, gmapsMarker },
        data(){
            return{
                optionsA: {
                    position: { lat: 0, lng: 0 },
                    title: 'Twój znacznik',
                    clickable: true,
                    draggable: true,
                    label: 'Tutaj jesteś',

                },
                myLocation:false,
                userLocation:null,
                searchLocation:'',
                mapOptions: {
                    center: { lat: 50.270908, lng: 19.039993 },
                    zoom: 12,
                },
                info:'',
            }
        },
        methods:{
            updatePosition(pos) {
                this.positionA = pos
            },
            async searchForCity(){
                const url = 'https://maps.googleapis.com/maps/api/geocode/json?address='+this.searchLocation+'&key=AIzaSyDhVXa0nOz4UUTyrLBYp4sNjTMD6izwX6Y'
                const res = await this.callApi('get', url);
                console.log(res.data.results[0].geometry.location)
                this.mapOptions.center = res.data.results[0].geometry.location;
                this.mapOptions.zoom = 16;
                this.myLocation = true;
                this.optionsA.position = res.data.results[0].geometry.location
            },
            getLocation() {
                if (navigator.geolocation) navigator.geolocation.getCurrentPosition(this.setLocation, this.locationError)
                else alert('Geolocation is not supported by this browser.')
            },
            setLocation(pos) {
                this.mapOptions = { ...this.mapOptions, center: { lat: pos.coords.latitude, lng: pos.coords.longitude } }
                this.center = { lat: pos.coords.latitude, lng: pos.coords.longitude }
                this.myLocation = true;
                this.optionsA.position = {lat: pos.coords.latitude, lng: pos.coords.longitude}
            },
            locationError(error) {
                if (error.PERMISSION_DENIED) alert('User denied the request for Geolocation.')
                else if (error.POSITION_UNAVAILABLE) alert('Location information is unavailable.')
                else if (error.TIMEOUT) alert('The request to get user location timed out.')
                else alert('An unknown error occurred.')
            },
            saveLocation(){

                this.$store.commit('setCompanyLocation',this.optionsA.position);
                console.log(this.optionsA.position)
            },
        },
    }
</script>
