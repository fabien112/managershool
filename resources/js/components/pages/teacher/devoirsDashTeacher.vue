<template>
    <div>
        <div class="wrapper">
            <HeaderTeacher />
            <MenuTeacher />
            <div class="content-wrapper">
                <div class="container-full">
                    <section class="content">
                        <Modal v-model="showDelateModal" width="360">
                            <p slot="header" style="color:#f60;text-align:center">
                                <span> Suppression </span>
                            </p>
                            <div style="text-align:center">
                                <p>Etes vous sure de voulior supprimer ?</p>
                            </div>
                            <div slot="footer">
                                <Button type="error" size="large" long @click="delateDevoir">Confirmer</Button>
                            </div>
                        </Modal>

                        <router-link to="createDevoir">
                            <Button type="primary" class="pull-right">
                                <Icon type="md-add" /> Nouveau
                            </Button>
                            <br /><br />
                        </router-link> <br>

                        <div class="row">
                            <div class="col-xl-3 col-12" v-for="(data, i) in DevoirsListes" :key="i">
                                <div>
                                    <div class="box mb-15 pull-up">
                                        <div class="box-body">
                                            <div class="d-flex align-items-center justify-content-between">
                                                <div class="d-flex align-items-center">
                                                    <!-- <div class="mr-15 bg-primary h-50 w-50 l-h-60 rounded text-center">
                                                        <span class="icon-Book-open font-size-24"><span
                                                                class="path1"></span><span class="path2"></span></span>
                                                    </div> -->
                                                    <div class="d-flex flex-column font-weight-500">

                                                        <p class="font-size-10">{{ data.classe.libelleClasse }}</p>

                                                        <a href="#" class="text-dark hover-primary mb-1 font-size-10">
                                                            <!-- {{
                                                                data.libelle.slice(
                                                                    0,
                                                                    15
                                                                )
                                                            }}... | -->


                                                            {{
                                                                data.matiere
                                                                    .libelle
                                                            }}
                                                        </a>

                                                        <span class="text-fade font-size-10">
                                                             Crée le
                                                            {{

                                                                    data.created_at|dateFormat
                                                            }}
                                                        </span>
                                                        <div class="px-0 py-10 w-100">
                                                            <span v-if="
                                                                data.statut ==
                                                                1
                                                            " class="badge badge-primary">Public</span>
                                                            <span v-if="
                                                                data.statut ==
                                                                0
                                                            " class="badge badge-danger">Privé</span>
                                                            <!-- <span v-if="
                                                                data.statut ==
                                                                0
                                                            " class="badge badge-primary">
                                                                <Icon type="md-create" />
                                                            </span> -->
                                                            <span @click="
                                                                showDelatingModal(
                                                                    data,
                                                                    i
                                                                )
                                                            " class="badge badge-warning">
                                                                <Icon type="ios-trash" />
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <router-link to="detailsDevoirTeacher">
                                                    <span @click="
                                                        details(data, i)
                                                    " class="icon-Arrow-right font-size-20"><span
                                                            class="path1"></span><span class="path2"></span></span>
                                                </router-link>
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
            data: {},
            users: "",
            DevoirsListes: "",
            showDelateModal: false,
            delateItem: {},
            i: -1
        };
    },

    async mounted() {
        if (localStorage.users) {
            this.users = JSON.parse(localStorage.getItem("users"));
        }

        const response = await this.callApi(
            "post",
            "api/teacher/getAllDevoirsTeacher",
            this.users
        );

        this.DevoirsListes = response.data;
    },

    methods: {
        async delateDevoir() {
            const response = await axios.post(
                "api/teacher/delateDevoir",
                this.delateItem
            );
            if (response.status === 200) {
                console.log(this.delateItem);
                this.DevoirsListes.splice(this.i, 1);
                this.showDelateModal = false;
                this.s("Devoir supprimé correctement");
            }
            // this.modal2 = false;
        },

        showDelatingModal(data, i) {
            this.delateItem = data;
            this.i = i;
            this.showDelateModal = true;
        },

        publier(data, i) {
            console.log(data);
        },

        details(data, i) {
            localStorage.setItem("devoirs", JSON.stringify(data));
        }
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
