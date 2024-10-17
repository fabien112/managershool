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
                                    <h6 class="box-title">


                                    </h6>
                                </div>

                                <div class="box-footer">
                                    <div class="row">

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for>Date</label>

                                                <input type="date" class="form-control" v-model="data.date" />

                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for>Montant</label>

                                                <input type="number" class="form-control" v-model="data.montant" />

                                            </div>
                                        </div>

                                        <!-- <div class="col-md-6">
                                            <div class="form-group">
                                                <label>
                                                    Motif
                                                </label>
                                                <select @change="onChange2($event)"
                                                    class="custom-select form-control required" v-model="
                                                        data.role
                                                    ">
                                                    <option value=""> Sélectioner le motif </option>
                                                    <option value="banque"> Dépot de la caisse vers la banque  </option>
                                                    <option value="autre"> Autres </option>
                                                </select>


                                            </div>



                                        </div> -->

                                        <div class="col-md-6" >
                                            <div class="form-group">
                                                <label>
                                                    Précision sur le motif
                                                </label>

                                                <input  type="text"
                                                    class="form-control required" v-model.trim="
                                                        data.motif
                                                    " />

                                            </div>
                                        </div>





                                        <!-- <div class="col-md-6">
                                            <div class="form-group">
                                                <label for>Motif</label>

                                                <input class="form-control" v-model="data.motif" />

                                            </div>
                                        </div> -->





                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <button @click="Afficher" class="btn btn-primary">Enregistrer</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>






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
                motif: "",
                date: "",
                role: '',

            },
            ElevesAbsences: "",
            champautre: false,

        };


    },


    async created() {


        if (!localStorage.users) {

            this.$router.push('login');
        }

    },


    async mounted() {


        if (localStorage.EtabInfos) {
            this.EtabInfos = JSON.parse(localStorage.getItem("EtabInfos"));
        }

        // Allons chercher la session et le code etablissement ce cet enseigant

        const response2 = await this.callApi(
            "post",
            "api/locale/getAllMois"
        );

        this.ClasseListes = response2.data;




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
        async onChange2(event) {

            this.data.role = event.target.value;

            if (this.data.role == 'autre') {

                this.champautre = true;
            }

            else {
                this.champautre = false;

            }

        },

        async Afficher() {

            if (this.data.date == "") {
                return this.e("Mentionner la date");
            }


            if (this.data.montant == "") {
                return this.e("Mentionner le montant ");
            }
            if (this.data.role == "" && this.data.motif =='') {
                return this.e("Mentionner le motif");
            }


            this.data.EtabInfos = this.EtabInfos

            const response4 = await this.callApi(
                "post",
                "api/caisse/payerAutredepense", this.data
            );

            this.ElevesAbsences = response4.data

            if (response4.status == 422) {
                return this.e("Vous saisir correctement tous les champs");
            }

            if (response4.status == 400) {
                return this.e("Vous saisir correctement tous les champs ");
            }

            if (response4.status == 200) {
                this.s("Paiement correctement effectué ");
                // this.$router.push("depenseCaisse");
                this.$router.go(-1)
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
