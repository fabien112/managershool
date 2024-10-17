<template>
  <div>
    <div class="wrapper">
      <Header />
      <MenuLocal />
      <div class="content-wrapper">
        <div class="container-full">
          <section class="content">
            <div class="row">
              <div class="col-md-12 col-lg-3">
                <router-link to="addNoteLocal">
                  <div class="card" style="background-color: #155A75;color: white;">
                    <span style="margin-top: 40px;font-size: 50px; text-align:center;">➕</span>
                    <!-- <Icon type="ios-browsers" style="margin-top: 50px;font-size: 50px;" /> -->

                    <div class="box-body py-25" style="text-align: center;">
                      <p class="font-weight-600">Ajouter les notes</p>
                    </div>
                  </div>
                </router-link>
              </div>

              <div class="col-md-12 col-lg-3">
                <router-link to="notes">
                  <div class="card" style="background-color: #155A75;color: white;">
                    <!-- <Icon type="ios-browsers" style="margin-top: 50px;font-size: 50px;" /> -->

                    <span style="margin-top: 40px;font-size: 50px; text-align:center;">📚</span>

                    <div class="box-body py-25" style="text-align: center;">
                      <p class="font-weight-600">Bilan des notes par matière</p>
                    </div>
                  </div>
                </router-link>
              </div>

              <div class="col-md-12 col-lg-3">
                <router-link to="BulletinEleve">
                  <div class="card" style="background-color: #08222f;color: white;">
                    <!-- <Icon type="ios-folder" style="margin-top: 50px;font-size: 50px;" /> -->

                    <span style="margin-top: 40px;font-size: 50px; text-align:center;">🕮</span>

                    <div class="box-body py-25" style="text-align: center;">
                      <p class="font-weight-600">Bilan des notes globale</p>
                    </div>
                  </div>
                </router-link>
              </div>

              <div class="col-md-12 col-lg-3">
                <router-link to="BulletinsEvaluation">
                  <div class="card" style="background-color: red;color: white;">
                    <!-- <Icon type="ios-bookmarks" style="margin-top: 50px;font-size: 50px;" /> -->

                    <span style="margin-top: 40px;font-size: 50px; text-align:center;">📒</span>

                    <div class="box-body py-25" style="text-align: center;">
                      <p class="font-weight-600">Bulletins Evaluations</p>
                    </div>
                  </div>
                </router-link>
              </div>

              <div class="col-md-12 col-lg-3">
                <router-link to="BulletinsTrimestre">
                  <div class="card" style="background-color: #33993e;color: white;">
                    <!-- <Icon type="logo-buffer" style="margin-top: 50px;font-size: 50px;" /> -->
                    <span style="margin-top: 40px;font-size: 50px; text-align:center;">📓</span>
                    <div class="box-body py-25" style="text-align: center;">
                      <p class="font-weight-600">Bulletins Trimestres</p>
                    </div>
                  </div>
                </router-link>
              </div>

              <div class="col-md-12 col-lg-3">
                <router-link to="bulletinAnnuelle">
                  <div class="card" style="background-color: #2196F3;color: white;">
                    <!-- <Icon type="ios-briefcase" style="margin-top: 50px;font-size: 50px;" /> -->

                    <span style="margin-top: 40px;font-size: 50px; text-align:center;">📚</span>

                    <div class="box-body py-25" style="text-align: center;">
                      <p class="font-weight-600">Bulletins annuelles</p>
                    </div>
                  </div>
                </router-link>
              </div>

              <div class="col-md-12 col-lg-3">
                <router-link to="ChangeClasse">
                  <div class="card" style="background-color: #155A75;color: white;">
                    <span style="margin-top: 40px;font-size: 50px; text-align:center;">
                      <Icon type="md-git-compare" />
                    </span>
                    <!-- <Icon type="ios-browsers" style="margin-top: 50px;font-size: 50px;" /> -->

                    <div class="box-body py-25" style="text-align: center;">
                      <p class="font-weight-600">Classes Global Changes</p>
                    </div>
                  </div>
                </router-link>
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
    return {};
  },

  async mounted() {
    if (!localStorage.users) {
      this.$router.push("login");
    }
  },

  methods: {}
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
