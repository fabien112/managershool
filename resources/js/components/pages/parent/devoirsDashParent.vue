<template>
    <div>
        <div class="wrapper">
            <Header />
            <MenuParent />
            <div class="content-wrapper">
                <div class="container-full">
                    <section class="content">

                        <Alert type="light" closable class="card">

                                         <div class="card-header">
                                             <h4 class="card-title">  Devoirs
                                                  <p
                                                class="subtitle font-size-14 mb-0"
                                            >
                                               Tous les devoirs
                                            </p>
                                             </h4>

                                         </div>
                        </Alert> <br>


                        <div class="row">
                            <div
                                class="col-xl-4 col-12"
                                v-for="(data, i) in DevoirsListes"
                                :key="i"
                            >
                                <div>
                                    <div class="box mb-15 pull-up">
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
                                                            class="text-dark hover-primary mb-1 font-size-10"
                                                        >
                                                            {{
                                                                data.libelle.slice(
                                                                    0,
                                                                    15
                                                                )
                                                            }}... |
                                                            {{
                                                                data.matiere
                                                                    .libelle
                                                            }}
                                                        </a>

                                                       <span class="text-fade font-size-10"> Classe, {{data.classe.libelleClasse}}</span>


                                                        <span
                                                            class="text-fade font-size-10"
                                                        >
                                                            Date limite,
                                                            {{
                                                                data.dateLimite
                                                                    | dateFormat
                                                            }}
                                                        </span>

                                                         <span
                                                            class="text-fade font-size-10"
                                                        >
                                                           Par,
                                                           {{
                                                                data.enseignants.nom

                                                            }}

                                                            {{
                                                                data.enseignants.prenom

                                                            }}

                                                             le
                                                            {{

                                                                data.created_at|dateFormatHeure
                                                            }}
                                                        </span>


                                                    </div>
                                                </div>
                                                <router-link
                                                    to="detailsDevoirParent"
                                                >
                                                    <span
                                                        @click="
                                                            details(data, i)
                                                        "
                                                        class="icon-Arrow-right font-size-20"
                                                        ><span
                                                            class="path1"
                                                        ></span
                                                        ><span
                                                            class="path2"
                                                        ></span
                                                    ></span>
                                                </router-link>
                                            </div>
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
            data: {},
            datasEnfants: "",
            DevoirsListes: "",

        };
    },

    async mounted() {

        if (localStorage.datasEnfant) {

            this.datasEnfants = JSON.parse(localStorage.getItem("datasEnfant"));

        }

            const response = await this.callApi(
            "post",
            "api/parent/getAllDevoirsParentParClasse",
            this.datasEnfants
        );

        this.DevoirsListes = response.data;
    },

    methods: {

        details(data, i) {
            localStorage.setItem("devoirsParent", JSON.stringify(data));
        }


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
