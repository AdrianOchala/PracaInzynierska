<template>
    <div class="container-fluid">
        <v-row>
        <v-col cols="3">
            <v-card>
                <v-card-title style="background: rgba(0, 0, 0, 0.7); color: white; ">Dane użytkownika
                    <v-spacer></v-spacer>
                <v-btn outlined color="white" @click="editUserData">Edytuj</v-btn>
                </v-card-title>
                <v-card-text v-if="user">
                    <v-row>
                        <v-col cols="12">
                            <v-text-field v-model="changeUserData ? user.name : editUser.name" label="Imię"
                                          :disabled="changeUserData"
                                             :error-messages="userNameErrors"
                                             @input="$v.user.name.$touch()"
                                             @blur="$v.user.name.$touch()"
                            ></v-text-field>
                        </v-col>
                        <v-col cols="12">
                            <v-text-field v-model="user.surname" label="Nazwisko"
                                          :disabled="changeUserData"
                                          :error-messages="userSurnameErrors"
                                          @input="$v.user.surname.$touch()"
                                          @blur="$v.user.surname.$touch()"
                            ></v-text-field>
                        </v-col>

                        <v-col cols="12">
                            <v-text-field v-model="user.email" label="Email"
                                          :disabled="changeUserData"
                                          :error-messages="userEmailErrors"
                                          @input="$v.user.email.$touch()"
                                          @blur="$v.user.email.$touch()"
                            ></v-text-field>
                        </v-col>
                        <v-col cols="12">
                            <v-text-field v-model="user.phone" label="Telefon"
                                          :disabled="changeUserData"
                                          :error-messages="userPhoneErrors"
                                          @input="$v.user.phone.$touch()"
                                          @blur="$v.user.phone.$touch()"
                            ></v-text-field>
                        </v-col>
                    </v-row>
                </v-card-text>
                <v-card-actions v-if="!changeUserData">
                    <v-btn outlined @click="cancelEditing">Anuluj</v-btn>
                    <v-spacer></v-spacer>
                    <v-btn outlined @click="editPersonalUserData">Zapisz</v-btn>
                </v-card-actions>
            </v-card>
        </v-col>
            <v-col cols="3">
                <v-card>
                    <v-card-title style="background: rgba(0, 0, 0, 0.7); color: white; ">Hasło użytkownika
                        <v-spacer></v-spacer>
                        <v-btn outlined color="white" @click="showEditingPassword">Edytuj</v-btn>
                    </v-card-title>
                    <v-card-text v-if="user && changeUserPassword">
                        <v-row>
                            <v-col cols="12">
                                <v-text-field v-model="userPassword" label="Stare hasło" :type="typ1"
                                              :append-outer-icon="'mdi-eye'"
                                              @click:append-outer="showOldPassword"
                                              :error-messages="userPasswordErrors"
                                              @input="$v.userPassword.$touch()"
                                              @blur="$v.userPassword.$touch()"
                                ></v-text-field>
                                <v-text-field v-model="userNewPassword" label="Nowe hasło" :type="typ2"
                                              :append-outer-icon="'mdi-eye'"
                                              @click:append-outer="showNewPassword"
                                              :error-messages="userNewPasswordErrors"
                                              @input="$v.userNewPassword.$touch()"
                                              @blur="$v.userNewPassword.$touch()"
                                ></v-text-field>
                                <v-text-field v-model="userNewRepeatPassword" label="Powtórz nowe hasło" :type="typ3"
                                              :append-outer-icon="'mdi-eye'"
                                              @click:append-outer="showRepeatPassword"
                                              :error-messages="userRepeatPasswordErrors"
                                              @input="$v.userNewRepeatPassword.$touch()"
                                              @blur="$v.userNewRepeatPassword.$touch()"
                                ></v-text-field>
                            </v-col>
                        </v-row>
                    </v-card-text>
                    <v-card-actions v-if="changeUserPassword">
                        <v-btn outlined @click="cancelEditingPassword">Anuluj</v-btn>
                        <v-spacer></v-spacer>
                        <v-btn outlined @click="editPassword">Zmień</v-btn>
                    </v-card-actions>
                </v-card>
            </v-col>
            <v-col cols="3">
                <v-card>
                    <v-card-title style="background: rgba(0, 0, 0, 0.7); color: white; ">
                        Dezaktywuj konto
                        <v-spacer></v-spacer>
                        <v-btn color="white" outlined @click="deleteAccountModal">Usuń</v-btn>
                    </v-card-title>
                    <v-dialog v-model="showDeleteModal" persistent max-width="500px">
                        <v-card>
                            <v-card-title class="justify-center text-danger">
                                Czy na pewno chcesz dezaktywować konto?
                            </v-card-title>
                            <v-card-actions class="justify-center">
                                <v-btn text color="primary" @click="closeDeleteAccountModal">Nie</v-btn>
                                <v-btn text color="primary" @click="deleteAccount">Tak</v-btn>
                            </v-card-actions>
                        </v-card>
                    </v-dialog>
                </v-card>
            </v-col>
        </v-row>
    </div>
