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
                <h4 class="box-title">CHANGEMENT DE CLASSE</h4>
              </div>

              <div class="box-body wizard-content">
                <div class="row">
                  <div class="col-md-12 col-lg-12">
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for>Classe actuelle</label>
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

                      <div class="col-md-6">
                        <div class="form-group">
                          <label for>Classe nouvelle</label>
                          <select
                            v-model="datas.classeName1
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

                      <!-- <div class="col-md-4">
                        <div class="form-group">
                          <label for>Moy Min de passage</label>

                          <input
                            v-model="datas.moy
                                                        "
                            class="form-control required"
                          />
                        </div>
                      </div>-->
                    </div>

                    <br />
                    <div class="row">
                      <div class="col-md-4">
                        <div class="form-group">
                          <button
                            @click="send()"
                            class="waves-effect waves-light btn btn-primary"
                          >Afficher</button>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <br />
                <br />

                <div class="row">
                  <div class="col-12">
                    <div class="box">
                      <div class="box-header bg-primary">
                        <h4 class="box-title text-white">Liste des Eleves</h4>
                      </div>
                      <div class="box-body">
                        <div class="table-responsive">
                          <table id="example" class="table simple mb-0" style="width:100%">
                            <thead>
                              <tr>
                                <!-- <th></th> -->

                                <th>Matricule</th>

                                <th>Noms et Prénoms</th>

                                <!-- <th>Moyenne annuelle</th> -->

                                <th>Selection</th>
                              </tr>
                            </thead>
                            <tbody>
                              <tr v-for="(data, i) in Classes" :key="i">
                                <!-- <td>
                                  <img
                                    class="avatar"
                                    :src="`/Photos/Logos/${data.photo}`
                                                                        "
                                    alt
                                  />
                                </td>-->

                                <td>{{ data.matricule }}</td>

                                <td>{{ data.nom }} {{ data.prenom }}</td>

                                <!-- <td>
                                  <button class="btn btn-xs btn-primary-light">
                                    {{
                                    data.valeur }}
                                  </button>
                                </td>-->
                                <td>
                                  <div class="custom-control custom-checkbox">
                                    <input
                                      type="checkbox"
                                      :id="data.id"
                                      :value="data.id"
                                      class="chk-col-primary"
                                      v-model="checkedNames"
                                    />

                                    <label :for="data.id"></label>
                                  </div>
                                </td>
                              </tr>
                            </tbody>
                          </table>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="col-3">
                    <button
                      @click="update()"
                      class="waves-effect waves-light btn-outline btn btn-block btn-primary"
                    >Transferer</button>
                  </div>
                </div>

                <!-- <div class="row" v-if="rempli == true && Classes.length == 0">
                  <div class="col-12">
                    <Alert type="error" fade="true" show-icon closable>
                      Aucun élève ne possède une note annuelle supérieure ou égale à {{datas.moy}} dans cette
                      classe
                    </Alert>
                  </div>
                </div>-->
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
      rempli: false,
      Classes: [],
      checkedNames: [],
      datas: {
        classeName: "",
        classeName1: "",
        idClasse: "",
        dec: "",
        trimestre: "",
        moy: ""
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
    // this.ClassListes = this.ClassListes.filter(item => item.eleves.length > 0);

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

      if (event.target.value == 3) {
        this.showBull = false;
      } else {
        this.showBull = true;
      }
    },
    ShowModal() {
      this.showDelateModal = true;
    },

    async send() {
      if (this.datas.classeName == "") {
        return this.e("Sélectionner la classe actuelle");
      }

      if (this.datas.classeName1 == "") {
        return this.e("Sélectionner la nouvelle classe ");
      }

      if (this.datas.classeName1 == this.datas.classeName) {
        return this.e("Vous ne pouvez choisir la meme classe ");
      }

      this.$Spin.show();

      const response7 = await this.callApi(
        "post",
        "api/locale/changeClasse",
        this.datas
      );

      if (response7.status != 200) {
        this.$Spin.hide();
        this.e("Une érreure est survenue lors de la procédure");
      }

      if (response7.status == 200) {
        this.rempli = true;

        this.Classes = response7.data;

        this.$Spin.hide();
      }
    },
    async update() {
      this.$Spin.show();

      this.datas.checkedNames = this.checkedNames;

      const response77 = await this.callApi(
        "post",
        "api/locale/changeClasseTranfert",
        this.datas
      );

      console.log(response77);

      if (response77.status != 200) {
        this.$Spin.hide();
        this.e("Une érreure est survenue lors de la procédure");
      }

      if (response77.status == 200) {
        this.rempli = true;
        this.$Spin.hide();
        this.s("Tranfert correctement effectué");
        // this.$router.push("cycle");
      }
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
