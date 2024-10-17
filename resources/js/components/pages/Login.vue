<template>
  <div class="auth-wrapper">
    <div class="container auth-content">
      <!-- <form> -->
      <div class="card">
        <div class="row align-items-center">
          <div class="col-md-6 d-none d-md-block">
            <img height="640px" src="assets/images/auth/auth3.jpeg" alt class />
          </div>
          <div class="col-md-6">
            <div class="card-body">
              <!-- <img
                                src="assets/images/logo-dark.svg"
                                alt=""
                                class="img-fluid mb-4"
                                id="logoimg"
              />-->
              <!-- <h4 class="mb-3 f-w-400">
                                Connexion à votre compte
              </h4>-->

              <div class="form-group mb-2">
                <label class="form-label">Login</label>
                <input
                  type="text"
                  id="login"
                  name="login"
                  v-model="values.login"
                  class="form-control"
                  placeholder="Entrer le login"
                />
                <!-- <p  class="form-input-hint" v-if="!!errors.login">
                            {{ errors.login }}
                </p>-->
              </div>
              <div class="form-group mb-3">
                <label class="form-label">Mot de passe</label>
                <input
                  type="password"
                  id="motdepasse"
                  name="motdepasse"
                  v-model="values.password"
                  class="form-control"
                  placeholder="Entrer le mot de passe"
                />
              </div>

              <!-- <div class="form-group text-left mt-2">
                                <div class="checkbox checkbox-primary d-inline">
                                    <input type="checkbox" name="checkbox-fill-1" id="checkbox-fill-a1" checked="" />
                                    <label for="checkbox-fill-a1" class="cr">Rester connecter</label>
                                </div>
              </div>-->

              <button class="btn btn-primary mb-4" @click="onSubmit">
                <Icon type="md-log-in" />Se connecter
              </button>

              <!-- <p class="mb-2 text-muted">
                                Mot de passe oublié ?
                                <a href="#" class="f-w-400">Réinitialiser</a>
                            </p>
                            <p class="mb-0 text-muted">
                                Vous êtes dejà inscrit ?
                                <a href="#" class="f-w-400">Se connecter</a>
              </p>-->
            </div>
          </div>
        </div>
      </div>
      <!-- </form> -->
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      values: {
        login: "",
        password: ""
      },

      IsloggIn: false
    };
  },
  methods: {
    async onSubmit() {
      if (this.values.login.trim() == "")
        return this.w("Veillez saisir un identifiant");

      if (this.values.password.trim() == "")
        return this.w("Veillez saisir un mot de passe");
      const response = await this.callApi("post", "/api/login", this.values);

      //console.log(response.data.userDatas.nom)

      if (response.status === 200) {
        // Enregistrer les donnees du user dans le local storage

        localStorage.setItem("users", JSON.stringify(response.data.userDatas));

        let typecompte = response.data.userDatas.type;

        if (typecompte === "Administrateur") {
          console.log(typecompte);
          this.$router.push("dashboard");
        }

        if (typecompte === "Admin_locale") {
          console.log(typecompte);
          this.$router.push("DashboardLocal");
        }

        if (typecompte === "Enseignant") {
          if (response.data.userDatas.state == 0) {
            return this.e(
              " Vos parametres de connexion sont correts mais votre compte est restraint , Contacter L'administrateur"
            );
          } else {
            console.log(response.data.userDatas);

            this.$router.push("DashTeacher");
          }
        }

        if (typecompte === "Comptable") {
          console.log(typecompte);
          this.$router.push("dashboardCaisse");
        }

        if (typecompte === "SG") {
          console.log(typecompte);
          this.$router.push("dashboardsg");
        }

        if (typecompte === "Parent") {
          console.log(typecompte);

          this.$router.push("DashParent");
        }

        if (typecompte === "Eleve") {
          console.log(typecompte);
          this.$router.push("EleveDash");
        }

        //this.s(response.data.msg)
        this.IsloggIn = true;
      }

      if (response.status === 401) {
        this.e(response.data.msg);
      }
    }
  },
  mounted() {
    // console.log('Component mounted.')
  }
};
</script>
