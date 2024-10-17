<template>
    <div>
        <div class="wrapper">
            <Header />
            <MenuLocal />
            <div class="content-wrapper">
                <div class="container-full">
                    <section class="content">
                        <!-- START Card With Image -->
                        <!-- <div class="card">
                            <div class="card-header">
                                <h4 class="card-title"> LISTING DES ABSENCES

                                </h4>

                            </div>
                        </div> -->

                        <!-- Modal de modification -->

                        <Modal v-model="EdetingModal" title="Modifier  une absence ">
                            <div class="row">
                                <div class="col-md-12">
                                    <label class="form-label">
                                        Date
                                    </label>
                                    <input type="date" class="form-control" v-model.trim="data.date
                                        " />
                                </div>
                            </div> <br>
                            <div class="row">
                                <div class="col-md-12">
                                    <label class="form-label"> Durée
                                    </label>
                                    <input type="number" class="form-control" v-model.trim="data.duree
                                        " />
                                </div>
                            </div>



                            <br />

                            <div slot="footer">
                                <Button type="primary" size="large" long @click="Update()">Enregistrer</Button>
                            </div>
                        </Modal>

                        <!-- Modal de suppression -->

                        <Modal v-model="showDelateModal" width="360">
                            <p slot="header" style="color:#f60;text-align:center">
                                <span> Suppression </span>
                            </p>
                            <div style="text-align:center">
                                <p>Etes-vous sure de vouloir supprimer ?</p>
                            </div>
                            <div slot="footer">
                                <Button type="error" size="large" long @click="delateAbsence">Confirmer</Button>
                            </div>
                        </Modal>




                        <div class="row">

                            <div class="col-md-6">


                                <div class="form-group">

                                    <label for=""> Trimestre </label>

                                    <select class="form-control" v-model="keyword3" @change="onChange3($event)">

                                        <option v-for="(data, i) in TrimestreListes " :key="i" :value="data.id"> {{
                                            data.libelle_semes
                                        }}</option>

                                    </select>

                                </div>


                            </div>


                            <div class="col-md-6">


                                <div class="form-group">

                                    <label for=""> Classe </label>

                                    <select name="LeaveType" @change="onChange($event)" class="form-control"
                                        v-model="keyword">

                                        <option v-for="(data, i) in ClasseListes " :key="i" :value="data.id"> {{
                                            data.libelleClasse
                                        }}</option>

                                    </select>

                                </div>


                            </div>


                            <div class="col-md-6">


                                <div class="form-group">

                                    <label for=""> Elève </label>

                                    <select @change="onChange2($event)" v-model="keyword2"
                                        class="custom-select form-control required">
                                        <option value=""> Sélectionner un élève </option>
                                        <option v-for="(data, i) in EleveListes" :key="i" :value="data.id">
                                            {{ data.nom }} {{ data.prenom }}

                                        </option>

                                    </select>
                                </div>


                            </div>

                        </div>

                        <div class="row">
                            <div class="col-md-6">

                                <div class="form-group">

                                    <button @click="Afficher" class="btn btn-primary"> Envoyer </button>


                                </div>

                            </div>

                        </div>
                        <br>
                        <br>

                        <div class="row">


                            <div class="col-6">
                                <div class="box no-shadow mb-0 bg-transparent">
                                    <div class="box-header no-border px-0">
                                        <Alert fade=true show-icon closable>

                                            Absences du trimestre

                                            <template slot="desc">
                                                Total : {{ ElevesAbsences.sommmeTrimetre }} h , Non justifié : {{
                                                    ElevesAbsences.sommeTrimestreNonJust }} h
                                            </template> <br>
                                        </Alert>
                                    </div>
                                </div>
                            </div>

                            <div class="col-6">
                                <div class="box no-shadow mb-0 bg-transparent">
                                    <div class="box-header no-border px-0">
                                        <Alert type="error" fade=true show-icon closable>

                                            Absences de l'année
                                            <template slot="desc">
                                                Total : {{ ElevesAbsences.sommeAnnee }} h , Non justifié : {{
                                                    ElevesAbsences.sommeAnneeNjust }} h
                                            </template>
                                        </Alert>
                                    </div>
                                </div>
                            </div>


                        </div>

                        <div class="row">

                            <div class="col-12">
                                <!-- /.box -->

                                <div class="box">
                                    <div class="box-header bg-primary">
                                        <h4 class="box-title" style="margin:auto;text-align: center;">
                                            Historique des absences du trimestre

                                        </h4>
                                    </div>


                                    <div class="box-body">
                                        <div class="table-responsive">
                                            <table id="example" class="table simple mb-0" style="width:100%">
                                                <thead>
                                                    <tr>
                                                        <th> Jours </th>
                                                        <th> Heures</th>
                                                        <th> Matières </th>
                                                        <th> Durée du cour </th>
                                                        <th> Etat </th>

                                                    </tr>
                                                </thead>
                                                <tbody name="fruit-table" is="transition-group">
                                                    <tr v-for="(data,
                                                        i) in ElevesAbsences.listeTrimestre" :key="i">
                                                        <td>
                                                            {{
                                                                data.date | dateFormat
                                                            }}
                                                        </td>

                                                        <td>
                                                            {{
                                                                data.heure
                                                            }}
                                                        </td>

                                                        <td>
                                                            {{
                                                                data.matiere
                                                            }}
                                                        </td>

                                                        <td>
                                                            {{
                                                                data.duree
                                                            }} h
                                                        </td>

                                                        <td>


                                                            <span v-if="data.etat == 0" style="color:#f60"> Non Jusifié
                                                            </span>
                                                            <span v-if="data.etat == 1" style="color:green"> Jusifié </span>



                                                            <!-- <button @click="showEdetingModal(data, i)"
                                                                class=" btn btn-primary">
                                                                <Icon type="md-create" /> Modifier
                                                            </button> -->

                                                            <!-- <button @click="showDelatingModal(data, i)"
                                                                class="btn btn-danger">
                                                                <Icon type="md-trash" /> Supprimer
                                                            </button> -->

                                                        </td>

                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <!-- /.box-body -->
                                </div>
                                <!-- /.box -->
                            </div>
                            <!-- /.col -->
                        </div>



                    </section>

                </div>
            </div>
        </div>
        <Chats />
    </div>
