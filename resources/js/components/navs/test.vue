<template>
    <div>
        <div class="wrapper">
            <Header />
            <MenuLocal />
            <div class="content-wrapper">
                <div class="container-full">
                    <section class="content">
                        <div class="row">
                            <div class="col-12">
                                <div class="box box-default">
                                    <div class="box-header with-border">
                                        <h4 class="box-title">Messagerie</h4>
                                    </div>
                                    <!-- /.box-header -->
                                    <div class="box-body">
                                        <!-- Nav tabs -->
                                        <ul
                                            class="nav nav-pills justify-content-end mb-20"
                                        >
                                            <li class=" nav-item">
                                                <a
                                                    href="#navpills2-1"
                                                    class="nav-link active"
                                                    data-toggle="tab"
                                                    aria-expanded="false"
                                                >
                                                    Réception
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a
                                                    href="#navpills2-2"
                                                    class="nav-link"
                                                    data-toggle="tab"
                                                    aria-expanded="false"
                                                >
                                                    Nouveau
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a
                                                    href="#navpills2-3"
                                                    class="nav-link"
                                                    data-toggle="tab"
                                                    aria-expanded="true"
                                                >
                                                    Boite d'envoi
                                                </a>
                                            </li>
                                        </ul>

                                        <div class="tab-content">
                                            <div
                                                id="navpills2-1"
                                                class="tab-pane active"
                                            >
                                                <div class="row">
                                                    <div class="col-md-8">
                                                        <div
                                                            class="slimScrollDiv"
                                                            style="position: relative; overflow: hidden; width: auto; height: 540px;"
                                                        >
                                                            <div
                                                                class="mailbox-messages inbox-bx"
                                                                style="overflow: hidden; width: auto; height: 540px;"
                                                            >
                                                                <div
                                                                    class="table-responsive"
                                                                >
                                                                    <table
                                                                        class="table table-hover table-striped"
                                                                    >
                                                                        <tbody>
                                                                            <tr
                                                                                v-for="(data,
                                                                                i) in MessagesParents"
                                                                                :key="
                                                                                    i
                                                                                "
                                                                            >
                                                                                <td>
                                                                                    <p
                                                                                        class="mailbox-name mb-0 font-size-16 font-weight-600"
                                                                                    >
                                                                                        <span
                                                                                            style="font-size:10px;"
                                                                                        >
                                                                                            Expéditeur
                                                                                            :
                                                                                        </span>

                                                                                        {{data.user.nom}}   {{data.user.prenom}} (Parent)


                                                                                    </p>
                                                                                     <router-link
                                                                                            to="detailsMessageReceiveByLocal"
                                                                                            class="mailbox-subject"
                                                                                        >
                                                                                            <p
                                                                                                @click="
                                                                                                    details(
                                                                                                        data,
                                                                                                        i
                                                                                                    )
                                                                                                "
                                                                                            >
                                                                                                {{
                                                                                                    data.messages.commentaires.slice(
                                                                                                        0,
                                                                                                        50
                                                                                                    )
                                                                                                }}...
                                                                                                <span
                                                                                                    style="color:rgb(38, 168, 243)"
                                                                                                    >Voir
                                                                                                    plus
                                                                                                </span>
                                                                                            </p>
                                                                                        </router-link>
                                                                                </td>
                                                                                <td
                                                                                    class="mailbox-attachment"
                                                                                >
                                                                                    <span
                                                                                        class="badge badge-danger"
                                                                                        v-if="
                                                                                            data.messages.statut ==
                                                                                                0
                                                                                        "
                                                                                    >
                                                                                        Non
                                                                                        lu
                                                                                    </span>
                                                                                    <span
                                                                                        class="badge badge-success"
                                                                                        v-if="
                                                                                            data.messages.statut ==
                                                                                                1
                                                                                        "
                                                                                    >
                                                                                        Lu
                                                                                    </span>
                                                                                </td>

                                                                                <td
                                                                                    class="mailbox-date"
                                                                                >
                                                                                    <span
                                                                                        class="badge badge-info"
                                                                                        >reçu
                                                                                        :{{
                                                                                            data.messages.date|dateFormatHeure
                                                                                        }}
                                                                                    </span>
                                                                                </td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                                <!-- /.table -->
                                                            </div>
                                                            <div
                                                                class="slimScrollBar"
                                                                style="background: rgb(0, 0, 0) none repeat scroll 0% 0%;
                                                                                   width: 7px; position: absolute; top: 0px; opacity: 0.4; display: none;
                                                                                   border-radius: 7px; z-index: 99; right: 1px; height: 468.058px;"
                                                            ></div>
                                                            <div
                                                                class="slimScrollRail"
                                                                style="width: 7px; height:
                                                                                    100%; position: absolute; top: 0px; display: none; border-radius: 7px;
                                                                                    background: rgb(51, 51, 51) none repeat scroll 0% 0%; opacity: 0.2; z-index: 90; right: 1px;"
                                                            >
                                                                <!-- /.mail-box-messages -->
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div
                                                id="navpills2-2"
                                                class="tab-pane"
                                            >
                                                <div class="row">
                                                    <div class="col-md-10">
                                                        <div class="row">
                                                            <div
                                                                class="col-md-6"
                                                            >
                                                                <div
                                                                    class="form-group"
                                                                >
                                                                    <label>
                                                                        Objet du
                                                                        message
                                                                    </label>
                                                                    <input
                                                                        type="text"
                                                                        class="form-control"
                                                                        v-model="
                                                                            data.objet
                                                                        "
                                                                    />
                                                                </div>
                                                            </div>
                                                            <div
                                                                class="col-md-6"
                                                            >
                                                                <div
                                                                    class="form-group"
                                                                >
                                                                    <label>
                                                                        Destinataires
                                                                    </label>
                                                                    <select
                                                                        v-model="
                                                                            data.destinataire
                                                                        "
                                                                        class="form-control"
                                                                    >

                                                                        <option
                                                                            value="Parents"
                                                                        >
                                                                            Parents
                                                                        </option>
                                                                        <option
                                                                            value="Enseignants"
                                                                        >
                                                                            Professeurs
                                                                        </option>
                                                                    </select>
                                                                </div>
                                                            </div>

                                                            <div
                                                                class="col-md-6"
                                                            >
                                                                <div
                                                                    class="form-group"
                                                                >
                                                                    <label
                                                                        for=""
                                                                    >
                                                                        Envoyer
                                                                        uniquement
                                                                        a une
                                                                        classe
                                                                        precise
                                                                        ?
                                                                    </label>
                                                                    <br />
                                                                    <RadioGroup
                                                                        v-model="
                                                                            data.tous
                                                                        "
                                                                        type="button"
                                                                        button-style="solid"
                                                                        @input="
                                                                            selected
                                                                        "
                                                                    >
                                                                        <Radio
                                                                            label="NON"
                                                                        ></Radio>
                                                                        <Radio
                                                                            label="OUI"
                                                                        ></Radio>
                                                                    </RadioGroup>
                                                                </div>
                                                            </div>

                                                            <div v-if="data.tous=='NON'"
                                                                class="col-md-6"
                                                            >
                                                                <div

                                                                    class="form-group"
                                                                >
                                                                    <div>
                                                                        <label
                                                                            class="typo__label"
                                                                            >Choisir
                                                                            la
                                                                            classe
                                                                            concernée
                                                                        </label>



                                                                        <select
                                                                            class="custom-select form-control required"
                                                                            v-model="
                                                                                data.classe
                                                                            "
                                                                        >
                                                                            <option
                                                                                v-for="(data,
                                                                                i) in classes"
                                                                                :key="
                                                                                    i
                                                                                "
                                                                                :value="
                                                                                    data.id
                                                                                "
                                                                            >
                                                                                {{
                                                                                    data.libelleClasse
                                                                                }}
                                                                            </option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div
                                                                class="col-md-12"
                                                            >
                                                                <div
                                                                    class="form-group"
                                                                >
                                                                    <label>
                                                                        Message
                                                                    </label>
                                                                    <textarea
                                                                        v-model="
                                                                            data.message
                                                                        "
                                                                        class="form-control"
                                                                        cols="3"
                                                                        rows="5"
                                                                    >
                                                                    </textarea>
                                                                </div>
                                                            </div>

                                                            <div
                                                                class="col-md-12"
                                                            >
                                                                <Upload
                                                                    multiple
                                                                    type="drag"
                                                                    action="api/admin/upload"
                                                                    :on-success="
                                                                        handleSuccess
                                                                    "
                                                                    :on-error="
                                                                        handleError
                                                                    "
                                                                    :format="[
                                                                        'jpg',
                                                                        'jpeg',
                                                                        'png',
                                                                        'pdf',
                                                                        'doc',
                                                                        'docx',
                                                                        'xls',
                                                                        'xlsx'
                                                                    ]"
                                                                    :max-size="
                                                                        2048
                                                                    "
                                                                    :on-format-error="
                                                                        handleFormatError
                                                                    "
                                                                    :on-exceeded-size="
                                                                        handleMaxSize
                                                                    "
                                                                    :headers="{
                                                                        'X-Requested-With':
                                                                            'XMLHttpRequest'
                                                                    }"
                                                                >
                                                                    <div
                                                                        style="padding: 20px 0"
                                                                    >
                                                                        <Icon
                                                                            type="ios-cloud-upload"
                                                                            size="52"
                                                                            style="color: #3399ff"
                                                                        ></Icon>
                                                                        <p
                                                                            class="text-center"
                                                                        >
                                                                            Joindre
                                                                            un
                                                                            fichier
                                                                        </p>
                                                                    </div>
                                                                </Upload>
                                                            </div> <br>

                                                            <div
                                                                class="col-md-12"
                                                            >
                                                                <div
                                                                    class="form-group"
                                                                >
                                                                    <button
                                                                        @click="
                                                                            sendMessage
                                                                        "
                                                                        class="btn btn-primary"
                                                                    >
                                                                        Envoyer
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div
                                                id="navpills2-3"
                                                class="tab-pane"
                                            >
                                                <div class="row">
                                                    <div class="col-md-8">
                                                        <div
                                                            class="slimScrollDiv"
                                                            style="position: relative; overflow: hidden; width: auto; height: 540px;"
                                                        >
                                                            <div
                                                                class="mailbox-messages inbox-bx"
                                                                style="overflow: hidden; width: auto; height: 540px;"
                                                            >
                                                                <div
                                                                    class="table-responsive"
                                                                >
                                                                    <table
                                                                        class="table table-hover table-striped"
                                                                    >
                                                                        <tbody>
                                                                            <tr
                                                                                v-for="(data,
                                                                                i) in messages"
                                                                                :key="
                                                                                    i
                                                                                "
                                                                            >
                                                                                <td>
                                                                                    <p
                                                                                        class="mailbox-name mb-0 font-size-16 font-weight-600"
                                                                                    >
                                                                                        <span
                                                                                            style="font-size:10px;"
                                                                                        >
                                                                                            Destinataire
                                                                                            :
                                                                                        </span>
                                                                                        {{
                                                                                            data.type_destinataire
                                                                                        }}
                                                                                    </p>


                                                                                    <router-link
                                                                                        class="mailbox-subject"
                                                                                        to="detailsMessageSendByLocal"
                                                                                    >
                                                                                        <p  @click="details(data,i)">


                                                                                       {{
                                                                                            data.messages.commentaires.slice(
                                                                                                0,
                                                                                                30
                                                                                            )
                                                                                        }}...
                                                                                        <span
                                                                                            style="color:rgb(38, 168, 243)"
                                                                                            >Voir
                                                                                            plus
                                                                                        </span>



                                                                                        </p>



                                                                                    </router-link>
                                                                                </td>

                                                                                <td
                                                                                    class="mailbox-date"
                                                                                >
                                                                                    <span
                                                                                        class="badge badge-info"
                                                                                    >
                                                                                        envoyé
                                                                                        :{{
                                                                                            data.messages.date|dateFormatHeure
                                                                                        }}
                                                                                    </span>
                                                                                </td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                                <!-- /.table -->
                                                            </div>
                                                            <div
                                                                class="slimScrollBar"
                                                                style="background: rgb(0, 0, 0) none repeat scroll 0% 0%;
                                                                                   width: 7px; position: absolute; top: 0px; opacity: 0.4; display: none;
                                                                                   border-radius: 7px; z-index: 99; right: 1px; height: 468.058px;"
                                                            ></div>
                                                            <div
                                                                class="slimScrollRail"
                                                                style="width: 7px; height:
                                                                                    100%; position: absolute; top: 0px; display: none; border-radius: 7px;
                                                                                    background: rgb(21, 68, 112) none repeat scroll 0% 0%; opacity: 0.2; z-index: 90; right: 1px;"
                                                            >
                                                                <!-- /.mail-box-messages -->
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.box-body -->
                                </div>
                                <!-- /.box -->
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
import Multiselect from "vue-multiselect";
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
    components: { Header, MenuLocal, Multiselect, Chats },

    async mounted() {
        if (localStorage.EtabInfos) {
            this.EtabInfos = JSON.parse(localStorage.getItem("EtabInfos"));
        }

        this.data.EtabInfos = this.EtabInfos;

        const response = await this.callApi(
            "post",
            "api/locale/getMessageEnvoyes",
            this.data
        );

        this.messages = response.data;

        const response2 = await this.callApi(
            "post",
            "api/locale/getClasseEtablissement",
            this.EtabInfos
        );

        this.classes = response2.data;

        const response4 = await this.callApi(
            "post",
            "api/locale/getMessageSendByParents",
             this.EtabInfos
        );

        this.MessagesParents = response4.data;
    },

    data() {
        return {
            data: {
                tous: "NON",
                objet: "",
                destinataire: "",
                message: "",
                classe: ""
            },

            messages: "",
            MessagesParents:'',
            EtabInfos: [],

            form: false,
            value: [],

            classes: "",

            imageEmploiTmp:'',

            options: [
                { name: "Vue.js", code: "vu" },
                { name: "Javascript", code: "js" },
                { name: "Open Source", code: "os" }
            ]

            // options : [

            // ]
        };
    },

    methods: {

        details(data,i) {

            localStorage.setItem('messagesendlocal', JSON.stringify(data));
            console.log(data);
        },
        addTag(newTag) {
            const tag = {
                name: newTag,
                code:
                    newTag.substring(0, 2) +
                    Math.floor(Math.random() * 10000000)
            };
            this.options.push(tag);
            this.value.push(tag);
        },

        selected() {
            if (this.data.tous == "OUI") {
                this.form = true;
            } else {
                this.form = false;
            }
        },
        async sendMessage() {
            if (this.data.objet.trim() == "") {
                return this.e("Saisir l'objet du message ");
            }
            if (this.data.destinataire.trim() == "") {
                return this.e("Choisir les destinataires ");
            }
            if (this.data.message.trim() == "") {
                return this.e("Saisir le contenu du  message ");
            }

            this.data.EtabInfos = this.EtabInfos;

            const response2 = await this.callApi(
                "post",
                "api/locale/sendMessage",
                this.data
            );
            if (response2.status == 200) {
                this.s("Message envoyé avec success");
                //this.$router.go();
            } else {
                this.e("Une erreure est survenue");
            }
        },

        async handleRemove(file) {
            const image = this.data;

            this.data.imageLogo = "";

            this.$refs.uploads.clearFiles();

            try {
                await axios.post("api/admin/delateImage", image);
            } catch (e) {
                this.generalError = e.response.data.errors;
            }
        },

        handleView(name) {
            this.data.imageLogo = name;
            this.visible = true;
        },

        handleSuccess(res, file) {
            this.data.imageEmploiTmp = res;
            console.log(res);
        },

        handleError(res, file) {
            this.w("Selectionner un jpg, png ou jpeg.");
        },
        handleFormatError(file) {
            this.w("Selectionner un jpg, png ou jpeg");
        },
        handleMaxSize(file) {
            this.w("Selctionner un fichier de moins de 2M.");
        },

        handleBeforeUpload() {
            const check = this.uploadList.length < 1;
            if (!check) {
                this.w("Le logo est requi...");
            }
            return check;
        }
    }
};
</script>

<style src="vue-multiselect/dist/vue-multiselect.min.css">
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
