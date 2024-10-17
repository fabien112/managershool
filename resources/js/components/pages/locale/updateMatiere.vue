<template>
    <div>
        <div class="wrapper">
            <Header />
            <MenuLocal />
            <div class="content-wrapper">
                <div class="container-full">
                    <section class="content">
                        <div class="box box-default">
                            <div class="box-header" style="background-color:#0052CC;text-align: center; color:white">

                                <h4 class="box-title">
                                    Modification
                                </h4>
                            </div>

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

                                                    <select class="custom-select form-control required" v-model="
                                                        data.matiere
                                                    ">
                                                        <option v-for="(data,
                                                        i) in Libelles" :key="
        i
    ">
                                                            {{
                                                                    data.libelle
                                                            }}</option>
                                                    </select>
                                                </div>

                                                <div class="col-md-12 col-sm-12">
                                                    <label>
                                                        Sélectionner
                                                        la catégorie ce cette matière pour
                                                        cette classe

                                                    </label>

                                                    <select class="custom-select form-control required" v-model="
                                                        data.categorie
                                                    ">
                                                        <option v-for="(data,
                                                        i) in cat" :key="i"
                                                            :value="data.id">
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
                                                    <input type="number" class=" form-control required" v-model="
                                                        data.coef
                                                    " />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <br />

                                    <div class="row">
                                        <div class="col-md-6">
                                            <input type="submit" class="btn btn-facebook" value="Enregistrer" @click="
                                                SaveMatiere
                                            " />
                                        </div>
                                    </div>
                                </section>
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
import { exportDefaultSpecifier } from '@babel/types';

export default {
    components: { Header, MenuLocal, Chats },
    data() {
        return {
            UserData: [],
            keyword2: "",
            champautre: false,

            data: {
                 data: {
                libelle: "",
                matiere: "",
                categorie: "",
                prof: "",
                coef: ""
            },

            },

            EtabInfos: "",
            EcoleInfos: "",
            visible: false,
            uploadList: [],
            Libelles: [],
            cat : []
        };
    },






    async mounted() {

        const response2 = await this.callApi(
            "post",
            "/api/locale/getLibelles",
            this.data
        );
        this.Libelles = response2.data;

        const response4 = await this.callApi(
            "post",
            "/api/locale/getcat",
            this.data
        );
        this.cat = response4.data;

        // Recuperer toutes les infos de cette ecole dans le storage

        if (!localStorage.users) {

            this.$router.push('login');
        }

        if (localStorage.EtabInfos) {

            this.EtabInfos = JSON.parse(localStorage.getItem("EtabInfos"));
        }

        if (localStorage.Teacherdata) {

            this.Teacherdata = JSON.parse(localStorage.getItem("Teacherdata"));
            this.data = this.Teacherdata;
            this.data.nomAdmin = this.Teacherdata.nom
            this.data.PrenomAdmin = this.Teacherdata.prenom
            this.data.emailAdmin = this.Teacherdata.email
            this.data.telAdmin = this.Teacherdata.tel
            this.data.salaire = this.Teacherdata.salaire


        }


    },

    methods: {



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
