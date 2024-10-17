<template>
    <div>
        <div class="wrapper">
            <Header />
            <MenuParent />
            <div class="content-wrapper">
                <div class="container-full">
                    <section class="content">
                        <div class="row">


                            <div class="col-md-9">
                                <div class="box">
                                    <div
                                        class="box-header bg-primary "
                                        style="text-align: center;"
                                    >
                                        <h4 class="box-title">
                                            <strong>
                                                {{ Quizzdetails.libelle }}
                                            </strong>
                                        </h4>
                                    </div>
                                    <div class="box-body">
                                        <div class="table-responsive">
                                            <table class="table simple mb-0">
                                                <tbody>
                                                    <tr>
                                                        <td>Classe</td>
                                                        <td
                                                            class=" font-weight-700"
                                                        >
                                                            {{
                                                                Quizzdetails.classe.libelleClasse


                                                            }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Matiere</td>
                                                        <td
                                                            class=" font-weight-700"
                                                        >
                                                            {{
                                                               Quizzdetails.matiere.libelle


                                                            }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            Date et heure
                                                        </td>
                                                        <td
                                                            class="font-weight-700"
                                                        >
                                                            {{
                                                                Quizzdetails.date
                                                                    | dateFormatHeure
                                                            }}
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td>
                                                            Duree
                                                        </td>
                                                        <td
                                                            class="font-weight-700"
                                                        >
                                                            {{
                                                                Quizzdetails.duree
                                                            }}
                                                        </td>
                                                    </tr>

                                                     <tr>
                                                        <td>
                                                            Consigne
                                                        </td>
                                                        <td
                                                            class="font-weight-700 font-size-10"
                                                        >
                                                            {{
                                                                Quizzdetails
                                                                    .consigne

                                                            }}

                                                        </td>
                                                    </tr>

                                                     <tr>
                                                        <td>
                                                            Enseignant
                                                        </td>
                                                        <td
                                                            class="font-weight-700"
                                                        >
                                                            {{
                                                                Quizzdetails
                                                                    .user
                                                                    .nom
                                                            }}
                                                            {{
                                                                Quizzdetails
                                                                    .user
                                                                    .prenom
                                                            }}
                                                        </td>
                                                    </tr>

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <a
                                    class="box box-link-shadow text-center pull-up"
                                    href="javascript:void(0)"
                                >
                                    <div class="box-body py-25 bg-info px-5">
                                        <p class="font-weight-600 ">
                                            Quizz
                                        </p>
                                    </div>
                                    <div class="box-body">
                                        <h3 class="countnm font-size-20 m-0">
                                           <Icon type="md-help" />
                                        </h3>

                                        <Divider></Divider>
                                        <h5 >
                                            {{Nbre}}  question(s)
                                        </h5>


                                        <Divider></Divider>

                                        <Button

                                                                    v-if="
                                                                        Quizzdetails.verrouiller ==
                                                                            0
                                                                    "
                                                                    type="error"
                                                                    long
                                                                >

                                                                   Quizz  programmé
                                        </Button>

                                        <Button
                                                                    v-if="
                                                                        Quizzdetails.verrouiller ==
                                                                            1
                                                                    "
                                                                    type="primary"
                                                                    long
                                                                >

                                                                    Quizz déja passé
                                        </Button>

                                    </div>
                                </a>
                            </div>
                            <div class="col-md-12">
                                <div class="box">
                                    <div class="box-header bg-primary">
                                        <h4
                                            class="box-title"
                                            style="margin:auto"
                                        >
                                            <strong>
                                               Répondre par Vrai ou Faux

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
                                                        <th>N°</th>
                                                        <th>Questions</th>
                                                         <th>Points</th>
                                                        <!-- <th>Réponse</th> -->

                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr v-for="(data, i) in Quizzdetails.question"  :key="i">
                                                        <td>{{i+1}}</td>
                                                        <td>{{data['libelle_question']}}</td>
                                                        <td> {{data['point']}} point(s) </td>

                                                    </tr>
                                                </tbody>
                                            </table>
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
import MenuParent from "../../navs/MenuParent.vue";
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
    components: { Header, MenuParent, Chats },
    data() {
        return {
            data: {
                idDevoir: "",
                imageEmploiTmp:''
            },
            Quizzdetails: "",
            Nbre:"",
            PublierModal: false,
            PosterModal: false
        };
    },

    mounted() {
        if (localStorage.users) {
            this.Quizzdetails = JSON.parse(localStorage.getItem("quizzParent"));

            this.Nbre = this.Quizzdetails.question.length
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