</template>
<script>
    import {mapGetters} from 'vuex'
    import {required, minLength,maxLength, between, sameAs,email,numeric} from 'vuelidate/lib/validators';
    export default{
        name:'UserSettingsComponent',
        data(){
            return{
                editUser:null,
                user:null,
                changeUserData:true,
                changeUserPassword:false,
                fieldType:'password',
                userNewPassword:'',
                userNewRepeatPassword:'',
                userPassword:'',
                typ1:'password',
                typ2:'password',
                typ3:'password',
                showDeleteModal:false,
            }
        },
        validations: {
            user: {
                name: {
                    required: required,
                    minLength: minLength(3),
                },
                surname: {
                    required,
                    minLength: minLength(3),
                },
                email: {
                    required,
                    email: email,
                },
                phone: {
                    numeric,
                },
            },
            userPassword:{
                required
            },
            userNewPassword:{
                required,
                minLength:minLength(7)
            },
            userNewRepeatPassword:{
                sameAs:sameAs("userNewPassword")
            },
        },
        methods:{
            async deleteAccount(){
                const response = await this.callApi('get','/deleteAccount')
                if(response.status === 200){
                    window.location = '/logout';
                }
            },
            closeDeleteAccountModal(){
                this.showDeleteModal = false;
            },
            deleteAccountModal(){
                this.showDeleteModal = true;
            },
            showEditingPassword(){
                this.changeUserPassword = true;
            },
            cancelEditingPassword(){
                this.changeUserPassword = false;
                this.userNewPassword='';
                this.userNewRepeatPassword='';
                this.userPassword='';
            },
            showOldPassword(){
                if(this.typ1 === 'password'){
                    this.typ1 = 'text';
                }else{
                    this.typ1 = 'password';
                }
            },
            showNewPassword(){
                if(this.typ2 === 'password'){
                    this.typ2 = 'text';
                }else{
                    this.typ2 = 'password';
                }
            },
            showRepeatPassword(){
                if(this.typ3 === 'password'){
                    this.typ3 = 'text';
                }else{
                    this.typ3 = 'password';
                }
            },
            async editPassword(){
                const response = await this.callApi('post','/changeUserPassword',{userPassword:this.userPassword,
                                                                            userNewPassword:this.userNewPassword});
                if(response.status === 200){
                    this.$toast.success('Pomyślnie zmieniono hasło');
                    this.changeUserPassword = false;
                    this.userNewPassword='';
                    this.userNewRepeatPassword='';
                    this.userPassword='';
                }else{
                    this.$toast.error('Problem z edycją hasła. Proszę spróbować później.')
                }
            },
            cancelEditing(){
                console.log("po kliknięciu anuluj")
                console.log(this.editUser.name)
                console.log(this.user.name)
                this.changeUserData = true;
            },
            editUserData(){
                let userData ={
                    id:this.user.id,
                    name:this.user.name,
                    surname:this.user.surname,
                    email:this.user.email,
                    phone:this.user.phone
                };
                this.editUser = userData;
                this.changeUserData = false;
            },
            show(){
                console.log(this.user)
            },
            async editPersonalUserData(){
                console.log(this.editUser);
                const response = await this.callApi('post','/editPersonalUserData',this.editUser);
                if(response.status === 200){
                    this.user.name = this.editUser.name;
                    this.user.surname = this.editUser.surname;
                    this.user.email = this.editUser.email;
                    this.user.phone = this.editUser.phone;
                    this.$toast.success('Pomyślnie edytowano dane');
                    this.changeUserData = true;
                }else{
                    this.$toast.error('Problem z edycją danych. Proszę spróbować później.')
                }
            },
        },
        created(){
            this.user = this.getUser;
            console.log(this.user)
        },
        computed:{
            ...mapGetters(['getUser']),
            userNameErrors(){
                const errors = [];
                if (!this.$v.user.name.$dirty) return errors;
                !this.$v.user.name.minLength && errors.push('Podaj przynajmniej 3 znaki.');
                !this.$v.user.name.required && errors.push('Imię jest wymagane.');
                return errors;
            },
            userSurnameErrors(){
                const errors = [];
                if (!this.$v.user.surname.$dirty) return errors;
                !this.$v.user.surname.minLength && errors.push('Podaj przynajmniej 3 znaki.');
                !this.$v.user.surname.required && errors.push('Nazwisko jest wymagane.');
                return errors;
            },
            userEmailErrors(){
                const errors = [];
                if (!this.$v.user.email.$dirty) return errors;
                !this.$v.user.email.required && errors.push('E-mail jest wymagany.');
                !this.$v.user.email.email && errors.push('Adres e-mail nie poprawny.');
                return errors;
            },
            userPhoneErrors(){
                const errors = [];
                if (!this.$v.user.phone.$dirty) return errors;
                !this.$v.user.phone.numeric && errors.push('Wpisz tylko cyfry.');
                return errors;
            },
            userPasswordErrors(){
                const errors = [];
                if (!this.$v.userPassword.$dirty) return errors;
                !this.$v.userPassword.required && errors.push('Hasło jest wymagane.');
                return errors;
            },
            userNewPasswordErrors(){
                const errors = [];
                if (!this.$v.userNewPassword.$dirty) return errors;
                !this.$v.userNewPassword.required && errors.push('Hasło jest wymagane.');
                return errors;
            },
            userRepeatPasswordErrors(){
                const errors = [];
                if (!this.$v.userNewRepeatPassword.$dirty) return errors;
                !this.$v.userNewRepeatPassword.sameAs && errors.push('Hasła muszą być takie same.');
                return errors;
            },
        },
    }
</script>
