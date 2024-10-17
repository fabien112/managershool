<template>
    <div>
        <div class="wrapper">
            <Header />
            <MenuLocal />
            <Modal v-model="showDelateModal" width="360">
                <p slot="header" style="color:#f60;text-align:center">
                    <span> Suppression </span>
                </p>
                <div style="text-align:center">
                    <p>Etes-vous sure de vouloir supprimer ?</p>
                </div>
                <div slot="footer">
                    <Button type="error" size="large" long @click="delateParent">Confirmer</Button>
                </div>
            </Modal>

            <div class="content-wrapper" style="min-height: 653px; background-color:#FAFBFD">
                <div class="container-full">
                    <!-- Main content -->
                    <section class="content">
                        <div class="row">
                            <div class="col-12">
                                <div class="box">
                                    <div class="box-header bg-primary">



                                            <span class="pull-right">


                                                {{ rows }}
                                            </span>



                                        <span>
                                            <router-link to="addenseignant">
                                                <button type="button" class="pull-right waves-effect btn  btn-primary mb-5"
                                                    @click="modal6 = true">
                                                    <Icon type="md-person-add" />

                                                    Nouveau
                                                </button>
                                            </router-link>
                                        </span>


                                        <span>

                                                <button type="button" class="pull-right waves-effect btn  btn-primary mb-5"
                                                    @click="SetAllTrust(1)">


                                                    Autoriser tout le monde
                                                </button>

                                        </span>

                                        <span>

                                           <button type="button" class="pull-right waves-effect btn  btn-primary mb-5"
                                               @click="SetAllTrust(0)">


                                              Bloquer tout le monde
                                           </button>

                                   </span>

                                   <span>

<button type="button" class="pull-left waves-effect btn  btn-primary mb-5"
@click="print">
                                            <i class="ti-printer" title="Imprimer en PDF la liste des enseignants "></i>
                                            Liste des enseignants en PDF
</button>

