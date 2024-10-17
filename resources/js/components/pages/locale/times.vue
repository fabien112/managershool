<template>
    <div>
        <div class="wrapper">
            <Header />
            <MenuLocal />

            <div class="content-wrapper" style="min-height: 653px; background-color:#FAFBFD">
                <div class="container-full">
                    <!-- Main content -->




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

                    <section class="content">
                        <div class="row">
                            <div class="col-12 ">
                                <div class="box">
                                    <div class="box-header bg-primary">

                                        <span @click="afficher" class="text-left btn btn-primary"> EMPLOI DU TEMPS DE LA
                                            CLASSE DE {{
                                                data.classeId.libelleClasse }}
                                        </span>


                                        <router-link to="emploiTempc">
                                            <span class="pull-right mb-5 text-white"> + Add </span>


                                        </router-link>


                                    </div>

                                    <div class="box-body">
                                        <div class="table-responsive">
                                            <table class="table product-overview">
                                                <thead>
                                                    <tr>


                                                        <th> Lundi </th>
                                                        <th> Mardi </th>
                                                        <th> Mercredi </th>
                                                        <th> Jeudi </th>
                                                        <th> Vendredi </th>

                                                        <th> Samedi </th>
                                                    </tr>
                                                </thead>
                                                <tbody>


                                                    <td v-for="(data,
                                                        i) in classeListe" :key="i">



                                                        <tr v-for="(dat,
                                                            i) in data" :key="i"> <br>

                                                            <!-- <Button type="primary" shape="circle">{{ dat.id_heureD }} - {{ dat.id_heureF }}</Button> -->

                                                            <span class="badge badge-primary  text-center">
                                                                <!-- ⏰ :  -->

                                                                {{ dat.id_heureD }} - {{ dat.id_heureF }}

                                                            </span>

                                                            <i @click="showDelatingModal(dat, i)" class="ti-trash"> </i>

                                                            <br>

                                                            <p v-if="dat.matiere != 'PAUSE'"
                                                                style="font-size:8px;color:#663399;"> {{
                                                                    dat.matiere
                                                                }}

                                                            </p>

                                                            <p class="btn btn-danger btn-xs" v-if="dat.matiere == 'PAUSE'"
                                                                style="font-size:8px;"> {{
                                                                    dat.matiere
                                                                }}

                                                            </p>


                                                            <p v-if="dat.enseignant != null"
                                                                style="font-size:9px;font-weight: bold;">{{
                                                                    dat.enseignant.nom
                                                                }}.

                                                                {{
                                                                    dat.enseignant.prenom.substr(0, 1) | upperCase
                                                                }}
                                                            </p>



                                                            <p style="font-size:9px;" v-if="dat.enseignant == null">
                                                                &ensp; </p>


                                                        </tr>






                                                    </td>


                                                </tbody>


                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>

                    <!-- /.content -->
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
import VueHtml2pdf from "vue-html2pdf";
import {
    required,
    minLength,
    alpha,
    email,
    maxLength,
    sameAs
} from "vuelidate/lib/validators";
import { log } from "util";
import { upperCase } from "lodash";

export default {
    components: { Header, MenuLocal, Chats, VueHtml2pdf },
    data() {
        return {
            data: {
                classeId: ""
            },

            showDelateModal: false,
            delateItem: {},
            i: -1,
            classeListe: [],
            EtabInfos: [],
            parentEleveInfos: [],
            IdParentInfolocal: "",
            datas: [],
            classeItem: "",
        };
    },

    methods: {


        async afficher() {



            window.open(
                "api/locale/getEmploiTempPdf/" +
                this.data.classeId.id,
                "_blank"
            );

            const response2 = await this.callApi(
                "get",
                "api/locale/getEmploiTempPdf/" +
                this.data.classeId.id,
            );
        },

        showDelatingModal(data, i) {
            this.delateItem = data;
            this.i = i;
            this.showDelateModal = true;
        },


        async delatePaiement() {


            const response = await axios.post(
                "api/locale/delatimetable",
                this.delateItem
            );
            if (response.status === 200) {
                this.s("Supprimée correctement");

                this.showDelateModal = false;

                const response2 = await this.callApi(
                    "post",
                    "api/locale/getTimestabs",
                    this.data
                );

                this.classeListe = response2.data;


            }
            // this.modal2 = false;
        },





    },

    async mounted() {
        // Recuperer les infos de cette classe  dans le storage. classdId  contient toutes les classes et leur eleves respectivement
        if (!localStorage.users) {

            this.$router.push('login');
        }
        if (localStorage.classeId) {
            this.data.classeId = JSON.parse(localStorage.getItem("classeId"));
        }

        // Recuperer tous les eleves de cette classe

        const response2 = await this.callApi(
            "post",
            "api/locale/getTimestabs",
            this.data
        );

        this.classeListe = response2.data;

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
