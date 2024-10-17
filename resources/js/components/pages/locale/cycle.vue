<template>
  <div>
    <div class="wrapper">
      <Header />
      <MenuLocal />

      <Modal v-model="modalAddClasse" title="Ajouter un cycle ">
        <div class="row">
          <div class="col-md-12">
            <label class="form-label">Nom</label>
            <input
              type="text"
              class="form-control"
              v-model.trim="data.nom
                                                    "
            />
          </div>
        </div>

        <div class="row">
          <div class="col-md-12">
            <label class="form-label">Lieu de paiement Contribution exigible</label>
            <input
              type="text"
              class="form-control"
              v-model.trim="data.lieupaiecontrexi
                                                    "
            />
          </div>
        </div>

        <div class="row">
          <div class="col-md-12">
            <label class="form-label">Lieu de paiement Contribution des parents</label>
            <input
              type="text"
              class="form-control"
              v-model.trim="data.lieucontriparent
                                                    "
            />
          </div>
        </div>

        <div class="row">
          <div class="col-md-12">
            <label class="form-label">Lieu de paiement Frais des timbres</label>
            <input
              type="text"
              class="form-control"
              v-model.trim="data.paiefraistimbre
                                                    "
            />
          </div>
        </div>

        <div class="row">
          <div class="col-md-12">
            <label class="form-label">Lieu de paiement Frais d'examen</label>
            <input type="text" class="form-control" v-model.trim="data.paiefraisexam" />
          </div>
        </div>

        <br />

        <div slot="footer">
          <Button type="primary" size="large" long @click="Submit()">Enregistrer</Button>
        </div>
      </Modal>

      <div class="content-wrapper">
        <div class="container">
          <section class="content">
            <div class="row">
              <div
                class="col-md-3"
                @click="SadeData(data.id)"
                v-for="(data,
                                                        i) in sections"
                :key="i"
              >
                <div class="card" style="background-color: green;color: white;">
                  <!-- <Icon type="md-albums" style="margin-top: 50px;font-size: 60px;" /> -->

                  <span style="margin-top: 40px;font-size: 50px; text-align:center;">📚</span>

                  <div class="box-body py-25" style="text-align: center;">
                    <p class="font-weight-600">{{data.nom}}</p>
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
      data: {
        cycle1: 1,
        nom: "", // Nom de la classe
        lieupaiecontrexi: "", // Lieu de paiement contre-extrait
        lieucontriparent: "", // Lieu de contrat pour le parent
        paiefraistimbre: "", // Paiement des frais de timbre
        paiefraisexam: "" // Paiement des frais d'examen
      },
      modalAddClasse: false,
      sections: ""
    };
  },

  async mounted() {
    if (!localStorage.users) {
      this.$router.push("login");
    }

    // Recuperer les donnes de cet utulisateurs dans la storage local

    if (localStorage.users) {
      this.users = JSON.parse(localStorage.getItem("users"));
    }

    const response = await this.callApi("post", "api/locale/section");

    this.sections = response.data;
  },

  methods: {
    SadeData(data) {
      localStorage.setItem("niveau", JSON.stringify(data));
      this.$router.push({ name: "niveau" });
    },

    ShowmodalAddClasse() {
      this.modalAddClasse = true;
    },

    SadeData2(data) {
      // localStorage.setItem("section", JSON.stringify(data));
      // this.$router.push("niveau");

      this.$router.push({ name: "niveau", params: { data: data } });
    },

    SadeData3(data) {
      localStorage.setItem("section", JSON.stringify(data));
      this.$router.push("niveau");
    },

    SadeData4(data) {
      localStorage.setItem("section", JSON.stringify(data));

      this.$router.push("niveau");
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
