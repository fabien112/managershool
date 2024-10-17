<template>
    <div>
        <div class="wrapper">
            <Header />
            <MenuLocal />

            <div class="content-wrapper">
                <div class="container-full">
                    <section class="content">
                        <div class="box box-default">

                            <div class="box-header with-border bg-primary">
                                <h4 class="box-title">
                                    Configurer l'emploi du temp de la classe
                                </h4>
                                <!-- <h6 class="box-subtitle">You can us the validation like what we did</h6> -->
                            </div>

                            <div class="box-body wizard-content">




                                <div class="row" v-for="(input,
                                    k) in data.inputs2" :key="k">


                                    <div class="col-md-12">

                                        <div class="row pl-2">



                                            <div class="col-md-8">

                                                <label> Heure {{ k + 1 }} </label>


                                                <input type="time" v-model="input.heureD" class=" form-control">


                                            </div>



                                        </div>


                                        <br>


                                        <span>
                                            <Icon style="font-size:25px; color:red" type="md-remove-circle" @click="
                                                remove2(
                                                    k
                                                )
                                                " v-show="k ||
        (!k &&
            data
                .inputs2
                .length >
            1)
        " />

                                            <Icon style="font-size:25px; color:green" type="ios-add-circle" @click="
                                                add2(
                                                    k
                                                )
                                                " v-show="k ==
        data
            .inputs2
            .length -
        1
        " />
                                        </span>
                                        <br />
                                        <br />
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <button @click="send" type="button" class="btn btn-primary">Enregistrer</button>
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
import Header from "../../headers/Header.vue";

export default {
    components: { MenuLocal, Chats, Header },
    data() {
        return {
            UserData: [],

            data: {

                matiere: "",
                idClasse: "",

                inputs2: [
                    {
                        heureD: "",

                    }
                ]


            },

            keyword: "",

            ClasseListes: "",
            MoisListes: '',
            visible: false,
            uploadList: [],
            LIbelleMatiereclasse: [],
            HeuresListes: [],
            ChapitreListes: [],
            PartieListes: [],
            EtabInfos: "",
            Matieres: ""
        };
    },

    async mounted() {
        if (localStorage.users) {
            this.users = JSON.parse(localStorage.getItem("users"));
        }

        if (localStorage.EtabInfos) {
            this.EtabInfos = JSON.parse(localStorage.getItem("EtabInfos"));

        }












    },

    methods: {



        add2(index) {
            this.data.inputs2.push({
                heureD: "",
                heureF: "",
                matiere: ""

            });

            console.log(this.data.inputs1);
        },



        remove(index) {
            this.data.inputs1.splice(index, 1);
        },
        remove2(index) {
            this.data.inputs2.splice(index, 1);
        },

        async send() {


            for (let i = 0; i < this.data.inputs2.length; i++) {
                if (this.data.inputs2[i].heureD == "") {
                    return this.e(
                        " Remplir correctement tous les heures."
                    );
                }


            }


            const response4 = await this.callApi(
                "post",
                "api/locale/createHoraires",
                this.data
            );

            if (response4.status == 200) {
                this.s("Horaires correctement");
                //  this.$router.push("cahierNewAll");

            } else {
                this.e("Une erreure est survenue");
            }
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
