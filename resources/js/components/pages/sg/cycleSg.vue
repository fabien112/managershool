<template>
    <div>
        <div class="wrapper">
            <Header />
            <MenuSG />

            <div class="content-wrapper">
                <div class="container-full">
                    <section class="content">
                        <!-- START Card With Image -->


                        <div class="row">

                            <!-- <div class="col-md-12" @click="SadeData4(4)">



                                    <div class="card" style="background-color: #2C353D;color: white;">

                                        <Icon type="ios-list" style="margin-top: 60px;font-size: 60px;" />


                                        <div class="box-body py-25" style="text-align: center;">

                                            <p class="font-weight-600">   Liste des classes dont vous avez la charge  </p>
                                        </div>


                                    </div>





                            </div> -->


                        </div>


                        <div class="row">
                            <div class="box">
                                <div class="box-header bg-primary" >
                                    <h4 class="box-title">

                                        Retrouver  un  élève a partir de son nom ou de son matricule  </h4>


                                        <button type="button" class=" pull-right btn  btn-primary mb-5" @click="SadeData4(4)" >
                                                   <Icon  type="ios-list" style="font-size: 40px;" />
                                        </button>
                                </div>

                                <div class="box-footer">
                                    <div class="row">

                                        <div class="col-md-9">
                                            <div class="form-group">
                                                <label for> Nom ou matricule de l’élève  </label>

                                                <input  class="form-control" placeholder="Saisir le nom  ou le matricule de l’élève" v-model="data.nom" />

                                            </div>
                                        </div>

                                        <!-- <div class="col-md-6">
                                            <div class="form-group">
                                                <label for> Prénom </label>

                                                <input class="form-control" v-model="data.prenom" />

                                            </div>
                                        </div> -->


                                        <div class="col-md-3"> <br>
                                            <div class="form-group">
                                                <button @click="Afficher" class="btn btn-primary"> <Icon type="ios-search" /> Rechercher</button>
                                            </div>
                                        </div>




                                    </div>

                                    <div class="row">

                                    </div>

                                     <div class="row" >
                            <div class="col-12" v-if="cache==true">
                                <!-- /.box -->

                                <div class="box">


                                    <div class="box-body">
                                        <div class="table-responsive">
                                            <table id="example" class="table simple mb-0" style="width:100%">
                                                <thead>
                                                    <tr>
                                                        <th></th>
                                                        <th> Matricule </th>
                                                        <th> Nom et Prénom</th>
                                                        <th> Classe </th>
                                                        <th> Date et lieu de naissance </th>


                                                    </tr>
                                                </thead>
                                                <tbody name="fruit-table" is="transition-group">
                                                    <tr v-for="(data,
                                                    i) in ElevesAbsences" :key="i">

                                                    <td>
                                                            <img :src="
                                                                `/Photos/Logos/${data.user.photo}`
                                                            " alt="" width="60" style="width: 30px;" height="40" />
                                                        </td>

                                                        <td>{{data.matricule}}</td>

                                                        <td>

                                                            {{ data.nom }}  {{ data.prenom }}

                                                        </td>




                                                        <td>

                                                            {{ data.classe.libelleClasse }}


                                                        </td>




                                                        <td>

                                                            {{ data.dateNaiss|dateFormat}} à  {{ data.lieuNaiss}}


                                                        </td>

                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <!-- /.box-body -->
                                </div>
                                <!-- /.box -->
                            </div>
                            <!-- /.col -->
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
import MenuSG from "../../navs/MenuSG.vue";
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
    components: { Header, MenuSG, Chats },
    data() {
        return {

            data: {
                cycle1: 1,

            },

             cache : false ,

              ElevesAbsences:'',

              EtabInfos:"",

             data2: {
                nom: '',

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
              this.EtabInfos = JSON.parse(localStorage.getItem("EtabInfos"));

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

        async Afficher() {


            if (this.data.nom == "") {
                return this.e("Mentionner le nom ou le matricule ");
            }


            this.data.EtabInfos = this.EtabInfos

            const response4 = await this.callApi(
                "post",
                "api/caisse/rechercher", this.data
            );

            this.ElevesAbsences = response4.data

            if (this.ElevesAbsences.length != 0 ) {
                this.cache = true
            } else {
                this.e("Aucun élève trouvé  dans le système ");
            }

        },

        SadeData1(data) {

            localStorage.setItem("cycle", JSON.stringify(data));

            this.$router.push('classeSg');

        },

        SadeData2(data) {

            localStorage.setItem("cycle", JSON.stringify(data));

            this.$router.push('classeSg');

        },

        SadeData3(data) {

            localStorage.setItem("cycle", JSON.stringify(data));

            this.$router.push('classeSg');

        },

        SadeData4(data) {

            localStorage.setItem("cycle", JSON.stringify(data));

            this.$router.push('classeSg');

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
