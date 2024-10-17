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
                                <h5 class="box-title text-center">
                                    Configurer les horaires
                                </h5>
                                <!-- <h6 class="box-subtitle">You can us the validation like what we did</h6> -->
                            </div>

                            <div class="box-body wizard-content">






                                <div class="row" v-for="(input,
                                    k) in data.inputs2" :key="k">


                                    <div class="col-md-12">


                                        <div class="row">





                                            <div class="col-md-12">

                                                <label> </label>


                                                <p style="text-align:center">
                                                    Horaire {{ k + 1 }}
                                                </p>



                                            </div>

                                            <div class="col-md-6">

                                                <label> Début </label>


                                                <input v-model="input.heureD" type="time" class="form-control">



                                            </div>

                                            <div class="col-md-6">


                                                <label> Fin </label>

                                                <input v-model="input.heureF" type="time" class="form-control">



                                            </div>

                                            <br>







                                            <br>





                                            <!-- <div class="col-md-2">

                                                <br>


                                                <button @click="suppri2(data, k)" class="btn btn-primary"> En </button>

                                                <button @click="suppri(data, k)" class="btn btn-danger"> Hr</button>
                                            </div> -->





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
                jour: "",
                HeuresListes: "",

                inputs2: [
                    {
                        heureD: "",
                        heureF: "",

                        // Idteacher: ""


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



        const response = await this.callApi(
            "post",
            "api/locale/getHeures"
        );

        this.HeuresListes = response.data



        const response3 = await this.callApi(
            "post",
            "api/locale/getAllEnseignant"
        );

        this.Matieres = response3.data.contentSimple



        const response2 = await this.callApi(
            "post",
            "api/locale/getClasseEtablissement",
            this.EtabInfos
        );

        this.ClasseListes = response2.data

        this.ClasseListes = this.ClasseListes.filter(item => item.eleves.length > 0)






    },

    methods: {


        // async suppri(data, k) {

        //     console.log(data.inputs2[k]);

        //     data.inputs2[k].heureD = ''; data.inputs2[k].heureF = '';
        //     const response3 = await this.callApi(
        //         "post",
        //         "/api/locale/getMatieresClasse2",
        //         this.data
        //     );

        //     this.Matieres = response3.data;


        // },



        // async suppri2(data, k) {


        //     data.inputs2[k].matiere.libelle = '';

        //     const response3 = await this.callApi(
        //         "post",
        //         "/api/locale/getMatieresClasse2",
        //         this.data
        //     );

        //     this.Matieres = response3.data;


        // },



        add2(index) {

            if (this.data.inputs2[index].heureD == "" || this.data.inputs2[index].heureF == "") {
                return this.e("Vous devez remplir tous les champs");
            }
            else {


                this.data.inputs2.push({
                    heureD: "",
                    heureF: "",

                });

                console.log(this.data.inputs1);


            }





        },


        async onChange3(event) {

            this.data.chapitre = event.target.value;

            this.data.users = this.users;

            // Recuperer tous les chapitres

            const response5 = await this.callApi(
                "post",
                "api/teacher/getPartieByMatiereAndclasse",
                this.data
            );

            this.PartieListes = response5.data;
        },

        async onChange2(event) {

            this.data.matiere = event.target.value;

            this.data.users = this.users;

            // Recuperer tous les chapitres

            const response4 = await this.callApi(
                "post",
                "api/teacher/getChapitreByMatiereAndclasse",
                this.data
            );

            this.ChapitreListes = response4.data;
        },
        remove(index) {
            this.data.inputs1.splice(index, 1);
        },
        remove2(index) {
            this.data.inputs2.splice(index, 1);
        },

        async send() {








            for (let i = 0; i < this.data.inputs2.length; i++) {



                if (this.data.inputs2[i].heureD == "" || this.data.inputs2[i].heureF == "") {
                    return this.e(
                        " Remplir correctement tous les heures de la ligne" + i + 1
                    );
                }





            }


            const response4 = await this.callApi(
                "post",
                "api/locale/createEmpldoiTempsDash",
                this.data
            );

            if (response4.status == 200) {
                this.s("Cahier de texte ajouté correctement");
                this.$router.push("session");

            }

            if (response4.status == 403) {
                this.e("Cet enregistrement existe deja...");


            } else {
                this.e("Une erreure est survenue");
            }
        },

        async onChange(event) {

            this.data.idClasse = event.target.value;

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
