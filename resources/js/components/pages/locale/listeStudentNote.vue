<template>
    <div>
        <div class="wrapper">
            <Header />
            <MenuLocal />

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
                                                {{
                                                        data.classeId.libelleClasse
                                                }}
                                            </strong>
                                        </h4>
                                        <!-- <span>
                                            <button
                                                type="button"
                                                class=" pull-right btn  btn-primary mb-5"
                                            >
                                                <Icon type="md-print" />

                                                Bulletins de toute la classe
                                            </button>
                                        </span> -->
                                    </div>

                                    <div class="box-body">
                                        <div class="table-responsive">
                                            <table class="table product-overview">
                                                <thead>
                                                    <tr>
                                                        <th></th>
                                                        <th>Noms et prénoms</th>
                                                        <th>Matricule</th>
                                                        <!-- <th>Email</th>
                                                        <th>Ancienneté</th> -->
                                                        <th></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr v-for="(data,
                                                    i) in classeListe" :key="i">
                                                        <td>
                                                            <img :src="
                                                                `/Photos/Logos/${data.user.photo}`
                                                            " alt="" style="width: 30px;" />
                                                        </td>

                                                        <td class="font-weight-900">
                                                            <h6>
                                                                {{ data.nom }}
                                                                {{
                                                                        data.prenom
                                                                }}
                                                            </h6>
                                                        </td>
                                                        <td>
                                                            {{ data.matricule }}
                                                        </td>
                                                        <!-- <td>
                                                            {{ data.email }}
                                                        </td>
                                                        <td>
                                                            {{ data.doublant }}
                                                        </td> -->
                                                        <td align="center">
                                                            <router-link to="BulletinEleve">
                                                                <button @click="
                                                                    ParentEleve(
                                                                        data,
                                                                        i
                                                                    )
                                                                " class="btn btn btn-primary btn-sm"
                                                                    title="Les details sur cet eleve ">
                                                                    <Icon type="ios-apps" />
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
                classeId: ""
            },
            classeListe: [],
            EtabInfos: [],
            parentEleveInfos: []
        };
    },

    methods: {
        ParentEleve(data, i) {
            localStorage.setItem("parentEleveInfos", JSON.stringify(data));
        }
    },

    async mounted() {

        if (!localStorage.users) {

            this.$router.push('login');
        }
        // Recuperer les infos de cette classe  dans le storage. classdId  contient toutes les classes et leur eleves respectivement

        if (localStorage.classeId) {
            this.data.classeId = JSON.parse(localStorage.getItem("classeId"));
        }

        // Recuperer tous les eleves de cette classe

        const response2 = await this.callApi(
            "post",
            "api/locale/getEleveclasse",
            this.data
        );

        this.classeListe = response2.data;

        console.log(this.classeListe);
    }
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
