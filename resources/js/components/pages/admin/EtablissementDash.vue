<template>
    <div>
        <div class="wrapper">
            <Header />
            <Menu />
            <div class="content-wrapper">
                <div class="container-full">
                    <section class="content">
                        <!-- START Card With Image -->
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title"> ESPACE ETABLISSEMENT </h4>
                            </div>
                        </div>

                        <div class="row">

                            <div class="col-md-12 col-lg-4">

                                <router-link to="etablissements">

                                    <div class="card">
                                        <img
                                            class="card-img-top"
                                            src="https://img.freepik.com/photos-gratuite/rangee-etudiants-elementaires-multiethniques-lecture-livre-dans-salle-classe-images-style-effet-vintage_1253-1577.jpg?size=626&ext=jpg"
                                            alt="Card image cap"
                                        />
                                        <div class="card-body">
                                            <h4 class="card-title"> Etablissement </h4>
                                            <p class="card-text">
                                                Ajouter et configurer les ecoles 
                                            </p>
                                        </div>
                                        
                                    </div>

                                </router-link>
                               
                            </div>

                            <div class="col-md-12 col-lg-4">

                                <router-link to="addLocal">

                                    <div class="card">
                                        <img
                                            class="card-img-top"
                                            src="https://image.freepik.com/photos-gratuite/fille-dessine-crayons-couleur-dans-salle-classe-maternelle-concept-education-prescolaire-enfant-images-style-vintage_1253-1129.jpg"
                                            alt="Card image cap"
                                        />
                                        <div class="card-body">
                                            <h4 class="card-title"> Administrateur locaux  </h4>
                                            <p class="card-text">
                                                Ajouter et configurer les admins locaux
                                            </p>
                                        </div>
                                        
                                    </div>

                                </router-link>
                               
                            </div>
                            
                            <div class="col-md-12 col-lg-4">

                                <router-link to="etablissement">

                                    <div class="card">
                                        <img
                                            class="card-img-top"
                                            src="https://img.freepik.com/photos-gratuite/rangee-etudiants-elementaires-multiethniques-lecture-livre-dans-salle-classe-images-style-effet-vintage_1253-1577.jpg?size=626&ext=jpg"
                                            alt="Card image cap"
                                        />
                                        <div class="card-body">
                                            <h4 class="card-title"> Matieres </h4>
                                            <p class="card-text">
                                                Ajouter et configurer les matieres
                                            </p>
                                        </div>
                                        
                                    </div>

                                </router-link>
                               
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
import Menu from "../../navs/Menu.vue";
import Chats from "../../navs/Chats.vue";
import { mapState } from "vuex";

export default {
    components: { Header, Menu, Chats },
    data() {
        return {
            UserData: []
        };
    },

    //  Recuperer les donnees envoyees dans la store par computed:
    //computed:mapState(["datasUser"]),

    async mounted() {

        callApi()
    }
};
</script>
