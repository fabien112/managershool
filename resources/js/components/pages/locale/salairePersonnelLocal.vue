<template>
    <div>
        <div class="wrapper">
            <Header />
            <MenuLocal />
            <div class="content-wrapper">
                <div class="container-full">
                    <section class="content">


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

                        <div class="row">
                            <div class="col-12">
                                <div class="box no-shadow mb-0 bg-transparent">
                                    <div class="box-header no-border px-0">
                                        <Alert fade=true show-icon closable>

                                            Bilan des salaires mensuelles de tout le personnel

                                            <Icon type="ios-bulb-outline" slot="icon"></Icon>
                                            <!-- <template slot="desc">
                                                Quelques chiffres concernant votre école...
                                            </template> -->
                                        </Alert>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for>Mois</label>

                                    <select name="LeaveType" @change="onChange($event)" class="form-control"
                                        v-model="data.idMois">
                                        <option v-for="(data, i) in ClasseListes" :key="i" :value="data.id">{{ data.nom
                                        }}</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <br>
                                <div class="form-group">
                                    <button @click="Afficher" class="btn btn-primary btn-block">Envoyer</button>
                                </div>
                            </div>


                        </div>
                        <br />
                        <br />
                        <br />

                        <div class="row" v-if="showRecap == true">
                            <div class="col-12">
                                <!-- /.box -->

                                <div class="box">
                                    <div class="box-header bg-primary">
                                        <h6 class="box-title" style="margin:auto">SALAIRES MENSUELS</h6>

                                        <!-- <span>
                                            <router-link to="Enseignants">
                                                <button
                                                    type="button"
                                                    class="pull-right btn btn-primary"
                                                >
                                                    <Icon type="md-add" /> Paiement
                                                </button>
                                            </router-link>
                                        </span> -->
                                    </div>

                                    <div class="box-body">
                                        <div class="table-responsive">
                                            <table id="example" class="table simple mb-0" style="width:100%">
                                                <thead>
                                                    <tr>
                                                        <th>Noms et prénoms</th>
                                                        <!-- <th>Total heures du mois </th> -->
                                                        <th> Fonction </th>
                                                        <th> Salaire mensuelle </th>
                                                        <th>Déja payés</th>
                                                        <th>Reste</th>
                                                        <th></th>

                                                    </tr>
                                                </thead>
                                                <tbody name="fruit-table" is="transition-group">
                                                    <tr v-for="(data,
                                                    i) in Salaires" :key="i">
                                                        <td style="background-color:#2C353D; color:white">
                                                            {{
                                                                    data.nom
                                                            }}

                                                            {{
                                                                    data.prenom
                                                            }}
                                                        </td>

                                                        <td style="background-color:#E91E63; color:white">
                                                            <strong>{{ data.role }} </strong>
                                                        </td>

                                                        <td style="background-color:#663399; color:white">

                                                            <strong>{{ data.salaire }} F </strong>

                                                        </td>


                                                        <!-- <td style="background-color:#33993E; color:white">
                                                            <strong> {{ data.scolarite.heure *
                                                                    data.scolarite.prixhoraire
                                                            }}
                                                                F</strong>
                                                        </td> -->

                                                        <td style="background-color:#0052CC; color:white">
                                                            <strong> {{ data.scolarite.total }} F</strong>

                                                        </td>



                                                        <td style="background-color:#FF0000; color:white">
                                                            {{
                                                                    -data.scolarite.total + data.salaire
                                                            }}
                                                            F
                                                        </td>

                                                        <!-- <td>

                                                            <router-link to="payersalaireCaissePersonnel">
                                                                <button @click="Payer(data, i)" type="button"
                                                                    class="pull-right btn btn-warning"
                                                                    title="Faire un paiement">
                                                                    <Icon type="md-add" />


                                                                </button>
                                                            </router-link>

                                                        </td> -->

                                                        <td>

                                                            <router-link to="histPersonnelLocal">
                                                                <button @click="Payer(data, i)" type="button"
                                                                    class=" btn btn-primary"
                                                                    title="Lister l'historique">
                                                                    <Icon type="md-eye" />
                                                                </button>
                                                            </router-link>

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
                    </section>
                </div>
            </div>
        </div>
        <Chats />
    </div>
</template>

<script>
import Header from "../../headers/Header.vue";
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
import MenuLocal from "../../navs/MenuLocal.vue";

export default {
    components: { Header, Chats, MenuLocal },
    data() {
        return {

            data: {

                idMois: "",


            },
            EdetingModal: false,
            showDelateModal: false,
            keyword: "",
            keyword2: "",
            ClasseListes: "",
            Salaires: "",
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

        Payer(data, i) {

            localStorage.setItem('Teacherdata2', JSON.stringify(data));

        },

        async Afficher() {


            this.TotalHeure = 0;

            if (this.data.idMois == "") {
                return this.e("Selectionner un mois  ");
            }


            const response3 = await this.callApi(
                "post",
                "api/caisse/getAllSalairesPersonnelMois", this.data
            );

            this.Salaires = response3.data;

            this.showRecap = true




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
