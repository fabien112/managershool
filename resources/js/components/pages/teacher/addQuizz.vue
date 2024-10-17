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
                                    Formulaire de création d'un quizz
                                </h4>
                            </div>

                            <!-- /.box-header -->
                            <div class="box-body wizard-content">
                                <section>

                                    <div class="row">

                                        <div class="col-12">
                                            <!-- <Alert
                                                fade="true"
                                                show-icon
                                                closable

                                            >
                                                ETAPE 1 : Paremetres du quizz
                                                <Icon
                                                    type="ios-bulb-outline"
                                                    slot="icon"
                                                ></Icon>
                                                <template slot="desc">
                                               Toutes les informations utiles
                                            </template>

                                            </Alert> -->
                                        </div>

                                    </div> <br>
                                    <div class="row">

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for=""> Classe </label>
                                                <select @change="onChange($event)" v-model="data.classeName"
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
                                                <label for="wlocation2">
                                                    Matiere
                                                    <span class="danger"></span>
                                                </label>
                                                <select v-model="data.matiere"
                                                    class="custom-select form-control required">
                                                    <option v-for="(data,
                                                    i) in LIbelleMatiereclasse" :key="i" :value="data.id">
                                                        {{ data.libelle }}
                                                    </option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>
                                                    Libellé
                                                </label>
                                                <input type="text" class="form-control required" v-model.trim="
                                                    data.libelleDevoir
                                                " />
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>
                                                    Consigne
                                                </label>
                                                <input type="text" class="form-control required" v-model.trim="
                                                    data.consigne
                                                " />
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>
                                                    Date et heure
                                                </label>
                                                <input type="datetime-local" class="form-control required" v-model.trim="
                                                    data.dateLimite
                                                " />
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <label for="">
                                                Durée
                                            </label>

                                            <div class="form-group">
                                                <input type="time" class="form-control required" v-model.trim="
                                                    data.duree
                                                " />
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <label for="">
                                                Vérouiller le devoir apres la
                                                durée limite ?
                                            </label>

                                            <div class="form-group">
                                                <RadioGroup v-model="data.verrouiller" type="button"
                                                    button-style="solid">
                                                    <Radio label="Oui"></Radio>
                                                    <Radio label="Non"></Radio>
                                                </RadioGroup>
                                            </div>
                                        </div>
                                    </div> <br>

                                    <div class="row">

                                        <div class="col-12">
                                            <!-- <Alert
                                                fade="true"
                                                show-icon
                                                closable

                                            >
                                                ETAPE 2 : Créez votre  questionnaire
                                                <Icon
                                                    type="ios-bulb-outline"
                                                    slot="icon"
                                                ></Icon>
                                                <template slot="desc">
                                                    Parametrer vos questions et réponses
                                                    </template>
                                            </Alert> -->
                                        </div>

                                    </div> <br>

                                    <div class="row" v-for="(input,
                                    k) in data.inputs" :key="k">
                                        <div class="col-md-6">

                                            <label for=""> Question {{ k + 1 }} </label>

                                            <textarea name="" id="" cols="1" rows="1" type="text"
                                                class="custom-select form-control required"
                                                placeholder="Saisir une question " v-model="input.name">

                                              </textarea>


                                            <!-- <select
                                                    class="custom-select form-control required"
                                                    v-model="input.name"
                                                >
                                                    <option value="">
                                                        Selectioner un mode de
                                                        réponse
                                                    </option>
                                                    <option value="V"
                                                        > Vraix ou Faux </option>

                                                    <option value="F">
                                                        Choix multiple
                                                    </option>
                                                </select> -->

                                            <br> <br>

                                            <span>
                                                <Icon style="font-size:25px; color:red" type="md-remove-circle"
                                                    @click="remove(k)" v-show="
                                                        k ||
                                                        (!k &&
                                                            data.inputs
                                                                .length >
                                                            1)
                                                    " />

                                                <Icon style="font-size:25px; color:green" type="ios-add-circle"
                                                    @click="add(k)" v-show="
                                                        k ==
                                                        data.inputs
                                                            .length -
                                                        1
                                                    " />
                                            </span> <br>


                                        </div>

                                        <div class="col-md-3">

                                            <label for=""> Nombre de point </label>

                                            <input type="number" class="custom-select form-control required"
                                                placeholder="Saisir le nombre de point" v-model="input.point">

                                        </div>

                                        <!-- <div class="col-md-4">

                                                <select @change="onChange2($event)"
                                                    class="custom-select form-control required"
                                                    v-model="input.choix"
                                                >
                                                    <option value="">
                                                        Selectioner un mode de
                                                        réponse
                                                    </option>
                                                    <option value="V"
                                                        > Vraix ou Faux </option>

                                                    <option value="F">
                                                        Choix multiple
                                                    </option>
                                                </select>


                                            </div> -->



                                        <div class="col-md-3">

                                            <div class="form-group">
                                                <label for=""> Réponse </label> <br>
                                                <RadioGroup v-model="input.resp" type="button" button-style="solid">
                                                    <Radio label="Vrai"></Radio>
                                                    <Radio label="Faux"></Radio>
                                                </RadioGroup>
                                            </div>


                                        </div>


                                    </div> <br>

                                    <div class="row">

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <button @click="send" type="button" class="btn btn-facebook">
                                                    Enregistrer
                                                </button>
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
import MenuTeacher from "../../navs/MenuTeacher.vue";
import HeaderTeacher from "../../headers/HeaderTeacher.vue";

