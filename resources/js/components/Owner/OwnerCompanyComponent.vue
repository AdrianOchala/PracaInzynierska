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
                            <v-col cols="12" v-if="userCompany.description">
                                <h5>Opis właściciela:</h5>
                                {{userCompany.description}}
                            </v-col>
                            <v-col cols="12" v-if="userCompany.hours">
                                <h5>Godziny otwarcia:</h5>
                                <span v-for="hour in userCompany.hours">{{hour.day}}: {{hour.from}}-{{hour.to}}<br></span>
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
                                <td v-if="repair.car">{{repair.car.model.brand.name}} {{ repair.car.model.name }}</td>
                                <td v-if="!repair.car">Samochód usunięty</td>
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
            <v-col cols="12" lg="6">
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
                            <td v-if="repair.car">{{repair.car.model.brand.name}} {{ repair.car.model.name }}</td>
                            <td v-if="!repair.car">Samochód usunięty</td>
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
            <v-col cols="12" lg="6">
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
                            <tr v-for="(repair,i) in finishedRepairs" :key="i">
                                <td>{{ repair.updated_at }}</td>
                                <td>{{ repair.price }}</td>
                                <td>{{ repair.company.name }}</td>
                                <td>{{ repair.status }}</td>
                                <td v-if="repair.car">{{repair.car.model.brand.name}} {{ repair.car.model.name }}</td>
                                <td v-if="!repair.car">Samochód usunięty</td>
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
        </v-row>
        <v-row>
            <v-col cols="12" lg="12">
                <v-card>
                    <v-card-title style="background: rgba(0, 0, 0, 0.7); color: white; "><h4 class="mb-0">Komentarze</h4></v-card-title>
                    <v-card-text>
                        <v-card>
                            <v-list two-line>
                                <v-list-item-group>
                                    <template v-for="(c, index) in companyComments">
                                        <v-list-item>
                                            <template>
                                                <v-list-item-content>
                                                    <v-list-item-title v-if="c.user">{{c.user.name}} {{c.user.surname}}</v-list-item-title>
                                                    <v-list-item-title v-if="!c.user">Użytkownik usunięty</v-list-item-title>
                                                    <v-list-item-subtitle>{{c.comment}}</v-list-item-subtitle>
                                                </v-list-item-content>
                                                <v-list-item-action>
                                                    <v-list-item-action-text>{{commentsDate[index]}}</v-list-item-action-text>
                                                    <v-rating
                                                        v-model="c.rating"
                                                        color="yellow darken-3"
                                                        background-color="grey darken-1"
                                                        empty-icon="$ratingFull"
                                                        half-increments
                                                        hover
                                                        medium
                                                        readonly
                                                    ></v-rating>
                                                    <v-btn v-if="getUser.id === c.user.id" outlined small @click="reportComment(c.id)">Usuń komentarz</v-btn>
                                                    <v-btn v-else outlined color="red" small @click="reportComment(c.id)">Zgłoś</v-btn>
                                                </v-list-item-action>
                                            </template>
                                        </v-list-item>
                                        <v-divider v-if="index < companyComments.length - 1">
                                        </v-divider>
                                    </template>
                                    <v-divider></v-divider>
                                    <v-pagination v-if="paginationInfo"
                                                  :value="paginationInfo.current_page"
                                                  :length="paginationInfo.total"
                                                  @input="getCommentsForPagination"
                                    ></v-pagination>
                                </v-list-item-group>
                            </v-list>
                        </v-card>
                    </v-card-text>
                </v-card>

            </v-col>
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
                finishedRepairs:'',
                companyComments:'',
                total:4,
                paginationInfo:{
                    current_page:0,
                    total:0
                },
            }
        },
        methods:{
            showEditCompany(){
                this.$store.commit('setShowEditCompany', true);
            },
            async getCommentsForPagination(page = 1){

                const companyId = this.userCompany.id;
                const response = await this.callApi('get',`/getMechanicComments/${companyId}?page=${page}&total=${this.total}`);
                if(response.status ===200){
                    this.companyComments = response.data[0].data;
                    this.paginationInfo.current_page = response.data[0].current_page;
                    this.paginationInfo.total = response.data[0].last_page;
                    this.commentsDate = response.data[1];
                }
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
                this.finishedRepairs = userCompany.data[3];

                this.fullname = this.userCompany.user.name +" "+ this.userCompany.user.surname;
                this.fullAddress = this.userCompany.city + " ul." + this.userCompany.street + " "+this.userCompany.zipCode;
                this.userCompany.phones = JSON.parse(this.userCompany.phones);
                this.userCompany.hours = JSON.parse(this.userCompany.hours);
            }else{
                this.$toast.error('Nie udało się pobrac danych firmy')
            }
            this.getCommentsForPagination();
        },
        computed:{
            ...mapGetters(['getUser','getShowEditCompany']),

        },
        watch:{

        },
    }
</script>
