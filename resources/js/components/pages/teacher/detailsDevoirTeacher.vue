<template>
    <div>
        <div class="wrapper">
            <HeaderTeacher />
            <MenuTeacher />
            <div class="content-wrapper">
                <div class="container-full">
                    <section class="content">
                        <div class="row">
                            <Modal v-model="PosterModal" width="660">
                                <p slot="header" style="color:rgb(235, 14, 14);text-align:center">
                                    <span> CORRECTION </span>
                                </p>
                                <div style="text-align:center">
                                    <p>
                                        Destinée aux parents, éleves et
                                        aministrateurs.
                                    </p>

                                    <br>

                                    <Upload multiple type="drag" action="api/admin/upload" :on-success="handleSuccess"
                                        :on-error="handleError"
                                        :format="['jpg', 'jpeg', 'png', 'jpg', 'jpeg', 'png', 'pdf', 'doc', 'docx']"
                                        :max-size="2048" :on-format-error="handleFormatError"
                                        :on-exceeded-size="handleMaxSize" :headers="{
                                            'X-Requested-With':
                                                'XMLHttpRequest'
                                        }">
                                        <div style="padding: 20px 0">
                                            <Icon type="ios-cloud-upload" size="52" style="color: #3399ff"></Icon>
                                            <p class="text-center">
                                                Cliquer ou glisser-déposer
                                                pour insérer le fichier
                                            </p>
                                        </div>
                                    </Upload>
                                </div>
                                <div slot="footer">
                                    <Button type="primary" size="large" long @click="Poster">Envoyer</Button>
                                </div>
                            </Modal>
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

                            <div class="col-md-9">
                                <div class="box">
                                    <div class="box-header bg-primary " style="text-align: center;">
                                        <h4 class="box-title">
                                            <strong>
                                                {{ Devoirdetails.libelle }}
                                            </strong>
                                        </h4>
                                    </div>
                                    <div class="box-body">
                                        <div class="table-responsive">
                                            <table class="table simple mb-0">
                                                <tbody>
                                                    <tr>
                                                        <td>Classe</td>
                                                        <td class=" font-weight-700">
                                                            {{
                                                                Devoirdetails
                                                                    .classe
                                                                    .libelleClasse
                                                            }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Matiere</td>
                                                        <td class=" font-weight-700">
                                                            {{
                                                                Devoirdetails
                                                                    .matiere
                                                                    .libelle
                                                            }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            Date limite
                                                        </td>
                                                        <td class="font-weight-700">
                                                            {{
                                                                Devoirdetails.dateLimite
                                                                    | dateFormat
                                                            }}
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td>
                                                            Enseignant
                                                        </td>
                                                        <td class="font-weight-700">
                                                            {{
                                                                Devoirdetails
                                                                    .enseignants
                                                                    .nom
                                                            }}
                                                            {{
                                                                Devoirdetails
                                                                    .enseignants
                                                                    .prenom
                                                            }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            Instructions
                                                        </td>
                                                        <td class="font-weight-700 font-size-10">
                                                            {{
                                                                Devoirdetails
                                                                    .instructions

                                                            }}

                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td>
                                                            <h5>
                                                                <Button @click="
                                                                    showPublierModal
                                                                " v-if="
    Devoirdetails.statut ==
    0
" type="error" long>
                                                                    <Icon type="md-eye" />
                                                                    Publier le
                                                                    devoir
                                                                </Button>
                                                                <Button v-if="
                                                                    Devoirdetails.statut ==
                                                                    1
                                                                " type="primary" long>
                                                                    <Icon type="md-eye" />
                                                                    Devoir deja
                                                                    publié
                                                                </Button>
                                                            </h5>
                                                        </td>
                                                        <td class="font-weight-700">
                                                            <h5>
                                                                <Button @click="
                                                                    showPostterMolad
                                                                " v-if="
    Devoirdetails.support ==
    null
" type="error" long>
                                                                    <Icon type="md-checkmark" />
                                                                    Poster la
                                                                    correction
                                                                </Button>
                                                                <Button v-if="
                                                                    Devoirdetails.support !=
                                                                    null
                                                                " type="primary" long>
                                                                    <Icon type="md-checkmark" />

                                                                    Correction
                                                                    déja postée
                                                                </Button>
                                                            </h5>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <a class="box box-link-shadow text-center pull-up" href="javascript:void(0)">
                                    <div class="box-body py-25 bg-info px-5">
                                        <p class="font-weight-600 ">
                                            Support du devoir
                                        </p>
                                    </div>
                                    <div class="box-body">
                                        <h1 class="countnm font-size-50 m-0">
                                            <Icon type="ios-document" />
                                        </h1>

                                        <Divider></Divider>
                                        <h5 v-if="Devoirdetails.document">
                                            ( 1 ) Support
                                        </h5>
                                        <h5 v-if="!Devoirdetails.document">
                                            ( 0 ) Support
                                        </h5>

                                        <Divider></Divider>
                                        <h5>
                                            <a v-if="Devoirdetails.document != null" :download="
                                                Devoirdetails.libelle
                                            " :href="
    `/Photos/Logos/${Devoirdetails.document}`
">
                                                <Button type="primary" long>
                                                    <Icon type="md-cloud-download" />
                                                    Télécharger le devoir
                                                </Button>
                                            </a>
                                            <Divider></Divider>

                                            <a v-if="Devoirdetails.support != null" :download="
                                                Devoirdetails.libelle
                                            " :href="
    `/Photos/Logos/${Devoirdetails.support}`
">
                                                <Button type="success" long>
                                                    <Icon type="md-cloud-download" />
                                                    Téléchar..la correction
                                                </Button>
                                            </a>
                                        </h5>
                                    </div>
                                </a>
                            </div>
                            <!-- <div class="col-md-12">
                                <div class="box">
                                    <div class="box-header bg-primary">
                                        <h4
                                            class="box-title"
                                            style="margin:auto"
                                        >
                                            <strong>
                                                Devoirs rendus
                                                <button
                                                    style="margin-left: 650px;"
                                                    type="button"
                                                    class="waves-effect btn  btn-primary mb-5"
                                                >
                                                    <i class="ti-printer"></i>
                                                    Imprimer
                                                </button>
                                            </strong>
                                        </h4>
                                    </div>

                                    <div class="box-body">
                                        <div class="table-responsive">
                                            <table
                                                class="table product-overview"
                                            >
                                                <thead>
                                                    <tr>
                                                        <th></th>
                                                        <th>Noms et prénoms</th>
                                                        <th>Matricule</th>
                                                        <th>Email</th>
                                                        <th>N/A</th>
                                                        <th></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td align="center"></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div> -->
                        </div>
                    </section>
                </div>
            </div>
        </div>
        <Chats />
    </div>
</template>

<script>
import MenuTeacher from "../../navs/MenuTeacher.vue";
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
import HeaderTeacher from "../../headers/HeaderTeacher.vue";

export default {
    components: { MenuTeacher, Chats, HeaderTeacher },
    data() {
        return {
            data: {
                idDevoir: "",
                imageEmploiTmp: ''
            },
            Devoirdetails: "",
            PublierModal: false,
            PosterModal: false
        };
    },

    mounted() {
        if (localStorage.users) {
            this.Devoirdetails = JSON.parse(localStorage.getItem("devoirs"));
        }
    },

    methods: {
        showPublierModal() {
            this.PublierModal = true;
        },

        showPostterMolad() {
            this.PosterModal = true;
        },

        async Poster() {


            this.data.idDevoir = this.Devoirdetails.id;


            if (this.data.imageEmploiTmp.trim() == "") {
                return this.e("Envoyez le fichier contenant la correction");
            }
            const response = await this.callApi(
                "post",
                "api/teacher/posterCorrectionDevoirsTeacher",
                this.data
            );

            if (response.status == 200) {
                this.s("Correction posté correctement");

                this.$router.push("devoirsDashTeacher");
            } else {
                this.e("Une erreure est survenue");
            }

            this.PublierModal = false;

            this.$router.push("devoirsDashTeacher");
        },

        async publier() {

            this.data.idDevoir = this.Devoirdetails.id;
            const response = await this.callApi(
                "post",
                "api/teacher/updateDevoirsTeacher",
                this.data
            );

            if (response.status == 200) {
                this.s("Devoir publié correctement");

                this.$router.push("devoirsDashTeacher");
            } else {
                this.e("Une erreure est survenue");
            }

            this.PublierModal = false;

            this.$router.push("devoirsDashTeacher");
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
        },
    }
};
</script>

<style>
.content-wrapper {
    background-color: #fafbfd;
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
