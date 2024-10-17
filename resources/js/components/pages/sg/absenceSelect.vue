<template>

    <div>
          <div class="wrapper">
              <Header />
              <MenuSG />
              <div class="content-wrapper">
                  <div class="container-full">
                      <section class="content">
                          <!-- START Card With Image -->


                          <div class="row">

                              <div class="col-md-4">

                                  <router-link to="addAbsenceSg">

                                       <div class="card" style="background-color:#E67D21;color: white;">

                                          <!-- <Icon type="ios-person" style="margin-top: 50px;font-size: 50px;" /> -->

                                          <span  style="font-size: 40px; text-align: center;">➕</span>

                                           <div class="box-body py-25" style="text-align: center;">

                                                  <p class="font-weight-600"> Ajouter les absences   </p>
                                          </div>


                                      </div>


                                  </router-link>

                              </div>

                              <div class="col-md-4">

                                  <router-link to="absenceSeg2">

                                       <div class="card" style="background-color: #4983DA;color: white;">

                                          <!-- <Icon type="ios-person" style="margin-top: 50px;font-size: 50px;" /> -->

                                          <span  style="font-size: 40px; text-align: center;">🧑‍🤝‍🧑</span>

                                           <div class="box-body py-25" style="text-align: center;">

                                                  <p class="font-weight-600"> Absences par classe  </p>
                                          </div>


                                      </div>


                                  </router-link>

                              </div>

                              <div class="col-md-4">

                                <router-link to="recapAbsenceSg">

                                    <div class="card" style="background-color: #2C353D ;color: white;">

                                        <!-- <Icon type="ios-person" style="margin-top: 50px;font-size: 50px;" /> -->

                                        <span style="font-size:40px; text-align: center;">👨‍🏫</span>

                                        <div class="box-body py-25" style="text-align: center;">

                                                <p class="font-weight-600"> Absence individuelle  </p>
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
  import MenuSG from "../../navs/MenuSG.vue";
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
      components: { Header, MenuSG, Chats },
      data() {
          return {
              data: {

              },


          };
      },


      methods: {

      } ,


  };
  </script>

  <style>

  .content-wrapper{
      background-color: #FAFBFD
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
