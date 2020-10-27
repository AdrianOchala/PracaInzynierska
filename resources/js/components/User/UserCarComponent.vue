<template>
    <div class="container-fluid">
        <v-row >
            <v-col cols="12" lg="7">
                <v-card>
                    <v-card-title style="background: rgba(0, 0, 0, 0.7); color: white; "><h4 class="mb-0">Twoje samochody</h4>
                        <v-spacer></v-spacer>
                        <v-btn @click="showAddCarDialog">Dodaj samochód</v-btn>
                    </v-card-title>
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
                                                  :error-messages="addCarBrandErrors"
                                                  @input="$v.car.brand.$touch()"
                                                  @blur="$v.car.brand.$touch()"
                                        ></v-select>
                                    </v-col>
                                    <v-col cols="12" lg="6">
                                        <v-select :items="selectedBrandModels"
                                                  item-text="name"
                                                  item-value="id"
                                                  v-model="car.model"
                                                  label="Wybierz model"
                                                  :error-messages="addCarModelErrors"
                                                  @input="$v.car.model.$touch()"
                                                  @blur="$v.car.model.$touch()"
                                        ></v-select>
                                    </v-col>
                                    <v-col cols="12" lg="6">
                                        <v-select :items="fuels"
                                                  v-model="car.fuel"
                                                  label="Wybierz paliwo"
                                                  :error-messages="addCarFuelErrors"
                                                  @input="$v.car.fuel.$touch()"
                                                  @blur="$v.car.fuel.$touch()"
                                        ></v-select>
                                    </v-col>
                                    <v-col cols="12" lg="6">
                                        <v-select :items="types"
                                                  v-model="car.type"
                                                  label="Wybierz typ nadwozia"
                                                  :error-messages="addCarTypeErrors"
                                                  @input="$v.car.type.$touch()"
                                                  @blur="$v.car.type.$touch()"
                                        ></v-select>
                                    </v-col>
                                    <v-col cols="12" lg="6">
                                        <v-select :items="transmissions"
                                                  v-model="car.transmission"
                                                  label="Wybierz skrzynię biegów"
                                                  :error-messages="addCarTransmissionErrors"
                                                  @input="$v.car.transmission.$touch()"
                                                  @blur="$v.car.transmission.$touch()"
                                        ></v-select>
                                    </v-col>
                                    <v-col cols="12" lg="6">
                                        <v-text-field
                                            v-model="car.mileage"
                                            label="Przebieg samochodu"
                                            :error-messages="addCarMileageErrors"
                                            @input="$v.car.mileage.$touch()"
                                            @blur="$v.car.mileage.$touch()"
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
                                            :error-messages="addCarProductionErrors"
                                            @input="$v.car.production.$touch()"
                                            @blur="$v.car.production.$touch()"
                                        ></v-text-field>
                                    </v-col>
                                    <v-col cols="12" lg="6">
                                        <v-text-field
                                            v-model="car.plate"
                                            label="Numer rejestracyjny"
                                            :error-messages="addCarPlateErrors"
                                            @input="$v.car.plate.$touch()"
                                            @blur="$v.car.plate.$touch()"
                                        ></v-text-field>
                                    </v-col>
                                    <v-col cols="12" lg="6">
                                        <v-text-field
                                            v-model="car.engine"
                                            label="Pojemność silnika"
                                            :error-messages="addCarEngineErrors"
                                            @input="$v.car.engine.$touch()"
                                            @blur="$v.car.engine.$touch()"
                                        ></v-text-field>
                                    </v-col>
                                    <v-col cols="12" lg="6">
                                        <v-text-field
                                            v-model="car.VIN"
                                            label="Numer VIN"
                                            :error-messages="addCarVINErrors"
                                            @input="$v.car.VIN.$touch()"
                                            @blur="$v.car.VIN.$touch()"
                                        ></v-text-field>
                                    </v-col>
                                </v-row>
                            </v-container>
                        </v-card-text>
                        <v-card-actions>
                            <v-spacer></v-spacer>
                            <v-btn text color="primary" @click="saveCar" :disabled="$v.car.$invalid">Zapisz</v-btn>
                        </v-card-actions>
                    </v-card>
                </v-dialog>
