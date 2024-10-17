<template>

    <div>
        <div class="wrapper">
            <Header />
            <MenuParent />
            <div class="content-wrapper">
                <div class="container-full">
                    <section class="content">

                        <!-- <Alert type="light" closable class="card">

                            <div class="card-header">
                                <h4 class="card-title"> Absence
                                    <p class="subtitle font-size-14 mb-0">
                                        Toutes vos absences en details
                                    </p>
                                </h4>

                            </div>
                        </Alert> -->


                        <br>

                        <div class="row">

                            <div class="col-12">
                                <!-- /.box -->

                                <div class="box">
                                    <div class="box-header bg-primary">
                                        <h4 class="box-title" style="margin:auto">
                                            {{ datasEnfant.nom }} {{ datasEnfant.prenom }} totalise

                                            <span style="font-size: 20px;"> {{ TotalHeure }}</span> heure(s) d'absence


                                        </h4>
                                    </div>


                                    <div class="box-body">
                                        <div class="table-responsive">
                                            <table id="example" class="table simple mb-0" style="width:100%">
                                                <thead>
                                                    <tr>
                                                        <th> Jours </th>
                                                        <th> Heures</th>
                                                        <th> Matieres</th>
                                                        <th> Durée du cour </th>
                                                    </tr>
                                                </thead>
                                                <tbody name="fruit-table" is="transition-group">
                                                    <tr v-for="(data,
                                                    i) in ElevesAbsences" :key="i">
                                                        <td>
                                                            {{
                                                                    data.dateHeure | dateFormat
                                                            }}
                                                        </td>

                                                        <td>
                                                            {{
                                                                    data.heure
                                                            }}
                                                        </td>

                                                        <td>
                                                            {{
                                                                    data.matiere
                                                            }}
                                                        </td>

                                                        <td>
                                                            {{
                                                                    data.duree
                                                            }} heure(s)
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



                    </section>

                </div>
            </div>
        </div>
        <Chats />
    </div>

</template>

<script>
import Header from "../../headers/Header.vue";
import MenuParent from "../../navs/MenuParent.vue";
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
    components: { Header, MenuParent, Chats },
    data() {
        return {

            data: {


            }
            ,
            ElevesAbsences: "",

            TotalHeure: 0,

            datasEnfant: ''


        };
    },


    async mounted() {



        if (localStorage.datasEnfant) {
            this.datasEnfant = JSON.parse(localStorage.getItem("datasEnfant"));
        }


        const response4 = await this.callApi(

            "post",
            "api/locale/getAbensesOfEleveclasseByParent",
            this.datasEnfant)

        this.ElevesAbsences = response4.data

        for (let i = 0; i < this.ElevesAbsences.length; i++) {


            this.TotalHeure = this.TotalHeure + parseInt(this.ElevesAbsences[i].duree)

        }


    },

    methods: {


    },


};
</script>

<style>
.content-wrapper {
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
