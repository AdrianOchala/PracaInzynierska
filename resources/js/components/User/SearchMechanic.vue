<template>
    <div class="container-fluid">
        <div class="container">
        <h1 v-if="getUser">Wyszukaj warsztat</h1>
        <h1 v-else >Wskaż lokalizację swojego warsztatu</h1>

        <v-btn color="dark" @click="getLocation" class="mb-2">Moja lokalizacja</v-btn>
        <v-text-field v-model="searchLocation" label="Miasto" ></v-text-field>
        <v-btn color="dark" @click="searchForCity">Szukaj miasta</v-btn>
        <v-btn v-if="!getUser" @click="saveLocation">Zapisz lokalizację</v-btn>

        <template>
            <gmaps-map :options="mapOptions" style="height: 50vh" class="mt-4" @centerChanged="centerChanged" >
                <gmaps-marker :visible="myLocation" :options="optionsA" :icon="'/images/userMarker.png'" @move="updatePosition" />
                <span v-for="(company,index) in companies">
                        <gmaps-marker  :key="index" :position="company.location" :title="company.name"  />
                             <gmaps-popup
                                 :position="company.location"
                                 background="#BBF0FF">
                                 {{company.name}}
                            </gmaps-popup>
                </span>
            </gmaps-map>
        </template>
        </div>
        <div v-if="getUser" class="container-fluid">
            <v-row>
                <v-col cols="12">
                    <h2>Warsztaty w promieniu  <v-chip class="mr-2" @click="showDistanceModel">
                        {{distance}} km
                    </v-chip></h2>
                </v-col>
            </v-row>
            <v-row v-if="shownearCompanies && getUser">
                <v-col cols="12" lg="12">
                    <v-row class="justify-content-center my-2" no-gutters>
                        <v-col lg="3" md="6" sm="12" xs="12"  v-for="(company,index) in nearCompanies" :key="company.id">
                            <v-card class="mx-2">
                                <v-card-title style="background: rgba(0, 0, 0, 0.7); color: white; ">
                                    {{company.user.name}} {{company.user.surname}} "{{company.name}}"
                                    <v-spacer></v-spacer>
                                    <v-btn text color="white" small class="px-0" @click="$router.push(`/MechanicDetails/${company.id}`)">
                                        <v-icon >mdi-open-in-new</v-icon>
                                    </v-btn>
                                </v-card-title>
                                <v-card-text>
                                    <h4 v-if="company.description">Opis właściciela</h4>
                                    <p>{{company.description}}</p>
                                    <v-divider></v-divider>
                                    <v-chip v-for="(spec,index) in company.specialization" :key="index"
                                            class="ma-2"
                                            color="green"
                                            text-color="white"
                                    >
                                        {{spec.name}}
                                    </v-chip>
                                </v-card-text>
                            </v-card>
                        </v-col>
                    </v-row>
                </v-col>
            </v-row>

            <v-row  v-else>
                <v-col cols="12">
                        <h3 class="red--text" >Nie znaleziono warsztatów w podanym promieniu</h3>
                </v-col>
            </v-row>
<!--            Pop-up distance changing model-->
            <v-dialog v-model="editDistance" max-width="500px">
                <v-card>
                    <v-card-text class="pb-0 px-0 pt-2">
                        <v-container fluid><v-row><v-col cols="12">
                        <v-slider
                            v-model="editingdistance"
                            :max="50"
                            label="Zasięg"
                            class="align-center"
                        >
                            <template v-slot:append>
                                <v-text-field
                                    v-model="editingdistance"
                                    class="mt-0 pt-0"
                                    type="number"
                                    style="width: 60px"
                                    suffix="km"
                                ></v-text-field>
                            </template>
                        </v-slider>
                        </v-col></v-row></v-container>
                    </v-card-text>
                    <v-card-actions class="justify-center">
                        <v-btn text color="primary" @click="refreshNearCompanies">Zapisz</v-btn>
                    </v-card-actions>
                </v-card>
            </v-dialog>
        </div>
    </div>
</template>
<style scoped>
    .card-outter {
        position: relative;
        padding-bottom: 50px;
    }
    .card-actions {
        position: absolute;
        bottom: 0;
    }
    /*.v-card__actions {*/
    /*    text-align: center;*/
    /*    background-color:red;*/
    /*    display: flex;*/
    /*    padding: 8px;*/
    /*}*/