export default {
    components: { Chats, MenuTeacher, HeaderTeacher },
    data() {
        return {

            UserData: [],

            data: {
                classeName: "",
                matiere: "",
                idClasse: "",
                libelleDevoir: "",
                dateLimite: "",
                duree: "",
                consigne: "",
                verrouiller: "Non",
                inputs: [
                    {
                        name: "",
                        resp: "",
                        point: "",
                        repElev: '',
                        choix: '',
                    }
                ]
            },

            ClassListes: "",
            visible: false,
            uploadList: [],
            LIbelleMatiereclasse: []
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
    },

    methods: {
        add(index) {
            this.data.inputs.push({
                name: "",
                resp: "",
                point: "",

            });

            console.log(this.data.inputs);
        },

        async onChange2(event) {

            this.choix = event.target.value;


        },
        remove(index) {
            this.data.inputs.splice(index, 1);
        },

        async send() {
            if (this.data.classeName == "") {
                return this.e("Selectionner une classe ");
            }

            if (this.data.matiere == "") {
                return this.e("Selectionner la matiere");
            }

            if (this.data.libelleDevoir.trim() == "") {
                return this.e("Saisir le libellé du quizz ");
            }
            if (this.data.consigne.trim() == "") {
                return this.e("Saisir la consigne du quizz ");
            }
            if (this.data.dateLimite.trim() == "") {
                return this.e("Donner la date et l'heure du quizz");
            }

            if (this.data.duree.trim() == "") {
                return this.e("Saisir la dureé du quizz");
            }

            for (let i = 0; i < this.data.inputs.length; i++) {

                if (this.data.inputs[i].name.trim() == "") {
                    return this.e("Saisir le libellé de la question " + '' + (i + 1));
                }

                if (this.data.inputs[i].point.trim() == "") {
                    return this.e("Saisir le nombre de point  de la question " + '' + (i + 1));
                }


                if (this.data.inputs[i].resp.trim() == "") {
                    return this.e("Saisir la reponse de la question " + '' + (i + 1));
                }
            }

            const response4 = await this.callApi(
                "post",
                "api/teacher/createQuizz",
                this.data
            );

            if (response4.status == 200) {
                this.s("Quizz ajouté correctement");
                this.$router.push("Quizz");
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
        },


    }
};
</script>

<style>
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
