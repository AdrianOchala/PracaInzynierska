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
            <login v-if="getShowLoginComponent"></login>
            <register v-if="getShowRegisterComponent"></register>
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
    import about from '../components/WelcomePage/AboutComponent';
    import login from '../components/Auth/LoginComponent';
    import register from '../components/Auth/RegisterComponent';
    import {mapGetters} from 'vuex';
    import { gmapsMap, gmapsMarker,gmapsInfoWindow,gmapsPopup} from 'x5-gmaps';
    export default {
        name: "welcome",
        components:{about,login, register,gmapsMap, gmapsMarker,gmapsInfoWindow,gmapsPopup  },
        data(){
            return{
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
               this.$store.commit('setShowLoginComponent', true);
               this.$store.commit('setShowRegisterComponent', false);
                // if(this.getShowRegisterComponent===true){
                //     this.setShowRegisterComponent(false)
                //     this.showRegisterModel = false
                // }
                // this.setShowLoginComponent(true)
                // this.showLoginModel = true
            },
            showRegistration(){
                this.$store.commit('setShowLoginComponent', false);
               this.$store.commit('setShowRegisterComponent', true);
                // if(this.getShowLoginComponent===true) {
                //     this.setShowLoginComponent(false)
                //     this.showLoginModel = false
                // }
                // this.showRegisterModel=true
                // this.setShowRegisterComponent(true)
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
            ...mapGetters(['getShowLoginComponent','getShowRegisterComponent']),

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
                this.$toast.error('Nie udało się pobrać warsztatów ! Odśwież stronę', { timeout: 6000 })
            }
        },
        watch:{

        },
    }
</script>
