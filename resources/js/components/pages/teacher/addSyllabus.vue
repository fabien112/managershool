<template>
    <div>
        <div class="wrapper">
            <HeaderTeacher />
            <MenuTeacher />
            <div class="content-wrapper">
                <div class="container-full">
                    <section class="content">
                        <div class="box box-default">
                            <div class="box-header" style="background-color:#0052CC;text-align: center; color:white">

                                <h4 class="box-title">
                                    Ajouter le syllabus du chapitre
                                </h4>
                            </div>

                            <div class="box-body wizard-content">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label> Titre du chapitre</label>
                                            <input placeholder="Chapitre 1 : Les forces " class="required form-control" type="text" v-model="data.chapitre" />
                                        </div>
                                    </div>

                                    <!-- <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Date de création</label>
                                            <input class="required form-control" type="date" v-model="data.date" />
                                        </div>
                                    </div> -->

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for=""> Durée du cour </label>

                                            <input type="number" v-model="data.duree" class="form-control required">


                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for>Classe</label>
                                            <select @change="
                                                onChange(
                                                    $event
                                                )
                                            " v-model="
    data.classeName
" class="custom-select form-control required">
                                                <option v-for="(data,
                                                i) in ClassListes" :key="
        i
    " :value="
    data
        .classe
        .id
">
                                                    {{
                                                            data
                                                                .classe
                                                                .libelleClasse
                                                    }}
                                                </option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="wlocation2">
                                                Matière
                                                <span class="danger"></span>
                                            </label>
                                            <select v-model="
                                                data.matiere
                                            " class="custom-select form-control required">
                                                <option v-for="(data,
                                                i) in LIbelleMatiereclasse" :key="
        i
    " :value="
    data.id
">
                                                    {{
                                                            data.libelle
                                                    }}
                                                </option>
                                            </select>
                                        </div>
                                    </div>


                                </div> <br />

                                <div class="row">
                                    <div class="col-12">
                                        <div class="box no-shadow mb-0 bg-transparent">
                                            <div class="box-header no-border px-0">
                                                <Alert fade=true show-icon closable>
                                                    LES OBJECTIFS DU COURS

                                                    <Icon type="ios-bulb-outline" slot="icon"></Icon>
                                                    <!-- <template slot="desc">
                                                Quelques chiffres concernant votre école...
                                            </template> -->
                                                </Alert>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                                <div class="row" v-for="(input, k) in data.inputs1" :key="k">
                                    <div class="col-md-12">
                                        <label for>
                                            OBJECTIF
                                            {{ k + 1 }}
                                        </label>

                                        <input name id type="text" class="form-control required"
                                            placeholder="Ecrire ici " v-model="
                                                input.objectif
                                            " />

                                        <br />

                                        <span>
                                            <Icon style="font-size:25px; color:red" type="md-remove-circle" @click="
                                            remove(k)" v-show="k || (!k && data.inputs1.length > 1)" />

                                            <Icon style="font-size:25px; color:green" type="ios-add-circle"
                                                @click="add(k)" v-show="k == data.inputs1.length - 1
                                                " />
                                        </span>
                                        <br />
                                    </div>
                                </div> <br>

                                <div class="row">
                                    <div class="col-12">
                                        <div class="box no-shadow mb-0 bg-transparent">
                                            <div class="box-header no-border px-0">
                                                <Alert fade=true show-icon closable>
                                                    LES PARTIES DU COURS

                                                    <Icon type="ios-bulb-outline" slot="icon"></Icon>
                                                    <!-- <template slot="desc">
                                                Quelques chiffres concernant votre école...
                                            </template> -->
                                                </Alert>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                                <div class="row" v-for="(input,
                                k) in data.inputs2" :key="k">
                                    <div class="col-md-12">
                                        <label for>
                                            PARTIE
                                            {{ k + 1 }}
                                        </label>

                                        <input name id type="text" class="form-control required"
                                            placeholder="Titre de cette partie " v-model="
                                                input.partie
                                            " />

                                        <br />

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>
                                                    Exercices
                                                    (non
                                                    obligatoire)
                                                </label>
                                                <input type="textt" class="form-control required" v-model="
                                                    input.exercie
                                                " placeholder="Exercice " />
                                            </div>
                                        </div>

                                        <span>
                                            <Icon style="font-size:25px; color:red" type="md-remove-circle" @click="
                                                remove2(
                                                    k
                                                )
                                            " v-show="
    k ||
    (!k &&
        data
            .inputs2
            .length >
        1)
