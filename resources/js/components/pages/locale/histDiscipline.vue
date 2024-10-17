<template>

    <div>
        <div class="wrapper">
            <Header />
            <MenuLocal />
            <div class="content-wrapper">
                <div class="container-full">
                    <section class="content">
                        <!-- START Card With Image -->
                        <!-- <div class="card">
                            <div class="card-header">
                                <h4 class="card-title"> LISTING DES ABSENCES

                                </h4>

                            </div>
                        </div> -->

                        <!-- Modal de modification -->

                        <Modal v-model="EdetingModal" title="Modifier  une cension ">
                            <div class="row">


                                <div class="col-md-12">
                                    <label class="form-label">
                                        Motif
                                    </label>
                                    <input type="text" class="form-control" v-model.trim="
                                        data.motif
                                    " />
                                </div>


                            </div> <br>
                            <div class="row">
                                <div class="col-md-12">
                                    <label class="form-label"> Durée en heure
                                    </label>
                                    <input type="number" class="form-control" v-model="
                                        data.duree
                                    " />
                                </div>
                            </div>



                            <br />

                            <div slot="footer">
                                <Button type="primary" size="large" long @click="Update()">Enregistrer</Button>
                            </div>
                        </Modal>

                        <!-- Modal de suppression -->

                        <Modal v-model="showDelateModal" width="360">
                            <p slot="header" style="color:#f60;text-align:center">
                                <span> Suppression </span>
                            </p>
                            <div style="text-align:center">
                                <p>Etes-vous sure de vouloir supprimer ?</p>
                            </div>
                            <div slot="footer">
                                <Button type="error" size="large" long @click="delateAbsence">Confirmer</Button>
                            </div>
                        </Modal>


                        <div class="row">


                            <div class="col-6">
                                <div class="box no-shadow mb-0 bg-transparent">
                                    <div class="box-header no-border px-0">
                                        <Alert fade=true show-icon closable>

                                            Total consigne annuelle

                                            <template slot="desc">
                                                {{ this.TrimestreListes.totalCon}} heure(s)
                                            </template>
                                        </Alert>
                                    </div>
                                </div>
                            </div>

                            <div class="col-6">
                                <div class="box no-shadow mb-0 bg-transparent">
                                    <div class="box-header no-border px-0">
                                        <Alert type="error" fade=true show-icon closable>

                                            Total exclusion annuelle
                                            <template slot="desc">
                                                 {{ this.TrimestreListes.totalExc}} Jour(s)
                                            </template>
                                        </Alert>
                                    </div>
                                </div>
                            </div>



                        </div>

                        <div class="row" >


                            <div class="col-6">
                                <!-- /.box -->

                                <div class="box">
                                    <div class="box-header bg-primary">
                                        <h4 class="box-title" style="margin:auto;text-align: center;">
                                            Historique des consignes



                                        </h4>
                                    </div>


                                    <div class="box-body">
                                        <div class="table-responsive">
                                            <table id="example" class="table simple mb-0" style="width:100%">
                                                <thead>
                                                    <tr>

                                                        <th> Date  </th>
                                                        <th> Motif </th>
                                                        <th> Durée  </th>
                                                        <!-- <th></th> -->
                                                    </tr>
                                                </thead>
                                                <tbody name="fruit-table" is="transition-group">
                                                    <tr v-for="(data,
                                                    i) in TrimestreListes.infosCon" :key="i">
                                                        <td>
                                                            {{
                                                                    data.created_at | dateFormat
                                                            }}
                                                        </td>
                                                        <td>   {{data.motif}}</td>



                                                        <td>
                                                            {{
                                                                    data.duree
                                                            }} h
                                                        </td>

                                                        <!-- <td>

                                                            <button @click="showEdetingModal(data, i)"
                                                                class=" btn btn-primary btn-sm">
                                                                <Icon type="md-create" />
                                                            </button>

                                                            <button @click="showDelatingModal(data, i)"
                                                                class="btn btn-danger btn-sm">
                                                                <Icon type="md-trash" />
                                                            </button>

                                                        </td> -->

                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <!-- /.box-body -->
                                </div>
                                <!-- /.box -->
                            </div>

                             <div class="col-6">
                                <!-- /.box -->

                                <div class="box">
                                    <div class="box-header bg-danger">
                                        <h4 class="box-title" style="margin:auto;text-align: center;">
                                            Historique des exclusions

                                        </h4>
                                    </div>


                                     <div class="box-body">
                                        <div class="table-responsive">
                                            <table id="example" class="table simple mb-0" style="width:100%">
                                                <thead>
                                                    <tr>

                                                        <th> Date  </th>
                                                        <th> Motif </th>
                                                        <th> Durée  </th>
                                                        <!-- <th></th> -->
                                                    </tr>
                                                </thead>
                                                <tbody name="fruit-table" is="transition-group">
                                                    <tr v-for="(data,
                                                    i) in TrimestreListes.infosEx" :key="i">
                                                        <td>
                                                            {{
                                                                    data.created_at | dateFormat
                                                            }}
                                                        </td>
                                                        <td>
                                                            {{data.motif}}
                                                        </td>



                                                        <td>
                                                            {{
                                                                    data.duree
                                                            }} jr(s)
                                                        </td>

                                                        <!-- <td>

                                                            <button @click="showEdetingModal(data, i)"
                                                                class=" btn btn-primary btn-sm">
                                                                <Icon type="md-create" />
                                                            </button>

                                                            <button @click="showDelatingModal(data, i)"
                                                                class="btn btn-danger btn-sm">
                                                                <Icon type="md-trash" />
                                                            </button>

                                                        </td> -->

                                                    </tr>
                                                </tbody>
                                            </table>
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

                idPresence: "",
                date: "",
                duree: "",
                idTrimestre: ""

            },

            data2: {

                idEleve : "",

            },

            idEleve : '',
            EdetingModal: false,
            showDelateModal: false,
            keyword: "",
            keyword2: "",
            keyword3: "",
            ClasseListes: "",
            TrimestreListes: "",
            EleveListes: "",
            ElevesAbsences: {
                'sommmeTrimetre': 0,
                'sommeAnnee': 0,

            },
            TotalHeure: 0,
            showRecap: false,
            i: -1,
            users:""
        };


    },


    async created() {

        if (!localStorage.users) {

            this.$router.push('login');
        }

         if (localStorage.idEleveDiscipline) {

           this.data2.idEleve = JSON.parse(localStorage.getItem("idEleveDiscipline"))
        }

        if (localStorage.users) {
            this.users = JSON.parse(localStorage.getItem("users"));
        }



        if (localStorage.EtabInfos) {
            this.EtabInfos = JSON.parse(localStorage.getItem("EtabInfos"));
        }



        // Allons chercher les trimestre

        const response3 = await this.callApi(
            "post",
            "api/locale/getAlldiscipline",
            this.data2

        );

        this.TrimestreListes = response3.data;


    },

    methods: {

        showDelatingModal(data, i) {
            this.delateItem = data;
            this.i = i;
            this.showDelateModal = true;
        },

        showEdetingModal(data, i) {



            this.EdetingModal = true
            this.i = i;
            this.delateItem = data;

            this.data.duree = data.duree

            this.data.idPresence = data.id

            this.data.motif = data.motif

        },

        async onChange(event) {

            this.data.idClasse = event.target.value;

            // Recuperer tous les eleves de cette classe

            const response3 = await this.callApi(
                "post",
                "api/locale/getEleveclasseById", this.data
            );

            this.EleveListes = response3.data

        },

         async delateAbsence() {

            //console.log(this.delateItem.duree);
            const response = await axios.post(
                "api/locale/delateCension",
                this.delateItem
            );

            if (response.status === 200) {
                // this.ElevesAbsences.listeTrimestre.splice(this.i, 1);
                this.showDelateModal = false;
                this.s("Cension supprimée correctement");

               this.$router.go();


            }
            // this.modal2 = false;
        },


        async Update () {

            //console.log(this.delateItem.duree);

            if (this.data.duree.trim() == ""|| this.data.duree < 1) {

                this.e("Cette valeur est incorrecte ");

            }


            const response = await axios.post(
                "api/locale/updateCension",
                this.data
            );

            if (response.status === 200) {
                this.EdetingModal = false;
                this.s("Cension modifiée correctement");

                   this.$router.go();

            }



        },







    },


};
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
