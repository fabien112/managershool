<template>
    <div>
        <div class="wrapper">
            <HeaderTeacher />
            <MenuTeacher />

            <Modal v-model="PublierModal" width="360">
                <p slot="header" style="color:#f60;text-align:center">
                    <span> Publication </span>
                </p>
                <div style="text-align:center">
                    <p>Etes-vous sure de vouloir publier ?</p>
                </div>
                <div slot="footer">
                    <Button type="error" size="large" long @click="publier">Confirmer</Button>
                </div>
            </Modal>

            <Modal v-model="delateModal" width="360">
                <p slot="header" style="color:#f60;text-align:center">
                    <span> SUPPRIMER </span>
                </p>
                <div style="text-align:center">
                    <p> Etes-vous sure de vouloir supprimer ?</p>
                </div>
                <div slot="footer">
                    <Button type="error" size="large" long @click="delate">Confirmer</Button>
                </div>
            </Modal>

            <Modal v-model="PosterModal" width="660">
                <p slot="header" style="text-align:center">
                    <span> Cahier de liaison de la semaine </span>
                </p>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for=""> Début de la semaine </label>
                            <input v-model="data.dateDebut" type="date" class="form-control" />
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label for=""> Fin de la semaine </label>

                        <div class="form-group">
                            <input v-model="data.dateFin" type="date" class="form-control" />
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for=""> Classe </label>
                            <select @change="onChange($event)" v-model="data.classeName"
                                class="custom-select form-control required">
                                <option v-for="(data, i) in ClassListes" :key="i" :value="data.classe.id">
                                    {{ data.classe.libelleClasse }}
                                </option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="wlocation2">
                                Matiere
                                <span class="danger"></span>
                            </label>
                            <select v-model="data.idMatiere" class="custom-select form-control required">
                                <option v-for="(data, i) in LIbelleMatiereclasse" :key="i" :value="data.id">
                                    {{ data.libelle }}
                                </option>
                            </select>
                        </div>
                    </div>
                </div>
                <div style="text-align:center">
                    <Upload multiple type="drag" action="api/admin/upload" :on-success="handleSuccess"
                        :on-error="handleError" :format="[
                            'jpg',
                            'jpeg',
                            'png',
                            'jpg',
                            'jpeg',
                            'png',
                            'pdf',
                            'doc',
                            'docx'
                        ]" :max-size="2048" :on-format-error="handleFormatError" :on-exceeded-size="handleMaxSize"
                        :headers="{
                            'X-Requested-With': 'XMLHttpRequest'
                        }">
                        <div style="padding: 20px 0">
                            <Icon type="ios-cloud-upload" size="52" style="color: #3399ff"></Icon>
                            <p class="text-center">
                                Cliquer ou glisser-déposer pour insérer le
                                fichier
                            </p>
                        </div>
                    </Upload>
                </div>
                <div slot="footer">
                    <Button type="primary" size="large" long @click="Poster">Envoyer</Button>
                </div>
            </Modal>

            <div class="content-wrapper">
                <div class="container-full">
                    <section class="content">
                        <!-- <div type="light" closable class="card">
                            <div class="card-header">
                                <h4 class="card-title">
                                    CAHIER DE TEXTE
                                    <p class="subtitle font-size-14 mb-0">
                                        Mentionner les titres des cours chaque
                                        semaine
                                    </p>
                                </h4>
                            </div>
                        </div> -->

                        <div>
                            <Button class="pull-right" type="primary" @click="showPostterModale">
                                <Icon type="md-add" /> Nouveau
                            </Button>
                        </div>

                        <br />
                        <br />
                        <div class="row">
                            <div class="col-xl-4 col-12" v-for="(data, i) in CahiersListes" :key="i">
                                <div class="box">
                                    <div class="box-header bg-primary " style="text-align: center;">
                                        <p class="box-title">
                                            <strong>
                                                Semaine ({{ data.dateDeb | dateFormat }} au {{ data.dateFin | dateFormat }})
                                                <br>
                                                <span style="font-size:20px;color:#FF562F" v-if="data.statut == 0" @click="
                                                    showPublierModal(data, i)
                                                ">

                                                    <Icon type="md-eye-off" title="Cliquer ici pour publier " />
                                                </span>
                                                <span style="font-size:20px;color:#04A08B" v-if="data.statut == 1">

                                                    <Icon type="md-eye" />
                                                </span>
                                            </strong>
                                        </p>
                                    </div>
                                    <div class="box-body">
                                        <div class="table-responsive">
                                            <table class="table simple mb-0">
                                                <tbody>
                                                    <tr>
                                                        <td>Classe</td>
                                                        <td class=" font-weight-700">
                                                            {{ data.classe.libelleClasse }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            Matiere
                                                        </td>
                                                        <td class="font-weight-700">

                                                            {{ data.matiere.libelle }}

                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="box-footer">
                                        <a :href="
                                            `/Photos/Logos/${data.document}`

                                        " :download="
    data.classe.libelleClasse
"><button class="btn btn-primary btn-sm">
                                                <Icon type="md-download" />Téléch..
                                            </button></a>
                                        <!-- <a href="/emploiTempteacher" class=""
                                            ><button  v-if="data.statut==0"
                                                class="btn btn-info btn-sm"
                                            >
                                                <Icon type="md-create" />
                                                Modif..
                                            </button></a
                                        > -->

                                        <a v-if="data.statut == 0" aria-current="page"
                                            class="router-link-exact-active router-link-active"><button
                                                @click="ShowdelateModal(data, i)" class="btn btn-danger btn-sm">
                                                <Icon type="md-trash" />
                                                Supp..
                                            </button></a>
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

import MenuLocal from "../../navs/MenuLocal.vue";
import Chats from "../../navs/Chats.vue";
import { mapState } from "vuex";
import MenuTeacher from "../../navs/MenuTeacher.vue";
import HeaderTeacher from "../../headers/HeaderTeacher.vue";

export default {
    components: { MenuLocal, Chats, MenuTeacher, HeaderTeacher },
    data() {
        return {
            ClassListes: [],
            CahiersListes: [],
            ClassesTeacher: [],
            LIbelleMatiereclasse: [],
            PosterModal: false,
            data: {
                idCahier: "",
                imageEmploiTmp: "",
                dateDebut: "",
                dateFin: "",
                idMatiere: "",
                idClasse: ""
            },

            PublierModal: false,
            delateModal: false,
            Item: '',
            i: -1

        };
    },

    async mounted() {

        if (localStorage.users) {
            this.users = JSON.parse(localStorage.getItem("users"));
        }

        const response = await this.callApi(
            "post",
            "api/teacher/getAllClasseOfTeacher",
            this.users
        );

        this.ClassListes = response.data

        const response2 = await this.callApi(
            "post",
            "api/teacher/getAllCahierByATeacher",
            this.users
        );

        this.CahiersListes = response2.data


    },

    methods: {

        showPublierModal(data, i) {
            this.Item = data.id
            this.i = i
            console.log(this.Item);
            this.PublierModal = true;

        },

        ShowdelateModal(data, i) {
            this.Item = data.id
            this.i = i
            console.log(this.Item);
            this.delateModal = true;
        },

        // ModLe pour creer un nouveu cahier de texte

        showPostterModale() {

            this.PosterModal = true;
        },

        async Poster() {
            if (this.data.dateDebut == "") {
                return this.e("Selectionner la date du début");
            }

            if (this.data.dateFin == "") {
                return this.e("Selectionner la date de fin");
            }

            if (this.data.idClasse == "") {
                return this.e("Selectionner une classe ");
            }

            if (this.data.idMatiere == "") {
                return this.e("Selectionner une matiere ");
            }

            if (this.data.imageEmploiTmp == "") {
                return this.e("Selectionner le fichier");
            }

            const response4 = await this.callApi(
                "post",
                "api/teacher/createCahier",
                this.data
            );

            if (response4.status == 200) {

                this.CahiersListes.unshift(response4.data)

                console.log(response4.data);

                this.s("Cahier de liaison rempli  correctement")

                this.PosterModal = false

                // this.$router.go();


            } else {
                this.e("Une erreure est survenue");
                this.PosterModal = false
            }
        },

        async delate() {

            this.data.idCahier = this.Item
            const response = await this.callApi(
                "post",
                "api/teacher/delateCahierTeacher",
                this.data
            );

            if (response.status == 200) {

                this.s("Cahier de liaison   supprimé correctement");
                this.CahiersListes.splice(this.i, 1)
                this.PosterModal = false

            } else {
                this.e("Une erreure est survenue");
            }

            this.delateModal = false;




        },

        async publier() {

            this.data.idCahier = this.Item
            const response = await this.callApi(
                "post",
                "api/teacher/updateCahierTeacher",
                this.data
            );

            if (response.status == 200) {
                this.s("Cahier de liasion  publié correctement");
                this.$router.go()


            } else {
                this.e("Une erreure est survenue");
            }

            this.PublierModal = false;




        },

        async onChange(event) {

            this.data.idClasse = event.target.value;

            this.data.users = this.users;


            // Recuperer toutes les matieres de cette  classe

            const response3 = await this.callApi(
                "post",
                "api/teacher/getLibelleMatiereclasseById", this.data
            );

            this.LIbelleMatiereclasse = response3.data

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
            this.w("Selectionner un jpg, png , jpeg, pdf, doc, ou docx");
        },
        handleFormatError(file) {
            this.w("Selectionner un jpg, png , jpeg, pdf, doc, ou docx");
        },
        handleMaxSize(file) {
            this.w("Selctionner un fichier de moins de 2M.");
        },

        handleBeforeUpload() {
            const check = this.uploadList.length < 1;
            if (!check) {
                this.w("Le logo est requi...");
            }
            return check;
        }
    }
};
</script>
