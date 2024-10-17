<template>
    <div>
        <div class="wrapper">
            <HeaderTeacher />
            <MenuTeacher />
            <div class="content-wrapper">
                <div class="container-full">
                    <section class="content">
                        <div class="box box-default">
                            <div class="box-header" style="background-color:#0052CC;text-align: center; color:white">

                                <h4 class="box-title">
                                    Ajouter un devoir
                                </h4>
                            </div>
                            <!-- /.box-header -->
                            <div class="box-body wizard-content">
                                <form action="#" class="">
                                    <section>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for=""> Classe </label>
                                                    <select @change="onChange($event)" v-model="data.classeName"
                                                        class="custom-select form-control required">
                                                        <option v-for="(data, i) in ClassListes" :key="i"
                                                            :value="data.classe.id">
                                                            {{ data.classe.libelleClasse }}
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="wlocation2">
                                                        Matière
                                                        <span class="danger"></span>
                                                    </label>
                                                    <select v-model="data.matiere"
                                                        class="custom-select form-control required">
                                                        <option v-for="(data, i) in LIbelleMatiereclasse" :key="i"
                                                            :value="data.id">
                                                            {{ data.libelle }}
                                                        </option>
                                                    </select>

                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>
                                                        Libellé du devoir
                                                    </label>
                                                    <input type="text" class="form-control required" v-model.trim="
                                                        data.libelleDevoir
                                                    " />
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>
                                                        Date limite
                                                    </label>
                                                    <input type="date" class="form-control required" v-model.trim="
                                                        data.dateLimite
                                                    " />
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <label for="">
                                                    Instructions du devoir
                                                </label>

                                                <div class="form-group">
                                                    <textarea v-model="data.instructions" class="form-control" cols="3"
                                                        rows="3">
                                                    </textarea>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <label for="">
                                                    Vérouillé le devoir après la
                                                    date limite ?
                                                </label>

                                                <div class="form-group">
                                                    <RadioGroup v-model="data.verrouiller" type="button"
                                                        button-style="solid">
                                                        <Radio label="Oui"></Radio>
                                                        <Radio label="Non"></Radio>

                                                    </RadioGroup>
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <Upload multiple type="drag" action="api/admin/upload"
                                                    :on-success="handleSuccess" :on-error="handleError" :format="[
                                                        'jpg',
                                                        'jpeg',
                                                        'png',
                                                        'pdf',
                                                        'doc',
                                                        'docx',
                                                        'xls',
                                                        'xlsx'
                                                    ]" :max-size="2048" :on-format-error="
    handleFormatError
" :on-exceeded-size="
    handleMaxSize
" :headers="{
    'X-Requested-With':
        'XMLHttpRequest'
}">
                                                    <div style="padding: 20px 0">
                                                        <Icon type="ios-cloud-upload" size="52" style="color: #3399ff">
                                                        </Icon>
                                                        <p class="text-center">
                                                            Cliquer ou glisser
                                                            deposer pour insérer
                                                            un fichier
                                                        </p>
                                                    </div>
                                                </Upload>
                                            </div>


                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <button @click="send" type="button" class="btn btn-primary">
                                                        Enregistrer
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </section>
                                </form>
                            </div>
                            <!-- /.box-body -->
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
import {
    required,
    minLength,
    alpha,
    email,
    maxLength,
    sameAs
} from "vuelidate/lib/validators";
import { log } from "util";
import MenuTeacher from "../../navs/MenuTeacher.vue";
import HeaderTeacher from "../../headers/HeaderTeacher.vue";

export default {
    components: { Chats, MenuTeacher, HeaderTeacher },
    data() {
        return {
            UserData: [],

            data: {

                classeName: "",
                matiere: "",
                idClasse: "",
                libelleDevoir: "",
                dateLimite: "",
                instructions: "",
                imageLogo: "",
                verrouiller: "Non"

            },

            ClassListes: '',
            visible: false,
            uploadList: [],
            LIbelleMatiereclasse: []
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

        this.ClassListes = response.data;
    },

    methods: {



        async send() {

            if (this.data.classeName == "") {
                return this.e("Sélectionner une classe ");
            }

            if (this.data.matiere == "") {
                return this.e("Sélectionner la matiere");
            }

            if (this.data.libelleDevoir.trim() == "") {
                return this.e("Saisir le libelle du devoir ");
            };
            if (this.data.dateLimite.trim() == "") {
                return this.e("Donner une date limite de remise du devoir");
            };
            if (this.data.instructions.trim() == "") {
                return this.e("Saisir les consignes du devoir");
            };


            const response4 = await this.callApi(
                "post",
                "api/teacher/createDevoir", this.data
            );

            if (response4.status == 200) {

                this.s("Devoir ajouté correctement");
                this.$router.push('devoirsDashTeacher');


            } else {
                this.e("Une erreure est survenue");
            }



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
            this.data.imageLogo = res;
            console.log(res);
        },

        handleError(res, file) {
            this.w("Sélectionner un jpg, png ou jpeg.");
        },
        handleFormatError(file) {
            this.w("Sélectionner un jpg, png ou jpeg");
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
