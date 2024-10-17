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

                                <!-- /.box -->

                                <div class="box">
                                    <div class="box-header">
                                        <h4 class="box-title"> Envoi des notes <br>

                                        </h4>
                                    </div>
                                    <!-- /.box-header -->
                                    <div class="box-body">


                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for=""> Classe </label>

                                                    <!-- <input type="text" class="form-control required"
                                                        v-model="data.siteInternetEtablissement" /> -->

                                                    <select class="custom-select form-control required" v-model="data.classe
                                                        ">
                                                        <option v-for="(data,
                                                            i) in classes" :key="i
        " :value="data.id
        ">
                                                            {{
                                                                data.libelleClasse
                                                            }}
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="">
                                                        TRIMESTRE
                                                    </label>

                                                    <select v-model="data.libelleEvaluation
                                                        " class="custom-select form-control required">
                                                        <option v-for="(data,
                                                            i) in Evaluation" :key="i" :value="data.id">
                                                            {{
                                                                data.libelle_semes
                                                            }}
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- <textarea v-model="msg" class="textarea" placeholder="Ecrire votre message  ici "
                                            maxLength="160"
                                            style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;">

					</textarea> <br>

                                        <p></p>
                                        <p></p>
                                        <p v-if="msg.length > 0"
                                            style="color:rgb(48, 102, 164)(56, 60, 64);font-family:italic;">

                                            Il reste {{ 160 - msg.length }} caracteres
                                        </p>

                                        <p></p>
                                        <p></p> -->

                                        <button class="btn btn-primary" @click="SendAffciher"> Afficher </button>




                                        <br> <br> <br> <br>

                                        {{ classeListe.length }}


                                        <div class="box-body">
                                            <div class="table-responsive">
                                                <table class="table product-overview">
                                                    <thead>
                                                        <tr>

                                                            <th>Eleve </th>
                                                            <th>Note </th>
                                                            <th>Absence</th>
                                                            <th>Parent </th>
                                                            <th>Telephone</th>


                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr v-for="(data,
                                                            i) in classeListe" :key="i">









                                                            <td>

                                                                {{ data.nom }} {{
                                                                    data.prenom
                                                                }}


                                                            </td>

                                                            <td>

                                                                {{ data.valeur }}


                                                            </td>
                                                            <td>

                                                                {{ data.duree }}



                                                            </td>

                                                            <td>

                                                                {{ data.nomParent }} {{
                                                                    data.prenomParent
                                                                }}


                                                            </td>

                                                            <td>

                                                                {{ data.telParent }}



                                                            </td>



                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <button class="btn btn-primary  btn-block" @click="Send"> Envoyer </button>

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
            UserData: [],

            msg: "",

            data: {
                'classe': " ",
                'libelleEvaluation': "",
                'student_id': ""



            },

            EtabInfos: "",

            classes: '',
            Evaluation: "",
            libelleEvaluation: "",
            classeListe: ""


        };
    },


    async mounted() {

        if (!localStorage.users) {

            this.$router.push('login');
        }

        // Recuperer toutes les infos de cette ecole dans le storage

        if (localStorage.EtabInfos) {

            this.EtabInfos = JSON.parse(localStorage.getItem("EtabInfos"));
        }


        const response2 = await this.callApi(
            "post",
            "api/locale/getClasseEtablissement",
            this.EtabInfos
        );

        this.classes = response2.data;



        const response4 = await this.callApi(
            "post",
            "api/locale/getTrimestreEtablissement",
            this.EtabInfos
        );

        this.Evaluation = response4.data[0].trimestres;


    },

    methods: {


        async Send() {
            try {
                const promises = this.classeListe.map(student => this.callApi("post", "api/local/sms", student));
                const responses = await Promise.all(promises);

                for (const response of responses) {
                    if (response.status === 200) {
                        console.log(response);
                        this.classeListe.shift();
                        // this.$router.push("notesTeacher");
                    } else {
                        console.error("Error sending SMS for student:", student);
                    }
                }
            } catch (error) {
                console.error("Error during API calls:", error);
            }
        }

        ,


        async SendAffciher() {


            console.log(this.data)

            const response = await this.callApi(
                "post",
                "api/locale/getParentByIdClasse",
                this.data
            );
            if (response.status == 200) {

                this.classeListe = response.data



            }
        }








    }
};
</script>

<style>
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
