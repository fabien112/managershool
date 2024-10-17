<template>
    <div>
        <div class="wrapper">
            <HeaderTeacher />
            <MenuTeacher />

            <Modal v-model="showDelateModal" width="360">
                <p slot="header" style="color:rgb(61, 139, 228);text-align:center">
                    <Icon type="ios-information-circle"></Icon>
                    <span> Validation </span>
                </p>
                <div style="text-align:center">
                    <p> Etes-vous sure d'avoir coché uniquement les absents ? </p>
                    <p> Vous pouvez annuler en fermant la modal ? </p>
                </div>
                <div slot="footer">
                    <Button type="primary" size="large" long @click="Presence">Confirmer</Button>
                </div>
            </Modal>
            <div class="content-wrapper">
                <div class="container-full">
                    <section class="content">

                        <!-- START Card With Image -->
                        <!-- <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">
                                    PRESENCES
                                    <p class="subtitle font-size-14 mb-0">
                                        Selectionner une classe et faites
                                        l'appel
                                    </p>
                                </h4>
                            </div>
                        </div> -->

                        <div class="row">
                            <div class="col-12">
                                <div class="box no-shadow mb-0 bg-transparent">
                                    <div class="box-header no-border px-0">
                                        <Alert type="error" fade=true show-icon closable>

                                            Notifications des absences aux parents

                                            <Icon type="ios-bulb-outline" slot="icon"></Icon>
                                            <template slot="desc">
                                                Cette notifications est instantanee chez le parent
                                            </template>
                                        </Alert>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <input type="checkbox" id="jack" value="Jack" v-model="datas.checkedNames">
                        <br>
                        <div class="row">
                            <div class="col-md-12 col-lg-12">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for=""> Date et heure du cour </label>
                                            <input v-model="datas.dateJour" class="form-control"
                                                type="datetime-local" />
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for=""> Classe </label>
                                            <select @change="onChange($event)" v-model="datas.classeName"
                                                class="custom-select form-control required">
                                                <option v-for="(data, i) in ClassListes" :key="i"
                                                    :value="data.classe.id">
                                                    {{ data.classe.libelleClasse }}
                                                </option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for=""> Durée du cour en heure </label>

                                            <input type="number" v-model="datas.duree" class="form-control">

                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for=""> Matiere </label>

                                            <select v-model="datas.matiere" class="custom-select form-control required">
                                                <option v-for="(data, i) in LIbelleMatiereclasse" :key="i"
                                                    :value="data.libelle">
                                                    {{ data.libelle }}
                                                </option>
                                            </select>

                                        </div>
                                    </div>


                                </div>

                                <div class="row">

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <button @click="afficher"
                                                class="waves-effect waves-light btn mb-5  btn btn-primary">
                                                Suivant
                                            </button>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>


                        <div class="card" v-if="rempli == true">
                            <div class="row">
                                <div class="col-lg-12 col-md-12">

                                    <Alert type="info" show-icon closable>

                                        <p style="text-align:center"> Cocher les eleves absents et cliquer sur terminer
                                        </p>

                                        <template slot="desc">
                                            <template slot="desc">
                                                Attention !!! Vous ne pourrez plus modifier une fois valider.
                                            </template>
                                        </template>

                                    </Alert>
                                    <div v-for="(data, i) in Classes" :key="i">
                                        <div>
                                            <div class="media-list media-list-divided media-list-hover">
                                                <div class="media align-items-center">
                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox" :id="data.id" :value="data.id"
                                                            class="chk-col-danger" v-model="checkedNames" />

                                                        <label :for="data.id">   </label>

                                                    </div>

                                                    <a class="flexbox flex-grow gap-items text-truncate"
                                                        href="#qv-user-details" data-toggle="quickview">
                                                        <img class="avatar" :src="
                                                            `/Photos/Logos/${data.user.photo}`
                                                        " alt="" />

                                                        <div class="media-body text-truncate">
                                                            <h6>{{ data.nom }}</h6>
                                                            <small>
                                                                <span>{{ data.prenom }}</span>

                                                            </small>
                                                        </div>
                                                    </a>


                                                    <!-- <input type="text" v-model="Retard[data.id]"
                                                            class="chk-col-danger" placeholder="Retard" /> -->



                                                </div>
                                            </div>
                                        </div>
                                        <!-- /.box-body -->
                                    </div>
                                </div>
                            </div>


                        </div>

                        <div class="row" v-if="rempli == true">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <button type="button" class="waves-effect waves-light btn mb-5 btn btn-primary"
                                        @click="ShowModal">
                                        Terminer
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
            datas: {

                matiere: "",
                dateJour: "",
                duree: "",
                idClasse: "",
                classeName: ""


            },

            showDelateModal: false,
            LIbelleMatiereclasse: "",
            checkedNames: [],
            checkBoxs: [],
            Retard:{},

            rempli: false,
            users: [],
            ClassListes: [],
            HeuresListes: [],
            MatieresListes: [],
            Classes: [],
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

        const response1 = await this.callApi(
            "post",
            "api/teacher/getAllHeures"
        );

        this.HeuresListes = response1.data;

    },

    methods: {

        async onChange(event) {

            this.datas.idClasse = event.target.value;

            this.datas.users = this.users;


            // Recuperer toutes les matieres de cette  classe

            const response3 = await this.callApi(
                "post",
                "api/teacher/getLibelleMatiereclasseById", this.datas
            );

            this.LIbelleMatiereclasse = response3.data

        },

        ShowModal() {

            this.showDelateModal = true


        },

        async afficher() {

            this.show = true;

            if (this.datas.dateJour.trim() == "") {
                return this.e("Date et heure du cour ");
            }

            if (this.datas.classeName == "") {
                return this.e("Selectionner une classe ");
            }

            if (this.datas.matiere.trim() == "") {
                return this.e("Saisir la matiere");
            }

            if (this.datas.duree == "") {
                return this.e("Saisir la durée de votre  cour ");
            }

            const response2 = await this.callApi(
                "post",
                "api/teacher/getStudentByTeacherForAppel",
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

            // var message ="Salut test"

            // var send = "https://api.whatsapp.com/send?phone=+237673000865&text=" + message;

            // window.open(send);

            this.datas.checkBoxs = this.checkedNames;


            // this.datas.retard = this.Retard;



            //  this.datas.users = this.users

            // Exeptionnellement ici on envoie le message de felicitation
            // avant de faire lappel d'envoyer le mail car l'envoie prend du temps

            this.showDelateModal = false

            this.s('Vous avez correctement fait la présence')

           this.$router.push('dashTeacher');


            const response = await this.callApi(
                "post",
                "api/teacher/DoAppelByTeacher",
                this.datas
            );



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
