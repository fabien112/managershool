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

                                 <Modal v-model="EdetingModal" title="Modifier  un cahier ">
                            <div class="row">


                                <!-- <div class="col-md-12">
                                    <label class="form-label">
                                        Date
                                    </label>
                                    <input type="date" class="form-control" v-model.trim="
                                        data.date
                                    " />
                                </div> -->


                            </div> <br>
                            <div class="row">
                                <div class="col-md-12">
                                    <label class="form-label"> Durée en heure
                                    </label>
                                    <input type="number" class="form-control" v-model="
                                        data.duree
                                    " />
                                </div>
                            </div>



                            <br />

                            <div slot="footer">
                                <Button type="primary" size="large" long @click="Update()">Enregistrer</Button>
                            </div>
                        </Modal>

                                <Modal v-model="showDelateModal" width="360">
                                <p slot="header" style="color:#f60;text-align:center">
                                    <span> Suppression </span>
                                </p>
                                <div style="text-align:center">
                                    <p>Etes-vous sure de vouloir supprimer ?</p>
                                </div>
                                <div slot="footer">
                                    <Button type="error" size="large" long @click="delatePaiement">Confirmer</Button>
                                </div>
                            </Modal>
                                <div class="box-header bg-primary" style="text-align: center;">
                                    <h4 class="box-title">
                                        <strong> Heure de cours du mois de  M./Mme {{ Teacherdata.nom }} {{ Teacherdata.prenom }}</strong>
                                    </h4>
                                </div>

                                <div class="box-footer">
                                    <div class="row">


                                        <div class="table-responsive">
                                            <table id="example" class="table simple mb-0" style="width:100%">
                                                <thead>
                                                    <tr>

                                                        <th>Date du jour </th>
                                                        <!-- <th> Date automatique </th> -->
                                                        <th> Durée </th>
                                                        <th> Classe </th>
                                                        <th> Matiere  </th>
                                                        <th></th>
                                                    </tr>
                                                </thead>
                                                <tbody name="fruit-table">
                                                    <tr v-for="(data,
                                                    i) in ClasseListes.scolarite.cours" :key="i">


                                                        <!-- <td>
                                                            {{ data.created_at | dateFormat }}
                                                        </td> -->
                                                        <td> {{data.date| dateFormat }}</td>
                                                        <td>
                                                            {{ data.duree }} h

                                                        </td>

                                                         <td>
                                                            {{ data.classe.libelleClasse }}

                                                        </td>

                                                         <td>
                                                            {{ data.matiere.libelle }}

                                                        </td>


                                                        <td>

                                                             <button @click="showEdetingModal(data, i)"
                                                                class=" btn btn-primary">
                                                                <Icon type="md-create" />
                                                            </button>

                                                             <button
                                                                @click="generateSyllabusPdf(data, i)" type="button"
                                                                class="btn btn-warning">
                                                               <Icon type="ios-apps" />
                                                            </button>

                                                            <button
                                                                @click="showDelatingModal(data, i)" type="button"
                                                                class="btn btn-danger">
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

            this.ClasseListes = JSON.parse(localStorage.getItem("Teacherdata2"));


            console.log(this.ClasseListes.scolarite);


        }

        const response3 = await this.callApi(
            "post",
            "api/locale/getAllHistorique", this.data
        );

        this.HistListes = response3.data;


    },

    methods: {

         async delatePaiement() {

            console.log(this.delateItem);
            const response = await axios.post(
                "api/locale/delateBook",
                this.delateItem
            );
            if (response.status === 200) {
                console.log(this.delateItem);
                this.ClasseListes.scolarite.cours.splice(this.i, 1);
                this.showDelateModal = false;
                this.s("Cours  supprimé correctement");
            }
            // this.modal2 = false;
        },

          async Update () {

            //console.log(this.delateItem.duree);

            if (this.data.duree == ""|| this.data.duree < 1) {

                this.e("Le nombre d'heure est incorrect");

            }

            this.data.id = this.delateItem.id

            const response = await axios.post(
                "api/locale/updatecahier",
                this.data
            );

            if (response.status === 200) {
                this.EdetingModal = false;
                this.s("Cahier  modifié correctement");

                  this.$router.push('salaires');

            }



        },


         showEdetingModal(data, i) {



            this.EdetingModal = true
            this.i = i;
            this.delateItem = data;
            this.data.duree = data.duree

        },

         async generateSyllabusPdf(data, i) {

            // // Recuperer tous les infos de cet eleve

            window.open('api/teacher/generateBooktextePdf/' + data.id, '_blank')

            const responsePdf = await this.callApi(
                "get",
                "api/teacher/generateBooktextePdf/" + data.id

            );

        },


         showDelatingModal(data, i) {
            this.delateItem = data;
            this.i = i;
            this.showDelateModal = true;
        },



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
