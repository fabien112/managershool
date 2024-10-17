<template>
    <div>
        <div class="wrapper">
            <Header />
            <MenuCaisse />
            <div class="content-wrapper">
                <div class="container-full">
                    <section class="content">
                        <!-- START Card With Image -->
                        <!-- <div class="card">
                            <div class="card-header">
                                <h4 class="card-title"> LISTING DES PAIEMENTS </h4>
                            </div>
                        </div> -->

                        <div class="row">

                            <div class="col-md-4">
                                <div class="box">
                                    <div class="box-header "
                                        style="text-align: center;color:white;background-color:rgb(43, 160, 196)">
                                        <p>
                                            <strong>
                                                INSCRIPTION
                                            </strong>
                                        </p>
                                    </div>
                                    <div class="box-body">
                                        <div class="table-responsive">
                                            <table class="table simple mb-0">
                                                <tbody>
                                                    <tr>
                                                        <td>

                                                            Totale
                                                            à
                                                            payer
                                                        </td>
                                                        <td class=" font-weight-700 font-Size-10">

                                                            {{ parentEleveInfos.classe.scolariteaff_Classe }}

                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>

                                                            Déja
                                                            payé
                                                        </td>
                                                        <td class="font-weight-700 font-Size-10">

                                                            {{ DaitlsFinancesEleve.ape }}

                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="color: red;">
                                                            Restant
                                                        </td>
                                                        <td style="color: red;" class="font-weight-700 font-Size-10">

                                                            {{ parentEleveInfos.classe.scolariteaff_Classe -
                                                                    DaitlsFinancesEleve.ape
                                                            }}



                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="box">
                                    <div class="box-header bg-success" style="text-align: center;">
                                        <p>
                                            <strong>
                                                TRANCHE 1
                                            </strong>
                                        </p>
                                    </div>
                                    <div class="box-body">
                                        <div class="table-responsive">
                                            <table class="table simple mb-0">
                                                <tbody>
                                                    <tr>
                                                        <td>

                                                            Totale
                                                            à
                                                            payer

                                                        </td>
                                                        <td class=" font-weight-700 font-Size-10">

                                                            {{ parentEleveInfos.classe.scolarite_Classe }}


                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            Déja
                                                            payé
                                                        </td>
                                                        <td class="font-weight-700 font-Size-10">

                                                            {{ DaitlsFinancesEleve.tranche1 }}

                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="color: red;">

                                                            Restant
                                                        </td>
                                                        <td style="color: red;" class="font-weight-700 font-Size-10">

                                                            {{ parentEleveInfos.classe.scolarite_Classe -
                                                                    DaitlsFinancesEleve.tranche1
                                                            }}


                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="box">
                                    <div class="box-header bg-primary " style="text-align: center;">
                                        <p>
                                            <strong>
                                                TRANCHE 2
                                            </strong>
                                        </p>
                                    </div>
                                    <div class="box-body">
                                        <div class="table-responsive">
                                            <table class="table simple mb-0">
                                                <tbody>
                                                    <tr>
                                                        <td>
                                                            Totale
                                                            à
                                                            payer
                                                        </td>
                                                        <td class=" font-weight-700 font-Size-10">

                                                            {{ parentEleveInfos.classe.inscription_Classe }}

                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            Déja
                                                            payé
                                                        </td>
                                                        <td class="font-weight-700 font-Size-10">

                                                            {{ DaitlsFinancesEleve.tranche2 }}


                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="color: red;">
                                                            Restant
                                                        </td>
                                                        <td style="color: red;" class="font-weight-700 font-Size-10">

                                                            {{ parentEleveInfos.classe.inscription_Classe -
                                                                    DaitlsFinancesEleve.tranche2
                                                            }}


                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
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
import MenuCaisse from "../../navs/MenuCaisse.vue";
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
    components: { Header, MenuCaisse, Chats },
    data() {
        return {
            data: {
                idClasse: ""
            },

            parentEleveInfos: '',

            DaitlsFinancesEleve: ''
        };
    },

    async mounted() {

        if (!localStorage.users) {

            this.$router.push('login');
        }

        if (localStorage.EtabInfos) {
            this.EtabInfos = JSON.parse(localStorage.getItem("EtabInfos"));
        }

        if (localStorage.Elevefi) {

            this.parentEleveInfos = JSON.parse(

                localStorage.getItem("Elevefi")

            );

            const response4 = await this.callApi(
                "post",
                "api/locale/getAstudentDatailsFinancesInfos",
                this.parentEleveInfos
            );

            this.DaitlsFinancesEleve = response4.data;

        }



        const response2 = await this.callApi(
            "post",
            "api/locale/getClasseEtablissement",
            this.EtabInfos
        );

        this.ClasseListes = response2.data;
    },

    methods: {



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
