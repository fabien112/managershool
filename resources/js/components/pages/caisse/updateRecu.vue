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
                                <div class="box-header bg-primary">
                                    <h4 class="box-title">
                                        <strong> Modification du reçu </strong>
                                    </h4>
                                </div>

                                <div class="box-footer">
                                    <div class="row">

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for>Montant</label>

                                                <input type="number" class="form-control" v-model="data.montant" />

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
import { thisTypeAnnotation } from '@babel/types';

export default {
    components: { Header, MenuCaisse, Chats },
    data() {
        return {

            data: {

                idMois: "",
                montant: "",
                id: '',

            },
            EdetingData: [],
            ClasseListes: "",

        };


    },


    async mounted() {


        if (localStorage.EtabInfos) {
            this.EtabInfos = JSON.parse(localStorage.getItem("EtabInfos"));
        }


        if (localStorage.recudata) {

            this.EdetingData = JSON.parse(localStorage.getItem("recudata"));

            this.data.montant = this.EdetingData.montant;
            this.data.id = this.EdetingData.id;
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





        async onChange(event) {

            this.data.idMois = event.target.value;

        },

        async Afficher() {


            console.log(this.EdetingData);


            if (this.data.montant == "") {
                return this.e("Mentionner une somme  ");
            }

            if (this.data.idMois == "") {
                return this.e("Selectionner un mois ");
            }

            const response4 = await this.callApi(
                "post",
                "api/caisse/upadteSalaire", this.data
            );

            this.ElevesAbsences = response4.data

            if (response4.status == 422) {
                return this.e("Veillez sairsir un montant correct");
            }

            if (response4.status == 400) {
                return this.e("Vous essayez de faire un paiement à l’excès ");
            }

            if (response4.status == 200) {
                this.s("modification correctement effectué ");
                this.$router.push("histsalaireCaisse");
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
