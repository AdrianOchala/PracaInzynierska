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
                        <v-btn color="rgba(0, 0, 0, 0.6)" outlined class="mt-1" @click="showMessageModal()">
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
                    <v-row>
                    <v-col cols="12">
                    <v-chip v-for="(spec,index) in company.specialization" :key="index"
                        class="ma-2"
                        color="green"
                        text-color="white"
                    >
                        {{spec.name}}
                    </v-chip>
                    </v-col>
                    <v-col cols="12" v-if="company.description">
                        <h5>Opis właściciela:</h5>
                        {{company.description}}
                    </v-col>
                    <v-col cols="12" v-if="company.hours">
                        <h5>Godziny otwarcia:</h5>
                        <span v-for="hour in company.hours">
                            <span v-if="hour.from !==null & hour.to !== null">
                                {{hour.day}}: {{hour.from}}-{{hour.to}}<br>
                            </span>
                            <span v-else-if="hour.from === null">
                                {{ hour.day}}: Zamknięte <br>
                            </span>
                        </span>
                    </v-col>
                    </v-row>
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
                                <v-divider v-if="index < comments.length - 1">
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
                                :error-messages="addRatingErrors"
                                @input="$v.comment.rating.$touch()"
                                @blur="$v.comment.rating.$touch()"
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
                            :error-messages="addCommentErrors"
                            @input="$v.comment.comment.$touch()"
                            @blur="$v.comment.comment.$touch()"
                        ></v-textarea>
                    </v-container>
                    <div class="container-fluid commentButton">
                        <v-btn class="mb-3" @click="addComment" :disabled="$v.comment.$invalid">Dodaj!</v-btn>
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
            <v-dialog v-model="showSendMessageModal" persistent max-width="700px">
                <v-card>
                    <v-card-title class="justify-center ">
                        <h4>Wyślij wiadomość do właściciela</h4>
                    </v-card-title>
                    <v-card-text>
                        <v-text-field v-model="message.title" label="Tytuł"></v-text-field>
                        <v-textarea
                            clearable
                            counter
                            clear-icon="mdi-close-circle"
                            label="Treść wiadomości"
                            v-model="message.message"
                            hint="Max 250 znaków"
                            filled
                            auto-grow
                            background-color="#CFD8DC"
                            rows="1"
                        ></v-textarea>
                    </v-card-text>
                    <v-card-actions class="justify-center">
                        <v-btn text color="primary" @click="closeMessageModal">Anuluj</v-btn>
                        <v-btn text color="primary" @click="sendUserMessage" >Wyślij</v-btn>
                    </v-card-actions>
                </v-card>
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
    import {required, minLength,maxLength,between,numeric} from 'vuelidate/lib/validators';
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
                    rating:null,
                },
                rules: [v => v.length <= 250 || 'Max 250 characters'],
                showSendMessageModal:false,
                message:{
                    title:'',
                    message:'',
                    userId:0,
                },
                total:4,
                paginationInfo:{
                    current_page:0,
                    total:0
                },
            }
        },
        validations:{
            comment:{
                comment:{
                    required,
                    maxLength:maxLength(250)
                },
                rating:{
                    required
                }
            }
        },
        methods:{
            async sendUserMessage(){
                this.message.userId = this.company.user_id;
                const response = await this.callApi('post', '/sendUserMessage', this.message);
                if (response.status === 201) {
                    this.showSendMessageModal = false;
                    this.$toast.success('Pomyślnie wysłano wiadomość');
                    const clearMessage = {
                        title: '',
                        message: '',
                        userId: null,
                    };
                    this.message = clearMessage;
                } else {
                    this.$toast.error('Problem z wysłaniem wiadomości. Proszę spróbować później.')
                }
            },
            closeMessageModal(){
                this.showSendMessageModal = false;
                this.message.title = '';
                this.message.message = '';
            },
            showMessageModal(){
                this.showSendMessageModal = true;
            },
            showAskForRepair(){
                this.$store.commit('setShowAskForRepair', true);
            },
            reportComment(index){
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
            async getCommentsForPagination(page = 1){

                const companyId = parseInt(this.$route.params.id);
                const response = await this.callApi('get',`/getMechanicComments/${companyId}?page=${page}&total=${this.total}`);
                if(response.status ===200){

                    this.comments = response.data[0].data;
                    this.paginationInfo.current_page = response.data[0].current_page;
                    this.paginationInfo.total = response.data[0].last_page;

                    console.log(this.paginationInfo);
                    this.commentsDate = response.data[1];
                }
            }
        },
        async created() {
            const companyId = parseInt(this.$route.params.id);
            if(!companyId){
                this.$router.push('/pagenotfound');
            }
            const [res] = await Promise.all([
                this.callApi('get',`/getMechanicDetails/${companyId}`),
                // this.callApi('get',`/getMechanicComments/${companyId}`),
            ]);
            if(res.status === 200){
                this.company = res.data[0];
                this.companyRating = res.data[1];
                console.log(this.companyRating)
                this.location = JSON.parse(this.company.location);
                this.company.hours = JSON.parse(this.company.hours);

            }
            // if(savedComments.status === 200){
            //     this.comments = savedComments.data[0];
            //     this.commentsDate = savedComments.data[1];
            // }
            this.avatarTag = this.company.user.name.charAt(0) + this.company.user.surname.charAt(0);
            this.getCommentsForPagination();
        },
        computed:{
            ...mapGetters(['getShowAskForRepair','getReportComponent','getUser']),
            addCommentErrors(){
                const errors = [];
                if (!this.$v.comment.comment.$dirty) return errors;
                !this.$v.comment.comment.required && errors.push('To pole jest wymagane.');
                !this.$v.comment.comment.maxLength && errors.push('Maksymalnie 250 znaków>.');
                return errors;
            },
            addRatingErrors(){
                const errors = [];
                if (!this.$v.comment.rating.$dirty) return errors;
                !this.$v.comment.rating.required && errors.push('To pole jest wymagane.');
                return errors;
            },
        },

    }
</script>
