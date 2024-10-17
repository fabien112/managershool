<template>
    <div>
        <div class="wrapper">
            <Header />
            <MenuSG />

            <div class="content-wrapper" style="min-height: 653px; background-color:#FAFBFD">
                <div class="container-full">
                    <!-- Main content -->
                    <section class="content">

                        <!-- Modal pour modifier  une classe -->

                        <Modal v-model="modal7" title="Modifier  une classe ">
                            <div class="row">
                                <div class="col-md-12">
                                    <label class="form-label"> Nom de la classe
                                    </label>
                                    <input type="text" class="form-control" v-model="data.libelleClasse" />
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <label class="form-label">
                                        Montant de l'inscription
                                    </label>
                                    <input type="number" class="form-control" />
                                </div>
                            </div>


                            <div class="row">
                                <div class="col-md-12">
                                    <label class="form-label">
                                        Montant de la première tranche
                                    </label>
                                    <input type="number" class="form-control" />
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <label class="form-label"> Montant de la deuxième tranche </label>
                                    <input type="number" class="form-control" />
                                </div>
                            </div>


                            <br />


                            <div slot="footer">
                                <Button type="primary" size="large" long @click="Update()">Enregistrer</Button>
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

                                        Classes

                                        </h4>



                                    </div>

                                    <!-- Modal pour ajouter une classe -->

                                    <Modal v-model="modalAddClasse" title="Ajouter une classe ">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label class="form-label"> Nom de la classe
                                                </label>
                                                <input type="text" class="form-control" v-model.trim="
                                                    data.sigleClasse
                                                " />
                                            </div>
                                        </div>


                                        <div class="row">
                                            <div class="col-md-12">
                                                <label class="form-label">
                                                    Montant de l'inscription
                                                </label>
                                                <input type="number" class="form-control" v-model.trim="
                                                    data.MontantScolAffect
                                                " />
                                            </div>
                                        </div>


                                        <div class="row">
                                            <div class="col-md-12">
                                                <label class="form-label">
                                                    Montant de la première tranche
                                                </label>
                                                <input type="number" class="form-control" v-model.trim="
                                                    data.MontantScol
                                                " />
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-12">
                                                <label class="form-label"> Montant de la deuxième tranche </label>
                                                <input type="number" class="form-control" v-model.trim="
                                                    data.FraisInscrip
                                                " />
                                            </div>
                                        </div>


                                        <br />
                                        <Upload multiple type="drag" action="api/admin/upload"
                                            :on-success="handleSuccess" :on-error="handleError"
                                            :format="['jpg', 'jpeg', 'png', 'pdf', 'doc', 'docx']" :max-size="2048"
                                            :on-format-error="handleFormatError" :on-exceeded-size="handleMaxSize"
                                            :headers="{
                                                'X-Requested-With':
                                                    'XMLHttpRequest'
                                            }">
                                            <div style="padding: 20px 0">
                                                <Icon type="ios-cloud-upload" size="52" style="color: #3399ff"></Icon>
                                                <p class="text-center">
                                                    Cliquer ou glisser déposer pour insérer l'emploi du
                                                    temps de la classe

                                                </p>
                                            </div>
                                        </Upload>

                                        <div slot="footer">
                                            <Button type="primary" size="large" long
                                                @click="Submit()">Enregistrer</Button>
                                        </div>
                                    </Modal>


                                    <Modal v-model="modalUpadteClasse" title="Modifier  une classe ">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label class="form-label"> Nom de la classe
                                                </label>
                                                <input type="text" class="form-control" v-model.trim="
                                                    data.sigleClasse
                                                " />
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-12">
                                                <label class="form-label">
                                                    Montant de la première tranche
                                                </label>
                                                <input type="number" class="form-control" v-model.trim="
                                                    data.MontantScol
                                                " />
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-12">
                                                <label class="form-label"> Montant de la deuxième tranche </label>
                                                <input type="number" class="form-control" v-model.trim="
                                                    data.FraisInscrip
                                                " />
                                            </div>
                                        </div>



                                        <div class="row">
                                            <div class="col-md-12">
                                                <label class="form-label">
                                                    Montant de l'APE ou de la troisième tranche
                                                </label>
                                                <input type="number" class="form-control" v-model.trim="
                                                    data.MontantScolAffect
                                                " />
                                            </div>
                                        </div>



                                        <br />
                                        <Upload multiple type="drag" action="api/admin/upload"
                                            :on-success="handleSuccess" :on-error="handleError"
                                            :format="['jpg', 'jpeg', 'png', 'pdf', 'doc', 'docx']" :max-size="2048"
                                            :on-format-error="handleFormatError" :on-exceeded-size="handleMaxSize"
                                            :headers="{
                                                'X-Requested-With':
                                                    'XMLHttpRequest'
                                            }">
                                            <div style="padding: 20px 0">
                                                <Icon type="ios-cloud-upload" size="52" style="color: #3399ff"></Icon>
                                                <p class="text-center">
                                                    Cliquer ou glisser déposer pour insérer l'emploi du
                                                    temps de la classe

                                                </p>
                                            </div>
                                        </Upload>

                                        <div slot="footer">
                                            <Button type="primary" size="large" long
                                                @click="Submit()">Enregistrer</Button>
                                        </div>
                                    </Modal>

                                    <!-- /.box-header -->

                                    <div class="box-body">
                                        <div class="table-responsive">
                                            <table id="example" class="table simple mb-0" style="width:100%">
                                                <thead>
                                                    <tr>

                                                        <th>Classes</th>
                                                        <th>Effectifs</th>
                                                        <th></th>
                                                    </tr>
                                                </thead>
                                                <tbody name="fruit-table" is="transition-group">
                                                    <tr v-for="(data,
                                                    i) in datas" :key="i">

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


                                                            <router-link to="listeEleveSg">
                                                                <button class="btn btn-sm btn-primary"


                                                                    title="Liste des eleves de cette classe ">
                                                                    <Icon type="ios-menu"  @click="
                                                                        ListeEleve(
                                                                            data,
                                                                            i
                                                                        )
                                                                    " />

                                                                </button>
                                                            </router-link>
                                                            <!-- <span @click="showUpdatingModal(data)" class="btn btn-xs"
                                                                style="background-color:rgb(18, 114, 240);color:white"
                                                                title="Modifier la classe">
                                                                <i class="ti-pencil"></i>
                                                            </span>
                                                            <span @click="showDelatingModal(data, i)" class="btn btn-xs"
                                                                style="background-color:red;color:white"
                                                                title="Supprimer">
                                                                <i class="ti-trash"></i>
                                                            </span> -->
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


            // dataRefresh: {

            //     sigleClasse: "",
            //     MontantScol: "",
            //     FraisInscrip: "",
            //     MontantScolAffect: "",
            //     imageEmploiTmp: "",

            // },
            showDelateModal: false,
            delateItem: {},
            i: -1,
            datas: [],
            classeItem: "",
            classeId: "",
            visible: false,
            uploadList: [],
            users:""

        };
    },

    methods: {

        ShowmodalAddClasse() {

            this.modalAddClasse = true
        },

        showUpdatingModal(data) {

            this.modalUpadteClasse = true

            console.log(data);
        },


        showDelatingModal(data, i) {
            this.delateItem = data;
            this.i = i;
            this.showDelateModal = true;
        },

        async delateClasse() {

            console.log(this.delateItem);
            const response = await axios.post(
                "api/locale/delateClasse",
                this.delateItem
            );
            if (response.status === 200) {
                console.log(this.delateItem);
                this.datas.splice(this.i, 1);
                this.showDelateModal = false;
                this.s("Classe supprimée correctement");
            }
            // this.modal2 = false;
        },
        async handleRemove(file) {
            const image = this.data;

            this.data.imageLogo = "";

            this.$refs.uploads.clearFiles();

            try {
                await axios.post("api/admin/delateImage", image);
            } catch (e) {
                this.generalError = e.response.data.errors;
            }
        },

        handleView(name) {
            this.data.imageLogo = name;
            this.visible = true;
        },

        handleSuccess(res, file) {
            this.data.imageEmploiTmp = res;
            console.log(res);
        },

        handleError(res, file) {
            this.w("Sélectionner un jpg, png , jpeg, pdf, doc, ou docx");
        },
        handleFormatError(file) {
            this.w("Sélectionner un jpg, png , jpeg, pdf, doc, ou docx");
        },
        handleMaxSize(file) {
            this.w("Sélctionner un fichier de moins de 2M.");
        },

        handleBeforeUpload() {
            const check = this.uploadList.length < 1;
            if (!check) {
                this.w("Le logo est requi");
            }
            return check;
        },
        async Submit() {

            if (this.data.MontantScolAffect.trim() == "" || this.data.MontantScolAffect < 0) {

                return this.e("Montant montant de l'inscription incorrect ou absent ");
            }

            if (this.data.sigleClasse.trim() == "") {
                return this.e("Saisir un nom de la classe ");
            }

            if (this.data.MontantScol.trim() == "" || this.data.MontantScol < 0) {
                return this.e("Montant de la tranche1 incorrect ou absent ");
            }

            if (this.data.FraisInscrip.trim() == "" || this.data.FraisInscrip < 0) {


                return this.e("Montant de la tranche2 incorrect ou absent ");
            }




            if (this.data.imageEmploiTmp.trim() == "") {
                return this.e("Insérer l'emploi du temps");
            }

            this.data.EcoleInfos = this.EtabInfos;
            this.data.EcoleInfos.cycle = this.cycle;

            const res = await this.callApi(
                "post",
                "api/locale/Addclasse",
                this.data
            );

            if (res.status == 400) {

                this.w("Cette classe existe déja ");

                // this.$router.go();
            }

            else if (res.status == 200) {


                this.s("Classe ajoutée correctement");

                this.datas.unshift(res.data);

                this.modalAddClasse = false;

            } else {
                this.e("Une erreure est survenue");
            }


        },

        cloturer(data, i) {
            this.classeItem = data;

            // Enregistrer les donnees de la classe  dans le local storage

            localStorage.setItem("classeItem", JSON.stringify(data));
        },

        ListeEleve(data, i) {
            this.classeId = data;

            // mettre  id de la classe cliquee  dans le local storage

            localStorage.setItem("classeId", JSON.stringify(data));

            // console.log(data);
        }
    },

    async created() {
        // Recuperer toutes les infos de cette ecole dans le storage

        if (!localStorage.users) {

            this.$router.push('login');
        }

        if (localStorage.users) {
            this.users = JSON.parse(localStorage.getItem("users"));
        }

        if (localStorage.EtabInfos) {
            this.EtabInfos = JSON.parse(localStorage.getItem("EtabInfos"));
        }

        if (localStorage.cycle) {
            this.cycle = JSON.parse(localStorage.getItem("cycle"));
            this.EtabInfos[0].cycle = this.cycle;
        }

        // Recuperer toutes les sessions de cette ecole

        const response2 = await this.callApi(
            "post",
            "api/locale/getClasseEtablissementBySg",
            this.users
        );

        this.datas = response2.data;

        this.datas =  this.datas.filter(item => item.eleves.length >0 )


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
