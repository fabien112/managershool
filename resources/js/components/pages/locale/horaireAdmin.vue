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
                    <p> Etes-vous sûr de vouloir enregistrer ? </p>

                </div>
                <div slot="footer">
                    <Button type="error" size="large" long @click="Presence">Confirmer</Button>
                </div>
            </Modal>
            <div class="content-wrapper">
                <div class="container-full">

                    <section class="content">
                        <div class="box box-default">

                            <div class="box-header" style="background-color:#0052CC;text-align: center; color:white">

                                <h4 class="box-title">
                                    Heures de cour du mois de {{ nomMois }}
                                </h4>
                            </div>

                            <!-- /.box-header -->
                            <div class="box-body wizard-content">
                                <section class="content">




                                    <div class="row">
                                        <div class="col-lg-12 col-md-12">


                                            <div v-for="(data, i) in ClassListes" :key="i">
                                                <div>
                                                    <div class="media-list media-list-divided media-list-hover">
                                                        <div class="media align-items-center">

                                                            <a class="flexbox flex-grow gap-items text-truncate"
                                                                href="#qv-user-details" data-toggle="quickview">


                                                                <div class="media-body text-truncate">
                                                                    <h6> {{ data.nom }} {{ data.prenom }} </h6>

                                                                </div>
                                                            </a>

                                                            <div class="custom-control custom-checkbox">



                                                                <input placeholder="Ajouter" type="number"
                                                                    class="form-control" v-model="Note[data.user_id]" />

                                                            </div>


                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>


                                    </div> <br>

                                    <div class="row">
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

import Menu from "../../navs/Menu.vue";
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
import MenuLocal from "../../navs/MenuLocal.vue";
import Header from "../../headers/Header.vue";
import { thisTypeAnnotation } from "@babel/types";

export default {
    components: { Menu, Chats, MenuLocal, Header },
    data() {
        return {

            idMois: "",
            nomMois: '',

            datas: {
                classeName: "",
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

        if (localStorage.IdMois) {

            this.idMois = JSON.parse(localStorage.getItem("IdMois"));

            if (this.idMois == 1) {

                this.nomMois = 'Janvier';
            }

            if (this.idMois == 2) {

                this.nomMois = 'Février';
            }

            if (this.idMois == 3) {

                this.nomMois = 'Mars';
            }

            if (this.idMois == 4) {

                this.nomMois = 'Avril';
            }

            if (this.idMois == 5) {

                this.nomMois = 'Mai';
            }

            if (this.idMois == 6) {

                this.nomMois = 'Juin';
            }

            if (this.idMois == 7) {

                this.nomMois = 'Juillet';
            }

            if (this.idMois == 8) {

                this.nomMois = 'Aout';
            }

            if (this.idMois == 9) {

                this.nomMois = 'Septembre';
            }

            if (this.idMois == 10) {

                this.nomMois = 'Octobre';
            }

            if (this.idMois == 11) {

                this.nomMois = 'Novembre';
            }

            if (this.idMois == 12) {

                this.nomMois = 'Decembre';
            }


        }




        const response = await this.callApi(
            "post",
            "api/locale/getAllEnseignant",
            this.users
        );

        this.ClassListes = response.data.contentSimple

    },
    methods: {


        async onChange(event) {


            this.idMois = event.target.value;

            localStorage.setItem('IdMois', JSON.stringify(this.idMois));




        },



        ShowModal() {

            this.showDelateModal = true


        },



        async Presence() {


            this.showDelateModal = false

            //this.s('Vous avez correctement fait la presence')


            this.datas.Note = this.Note

            this.datas.idMois = this.idMois


            if (Object.keys(this.Note).length != this.ClassListes.length) {

                this.e("Vous devez ajouter les heures de tous les enseignants");

            }



            else {



                for (var item in this.Note) {


                    console.log(this.Note[item]);

                    if (this.Note[item] == '') {

                        var dec = true;

                        this.e(" Saisir correctement toutes les heures ! ");

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
                        "api/locale/getAdminHeure",
                        this.datas
                    );
                    if (response.status == 200) {

                        this.s(" Heures ajoutées correctement");

                        this.$router.push('salaires');


                    }

                    if (response.status != 200) {

                        this.e(" Ces heures sont incorrectes ou existent deja !  ");

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
