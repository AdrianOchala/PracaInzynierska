<template>
    <v-card>
        <v-card-title>
            <span class="headline">Dane firmy</span>
        </v-card-title>
        <v-card-text>
            <v-container>
                <v-row>
                    <v-col cols="12" sm="6" md="6">
                        <v-text-field v-model="owner.companyName" label="Nazwa firmy" required></v-text-field>
                    </v-col>
                    <v-col cols="12" sm="6" md="6">
                        <v-text-field v-model="owner.NIP" label="NIP" ></v-text-field>
                    </v-col>
                    <v-col cols="12" sm="12">
                        <v-select v-model="owner.selectedSpecs"
                                  :items="specializations"
                                  item-text="name"
                                  item-value="id"
                                  label="Wybierz specjalizację"
                                  multiple
                        ></v-select>
                    </v-col>
                    <v-col cols="12" sm="6" md="6">
                        <v-text-field v-model="owner.city" label="Miasto" required></v-text-field>
                    </v-col>
                    <v-col cols="12" sm="6" md="6">
                        <v-text-field v-model="owner.street" label="Ulica"></v-text-field>
                    </v-col>
                    <v-col cols="12" sm="6" md="6">
                        <v-text-field v-model="owner.zipCode" label="Kod pocztowy"></v-text-field>
                    </v-col>
                    <v-col cols="12" sm="6" md="6">
                        <v-text-field v-for="(number,index) in owner.companyPhones" :key="index" v-model="owner.companyPhones[index].number" label="Telefon"></v-text-field>
                        <v-btn class="ma-2" tile outlined color="success" @click="addPhoneNumber()">
                            <v-icon left>mdi-plus</v-icon> Dodaj
                        </v-btn>
                        <v-btn class="ma-2" tile outlined color="error" @click="deletePhoneNumber()">
                            <v-icon left>mdi-minus</v-icon> Usuń
                        </v-btn>
                    </v-col>
                </v-row>
                <v-row>
                    <v-col cols="12" sm="12" md="12">
<!--                        <searchOnTheMap>-->
<!--                        </searchOnTheMap>-->
                    </v-col>
                </v-row>
            </v-container>
            <v-btn @click="closeEditCompany">Anuluj</v-btn>
            <v-btn @click="editCompany">Edytuj</v-btn>
        </v-card-text>
    </v-card>
<!--    <gmaps-map :options="mapOptions" style="height: 50vh" class="mt-4">-->
<!--        <gmaps-marker :options="optionsA" />-->
<!--    </gmaps-map>-->
</template>
<script>
import { gmapsMap, gmapsMarker,gmapsPopup } from 'x5-gmaps';
export default {
    name:'SingleCompanyLocation',
    props:['company'],
    components: { gmapsMap, gmapsMarker,gmapsPopup },
    data(){
        return{
            optionsA: {
                position: this.center,
                title: 'Twój znacznik',
                clickable: true,
                label:this.name ,
            },
            mapOptions: {
                center: this.center,
                zoom: 12,
            },
            specializations:[], //Specjalizacje warsztatu
            owner:{
                id:'',
                companyName:'',
                NIP:'',
                city:'',
                street:'',
                zipCode:'',
                companyPhones:[{'number': null}],
                companyConvertedPhones:null,
                location:'',
                selectedSpecs:[],
            },
        }
    },
    methods:{
        closeEditCompany(){
            this.$store.commit('setShowEditCompany', false);
        },
        async editCompany(){
            console.log(this.owner)
            this.owner.companyConvertedPhones = JSON.stringify(this.owner.companyPhones)
            const res = await this.callApi('post','/updateCompany', this.owner );
            if(res.status === 200){
                this.$toast.success('Edycja przebiegła pomyślnie');
                this.$store.commit('setShowEditCompany', false);
            }else{
                this.$toast.warning('Coś poszło nie tak')
            }
        },
    },
    async created() {
        console.log(this.company);
        const res = await this.callApi('get', '/getSpecializations');
        if(res.status === 200){
            this.specializations = res.data
        }else{
            this.$toast.error('Nie udało się pobrać specjalizacji ! Odśwież stronę', { timeout: 6000 })
        }
        this.owner={
            id:this.company.id,
            companyName:this.company.name,
            NIP:this.company.NIP,
            city:this.company.city,
            street:this.company.street,
            zipCode:this.company.zipCode,
            companyPhones:this.company.phones,
            companyConvertedPhones:null,
            location:this.company.location,
            selectedSpecs:this.company.specialization,
        }
    }
}
</script>
