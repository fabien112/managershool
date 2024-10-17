<template>
    <div>
        <div class="wrapper">
            <Header />
            <MenuLocal />

            <div class="content-wrapper">
                <div class="container-full">
                    <section class="content">


                        <br />

                        <div class="row">
                            <div class="col-md-12 col-lg-12">
                                <div class="row">
                                    <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for=""> TRIMESTRE </label>

                                                    <select v-model="
                                                        datas.libelleEvaluation
                                                    " class="custom-select form-control required">
                                                        <option v-for="(data,
                                                        i) in Evaluation" :key="i" :value="data.id">
                                                            {{ data.libelle_semes }}
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for=""> Classe </label>
                                            <select @change="onChange($event)" v-model="datas.classeName"
                                                class="custom-select form-control required">
                                                <option v-for="(data,
                                                i) in ClassListes" :key="i" :value="data.id">
                                                    {{
                                                            data.libelleClasse
                                                    }}
                                                </option>
                                            </select>
                                        </div>
                                    </div>


                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <button @click="afficher"
                                                class="waves-effect waves-light btn mb-5  btn btn-primary">
                                                Envoyer
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row" v-if="rempli == true">
                            <div class="col-6">
                                <div class="box no-shadow mb-0 bg-transparent">
                                    <div class="box-header no-border px-0">
                                        <Alert type="success" fade=true show-icon closable>
                                            Taux de réussite dans tout l'établissement :
                                            <template slot="desc">
                                                {{ Notes.porcentageAdmisEcole }} %
                                            </template>

                                        </Alert>
                                    </div>
                                </div>
                            </div>

                            <div class="col-6">
                                <div class="box no-shadow mb-0 bg-transparent">
                                    <div class="box-header no-border px-0">
                                        <Alert type="error" fade=true show-icon closable>
                                            Taux d'échec dans tout l'établissement :
                                            <template slot="desc">
                                                {{
                                                        Math.round((100 - Notes.porcentageAdmisEcole) * 100) / 100
                                                }} %
                                            </template>

                                        </Alert>
                                    </div>
                                </div>
                            </div>

                            <div class="col-6">

                                <div class="card">

                                    <div class="card-header bg-success" color="primary">
                                        Meilleur(e) élève de l'établissement
                                    </div>



                                    <div class="card-body">
                                        <img :src="
                                            `/Photos/Logos/${Notes.eleveMaxEcole.photo.user.photo}`
                                        " alt="" width="80" height="80" />

                                        <ul class="list-group list-group-flush">
                                            <li class="list-group-item"> Noms : {{ Notes.eleveMaxEcole.student.nom }} {{
                                                    Notes.eleveMaxEcole.student.prenom
                                            }}</li>
                                            <li class="list-group-item"> Moyenne : {{ Notes.eleveMaxEcole.valeur }} / 20
                                            </li>
                                            <li class="list-group-item"> Classe : {{
                                                    Notes.eleveMaxEcole.photo.classe.libelleClasse
                                            }}</li>

                                        </ul>


                                    </div>


                                </div>




                            </div>

                            <div class="col-6">

                                <div class="card">

                                    <div class="card-header bg-danger">
                                        Dernier(e) élève de l'établissement
                                    </div>



                                    <div class="card-body">

                                        <img :src="
                                            `/Photos/Logos/${Notes.eleveMinEcole.photo.user.photo}`
                                        " alt="" width="80" height="80" />

                                        <ul class="list-group list-group-flush">
                                            <li class="list-group-item"> Noms : {{ Notes.eleveMinEcole.student.nom }} {{
                                                    Notes.eleveMinEcole.student.prenom
                                            }} </li>
                                            <li class="list-group-item"> Moyenne : {{ Notes.eleveMinEcole.valeur }} / 20
                                            </li>
                                            <li class="list-group-item"> Classe : {{
                                                    Notes.eleveMinEcole.photo.classe.libelleClasse
                                            }}</li>

                                        </ul>



                                    </div>

                                </div>



                            </div>

                            <div class="col-6">

                                <div class="card">

                                    <div class="card-header bg-primary">
                                        Meilleur(e) élève de la classe
                                    </div>

                                    <div class="card-body">
                                        <img :src="
                                            `/Photos/Logos/${Notes.eleveMax.photo.user.photo}`
                                        " alt="" width="80" height="80" />

                                        <ul class="list-group list-group-flush">
                                            <li class="list-group-item"> Noms : {{ Notes.eleveMax.student.nom }}
                                                {{ Notes.eleveMax.student.prenom }}</li>
                                            <li class="list-group-item"> Moyenne : {{ Notes.eleveMax.valeur }} / 20
                                            </li>

                                        </ul>
                                    </div>


                                </div>

                            </div>

                            <div class="col-6">

                                <div class="card">

                                    <div class="card-header bg-danger" color="primary">
                                        Dernier(e) élève de la classe
                                    </div>



                                    <div class="card-body">

                                        <img :src="
                                            `/Photos/Logos/${Notes.eleveMin.photo.user.photo}`
                                        " alt="" width="80" height="80" style="margin:auto" />


                                        <ul class="list-group list-group-flush">
                                            <li class="list-group-item"> Noms : {{ Notes.eleveMin.student.nom }}
                                                {{ Notes.eleveMin.student.prenom }}</li>
                                            <li class="list-group-item"> Moyenne : {{ Notes.eleveMin.valeur }} / 20
                                            </li>

                                        </ul>
                                    </div>

                                </div>

                            </div>

                        </div>

                        <br><br>


                        <div class="row" v-if="rempli == true">


                            <div class="col-xl-6 col-12">
                                <div class="box">
                                    <div class="box-header bg-primary " style="text-align: center;">
                                        <h4 class="box-title">
                                            <strong>
                                                Pourcentage de réuissite de la classe
                                            </strong>
                                        </h4>
                                    </div>
                                    <div class="box-body">
                                        <div class="table-responsive">
                                            <table class="table simple mb-0">
                                                <tbody>
                                                    <tr>
                                                        <td>Globale </td>
                                                        <td class=" font-weight-700">

                                                            {{ (Notes.nbreAllAdmis) }} admi(s) sur {{ (Notes.nbreAll) }}
                                                            élèves soit {{ Notes.pourcetageAlladmis }} %

                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td>Garçons </td>
                                                        <td class=" font-weight-700">

                                                            {{ (Notes.numberGarconAdmis) }} garçon(s) admis sur
                                                            {{ (Notes.numberGarcon) }} soit {{ Notes.pourcentgarconAdmis
                                                            }}
                                                            %


                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td> Filles </td>
                                                        <td class=" font-weight-700">

                                                            {{ (Notes.nombreFilleAdmis) }} fille(s) admise(s) sur
                                                            {{ (Notes.nombreFille) }} soit {{ Notes.pourcentfilleAdmis
                                                            }} %


                                                        </td>
                                                    </tr>

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="col-xl-6 col-12">
                                <div class="box">
                                    <div class="box-header bg-danger " style="text-align: center;">
                                        <h4 class="box-title">
                                            <strong>
                                                Pourcentage d'echec de la classe
                                            </strong>
                                        </h4>
                                    </div>
                                    <div class="box-body">
                                        <div class="table-responsive">
                                            <table class="table simple mb-0">
                                                <tbody>
                                                    <tr>
                                                        <td>Globale </td>
                                                        <td class=" font-weight-700">

                                                            {{ (Notes.nbreAll - Notes.nbreAllAdmis) }} échoué(s) sur
                                                            {{ (Notes.nbreAll) }} élèves soit {{
                                                                    Math.round((100 - Notes.pourcetageAlladmis) * 100) / 100
                                                            }} %

                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td>Garçons </td>
                                                        <td class=" font-weight-700">

                                                            {{ (Notes.numberGarcon - Notes.numberGarconAdmis) }}
                                                            garçon(s)
                                                            échoué(s) sur {{ (Notes.numberGarcon) }} soit
                                                            {{ Math.round((((Notes.numberGarcon -
                                                                    Notes.numberGarconAdmis) / Notes.numberGarcon)) * 100
                                                                    * 100) / 100
                                                            }} %


                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td> Fille </td>
                                                        <td class=" font-weight-700">


                                                            {{ (Notes.nombreFille) - (Notes.nombreFilleAdmis) }}
                                                            fille(s)
                                                            échouée(s) sur {{ (Notes.nombreFille) }} soit
                                                            {{ Math.round(PourcenatgeFilleEchoue * 100) / 100 }} %

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
            datas: {
                classeName: "",
                idClasse: "",
                libelleEvaluation: "",
                matiere: "",
                trimestre: ""
            },

            datasEdit: {
                note: "",
                mention: "",
                idNote: "",
            },
            PourcenatgeFilleEchoue: 0,

            Note: {},
            Obser: {},
            i: 1,
            showDelateModal: false,
            EdetingModal: false,
            LIbelleMatiereclasse: "",
            checkedNames: [],
            checkBoxs: [],
            rempli: false,
            users: [],
            ClassListes: [],
            MatieresListes: [],
            Notes: [],
            Evaluation: [],
            delateItem: '',
            show: false
        };
    },

    async mounted() {

        if (!localStorage.users) {

            this.$router.push('login');
        }

        if (localStorage.EtabInfos) {
            this.EtabInfos = JSON.parse(localStorage.getItem("EtabInfos"));
        }

        // Recuperer toutes les sessions de cette ecole

        const response2 = await this.callApi(
            "post",
            "api/locale/getClasseEtablissement",
            this.EtabInfos
        );

        this.ClassListes = response2.data;

        this.ClassListes = this.ClassListes.filter(item => item.eleves.length > 0)


        const response4 = await this.callApi(
            "post",
            "api/locale/getTrimestreEtablissement",
            this.EtabInfos
        );
        this.Evaluation = response4.data[0].trimestres;



    },
    methods: {

        showEdetingModal(data, i) {

            this.EdetingModal = true
            this.i = i;
            this.delateItem = data;
            this.datasEdit.note = data.valeur
            this.datasEdit.mention = data.mention
            this.datasEdit.eleveId = data.id
            this.datasEdit.reste = this.datas

        },

        async Update() {

            //console.log(this.delateItem.duree);

            if (this.datasEdit.note == "" || this.datasEdit.note == null) {

                this.e("Saisir une note valide");

            }

            //  if (this.datasEdit.mention == "") {

            //     this.e("Saisir une mention ");

            // }

            else {



                this.datasEdit.idNote = this.delateItem.idNote
                const response = await axios.post(
                    "api/teacher/updateNote",
                    this.datasEdit
                );



                if (response.status === 200) {
                    this.EdetingModal = false;

                    const response2 = await this.callApi(
                        "post",
                        "api/teacher/getStudentByTeacherVoirNote",
                        this.datas
                    );

                    this.Notes = response2.data;

                    this.s("Note modifiée correctement");



                    //   this.$router.go();

                }


            }



        },
        async onChange(event) {

            this.datas.idClasse = event.target.value;

            this.datas.EtabInfos = this.EtabInfos;

            // Recuperer toutes les matieres de cette  classe

            const response3 = await this.callApi(
                "post",
                "api/locale/getLibelleMatiereclasseLocaleById",
                this.datas
            );

            this.LIbelleMatiereclasse = response3.data;
        },

        ShowModal() {
            this.showDelateModal = true;
        },

        async afficher() {

            if (this.datas.libelleEvaluation == "") {
                return this.e("Sélectionner  un trimestre  ");
            }

            if (this.datas.classeName == "") {
                return this.e("Sélectionner  une classe ");
            }



            const response2 = await this.callApi(
                "post",
                "api/locale/getStatClasseTrimestre",
                this.datas
            );

            if (response2.status != 200) {

                return this.e("Les moyennes des élèves de cette classe n’ont pas encore été calculées pour cette évaluation  ")
            }

            if (response2.status == 200) {

                this.Notes = response2.data;


                if (this.Classes == "") {
                    this.rempli = false;
                } else {
                    this.rempli = true;
                }


            }


        },


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
