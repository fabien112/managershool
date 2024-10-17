<template>
    <div>
        <div class="wrapper">
            <Header />
            <MenuCaisse />
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

                                <Modal v-model="showDelateModal" width="360">
                                    <p slot="header" style="color:#f60;text-align:center">
                                        <span> Suppression </span>
                                    </p>
                                    <div style="text-align:center">
                                        <p>Etes-vous sure de vouloir supprimer ?</p>
                                    </div>
                                    <div slot="footer">
                                        <Button type="error" size="large" long
                                            @click="delatePaiement">Confirmer</Button>
                                    </div>
                                </Modal>


                                <div class="box-footer">
                                    <div class="row">


                                        <div class="table-responsive">
                                            <table id="example" class="table simple mb-0" style="width:100%">
                                                <thead>
                                                    <tr>

                                                        <th> Jour </th>
                                                        <th> Somme reçue </th>
                                                        <th> </th>

                                                    </tr>
                                                </thead>
                                                <tbody name="fruit-table">
                                                    <tr v-for="(data,
                                                    i) in HistListes" :key="i">
                                                        <td>
                                                            {{ data.date | dateFormat }}
                                                        </td>
                                                        <td>
                                                            {{ data.montant }} F

                                                        </td>


                                                        <td>

                                                            <button title=" Iprimer le recu de cette transaction "
                                                                @click="RecuPDF(data, i)" type="button"
                                                                class="btn btn-warning">
                                                                <Icon type="md-print" />

                                                            </button>


                                                            <button title="Supprimer ce paiement "
                                                                @click="showDelatingModal(data, i)" type="button"
                                                                class=" btn btn-danger">
                                                                <Icon type="md-trash" />
                                                            </button>
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

                idMois: "",
                montant: "",

            },

            showDelateModal: false,
            delateItem: {},
            i: -1,
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
            "api/caisse/getAllHistorique2", this.data
        );

        this.HistListes = response3.data;


    },

    methods: {


        showDelatingModal(data, i) {
            this.delateItem = data;
            this.i = i;
            this.showDelateModal = true;
        },

        async delatePaiement() {

            console.log(this.delateItem);
            const response = await axios.post(
                "api/caisse/delatePaiement",
                this.delateItem
            );
            if (response.status === 200) {
                console.log(this.delateItem);
                this.HistListes.splice(this.i, 1);
                this.showDelateModal = false;
                this.s("Paiement supprimée correctement");
            }
            // this.modal2 = false;
        },


        async RecuPDF(data, i) {


            window.open("api/locale/getSalairePersonnelRecuPdf/" + data.id + '*' + this.Teacherdata.id, '_blank')

            const responsePdf = await this.callApi(
                "get",
                "api/locale/getSalairePersonnelRecuPdf/" + data.id + '*' + this.Teacherdata.id

            );


        }


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
