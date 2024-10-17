<template>
  <div>
    <div class="wrapper">
      <Header />
      <MenuLocal />
      <div class="content-wrapper">
        <div class="container-full">
          <section class="content">
            <div class="row align-items-end">
              <div class="col-xl-12 col-12">
                <div class="box pull-up" style="background-color: #2C353D;">
                  <div class="box-body p-xl-0">
                    <div class="row align-items-center">
                      <div class="col-12 col-lg-3">
                        <img src="images/cap3.png" alt />
                      </div>

                      <div class="col-12 col-lg-9 text-warning">
                        <h3
                          v-for="(data,
                                                    i) in EtabInfos"
                          :key="i"
                        >
                          😊 😊 Hi ,
                          {{ data.libelleEtab }} ✋
                        </h3>

                        <p class="text-white mb-0 font-size-10">
                          <strong>
                            Bienvenu(e)
                            {{ this.users.nom }}
                            {{ this.users.prenom }}
                            ✋
                            <br />Administrateur de l'année scolaire 2024-2025
                          </strong>
                        </p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-12">
                <div class="box no-shadow mb-0 bg-transparent">
                  <div class="box-header no-border px-0">
                    <Alert fade="true">
                      Entrées scolarité 💰
                      <span
                        class="pull-right"
                        style="font-size: 40px;"
                      >{{ totalEntree }}</span>
                      <template slot="desc">Montant total des paiements recus</template>
                    </Alert>
                  </div>
                </div>
              </div>

              <!-- <div class="col-4">
                <router-link to="autreentreelocal">
                  <div class="box no-shadow mb-0 bg-transparent">
                    <div class="box-header no-border px-0">
                      <Alert fade="true" show-icon closable>
                        Autres entrées
                        <span class="pull-right" style="font-size: 40px;">💸</span>

                        <template slot="desc">{{ totalEntree2 }} F</template>
                      </Alert>
                    </div>
                  </div>
                </router-link>
              </div>

              <div class="col-4">
                <div class="box no-shadow mb-0 bg-transparent">
                  <div class="box-header no-border px-0">
                    <Alert fade="true" show-icon closable>
                      Total de vos entrées
                      <span class="pull-right" style="font-size: 40px;">💰</span>
                      <template slot="desc">
                        {{ totalEntree + totalEntree2 }}
                        F
                      </template>
                    </Alert>
                  </div>
                </div>
              </div>-->

              <!-- <div class="col-4">
                <div class="box no-shadow mb-0 bg-transparent">
                  <div class="box-header no-border px-0">
                    <Alert type="success" fade="true" show-icon closable>
                      DEPENSES
                      <span class="pull-right" style="font-size: 40px;">💸</span>

                      <template slot="desc">
                        {{
                        totalSorties.total -
                        totalCaisseBanque
                        }}
                        F
                      </template>
                    </Alert>
                  </div>
                </div>
              </div>

              <div class="col-4">
                <div class="box no-shadow mb-0 bg-transparent">
                  <div class="box-header no-border px-0">
                    <Alert type="error" fade="true" show-icon closable>
                      Solde en caisse
                      <span class="pull-right" style="font-size: 40px;">💰</span>
                      <template slot="desc">{{ solde }} F</template>
                    </Alert>
                  </div>
                </div>
              </div>

              <div class="col-4">
                <div class="box no-shadow mb-0 bg-transparent">
                  <div class="box-header no-border px-0">
                    <Alert type="warning" fade="true" show-icon closable>
                      Solde en banque
                      <span class="pull-right" style="font-size: 40px;">💸</span>
                      <template slot="desc">
                        {{
                        datas.totalAppro -
                        datas.totalSortiBank
                        }}
                        F
                      </template>
                    </Alert>
                  </div>
                </div>
              </div>-->
            </div>

            <div class="row">
              <div class="col-xl-3 col-12">
                <router-link to="cycle">
                  <div class="box" style="background-color:#E67D21;color:white">
                    <div class="box-body">
                      <h1 style="font-size: 20px;">
                        {{ Stats["totalEleves"] }}
                        <!--
                        <Divider type="vertical" />-->
                        <!--  <Icon type="md-walk" class="pull-right " style="font-size: 80px;" /> -->

                        <span class="pull-right" style="font-size: 60px;">👨🏽‍🎓</span>
                      </h1>
                      <p class="mt-0 mb-20" style="font-size: 10px;">ELEVES</p>
                      <div id="charts_widget_2_chart"></div>
                    </div>
                  </div>
                </router-link>
              </div>

              <div class="col-xl-3 col-12">
                <router-link to="enseignants">
                  <div class="box" style="background-color:#2196F3;color:white">
                    <div class="box-body">
                      <h1 style="font-size: 20px;">
                        {{ Stats["totalEnseignants"] }}
                        <span
                          class="pull-right"
                          style="font-size: 60px;"
                        >👨‍🏫</span>
                      </h1>
                      <p class="mt-0 mb-20" style="font-size: 10px;">ENSEIGNANTS</p>
                      <div id="charts_widget_2_chart"></div>
                    </div>
                  </div>
                </router-link>
              </div>
              <div class="col-xl-3 col-12">
                <router-link to="cycle">
                  <div class="box" style="background-color:#6b5e62;color:white">
                    <div class="box-body">
                      <h1 style="font-size: 20px;">
                        {{ Stats["totalClasse"] }}
                        <span
                          class="pull-right"
                          style="font-size: 60px;"
                        >👨🏽‍🎓</span>
                      </h1>
                      <p class="mt-0 mb-20" style="font-size: 10px;">CLASSES</p>
                      <div id="charts_widget_2_chart"></div>
                    </div>
                  </div>
                </router-link>
              </div>

              <div class="col-xl-3 col-12">
                <router-link to="parents">
                  <div class="box" style="background-color:#E91E63;color:white">
                    <div class="box-body">
                      <h1 style="font-size: 20px;">
                        {{ Stats["totalElevesRegle"] }}
                        <span
                          class="pull-right"
                          style="font-size: 60px;"
                        >🧑‍🤝‍🧑</span>
                      </h1>
                      <p class="mt-0 mb-20" style="font-size: 10px;">Eleves en regles</p>
                      <div id="charts_widget_2_chart"></div>
                    </div>
                  </div>
                </router-link>
              </div>

              <!-- <div class="col-xl-3 col-12">
                <router-link to="parents">
                  <div class="box" style="background-color:#E91E63;color:white">
                    <div class="box-body">
                      <h1 style="font-size: 20px;">
                        {{ Stats["totalParents"] }}

                        <span class="pull-right" style="font-size: 60px;">🧑‍🤝‍🧑</span>
                      </h1>
                      <p class="mt-0 mb-20" style="font-size: 10px;">PARENTS</p>
                      <div id="charts_widget_2_chart"></div>
                    </div>
                  </div>
                </router-link>
              </div>-->
            </div>

            <div class="row">
              <div class="box">
                <div class="box-header bg-primary" style>
                  <h4
                    class="box-title"
                  >Rechercher un élève avec son nom , son prénom ou son matricule</h4>
                </div>

                <div class="box-footer">
                  <div class="row">
                    <div class="col-md-9">
                      <div class="form-group">
                        <label for>Keyword</label>

                        <input
                          class="form-control"
                          placeholder="Saisir le nom  ou le matricule de l’élève"
                          v-model="data.nom"
                        />
                      </div>
                    </div>

                    <div class="col-md-3">
                      <br />
                      <div class="form-group">
                        <button @click="Afficher" class="btn btn-outline btn-primary">
                          <Icon type="ios-search" />Rechercher
                        </button>
                      </div>
                    </div>
                  </div>

                  <div class="row"></div>

                  <div class="row">
                    <div class="col-12" v-if="cache == true">
                      <!-- /.box -->

                      <div class="box">
                        <div class="box-body">
                          <div class="table-responsive">
                            <table id="example" class="table simple mb-0" style="width:100%">
                              <thead>
                                <tr>
                                  <th></th>
                                  <th>Matricule</th>
                                  <th>Nom et Prénom</th>
                                  <th>Classe</th>
                                  <th>Date et lieu de naissance</th>
                                </tr>
                              </thead>
                              <tbody name="fruit-table" is="transition-group">
                                <tr
                                  v-for="(data,
                                                                    i) in ElevesAbsences"
                                  :key="i"
                                >
                                  <td>
                                    <img
                                      :src="`/Photos/Logos/${data.user.photo}`
                                                                            "
                                      alt
                                      width="50"
                                      height="50"
                                    />
                                  </td>

                                  <td>{{ data.matricule }}</td>

                                  <td>{{ data.nom }} {{ data.prenom }}</td>

                                  <td>{{ data.classe.libelleClasse }}</td>

                                  <td>
                                    {{ data.dateNaiss | dateFormat }} à {{
                                    data.lieuNaiss }}
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
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-xl-4 col-12">
                <div class="box">
                  <div class="box-header bg-primary" style="text-align: center;">
                    <h4 class="box-title">
                      <strong>INCRIPTION / APE</strong>
                    </h4>
                  </div>
                  <div class="box-body">
                    <div class="table-responsive">
                      <table class="table simple mb-0">
                        <tbody>
                          <tr>
                            <td>Total attendu</td>
                            <td class="font-weight-700">{{ Finances.ape }} F</td>
                          </tr>

                          <tr>
                            <td>Total perçu</td>
                            <td class="font-weight-700">{{ Aspayed.ape }} F</td>
                          </tr>

                          <tr>
                            <td>Reste</td>
                            <td class="font-weight-700">
                              {{
                              Finances.ape -
                              Aspayed.ape
                              }}
                              F
                            </td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>

              <div class="col-xl-4 col-12">
                <div class="box">
                  <div class="box-header bg-success" style="text-align: center;">
                    <h4 class="box-title">
                      <strong>TRANCHE 1</strong>
                    </h4>
                  </div>
                  <div class="box-body">
                    <div class="table-responsive">
                      <table class="table simple mb-0">
                        <tbody>
                          <tr>
                            <td>Total attendu</td>
                            <td class="font-weight-700">
                              {{
                              Finances.tranche1
                              }}
                              F
                            </td>
                          </tr>

                          <tr>
                            <td>Total perçu</td>
                            <td class="font-weight-700">
                              {{
                              Aspayed.tranche1
                              }}
                              F
                            </td>
                          </tr>

                          <tr>
                            <td>Reste</td>
                            <td class="font-weight-700">
                              {{
                              Finances.tranche1 -
                              Aspayed.tranche1
                              }}
                              F
                            </td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>

              <div class="col-xl-4 col-12">
                <div class="box">
                  <div class="box-header bg-danger" style="text-align: center;">
                    <h4 class="box-title">
                      <strong>TRANCHE 2</strong>
                    </h4>
                  </div>
                  <div class="box-body">
                    <div class="table-responsive">
                      <table class="table simple mb-0">
                        <tbody>
                          <tr>
                            <td>Total attendu</td>
                            <td class="font-weight-700">
                              {{
                              Finances.tranche2
                              }}
                              F
                            </td>
                          </tr>

                          <tr>
                            <td>Total perçu</td>
                            <td class="font-weight-700">
                              {{
                              Aspayed.tranche2
                              }}
                              F
                            </td>
                          </tr>

                          <tr>
                            <td>Reste</td>
                            <td class="font-weight-700">
                              {{
                              Finances.tranche2 -
                              Aspayed.tranche2
                              }}
                              F
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

