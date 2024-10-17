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
                                    BULLETIN SEQUENCE
                                </h4>
                            </div>

                            <div class="box-body wizard-content">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">
                                                Evaluation
                                            </label>

                                            <select v-model="datas.libelleEvaluation
                                                " class="custom-select form-control required">
                                                <option v-for="(data,
                                                    i) in Evaluation" :key="i" :value="data.id">
                                                    {{ data.libelle }}
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">
                                                Classe
                                            </label>
                                            <select @change="
                                                onChange($event)
                                                " v-model="datas.classeName
        " class="custom-select form-control required">
                                                <option v-for="(data,
                                                    i) in ClassListes" :key="i" :value="data.id">
                                                    {{
                                                        data.libelleClasse
                                                    }}
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                </div> <br><br>

                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <button @click="update"
                                                class="waves-effect waves-light btn mb-5   btn-primary btn-block btn-outline ">
                                                CALCULATEUR DE MOYENNES
                                            </button>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <button @click="afficher"
                                                class="waves-effect waves-light btn mb-5  btn btn-primary btn-block">
                                                <!-- <Icon type="md-printer"  />
                                                         -->
                                                BULLETINS DE
                                                NOTES EN PDF
                                            </button>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <button @click="update2"
                                                class="waves-effect waves-light btn mb-5   btn-primary btn-block btn-outline ">
                                                POURCENTAGE DE REMPLISSAGE GLOBALE
                                            </button>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <button @click="update3"
                                                class="waves-effect waves-light btn mb-5  btn btn-primary btn-block">
                                                <!-- <Icon type="md-printer"  />
                                                         -->
                                                POURCENTAGE DE REMPLISSAGE CLASSE
                                            </button>
                                        </div>
                                    </div>


                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <button @click="update4"
                                                class="waves-effect waves-light btn mb-5   btn-primary btn-block btn-outline ">
                                                LISTE DES MATIERES NON SAISIES
                                            </button>
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
            datas: {
                classeName: "",
                idClasse: "",
                libelleEvaluation: "",
                trimestre: ""
            },

            Note: {},
            Obser: {},
            i: 1,
            showDelateModal: false,
            LIbelleMatiereclasse: "",
            checkedNames: [],
            checkBoxs: [],
            rempli: false,
            users: [],
            ClassListes: [],
            MatieresListes: [],
            Notes: [],
            Evaluation: [],
            show: false,
            val: false
        };
    },

    async mounted() {
        if (!localStorage.users) {
            this.$router.push("login");
        }

        if (localStorage.EtabInfos) {
            this.EtabInfos = JSON.parse(localStorage.getItem("EtabInfos"));
        }

        // Recuperer toutes les sessions de cette ecole

        const response2 = await this.callApi(
            "post",
            "api/locale/getClasseEtablissement",
            this.EtabInfos
        );

        this.ClassListes = response2.data;
        this.ClassListes = this.ClassListes.filter(
            item => item.eleves.length > 0
        );

        const response4 = await this.callApi(
            "post",
            "api/locale/getAllEvaluations",
            this.EtabInfos
        );
        this.Evaluation = response4.data;
    },
    methods: {
        async onChange(event) {
            this.datas.idClasse = event.target.value;

            this.datas.EtabInfos = this.EtabInfos;

            // Recuperer toutes les matieres de cette  classe

            const response3 = await this.callApi(
                "post",
                "api/locale/getLibelleMatiereclasseLocaleById",
                this.datas
            );

            this.LIbelleMatiereclasse = response3.data;
        },

        ShowModal() {
            this.showDelateModal = true;
        },

        async update() {
            if (this.datas.libelleEvaluation == "") {
                return this.e("Sélectionner une évaluation ");
            }

            if (this.datas.classeName == "") {
                return this.e("Sélectionner une classe ");
            }

            const response7 = await this.callApi(
                "post",
                "api/locale/updateMoyenne",
                this.datas
            );

            this.$Loading.start();
            this.$Spin.show();

            if (response7.status == 200) {
                this.$Loading.finish();
                this.$Spin.hide();
                this.s("Synchronisation des notes correctement éffectuée");

                this.val = true;
            }

            if (response7.status == 403) {
                this.e(
                    "Une érreure est survenue lors du cacul....Applez le  693333162 pour informations"
                );
                this.$Loading.finish();
                this.$Spin.hide();
            }

            if (response7.status == 400) {
                this.s("Mise a jour des notes...");
                this.$Loading.finish();
                this.$Spin.hide();
                this.val = true;
            }
        },

        async update4() {
            if (this.datas.libelleEvaluation == "") {
                return this.e("Sélectionner une évaluation ");
            } else {

                window.open("api/locale/getAllBulletinEval4/" +

                    this.datas.libelleEvaluation,
                    "_blank")


            }





        },


        async update3() {
            if (this.datas.libelleEvaluation == "") {
                return this.e("Sélectionner une évaluation ");
            } else {

                window.open("api/locale/getAllBulletinEval3/" +

                    this.datas.libelleEvaluation,
                    "_blank")


            }





        },
        async update2() {
            if (this.datas.libelleEvaluation == "") {
                return this.e("Sélectionner une évaluation ");
            } else {

                window.open("api/locale/getAllBulletinEval2/" +

                    this.datas.libelleEvaluation,
                    "_blank")


            }





        },

        async afficher() {
            this.val = false;

            if (this.datas.libelleEvaluation == "") {
                return this.e("Sélectionner une évaluation ");
            }

            if (this.datas.classeName == "") {
                return this.e("Sélectionner une classe ");
            }

            window.open(
                "api/locale/getAllBulletinEval/" +
                this.datas.classeName +
                "*" +
                this.datas.libelleEvaluation,
                "_blank"
            );

            const response2 = await this.callApi(
                "get",
                "api/locale/getAllBulletinEval/" +
                this.datas.classeName +
                "*" +
                this.datas.libelleEvaluation
            );
        }
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
