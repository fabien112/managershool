<template>
    <div>
        <div class="wrapper">
            <HeaderTeacher />
            <MenuTeacher />
            <div class="content-wrapper">
                <div class="container-full">
                    <section class="content">
                        <div class="row align-items-end">
                            <div class="col-xl-12 col-12">
                                <div class="box bg-primary-light pull-up">
                                    <div class="box-body p-xl-0">
                                        <div class="row align-items-center">
                                            <div class="col-12 col-lg-3">
                                                <img src="images/cap3.png" alt="" />
                                            </div>

                                            <div class="col-12 col-lg-9">
                                                <h4>ENSEIGNANT(E)</h4>

                                                <p class="text-dark mb-0 font-size-13">
                                                    Bienvenu,
                                                    {{ this.users.nom }}
                                                    {{ this.users.prenom }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">


                            <div class="col-xl-4 col-12" v-for="(data,i) in InfosTeacher" :key="i">
                                <div class="box box-slided-up">
                                    <div class="box-header with-border" style="text-align: center">
                                        <h4 class="box-title"> <strong> {{data.classe.libelleClasse}} </strong></h4>
                                        <ul class="box-controls pull-right">
                                            <li><a class="box-btn-close" href="#"></a></li>
                                            <li><a class="box-btn-slide rotate-180" href="#"></a></li>
                                            <li><a class="box-btn-fullscreen" href="#"></a></li>
                                        </ul>
                                    </div>

                                    <div class="box-body" style="display: block;text-align: center">

                                        <div class="box-body" style="display: block;">
                                            <div class="dropdown">

                                                <button @click="SaveID(data,i)"
                                                    class="btn btn-rounded btn-primary dropdown-toggle" type="button"
                                                    data-toggle="dropdown" aria-expanded="false"><i
                                                        class="icon ti-menu"></i>
                                                    Détails </button>
                                                <div class="dropdown-menu dropdown-menu dropdown-menu-left" style="">
                                                    <router-link class="dropdown-item" to="listeEleveTeacher"> Liste des
                                                        éleves </router-link>
                                                    <router-link class="dropdown-item" to="emploiTempTeacherForAclass">
                                                        Emploi du temps </router-link>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="callout callout-primary mb-0" role="alert">
                                            {{data.libelle}}
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- <div class="col-xl-4 col-12"

                                v-for="(data,i) in InfosTeacher"  :key="i"

                            >
                                <div class="box box-solid box-inverse box-info">
                                    <div class="box-header with-border" style="text-align: center;background-color: #276eac;">
                                        <h4 class="box-title">
                                            <strong>{{data.classe.libelleClasse}}</strong>
                                        </h4>

                                            <ul class="box-controls pull-right">
                                                    <li class="dropdown">
                                                        <a data-toggle="dropdown" href="#" aria-expanded="false"><i class="ti-more-alt rotate-90"></i></a>
                                                        <div class="dropdown-menu dropdown-menu-right" style="">
                                                        <a class="dropdown-item" href="#"><i class="ti-import"></i> Liste de la classe </a>
                                                         <div class="dropdown-divider"></div>
                                                        <a class="dropdown-item" href="#"><i class="ti-export"></i> Emploi du temps </a>
                                                        <a class="dropdown-item" href="#"></a>

                                                        </div>
                                                    </li>
					                        </ul>

                                    </div>
                                    <div class="box-body" style="text-align:center" >
                                        <label>{{data.libelle}}</label>
                                        <div class="dropdown-divider"></div>
                                        <p> Cliquez sur les trois points pour voir la lsite de la classe et l'emploi du temps</p>
                                    </div>
                                </div>
                            </div> -->

                            <!-- <div class="col-xl-3 col-md-6 col-12">
					<div class="box bg-secondary-light pull-up" style="background-image: url(https://www.multipurposethemes.com/admin/eduadmin-template/images/svg-icon/color-svg/st-4.svg); background-position: right bottom; background-repeat: no-repeat;">
						<div class="box-body">
							<div class="flex-grow-1">
								<div class="d-flex align-items-center pr-2 justify-content-between">
									<div class="d-flex">
										<span class="badge badge-warning-light mr-15">Paused</span>
										<span class="badge badge-warning-light mr-5"><i class="fa fa-lock"></i></span>
									</div>
									<div class="dropdown">
										<a data-toggle="dropdown" href="#" class="px-10 pt-5"><i class="ti-more-alt"></i></a>
										<div class="dropdown-menu dropdown-menu-right">
										  <a class="dropdown-item" href="#"><i class="ti-import"></i> Import</a>
										  <a class="dropdown-item" href="#"><i class="ti-export"></i> Export</a>
										  <a class="dropdown-item" href="#"><i class="ti-printer"></i> Print</a>
										  <div class="dropdown-divider"></div>
										  <a class="dropdown-item" href="#"><i class="ti-settings"></i> Settings</a>
										</div>
									</div>
								</div>
								<h4 class="mt-25 mb-5">Network Security</h4>
								<p class="text-fade mb-0 font-size-12">21 Days Left</p>
							</div>
						</div>
					</div>
				</div> -->
                        </div>

                        <!-- <div class="row">
                            <div class="col-xl-4 col-12">
                                <div class="box">
                                    <div class="box-body">
                                        <p class="text-fade">fff</p>
                                        <h3 class="mt-0 mb-20">
                                            test<small class="text-success"
                                                ><i
                                                    class="fa fa-arrow-up ml-15 mr-5"
                                                ></i>
                                                2 New</small
                                            >
                                        </h3>
                                        <div id="charts_widget_2_chart"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-5 col-12">
                                <div class="box">
                                    <div class="box-body">
                                        <p class="text-fade">Hours spent</p>
                                        <h3 class="mt-0 mb-20">
                                            21 h 30 min
                                            <small class="text-danger"
                                                ><i
                                                    class="fa fa-arrow-down ml-25 mr-5"
                                                ></i>
                                                15%</small
                                            >
                                        </h3>
                                        <div id="charts_widget_1_chart"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-12">
                                <div class="box">
                                    <div class="box-header with-border">
                                        <h4 class="box-title">Working Hours</h4>
                                        <ul
                                            class="box-controls pull-right d-md-flex d-none"
                                        >
                                            <li class="dropdown">
                                                <button
                                                    class="dropdown-toggle btn btn-warning-light px-10"
                                                    data-toggle="dropdown"
                                                    href="#"
                                                >
                                                    Today
                                                </button>
                                                <div
                                                    class="dropdown-menu dropdown-menu-right"
                                                >
                                                    <a
                                                        class="dropdown-item active"
                                                        href="#"
                                                        >Today</a
                                                    >
                                                    <a
                                                        class="dropdown-item"
                                                        href="#"
                                                        >Yesterday</a
                                                    >
                                                    <a
                                                        class="dropdown-item"
                                                        href="#"
                                                        >Last week</a
                                                    >
                                                    <a
                                                        class="dropdown-item"
                                                        href="#"
                                                        >Last month</a
                                                    >
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="box-body">
                                        <div id="revenue5"></div>
                                        <div
                                            class="d-flex justify-content-center"
                                        >
                                            <p
                                                class="d-flex align-items-center font-weight-600 mx-20"
                                            >
                                                <span
                                                    class="badge badge-xl badge-dot badge-warning mr-20"
                                                ></span>
                                                Progress
                                            </p>
                                            <p
                                                class="d-flex align-items-center font-weight-600 mx-20"
                                            >
                                                <span
                                                    class="badge badge-xl badge-dot badge-primary mr-20"
                                                ></span>
                                                Done
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> -->
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
import HeaderTeacher from "../../headers/HeaderTeacher.vue";

export default {
    components: {  MenuTeacher, Chats, HeaderTeacher },
    data() {
        return {
            IdClasseTeacher: [],
            InfosTeacher:[],
            users: []
        };
    },

    async mounted() {
        // Recuperer les donnes de cet utulisateurs dans la storage local

        if (localStorage.users) {
            this.users = JSON.parse(localStorage.getItem("users"));

            console.log(this.users.nom);
        }

        // Allons chercher la session et le code etablissement ce cet enseigant

        const response = await this.callApi(
            "post",
            "api/locale/getInfosTeacher",
            this.users
        );

        this.InfosTeacher = response.data;

        // Garder les donnees de l'enseigant  dans le storage de navigateur

        localStorage.setItem("InfosTeacher", JSON.stringify(this.InfosTeacher));
    },

    methods: {

                SaveID(data,i) {


                    localStorage.setItem('IdClasseTeacher', JSON.stringify(data));

                    console.log(data);
                }

    },
};
</script>
