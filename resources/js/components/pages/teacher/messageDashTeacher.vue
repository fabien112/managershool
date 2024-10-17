<template>
    <div>
        <div class="wrapper">
            <HeaderTeacher />
            <MenuTeacher />
            <div class="content-wrapper">
                <div class="container-full">
                    <section class="content">
                        <!-- tabs -->

                        <div class="row">
                            <div class="col-12">
                                <div class="box box-default">
                                    <div class="box-header with-border">
                                        <h4 class="box-title">Messagerie</h4>
                                    </div>
                                    <!-- /.box-header -->
                                    <div class="box-body">
                                        <!-- Nav tabs -->
                                        <div class="vtabs">
                                            <ul class="nav nav-tabs tabs-vertical" role="tablist">
                                                <!-- <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#home4" role="tab" aria-selected="false"><span class="hidden-sm-up"><i class="ion-home"></i></span> <span class="hidden-xs-down">Nouveau</span> </a> </li> -->
                                                <li class="nav-item">
                                                    <a class="nav-link active" data-toggle="tab" href="#profile4"
                                                        role="tab" aria-selected="true"><span class="hidden-sm-up"><i
                                                                class="ion-person"></i></span>
                                                        <span class="hidden-xs-down">Réception
                                                        </span></a>
                                                </li>
                                                <!-- <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#messages4" role="tab" aria-selected="false"><span class="hidden-sm-up"><i class="ion-email"></i></span> <span class="hidden-xs-down">Boite d'envoi </span></a> </li> -->
                                            </ul>
                                            <!-- Tab panes -->
                                            <div class="tab-content">

                                                <!-- <div
                                                    class="tab-pane"
                                                    id="home4"
                                                    role="tabpanel"
                                                >
                                                    <div class="p-15">
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
                                                                            la
                                                                            classe
                                                                            concernée
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
                                                                        rows="3"
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
                                                                            Send
                                                                        "
                                                                        class="btn btn-primary"
                                                                    >
                                                                        Envoyer
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div> -->

                                                <div class="tab-pane active" id="profile4" role="tabpanel">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="slimScrollDiv"
                                                                style="position: relative; overflow: hidden; width: auto; height: 540px;">
                                                                <div class="mailbox-messages inbox-bx"
                                                                    style="overflow: hidden; width:auto; height: 540px;">
                                                                    <div class="table-responsive">
                                                                        <table class="table table-hover table-striped">
                                                                            <tbody>
                                                                                <tr v-for="(data,
                                                                                i) in MessagesTeacher" :key="
        i
    ">
                                                                                    <td>
                                                                                        <h5
                                                                                            class="mailbox-name mb-0 font-size-16 font-weight-600">
                                                                                            <span
                                                                                                style="font-size:12px">
                                                                                                Objet
                                                                                                :
                                                                                                {{
                                                                                                    data
                                                                                                        .messages
                                                                                                        .object
                                                                                                }}
                                                                                            </span>
                                                                                        </h5>
                                                                                        <p
                                                                                            class="mailbox-name mb-0 font-size-16 font-weight-600">
                                                                                            <span
                                                                                                style="font-size:10px;">
                                                                                                Expediteur
                                                                                                :
                                                                                                {{
                                                                                                    data
                                                                                                        .user
                                                                                                        .nom
                                                                                                }}
                                                                                                {{
                                                                                                    data
                                                                                                        .user
                                                                                                        .prenom
                                                                                                }}
                                                                                                (Administrateur)
                                                                                            </span>
                                                                                        </p>

                                                                                        <router-link
                                                                                            to="detailsMessageTeacher"
                                                                                            class="mailbox-subject">
                                                                                            <p @click="
                                                                                                details(
                                                                                                    data,
                                                                                                    i
                                                                                                )
                                                                                            ">
                                                                                                {{
                                                                                                    data.messages.commentaires.slice(
                                                                                                        0,
                                                                                                        70
                                                                                                    )
                                                                                                }}...
                                                                                                <span
                                                                                                    style="color:rgb(38, 168, 243)">Voir
                                                                                                    plus
                                                                                                </span>
                                                                                            </p>
                                                                                        </router-link>
                                                                                    </td>
                                                                                    <td class="mailbox-attachment">
                                                                                        <span class="badge badge-danger"
                                                                                            v-if="
                                                                                                data
                                                                                                    .messages
                                                                                                    .statut ==
                                                                                                0
                                                                                            ">
                                                                                            Non
                                                                                            lu
                                                                                        </span>
                                                                                        <span
                                                                                            class="badge badge-success"
                                                                                            v-if="
                                                                                                data
                                                                                                    .messages
                                                                                                    .statut ==
                                                                                                1
                                                                                            ">
                                                                                            Lu
                                                                                        </span>
                                                                                    </td>

                                                                                    <td class="mailbox-date">
                                                                                        <span class="badge badge-info">
                                                                                            envoyé
                                                                                            :
                                                                                            {{
                                                                                                data
                                                                                                    .messages
                                                                                                    .date | dateFormatHeure
                                                                                            }}
                                                                                        </span>
                                                                                    </td>
                                                                                </tr>
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                    <!-- /.table -->
                                                                </div>
                                                                <div class="slimScrollBar"
                                                                    style="background: rgb(0, 0, 0) none repeat scroll 0% 0%;
                                                                                   width: 7px; position: absolute; top: 0px; opacity: 0.4; display: none;
                                                                                   border-radius: 7px; z-index: 99; right: 1px; height: 468.058px;">
                                                                </div>
                                                                <div class="slimScrollRail"
                                                                    style="width: 7px; height:
                                                                                    100%; position: absolute; top: 0px; display: none; border-radius: 7px;
                                                                                    background: rgb(51, 51, 51) none repeat scroll 0% 0%; opacity: 0.2; z-index: 90; right: 1px;">
                                                                    <!-- /.mail-box-messages -->
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- <div
                                                    class="tab-pane"
                                                    id="messages4"
                                                    role="tabpanel"
                                                >
                                                    <div class="p-15">
                                                        <h3>
                                                            Donec vitae laoreet
                                                            neque, id convallis
                                                            ante.
                                                        </h3>
                                                        <p>
                                                            Duis cursus eros
                                                            lorem, pretium
                                                            ornare purus
                                                            tincidunt eleifend.
                                                            Etiam quis justo
                                                            vitae erat faucibus
                                                            pharetra. Morbi in
                                                            ullamcorper diam.
                                                            Morbi lacinia, sem
                                                            vitae dignissim
                                                            cursus, massa nibh
                                                            semper magna, nec
                                                            pellentesque lorem
                                                            nisl quis ex.
                                                        </p>
                                                        <h4>
                                                            Fusce porta eros a
                                                            nisl varius, non
                                                            molestie metus
                                                            mollis. Pellentesque
                                                            tincidunt ante sit
                                                            amet ornare lacinia.
                                                        </h4>
                                                    </div>
                                                </div> -->
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
                users: ""
            },

            MessagesTeacher: []
        };
    },



    methods: {
        details(data, i) {
            localStorage.setItem("messageTeach", JSON.stringify(data));

            console.log(data);
        }
    },

    async mounted() {
        if (localStorage.users) {
            this.users = JSON.parse(localStorage.getItem("users"));
        }

        const response = await this.callApi(
            "post",
            "api/parent/getMessagesTeacher",
            this.users
        );

        this.MessagesTeacher = response.data;
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
