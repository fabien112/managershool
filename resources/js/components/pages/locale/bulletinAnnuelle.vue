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
                <h4 class="box-title">BULLETINS ANNUELS</h4>
              </div>

              <div class="box-body wizard-content">
                <div class="row">
                  <div class="col-md-12 pt-5">
                    <div class="form-group">
                      <label for>Classe</label>
                      <select
                        @change="
                                                onChange($event)
                                                "
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
                <br />
                <br />

                <div class="row">
                  <div class="col-md-4">
                    <div class="form-group">
                      <button
                        @click="update"
                        class="waves-effect waves-light btn mb-5 btn btn-primary btn-block"
                      >
                        CALCULATEUR DE
                        MOYENNES ANNUELLES
                      </button>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <button
                        @click="afficher"
                        class="waves-effect waves-light btn mb-5 btn btn-primary btn-outline btn-block"
                      >BULLETINS ANNUELS EN PDF</button>
                    </div>
                  </div>

                  <div class="col-md-4">
                    <div class="form-group">
                      <button
                        @click="afficher3"
                        class="waves-effect waves-light btn mb-5 btn btn-primary btn-outline btn-block"
                      >PROCES VERBAL ANNUEL</button>
                    </div>
                  </div>

                  <div class="col-md-4">
                    <div class="form-group">
                      <button
                        @click="afficher4"
                        class="waves-effect waves-light btn mb-5 btn btn-primary btn-block"
                      >TOUS LES TABLEAU HONNEURS ANNUEL</button>
                    </div>
                  </div>

                  <div class="col-md-4">
                    <div class="form-group">
                      <button
                        @click="afficher5"
                        class="waves-effect waves-light btn mb-5 btn btn-primary btn-block"
                      >STATISTIQUES MEILLEURS ELEVES</button>
                    </div>
                  </div>

                  <div class="col-md-4">
                    <div class="form-group">
                      <button
                        @click="afficher7"
                        class="waves-effect waves-light btn mb-5 btn btn-primary btn-outline btn-block"
                      >LISTE DES BOURSIERS</button>
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
        trimestre: ""
      },

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
    ShowModal() {
      this.showDelateModal = true;
    },

    async afficher5() {
      window.open("api/locale/getAllstatresultmeilleurAnnuel", "_blank");

      const response2 = await this.callApi(
        "get",
        "api/locale/getAllstatresultmeilleurAnnuel"
      );
    },

    async afficher4() {
      window.open("api/locale/getAllTHAnnuel", "_blank");

      const response2 = await this.callApi("get", "api/locale/getAllTHAnnuel");
    },

    async afficher7() {
      window.open("api/locale/getAllBourse", "_blank");

      const response2 = await this.callApi("get", "api/locale/getAllBourse");
    },

    async update() {
      if (this.datas.classeName == "") {
        return this.e("Sélectionner une classe ");
      }

      this.$Loading.start();

      //this.$Spin.show();

      const response7 = await this.callApi(
        "post",
        "api/locale/updateMoyenneAnnuelle",
        this.datas
      );

      if (response7.status != 200) {
        this.e(
          "Une érreure est survenue lors du cacul....Applez le  693333162 pour informations"
        );

        this.val = 0;

        this.$Loading.finish();
        this.$Spin.hide();
      }

      if (response7.status == 200) {
        this.s("Les moyennes ont correctement été calculées");

        this.val = 1;

        this.$Loading.finish();
        this.$Spin.hide();
      }
    },

    async afficher() {
      this.val = false;

      if (this.datas.classeName == "") {
        return this.e("Sélectionner une classe ");
      }

      window.open(
        "api/locale/getAllBulletinAnnuelle/" + this.datas.classeName,
        "_blank"
      );

      const response2 = await this.callApi(
        "get",
        "api/locale/getAllBulletinAnnuelle/" + this.datas.classeName
      );
    },

    async afficher2() {
      this.val = false;

      if (this.datas.libelleEvaluation == "") {
        return this.e("Sélectionner un trimestre ");
      }

      if (this.datas.classeName == "") {
        return this.e("Sélectionner une classe ");
      }

      window.open(
        "api/locale/getAllProcesVerbalTrimestre/" +
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

    async afficher3() {
      this.val = false;

      if (this.datas.classeName == "") {
        return this.e("Sélectionner une classe ");
      }

      window.open(
        "api/locale/getAllProcesVerbalAnnuel/" +
          this.datas.classeName +
          "*" +
          this.datas.libelleEvaluation,
        "_blank"
      );

      const response2 = await this.callApi(
        "get",
        "api/locale/getAllProcesVerbalAnnuel/" +
          this.datas.classeName +
          "*" +
          this.datas.libelleEvaluation
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
