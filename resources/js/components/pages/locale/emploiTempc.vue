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
                                <h3 class="box-title text-center">
                                    {{ data.libelle.libelleClasse }}
                                </h3>
                                <!-- <h6 class="box-subtitle">You can us the validation like what we did</h6> -->
                            </div>

                            <div class="box-body wizard-content">



                                <div class="row">



                                    <div class="col-md-12">

                                        <label>
                                            Jour de la semaine

                                        </label>



                                        <select class="form-control" v-model="data.jour">

                                            <option value="1">Lundi</option>
                                            <option value="2">Mardi</option>
                                            <option value="3">Mercredi</option>
                                            <option value="4">Jeudi</option>
                                            <option value="5">Vendredi</option>
                                            <option value="6">Samedi</option>
                                            <option value="7">Dimanche</option>
                                        </select>

                                    </div>


                                </div> <br>



                                <div class="row" v-for="(input,
                                    k) in data.inputs2" :key="k">


                                    <div class="col-md-12">


                                        <div class="row">



                                            <div class="col-md-6">

                                                <label> Périodicité {{ k + 1 }} </label>


                                                <select v-model="input.heureD" class="custom-select form-control required">
                                                    <option v-for="(data, i) in HeuresListes" :key="i" :value="data">
                                                        {{
                                                            data.libelle
                                                        }}

                                                        <!-- - {{ data.heure_D }} a {{
    data.heure_F }}  -->

                                                    </option>
                                                </select>


                                            </div>








                                            <div class="col-md-6">


                                                <label> Matière {{ k + 1 }} </label>


                                                <select v-model="input.matiere" class="custom-select form-control required">
                                                    <option v-for="(data, i) in Matieres" :key="i" :value="data">
                                                        {{
                                                            data.libelle
                                                        }}



                                                    </option>


                                                </select>


                                            </div>














                                            <br>



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
            idClasse: "",

            data: {


                idClasse: "",
                libelle: "",
                jour: "",
                req: 0,


                inputs2: [
                    {
                        heureD: "",
                        matiere: "",

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

        if (localStorage.classeId) {
            this.data.idClasse = JSON.parse(localStorage.getItem("classeId")).id;

            this.data.libelle = JSON.parse(localStorage.getItem("classeId"));

            this.idClasse = this.data.idClasse

            // this.data.idClasse = this.data.classeId.id
        }



        const response = await this.callApi(
            "post",
            "api/locale/getHeures"
        );

        this.HeuresListes = response.data



        const response3 = await this.callApi(
            "post",
            "api/locale/getMatieresClasse2",
            this.data
        );

        this.Matieres = response3.data



        // const response2 = await this.callApi(
        //     "post",
        //     "api/locale/getClasseEtablissement",
        //     this.EtabInfos
        // );

        // this.ClasseListes = response2.data

        // this.ClasseListes = this.ClasseListes.filter(item => item.eleves.length > 0)






    },

    methods: {

        async afficher() {

            window.open(
                "api/locale/getEmploiTempPdf/" +
                this.datas.libelle.id,
                "_blank"
            );

            const response2 = await this.callApi(
                "get",
                "api/locale/getEmploiTempPdf/" +
                datas.libelle.id,
            );
        },



        add2(index) {
            this.data.inputs2.push({
                heureD: "",
                matiere: "",
                idTeacher: ""

            });


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




            if (this.data.jour == "") {
                return this.e("Selectionner un jour  ");
            }




            for (let i = 0; i < this.data.inputs2.length; i++) {



                if (this.data.inputs2[i].heureD == "") {
                    return this.e(
                        " Remplir correctementles toutes les horaires"
                    );
                }



                // if (this.data.inputs2[i].matiere == "") {
                //     return this.e(
                //         " La matiere de la ligne" + i + 1 + " ne peut etre vide"
                //     );
                // }

            }


            const response4 = await this.callApi(
                "post",
                "api/locale/createEmpldoiTempsDashvrai",
                this.data
            );

            if (response4.status == 200) {
                this.s("Enploi du temps ajouté correctement");
                this.$router.push("times");

            }

            else if (response4.status == 403) {
                this.e("Cet enregistrement existe déja...");


            } else {
                this.e("Une erreure est survenue");
            }
        },

        // async onChange(event) {

        //     console.log(event.target.value)


        //     for (let i = 0; i <= this.Matieres.length; i++) {


        //         if (this.Matieres[i] == event.target.value) {

        //             this.nameTeacher = this.Matieres[i].enseignant.nom
        //         }
        //     }

        //     console.log(this.nameTeacher)



        //     // const response3 = await this.callApi(
        //     //     "post",
        //     //     "api/teacher/getLibelleMatiereclasseById",
        //     //     this.datas
        //     // );



        // }
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
