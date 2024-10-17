<template>
    <div>
        <div class="wrapper">
            <Header />
            <MenuLocal />
            <div class="content-wrapper">
                <div class="container-full">
                    <!-- Main content -->
                    <section class="content">
                        <Modal v-model="EdetingModal" title="Modifier">
                            <div class="row"></div>
                            <br />
                            <div class="row">
                                <div class="col-md-12">
                                    <label class="form-label"> </label>
                                    <input type="text" class="form-control" v-model="datasEdit.libelle" />
                                </div>
                                <br />
                            </div>

                            <br />

                            <div slot="footer">
                                <Button type="primary" size="large" long @click="Update()">Enregistrer</Button>
                            </div>
                        </Modal>

                        <Modal v-model="showDelateModal" width="360">
                            <p slot="header" style="color:#f60;text-align:center">
                                <span> Suppression </span>
                            </p>
                            <div style="text-align:center">
                                <p>Etes-vous sure de vouloir supprimer ?</p>
                            </div>
                            <div slot="footer">
                                <Button type="error" size="large" long @click="delateMatiere">Confirmer</Button>
                            </div>
                        </Modal>

                        <Modal v-model="showDelateModal2" width="360">
                            <p slot="header" style="color:#f60;text-align:center">
                                <span> Suppression </span>
                            </p>
                            <div style="text-align:center">
                                <p>
                                    Etes-vous sure de vouloir supprimer ce
                                    libellé ?
                                </p>
                            </div>
                            <div slot="footer">
                                <Button type="error" size="large" long @click="delateLibelle">Confirmer</Button>
                            </div>
                        </Modal>
                        <!-- tabs -->

                        <div class="row">
                            <div class="col-12">
                                <div class="box box-default">
                                    <div class="box-header with-border" style="margin:auto;">
                                        <h2 class="box-title" style="text-align:center">
                                            {{ ClasseInfos.libelleClasse }} : {{ Matieres.length }} matiere(s)
                                        </h2>
                                    </div>
                                    <!-- /.box-header -->
                                    <div class="box-body">
                                        <!-- Modal pour affecter un enseigant  -->

                                        <Modal v-model="modal8" title="Modifier  une matiere ">


                                            <div class="col-md-12 col-sm-12">
                                                <label>
                                                    Sélectionner la catégorie ce
                                                    cette matière pour cette
                                                    classe
                                                </label>

                                                <select class="custom-select form-control required"
                                                    v-model="data2.categorie">
                                                    <option v-for="(data, i) in cat" :key="i" :value="data.id">
                                                        {{ data.nom }}</option>
                                                </select>
                                            </div>

                                            <div class="col-md-12 col-sm-12">
                                                <label for=" ">
                                                    Coefficient de cette matière
                                                </label>
                                                <input type="number" class=" form-control required" v-model="data2.coef" />
                                            </div>


                                            <div class="col-md-12 col-sm-12">
                                                <label for=" ">
                                                    Nom de cette matière
                                                </label>
                                                <input type="text" class=" form-control required" v-model="data2.libelle" />
                                            </div>

                                            <div slot="footer">
                                                <Button @click="updateMatiere" type="primary" size="large">
                                                    Valider
                                                </Button>
                                            </div>
                                        </Modal>

                                        <Modal v-model="modal7" title="Modifier  une affectaton">
                                            <label for="">
                                                Modifier l'affectation
                                            </label>

                                            <select class="custom-select form-control required" v-model="data.prof">
                                                <option v-for="(data,
                                                    i) in Enseignants" :key="i" :value="data.id">
                                                    {{ data.nom }}
                                                    {{ data.prenom }}
                                                </option>
                                            </select>

                                            <div slot="footer">
                                                <Button @click="Affecttation2" type="primary" size="large">
                                                    Valider
                                                </Button>
                                            </div>
                                        </Modal>

                                        <Modal v-model="modal6" title="Affecter la matiere a un enseignant ">
                                            <label for="">
                                                Sélectionner un enseignant et
                                                valider
                                            </label>

                                            <select class="custom-select form-control required" v-model="data.prof">
                                                <option v-for="(data,
                                                    i) in Enseignants" :key="i" :value="data.id">
                                                    {{ data.nom }}
                                                    {{ data.prenom }}
                                                </option>
                                            </select>

                                            <div slot="footer">
                                                <Button @click="Affecttation" type="primary" size="large">
                                                    Valider
                                                </Button>
                                            </div>
                                        </Modal>

                                        <!-- <Modal v-model="showDelateModal" width="360">
                                            <p slot="header" style="color:#f60;text-align:center">
                                                <Icon type="ios-information-circle"></Icon>
                                                <span> ATTENTION ! </span>
                                            </p>
                                            <div style="text-align:center">
                                                <p>
                                                    Etes-vous sure de vouloir
                                                    clôturer ce trimestre et
                                                    activer le prochain
                                                    ?
                                                </p>
                                            </div>
                                            <div slot="footer">
                                                <Button type="error" size="large" long>
                                                    Clôturer
                                                </Button>
                                            </div>
                                        </Modal> -->

                                        <!-- Nav tabs -->
                                        <ul class="nav nav-tabs" role="tablist">
                                            <li class="nav-item">
                                                <a class="nav-link active" data-toggle="tab" href="#home" role="tab">
                                                    <span class="hidden-sm-up">
                                                        <i class="ion-home"></i>
                                                    </span>
                                                    <span class="hidden-xs-down">Liste des matières
                                                    </span>
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" data-toggle="tab" href="#profile" role="tab">
                                                    <span class="hidden-sm-up">
                                                        <i class="ion-person"></i>
                                                    </span>
                                                    <span class="hidden-xs-down">Ajouter une matière
                                                    </span>
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" data-toggle="tab" href="#messages" role="tab">
                                                    <span class="hidden-sm-up">
                                                        <i class="ion-email"></i>
                                                    </span>
                                                    <span class="hidden-xs-down">
                                                        Ajouter libellé</span>
                                                </a>
                                            </li>
                                            <!-- <li class="nav-item">
                                                <a class="nav-link" data-toggle="tab" href="#see" role="tab">
                                                    <span class="hidden-sm-up">
                                                        <i class="ion-email"></i>
                                                    </span>
                                                    <span class="hidden-xs-down">
                                                        Listing des affectations </span>
                                                </a>
                                            </li> -->
                                        </ul>
                                        <!-- Tab panes -->
                                        <div class="tab-content tabcontent-border">
                                            <div class="tab-pane active" id="home" role="tabpanel">
                                                <section class="content">
                                                    <div class="box box-default">
                                                        <div class="box-header with-border"></div>

                                                        <div class="box-body wizard-content">
                                                            <section>
                                                                <div class="row">
                                                                    <div class="table-responsive">
                                                                        <table
                                                                            class="table table-striped table-bordered display">
                                                                            <thead>
                                                                                <tr>
                                                                                    <th>
                                                                                        Matières
                                                                                    </th>
                                                                                    <!-- <th>
                                                                                        Groupe
                                                                                    </th> -->
                                                                                    <th>
                                                                                        Coef
                                                                                    </th>

                                                                                    <th>
                                                                                        Affectation
                                                                                    </th>

                                                                                    <th>
                                                                                        Actions
                                                                                    </th>
                                                                                </tr>
                                                                            </thead>

                                                                            <tbody>
                                                                                <tr v-for="(data,
                                                                                    i) in Matieres" :key="i
        ">
                                                                                    <td>

                                                                                        <span v-if="data.cathegory_id == 1"
                                                                                            class="btn btn-xs"
                                                                                            style="background-color:#1e65e9;color:white; width:100%;">
                                                                                            {{
                                                                                                data.libelle
                                                                                            }}
                                                                                        </span>

                                                                                        <span v-if="data.cathegory_id == 2"
                                                                                            class="btn btn-xs"
                                                                                            style="background-color:rgba(102, 14, 218, 0.827);color:white; width:100%;">
                                                                                            {{
                                                                                                data.libelle
                                                                                            }}
                                                                                        </span>


                                                                                        <span v-if="data.cathegory_id == 3"
                                                                                            class="btn btn-xs"
                                                                                            style="background-color:#2C353D;color:white; width:100%;">
                                                                                            {{
                                                                                                data.libelle
                                                                                            }}
                                                                                        </span>

                                                                                        <span v-if="data.cathegory_id == 4"
                                                                                            class="btn btn-xs"
                                                                                            style="background-color:#e63393;color:white; width:100%;">
                                                                                            {{
                                                                                                data.libelle
                                                                                            }}
                                                                                        </span>



                                                                                    </td>

                                                                                    <!-- <td>
                                                                                        <span v-if="data.cathegory_id == 1"
                                                                                            class="btn btn-xs"
                                                                                            style="background-color:#E91E63;color:white; width:100%;">
                                                                                            {{
                                                                                                data.cathegory_id
                                                                                            }}
                                                                                        </span>

                                                                                        <span v-if="data.cathegory_id == 2"
                                                                                            class="btn btn-xs"
                                                                                            style="background-color:#2C353D;color:white; width:100%;">
                                                                                            {{
                                                                                                data.cathegory_id
                                                                                            }}
                                                                                        </span>

                                                                                        <span v-if="data.cathegory_id == 3"
                                                                                            class="btn btn-xs"
                                                                                            style="background-color:#2D8CF0;color:white; width:100%;">
                                                                                            {{
                                                                                                data.cathegory_id
                                                                                            }}
                                                                                        </span>
                                                                                    </td> -->

                                                                                    <td>
                                                                                        <span class="btn btn-xs"
                                                                                            style="background-color:#04A08B;color:white; width:50%;">
                                                                                            {{
                                                                                                data.coef
                                                                                            }}
                                                                                        </span>
                                                                                    </td>

                                                                                    <td>
                                                                                        <span v-if="data.affected ==
                                                                                                1
                                                                                                " class="btn btn-xs"
                                                                                            style="background-color:#2D8CF0;color:white;width: 75%">
                                                                                            {{
                                                                                                data
                                                                                                    .enseignant
                                                                                                    .nom
                                                                                            }}
                                                                                            {{
                                                                                                data
                                                                                                    .enseignant
                                                                                                    .prenom
                                                                                            }}
                                                                                        </span>

                                                                                        <span v-if="data.affected ==
                                                                                                1
                                                                                                " @click="
            Affecter2(
                data,
                i
            )
            " class="btn btn-xs" style="background-color:#1f2429;color:white;width: 15%">
                                                                                            <Icon type="md-build" />
                                                                                        </span>

                                                                                        <span v-if="data.affected ==
                                                                                            0
                                                                                            " class="btn btn-xs"
                                                                                            style="background-color:red;color:white;width: 70%"
                                                                                            title="Modifier une affectation ">
                                                                                            Disponible
                                                                                        </span>

                                                                                        <span v-if="data.affected ==
                                                                                            0
                                                                                            " @click="
        Affecter(
            data,
            i
        )
        " class="btn btn-xs" style="background-color:#1f2429;color:white;width:25%">
                                                                                            <i title="Affecter  un enseignant "
                                                                                                class="ti-control-shuffle "></i>
                                                                                        </span>
                                                                                    </td>

                                                                                    <td>
                                                                                        <button @click="
                                                                                            showDelatingModal(
                                                                                                data,
                                                                                                i
                                                                                            )
                                                                                            "
                                                                                            class="btn btn-danger btn-xs"
                                                                                            title="Supprimer">
                                                                                            <i class="ti-trash"></i>
                                                                                        </button>

                                                                                        <button @click="
                                                                                            Details(
                                                                                                data,
                                                                                                i
                                                                                            )
                                                                                            "
                                                                                            class="btn btn-primary btn-xs"
                                                                                            title="Voir">
                                                                                            <i class="ti-pencil"></i>
                                                                                        </button>
                                                                                    </td>
                                                                                </tr>
                                                                            </tbody>
                                                                        </table>
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
                                                    <div class="box box-default">
                                                        <div class="box-header with-border"></div>

                                                        <div class="box-body wizard-content">
                                                            <section>
                                                                <div class="row">
                                                                    <div class="col-md-6 col-sm-12">
                                                                        <div class="row"
                                                                            style="display: flex; flex-wrap: wrap; margin-right: -15px; margin-left: -15px;">
                                                                            <div class="col-md-12 col-sm-12">
                                                                                <label>
                                                                                    Sélectioner
                                                                                    le
                                                                                    libellé
                                                                                    cette
                                                                                    matière
                                                                                </label>

                                                                                <select
                                                                                    class="custom-select form-control required"
                                                                                    v-model="data.matiere
                                                                                        ">
                                                                                    <option v-for="(data,
                                                                                        i) in Libelles" :key="i
        ">
                                                                                        {{
                                                                                            data.libelle
                                                                                        }}</option>
                                                                                </select>
                                                                            </div>

                                                                            <div class="col-md-12 col-sm-12">
                                                                                <label>
                                                                                    Sélectionner
                                                                                    la
                                                                                    catégorie
                                                                                    ce
                                                                                    cette
                                                                                    matière
                                                                                    pour
                                                                                    cette
                                                                                    classe
                                                                                </label>

                                                                                <select
                                                                                    class="custom-select form-control required"
                                                                                    v-model="data.categorie
                                                                                        ">
                                                                                    <option v-for="(data,
                                                                                        i) in cat" :key="i
        " :value="data.id
        ">
                                                                                        {{
                                                                                            data.nom
                                                                                        }}</option>
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <br />

                                                                <div class="row">
                                                                    <div class="col-md-6 col-sm-12">
                                                                        <div class="row"
                                                                            style="display: flex; flex-wrap: wrap; margin-right: -15px; margin-left: -15px;">
                                                                            <div class="col-md-12 col-sm-12">
                                                                                <label for=" ">
                                                                                    Mentionner
                                                                                    le
                                                                                    coefficient
                                                                                    de
                                                                                    cette
                                                                                    matière
                                                                                </label>
                                                                                <input type="number"
                                                                                    class=" form-control required" v-model="data.coef
                                                                                        " />
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <br />

                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        <input type="submit" class="btn btn-facebook"
                                                                            value="Enregistrer" @click="SaveMatiere
                                                                                " />
                                                                    </div>
                                                                </div>
                                                            </section>
                                                        </div>
                                                        <!-- /.box-body -->
                                                    </div>
                                                </section>
                                            </div>

                                            <div class="tab-pane" id="messages" role="tabpanel">
                                                <section class="content">
                                                    <div class="box box-default">
                                                        <div class="box-header with-border"></div>

                                                        <div class="box-body wizard-content">
                                                            <!-- Step 1 -->

                                                            <section>
                                                                <div class="row">

                                                                    <div class="col-md-6 col-sm-12">
                                                                        <!-- <div class="form-group">
                                                                            <label for="">
                                                                                Libellé
                                                                            </label>

                                                                            <input type="text" class="form-control required"
                                                                                v-model="data.libelle
                                                                                    " />
                                                                        </div> -->
                                                                    </div>
                                                                    <div class="col-md-4 col-sm-12">
                                                                        <div class="form-group">
                                                                            <label for="">
                                                                                Libellé
                                                                            </label>

                                                                            <input type="text" class="form-control required"
                                                                                v-model="data.libelle
                                                                                    " />
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-2">
                                                                        <br />
                                                                        <input type="submit" class="btn btn-facebook"
                                                                            value="Enregistrer" @click="send
                                                                                " />
                                                                    </div>
                                                                </div>

                                                                <div class="row">
                                                                    <div class="box-body">
                                                                        <div class="table-responsive">
                                                                            <table id="example" class="table simple mb-0"
                                                                                style="width:100%">
                                                                                <thead>
                                                                                    <tr>
                                                                                        <th>
                                                                                            Libellés
                                                                                        </th>
                                                                                        <th>
                                                                                            Actions
                                                                                        </th>
                                                                                    </tr>
                                                                                </thead>
                                                                                <tbody>
                                                                                    <tr v-for="(data,
                                                                                        i) in Libelles" :key="i
        ">
                                                                                        <td>
                                                                                            {{
                                                                                                data.libelle
                                                                                            }}
                                                                                        </td>

                                                                                        <td style="text-align:center"
                                                                                            class="center">
                                                                                            <button @click="
                                                                                            showDelatingModal2(
                                                                                                data,
                                                                                                i
                                                                                            )
                                                                                                "
                                                                                                class="btn btn-danger">
                                                                                                <i class="ti-trash"></i>

                                                                                            </button>

                                                                                            <button @click="
                                                                                                showEdetingModal(
                                                                                                    data,
                                                                                                    i
                                                                                                )
                                                                                                "
                                                                                                class="btn btn-primary">
                                                                                                <i class="ti-pencil"></i>

                                                                                            </button>
                                                                                        </td>
                                                                                    </tr>
                                                                                </tbody>
                                                                            </table>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </section>


                                                        </div>
                                                        <!-- /.box-body -->
                                                    </div>

                                                    <b-pagination :total-rows="rows" @change="handlePageChange" size="lg"
                                                        v-model="currentPage" align="center" :per-page="10"
                                                        :current-page="currentPage">
                                                    </b-pagination>
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
                libelle: "",
                matiere: "",
                categorie: "",
                prof: "",
                coef: ""
            },

            rows: 0,
            currentPage: 0,

            datasEdit: {
                libelle: "",
                Idclasse: "",
                libelleAncien: ""
            },
            data2: {
                libelle: "",
                matiere: "",
                categorie: "",
                prof: "",
                id: "",
                coef: ""
            },
            Libelles: [],
            cat: [],
            Classes: [],
            modal6: false,
            modal7: false,
            modal8: false,

            showDelateModal2: false,
            classeItem: "",
            users: [],
            sessions: [],
            ClasseInfos: [],
            success: "badge badge-success",
            EtabInfos: [],
            Matieres: [],
            Enseignants: [],
            ItemMatiere: "",
            Item2: "",
            EnseignantsMatieres: [],
            showDelateModal: false,
            EdetingModal: false,
            i: -1,
            datas: [],
            classeItem: ""
        };
    },

    methods: {

        async handlePageChange(value) {

            this.data.currentPage = value - 1

            console.log(value)

            const response2 = await this.callApi(
                "post",
                "/api/locale/getLibelles",
                this.data
            );
            this.Libelles = response2.data.content;

            this.rows = response2.data.totalPages;
        },
        async Update() {
            //console.log(this.delateItem.duree);

            if (this.datasEdit.libelle == "") {
                this.e("Saisir un libellé  valide");
            } else {
                const response = await axios.post(
                    "api/locale/updatelibelle",
                    this.datasEdit
                );

                if (response.status === 200) {
                    this.EdetingModal = false;

                    const response2 = await this.callApi(
                        "post",
                        "/api/locale/getLibelles",
                        this.data
                    );
                    this.Libelles = response2.data.content;

                    this.rows = response2.data.totalPages;

                    this.s("Libellé  modifiée correctement");
                }
            }
        },

        showDelatingModal(data, i) {
            this.delateItem = data;
            this.i = i;
            this.showDelateModal = true;
        },

        showDelatingModal2(data, i) {
            this.delateItem = data;
            this.i = i;
            this.showDelateModal2 = true;
        },

        showEdetingModal(data, i) {
            console.log(data);

            this.EdetingModal = true;
            this.i = i;
            this.delateItem = data;
            this.datasEdit.id = data.id;
            this.datasEdit.libelle = data.libelle;
            this.datasEdit.Idclasse = this.ClasseInfos.id;
            this.datasEdit.libelleAncien = data.libelle;
        },

        async delateMatiere() {
            console.log(this.delateItem);
            const response = await axios.post(
                "api/locale/delateMatiere",
                this.delateItem
            );
            if (response.status === 200) {
                this.Matieres.splice(this.i, 1);
                this.showDelateModal = false;
                this.s(" Matière supprimé correctement");
                // this.$router.go();
            }
            // this.modal2 = false;
        },

        async delateLibelle() {
            console.log(this.delateItem);
            const response = await axios.post(
                "api/locale/delateLibelle",
                this.delateItem
            );
            if (response.status === 200) {
                this.Libelles.splice(this.i, 1);
                this.showDelateModal2 = false;
                this.s(" LIbellé  supprimé correctement");
                // this.$router.go();
            }
            // this.modal2 = false;
        },
        async send() {
            if (this.data.libelle.trim() == "") {
                return this.e("Saisir un libellé  ");
            } else {
                // Cas  valide

                // Je rajoute les  information de lecole appartenant a lutulisateur qui sest logger a ma data qui ira dans lapi de creation du libelle

                this.data.ClasseInfos = this.ClasseInfos;

                const response = await this.callApi(
                    "post",
                    "/api/locale/addLibelle",
                    this.data
                );

                if (response.status == 400) {
                    this.w("Ce libellé existe déja");
                    // this.$router.go();
                } else if (response.status == 200) {
                    this.data.libelle = "";
                    this.s("Libellé ajouté correctement");

                    const response2 = await this.callApi(
                        "post",
                        "/api/locale/getLibelles",
                        this.data
                    );
                    this.Libelles = response2.data;
                } else {
                    this.e("Une erreure est survenue");
                }
            }
        },

        async SaveMatiere() {
            if (this.data.matiere.trim() == "") {
                return this.e("Sélectionner le nom de la matière  ");
            }

            if (this.data.coef.trim() == "") {
                return this.e("Saisir le coefficient cette  matière");
            } else {
                // Cas  valide ou tous les champs sont remplis

                // Je rajoute les  information de la classe de l'ecole  appartenant a l'utulisateur qui s'est logger a ma data qui ira dans l'api de creation de la matiere

                this.data.ClasseInfos = this.ClasseInfos;

                const response = await this.callApi(
                    "post",
                    "/api/locale/addMatiere",
                    this.data
                );
                if (response.status == 400) {
                    this.w("Cette matière existe déja dans cette classe");
                    // this.$router.go();
                } else if (response.status == 200) {
                    this.s("Matière ajoutée correctement");
                } else {
                    this.e("Une erreure est survenue");
                }
            }
        },

        Affecter2(data, i) {
            this.modal7 = true;


            for (let item of this.Enseignants) {

                if (item.id == data.affected) {

                    this.data.prof = data.affected

                }
            }

            this.ItemMatiere = data;
        },

        Details(data, i) {
            this.modal8 = true;

            this.ItemMatiere = data;

            this.data2.id = data.id;

            this.data2.libelle = data.libelle

            console.log(data)

            for (let item of this.cat) {

                if (item.id == data.cathegory_id) {

                    this.data2.categorie = item.id

                }
            }
            this.data2.coef = data.coef;
        },

        async updateMatiere() {
            if (this.data2.categorie == "") {
                this.e("Choisir une categorie");
            }

            if (this.data2.coef == "") {
                this.e("Le coefficient de la matière est requis ");
            }

            console.log(this.delateItem);
            const response = await axios.post(
                "api/locale/updateMatiere",
                this.data2
            );
            if (response.status === 200) {
                // this.Matieres.splice(this.i, 1);
                this.modal8 = false;
                this.s(" Matière modifiée  correctement");

                const response3 = await this.callApi(
                    "post",
                    "/api/locale/getMatieresClasse",
                    this.data
                );

                this.Matieres = response3.data;

                // this.$router.go();
            }
            // this.modal2 = false;
        },
        Affecter(data, i) {
            this.modal6 = true;

            this.ItemMatiere = data;
        },

        async Affecttation2() {
            // Affecter une matiere a un professeur , ItemMatiere  contient les infos de la matiere

            if (this.data.prof == "") {
                return this.e("Sélectionner un enseignant  ");
            } else {
                // Ajouter lid du prof  choisi aux donnes de la  matiere

                this.ItemMatiere.Enseignants = this.data.prof;

                const response = await this.callApi(
                    "post",
                    "/api/locale/affecterTeacher2",
                    this.ItemMatiere
                );
                if (response.status == 200) {
                    this.s("Affectation modifiée correctement");
                    this.modal7 = false;
                    this.prof = "";

                    const response3 = await this.callApi(
                        "post",
                        "/api/locale/getMatieresClasse",
                        this.data
                    );

                    this.Matieres = response3.data;

                    // this.$router.go();
                } else {
                    this.e("Une erreure est survenue");
                }
            }
        },

        async Affecttation() {
            // Affecter une matiere a un professeur , ItemMatiere  contient les infos de la matiere

            if (this.data.prof == "") {
                return this.e("Sélectionner un enseignant  ");
            } else {
                // Ajouter lid du prof  choisi aux donnes de la  matiere

                this.ItemMatiere.Enseignants = this.data.prof;

                const response = await this.callApi(
                    "post",
                    "/api/locale/affecterTeacher",
                    this.ItemMatiere
                );
                if (response.status == 200) {
                    this.s("Matière affectée correctement");
                    this.modal6 = false;
                    this.prof = "";
                    const response3 = await this.callApi(
                        "post",
                        "/api/locale/getMatieresClasse",
                        this.data
                    );

                    this.Matieres = response3.data;

                    // this.$router.go();
                } else {
                    this.e("Une erreure est survenue");
                }
            }
        }
    },

    async created() {
        this.$Spin.show();

        if (!localStorage.users) {
            this.$router.push("login");
        }

        // Recuperer toutes les infos de cette ecole dans le storage

        if (localStorage.EtabInfos) {
            this.EtabInfos = JSON.parse(localStorage.getItem("EtabInfos"));
        }

        // Recuperer toutes les infos de cette ecole  dans le storage

        if (localStorage.classeItem) {
            this.ClasseInfos = JSON.parse(localStorage.getItem("classeItem"));
        }

        // Je rajoute les  information de la classe de lecole  appartenant a lutulisateur qui sest logger a ma data qui ira dans lapi de creation de la matiere

        this.data.ClasseInfos = this.ClasseInfos;

        this.data.currentPage = this.currentPage

        // Recuperer les libelles de toutes les matieres au chargement de la page

        const response2 = await this.callApi(
            "post",
            "/api/locale/getLibelles",
            this.data
        );
        this.Libelles = response2.data.content;

        this.rows = response2.data.totalPages;



        const response4 = await this.callApi(
            "post",
            "/api/locale/getcat",
            this.data
        );
        this.cat = response4.data;

        // Recuperer les matiere de la  classe de cette ecole  au chargement de la page

        const response3 = await this.callApi(
            "post",
            "/api/locale/getMatieresClasse",
            this.data
        );

        this.Matieres = response3.data;

        // Recuperer tous les enseigants de cette ecole pour affectation

        const res = await this.callApi(
            "post",
            "api/locale/getAllEnseignantAffect",
            this.ClasseInfos
        );

        this.Enseignants = res.data;

        // Recuperer tous les enseignants de cette ecole avec leur classe

        // const res4 = await this.callApi(
        //     "post",
        //     "api/locale/getAllEnseignantAffectMatieres",
        //     this.ClasseInfos
        // );

        // this.EnseignantsMatieres = res4.data;

        if (response2.status === 200) {
            this.$Spin.hide();
        }
    }
};
</script>

<style>
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
