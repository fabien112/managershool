<template>
    <div>
        <div class="wrapper">
            <Header />
            <MenuLocal />
            <Modal v-model="PosterModal" width="660">
                <p slot="header" style="text-align:center">
                    <span> Modification de l'emploi du temps </span>
                </p>
                <div style="text-align:center">


                    <br>

                    <Upload multiple type="drag" action="api/admin/upload" :on-success="handleSuccess"
                        :on-error="handleError" :format="['jpg', 'jpeg', 'png', 'jpg', 'jpeg', 'png', 'pdf', 'doc', 'docx']"
                        :max-size="2048" :on-format-error="handleFormatError" :on-exceeded-size="handleMaxSize"
                        :headers="{
                            'X-Requested-With':
                                'XMLHttpRequest'
                        }">
                        <div style="padding: 20px 0">
                            <Icon type="ios-cloud-upload" size="52" style="color: #3399ff"></Icon>

                            <p class="text-center">
                                Cliquer ou glisser deposer
                                pour inserer l'emploi du
                                temps de la classe
                            </p>

                        </div>
                    </Upload>
                </div>
                <div slot="footer">
                    <Button type="primary" size="large" long @click="Poster">Envoyer</Button>
                </div>
            </Modal>
            <div class="content-wrapper">
                <div class="container-full">
                    <section class="content">
                        <div class="row">
                            <!-- <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title">
                                            EMPLOI DU TEMPS
                                            <p
                                                class="subtitle font-size-14 mb-0"
                                            >
                                                Emploi du temps de toutes les
                                                classes
                                            </p>
                                        </h4>
                                    </div>
                                </div>
                            </div> -->

                            <!--card deck!-->

                            <div class="col-lg-3" v-for="(data, i) in TimeTables" :key="i">

                                <div v-if="data.number>0">

                                    <div class="box">
                                    <div class="box-body ribbon-box" >
                                        <div class="ribbon ribbon-primary"  >
                                            {{ data.libelleClasse }}
                                        </div>

                                        <p class="mb-0 ">
                                            <img height="100px" class="center center" :src="
                                                `/Photos/Logos/${data.emp_Classe}`
                                            " alt="" />
                                        </p>
                                    </div>
                                    <a target="blank" :href="`/Photos/Logos/${data.emp_Classe}`">
                                        <Button type="primary" style="width:100%"><i class="ti-import"></i>
                                            Télécharger</Button>
                                    </a>
                                    <a>
                                        <Button @click="change(data, i)" type="success" style="width:100%"><i
                                                class="ti-pencil-alt"> </i> Modifier </Button>
                                    </a>

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

export default {
    components: { Header, MenuLocal, Chats },
    data() {
        return {
            TimeTables: [],
            TimeTablesFiltres: [],
            data: {

                imageEmploiTmp: "",
                itemElement: ""

            },
            PosterModal: false
        };
    },

    async mounted() {

        if (!localStorage.users) {

            this.$router.push('login');
        }


        if (localStorage.EtabInfos) {

            this.EtabInfos = JSON.parse(localStorage.getItem("EtabInfos"));

        }

        this.data.EtabInfos = this.EtabInfos
        const response2 = await this.callApi(
            "post",
            "api/locale/getAllTimetable",
            this.data
        );


        this.TimeTables = response2.data;

        // Je retire les classe ou il ya pas d'eleve


        this.TimeTables =  this.TimeTables.filter(item => item.number >0 )
    },

    methods: {

        change(data, i) {

            this.PosterModal = true
            this.itemElement = data

        },

        async Poster() {

            this.data.itemElement = this.itemElement

            if (this.data.imageEmploiTmp.trim() == "") {
                return this.e("Vous devez inserer un fichier");
            }
            const response3 = await this.callApi(
                "post",
                "api/locale/updateTimetable",
                this.data
            )

            if (response3.status == 200) {
                this.s(" Emploi du temps modifié correctement");
                this.$router.go()
            } else {
                this.e("Une erreure est survenue");
            }


        }
        ,

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
            this.w("Selectionner un jpg, png , jpeg, pdf, doc, ou docx");
        },
        handleFormatError(file) {
            this.w("Selectionner un jpg, png , jpeg, pdf, doc, ou docx");
        },
        handleMaxSize(file) {
            this.w("Selctionner un fichier de moins de 2M.");
        },

        handleBeforeUpload() {
            const check = this.uploadList.length < 1;
            if (!check) {
                this.w("Le docuement est requi...");
            }
            return check;
        },
    }
};
</script>
