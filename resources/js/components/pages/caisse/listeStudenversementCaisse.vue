<template>
    <div>
        <div class="wrapper">
            <Header />
            <MenuCaisse />

            <div class="content-wrapper" style="min-height: 653px; background-color:#FAFBFD">
                <div class="container-full">
                    <!-- Main content -->

                    <section class="content">

                        <div class="row">
                            <div class="col-12 ">
                                <div class="box">

                                    <div class="box-header bg-primary">
                                        <h4 class="box-title" style="margin:auto">
                                            <strong>
                                                {{ data.classeId.libelleClasse }}
                                            </strong>
                                        </h4>

                                        <h1 type="button" class="pull-right  mb-5">

                                            {{ classeListe.length }}
                                            <Icon type="ios-school" />
                                        </h1>
                                    </div>

                                    <div class="box-body">
                                        <div class="table-responsive">

                                            <table class="table product-overview">
                                                <thead>
                                                    <tr>
                                                        <th></th>
                                                        <th> Noms et prénoms </th>
                                                        <th>Matricule</th>
                                                        <th>Sexe</th>
                                                        <th>Date et lieu de Naissance </th>



                                                        <th></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr v-for="(data, i) in classeListe.content" :key="i">
                                                        <td><img :src="`/Photos/Logos/${data.user.photo}`
                                                            " alt="" style="width: 30px;"></td>
                                                        <td class="font-weight-900">
                                                            <h6>{{ data.nom }} {{ data.prenom }}</h6>
                                                        </td>
                                                        <td> {{ data.matricule }}</td>
                                                        <td>{{ data.sexe }} </td>
                                                        <td>{{ data.dateNaiss }} à {{ data.lieuNaiss }} </td>


                                                        <td align="center">

                                                            <router-link to="detailsEleveFinanceCaisse">

                                                                <button @click="ParentEleve(data, i)"
                                                                    class="btn btn-outline btn-primary btn-sm"
                                                                    title="Les details sur cet eleve ">
                                                                    <!-- <Icon type="ios-apps" /> -->
                                                                    <Icon type="md-done-all" style="font-size:13px" />
                                                                    Paiements
                                                                </button>

                                                            </router-link>

                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>

                                        </div>

                                    </div>


                                    <b-pagination :total-rows="rows" @change="handlePageChange" size="lg"
                                        v-model="currentPage" align="center" :per-page="10" :current-page="currentPage">
                                    </b-pagination>

                                </div>
                            </div>

                        </div>

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
import MenuCaisse from "../../navs/MenuCaisse.vue";

export default {
    components: { Header, Chats, MenuCaisse },
    data() {
        return {

            data: {
                classeId: '',
            },
            rows: 0,
            currentPage: 0,

            classeListe: [],
            EtabInfos: [],
            parentEleveInfos: []
        };
    },


    methods: {

        ParentEleve(data, i) {


            localStorage.setItem('parentEleveInfos', JSON.stringify(data));

        },

        handlePageChange(value) {

            this.data.currentPage = value - 1

            console.log(value)

            this.getAll()
        },
        async getAll() {

            const response2 = await this.callApi(
                "post",
                "api/locale/getEleveclasse",
                this.data
            );

            this.classeListe = response2.data

            this.rows = res.data.totalPages

        },



    },

    async mounted() {

        if (!localStorage.users) {

            this.$router.push('login');
        }


        // Recuperer les infos de cette classe  dans le storage. classdId  contient toutes les classes et leur eleves respectivement


        if (localStorage.classeId) {

            this.data.classeId = JSON.parse(localStorage.getItem("classeId"));


            console.log(this.data.classeId)

            const response2 = await this.callApi(
                "post",
                "api/locale/getEleveclasse",
                this.data
            );

            this.classeListe = response2.data

            this.rows = response2.data.totalPages


        }

        // Recuperer tous les eleves de cette classe





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
