<template>
  <div>
    <div class="wrapper">
      <Header />
      <MenuLocal />

      <div class="content-wrapper">
        <div class="container-full">
          <section class="content">
            <div class="box box-default">
              <div
                class="box-header"
                style="background-color:#0052CC;text-align: center; color:white"
              >
                <h4 class="box-title">BULLETIN DU TRIMESTRE</h4>
              </div>

              <div class="box-body wizard-content">
                <div class="row">
                  <div class="col-md-12 col-lg-12">
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for>TRIMESTRE</label>

                          <select
                            @change="
                                                        onChange($event)
                                                        "
                            v-model="datas.libelleEvaluation
        "
                            class="custom-select form-control required"
                          >
                            <option
                              v-for="(data,
                                                            i) in Evaluation"
                              :key="i"
                              :value="data.id"
                            >
                              {{
                              data.libelle_semes
                              }}
                            </option>
                          </select>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for>Classe</label>
                          <select
                            v-model="datas.classeName
                                                        "
                            class="custom-select form-control required"
                          >
                            <option
                              v-for="(data,
                                                            i) in ClassListes"
                              :key="i"
                              :value="data.id"
                            >
                              {{
                              data.libelleClasse
                              }}
                            </option>
                          </select>
                        </div>
                      </div>
                    </div>

                    <!-- <div class="row">
                                            <div class="col-md-12">

                                                <div class="form-group">
                                                    <button @click="update"
                                                        class="waves-effect waves-light btn mb-5  btn btn-danger btn-block ">

                                                        LANCER LE CALCULATEUR DE MOYENNES
                                                    </button>
                                                </div>

                                            </div>



                    </div>-->
                    <br />
                    <br />

                    <div class="row">
                      <div class="col-md-3">
                        <div class="form-group">
                          <button
                            @click="update"
                            class="waves-effect waves-light btn mb-5 btn btn-primary btn-block"
                          >
                            CALCULATEUR DE
                            MOYENNES
                          </button>
                        </div>
                      </div>

                      <div class="col-md-3" v-if="showBull == true">
                        <div class="form-group">
                          <button
                            @click="afficher"
                            class="waves-effect waves-light btn mb-5 btn btn-primary btn-outline btn-block"
                          >BULLETINS EN PDF PAR CLASSE</button>
                        </div>
                      </div>

                      <div class="col-md-3" v-if="showBull == true">
                        <div class="form-group">
                          <button
                            @click="afficher3"
                            class="waves-effect waves-light btn mb-5 btn btn-primary btn-block"
                          >PROCES VERBAL PAR CLASSE</button>
                        </div>
                      </div>

                      <div class="col-md-3" v-if="showBull == true">
                        <div class="form-group">
                          <button
                            @click="afficherprofil"
                            class="waves-effect waves-light btn mb-5 btn btn-primary btn-outline btn-block"
                          >PROFIL DE LA CLASSE PAR MATIERE</button>
                        </div>
                      </div>

                      <div class="col-md-3" v-if="showBull == true">
                        <div class="form-group">
                          <button
                            @click="afficher4"
                            class="waves-effect waves-light btn mb-5 btn btn-primary btn-outline btn-block"
                          >STATISTIQUES RESULTATS</button>
                        </div>
                      </div>

                      <div class="col-md-3" v-if="showBull == true">
                        <div class="form-group">
                          <button
                            @click="afficher5"
                            class="waves-effect waves-light btn mb-5 btn btn-primary btn-block"
                          >STATISTIQUES MEILLEURS ELEVES</button>
                        </div>
                      </div>

                      <div class="col-md-3" v-if="showBull == true">
                        <div class="form-group">
                          <button
                            @click="afficher6"
                            class="waves-effect waves-light btn mb-5 btn btn-primary btn-outline btn-block"
                          >TOUS LES TABLEAUX D'HONNEUR</button>
                        </div>
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
      spinShow: false,
      datas: {
        classeName: "",
        idClasse: "",
        libelleEvaluation: "",
        trimestre: ""
      },

      showBull: true,

      Note: {},
      Obser: {},
      i: 1,
      showDelateModal: false,
      LIbelleMatiereclasse: "",
      checkedNames: [],
      checkBoxs: [],
      rempli: false,
      users: [],
      ClassListes: [],
      MatieresListes: [],
      Notes: [],
      Evaluation: [],
      val: 0
    };
  },

  async mounted() {
    if (!localStorage.users) {
      this.$router.push("login");
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
    this.ClassListes = this.ClassListes.filter(item => item.eleves.length > 0);

    const response4 = await this.callApi(
      "post",
      "api/locale/getTrimestreEtablissement",
      this.EtabInfos
    );
    this.Evaluation = response4.data[0].trimestres;
  },
  methods: {
    onChange(event) {
      console.log(event.target.value);

      //   if (event.target.value == 3) {
      //     this.showBull = false;
      //   } else {
      //     this.showBull = true;
      //   }
    },
    ShowModal() {
      this.showDelateModal = true;
    },

    async update() {
      if (this.datas.libelleEvaluation == "") {
        return this.e("Selectionner un trimestre");
      }

      if (this.datas.classeName == "") {
        return this.e("Sélectionner une classe ");
      }

      this.$Loading.start();

      //this.$Spin.show();

      const response7 = await this.callApi(
        "post",
        "api/locale/updateNoteTrimestre",
        this.datas
      );

      if (response7.status != 200) {
        this.$Loading.finish();
        // this.$Spin.hide();
        this.e(
          "Une érreure est survenue lors du cacul....Applez le  693333162 pour informations"
        );

        this.val = 0;
      }

      if (response7.status == 200) {
        this.$Loading.finish();

        this.$Spin.hide();
        this.s(
          "Les moyennes ont correctement été calculées. Clquez sur imprimer les bulletins"
        );

        this.val = 1;
      }
    },

    async afficherprofil() {
      this.val = false;

      if (this.datas.libelleEvaluation == "") {
        return this.e("Sélectionner un trimestre ");
      }

      if (this.datas.classeName == "") {
        return this.e("Sélectionner une classe ");
      }

      window.open(
        "api/locale/getAllProfilTrimestre/" +
          this.datas.classeName +
          "*" +
          this.datas.libelleEvaluation,
        "_blank"
      );

      const response2 = await this.callApi(
        "get",
        "api/locale/getAllProfilTrimestre/" +
          this.datas.classeName +
          "*" +
          this.datas.libelleEvaluation
      );
    },

    async afficher() {
      this.val = false;

      if (this.datas.libelleEvaluation == "") {
        return this.e("Sélectionner un trimestre ");
      }

      if (this.datas.classeName == "") {
        return this.e("Sélectionner une classe ");
      }

      window.open(
        "api/locale/getAllBulletinExamTrimestre/" +
          this.datas.classeName +
          "*" +
          this.datas.libelleEvaluation,
        "_blank"
      );

      const response2 = await this.callApi(
        "get",
        "api/locale/getAllBulletinExamTrimestre/" +
          this.datas.classeName +
          "*" +
          this.datas.libelleEvaluation
      );
    },

    async afficher3() {
      this.val = false;

      if (this.datas.libelleEvaluation == "") {
        return this.e("Sélectionner un trimestre ");
      }

      if (this.datas.classeName == "") {
        return this.e("Sélectionner une classe ");
      }

      window.open(
        "api/locale/getAllProcesVerbalTrimestre2/" +
          this.datas.classeName +
          "*" +
          this.datas.libelleEvaluation,
        "_blank"
      );

      const response2 = await this.callApi(
        "get",
        "api/locale/getAllProcesVerbalTrimestre/" +
          this.datas.classeName +
          "*" +
          this.datas.libelleEvaluation
      );
    },

    // async afficher3() {
    //   this.val = false;

    //   if (this.datas.libelleEvaluation == "") {
    //     return this.e("Sélectionner un trimestre ");
    //   }

    //   if (this.datas.classeName == "") {
    //     return this.e("Sélectionner une classe ");
    //   }

    //   window.open(
    //     "api/locale/getAllProcesVerbalTrimestre2/" + this.datas,
    //     "_blank"
    //   );

    //   const response2 = await this.callApi(
    //     "get",
    //     "api/locale/getAllProcesVerbalTrimestre2/" +
    //       this.datas.classeName+
    //       "*" +
    //       this.datas.libelleEvaluation
    //   );
    // },

    async afficher4() {
      this.val = false;

      if (this.datas.libelleEvaluation == "") {
        return this.e("Sélectionner un trimestre ");
      }

      window.open(
        "api/locale/getAllstatresult/" + this.datas.libelleEvaluation,
        "_blank"
      );

      const response2 = await this.callApi(
        "get",
        "api/locale/getAllstatresult/" + this.datas.libelleEvaluation
      );
    },

    async afficher5() {
      this.val = false;

      if (this.datas.libelleEvaluation == "") {
        return this.e("Sélectionner un trimestre ");
      }

      window.open(
        "api/locale/getAllstatresultmeilleur/" + this.datas.libelleEvaluation,
        "_blank"
      );

      const response2 = await this.callApi(
        "get",
        "api/locale/getAllstatresultmeilleur/" + this.datas.libelleEvaluation
      );
    },

    async afficher6() {
      this.val = false;

      if (this.datas.libelleEvaluation == "") {
        return this.e("Sélectionner un trimestre ");
      }

      window.open(
        "api/locale/getAllTBTrimestre/" + this.datas.libelleEvaluation,
        "_blank"
      );

      const response2 = await this.callApi(
        "get",
        "api/locale/getAllstatresultmeilleur/" + this.datas.libelleEvaluation
      );
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
