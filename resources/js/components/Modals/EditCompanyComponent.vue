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
                    <v-col cols="12" sm="12" md="12">
                        <v-textarea
                            clearable
                            counter
                            clear-icon="mdi-close-circle"
                            label="Opis firmy..."
                            v-model="owner.description"
                            hint="Max 500 znaków"
                            filled
                            auto-grow
                            background-color="#CFD8DC"
                            rows="1"
                        ></v-textarea>
                    </v-col>
                    <v-col cols="12" sm="12" md="12" v-if="owner.hours">
                        <v-card>
                            <v-card-title>Godziny otwarcia</v-card-title>
                            <v-card-text>
                                <v-simple-table dark>
                                    <thead>
                                    <tr>
                                        <th>Dzień</th>
                                        <th>Od</th>
                                        <th>Do</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td>{{owner.hours[0].day}}</td>
                                        <td>
                                            <v-select
                                                v-model="owner.hours[0].from"
                                                :items="hours"
                                            ></v-select>
                                        </td>
                                        <td>
                                            <v-select
                                                v-model="owner.hours[0].to"
                                                :items="hours"
                                            ></v-select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>{{owner.hours[1].day}}</td>
                                        <td>
                                            <v-select
                                                v-model="owner.hours[1].from"
                                                :items="hours"
                                            ></v-select>
                                        </td>
                                        <td>
                                            <v-select
                                                v-model="owner.hours[1].to"
                                                :items="hours"
                                            ></v-select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>{{owner.hours[2].day}}</td>
                                        <td>
                                            <v-select
                                                v-model="owner.hours[2].from"
                                                :items="hours"
                                            ></v-select>
                                        </td>
                                        <td>
                                            <v-select
                                                v-model="owner.hours[2].to"
                                                :items="hours"
                                            ></v-select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>{{owner.hours[3].day}}</td>
                                        <td>
                                            <v-select
                                                v-model="owner.hours[3].from"
                                                :items="hours"
                                            ></v-select>
                                        </td>
                                        <td>
                                            <v-select
                                                v-model="owner.hours[3].to"
                                                :items="hours"
                                            ></v-select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>{{owner.hours[4].day}}</td>
                                        <td>
                                            <v-select
                                                v-model="owner.hours[4].from"
                                                :items="hours"
                                            ></v-select>
                                        </td>
                                        <td>
                                            <v-select
                                                v-model="owner.hours[4].to"
                                                :items="hours"
                                            ></v-select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>{{owner.hours[5].day}}</td>
                                        <td>
                                            <v-select
                                                v-model="owner.hours[5].from"
                                                :items="hours"
                                            ></v-select>
                                        </td>
                                        <td>
                                            <v-select
                                                v-model="owner.hours[5].to"
                                                :items="hours"
                                            ></v-select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>{{owner.hours[6].day}}</td>
                                        <td>
                                            <v-select
                                                v-model="owner.hours[6].from"
                                                :items="hours"
                                            ></v-select>
                                        </td>
                                        <td>
                                            <v-select
                                                v-model="owner.hours[6].to"
                                                :items="hours"
                                            ></v-select>
                                        </td>
                                    </tr>
                                    </tbody>
                                </v-simple-table>
                            </v-card-text>
                        </v-card>
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
                description:'',
                hours:[
                    {'day':'Poniedziałek','from':null,'to':null},
                    {'day':'Wtorek','from':null,'to':null},
                    {'day':'Środa','from':null,'to':null},
                    {'day':'Czwartek','from':null,'to':null},
                    {'day':'Piątek','from':null,'to':null},
                    {'day':'Sobota','from':null,'to':null},
                    {'day':'Niedziela','from':null,'to':null},
                ],
            },
            hours:['00:00','01:00','02:00','03:00','04:00','05:00','06:00','07:00','08:00','09:00','10:00',
                '11:00','12:00','13:00','14:00','15:00','16:00','17:00','18:00','19:00','20:00','21:00','22:00','23:00'],
        }
    },
    methods:{
        closeEditCompany(){
            this.$store.commit('setShowEditCompany', false);
        },
        async editCompany(){
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
            description:this.company.description,
            hours: this.company.hours,
        }
        console.log("OOOOOO TUTAJ")
        console.log(this.owner.hours[0].from)
    }
}
</script>
