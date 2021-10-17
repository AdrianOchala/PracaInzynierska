<template>

            <v-card>
              <v-card-title class="justify-center text-danger">
                  <h4>Czy na pewno chcesz zgłosić ten {{getReportComponent.reportObject}}? </h4>

              </v-card-title>
                <v-card-text>
                    <v-textarea
                        clearable
                        counter
                        clear-icon="mdi-close-circle"
                        label="Powód zgłoszenia"
                        v-model="reason"
                        hint="Max 250 znaków"
                        filled
                        auto-grow
                        background-color="#CFD8DC"
                        rows="1"
                        :error-messages="addReasonErrors"
                        @input="$v.reason.$touch()"
                        @blur="$v.reason.$touch()"
                    ></v-textarea>
                </v-card-text>
                <v-card-actions class="justify-center">
                    <v-btn text color="primary" @click="closeModal">Anuluj</v-btn>
                    <v-btn text color="primary" @click="report" :disabled="$v.reason.$invalid">Zgłoś</v-btn>
                </v-card-actions>
            </v-card>

</template>
<script>
    import {mapGetters} from 'vuex';
    import {required, minLength,maxLength,between,numeric} from 'vuelidate/lib/validators';

    export default{
        data(){
            return{
                reason:'',
            }
        },
        validations:{
            reason:{
                required,
                maxLength:maxLength(250)
            }
        },
        methods:{
            closeModal(){
                const reportInfo = {
                    showReportComponent:false,
                    reportUrl:'',
                    targetIndex:0,
                    reportObject:'',
                };
                this.reason = '';
                this.$store.commit('setReportComponent',reportInfo);
            },
            async report(){
                const res = await this.callApi('post', this.getReportComponent.reportUrl, {index:this.getReportComponent.targetIndex,
                                                                                            reason:this.reason});
                if(res.status ===201){
                    this.$toast.success('Zgłosiłeś ' + this.getReportComponent.reportObject);
                    this.reason = '';
                    const reportInfo = {
                        showReportComponent:false,
                        reportUrl:'',
                        targetIndex:0,
                        reportObject: '',
                    };
                    this.$store.commit('setReportComponent',reportInfo);
                }else if(res.status === 401)
                {
                    console.log(res)
                    this.$toast.error(res.data.msg)
                }else{
                    this.$toast.warning('Oops! Coś poszło nie tak :(')
                }
            },
        },
        computed:{
            ...mapGetters(['getReportComponent']),
            addReasonErrors(){
                const errors = [];
                if (!this.$v.reason.$dirty) return errors;
                !this.$v.reason.required && errors.push('To pole jest wymagane.');
                !this.$v.reason.maxLength && errors.push('Maksymalnie 250 znaków.');
                return errors;
            },
        },
    }
</script>
