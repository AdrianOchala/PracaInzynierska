<template>
    <div class="container-fluid">
        <v-row >
            <v-col cols="12" lg="7">
                <h3 style="text-align:center">Twoje samochody <v-btn color="primary" @click="showAddCarDialog">Dodaj samochód</v-btn></h3>
<!--                Dialog dodawania samochodu-->
                <v-dialog v-model="addCarDialog" max-width="700px">
                    <v-card>
                        <v-card-title>Dodaj samochód</v-card-title>
                        <v-card-text>
                            <v-container>
                                <v-row>
                                    <v-col cols="12" lg="6">
                                        <v-select :items="carBrands"
                                                  item-text="name"
                                                  item-value="id"
                                                  v-model="car.brand"
                                                  label="Wybierz markę"
                                                  @change="selectedBrand"
                                        ></v-select>
                                    </v-col>
                                    <v-col cols="12" lg="6">
                                        <v-select :items="selectedBrandModels"
                                                  item-text="name"
                                                  item-value="id"
                                                  v-model="car.model"
                                                  label="Wybierz model"
                                        ></v-select>
                                    </v-col>
                                    <v-col cols="12" lg="6">
                                        <v-select :items="fuels"
                                                  v-model="car.fuel"
                                                  label="Wybierz paliwo"
                                        ></v-select>
                                    </v-col>
                                    <v-col cols="12" lg="6">
                                        <v-select :items="types"
                                                  v-model="car.type"
                                                  label="Wybierz typ nadwozia"
                                        ></v-select>
                                    </v-col>
                                    <v-col cols="12" lg="6">
                                        <v-select :items="transmissions"
                                                  v-model="car.transmission"
                                                  label="Wybierz skrzynię biegów"
                                        ></v-select>
                                    </v-col>
                                    <v-col cols="12" lg="6">
                                        <v-text-field
                                            v-model="car.mileage"
                                            label="Przebieg samochodu"
                                        ></v-text-field>
                                    </v-col>
                                    <v-col cols="12" lg="6">
                                        <v-menu
                                            ref="menupicker"
                                            v-model="menupicker"
                                            :close-on-content-click="false"
                                            :return-value.sync="car.service"
                                            transition="scale-transition"
                                            offset-y
                                            min-width="290px"
                                        >
                                            <template v-slot:activator="{ on, attrs }">
                                                <v-text-field
                                                    v-model="car.service"
                                                    label="Termin przeglądu technicznego"
                                                    prepend-icon="mdi-calendar"
                                                    readonly
                                                    v-bind="attrs"
                                                    v-on="on"
                                                ></v-text-field>
                                            </template>
                                            <v-date-picker
                                                v-model="car.service"
                                                scrollable
                                                locale="pl"
                                            >
                                                <v-spacer></v-spacer>
                                                <v-btn @click="resetDate">Resetuj</v-btn>
                                                <v-btn @click="menupicker = false">Anuluj</v-btn>
                                                <v-btn @click="$refs.menupicker.save(car.service)">Zapisz</v-btn>
                                            </v-date-picker>
                                        </v-menu>
                                    </v-col>
                                    <v-col cols="12" lg="6">
                                        <v-text-field
                                            v-model="car.production"
                                            label="Rok produkcji"
                                        ></v-text-field>
                                    </v-col>
                                    <v-col cols="12" lg="6">
                                        <v-text-field
                                            v-model="car.plate"
                                            label="Numer rejestracyjny"
                                        ></v-text-field>
                                    </v-col>
                                    <v-col cols="12" lg="6">
                                        <v-text-field
                                            v-model="car.engine"
                                            label="Pojemność silnika"
                                        ></v-text-field>
                                    </v-col>
                                    <v-col cols="12" lg="6">
                                        <v-text-field
                                            v-model="car.VIN"
                                            label="Numer VIN"
                                        ></v-text-field>
                                    </v-col>
                                </v-row>
                            </v-container>
                        </v-card-text>

                        <v-card-actions>
                            <v-spacer></v-spacer>
                            <v-btn text color="primary" @click="saveCar">Zapisz</v-btn>
                        </v-card-actions>
                    </v-card>
                </v-dialog>
