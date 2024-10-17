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
            <div class="content-wrapper">
                <div class="container-full">

                    <section class="content">
                        <div class="box box-default">

                            <div class="box-header" style="background-color:#0052CC;text-align: center; color:white">

                                <h4 class="box-title">
                                    Ajouter des absences
                                </h4>
                            </div>

                            <!-- /.box-header -->
                            <div class="box-body wizard-content">
                                <section class="content">

                                    <!-- START Card With Image -->
                                    <!-- <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">
                                   AJOUTER UNE NOTE
                                    <p class="subtitle font-size-14 mb-0">
                                        Selectionner une classe et ajouter une note
                                    </p>
                                </h4>
                            </div>
                        </div> -->

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




                                            </div>



                                            <div class="row">

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <button @click="afficher"
                                                            class="waves-effect waves-light btn mb-5  btn btn-primary">
                                                            Assigner
                                                        </button>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div> <br><br><br>

                                    <div class="card" v-if="rempli == true">

                                        <div class="row">
                                            <div class="col-lg-12 col-md-12">

                                                <Alert type="info" show-icon closable>

                                                    <p style="text-align:center"> Ajoutez les heures de chaque élève
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
                                                                        <h6> {{ data.nom }} {{ data.prenom }} </h6>

                                                                    </div>
                                                                </a>

                                                                <div class="custom-control custom-checkbox">



                                                                    <input placeholder="Ajouter" type="number"
                                                                        class="form-control" v-model="Note[data.id]" />

                                                                </div> &nbsp;&nbsp;&nbsp;&nbsp;



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
                                                <button type="button"
                                                    class="waves-effect waves-light btn mb-5 btn btn-primary"
                                                    @click="ShowModal">
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



        ShowModal() {

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
                "api/locale/getStudentBySg",
                this.datas
            );

            this.Classes = response2.data

            console.log(this.Classes)

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

                this.e("Saisir les absences à tout le monde. Mettez 0 à ceux qui n'en ont pas !");


            }

            else {



                for (var item in this.Note) {


                    console.log(this.Note[item]);

                    if (this.Note[item] == '') {

                        var dec = true;

                        this.e(" Saisir correctement toutes les absences ! ");

                        break;


                    }


                    else {

                        dec = false
                    }




                }


                console.log(dec);




                if (dec == false) {

                    const response = await this.callApi(
                        "post",
                        "api/locale/AddabsenceSg",
                        this.datas
                    );

                    if (response.status == 200) {

                        this.s(" Absences ajoutées correctement");

                        // this.$router.push('absenceSeg2');


                    }

                    if (response.status != 200) {

                        this.e(" Ces absences sont incorrectes ou existent deja !  ");

                    }




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
