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

                        <div class="col-12">
                            <div class="box no-shadow mb-0 bg-transparent">
                                <div class="box-header no-border px-0">
                                    <Alert fade=true show-icon closable>

                                        SOLDE EN BANQUE
                                        <Icon type="ios-bulb-outline" slot="icon"></Icon>
                                        <template slot="desc">

                                            {{datas.totalAppro-datas.totalSortiBank}}

                                        </template>
                                    </Alert>
                                </div>
                            </div>
                        </div>
                        <div class="row">

                            <div class="col-6">
                                <div class="box">
                                    <div class="box-header bg-primary">
                                        <h4 class="box-title" style="margin:auto">

                                            Caisse vers Banque : {{datas.totalAppro}}
                                        </h4>

                                        <!-- <span>
                                            <router-link to="addVersementBanque">

                                                <button type="button" class=" pull-right btn  btn-primary mb-5"
                                                    @click="modal6 = true">
                                                    <i class="ti-plus"></i>


                                                </button>

                                            </router-link>

                                        </span> -->
                                    </div>
                                    <div class="box-body">
                                        <div class="table-responsive">
                                            <table id="example" class="table simple mb-0" style="width:100%">

                                                <thead>

                                                    <tr>

                                                        <th>Jour</th>
                                                        <th>Somme</th>
                                                        <!-- <th>Motifs</th> -->


                                                    </tr>
                                                </thead>
                                                <tbody>

                                                    <tr v-for="(data, i) in datas.appro" :key="i">
                                                        <td>{{ data.date|dateFormat }}</td>
                                                        <td>{{ data.montant}}</td>
                                                        <!-- <td>{{ data.motif }}</td> -->




                                                    </tr>

                                                </tbody>

                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-6">
                                <div class="box">
                                    <div class="box-header bg-danger">
                                        <h4 class="box-title" style="margin:auto">

                                            Banque vers Caisse : {{datas.totalSortiBank}}
                                        </h4>

                                        <!-- <span>
                                            <router-link to="retraitBanque">

                                                <button type="button" class=" pull-right btn  btn-danger mb-5"
                                                    @click="modal6 = true">
                                                    <i class="ti-plus"></i>


                                                </button>

                                            </router-link>

                                        </span> -->
                                    </div>
                                    <div class="box-body">
                                        <div class="table-responsive">
                                            <table id="example" class="table simple mb-0" style="width:100%">

                                                <thead>

                                                    <tr>

                                                        <th>Jour</th>
                                                        <th>Somme</th>

                                                    </tr>
                                                </thead>
                                                <tbody>

                                                    <tr v-for="(data, i) in datas.sorti" :key="i">
                                                        <td>{{ data.date|dateFormat }}</td>
                                                        <td>{{ data.montant }}</td>



                                                    </tr>

                                                </tbody>

                                            </table>
                                        </div>
                                    </div>
                                </div>
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
            EtabInfos: '',

            data: {
                sigleClasse: '',
                MontantScol: '',
                FraisInscrip: '',
                MontantScolAffect: '',
                imageEmploiTmp: ''
            },

            appro: 0,
            rettaitBank: 0,
            solde: 0,
            modalAddClasse: false,

            datas: [],
            IdParentInfolocal: "",
            showDelateModal: false,
            i: -1,

            classeItem: "",

            datas2: 0

        };
    },



    methods: {

        ShowmodalAddClasse() {

            this.modalAddClasse = true
        },

        Details(data, i) {


            localStorage.setItem('IdParentInfolocal', JSON.stringify(data));
        },

        showDelatingModal(data, i) {
            this.delateItem = data;
            this.i = i;
            this.showDelateModal = true;
        },

        async delateParent() {

            console.log(this.delateItem);
            const response = await axios.post(
                "api/caisse/delateBanque",
                this.delateItem
            );
            if (response.status === 200) {

                if (this.delateItem.type == 'ret') {

                    this.datas.sorti.splice(this.i, 1);

                }

                if (this.delateItem.type == 'dep') {

                    this.datas.appro.splice(this.i, 1);

                }
                this.showDelateModal = false;
                this.s("Element supprimé correctement");
                const response2 = await this.callApi(
                    "post",
                    "api/locale/getEntressAutre",
                    this.EtabInfos
                );

                this.datas = response2.data



            }

        },


    },

    async mounted() {

        if (!localStorage.users) {

            this.$router.push('login');
        }

        // Recuperer toutes les infos de cette ecole dans le storage



        if (localStorage.EtabInfos) {

            this.EtabInfos = JSON.parse(localStorage.getItem("EtabInfos"));
        }

        // Recuperer tous les parents de cette ecole

        const response2 = await this.callApi(
            "post",
            "api/locale/getEntressAutre",
            this.EtabInfos
        );



        this.datas = response2.data

        this.datas2 = response2.data





    }

}


</script>

<style>
.content-wrapper {
    background-color: #FAFBFD
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
