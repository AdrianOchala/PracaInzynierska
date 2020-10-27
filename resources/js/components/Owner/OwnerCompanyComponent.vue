<template>
    <div class="container-fluid">
        <v-row>
            <v-col cols="12" lg="6">
                <v-card>
                    <v-card-title style="background: rgba(0, 0, 0, 0.7); color: white;">
                        Informacje o warsztacie
                        <v-spacer></v-spacer>
                        <v-btn outlined color="white" @click="showEditCompany">Edytuj dane</v-btn>
                        <v-dialog v-model="getShowEditCompany" persistent width="700px">
                            <edit-company :company="userCompany"></edit-company>
                        </v-dialog>
                    </v-card-title>
                    <v-card-text>
                        <v-row>
                            <v-col cols="6">
                                <v-text-field
                                    class="mb-0"
                                    label="Nazwa warsztatu"
                                    v-model="userCompany.name"
                                    outlined
                                    disabled
                                ></v-text-field>
                            </v-col>
                            <v-col cols="6">
                                <v-text-field
                                    label="Właściciel warsztatu"
                                    v-model="fullname"
                                    outlined
                                    disabled
                                ></v-text-field>
                            </v-col>
                            <v-col cols="6">
                                <v-text-field
                                    class="mb-0"
                                    label="NIP"
                                    v-model="userCompany.NIP"
                                    outlined
                                    disabled
                                ></v-text-field>
                            </v-col>
                            <v-col cols="6">
                                <v-text-field
                                    label="Adres"
                                    v-model="fullAddress"
                                    outlined
                                    disabled
                                ></v-text-field>
                            </v-col>
                            <v-col cols="6" v-for="(number,index) in userCompany.phones" :key="index">
                                <v-text-field
                                    label="Numer"
                                    v-model="number.number"
                                    outlined
                                    disabled
                                ></v-text-field>
                            </v-col>
                            <v-col cols="12">
                                <v-chip v-for="(spec,index) in userCompany.specialization" :key="index"
                                        class="ma-2"
                                        color="green"
                                        text-color="white"
                                >
                                    {{spec.name}}
                                </v-chip>
                            </v-col>
                        </v-row>
                    </v-card-text>
                </v-card>
            </v-col>
            <v-col cols="12" lg="6">
                <v-card>
                    <v-card-title style="background: rgba(0, 0, 0, 0.7); color: white;">Nowe zlecenia</v-card-title>
                    <v-card-text>
                        <v-simple-table>
                            <thead>
                            <tr>
                                <th class="text-left">Data zgłoszenia</th>
                                <th class="text-left">Status</th>
                                <th class="text-left">Samochód</th>
                                <th class="text-left">Akcje</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(repair,i) in newRepairs" :key="i">
                                <td>{{ repair.created_at }}</td>
                                <td>{{ repair.status }}</td>
                                <td>{{repair.car.model.brand.name}} {{ repair.car.model.name }}</td>
                                <!--                        Edycja i usuwanie roli-->
                                <td>
                                    <v-btn color="green" @click="$router.push(`/OwnerRepairDetails/${repair.id}`)">Otwórz</v-btn>
                                </td>
                            </tr>
                            </tbody>
                        </v-simple-table>
                    </v-card-text>
                </v-card>
            </v-col>
            <v-col cols="12" lg="12">
            <v-card>
                <v-card-title style="background: rgba(0, 0, 0, 0.7); color: white;"><h4 class="mb-0">Aktualne naprawy</h4></v-card-title>
                <v-card-text>
                    <v-simple-table>
                        <thead>
                        <tr>
                            <th class="text-left">Data rozpoczęcia</th>
                            <th class="text-left">Status</th>
                            <th class="text-left">Samochód</th>
                            <th class="text-left">Akcje</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="(repair,i) in inProgressRepairs" :key="i">
                            <td>{{ repair.created_at }}</td>
                            <td>{{ repair.status }}</td>
                            <td>{{repair.car.model.brand.name}} {{ repair.car.model.name }}</td>
                            <!--                        Edycja i usuwanie roli-->
                            <td>
                                <v-btn color="green" @click="$router.push(`/OwnerRepairDetails/${repair.id}`)">Otwórz</v-btn>
                            </td>
                        </tr>
                        </tbody>
                    </v-simple-table>
                </v-card-text>
            </v-card>
        </v-col>
            <v-col cols="12" lg="12">
                <v-card>
                    <v-card-title style="background: rgba(0, 0, 0, 0.7); color: white; "><h4 class="mb-0">Zakończone naprawy</h4></v-card-title>
                    <v-card-text>
                        <v-simple-table>
                            <thead>
                            <tr>
                                <th class="text-left">Data zakończenia</th>
                                <th class="text-left">Cena</th>
                                <th class="text-left">Warsztat</th>
                                <th class="text-left">Status</th>
                                <th class="text-left">Samochód</th>
                                <th class="text-left">Akcje</th>
                            </tr>
                            </thead>
                            <tbody>
<!--                            <tr v-for="(repair,i) in userRepairs" :key="i">-->
<!--                                <td>{{ repair.updated_at }}</td>-->
<!--                                <td>{{ repair.price }}</td>-->
<!--                                <td>{{ repair.company.name }}</td>-->
<!--                                <td>{{ repair.status }}</td>-->
<!--                                <td>{{repair.car.model.brand.name}} {{ repair.car.model.name }}</td>-->
<!--                                &lt;!&ndash;                        Edycja i usuwanie roli&ndash;&gt;-->
<!--                                <td>-->
<!--                                    <v-btn color="green" @click="$router.push(`/UserRepairDetails/${repair.id}`)">Otwórz</v-btn>-->
<!--                                </td>-->
<!--                            </tr>-->
                            </tbody>
                        </v-simple-table>
                    </v-card-text>
                </v-card>
            </v-col>
        </v-row>
        <v-row>
            dalsze info
        </v-row>
    </div>
</template>
<script>
    import deleteModal from '../Modals/DeleteModalComponent';
    import editCompany from '../Modals/EditCompanyComponent';
    import {mapGetters} from 'vuex';
    export default {
        name:'UserRepair',
        components:{
            deleteModal,editCompany
        },
        data(){
            return{
                userCompany:'',
                fullname:'',
                fullAddress:'',
                newRepairs:'',
                inProgressRepairs:'',
                // userRepairs:'',
            }
        },
        methods:{
            showEditCompany(){
                this.$store.commit('setShowEditCompany', true);
            }
        },
        async created() {
            const user_id = this.getUser.id;
            const [userCompany] = await Promise.all([
                this.callApi('get',`/getOwnerCompany/${user_id}`),
            ]);
            if(userCompany.status === 200){
                this.userCompany = userCompany.data[0];
                this.newRepairs = userCompany.data[1];
                this.inProgressRepairs = userCompany.data[2];
                console.log(this.newRepairs)
                this.fullname = this.userCompany.user.name +" "+ this.userCompany.user.surname;
                this.fullAddress = this.userCompany.city + " ul." + this.userCompany.street + " "+this.userCompany.zipCode;
                this.userCompany.phones = JSON.parse(this.userCompany.phones);
            }else{
                this.$toast.error('Nie udało się pobrac danych firmy')
            }
        },
        computed:{
            ...mapGetters(['getUser','getShowEditCompany']),

        },
        watch:{

        },
    }
</script>
