<template>
    <div>
        <div class="wrapper">
            <MenuSG />
            <Header />
            <Modal v-model="showDelateModal" width="360">
                <p slot="header" style="color:red;text-align:center">
                    <Icon type="ios-information-circle"></Icon>
                    <span> CONFIRMATION </span>
                </p>
                <div style="text-align:center">
                    <p> Etes-vous sûr de vouloir enregistrer ? </p>

                </div>
                <div slot="footer">
                    <Button type="primary" size="large" long @click="Presence">Confirmer</Button>
                </div>
            </Modal>

            <Modal v-model="EdetingModal" title="Justifiier absence">
                <div class="row">

                </div> <br>
                <div class="row">
                    <div class="col-md-12">

                        <input type="number" placeholder="Mettre le nombre d'heure justifiees" class="form-control"
                            v-model="heurejustfif" />
                    </div> <br>

                </div>



                <br />

                <div slot="footer">
                    <Button type="primary" size="large" long @click="Update()">Enregistrer</Button>
                </div>
            </Modal>
            <div class="content-wrapper">
                <div class="container-full">

                    <section class="content">
                        <div class="box box-default">

                            <div class="box-header" style="background-color:#0052CC;text-align: center; color:white">

                                <h4 class="box-title">
                                    Bilan des absences du trimestre
                                </h4>
                            </div>

                            <!-- /.box-header -->
                            <div class="box-body wizard-content">
                                <section class="content">
                                    <br>

                                    <div class="row">
                                        <div class="col-md-12 col-lg-12">

                                            <div class="row">

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for=""> Trimestres </label>

                                                        <select v-model="datas.libelleEvaluation"
                                                            class="custom-select form-control required">
                                                            <option v-for="(data, i) in Evaluation" :key="i"
                                                                :value="data.id">
                                                                {{ data.libelle_semes }}

                                                            </option>
                                                        </select>
                                                    </div>
                                                </div>



                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for=""> Classe </label>
                                                        <select v-model="datas.classeName"
                                                            class="custom-select form-control required">
                                                            <option v-for="(data, i) in ClassListes" :key="i"
                                                                :value="data.id">
                                                                {{ data.libelleClasse }}
                                                            </option>
                                                        </select>
                                                    </div>
                                                </div>

                                            </div> <br>

                                            <div class="row">

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <button @click="afficher"
                                                            class="waves-effect waves-light btn mb-5  btn btn-primary">
                                                            Envoyer
                                                        </button>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div> <br>

                                    <div v-if="rempli == true">

                                        <div class="row">


                                            <div class="col-12">

                                                <div class="table-responsive">
                                                    <table id="example" class="table simple mb-0" style="width:100%">
                                                        <thead>
                                                            <tr>
                                                                <th> Noms et prénoms </th>
                                                                <th> Total </th>
                                                                <th> Justifiées</th>
                                                                <th>Non justifiées</th>
                                                                <th></th>

                                                            </tr>
                                                        </thead>
                                                        <tbody name="fruit-table" is="transition-group">
                                                            <tr v-for="(data,
                                                                i) in Classes" :key="i">
                                                                <td>
                                                                    {{
                                                                        data.nom
                                                                    }}

                                                                    {{
                                                                        data.prenom
                                                                    }}
                                                                </td>

                                                                <td>

                                                                    {{ data.heure }}



                                                                </td>

                                                                <td>
                                                                    {{ data.heurejustif }}



                                                                </td>

                                                                <td style="color:red">
                                                                    {{ data.heure - data.heurejustif }}



                                                                </td>

                                                                <td>


                                                                    <button class="btn btn-primary"
                                                                        @click="showEdetingModal(data, i)">
                                                                        <Icon type="md-create" /> Justifier
                                                                    </button>



                                                                </td>

                                                                <!-- <td>

                                                                    <router-link to="recapAbsenceSg">

                                                                        <button class="btn btn-primary">
                                                                            <Icon type="md-create" /> Plus
                                                                        </button>


                                                                    </router-link>

                                                                </td> -->


                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>

                                            </div>

                                        </div>




                                    </div>


                                </section>
                            </div>
                            <!-- /.box-body -->
                        </div>
                    </section>

                </div>
            </div>
        </div>
        <Chats />
    </div>