<!--                    Moje samochody-->
                <v-expansion-panels>
                    <v-expansion-panel v-for="(userCar,i) in userCars" :key="i" >
                        <v-expansion-panel-header>
                            {{userCar.model.brand.name}} {{userCar.model.name}} {{userCar.plate}}
                            <v-spacer></v-spacer>
                            Szczegóły
                        </v-expansion-panel-header>
                        <v-expansion-panel-content>
                            <v-simple-table dark>
                                <template v-slot:default>
                                    <thead>
                                    <tr>
                                        <th class="text-left">
                                            Typ nadwozia
                                        </th>
                                        <th class="text-left">
                                            Rok produkcji
                                        </th>
                                        <th class="text-left">
                                            Paliwo
                                        </th>
                                        <th class="text-left">
                                            Skrzynia biegów
                                        </th>
                                        <th class="text-left">
                                            Pojemność
                                        </th>
                                        <th class="text-left">
                                            Przebieg
                                        </th>
                                        <th class="text-left">
                                            VIN
                                        </th>
                                        <th class="text-left">
                                            Opcje
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td>{{ userCar.type }}</td>
                                        <td>{{ userCar.production }}</td>
                                        <td>{{ userCar.fuel }}</td>
                                        <td>{{ userCar.transmission }}</td>
                                        <td>{{ userCar.engine }}</td>
                                        <td>{{ userCar.mileage }}</td>
                                        <td>{{ userCar.VIN }}</td>
                                        <td>
                                            <v-icon
                                                small
                                                class="mr-2"
                                                @click="showEditingModal(userCar,i,userCar.id)"
                                            >
                                                mdi-pencil
                                            </v-icon>
                                            <v-icon
                                                small
                                                @click="showDeletingModal(userCar,i)"
                                            >
                                                mdi-delete
                                            </v-icon>
                                        </td>
                                    </tr>
                                    </tbody>
                                </template>
                            </v-simple-table>
                            <deleteModal v-if="getDeleteModalData.showDeleteModal">
                                <h4 slot="header">Czy napewno chcesz usunąć samochód?</h4>
                            </deleteModal>
                            <h4>Przegląd samochodu ważny do: {{userCar.service}}</h4>
                        </v-expansion-panel-content>
                    </v-expansion-panel>
                </v-expansion-panels>
