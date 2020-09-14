<template>
    <v-app>
        <v-dialog :value="getDeleteModalData.showDeleteModal" persistent max-width="500px">
            <v-card>
              <v-card-title class="justify-center text-danger">
                  <slot name="header">
                      default header
                  </slot>
              </v-card-title>
                <v-card-actions class="justify-center">

                    <v-btn text color="primary" @click="closeModal">Anuluj</v-btn>
                    <v-btn text color="primary" @click="deleteRole">Usuń</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </v-app>
</template>
<script>
    import {mapGetters} from 'vuex'
    export default{
        data(){
            return{

            }
        },
        methods:{
            closeModal(){
                this.$store.commit('setShowModal',false);
            },
            async deleteRole(){
                const res = await this.callApi('post', this.getDeleteModalData.deleteUrl, this.getDeleteModalData.data);
                if(res.status ===200){
                    this.$toast.success('Pomyślnie usunięto rolę z systemu :)');
                    this.$store.commit('setDeletingModalDataAfterDelete',{
                        index: this.getDeleteModalData.deletingIndex,
                        isDeleted: true,
                    });
                }else{
                    this.$toast.warning('Oops! Coś poszło nie tak :(')
                }
            },
        },
        computed:{
            ...mapGetters(['getDeleteModalData']),
        },
    }
</script>
