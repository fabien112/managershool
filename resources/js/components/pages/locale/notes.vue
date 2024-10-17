<template>
  <div>
    <div class="wrapper">
      <Header />
      <MenuLocal />

      <Modal v-model="EdetingModal" title="Modifier  une note ">
        <div class="row"></div>
        <br />
        <div class="row">
          <div class="col-md-12">
            <label class="form-label">Note</label>
            <input type="number" class="form-control" v-model="datasEdit.note" />
          </div>
          <br />
          <!-- <div class="col-md-12">
                                    <label class="form-label"> Mention
                                    </label>
                                    <input type="text" class="form-control"  v-model="datasEdit.mention" />
          </div>-->
        </div>

        <br />

        <div slot="footer">
          <Button type="primary" size="large" long @click="Update()">Enregistrer</Button>
        </div>
      </Modal>

      <div class="content-wrapper">
        <div class="container-full">
          <section class="content">
            <br />

            <div class="row">
              <div class="col-md-12 col-lg-12">
                <div class="row">
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for>Evaluation</label>

                      <select
                        v-model="datas.libelleEvaluation
                                                "
                        class="custom-select form-control required"
                      >
                        <option
                          v-for="(data,
                                                    i) in Evaluation"
                          :key="i"
                          :value="data.id"
                        >{{ data.libelle }}</option>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for>Classe</label>
                      <select
                        @change="onChange($event)"
                        v-model="datas.classeName"
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

                  <div class="col-md-4">
                    <div class="form-group">
                      <label for>Matière</label>

                      <select v-model="datas.matiere" class="custom-select form-control required">
                        <option
                          v-for="(data,
                                                    i) in LIbelleMatiereclasse"
                          :key="i"
                          :value="data.id"
                        >{{ data.libelle }}</option>
                      </select>
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <button
                        @click="afficher"
                        class="waves-effect waves-light btn mb-5 btn btn-primary"
                      >Envoyer</button>
                    </div>
                  </div>
                </div>
                <br />
                <br />
                <br />
                <br />
              </div>
            </div>

            <br />
            <br />
            <br />
            <br />

            <div class="row" v-if="rempli == true">
              <div class="col-12">
                <div class="box">
                  <div class="box-header bg-primary">
                    <h4 class="box-title">Notes</h4>
                  </div>
                  <div class="box-body">
                    <div class="table-responsive">
                      <table id="example" class="table simple mb-0" style="width:100%">
                        <thead>
                          <tr>
                            <th>Noms et Prénoms</th>

                            <th>Notes</th>

                            <th>Actions</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr v-for="(data, i) in Notes" :key="i">
                            <td>{{ data.nom }} {{ data.prenom }}</td>
                            <td>
                              <button class="btn btn-danger btn-xs" v-if="data.valeur == null">Vide</button>

                              <button v-else class="btn btn-xs btn-primary">
                                {{
                                data.valeur }}
                              </button>
                            </td>

                            <td>
                              <span
                                v-if="data.valeur != null"
                                class="btn btn-primary"
                                @click="showEdetingModal(data, i,1)"
                                title="Modifier"
                              >
                                <i class="ti-pencil"></i>
                              </span>
                              <span
                                v-else
                                class="btn btn-danger"
                                @click="showEdetingModal(data, i,0)"
                                title="Modifier"
                              >
                                <i class="ti-plus"></i>
                              </span>
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
        idNote: ""
      },

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
      delateItem: "",
      show: false
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
      "api/locale/getAllEvaluations",
      this.EtabInfos
    );
    this.Evaluation = response4.data;
  },
  methods: {
    showEdetingModal(data, i, d) {
      this.EdetingModal = true;
      this.i = i;
      this.delateItem = data;
      this.datasEdit.note = data.valeur;
      this.datasEdit.mention = data.mention;
      this.datasEdit.eleveId = data.id;
      this.datasEdit.reste = this.datas;

      this.datasEdit.dec = d;
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
        this.datasEdit.idNote = this.delateItem.idNote;

        this.$Spin.show();
        const response = await axios.post(
          "api/teacher/updateNote",
          this.datasEdit
        );

        if (response.status === 200) {
          this.EdetingModal = false;

          this.$Spin.hide();

          this.s("Note modifiée correctement");

          const response2 = await this.callApi(
            "post",
            "api/teacher/getStudentByTeacherVoirNote",
            this.datas
          );

          this.Notes = response2.data;

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
        return this.e("Sélectionner  une évaluation ");
      }

      if (this.datas.classeName == "") {
        return this.e("Sélectionner  une classe ");
      }

      if (this.datas.matiere == "") {
        return this.e("Sélectionner la matiere");
      }

      const response2 = await this.callApi(
        "post",
        "api/teacher/getStudentByTeacherVoirNote",
        this.datas
      );

      this.Notes = response2.data;

      if (this.Classes == "") {
        this.rempli = false;
      } else {
        this.rempli = true;
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
