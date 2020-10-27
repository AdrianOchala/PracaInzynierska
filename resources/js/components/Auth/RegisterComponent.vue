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
                                            <v-text-field v-model="owner.name" label="Imię*" required
                                                          :error-messages="ownerNameErrors"
                                                          @input="$v.owner.name.$touch()"
                                                          @blur="$v.owner.name.$touch()"
                                            ></v-text-field>
                                        </v-col>
                                        <v-col cols="12" sm="6" md="6">
                                            <v-text-field v-model="owner.surname" label="Nazwisko"
                                                          :error-messages="ownerSurnameErrors"
                                                          @input="$v.owner.surname.$touch()"
                                                          @blur="$v.owner.surname.$touch()"
                                            ></v-text-field>
                                        </v-col>

                                        <v-col cols="12" sm="6" md="6">
                                            <v-text-field v-model="owner.email" label="Email*" required
                                                          :error-messages="ownerEmailErrors"
                                                          @input="$v.owner.email.$touch()"
                                                          @blur="$v.owner.email.$touch()"
                                            ></v-text-field>
                                        </v-col>
                                        <v-col cols="12" sm="6" md="6">
                                            <v-text-field v-model="owner.phone" label="Telefon"
                                                          :error-messages="ownerPhoneErrors"
                                                          @input="$v.owner.phone.$touch()"
                                                          @blur="$v.owner.phone.$touch()"
                                            ></v-text-field>
                                        </v-col>
                                        <v-col cols="12">
                                            <v-text-field v-model="owner.password" label="Hasło*" type="password" required
                                                          :error-messages="ownerPasswordErrors"
                                                          @input="$v.owner.password.$touch()"
                                                          @blur="$v.owner.password.$touch()"
                                            ></v-text-field>
                                        </v-col>
                                        <v-col cols="12">
                                            <v-text-field v-model="owner.repeatPassword" label="Powtórz hasło*" type="password" required
                                                          :error-messages="ownerRepeatPasswordErrors"
                                                          @input="$v.owner.repeatPassword.$touch()"
                                                          @blur="$v.owner.repeatPassword.$touch()"></v-text-field>
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
                                            <v-text-field v-model="owner.companyName" label="Nazwa firmy*" required
                                                          :error-messages="ownerCompanyNameErrors"
                                                          @input="$v.owner.companyName.$touch()"
                                                          @blur="$v.owner.companyName.$touch()"
                                            ></v-text-field>
                                        </v-col>
                                        <v-col cols="12" sm="6" md="6">
                                            <v-text-field v-model="owner.NIP" label="NIP*"
                                                          :error-messages="ownerNIPErrors"
                                                          @input="$v.owner.NIP.$touch()"
                                                          @blur="$v.owner.NIP.$touch()"
                                            ></v-text-field>
                                        </v-col>
                                        <v-col cols="12" sm="12">
                                             <v-select v-model="owner.selectedSpecs"
                                                  :items="specializations"
                                                  item-text="name"
                                                  item-value="id"
                                                  label="Wybierz specjalizację*"
                                                  multiple
                                                  :error-messages="ownerSpecsErrors"
                                                  @input="$v.owner.selectedSpecs.$touch()"
                                                  @blur="$v.owner.selectedSpecs.$touch()"
                                              ></v-select>
                                        </v-col>
                                        <v-col cols="12" sm="6" md="6">
                                            <v-text-field v-model="owner.city" label="Miasto*" required
                                                          :error-messages="ownerCityErrors"
                                                          @input="$v.owner.city.$touch()"
                                                          @blur="$v.owner.city.$touch()"
                                            ></v-text-field>
                                        </v-col>
                                        <v-col cols="12" sm="6" md="6">
                                            <v-text-field v-model="owner.street" label="Ulica*"
                                                          :error-messages="ownerStreetErrors"
                                                          @input="$v.owner.street.$touch()"
                                                          @blur="$v.owner.street.$touch()"
                                            ></v-text-field>
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
                            :disabled="$v.owner.$invalid"
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
                                            <v-text-field v-model="user.name" label="Imię*"
                                            :error-messages="userNameErrors"
                                            @input="$v.user.name.$touch()"
                                            @blur="$v.user.name.$touch()"
                                            ></v-text-field>
                                        </v-col>
                                        <v-col cols="12" sm="6" md="6">
                                            <v-text-field v-model="user.surname" label="Nazwisko*"
                                             :error-messages="userSurnameErrors"
                                             @input="$v.user.surname.$touch()"
                                             @blur="$v.user.surname.$touch()"
                                            ></v-text-field>
                                        </v-col>

                                        <v-col cols="12" sm="6" md="6">
                                            <v-text-field v-model="user.email" label="Email*" required
                                                :error-messages="userEmailErrors"
                                                @input="$v.user.email.$touch()"
                                                @blur="$v.user.email.$touch()"
                                            ></v-text-field>
                                        </v-col>
                                        <v-col cols="12" sm="6" md="6">
                                            <v-text-field v-model="user.phone" label="Telefon"
                                                :error-messages="userPhoneErrors"
                                                @input="$v.user.phone.$touch()"
                                                @blur="$v.user.phone.$touch()"
                                            ></v-text-field>
                                        </v-col>
                                        <v-col cols="12">
                                            <v-text-field v-model="user.password" label="Hasło*" type="password" required
                                                :error-messages="userPasswordErrors"
                                                @input="$v.user.password.$touch()"
                                                @blur="$v.user.password.$touch()"
                                            ></v-text-field>
                                        </v-col>
                                        <v-col cols="12">
                                            <v-text-field v-model="user.repeatPassword" label="Powtórz hasło*" type="password" required
                                                :error-messages="userRepeatPasswordErrors"
                                                @input="$v.user.repeatPassword.$touch()"
                                                @blur="$v.user.repeatPassword.$touch()"
                                            ></v-text-field>
                                        </v-col>
                                    </v-row>
                                </v-container>
                                <small>*Wymagane</small>
                            </v-card-text>
                            <v-card-actions>
                                <v-spacer></v-spacer>
                                <v-btn color="blue darken-1" text @click="dialog = false">Close</v-btn>
                                <v-btn color="blue darken-1" text @click="registerUser" :disabled="$v.user.$invalid">Zarejestruj</v-btn>
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
    import {required, minLength,maxLength, between, sameAs,email,numeric} from 'vuelidate/lib/validators';
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
                    repeatPassword:'',
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
                    repeatPassword:'',
                }
            }
        },
        validations:{
            user: {
                name: {
                    required: required,
                    minLength:minLength(3),
                },
                surname:{
                    required,
                    minLength:minLength(3),
                },
                email:{
                    required,
                    email:email,
                },
                phone:{
                    numeric,
                },
                password:{
                    required,
                    minLength:minLength(7),
                },
                repeatPassword:{
                    sameAs:sameAs("password"),
                }
            },
            owner:{
                name: {
                    required: required,
                    minLength:minLength(3),
                },
                surname:{
                    required,
                    minLength:minLength(3),
                },
                email:{
                    required,
                    email:email,
                },
                phone:{
                    numeric,
                },
                password:{
                    required,
                    minLength:minLength(7),
                },
                repeatPassword:{
                    sameAs:sameAs("password")
                },
                companyName:{
                    required
                },
                NIP:{
                    minLength:minLength(10),
                    maxLength:maxLength(10),
                    numeric,
                    required
                },
                selectedSpecs: {
                    required
                },
                city: {
                    required
                },
                street: {
                    required
                },
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
                if(this.getCompanyLocation){
                    this.owner.location = this.getCompanyLocation;
                    this.owner.companyConvertedPhones = JSON.stringify(this.owner.companyPhones);
                    this.owner.location = JSON.stringify(this.owner.location);
                    const res = await this.callApi('post','/registerOwner', this.owner );
                    if(res.status === 200){
                        this.$toast.success('Pomyślnie zarejestowano, proszę się zalogować');
                        this.$store.commit('setShowLoginComponent', true);
                        this.$store.commit('setShowRegisterComponent', false);
                    }else{
                        this.$toast.warning('Coś poszło nie tak');
                    }
                }else{
                    this.$toast.warning('Proszę zapisać lokalizację warsztatu!');
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
            userNameErrors(){
                const errors = [];
                if (!this.$v.user.name.$dirty) return errors;
                !this.$v.user.name.minLength && errors.push('Podaj przynajmniej 3 znaki.');
                !this.$v.user.name.required && errors.push('Imię jest wymagane.');
                return errors;
            },
            userSurnameErrors(){
                const errors = [];
                if (!this.$v.user.surname.$dirty) return errors;
                !this.$v.user.surname.minLength && errors.push('Podaj przynajmniej 3 znaki.');
                !this.$v.user.surname.required && errors.push('Nazwisko jest wymagane.');
                return errors;
            },
            userEmailErrors(){
                const errors = [];
                if (!this.$v.user.email.$dirty) return errors;
                !this.$v.user.email.required && errors.push('E-mail jest wymagany.');
                !this.$v.user.email.email && errors.push('Adres e-mail nie poprawny.');
                return errors;
            },
            userPhoneErrors(){
                const errors = [];
                if (!this.$v.user.phone.$dirty) return errors;
                !this.$v.user.phone.numeric && errors.push('Wpisz tylko cyfry.');
                return errors;
            },
            userPasswordErrors(){
                const errors = [];
                if (!this.$v.user.password.$dirty) return errors;
                !this.$v.user.password.required && errors.push('Hasło jest wymagane.');
                !this.$v.user.password.minLength && errors.push('Minimum 7 znaków.');
                return errors;
            },
            userRepeatPasswordErrors(){
                const errors = [];
                if (!this.$v.user.repeatPassword.$dirty) return errors;
                !this.$v.user.repeatPassword.sameAs && errors.push('Hasła muszą być takie samo.');
                return errors;
            },
            ownerNameErrors(){
                const errors = [];
                if (!this.$v.owner.name.$dirty) return errors;
                !this.$v.owner.name.minLength && errors.push('Podaj przynajmniej 3 znaki.');
                !this.$v.owner.name.required && errors.push('Imię jest wymagane.');
                return errors;
            },
            ownerSurnameErrors(){
                const errors = [];
                if (!this.$v.owner.surname.$dirty) return errors;
                !this.$v.owner.surname.minLength && errors.push('Podaj przynajmniej 3 znaki.');
                !this.$v.owner.surname.required && errors.push('Nazwisko jest wymagane.');
                return errors;
            },
            ownerEmailErrors(){
                const errors = [];
                if (!this.$v.owner.email.$dirty) return errors;
                !this.$v.owner.email.required && errors.push('E-mail jest wymagany.');
                !this.$v.owner.email.email && errors.push('Adres e-mail nie poprawny.');
                return errors;
            },
            ownerPhoneErrors(){
                const errors = [];
                if (!this.$v.owner.phone.$dirty) return errors;
                !this.$v.owner.phone.numeric && errors.push('Wpisz tylko cyfry.');
                return errors;
            },
            ownerPasswordErrors(){
                const errors = [];
                if (!this.$v.owner.password.$dirty) return errors;
                !this.$v.owner.password.required && errors.push('Hasło jest wymagane.');
                !this.$v.owner.password.minLength && errors.push('Minimum 7 znaków.');
                return errors;
            },
            ownerRepeatPasswordErrors(){
                const errors = [];
                if (!this.$v.owner.repeatPassword.$dirty) return errors;
                !this.$v.owner.repeatPassword.sameAs && errors.push('Hasła muszą być takie samo.');
                return errors;
            },
            ownerCompanyNameErrors(){
                const errors = [];
                if (!this.$v.owner.companyName.$dirty) return errors;
                !this.$v.owner.companyName.required && errors.push('To pole jest wymagane.');
                return errors;
            },
            ownerSpecsErrors(){
                const errors = [];
                if (!this.$v.owner.selectedSpecs.$dirty) return errors;
                !this.$v.owner.selectedSpecs.required && errors.push('To pole jest wymagane. Proszę wybrać minimum jedną specjalizację.');
                return errors;
            },
            ownerCityErrors(){
                const errors = [];
                if (!this.$v.owner.city.$dirty) return errors;
                !this.$v.owner.city.required && errors.push('To pole jest wymagane.');
                return errors;
            },
            ownerStreetErrors(){
                const errors = [];
                if (!this.$v.owner.street.$dirty) return errors;
                !this.$v.owner.street.required && errors.push('To pole jest wymagane.');
                return errors;
            },
            ownerNIPErrors(){
                const errors = [];
                if (!this.$v.owner.NIP.$dirty) return errors;
                !this.$v.owner.NIP.required && errors.push('To pole jest wymagane.');
                !this.$v.owner.NIP.numeric && errors.push('NIP zawiera tylko cyfry.');
                !this.$v.owner.NIP.minLength && errors.push('Za mało! NIP posiada 10 znaków.');
                !this.$v.owner.NIP.maxLength && errors.push('Za dużo! NIP posiada 10 znaków.');
                return errors;
            },
        },
        async created(){
            const res = await this.callApi('get', '/getSpecializations');
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
