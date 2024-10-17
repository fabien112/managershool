<template>
    <div>
        <div class="wrapper">
            <Header />
            <MenuCaisse/>



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
                                        <h4 class="box-title" style="margin:auto">

                                            Total =  {{this.datas.totalAppro}}
                                        </h4>

                                        <span>
                                            <router-link to="addautreVersement">

                                                <button type="button" class=" pull-right btn  btn-primary mb-5"
                                                    @click="modal6 = true">
                                                    <Icon type="md-person-add" />

                                                    Nouveau
                                                </button>

                                            </router-link>

                                        </span>
                                    </div>
                                    <div class="box-body">
                                        <div class="table-responsive">
                                            <table id="example" class="table simple mb-0" style="width:100%">

                                                <thead>

                                                    <tr>

                                                        <th>Jour</th>
                                                        <th>Somme</th>
                                                        <th>Motifs</th>

                                                        <th></th>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                    <tr v-for="(data, i) in datas.appro" :key="i">
                                                        <td>{{ data.date|dateFormat }}</td>
                                                        <td>{{ data.montantverser }}</td>
                                                        <td>{{ data.motif }}</td>

                                                        <td style="text-align:center" class="center">




                                                            <button @click="showDelatingModal(data, i)" class="btn btn-danger btn-xs"

                                                                title="Supprimer">
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
            UserData: [],
            EtabInfos: '',

            data: {
                sigleClasse: '',
                MontantScol: '',
                FraisInscrip: '',
                MontantScolAffect: '',
                imageEmploiTmp: ''
            },
            modalAddClasse: false,
            IdParentInfolocal: "",
            showDelateModal: false,
            i: -1,
            datas: [],
            classeItem: "",

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
                "api/caisse/delateVersement",
                this.delateItem
            );
            if (response.status === 200) {
                this.datas.splice(this.i, 1);
                this.showDelateModal = false;
                this.s("Element supprimé correctement");
            }
            // this.modal2 = false;
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
            "api/locale/getEntressAutre2",
            this.EtabInfos
        );

        this.datas = response2.data





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