<!--                    Moje samochody-->
                    <v-card-text>
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
                    </v-card-text>
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
                                                  :error-messages="editCarBrandErrors"
                                                  @input="$v.editcar.brand.$touch()"
                                                  @blur="$v.editcar.brand.$touch()"
                                        ></v-select>
                                    </v-col>
                                    <v-col cols="12" lg="6">
                                        <v-select :items="selectedEditedBrandModels"
                                                  item-text="name"
                                                  item-value="id"
                                                  v-model="editcar.model"
                                                  label="Wybierz model"
                                                  :error-messages="editCarModelErrors"
                                                  @input="$v.editcar.model.$touch()"
                                                  @blur="$v.editcar.model.$touch()"
                                        ></v-select>
                                    </v-col>
                                    <v-col cols="12" lg="6">
                                        <v-select :items="fuels"
                                                  v-model="editcar.fuel"
                                                  label="Wybierz paliwo"
                                                  :error-messages="editCarFuelErrors"
                                                  @input="$v.editcar.fuel.$touch()"
                                                  @blur="$v.editcar.fuel.$touch()"
                                        ></v-select>
                                    </v-col>
                                    <v-col cols="12" lg="6">
                                        <v-select :items="types"
                                                  v-model="editcar.type"
                                                  label="Wybierz typ nadwozia"
                                                  :error-messages="editCarTypeErrors"
                                                  @input="$v.editcar.type.$touch()"
                                                  @blur="$v.editcar.type.$touch()"
                                        ></v-select>
                                    </v-col>
                                    <v-col cols="12" lg="6">
                                        <v-select :items="transmissions"
                                                  v-model="editcar.transmission"
                                                  label="Wybierz skrzynię biegów"
                                                  :error-messages="editCarTransmissionErrors"
                                                  @input="$v.editcar.transmission.$touch()"
                                                  @blur="$v.editcar.transmission.$touch()"
                                        ></v-select>
                                    </v-col>
                                    <v-col cols="12" lg="6">
                                        <v-text-field
                                            v-model="editcar.mileage"
                                            label="Przebieg samochodu"
                                            :error-messages="editCarMileageErrors"
                                            @input="$v.editcar.mileage.$touch()"
                                            @blur="$v.editcar.mileage.$touch()"
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
                                            :error-messages="editCarProductionErrors"
                                            @input="$v.editcar.production.$touch()"
                                            @blur="$v.editcar.production.$touch()"
                                        ></v-text-field>
                                    </v-col>
                                    <v-col cols="12" lg="6">
                                        <v-text-field
                                            v-model="editcar.plate"
                                            label="Numer rejestracyjny"
                                            :error-messages="editCarPlateErrors"
                                            @input="$v.editcar.plate.$touch()"
                                            @blur="$v.editcar.plate.$touch()"
                                        ></v-text-field>
                                    </v-col>
                                    <v-col cols="12" lg="6">
                                        <v-text-field
                                            v-model="editcar.engine"
                                            label="Pojemność silnika"
                                            :error-messages="editCarEngineErrors"
                                            @input="$v.editcar.engine.$touch()"
                                            @blur="$v.editcar.engine.$touch()"
                                        ></v-text-field>
                                    </v-col>
                                    <v-col cols="12" lg="6">
                                        <v-text-field
                                            v-model="editcar.VIN"
                                            label="Numer VIN"
                                            :error-messages="editCarVINErrors"
                                            @input="$v.editcar.VIN.$touch()"
                                            @blur="$v.editcar.VIN.$touch()"
                                        ></v-text-field>
                                    </v-col>
                                </v-row>
                            </v-container>
                        </v-card-text>
                        <v-card-actions>
                            <v-spacer></v-spacer>
                            <v-btn text color="primary" @click="editCar" :disabled="$v.editcar.$invalid">Edytuj</v-btn>
                        </v-card-actions>
                    </v-card>
                </v-dialog>
                </v-card>
            </v-col>
            <v-col cols="12" lg="5">
                <v-card>
                    <v-card-title style="background: rgba(0, 0, 0, 0.7); color: white; "><h4 class="mb-0">Ważne informacje/Notatki</h4>
                    <v-spacer></v-spacer>
                    <v-btn @click="showAddNotesDialog">Dodaj notatkę</v-btn>
                    </v-card-title>
                    <v-card-text>
                        <v-row>
                            <v-col cols="4" v-if="userNotes" v-for="(userNote,i) in userNotes" :key="i" id="create">
                            <v-card  width="190px" class="mx-2 my-1">
                                <v-card-title style="background: rgba(0, 0, 0, 0.5); color: white;">
                                    {{userNote.car.model.brand.name}} {{userNote.car.model.name}}
                                </v-card-title>
                                <v-card-text style="text-align: center;" class="pt-4">
                                    <h5>{{userNote.description}}</h5>
                                </v-card-text>
                                <v-card-actions v-if="userNote.daysLeft < 7" style="background: rgba(217,30,24,0.8);">
                                    Pozostało: {{userNote.daysLeft}} dni.
                                </v-card-actions>
                                <v-card-actions v-else>
                                    Pozostało: {{userNote.daysLeft}} dni.
                                </v-card-actions>
                            </v-card>
                                <v-speed-dial
                                    :top=true
                                    :right=true
                                    :direction="direction"
                                    :transition="transition"
                                    small
                                >
                                    <template v-slot:activator>
                                        <v-btn color="rgba(255, 255, 255, 0)" dark fab>
                                            <v-icon>
                                                mdi-wrench
                                            </v-icon>
                                        </v-btn>
                                    </template>
                                    <v-btn fab dark small color="green" @click="showEditNote(userNote)">
                                        <v-icon>mdi-pencil</v-icon>
                                    </v-btn>
                                    <v-btn fab dark small color="red" @click="showDeletingNotesModal(userNote,i)">
                                        <v-icon>mdi-delete</v-icon>
                                    </v-btn>
                                </v-speed-dial>
                            </v-col>
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
                                        <v-textarea
                                            clearable
                                            counter
                                            clear-icon="mdi-close-circle"
                                            label="Treść..."
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
                <v-dialog v-model="editNotesDialog" max-width="700px">
                    <v-card>
                        <v-card-title>Dodaj notatkę</v-card-title>
                        <v-card-text>
                            <v-container>
                                <v-row>
                                    <v-col cols="12" lg="6">
                                        <v-select :items="userCars"
                                                  item-text="plate"
                                                  item-value="id"
                                                  v-model="editnote.car"
                                                  label="Wybierz swój samochód"
                                        ></v-select>
                                    </v-col>
                                    <v-col cols="12" lg="6">
                                        <v-menu
                                            ref="notemenupicker"
                                            v-model="notemenupicker"
                                            :close-on-content-click="false"
                                            :return-value.sync="editnote.date"
                                            transition="scale-transition"
                                            offset-y
                                            min-width="290px"
                                        >
                                            <template v-slot:activator="{ on, attrs }">
                                                <v-text-field
                                                    v-model="editnote.date"
                                                    label="Termin notatki"
                                                    prepend-icon="mdi-calendar"
                                                    readonly
                                                    v-bind="attrs"
                                                    v-on="on"
                                                ></v-text-field>
                                            </template>
                                            <v-date-picker
                                                v-model="editnote.date"
                                                scrollable
                                                locale="pl"
                                            >
                                                <v-spacer></v-spacer>
                                                <v-btn @click="resetNoteDate">Resetuj</v-btn>
                                                <v-btn @click="notemenupicker = false">Anuluj</v-btn>
                                                <v-btn @click="$refs.notemenupicker.save(editnote.date)">Zapisz</v-btn>
                                            </v-date-picker>
                                        </v-menu>
                                    </v-col>
                                    <v-col cols="12" lg="12">
                                        <v-textarea
                                            clearable
                                            counter
                                            clear-icon="mdi-close-circle"
                                            label="Treść..."
                                            v-model="editnote.description"
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
                            <v-btn text color="primary" @click="saveEditedNote">Zapisz</v-btn>
                        </v-card-actions>
                    </v-card>
                </v-dialog>
                <deleteModal v-if="getDeleteModalData.showDeleteModal">
                    <h4 slot="header">Czy napewno chcesz usunąć notatkę?</h4>
                </deleteModal>
            </v-col>
        </v-row>
        <v-row>

        </v-row>
    </div>
