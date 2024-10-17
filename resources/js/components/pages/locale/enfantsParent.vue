<template>
    <div>
        <div class="wrapper">
            <Header />
            <MenuLocal />
            <div class="content-wrapper">
                <div class="container-full">
                    <section class="content">
                        <!-- START Card With Image -->
                        <Alert type="light" closable class="card">
                            <Icon type="ios-bulb-outline" slot="icon"></Icon>

                            Ce parent possède
                            {{ InfoEleveParent.length }} enfant(s)
                        </Alert>

                        <div class="row">
                            <div
                                v-for="(data, i) in InfoEleveParent"
                                :key="i"
                                class="col-md-12 col-lg-4"
                            >
                                <div class="card  shadow">
                                    <div
                                        style="margin:auto;text-align:center;width: 100%;height: 80px;background-color:#0052cc;"
                                    >
                                        <img
                                            style="margin: 15px auto auto;width: 100px;border-radius: 50%;"
                                            class="card-img-top img-responsive"
                                            :src="
                                                `/Photos/Logos/${data.user.photo}`
                                            "
                                            alt="Card image cap"
                                        />
                                    </div>

                                    <div class="table-responsive">
                                        <table class="table simple mb-0">
                                            <tbody>
                                                <br /><br />

                                                <tr>
                                                    <th class="bt-1">
                                                        Noms
                                                    </th>
                                                    <td class="font-weight-700">
                                                        {{ data.nom }}

                                                        {{ data.prenom }}
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td>
                                                        Classe
                                                    </td>
                                                    <td class="font-weight-700">
                                                        {{
                                                            data.classe
                                                                .libelleClasse
                                                        }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        Matricule
                                                    </td>
                                                    <td class="font-weight-700">
                                                        {{ data.matricule }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        Date et lieu de
                                                        naissance
                                                    </td>
                                                    <td
                                                        class=" font-weight-700"
                                                    >
                                                        {{
                                                            data.dateNaiss
                                                                | dateFormat
                                                        }}
                                                        , {{ data.lieuNaiss }}
                                                    </td>
                                                </tr>

                                                <!-- <tr>
                                                            <td>
                                                                Email
                                                            </td>
                                                            <td
                                                                class=" font-weight-700"
                                                            >
                                                                {{ data.email }}
                                                            </td>
                                                        </tr> -->
                                                <tr>
                                                    <td>Statut</td>
                                                    <td
                                                        class=" font-weight-700"
                                                    >
                                                        {{ data.doublant }}
                                                    </td>
                                                </tr>
                                                <!-- <tr>
                                                            <td>
                                                                Sexe
                                                            </td>
                                                            <th
                                                                class=" font-weight-700"
                                                            >
                                                                {{ data.sexe }}
                                                            </th>
                                                        </tr> -->
                                            </tbody>
                                        </table>
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
            parentEleve: [],
            InfoEleveParent: []
        };
    },

    methods: {},

    async mounted() {
        // Recuperer toutes les infos de ce parent
        if (!localStorage.users) {
            this.$router.push("login");
        }

        if (localStorage.IdParentInfolocal) {
            this.parentEleve = JSON.parse(
                localStorage.getItem("IdParentInfolocal")
            );
        }

        // Recuperer toutes les enfants de ce parent

        const response2 = await this.callApi(
            "post",
            "api/locale/getAllStudentofeParentByLocal",
            this.parentEleve
        );

        this.InfoEleveParent = response2.data;

        console.log(this.InfoEleveParent);
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
