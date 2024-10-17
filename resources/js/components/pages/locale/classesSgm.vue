<template>
    <div>
        <div class="wrapper">
            <Header />
            <MenuLocal />

            <div class="content-wrapper" style="min-height: 653px; background-color:#FAFBFD">
                <div class="container-full">
                    <!-- Main content -->
                    <section class="content">

                        <Modal v-model="modal7" title=" Modifier une affectation   ">
                            <label for="">
                                Sélectionner un surveillant et
                                valider
                            </label>

                            <select class="custom-select form-control required" v-model="data.prof">
                                <option v-for="(data,
                                i) in Enseignants" :key="i" :value="data.id">

                                    {{ data.nom }} {{ data.prenom }}


                                </option>
                            </select>

                            <div slot="footer">
                                <Button @click="Affecttation2" type="primary" size="large">
                                    Valider
                                </Button>
                            </div>
                        </Modal>


                        <Modal v-model="modal6" title=" Affecter une classe a un surveillant  ">
                            <label for="">
                                Sélectionner un surveillant et
                                valider
                            </label>

                            <select class="custom-select form-control required" v-model="data.prof">
                                <option v-for="(data,
                                i) in Enseignants" :key="i" :value="data.id">

                                    {{ data.nom }} {{ data.prenom }}


                                </option>
                            </select>

                            <div slot="footer">
                                <Button @click="Affecttation" type="primary" size="large">
                                    Valider
                                </Button>
                            </div>
                        </Modal>



                        <!-- Modol pour supprimer la classe  -->

                        <Modal v-model="showDelateModal" width="360">
                            <p slot="header" style="color:#f60;text-align:center">
                                <span> Suppression </span>
                            </p>
                            <div style="text-align:center">
                                <p>Etes-vous sure de vouloir supprimer ?</p>
                            </div>
                            <div slot="footer">
                                <Button type="error" size="large" long @click="delateClasse">Confirmer</Button>
                            </div>
                        </Modal>

                        <div class="row">
                            <div class="col-12">
                                <!-- /.box -->

                                <div class="box">
                                    <div class="box-header bg-primary">
                                        <h4 class="box-title" style="margin:auto">

                                            Classes et surveillants

                                        </h4>

                                        <!-- <span>
                                            <button type="button" class=" pull-right btn btn-primary "
                                                @click="ShowmodalAddClasse">
                                                <Icon type="md-add" />

                                                Nouvelle classe
                                            </button>

                                            <router-link to="inscriptionEleve">

                                            <button type="button"
                                                class="waves-effect btn  btn-primary mb-5  pull-center ">

                                                <Icon type="md-add" /> Nouveau élève

                                            </button>

                                        </router-link>
                                        </span> -->


                                    </div>


                                    <!-- /.box-header -->
                                    <div class="box-body">
                                        <div class="table-responsive">
                                            <table id="example" class="table simple mb-0" style="width:100%">
                                                <thead>
                                                    <tr>
                                                        <!-- <th>Id</th> -->
                                                        <th>Classes</th>
                                                        <th>Effectifs</th>
                                                        <th> Disponiblité </th>
                                                        <th> Actions </th>

                                                    </tr>
                                                </thead>
                                                <tbody name="fruit-table" is="transition-group">
                                                    <tr v-for="(data,
                                                    i) in datas" :key="i">
                                                        <!-- <td>
                                                            {{
                                                                    data.id
                                                            }}
                                                        </td> -->
                                                        <td>
                                                            {{
                                                                    data.libelleClasse
                                                            }}
                                                        </td>

                                                        <td>
                                                            <span class="btn btn-xs"
                                                                style="background-color:rgba(105, 21, 98, 0.829);color:white"
                                                                title="Ajouter une matiere ">
                                                                {{
                                                                        data.eleves
                                                                            .length
                                                                }}
                                                            </span>
                                                        </td>


                                                        <td>
                                                            <p  class="btn btn-xs" style="background-color:#FD4217;color:white" v-if="data.sectionClasse == 0"> {{data.surveillant}} </p>
                                                            <p class="btn btn-xs" style="background-color:#1f2429;color:white"  v-if="data.sectionClasse == 1"> {{data.surveillant.nom}} {{data.surveillant.prenom}} </p>
                                                        </td>

                                                        <td>
                                                            <button @click="
                                                                Affecter(
                                                                    data,
                                                                    i
                                                                )
                                                            "
                                                                v-if="data.sectionClasse == 0" class="btn btn-primary">
                                                                <Icon type="ios-construct" /> Affecter </button>
                                                            <button  @click="
                                                                Affecter2(
                                                                    data,
                                                                    i
                                                                )
                                                            " v-if="data.sectionClasse == 1" class="btn btn-danger">
                                                               <Icon type="ios-construct" />  Changer  </button>
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
                        <!-- /.row -->
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
            UserData: [],
            BtnDisabled: "",
            EtabInfos: "",
            cycle: '',
            Modal: false,
            modal6: false,
            modal7: false,
            modalAddClasse: false,
            modalUpadteClasse: false,
            data: {
                sigleClasse: "",
                MontantScol: "",
                FraisInscrip: "",
                MontantScolAffect: "",
                imageEmploiTmp: "",
                libelleClasse: ''

            },


            dataRefresh: {

                libelleClasse: "",
                FraisInscrip: "",
                MontantScolAffect: "",
                imageEmploiTmp: "",
                idClasse: "",
                newImage: ""

            },
            showDelateModal: false,
            delateItem: {},
            i: -1,
            datas: [],
            classeItem: "",
            classeId: "",
            visible: false,
            uploadList: [],

        };
    },

    methods: {


        Affecter(data, i) {

            this.modal6 = true;

            this.ItemMatiere = data;
        },

         Affecter2(data, i) {

            this.modal7 = true;

            this.ItemMatiere = data;
        },

        showUpdatingModal(data, i) {

            this.delateItem = data;
            this.modalUpadteClasse = true
            this.dataRefresh.scolariteaff_Classe = data.scolariteaff_Classe
            this.dataRefresh.scolarite_Classe = data.scolarite_Classe
            this.dataRefresh.inscription_Classe = data.inscription_Classe
            this.dataRefresh.libelleClasse = data.libelleClasse
            this.dataRefresh.imageEmploiTmp = data.emp_Classe


        },

        async Affecttation2() {


            // Affecter une matiere a un professeur , ItemMatiere  contient les infos de la matiere

            if (this.data.prof == "") {
                return this.e("Sélectionner un SG  ");
            } else {


                // Ajouter lid du prof  choisi aux donnes de la  matiere

                this.ItemMatiere.Surveillant = this.data.prof

                const response = await this.callApi(
                    "post",
                    "/api/locale/affecterSurveillant2",
                    this.ItemMatiere
                );
                if (response.status == 200) {
                    this.s("SG affecté correctement");
                    this.modal7 = false;
                    this.prof = ''
                      const response2 = await this.callApi(
            "post",
            "api/locale/getClasseEtablissementSurveillant",
            this.EtabInfos
        );

        this.datas = response2.data;


                } else {
                    this.e("Une erreure est survenue");
                }
            }
        },

        async Affecttation() {


            // Affecter une matiere a un professeur , ItemMatiere  contient les infos de la matiere

            if (this.data.prof == "") {
                return this.e("Sélectionner un SG  ");
            } else {


                // Ajouter lid du prof  choisi aux donnes de la  matiere

                this.ItemMatiere.Surveillant = this.data.prof

                const response = await this.callApi(
                    "post",
                    "/api/locale/affecterSurveillant",
                    this.ItemMatiere
                );
                if (response.status == 200) {
                    this.s("SG affecté correctement");
                    this.modal6 = false;
                    this.prof = ''
                      const response2 = await this.callApi(
            "post",
            "api/locale/getClasseEtablissementSurveillant",
            this.EtabInfos
        );

        this.datas = response2.data;


                } else {
                    this.e("Une erreure est survenue");
                }
            }
        }

    },

    async created() {
        // Recuperer toutes les infos de cette ecole dans le storage



        if (!localStorage.users) {

            this.$router.push('login');
        }

        if (localStorage.EtabInfos) {
            this.EtabInfos = JSON.parse(localStorage.getItem("EtabInfos"));
        }

        if (localStorage.cycle) {
            this.cycle = JSON.parse(localStorage.getItem("cycle"));
            this.EtabInfos[0].cycle = this.cycle;
        }

        // Recuperer toutes les sessions de cette ecole

         const res = await this.callApi(
            "post",
            "api/locale/getAllSurveillant",
            this.EtabInfos
        );

        this.Enseignants = res.data;

        this.EtabInfos.users = this.users;

        const response2 = await this.callApi(
            "post",
            "api/locale/getClasseEtablissementSurveillant",
            this.EtabInfos
        );

        this.datas = response2.data;

        this.datas =  this.datas.filter(item => item.eleves.length > 0 )


        //console.log(this.datas);
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
