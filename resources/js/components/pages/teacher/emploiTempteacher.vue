<template>
    <div>
        <div class="wrapper">
            <HeaderTeacher />
            <MenuTeacher />
            <div class="content-wrapper">
                <div class="container-full">
                    <section class="content">
                        <div class="row">
                            <div class="col-12">
                                <!-- <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title">
                                            EMPLOI DU TEMPS
                                            <p
                                                class="subtitle font-size-14 mb-0"
                                            >
                                                Emploi du temps de toutes les
                                                classes dans lesquelles vous avez des cours
                                            </p>
                                        </h4>
                                    </div>
                                </div> -->
                            </div>

                            <!--card deck!-->

                            <div class="col-lg-3" v-for="(data, i) in TimeTables" :key="i">
                                <div class="box">
                                    <div class="box-body ribbon-box">
                                        <div class="ribbon ribbon-primary">
                                            {{ data.libelleClasse }}
                                        </div>

                                        <p class="mb-0 ">
                                            <img height="100px" class="center center" :src="
                                                `/Photos/Logos/${data.emp_Classe}`
                                            " alt="" />
                                        </p>
                                    </div>
                                    <a :href="`/Photos/Logos/${data.emp_Classe}`">
                                        <Button type="primary" style="width:100%"><i class="ti-import"></i>
                                            Télécharger</Button>
                                    </a>

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
import MenuTeacher from "../../navs/MenuTeacher.vue";
import Chats from "../../navs/Chats.vue";
import { mapState } from "vuex";
import HeaderTeacher from "../../headers/HeaderTeacher.vue";

export default {
    components: { MenuTeacher, Chats, HeaderTeacher },
    data() {
        return {
            TimeTables: [],
            teacherData: []
        };
    },

    async mounted() {

        if (localStorage.users) {

            this.teacherData = JSON.parse(localStorage.getItem("users"));

            const response2 = await this.callApi(
                "post",
                "api/locale/getAllTimetableTeacher", this.teacherData

            );

            this.TimeTables = response2.data;


        }


    },

    methods: {}
};
</script>
