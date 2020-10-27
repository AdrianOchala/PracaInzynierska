<template>
    <div class="container-fluid">
        <v-row>
            <v-col cols="12" lg="6">
            <v-card v-if="company">
                <v-list-item>
                <v-list-item-avatar color="grey">{{avatarTag}}</v-list-item-avatar>
                <v-list-item-content>
                    <v-list-item-title class="headline">{{company.user.name}} {{company.user.surname}} "{{company.name}}"</v-list-item-title>
                    <v-list-item-subtitle>{{company.city}} {{company.zipCode}} {{company.street}}</v-list-item-subtitle>
                </v-list-item-content>
                    <v-list-item-action><v-btn color="green" outlined @click="showAskForRepair">
                        Złóż zapytanie
                    </v-btn>
                        <v-btn color="rgba(0, 0, 0, 0.6)" outlined class="mt-1">
                            Wyślij wiadomość
                        </v-btn>
                        <v-btn outlined color="red" @click="reportCompany(company.id)" class="mt-1">Zgłoś warsztat</v-btn>
                    </v-list-item-action>
                </v-list-item>
                <v-divider></v-divider>
                <companyLocation :center="location" :name="company.name"></companyLocation>
                <v-divider></v-divider>
                <v-list-item-content class="pl-4 pr-4">
                    <h3>O warsztacie</h3>
                    <p>Warsztat znajduje się w mieście {{company.city}} na ulicy {{company.street}}.</p>
                    <p>Główne specjalizację warsztatu:</p>
                    <v-row><v-col>
                    <v-chip v-for="(spec,index) in company.specialization" :key="index"
                        class="ma-2"
                        color="green"
                        text-color="white"
                    >
                        {{spec.name}}
                    </v-chip>
                    </v-col></v-row>
                </v-list-item-content>
            </v-card>
            </v-col>
            <v-col lg="6">
            <v-card>
                <v-list-item>
                    <v-list-item-avatar color="grey"><v-icon>mdi-star-half-full</v-icon></v-list-item-avatar>
                    <v-list-item-content>
                        <v-list-item-title class="headline">Opinie o warsztacie</v-list-item-title>
                        <v-rating
                            :value="companyRating"
                            color="yellow darken-3"
                            background-color="grey darken-1"
                            empty-icon="$ratingFull"
                            medium
                            half-increments
                        ></v-rating>
                        ({{companyRating}})
                    </v-list-item-content>
                </v-list-item>
                <v-divider></v-divider>
<!--                    Ciało komentarzy-->
                <v-list-item-content>
                    <h3 class="justify-center d-flex" v-if="!comments">Brak opini o  tym warsztacie</h3>
                    <v-card v-else>
                    <v-list two-line>
                        <v-list-item-group>
                            <template v-for="(c, index) in comments">
                                <v-list-item>
                                    <template>
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
                                            ></v-rating>
                                            <v-btn outlined color="red" small @click="reportComment(c.id)">Zgłoś</v-btn>
                                        </v-list-item-action>
                                    </template>
                                </v-list-item>
                                <v-divider v-if="index < comments.length - 1">
                                </v-divider>
                            </template>
                            <v-divider></v-divider>
                            <v-pagination
                                v-model="page"
                                :length="3"
                            ></v-pagination>
                        </v-list-item-group>
                    </v-list>
                </v-card>
                </v-list-item-content>
                <v-divider></v-divider>
<!--                koniec komentarzy-->
<!--                Dodaj swój komentarz-->
                <template>
                    <div class="text-center">
                        <h3>Dodaj swój komentarz</h3>
                            <v-rating
                                v-model="comment.rating"
                                color="yellow darken-3"
                                background-color="grey darken-1"
                                empty-icon="$ratingFull"
                                half-increments
                                hover
                                medium
                            ></v-rating>
                    </div>
                    <v-container fluid class="pt-1">
                        <v-textarea
                            clearable
                            counter
                            clear-icon="mdi-close-circle"
                            label="Komentarz"
                            v-model="comment.comment"
                            hint="Max 250 znaków"
                            :rules="rules"
                            filled
                            auto-grow
                            background-color="#CFD8DC"
                            rows="1"
                        ></v-textarea>
                    </v-container>
                    <div class="container-fluid commentButton">
                        <v-btn class="mb-3" @click="addComment">Dodaj!</v-btn>
                    </div>

                </template>
            </v-card>
            </v-col>
            <v-dialog v-model="getShowAskForRepair" persistent width="700px">
                <ask-for-repair :company="company.id"></ask-for-repair>
            </v-dialog>
            <v-dialog v-model="getReportComponent.showReportComponent" persistent width="700px">
                <report-component>
                    <h4 slot="header">Czy napewno chcesz zgłosić ten komentarz?</h4>
                </report-component>
            </v-dialog>
        </v-row>
    </div>
</template>
<style scoped>
    .commentButton{
        text-align: right;
    }
</style>
<script>
    import companyLocation from '../Modals/SingleCompanyLocationComponent';
    import askForRepair from '../Modals/AskForRepairComponent';
    import reportComponent from '../Modals/ReportComponent';
    import {mapGetters} from 'vuex';
    export default{
        components:{ companyLocation,askForRepair,reportComponent },
        data(){
            return{
                company:'', //Dany warsztat
                location:'', //Współrzędne gotowe do przekazania do mapy
                avatarTag:',',
                comments:'', //Komentarze do warsztatu
                commentsDate:'', //Daty przekształcone na odpowiednią wartość
                companyRating:0,
                comment:{
                    companyId: '',
                    userId:this.$store.state.user.id,
                    comment:'',
                    rating:0,
                },
                rules: [v => v.length <= 250 || 'Max 250 characters'],
                page:2,
            }
        },
        methods:{
            showAskForRepair(){
                this.$store.commit('setShowAskForRepair', true);
            },
            reportComment(index){
                console.log(index)
                const reportInfo = {
                    showReportComponent:true,
                    reportUrl:'/reportComment',
                    targetIndex:index,
                    reportObject: 'komentarz',
                };
                this.$store.commit('setReportComponent',reportInfo);
            },
            reportCompany(index){
                const reportInfo = {
                    showReportComponent:true,
                    reportUrl:'/reportCompany',
                    targetIndex:index,
                    reportObject: 'warsztat',
                };
                this.$store.commit('setReportComponent',reportInfo);
            },
            async addComment(){
                this.comment.companyId = this.company.id;
                const res = await this.callApi('post','/addComment', this.comment)
                if(res.status === 200){
                    this.$toast.success('Pomyślnie dodano komentarz!')
                    this.$router.go();
                }else{
                    this.$toast.error('Nie udało się dodać komentarza, proszę spróbować później.')
                }
            },
        },
        async created() {
            const companyId = parseInt(this.$route.params.id);
            if(!companyId){
                this.$router.push('/pagenotfound');
            }
            const [res, savedComments] = await Promise.all([
                this.callApi('get',`/getMechanicDetails/${companyId}`),
                this.callApi('get',`/getMechanicComments/${companyId}`),
            ]);
            if(res.status === 200){
                this.company = res.data;
                this.location = JSON.parse(this.company.location);
            }
            if(savedComments.status === 200){
                this.comments = savedComments.data[0];
                this.commentsDate = savedComments.data[1];
                this.companyRating = savedComments.data[2];
            }
            this.avatarTag = this.company.user.name.charAt(0) + this.company.user.surname.charAt(0);
        },
        computed:{
            ...mapGetters(['getShowAskForRepair','getReportComponent']),

        },

    }
</script>
