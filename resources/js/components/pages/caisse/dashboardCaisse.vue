<template>
    <div>
        <div class="wrapper">
            <Header />
            <MenuCaisse />
            <div class="content-wrapper">
                <div class="container-full">
                    <section class="content">
                        <div class="row align-items-end">
                            <div class="col-xl-12 col-12">
                                <div class="box bg-primary-light pull-up">
                                    <div class="box-body p-xl-0">
                                        <div class="row align-items-center">
                                            <div class="col-12 col-lg-3">
                                                <img src="images/1234.jpg" alt="" />
                                            </div>

                                            <div class="col-12 col-lg-9">

                                                <h1> 😊 😊 COMPTABLE 😊 ✋ </h1>


                                                <h4 class="text-dark mb-0 font-size-10">

                                                    Bienvenu,

                                                    {{
                                                        this.users.nom
                                                    }}
                                                    {{
                                                        this.users.prenom
                                                    }} ✋

                                                </h4>
                                                <p v-for="(data,
                                                i) in EtabInfos" :key="i">
                                                    {{ data.libelleEtab }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-4">
                                <div class="box no-shadow mb-0 bg-transparent">
                                    <div class="box-header no-border px-0">
                                        <Alert fade=true show-icon closable type="error">

                                            TOTAL ENTREES

                                            <!-- <Icon type="ios-bulb-outline" slot="icon"></Icon> -->

                                            <span class="pull-right" style="font-size: 40px;"> 💸 </span>


                                            <template slot="desc">
                                                {{ totalEntree+ totalEntree2 }} F
                                            </template>
                                        </Alert>
                                    </div>
                                </div>
                            </div>





                            <div class="col-xl-4 col-12">



                                <div class="box" style="background-color:#E67D21;color:white">
                                    <div class="box-body">
                                        <p>
                                            {{
                                                totalEntree
                                            }} F
                                            <!--
                                            <Divider type="vertical" /> -->
                                            <!-- <Icon type="md-walk" class="pull-right " style="font-size: 60px;" /> -->

                                            <span class="pull-right" style="font-size: 40px;"> 👨🏽‍🎓 </span>
                                        </p>
                                        <p class="mt-0 mb-20 " style="font-size: 10px;">
                                            ENTREES SCOLARITE
                                        </p>
                                        <div id="charts_widget_2_chart"></div>
                                    </div>
                                </div>


                            </div>






                            <div class="col-xl-4 col-12">

                                <router-link to="autreentree">


                                    <div class="box" style="background-color:#4983DA;color:white">
                                        <div class="box-body">
                                            <p>
                                                {{ totalEntree2 }} F

                                                <!-- <Icon type="ios-basketball" class="pull-right "
                                                    style="font-size: 60px;" /> -->

                                                <span class="pull-right" style="font-size: 40px;"> 💰 </span>

                                            </p>
                                            <p class="mt-0 mb-20 " style="font-size: 10px;">
                                                AUTRES ENTREES
                                            </p>
                                            <div id="charts_widget_2_chart"></div>

                                        </div>
                                    </div>

                                </router-link>

                            </div>


                            <div class="col-4">
                                <div class="box no-shadow mb-0 bg-transparent">
                                    <div class="box-header no-border px-0">
                                        <Alert fade=true show-icon closable>

                                            DEPENSES
                                            <!-- <Icon type="ios-bulb-outline" slot="icon"></Icon> -->


                                            <span class="pull-right" style="font-size: 40px;"> 💸 </span>
                                            <template slot="desc">
                                                {{ totalSorties.total - totalCaisseBanque }} F
                                            </template>
                                        </Alert>
                                    </div>
                                </div>
                            </div>




                            <div class="col-xl-4 col-12">

                                <div class="box" style="background-color:#E91E63;color:white">
                                    <div class="box-body">
                                        <p>

                                            {{ solde }} F


                                            <!-- <Icon type="ios-aperture" class="pull-right " style="font-size: 60px;" /> -->


                                            <span class="pull-right" style="font-size: 40px;"> 💰 </span>
                                        </p>
                                        <p class="mt-0 mb-20 " style="font-size: 10px;">
                                            SOLDE EN CAISSE
                                        </p>

                                        <div id="charts_widget_2_chart"></div>
                                    </div>
                                </div>

                            </div>


                            <div class="col-xl-4 col-12">

                                <div class="box" style="background-color:#2C353D;color:white">
                                    <div class="box-body">
                                        <p>

                                            {{ datas.totalAppro - datas.totalSortiBank }} F
                                            <!-- {{Stats["totalEleves"]}} -->

                                            <!-- <Icon type="ios-analytics" class="pull-right " style="font-size: 60px;" /> -->


                                            <span class="pull-right" style="font-size: 40px;"> 💰 </span>
                                        </p>
                                        <p class="mt-0 mb-20 " style="font-size: 10px;">
                                            SOLDE BANQUE

                                        </p>
                                        <div id="charts_widget_2_chart"></div>
                                    </div>
                                </div>

                            </div>





                        </div>


                        <div class="row">
                            <div class="col-xl-4 col-12">
                                <div class="box">
                                    <div class="box-header bg-primary " style="text-align: center;">
                                        <h4 class="box-title">
                                            <strong>
                                                INCRIPTION
                                            </strong>
                                        </h4>
                                    </div>
                                    <div class="box-body">
                                        <div class="table-responsive">
                                            <table class="table simple mb-0">
                                                <tbody>
                                                    <tr>
                                                        <td>Total attendu </td>
                                                        <td class=" font-weight-700">
                                                            {{ Finances.ape }} F
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td>Total perçu </td>
                                                        <td class=" font-weight-700">
                                                            {{ Aspayed.ape }} F
                                                        </td>
                                                    </tr>


                                                    <tr>
                                                        <td> Reste </td>
                                                        <td class=" font-weight-700">
                                                            {{ Finances.ape - Aspayed.ape }} F
                                                        </td>
                                                    </tr>

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-4 col-12">
                                <div class="box">
                                    <div class="box-header bg-success " style="text-align: center;">
                                        <h4 class="box-title">
                                            <strong>
                                                TRANCHE 1
                                            </strong>
                                        </h4>
                                    </div>
                                    <div class="box-body">
                                        <div class="table-responsive">
                                            <table class="table simple mb-0">
                                                <tbody>
                                                    <tr>
                                                        <td>Total attendu </td>
                                                        <td class=" font-weight-700">
                                                            {{ Finances.tranche1 }} F
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td>Total perçu </td>
                                                        <td class=" font-weight-700">
                                                            {{ Aspayed.tranche1 }} F
                                                        </td>
                                                    </tr>


                                                    <tr>
                                                        <td>Reste </td>
                                                        <td class=" font-weight-700">
                                                            {{ Finances.tranche1 - Aspayed.tranche1 }} F
                                                        </td>
                                                    </tr>

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-4 col-12">
                                <div class="box">
                                    <div class="box-header bg-dark " style="text-align: center;">
                                        <h4 class="box-title">
                                            <strong>
                                                TRANCHE 2
                                            </strong>
                                        </h4>
                                    </div>
                                    <div class="box-body">
                                        <div class="table-responsive">
                                            <table class="table simple mb-0">
                                                <tbody>
                                                    <tr>
                                                        <td>Total attendu </td>
                                                        <td class=" font-weight-700">
                                                            {{ Finances.tranche2 }} F
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td>Total perçu </td>
                                                        <td class=" font-weight-700">
                                                            {{ Aspayed.tranche2 }} F
                                                        </td>
                                                    </tr>


                                                    <tr>
                                                        <td> Reste </td>
                                                        <td class=" font-weight-700">
                                                            {{ Finances.tranche2 - Aspayed.tranche2 }} F
                                                        </td>
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
import Chats from "../../navs/Chats.vue";
import { mapState } from "vuex";
import MenuCaisse from "../../navs/MenuCaisse.vue";
import { thisExpression } from '@babel/types';

export default {
    components: { Header, Chats, MenuCaisse },
    data() {
        return {
            EtabInfos: [],
            Stats: [],
            users: [],
            Finances: [],
            Aspayed: [],
            totalEntree: 0,
            totalEntree2: 0,
            totalDepotBanque: 0,
            totalCaisseBanque: 0,
            totalSorties: 0,
            solde: 0,
            datas: {
                'totalAppro': 0,
                'totalSortiBank': 0
            },
        };
    },

    //  Recuperer les donnees envoyees dans la store par computed:


    async created() {


        if (!localStorage.users) {

            this.$router.push('login');
        }


    },

    async mounted() {





        if (localStorage.users) {
            this.users = JSON.parse(localStorage.getItem("users"));
        }

        const response = await this.callApi(
            "post",
            "api/caisse/getEtabinfosCaisse",
            this.users
        );

        this.EtabInfos = response.data;

        // Garder les donnees de l'ecole dans le storage de navigateur

        localStorage.setItem("EtabInfos", JSON.stringify(this.EtabInfos));

        //  STATISTIQUES

        // Total entree

        const response5 = await this.callApi(
            "post",
            "api/locale/getAstudentDatailsFinancesDashboard",
            this.EtabInfos
        );

        this.Aspayed = response5.data;

        const response2 = await this.callApi(
            "post",
            "api/locale/getstatsEtab",
            this.EtabInfos
        );

        this.Stats = response2.data;

        const response8 = await this.callApi(
            "post",
            "api/locale/getTotaldepense",
            this.EtabInfos
        );


        this.totalSorties = response8.data;


        const response9 = await this.callApi(
            "post",
            "api/locale/getEntressAutre",
            this.EtabInfos
        );

        this.datas = response9.data



        const response3 = await this.callApi(
            "post",
            "api/locale/getRecapFinances",
            this.EtabInfos
        );
        this.Finances = response3.data;

        this.totalEntree = parseInt(this.Aspayed.ape, 10) + parseInt(this.Aspayed.tranche1, 10) + parseInt(this.Aspayed.tranche2, 10) // scolarite

        this.totalEntree2 = parseInt(this.Aspayed.autre, 10) // autre entrees


        // pour avoir le solde de la caisse  je fais toutes les entrees - toutes les depense ( depense et depot en banque)

        // je dois inclure les entrees qui viennene t de l'approvisionnement bancaire ( mais cette entree n'est pas pris en compte dans la somme des entre)

        this.totalVenantDeBank = parseInt(this.Aspayed.totalBanqueCaisse, 10);

        this.totalCaisseBanque = parseInt(this.Aspayed.totalCaiiseBanque, 10);

        this.solde = this.totalEntree + this.totalEntree2 + this.totalVenantDeBank - this.totalSorties.total

    },

    methods: {

        async pdf() {

            const response8 = await this.callApi(
                "post",
                "api/pdf"
            );



        }
    }

}


</script>