</template>
<style scoped>

        /* This is for documentation purposes and will not be needed in your application */
    #create .v-speed-dial {
        position: absolute;
    }

    #create .v-btn--floating {
        position: relative;
    }
        .v-speed-dial--right {
            right: 12px;
        }
        .v-btn--icon.v-size--default .v-icon, .v-btn--fab.v-size--default .v-icon {
            height: 28px;
            font-size: 28px;
            width: 28px;
        }
        .v-btn--fab.v-size--default {
            height: 28px;
            width: 28px;
        }
</style>
<script>
    import deleteModal from '../Modals/DeleteModalComponent';
    import {mapGetters} from 'vuex';
    import common from "../../common";
    import {required, minLength,maxLength,between,numeric} from 'vuelidate/lib/validators';
    export default {
        name:'UserCar',
        components:{
            deleteModal,
        },
        data(){
            return{
                fab: false,
                direction:'bottom',
                transition: 'scale-transition',
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
                    date:'',
                    description:'',
                    car:'',
                },
                editNotesDialog:false,
                editnote:{
                    id:'',
                    date:'',
                    description:'',
                    car:'',
                },
                rules: [v => v.length <= 250 || 'Max 250 characters'],
                userNotes:'',
                deletingCar:false,
                deletingNote:false,
            }
        },
        validations:{
            car:{
                brand:{
                    required
                },
                model:{
                    required
                },
                fuel:{
                    required
                },
                type:{
                    required
                },
                transmission:{
                    required
                },
                mileage:{
                    numeric,
                    maxLength:maxLength(8)
                },
                production:{
                    required,
                    between:between(1900,2020)
                },
                plate:{
                    required,
                    maxLength:maxLength(7)
                },
                engine:{
                    required
                },
                VIN:{
                    required,
                    minLength:minLength(17),
                    maxLength:maxLength(17)
                },


            },
            editcar:{
                brand:{
                    required
                },
                model:{
                    required
                },
                fuel:{
                    required
                },
                type:{
                    required
                },
                transmission:{
                    required
                },
                mileage:{
                    numeric,
                    maxLength:maxLength(8)
                },
                production:{
                    required,
                    between:between(1900,2020)
                },
                plate:{
                    required,
                    maxLength:maxLength(7)
                },
                engine:{
                    required
                },
                VIN:{
                    required,
                    minLength:minLength(17),
                    maxLength:maxLength(17)
                },


            }
        },
        methods:{
            showDeletingNotesModal(userNote, index){
                const deleteModalData = {
                    showDeleteModal: true,
                    deleteUrl: "/deleteUserNote",
                    data: userNote,
                    deletingIndex: index,
                    isDeleted: false,
                };
                this.deletingNote = true;
                this.$store.commit('setDeletingModalData', deleteModalData);
            },
            showEditNote(note){
                this.editNotesDialog = true;
                this.editnote.id = note.id;
                this.editnote.date = note.date;
                this.editnote.description = note.description;
                this.editnote.car = note.car.id;
            },
            async saveEditedNote(){
                console.log(this.editnote)
                const res = await this.callApi('post', '/editUserNote', this.editnote);
                if(res.status === 200)
                {
                    this.$toast.success('Pomyślnie edytowano notatkę', { timeout: 3000 });
                    this.editNotesDialog = false;
                    const clearNote = {
                        id:'',
                        date:'',
                        description:'',
                        car:'',
                    };
                    this.editnote = clearNote;
                    setTimeout(() => {
                        this.$router.go();
                    }, 3000)
                }else{
                    this.$toast.error('Błąd edycji samochodu');
                }
            },
            deleteNote(index){
                console.log(index)
            },
            async saveNote(){
                const res = await this.callApi('post','/addNote',this.note);
                if(res.status === 201){
                    this.$toast.success('Pomyślnie dodano notatkę', { timeout: 2000 });
                    this.addNotesDialog = false;
                    const clearNote = {
                        date:'',
                        description:'',
                        car:'',
                    };
                    this.note = clearNote;
                    setTimeout(() => {
                        this.$router.go();
                        }, 2000)
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
                   this.$toast.error('Błąd edycji samochodu');
                }
            },
            showDeletingModal(car, index){
                const deleteModalData = {
                    showDeleteModal: true,
                    deleteUrl: "/deleteUserCar",
                    data: car,
                    deletingIndex: index,
                    isDeleted: false,
                };
                this.deletingCar = true;
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
            console.log('Notatki uzytkownika:')
            console.log(this.userNotes)
        },
        computed:{
            ...mapGetters(['getDeleteModalData']),
            addCarBrandErrors(){
                const errors = [];
                if (!this.$v.car.brand.$dirty) return errors;
                !this.$v.car.brand.required && errors.push('To pole jest wymagane.');
                return errors;
            },
            addCarModelErrors(){
                const errors = [];
                if (!this.$v.car.model.$dirty) return errors;
                !this.$v.car.model.required && errors.push('To pole jest wymagane.');
                return errors;
            },
            addCarFuelErrors(){
                const errors = [];
                if (!this.$v.car.fuel.$dirty) return errors;
                !this.$v.car.fuel.required && errors.push('To pole jest wymagane.');
                return errors;
            },
            addCarTypeErrors(){
                const errors = [];
                if (!this.$v.car.type.$dirty) return errors;
                !this.$v.car.type.required && errors.push('To pole jest wymagane.');
                return errors;
            },
            addCarTransmissionErrors(){
                const errors = [];
                if (!this.$v.car.transmission.$dirty) return errors;
                !this.$v.car.transmission.required && errors.push('To pole jest wymagane.');
                return errors;
            },
            addCarMileageErrors(){
                const errors = [];
                if (!this.$v.car.mileage.$dirty) return errors;
                !this.$v.car.mileage.numeric && errors.push('Proszę wpisywać tylko cyfry.');
                !this.$v.car.mileage.maxLength && errors.push('Maksymalnie 8 znaków.');
                return errors;
            },
            addCarProductionErrors(){
                const errors = [];
                if (!this.$v.car.production.$dirty) return errors;
                !this.$v.car.production.required && errors.push('To pole jest wymagane.');
                !this.$v.car.production.between && errors.push('Proszę wpisać prawidłowy rok.');
                return errors;
            },
            addCarPlateErrors(){
                const errors = [];
                if (!this.$v.car.plate.$dirty) return errors;
                !this.$v.car.plate.required && errors.push('To pole jest wymagane.');
                !this.$v.car.plate.maxLength && errors.push('Proszę podać prawidłowy numer rejestracyjny.');
                return errors;
            },
            addCarEngineErrors(){
                const errors = [];
                if (!this.$v.car.engine.$dirty) return errors;
                !this.$v.car.engine.required && errors.push('To pole jest wymagane.');
                return errors;
            },
            addCarVINErrors(){
                const errors = [];
                if (!this.$v.car.VIN.$dirty) return errors;
                !this.$v.car.VIN.required && errors.push('To pole jest wymagane.');
                !this.$v.car.VIN.maxLength && errors.push('Za dużo znaków.');
                !this.$v.car.VIN.minLength && errors.push('Za mało znaków.');
                return errors;
            },
            editCarBrandErrors(){
                const errors = [];
                if (!this.$v.editcar.brand.$dirty) return errors;
                !this.$v.editcar.brand.required && errors.push('To pole jest wymagane.');
                return errors;
            },
            editCarModelErrors(){
                const errors = [];
                if (!this.$v.editcar.model.$dirty) return errors;
                !this.$v.editcar.model.required && errors.push('To pole jest wymagane.');
                return errors;
            },
            editCarFuelErrors(){
                const errors = [];
                if (!this.$v.editcar.fuel.$dirty) return errors;
                !this.$v.editcar.fuel.required && errors.push('To pole jest wymagane.');
                return errors;
            },
            editCarTypeErrors(){
                const errors = [];
                if (!this.$v.editcar.type.$dirty) return errors;
                !this.$v.editcar.type.required && errors.push('To pole jest wymagane.');
                return errors;
            },
            editCarTransmissionErrors(){
                const errors = [];
                if (!this.$v.editcar.transmission.$dirty) return errors;
                !this.$v.editcar.transmission.required && errors.push('To pole jest wymagane.');
                return errors;
            },
            editCarMileageErrors(){
                const errors = [];
                if (!this.$v.editcar.mileage.$dirty) return errors;
                !this.$v.editcar.mileage.numeric && errors.push('Proszę wpisywać tylko cyfry.');
                !this.$v.editcar.mileage.maxLength && errors.push('Maksymalnie 8 znaków.');
                return errors;
            },
            editCarProductionErrors(){
                const errors = [];
                if (!this.$v.editcar.production.$dirty) return errors;
                !this.$v.editcar.production.required && errors.push('To pole jest wymagane.');
                !this.$v.editcar.production.between && errors.push('Proszę wpisać prawidłowy rok.');
                return errors;
            },
            editCarPlateErrors(){
                const errors = [];
                if (!this.$v.editcar.plate.$dirty) return errors;
                !this.$v.editcar.plate.required && errors.push('To pole jest wymagane.');
                !this.$v.editcar.plate.maxLength && errors.push('Proszę podać prawidłowy numer rejestracyjny.');
                return errors;
            },
            editCarEngineErrors(){
                const errors = [];
                if (!this.$v.editcar.engine.$dirty) return errors;
                !this.$v.editcar.engine.required && errors.push('To pole jest wymagane.');
                return errors;
            },
            editCarVINErrors(){
                const errors = [];
                if (!this.$v.editcar.VIN.$dirty) return errors;
                !this.$v.editcar.VIN.required && errors.push('To pole jest wymagane.');
                !this.$v.editcar.VIN.maxLength && errors.push('Za dużo znaków.');
                !this.$v.editcar.VIN.minLength && errors.push('Za mało znaków.');
                return errors;
            },
        },
        watch:{
            getDeleteModalData(obj){
                if(obj.isDeleted & this.deletingCar){
                    this.userCars.splice(obj.deletingIndex, 1);
                    this.$router.go();
                }else if(obj.isDeleted & this.deletingNote){
                    this.userNotes.splice(obj.deletingIndex, 1);
                }
            }
        },
    }
</script>
