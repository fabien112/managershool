<template>
    <div>
        <div class="wrapper">
            <Header />
            <MenuSG />

            <Modal v-model="modalUpadteClasse" title="Consigne en ou exclusion ">

                <div class="row">
                    <div class="col-md-12">
                        <label class="form-label">Selectionner la cension
                        </label>
                        <select class="custom-select form-control required" v-model="data2.mode">

                            <option value="ex">Exclusion</option>
                            <option value="con">Consigne</option>
                        </select>
                    </div>
                </div>

                  <br />


                <div class="row">
                    <div class="col-md-12">

                          <label class="form-label">Saisir le nombre de jour ou d'heure
                        </label>

                        <input type="number" placeholder="" class="form-control" v-model.trim="
                            data2.montant
                        " />
                    </div>
                </div>


                <div class="row">
                    <div class="col-md-12">

                         <label class="form-label">Motif de  la cension </label>

                        <input type="text"  class="form-control" v-model.trim="
                            data2.motif
                        " />
                    </div>
                </div>



                <br />

                <div slot="footer">
                    <Button type="primary" size="large" long @click="Submit()">Enregistrer</Button>
                </div>
            </Modal>




            <div class="content-wrapper" style="min-height: 653px; background-color:#FAFBFD">
                <div class="container-full">
                    <!-- Main content -->

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

                    <section class="content">
                        <div class="row">
                            <div class="col-12 ">
                                <div class="box">
                                    <div class="box-header bg-primary">
                                        <h4 class="box-title" style="margin:auto">
                                            <strong>{{
                                                    data.classeId.libelleClasse
                                            }}
                                            </strong>
                                        </h4>




                                        <!--
                                        <button @click="generateAllPdf" type="button"
                                            class="waves-effect btn  btn-primary mb-5  pull-center ">

                                            <Icon type="md-print" /> Toutes les CIS

                                        </button>


                                        <router-link to="inscriptionEleve">

                                            <button type="button"
                                                class="waves-effect btn  btn-primary mb-5  pull-center ">

                                                <Icon type="md-add" /> Nouveau élève

                                            </button>

                                        </router-link>



                                        <button @click="generatePdf" type="button"
                                            class="waves-effect btn  btn-primary mb-5  pull-right ">

                                            <i class="ti-printer"></i> Liste de la classe

                                        </button> -->

                                        <!-- </a> -->


                                    </div>

                                    <div class="box-body">
                                        <div class="table-responsive">
                                            <table class="table product-overview">
                                                <thead>
                                                    <tr>
                                                        <th></th>
                                                        <th> Elève </th>
                                                        <!-- <th>Matricule</th> -->
                                                        <th> Parent </th>

                                                        <th> Téléphone du parent </th>

                                                        <th> </th>


                                                        <!-- <th>Profession </th> -->
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr v-for="(data,
                                                    i) in classeListe" :key="i">
                                                        <td>
                                                            <img :src="
                                                                `/Photos/Logos/${data.user.photo}`
                                                            " alt="" width="30" height="30" />
                                                        </td>


                                                        <td class="font-weight-900">
                                                            <h5>
                                                                {{ data.nom }}
                                                                {{
                                                                        data.prenom
                                                                }}
                                                            </h5>
                                                        </td>

                                                        <!-- <td> {{data.matricule}}</td> -->
                                                        <td>
                                                            <h5>
                                                                {{ data.parent.nomParent }}
                                                                {{ data.parent.prenomParent }}

                                                            </h5>
                                                        </td>
                                                        <td> {{ data.parent.telParent }}</td>

                                                        <td>


                                                            <button class="btn btn-danger"
                                                                @click="showUpdatingModal(data, i)">
                                                                <Icon type="md-add" />
                                                            </button>

                                                             <button class="btn btn-primary"
                                                                @click="showDetails(data, i)">
                                                             <Icon type="ios-menu" />
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

                    <!-- /.content -->
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
import VueHtml2pdf from "vue-html2pdf";
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
    components: { Header, MenuSG, Chats, VueHtml2pdf },
    data() {
        return {
            data: {

                classeId:"",

            },

            data2: {
                eleveId: "",
                mode:"",
                montant:"",
                motif:""
            },

            showDelateModal: false,
            delateItem: {},
            i: -1,
            classeListe: [],
            EtabInfos: [],
            parentEleveInfos: [],
            modalUpadteClasse: false,

        };
    },

    methods: {


        showUpdatingModal(data, i) {

            this.delateItem = data;

            this.modalUpadteClasse = true


        },

        async Submit() {


            this.data2.eleveId= this.delateItem
            const response = await axios.post(
                "api/locale/addSencion",
                this.data2
            );
            if (response.status === 200) {

                this.modalUpadteClasse = false;
                this.s("Cension ajoutée correctement");
            }
            // this.modal2 = false;
        },

        async delatePaiement() {

            console.log(this.delateItem);
            const response = await axios.post(
                "api/locale/delateEleve",
                this.delateItem
            );
            if (response.status === 200) {
                console.log(this.delateItem);
                this.classeListe.splice(this.i, 1);
                this.showDelateModal = false;
                this.s("Elève supprimée correctement");
            }
            // this.modal2 = false;
        },


        async generateCniPdf(data, i) {

            // // Recuperer tous les infos de cet eleve

            window.open('api/locale/getEleveCniPdf/' + data.id, '_blank')

            const responsePdf = await this.callApi(
                "get",
                "api/locale/getEleveCniPdf/" + data.id

            );

        },

        showDelatingModal(data, i) {
            this.delateItem = data.id;
            this.i = i;
            this.showDelateModal = true;
        },


        async generatePdf() {

            if (localStorage.classeId) {

                this.data.classeId = JSON.parse(localStorage.getItem("classeId"));
            }

            // console.log(this.data.classeId);

            // Recuperer tous les eleves de cette classe

            window.open('api/locale/getEleveclassePdf/' + this.data.classeId.id + '*' + this.data.classeId.codeEtabClasse, '_blank')

            const responsePdf = await this.callApi(
                "get",
                "api/locale/getEleveclassePdf/" + this.data.classeId.id + '*' + this.data.classeId.codeEtabClasse


            );


        },

        async generateAllPdf() {





            if (localStorage.classeId) {

                this.data.classeId = JSON.parse(localStorage.getItem("classeId"));
            }

            window.open('api/locale/index2/' + this.data.classeId.id + '*' + this.data.classeId.codeEtabClasse, '_blank')
            const response2 = await this.callApi(
                "get",
                "api/locale/index2" + this.data.classeId.id + '*' + this.data.classeId.codeEtabClasse

            );


            // Recuperer tous les eleves de cette classe

            //   window.open('api/locale/getAllCniPdf/'+this.data.classeId.id+'*'+this.data.classeId.codeEtabClasse,'_blank')

            //      const responsePdf = await this.callApi(
            //     "get",
            //     "api/locale/getAllCniPdf/"+this.data.classeId.id+'*'+this.data.classeId.codeEtabClasse


            // );


        },

        showDetails(data, i) {
            localStorage.setItem("idEleveDiscipline", JSON.stringify(data.id));
             this.$router.push('disciplineSg');
        },

        ParentEleve(data, i) {
            localStorage.setItem("parentEleveInfos", JSON.stringify(data));
        }
    },

    async mounted() {
        // Recuperer les infos de cette classe  dans le storage. classdId  contient toutes les classes et leur eleves respectivement
        if (!localStorage.users) {

            this.$router.push('login');
        }
        if (localStorage.classeId) {
            this.data.classeId = JSON.parse(localStorage.getItem("classeId"));
        }

        // Recuperer tous les eleves de cette classe

        const response2 = await this.callApi(
            "post",
            "api/locale/getEleveclasse",
            this.data
        );

        this.classeListe = response2.data;

        // console.log(this.classeListe);
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
