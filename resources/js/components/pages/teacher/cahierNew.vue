<template>
    <div>
        <div class="wrapper">
            <HeaderTeacher />
            <MenuTeacher />
            <div class="content-wrapper">
                <div class="container-full">
                    <section class="content">
                        <div class="box box-default">

                            <div class="box-header with-border">
                                <h4 class="box-title">
                                    Remplir le cahier de texte du jour
                                </h4>
                                <!-- <h6 class="box-subtitle">You can us the validation like what we did</h6> -->
                            </div>

                            <div class="box-body wizard-content">

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Date du jour </label>
                                            <input class="required form-control" type="date" v-model="data.date" />
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for>Durée du cour en heure </label>

                                            <input type="number" v-model="data.duree" class="form-control required">

                                        </div>
                                    </div>

                                    <!-- <div class="col-md-6">
                                        <div class="form-group">
                                            <label for>Mois</label>

                                            <select name="LeaveType" class="form-control" v-model="data.idMois">
                                                <option v-for="(data, i) in MoisListes" :key="i" :value="data.id">{{
                                                        data.nom
                                                }}</option>
                                            </select>
                                        </div>
                                    </div> -->

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
                                            <select @change="
                                                onChange2(
                                                    $event
                                                )
                                            " v-model="
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
                                    <br />

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>CHOISIR LE CHAPITRE</label>
                                            <select v-model="data.chapitre" class="custom-select form-control required"
                                                @change="
                                                    onChange3(
                                                        $event
                                                    )
                                                ">
                                                <option v-for="(data, i) in ChapitreListes" :key="i" :value="data.id">
                                                    CHAPITRE {{ i + 1 }} : {{ data.chapitre }}</option>
                                            </select>
                                        </div>
                                    </div>
                                    <br />

                                    <div class="col-md-12" v-for="(input,
                                    k) in data.inputs2" :key="k">
                                        <label>
                                            PARTIE
                                            {{ k + 1 }}
                                        </label>
                                        <br />

                                        <select v-model="input.partie" class="custom-select form-control required">
                                            <option v-for="(data, i) in PartieListes" :key="i" :value="data.id">{{
                                                    data.libelle
                                            }}</option>
                                        </select>

                                        <div class="col-md-6">
                                            <br />

                                            <label> SOUS-PARTIE</label>
                                            <br />

                                            <textarea cols="100" rows="5" class="form-control required"
                                                placeholder="1.Les fonctions#; 2.Les suites#; 3.Les integrales#"
                                                v-model="
                                                    input.souspartie
                                                " />
                                            <br />
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
                idClasse: "",
                idMois: "",
                chapitre: "",
                date: "00/10/2035",
                duree: "",
                inputs2: [
                    {
                        partie: "",
                        souspartie: "",


                    }
                ]


            },

            ClassListes: "",
            MoisListes: '',
            visible: false,
            uploadList: [],
            LIbelleMatiereclasse: [],
            HeuresListes: [],
            ChapitreListes: [],
            PartieListes: []
        };
    },

    async mounted() {
        if (localStorage.users) {
            this.users = JSON.parse(localStorage.getItem("users"));
        }

        const response2 = await this.callApi(
            "post",
            "api/locale/getAllMois"
        );

        this.MoisListes = response2.data;

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

        add2(index) {
            this.data.inputs2.push({
                partie: "",
                souspartie: ""
            });

            console.log(this.data.inputs1);
        },


        async onChange3(event) {

            this.data.chapitre = event.target.value;

            this.data.users = this.users;

            // Recuperer tous les chapitres

            const response5 = await this.callApi(
                "post",
                "api/teacher/getPartieByMatiereAndclasse",
                this.data
            );

            this.PartieListes = response5.data;
        },

        async onChange2(event) {

            this.data.matiere = event.target.value;

            this.data.users = this.users;

            // Recuperer tous les chapitres

            const response4 = await this.callApi(
                "post",
                "api/teacher/getChapitreByMatiereAndclasse",
                this.data
            );

            this.ChapitreListes = response4.data;
        },
        remove(index) {
            this.data.inputs1.splice(index, 1);
        },
        remove2(index) {
            this.data.inputs2.splice(index, 1);
        },

        async send() {

            if (this.data.date == "") {
                return this.e("Mentionner la date de création ");
            }

            if (this.data.duree == "") {
                return this.e("Mentionner la durée totale  du cour");
            }

            // if (this.data.idMois == "") {
            //     return this.e("Selectionner le mois");
            // }



            if (this.data.classeName == "") {
                return this.e("Selectionner une classe ");
            }

            if (this.data.matiere == "") {
                return this.e("Selectionner la matiere");
            }

            if (this.data.chapitre.trim() == "") {
                return this.e("Choisir le chapitre ");
            }




            for (let i = 0; i < this.data.inputs2.length; i++) {
                if (this.data.inputs2[i].partie == "") {
                    return this.e(
                        "Choisir la partie " + " " + (i + 1)
                    );
                }

                if (this.data.inputs2[i].souspartie == "") {
                    return this.e(
                        "Renseignez  les sous-parties de la partie" + " " + (i + 1)
                    );
                }

            }


            const response4 = await this.callApi(
                "post",
                "api/teacher/createCahierTexte",
                this.data
            );

            if (response4.status == 200) {
                this.s("Cahier de texte ajouté correctement");
                this.$router.push("cahierNewAll");

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
