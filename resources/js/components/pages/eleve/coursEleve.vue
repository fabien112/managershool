<template>
    <div>
        <div class="wrapper">
            <Header />
            <MenuEleve />
            <div class="content-wrapper">
                <div class="container-full">
                    <section class="content">
                        <!-- <div type="light" closable class="card">
                            <div class="card-header">
                                <h4 class="card-title">
                                    CAHIER DE TEXTE
                                    <p class="subtitle font-size-14 mb-0">
                                        Mentionner les titres des cours chaque
                                        semaine
                                    </p>
                                </h4>
                            </div>
                        </div> -->

                         <!-- <Alert type="light" closable class="card">

                                         <div class="card-header">
                                             <h4 class="card-title">  Cours en ligne
                                                  <p
                                                class="subtitle font-size-14 mb-0"
                                            >
                                               Liste des cours postés par les enseignants en ligne
                                            </p>
                                             </h4>

                                         </div>
                        </Alert> <br> -->

                        <div class="row">
                            <div class="col-xl-4 col-12"  v-for="(data, i) in DevoirsListes"
                                :key="i">
                                <div class="box">
                                    <div
                                        class="box-header bg-primary "
                                        style="text-align: center;"
                                    >
                                        <p class="box-title">
                                            <strong>
                                               {{data.chapitre}} <br>

                                            </strong>
                                        </p>
                                    </div>
                                    <div class="box-body">
                                        <div class="table-responsive">
                                            <table class="table simple mb-0">
                                                <tbody>
                                                    <tr>
                                                        <td>Classe</td>
                                                        <td
                                                            class=" font-weight-700 font-Size-10"
                                                        >
                                                            {{data.classe.libelleClasse}}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            Enseignant
                                                        </td>
                                                        <td
                                                            class="font-weight-700 font-Size-10"
                                                        >

                                                           {{data.enseignants.nom}}  {{data.enseignants.prenom}} publie le  {{data.created_at|dateFormat}}

                                                        </td>
                                                    </tr>

                                                     <tr>
                                                        <td>
                                                            Matiere
                                                        </td>
                                                        <td
                                                            class="font-weight-700 font-Size-10"
                                                        >

                                                           {{data.matiere.libelle}}

                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td>
                                                            Compétences
                                                        </td>
                                                        <td
                                                            class="font-weight-700 font-Size-10"
                                                        >

                                                           {{data.competence}}

                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="box-footer">
                                        <a  :href="
                                                    `/Photos/Logos/${data.document}`

                                                "
                                                :download="
                                                    data.classe.libelleClasse
                                                "
                                            ><button
                                                class="btn btn-primary btn-block"
                                            >
                                                <Icon
                                                    type="md-download"
                                                />Télécharger  le cours
                                            </button></a
                                        >



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
import MenuEleve from "../../navs/MenuEleve.vue";
import Chats from "../../navs/Chats.vue";
import { mapState } from "vuex";


export default {

    components: { Header,  Chats, MenuEleve },

   data() {
        return {
            data: {},
            datasEnfants: "",
            DevoirsListes: "",

        };
    },

    async mounted() {

        if (localStorage.InfosParent) {

            this.datasEnfants = JSON.parse(localStorage.getItem("InfosParent"));

        }

            const response = await this.callApi(
            "post",
            "api/parent/getAllCoursParentParClasse",
            this.datasEnfants
        );

        this.DevoirsListes = response.data;

        console.log(this.DevoirsListes);
    },

    methods: {


    }
};
</script>
