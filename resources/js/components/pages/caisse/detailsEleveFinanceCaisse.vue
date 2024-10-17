<template>
    <div>
        <div class="wrapper">
            <Header />
            <MenuCaisse />


            <Modal v-model="showDelateModal" width="360">
                <p slot="header" style="color:#f60;text-align:center">
                    <span> Suppression </span>
                </p>
                <div style="text-align:center">
                    <p>Etes-vous sure de vouloir supprimer ?</p>
                </div>
                <div slot="footer">
                    <Button type="error" size="large" long @click="delatePaiement">Confirmer</Button>
                </div>
            </Modal>

            <Modal width="860" v-model="modalVersement" title="Faire un versement  ">
                <div class="row">
                    <div class="col-md-6">
                        <label class="form-label"> Date </label>
                        <input v-model="data.date" type="date" name="" id="" class="form-control" />
                    </div>
                    <br />

                    <div class="col-md-6">
                        <label class="form-label"> Déposant </label>
                        <input v-model="data.deposant" type="text" class="form-control" />
                    </div>

                    <br />

                    <!-- <div class="col-md-6">
                        <label class="form-label"> Percepteur </label>
                        <input v-model="data.percepteur" type="text" class="form-control" />
                    </div> -->
                    <br />

                    <div class="col-md-6">
                        <label class="form-label">
                            Montant versé
                        </label>
                        <input v-model="data.montantverse" type="number" class="form-control" />
                    </div>

                    <br />

                    <div class="col-md-6">
                        <label for="" class="form-label">
                            Motif du versement
                        </label>
                        <select v-model="data.motif" class=" form-control required">
                            <option value="APE"> INSCRIPTION </option>
                            <option value="tranche1"> TRANCHE 1 </option>
                            <option value="tranche2"> TRANCHE 2 </option>
                            <!-- <option value="bus"> BUS </option>
                            <option value="cantine"> CANTINE </option> -->


                        </select>
                    </div>
                    <br />
                    <!--
                    <div class="col-md-6">
                        <label for="" class="form-label">
                            Mode de versement
                        </label>
                        <select v-model="data.mode" class=" form-control required">
                            <option value="Mobile">Mobile</option>
                            <option value="Espace"> Espece </option>
                        </select>
                    </div> -->
                </div>

                <div slot="footer">
                    <Button type="primary" long @click="Submit()">Enregistrer</Button>
                </div>
            </Modal>
            <div class="content-wrapper">
                <div class="container-full">
                    <section class="content">
                        <div class="row">
                            <div class="col-12">
                                <div class="box box-default">
                                    <div class="box-header with-border">
                                        <h4 class="box-title">FINANCES-CAISSE</h4>
                                        <span>
                                            <button @click="showmodalVersement" class=" btn btn-danger pull-right"
                                                type="primary">
                                                <Icon type="md-add" /> Versement
                                            </button>
                                        </span>
                                    </div>
                                    <!-- /.box-header -->
                                    <div class="box-body">
                                        <!-- Nav tabs -->
                                        <div class="vtabs customvtab">
                                            <ul class="nav nav-tabs tabs-vertical" role="tablist">
                                                <li class="nav-item">
                                                    <a class="nav-link active" data-toggle="tab" href="#home3"
                                                        role="tab" aria-expanded="true" aria-selected="true"><span
                                                            class="hidden-sm-up"><i class="ion-home"></i></span>
                                                        <span class="hidden-xs-down">
                                                            Récapitulatifs
                                                        </span>
                                                    </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" data-toggle="tab" href="#profile3" role="tab"
                                                        aria-expanded="false" aria-selected="false"><span
                                                            class="hidden-sm-up"><i class="ion-person"></i></span>
                                                        <span class="hidden-xs-down">Versements</span></a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" data-toggle="tab" href="#messages3" role="tab"
                                                        aria-expanded="false" aria-selected="false"><span
                                                            class="hidden-sm-up"><i class="ion-email"></i></span>
                                                        <span class="hidden-xs-down">Détails</span></a>
                                                </li>
                                            </ul>
                                            <!-- Tab panes -->
                                            <div class="tab-content">
                                                <div class="tab-pane active" id="home3" role="tabpanel"
                                                    aria-expanded="true">
                                                    <div class="p-65">
                                                        <div class="row">
                                                            <div class="col-md-4">
                                                                <div class="box">
                                                                    <div class="box-header "
                                                                        style="text-align: center;color:white;background-color:rgb(43, 160, 196)">
                                                                        <p>
                                                                            <strong>
                                                                                INSCRIPTION
                                                                            </strong>
                                                                        </p>
                                                                    </div>
                                                                    <div class="box-body">
                                                                        <div class="table-responsive">
                                                                            <table class="table simple mb-0">
                                                                                <tbody>
                                                                                    <tr>
                                                                                        <td>

                                                                                            Totale
                                                                                            à
                                                                                            payer
                                                                                        </td>
                                                                                        <td
                                                                                            class=" font-weight-700 font-Size-10">
                                                                                            {{
                                                                                                    InfoEleveParent.classe.scolariteaff_Classe
                                                                                            }}
                                                                                        </td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td>

                                                                                            Déja
                                                                                            payé
                                                                                        </td>
                                                                                        <td
                                                                                            class="font-weight-700 font-Size-10">
                                                                                            {{ DaitlsFinancesEleve.ape
                                                                                            }}

                                                                                        </td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td style="color: red;">
                                                                                            Restant
                                                                                        </td>
                                                                                        <td style="color: red;"
                                                                                            class="font-weight-700 font-Size-10">

                                                                                            {{
                                                                                                    InfoEleveParent.classe.scolariteaff_Classe
                                                                                                    - DaitlsFinancesEleve.ape
                                                                                            }}

                                                                                        </td>
                                                                                    </tr>
                                                                                </tbody>
                                                                            </table>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="box">
                                                                    <div class="box-header bg-success"
                                                                        style="text-align: center;">
                                                                        <p>
                                                                            <strong>
                                                                                TRANCHE 1
                                                                            </strong>
                                                                        </p>
                                                                    </div>
                                                                    <div class="box-body">
                                                                        <div class="table-responsive">
                                                                            <table class="table simple mb-0">
                                                                                <tbody>
                                                                                    <tr>
                                                                                        <td>

                                                                                            Totale
                                                                                            à
                                                                                            payer

                                                                                        </td>
                                                                                        <td
                                                                                            class=" font-weight-700 font-Size-10">
                                                                                            {{
                                                                                                    InfoEleveParent.classe.scolarite_Classe
                                                                                            }}

                                                                                        </td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td>
                                                                                            Déja
                                                                                            payé
                                                                                        </td>
                                                                                        <td
                                                                                            class="font-weight-700 font-Size-10">

                                                                                            {{
                                                                                                    DaitlsFinancesEleve.tranche1
                                                                                            }}

                                                                                        </td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td style="color: red;">

                                                                                            Restant
                                                                                        </td>
                                                                                        <td style="color: red;"
                                                                                            class="font-weight-700 font-Size-10">

                                                                                            {{
                                                                                                    InfoEleveParent.classe.scolarite_Classe
                                                                                                    -
                                                                                                    DaitlsFinancesEleve.tranche1
                                                                                            }}

                                                                                        </td>
                                                                                    </tr>
                                                                                </tbody>
                                                                            </table>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-4">
                                                                <div class="box">
                                                                    <div class="box-header bg-primary "
                                                                        style="text-align: center;">
                                                                        <p>
                                                                            <strong>
                                                                                TRANCHE 2
                                                                            </strong>
                                                                        </p>
                                                                    </div>
                                                                    <div class="box-body">
                                                                        <div class="table-responsive">
                                                                            <table class="table simple mb-0">
                                                                                <tbody>
                                                                                    <tr>
                                                                                        <td>
                                                                                            Totale
                                                                                            à
                                                                                            payer
                                                                                        </td>
                                                                                        <td
                                                                                            class=" font-weight-700 font-Size-10">
                                                                                            {{
                                                                                                    InfoEleveParent.classe.inscription_Classe
                                                                                            }}
                                                                                        </td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td>
                                                                                            Déja
                                                                                            payé
                                                                                        </td>
                                                                                        <td
                                                                                            class="font-weight-700 font-Size-10">

                                                                                            {{
                                                                                                    DaitlsFinancesEleve.tranche2
                                                                                            }}

                                                                                        </td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td style="color: red;">
                                                                                            Restant
                                                                                        </td>
                                                                                        <td style="color: red;"
                                                                                            class="font-weight-700 font-Size-10">
                                                                                            {{
                                                                                                    InfoEleveParent.classe.inscription_Classe
                                                                                                    -
                                                                                                    DaitlsFinancesEleve.tranche2
                                                                                            }}

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
                                                <div class="tab-pane" id="profile3" role="tabpanel"
                                                    aria-expanded="false">
                                                    <div>
                                                        <div class="row">
                                                            <div class="col-12">
                                                                <div class="box">
                                                                    <div class="box-header bg-primary">
                                                                        <h4 style="margin: auto;">
                                                                            Historique
                                                                            des
                                                                            versements
                                                                        </h4>
                                                                    </div>
                                                                    <div class="box-body">
                                                                        <div class="table-responsive">
                                                                            <table id="example"
                                                                                class="table simple mb-0">
                                                                                <thead>
                                                                                    <tr>
                                                                                        <th>
                                                                                            Jour
                                                                                        </th>
                                                                                        <th>
                                                                                            Motif

                                                                                        </th>
                                                                                        <th>
                                                                                            Déposant
                                                                                        </th>
                                                                                        <th>
                                                                                            Recepteur
                                                                                        </th>
                                                                                        <!-- <th>
                                                                                            Code

                                                                                        </th>
                                                                                        <th>
                                                                                            Type

                                                                                        </th> -->
                                                                                        <th>
                                                                                            Somme
                                                                                            versée
                                                                                        </th>
                                                                                        <th>

                                                                                        </th>
                                                                                    </tr>
                                                                                </thead>
                                                                                <tbody
                                                                                    v-for="(data, i) in VersementEleve"
                                                                                    :key="i">
                                                                                    <tr>
                                                                                        <td>
                                                                                            {{ data.date | dateFormat }}
                                                                                        </td>
                                                                                         <td v-if="data.motif=='APE'">
                                                                                           Inscription
                                                                                        </td>
                                                                                         <td v-else>
                                                                                            {{ data.motif }}
                                                                                        </td>
                                                                                        <td>
                                                                                            {{ data.deposant }}
                                                                                        </td>
                                                                                        <td>
                                                                                            <!-- {{ data.receptionneur }} -->

                                                                                            La caisse
                                                                                        </td>
                                                                                        <!-- <td>
                                                                                            {{ data.code }}
                                                                                        </td>
                                                                                        <td>
                                                                                            {{ data.mode }}
                                                                                        </td> -->
                                                                                        <td>
                                                                                            {{ data.montantverser }} F

                                                                                        </td>
                                                                                        <td> <Button
                                                                                                @click="RecuPDF(data, i)"
                                                                                                class="btn  btn-warning btn-xs"
                                                                                                title="Imprimer le reçu de ce versement">
                                                                                                <Icon
                                                                                                    type="ios-print" />


                                                                                            </Button>

                                                                                            <Button
                                                                                                @click="showDelatingModal(data, i)"
                                                                                                class="btn  btn-danger btn-xs"
                                                                                                title="Imprimer le reçu de ce versement">
                                                                                                <i class="ti-trash"></i>


                                                                                            </Button>
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
                                                <div class="tab-pane" id="messages3" role="tabpanel"
                                                    aria-expanded="false">
                                                    <div class="p-35">

                                                        <div class="row">
                                                            <div class="col-12">
                                                                <div class="box box-widget widget-user">
                                                                    <div class="box">
                                                                        <div class="box-header bg-primary "
                                                                            style="text-align: center;">
                                                                            <h6 class="box-title" style="color: white;">
                                                                                <strong>
                                                                                    INFORMATIONS UTILES
                                                                                </strong>
                                                                            </h6>
                                                                        </div>
                                                                        <div class="box-body">
                                                                            <div class="table-responsive">
                                                                                <table class="table simple mb-0"
                                                                                    style="width:650px;">
                                                                                    <tbody>

                                                                                        <tr>
                                                                                            <td>
                                                                                                Noms
                                                                                                et
                                                                                                prénoms
                                                                                            </td>
                                                                                            <td
                                                                                                class="bt-1  font-weight-900">
                                                                                                {{
                                                                                                        InfoEleveParent.nom
                                                                                                }}
                                                                                                {{
                                                                                                        InfoEleveParent.prenom
                                                                                                }}
                                                                                            </td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td>
                                                                                                Classe
                                                                                            </td>
                                                                                            <td
                                                                                                class=" font-weight-700">
                                                                                                {{
                                                                                                        InfoEleveParent.classe.libelleClasse
                                                                                                }}
                                                                                            </td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td>
                                                                                                Date de naissance
                                                                                            </td>
                                                                                            <td
                                                                                                class=" font-weight-700">
                                                                                                {{
                                                                                                        InfoEleveParent.dateNaiss
                                                                                                }}
                                                                                            </td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td>
                                                                                                Matricule
                                                                                            </td>
                                                                                            <td
                                                                                                class=" font-weight-700">
                                                                                                {{
                                                                                                        InfoEleveParent.matricule
                                                                                                }}
                                                                                            </td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td>
                                                                                                Noms et prénoms du
                                                                                                parent
                                                                                            </td>
                                                                                            <td
                                                                                                class=" font-weight-700">
                                                                                                {{
                                                                                                        InfoEleveParent.parent.nomParent
                                                                                                }}
                                                                                                {{
                                                                                                        InfoEleveParent.parent.prenomParent
                                                                                                }}
                                                                                            </td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td>
                                                                                                Téléphone du parent
                                                                                            </td>
                                                                                            <td
                                                                                                class=" font-weight-700">
                                                                                                {{
                                                                                                        InfoEleveParent.parent.telParent
                                                                                                }}
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
import MenuCaisse from "../../navs/MenuCaisse.vue";

