<template>
    <v-app>
        <v-app-bar app dark>
            <v-toolbar-title class="mx-auto">AutoCenter24</v-toolbar-title>
        </v-app-bar>
        <v-main>
            <v-container fluid>
                <v-row class="mt-3 ml-3 justify-content-center">
                    <v-btn @click="showLogin" width="300px">Logowanie</v-btn>
                    <v-btn @click="showRegistration" width="300px">Rejestracja</v-btn>
                </v-row>
            </v-container>
            <login v-if="showLoginModel"></login>
            <register v-if="showRegisterModel"></register>
            <div class="container-fluid">
                <about></about>
            </div>
<!--            Pokazowa mapa z warsztatami i pobieraniem lokalizacji/ wyszukiwaniem miasta-->
            <v-container>
                <v-app>
                <h1>Sprawdź działanie</h1>
                <v-btn color="dark" @click="getLocation" class="mb-2">Moja lokalizacja</v-btn>
                <v-text-field v-model="searchLocation" label="Miasto" ></v-text-field>
                <v-btn color="dark" @click="searchForCity" class="mb-2">Szukaj miasta</v-btn>
<!--                <v-btn @click="saveLocation">Zapisz lokalizację</v-btn>-->
                    <gmaps-map :options="mapOptions">
                        <gmaps-marker :visible="myLocation" :options="optionsA" :icon="'/images/userMarker.png'" />

                        <span v-for="(company,index) in companies">
                        <gmaps-marker  :key="index" :position="company.location" :title="company.name"  />
                             <gmaps-popup
                                 :position="company.location"
                                 background="#BBF0FF">
                                 {{company.name}}
                            </gmaps-popup>
                        </span>
                    </gmaps-map>
                </v-app>
            </v-container>
        </v-main>
        <v-footer app dark class="white--text">
            <span>AutoService24</span>
            <v-spacer></v-spacer>
            <span>Adrian Ochała &copy; {{ new Date().getFullYear() }}</span>
        </v-footer>
    </v-app>
</template>
<script>
    import about from '../components/AboutComponent'
    import login from '../components/LoginComponent'
    import register from '../components/RegisterComponent'
    import {mapGetters} from 'vuex';
    import { gmapsMap, gmapsMarker,gmapsInfoWindow,gmapsPopup} from 'x5-gmaps';
    export default {
        name: "welcome",
        components:{about,login, register,gmapsMap, gmapsMarker,gmapsInfoWindow,gmapsPopup  },
        data(){
            return{
                showLoginModel:false,
                showRegisterModel:false,
                optionsA: {
                    position: { lat: 0, lng: 0 },
                    title: 'Twój znacznik',
                    clickable: true,
                    draggable: true,
                    label: 'Tutaj jesteś',
                },
                mapOptions: {
                    center: { lat: 50.270908, lng: 19.039993 },
                    zoom: 12,
                },
                myLocation:false,
                userLocation:null,
                searchLocation:'',
                info:'',
                companies:'',
                popsups:[],
                popupsInfo:[],
            }},
        methods:{
            showLogin(){
                if(this.showRegisterModel===true){ this.showRegisterModel = !this.showRegisterModel;}
                this.showLoginModel = !this.showLoginModel;
            },
            showRegistration(){
                if(this.showLoginModel===true) {this.showLoginModel = !this.showLoginModel;}
                this.showRegisterModel = !this.showRegisterModel;
            },
            updatePosition(pos) {
                this.positionA = pos
            },
            async searchForCity(){
                const url = 'https://maps.googleapis.com/maps/api/geocode/json?address='+this.searchLocation+'&key=AIzaSyDhVXa0nOz4UUTyrLBYp4sNjTMD6izwX6Y'
                const res = await this.callApi('get', url);
                console.log(res.data.results[0].geometry.location)
                this.mapOptions.center = res.data.results[0].geometry.location;
                this.mapOptions.zoom = 14;
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
                console.log(this.myLocation)
                this.optionsA.position = {lat: pos.coords.latitude, lng: pos.coords.longitude}
            },
            locationError(error) {
                if (error.PERMISSION_DENIED) alert('User denied the request for Geolocation.')
                else if (error.POSITION_UNAVAILABLE) alert('Location information is unavailable.')
                else if (error.TIMEOUT) alert('The request to get user location timed out.')
                else alert('An unknown error occurred.')
            },
        },
        computed:{
            ...mapGetters(['getCompanyLocation']),
        },
        async created(){
            const res = await  this.callApi('get','/getCompanies')
            if(res.status === 200){
                this.companies = res.data
                console.log(this.companies.length)
                for (let i = 0; i < this.companies.length;i++){
                    this.companies[i].location = JSON.parse(this.companies[i].location)
                    this.popsups[i]= this.companies[i].location
                }
            }else{
                this.$toast.error('Nie udało się pobrać specjalizacji ! Odśwież stronę', { timeout: 0 })
            }
        },
    }
</script>
