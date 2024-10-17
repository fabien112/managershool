<template>
  <div>
    <div class="wrapper">
      <Header />
      <MenuLocal />

      <Modal v-model="modalAddClasse" size="lg" title="Ajouter un niveau">
        <!-- Nom du niveau -->
        <div class="row">
          <div class="col-md-12">
            <label
              class="form-label text-center font-weight-bold"
              style="font-size: 18px;"
            >Nom du niveau</label>
            <input type="text" class="form-control" v-model.trim="data.nom" placeholder="6 EME" />
          </div>
        </div>

        <!-- Contribution exigible -->
        <div class="row pt-3">
          <div class="col-md-12">
            <label
              class="form-label text-center font-weight-bold"
              style="font-size: 18px;"
            >Contribution exigible</label>
          </div>
          <div class="col-md-6">
            <input
              type="text"
              class="form-control"
              v-model.trim="data.lieupaiecontrexi"
              placeholder="Lieu de paiement"
            />
          </div>
          <div class="col-md-6">
            <input
              type="number"
              class="form-control"
              v-model.trim="data.amountlieupaiecontrexi"
              placeholder="Montant"
            />
          </div>
        </div>

        <!-- Contribution des parents -->
        <div class="row pt-3">
          <div class="col-md-12">
            <label
              class="form-label text-center font-weight-bold"
              style="font-size: 18px;"
            >Contribution des parents</label>
          </div>
          <div class="col-md-6">
            <input
              type="text"
              class="form-control"
              v-model.trim="data.lieucontriparent"
              placeholder="Lieu de paiement"
            />
          </div>
          <div class="col-md-6">
            <input
              type="number"
              class="form-control"
              v-model.trim="data.amountlieucontriparent"
              placeholder="Montant"
            />
          </div>
        </div>

        <!-- Frais des timbres -->
        <div class="row pt-3">
          <div class="col-md-12">
            <label
              class="form-label text-center font-weight-bold"
              style="font-size: 18px;"
            >Frais des timbres</label>
          </div>
          <div class="col-md-6">
            <input
              type="text"
              class="form-control"
              v-model.trim="data.paiefraistimbre"
              placeholder="Lieu de paiement"
            />
          </div>
          <div class="col-md-6">
            <input
              type="number"
              class="form-control"
              v-model.trim="data.amountpaiefraistimbre"
              placeholder="Montant"
            />
          </div>
        </div>

        <!-- Contribution Frais examens -->
        <div class="row pt-3">
          <div class="col-md-12">
            <label
              class="form-label text-center font-weight-bold"
              style="font-size: 18px;"
            >Contribution Frais examens</label>
          </div>
          <div class="col-md-6">
            <input
              type="text"
              class="form-control"
              v-model.trim="data.paiefraisexam"
              placeholder="Lieu de paiement"
            />
          </div>
          <div class="col-md-6">
            <input
              type="number"
              class="form-control"
              v-model.trim="data.amountpaiefraisexam"
              placeholder="Montant"
            />
          </div>
        </div>

        <!-- Footer du modal -->
        <br />
        <div slot="footer">
          <Button type="primary" size="large" long @click="Submit()">Enregistrer</Button>
        </div>
      </Modal>

      <div class="content-wrapper">
        <div class="container">
          <section class="content">
            <!-- START Card With Image -->

            <div class="row">
              <div class="col-12">
                <div class="box">
                  <div class="box-header bg-primary">
                    <h4 class="box-title">Niveaux</h4>

                    <span>
                      <button
                        type="button"
                        class="pull-right btn btn-primary"
                        @click="ShowmodalAddClasse"
                      >
                        <Icon type="md-add" />Cathegories / Niveau
                      </button>
                    </span>
                  </div>
                  <div class="box-body">
                    <div class="table-responsive">
                      <table id="example" class="table simple mb-0" style="width:100%">
                        <thead>
                          <tr>
                            <th>Désignation</th>
                            <th>Contribution exigible</th>
                            <th>Contribution Parent</th>
                            <th>Frais Timbre</th>
                            <th>Frais Examen</th>
                            <th>Action</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr v-for="cycle in cycles" :key="cycle.id">
                            <td>
                              <h5>{{ cycle.designation }}</h5>
                            </td>
                            <td>
                              <span
                                class="btn btn-xs"
                                style="background-color:#0052CC;color:white"
                              >{{ cycle.lieucontriexg }}</span>

                              <br />
                              {{ cycle.amountlieucontriexg }} Fcfa
                            </td>
                            <td>
                              <span
                                class="btn btn-xs"
                                style="background-color:#0052CC;color:white"
                              >{{ cycle.lieucontripar}}</span>

                              <br />
                              {{ cycle.amountlieucontripar }} Fcfa
                            </td>
                            <td>
                              <span
                                class="btn btn-xs"
                                style="background-color:#0052CC;color:white"
                              >{{ cycle.lieufraistimbre }}</span>

                              <br />
                              {{ cycle.amountlieufraistimbre }} Fcfa
                            </td>
                            <td>
                              <span
                                class="btn btn-xs"
                                style="background-color:#0052CC;color:white"
                              >{{ cycle.lieufraisexam }}</span>
                              <br />
                              {{ cycle.amountlieufraisexam }} Fcfa
                            </td>
                            <td>
                              <!-- Bouton Voir -->
                              <button
                                class="btn btn-primary btn-sm"
                                @click="voir(cycle.id)"
                                style="margin-right: 5px;"
                              >
                                <i class="fa-solid fa-circle-info"></i>
                              </button>

                              <!-- Bouton Modifier -->
                              <button class="btn btn-secondary btn-sm" @click="edit(cycle.id)">
                                <i class="fa-solid fa-pen-to-square"></i>
                              </button>
                            </td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>

              <!-- /.col -->
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
        nom: "", // Nom du niveau (classe)
        lieupaiecontrexi: "", // Lieu de paiement contre-extrait
        amountlieupaiecontrexi: 0, // Montant pour le lieu de paiement contre-extrait
        lieucontriparent: "", // Lieu de paiement pour la contribution des parents
        amountlieucontriparent: 0, // Montant de la contribution des parents
        paiefraistimbre: "", // Lieu de paiement pour les frais de timbre
        amountpaiefraistimbre: 0, // Montant des frais de timbre
        paiefraisexam: "", // Lieu de paiement pour les frais d'examen
        amountpaiefraisexam: 0, // Montant des frais d'examen
        section: ""
      },
      modalAddClasse: false,
      cycles: "",
      values: ""
    };
  },

  async mounted() {
    if (!localStorage.users) {
      this.$router.push("login");
    }

    this.values = this.$route.params.id;

    // Recuperer les donnes de cet utulisateurs dans la storage local

    if (localStorage.users) {
      this.users = JSON.parse(localStorage.getItem("users"));
    }

    this.data.section = JSON.parse(localStorage.getItem("niveau"));

    const response = await this.callApi("post", "api/locale/cycle", this.data);

    this.cycles = response.data;
  },

  methods: {
    voir(data) {
      localStorage.setItem("classe", JSON.stringify(data));
      this.$router.push("classes");
    },

    ShowmodalAddClasse() {
      this.modalAddClasse = true;
    },

    SadeData2(data) {
      localStorage.setItem("cycle", JSON.stringify(data));

      this.$router.push("classes");
    },

    SadeData3(data) {
      localStorage.setItem("cycle", JSON.stringify(data));

      this.$router.push("classes");
    },

    SadeData4(data) {
      localStorage.setItem("cycle", JSON.stringify(data));

      this.$router.push("classes");
    },

    async Submit() {
      // Vérification des champs obligatoires
      if (
        this.data.nom.trim() === "" ||
        this.data.lieupaiecontrexi.trim() === "" ||
        this.data.lieucontriparent.trim() === "" ||
        this.data.paiefraistimbre.trim() === "" ||
        this.data.paiefraisexam.trim() === ""
      ) {
        return this.e("Veuillez saisir toutes les informations requises.");
      }

      // Vérification des montants
      if (
        this.data.amountlieupaiecontrexi < 0 ||
        this.data.amountlieucontriparent < 0 ||
        this.data.amountpaiefraistimbre < 0 ||
        this.data.amountpaiefraisexam < 0
      ) {
        return this.e(
          "Veuillez saisir des montants valides pour les paiements."
        );
      }

      try {
        // Appel de l'API
        const res = await this.callApi(
          "post",
          "api/locale/Addcycle",
          this.data
        );

        // Vérification du statut de la réponse
        if (res.status === 200) {
          this.s("Ajouté correctement.");
          this.cycles.push(res.data);
          this.modalAddClasse = false;
        } else {
          // Gérer les autres statuts d'erreur ici
          this.e("Une erreur est survenue.");
        }
      } catch (error) {
        // Gestion des erreurs de l'appel API
        this.e("Une erreur est survenue lors de l'appel de l'API.");
        console.error(error); // Pour un debug plus détaillé
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
