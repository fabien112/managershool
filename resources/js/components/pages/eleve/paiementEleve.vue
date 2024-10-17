<template>
    <div>
        <div class="wrapper">
            <Header />
            <MenuEleve />
            <div class="content-wrapper">
                <div class="container-full">

                    <section class="content">


                        <div class="row">
                            <div class="col-12">
                                <div class="box box-default">
                                    <div class="box-header with-border">
                                        <h4 class="box-title">PAIEMENTS</h4>
                                        <!-- <span>
                                            <Button
                                                @click="showmodalVersement"
                                                class="pull-right"
                                                type="primary"
                                            >
                                                <Icon type="md-add" /> Versement
                                            </Button>
                                        </span> -->
                                    </div>
                                    <!-- /.box-header -->
                                    <div class="box-body">
                                        <!-- Nav tabs -->
                                        <div class="vtabs customvtab">
                                            <ul
                                                class="nav nav-tabs tabs-vertical"
                                                role="tablist"
                                            >
                                                <li class="nav-item">
                                                    <a
                                                        class="nav-link active"
                                                        data-toggle="tab"
                                                        href="#home3"
                                                        role="tab"
                                                        aria-expanded="true"
                                                        aria-selected="true"
                                                        ><span
                                                            class="hidden-sm-up"
                                                            ><i
                                                                class="ion-home"
                                                            ></i
                                                        ></span>
                                                        <span
                                                            class="hidden-xs-down"
                                                        >
                                                            Récapitulatifs
                                                        </span>
                                                    </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a
                                                        class="nav-link"
                                                        data-toggle="tab"
                                                        href="#profile3"
                                                        role="tab"
                                                        aria-expanded="false"
                                                        aria-selected="false"
                                                        ><span
                                                            class="hidden-sm-up"
                                                            ><i
                                                                class="ion-person"
                                                            ></i
                                                        ></span>
                                                        <span
                                                            class="hidden-xs-down"
                                                            >Versements</span
                                                        ></a
                                                    >
                                                </li>
                                                <!-- <li class="nav-item">
                                                    <a
                                                        class="nav-link"
                                                        data-toggle="tab"
                                                        href="#messages3"
                                                        role="tab"
                                                        aria-expanded="false"
                                                        aria-selected="false"
                                                        ><span
                                                            class="hidden-sm-up"
                                                            ><i
                                                                class="ion-email"
                                                            ></i
                                                        ></span>
                                                        <span
                                                            class="hidden-xs-down"
                                                            >Détails</span
                                                        ></a
                                                    >
                                                </li> -->
                                            </ul>
                                            <!-- Tab panes -->
                                            <div class="tab-content">
                                               <div
                                                    class="tab-pane active"
                                                    id="home3"
                                                    role="tabpanel"
                                                    aria-expanded="true"
                                                >
                                                    <div class="p-65">
                                                        <div class="row">
                                                            <div
                                                                class="col-md-4"
                                                            >
                                                                <div
                                                                    class="box"
                                                                >
                                                                    <div
                                                                        class="box-header bg-success"
                                                                        style="text-align: center;"
                                                                    >
                                                                        <p>
                                                                            <strong>
                                                                                TRANCHE 1
                                                                            </strong>
                                                                        </p>
                                                                    </div>
                                                                    <div
                                                                        class="box-body"
                                                                    >
                                                                        <div
                                                                            class="table-responsive"
                                                                        >
                                                                            <table
                                                                                class="table simple mb-0"
                                                                            >
                                                                                <tbody>
                                                                                    <tr>
                                                                                        <td>

                                                                                            Totale
                                                                                            à
                                                                                            payer

                                                                                        </td>
                                                                                        <td
                                                                                            class=" font-weight-700 font-Size-10"
                                                                                        >
                                                                                        {{InfoEleveParent.classe.scolarite_Classe}} Fcfa

                                                                                        </td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td>
                                                                                             Déja
                                                                                            payé
                                                                                        </td>
                                                                                        <td
                                                                                            class="font-weight-700 font-Size-10"
                                                                                        >

                                                                                        {{DaitlsFinancesEleve.tranche1}} Fcfa

                                                                                        </td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td
                                                                                            style="color: red;"
                                                                                        >

                                                                                            Restant
                                                                                        </td>
                                                                                        <td
                                                                                            style="color: red;"
                                                                                            class="font-weight-700 font-Size-10"
                                                                                        >

                                                                                         {{InfoEleveParent.classe.scolarite_Classe-DaitlsFinancesEleve.tranche1}} Fcfa

                                                                                        </td>
                                                                                    </tr>
                                                                                </tbody>
                                                                            </table>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div
                                                                class="col-md-4"
                                                            >
                                                                <div
                                                                    class="box"
                                                                >
                                                                    <div
                                                                        class="box-header bg-primary "
                                                                        style="text-align: center;"
                                                                    >
                                                                        <p>
                                                                            <strong>
                                                                               TRANCHE 2
                                                                            </strong>
                                                                        </p>
                                                                    </div>
                                                                    <div
                                                                        class="box-body"
                                                                    >
                                                                        <div
                                                                            class="table-responsive"
                                                                        >
                                                                            <table
                                                                                class="table simple mb-0"
                                                                            >
                                                                                <tbody>
                                                                                    <tr>
                                                                                        <td>
                                                                                            Totale
                                                                                            à
                                                                                            payer
                                                                                        </td>
                                                                                        <td
                                                                                            class=" font-weight-700 font-Size-10"
                                                                                        >
                                                                                            {{InfoEleveParent.classe.inscription_Classe}} Fcfa
                                                                                        </td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td>
                                                                                            Déja
                                                                                            payé
                                                                                        </td>
                                                                                        <td
                                                                                            class="font-weight-700 font-Size-10"
                                                                                        >

                                                                                            {{DaitlsFinancesEleve.tranche2}} Fcfa

                                                                                        </td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td
                                                                                            style="color: red;"
                                                                                        >
                                                                                            Restant
                                                                                        </td>
                                                                                        <td
                                                                                            style="color: red;"
                                                                                            class="font-weight-700 font-Size-10"
                                                                                        >
                                                                                         {{InfoEleveParent.classe.inscription_Classe-DaitlsFinancesEleve.tranche2}} Fcfa

                                                                                        </td>
                                                                                    </tr>
                                                                                </tbody>
                                                                            </table>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                             <div
                                                                class="col-md-4"
                                                            >
                                                                <div
                                                                    class="box"
                                                                >
                                                                    <div
                                                                        class="box-header "
                                                                        style="text-align: center;color:white;background-color:rgb(43, 160, 196)"
                                                                    >
                                                                        <p>
                                                                            <strong>
                                                                                APE OU TRANCHE 3
                                                                            </strong>
                                                                        </p>
                                                                    </div>
                                                                    <div
                                                                        class="box-body"
                                                                    >
                                                                        <div
                                                                            class="table-responsive"
                                                                        >
                                                                            <table
                                                                                class="table simple mb-0"
                                                                            >
                                                                                <tbody>
                                                                                    <tr>
                                                                                        <td>

                                                                                            Totale
                                                                                            à
                                                                                            payer
                                                                                        </td>
                                                                                        <td
                                                                                            class=" font-weight-700 font-Size-10"
                                                                                        >
                                                                                            {{InfoEleveParent.classe.scolariteaff_Classe}} Fcfa
                                                                                        </td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td>

                                                                                            Déja
                                                                                            payé
                                                                                        </td>
                                                                                        <td
                                                                                            class="font-weight-700 font-Size-10"
                                                                                        >
                                                                                            {{DaitlsFinancesEleve.ape}} Fcfa

                                                                                        </td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td
                                                                                            style="color: red;"
                                                                                        >
                                                                                           Restant
                                                                                        </td>
                                                                                        <td
                                                                                            style="color: red;"
                                                                                            class="font-weight-700 font-Size-10"
                                                                                        >

                                                                                         {{InfoEleveParent.classe.reinscription_Classe-DaitlsFinancesEleve.ape}} Fcfa

                                                                                        </td>
                                                                                    </tr>
                                                                                </tbody>
                                                                            </table>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div
                                                    class="tab-pane"
                                                    id="profile3"
                                                    role="tabpanel"
                                                    aria-expanded="false"
                                                >
                                                    <div>
                                                        <div class="row">
                                                            <div class="col-12">
                                                                <div
                                                                    class="box"
                                                                >
                                                                    <div
                                                                        class="box-header bg-primary"
                                                                    >
                                                                        <h4
                                                                            style="margin: auto;"
                                                                        >
                                                                            Historique
                                                                            des
                                                                            versements
                                                                        </h4>
                                                                    </div>
                                                                    <div
                                                                        class="box-body"
                                                                    >
                                                                        <div
                                                                            class="table-responsive"
                                                                        >
                                                                            <table
                                                                                id="example"
                                                                                class="table simple mb-0"

                                                                            >
                                                                                <thead>
                                                                                    <tr>
                                                                                        <th>
                                                                                            Jour
                                                                                        </th>
                                                                                        <th>
                                                                                            Motif

                                                                                        </th>
                                                                                        <th>
                                                                                            Dépo
                                                                                        </th>
                                                                                        <th>
                                                                                            Recep
                                                                                        </th>
                                                                                        <th>
                                                                                            Code

                                                                                        </th>
                                                                                        <th>
                                                                                            Type

                                                                                        </th>
                                                                                        <th>
                                                                                            Somme
                                                                                            versée
                                                                                        </th>
                                                                                        <th>

                                                                                        </th>
                                                                                    </tr>
                                                                                </thead>
                                                                                 <tbody  v-for="(data,  i) in VersementEleve" :key="i">
                                                                                    <tr>
                                                                                        <td>
                                                                                           {{data.date|dateFormatHeure}}                                                                                        </td>
                                                                                        <td>
                                                                                            {{data.motif}}
                                                                                        </td>
                                                                                        <td>
                                                                                           {{data.deposant}}
                                                                                        </td>
                                                                                         <td>
                                                                                           {{data.receptionneur}}
                                                                                        </td>
                                                                                        <td>
                                                                                           {{data.code}}
                                                                                        </td>
                                                                                        <td>
                                                                                           {{data.mode}}
                                                                                        </td>
                                                                                        <td>
                                                                                           {{data.montantverser}}

                                                                                        </td>
                                                                                        <!-- <td> <button @click="ParentEleve(data,i)" class="btn btn-circle btn-warning btn-xs" title="Imprimer le recu de ce versement ">
                                                                                            <Icon type="ios-print" /></button>
                                                                                        </td> -->
                                                                                    </tr>
                                                                                </tbody>
                                                                            </table>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

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
import Chats from "../../navs/Chats.vue";
import { mapState } from "vuex";
import MenuEleve from "../../navs/MenuEleve.vue";

