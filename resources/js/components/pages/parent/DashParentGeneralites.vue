<template>

  <div>
        <div class="wrapper">
            <Header />
            <MenuParent />
            <div class="content-wrapper">
                <div class="container-full">
                    <section class="content">
                        <!-- START Card With Image -->


                        <div class="row">

                             <div class="col-md-3">

                                <router-link to="detailsFinancesByParent">

                                     <div class="card" style="background-color: red;color: white;">

                                        <Icon type="logo-usd" style="margin-top: 50px;font-size: 50px;" />

                                         <div class="box-body py-25" style="text-align: center;">

                                                <p class="font-weight-600"> Frais de scolarités  </p>
                                        </div>


                                    </div>


                                </router-link>

                            </div>

                            <div class="col-md-3">

                                <router-link to="DetailsAbsenceByParent">

                                     <div class="card" style="background-color: #155A75;color: white;">

                                        <Icon type="ios-person" style="margin-top: 50px;font-size: 50px;" />

                                         <div class="box-body py-25" style="text-align: center;">

                                                <p class="font-weight-600"> Absences </p>
                                        </div>


                                    </div>


                                </router-link>

                            </div>


                            <div class="col-md-3">

                                <router-link to="EmploiTempsByParent">

                                     <div class="card" style="background-color: #E91E63 ; color:white">

                                        <Icon  type="logo-buffer" style="margin-top: 50px;font-size: 50px;" />

                                         <div class="box-body py-25" style="text-align: center;">

                                                <p class="font-weight-600"> Emploi du temps  </p>
                                        </div>


                                    </div>



                                </router-link>

                            </div>

                            <div class="col-md-3">

                                <router-link to="cahierParent">

                                     <div class="card" style="background-color: #2C353D;color: white;">

                                        <Icon  type="ios-book" style="margin-top: 50px;font-size: 50px;" />

                                         <div class="box-body py-25" style="text-align: center;">

                                                <p class="font-weight-600"> Cahier de texte   </p>
                                        </div>


                                    </div>



                                </router-link>

                            </div>

                            <div class="col-md-3">

                                <router-link to="quizzParent">

                                     <div class="card" style="background-color:#33993e;color: white;" >

                                        <Icon type="md-help" style="margin-top: 50px;font-size: 50px;" />

                                         <div class="box-body py-25" style="text-align: center;">

                                                <p class="font-weight-600"> Quizz en ligne   </p>
                                        </div>


                                    </div>



                                </router-link>

                            </div>

                            <div class="col-md-3">

                                <router-link to="coursParent">

                                     <div class="card" style="background-color:rebeccapurple;color: white;">

                                        <Icon type="ios-albums" style="margin-top: 50px;font-size: 50px;" />

                                         <div class="box-body py-25" style="text-align: center;">

                                                <p class="font-weight-600"> Cours en ligne   </p>
                                        </div>


                                    </div>



                                </router-link>

                            </div>


                            <div class="col-md-3">

                                <router-link to="devoirsDashParent">

                                     <div class="card" style="background-color:#7451EB;color: white;">


                                        <Icon type="ios-calendar"  style="margin-top: 50px;font-size: 50px;" />

                                         <div class="box-body py-25" style="text-align: center;">

                                                <p class="font-weight-600"> Devoirs  </p>
                                        </div>

                                    </div>

                                </router-link>

                            </div>

                            <div class="col-md-12 col-lg-3">

                                <router-link to="moyenneParent">

                                    <div class="card" style="background-color:#2196F3;color: white;">

                                        <Icon type="ios-folder" style="margin-top: 50px;font-size: 50px;" />

                                         <div class="box-body py-25" style="text-align: center;">

                                                <p class="font-weight-600"> Notes </p>
                                        </div>


                                    </div>



                                </router-link>

                            </div>

                             <div class="col-md-12 col-lg-3">

                                <router-link to="consigneParent">

                                    <div class="card" style="background-color:#8196F9;color: white;">

                                        <Icon type="ios-folder" style="margin-top: 50px;font-size: 50px;" />

                                         <div class="box-body py-25" style="text-align: center;">

                                                <p class="font-weight-600"> Consignes et exclusions  </p>
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
            data: {

            },


        };
    },


    methods: {

    } ,


};
</script>

<style>

.content-wrapper{
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
