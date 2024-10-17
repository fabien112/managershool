<template>
    <div>
        <div class="wrapper">
            <Header />
            <MenuLocal />
            <div class="content-wrapper">
                <div class="container-full">
                    <section class="content">


                        <div class="row">

                            <div class="col-md-12 col-lg-3">

                                <router-link to="session">


                                    <div class="card">

                                        <!-- <Icon type="md-calendar" style="margin-top: 50px;font-size: 50px;" /> -->

                                        <span style="margin-top: 50px;font-size: 40px; text-align: center;"> 📒 </span>


                                        <div class="box-body py-25" style="text-align: center;">

                                            <p class="font-weight-600"> Session </p>
                                        </div>

                                    </div>


                                </router-link>

                            </div>

                            <div class="col-md-12 col-lg-3">

                                <router-link to="users">


                                    <div class="card" style="background-color:#FF0000;color: white;">

                                        <!-- <Icon type="ios-people" style="margin-top: 50px;font-size: 50px;" /> -->

                                        <span
                                            style="margin-top: 50px;font-size: 40px; text-align: center;">👨‍👩‍👧‍👦</span>



                                        <div class="box-body py-25" style="text-align: center;">

                                            <p class="font-weight-600"> Utilisateurs </p>
                                        </div>

                                    </div>


                                </router-link>

                            </div>


                            <div class="col-md-12 col-lg-3">

                                <router-link to="cycle2">


                                    <div class="card" style="background-color:#E91E63;color: white;">

                                        <!-- <Icon type="logo-usd" style="margin-top: 50px;font-size: 50px;" /> -->

                                        <span style="margin-top: 50px;font-size: 40px; text-align: center;">💸</span>



                                        <div class="box-body py-25" style="text-align: center;">

                                            <p class="font-weight-600"> Frais de scolairté </p>
                                        </div>

                                    </div>

                                </router-link>

                            </div>

                            <div class="col-md-12 col-lg-3">

                                <router-link to="cycle">

                                    <div class="card" style="background-color:#3399;color: white;">


                                        <!-- <Icon type="ios-book" style="margin-top: 50px;font-size: 50px;" /> -->


                                        <span style="margin-top: 50px;font-size: 40px; text-align: center;">📚</span>


                                        <div class="box-body py-25" style="text-align: center;">

                                            <p class="font-weight-600"> Classes et Matières </p>
                                        </div>

                                    </div>

                                </router-link>

                            </div>


                            <div class="col-md-12 col-lg-3">

                                <router-link to="navdepenseLocal">


                                    <div class="card" style="background-color:#2C353D;color: white;">

                                        <span style="margin-top: 50px;font-size: 40px; text-align: center;">📓</span>


                                        <!-- <Icon type="ios-card" style="margin-top: 50px;font-size: 50px;" /> -->


                                        <div class="box-body py-25" style="text-align: center;">

                                            <p class="font-weight-600"> Salaires et dépenses </p>
                                        </div>

                                    </div>


                                </router-link>

                            </div>


                            <div class="col-md-12 col-lg-3">

                                <router-link to="cycle4">

                                    <div class="card" style="background-color:#2D8CF0;color: white;">


                                        <!-- <Icon type="ios-book" style="margin-top: 50px;font-size: 50px;" /> -->

                                        <span style="margin-top: 50px;font-size: 40px; text-align: center;">💻</span>


                                        <div class="box-body py-25" style="text-align: center;">

                                            <p class="font-weight-600"> Surveillance Générale </p>
                                        </div>

                                    </div>

                                </router-link>

                            </div>


                            <div class="col-md-12 col-lg-3">

                                <router-link to="RecapAbsence">

                                    <div class="card" style="background-color:#04A08B;color: white;">

                                        <span style="margin-top: 50px;font-size: 40px; text-align: center;">👨‍💻</span>
                                        <!--

                                        <Icon type="ios-book" style="margin-top: 50px;font-size: 50px;" /> -->


                                        <div class="box-body py-25" style="text-align: center;">

                                            <p class="font-weight-600"> Absences </p>
                                        </div>

                                    </div>

                                </router-link>

                            </div>



                            <div class="col-md-12 col-lg-3">

                                <router-link to="cycle5">

                                    <div class="card" style="background-color:#E67D21;color: white;">

                                        <span style="margin-top: 50px;font-size: 40px; text-align: center;">🐱‍💻</span>


                                        <!-- <Icon type="ios-book" style="margin-top: 50px;font-size: 50px;" /> -->


                                        <div class="box-body py-25" style="text-align: center;">

                                            <p class="font-weight-600"> Consignes </p>
                                        </div>

                                    </div>

                                </router-link>

                            </div>

                            <div class="col-md-12 col-lg-3">

                                <router-link to="bankLocal">


                                    <div class="card" style="background-color:#4C1C45;color: white;">

                                        <!-- <Icon type="ios-card" style="margin-top: 50px;font-size: 50px;" /> -->

                                        <span style="margin-top: 50px;font-size: 40px; text-align: center;">🕹️</span>

                                        <div class="box-body py-25" style="text-align: center;">

                                            <p class="font-weight-600"> Banques </p>

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
import MenuLocal from "../../navs/MenuLocal.vue";
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
    components: { Header, MenuLocal, Chats },
    data() {
        return {
            data: {
                AnneeScolaire: "",
                dateDebut: "",
                dateFin: "",
                buttonType: "Trimestre"
            },

            users: [],
            sessions: [],
            EtabInfos: [],
            trimestres: [],
            success: 'badge badge-success'
        };
    },

    computed: mapState(["datasUser"]),

    validations: {
        data: {
            AnneeScolaire: {
                required
            },
            dateDebut: {
                required
            },
            dateFin: {
                required
            }
        }
    },

    methods: {
        async onSubmit() {
            this.$v.$touch();

            if (this.$v.$invalid) {
                // Cas du  Formulaire non valide

                console.log("Errorrrrr sur le formulaire ");
            } else {
                // Cas du Formulaire  valide

                // Je rajoute les  information de l'ecole appartenant a l'utulisateur qui s'est logger a ma data qui ira dans l'api de creation de la session

                this.data.EcoleInfos = this.EtabInfos;
                console.log(this.data);
                const response = await this.callApi(
                    "post",
                    "/api/locale/addSession",
                    this.data
                );
                if (response.status == 200) {
                    this.s("Session ajoutée correctement");
                } else {
                    this.e("Une erreure est survenue");
                }
            }
        }
    },

    async mounted() {

        if (!localStorage.users) {

            this.$router.push('login');
        }



        // Recuperer toutes les infos de cette ecole

        const response = await this.callApi("get", "api/locale/getEtabinfos");

        this.EtabInfos = response.data;

        if (localStorage.users) {

            this.users = JSON.parse(localStorage.getItem("users"));
        }

        // Recuperer toutes les sessions de cette ecole

        const response2 = await this.callApi("post", "api/locale/getSessionEtablissement", this.EtabInfos);

        this.sessions = response2.data

        console.log(this.sessions);

        // Recuperer toutes les trimestres  de cette ecole

        const response3 = await this.callApi("post", "api/locale/getTrimestreEtablissement", this.EtabInfos);

        this.trimestres = response3.data

        console.log(this.trimestres);


    },

};
</script>

<style>
.content-wrapper {
    background-color: #FAFBFD
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
