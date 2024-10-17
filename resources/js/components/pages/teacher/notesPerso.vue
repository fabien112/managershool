<template>
    <div>
        <div class="wrapper">
          <Header />
            <MenuTeacher />
            <Modal v-model="showDelateModal" width="360">
                <p slot="header" style="color:rgb(228, 61, 61);text-align:center">
                    <Icon type="ios-information-circle"></Icon>
                    <span> CONFIRMATION </span>
                </p>
                <div style="text-align:center">
                    <p>Etes vous sure d'avoir rempli les notes a tous ?</p>
                </div>
                <div slot="footer">
                    <Button type="primary" size="large" long @click="Presence">Confirmer</Button>
                </div>
            </Modal>
            <div class="content-wrapper">
                <div class="container-full">

                    <section class="content">

                         <div class="box box-default">

                            <div class="box-header" style="background-color:#0052CC;text-align: center; color:white">

                                <h4 class="box-title">
                                    Ajouter une note personnelle
                                </h4>
                            </div>

                            <!-- /.box-header -->
                            <div class="box-body wizard-content">
                                <section>
                                    <div class="row">
                            <div class="col-md-12 col-lg-12">
                                <div class="row">
                                    <div class="col-md-6">
                                       <div class="form-group">
                                            <label for=""> Evaluation en cour </label>

                                            <select v-model="datas.libelleEvaluation"
                                                class="custom-select form-control required">
                                                <option selected :value="Evaluation.id">
                                                    {{ Evaluation.libelle }}

                                                </option>
                                            </select>
                                        </div>
                                    </div>

                                     <!-- <div class="col-md-6">
                                        <div class="form-group">

                                            <label for=""> Trimestre </label>

                                            <select

                                                v-model="datas.trimestre"

                                                class="custom-select form-control required"
                                            >
                                                <option

                                                    selected="selected"

                                                    :value="Evaluation.trimestre.id"
                                                >
                                                    {{Evaluation.trimestre.libelle_semes}}

                                                </option>
                                            </select>
                                        </div>
                                    </div> -->

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for=""> Classe </label>
                                            <select @change="onChange($event)" v-model="datas.classeName"
                                                class="custom-select form-control required">
                                                <option v-for="(data,
                                                i) in ClassListes" :key="i" :value="data.classe.id">
                                                    {{
                                                        data.classe
                                                            .libelleClasse
                                                    }}
                                                </option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for=""> Eleve </label>
                                            <select @change="onChange2($event)" v-model="datas.ideleve"
                                                class="custom-select form-control required">

                                                <option v-for="(data, i) in EleveListes" :key="i" :value="data.id">
                                                    {{ data.nom }} {{ data.prenom }}

                                                </option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for=""> Matiere </label>

                                            <select v-model="datas.matiere" class="custom-select form-control required">
                                                <option v-for="(data,
                                                i) in LIbelleMatiereclasse" :key="i" :value="data.id">
                                                    {{ data.libelle }}
                                                </option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for=""> Note </label>
                                            <input type="number"  v-model="datas.note" class="custom-select form-control required">

                                        </div>
                                    </div>
                                </div>

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
import MenuTeacher from "../../navs/MenuTeacher.vue";
import Header from "../../headers/Header.vue";
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
    components: { MenuTeacher, Chats , Header},
    data() {
        return {
            datas: {
                classeName: "",
                idClasse: "",
                libelleEvaluation: "",
                matiere: "",
                note: "",
                idEleve : ""
            },

            Note: {},
            Obser: {},
            i: 1,
            showDelateModal: false,
            LIbelleMatiereclasse: "",
            EleveListes: '',
            checkedNames: [],
            checkBoxs: [],
            rempli: false,
            users: [],
            ClassListes: [],
            MatieresListes: [],
            Notes: [],
            Evaluation: [],
            show: false
        };
    },

    async mounted() {

        if (localStorage.users) {
            this.users = JSON.parse(localStorage.getItem("users"));
        }





        const response = await this.callApi(
            "post",
            "api/teacher/getAllClasseOfTeacher",
            this.users
        );

        this.ClassListes = response.data;

        const response2 = await this.callApi(
            "post",
            "api/teacher/getEvaluationActif",
            this.users
        );

        this.Evaluation = response2.data;
    },
    methods: {
        async onChange(event) {


            this.datas.idClasse = event.target.value;

            this.datas.users = this.users;

            // Recuperer toutes les matieres de cette  classe

            const response3 = await this.callApi(
                "post",
                "api/teacher/getLibelleMatiereclasseById",
                this.datas
            );

            this.LIbelleMatiereclasse = response3.data;

            const response7 = await this.callApi(
                "post",
                "api/locale/getEleveclasseById", this.datas
            );

            this.EleveListes = response7.data


        },

        async onChange2(event) {


            this.datas.idEleve = event.target.value;

        },

        ShowModal() {
            this.showDelateModal = true;
        },

        async afficher() {
            if (this.datas.libelleEvaluation == "") {
                return this.e("Selectionner une évaluation");
            }

            if (this.datas.classeName == "") {
                return this.e("Selectionner une classe ");
            }

            if (this.datas.matiere == "") {
                return this.e("Choisir la matiere");
            }

            if (this.datas.idEleve == "") {
                return this.e("Choisir un eleve");
            }

            if (this.datas.note == "") {
                return this.e("Saisir une note correct");
            }



            const response = await this.callApi(
                "post",
                "api/teacher/AddNoteAlone",
                this.datas
            );

            if (response.status == 200) {

                    this.s(" Note ajoutée correctement");

                    this.$router.push('notesTeacher');


                }

                if (response.status == 401) {

                    this.e("cette note  existe deja ");



                }

                if (response.status == 402 || response.status == 422) {

                    this.e("Note saisie incorrecte ");

                }





        },


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
