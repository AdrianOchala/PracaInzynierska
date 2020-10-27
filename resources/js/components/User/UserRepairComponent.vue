<template>
    <div class="container-fluid">
        <v-row>
            <v-col cols="12" lg="6">
            <v-card>
                <v-card-title style="background: rgba(0, 0, 0, 0.7); color: white; "><h4 class="mb-0">Oczekujące na zatwierdzenie naprawy</h4></v-card-title>
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
                        <tr v-for="(repair,i) in userWaitingRepairs" :key="i">
                            <td>{{ userWaitingRepairsDates[i] }}</td>
                            <td>{{ repair.status }}</td>
                            <td>{{repair.car.model.brand.name}} {{ repair.car.model.name }}</td>
                            <!--                        Edycja i usuwanie roli-->
                            <td>
                                <v-btn color="green" @click="$router.push(`/UserRepairDetails/${repair.id}`)">Otwórz</v-btn>
                            </td>
                        </tr>
                        </tbody>
                    </v-simple-table>
                </v-card-text>
            </v-card>
        </v-col>
            <v-col cols="12" lg="6">
                <v-card>
                    <v-card-title style="background: rgba(0, 0, 0, 0.7); color: white; "><h4 class="mb-0">Aktualne naprawy</h4></v-card-title>
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
                            <tr v-for="(repair,i) in userInProgressRepairs" :key="i">
                                <td>{{ userInProgressRepairsDates[i] }}</td>
                                <td>{{ repair.status }}</td>
                                <td>{{repair.car.model.brand.name}} {{ repair.car.model.name }}</td>
                                <!--                        Edycja i usuwanie roli-->
                                <td>
                                    <v-btn color="green" @click="$router.push(`/UserRepairDetails/${repair.id}`)">Otwórz</v-btn>
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
                            <tr v-for="(repair,i) in userFinishedRepairs" :key="i">
                                <td>{{ userFinishedRepairsDates[i] }}</td>
                                <td>{{ repair.price }}</td>
                                <td>{{ repair.company.name }}</td>
                                <td>{{ repair.status }}</td>
                                <td>{{repair.car.model.brand.name}} {{ repair.car.model.name }}</td>
                                <!--                        Edycja i usuwanie roli-->
                                <td>
                                    <v-btn color="green" @click="$router.push(`/UserRepairDetails/${repair.id}`)">Otwórz</v-btn>
                                </td>
                            </tr>
                            </tbody>
                        </v-simple-table>
                        <h5 style="text-align:center">Brak zakończonych napraw</h5>
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
    import {mapGetters} from 'vuex';
    export default {
        name:'UserRepair',
        components:{
            deleteModal,
        },
        data(){
            return{
                userWaitingRepairs:'',
                userWaitingRepairsDates:'',
                userInProgressRepairs:'',
                userInProgressRepairsDates:'',
                userFinishedRepairs:'',
                userFinishedRepairsDates:'',
            }
        },
        methods:{

        },
        async created() {
            const [userRepairs] = await Promise.all([
                this.callApi('get','/getUserRepairs'),
            ]);
            if(userRepairs.status === 200){
                this.userWaitingRepairs = userRepairs.data[0];
                this.userWaitingRepairsDates = userRepairs.data[1];
                this.userInProgressRepairs = userRepairs.data[2];
                this.userInProgressRepairsDates = userRepairs.data[3];
                this.userFinishedRepairs = userRepairs.data[4];
                this.userFinishedRepairsDates = userRepairs.data[5];
            }else{
                this.$toast.error('Nie udało się pobrać napraw z bazy danych. Proszę odświeżyć stronę');
            }
        },
        computed:{

        },
        watch:{

        },
    }
</script>
