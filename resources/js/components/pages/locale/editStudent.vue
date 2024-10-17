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
                class="box-header with-border"
                style="background-color:#0052CC;text-align: center; color:white"
              >
                <h4 class="box-title">Modifier un élève</h4>
                <!-- <h6 class="box-subtitle">You can us the validation like what we did</h6> -->
              </div>
              <!-- /.box-header -->
              <div class="box-body wizard-content">
                <form action="#" class @submit.prevent="onSubmit">
                  <!-- Step 1 -->

                  <section>
                    <div></div>
                    <Upload
                      multiple
                      type="drag"
                      action="api/admin/upload"
                      :on-success="handleSuccess"
                      :on-error="handleError"
                      :format="['jpg', 'jpeg']"
                      :max-size="20480"
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
                          pour insérer la photo
                        </p>
                      </div>
                    </Upload>
                    <Modal title="Image" v-model="visible">
                      <img
                        :src="`/Photos/Logos/${data.imageLogo}`
                                                "
                        v-if="visible"
                        style="width: 100%"
                      />
                      <div slot="footer">
                        <Button type="primary" @click="visible = false">Close</Button>
                      </div>
                    </Modal>
                    <div class="demo-upload-list" v-if="data.imageLogo">
                      <img
                        :src="`/Photos/Logos/${data.imageLogo}`
                                                "
                      />
                      <div class="demo-upload-list-cover">
                        <Icon
                          type="ios-eye-outline"
                          @click.native="
                                                    handleView(
                                                        data.imageLogo
                                                    )
                                                    "
                        ></Icon>
                        <Icon
                          type="ios-trash-outline"
                          @click.native="
                                                    handleRemove(
                                                        data.imageLogo
                                                    )
                                                    "
                        ></Icon>
                      </div>
                    </div>

                    <br />
                  </section>

                  <section>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label>
                            Matricule :
                            <span class="danger">*</span>
                          </label>

                          <input
                            class="form-control required"
                            placeholder="Les matricules sont automaquement générés "
                            v-model.trim="data.matricule
                                                            "
                          />
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label>
                            Nom :
                            <span class="danger">*</span>
                          </label>
                          <input type="text" class="form-control required" v-model.trim="data.nom" />
                          <span
                            class="text-danger"
                            v-if="!$v.data.nom
                                                        .required &&
                                                        $v.data.nom
                                                            .$dirty
                                                        "
                          >Le nom est requis</span>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label>
                            Prénom :
                            <span class="danger">*</span>
                          </label>
                          <input
                            type="text"
                            class="form-control required"
                            v-model.trim="data.prenom
                                                        "
                          />
                          <span
                            class="text-danger"
                            v-if="!$v.data.prenom
                                                        .required &&
                                                        $v.data.prenom
                                                            .$dirty
                                                        "
                          >Le prénom est requis</span>
                        </div>
                      </div>
                      <!-- <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="wemailAddress2">
                                                        Addresse email :
                                                        <span class="danger">*</span>
                                                    </label>
                                                    <input type="email" class="form-control required"
                                                        v-model="data.email" />
                                                    <span class="text-danger mt-2" v-if="
                                                        (
                                                            !$v.data.email
                                                                .email) &&
                                                        $v.data.email
                                                            .$dirty
                                                    ">
                                                        L'addresse email est
                                                        invalide
                                                    </span>
                                                </div>
                      </div>-->

                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="wlocation2">
                            Sexe :
                            <span class="danger">*</span>
                          </label>
                          <select class="custom-select form-control required" v-model="data.sexe">
                            <option value>Sélectioner son sexe</option>
                            <option value="M">Masculin</option>
                            <option value="F">Féminin</option>
                          </select>
                          <span
                            class="text-danger"
                            v-if="!$v.data.sexe
                                                        .required &&
                                                        $v.data.sexe
                                                            .$dirty
                                                        "
                          >La sexe est requis</span>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="wlocation2">
                            Classe :
                            <span class="danger">*</span>
                          </label>
                          <select class="custom-select form-control required" v-model="data.classe">
                            <option
                              v-for="(data,
                                                            i) in classes"
                              :key="i"
                              :value="data.id"
                            >{{ data.libelleClasse }}</option>
                          </select>
                          <span
                            class="text-danger"
                            v-if="!$v.data.classe
                                                        .required &&
                                                        $v.data.classe
                                                            .$dirty
                                                        "
                          >La classe est requise</span>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label>Date de naissance :</label>
                          <input
                            type="date"
                            class="form-control required"
                            v-model.trim="data.dateNaiss
                                                        "
                          />
                        </div>
                        <span
                          class="text-danger"
                          v-if="!$v.data.dateNaiss
                                                    .required &&
                                                    $v.data
                                                        .dateNaiss
                                                        .$dirty
                                                    "
                        >
                          La date de naissance est
                          requise
                        </span>
                      </div>

                      <div class="col-md-6">
                        <div class="form-group">
                          <label>
                            Lieu de naissance :
                            <span class="danger">*</span>
                          </label>
                          <input
                            class="form-control required"
                            v-model.trim="data.lieuNaiss
                                                        "
                          />
                          <span
                            class="text-danger"
                            v-if="!$v.data.lieuNaiss
                                                        .required &&
                                                        $v.data
                                                            .lieuNaiss
                                                            .$dirty
                                                        "
                          >Le lieu de naissance est requis</span>
                        </div>
                      </div>

                      <div class="col-md-6">
                        <label for>Situation de l'élève dans la classe</label>

                        <div class="form-group">
                          <RadioGroup v-model="data.redoubl" type="button" button-style="solid">
                            <Radio label="Non"></Radio>
                            <Radio label="Oui"></Radio>
                          </RadioGroup>
                        </div>
                      </div>

                      <Divider>LIAISON AVEC SES PARENTS</Divider>
                    </div>

                    <div class="row">
                      <div class="col-md-6">
                        <Button
                          icon="ios-search"
                          type="primary"
                          @click="modal7 = true"
                          size="large"
                        >LE PERE</Button>
                      </div>
                    </div>

                    <br />

                    <div class="row">
                      <Divider>INFORMATION SUR LA MERE</Divider>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label>
                            Noms et premons :
                            <span class="danger">*</span>
                          </label>
                          <input
                            type="text"
                            class="form-control required"
                            v-model.trim="data.nomParent
                                                        "
                          />
                          <span
                            class="text-danger"
                            v-if="!$v.data.nomParent
                                                        .required &&
                                                        $v.data
                                                            .nomParent
                                                            .$dirty
                                                        "
                          >
                            Le nom du parent est
                            requis
                          </span>
                        </div>
                      </div>

                      <!-- <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>
                                                        Prénom :
                                                        <span class="danger">*</span>
                                                    </label>
                                                    <input type="text" class="form-control required" v-model.trim="data.prenomParent
                                                        " />
                                                    <span class="text-danger" v-if="!$v.data
                                                        .prenomParent
                                                        .required &&
                                                        $v.data
                                                            .prenomParent
                                                            .$dirty
                                                        ">
                                                        Le prénom du parent est
                                                        requis
                                                    </span>
                                                </div>
                      </div>-->

                      <div class="col-md-6">
                        <div class="form-group">
                          <label>
                            Téléphone :
                            <span class="danger">*</span>
                          </label>
                          <input
                            type="number"
                            class="form-control required"
                            v-model.trim="data.telParent
                                                        "
                          />
                          <span
                            class="text-danger"
                            v-if="!$v.data.telParent
                                                        .required &&
                                                        $v.data
                                                            .telParent
                                                            .$dirty
                                                        "
                          >
                            Le téléphone du parent
                            est requis
                          </span>
                        </div>
                      </div>

                      <br />
                    </div>

                    <br />
                    <br />

                    <div class="row">
                      <div class="col-md-6">
                        <Button
                          icon="ios-search"
                          type="primary"
                          @click="modal8 = true"
                          size="large"
                        >LA MAMAN</Button>
                      </div>
                    </div>

                    <br />

                    <div class="row">
                      <Divider>INFORMATION SUR LA MERE</Divider>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label>
                            Nom et prenoms :
                            <span class="danger">*</span>
                          </label>
                          <input
                            type="text"
                            class="form-control required"
                            v-model.trim="data.nomParent2
                                                        "
                          />
                          <span
                            class="text-danger"
                            v-if="!$v.data.nomParent2
                                                        .required &&
                                                        $v.data
                                                            .nomParent2
                                                            .$dirty
                                                        "
                          >
                            Le nom du parent est
                            requis
                          </span>
                        </div>
                      </div>

                      <!-- <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>
                                                        Prénom :
                                                        <span class="danger">*</span>
                                                    </label>
                                                    <input type="text" class="form-control required" v-model.trim="data.prenomParent2
                                                        " />
                                                    <span class="text-danger" v-if="!$v.data
                                                        .prenomParent2
                                                        .required &&
                                                        $v.data
                                                            .prenomParent2
                                                            .$dirty
                                                        ">
                                                        Le prénom du parent est
                                                        requis
                                                    </span>
                                                </div>
                      </div>-->

                      <!-- <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>
                                                        Téléphone :
                                                        <span class="danger">*</span>
                                                    </label>
                                                    <input type="number" class="form-control required" v-model.trim="data.telParent2
                                                        " />
                                                    <span class="text-danger" v-if="!$v.data.telParent2
                                                        .required &&
                                                        $v.data
                                                            .telParent2
                                                            .$dirty
                                                        ">
                                                        Le téléphone du parent
                                                        est requis
                                                    </span>
                                                </div>
                      </div>-->

                      <br />
                      <br />
                      <div class="col-md-12">
                        <input
                          type="submit"
                          class="btn btn-primary btn-block"
                          value="METTRE A JOUR LE PROFIL
 "
                        />
                      </div>
                    </div>
                  </section>
                </form>

                <Modal title="Changer parent 2 " v-model="modal8">
                  <Row>
                    <Col span="16">
                      <div class="form-group">
                        <input
                          type="text"
                          placeholder="Entrer le télephone du parent"
                          class="form-control required"
                          v-model.trim="data.telSeach2"
                        />
                      </div>
                    </Col>
                    <Col span="4" offset="1">
                      <div class="form-group">
                        <Button type="primary" icon="ios-search" @click="SearchParent2">Rechercher</Button>
                      </div>
                    </Col>
                  </Row>

                  <div slot="footer"></div>
                  <br />
                  <br />

                  <div class="table-responsive" v-if="parent2 != ''">
                    <table id="example" class="table table-bordered" style="width:100%">
                      <thead class="bg-primary">
                        <tr>
                          <th>Nom et prénoms</th>
                          <th>Téléphone</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td>
                            {{ parent2.nomParent }}
                            {{
                            parent2.prenomParent
                            }}
                          </td>
                          <td>{{ parent2.telParent }}</td>
                        </tr>
                      </tbody>
                    </table>

                    <Button
                      style="background-color:#2D8CF0;color:white"
                      icon="md-repeat"
                      @click="getParentSearch2"
                    >Association 2</Button>
                  </div>
                </Modal>

                <Modal title="Changer Parent 1 " v-model="modal7">
                  <Row>
                    <Col span="16">
                      <div class="form-group">
                        <input
                          type="text"
                          placeholder="Entrer le télephone du parent"
                          class="form-control required"
                          v-model.trim="data.telSeach"
                        />
                      </div>
                    </Col>
                    <Col span="4" offset="1">
                      <div class="form-group">
                        <Button type="primary" icon="ios-search" @click="SearchParent">Rechercher</Button>
                      </div>
                    </Col>
                  </Row>

                  <div slot="footer"></div>
                  <br />
                  <br />

                  <div class="table-responsive" v-if="parent != ''">
                    <table id="example" class="table table-bordered" style="width:100%">
                      <thead class="bg-primary">
                        <tr>
                          <th>Nom et prénoms</th>
                          <th>Téléphone</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td>
                            {{ parent.nomParent }}
                            {{
                            parent.prenomParent
                            }}
                          </td>
                          <td>{{ parent.telParent }}</td>
                        </tr>
                      </tbody>
                    </table>

                    <Button
                      style="background-color:#2D8CF0;color:white"
                      icon="md-repeat"
                      @click="getParentSearch"
                    >Association</Button>
                  </div>
                </Modal>
              </div>
              <!-- /.box-body -->
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
      UserData: [],
      modal7: false,
      modal8: false,
      data: {
        matricule: "",
        nom: "",
        classe: "",
        prenom: "",
        sexe: "",
        email: "",
        login: "",
        pass: "",
        Cpass: "",
        dateNaiss: "",
        lieuNaiss: "",
        imageLogo: "",
        natio: "",
        address: "",

        nomParent: "",
        prenomParent: "",
        professionParent: "",
        addressParent: "",
        telParent: "",
        nomParent2: "",
        prenomParent2: "",
        professionParent2: "",
        addressParent2: "",
        telParent2: "",

        emailParent: "",
        idParent: "",
        idParent2: "",
        telSeach: "",
        telSeach2: "",
        redoubl: "Non"
      },

      data2: {
        matricule: "",
        nom: "",
        classe: "",
        Prenom: "",
        sexe: "",
        email: "",
        login: "",
        pass: "",
        Cpass: "",
        dateNaiss: "",
        lieuNaiss: "",
        imageLogo: "",
        natio: "",
        address: "",
        nomParent: "",
        prenomParent: "",
        professionParent: "",
        addressParent: "",
        telParent: "",
        emailParent: "",
        idParent: "",
        telSeach: "",
        redoubl: "Non"
      },
      EtabInfos: "",
      EcoleInfos: "",
      visible: false,
      uploadList: [],
      parent: "",
      parent2: "",
      nouveauParent: false,
      trouverParent: false,
      cniParent: "",
      loginParent: "",
      passParent: "",
      classes: []
    };
  },

  validations: {
    data: {
      // matricule: {
      //     required
      // },
      classe: {
        required
      },
      nom: {
        required
      },
      prenom: {
        required
      },

      profession: {
        required
      },
      Cni: {
        required
      },
      sexe: {
        required
      },
      email: {
        email
      },
      dateNaiss: {
        required
      },
      lieuNaiss: {
        required
      },

      emailParent: {
        required,
        email
      },
      // login: {
      //     required,
      //     minLength: minLength(6)
      // },
      // pass: {
      //     required
      // },
      // Cpass: {
      //     required,
      //     sameAs: sameAs("pass")
      // },
      nomParent: {
        required
      },
      prenomParent: {
        required
      },
      professionParent: {
        required
      },
      sexeParent: {
        required
      },
      telParent: {
        required
      },

      nomParent2: {
        required
      },
      prenomParent2: {
        required
      },
      professionParent2: {
        required
      },
      sexeParent2: {
        required
      },
      telParent2: {
        required
      },
      loginParent: {
        required,
        minLength: minLength(6)
      },
      passParent: {
        required
      }
    }
  },

  async mounted() {
    // Recuperer toutes les infos de cette ecole dans le storage

    const res = await this.callApi(
      "post",
      "api/locale/getClasseEtablissementTest"
    );

    this.classes = res.data;

    if (!localStorage.users) {
      this.$router.push("login");
    }

    if (localStorage.parentEleveInfos) {
      this.parentEleveInfos = JSON.parse(
        localStorage.getItem("parentEleveInfos")
      );

      console.log("Je teste ", this.parentEleveInfos);

      this.data = this.parentEleveInfos;

      this.data.login = this.parentEleveInfos.user.login;

      this.data.redoubl = this.parentEleveInfos.doublant;

      this.data.classe = this.parentEleveInfos.classe_id;

      // Infos parent 1

      this.data.nomParent = this.parentEleveInfos.parent.nomParent;

      this.data.prenomParent = this.parentEleveInfos.parent.prenomParent;

      this.data.telParent = this.parentEleveInfos.parent.telParent;

      this.data.professionParent = this.parentEleveInfos.parent.professionParent;

      // Infos parent 2

      this.data.nomParent2 = this.parentEleveInfos.parent2.nomParent;

      this.data.prenomParent2 = this.parentEleveInfos.parent2.prenomParent;

      this.data.telParent2 = this.parentEleveInfos.parent2.telParent;

      this.data.professionParent2 = this.parentEleveInfos.parent2.professionParent;
    }

    if (localStorage.EtabInfos) {
      this.EtabInfos = JSON.parse(localStorage.getItem("EtabInfos"));
    }

    // Recuperer toutes les classes pour pouvoir inscrire

    // this.classes = this.classes.filter(item => item.eleves.length > 0)

    for (let value of this.classes) {
      if (value.id == this.parentEleveInfos.classe_id) {
        this.data.classe = value.id;
      }
    }

    // console.log(this.classes);
  },

  methods: {
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
      this.data.imageLogo = res;
      console.log(res);
    },

    handleError(res, file) {
      this.w("Séctionner un jpg, ou jpeg.Les png ne sont pas acceptés");
    },
    handleFormatError(file) {
      this.w("Sélectionner un jpg, ou jpeg. Les png ne sont pas acceptés");
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
    async onSubmit() {
      this.data.EcoleInfos = this.EtabInfos;
      this.$v.$touch();
      if (this.$v.$invalid) {
        const res = await this.callApi(
          "post",
          "api/locale/updateinscripEleve",
          this.data
        );

        if (res.status == 401) {
          this.w(" Ce login est déja utilisé par une autre personne");
        } else if (res.status == 500) {
          this.e("Erreure systeme interne ou addresse email  déja prise");
        } else if (res.status == 200) {
          this.s("Elève  modifié correctement");

          this.$router.push("listeEleve");
        }
      } else {
        console.log("Errorrrrr");
      }
    },

    async SearchParent() {
      if (this.data.telSeach == "") {
        this.e("Veillez saisir le  téléphone du parent.");
      } else {
        this.data.EcoleInfos = this.EtabInfos;
        this.data.check = 1;

        const res = await this.callApi(
          "post",
          "api/locale/SearchParent",
          this.data
        );

        if (res.data == "") {
          this.e("Aucun parent trouvé avec ce numéro");
        } else {
          this.parent = res.data[0];
          this.data.nomParent = this.parent.nomParent;
          this.data.prenomParent = this.parent.prenomParent;
          this.data.professionParent = this.parent.professionParent;
          this.data.sexeParent = this.parent.sexeParent;
          this.data.telParent = this.parent.telParent;
          this.data.addressParent = this.parent.addressParent;
          this.data.emailParent = this.parent.emailParent;
          this.data.cniParent = this.parent.cniParent;
          this.data.parent.id = this.parent.id;
        }
      }
    },

    getParentSearch2() {
      this.trouverParent2 = true;
      this.modal8 = false;
      this.s("liaison parent-enfant faite normalement");
      this.data.telSeach2 = "";
    },

    async SearchParent2() {
      if (this.data.telSeach2 == "") {
        this.e("Veillez saisir le  téléphone du parent.");
      } else {
        this.data.EcoleInfos = this.EtabInfos;
        this.data.check = 2;

        const res = await this.callApi(
          "post",
          "api/locale/SearchParent",
          this.data
        );

        if (res.data == "") {
          this.e("Aucun parent trouvé avec ce numéro");
        } else {
          this.parent2 = res.data[0];
          console.log(this.parent2);
          this.data.nomParent2 = this.parent2.nomParent;
          this.data.prenomParent2 = this.parent2.prenomParent;
          this.data.professionParent2 = this.parent2.professionParent;
          this.data.sexeParent2 = this.parent2.sexeParent;
          this.data.telParent2 = this.parent2.telParent;
          this.data.addressParent2 = this.parent2.addressParent;
          this.data.emailParent2 = this.parent2.emailParent;
          this.data.cniParent2 = this.parent2.cniParent;
          this.data.idParent2 = this.parent2.id;
        }
      }
    },
    ParentForm() {
      this.nouveauParent = true;
    },

    getParentSearch() {
      this.trouverParent = true;
      this.modal7 = false;
      this.s("liaison parent-enfant faite normalement");
      this.telSeach = "";
    },
    onChange: function(evenement, dat) {
      console.log(dat);
    }
  }
};
</script>

<style>
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
