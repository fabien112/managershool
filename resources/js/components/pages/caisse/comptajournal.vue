<template>

    <div>
        <div class="wrapper">
            <Header />
            <MenuCaisse />
            <div class="content-wrapper">
                <div class="container-full">

                    <section class="content">

                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for> Selectionner le jour </label>
                                    <input type="date" v-model="data.jour" class="form-control">
                                </div>


                            </div>

                            <div class="col-md-3"> <br>
                                <div class="form-group">

                                    <p class="btn btn-primary btn-block" @click="Afficher">

                                        BILAN JOURNALIER
                                    </p>


                                </div>
                            </div>

                            <div class="col-md-3"> <br>
                                <div class="form-group">

                                    <p class="btn btn-warning btn-block" @click="BilanPdf">

                                        PDF JOUR
                                    </p>


                                </div>
                            </div>
                            <div class="col-md-3"> <br>
                                <div class="form-group">

                                    <p class="btn btn-danger btn-block" @click="BilanPdf2">

                                        PDF Global
                                    </p>


                                </div>
                            </div>


                        </div>
                        <!-- tabs -->

                        <div class="row">
                            <div class="col-12">
                                <div class="box box-default">
                                    <!-- <div class="box-header with-border bg-primary">
                                        <h4 class="box-title">Bilan financier du jour </h4>
                                    </div> -->
                                    <!-- /.box-header -->
                                    <div class="box-body">



                                        <!-- Nav tabs -->
                                        <ul class="nav nav-tabs" role="tablist">
                                            <li class="nav-item">
                                                <a class="nav-link active" data-toggle="tab" href="#home" role="tab">
                                                    <span class="hidden-sm-up">
                                                        <i class="ion-home"></i>
                                                    </span>
                                                    <span class="hidden-xs-down"> Entrées du jour
                                                    </span>
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" data-toggle="tab" href="#profile" role="tab">
                                                    <span class="hidden-sm-up">
                                                        <i class="ion-person"></i>
                                                    </span>
                                                    <span class="hidden-xs-down"> Sorties du jour
                                                    </span>
                                                </a>
                                            </li>
                                            <!-- <li class="nav-item">
                                                <a class="nav-link" data-toggle="tab" href="#messages" role="tab">
                                                    <span class="hidden-sm-up">
                                                        <i class="ion-email"></i>
                                                    </span>
                                                    <span class="hidden-xs-down">Ajouter une année
                                                        scolaire </span>
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" data-toggle="tab" href="#parametres" role="tab">
                                                    <span class="hidden-sm-up">
                                                        <i class="ion-email"></i>
                                                    </span>
                                                    <span class="hidden-xs-down"> Configuration </span>
                                                </a>
                                            </li> -->
                                        </ul>
                                        <!-- Tab panes -->
                                        <div class="tab-content tabcontent-border">
                                            <div class="tab-pane active" id="home" role="tabpanel">

                                                <section class="content">
                                                    <div>


                                                        <div class="box-body wizard-content">
                                                            <section>
                                                                <div class="row">

                                                                    <div class="col-12">
                                                                        <div class="box">

                                                                            <div class="box-header bg-primary">
                                                                                <h4 class="box-title"
                                                                                    style="margin:auto;color:white">
                                                                                    <strong>
                                                                                        {{
                                                                                            Salaires.entreJour
                                                                                        }} F
                                                                                    </strong>
                                                                                </h4>
                                                                            </div>

                                                                            <div class="box-body">
                                                                                <div class="table-responsive">

                                                                                    <table
                                                                                        class="table product-overview">
                                                                                        <thead>
                                                                                            <tr>

                                                                                                <th> Montant</th>
                                                                                                <th> Paiement </th>
                                                                                                <th>Elève</th>
                                                                                                <th>Classe</th>

                                                                                            </tr>
                                                                                        </thead>
                                                                                        <tbody>
                                                                                            <tr v-for="(data, i) in Salaires.totalE"
                                                                                                :key="i">

                                                                                                <td> {{
                                                                                                    data.montantverser
                                                                                                }} F </td>



                                                                                                <td>



                                                                                                    <span
                                                                                                        v-if="data.motif != 'APE'">
                                                                                                        {{
                                                                                                            data.motif.toUpperCase()
                                                                                                        }}
                                                                                                    </span>

                                                                                                    <span
                                                                                                        v-if="data.motif == 'APE'">
                                                                                                        INSCRIPTION</span>

                                                                                                </td>
                                                                                                <td>{{
                                                                                                    data.student.nom
                                                                                                }} {{
    data.student.prenom
}}</td>
                                                                                                <td> {{
                                                                                                    data.classe.libelleClasse
                                                                                                }}</td>
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
                                                        <!-- /.box-body -->
                                                    </div>
                                                </section>


                                            </div>

                                            <div class="tab-pane" id="profile" role="tabpanel">

                                                <section class="content">
                                                    <div>


                                                        <div class="box-body wizard-content">

                                                            <div>


                                                                <div class="box-body wizard-content">
                                                                    <section>
                                                                        <div class="row">

                                                                            <div class="col-12">
                                                                                <div class="box">

                                                                                    <div class="box-header bg-primary">
                                                                                        <h4 class="box-title"
                                                                                            style="margin:auto;color: white;">
                                                                                            <strong>
                                                                                                {{
                                                                                                    Salaires.sortieJ
                                                                                                }} F
                                                                                            </strong>
                                                                                        </h4>
                                                                                    </div>

                                                                                    <div class="box-body">
                                                                                        <div class="table-responsive">

                                                                                            <table
                                                                                                class="table product-overview">
                                                                                                <thead>
                                                                                                    <tr>

                                                                                                        <th> Montant
                                                                                                        </th>
                                                                                                        <th> Motif </th>


                                                                                                    </tr>
                                                                                                </thead>
                                                                                                <tbody>
                                                                                                    <tr v-for="(data, i) in Salaires.totalS"
                                                                                                        :key="i">

                                                                                                        <td> {{
                                                                                                            data.montant
                                                                                                        }} F </td>



                                                                                                        <td>



                                                                                                            <span>{{
                                                                                                                data.motif
                                                                                                            }}</span>

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
                                                                <!-- /.box-body -->
                                                            </div>

                                                        </div>
                                                        <!-- /.box-body -->
                                                    </div>
                                                </section>
                                            </div>


                                        </div>
                                    </div>
                                    <!-- /.box-body -->
                                </div>
                                <!-- /.box -->
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
import MenuCaisse from "../../navs/MenuCaisse.vue";
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
    components: { Header, MenuCaisse, Chats },
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

        async BilanPdf2() {


            if (this.data.jour == "") {
                return this.e("Mentionner un jour  ");
            }

            window.open("api/caisse/getBilanJourRecuPdf2/" + this.data.jour, '_blank')

            const responsePdf = await this.callApi(
                "get",
                "api/caisse/getBilanJourRecuPdf2/" + this.data.jour

            );

        },

        async BilanPdf() {


            if (this.data.jour == "") {
                return this.e("Mentionner un jour  ");
            }

            window.open("api/caisse/getBilanJourRecuPdf/" + this.data.jour, '_blank')

            const responsePdf = await this.callApi(
                "get",
                "api/caisse/getBilanJourRecuPdf/" + this.data.jour

            );


        },

        showDelatingModal(data, i) {
            this.delateItem = data;
            this.i = i;
            this.showDelateModal = true;
        },

        showEdetingModal() {

            this.EdetingModal = true
        },

        async Afficher() {


            if (this.data.jour == "") {
                return this.e("Mentionner un jour  ");
            }


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