</template>

<script>

import MenuSG from "../../navs/MenuSG.vue";
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
import Header from "../../headers/Header.vue";
import { thisTypeAnnotation } from "@babel/types";

export default {
    components: { MenuSG, Chats, Header },
    data() {
        return {

            datas: {

                classeName: "",
                idClasse: "",
                libelleEvaluation: "",
                matiere: "",
                trimestre: ""
            },
            heurejustfif: "",

            Note: {},
            Obser: {},
            itemheure: "",
            i: 1,
            showDelateModal: false,
            EdetingModal: false,
            LIbelleMatiereclasse: "",
            checkedNames: [],
            checkBoxs: [],
            rempli: false,
            users: [],
            ClassListes: [],
            MatieresListes: [],
            Classes: [],
            Evaluation: [],
            Trimestre: [],
            show: false

        };
    },

    async mounted() {

        if (localStorage.users) {
            this.users = JSON.parse(localStorage.getItem("users"));
        }

        const response = await this.callApi(
            "post",
            "api/locale/getClasseEtablissementBySg",
            this.users
        );

        this.ClassListes = response.data

        this.ClassListes = this.ClassListes.filter(item => item.eleves.length > 0)




        const response2 = await this.callApi(
            "post",
            "api/locale/getAllTrimestre",
            this.users
        );

        this.Evaluation = response2.data;



    },
    methods: {

        showEdetingModal(data, i) {

            this.EdetingModal = true
            this.i = i;
            this.itemheure = data


        },

        async Update() {



            this.itemheure.data = this.heurejustfif





            if (this.heurejustfif == "") {

                this.e("Saisir un nombre valide");

            } else if (this.heurejustfif > this.itemheure.heure) {

                this.e("Vous ne pouvez justifier plus d'heure que ce que vous en avez");

            }

            else {


                const response = await axios.post(
                    "api/surveillant/justifierabsence",
                    this.itemheure
                );



                if (response.status === 200) {
                    this.EdetingModal = false;
                    this.heurejustfif = ""

                    this.afficher()

                    this.s("Absence justifiée correctement");


                }


            }



        },



        ShowModal(data) {

            this.showDelateModal = true


        },

        async afficher() {


            if (this.datas.libelleEvaluation == "") {
                return this.e("Selectionner une évaluation");
            }


            if (this.datas.classeName == "") {
                return this.e("Selectionner une classe ");
            }


            const response2 = await this.callApi(
                "post",
                "api/locale/getStudentBySg2",
                this.datas
            );

            this.Classes = response2.data

            if (this.Classes == "") {
                this.rempli = false

            }

            else {
                this.rempli = true
            }


        },

        async Presence() {


            this.showDelateModal = false

            //this.s('Vous avez correctement fait la presence')


            this.datas.Note = this.Note

            this.datas.Classes = this.Classes


            if (Object.keys(this.Note).length != this.Classes.length) {

                this.e("Toutes les notes n'ont pas ete saisies ");


            }

            else {

                const response = await this.callApi(
                    "post",
                    "api/locale/AddabsenceSg",
                    this.datas
                );

                if (response.status == 200) {

                    this.s(" Absences ajoutées correctement");

                    // this.$router.push('notesTeacher');


                }

                if (response.status == 401) {

                    this.e("Les absences de cette sequences existent deja ");



                }

                if (response.status == 402 || response.status == 403) {

                    this.e("Certaines  absences saisies sont incorrectes ");

                }


            }




            // this.$router.go();


        }
    }
};
</script>

<style>
.content-wrapper {
    background-color: #fafbfd;
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
