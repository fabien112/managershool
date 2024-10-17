<template>
    <div>
        <div class="wrapper">
            <Header />
            <MenuEleve />
            <div class="content-wrapper">
                <div class="container-full">
                    <section class="content">

                        <div class="row">
                            <div class="col-xl-12 col-12" >
                                <Alert closable style="background-color:#0052cc ;color:white">
                                    <h4>
                                        Bienvenu(e) élève
                                        <strong
                                            >{{ users.nom }} {{ users.prenom }}
                                        </strong>
                                    </h4>
                                </Alert>

                            </div>
                        </div> <br>
                        <div class="row">


                            <div class="col-xl-12 col-12">
                                <div class="card">
                                    <div
                                        style="margin:auto;text-align:center;width: 100%;height:80px;background-color:#0052cc;"
                                    >
                                        <img
                                            style="margin: 15px auto auto;width: 100px;border-radius: 50%;height:100px"
                                            class="card-img-top img-responsive"
                                            :src="
                                                `/Photos/Logos/${InfosParent.user.photo}`
                                            "
                                            alt="Card image cap"
                                        />
                                    </div>

                                    <div class="table-responsive">
                                        <table class="table simple mb-0">
                                            <tbody>
                                                <br /><br />

                                                <tr>
                                                    <td>Noms et prénoms</td>
                                                    <td class="font-weight-700">
                                                        {{ InfosParent.nom }}
                                                        {{ InfosParent.prenom }}
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td>
                                                        Classe
                                                    </td>
                                                    <td class="font-weight-700">
                                                        {{
                                                            InfosParent.classe
                                                                .libelleClasse
                                                        }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        Matricule
                                                    </td>
                                                    <td class="font-weight-700">
                                                        {{
                                                            InfosParent.matricule
                                                        }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        Date et lieu de naissance
                                                    </td>
                                                    <td
                                                        class=" font-weight-700"
                                                    >
                                                        {{
                                                            InfosParent.dateNaiss
                                                                | dateFormat
                                                        }} à

                                                        {{
                                                            InfosParent.lieuNaiss
                                                        }}
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td>
                                                        Email
                                                    </td>
                                                    <td
                                                        class=" font-weight-700"
                                                    >
                                                        {{ InfosParent.email }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Statut</td>
                                                    <td
                                                        class=" font-weight-700"
                                                    >
                                                        {{
                                                            InfosParent.doublant
                                                        }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th class="bt-1">
                                                        Sexe
                                                    </th>
                                                    <th
                                                        class=" font-weight-700"
                                                    >
                                                        {{ InfosParent.sexe }}
                                                    </th>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <!-- <div class="col-xl-4 col-12">
                                <div class="row">
                                    <div class="box">
                                        <div class="box-body"> <br>
                                            <div
                                                class="box no-shadow mb-0 px-10"
                                            >
                                                <div
                                                    class="box-header no-border"
                                                >
                                                    <h4 class="box-title">
                                                        Lessons
                                                    </h4>
                                                    <div
                                                        class="box-controls pull-right d-md-flex d-none"
                                                    >
                                                        <a href="#">View All</a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="px-10">
                                                <div class="box mb-15">
                                                    <div class="box-body">
                                                        <div
                                                            class="d-flex align-items-center justify-content-between"
                                                        >
                                                            <div
                                                                class="d-flex align-items-center"
                                                            >
                                                                <div
                                                                    class="mr-15 bg-warning h-50 w-50 l-h-60 rounded text-center"
                                                                >
                                                                    <span
                                                                        class="icon-Book-open font-size-24"
                                                                        ><span
                                                                            class="path1"
                                                                        ></span
                                                                        ><span
                                                                            class="path2"
                                                                        ></span
                                                                    ></span>
                                                                </div>
                                                                <div
                                                                    class="d-flex flex-column font-weight-500"
                                                                >
                                                                    <a
                                                                        href="#"
                                                                        class="text-dark hover-primary mb-1 font-size-16"
                                                                        >Informatic
                                                                        Course</a
                                                                    >
                                                                    <span
                                                                        class="text-fade"
                                                                        >Johen
                                                                        Doe, 19
                                                                        April</span
                                                                    >
                                                                </div>
                                                            </div>
                                                            <a href="#">
                                                                <span
                                                                    class="icon-Arrow-right font-size-24"
                                                                    ><span
                                                                        class="path1"
                                                                    ></span
                                                                    ><span
                                                                        class="path2"
                                                                    ></span
                                                                ></span>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="box mb-15">
                                                    <div class="box-body">
                                                        <div
                                                            class="d-flex align-items-center justify-content-between"
                                                        >
                                                            <div
                                                                class="d-flex align-items-center"
                                                            >
                                                                <div
                                                                    class="mr-15 bg-primary h-50 w-50 l-h-60 rounded text-center"
                                                                >
                                                                    <span
                                                                        class="icon-Mail font-size-24"
                                                                    ></span>
                                                                </div>
                                                                <div
                                                                    class="d-flex flex-column font-weight-500"
                                                                >
                                                                    <a
                                                                        href="#"
                                                                        class="text-dark hover-primary mb-1 font-size-16"
                                                                        >Live
                                                                        Drawing</a
                                                                    >
                                                                    <span
                                                                        class="text-fade"
                                                                        >Micak
                                                                        Doe, 12
                                                                        June</span
                                                                    >
                                                                </div>
                                                            </div>
                                                            <a href="#">
                                                                <span
                                                                    class="icon-Arrow-right font-size-24"
                                                                    ><span
                                                                        class="path1"
                                                                    ></span
                                                                    ><span
                                                                        class="path2"
                                                                    ></span
                                                                ></span>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="box mb-0">
                                                    <div class="box-body">
                                                        <div
                                                            class="d-flex align-items-center justify-content-between"
                                                        >
                                                            <div
                                                                class="d-flex align-items-center"
                                                            >
                                                                <div
                                                                    class="mr-15 bg-danger h-50 w-50 l-h-60 rounded text-center"
                                                                >
                                                                    <span
                                                                        class="icon-Book-open font-size-24"
                                                                        ><span
                                                                            class="path1"
                                                                        ></span
                                                                        ><span
                                                                            class="path2"
                                                                        ></span
                                                                    ></span>
                                                                </div>
                                                                <div
                                                                    class="d-flex flex-column font-weight-500"
                                                                >
                                                                    <a
                                                                        href="#"
                                                                        class="text-dark hover-primary mb-1 font-size-16"
                                                                        >Contemporary
                                                                        Art</a
                                                                    >
                                                                    <span
                                                                        class="text-fade"
                                                                        >Potar
                                                                        doe, 27
                                                                        July</span
                                                                    >
                                                                </div>
                                                            </div>
                                                            <a href="#">
                                                                <span
                                                                    class="icon-Arrow-right font-size-24"
                                                                    ><span
                                                                        class="path1"
                                                                    ></span
                                                                    ><span
                                                                        class="path2"
                                                                    ></span
                                                                ></span>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div> -->
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
import MenuEleve from "../../navs/MenuEleve.vue";
import Chats from "../../navs/Chats.vue";
import { mapState } from "vuex";

export default {
    components: { Header, MenuEleve, Chats },
    data() {
        return {
            InfosParent: [],
            users: []
        };
    },

    async mounted() {
        // Recuperer les donnes de cet utulisateurs dans la storage local

        if (localStorage.users) {
            this.users = JSON.parse(localStorage.getItem("users"));
        }

        // Allons chercher la session et le code etablissement ce cet enseigant

        const response = await this.callApi(
            "post",
            "api/eleve/getEleveInfos",
            this.users
        );

        this.InfosParent = response.data;

        // Garder les donnees de l'enseigant  dans le storage de navigateur

        localStorage.setItem("InfosParent", JSON.stringify(this.InfosParent));
    },

    methods: {}
};
</script>
