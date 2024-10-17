<template>
  <div>
    <div class="wrapper">
      <Header />
      <MenuLocal />

      <div class="content-wrapper" style="min-height: 653px; background-color:#FAFBFD">
        <div class="container-full">
          <!-- Main content -->
          <section class="content">
            <!-- Modol pour supprimer la classe  -->

            <Modal v-model="showDelateModal" width="360">
              <p slot="header" style="color:#f60;text-align:center">
                <span>Suppression</span>
              </p>
              <div style="text-align:center">
                <p>Etes-vous sure de vouloir supprimer ?</p>
              </div>
              <div slot="footer">
                <Button type="error" size="large" long @click="delateClasse">Confirmer</Button>
              </div>
            </Modal>

            <div class="row">
              <div class="col-12">
                <!-- /.box -->

                <div class="box">
                  <div class="box-header bg-primary">
                    <h4 class="box-title" style="margin:auto"></h4>

                    <span>
                      <button
                        type="button"
                        class="pull-right btn btn-primary"
                        @click="ShowmodalAddClasse"
                      >
                        <Icon type="md-add" />Classe
                      </button>

                      <router-link to="inscriptionEleve">
                        <button type="button" class="waves-effect btn btn-primary mb-5 pull-center">
                          <Icon type="md-add" />Elève
                        </button>
                      </router-link>
                    </span>

                    <span
                      class="box-title"
                      style="margin:auto;padding-left: 120px; font-size: 20px;"
                    >
                      {{ somme }}
                      👨🏽‍🎓 élèves au total
                    </span>

                    <span
                      class="box-title"
                      style="margin:auto;padding-left: 120px; font-size: 20px;"
                    >
                      {{ datas.length }}
                      👨‍🏫 classes
                    </span>
                  </div>

                  <!-- Modal pour ajouter une classe -->

                  <Modal v-model="modalAddClasse" title="Ajouter une nouvelle classe ">
                    <div class="row">
                      <div class="col-md-12">
                        <label class="form-label">Nom de la classe</label>
                        <input
                          type="text"
                          class="form-control"
                          v-model.trim="data.sigleClasse
                                                    "
                        />
                      </div>

                      <div class="col-md-12">
                        <label class="form-label">Filieres</label>

                        <select class="form-control" v-model="data.IdFiliere">
                          <option v-for="(data, i) in Filieres" :key="i" :value="data.id">
                            {{
                            data.nom
                            }}
                          </option>
                        </select>
                      </div>

                      <div class="col-md-12">
                        <label class="form-label">Specialite</label>

                        <select class="form-control" v-model="data.IdSpecialite">
                          <option v-for="(data, i) in Specialites" :key="i" :value="data.id">
                            {{
                            data.nom
                            }}
                          </option>
                        </select>
                      </div>
                    </div>

                    <!-- <div class="row">
                      <div class="col-md-12">
                        <label class="form-label">Contribution exigible</label>
                        <input
                          type="number"
                          class="form-control"
                          v-model.trim="data.MontantScolAffect
                                                    "
                        />
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-md-12">
                        <label class="form-label">Contribution des parents</label>
                        <input
                          type="number"
                          class="form-control"
                          v-model.trim="data.MontantScol
                                                    "
                        />
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-md-12">
                        <label class="form-label">Frais des timbres</label>
                        <input
                          type="number"
                          class="form-control"
                          v-model.trim="data.FraisInscrip
                                                    "
                        />
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-md-12">
                        <label class="form-label">Frais d'examen</label>
                        <input
                          type="number"
                          class="form-control"
                          v-model.trim="data.Fraistrois
                                                    "
                        />
                      </div>
                    </div>-->

                    <br />
                    <!-- <Upload
                      multiple
                      type="drag"
                      action="api/admin/upload"
                      :on-success="handleSuccess"
                      :on-error="handleError"
                      :format="[
                                                'jpg',
                                                'jpeg',
                                                'png',
                                                'pdf',
                                                'doc',
                                                'docx'
                                            ]"
                      :max-size="2048"
                      :on-format-error="handleFormatError"
                      :on-exceeded-size="handleMaxSize"
                      :headers="{
                                                'X-Requested-With':
                                                    'XMLHttpRequest'
                                            }"
                    >
                      <div style="padding: 20px 0">
                        <Icon type="ios-cloud-upload" size="52" style="color: #3399ff"></Icon>
                        <p class="text-center">
                          Cliquer ou glisser déposer
                          pour insérer l'emploi du
                          temps de la classe
                        </p>
                      </div>
                    </Upload>-->

                    <div slot="footer">
                      <Button type="primary" size="large" long @click="Submit()">Enregistrer</Button>
                    </div>
                  </Modal>

                  <Modal v-model="modalUpadteClasse" title="Modifier  une classe ">
                    <div class="row">
                      <div class="col-md-12">
                        <label class="form-label">Nom de la classe</label>
                        <input
                          type="text"
                          class="form-control"
                          v-model="dataRefresh.libelleClasse
                                                    "
                        />
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-md-12">
                        <label class="form-label">Montant de l'inscription</label>
                        <input
                          type="number"
                          class="form-control"
                          v-model="dataRefresh.scolariteaff_Classe
                                                    "
                        />
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-md-12">
                        <label class="form-label">
                          Montant de la première
                          tranche
                        </label>
                        <input
                          type="number"
                          class="form-control"
                          v-model="dataRefresh.scolarite_Classe
                                                    "
                        />
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-md-12">
                        <label class="form-label">
                          Montant de la deuxième
                          tranche
                        </label>
                        <input
                          type="number"
                          class="form-control"
                          v-model="dataRefresh.inscription_Classe
                                                    "
                        />
                      </div>
                    </div>

                    <br />
                    <!-- <Upload multiple type="drag" action="api/admin/upload"
                                            :on-success="handleSuccess" :on-error="handleError"
                                            :format="['jpg', 'jpeg', 'png', 'pdf', 'doc', 'docx']" :max-size="2048"
                                            :on-format-error="handleFormatError" :on-exceeded-size="handleMaxSize"
                                            :headers="{
                                                'X-Requested-With':
                                                    'XMLHttpRequest'
                                            }">
                                            <div style="padding: 20px 0">
                                                <Icon type="ios-cloud-upload" size="52" style="color: #3399ff"></Icon>
                                                <p class="text-center">
                                                    Cliquer ou glisser déposer pour insérer l'emploi du
                                                    temps de la classe

                                                </p>
                                            </div>
                    </Upload>-->

                    <div slot="footer">
                      <Button type="primary" size="large" long @click="updateClasse()">Enregistrer</Button>
                    </div>
                  </Modal>

                  <Modal v-model="modalUpadteClasse2" title="Professeur principal ">
                    <div class="row">
                      <div class="col-md-12">
                        <select class="custom-select form-control required" v-model="data.prof">
                          <option
                            v-for="(data,
                                                        i) in Enseignants"
                            :key="i"
                            :value="data.id"
                          >
                            {{ data.nom }}
                            {{ data.prenom }}
                          </option>
                        </select>
                      </div>
                    </div>

                    <div slot="footer">
                      <Button type="primary" size="large" long @click="Affecttation2()">Enregistrer</Button>
                    </div>
                  </Modal>

                  <!-- /.box-header -->
                  <div class="box-body">
                    <div class="table-responsive">
                      <table id="example" class="table simple mb-0" style="width:100%">
                        <thead>
                          <tr>
                            <th>Classes</th>
                            <th>Filiere</th>
                            <!-- <th>Spectialite</th> -->
                            <th>Effectifs</th>
                            <th>Garçons</th>
                            <th>Filles</th>
                            <th>Professeur principal</th>

                            <th>Actions</th>
                          </tr>
                        </thead>
                        <tbody name="fruit-table" is="transition-group">
                          <tr
                            v-for="(data,
                                                        i) in datas"
                            :key="i"
                          >
                            <td>
                              {{
                              data.libelleClasse
                              }}
                            </td>

                            <td>
                              {{
                              data.filieres.nom
                              }}
                            </td>

                            <!-- <td>{{ data.specialites ? data.specialites.nom : 'Aucune' }}</td> -->

                            <td>
                              <span
                                class="btn btn-xs"
                                style="background-color:rgba(105, 21, 98, 0.829);color:white"
                                title="Ajouter une matiere "
                              >
                                {{
                                data.eleves
                                .length
                                }}
                              </span>
                            </td>

                            <td>
                              <button class="btn btn-warning btn-xs">
                                {{
                                data.garcon
                                }}
                              </button>
                            </td>

                            <td>
                              <button class="btn btn-success btn-xs">
                                {{
                                data.fille
                                }}
                              </button>
                            </td>
                            <td>
                              <span
                                class="btn btn-xs"
                                style="background-color:#0052CC;color:white"
                                v-if="data.enseignantPrincipal !=
                                                                        null
                                                                        "
                              >
                                {{
                                data
                                .enseignantPrincipal
                                .nom
                                }}
                                {{
                                data
                                .enseignantPrincipal
                                .prenom
                                }}
                              </span>

                              <span
                                class="btn btn-xs"
                                style="background-color:red;color:white"
                                v-if="data.enseignantPrincipal ==
                                                                        null
                                                                        "
                              >Aucun</span>
                            </td>

                            <td>
                              <div class="dropdown">
                                <button
                                  class="btn btn-primary btn-outline btn-sm dropdown-toggle"
                                  type="button"
                                  id="dropdownMenuButton"
                                  data-toggle="dropdown"
                                  aria-haspopup="true"
                                  aria-expanded="false"
                                >Actions</button>
                                <div
                                  class="dropdown-menu dropdown-menu-right"
                                  aria-labelledby="dropdownMenuButton"
                                  style="text-align: left;"
                                >
                                  <!-- Ajouter une matière -->
                                  <router-link to="matieres" class="dropdown-item">
                                    <span @click="cloturer(data, i)" style="color: black;">
                                      <i class="ti-plus"></i> Ajouter une matière
                                    </span>
                                  </router-link>

                                  <!-- Liste des élèves -->
                                  <router-link to="listeEleve" class="dropdown-item">
                                    <span @click="ListeEleve(data, i)" style="color: black;">
                                      <i class="ti-list"></i> Liste des élèves
                                    </span>
                                  </router-link>

                                  <!-- Modifier la classe -->
                                  <span
                                    @click="showUpdatingModal(data, i)"
                                    class="dropdown-item"
                                    style="color: black;"
                                  >
                                    <i class="ti-pencil"></i> Modifier la classe
                                  </span>

                                  <!-- Affecter un professeur principal -->
                                  <span
                                    @click="showUpdatingModal2(data, i)"
                                    class="dropdown-item"
                                    style="color: black;"
                                  >
                                    <i class="ti-user"></i> Affecter un professeur
                                  </span>

                                  <!-- Rapport Conseil de Classe -->
                                  <span
                                    @click="generate(data, i)"
                                    class="dropdown-item"
                                    style="color: black;"
                                  >
                                    <i class="ti-printer"></i> Rapport Conseil de Classe
                                  </span>

                                  <!-- Relevé de Notes -->
                                  <span
                                    @click="generaterel(data, i)"
                                    class="dropdown-item"
                                    style="color: black;"
                                  >
                                    <i class="fa-solid fa-circle-info"></i> Relevé de Notes
                                  </span>

                                  <!-- Fiche de paiment -->
                                  <span
                                    @click="generatepaiement(data, i)"
                                    class="dropdown-item"
                                    style="color: black;"
                                  >
                                    <i class="fa-solid fa-circle-info"></i> Fiche de paiement
                                  </span>
                                </div>
                              </div>
                            </td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
                  <!-- /.box-body -->
                </div>
                <!-- /.box -->
              </div>
              <!-- /.col -->
            </div>
            <!-- /.row -->
          </section>
          <!-- /.content -->
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
      BtnDisabled: "",
      EtabInfos: "",
      cycle: "",
      section: "",
      Modal: false,
      modal6: false,
      modal7: false,
      modalAddClasse: false,
      modalUpadteClasse: false,
      modalUpadteClasse2: false,
      somme: 0,
      data: {
        sigleClasse: "",
        MontantScol: "",
        FraisInscrip: "",
        Fraistrois: "",
        MontantScolAffect: "",
        imageEmploiTmp: "",
        libelleClasse: "",
        prof: "",
        IdFiliere: "",
        IdSpecialite: ""
      },

      Enseignants: "",

      dataRefresh: {
        libelleClasse: "",
        FraisInscrip: "",
        MontantScolAffect: "",
        imageEmploiTmp: "",
        idClasse: "",
        newImage: ""
      },
      showDelateModal: false,
      delateItem: {},
      i: -1,
      datas: [],
      classeItem: "",
      classeId: "",
      visible: false,
      uploadList: [],
      Filiers: [],
      Specialites: [],
      keyword3: "",
      keyword4: ""
    };
  },

  methods: {
    generaterel(data) {
      console.log(data);

      window.open("api/locale/listerelenote/" + data.id);
    },

    generatepaiement(data) {
      window.open("api/locale/listepourpaiement/" + data.id);
    },

    generate(data) {
      console.log(data);

      window.open("api/locale/listeprof/" + data.id);
    },
    async Affecttation2() {
      // Affecter une matiere a un professeur , ItemMatiere  contient les infos de la matiere

      if (this.data.prof == "") {
        return this.e("Sélectionner un enseignant  ");
      } else {
        // Ajouter lid du prof  choisi aux donnes de la  matiere

        this.delateItem.Enseignants = this.data.prof;

        const response = await this.callApi(
          "post",
          "/api/locale/doProfPrincipal",
          this.delateItem
        );

        if (response.status == 200) {
          this.s("Affectation modifiée correctement");
          this.modalUpadteClasse2 = false;

          const response2 = await this.callApi(
            "post",
            "api/locale/getClasseEtablissement2",
            this.EtabInfos
          );
          this.datas = response2.data;

          this.datas = this.datas.filter(item => item.eleves.length > 0);

          for (let i = 0; i <= this.datas.length; i++) {
            this.somme = this.somme + parseInt(this.datas[i].eleves.length);
          }

          // this.$router.go();
        } else {
          this.e("Une erreure est survenue");
        }
      }
    },

    ShowmodalAddClasse() {
      this.modalAddClasse = true;
    },

    showUpdatingModal(data, i) {
      this.delateItem = data;
      this.modalUpadteClasse = true;
      this.dataRefresh.scolariteaff_Classe = data.scolariteaff_Classe;
      this.dataRefresh.scolarite_Classe = data.scolarite_Classe;
      this.dataRefresh.inscription_Classe = data.inscription_Classe;
      this.dataRefresh.libelleClasse = data.libelleClasse;
      this.dataRefresh.imageEmploiTmp = data.emp_Classe;
    },

    showUpdatingModal2(data, i) {
      this.delateItem = data;

      this.modalUpadteClasse2 = true;
    },

    async updateClasse() {
      this.dataRefresh.idClasse = this.delateItem.id;

      if (this.dataRefresh.libelleClasse.trim() == "") {
        return this.e("Saisir un nom de la classe ");
      }

      if (
        this.dataRefresh.scolariteaff_Classe == "" ||
        this.dataRefresh.scolariteaff_Classe < 0
      ) {
        return this.e("Montant de l 'inscription incorrect ou absent ");
      }

      if (
        this.dataRefresh.scolarite_Classe == "" ||
        this.dataRefresh.scolarite_Classe < 0
      ) {
        return this.e("Montant de la tranche1 incorrect ou absent ");
      }

      if (
        this.dataRefresh.inscription_Classe == "" ||
        this.dataRefresh.inscription_Classe < 0
      ) {
        return this.e("Montant de la tranche2 incorrect ou absent ");
      }

      const response = await axios.post(
        "api/locale/updateClasse",
        this.dataRefresh
      );
      if (response.status === 200) {
        this.s("Classe modifiée correctement");

        this.modalUpadteClasse = false;

        this.$router.go();
      }
      // this.modal2 = false;
    },

    showDelatingModal(data, i) {
      this.delateItem = data;
      this.i = i;
      this.showDelateModal = true;
    },

    async delateClasse() {
      console.log(this.delateItem);
      const response = await axios.post(
        "api/locale/delateClasse",
        this.delateItem
      );
      if (response.status === 200) {
        console.log(this.delateItem);
        this.datas.splice(this.i, 1);
        this.showDelateModal = false;
        this.s("Classe supprimée correctement");
      }
      // this.modal2 = false;
    },
    async handleRemove(file) {
      const image = this.data;

      this.data.imageLogo = "";

      this.$refs.uploads.clearFiles();

      try {
        await axios.post("api/admin/delateImage", image);
      } catch (e) {
        this.generalError = e.response.data.errors;
      }
    },

    handleView(name) {
      this.data.imageLogo = name;
      this.visible = true;
    },

    handleSuccess(res, file) {
      this.data.imageEmploiTmp = res;
      // this.dataRefresh.newImage= res;
      console.log(res);
    },

    handleError(res, file) {
      this.w("Sélectionner un jpg, png , jpeg, pdf, doc, ou docx");
    },
    handleFormatError(file) {
      this.w("Sélectionner un jpg, png , jpeg, pdf, doc, ou docx");
    },
    handleMaxSize(file) {
      this.w("Sélctionner un fichier de moins de 2M.");
    },

    handleBeforeUpload() {
      const check = this.uploadList.length < 1;
      if (!check) {
        this.w("Le logo est requi");
      }
      return check;
    },
    async Submit() {
      if (this.data.sigleClasse.trim() == "") {
        return this.e("Saisir un nom de la classe ");
      }
      //   if (
      //     this.data.MontantScolAffect.trim() == "" ||
      //     this.data.MontantScolAffect < 0
      //   ) {
      //     return this.e("Montant montant de l'inscription incorrect ou absent ");
      //   }

      //   if (this.data.MontantScol.trim() == "" || this.data.MontantScol < 0) {
      //     return this.e("Montant de la tranche1 incorrect ou absent ");
      //   }

      //   if (this.data.FraisInscrip.trim() == "" || this.data.FraisInscrip < 0) {
      //     return this.e("Montant de la tranche2 incorrect ou absent ");
      //   }

      //   if (this.data.imageEmploiTmp.trim() == "") {
      //     return this.e("Insérer l'emploi du temps");
      //   }

      this.data.EcoleInfos = this.EtabInfos;
      this.data.EcoleInfos.cycle = this.cycle;

      const res = await this.callApi("post", "api/locale/Addclasse", this.data);

      if (res.status == 400) {
        this.w("Cette classe existe déja ");

        // this.$router.go();
      } else if (res.status == 200) {
        this.s("Classe ajoutée correctement");

        this.datas.unshift(res.data);

        this.modalAddClasse = false;
      } else {
        this.e("Une erreure est survenue");
      }
    },

    cloturer(data, i) {
      this.classeItem = data;
      // Enregistrer les donnees de la classe  dans le local storage
      localStorage.setItem("classeItem", JSON.stringify(data));
    },

    ListeEleve(data, i) {
      this.classeId = data;

      // mettre  id de la classe cliquee  dans le local storage

      localStorage.setItem("classeId", JSON.stringify(data));

      // console.log(data);
    }
  },

  async created() {
    //this.$Spin.show();
    // Recuperer toutes les infos de cette ecole dans le storage

    if (!localStorage.users) {
      this.$router.push("login");
    }

    if (localStorage.EtabInfos) {
      this.EtabInfos = JSON.parse(localStorage.getItem("EtabInfos"));

      this.data.EcoleInfos = this.EtabInfos;
    }

    this.cycle = JSON.parse(localStorage.getItem("niveau"));
    this.section = JSON.parse(localStorage.getItem("classe"));

    this.EtabInfos[0].cycle = this.cycle;
    this.EtabInfos[0].section = this.section;

    const resFilieres = await this.callApi(
      "post",
      "api/locale/getFileres",
      this.EtabInfos
    );

    this.Filieres = resFilieres.data;

    const resSpecialites = await this.callApi(
      "post",
      "api/locale/getSpectialites"
    );

    this.Specialites = resSpecialites.data;

    const res = await this.callApi("post", "api/locale/getAllEnseignant");

    this.Enseignants = res.data.contentSimple;

    const response2 = await this.callApi(
      "post",
      "api/locale/getClasseEtablissement2",
      this.EtabInfos
    );

    if (response2.status == 200) {
      this.$Spin.hide();
    }

    this.datas = response2.data;

    // Je  n'affiche que les classes qui ont un eleve au moins , commtez cette ligne en cas de new ecole ou on recree les classes

    // this.datas = this.datas.filter(item => item.eleves.length > 0);

    for (let i = 0; i <= this.datas.length; i++) {
      this.somme = this.somme + parseInt(this.datas[i].eleves.length);
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
