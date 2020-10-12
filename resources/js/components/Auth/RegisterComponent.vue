<template>

    <div>
            <v-container fluid>
                <h2>Rejestracja jako: </h2>
                <v-radio-group v-model="accountType" row class="label">
                    <v-radio label="Użytkownik" value="User"></v-radio>
                    <v-radio label="Właściciel warsztatu" value="Owner"></v-radio>
                </v-radio-group>
            </v-container>
            <!--        Rejestracja właściciela warsztatu-->
            <v-container fluid>
            <v-stepper v-if="accountType === 'Owner'" :value="owner.activeStep" non-linear>
                <v-stepper-header>
                    <template>
                        <v-stepper-step  :complete="owner.activeStep > 1" step="1" >Dane użytkownika</v-stepper-step>

                        <v-divider></v-divider>

                        <v-stepper-step  :complete="owner.activeStep > 2" step="2" >Dane warsztatu</v-stepper-step>

                    </template>
                </v-stepper-header>
                <!--                    Dane dla pierwszego kroku rejestracji, dane użytkownika-->
                <v-stepper-items>
                    <v-stepper-content step="1">
                        <v-card>
                            <v-card-title>
                                <span class="headline">Profil użytkownika</span>
                            </v-card-title>
                            <v-card-text>
                                <v-container>
                                    <v-row>
                                        <v-col cols="12" sm="6" md="6">
                                            <v-text-field v-model="owner.name" label="Imię*" required></v-text-field>
                                        </v-col>
                                        <v-col cols="12" sm="6" md="6">
                                            <v-text-field v-model="owner.surname" label="Nazwisko" ></v-text-field>
                                        </v-col>

                                        <v-col cols="12" sm="6" md="6">
                                            <v-text-field v-model="owner.email" label="Email*" required></v-text-field>
                                        </v-col>
                                        <v-col cols="12" sm="6" md="6">
                                            <v-text-field v-model="owner.phone" label="Telefon"></v-text-field>
                                        </v-col>
                                        <v-col cols="12">
                                            <v-text-field v-model="owner.password" label="Hasło*" type="password" required></v-text-field>
                                        </v-col>
                                        <v-col cols="12">
                                            <v-text-field label="Powtórz hasło*" type="password" required></v-text-field>
                                        </v-col>
                                    </v-row>
                                </v-container>
                                <small>*Wymagane</small>
                            </v-card-text>

                        </v-card>

                        <v-btn
                            color="primary"
                            @click="owner.activeStep = 2"
                        >
                            Continue
                        </v-btn>

                        <v-btn text>Cancel</v-btn>
                    </v-stepper-content>

                    <!--Dane dla druugiego kroku rejestracji, dane warsztatu-->
                    <v-stepper-content step="2">
                        <v-card>
                            <v-card-title>
                                <span class="headline">Dane firmy</span>
                            </v-card-title>
                            <v-card-text>
                                <v-container>
                                    <v-row>
                                        <v-col cols="12" sm="6" md="6">
                                            <v-text-field v-model="owner.companyName" label="Nazwa firmy*" required></v-text-field>
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
                                            <searchOnTheMap>
                                            </searchOnTheMap>
                                        </v-col>
                                    </v-row>
                                </v-container>
                                <small>*Wymagane</small>
                            </v-card-text>
                        </v-card>
                        <v-btn
                            color="primary"
                            @click="registerOwner"
                        >
                            Zarejestruj
                        </v-btn>

                        <v-btn text>Cancel</v-btn>
                    </v-stepper-content>
                </v-stepper-items>
            </v-stepper>
            <!--        Rejestracja użytkownika-->
            <v-stepper v-if="accountType === 'User'" :value="user.activeStep">
                <v-stepper-header>
                    <v-stepper-step step="1">Dane użytkownika</v-stepper-step>
                </v-stepper-header>

                <v-stepper-items>
                    <v-stepper-content step="1">
                        <v-card>
                            <v-card-title>
                                <span class="headline">Profil użytkownika</span>
                            </v-card-title>
                            <v-card-text>
                                <v-container>
                                    <v-row>
                                        <v-col cols="12" sm="6" md="6">
                                            <v-text-field v-model="user.name" label="Imię*" required></v-text-field>
                                        </v-col>
                                        <v-col cols="12" sm="6" md="6">
                                            <v-text-field v-model="user.surname" label="Nazwisko*" ></v-text-field>
                                        </v-col>

                                        <v-col cols="12" sm="6" md="6">
                                            <v-text-field v-model="user.email" label="Email*" required></v-text-field>
                                        </v-col>
                                        <v-col cols="12" sm="6" md="6">
                                            <v-text-field v-model="user.phone" label="Telefon"></v-text-field>
                                        </v-col>
                                        <v-col cols="12">
                                            <v-text-field v-model="user.password" label="Hasło*" type="password" required></v-text-field>
                                        </v-col>
                                        <v-col cols="12">
                                            <v-text-field label="Powtórz hasło*" type="password" required></v-text-field>
                                        </v-col>
                                    </v-row>
                                </v-container>
                                <small>*Wymagane</small>
                            </v-card-text>
                            <v-card-actions>
                                <v-spacer></v-spacer>
                                <v-btn color="blue darken-1" text @click="dialog = false">Close</v-btn>
                                <v-btn color="blue darken-1" text @click="registerUser">Zarejestruj</v-btn>
                            </v-card-actions>
                        </v-card>
                    </v-stepper-content>
                </v-stepper-items>
            </v-stepper>
            </v-container>
    </div>
