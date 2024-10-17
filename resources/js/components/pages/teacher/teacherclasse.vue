<template>
    <div>
        <div class="wrapper">
            <HeaderTeacher />
            <MenuTeacher />
            <div class="content-wrapper">
                <div class="container-full">
                    <section class="content">
                        <div type="light" closable class="card">
                            <div class="card-header">
                                <h4 class="card-title"> CLASSES
                                    <p class="subtitle font-size-14 mb-0">
                                        Liste de toutes les classes dans lesquelles vous enseignez
                                    </p>
                                </h4>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-4 col-12" v-for="(data, i) in ClassesTeacher" :key="i">
                                <div class="box">
                                    <div class="box-header bg-primary " style="text-align: center;">
                                        <h4 class="box-title">
                                            <strong>
                                                {{ data.libelleClasse }}
                                            </strong>
                                        </h4>
                                    </div>

                                    <div class="box-body">
                                        <div class="table-responsive">
                                            <table class="table simple mb-0">
                                                <tbody>
                                                    <tr>
                                                        <td>Effectif</td>
                                                        <td class=" font-weight-700">
                                                            $3240
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td>
                                                            Data
                                                        </td>
                                                        <td class="font-weight-700">
                                                            $50
                                                        </td>
                                                    </tr>

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="box-footer">

                                        <router-link to="">

                                            <button class="btn btn-danger btn-sm">
                                                Liste de la classe
                                            </button>

                                        </router-link>

                                        <router-link to="emploiTempteacher">

                                            <button class="btn btn-primary btn-sm">
                                                Emploi du temps
                                            </button>

                                        </router-link>


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
import MenuTeacher from "../../navs/MenuTeacher.vue";
import Chats from "../../navs/Chats.vue";
import { mapState } from "vuex";
import HeaderTeacher from "../../headers/HeaderTeacher.vue";

export default {
    components: { MenuTeacher, Chats, HeaderTeacher },
    data() {
        return {
            ClassesTeacher: [],
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
            "api/teacher/getAllasseByATeacher",
            this.users
        );

        this.ClassesTeacher = response.data;

        console.log(this.ClassesTeacher);

        // Garder les donnees de l'enseigant  dans le storage de navigateur
    }
};
</script>
