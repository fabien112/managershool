<template>
    <div>
        <div class="wrapper">
            <Header />
            <MenuParent />
            <div class="content-wrapper">
                <div class="container-full">
                    <section class="content">

                        <div class="row">
                            <div class="col-xl-9 col-12" >
                                <div class="box">
                                    <div
                                        class="box-header bg-primary "
                                        style="text-align: center;"
                                    >
                                        <p class="box-title">
                                            <strong>

                                               {{DevoirsListes.titre.toUpperCase()}} <br>

                                            </strong>
                                        </p>
                                    </div>
                                    <div class="box-body">
                                        <div class="table-responsive">
                                            <table class="table simple mb-0">
                                                <tbody>
                                                    <tr  v-for="(data, i) in DevoirsListes.partie" :key="i">
                                                        <td>


                                                            <span class="btn btn-xs" style="background-color:#0052CC;color:white" >
                                                            {{data.partie.toUpperCase()}} <br>
                                                            </span>


                                                            <ol style="padding-left:35px">
                                                                 <li  v-for="(data1, i) in data.sp['sous']" :key="i">

                                                                 {{data1}}

                                                                </li>
                                                            </ol>

                                                        </td>
                                                    </tr>

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <!-- <div class="box-footer">
                                        <a  :href="
                                                    `/Photos/Logos/${data.document}`

                                                "
                                                :download="
                                                    data.classe.libelleClasse
                                                "
                                            ><button
                                                class="btn btn-success btn-sm"
                                            >
                                                <Icon
                                                    type="md-download"
                                                />Télécharger  le cours
                                            </button></a
                                        >



                                    </div> -->
                                </div>
                            </div>

                            <div class="col-xl-3 col-12" >
                                <div class="box">
                                    <div
                                        class="box-header bg-success "
                                        style="text-align: center;"
                                    >
                                        <p class="box-title">
                                            <strong>

                                               Durée du cour

                                            </strong>
                                        </p>
                                    </div>
                                    <div class="box-body">
                                        <div class="table-responsive">
                                            <table class="table simple mb-0">
                                                <tbody>


                                                        <p style="text-align:center"> <strong>{{DevoirsListes.duree}}</strong> h </p>




                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <!-- <div class="box-footer">
                                        <a  :href="
                                                    `/Photos/Logos/${data.document}`

                                                "
                                                :download="
                                                    data.classe.libelleClasse
                                                "
                                            ><button
                                                class="btn btn-success btn-sm"
                                            >
                                                <Icon
                                                    type="md-download"
                                                />Télécharger  le cours
                                            </button></a
                                        >



                                    </div> -->
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
import MenuParent from "../../navs/MenuParent.vue";
import Chats from "../../navs/Chats.vue";
import { mapState } from "vuex";


export default {

    components: { Header,  Chats, MenuParent },

   data() {
        return {
            data: {

                'idTexte':"",

            },
            datasEnfants: "",
            DevoirsListes: "",

        };
    },

    async mounted() {

        if (localStorage.datasEnfant) {

            this.data.idTexte = JSON.parse(localStorage.getItem("idCahierTexte"));

        }

            const response = await this.callApi(
            "post",
            "api/parent/getDetailsCahierTexte",
            this.data
        );

        this.DevoirsListes = response.data;

        console.log(this.DevoirsListes);
    },

    methods: {


    }
};
</script>
