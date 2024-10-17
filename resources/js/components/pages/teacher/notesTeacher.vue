<template>
  <div>
    <div class="wrapper">
      <HeaderTeacher />
      <MenuTeacher />

      <Modal v-model="showDelateModal" width="360">
        <p slot="header" style="color:green;text-align:center">
          <span>Justification</span>
        </p>
        <div style="text-align:center">
          <p>Etes-vous sure de vouloir justifier ?</p>
        </div>
        <div slot="footer">
          <Button type="success" size="large" long @click="JustifierNote">Confirmer</Button>
        </div>
      </Modal>

      <Modal v-model="showDelateModal2" width="360">
        <p slot="header" style="color:red;text-align:center">
          <span>Blamer</span>
        </p>
        <div style="text-align:center">
          <p>Etes-vous sure de vouloir Blamer ?</p>
        </div>
        <div slot="footer">
          <Button type="error" size="large" long @click="BlameNote">Confirmer</Button>
        </div>
      </Modal>
      <!--
            <Modal v-model="showDelateModal" width="360">
                <p slot="header" style="color:rgb(228, 61, 61);text-align:center">
                    <Icon type="ios-information-circle"></Icon>
                    <span> CONFIRMATION </span>
                </p>
                <div style="text-align:center">
                    <p>Etes vous sure d'avoir rempli les notes a tous ?</p>
                </div>
                <div slot="footer">
                    <Button type="primary" size="large" long @click="Presence">Confirmer</Button>
                </div>
      </Modal>-->

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
            <!-- START Card With Image -->
            <!-- <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">
                                    NOTE DE LA CLASSE
                                    <p class="subtitle font-size-14 mb-0">
                                        Selectionner une classe et voir les
                                        notes
                                    </p>
                                </h4>
                            </div>
            </div>-->

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
                  <!--
                                     <div class="col-md-6">
                                        <div class="form-group">

                                            <label for=""> Trimestre </label>

                                            <select

                                                v-model="datas.trimestre"

                                                class="custom-select form-control required"
                                            >
                                                <option

                                                    selected="selected"

                                                    :value="Evaluation.trimestre.id"
                                                >
                                                    {{Evaluation.trimestre.libelle_semes}}

                                                </option>
                                            </select>
                                        </div>
                  </div>-->

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
                          :value="data.classe.id"
                        >
                          {{
                          data.classe
                          .libelleClasse
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

                <br />

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
              </div>
            </div>

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
                            <th></th>
                            <th>Noms et Prénoms</th>

                            <th>Notes</th>

                            <th></th>

                            <th></th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr v-for="(data, i) in Notes" :key="i">
                            <td>
                              <img
                                class="avatar"
                                :src="`/Photos/Logos/${data.user.photo}`
                                                            "
                                alt
                              />
                            </td>
                            <td>{{ data.nom }} {{ data.prenom }}</td>
                            <td>
                              <!-- <button class="btn btn-dark btn-xs" v-if="data.valeur == null">
                              Aucune note </button>-->

                              <button
                                v-if="data.valeur != null && data.statusNote == null"
                                class="btn btn-primary btn-xs"
                              >
                                {{
                                data.valeur
                                }}
                              </button>

                              <button
                                v-if="data.valeur != null && data.statusNote == 1"
                                class="btn btn-primary btn-xs"
                              >
                                <Icon type="md-checkmark" />
                              </button>

                              <button
                                v-if="data.valeur == null"
                                class="btn btn-danger btn-xs"
                                @click="showEdetingModal(data,i,d)"
                                title="Ajouter"
                              >
                                <i class="ti-plus"></i>
                              </button>
                            </td>

                            <td>
                              <button
                                v-if="data.valeur != NULL && data.valeur == 0"
                                class="btn btn-success btn-xs"
                                @click="showDelatingModal(data, i)"
                                title="Justifier en cas d'absence"
                              >Justifier</button>

                              <button
                                v-if="data != NULL && data.valeur == 0"
                                class="btn btn-danger btn-xs"
                                @click="showDelatingModal2(data, i)"
                                title="Blamer en cas d'absence"
                              >Blammer</button>
                            </td>

                            <!-- <td> {{ data.mention }}</td> -->

                            <!-- <td>

                                                             <button v-if="data.valeur != null" class="btn btn-primary"
                                                                 title="Modifier"> <i
                                                                    class="ti-pencil"></i>
                                                            </button>




                            </td>-->
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

      showDelateModal: false,
      showDelateModal2: false,

      Note: {},
      Obser: {},
      i: 1,
      showDelateModal: false,
      EdetingModal: false,
      LIbelleMatiereclasse: "",
      checkedNames: [],
      checkBoxs: [],
      rempli: false,
      delateItem: "",
      users: [],
      ClassListes: [],
      MatieresListes: [],
      Notes: [],
      Evaluation: [],
      show: false
    };
  },

  async mounted() {
    if (localStorage.users) {
      this.users = JSON.parse(localStorage.getItem("users"));
    }

    const response = await this.callApi(
      "post",
      "api/teacher/getAllClasseOfTeacher",
      this.users
    );

    this.ClassListes = response.data;

    const response2 = await this.callApi(
      "post",
      "api/teacher/getEvaluationAll",
      this.users
    );

    this.Evaluation = response2.data;
  },
  methods: {
    async BlameNote() {
      console.log(this.delateItem);

      const response = await axios.post(
        "api/teacher/BlamerNote",
        this.delateItem
      );
      if (response.status === 200) {
        console.log(this.delateItem);

        this.showDelateModal2 = false;
        this.s("Note blamée correctement");

        this.afficher();
      }
      // this.modal2 = false;
    },

    async JustifierNote() {
      console.log(this.delateItem);
      const response = await axios.post(
        "api/teacher/JustifierNote",
        this.delateItem
      );
      if (response.status === 200) {
        console.log(this.delateItem);

        this.showDelateModal = false;
        this.s("Note justifiée correctement");

        this.afficher();
      }
      // this.modal2 = false;
    },

    showDelatingModal(data, i) {
      this.delateItem = data;
      this.i = i;
      this.showDelateModal = true;
    },

    showDelatingModal2(data, i) {
      this.delateItem = data;
      this.i = i;
      this.showDelateModal2 = true;
    },

    async Update() {
      //console.log(this.delateItem.duree);

      if (this.datasEdit.note == "" || this.datasEdit.note == null) {
        this.e("Saisir une note valide");
      } else {
        this.$Spin.show();
        this.datasEdit.idNote = this.delateItem.idNote;
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

    showEdetingModal(data, i, d) {
      this.EdetingModal = true;
      this.i = i;
      this.delateItem = data;
      this.datasEdit.note = data.valeur;
      this.datasEdit.mention = data.mention;
      this.datasEdit.eleveId = data.id;
      this.datasEdit.reste = this.datas;
      this.datasEdit.d = d;
    },
    async onChange(event) {
      this.datas.idClasse = event.target.value;

      this.datas.users = this.users;

      // Recuperer toutes les matieres de cette  classe

      const response3 = await this.callApi(
        "post",
        "api/teacher/getLibelleMatiereclasseById",
        this.datas
      );

      this.LIbelleMatiereclasse = response3.data;
    },

    ShowModal() {
      this.showDelateModal = true;
    },

    async afficher() {
      if (this.datas.libelleEvaluation == "") {
        return this.e("Selectionner une évaluation");
      }

      if (this.datas.classeName == "") {
        return this.e("Selectionner une classe ");
      }

      if (this.datas.matiere == "") {
        return this.e("Selectionner la matiere");
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
    },

    async Presence() {
      this.showDelateModal = false;

      //this.s('Vous avez correctement fait la presence')

      this.datas.Note = this.Note;

      const response = await this.callApi(
        "post",
        "api/teacher/AddNote",
        this.datas
      );

      if (response.status == 401) {
        this.e("Vérifiez que vous vous avez saisi toutes les notes.");
      }

      if (response.status == 400) {
        this.e("Vérifiez que vous vous avez saisi toutes les notes.");
      }

      if (response.status == 501) {
        this.e("Vérifiez que toutes vos notes sont  valides (entre 0 et 20).");
      }

      if (response.status == 402) {
        this.e(
          "Vous avez déja entrer les notes pour cette évaluation dans cette matiere et dans cette classe ."
        );
      }
      if (response.status == 200) {
        this.s(" Notes ajoutées correctement");
      }

      // this.$router.push('absenceDashTeacher');

      // this.$router.go();
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
