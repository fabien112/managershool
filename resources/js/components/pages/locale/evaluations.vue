<template>
    <div>
        <div class="wrapper">
            <Header />
            <MenuLocal />
            <!-- Modal pour ajouter une evaluation  -->

            <Modal v-model="Modal" title="Ajouter une évaluation ">
                <div class="row">
                    <div class="col-md-12">
                        <label class="form-label"> Libellé
                        </label>
                        <input type="text" class="form-control" v-model.trim="
                            data.libelle
                        " />
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <label class="form-label">
                            Date de début
                        </label>
                        <input type="date" class="form-control" v-model.trim="
                            data.dateDebut
                        " />
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <label class="form-label"> Date de la fin </label>
                        <input type="date" class="form-control" v-model.trim="
                            data.dateFin
                        " />
                    </div>
                </div>

                <br />


                <div slot="footer">

                    <button class="btn btn-primary btn-block" @click="Add()"> Enregistrer
                    </button>

                </div>
            </Modal>

            <!-- Modol pour supprimer une evaluation  -->

            <Modal v-model="showDelateModal" width="360">
                <p slot="header" style="color:#f60;text-align:center">
                    <span> Suppression </span>
                </p>
                <div style="text-align:center">
                    <p> Etes-vous sure de vouloir supprimer ?</p>
                </div>
                <div slot="footer">
                    <Button type="error" size="large" long @click="delateEvaluation">Confirmer</Button>
                </div>
            </Modal>

            <Modal v-model="showActivateModal" width="360">
                <p slot="header" style="color:#0052CC;text-align:center">
                    <span> Activation </span>
                </p>
                <div style="text-align:center">
                    <p> Etes vous sure de vouloir activer ?</p>
                </div>
                <div slot="footer">
                    <Button type="primary" size="large" long @click="activateEvaluation">Confirmer</Button>
                </div>
            </Modal>

            <div class="content-wrapper">
                <div class="container-full">
                    <section class="content">


                        <div class="row">
                            <div class="col-md-12">

                                <button type="button" class="pull-right waves-effect btn  btn-primary mb-15"
                                    @click="Modal = true">
                                    <Icon type="md-add-circle" />

                                    Nouveau
                                </button>

                            </div>

                        </div>

                        <div class="row">
                            <div class="col-xl-4 col-12" v-for="(data, i) in Evaluations" :key="i">
                                <div class="box">
                                    <div class="box-header bg-primary " style="text-align: center;">
                                        <p class="box-title " style="font-size: 12px;">
                                            <strong>

                                                {{ data.libelle }} &nbsp; &nbsp;


                                                <span v-if='data.statut == 1'
                                                    class="badge badge-xl badge-dot badge-success"></span>

                                                <span v-if='data.statut == 0'
                                                    class="badge badge-xl badge-dot badge-danger"></span>

                                            </strong>

                                        </p>
                                    </div>
                                    <div class="box-body">
                                        <div class="table-responsive">
                                            <table class="table simple mb-0">
                                                <tbody>
                                                    <tr>
                                                        <td>
                                                            PERIODICITE
                                                        </td>
                                                        <td class="font-weight-700 font-Size-10"> TRIMESTRE
                                                            {{ data.trimestre_id }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>DEBUT</td>
                                                        <td class=" font-weight-700 font-Size-10">
                                                            {{ data.dateDeb | dateFormat }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            FIN
                                                        </td>
                                                        <td class="font-weight-700 font-Size-10">
                                                            {{ data.dateFin | dateFormat }} </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="box-footer">

                                        <button @click="showActivatingModal(data, i)" v-if='data.statut == 0'
                                            class="btn btn-primary ">
                                            <Icon type="md-checkmark-circle-outline" class="font-Size-18" /> Activer
                                        </button>


                                        <button class="btn btn-danger" @click="showDelatingModal(data, i)">
                                            <Icon type="ios-trash" class="font-Size-18" />
                                            Supprimer
                                        </button>
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

export default {
    components: { Header, Chats, MenuLocal },
    data() {
        return {

            Evaluations: [],
            data: {
                dateDebut: "",
                dateFin: "",
                libelle: ""

            },
            EtabInfos: "",
            Modal: false,
            showDelateModal: false,
            showActivateModal: false,
            delateItem: {},
            activateItem: {},
            i: -1,

        };
    },

    async mounted() {

        if (!localStorage.users) {

            this.$router.push('login');
        }
        if (localStorage.EtabInfos) {
            this.EtabInfos = JSON.parse(localStorage.getItem("EtabInfos"));
        }

        const response2 = await this.callApi(
            "post",
            "api/locale/getAllEvaluations",
            this.EtabInfos
        );
        this.Evaluations = response2.data;


    },

    methods: {

        async delateEvaluation() {

            console.log(this.delateItem);
            const response = await axios.post(
                "api/locale/delateEvaluation",
                this.delateItem
            );
            if (response.status === 200) {
                this.Evaluations.splice(this.i, 1);
                this.showDelateModal = false;
                this.s("Evaluation supprimée correctement");
            }

        },

        async activateEvaluation() {

            const response = await axios.post(
                "api/locale/activateEvaluation",
                this.activateItem
            );
            if (response.status === 200) {
                this.showActivateModal = false;
                this.s("Evaluation activée correctement");
                const response2 = await this.callApi(
            "post",
            "api/locale/getAllEvaluations",
            this.EtabInfos
        );
        this.Evaluations = response2.data;
            }

        },


        showActivatingModal(data, i) {

            this.activateItem = data;
            this.showActivateModal = true;
        },

        showDelatingModal(data, i) {
            this.delateItem = data;
            this.i = i;
            this.showDelateModal = true;
        },

        async Add() {

            if (this.data.libelle.trim() == "") {
                return this.e("Saisir le nom de l'évaluation");
            }
            if (this.data.dateDebut.trim() == "") {
                return this.e("Saisir une date de début");
            }
            if (this.data.dateFin.trim() == "") {
                return this.e("Saisir une date de fin");
            }

            this.data.EtabInfos = this.EtabInfos

            const response5 = await this.callApi(
                "post",
                "api/locale/addEvaluations",
                this.data
            );

            if (response5.status == 200) {

                this.s("Evaluation ajoutée correctement");

                this.Evaluations.unshift(response5.data);

                this.Modal = false;

            }

            if (response5.status == 400) {

                this.e("-	Vous ne pouvez créer plus de deux séquences pour un même trimestre ");


            }
            else {
                this.e("Une erreure est survenue");
            }


        }






    }
};
</script>
