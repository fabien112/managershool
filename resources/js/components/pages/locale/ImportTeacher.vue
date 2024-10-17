<template>
    <div>
        <div class="wrapper">
            <Header />
            <MenuLocal />
            <div class="content-wrapper">
                <div class="container-full">
                    <section class="content">
                        <div class="box  box-default">

                            <div class="box-header" style="background-color:#0052CC;text-align: center; color:white">

                                <h4 class="box-title">
                                    IMPORTATION DES ENSEIGNANTS
                                </h4>
                            </div>

                            <div class="box-body wizard-content">
                                <div class="row">

                                    <div class="col-md-12">
                                        <Upload multiple type="drag" action="api/admin/uploadteacher" :on-success="
                                            handleSuccess
                                        " :on-error="
    handleError
" :format="[

    'xls',
    'xlsx'
]" :on-format-error="
    handleFormatError
" :on-exceeded-size="
    handleMaxSize
" :headers="{
    'X-Requested-With':
        'XMLHttpRequest'
}">
                                            <div style="padding: 20px 0">
                                                <Icon type="ios-cloud-upload" size="52" style="color: #3399ff"></Icon>
                                                <p class="text-center">
                                                    Joindre
                                                    le
                                                    fichier Excel correspondant
                                                </p>
                                            </div>
                                        </Upload>
                                    </div>
                                    <br />

                                    <!-- <div
                                                                class="col-md-12"
                                                            >
                                                                <div
                                                                    class="form-group"
                                                                >
                                                                    <button
                                                                        @click="
                                                                            sendMessage
                                                                        "
                                                                        class="btn btn-primary"
                                                                    >
                                                                       Chargement
                                                                    </button>
                                                                </div>
                                                            </div> -->
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

                imageEmploiTmp: ""

            },


        };
    },

    methods: {



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


        handleSuccess(res, file) {
            this.data.imageEmploiTmp = res;
            this.s("Importation effectuée avec succès");
            this.$router.push('Enseignants');

        },


        handleFormatError(file) {
            this.w("Selectionner un fichier Excel ");
        },

        handleError(res, file) {
            this.w("Une erreur est survenue lors de la procédure.");
        },


        handleBeforeUpload() {
            const check = this.uploadList.length < 1;
            if (!check) {
                this.w("Vous devez inserer un fichier Excel...");
            }
            return check;
        }
    },

    async mounted() {
        if (!localStorage.users) {

            this.$router.push('login');
        }
    },


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