export default {
  components: { Header, MenuLocal, Chats },
  data() {
    return {
      EtabInfos: [],
      Stats: [],
      users: [],
      datas: {
        totalAppro: 0,
        totalSortiBank: 0
      },
      Finances: [],
      Aspayed: [],
      totalEntree: 0,
      totalEntree2: 0,
      totalSorties: 0,
      solde: 0,
      data: {
        nom: "",
        prenom: ""
      },

      cache: false,
      ElevesAbsences: ""
    };
  },

  //  Recuperer les donnees envoyees dans la store par computed:

  async mounted() {
    if (!localStorage.users) {
      this.$router.push("login");
    }
    if (localStorage.users) {
      this.users = JSON.parse(localStorage.getItem("users"));
    }
    // this.$Loading.start();
    //this.$Spin.show();

    const response = await this.callApi(
      "post",
      "api/locale/getEtabinfos",
      this.users
    );

    this.EtabInfos = response.data;

    // Garder les donnees de l'ecole dans le storage de navigateur

    localStorage.setItem("EtabInfos", JSON.stringify(this.EtabInfos));

    //  STATISTIQUES

    const response5 = await this.callApi(
      "post",
      "api/locale/getAstudentDatailsFinancesDashboard",
      this.EtabInfos
    );

    this.Aspayed = response5.data;

    const response2 = await this.callApi(
      "post",
      "api/locale/getstatsEtab",
      this.EtabInfos
    );

    this.Stats = response2.data;

    const response3 = await this.callApi(
      "post",
      "api/locale/getRecapFinances",
      this.EtabInfos
    );
    this.Finances = response3.data;

    const response9 = await this.callApi(
      "post",
      "api/locale/getEntressAutre",
      this.EtabInfos
    );

    this.datas = response9.data;

    const response8 = await this.callApi(
      "post",
      "api/locale/getTotaldepense",
      this.EtabInfos
    );

    this.totalSorties = response8.data;

    this.totalEntree =
      parseInt(this.Aspayed.ape, 10) +
      parseInt(this.Aspayed.tranche1, 10) +
      parseInt(this.Aspayed.tranche2, 10);

    this.totalEntree2 = parseInt(this.Aspayed.autre, 10);

    // pour avoir le solde de la caisse  je fais toutes les entrees - toutes les depense ( depense et depot en banque)

    // je dois inclure les entrees qui viennene t de l'approvisionnement bancaire ( mais cette entree n'est pas pris en compte dans la somme des entre)

    this.totalVenantDeBank = parseInt(this.Aspayed.totalBanqueCaisse, 10);

    this.totalCaisseBanque = parseInt(this.Aspayed.totalCaiiseBanque, 10);

    this.solde =
      this.totalEntree +
      this.totalEntree2 +
      this.totalVenantDeBank -
      this.totalSorties.total;

    if (response.status == 200) {
      // this.$Loading.finish();
      this.$Spin.hide();
    }
  },

  methods: {
    async pdf() {
      const response8 = await this.callApi("post", "api/pdf");
    },
    async Afficher() {
      if (this.data.nom == "") {
        return this.e("Mentionner le nom ou le matricule ");
      }

      this.data.EtabInfos = this.EtabInfos;

      const response4 = await this.callApi(
        "post",
        "api/caisse/rechercher",
        this.data
      );

      this.ElevesAbsences = response4.data;

      if (this.ElevesAbsences.length != 0) {
        this.cache = true;
      } else {
        this.e("Aucun élève trouvé  dans le système ");
      }
    }
  }
};
</script>
