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
                        :rules="rules"
                        filled
                        auto-grow
                        background-color="#CFD8DC"
                        rows="1"
                    ></v-textarea>
                </v-card-text>
                <v-card-actions class="justify-center">
                    <v-btn text color="primary" @click="closeModal">Anuluj</v-btn>
                    <v-btn text color="primary" @click="report">Zgłoś</v-btn>
                </v-card-actions>
            </v-card>

</template>
<script>
    import {mapGetters} from 'vuex'
    export default{
        data(){
            return{
                reason:'',
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
                const res = await this.callApi('post', this.getReportComponent.reportUrl, {index:this.getReportComponent.targetIndex});
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
        },
    }
</script>
