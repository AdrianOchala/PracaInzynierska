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
                                ></v-select>
                            </v-col>
                            <v-col cols="12" lg="6">
                                <v-select :items="repairCategories"
                                          item-text="name"
                                          item-value="id"
                                          v-model="repair.category"
                                          label="Kategoria naprawy"
                                          @change="showCategory"
                                ></v-select>
                            </v-col>
                            <v-col cols="12" lg="6">
                                <v-select v-if="showSubcategory" :items="repairCategories[repair.category].subCategory"
                                          v-model="repair.subCategory"
                                          label="Kategoria naprawy"
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
                                ></v-textarea>
                            </v-col>
                            <v-col cols="12" lg="12">
                                <h4>Preferowany kontakt przez: </h4>
                                <v-radio-group v-model="repair.contact" row class="label">
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
                    <v-btn text color="primary" @click="saveRepair">Zapytaj</v-btn>
                </v-card-actions>
            </v-card>

</template>
<script>
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
                        'Wymiana filtra paliwa', 'Wymiana płynu chłodniczego']},
                    {id:1,name:'Diagnostyka auta', subCategory:['Diagnostyka komputerowa', 'Przegląd przed zakupem']},
                ],
                indexOfSubcategory:0,
                showSubcategory:false,
                descriptionRules: [v => v.length <= 250 || 'Max 250 characters'],
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
        }

    }
</script>
