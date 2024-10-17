<template>
  <div>
    <div class="wrapper">
      <Header />
      <MenuLocal />

      <div class="content-wrapper" style="min-height: 653px; background-color:#FAFBFD">
        <div class="container-full">
          <!-- Main content -->

          <Modal v-model="showDelateModal" width="360">
            <p slot="header" style="color:#f60;text-align:center">
              <span>Suppression</span>
            </p>
            <div style="text-align:center">
              <p>Etes-vous sure de vouloir supprimer ?</p>
            </div>
            <div slot="footer">
              <Button type="error" size="large" long @click="delatePaiement">Confirmer</Button>
            </div>
          </Modal>

          <section class="content">
            <div class="row">
              <div class="col-md-12">
                <Upload
                  multiple
                  type="drag"
                  action="api/admin/uploadstudent"
                  :data="this.data"
                  :on-success="handleSuccess
                                                "
                  :on-error="handleError
        "
                  :format="[

        'xls',
        'xlsx'
    ]"
                  :on-format-error="handleFormatError
    "
                  :headers="{
        'X-Requested-With':
            'XMLHttpRequest'
    }"
                >
                  <div style="padding: 20px 0">
                    <Icon type="ios-cloud-upload" size="52" style="color: #3399ff"></Icon>
                    <p
                      class="text-center"
                    >Cliquer ici pour charger un Fichier importation des eleves</p>
                  </div>
                </Upload>
              </div>
            </div>

            <div class="row pt-5">
              <div class="col-12">
                <div class="box">
                  <div class="box-header bg-primary">
                    <h4 class="box-title" style="margin:auto">
                      <strong>
                        {{
                        data.classeId.libelleClasse
                        }}
                      </strong>
                    </h4>

                    <button
                      @click="generateAllPdf"
                      type="button"
                      class="waves-effect btn btn-primary mb-5 pull-center"
                    >
                      <strong>
                        <!-- <Icon type="md-print" />  -->
                        CARTES
                      </strong>
                    </button>

                    <h1 type="button" class="pull-right mb-5">
                      <strong>
                        {{ rows }}
                        <Icon type="ios-school" />
                      </strong>
                    </h1>

                    <button
                      @click="generatePdf"
                      type="button"
                      class="waves-effect btn btn-primary mb-5"
                    >
                      <strong>
                        <!-- <Icon type="ios-school" /> -->
                        LISTES
                      </strong>
                    </button>

                    <button
                      @click="generatePdf2"
                      type="button"
                      class="waves-effect btn btn-primary mb-5"
                    >
                      <strong>Manquements</strong>
                    </button>

                    <button
                      @click="generatePdf3"
                      type="button"
                      class="waves-effect mb-5 btn btn-primary"
                    >
                      <strong>CERTIFICAT DE SCOLARITE</strong>
                    </button>
                  </div>

                  <div class="box-body">
                    <div class="table-responsive">
                      <table class="table product-overview">
                        <thead>
                          <tr>
                            <th></th>
                            <th></th>
                            <th>Noms et prénoms</th>
                            <th>Matricule</th>
                            <th>Dates</th>
                            <th>Lieux</th>
                            <th>Sexe</th>
                            <th>Redoublant</th>
                            <th>Statut</th>
                            <th></th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr
                            v-for="(data,
                                                        i) in classeListe"
                            :key="i"
                          >
                            <td>{{ i + 1 }}</td>

                            <td>
                              <img
                                :src="`/Photos/Logos/${data.user.photo}`
                                                                "
                                alt
                                width="50"
                                height="30"
                              />
                            </td>

                            <td>
                              {{ data.nom }}
                              {{
                              data.prenom
                              }}
                            </td>
                            <td>{{ data.matricule }}</td>
                            <td>{{ data.dateNaiss | dateFormat }}</td>
                            <td>{{ data.lieuNaiss }}</td>
                            <td>{{ data.sexe }}</td>
                            <td>{{ data.doublant }}</td>
                            <td>
                              <span v-if="data.statut == 2" style="font-size:25px;color:green">
                                <Icon type="md-checkmark-circle" />
                              </span>

                              <span v-if="data.statut == 0" style="font-size:25px;color:red">
                                <Icon type="md-close-circle" />
                              </span>

                              <span
                                v-if="data.statut == 3"
                                style="font-size:25px;color:rgb(22, 20, 21)"
                              >
                                <Icon type="md-warning" />
                              </span>
                            </td>

                            <td align="center">
                              <router-link to="detailsEleve">
                                <button
                                  @click="
                                                                    ParentEleve(
                                                                        data,
                                                                        i
                                                                    )
                                                                    "
                                  class="btn btn-primary btn-xs"
                                  title="Les details sur cet eleve "
                                >
                                  <Icon type="md-apps" />
                                </button>
                              </router-link>

                              <button
                                @click="
                                                                generateCniPdf(
                                                                    data,
                                                                    i
                                                                )
                                                                "
                                class="btn btn-warning btn-xs"
                              >
                                <i class="ti-printer" title="Imprimer la CNI en PDF "></i>
                              </button>

                              <router-link to="editStudent">
                                <button
                                  @click="
                                                                    ParentEleve(
                                                                        data,
                                                                        i
                                                                    )
                                                                    "
                                  class="btn btn-success btn-xs"
                                >
                                  <Icon type="md-create" />
                                </button>
                              </router-link>

                              <button
                                @click="
                                                                showDelatingModal(
                                                                    data,
                                                                    i
                                                                )
                                                                "
                                class="btn btn-danger btn-xs"
                              >
                                <i class="ti-trash" title="supprimer "></i>
                              </button>
                            </td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- <b-pagination :total-rows="rows" @change="handlePageChange" size="lg" v-model="currentPage"
                            align="center" :per-page="12" :current-page="currentPage">
            </b-pagination>-->
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
import VueHtml2pdf from "vue-html2pdf";
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
  components: { Header, MenuLocal, Chats, VueHtml2pdf },
  data() {
    return {
      data: {
        classeId: 12,
        currentPage: 0
      },

      rows: 0,
      currentPage: 0,

      showDelateModal: false,
      delateItem: {},
      i: -1,
      classeListe: [],
      EtabInfos: [],
      parentEleveInfos: []
    };
  },

  methods: {
    handlePageChange(value) {
      this.data.currentPage = value - 1;

      console.log(value);

      this.getAll();
    },

    handleSuccess(res, file) {
      this.data.imageEmploiTmp = res;
      this.s("Importation effectuée avec succès");
      this.$router.push("classes");
    },

    handleFormatError(file) {
      this.w("Selectionner un fichier Excel ");
    },

    handleError(res, file) {
      this.w("Une erreur est survenue lors de la procédure.");
    },

    handleBeforeUpload() {
      const check = this.uploadList.length < 1;
      if (!check) {
        this.w("Vous devez inserer un fichier Excel...");
      }
      return check;
    },

    async generatePdf3() {
      if (localStorage.classeId) {
        this.data.classeId = JSON.parse(localStorage.getItem("classeId"));
      }

      alert(this.data.classeId);

      window.open(
        "api/locale/getEleveclassePdf3/" +
          this.data.classeId.id +
          "*" +
          this.data.classeId.codeEtabClasse,
        "_blank"
      );

      const responsePdf = await this.callApi(
        "get",
        "api/locale/getEleveclassePdf3/" +
          this.data.classeId.id +
          "*" +
          this.data.classeId.codeEtabClasse
      );
    },

    async getAll() {
      this.$Spin.show();

      const response2 = await this.callApi(
        "post",
        "api/locale/getEleveclasse",
        this.data
      );

      if (response2.status === 200) {
        this.$Spin.hide();
      }

      this.classeListe = response2.data.content;

      this.rows = response2.data.totalPages;
    },
    async delatePaiement() {
      console.log(this.delateItem);
      const response = await axios.post(
        "api/locale/delateEleve",
        this.delateItem
      );
      if (response.status === 200) {
        console.log(this.delateItem);
        this.classeListe.splice(this.i, 1);
        this.showDelateModal = false;
        this.s("Elève supprimée correctement");
      }
      // this.modal2 = false;
    },

    async generateCniPdf(data, i) {
      // // Recuperer tous les infos de cet eleve

      window.open("api/locale/getEleveCniPdf/" + data.id, "_blank");

      const responsePdf = await this.callApi(
        "get",
        "api/locale/getEleveCniPdf/" + data.id
      );
    },

    showDelatingModal(data, i) {
      this.delateItem = data;
      this.i = i;
      this.showDelateModal = true;
    },

    async generatePdf() {
      if (localStorage.classeId) {
        this.data.classeId = JSON.parse(localStorage.getItem("classeId"));
      }

      // console.log(this.data.classeId);

      // Recuperer tous les eleves de cette classe

      window.open(
        "api/locale/getEleveclassePdf/" +
          this.data.classeId.id +
          "*" +
          this.data.classeId.codeEtabClasse,
        "_blank"
      );

      const responsePdf = await this.callApi(
        "get",
        "api/locale/getEleveclassePdf/" +
          this.data.classeId.id +
          "*" +
          this.data.classeId.codeEtabClasse
      );
    },
    async generatePdf2() {
      if (localStorage.classeId) {
        this.data.classeId = JSON.parse(localStorage.getItem("classeId"));
      }

      // console.log(this.data.classeId);

      // Recuperer tous les eleves de cette classe

      window.open(
        "api/locale/getEleveclassePdf2/" +
          this.data.classeId.id +
          "*" +
          this.data.classeId.codeEtabClasse,
        "_blank"
      );

      const responsePdf = await this.callApi(
        "get",
        "api/locale/getEleveclassePdf2/" +
          this.data.classeId.id +
          "*" +
          this.data.classeId.codeEtabClasse
      );
    },

    async generatePdf4() {
      if (localStorage.classeId) {
        this.data.classeId = JSON.parse(localStorage.getItem("classeId"));
      }

      // console.log(this.data.classeId);

      // Recuperer tous les eleves de cette classe

      window.open(
        "api/locale/getEleveclassePdf4/" +
          this.data.classeId.id +
          "*" +
          this.data.classeId.codeEtabClasse,
        "_blank"
      );

      const responsePdf = await this.callApi(
        "get",
        "api/locale/getEleveclassePdf4/" +
          this.data.classeId.id +
          "*" +
          this.data.classeId.codeEtabClasse
      );
    },

    async generateAllPdf() {
      if (localStorage.classeId) {
        this.data.classeId = JSON.parse(localStorage.getItem("classeId"));
        this.data.currentPage = JSON.parse(localStorage.getItem("classeId"));
      }

      window.open(
        "api/locale/index2/" +
          this.data.classeId.id +
          "*" +
          this.data.classeId.codeEtabClasse,
        "_blank"
      );
      const response2 = await this.callApi(
        "get",
        "api/locale/index2" +
          this.data.classeId.id +
          "*" +
          this.data.classeId.codeEtabClasse
      );

      // Recuperer tous les eleves de cette classe

      //   window.open('api/locale/getAllCniPdf/'+this.data.classeId.id+'*'+this.data.classeId.codeEtabClasse,'_blank')

      //      const responsePdf = await this.callApi(
      //     "get",
      //     "api/locale/getAllCniPdf/"+this.data.classeId.id+'*'+this.data.classeId.codeEtabClasse

      // );
    },

    ParentEleve(data, i) {
      localStorage.setItem("parentEleveInfos", JSON.stringify(data));

      console.log("Je suis la ", data);
    }
  },

  async mounted() {
    // Recuperer les infos de cette classe  dans le storage. classdId  contient toutes les classes et leur eleves respectivement
    // if (!localStorage.users) {
    //   this.$router.push("login");
    // }
    if (localStorage.classeId) {
      this.data.classeId = JSON.parse(localStorage.getItem("classeId"));
      this.data.currentPage = this.data.classeId.id;
    }

    // Recuperer tous les eleves de cette classe

    this.getAll();

    // console.log(this.classeListe);
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
