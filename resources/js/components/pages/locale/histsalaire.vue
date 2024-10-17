<template>
    <div>
        <div class="wrapper">
            <Header />
            <MenuLocal />
            <div class="content-wrapper">
                <div class="container-full">
                    <section class="content">
                        <div class="row">
                            <div class="box">
                                <div class="box-header bg-primary" style="text-align: center;">
                                    <h4 class="box-title">
                                        <strong> M./Mme {{ Teacherdata.nom }} {{ Teacherdata.prenom }}</strong>
                                    </h4>
                                </div>

                                <div class="box-footer">
                                    <div class="row">


                                        <div class="table-responsive">
                                            <table id="example" class="table simple mb-0" style="width:100%">
                                                <thead>
                                                    <tr>

                                                        <th>Date de réception </th>
                                                        <th> Somme reçue </th>
                                                        <!-- <th> </th> -->
                                                        <!-- <th> </th> -->
                                                    </tr>
                                                </thead>
                                                <tbody name="fruit-table">
                                                    <tr v-for="(data,
                                                    i) in HistListes" :key="i">
                                                        <td>
                                                            {{ data.created_at | dateFormat }}
                                                        </td>
                                                        <td>
                                                            {{ data.montant }} F

                                                        </td>


                                                        <!-- <td>

                                                            <button @click="RecuPDF(data, i)" type="button"
                                                                class="pull-right btn btn-warning">
                                                                <Icon type="md-print" />
                                                                Reçu
                                                                du paiment
                                                            </button>
                                                        </td> -->

                                                        <td>

                                                            <!-- <button
                                                                @click="delate(data, i)" type="button"
                                                                class="pull-right btn btn-danger">
                                                                <Icon type="md-trash" /> Suppimer ce paiment
                                                            </button> -->
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

                idMois: "",
                montant: "",

            },
            EdetingModal: false,
            showDelateModal: false,
            Teacherdata: "",
            ClassesTeacher: '',
            keyword: "",
            keyword2: "",
            ClasseListes: "",
            HistListes: "",
            EleveListes: "",
            ElevesAbsences: "",
            users: "",
            TotalHeure: 0,
            showRecap: false,
            i: -1,
        };


    },


    async mounted() {

        if (!localStorage.users) {

            this.$router.push('login');
        }


        if (localStorage.EtabInfos) {
            this.EtabInfos = JSON.parse(localStorage.getItem("EtabInfos"));
        }

        if (localStorage.users) {
            this.users = JSON.parse(localStorage.getItem("users"));
        }


        if (localStorage.Teacherdata2) {

            this.Teacherdata = JSON.parse(localStorage.getItem("Teacherdata2"));

            this.data.Teacherdata = this.Teacherdata;

        }

        const response3 = await this.callApi(
            "post",
            "api/locale/getAllHistorique", this.data
        );

        this.HistListes = response3.data;


    },

    methods: {



        async RecuPDF(data, i) {


            window.open("api/locale/getSalaireRecuPdf/" + data.id + '*' + this.Teacherdata.id, '_blank')

            const responsePdf = await this.callApi(
                "get",
                "api/locale/getSalaireRecuPdf/" + data.id + '*' + this.Teacherdata.id

            );


        },

        showDelatingModal(data, i) {
            this.delateItem = data;
            this.i = i;
            this.showDelateModal = true;
        },


    },


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
