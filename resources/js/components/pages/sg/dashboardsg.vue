<template>
    <div>
        <div class="wrapper">
            <Header />
            <MenuSG />
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

                                                <h1> Surveillant général </h1>


                                                <h4 class="text-dark mb-0 font-size-10">

                                                    Bienvenu,

                                                    {{
                                                            this.users.nom
                                                    }}
                                                    {{
                                                            this.users.prenom
                                                    }}

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
                            <div class="col-12">
                                <div class="box no-shadow mb-0 bg-transparent">
                                    <div class="box-header no-border px-0">
                                        <Alert fade=true show-icon closable>

                                            STATISTIQUES

                                            <Icon type="ios-bulb-outline" slot="icon"></Icon>
                                            <template slot="desc">
                                                Quelques chiffres concernant votre école.
                                            </template>
                                        </Alert>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="row">

                            <div class="col-xl-4 col-12">


                                    <div class="box" style="background-color:#E67D21;color:white">
                                        <div class="box-body">
                                            <p>
                                                {{
                                                        Stats["totalEleves"]
                                                }}
                                                <!--
                                            <Divider type="vertical" /> -->
                                                <!-- <Icon type="md-walk" class="pull-right " style="font-size: 60px;" /> -->

                                                <span class="pull-right" style="font-size: 40px;"> 👨🏽‍🎓 </span>
                                            </p>
                                            <p class="mt-0 mb-20 " style="font-size: 10px;">
                                                ELEVES
                                            </p>
                                            <div id="charts_widget_2_chart"></div>
                                        </div>
                                    </div>



                            </div>




                            <div class="col-xl-4 col-12">

                                <div class="box" style="background-color:#4983DA;color:white">
                                    <div class="box-body">
                                        <p>
                                           {{
                                                        Stats["totalParents"]
                                                }}
                                            <!-- <Icon type="ios-people" class="pull-right " style="font-size: 60px;" /> -->

                                            <span class="pull-right" style="font-size: 40px;"> 🧑‍🤝‍🧑 </span>
                                        </p>
                                        <p class="mt-0 mb-20 " style="font-size: 10px;">
                                            PARENTS
                                        </p>
                                        <div id="charts_widget_2_chart"></div>

                                    </div>
                                </div>

                            </div>
                            <div class="col-xl-4 col-12">

                                <div class="box" style="background-color:#2C353D;color:white">
                                    <div class="box-body">
                                        <p>
                                            {{Stats["totalEnseignants"]}}
                                            <!-- <Divider type="vertical" /> -->
                                            <!-- <Icon type="ios-man" class="pull-right " style="font-size: 60px;" /> -->

                                            <span class="pull-right" style="font-size: 40px;"> 👨‍🏫 </span>
                                        </p>
                                        <p class="mt-0 mb-20 " style="font-size: 10px;">
                                            ENSEIGNANTS

                                        </p>
                                        <div id="charts_widget_2_chart"></div>
                                    </div>
                                </div>

                            </div>





                        </div>



                        <!-- <div class="row">

                            <div class="col-xl-4 col-12">
                                <div class="box" style="background-color:#7451EB;color:white">
                                    <div class="box-body">
                                        <h6 style="font-size: 20px;">

                                            {{ Aspayed.tranche1 }}

                                            <span class="pull-right " style="font-size: 20px;"> FCFA </span>

                                        </h6>
                                        <p class="mt-0 mb-20 " style="font-size: 10px;">
                                            {{ Finances.tranche1 }}
                                        </p>
                                        <p style="font-size: 10px;">
                                            TRANCHE 1
                                        </p>
                                        <div id="charts_widget_2_chart"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4 col-12">
                                <div class="box" style="background-color:#084622;color:white">
                                    <div class="box-body">
                                        <h6 style="font-size: 20px;">

                                            {{ Aspayed.tranche2 }}

                                            <span class="pull-right " style="font-size: 20px;"> FCFA </span>

                                        </h6>
                                        <p class="mt-0 mb-20 " style="font-size: 10px;">
                                            {{ Finances.tranche2 }}
                                        </p>
                                        <p style="font-size: 10px;">
                                            TRANCHE 2
                                        </p>
                                        <div id="charts_widget_2_chart"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4 col-12">
                                <div class="box" style="background-color:#4b4845;color:white">
                                    <div class="box-body">
                                        <h6 style="font-size: 20px;">

                                            {{ Aspayed.ape }}

                                            <span class="pull-right " style="font-size: 20px;"> FCFA </span>

                                        </h6>
                                        <p class="mt-0 mb-20 " style="font-size: 10px;">
                                            {{ Finances.ape }}
                                        </p>
                                        <p style="font-size: 10px;">
                                            INSCRIPTION
                                        </p>
                                        <div id="charts_widget_2_chart"></div>
                                    </div>
                                </div>
                            </div>




                        </div> -->








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
import { thisExpression } from '@babel/types';
import MenuSG from "../../navs/MenuSG.vue";

export default {
    components: { Header, Chats, MenuSG },
    data() {
        return {
            EtabInfos: [],
            Stats: [],
            users: [],
            Finances: [],
            Aspayed: [],
            totalEntree: 0,
            totalSorties: 0,
            solde: 0
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

        const response3 = await this.callApi(
            "post",
            "api/locale/getRecapFinances",
            this.EtabInfos
        );
        this.Finances = response3.data;

        this.totalEntree = parseInt(this.Aspayed.ape, 10) + parseInt(this.Aspayed.tranche1, 10) + parseInt(this.Aspayed.tranche2, 10)

        this.solde = this.totalEntree - this.totalSorties.total
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