</template>

<script>
import Header from "../../headers/Header.vue";
import MenuLocal from "../../navs/MenuLocal.vue";
import Chats from "../../navs/Chats.vue";
import { mapState } from "vuex";
import {
    required,
    minLength,
    alpha,
    email,
    maxLength,
    sameAs
} from "vuelidate/lib/validators";
import { log } from "util";

export default {
    components: { Header, MenuLocal, Chats },
    data() {
        return {

            data: {

                idPresence: "",
                date: "",
                duree: "",
                idTrimestre: ""

            },
            EdetingModal: false,
            showDelateModal: false,
            keyword: "",
            keyword2: "",
            keyword3: "",
            ClasseListes: "",
            TrimestreListes: "",
            EleveListes: "",
            ElevesAbsences: {
                'sommmeTrimetre': 0,
                'sommeAnnee': 0,


            },
            TotalHeure: 0,
            showRecap: false,
            i: -1,
        };


    },


    async mounted() {

        if (!localStorage.users) {

            this.$router.push('login');
        }


        if (localStorage.EtabInfos) {
            this.EtabInfos = JSON.parse(localStorage.getItem("EtabInfos"));
        }

        // Allons chercher la session et le code etablissement ce cet enseigant

        const response2 = await this.callApi(
            "post",
            "api/locale/getClasseEtablissement",
            this.EtabInfos
        );

        this.ClasseListes = response2.data;

        this.ClasseListes = this.ClasseListes.filter(item => item.eleves.length > 0)



        // Allons chercher les trimestre

        const response3 = await this.callApi(
            "post",
            "api/locale/getAllTrimestre"

        );

        this.TrimestreListes = response3.data;


    },

    methods: {

        showDelatingModal(data, i) {
            this.delateItem = data;
            this.i = i;
            this.showDelateModal = true;
        },

        showEdetingModal() {

            this.EdetingModal = true
        },

        async onChange(event) {

            this.data.idClasse = event.target.value;

            // Recuperer tous les eleves de cette classe

            const response3 = await this.callApi(
                "post",
                "api/locale/getEleveclasseById", this.data
            );

            this.EleveListes = response3.data

        },


        async delateAbsence() {

            //console.log(this.delateItem.duree);
            const response = await axios.post(
                "api/locale/delateAbsence",
                this.delateItem
            );

            if (response.status === 200) {
                this.ElevesAbsences.listeTrimestre.splice(this.i, 1);
                this.showDelateModal = false;
                this.s("Absence supprimée correctement");

                this.ElevesAbsences.sommmeTrimetre = this.ElevesAbsences.sommmeTrimetre - parseInt(this.delateItem.duree)

                this.ElevesAbsences.sommeAnnee = this.ElevesAbsences.sommeAnnee - parseInt(this.delateItem.duree)


            }
            // this.modal2 = false;
        },


        async onChange2(event) {

            this.data.idEleve = event.target.value;

        },

        async onChange3(event) {

            this.data.idTrimestre = event.target.value;

        },

        async Afficher() {

            this.ElevesAbsences.sommmeTrimetre = 0;

            // this.ElevesAbsences.sommeAnnee = 0;


            if (typeof this.data.idTrimestre === 'undefined' || this.data.idTrimestre === '') {
                return this.e("Selectionner un trimestre ");
            }
            if (typeof this.data.idClasse === 'undefined' || this.data.idClasse === null) {
                return this.e("Selectionner une classe   ");
            }

            if (typeof this.data.idEleve === 'undefined' || this.data.idTrimestre === null) {
                return this.e("Selectionner un élève   ");
            }



            const response4 = await this.callApi(
                "post",
                "api/locale/getAbensesOfEleveclasseById", this.data
            );

            this.ElevesAbsences = response4.data

            // this.data.idTrimestre =''

            // this.data.idClasse=''

            // this.data.idEleve=''

            this.showRecap = true







        }

    },


};
</script>

<style>
.content-wrapper {
    background-color: #FAFBFD
}

.demo-upload-list {
    display: inline-block;
    width: 60px;
    height: 60px;
    text-align: center;
    line-height: 60px;
    border: 1px solid transparent;
    border-radius: 4px;
    overflow: hidden;
    background: #fff;
    position: relative;
    box-shadow: 0 1px 1px rgba(0, 0, 0, 0.2);
    margin-right: 4px;
}

.demo-upload-list img {
    width: 100%;
    height: 100%;
}

.demo-upload-list-cover {
    display: none;
    position: absolute;
    top: 0;
    bottom: 0;
    left: 0;
    right: 0;
    background: rgba(0, 0, 0, 0.6);
}

.demo-upload-list:hover .demo-upload-list-cover {
    display: block;
}

.demo-upload-list-cover i {
    color: #fff;
    font-size: 20px;
    cursor: pointer;
    margin: 0 2px;
}
</style>
