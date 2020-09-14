<template>
    <div class="container-fluid">
        <div class="container-fluid">
            <v-row>
                <v-col cols="12" md="6">
                <h1>Roles in system</h1>
                <!-- Pop-out dla dodania roli -->
                <v-dialog v-model="dialog" persistent max-width="600px">
                    <template v-slot:activator="{ on, attrs }">
                        <v-btn color="primary" dark v-bind="attrs" v-on="on"> Dodaj rolę </v-btn>
                    </template>
                    <v-card>
                        <v-card-title>
                            <span class="headline">Dodaj rolę do systemu</span>
                        </v-card-title>
                        <v-card-text>
                            <v-container>
                                <v-row>
                                    <v-col cols="12">
                                        <v-text-field name="name" label="Nazwa roli...*" required v-model="data.name" :rules="rules"></v-text-field>
                                    </v-col>
                                    <span v-if="errors.name"><v-alert color="red" dense>{{errors.name[0]}}</v-alert></span>
                                </v-row>
                            </v-container>
                            <small>*obowiązkowe pole</small>
                            <v-alert :value="alert" color="red" dark transition="scale-transition">
                                {{alertDescription}}
                            </v-alert>
                        </v-card-text>
                        <v-card-actions>
                            <v-spacer></v-spacer>
                            <v-btn color="blue darken-1" text @click="dialog = false">Close</v-btn>
                            <v-btn color="blue darken-1" text @click="addRole" :disabled="isAdding" :loading="isAdding">{{isAdding ? 'Dodawanie' : 'Dodaj rolę'}}</v-btn>
                        </v-card-actions>
                    </v-card>
                </v-dialog>
                <!-- /Pop-out dla dodania roli -->
                 <!--Tabela wyświetlająca role-->
                <v-simple-table>
                    <template v-slot:default>
                        <thead>
                        <tr>
                            <th class="text-left">Name</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="(role,i) in roles" :key="i">
                            <td>{{ role.name }}</td>
    <!--                        Edycja i usuwanie roli-->
                            <td>
                                <v-btn color="dark" @click="showEditDialog(role,i)">Edytuj</v-btn>

                                <v-btn color="red" @click="showDeletingModal(role,i)">Usuń</v-btn>
                            </td>
                        </tr>
                        </tbody>
                    </template>
                </v-simple-table>
                <!--/Tabela wyświetlająca role-->
                </v-col>
                    <v-col md="6">
                        Ok
                    </v-col>
            </v-row>
        </div>
            <!-- Pop-out dla edycji roli -->
            <v-dialog v-model="editdialog" max-width="500px">
                <v-card>
                    <v-card-text>
                        <v-text-field v-model="editdata.name"></v-text-field>

                        <small class="grey--text">* Nazwa musi być unikalna</small>
                    </v-card-text>

                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn text color="primary" @click="editRole">Zapisz</v-btn>
                    </v-card-actions>
                </v-card>
            </v-dialog>
            <!-- /Pop-out dla edycji roli -->

            <!--Pop-out potwierdzający usunięcie roli-->
            <deleteModal>
                <h4 slot="header">Czy napewno chcesz usunąć rolę?</h4>
            </deleteModal>
            <!--/Pop-out potwierdzający usunięcie roli-->

    </div>
</template>

<script>
    import deleteModal from '../components/Modals/DeleteModalComponent';
    import {mapGetters} from 'vuex';
    export default {
        name: "AdminRoleComponent",
        components:{
            deleteModal,
        },
        data(){
            return{
                data:{
                    name:'',
                },
                editdata:{
                    name:'',
                },
                roles:[],
                dialog: false,
                editdialog: false,
                alert: false,
                alertDescription:'',
                isAdding: false,
                rules: [v => v.length <= 25 || 'Max 25 characters'],
                errors:[],
                index:0,
            }
        },
        async created(){
            const res = await this.callApi('get', '/getRole');
            if(res.status === 200){
                this.roles = res.data
            }else{
                console.log('Nie można pobrać ról!')
            }

        },
        methods:{
            async addRole(){
                if(this.data.name.trim()===''){
                    this.alertDescription='Podaj nazwę roli!';
                    this.$toast.error("Podaj nazwę roli !");
                    return this.alert=true;
                }else{
                    this.alertDescription='';
                    this.alert=false;
                }
                const res = await this.callApi('post', '/addRole', this.data);
                if(res.status === 201)
                {
                    this.roles.unshift(res.data);
                    console.log('Dodano rolę');
                    this.$toast.success("Pomyślnie dodano rolę :)", { timeout: 3000 });
                    this.dialog = false;
                    this.data.name='';
                }else{
                    if(res.data.errors.name){
                        this.errors = res.data.errors
                    }
                    this.alertDescription='Nie można dodać roli. Popraw błędy stosując się do podanych zasad :)';
                    return this.alert=true;
                }
            },
            async editRole(){


                const res = await this.callApi('post', '/editRole', this.editdata);
                if(res.status === 200)
                {
                    this.roles[this.index].name = this.editdata.name;
                    this.$toast.success("Pomyślnie zaaktualizowano nazwę roli :)");
                    this.editdialog = false;
                }else{
                    if(res.data.errors.name){
                        this.errors = res.data.errors
                    }
                    this.alertDescription='Nie można dodać roli. Popraw błędy stosując się do podanych zasad :)';
                    return this.alert=true;
                }
            },
            showEditDialog(role, index){
                let singleRole = {
                    id : role.id,
                    name : role.name
                };
                this.index = index;
                this.editdata = singleRole;
                this.editdialog = true;
            },
            showDeletingModal(role, index){
                const deleteModalData = {
                        showDeleteModal: true,
                        deleteUrl: "deleteRole",
                        data: role,
                        deletingIndex: index,
                        isDeleted: false,
                }
                this.$store.commit('setDeletingModalData', deleteModalData);
            },

        },
        computed:{
            ...mapGetters(['getDeleteModalData'])
        },
        watch:{
            getDeleteModalData(obj){
                if(obj.isDeleted){
                    this.roles.splice(obj.deletingIndex, 1);
                }
            }
        },



    }
</script>
