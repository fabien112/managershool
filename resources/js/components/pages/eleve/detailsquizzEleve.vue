<template>
    <div>
        <div class="wrapper">
            <Header />
            <MenuEleve />
            <div class="content-wrapper">
                <div class="container-full">
                    <section class="content">

            <Modal v-model="PosterModal" width="360">
                    <p slot="header" style="color:rgb(235, 18, 54);text-align:center">
                    <Icon type="ios-information-circle"></Icon>
                    <span> Confirmation   </span>
                    </p>
                    <div style="text-align:center">
                    <p> Etes-vous sure de vouloir envoyer ce quizz  ?  </p>

                    </div>
                    <div slot="footer">
                        <Button type="error" size="large" long  @click="Poster">Confirmer</Button>
                    </div>
             </Modal>

                <Modal v-model="DemarerMolad" width="360">

                    <p slot="header" style="color:rgb(235, 18, 54);text-align:center">
                    <Icon type="ios-information-circle"></Icon>
                    <span> Confirmation   </span>
                    </p>
                    <div style="text-align:center">
                    <p> Etes-vous sure de vouloir commencer  ce quizz  ?  </p>

                    </div>
                    <div slot="footer">
                        <Button type="error" size="large" long  @click="Demmarer"> Confirmer </Button>
                    </div>

             </Modal>
                        <div class="row">

                            <div class="col-xl-6 col-6" v-if="correcStat!=0">

                                  <div class="box" >
                                    <div
                                        class="box-header bg-danger "
                                        style="text-align: center;"
                                    >
                                        <p class="box-title">
                                            <strong> CORRECTION DU QUIZZ </strong>
                                        </p>
                                    </div>
                                    <div class="box-body">
                                         <div class="table-responsive">
                                        <table class="table simple mb-0">
                                            <tbody>


                                                <tr>
                                                    <td> Nombre de questions </td>
                                                    <td class="font-weight-700">

                                                        {{Nbre}}

                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td>
                                                       Bonne(s) réponse(s)
                                                    </td>
                                                    <td class="font-weight-700">
                                                        {{
                                                            datas.totalBonne
                                                        }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        Mauvaise(s) réponse(s)
                                                    </td>
                                                    <td class="font-weight-700">
                                                        {{
                                                           Nbre-datas.totalBonne
                                                        }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                      <strong> Points du quizz  </strong>
                                                    </td>
                                                    <td
                                                        class=" font-weight-700"
                                                    >

                                                    <strong>{{ datas.sumPoint }} / {{datas.totalPoint}} </strong>

                                                    </td>
                                                </tr>


                                            </tbody>
                                        </table>
                                    </div>
                                    </div>

                                </div>


                            </div>



                            <div class="col-md-9" v-if="Showquestions==false">
                                <div class="box">
                                    <div
                                        class="box-header bg-primary "
                                        style="text-align: center;"
                                    >
                                        <h4 class="box-title">
                                            <strong>
                                                {{ Quizzdetails.libelle }}
                                            </strong>
                                        </h4>
                                    </div>
                                    <div class="box-body">
                                        <div class="table-responsive">
                                            <table class="table simple mb-0">
                                                <tbody>
                                                    <tr>
                                                        <td>Classe</td>
                                                        <td
                                                            class=" font-weight-700"
                                                        >
                                                            {{
                                                                Quizzdetails.classe.libelleClasse


                                                            }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Matiere</td>
                                                        <td
                                                            class=" font-weight-700"
                                                        >
                                                            {{
                                                               Quizzdetails.matiere.libelle


                                                            }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            Date et heure
                                                        </td>
                                                        <td
                                                            class="font-weight-700"
                                                        >
                                                            {{
                                                                Quizzdetails.date
                                                                    | dateFormatHeure
                                                            }}
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td>
                                                            Duree
                                                        </td>
                                                        <td
                                                            class="font-weight-700"
                                                        >
                                                            {{
                                                                Quizzdetails.duree
                                                            }}
                                                        </td>
                                                    </tr>

                                                     <tr>
                                                        <td>
                                                            Consigne
                                                        </td>
                                                        <td
                                                            class="font-weight-700 font-size-10"
                                                        >
                                                            {{
                                                                Quizzdetails
                                                                    .consigne

                                                            }}

                                                        </td>
                                                    </tr>

                                                     <tr>
                                                        <td>
                                                            Enseignant
                                                        </td>
                                                        <td
                                                            class="font-weight-700"
                                                        >
                                                            {{
                                                                Quizzdetails
                                                                    .user
                                                                    .nom
                                                            }}
                                                            {{
                                                                Quizzdetails
                                                                    .user
                                                                    .prenom
                                                            }}
                                                        </td>
                                                    </tr>

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3" v-if="Showquestions==false">
                                <a
                                    class="box box-link-shadow text-center pull-up"
                                    href="javascript:void(0)"
                                >
                                    <div class="box-body py-25 bg-info px-5">
                                        <p class="font-weight-600 ">
                                            Quizz
                                        </p>
                                    </div>
                                    <div class="box-body">
                                        <h3 class="countnm font-size-20 m-0">
                                           <Icon type="md-help" />
                                        </h3>

                                        <Divider></Divider>
                                        <h5 >
                                            {{Nbre}}  question(s)
                                        </h5>


                                        <Divider></Divider>

                                        <Button @click=" showDemarerMolad()"

                                                                    v-if="
                                                                        Quizzdetails.verrouiller ==
                                                                            0
                                                                    "
                                                                    type="error"
                                                                    long
                                                                >

                                                                   Démarrer le quizz
                                        </Button>

                                        <Button
                                                                    v-if="
                                                                        Quizzdetails.verrouiller ==
                                                                            1
                                                                    "
                                                                    type="primary"
                                                                    long
                                                                >

                                                                    Quizz déja passé
                                        </Button>

                                    </div>
                                </a>
                            </div>
                            <div class="col-md-12" v-if="Showquestions==true">
                                <div class="box">
                                    <div class="box-header bg-primary">
                                        <h4
                                            class="box-title"
                                            style="margin:auto"
                                        >
                                            <strong>

                                              Répondre par Vrai ou Faux

                                            </strong>
                                        </h4>
                                    </div>

                                    <div class="box-body">
                                        <div class="table-responsive">
                                            <table
                                                class="table product-overview"
                                            >
                                                <thead>
                                                    <tr>
                                                        <th>N°</th>
                                                        <th>Questions</th>
                                                         <th>Pt(s)</th>
                                                        <th>Réponses</th>
                                                        <td></td>

                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr v-for="(data, i) in Quizzdetails.question"  :key="i">
                                                        <td>{{i+1}}</td>
                                                        <td>{{data['libelle_question']}}</td>
                                                        <td> {{data['point']}} point(s) </td>
                                                        <td>

                                                        <RadioGroup
                                                        v-model="respEleve[i]"
                                                        type="button"
                                                        button-style="solid"

                                                    >
                                                        <Radio



                                                            label="Vrai"
                                                        ></Radio>
                                                        <Radio

                                                            label="Faux"
                                                        ></Radio>
                                                    </RadioGroup>

                                                        </td>

                                                        <td v-if="correcEleve!=''">

                                                            <span v-if="correcEleve[i]==1" style="color: rgb(32, 109, 32);font-size:30px"> <Icon type="md-checkmark" /> </span>   <span v-if="correcEleve[i]==0" style="color:rgb(185, 10, 10);font-size:30px"> <Icon type="md-close" /></span>

                                                        </td>

                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>

                                            <div class="form-group">
                                                <button
                                                    @click="showPostterMolad"
                                                    type="button"
                                                    class="btn btn-primary"
                                                >
                                                    Envoyez
                                                </button>
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
import MenuEleve from "../../navs/MenuEleve.vue";
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
    components: { Header, MenuEleve, Chats },
    data() {
        return {
            datas: {

                idQuizz: "",
                 sumPoint:0,
                 totalBonne:0,
                 totalPoint:0

            },

            Minutes:0,
            Secondes:0,
            Heure:0,

            correcStat:0,
            respEleve : {},
            correcEleve : {},
            Quizzdetails: "",

            Nbre:"",
            PosterModal: false,
            DemarerMolad:false,
            Showquestions:false
        };
    },

    mounted() {

        if (localStorage.users) {

            this.Quizzdetails = JSON.parse(localStorage.getItem("quizzParent"));

            this.Nbre = this.Quizzdetails.question.length
        }
    },

    methods: {


        showPostterMolad() {
            this.PosterModal = true;
        },

          showDemarerMolad() {
            this.DemarerMolad = true;
        },

            async Demmarer() {



            const StartingMinutes = 10;
            let time  = StartingMinutes*10;

            function upadte() {

                const minutes = Math.floor(time/60);
                let secondes = time%60;
                time--
            }

            this.DemarerMolad = false;

            this.Showquestions= true;

        },

         async Poster() {

            this.PosterModal = false;

            this.correcStat=1;

            // this.data.idDevoir = this.Devoirdetails.id;
            // const response = await this.callApi(
            //     "post",
            //     "api/teacher/posterCorrectionDevoirsTeacher",
            //     this.data
            // );

            // if (response.status == 200) {
            //     this.s("Correction posté correctement");

            //     this.$router.push("devoirsDashTeacher");
            // } else {
            //     this.e("Une erreure est survenue");
            // }

            // this.$router.push("devoirsDashTeacher");

            for(var i=0 ; i<this.Quizzdetails.question.length ;i++)  {


                let question = this.Quizzdetails.question[i]

                if(question.resp_question==this.respEleve[i]) {


                    this.correcEleve[i]=1;

                    this.datas.sumPoint = this.datas.sumPoint + question.point

                    this.datas.totalBonne = this.datas.totalBonne + 1

               }

               else {

                      this.correcEleve[i]=0;

               }

               this.datas.totalPoint =  this.datas.totalPoint+question.point


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
