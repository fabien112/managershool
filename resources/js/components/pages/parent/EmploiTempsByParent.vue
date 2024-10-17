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
                                             <h4 class="card-title"> Emploi du temps
                                                  <p
                                                class="subtitle font-size-14 mb-0"
                                            >
                                              Programme des cours de la classe
                                            </p>
                                             </h4>

                                         </div>
                        </Alert> <br>

                        <div class="row">


                            <div
                                class="col-md-6"

                            >
                                <div class="box">
                                    <div class="box-body ribbon-box">
                                        <div class="ribbon ribbon-primary">
                                            {{datasEnfant.classe.libelleClasse}}
                                        </div>

                                        <p class="mb-0 ">
                                            <img
                                                height="100px"
                                                class="center center"
                                                :src="
                                                    `/Photos/Logos/${datasEnfant.classe.emp_Classe}`
                                                "
                                                alt=""

                                            />
                                        </p>
                                    </div>
                                        <a  :href="`/Photos/Logos/${datasEnfant.classe.emp_Classe}`" target="blank">
                                             <Button type="primary" style="width:100%"> <i class="ti-import">  </i> Ouvrir et télécharger </Button>
                                        </a>

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

export default {
    components: { Header, MenuParent, Chats },
    data() {
        return {
            TimeTables: [],
            data: {

            },
            datasEnfant:''
        };
    },

    async mounted() {

         if (localStorage.datasEnfant)  {

            this.datasEnfant= JSON.parse(localStorage.getItem("datasEnfant"));

        }


    },

    methods: {}
};
</script>