export default {
    components: { Header, Chats, MenuCaisse },
    data() {
        return {

            IdClasseTeacher: [],
            InfosTeacher: [],
            parentEleveInfos: [],
            InfoEleveParent: [],
            modalVersement: false,
            VersementEleve: [],
            DaitlsFinancesEleve: [],
            showDelateModal: false,
            delateItem: {},
            i: -1,

            data: {
                date: "",
                deposant: "",
                percepteur: "",
                montantverse: "",
                motif: "",
                mode: "",
                EleveInfos: "",
                name: 'test'
            }
        };
    },

    async mounted() {

        if (!localStorage.users) {

            this.$router.push('login');
        }

        // Recuperer les donnes de cet utulisateurs dans la storage local


        if (!localStorage.EtabInfos) {


        }

        if (localStorage.parentEleveInfos) {
            this.parentEleveInfos = JSON.parse(
                localStorage.getItem("parentEleveInfos")
            );


            // Recuperer les donnees de l'enfant et de son parent

            const response2 = await this.callApi(
                "post",
                "api/locale/getEleveAndParentInfos",
                this.parentEleveInfos
            );

            this.InfoEleveParent = response2.data;

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


        }
    },

    methods: {
        showmodalVersement() {

            this.modalVersement = true;

            this.data.deposant ="Parent"

        },

        async RecuPDF(data, i) {


            window.open('api/locale/getEleveRecuPdf/' + data.id, '_blank')

            const responsePdf = await this.callApi(
                "get",
                "api/locale/getEleveRecuPdf/" + data.id

            );


        },

        async delatePaiement() {

            console.log(this.delateItem);
            const response = await axios.post(
                "api/caisse/delateVersement",
                this.delateItem
            );
            if (response.status === 200) {
                console.log(this.delateItem);
                this.VersementEleve.splice(this.i, 1);
                this.showDelateModal = false;
                this.s("Paiement supprimée correctement");
            }
            // this.modal2 = false;
        },

        showDelatingModal(data, i) {
            this.delateItem = data;
            this.i = i;
            this.showDelateModal = true;
        },

        async Submit() {
            if (this.data.date.trim() == "") {
                return this.e("Saisir la date et l'heure  du versement ");
            }

            if (this.data.deposant.trim() == "") {
                return this.e(
                    "Mensionner le nom de la personne ayant fait le versement  "
                );
            }

            // if (this.data.percepteur.trim() == "") {
            //     return this.e(
            //         "Mensionner le nom de la personne ayant percu le versement  "
            //     );
            // }

            if (this.data.montantverse.trim() == "" || this.data.montantverse < 0) {
                return this.e("Le montant du versement est absent ou invalide ");
            }

            if (this.data.motif.trim() == "") {
                return this.e("Mensionner le motif du  versement  ");
            }

            // if (this.data.mode.trim() == "") {
            //     return this.e("Mensionner le mode du  versement  ");
            // }

            this.data.EleveInfos = this.parentEleveInfos;

            const res = await this.callApi(
                "post",
                "api/locale/addVersement",
                this.data
            );

            if (res.status == 400) {

                this.e("Vous essayez de faire  un versement à l'excès");

                // this.modalVersement = false;
            }

            if (res.status == 200) {

                this.s("versement effectué correctement");

                this.modalVersement = false;

                // this.$router.go()
            }




        }
    }
};
</script>
