<template>

            <v-card>
                <v-card-title>Złóż zapytanie</v-card-title>
                <v-card-text>
                    <v-container>
                        <v-row>
                            <v-col cols="12" lg="12">
                                <v-select v-if="userCars" :items="userCars"
                                          item-text="plate"
                                          item-value="id"
                                          v-model="repair.car"
                                          label="Wybierz samochód, którego dotyczy naprawa"
                                          :error-messages="carErrors"
                                          @input="$v.repair.car.$touch()"
                                          @blur="$v.repair.car.$touch()"
                                ></v-select>
                            </v-col>
                            <v-col cols="12" lg="6">
                                <v-select :items="repairCategories"
                                          item-text="name"
                                          item-value="id"
                                          v-model="repair.category"
                                          label="Kategoria naprawy"
                                          @change="showCategory"
                                          :error-messages="categoryErrors"
                                          @input="$v.repair.category.$touch()"
                                          @blur="$v.repair.category.$touch()"
                                ></v-select>
                            </v-col>
                            <v-col cols="12" lg="6">
                                <v-select v-if="showSubcategory" :items="repairCategories[repair.category].subCategory"
                                          v-model="repair.subCategory"
                                          label="Kategoria naprawy"
                                          :error-messages="subcategoryErrors"
                                          @input="$v.repair.subCategory.$touch()"
                                          @blur="$v.repair.subCategory.$touch()"
                                ></v-select>
                            </v-col>
                            <v-col cols="12" lg="12">
                                <v-textarea
                                    clearable
                                    counter
                                    clear-icon="mdi-close-circle"
                                    label="Opis problemu/usterki/szkody..."
                                    v-model="repair.description"
                                    hint="Kiedy zauważono problem, w jakich okolicznościach, jakie były objawy... Max 250 znaków"
                                    :rules="descriptionRules"
                                    filled
                                    auto-grow
                                    background-color="#CFD8DC"
                                    rows="1"
                                    :error-messages="descriptionErrors"
                                    @input="$v.repair.description.$touch()"
                                    @blur="$v.repair.description.$touch()"
                                ></v-textarea>
                            </v-col>
                            <v-col cols="12" lg="12">
                                <h4>Preferowany kontakt przez: </h4>
                                <v-radio-group v-model="repair.contact" row class="label"
                                               :error-messages="contactErrors"
                                               @input="$v.repair.contact.$touch()"
                                               @blur="$v.repair.contact.$touch()"
                                >
                                    <v-radio label="Sms" value="sms"></v-radio>
                                    <v-radio label="Telefon" value="telefon"></v-radio>
                                    <v-radio label="Komunikator w aplikacji" value="komunikator w aplikacji"></v-radio>
                                </v-radio-group>
                            </v-col>
                        </v-row>
                    </v-container>
                </v-card-text>

                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn text color="primary" @click="closeDialog">Anuluj</v-btn>
                    <v-btn text color="primary" @click="saveRepair" :disabled="$v.repair.$invalid">Zapytaj</v-btn>
                </v-card-actions>
            </v-card>

