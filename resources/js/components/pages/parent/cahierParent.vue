<template>
    <div>
        <div class="wrapper">
            <Header />
            <MenuParent />
            <div class="content-wrapper">
                <div class="container-full">
                    <section class="content">


                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for=""> Date </label>

                                    <input v-model="datas.date" class="custom-select form-control required" type="date"
                                        name="" id="">


                                </div>
                            </div>

                            <div class="col-md-6">
                                <br>
                                <div class="form-group">

                                    <button @click="afficher" class=" btn btn-primary  btn-block"> Envoyer </button>

                                </div>
                            </div>

                        </div>



                        <div class="row" v-if="rempli==true">
                            <div class="col-xl-3 col-12" v-for="(data, i) in DevoirsListes" :key="i">
                                <div>
                                    <div class="box mb-15 pull-up">
                                        <div class="box-body">
                                            <div class="d-flex align-items-center justify-content-between">
                                                <div class="d-flex align-items-center">
                                                    <div class="mr-15 bg-primary h-50 w-50 l-h-60 rounded text-center">
                                                        <span class="icon-Book-open font-size-24"><span
                                                                class="path1"></span><span class="path2"></span></span>
                                                    </div>
                                                    <div class="d-flex flex-column font-weight-500">

                                                        <p class="font-size-10">{{ data.matiere
                                                                    .libelle }}

                                                        </p>

                                                        <a href="#" class="text-dark hover-primary mb-1 font-size-10"> Enseignant :


                                                            {{


                                                                    data.user.nom
                                                            }}

                                                            {{


                                                                    data.user.prenom
                                                            }}
                                                        </a>


                                                    </div>
                                                </div>
                                                <router-link to="detailsCahierTexte">
                                                    <span @click="
                                                        details(data, i)
                                                    " class="icon-Arrow-right font-size-20"><span
                                                            class="path1"></span><span class="path2"></span></span>
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
import { thisExpression } from '@babel/types';


export default {

    components: { Header, Chats, MenuParent },

    data() {
        return {
            datas: {
                date: '',
                classe:""
            },
            datasEnfants: "",
            DevoirsListes: "",
            rempli: false,

        };
    },

    async mounted() {

        if (localStorage.datasEnfant) {

            this.datasEnfants = JSON.parse(localStorage.getItem("datasEnfant"));

            this.datas.classe = this.datasEnfants.classe;

        }

    },

    methods: {


        async afficher() {

            if (this.datas.date.trim() == "") {
                return this.e("Choisir un jour ");
            }



            const response2 = await this.callApi(
                "post",
                "api/parent/getAllCahierParentParClasse",
                this.datas
            );

            this.DevoirsListes = response2.data

            if (this.DevoirsListes == "") {
                this.rempli = false

            }

            else {
                this.rempli = true
            }


        } ,

        details(data, i) {
            localStorage.setItem("idCahierTexte", JSON.stringify(data));

            console.log(data);
        }


    }
};
</script>