export default {
    components: { Header, Chats, MenuEleve },
    data() {
        return {

            IdClasseTeacher: [],
            InfosTeacher: [],
            parentEleveInfos: [],
            InfoEleveParent: [],
            modalVersement: false,
            VersementEleve:[],
            DaitlsFinancesEleve:[],
            data:{
                date: "",
                deposant: "",
                percepteur: "",
                montantverse: "",
                motif: "",
                mode: "",
                EleveInfos: ""
            }
        };
    },

    async mounted() {
        // Recuperer les donnes de cet utulisateurs dans la storage local

        if (localStorage.InfosParent) {
            this.parentEleveInfos = JSON.parse(
                localStorage.getItem("InfosParent")
            );

             // Recuperer les donnees de la finance pour cet enfant

            const response3 = await this.callApi(
                "post",
                "api/locale/getAstudentFinancesInfos",
                this.parentEleveInfos
            );

            this.VersementEleve = response3.data;

             // Recuperer les donnees des tranches 1 et 2 et APE   pour cet enfant

            const response4 = await this.callApi(
                "post",
                "api/locale/getAstudentDatailsFinancesInfos",
                this.parentEleveInfos
            );

            this.DaitlsFinancesEleve = response4.data;


             // Recuperer les donnees de l'enfant et de son parent

            const response2 = await this.callApi(
                "post",
                "api/locale/getEleveAndParentInfos",
                this.parentEleveInfos
            );

            this.InfoEleveParent = response2.data;


        }
    },

    methods: {




    }
};
</script>
