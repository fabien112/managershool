<template>
    <div>
        <div class="wrapper">
            <Header />
            <MenuLocal />

            <div class="content-wrapper">
                <div class="container-full">
                    <section class="content">
                        <!-- START Card With Image -->


                        <div class="row">

                            <div class="col-md-3" @click="SadeData1(1)">



                                <div class="card" style="background-color: green;color: white;">

<!--
                                    <Icon type="md-albums" style="margin-top: 50px;font-size: 60px;" /> -->

                                    <span  style="margin-top: 40px;font-size: 50px; text-align:center;" > 🖥️ </span>


                                    <div class="box-body py-25" style="text-align: center;">

                                        <p class="font-weight-600"> Enseign Gén Cycle 1 </p>
                                    </div>


                                </div>




                            </div>

                            <div class="col-md-3" @click="SadeData2(2)">


                                    <div class="card" style="background-color: #155A75;color: white;">

                                        <!-- <Icon type="md-albums" style="margin-top: 60px;font-size: 60px;" /> -->

                                        <span  style="margin-top: 40px;font-size: 50px; text-align:center;" > 📚 </span>


                                        <div class="box-body py-25" style="text-align: center;">

                                            <p class="font-weight-600"> Enseign Gén Cycle 2 </p>
                                        </div>


                                    </div>




                            </div>


                            <div class="col-md-3" @click="SadeData3(3)">


                                <div class="card" style="background-color: #E91E63 ; color:white">

                                    <!-- <Icon type="md-settings" style="margin-top: 60px;font-size: 60px;" /> -->

                                    <span  style="margin-top: 40px;font-size: 50px; text-align:center;" > 🖥️ </span>


                                    <div class="box-body py-25" style="text-align: center;">

                                        <p class="font-weight-600"> Enseign Techn Cycle 1</p>
                                    </div>


                                </div>




                            </div>

                            <div class="col-md-3" @click="SadeData4(4)">



                                    <div class="card" style="background-color: #2C353D;color: white;">

                                        <span  style="margin-top: 40px;font-size: 50px; text-align:center;" > 📚 </span>

                                        <div class="box-body py-25" style="text-align: center;">

                                            <p class="font-weight-600">Enseign Techn Cycle 2 </p>
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
                cycle1: 1,

            },

        };
    },

    async mounted() {

        if (!localStorage.users) {

            this.$router.push('login');
        }

        // Recuperer les donnes de cet utulisateurs dans la storage local

        if (localStorage.users) {
            this.users = JSON.parse(localStorage.getItem("users"));
        }

        // Allons chercher la session et le code etablissement ce cet enseigant

        const response = await this.callApi(
            "post",
            "api/parent/getInfosParent",
            this.users
        );

        this.InfosParent = response.data;

        // Garder les donnees de l'enseigant  dans le storage de navigateur

        localStorage.setItem("InfosParent", JSON.stringify(this.InfosParent));
    },

    methods: {

        SadeData1(data) {

            localStorage.setItem("cycle", JSON.stringify(data));

            this.$router.push('classesSgm');

        },

        SadeData2(data) {

            localStorage.setItem("cycle", JSON.stringify(data));

            this.$router.push('classesSgm');

        },

        SadeData3(data) {

            localStorage.setItem("cycle", JSON.stringify(data));

            this.$router.push('classesSgm');

        },

        SadeData4(data) {

            localStorage.setItem("cycle", JSON.stringify(data));

            this.$router.push('classesSgm');

        },








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
