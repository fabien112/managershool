<template>

    <div>
        <div class="wrapper">
            <Header />
            <MenuLocal />
            <div class="content-wrapper">
                <div class="container-full">

                    <section class="content">



                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for> Selectionner le jour </label>
                                    <input type="date" v-model="data.jour" class="form-control">
                                </div>


                            </div>

                            <div class="col-md-6"> <br>
                                <div class="form-group">

                                    <p class="btn btn-primary btn-block" @click="Afficher">
                                        <Icon style="font-size:20px" type="md-settings" />

                                        Voir les états du jour
                                    </p>


                                </div>
                            </div>

                        </div> <br> <br>

                        <div class="row">

                            <div class="col-md-12 col-lg-4">



                                <div class="card" style="background-color:#2C353D;color: white;">

                                    <p style="text-align:center; margin-top: 50px"> Total entrées </p>

                                    <Icon type="ios-basketball" style="margin-top: 10px;font-size: 40px;" />

                                    <div class="box-body py-17" style="text-align: center;">
                                        <p class="font-weight-600"> {{ Salaires.entreJour }} F </p>
                                    </div>


                                </div>



                            </div>

                            <div class="col-md-12 col-lg-4">



                                <div class="card" style="background-color:#0052CC;color: white;">

                                    <p style="text-align:center; margin-top: 50px"> Total sortie </p>

                                    <Icon type="ios-analytics" style="margin-top: 10px;font-size: 40px;" />

                                    <div class="box-body py-17" style="text-align: center;">

                                        <p class="font-weight-600"> {{ Salaires.sortieJ }} F </p>
                                    </div>


                                </div>



                            </div>



                            <div class="col-md-12 col-lg-4">



                                <div class="card" style="background-color: #E91E63 ; color:white">

                                    <p style="text-align:center; margin-top: 50px"> Solde en caisse </p>



                                    <Icon type="ios-aperture" style="margin-top:10px;font-size: 40px;" />

                                    <div class="box-body py-17" style="text-align: center;">

                                        <p class="font-weight-600"> {{ Salaires.solde }} F
                                        </p>
                                    </div>


                                </div>



                            </div>

                        </div>

                        <div class="row">
                            <div class="col-12">
                                <div class="box no-shadow mb-0 bg-transparent">
                                    <div class="box-header no-border px-0">
                                        <Alert type="error" fade=true show-icon closable>

                                            Bilan Finacier journalier

                                            <Icon type="ios-bulb-outline" slot="icon"></Icon>
                                            <!-- <template slot="desc">
                                                Quelques chiffres concernant votre école...
                                            </template> -->
                                        </Alert>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-6">
                                <div class="box">

                                    <div class="box-header bg-primary">
                                        <h4 class="box-title" style="margin:auto">
                                            <strong>
                                                Historique des entrées du jour
                                            </strong>
                                        </h4>
                                    </div>

                                    <div class="box-body">
                                        <div class="table-responsive">

                                            <table class="table product-overview">
                                                <thead>
                                                    <tr>

                                                        <th> Somme </th>
                                                        <th> Motif </th>

                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr v-for="(data, i) in Salaires.totalE" :key="i">

                                                        <td> {{ data.montantverser }} F </td>

                                                        <!-- <td v-if="data.motif == 'APE'"> Frais inscription </td>
                                                        <td v-else> Frais {{ data.motif }}</td> -->

                                                         <td>



                                                            <span v-if="data.motif!='APE'"> {{data.motif.toUpperCase()}} </span>

                                                    <span v-if="data.motif=='APE'"> INSCRIPTION</span>
                                                        </td>


                                                    </tr>
                                                </tbody>
                                            </table>

                                        </div>

                                    </div>
                                </div>
                            </div>

                            <div class="col-6">
                                <div class="box">

                                    <div class="box-header bg-danger">
                                        <h4 class="box-title" style="margin:auto">
                                            <strong>
                                                Historique des sorties du jour
                                            </strong>
                                        </h4>
                                    </div>

                                    <div class="box-body">
                                        <div class="table-responsive">

                                            <table class="table product-overview">
                                                <thead>
                                                    <tr>

                                                        <th> Somme </th>
                                                        <th> Motif </th>

                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr v-for="(data, i) in Salaires.totalS" :key="i">

                                                        <td> {{ data.montant }} F</td>
                                                        <td v-if="data.type == 0"> Paiement salaire du enseignant </td>
                                                        <td v-if="data.type == 1"> Paiement du salaire personnel </td>
                                                        <td v-if="data.type == 2"> {{ data.motif }} </td>
                                                    </tr>
                                                </tbody>
                                            </table>

                                        </div>

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

                jour: "",


            },

            Salaires: {
                entreJour: 0,
                sortieJ: 0
            },

            ClasseListes: "",

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

        showDelatingModal(data, i) {
            this.delateItem = data;
            this.i = i;
            this.showDelateModal = true;
        },

        showEdetingModal() {

            this.EdetingModal = true
        },

        async Afficher() {


            // if (this.data.idMois == "") {
            //     return this.e("Selectionner un mois  ");
            // }


            const response3 = await this.callApi(
                "post",
                "api/locale/getAllFinancesJour", this.data
            );

            this.Salaires = response3.data;



        }


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
