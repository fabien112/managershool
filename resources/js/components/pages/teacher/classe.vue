<template>
    <div>
        <div class="wrapper">
            <HeaderTeacher />
            <MenuTeacher />
            <div class="content-wrapper">
                <div class="container-full">
                    <section class="content">
                        <div type="light" closable class="card">
                            <div class="card-header">
                                <h4 class="card-title"> LISTE DES CLASSES </h4>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-4 col-12" v-for="(data, i) in ClassesTeacher" :key="i">
                                <div class="box">
                                    <div class="box-header bg-primary " style="text-align: center;">
                                        <h4 class="box-title">
                                            <strong>
                                                {{ data.libelleClasse }}
                                            </strong>
                                        </h4>
                                    </div>

                                    <div class="box-body">
                                        <div class="table-responsive">
                                            <table class="table simple mb-0">
                                                <tbody>
                                                    <tr>
                                                        <td>Total</td>
                                                        <td class="text-right font-weight-700">
                                                            $3240
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Coupan Discount</td>
                                                        <td class="text-right font-weight-700">
                                                            <span class="text-danger mr-15">50%</span>-$1620
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            Delivery Charges
                                                        </td>
                                                        <td class="text-right font-weight-700">
                                                            $50
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Tax</td>
                                                        <td class="text-right font-weight-700">
                                                            $18
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th class="bt-1">
                                                            Payable Amount
                                                        </th>
                                                        <th class="bt-1 text-right font-weight-900 font-size-18">
                                                            $1688
                                                        </th>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="box-footer">
                                        <button class="btn btn-danger btn-sm">
                                            Liste de la classe
                                        </button>
                                        <button class="btn btn-primary pull-right btn-sm">
                                            Emploi du temps
                                        </button>
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
import MenuTeacher from "../../navs/MenuTeacher.vue";
import Chats from "../../navs/Chats.vue";
import { mapState } from "vuex";
import HeaderTeacher from "../../headers/HeaderTeacher.vue";

export default {
    components: { MenuTeacher, Chats, HeaderTeacher },
    data() {
        return {
            ClassesTeacher: [],
            users: []
        };
    },

    async mounted() {
        // Recuperer les donnes de cet utulisateurs dans la storage local

        if (localStorage.users) {
            this.users = JSON.parse(localStorage.getItem("users"));
        }

        // Allons chercher la session et le code etablissement ce cet enseigant

        const response = await this.callApi(
            "post",
            "api/teacher/getAcllasseTeacher",
            this.users
        );

        this.ClassesTeacher = response.data;

        console.log(this.ClassesTeacher);

        // Garder les donnees de l'enseigant  dans le storage de navigateur
    }
};
</script>
