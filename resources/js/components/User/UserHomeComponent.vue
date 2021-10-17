<template>
    <div class="container-fluid">
        <v-row class="justify-content-center">
            <v-card>
                <v-card-title style="background: rgba(0, 0, 0, 0.7); color: white; "
                              class="justify-content-center">Ostatnio dodane warsztaty</v-card-title>

            <v-row class="justify-content-center my-2" no-gutters>
                <v-col lg="3" md="6" sm="12" xs="12"  v-for="(company,index) in newCompanies" :key="company.id">
                    <v-card class="mx-2">
                        <v-card-title style="background: rgba(0, 0, 0, 0.7); color: white; ">
                            {{company.user.name}} {{company.user.surname}} "{{company.name}}"
                            <v-spacer></v-spacer>
                            <v-btn text color="white" small class="px-0" @click="$router.push(`/MechanicDetails/${company.id}`)">
                                <v-icon >mdi-open-in-new</v-icon>
                            </v-btn>
                        </v-card-title>
                        <v-card-text>
                            <h4 v-if="company.description">Opis właściciela</h4>
                            <p>{{company.description}}</p>
                            <v-divider></v-divider>
                            <v-chip v-for="(spec,index) in company.specialization" :key="index"
                                    class="ma-2"
                                    color="green"
                                    text-color="white"
                            >
                                {{spec.name}}
                            </v-chip>
                        </v-card-text>
                    </v-card>
                </v-col>
            </v-row>
            </v-card>
        </v-row>
        <v-row class="justify-content-center">
            <v-card>
                <v-card-title style="background: rgba(0, 0, 0, 0.7); color: white; "
                              class="justify-content-center">Najlepiej ocenione warsztaty</v-card-title>

                <v-row class="justify-content-center my-2" no-gutters>
                    <v-col lg="3" md="6" sm="12" xs="12"  v-for="(company,index) in bestCompanies" :key="company.id">
                        <v-card class="mx-2">
                            <v-card-title style="background: rgba(0, 0, 0, 0.7); color: white; ">
                                #{{index + 1}} {{company.user.name}} {{company.user.surname}} "{{company.name}}"
                                <v-spacer></v-spacer>
                                <v-btn color="white" text class="px-0" small @click="$router.push(`/MechanicDetails/${company.id}`)">
                                    <v-icon>mdi-open-in-new</v-icon>
                                </v-btn>
                            </v-card-title>
                            <v-card-text>
                                <h4 v-if="company.description">Opis właściciela</h4>
                                <p>{{company.description}}</p>
                                <v-divider></v-divider>
                                <v-chip v-for="(spec,index) in company.specialization" :key="index"
                                        class="ma-2"
                                        color="green"
                                        text-color="white"
                                >
                                    {{spec.name}}
                                </v-chip>
                            </v-card-text>
                        </v-card>
                    </v-col>
                </v-row>
            </v-card>
        </v-row>
        <v-row class="justify-content-center">
            <v-card class="nomanie">
                <v-card-title style="background: rgba(0, 0, 0, 0.7); color: white; "
                              class="justify-content-center">Ostatnio dodane komentarze</v-card-title>

                <v-row class="justify-content-center my-2" no-gutters>
                    <v-col lg="6" md="6" sm="12" xs="12"  v-for="(c,index) in comments" :key="c.id">
                        <v-card>
                            <v-card-title>{{c.company.name}}</v-card-title>
                            <v-list two-line>
                                <v-list-item-group>
                                        <v-list-item>
                                                <v-list-item-content>
                                                    <v-list-item-title>{{c.user.name}} {{c.user.surname}}</v-list-item-title>
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
                                                </v-list-item-action>
                                        </v-list-item>
                                </v-list-item-group>
                            </v-list>
                        </v-card>
                    </v-col>
                </v-row>
            </v-card>
        </v-row>

    </div>
</template>
<script>
    export default {
        name:'Home',
        data(){
            return{
                newCompanies:'',
                bestCompanies:'',
                comments:'',
                commentsDate:[],
            }
        },
        async created() {
            const res = await this.callApi('get','/getNewMechanics');
            if(res.status === 200){
                this.newCompanies = res.data;
                console.log(this.newCompanies)
            }else{
                this.$toast.error('Nie udało się pobrać nowych warsztatów, odśwież stronę');
            }
            const bestCompanies = await this.callApi('get','/bestCompanies');
            if(bestCompanies.status ===200){
                this.bestCompanies = bestCompanies.data;

            }else{
                this.$toast.error('Nie udało się pobrać najlepiej ocenionych warsztatów, odśwież stronę');
            }
            const comments = await this.callApi('get','/getLastComments');
            if(comments.status ===200){
                this.comments = comments.data[0];
                this.commentsDate = comments.data[1];
                console.log(this.comments)
                console.log(this.commentsDate)
            }else{
                this.$toast.error('Nie udało się pobrać nowych komentarzy, odśwież stronę');
            }
        }
    }
</script>