</style>
<script>
    import { gmapsMap, gmapsMarker,gmapsPopup } from 'x5-gmaps';
    import {mapGetters} from 'vuex';
    export default {
        components: { gmapsMap, gmapsMarker,gmapsPopup },
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
                companies:'',
                nearCompanies:[],
                shownearCompanies:false,
                distance:5,
                editingdistance:0,
                editDistance:false,
            }
        },
        watch:{
            center(){
                console.log("Po zmianie")
                this.filterNearCompanies();
            }
        },
        computed:{
            ...mapGetters(['getUserLocation','getUser']),
            center(){
                return this.mapOptions.center;
            },
        },
        methods:{
            centerChanged(){
                console.log("zmieniłem center")
                console.log(this.mapOptions.center)
            },
            showcenter(){
                console.log("Computed property:")
                console.log(this.center)
                console.log(this.mapOptions.center)
                console.log(this.shownearCompanies)
                console.log(this.nearCompanies)


            },
            updatePosition(pos) {
                this.positionA = pos
                this.optionsA.position = this.positionA
                console.log(this.optionsA.position)
            },
            async searchForCity(){
                const url = 'https://maps.googleapis.com/maps/api/geocode/json?address='+this.searchLocation+'&key=AIzaSyDhVXa0nOz4UUTyrLBYp4sNjTMD6izwX6Y'
                const res = await this.callApi('get', url);
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
                console.log(this.mapOptions.center)
                console.log(this.center);
            },
            locationError(error) {
                if (error.PERMISSION_DENIED) alert('User denied the request for Geolocation.')
                else if (error.POSITION_UNAVAILABLE) alert('Location information is unavailable.')
                else if (error.TIMEOUT) alert('The request to get user location timed out.')
                else alert('An unknown error occurred.')
            },
            saveLocation(){
                this.$store.commit('setCompanyLocation',this.optionsA.position);
            },
            filterNearCompanies(){
                this.nearCompanies = [];
                for (let i = 0; i < this.companies.length; i++){
                    // coordinates from markers
                    let latitude = this.companies[i].location.lat
                    let longitude = this.companies[i].location.lng
                    // center of the map/your area
                    let mylatitude = this.mapOptions.center.lat;
                    let mylongitude = this.mapOptions.center.lng;
                    const radlat = latitude * Math.PI/180;
                    const radmylat = mylatitude * Math.PI/180;
                    const mylat_lat = (mylatitude - latitude)*Math.PI/180;
                    const mylon_lon = (mylongitude - longitude)*Math.PI/180;
                    const a = Math.sin(mylat_lat/2) * Math.sin(mylat_lat/2) + Math.cos(radlat) * Math.cos(radmylat)*Math.sin(mylon_lon/2)*Math.sin(mylon_lon/2);
                    const c = 2*Math.atan2(Math.sqrt(a), Math.sqrt(1-a));
                    const R = 6371e3; // metres
                    const d = R * c;
                    const searchDistance = this.distance * 1000;
                    if(d < searchDistance){
                        this.nearCompanies.push(this.companies[i])
                        console.log("Pokazuje blisko warsztaty")
                        this.shownearCompanies = true;
                    }
                    if(this.nearCompanies.length < 1){
                        this.shownearCompanies = false;
                    }
                }
            },
            showDistanceModel(){
                this.editDistance = true;
                this.editingdistance = this.distance;
            },
            refreshNearCompanies(){
                this.distance = this.editingdistance;
                this.filterNearCompanies()
                this.editDistance = false;
            }
        },
        async created(){
            if(this.getUser){
                this.getLocation();
            }
            const res = await  this.callApi('get','/getCompanies')
            if(res.status === 200){
                this.companies = res.data
                for (let i = 0; i < this.companies.length;i++){
                    this.companies[i].location = JSON.parse(this.companies[i].location)
                }
                this.filterNearCompanies();
            }else{
                this.$toast.error('Nie udało się pobrać warsztatów ! Odśwież stronę', { timeout: 0 })
            }
        },

    }
</script>

