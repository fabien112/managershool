<template>
    <div>
        <div class="wrapper">
            <Header />
            <MenuParent />

            <div
                class="content-wrapper"
                style="min-height: 653px; background-color:#FAFBFD"
            >
                <div class="container-full">
                    <!-- Main content -->

                    <section class="content">

                            <div class="row">
                                  <div class="col-md-6">
                                        <div class="form-group">
                                            <label for=""> Evaluation </label>

                                            <select
                                                v-model="
                                                    datas.libelleEvaluation
                                                "
                                                class="custom-select form-control required"
                                            >
                                                <option
                                                    v-for="(data,
                                                    i) in Evaluation"
                                                    :key="i"
                                                    :value="data.id"
                                                >
                                                    {{ data.libelle }}
                                                </option>
                                            </select>
                                        </div>
                                   </div>

                                    <div class="col-md-6">
                                        <div class="form-group"> <br>
                                            <button
                                                @click="afficher"
                                                class="waves-effect waves-light btn mb-5  btn btn-primary btn-block"
                                            >
                                                Envoyer
                                            </button>
                                        </div>
                                    </div>

                            </div>
                            <br><br>
                            <div class="row">
                            <div class="col-12 ">
                                <div class="box">
                                    <div class="box-header bg-primary">
                                        <h4
                                            class="box-title"
                                            style="margin:auto"
                                        > Bulletin de
                                            <strong>
                                                {{
                                                   datasEnfant.nom
                                                }}

                                                 {{
                                                    datasEnfant.prenom
                                                }}

                                            </strong>
                                        </h4>
                                        <!-- <span>
                                            <button
                                                type="button"
                                                class=" pull-right btn  btn-primary mb-5"
                                            >
                                                <Icon type="md-print" />

                                                Bulletin en PDF
                                            </button>
                                        </span> -->
                                    </div>

                                    <div  class="box-body">
                                        <div class="table-responsive">
                                            <table
                                                class="table product-overview"
                                            >
                                                <thead>
                                                    <tr>
                                                        <th> Matiere </th>
                                                        <th> Note / 20</th>
                                                        <th> Coef</th>
                                                        <th> Note * Coef </th>
                                                        <th> Mention </th>
                                                        <th> Enseignant </th>
                                                    </tr>
                                                </thead>
                                                <tbody >
                                                    <tr

                                                        v-for="(data,
                                                        i) in Notes.datas"
                                                        :key="i"

                                                    >


                                                        <td

                                                        >

                                                        {{data.matiere.libelle}}

                                                        </td>
                                                        <td  class="font-weight-600">

                                                            {{data.valeur}}

                                                        </td>
                                                        <td>

                                                              {{data.matiere.coef}}

                                                        </td>
                                                        <td>

                                                                 {{data.matiere.coef * data.valeur }}

                                                        </td>
                                                        <td class="font-weight-600">

                                                             {{data.mention}}

                                                        </td>

                                                         <td >

                                                             {{data.user.nom}}  {{data.user.prenom}}

                                                        </td>

                                                    </tr>

                                                    <tr v-if="rempli===true">
                                                        <td class="font-weight-900">
                                                            MOYENNE
                                                        </td>
                                                        <td class="font-weight-900">
                                                            {{Notes.moyenne}}

                                                        </td>

                                                    </tr>


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
            datas: {

                libelleEvaluation:''
            },
            classeListe: [],
            EtabInfos: [],
            parentEleveInfos: [],
            Evaluation:[],
            Notes:[]
        };
    },

     async mounted() {
        // Recuperer les infos de cette classe  dans le storage. classdId  contient toutes les classes et leur eleves respectivement

         if (localStorage.datasEnfant) {
            this.datasEnfant = JSON.parse(localStorage.getItem("datasEnfant"));
        }

         const response4 = await this.callApi(
            "post",
            "api/teacher/getAllEvaluationsByParent",
            this.datasEnfant
        );
        this. Evaluation = response4.data;

    },
    methods: {

         async afficher() {

            if (this.datas.libelleEvaluation == "") {
                return this.e("Selectionner une évaluation");
            }

            this.datas.datasEnfant = this.datasEnfant;

            const response2 = await this.callApi(
                "post",
                "api/teacher/getBulletinEleveByParent",
                this.datas
            );

            this.Notes= response2.data;

            if (this.Notes == "") {
                this.rempli = false;
            } else {
                this.rempli = true;
            }
        }


    },


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
