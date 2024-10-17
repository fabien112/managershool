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

                                <router-link to="typeEmploi">

                                    <div class="card" style="background-color:#33993e;color: white;">

                                        <!-- <Icon type="ios-browsers" style="margin-top: 50px;font-size: 50px;" /> -->

                                        <span style="margin-top: 40px;font-size: 50px; text-align:center;">📚 </span>

                                        <div class="box-body py-25" style="text-align: center;">

                                            <p class="font-weight-600"> Emploi du temps </p>
                                        </div>


                                    </div>

                                </router-link>

                            </div>

                            <div class="col-md-12 col-lg-3">

                                <router-link to="coursDashLocal">

                                    <div class="card" style="background-color:rebeccapurple;color: white;">

                                        <!-- <Icon type="md-calendar" style="margin-top: 50px;font-size: 50px;" /> -->

                                        <span style="margin-top: 40px;font-size: 50px; text-align:center;"> 🕮 </span>

                                        <div class="box-body py-25" style="text-align: center;">

                                            <p class="font-weight-600"> Cours en ligne </p>
                                        </div>


                                    </div>

                                </router-link>

                            </div>



                            <div class="col-md-12 col-lg-3">

                                <router-link to="quizzDashLocal">

                                    <div class="card" style="background-color: #2C353D;color: white;">

                                        <!-- <Icon type="md-help" style="margin-top: 50px;font-size: 50px;" /> -->

                                        <span style="margin-top: 40px;font-size: 50px; text-align:center;"> 📓 </span>

                                        <div class="box-body py-25" style="text-align: center;">

                                            <p class="font-weight-600"> Quizz en ligne </p>
                                        </div>


                                    </div>



                                </router-link>

                            </div>

                            <div class="col-md-12 col-lg-3">

                                <router-link to="devoirsDashLocal">

                                    <div class="card" style="background-color: #E91E63 ; color:white">

                                        <!-- <Icon type="ios-folder" style="margin-top: 50px;font-size: 50px;" /> -->

                                        <span style="margin-top: 40px;font-size: 50px; text-align:center;"> 📚 </span>

                                        <div class="box-body py-25" style="text-align: center;">

                                            <p class="font-weight-600"> Devoirs de maison </p>
                                        </div>


                                    </div>

                                </router-link>

                            </div>

                            <div class="col-md-12 col-lg-3">

                                <router-link to="/evaluations">

                                    <div class="card" style="background-color: #E91E63;color: white;">

                                        <!-- <Icon type="ios-book" style="margin-top: 50px;font-size: 50px;" /> -->

                                        <span style="margin-top: 40px;font-size: 50px; text-align:center;"> 📒 </span>

                                        <div class="box-body py-25" style="text-align: center;">

                                            <p class="font-weight-600"> Evaluations </p>
                                        </div>


                                    </div>



                                </router-link>

                            </div>




                            <div class="col-md-12 col-lg-3">

                                <router-link to="dashExamen">

                                    <div class="card" style="background-color: red;color: white;">

                                        <!-- <Icon type="ios-book" style="margin-top: 50px;font-size: 50px;" /> -->

                                        <span style="margin-top: 40px;font-size: 50px; text-align:center;"> 🔖 </span>

                                        <div class="box-body py-25" style="text-align: center;">

                                            <p class="font-weight-600"> Bulletins et Notes </p>
                                        </div>


                                    </div>



                                </router-link>

                            </div>

                            <!-- <div class="col-md-12 col-lg-3">

                                <router-link to="tableauhonneur">

                                    <div class="card" style="background-color:#0052CC;color: white;">



                                        <span style="margin-top: 40px;font-size: 50px; text-align:center;"> 📚 </span>

                                        <div class="box-body py-25" style="text-align: center;">

                                            <p class="font-weight-600"> Tableau d'honneur </p>
                                        </div>


                                    </div>



                                </router-link>

                            </div> -->


                            <div class="col-md-12 col-lg-3">

                                <router-link to="prestataire2">

                                    <div class="card" style="background-color:#2CC;color: white;">

                                        <!-- <Icon type="ios-book" style="margin-top: 50px;font-size: 50px;" /> -->

                                        <span style="margin-top: 40px;font-size: 50px; text-align:center;"> 🔖 </span>

                                        <div class="box-body py-25" style="text-align: center;">

                                            <p class="font-weight-600"> Statistiques Evaluation </p>
                                        </div>


                                    </div>



                                </router-link>

                            </div>


                            <div class="col-md-12 col-lg-3">

                                <router-link to="statTrimestre">

                                    <div class="card" style="background-color:#33993e;color: white;">

                                        <!-- <Icon type="ios-book" style="margin-top: 50px;font-size: 50px;" /> -->

                                        <span style="margin-top: 40px;font-size: 50px; text-align:center;"> 🖥️ </span>

                                        <div class="box-body py-25" style="text-align: center;">

                                            <p class="font-weight-600"> Statistiques trimestre </p>
                                        </div>


                                    </div>



                                </router-link>

                            </div>


                            <div class="col-md-12 col-lg-3">

                                <router-link to="horairetimetable">

                                    <div class="card" style="background-color:rebeccapurple;color: white;">

                                        <!-- <Icon type="md-calendar" style="margin-top: 50px;font-size: 50px;" /> -->

                                        <span style="margin-top: 40px;font-size: 50px; text-align:center;">
                                            <Icon type="ios-clock-outline" />
                                        </span>

                                        <div class="box-body py-25" style="text-align: center;">

                                            <p class="font-weight-600"> Horaires </p>
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

        };
    },


    methods: {

    },

    async mounted() {
        if (!localStorage.users) {

            this.$router.push('login');
        }
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
