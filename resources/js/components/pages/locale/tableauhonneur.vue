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
                                    Tableau d'honneur du trimestre
                                </h4>
                            </div>

                            <div class="box-body wizard-content">
                                <div class="row">
                                    <div class="col-md-12 col-lg-12">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for=""> TRIMESTRE </label>

                                                    <select v-model="
                                                        datas.libelleEvaluation
                                                    " class="custom-select form-control required">
                                                        <option v-for="(data,
                                                        i) in Evaluation" :key="i" :value="data.id">
                                                            {{ data.libelle_semes }}
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for=""> Classe </label>
                                                    <select @change="onChange($event)" v-model="datas.classeName"
                                                        class="custom-select form-control required">
                                                        <option v-for="(data,
                                                        i) in ClassListes" :key="i" :value="data.id">
                                                            {{
                                                                    data.libelleClasse
                                                            }}
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>

                                        </div>




                                        <div class="row">
                                            <div class="col-md-6">

                                                <div class="form-group">

                                                    <button @click="afficher"
                                                        class="waves-effect waves-light btn mb-5  btn btn-warning btn-block">
                                                        TOUS LES TABLEAUX
                                                        D’HONNEUR en PDF
                                                    </button>
                                                </div>

                                            </div>

                                            <div class="col-md-6">

                                                <div class="form-group">

                                                    <button @click="afficher2"
                                                        class="waves-effect waves-light btn mb-5  btn btn-success btn-block">
                                                        TOUS LES AUTRES TABLEAUX en PDF
                                                    </button>
                                                </div>

                                            </div>



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
            val: 0


        };
    },

    async mounted() {

        if (!localStorage.users) {

            this.$router.push('login');
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

        this.ClassListes = this.ClassListes.filter(item => item.eleves.length > 0)


        const response4 = await this.callApi(
            "post",
            "api/locale/getTrimestreEtablissement",
            this.EtabInfos
        );
        this.Evaluation = response4.data[0].trimestres;


    },
    methods: {


        ShowModal() {
            this.showDelateModal = true;
        },

        async afficher() {

            if (this.datas.libelleEvaluation == "") {
                return this.e("Sélectionner un trimestre ");
            }

            if (this.datas.classeName == "") {
                return this.e("Sélectionner une classe ");
            }


            window.open('api/locale/getAllTBTrimestre/' + this.datas.classeName + '*' + this.datas.libelleEvaluation, '_blank')

            const response2 = await this.callApi(
                "get",
                "api/locale/getAllTBTrimestre/" + this.datas.classeName + '*' + this.datas.libelleEvaluation

            );



        },

        async afficher2() {

            if (this.datas.libelleEvaluation == "") {
                return this.e("Sélectionner un trimestre ");
            }

            if (this.datas.classeName == "") {
                return this.e("Sélectionner une classe ");
            }


            window.open('api/locale/getAllTBTrimestre2/' + this.datas.classeName + '*' + this.datas.libelleEvaluation, '_blank')

            const response2 = await this.callApi(
                "get",
                "api/locale/getAllTBTrimestre2/" + this.datas.classeName + '*' + this.datas.libelleEvaluation

            );



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