<!--                Editing modal-->
                <v-dialog v-model="editCarDialog" max-width="700px">
                    <v-card>
                        <v-card-title>Edytuj samochód</v-card-title>
                        <v-card-text>
                            <v-container>
                                <v-row>
                                    <v-col cols="12" lg="6">
                                        <v-select :items="carBrands"
                                                  item-text="name"
                                                  item-value="id"
                                                  v-model="editcar.brand"
                                                  label="Wybierz markę"
                                                  @change="selectedEditedBrand"
                                        ></v-select>
                                    </v-col>
                                    <v-col cols="12" lg="6">
                                        <v-select :items="selectedEditedBrandModels"
                                                  item-text="name"
                                                  item-value="id"
                                                  v-model="editcar.model"
                                                  label="Wybierz model"
                                        ></v-select>
                                    </v-col>
                                    <v-col cols="12" lg="6">
                                        <v-select :items="fuels"
                                                  v-model="editcar.fuel"
                                                  label="Wybierz paliwo"
                                        ></v-select>
                                    </v-col>
                                    <v-col cols="12" lg="6">
                                        <v-select :items="types"
                                                  v-model="editcar.type"
                                                  label="Wybierz typ nadwozia"
                                        ></v-select>
                                    </v-col>
                                    <v-col cols="12" lg="6">
                                        <v-select :items="transmissions"
                                                  v-model="editcar.transmission"
                                                  label="Wybierz skrzynię biegów"
                                        ></v-select>
                                    </v-col>
                                    <v-col cols="12" lg="6">
                                        <v-text-field
                                            v-model="editcar.mileage"
                                            label="Przebieg samochodu"
                                        ></v-text-field>
                                    </v-col>
                                    <v-col cols="12" lg="6">
                                        <v-menu
                                            ref="editmenupicker"
                                            v-model="editmenupicker"
                                            :close-on-content-click="false"
                                            :return-value.sync="editcar.service"
                                            transition="scale-transition"
                                            offset-y
                                            min-width="290px"
                                        >
                                            <template v-slot:activator="{ on, attrs }">
                                                <v-text-field
                                                    v-model="editcar.service"
                                                    label="Termin przeglądu technicznego"
                                                    prepend-icon="mdi-calendar"
                                                    readonly
                                                    v-bind="attrs"
                                                    v-on="on"
                                                ></v-text-field>
                                            </template>
                                            <v-date-picker
                                                v-model="editcar.service"
                                                scrollable
                                                locale="pl"
                                            >
                                                <v-spacer></v-spacer>
                                                <v-btn @click="resetEditDate">Resetuj</v-btn>
                                                <v-btn @click="editmenupicker = false">Anuluj</v-btn>
                                                <v-btn @click="$refs.editmenupicker.save(editcar.service)">Zapisz</v-btn>
                                            </v-date-picker>
                                        </v-menu>
                                    </v-col>
                                    <v-col cols="12" lg="6">
                                        <v-text-field
                                            v-model="editcar.production"
                                            label="Rok produkcji"
                                        ></v-text-field>
                                    </v-col>
                                    <v-col cols="12" lg="6">
                                        <v-text-field
                                            v-model="editcar.plate"
                                            label="Numer rejestracyjny"
                                        ></v-text-field>
                                    </v-col>
                                    <v-col cols="12" lg="6">
                                        <v-text-field
                                            v-model="editcar.engine"
                                            label="Pojemność silnika"
                                        ></v-text-field>
                                    </v-col>
                                    <v-col cols="12" lg="6">
                                        <v-text-field
                                            v-model="editcar.VIN"
                                            label="Numer VIN"
                                        ></v-text-field>
                                    </v-col>
                                </v-row>
                            </v-container>
                        </v-card-text>
                        <v-card-actions>
                            <v-spacer></v-spacer>
                            <v-btn text color="primary" @click="editCar">Edytuj</v-btn>
                        </v-card-actions>
                    </v-card>
                </v-dialog>
            </v-col>
            <v-col cols="12" lg="5">
                <v-card>
                    <v-card-title style="background: rgba(0, 0, 0, 0.7); color: white; "><h4 class="mb-0">Ważne informacje/Notatki</h4>
                    <v-spacer></v-spacer>
                    <v-btn @click="showAddNotesDialog">Dodaj notatkę</v-btn>
                    </v-card-title>
                    <v-card-text>
                        <v-row>
                        <v-card v-if="userNotes" v-for="(userNote,i) in userNotes" :key="i" width="190px" class="mx-2 my-1">
                            <v-card-title style="background: rgba(0, 50, 0, 0.7); color: white;">
                               {{userNote.title}}
                            </v-card-title>
                            <v-card-subtitle style="background: rgba(0, 50, 0, 0.7); color: white; " class="mt-0">
                                {{userNote.car.model.brand.name}} {{userNote.car.model.name}}
                            </v-card-subtitle>
                            <v-card-text>
                                {{userNote.description}}
                            </v-card-text>
                            <v-card-actions v-if="userNote.daysLeft < 7" style="background: rgba(217,30,24,0.8);">
                                Pozostało: {{userNote.daysLeft}} dni.
                            </v-card-actions>
                            <v-card-actions v-else>
                                Pozostało: {{userNote.daysLeft}} dni.
                            </v-card-actions>
                        </v-card>
                        </v-row>
                    </v-card-text>
                </v-card>
                <v-dialog v-model="addNotesDialog" max-width="700px">
                    <v-card>
                        <v-card-title>Dodaj notatkę</v-card-title>
                        <v-card-text>
                            <v-container>
                                <v-row>
                                    <v-col cols="12" lg="6">
                                        <v-select :items="userCars"
                                                  item-text="plate"
                                                  item-value="id"
                                                  v-model="note.car"
                                                  label="Wybierz swój samochód"
                                        ></v-select>
                                    </v-col>
                                    <v-col cols="12" lg="6">
                                        <v-menu
                                            ref="notemenupicker"
                                            v-model="notemenupicker"
                                            :close-on-content-click="false"
                                            :return-value.sync="note.date"
                                            transition="scale-transition"
                                            offset-y
                                            min-width="290px"
                                        >
                                            <template v-slot:activator="{ on, attrs }">
                                                <v-text-field
                                                    v-model="note.date"
                                                    label="Termin notatki"
                                                    prepend-icon="mdi-calendar"
                                                    readonly
                                                    v-bind="attrs"
                                                    v-on="on"
                                                ></v-text-field>
                                            </template>
                                            <v-date-picker
                                                v-model="note.date"
                                                scrollable
                                                locale="pl"
                                            >
                                                <v-spacer></v-spacer>
                                                <v-btn @click="resetNoteDate">Resetuj</v-btn>
                                                <v-btn @click="notemenupicker = false">Anuluj</v-btn>
                                                <v-btn @click="$refs.notemenupicker.save(note.date)">Zapisz</v-btn>
                                            </v-date-picker>
                                        </v-menu>
                                    </v-col>
                                    <v-col cols="12" lg="12">
                                        <v-text-field
                                            v-model="note.title"
                                            label="Tytuł"
                                        ></v-text-field>
                                    </v-col>
                                    <v-col cols="12" lg="12">
                                        <v-textarea
                                            clearable
                                            counter
                                            clear-icon="mdi-close-circle"
                                            label="Opis..."
                                            v-model="note.description"
                                            hint="Max 250 znaków"
                                            :rules="rules"
                                            filled
                                            auto-grow
                                            background-color="#CFD8DC"
                                            rows="1"
                                        ></v-textarea>
                                    </v-col>
                                </v-row>
                            </v-container>
                        </v-card-text>
                        <v-card-actions>
                            <v-spacer></v-spacer>
                            <v-btn text color="primary" @click="saveNote">Zapisz</v-btn>
                        </v-card-actions>
                    </v-card>
                </v-dialog>
            </v-col>
        </v-row>
        <v-row>
            dalsze info
        </v-row>
    </div>
