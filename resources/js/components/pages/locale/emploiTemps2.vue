<template>
    <div>
        <div class="wrapper">
            <Header />
            <MenuLocal />

            <div class="content-wrapper" style="min-height: 653px; background-color:#FAFBFD">
                <div class="container-full">
                    <!-- Main content -->
                    <section class="content">


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


                            <div class="col-xl-4 col-12" v-for="(data, i) in datas" :key="i">
                                <div class="box box-slided-up">
                                    <div class="box-header with-border" style="text-align: center">
                                        <h4 class="box-title"> <strong> {{ data.libelleClasse }} </strong></h4>
                                        <ul class="box-controls pull-right">
                                            <li><a class="box-btn-close" href="#"></a></li>
                                            <li><a class="box-btn-slide rotate-180" href="#"></a></li>
                                            <li><a class="box-btn-fullscreen" href="#"></a></li>
                                        </ul>
                                    </div>

                                    <div class="box-body" style="display: block;text-align: center">
                                        <router-link to="times">
                                            <div class="callout callout-primary mb-0" role="alert" @click="
                                                ListeEleve(
                                                    data,
                                                    i
                                                )
                                                ">


                                                En savoir plus
                                            </div>


                                        </router-link>


                                    </div>
                                </div>
                            </div>


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
            modalUpadteClasse2: false,
            somme: 0,
            data: {
                sigleClasse: "",
                MontantScol: "",
                FraisInscrip: "",
                MontantScolAffect: "",
                imageEmploiTmp: "",
                libelleClasse: '',
                prof: ''

            },

            Enseignants: '',


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

        async Affecttation2() {


            // Affecter une matiere a un professeur , ItemMatiere  contient les infos de la matiere

            if (this.data.prof == "") {
                return this.e("Sélectionner un enseignant  ");
            } else {


                // Ajouter lid du prof  choisi aux donnes de la  matiere

                this.delateItem.Enseignants = this.data.prof

                const response = await this.callApi(
                    "post",
                    "/api/locale/doProfPrincipal",
                    this.delateItem
                );
                if (response.status == 200) {
                    this.s("Affectation modifiée correctement");
                    this.modalUpadteClasse2 = false;

                    // const response3 = await this.callApi(
                    //     "post",
                    //     "/api/locale/doProfPrincipal",
                    //     this.data
                    // );

                    this.Matieres = response3.data;

                    // this.$router.go();

                } else {
                    this.e("Une erreure est survenue");
                }
            }
        },

        ShowmodalAddClasse() {

            this.modalAddClasse = true
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

        showUpdatingModal2(data, i) {

            this.delateItem = data;

            this.modalUpadteClasse2 = true

        },

        async updateClasse() {

            this.dataRefresh.idClasse = this.delateItem.id

            if (this.dataRefresh.libelleClasse.trim() == "") {
                return this.e("Saisir un nom de la classe ");
            }

            if (this.dataRefresh.scolariteaff_Classe == "" || this.dataRefresh.scolariteaff_Classe < 0) {

                return this.e("Montant de l 'inscription incorrect ou absent ");
            }



            if (this.dataRefresh.scolarite_Classe == "" || this.dataRefresh.scolarite_Classe < 0) {
                return this.e("Montant de la tranche1 incorrect ou absent ");
            }

            if (this.dataRefresh.inscription_Classe == "" || this.dataRefresh.inscription_Classe < 0) {

                return this.e("Montant de la tranche2 incorrect ou absent ");

            }


            const response = await axios.post(
                "api/locale/updateClasse",
                this.dataRefresh
            );
            if (response.status === 200) {


                this.s("Classe modifiée correctement");

                this.modalUpadteClasse = false;

                this.$router.go();




            }
            // this.modal2 = false;
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
            // this.dataRefresh.newImage= res;
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


            localStorage.setItem("classeId", JSON.stringify(data));


        }
    },



    async created() {
        // Recuperer toutes les infos de cette ecole dans le storage

        if (!localStorage.users) {

            this.$router.push('login');
        }

        if (localStorage.EtabInfos) {
            this.EtabInfos = JSON.parse(localStorage.getItem("EtabInfos"));

            this.data.EcoleInfos = this.EtabInfos;

        }

        if (localStorage.cycle) {
            this.cycle = JSON.parse(localStorage.getItem("cycle"));
            this.EtabInfos[0].cycle = this.cycle;
        }






        const response2 = await this.callApi(
            "post",
            "api/locale/getClasseEtablissement",
            this.EtabInfos
        );

        this.datas = response2.data;

        // Je  n'affiche que les classes qui ont un eleve au moins , commtez cette ligne en cas de new ecole ou on recree les classes

        this.datas = this.datas.filter(item => item.eleves.length > 0)



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
