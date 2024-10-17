<template>
    <div>
        <div class="wrapper">
            <HeaderTeacher />
            <MenuTeacher />

            <div class="content-wrapper" style="min-height: 653px; background-color:#FAFBFD">
                <div class="container-full">
                    <!-- Main content -->

                    <section class="content">

                        <div class="row">
                            <div class="col-md-12 ">
                                <div class="box">

                                    <div class="box-header bg-primary">
                                        <h4 class="box-title" style="margin:auto"><strong> Liste de la classe



                                            </strong></h4>
                                        <button style="margin-left: 650px;" type="button"
                                            class="pull-right waves-effect btn  btn-primary mb-5">
                                            <i class="ti-printer"></i> Imprimer
                                        </button>
                                    </div>


                                    <div class="box-body">
                                        <div class="table-responsive">

                                            <table class="table product-overview">
                                                <thead>
                                                    <tr>
                                                        <th> </th>
                                                        <th>Noms et prénoms </th>
                                                        <th>Matricule</th>
                                                        <!-- <th>Email</th> -->
                                                        <th>Anciennete</th>
                                                        <th></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr v-for="(data, i) in EleveClasse" :key="i">
                                                        <td><img :src="
                                                            `/Photos/Logos/${data.user.photo}`
                                                        " alt="" width="60" style="width: 30px;" height="40">
                                                        </td>
                                                        <td class="font-weight-900">
                                                            <h5>{{ data.nom }} {{ data.prenom }}</h5>
                                                        </td>
                                                        <td> {{ data.matricule }}</td>
                                                        <!-- <td>{{ data.email }}</td> -->
                                                        <td>{{ data.doublant }}</td>
                                                        <td align="center">

                                                            <router-link to="detailEleveTeacher">

                                                                <button @click="ParentEleve(data, i)"
                                                                    class="btn  btn-primary btn-xs">
                                                                    <Icon type="md-apps" />
                                                                </button>
                                                            </router-link>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>

                                        </div>

                                    </div>
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
import MenuTeacher from "../../navs/MenuTeacher.vue";
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
import HeaderTeacher from "../../headers/HeaderTeacher.vue";

export default {
    components: { MenuTeacher, Chats, HeaderTeacher },
    data() {
        return {

            data: {
                classeInfos: '',
            },
            EleveClasse: [],
            EtabInfos: [],
            parentEleveInfosTeacher: []
        };
    },






    async mounted() {



        // Recuperer les infos de cette classe  dans le storage. classdId  contient toutes les classes et leur eleves respectivement


        if (localStorage.IdClasseTeacher) {

            this.classeInfos = JSON.parse(localStorage.getItem("IdClasseTeacher"));

        }

        // Recuperer tous les eleves de cette classe

        const response2 = await this.callApi(
            "post",
            "api/locale/getEleveclasseByTeacher",
            this.classeInfos
        );

        this.EleveClasse = response2.data

        console.log(this.EleveClasse);

    },

    methods: {

        ParentEleve(data, i) {


            localStorage.setItem('parentEleveInfosTeacher', JSON.stringify(data));


        }

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
