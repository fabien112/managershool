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
                                    <label for>Mois</label>

                                    <select name="LeaveType" class="form-control" v-model="data.idMois">
                                        <option v-for="(data, i) in ClasseListes" :key="i" :value="data.id">{{ data.nom
                                        }}</option>
                                    </select>
                                </div>


                            </div>

                            <div class="col-md-6"> <br>
                                <div class="form-group">
                                    <div class="form-group">
                                        <button @click="Afficher" class="btn btn-primary btn-block">Envoyer</button>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <!-- <div class="row">

                            <div class="col-md-12 col-lg-4">

                                <router-link to="salairesCaisse">

                                    <div class="card" style="background-color:rebeccapurple;color: white;">

                                        <Icon type="md-calendar" style="margin-top: 50px;font-size: 40px;" />

                                        <div class="box-body py-17" style="text-align: center;">

                                            <p class="font-weight-600"> Salaire des enseignants </p>
                                        </div>


                                    </div>

                                </router-link>

                            </div>

                            <div class="col-md-12 col-lg-4">

                                <router-link to="salairePersonnel">

                                    <div class="card" style="background-color:#33993e;color: white;">

                                        <Icon type="ios-browsers" style="margin-top: 50px;font-size: 40px;" />

                                        <div class="box-body py-17" style="text-align: center;">

                                            <p class="font-weight-600"> Salaires du personnel </p>
                                        </div>


                                    </div>

                                </router-link>

                            </div>



                            <div class="col-md-12 col-lg-4">

                                <router-link to="depenseCaisse">

                                    <div class="card" style="background-color: #2C353D ; color:white">

                                        <Icon type="ios-folder" style="margin-top: 50px;font-size: 40px;" />

                                        <div class="box-body py-17" style="text-align: center;">

                                            <p class="font-weight-600"> Autres dépenses </p>
                                        </div>


                                    </div>

                                </router-link>

                            </div>

                        </div> -->



                        <div class="row">
                            <div class="col-12">
                                <div class="box no-shadow mb-0 bg-transparent">
                                    <div class="box-header no-border px-0">
                                        <Alert type="warning" fade=true show-icon closable>

                                            Bilan des dépenses menseulles en générale

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
                            <div class="col-4">
                                <div class="box no-shadow mb-0 bg-transparent">
                                    <div class="box-header no-border px-0">
                                        <Alert fade=true show-icon closable>
                                            Total des entrées du mois
                                            <Icon type="ios-bulb-outline" slot="icon"></Icon>
                                            <template slot="desc">
                                                {{ Salaires.EntreMois }}F
                                            </template>
                                        </Alert>
                                    </div>
                                </div>
                            </div>

                            <div class="col-4">
                                <div class="box no-shadow mb-0 bg-transparent">
                                    <div class="box-header no-border px-0">
                                        <Alert type="error" fade=true show-icon closable>

                                            Total des sorties du mois

                                            <Icon type="ios-bulb-outline" slot="icon"></Icon>
                                            <template slot="desc">
                                                {{ Salaires.total + Salaires.totalp + Salaires.totalAutre
                                                }} F
                                            </template>
                                        </Alert>
                                    </div>
                                </div>
                            </div>

                            <div class="col-4">
                                <div class="box no-shadow mb-0 bg-transparent">
                                    <div class="box-header no-border px-0">
                                        <Alert fade=true show-icon closable>

                                            Solde en caisse

                                            <Icon type="ios-bulb-outline" slot="icon"></Icon>
                                            <template slot="desc">
                                                {{ Salaires.solde }} F
                                            </template>
                                        </Alert>
                                    </div>
                                </div>
                            </div>


                        </div>

                        <div class="row">
                            <div class="col-12">
                                <div class="box no-shadow mb-0 bg-transparent">
                                    <div class="box-header no-border px-0">
                                        <Alert type="success" fade=true show-icon closable>

                                            Précision sur les transactions  mensuelles

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


                            <div class="col-md-12 col-lg-4">

                                <router-link to="salaires">
                                    <div class="card" style="background-color:#2C353D;color: white;">

                                        <p style="text-align:center; margin-top: 20px"> Masse salariale des enseignants  </p>

                                        <Icon type="ios-basketball" style="margin-top: 10px;font-size: 20px;" />

                                        <div class="box-body py-17" style="text-align: center;">
                                            <p class="font-weight-600"> {{ Salaires.total }} F </p>
                                        </div>


                                    </div>
                                </router-link>

                            </div>


                            <div class="col-md-12 col-lg-4">


                                <router-link to="salairePersonnelLocal">



                                    <div class="card" style="background-color:#0052CC;color: white;">

                                        <p style="text-align:center; margin-top: 20px"> Masse salariale du personnel  </p>

                                        <Icon type="ios-analytics" style="margin-top: 10px;font-size: 20px;" />

                                        <div class="box-body py-17" style="text-align: center;">

                                            <p class="font-weight-600"> {{ Salaires.totalp }} F </p>
                                        </div>


                                    </div>

                                </router-link>



                            </div>



                            <div class="col-md-12 col-lg-4">

                                <router-link to="depenseLocal">

                                    <div class="card" style="background-color: #E91E63 ; color:white">

                                        <p style="text-align:center; margin-top: 20px"> Les autres dépenses du mois </p>



                                        <Icon type="ios-aperture" style="margin-top:10px;font-size: 20px;" />

                                        <div class="box-body py-17" style="text-align: center;">

                                            <p class="font-weight-600"> {{ Salaires.totalAutre }} F
                                            </p>
                                        </div>


                                    </div>

                                </router-link>



                            </div>

                             <div class="col-12">
                                <div class="box">
                                    <div class="box-header bg-primary">
                                        <h4 class="box-title" style="margin:auto"> Historique des entrées du mois

                                        </h4>


                                    </div>
                                    <div class="box-body">
                                        <div class="table-responsive">
                                            <table id="example" class="table simple mb-0" style="width:100%">

                                                <thead>

                                                    <tr>

                                                        <th> Date</th>
                                                        <th> Montant</th>
                                                        <th> Motif </th>

                                                    </tr>
                                                </thead>
                                                <tbody>

                                                    <tr v-for="(data, i) in Salaires.HistEntree" :key="i">
                                                        <td>{{ data.date|dateFormat }}</td>
                                                        <td>{{data.montantverser}} F </td>
                                                        <!-- <td v-if="data.motif!='APE'"> {{data.motif}}</td> -->
                                                        <td >

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

        const response2 = await this.callApi(
            "post",
            "api/locale/getAllMois"
        );

        this.ClasseListes = response2.data;


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


            if (this.data.idMois == "") {
                return this.e("Selectionner un mois  ");
            }



            this.TotalHeure = 0;


            const response3 = await this.callApi(
                "post",
                "api/locale/getAllTotalSalairesMois", this.data
            );

            this.Salaires = response3.data;


            this.showRecap = true



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
