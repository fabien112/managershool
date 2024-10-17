<template>
    <div>
        <div class="wrapper">
            <Header />
            <MenuLocal />
            <div class="content-wrapper">
                <div class="container-full">
                    <section class="content">

                        <!-- <div class="row">
                            <div class="col-xl-4 col-12" v-for="(data, i) in ClassesTeacher" :key="i">
                                <div class="box">
                                    <div class="box-header bg-primary " style="text-align: center;">
                                        <h4 class="box-title">
                                            <strong>
                                                {{ data.classe.libelleClasse }}
                                            </strong>
                                        </h4>
                                    </div>

                                    <div class="box-footer">
                                        <p class="text-center"> {{ data.libelle }} </p>
                                    </div>
                                </div>
                            </div>
                        </div> -->
                        <div class="row">
                            <div class="col-12 ">
                                <div class="box">
                                    <div class="box-header bg-primary">
                                        <h4 class="text-center">{{ Teacherdata2.nom }} {{ Teacherdata2.prenom }}</h4>
                                    </div>

                                    <div class="box-body">
                                        <div class="table-responsive">
                                            <table class="table product-overview">
                                                <thead>
                                                    <tr>


                                                        <th> Lundi </th>
                                                        <th> Mardi </th>
                                                        <th> Mercredi  </th>
                                                        <th> Jeudi </th>
                                                        <th> Vendredi </th>
                                                    </tr>
                                                </thead>
                                                <tbody>


                                                    <td v-for="(data,
                                                    i) in classeListe" :key="i">



                                                        <tr v-for="(dat,
                                                    i) in data" :key="i"> <br>

                                                            <!-- <Button type="primary" shape="circle">{{ dat.id_heureD }} - {{ dat.id_heureF }}</Button> -->

                                                                <p class="btn btn-primary btn-xs text-center" style=" border-radius: 4px;"> ⏰ :  {{ dat.id_heureD }} - {{ dat.id_heureF }} </p>

                                                                <br>   <br>



                                                        <p style="font-size:9px;font-weight: bold;" v-if="dat.matiere.libelle!=''">

                                                             {{ dat.matiere.libelle.substr(0, 25) }} <span v-if="dat.matiere.libelle.length > 25">...</span>

                                                        </p >


                                                        <p style="font-size:9px;font-weight: bold;"> ( {{ dat.classe.libelleClasse }} ) </p>





                                                       </tr>






                                                    </td>


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
            Teacherdata: "",
            Teacherdata2: "",
            classeListe: []
        };
    },

    async mounted() {
        // Recuperer les donnes de cet utulisateurs dans la storage local

        if (!localStorage.users) {

            this.$router.push('login');
        }

        if (localStorage.users) {
            this.Teacherdata2 = JSON.parse(localStorage.getItem("users"));


        }

        if (localStorage.InfosTeacher) {
            this.Teacherdata = JSON.parse(localStorage.getItem("InfosTeacher"));


        }

        // Allons chercher la session et le code etablissement ce cet enseigant

        const response = await this.callApi(
            "post",
            "api/locale/getAllasseTeacherBylocale2",
            this.Teacherdata
        );

        this.classeListe = response.data;


    }
};
</script>
