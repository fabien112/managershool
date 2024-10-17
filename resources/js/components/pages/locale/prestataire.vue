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
                    <p> Etes-vous sure de vouloir supprimer ?</p>
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
                                        <h4 class="box-title"> Prestataires

                                        </h4>

                                        <span>
                                            <router-link to="addcaissiere">

                                                <button type="button"
                                                    class="pull-right waves-effect btn  btn-primary mb-5"
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
                                                        <th>Nom</th>
                                                        <th>Prénom</th>
                                                        <th>Téléphone</th>
                                                        <th>Fonction</th>
                                                        <th>Salaire</th>

                                                        <th>Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                    <tr v-for="(data, i) in Enseignants" :key="i">
                                                        <td> {{ data.nom }}</td>
                                                        <td> {{ data.prenom }}</td>
                                                        <td> {{ data.tel }}</td>
                                                        <td> {{ data.role }}</td>
                                                        <td> {{ data.salaire }} F </td>

                                                        <td>

                                                            <!-- <router-link to="classeofTeacher">

                                                                <span @click="Voir(data, i)" class="btn btn-xs"
                                                                    style="background-color:gray;color:white"
                                                                    title="Voir les classes de cet enseignant">
                                                                    <Icon type="md-apps" />
                                                                </span>

                                                            </router-link> -->

                                                            <!-- <router-link to="payersalaire">

                                                    <span @click="Payer(data,i)" class="btn btn-xs" style="background-color:#2C353D;color:white" title="Effectuer un versement"> <Icon type="logo-usd" /> </span>

                                                </router-link> -->

                                                <router-link to="editPersonnel" >

                                                     <button  @click="Payer(data,i)"  class="btn btn-primary"

                                                                title="Modifier"> <i class="ti-pencil"></i>
                                                     </button>


                                                </router-link>





                                                            <button @click="showDelatingModal(data, i)"
                                                                class="btn btn-danger"
                                                                style="background-color:red;color:white"
                                                                title="Supprimer"> <i class="ti-trash"></i>
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

            EtabInfos: '',

            data: {

            },

            showDelateModal: false,
            i: -1,
            datas: [],
            classeItem: "",
            Enseignants: []

        };
    },



    methods: {

        showDelatingModal(data, i) {
            this.delateItem = data;
            this.i = i;
            this.showDelateModal = true;

        },

        async delateParent() {

            console.log(this.delateItem);
            const response = await axios.post(
                "api/locale/delateCaissiere",
                this.delateItem
            );
            if (response.status === 200) {
                this.Enseignants.splice(this.i, 1);
                this.showDelateModal = false;
                this.s("Comptable supprimé correctement");
            }
            // this.modal2 = false;
        },


        Voir(data, i) {

            localStorage.setItem('Teacherdata', JSON.stringify(data));

        },

        Payer(data, i) {

            localStorage.setItem('Teacherdata', JSON.stringify(data));

        }

    },


    async mounted() {



        if (!localStorage.users) {

            this.$router.push('login');
        }
        // Recuperer toutes les infos de cette ecole dans le storage

        if (localStorage.EtabInfos) {

            this.EtabInfos = JSON.parse(localStorage.getItem("EtabInfos"));


        }

        // Recuperer toutes les enseigants de cette  ecole

        // Je rajoute les  information de l'ecole appartenant a l'utulisateur qui s'est logger a ma data qui ira dans l'api de creation de la session

        this.data.EcoleInfos = this.EtabInfos;

        const res = await this.callApi("post", "api/locale/getCaissep", this.data);

        this.Enseignants = res.data


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