</template>
<style scoped>

</style>
<script>
    import deleteModal from '../Modals/DeleteModalComponent';
    import {mapGetters} from 'vuex';
    import common from "../../common";
    export default {
        name:'UserCar',
        components:{
            deleteModal,
        },
        data(){
            return{
                addCarDialog:false,
                carBrands:'',
                selectedBrandModels:['Wybierz markę'],
                carModels:'',
                fuels:['Benzyna', 'Benzyna + LPG','Benzyna + CNG', 'Diesel', 'Diesel + LPG', 'Hybryda','Elektryczny','Etanol','Wodór'],
                types:['Kabriolet', 'Sedan','Coupe','Pickup','Hatchback','Kombi','Terenowy','Minibus','Minivan','SUV','Bus','Ciężarowy'],
                transmissions:['Automatyczna','Manualna'],
                menupicker:false,
                car:{
                    brand:'',
                    model:'',
                    fuel:'',
                    type:'',
                    production:'',
                    plate:'',
                    engine:'',
                    VIN:'',
                    transmission:'',
                    mileage:'',
                    service:'',
                },
                userCars:'',
                deletingModal:false,
            //    editing car
                editCarDialog:false,
                editingCarIndex:0,
                editmenupicker:false,
                editcar:{
                    carId:'',
                    brand:'',
                    model:'',
                    fuel:'',
                    type:'',
                    production:'',
                    plate:'',
                    engine:'',
                    VIN:'',
                    transmission:'',
                    mileage:'',
                    service:'',
                },
                selectedEditedBrandModels:[],
                userRepairs:'',
                addNotesDialog:false,
                notemenupicker:false,
                note:{
                    title:'',
                    date:'',
                    description:'',
                    car:'',
                },
                rules: [v => v.length <= 250 || 'Max 250 characters'],
                userNotes:'',
                testArray:[
                    {name: 'Adrian', miejsce:3},
                    {name: 'agata', miejsce:1},
                    {name: 'Adam', miejsce:2},
                ],
            }
        },
        methods:{
            async saveNote(){
              console.log(this.note);
                const res = await this.callApi('post','/addNote',this.note);
                if(res.status === 201){
                    this.$toast.success('Pomyślnie dodano notatkę');
                    this.addNotesDialog = false;
                    const clearNote = {
                        title:'',
                        date:'',
                        description:'',
                        car:'',
                    };
                    this.note = clearNote;
                }else{
                    this.$toast.error('Coś poszło nie tak');
                }
            },
            showAddNotesDialog(){
                this.addNotesDialog = true;
            },
            resetDate(){
                this.car.service = '';
            },
            resetEditDate(){
                this.editcar.service = '';
            },
            resetNoteDate(){
                this.note.date = '';
            },
            showEditingModal(car,index,carId){
                let singleCar = {
                    carId:carId,
                    brand:car.model.brand.id,
                    model:car.model.id,
                    fuel:car.fuel,
                    type:car.type,
                    production:car.production,
                    plate:car.plate,
                    engine:car.engine,
                    VIN:car.VIN,
                    transmission:car.transmission,
                    mileage:car.mileage,
                    service: car.service,
                };
              this.editCarDialog = true;
              this.editcar = singleCar;
              this.editingCarIndex = index;
              this.selectedEditedBrand();
            },
            async editCar(){
                const res = await this.callApi('post', '/editUserCar', this.editcar);
                if(res.status === 200)
                {
                    this.$router.go();
                }else{
                    // if(res.data.errors.name){
                    //     this.errors = res.data.errors;
                    // }
                    // this.alertDescription='Nie można dodać roli. Popraw błędy stosując się do podanych zasad :)';
                    // return this.alert=true;
                }
            },
            deleteCar(){
                console.log('Delete car method');
            },
            showDeletingModal(car, index){
                this.deletingModal = true;
                const deleteModalData = {
                    showDeleteModal: true,
                    deleteUrl: "/deleteUserCar",
                    data: car,
                    deletingIndex: index,
                    isDeleted: false,
                };
                this.$store.commit('setDeletingModalData', deleteModalData);
            },
            showAddCarDialog(){
                this.addCarDialog = true;
            },
            selectedBrand(){
                this.selectedBrandModels = [];
                for (let i = 0; i < this.carModels.length;i++ ){
                    if(this.carModels[i].carBrand_id === this.car.brand){
                        this.selectedBrandModels.push(this.carModels[i]);
                    }
                }
            },
            selectedEditedBrand(){
                this.selectedEditedBrandModels = [];
                for (let i = 0; i < this.carModels.length;i++ ){
                    if(this.carModels[i].carBrand_id === this.editcar.brand){
                        this.selectedEditedBrandModels.push(this.carModels[i]);
                    }
                }
            },
            async saveCar(){
                console.log(this.car);
                const res = await this.callApi('post','/saveCar',this.car);
                if(res.status === 201){
                    this.addCarDialog = false;
                    this.$toast.success('Pomyślnie dodano samochód');
                    this.$router.go();
                }else{
                    this.$toast.error('Nie udało się dodać samochodu');
                }
            },
        },
        async created() {
            const [res,userCars,userRepairs,userNotes] = await Promise.all([
                this.callApi('get','/getCarsBrandAndModels'),
                this.callApi('get','/getUserCars'),
                this.callApi('get','/getUserRepairs'),
                this.callApi('get','/getUserNotes'),
            ]);
            if(res.status === 200){
                this.carBrands = res.data[0];
                this.carModels = res.data[1];
            }else{
                this.$toast.error('Problem przy pobieraniu marek i modeli samochodów. Proszę odświeżyć stronę.');
            }
            if(userCars.status === 200){
                this.userCars = userCars.data;
            }else{
                this.$toast.error('Nie udało się pobrać dodanych samochodów z bazy danych. Proszę odświeżyć stronę');
            }
            if(userRepairs.status === 200){
                this.userRepairs = userRepairs.data;
            }else{
                this.$toast.error('Nie udało się pobrać napraw z bazy danych. Proszę odświeżyć stronę');
            }
            if(userNotes.status === 200){
                this.userNotes = userNotes.data;
                for(let i =0; i < this.userNotes.length;i++){
                    const today = new Date();
                    const noteDate = new Date(this.userNotes[i].date);
                    const differenceTime = noteDate.getTime() - today.getTime();
                    const diffrenceDays = Math.ceil(differenceTime / (1000*3600*24));
                    console.log('Dzisiaj' + today);
                    console.log('Notatka' + noteDate);
                    console.log(diffrenceDays);
                    this.userNotes[i].daysLeft = diffrenceDays;
                }
                this.userNotes.sort(function(a,b){
                    return a.daysLeft - b.daysLeft;
                });
            }else{
                this.$toast.error('Nie udało się pobrać notatek z bazy danych. Proszę odświeżyć stronę');
            }
        },
        computed:{
            ...mapGetters(['getDeleteModalData'])
        },
        watch:{
            getDeleteModalData(obj){
                if(obj.isDeleted){
                    this.userCars.splice(obj.deletingIndex, 1);
                }
            }
        },
    }
</script>