</template>
<script>
    import {mapGetters} from 'vuex';
    import searchOnTheMap from '../User/SearchMechanic'
    export default {
        components:{searchOnTheMap},
        data(){
            return{
                accountType:'', // Wybór formularza do logowania
                specializations:[], //Specjalizacje warsztatu
                //Dane rejestracyjne właściciela warsztatu
                owner:{
                    activeStep:1,
                    name:'',
                    surname:'',
                    email:'',
                    phone:'',
                    password:'',
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
                //Dane rejestracyjne dla użytkownika
                user:{
                    activeStep:1,
                    name:'',
                    surname:'',
                    email:'',
                    phone:'',
                    password:'',
                }
            }
        },
        methods:{
            async registerUser(){
                const res = await this.callApi('post','/registerUser',this.user);
                if(res.status === 201){
                    this.$toast.success('Pomyślnie zarejestowano, proszę się zalogować')
                    this.accountType =''
                    this.$store.commit('setShowLoginComponent', true);
                    this.$store.commit('setShowRegisterComponent', false);
                }else{
                    this.$toast.warning('Coś poszło nie tak')
                }
            },
            async registerOwner(){
                this.owner.location = this.getCompanyLocation;
                this.owner.companyConvertedPhones = JSON.stringify(this.owner.companyPhones)
                this.owner.location = JSON.stringify(this.owner.location)
                const res = await this.callApi('post','/registerOwner', this.owner );
                if(res.status === 200){
                    this.$toast.success('Pomyślnie zarejestowano, proszę się zalogować')
                    this.$store.commit('setShowLoginComponent', true);
                    this.$store.commit('setShowRegisterComponent', false);
                }else{
                    this.$toast.warning('Coś poszło nie tak')
                }
            },
            addPhoneNumber(){
                this.owner.companyPhones.push({'number': null});
                console.log(this.owner.companyPhones);
            },
            deletePhoneNumber(){
                this.owner.companyPhones.pop();
            },
        },
        computed:{
            ...mapGetters(['getCompanyLocation']),
        },
        async created(){
            const res = await this.callApi('get', '/getSpecializations')
            if(res.status === 200){
                this.specializations = res.data
            }else{
                this.$toast.error('Nie udało się pobrać specjalizacji ! Odśwież stronę', { timeout: 6000 })
            }
        },
        watch: {
            accountType (val) {
                if (this.accountType === 'Owner') {
                    this.owner.activeStep = 1;
                }
            },

        },
    }
</script>