</span>


                                    </div>
                                    <div class="box-body">
                                        <div class="table-responsive">
                                            <table id="example" class="table simple mb-0" style="width:100%">
                                                <thead>
                                                    <tr>
                                                        <!-- <th>Id</th> -->
                                                        <th>Noms</th>
                                                        <th>Téléphone</th>
                                                        <th>Matricule</th>
                                                        <!-- <th> Genre</th> -->

                                                        <!-- <th> Secteur</th> -->
                                                        <th>Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr v-for="(data,
                                                        i) in Enseignants" :key="i">
                                                        <!-- <td>{{ data.id }}</td> -->
                                                        <td>
                                                            <span  v-if="data.state==1" style="font-size:25px;color:green">  <Icon type="md-checkmark-circle" /> </span>

                                                            <span  v-else  style="font-size:25px;color:red"> <Icon type="md-close-circle" /> </span>


                                                            {{ data.nom }} {{ data.prenom }}

                                                        </td>

                                                        <td>{{ data.tel }}</td>
                                                        <td>
                                                            {{ data.matricule }}
                                                        </td>
                                                        <!-- <td>
                                                            {{ data.sexe }}
                                                        </td> -->



                                                        <!-- <td>

                                                            <span class="btn btn-primary btn-xs" v-if="data.statut == 1">
                                                                Permanent
                                                            </span>

                                                            <span v-else class="btn btn-warning btn-xs">
                                                                Vacataire
                                                            </span>

                                                        </td> -->

                                                        <!-- <td>

                                                            <span class="btn btn-info btn-xs"
                                                                v-if="data.email == 'teacher@gmailcom'">
                                                                INDUSTRIEL
                                                            </span>

                                                            <span v-if="data.email == 'ttsteacher@gmail.com'"
                                                                class="btn btn-danger btn-xs">
                                                                TTS
                                                            </span>


                                                            <span v-if="data.email == 'genteacher@gmail.com'"
                                                                class="btn btn-dark btn-xs">
                                                                GENERAL
                                                            </span>



                                                        </td> -->



                                                        <td>


                                                            <button

                                                            v-if="data.state==0"

                                                            @click="
                                                                showTrust(
                                                                    data,
                                                                   1
                                                                )
                                                                " class="btn btn-primary btn-xs" title="Autorisation">
                                                               Autoriser
                                                            </button>

                                                            <button

                                                            v-if="data.state==1"

                                                            @click="
                                                                showTrust(
                                                                    data,
                                                                    0
                                                                )
                                                                " class="btn btn-dark btn-xs" title="Autorisation">
                                                                Bloquer
                                                            </button>







                                                            <router-link to="classeofTeacher">
                                                                <button @click="
                                                                    Voir(
                                                                        data,
                                                                        i
                                                                    )
                                                                    " class="btn btn-success btn-xs"
                                                                    title="Voir les classes de cet enseignant">
                                                                    <i title="CLASSES et MATIERES "
                                                                        class="fa-solid fa-circle-info"></i>
                                                                </button>
                                                            </router-link>

                                                            <router-link to="editTeacher">
                                                                <button @click="
                                                                    Voir(
                                                                        data,
                                                                        i
                                                                    )
                                                                    " class="btn btn-primary btn-xs" title="Modifier">
                                                                    <i class="ti-pencil"></i>
                                                                </button>
                                                            </router-link>



                                                            <button @click="
                                                                showDelatingModal(
                                                                    data,
                                                                    i
                                                                )
                                                                " class="btn btn-danger btn-xs" title="Supprimer">
                                                                <i class="ti-trash"></i>
                                                            </button>




                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>


                                </div>
                            </div>

                            <!-- /.col -->
                        </div>

                        <!-- <b-pagination :total-rows="rows" @change="handlePageChange" size="lg" v-model="currentPage"
                            align="center" :per-page="10" :current-page="currentPage">
                        </b-pagination> -->
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
            EtabInfos: "",
            total: 6,
            data: {},
            rows: 0,
            currentPage: 0,
            datas2: [],
            datas3: {
                'state':""
            },


            showDelateModal: false,
            i: -1,
            datas: [],
            classeItem: "",
            Enseignants: [],
            pageInfo: ""
        };
    },

    methods: {


        async SetAllTrust(data) {

            console.log(data)

            this.datas3.state = data



const response = await this.callApi(
    "post",
    "api/locale/getpermissionAll" ,
    this.datas3
);

this.getAll()
},


        async showTrust(data,state) {


            data.state = state

            const response = await this.callApi(
                "post",
                "api/locale/getpermission" ,
                data
            );

           this.getAll()
        },

        async print() {
            // // Recuperer tous les infos de cet eleve

            window.open("api/locale/generateListeProf/", "_blank");

            const responsePdf = await this.callApi(
                "get",
                "api/locale/generateListeProf/"
            );
        },



        async generateficheNotePdf(data, i) {
            // // Recuperer tous les infos de cet eleve

            window.open("api/locale/generateficheNotePdf/" + data.id, "_blank");

            const responsePdf = await this.callApi(
                "get",
                "api/locale/generateficheNotePdf/" + data.id
            );
        },


        handlePageChange(value) {

            this.data.currentPage = value - 1

            console.log(value)

            this.getAll()
        },
        async getAll() {
            this.$Spin.show();

            const res = await this.callApi(
                "post",
                "api/locale/getAllEnseignant",
                this.data
            );

            if (res.status == 200) {
                this.$Spin.hide();
            }

            this.Enseignants = res.data.contentSimple;

            this.rows = res.data.totalPages







            this.pageInfo = res.data;
        },

        showDelatingModal(data, i) {
            this.delateItem = data;
            this.i = i;
            this.showDelateModal = true;
        },

        async delateParent() {
            console.log(this.delateItem);
            const response = await axios.post(
                "api/locale/delateTeacher",
                this.delateItem
            );
            if (response.status === 200) {
                this.Enseignants.splice(this.i, 1);
                this.showDelateModal = false;
                this.s("Enseignant supprimé correctement");
            }
            // this.modal2 = false;
        },

        Voir(data, i) {
            localStorage.setItem("Teacherdata", JSON.stringify(data));
        },

        Payer(data, i) {
            localStorage.setItem("Teacherdata", JSON.stringify(data));
        }
    },

    async mounted() {
        if (!localStorage.users) {
            this.$router.push("login");
        }

        // Recuperer toutes les infos de cette ecole dans le storage

        if (localStorage.EtabInfos) {
            this.EtabInfos = JSON.parse(localStorage.getItem("EtabInfos"));
        }

        // Recuperer toutes les enseigants de cette  ecole

        // Je rajoute les  information de l'ecole appartenant a l'utulisateur qui s'est logger a ma data qui ira dans l'api de creation de la session

        this.data.EcoleInfos = this.EtabInfos;

        this.data.currentPage = this.currentPage;



        this.getAll();
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
