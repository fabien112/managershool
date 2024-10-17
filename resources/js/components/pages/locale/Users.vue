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

                                <router-link to="parents">

                                    <div class="card" style="background-color:#2C353D;color: white;">

                                        <!-- <Icon type="ios-person" style="margin-top: 50px;font-size: 50px;" /> -->

                                        <span  style="margin-top: 40px;font-size: 50px; text-align:center;" > 👫  </span>

                                        <div class="box-body py-25" style="text-align: center;">

                                            <p class="font-weight-600"> Parents </p>
                                        </div>


                                    </div>



                                </router-link>

                            </div>

                            <div class="col-md-12 col-lg-3">

                                <router-link to="students">

                                    <div class="card">

                                        <!-- <Icon type="ios-body" style="margin-top: 50px;font-size: 50px;" /> -->

                                        <span  style="margin-top: 40px;font-size: 50px; text-align:center;" > 👩‍🎓  </span>


                                        <div class="box-body py-25" style="text-align: center;">

                                            <p class="font-weight-600"> Eleves </p>
                                        </div>


                                    </div>



                                </router-link>

                            </div>

                            <div class="col-md-12 col-lg-3">

                                <router-link to="Enseignants">

                                    <div class="card" style="background-color:#2D8CF0;color: white;">

                                        <span  style="margin-top: 40px;font-size: 50px; text-align:center;" > 👨‍🏫  </span>

                                        <!-- <Icon type="ios-man" style="margin-top: 50px;font-size: 50px;" /> -->

                                        <div class="box-body py-25" style="text-align: center;">

                                            <p class="font-weight-600"> Enseignants </p>
                                        </div>


                                    </div>


                                </router-link>

                            </div>

                            <div class="col-md-12 col-lg-3">

                                <router-link to="caisse">

                                    <div class="card" style="background-color:green;color: white;">

                                        <!-- <Icon type="ios-man" style="margin-top: 50px;font-size: 50px;" /> -->

                                        <span  style="margin-top: 40px;font-size: 50px; text-align:center;" > 👨‍👩‍👦  </span>

                                        <div class="box-body py-25" style="text-align: center;">

                                            <p class="font-weight-600"> Le personnel </p>
                                        </div>


                                    </div>


                                </router-link>

                            </div>

                            <div class="col-md-12 col-lg-3">

                                <router-link to="prestataire">

                                    <div class="card" style="background-color:#E91E63;color: white;">
<!--
                                        <Icon type="md-document" style="margin-top: 50px;font-size: 50px;" /> -->

                                        <span  style="margin-top: 40px;font-size: 50px; text-align:center;" > 👨‍✈️ </span>

                                        <div class="box-body py-25" style="text-align: center;">

                                            <p class="font-weight-600"> Prestataires </p>
                                        </div>


                                    </div>


                                </router-link>

                            </div>

                            <div class="col-md-12 col-lg-3">

                                <router-link to="importations">

                                    <div class="card" style="background-color:#663399;color: white;">

                                        <!-- <Icon type="md-document" style="margin-top: 50px;font-size: 50px;" /> -->

                                        <span  style="margin-top: 40px;font-size: 50px; text-align:center;" > 📚 </span>

                                        <div class="box-body py-25" style="text-align: center;">

                                            <p class="font-weight-600"> Importations en groupe </p>
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

            },


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
