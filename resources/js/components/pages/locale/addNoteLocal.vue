<template>
    <div>
        <div class="wrapper">
            <Header />
            <MenuLocal />

            <Modal v-model="showDelateModal" width="360">
                <p slot="header" style="color:red;text-align:center">
                    <Icon type="ios-information-circle"></Icon>
                    <span> CONFIRMATION </span>
                </p>
                <div style="text-align:center">
                    <p>Etes-vous sûr d'avoir rempli les notes à tous ?</p>
                </div>
                <div slot="footer">
                    <Button type="error" size="large" long @click="Presence">Confirmer</Button>
                </div>
            </Modal>

            <div class="content-wrapper">
                <div class="container-full">
                    <section class="content">
                        <br />

                        <div class="row">
                            <div class="col-md-12 col-lg-12">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">
                                                Evaluation en cour
                                            </label>

                                            <select v-model="datas.libelleEvaluation
                                                " class="custom-select form-control required">
                                                <!-- <option selected :value="Evaluation.id">
                                                    {{ Evaluation.libelle }}
                                                </option> -->

                                                <option v-for="(data,
                                                    i) in Evaluation" :key="i" :value="data.id
        ">
                                                    {{
                                                        data.libelle
                                                    }}
                                                </option>
                                            </select>
                                        </div>
                                    </div>

                                    <!-- <div class="col-md-6">
                                        <div class="form-group">
                                            <label for=""> Evaluation </label>

                                            <select v-model="
                                                datas.libelleEvaluation
                                            " class="custom-select form-control required">
                                                <option v-for="(data,
                                                i) in Evaluation" :key="i" :value="data.id">
                                                    {{ data.libelle }}
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
                                                    i) in ClassListes" :key="i" :value="data.id">
                                                    {{ data.libelleClasse }}
                                                </option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for=""> Matière </label>

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
                                            <label for=""> Annuler cette matiere ? </label>

                                            <select v-model="datas.choice" class="custom-select form-control required">

                                                <option value="1"> Oui </option>

                                                <option value="0"> Non </option>

                                            </select>
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

                        <br /><br /><br />

                        <div class="card" v-if="rempli == true">
                            <div class="row">
                                <div class="col-lg-12 col-md-12">
                                    <Alert type="info" show-icon closable>
                                        <p style="text-align:center">
                                            Ajoutez une note pour chaque élève
                                        </p>
                                    </Alert>
                                    <div v-for="(data, i) in Classes" :key="i">
                                        <div>
                                            <div class="media-list media-list-divided media-list-hover">
                                                <div class="media align-items-center">
                                                    <a class="flexbox flex-grow gap-items text-truncate"
                                                        href="#qv-user-details" data-toggle="quickview">
                                                        <img class="avatar" :src="`/Photos/Logos/${data.user.photo}`
                                                            " alt="" />

                                                        <div class="media-body text-truncate">
                                                            <h6>
                                                                {{ data.nom }}
                                                            </h6>
                                                            <small>
                                                                <span>
                                                                    {{
                                                                        data.prenom
                                                                    }}
                                                                </span>
                                                            </small>
                                                        </div>
                                                    </a>

                                                    <div class="custom-control custom-checkbox">
                                                        <input placeholder="Saisir une note" type="number"
                                                            class="form-control" v-model="Note[data.id]
                                                                    " />
                                                    </div>
                                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row" v-if="rempli == true">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <button type="button" class="waves-effect waves-light btn mb-5 btn btn-primary"
                                        @click="ShowModal">
                                        Enregistrer
                                    </button>
                                </div>
                            </div>
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
            datas: {
                classeName: "",
                idClasse: "",
                libelleEvaluation: "",
                matiere: "",
                trimestre: "",
                choice: 0
            },

            Note: {},
            Obser: {},
            i: 1,
            showDelateModal: false,
            LIbelleMatiereclasse: "",
            checkedNames: [],
            checkBoxs: [],
            rempli: false,
            users: [],
            ClassListes: [],
            MatieresListes: [],
            Notes: [],
            Classes: [],
            Evaluation: [],
            show: false
        };
    },

    async mounted() {
        if (!localStorage.users) {
            this.$router.push("login");
        }

        if (localStorage.EtabInfos) {
            this.EtabInfos = JSON.parse(localStorage.getItem("EtabInfos"));
        }

        // Recuperer toutes les sessions de cette ecole

        const response2 = await this.callApi(
            "post",
            "api/locale/getClasseEtablissement",
            this.EtabInfos
        );

        this.ClassListes = response2.data;

        this.ClassListes = this.ClassListes.filter(
            item => item.eleves.length > 0
        );

        const response4 = await this.callApi(
            "post",
            "api/teacher/getEvaluationActif",
            this.EtabInfos
        );
        this.Evaluation = response4.data;
    },
    methods: {
        async onChange(event) {
            this.datas.idClasse = event.target.value;

            this.datas.EtabInfos = this.EtabInfos;

            // Recuperer toutes les matieres de cette  classe

            const response3 = await this.callApi(
                "post",
                "api/locale/getLibelleMatiereclasseLocaleById",
                this.datas
            );

            this.LIbelleMatiereclasse = response3.data;
        },

        ShowModal() {
            this.showDelateModal = true;
        },

        async Presence() {
            this.showDelateModal = false;

            //this.s('Vous avez correctement fait la presence')

            this.datas.Note = this.Note;

            this.datas.Classes = this.Classes;

            if (Object.keys(this.Note).length != this.Classes.length) {
                this.e("Toutes les notes n'ont pas été saisies ");
            } else {
                for (var item in this.Note) {
                    console.log(this.Note[item]);

                    if (this.Note[item] == "" || this.Note["item"] < 0) {
                        var dec = true;

                        this.e(" Saisir correctement toutes les notes ! ");

                        break;
                    } else {
                        dec = false;
                    }
                }

                console.log(dec);

                if (dec == false) {
                    const response = await this.callApi(
                        "post",
                        "api/locale/AddNotelocale",
                        this.datas
                    );

                    if (response.status == 200) {
                        this.s(" Notes ajoutées correctement");

                        // this.$router.push("notes");
                    }

                    if (response.status != 200) {
                        this.e(
                            " Ces notes sont incorrectes ou existent deja !  "
                        );
                    }

                    // if (response.status == 402 || response.status == 403) {

                    //     this.e("Certaines  notes saisies sont incorrectes ");

                    // }
                }
            }

            // this.$router.go();
        },

        async afficher() {

            console.log(this.datas)

            if (this.datas.libelleEvaluation == "") {
                return this.e("Sélectionner  une évaluation ");
            }

            if (this.datas.classeName == "") {
                return this.e("Sélectionner  une classe ");
            }

            if (this.datas.matiere == "") {
                return this.e("Sélectionner la matiere");
            }

            const response2 = await this.callApi(
                "post",
                "api/teacher/getStudentByTeacherForAppel",
                this.datas
            );

            this.Classes = response2.data;

            if (this.Classes == "") {
                this.rempli = false;
            } else {
                this.rempli = true;
            }
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
