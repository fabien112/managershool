<template>
    <div>
        <div class="wrapper">
            <Header />
            <Menu />

            <div class="content-wrapper">
                <div class="container-full">
                    <!-- Main content -->
                    <section class="content">
                        <div class="row">
                            <div class="col-12">
                                <!-- /.box -->

                                <div class="box">
                                    <div class="box-header with-border">
                                        <h3 class="box-title">

                                            Liste des écoles

                                                     <router-link to="addetablissement">

                                                        <button
                                                           type="button"  class="waves-effect btn btn-outline btn-info mb-5"

                                                        >

                                                           <Icon type="md-add" />

                                                            Nouveau

                                                        </button>


                                                     </router-link>

                                        </h3>


                                        <!-- <h6 class="box-subtitle">
                                            Export data to Copy, CSV, Excel, PDF
                                            & Print
                                        </h6> -->
                                    </div>

                                        <Modal v-model="showDelateModal" width="360">
                                                <p slot="header" style="color:#f60;text-align:center">
                                                    <Icon type="ios-information-circle"></Icon>
                                                    <span> Suppression ! </span>
                                                </p>
                                                <div style="text-align:center">
                                                    <p> Etes vous sure de voulor supprimer ?  </p>

                                                </div>
                                                <div slot="footer">
                                                    <Button type="error" size="large" long  @click="delateSchool">Confirmer</Button>
                                                </div>
                                        </Modal>

                                    <!-- /.box-header -->
                                    <div class="box-body">

                                        <div class="table-responsive">
                                            <table
                                                id="example"
                                                class="table table-bordered table-striped"
                                                style="width:100%"
                                            >
                                                <thead>
                                                    <tr>
                                                        <th>Nom</th>
                                                        <th>Logo</th>
                                                         <th>Pays</th>
                                                        <th>Ville</th>
                                                        <th>Adresse</th>
                                                        <th>Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody name="fruit-table" is="transition-group">
                                                    <tr
                                                        v-for="(data,
                                                        i) in datas"
                                                        :key="i"
                                                    >


                                                       <td>
                                                            {{ data.libelleEtab }}
                                                        </td>
                                                          <td>

                                                              <div class="text-center">

                                                                   <img
                                                                   style="width:50px"
                                                                   :src=" `/Photos/Logos/${data.logoEtab}` "
                                                                   />


                                                              </div>




                                                        </td>

                                                        <td>
                                                            {{ data.paysEtab }}
                                                        </td>
                                                        <td>
                                                            {{ data.villeEtab }}
                                                        </td>

                                                        <td>
                                                            {{
                                                                data.adresseEtab
                                                            }}
                                                        </td>

                                                        <td>
                                                            <button
                                                                type="button"
                                                                @click="
                                                                    updataSchool(
                                                                        data,
                                                                        i
                                                                    )
                                                                "
                                                                class="waves-effect waves-light btn btn-outline btn-info mb-5"
                                                            >
                                                                Modifier
                                                            </button>

                                                            <button
                                                                type="button"
                                                                @click="
                                                                   showDelatingModal(data,i)
                                                                "
                                                                class="waves-effect waves-light btn btn-outline btn-danger mb-5"
                                                            >
                                                                Supprimer
                                                            </button>
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
                        <!-- /.row -->
                    </section>
                    <!-- /.content -->
                </div>
            </div>

        </div>
        <Chats />
    </div>
</template>

<script>
import Header from "../../headers/Header.vue";
import Menu from "../../navs/Menu.vue";
import Chats from "../../navs/Chats.vue";
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
    components: { Header, Menu, Chats },
    data() {
        return {
            UserData: [],
            BtnDisabled: "",
            Modal: false,
            datas: [],
            datasEdits: [],
            visible: false,
            showDelateModal: false,
            delateItem:{},
            i:-1,
            visible:false
        };
    },

    validations: {
        data: {
            codeEtablissement: {
                required
            },
            libelleEtablissement: {
                required
            },
            dateCreation: {
                required
            },
            sigleEtablissement: {
                required
            },

            typeEtablissement: {
                required
            },

            emailEtablissement: {
                required,
                email
            },
            telephoneEtablissement: {
                required,
                maxLength: maxLength(9)
            },
            telephoneEtablissementSecond: {
                required,
                maxLength: maxLength(9)
            },
            paysEtablissement: {
                required
            },
            villeEtablissement: {
                required
            },
            siteInternetEtablissement: {
                required
            },
            sloganEtablissement: {
                required
            },
            addressEtablissement: {
                required
            },
            directeurEtablissement: {
                required
            },
            telephoneDirecteurEtablissement: {
                required,
                maxLength: maxLength(9)
            },
            nomAdmin: {
                required
            },
            PrenomAdmin: {
                required
            },
            fonctionAdmin: {
                required
            },
            emailAdmin: {
                required,
                email
            },
            telAdmin: {
                required,
                maxLength: maxLength(9)
            },
            loginAdmin: {
                required,
                minLength: minLength(6)
            },
            passAdmin: {
                required
            },
            CpassAdmin: {
                required,
                sameAs: sameAs("passAdmin")
            }
        }
    },

    async mounted() {
        console.log("Component mounted.");
        if (localStorage.getItem("UserData")) {
            let thedata = JSON.parse(localStorage.getItem("UserData"));
            // console.log(thedata.data.data);
            this.UserData = thedata.data.data;
            // let data=JSON.parse(thedata);
            // console.log(data);
        }
    },


    mounted(){

      console.log('App Mounted');

        if (localStorage.getItem('UserData'))

            this.UserData = JSON.parse(localStorage.getItem('UserData'));

            console.log(this.UserData);
    },
    methods: {


       async  delateSchool() {

            const response = await axios.post("api/admin/delateEtablissement", this.delateItem)
            if(response.status===200){
            console.log(this.delateItem);
                 this.datas.splice(this.i,1)
                 this.showDelateModal = false
                this.$Notice.success({
                             title: "Felecitations",
                            desc: "Etablissement supprime correctement  ."
                             })
            }
            // this.modal2 = false;
        },

        updataSchool(data, i) {

            // Envoyer lecole sur laquelle on a clique dans la store
            this.$store.commit("muttation", data);
            // aller a la page edit
            this.$router.push("/editEtablissment");
        },

        showDelatingModal(data, i) {

            this.delateItem = data
            this.i = i
            this.showDelateModal=true
        }
    },

    async created() {

        await axios
            .get("api/admin/getAllEtablissement")
            .then(response => {

                this.datas = response.data;

                console.log(this.datas);
            })
            .catch(error => console.log(error));
    },

};
</script>

<style>

.fruit-table-move {
  transition: transform 1s;
}

.fade-enter-active, .fade-leave-active {
  transition: opacity 2s, transform 1s,
}
.fade-enter, .fade-leave-active  {
  opacity: 0;
  transform: translate(20px);
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
