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

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for>Montant</label>

                                                <input class="form-control" v-model="data.montant" />

                                            </div>
                                        </div>


                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for>Mois</label>

                                                <select name="LeaveType" @change="onChange($event)" class="form-control"
                                                    v-model="keyword">
                                                    <option v-for="(data, i) in ClasseListes" :key="i" :value="data.id">
                                                        {{ data.nom }}</option>
                                                </select>
                                            </div>
                                        </div>


                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <button @click="Afficher" class="btn btn-primary">Envoyer</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <!-- Modal de modification -->

                        <Modal v-model="EdetingModal" title="Modifier  une absence ">
                            <div class="row">
                                <div class="col-md-12">
                                    <label class="form-label">Date</label>
                                    <input type="date" class="form-control" v-model.trim="
                                        data.date
                                    " />
                                </div>
                            </div>
                            <br />
                            <div class="row">
                                <div class="col-md-12">
                                    <label class="form-label">Durée</label>
                                    <input type="number" class="form-control" v-model.trim="
                                        data.duree
                                    " />
                                </div>
                            </div>

                            <br />

                            <div slot="footer">
                                <Button type="primary" size="large" long @click="Update()">Enregistrer</Button>
                            </div>
                        </Modal>

                        <!-- Modal de suppression -->

                        <Modal v-model="showDelateModal" width="360">
                            <p slot="header" style="color:#f60;text-align:center">
                                <span>Suppression</span>
                            </p>
                            <div style="text-align:center">
                                <p>Etes vous sure de vouloir supprimer ?</p>
                            </div>
                            <div slot="footer">
                                <Button type="error" size="large" long @click="delateAbsence">Confirmer</Button>
                            </div>
                        </Modal>
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
            EleveListes: "",
            ElevesAbsences: "",
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

        // Allons chercher la session et le code etablissement ce cet enseigant

        const response2 = await this.callApi(
            "post",
            "api/locale/getAllMois"
        );

        this.ClasseListes = response2.data;

        if (localStorage.Teacherdata2) {

            this.Teacherdata = JSON.parse(localStorage.getItem("Teacherdata2"));

            this.data.Teacherdata = this.Teacherdata;


        }


    },

    methods: {

        showDelatingModal(data, i) {
            this.delateItem = data;
            this.i = i;
            this.showDelateModal = true;
        },

        showEdetingModal() {

            this.EdetingModal = true
        },

        async onChange(event) {

            this.data.idMois = event.target.value;



        },

        async Afficher() {


            if (this.data.montant == "") {
                return this.e("Mentionner une somme  ");
            }

            if (this.data.idMois == "") {
                return this.e("Selectionner un mois ");
            }

            const response4 = await this.callApi(
                "post",
                "api/locale/payersalaireProf", this.data
            );

            this.ElevesAbsences = response4.data

            if (response4.status == 422) {
                return this.e("Veillez sairsir un montant correct");
            }

            if (response4.status == 400) {
                return this.e("Vous essayez de faire un paiement à l’excès ");
            }

            if (response4.status == 200) {
                this.s("Paiement correctement effectué ");
                this.$router.push("salaires");
            } else {
                this.e("Une erreure est survenue");
            }

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