</template>
<script>
    import {required, minLength,maxLength,between,numeric} from 'vuelidate/lib/validators';

    export default{
        props:['company'],
        data(){
            return{
                repair:{
                    car:'',
                    company:this.company,
                    category:'',
                    subCategory:'',
                    description:'',
                    contact:'',
                },
                userCars:'',
                repairCategories:[
                    {id:0,name:'Serwis i przegląd techniczny', subCategory:['Wymiana oleju i filtrów', 'Wymiana oleju',
                        'Wymiana filtra paliwa', 'Wymiana płynu chłodniczego','Wymiana płynu hamulcowego','Przegląd techniczny auta',
                        'Wiosenny przegląd auta','Zimowy przegląd auta','Inspekcja auta przed zakupem']},
                    {id:1,name:'Diagnostyka auta', subCategory:['Diagnostyka komputerowa', 'Przegląd przed zakupem','Inna usługa']},
                    {id:2,name:'Układ hamulcowy i wydechowy',subCategory:['Wymiana tarcz i klocków','Przednie klocki','Tylnie klocki',
                        'Przednie tarcze i klocki','Tylnie tarcze i klocki','Przednie i tylnie klocki','Przednie i tylnie tarcze i klocki',
                        'Wymiana płynu hamulcowego','Naprawa hamulców','Hamulec ręczny','Naprawa zacisków hamulcowych','System ABS','Spawanie i naprawa tłumika',
                        'EGR - naprawa i czyszczenie','Regeneracja filtra cząsteczek stałych DPF/FAP','Wymiana katalizatora',
                            'Wymiana przewodu hamulcowego','Wymiana sondy lambda','Inna usługa']},
                    {id:3,name:'Sprzęgła i skrzynie biegów manualne/automatyczne',subCategory:['Wymiana sprzęgła','Wymiana skrzyni manualnej',
                        'Wymiana skrzyni automatycznej','Regeneracja skrzyni manualnej','Regeneracja skrzyni automatycznej',
                        'Wymiana oleju w manualnej skrzyni biegów','Wymiana oleju w automatycznej skrzyni biegów',
                        'Skrzynia biegów CVT','Sprzęgła hydrokinetyczne','Inna usługi']},
                    {id:4,name:'Mechanika pojazdowa',subCategory:['Wymiana rozrządu','Wymiana pompy wody','Głowica','Wymiana uszczelni pokrywy zaworu',
                        'Wtryski benzynowe - naprawa i regeneracja','Regeneracja turbosprężarek','Wymiana chłodnicy','Wymiana nagrzewnicy',
                        'Wymiana poduszki silnika','Wymiana termostatu','Wymiana paska klinowego','Wymiana pompy paliwa','Inna usługa']},
                    {id:5,name:'Klimatyzacja',subCategory:['Nabijanie i kontrola szczelności','Odgrzybianie','Wymiana kompresora klimatyzacji','Diagnostyka',
                        'Inna usługa']},
                    {id:6,name:'Układ kierowniczy',subCategory:['Wymiana pompy wspomagania kierownicy',
                        'Wymiana przekładni kierowniczej maglownicy','Wymiana drążków kierowniczych','Geometria kół','Wymiana kolumny kierowniczej',
                        'Przekładnia kierownicy','Inna usługa']},
                    {id:7,name:'Układ zawieszenia',subCategory:['Wymiana amortyzatorów','Wymiana sprężyny','Wymiana wahacza','Wymiana łożyska',
                        'Wymiana przegubu','Wymiana półosi','Wymiana łącznika stabilizatora','Wymiana końcówki drążka','Wymiana piasty','Inna usługa']},
                    {id:8,name:'Wulkanizacja, koła i opony',subCategory:['Naprawa opon','Wymiana opon','Wyważanie kół','Wymiana kół','Inna usługa']},
                    {id:9,name:'Elektryka samochodowa i akumulatory',subCategory:['Wymiana bezpieczników','Wymiana żarówki','Wymiana akumulatora',
                        'Wymiana świec zapłonowych','Wymiana świec żarowych','Rozrusznik','Alternator','ICU','Inna usługa']},
                    {id:10,name:'Samochody hybrydowe i elektryczne',subCategory:['Naprawa - samochód elektryczny','Przegląd - samochód elektryczny',
                        'Naprawa - samochód hybrydoowy','Przegląd - samochód hybrydowy','Wymiana baterii - samochód hybrydowy','Inna usługa']},
                    {id:11,name:'Instalacja LPG i CNG',subCategory:['Naprawa LPG','Instalacja LPG','Naprawa CNG','Instalacja CNG', 'Inna usługa']},
                    {id:12,name:'Klucze, zamki i alarmy',subCategory:['Dorabianie kluczy','Awaryjne otwieranie','Centralne zamki','Kodowanie immobilizerem',
                        'Inna usługa']},
                    {id:13,name:'Szyby',subCategory:['Wymiana szyby','Naprawa szyby','Naprawa lusterka','Przyciemnianie szyb','Wymiana wycieraczek','Inna usługa']},
                    {id:14,name:'Naprawy lakiernicze i blacharskie',subCategory:['Lakierowanie elementów','Naprawy powypadkowe','Usuwanie wgnieceń','Spawanie',
                        'Inna usługa']},
                    {id:15,name:'System car audio i nawigacja',subCategory:['Wymiana głośników','Montaż subwoofera','Wymiana radia','Montaż CB radia','Nawigacja','Inna usługa']},
                    {id:16,name:'Auto detailing',subCategory:['Mycie auta','Czyszczenie wnętrza','Polerowanie lakieru','Renowacja lamp','Ozonowanie',
                        'Konserwacja podwozia','Czyszczenie tapicerki','Inna usługa']},
                    {id:17,name:'Tuning i oklejanie samochodów',subCategory:['Podnoszenie mocy silnika','Hamowania','Tuning optyczny','Zawieszenie sportowe',
                        'Przyciemnianie szyb','Oklejanie samochodu folią','Inna usługa']},
                    {id:18,name:'Nie jestem pewien',subCategory:['Samochód traci moc','Samochód nie odpala','Samochód kopci','Jest wyciek',
                        'Stuki w zawieszeniu','Dziwne dźwięki','Wibracje','Dziwny zapach w samochodzie','Proszę się opierać na moim opisie...']},
                ],
                indexOfSubcategory:0,
                showSubcategory:false,
                descriptionRules: [v => v.length <= 250 || 'Max 250 characters'],
            }
        },
        validations:{
            repair:{
                car:{
                    required
                },
                category:{
                    required
                },
                subCategory:{
                    required
                },
                description:{
                    required,
                    maxLength:maxLength(250)
                },
                contact:{
                    required
                }
            }
        },
        methods:{
            closeDialog(){
                this.repair = {
                    car:'',
                    company:this.company,
                    category:'',
                    subCategory:'',
                    description:'',
                    contact:'',
                };
                this.$store.commit('setShowAskForRepair', false);
            },
            showCategory(){
                this.showSubcategory = true;
            },
            async saveRepair(){
                const res = await this.callApi('post','/addRepair', this.repair);
                if(res.status === 201){
                    console.log('Dodano naprawę');
                    this.$router.push(`/UserRepairDetails/${res.data.id}`)
                }else{
                    this.$toast.error('Nie udało się dodać komentarza, proszę spróbować później.')
                }
                this.$store.commit('setShowLoginComponent', true);
                this.$store.commit('setShowRegisterComponent', false);
            },
        },
        // async created() {
        //     const companyId = parseInt(this.$route.params.id);
        //     if(!companyId){
        //         this.$router.push('/pagenotfound');
        //     }
        //     const [res, savedComments] = await Promise.all([
        //         this.callApi('get',`/getMechanicDetails/${companyId}`),
        //         this.callApi('get',`/getMechanicComments/${companyId}`),
        //     ]);
        //     // const res = await this.callApi('get',`/getMechanicDetails/${companyId}`);
        //     if(res.status === 200){
        //         this.company = res.data;
        //         this.location = JSON.parse(this.company.location);
        //     }
        //     if(savedComments.status === 200){
        //         this.comments = savedComments.data[0];
        //         this.commentsDate = savedComments.data[1];
        //         this.companyRating = savedComments.data[2];
        //     }
        //     this.avatarTag = this.company.user.name.charAt(0) + this.company.user.surname.charAt(0);
        // },
        async created(){
            const [res,userCars] = await Promise.all([
                this.callApi('get','/getCarsBrandAndModels'),
                this.callApi('get','/getUserCars'),
            ]);
            if(res.status === 200){
                this.carBrands = res.data[0];
                this.carModels = res.data[1];
            }else{
                this.$toast.error('Problem przy pobieraniu marek i modeli samochodów. Proszę odświeżyć stronę.');
            }
            if(userCars.status ===200){
                this.userCars = userCars.data;
            }else{
                this.$toast.error('Problem przy pobieraniu samochodów. Proszę odświeżyć stronę.');
            }
        },
        computed:{
            carErrors(){
                const errors = [];
                if (!this.$v.repair.car.$dirty) return errors;
                !this.$v.repair.car.required && errors.push('To pole jest wymagane.');
                return errors;
            },
            categoryErrors(){
                const errors = [];
                if (!this.$v.repair.category.$dirty) return errors;
                !this.$v.repair.category.required && errors.push('To pole jest wymagane.');
                return errors;
            },
            subcategoryErrors(){
                const errors = [];
                if (!this.$v.repair.subCategory.$dirty) return errors;
                !this.$v.repair.subCategory.required && errors.push('To pole jest wymagane.');
                return errors;
            },
            descriptionErrors(){
                const errors = [];
                if (!this.$v.repair.description.$dirty) return errors;
                !this.$v.repair.description.required && errors.push('To pole jest wymagane.');
                !this.$v.repair.description.maxLength && errors.push('Maksymalnie 250 znaków.');

                return errors;
            },
            contactErrors(){
                const errors = [];
                if (!this.$v.repair.contact.$dirty) return errors;
                !this.$v.repair.contact.required && errors.push('To pole jest wymagane.');
                return errors;
            },
        }

    }
</script>
