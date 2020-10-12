<template>
    <div class="container-fluid">
        <v-row>
            <v-col cols="12" lg="7">
                <v-card v-if="userRepair">
                    <v-card-title style="background: rgba(0, 0, 0, 0.7); color: white; ">
                        Szczegóły naprawy {{userRepair.car.model.brand.name}} {{userRepair.car.model.name}}
                        <v-spacer></v-spacer>
                        <v-btn outlined color="white">Status: " {{userRepair.status}}"</v-btn>
                    </v-card-title>
                    <v-card-text>
                        <v-list two-line subheader>
                            <v-list-item>
                                <v-row><v-col cols="12" lg="6">
                                <v-list-item-content>
                                    <v-list-item-title>Warsztat</v-list-item-title>
                                    <v-list-item-subtitle>{{userRepair.company.name}}</v-list-item-subtitle>
                                </v-list-item-content>
                                </v-col>
                                <v-col cols="12" lg="6">
                                    <v-list-item-content>
                                        <v-list-item-title>Temat naprawy</v-list-item-title>
                                        <v-list-item-subtitle>{{userRepair.category}}</v-list-item-subtitle>
                                    </v-list-item-content>
                                </v-col></v-row>
                            </v-list-item>
                            <v-list-item>
                                <v-row><v-col cols="12" lg="6">
                                <v-list-item-content>
                                    <v-list-item-title>Samochód</v-list-item-title>
                                    <v-list-item-subtitle>{{userRepair.car.model.brand.name}} {{userRepair.car.model.name}}</v-list-item-subtitle>
                                </v-list-item-content>
                                </v-col>
                                <v-col cols="12" lg="6">
                                    <v-list-item-content>
                                        <v-list-item-title>Preferowany kontakt</v-list-item-title>
                                        <v-list-item-subtitle>{{userRepair.contact}}</v-list-item-subtitle>
                                    </v-list-item-content>
                                </v-col></v-row>
                            </v-list-item>
                            <v-list-item>
                                <v-list-item-content>
                                    <v-list-item-title><v-textarea
                                        label="Problem użytkownika"
                                        v-model="userRepair.description"
                                        filled
                                        auto-grow
                                        background-color="#CFD8DC"
                                        rows="1"
                                    ></v-textarea></v-list-item-title>
                                </v-list-item-content>
                            </v-list-item>
                            <v-list-item>
                                <v-list-item-content>
                                    <v-list-item-title><v-textarea
                                        label="Odpowiedź warsztatu"
                                        v-model="userRepair.companyReply"
                                        filled
                                        auto-grow
                                        background-color="#CFD8DC"
                                        rows="1"
                                    ></v-textarea></v-list-item-title>
                                </v-list-item-content>
                            </v-list-item>
                            <v-list-item>
                                <v-list-item-content>
                                    <v-list-item-title v-if="userRepair.price > 0">Cena: {{userRepair.price}}</v-list-item-title>
                                    <v-list-item-title style="text-align: center" v-else>
                                        <v-btn outlined >Cena: Brak podanej ceny przez warsztat</v-btn>
                                    </v-list-item-title>
                                </v-list-item-content>
                            </v-list-item>
                        </v-list>

                    </v-card-text>
                </v-card>
            </v-col>
            <v-col cols="12" lg="5">
                <v-card>
                    <v-card-title style="background: rgba(0, 0, 0, 0.7); color: white; ">Czat</v-card-title>
                </v-card>
            </v-col>
        </v-row>
    </div>
</template>
<script>
    import {mapGetters} from 'vuex';
    export default {
        name:'UserRepairDetails',
        components:{

        },
        data(){
            return{
                userRepair:'',
            }
        },
        methods:{

        },
        async created() {
            const repairId = parseInt(this.$route.params.id);
            const [userRepair] = await Promise.all([
                this.callApi('get',`/getRepairDetails/${repairId}`),
            ]);
            if(userRepair.status === 200){
                this.userRepair = userRepair.data;
            }else{
                this.$toast.error('Błąd');
            }
        },
        computed:{

        },
        watch:{

        },
    }
</script>
