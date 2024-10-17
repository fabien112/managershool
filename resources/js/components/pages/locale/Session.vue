<template>
    <div>
        <div class="wrapper">
            <Header />
            <MenuLocal />
            <div class="content-wrapper" style="background-color:'#CCC'">
                <div class="container-full">
                    <!-- Main content -->
                    <section class="content">
                        <!-- tabs -->

                        <div class="row">
                            <div class="col-12">
                                <div class="box box-default">
                                    <div class="box-header with-border">
                                        <h4 class="box-title">Année scolaire </h4>
                                    </div>
                                    <!-- /.box-header -->
                                    <div class="box-body">

                                        <Modal v-model="showDelateModal" width="360">
                                            <p slot="header" style="color:#f60;text-align:center">
                                                <Icon type="ios-information-circle"></Icon>
                                                <span> ATTENTION ! </span>
                                            </p>
                                            <div style="text-align:center">
                                                <p> Etes-vous sure de vouloir le faire ? </p>


                                            </div>
                                            <div slot="footer">
                                                <Button type="error" size="large" long @click="cloturerSchool"> clôturer
                                                </Button>
                                            </div>
                                        </Modal>

                                        <!-- Nav tabs -->
                                        <ul class="nav nav-tabs" role="tablist">
                                            <li class="nav-item">
                                                <a class="nav-link active" data-toggle="tab" href="#home" role="tab">
                                                    <span class="hidden-sm-up">
                                                        <i class="ion-home"></i>
                                                    </span>
                                                    <span class="hidden-xs-down"> Tous les trimestres
                                                    </span>
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" data-toggle="tab" href="#profile" role="tab">
                                                    <span class="hidden-sm-up">
                                                        <i class="ion-person"></i>
                                                    </span>
                                                    <span class="hidden-xs-down"> Session
                                                    </span>
                                                </a>
                                            </li>
                                            <li class="nav-item">
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
                                            </li>

                                            <li class="nav-item">
                                                <a class="nav-link" data-toggle="tab" href="#horaires" role="tab">
                                                    <span class="hidden-sm-up">
                                                        <i class="ion-email"></i>
                                                    </span>
                                                    <span class="hidden-xs-down"> Horaires </span>
                                                </a>
                                            </li>
                                        </ul>
                                        <!-- Tab panes -->
                                        <div class="tab-content tabcontent-border">
                                            <div class="tab-pane active" id="home" role="tabpanel">

                                                <section class="content">
                                                    <div class="box box-default">
                                                        <div class="box-header with-border">

                                                        </div>

                                                        <div class="box-body wizard-content">
                                                            <section>
                                                                <div class="row">
                                                                    <div class="table-responsive">
                                                                        <table
                                                                            class="table table-striped table-bordered display">
                                                                            <thead>
                                                                                <tr>
                                                                                    <th>
                                                                                        Périodes
                                                                                    </th>
                                                                                    <th>
                                                                                        Statut
                                                                                    </th>
                                                                                    <th>
                                                                                        Clôturer
                                                                                    </th>
                                                                                </tr>
                                                                            </thead>

                                                                            <tbody>
                                                                                <tr v-for="(dat,
                                                                                    i) in trimestres" :key="i">


                                                                                    <td>
                                                                                        <div class="px-25 py-10 w-100">
                                                                                            <span
                                                                                                class="badge badge-primary">{{
                                                                                                    dat.libelle_semes
                                                                                                }}</span>
                                                                                        </div>
                                                                                    </td>

                                                                                    <td>

                                                                                        <div v-if="dat.statut_semes == 1"
                                                                                            class="px-25 py-10 w-100">
                                                                                            <span
                                                                                                class="badge badge-success">
                                                                                                ACTIF
                                                                                            </span>
                                                                                        </div>
                                                                                        <div v-if="dat.statut_semes == 0"
                                                                                            class="px-25 py-10 w-100">
                                                                                            <span
                                                                                                class="badge badge-danger">
                                                                                                INACTIF
                                                                                            </span>
                                                                                        </div>


                                                                                    </td>


                                                                                    <td>

                                                                                        <div v-if="dat.statut_semes == 1">
                                                                                            <button
                                                                                                @click="cloturer(dat, 0)"
                                                                                                class="btn btn-danger btn-sm">
                                                                                                <i class="ti-close"></i>

                                                                                            </button>
                                                                                        </div>

                                                                                        <div v-else>

                                                                                            <button
                                                                                                @click="cloturer(dat, 1)"
                                                                                                class="btn btn-success btn-sm">
                                                                                                <Icon i
                                                                                                    type="md-checkmark" />

                                                                                            </button>


                                                                                        </div>


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
                                                    <div class="box ">
                                                        <div class="box-header with-border"
                                                            style="background-color:#0052CC;color:white">

                                                        </div>

                                                        <div class="box-body wizard-content">
                                                            <section>
                                                                <div class="row">
                                                                    <div class="table-responsive">
                                                                        <table
                                                                            class="table table-striped table-bordered display">
                                                                            <thead>
                                                                                <tr>

                                                                                    <th>
                                                                                        Année
                                                                                        scolaire
                                                                                    </th>
                                                                                    <th>
                                                                                        Type
                                                                                        de
                                                                                        session
                                                                                    </th>
                                                                                    <th>
                                                                                        Situation
                                                                                    </th>


                                                                                </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                                <tr v-for="(data,
                                                                                    i) in sessions" :key="i
        ">

                                                                                    <td>
                                                                                        <div class="px-25 py-10 w-100">
                                                                                            <span
                                                                                                class="badge badge-primary">{{
                                                                                                    data.libelle_sess
                                                                                                }}</span>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td>
                                                                                        <div class="px-25 py-10 w-100">
                                                                                            <span
                                                                                                class="badge badge-secondary">{{
                                                                                                    data.type_sess
                                                                                                }}</span>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td
                                                                                        v-if="data.SemestreEncours != 'TERMINEE'">
                                                                                        <div class="px-25 py-10 w-100">
                                                                                            <span
                                                                                                class="badge badge-success">
                                                                                                {{
                                                                                                    data.SemestreEncours
                                                                                                }}</span>
                                                                                        </div>
                                                                                    </td>

                                                                                    <td
                                                                                        v-if="data.SemestreEncours == 'TERMINEE'">
                                                                                        <div class="px-25 py-10 w-100">
                                                                                            <span
                                                                                                class="badge badge-danger">
                                                                                                {{
                                                                                                    data.SemestreEncours
                                                                                                }}</span>
                                                                                        </div>
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

                                            <div class="tab-pane" id="messages" role="tabpanel">

                                                <section class="content">



                                                    <div class="box box-default">
                                                        <div class="box-header with-border">

                                                        </div>

                                                        <div class="box-body wizard-content">
                                                            <form action="#" class="" @submit.prevent="onSubmit
                                                                ">
                                                                <!-- Step 1 -->

                                                                <section>
                                                                    <div class="row">
                                                                        <div class="col-md-6">
                                                                            <div class="form-group">
                                                                                <label for="jobTitle3">
                                                                                    Année
                                                                                    scolaire
                                                                                </label>
                                                                                <span class="danger">*</span>
                                                                                <input placeholder="Exemple : 2019-2020"
                                                                                    type="text"
                                                                                    class="form-control required" v-model="data.AnneeScolaire
                                                                                        " />
                                                                                <span class="text-danger" v-if="!$v
                                                                                    .data
                                                                                    .AnneeScolaire
                                                                                    .required &&
                                                                                    $v
                                                                                        .data
                                                                                        .AnneeScolaire
                                                                                        .$dirty
                                                                                    ">
                                                                                    Année
                                                                                    scolaire
                                                                                    requise
                                                                                </span>
                                                                            </div>
                                                                        </div>

                                                                        <div class="col-md-6">
                                                                            <div class="form-group">
                                                                                <label for="jobTitle3">
                                                                                    Date
                                                                                    de
                                                                                    début
                                                                                </label>
                                                                                <span class="danger">*</span>
                                                                                <input type="date"
                                                                                    class="form-control required" v-model="data.dateDebut
                                                                                        " />
                                                                                <span class="text-danger" v-if="!$v
                                                                                    .data
                                                                                    .dateDebut
                                                                                    .required &&
                                                                                    $v
                                                                                        .data
                                                                                        .dateDebut
                                                                                        .$dirty
                                                                                    ">
                                                                                    La
                                                                                    date
                                                                                    de
                                                                                    début
                                                                                    est
                                                                                    requise
                                                                                </span>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="row">
                                                                        <div class="col-md-6">
                                                                            <div class="form-group">
                                                                                <label for="jobTitle3">
                                                                                    Date
                                                                                    de
                                                                                    la
                                                                                    fin
                                                                                </label>
                                                                                <span class="danger">*</span>
                                                                                <input type="date"
                                                                                    class="form-control required" v-model="data.dateFin
                                                                                        " />
                                                                                <span class="text-danger" v-if="!$v
                                                                                    .data
                                                                                    .dateFin
                                                                                    .required &&
                                                                                    $v
                                                                                        .data
                                                                                        .dateFin
                                                                                        .$dirty
                                                                                    ">
                                                                                    La
                                                                                    date
                                                                                    de
                                                                                    la
                                                                                    fin
                                                                                    est
                                                                                    requise
                                                                                </span>
                                                                            </div>
                                                                        </div>

                                                                        <div class="col-md-6">
                                                                            <div class="form-group">
                                                                                <label for="jobTitle3">
                                                                                    Type
                                                                                    de
                                                                                    session
                                                                                </label>

                                                                                <div>
                                                                                    <RadioGroup v-model="data.buttonType
                                                                                        " type="button"
                                                                                        button-style="solid">
                                                                                        <Radio label="Trimestre">
                                                                                        </Radio>
                                                                                        <Radio label="Semestre"></Radio>
                                                                                    </RadioGroup>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="row">
                                                                        <div class="col-md-6">
                                                                            <input type="submit" class="btn btn-facebook"
                                                                                value="Enregistrer" />
                                                                        </div>
                                                                    </div>
                                                                </section>
                                                            </form>
                                                        </div>
                                                        <!-- /.box-body -->
                                                    </div>
                                                </section>

                                            </div>

                                            <div class="tab-pane" id="parametres" role="tabpanel">

                                                <section class="content">



                                                    <div class="box box-default">
                                                        <div class="box-header with-border">

                                                        </div>

                                                        <div class="box-body wizard-content">

                                                            <!-- Step 1 -->

                                                            <section>
                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label for="jobTitle3">
                                                                                Moyenne minimale permattant d'etre
                                                                                admis
                                                                            </label>
                                                                            <span class="danger">*</span>
                                                                            <input type="number"
                                                                                class="form-control required" v-model="data.moymin
                                                                                    " />

                                                                        </div>
                                                                    </div>

                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label for="jobTitle3">
                                                                                Moyenne donnant droit au TH
                                                                            </label>
                                                                            <span class="danger">*</span>
                                                                            <input type="number"
                                                                                class="form-control required" v-model="data.moyth
                                                                                    " />

                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label for="jobTitle3">
                                                                                Absences min pour exclusion
                                                                            </label>
                                                                            <span class="danger">*</span>
                                                                            <input type="number"
                                                                                class="form-control required" v-model="data.abs
                                                                                    " />

                                                                        </div>
                                                                    </div>


                                                                    <div class="col-md-6">
                                                                        <br />
                                                                        <Upload multiple type="drag"
                                                                            action="api/admin/upload"
                                                                            :on-success="handleSuccess"
                                                                            :on-error="handleError"
                                                                            :format="['jpg', 'jpeg', 'png']"
                                                                            :max-size="2048"
                                                                            :on-format-error="handleFormatError"
                                                                            :on-exceeded-size="handleMaxSize" :headers="{
                                                                                'X-Requested-With':
                                                                                    'XMLHttpRequest'
                                                                            }">
                                                                            <div style="padding: 20px 0">
                                                                                <Icon type="ios-cloud-upload" size="52"
                                                                                    style="color: #3399ff"></Icon>
                                                                                <p class="text-center">
                                                                                    Cliquer ou glisser déposer pour
                                                                                    insérer le fichier entete

                                                                                </p>
                                                                            </div>
                                                                        </Upload>
                                                                    </div>


                                                                </div>



                                                                <div class="row">
                                                                    <div class="col-md-6">

                                                                        <button @click="send" class=" btn btn-facebook">
                                                                            Enregistrer
                                                                        </button>

                                                                    </div>
                                                                </div>
                                                            </section>

                                                        </div>
                                                        <!-- /.box-body -->
                                                    </div>
                                                </section>

                                            </div>

                                            <div class="tab-pane" id="horaires" role="tabpanel">

                                                <div class="box-body wizard-content">
                                                    <section>
                                                        <div class="row">
                                                            <div class="table-responsive">
                                                                <table class="table table-striped table-bordered display">
                                                                    <thead>
                                                                        <tr>

                                                                            <th>
                                                                                Libelle
                                                                            </th>
                                                                            <th>
                                                                                Périodicité
                                                                            </th>
                                                                            <th>
                                                                                Action
                                                                            </th>


                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <tr v-for="(data,
                                                                            i) in Horaires" :key="i
        ">

                                                                            <td>

                                                                                {{ data.libelle }}

                                                                            </td>
                                                                            <td>

                                                                                {{ data.heure_D }} -{{ data.heure_F }}

                                                                            </td>


                                                                            <td>
                                                                                <button class="btn btn-primary">

                                                                                    <Icon type="md-create" />

                                                                                </button>

                                                                                <button class="btn btn-danger">

                                                                                    <Icon type="ios-trash" />

                                                                                </button>
                                                                            </td>

                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </section>
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
                AnneeScolaire: "",
                dateDebut: "",
                dateFin: "",
                buttonType: "Trimestre",
                abs: "", moymin: "", moyth: "",
                imageEmploiTmp: "",


            },

            EtabInfos: "",
            Horaires: "",
            showDelateModal: false,
            cloturerItem: '',
            desc: "",

            visible: false,
            uploadList: [],

            users: [],
            sessions: [],
            EtabInfos: [],
            trimestres: [],
            success: "badge badge-success"
        };
    },

    computed: mapState(["datasUser"]),

    validations: {
        data: {
            AnneeScolaire: {
                required
            },
            dateDebut: {
                required
            },
            dateFin: {
                required
            }
        }
    },

    methods: {

        async delateClasse() {

            console.log(this.delateItem);
            const response = await axios.post(
                "api/locale/delateClasse",
                this.delateItem
            );
            if (response.status === 200) {
                console.log(this.delateItem);
                this.datas.splice(this.i, 1);
                this.showDelateModal = false;
                this.s("Classe supprimée correctement");
            }
            // this.modal2 = false;
        },
        async handleRemove(file) {
            const image = this.data;

            this.data.imageLogo = "";

            this.$refs.uploads.clearFiles();

            try {
                await axios.post("api/admin/delateImage", image);
            } catch (e) {
                this.generalError = e.response.data.errors;
            }
        },

        handleView(name) {
            this.data.imageLogo = name;
            this.visible = true;
        },

        handleSuccess(res, file) {
            this.data.imageEmploiTmp = res;
            console.log(res);
        },

        handleError(res, file) {
            this.w("Sélectionner un jpg, png , jpeg ");
        },
        handleFormatError(file) {
            this.w("Sélectionner un jpg, png , jpeg");
        },
        handleMaxSize(file) {
            this.w("Sélctionner un fichier de moins de 2M.");
        },

        handleBeforeUpload() {
            const check = this.uploadList.length < 1;
            if (!check) {
                this.w("Le logo est requi");
            }
            return check;
        },


        async send() {

            if (this.data.moymin.trim() == "") {

                return this.e(" Saisir la moyenne minimale permattant d'etre admis ");
            }

            if (this.data.moyth.trim() == "") {

                return this.e(" Saisir la moyenne minimale permattant d'avoir un TH ");
            }

            if (this.data.abs.trim() == "") {

                return this.e(" Saisir le nombre d'absence ninimum pour etre exclu ");
            }

            if (this.data.imageEmploiTmp.trim() == "") {
                return this.e("Insérer le fichier entete ");
            }

            this.data.EcoleInfos = this.EtabInfos;

            const res = await this.callApi(
                "post",
                "api/locale/Addconfig",
                this.data
            );

            if (res.status == 200) {

                this.s(" Ajout fait correctement");

                this.$router.go();
            }

            if (res.status != 200) {

                this.e(" Une erreure est survenu ");

                // this.$router.go();
            }


        },
        async onSubmit() {
            this.$v.$touch();

            if (this.$v.$invalid) {
                // Cas du  Formulaire non valide

                console.log("Errorrrrr sur le formulaire ");
            } else {

                // Cas du Formulaire  valide

                // Je rajoute les  information de l'ecole appartenant a l'utulisateur qui s'est logger a ma data qui ira dans l'api de creation de la session

                this.data.EcoleInfos = this.EtabInfos;

                const response = await this.callApi(
                    "post",
                    "/api/locale/addSession",
                    this.data
                );

                if (response.status == 400) {
                    this.e("Cette session existe déja ");

                }

                else if (response.status == 200) {
                    this.s("Session ajoutée correctement");
                    this.$router.go();
                } else {
                    this.e("Une erreure est survenue");
                }
            }
        },

        cloturer(dat, i) {

            this.cloturerItem = dat
            console.log(i);
            this.desc = i
            this.showDelateModal = true
        }
        ,

        async cloturerSchool() {

            console.log(this.cloturerItem);

            this.showDelateModal = false

            this.cloturerItem.rest = this.desc

            const response4 = await this.callApi(
                "post",
                "/api/locale/cloturerSession",
                this.cloturerItem
            );


            if (response4.status == 200) {
                this.s("Opération correctement effectuée");
                //   this.$router.go();
            } else {
                this.e("Une erreure est survenue");
            }



        }
    },

    async mounted() {

        if (!localStorage.users) {

            this.$router.push('login');
        }

        // Recuperer toutes les infos de cette ecole dans le storage

        if (localStorage.EtabInfos) {

            this.EtabInfos = JSON.parse(localStorage.getItem("EtabInfos"));

        }

        // Recuperer toutes les sessions de cette ecole

        const response2 = await this.callApi(
            "post",
            "api/locale/getSessionEtablissement",
            this.EtabInfos
        );

        this.sessions = response2.data;

        console.log(this.sessions);

        // Recuperer toutes les trimestres de la session de cette ecole

        const response3 = await this.callApi(
            "post",
            "api/locale/getTrimestreEtablissement",
            this.EtabInfos
        );

        this.trimestres = response3.data[0].trimestres;


        // Recuperer les horaires


        const response13 = await this.callApi(
            "post",
            "api/locale/getHeures"
        );


        this.Horaires = response13.data;




    },



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
