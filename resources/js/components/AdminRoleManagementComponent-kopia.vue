<template>
    <v-app>
        <v-container>
            <v-row class="justify-center">
                <v-col cols="12" md="6">
                    <h2>Edycja uprawnień w systemie</h2><br>
                    <v-select v-model="selectedRole"
                        :items="roles"
                        item-text="name"
                        item-value="id"
                        label="Wybierz rolę"
                       @change="changeRole"
                    ></v-select>

                <v-simple-table>
                        <thead>
                        <tr>
                            <th class="text-left">Dostęp</th>
                            <th class="text-left">Widok</th>
                            <th class="text-left">Zapis</th>
                            <th class="text-left">Edycja</th>
                            <th class="text-left">Usuwanie</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="(r,i) in resources" :key="i">
                            <td>{{ r.resourceName }}</td>
                            <td><v-checkbox v-model=r.read></v-checkbox></td>
                            <td><v-checkbox v-model=r.write></v-checkbox></td>
                            <td><v-checkbox v-model=r.update></v-checkbox></td>
                            <td><v-checkbox v-model=r.delete></v-checkbox></td>
                        </tr>
                        </tbody>
                    <v-btn @click="assignPermissions">Zapisz</v-btn>
                </v-simple-table>
                </v-col>
            </v-row>
        </v-container>

    </v-app>
</template>

<script>
    export default {
        name: "AdminRoleManagementComponent",
        data(){
            return{
                resources:[
                    {resourceName: 'Strona główna',read: false, write: false, update:false, delete:true, name:'/'},
                    {resourceName: 'Role',read: false, write: false, update:false, delete:true, name:'AdminRole'},
                    {resourceName: 'Zarządzanie rolami',read: false, write: false, update:false, delete:true, name:'AdminRoleManagement'},

                    {resourceName: 'Szukaj mechanika',read: false, write: false, update:false, delete:true, name:'SearchMechanic'},
                ],
                defaultResources:[
                    {resourceName: 'Strona główna',read: false, write: false, update:false, delete:false, name:'/'},
                    {resourceName: 'Role',read: false, write: false, update:false, delete:false, name:'AdminRole'},
                    {resourceName: 'Zarządzanie rolami',read: false, write: false, update:false, delete:false, name:'AdminRoleManagement'},

                    {resourceName: 'Szukaj mechanika',read: false, write: false, update:false, delete:false, name:'SearchMechanic'},
                ],
                roles:[],
                selectedRole:null,
            }
        },
        methods:{
           async assignPermissions(){
                let data = JSON.stringify(this.resources);
                const res = await this.callApi('post','assignPermissions',{'permission': data, id : this.selectedRole });
               if(res.status ===200){
                   this.$toast.success('Pomyślnie zaktualizowano uprawnienia')
               }else{
                   this.$toast.warning('Coś poszło nie tak')
               }
            },
             changeRole(){
                 let index = this.roles.findIndex(role => role.id === this.selectedRole)
                 let permission = this.roles[index].permission
                 if(!permission){
                     this.resources = this.defaultResources
                 }else{
                     this.resources = JSON.parse(permission)
                 }

            },
        },
       async created(){
            const res = await this.callApi('get','getRole');
           if(res.status ===200){
               this.roles = res.data;
               if(res.data.length){
                   this.selectedRole = res.data[0].id;
                   if(res.data[0].permission){
                       this.resources = JSON.parse(res.data[0].permission)
                   }
               }
           }else{
               this.$toast.warning('Coś poszło nie tak');
           }
       },


    }
</script>
