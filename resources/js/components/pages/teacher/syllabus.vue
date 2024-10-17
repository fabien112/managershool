<template>
    <div>
        <div class="wrapper">
            <HeaderTeacher />
            <MenuTeacher />

            <Modal v-model="PublierModal" width="360">
                <p slot="header" style="color:#f60;text-align:center">
                    <span>Publication</span>
                </p>
                <div style="text-align:center">
                    <p>Etes vous sure de vouloir publier ?</p>
                </div>
                <div slot="footer">
                    <Button type="error" size="large" long @click="publier">Confirmer</Button>
                </div>
            </Modal>

            <Modal v-model="delateModal" width="360">
                <p slot="header" style="color:#f60;text-align:center">
                    <span>SUPPRIMER</span>
                </p>
                <div style="text-align:center">
                    <p>Etes-vous sure de vouloir supprimer ?</p>
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
                        </div>-->

                        <div>
                            <!-- <router-link to="addSyllabus">
                                <button class="btn btn-primary pull-right">
                                    <Icon type="md-add" />Nouveau
                                </button>
                            </router-link> -->
                        </div>
                        <br />
                        <br />

                        <div class="col-12">
                            <div class="box">
                                <div class="box-header bg-primary">
                                    <h4 class="box-title">Syllabus</h4>
                                    <span>

                                        <router-link to="addSyllabus">
                                            <button class="btn btn-primary pull-right">
                                                <Icon type="md-add" />Nouveau
                                            </button>
                                        </router-link>

                                    </span>
                                </div>
                                <div class="box-body">
                                    <div class="table-responsive">
                                        <table id="example" class="table simple mb-0" style="width: 100%;">
                                            <thead>
                                                <tr>

                                                    <th> Classe </th>
                                                    <th> Matière </th>
                                                    <th> Chapitre </th>
                                                    <th> Date de création </th>
                                                    <th></th>

                                                </tr>


                                            </thead>
                                            <tbody>

                                                <tr v-for="(data, i) in Quizz" :key="i">

                                                    <td>{{ data.classe.libelleClasse }}</td>
                                                    <td style="font-size: 12px;font-weight:bold">
                                                        {{ data.matiere.libelle }}</td>
                                                    <td>{{ data.chapitre }}</td>
                                                    <td>{{ data.created_at | dateFormat }}</td>
                                                    <td>

                                                        <button @click="
                                                            generateSyllabusPdf(data, i)
                                                        " class="btn  btn-warning">
                                                            <i class="ti-printer"
                                                                title="Visualiser le syllabus en PDF "></i>
                                                        </button>

                                                        <button @click="ShowdelateModal(data, i)"
                                                            class="btn  btn-danger ">
                                                            <i class="ti-trash" title="Supprimer le syllabus "></i>
                                                        </button>
                                                    </td>



                                                </tr>


                                            </tbody>
                                        </table>
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
                idSyllabus: "",
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
            "api/teacher/getAllSyllabusByATeacher",
            this.users
        );

        this.Quizz = response2.data

    },

    methods: {

        ShowdelateModal(data, i) {
            this.Item = data.id
            this.i = i
            console.log(this.Item);
            this.delateModal = true;
        },



        async generateSyllabusPdf(data, i) {

            // // Recuperer tous les infos de cet eleve

            window.open('api/teacher/generateSyllabusPdf/' + data.id, '_blank')

            const responsePdf = await this.callApi(
                "get",
                "api/teacher/generateSyllabusPdf/" + data.id

            );

        },


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

        Showdetail(data, i) {

            localStorage.setItem("quizz", JSON.stringify(data));
        },


        async delate() {

            this.data.idCahier = this.Item
            const response = await this.callApi(
                "post",
                "api/teacher/delateSyllabus",
                this.data
            );

            if (response.status == 200) {

                this.s("Syllabus de texte  supprimé correctement");
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
