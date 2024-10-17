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
                    <p> Etes-vous sure de vouloir publier ?</p>
                </div>
                <div slot="footer">
                    <Button type="error" size="large" long @click="publier">Confirmer</Button>
                </div>
            </Modal>

            <Modal v-model="delateModal" width="360">
                <p slot="header" style="color:#f60;text-align:center">
                    <span> Publication </span>
                </p>
                <div style="text-align:center">
                    <p> Etes vous sure de voulior supprimer ?</p>
                </div>
                <div slot="footer">
                    <Button type="error" size="large" long @click="delate">Confirmer</Button>
                </div>
            </Modal>


            <div class="content-wrapper">
                <div class="container-full">
                    <section class="content">
                        <!-- <div type="light" closable class="card">
                            <div class="card-header">
                                <h4 class="card-title">
                                    Quizz
                                    <p class="subtitle font-size-14 mb-0">
                                        Tous les quizz
                                    </p>
                                </h4>
                            </div>
                        </div> -->

                        <div>

                            <router-link to="addQuizz">

                                <Button class="pull-right" type="primary">
                                    <Icon type="md-add" /> Nouveau
                                </Button>

                            </router-link>

                        </div> <br><br>


                        <div class="row">
                            <div class="col-xl-4 col-12" v-for="(data, i) in Quizz" :key="i">
                                <div class="box">
                                    <div class="box-header bg-primary " style="text-align: center;">
                                        <h6 class="box-title">

                                            {{ data.libelle }}


                                        </h6> <br>

                                        <span style="font-size:20px; color:#FF562F" v-if="data.statut == 0" @click="
                                            showPublierModal(data, i)
                                        ">

                                            <Icon type="md-eye-off" title="Cliquer ici pour publier " />
                                        </span>
                                        <span style="font-size:20px;color:#04A08B" v-if="data.statut == 1">

                                            <Icon type="md-eye" />
                                        </span>

                                    </div>
                                    <div class="box-body">
                                        <div class="table-responsive">
                                            <table class="table simple mb-0">
                                                <tbody>
                                                    <!-- <tr>
                                                        <td> Nom  </td>
                                                        <td
                                                            class=" font-weight-700"
                                                        >

                                                        {{data.libelle}}



                                                        </td>
                                                    </tr> -->

                                                    <tr>
                                                        <td>
                                                            Classe
                                                        </td>
                                                        <td class="font-weight-700">

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

                                                    <tr>
                                                        <td>
                                                            Date et heure
                                                        </td>
                                                        <td class="font-weight-700">

                                                            {{ data.date | dateFormatHeure }}

                                                        </td>
                                                    </tr>

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="box-footer">

                                        <router-link to="detailQuizz">


                                            <a aria-current="page"
                                                class="router-link-exact-active router-link-active"><button
                                                    @click="Showdetail(data, i)" class="btn btn-success btn-sm">
                                                    <Icon type="md-arrow-forward" />
                                                    Détails
                                                </button></a>


                                        </router-link>


                                        <!-- <a v-if="data.statut==0" href="/emploiTempteacher" class=""
                                            ><button
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
            },
            Quizz: [],

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
            "api/teacher/getAllQuizzByATeacher",
            this.users
        );

        this.Quizz = response2.data

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
            this.delateModal = true;
        },

        // Modale pour creer un nouveu cahier de texte

        showPostterModale() {

            this.PosterModal = true;
        },

        Showdetail(data, i) {

            localStorage.setItem("quizz", JSON.stringify(data));
        },


        async delate() {

            this.data.idCahier = this.Item
            const response = await this.callApi(
                "post",
                "api/teacher/delateQuizz",
                this.data
            );

            if (response.status == 200) {

                this.s("Cahier de texte  supprimé correctement");
                this.Quizz.splice(this.i, 1)
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
                "api/teacher/updateQuizz",
                this.data
            );

            if (response.status == 200) {

                this.s("Quizz publié correctement");

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

        }

    }
};
</script>