" />

                                            <Icon style="font-size:25px; color:green" type="ios-add-circle" @click="
                                                add2(
                                                    k
                                                )
                                            " v-show="
    k ==
    data
        .inputs2
        .length -
    1
" />
                                        </span>
                                        <br />
                                        <br />
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <button @click="send" type="button" class="btn btn-primary">Enregistrer</button>
                                    </div>
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

import MenuTeacher from "../../navs/MenuTeacher.vue";
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
import HeaderTeacher from "../../headers/HeaderTeacher.vue";

export default {
    components: { MenuTeacher, Chats, HeaderTeacher },
    data() {
        return {
            UserData: [],

            data: {
                classeName: "",
                matiere: "",
                duree: '',
                idClasse: "",
                chapitre: "",
                date: "22/06/2022",
                inputs1: [
                    {
                        objectif: "",

                    },

                ],

                inputs2: [
                    {
                        partie: "",
                        exercie: "",


                    }
                ]


            },

            ClassListes: "",
            visible: false,
            uploadList: [],
            LIbelleMatiereclasse: [],
            HeuresListes: []
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

        const response1 = await this.callApi(
            "post",
            "api/teacher/getAllHeures"
        );

        this.HeuresListes = response1.data;
    },

    methods: {
        add(index) {
            this.data.inputs1.push({
                objectif: "",

            });

            console.log(this.data.inputs1);
        },

        add2(index) {
            this.data.inputs2.push({
                partie: "",
                exercie: ""
            });

            console.log(this.data.inputs1);
        },

        async onChange2(event) {
            this.choix = event.target.value;
        },
        remove(index) {
            this.data.inputs1.splice(index, 1);
        },
        remove2(index) {
            this.data.inputs2.splice(index, 1);
        },

        async send() {

            if (this.data.chapitre.trim() == "") {
                return this.e("Saisir le chapitre ");
            }
            if (this.data.date == "") {
                return this.e("Mentionner la date de création ");
            }
            if (this.data.classeName == "") {
                return this.e("Selectionner une classe ");
            }

            if (this.data.matiere == "") {
                return this.e("Selectionner la matiere");
            }




            for (let i = 0; i < this.data.inputs1.length; i++) {
                if (this.data.inputs1[i].objectif.trim() == "") {
                    return this.e(
                        "Saisir l'objectif" + " " + (i + 1)
                    );
                }

            }

            for (let i = 0; i < this.data.inputs2.length; i++) {
                if (this.data.inputs2[i].partie.trim() == "") {
                    return this.e(
                        "Saisir la partie " + " " + (i + 1)
                    );
                }

            }

            const response4 = await this.callApi(
                "post",
                "api/teacher/createSyllabus",
                this.data
            );

            if (response4.status == 200) {
                this.s("Syllabus ajouté correctement");
                this.$router.push("syllabus");

            } else {
                this.e("Une erreure est survenue");
            }
        },

        async onChange(event) {
            this.data.idClasse = event.target.value;

            this.data.users = this.users;

            // Recuperer toutes les matieres de cette  classe

            const response3 = await this.callApi(
                "post",
                "api/teacher/getLibelleMatiereclasseById",
                this.data
            );

            this.LIbelleMatiereclasse = response3.data;
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
