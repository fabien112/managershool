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
                                                    > Boite de reception
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a
                                                    href="#navpills2-2"
                                                    class="nav-link"
                                                    data-toggle="tab"
                                                    aria-expanded="false"
                                                >

                                                Nouveau messsage

                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a
                                                    href="#navpills2-3"
                                                    class="nav-link"
                                                    data-toggle="tab"
                                                    aria-expanded="true"
                                                >
                                                    Messsages envoyés</a
                                                >
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
                                                                                        <tr v-for="(data,  i) in messages" :key="i">


                                                                                            <td>
                                                                                                <p
                                                                                                    class="mailbox-name mb-0 font-size-16 font-weight-600"
                                                                                                >
                                                                                                 <span style="font-size:10px;"> Destinataire : </span> {{data.destinataires}}
                                                                                                </p>
                                                                                                <a
                                                                                                    class="mailbox-subject"
                                                                                                    href="#"
                                                                                                    >
                                                                                                    <!-- <b>LoremIpsum</b >  - -->

                                                                                                    {{data.commentaires}}</a
                                                                                                >
                                                                                            </td>
                                                                                            <td
                                                                                                class="mailbox-attachment"
                                                                                            >
                                                                                               <span class="badge badge-danger" v-if="data.statut==0"> Non lu </span>
                                                                                                <span class="badge badge-success" v-if="data.statut==1"> Lu </span>
                                                                                            </td>

                                                                                            <td
                                                                                                class="mailbox-date"
                                                                                            >
                                                                                                <span class="badge badge-info" >reç :{{data.date}} </span>
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
                                                                            value=""
                                                                        >
                                                                        </option>
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
                                                                        a
                                                                        certaines
                                                                        classes
                                                                        precises
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

                                                            <div
                                                                class="col-md-6"
                                                            >
                                                                <div
                                                                    v-if="
                                                                        form ==
                                                                            true
                                                                    "
                                                                    class="form-group"
                                                                >
                                                                    <div>
                                                                        <label
                                                                            class="typo__label"
                                                                            >Choisir
                                                                            les
                                                                            classes
                                                                            concernées
                                                                        </label>

                                                                        <multiselect
                                                                            v-model="
                                                                                value
                                                                            "
                                                                            :placeholder="
                                                                                ''
                                                                            "
                                                                            :selected-label="
                                                                                'Sélectionnée par défault'
                                                                            "
                                                                            :select-label="
                                                                                ' '
                                                                            "
                                                                            :deselect-label="
                                                                                ' '
                                                                            "
                                                                            label="name"
                                                                            track-by="code"
                                                                            :options="
                                                                                options
                                                                            "
                                                                            :multiple="
                                                                                true
                                                                            "
                                                                            :taggable="
                                                                                true
                                                                            "
                                                                            @tag="
                                                                                addTag
                                                                            "
                                                                        ></multiselect>
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
                                                                                        <tr v-for="(data,  i) in messages" :key="i">


                                                                                            <td>
                                                                                                <p
                                                                                                    class="mailbox-name mb-0 font-size-16 font-weight-600"
                                                                                                >
                                                                                                 <span style="font-size:10px;"> Destinataire : </span> {{data.destinataires}}
                                                                                                </p>
                                                                                                <a
                                                                                                    class="mailbox-subject"
                                                                                                    href="#"
                                                                                                    >
                                                                                                    <!-- <b>LoremIpsum</b >  - -->

                                                                                                    {{data.commentaires | truncate(8, '...')}}</a
                                                                                                >
                                                                                            </td>

                                                                                            <td
                                                                                                class="mailbox-date"
                                                                                            >
                                                                                                <span class="badge badge-info" > envoyé :{{data.date}} </span>
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

//    filters: {
//         truncate: function (text, length, suffix) {
//             if (text.length > length) {
//                 return text.substring(0, length) + suffix;
//             } else {
//                 return text;
//             }
//         },
//     },

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

        this.messages = response.data
    },

    data() {
        return {
            data: {
                tous: "NON",
                objet: "",
                destinataire: "",
                message: ""
            },

            messages:'',

            EtabInfos: [],

            form: false,
            value: [{ name: "Javascript", code: "js" }],
            options: [
                { name: "Vue.js", code: "vu" },
                { name: "Javascript", code: "js" },
                { name: "Open Source", code: "os" }
            ]
        };
    },

    methods: {
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
            } else {
                this.e("Une erreure est survenue");
            }
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
