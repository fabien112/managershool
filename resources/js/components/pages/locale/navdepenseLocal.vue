<template>

    <div>
        <div class="wrapper">
            <Header />
            <MenuLocal />
            <div class="content-wrapper">
                <div class="container-full">

                    <section class="content">



                        <!-- <div class="row">
                            <div class="col-12">
                                <div class="box no-shadow mb-0 bg-transparent">
                                    <div class="box-header no-border px-0">
                                        <Alert  fade=true show-icon closable>
                                            SORTIES ET DEPENSES
                                            <Icon type="logo-usd" slot="icon"></Icon>

                                        </Alert>
                                    </div>
                                </div>
                            </div>

                        </div> -->




                        <div class="row">



                            <div class="col-md-12 col-lg-4">

                                <router-link to="salaires">

                                    <div class="card" style="background-color:rebeccapurple;color: white;">

                                        <!-- <Icon type="md-calendar" style="margin-top: 50px;font-size: 40px;" /> -->

                                        <span  style="margin-top: 40px;font-size: 50px; text-align:center;" > 💰 </span>

                                        <div class="box-body py-17" style="text-align: center;">

                                            <p class="font-weight-600"> Salaire des enseignants </p>
                                        </div>


                                    </div>

                                </router-link>

                            </div>

                            <div class="col-md-12 col-lg-4">

                                <router-link to="salairePersonnelLocal">

                                    <div class="card" style="background-color:#33993e;color: white;">

                                        <!-- <Icon type="ios-browsers" style="margin-top: 50px;font-size: 40px;" /> -->

                                        <span  style="margin-top: 40px;font-size: 50px; text-align:center;" > 💰 </span>

                                        <div class="box-body py-17" style="text-align: center;">

                                            <p class="font-weight-600"> Salaires du personnel </p>
                                        </div>


                                    </div>

                                </router-link>

                            </div>



                            <div class="col-md-12 col-lg-4">

                                <router-link to="depenseLocal">

                                    <div class="card" style="background-color: #2C353D ; color:white">

                                        <!-- <Icon type="ios-folder" style="margin-top: 50px;font-size: 40px;" /> -->

                                        <span  style="margin-top: 40px;font-size: 50px; text-align:center;" > 💰 </span>

                                        <div class="box-body py-17" style="text-align: center;">

                                            <p class="font-weight-600"> Autres dépenses </p>
                                        </div>


                                    </div>

                                </router-link>

                            </div>

                        </div>

                        <!-- <div class="row">
                            <div class="col-12">
                                <div class="box no-shadow mb-0 bg-transparent">
                                    <div class="box-header no-border px-0">
                                        <Alert  fade=true show-icon closable>
                                           COMPTABILITE
                                            <Icon type="logo-usd" slot="icon"></Icon>

                                        </Alert>
                                    </div>
                                </div>
                            </div>

                        </div> -->


                          <div class="row">



                            <div class="col-md-12 col-lg-4">

                                <router-link to="comptajournelocal">

                                    <div class="card" style="background-color:#E91E63;color: white;">

                                        <span  style="margin-top: 40px;font-size: 50px; text-align:center;" > 💰 </span>

                                        <!-- <Icon type="md-calendar" style="margin-top: 50px;font-size: 40px;" /> -->

                                        <div class="box-body py-17" style="text-align: center;">

                                            <p class="font-weight-600"> Comptabilité journalière  </p>
                                        </div>


                                    </div>

                                </router-link>

                            </div>

                            <div class="col-md-12 col-lg-4">

                                <router-link to="salairedash">

                                    <div class="card" style="background-color:#0052CC;color: white;">

                                        <!-- <Icon type="ios-browsers" style="margin-top: 50px;font-size: 40px;" /> -->

                                        <span  style="margin-top: 40px;font-size: 50px; text-align:center;" > 💰 </span>
                                        <div class="box-body py-17" style="text-align: center;">

                                            <p class="font-weight-600"> Comptabilité mensuelle  </p>
                                        </div>


                                    </div>

                                </router-link>

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

            data: {

                idMois: "",


            },
            EdetingModal: false,
            showDelateModal: false,
            keyword: "",
            keyword2: "",
            ClasseListes: "",
            Salaires: {

                total: 0,
                totalp: 0,
                totalAutre: 0
            },
            EleveListes: "",
            ElevesAbsences: "",
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

        // const response2 = await this.callApi(
        //     "post",
        //     "api/locale/getAllMois"
        // );

        // this.ClasseListes = response2.data;


    },

    methods: {

        // showDelatingModal(data, i) {
        //     this.delateItem = data;
        //     this.i = i;
        //     this.showDelateModal = true;
        // },

        // showEdetingModal() {

        //     this.EdetingModal = true
        // },

        // async Afficher() {


        //     if (this.data.idMois == "") {
        //         return this.e("Selectionner un mois  ");
        //     }



        //     this.TotalHeure = 0;


        //     const response3 = await this.callApi(
        //         "post",
        //         "api/locale/getAllTotalSalairesMois", this.data
        //     );

        //     this.Salaires = response3.data;


        //     this.showRecap = true



        // }


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
