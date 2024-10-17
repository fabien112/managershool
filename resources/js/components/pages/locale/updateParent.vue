<template>
    <div>
        <div class="wrapper">
            <Header />
            <MenuLocal />
            <div class="content-wrapper">
                <div class="container-full">
                    <section class="content">
                        <div class="box box-default">
                            <div class="box-header" style="background-color:#0052CC;text-align: center; color:white">

                                <h4 class="box-title">
                                    Modifier  un parent
                                </h4>
                            </div>
                            <!-- /.box-header -->
                            <div class="box-body wizard-content">
                                <form action="#" class="" @submit.prevent="onSubmit">
                                    <!-- Step 1 -->


                                    <section>
                                        <div></div>
                                        <Upload multiple type="drag" action="api/admin/upload"
                                            :on-success="handleSuccess" :on-error="handleError"
                                            :format="['jpg', 'jpeg', 'png']" :max-size="2048"
                                            :on-format-error="handleFormatError" :on-exceeded-size="handleMaxSize"
                                            :headers="{
                                                'X-Requested-With':
                                                    'XMLHttpRequest'
                                            }">
                                            <div style="padding: 20px 0">
                                                <Icon type="ios-cloud-upload" size="52" style="color: #3399ff"></Icon>
                                                <p class="text-center">
                                                    Cliquer ou glisser deposer
                                                    pour inserer la photo
                                                </p>
                                            </div>
                                        </Upload>
                                        <Modal title="Image" v-model="visible">
                                            <img :src="
                                                `/Photos/Logos/${data.imageLogo}`
                                            " v-if="visible" style="width: 100%" />
                                            <div slot="footer">
                                                <Button type="primary" @click="visible = false">Close</Button>
                                            </div>
                                        </Modal>
                                        <div class="demo-upload-list" v-if="data.imageLogo">
                                            <img :src="
                                                `/Photos/Logos/${data.imageLogo}`
                                            " />
                                            <div class="demo-upload-list-cover">
                                                <Icon type="ios-eye-outline" @click.native="
                                                    handleView(
                                                        data.imageLogo
                                                    )
                                                "></Icon>
                                                <Icon type="ios-trash-outline" @click.native="
                                                    handleRemove(
                                                        data.imageLogo
                                                    )
                                                "></Icon>
                                            </div>
                                        </div>

                                        <br />
                                    </section>

                                    <!-- Step 2 -->


                                    <section>

                                        <div> </div>



                                        <div class="row">


                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>
                                                        Nom :
                                                        <span class="danger">*</span>
                                                    </label>
                                                    <input type="text" class="form-control required" v-model.trim="
                                                        data.nomAdmin
                                                    " />
                                                    <span class="text-danger" v-if="
                                                        !$v.data.nomAdmin
                                                            .required &&
                                                        $v.data.nomAdmin
                                                            .$dirty
                                                    ">
                                                        Le nom du parent
                                                        est
                                                        requis
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>
                                                        Prénom :
                                                        <span class="danger">*</span>
                                                    </label>
                                                    <input type="text" class="form-control required" v-model.trim="
                                                        data.PrenomAdmin
                                                    " />
                                                    <span class="text-danger" v-if="
                                                        !$v.data.PrenomAdmin
                                                            .required &&
                                                        $v.data
                                                            .PrenomAdmin
                                                            .$dirty
                                                    ">
                                                        Le prénom du parent
                                                        est
                                                        requis
                                                    </span>
                                                </div>
                                            </div>
                                            <!-- <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="wemailAddress2">
                                                        Addresse email :
                                                        <span class="danger"
                                                            >*</span
                                                        >
                                                    </label>
                                                    <input
                                                        type="email"
                                                        class="form-control required"
                                                        v-model="
                                                            data.emailAdmin
                                                        "
                                                    />
                                                    <span
                                                        class="text-danger mt-2"
                                                        v-if="
                                                            (!$v.data.emailAdmin
                                                                .required ||
                                                                !$v.data
                                                                    .emailAdmin
                                                                    .email) &&
                                                                $v.data
                                                                    .emailAdmin
                                                                    .$dirty
                                                        "
                                                    >
                                                        L'addresse email est
                                                        invalide
                                                    </span>
                                                </div>
                                            </div> -->

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="wphoneNumber2">Téléphone
                                                        :</label>
                                                    <span class="danger">*</span>
                                                    <input type="number" class="form-control" maxlength="9"
                                                        v-model="data.telAdmin" />

                                                    <span class="text-danger" v-if="
                                                        !$v.data.telAdmin
                                                            .required &&
                                                        $v.data.telAdmin
                                                            .$dirty
                                                    ">
                                                        Le numéro de téléphone
                                                        du parent
                                                        est
                                                        requis
                                                    </span>

                                                    <span class="text-danger" v-if="
                                                        !$v.data.telAdmin
                                                            .maxLength
                                                    ">
                                                        Le numéro de téléphone
                                                        est incorrect
                                                    </span>
                                                </div>
                                            </div>

                                            <!-- <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="wlocation2">
                                                        Sexe :
                                                        <span class="danger"
                                                            >*</span
                                                        >
                                                    </label>
                                                    <select
                                                        class="custom-select form-control required"
                                                        v-model="
                                                            data.sexe
                                                        "
                                                    >
                                                        <option value=""
                                                            > Selectioner son sexe

                                                        </option>
                                                        <option value="M"
                                                            >Masculin</option
                                                        >
                                                        <option value="F"
                                                            >Feminin</option
                                                        >

                                                    </select>
                                                    <span
                                                        class="text-danger"
                                                        v-if="
                                                            !$v.data
                                                                .sexe
                                                                .required &&
                                                                $v.data
                                                                    .sexe
                                                                    .$dirty
                                                        "
                                                    >
                                                        La sexe est requis
                                                    </span>
                                                </div>
                                            </div> -->

                                            <!-- <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>
                                                        CNI :


                                                    </label>
                                                    <input
                                                        type="text"
                                                        class="form-control required"
                                                        v-model.trim="
                                                            data.cni
                                                        "
                                                    />

                                                </div>
                                            </div> -->

                                            <!-- <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>
                                                        Nationalite :


                                                    </label>
                                                    <input
                                                        type="text"
                                                        class="form-control required"
                                                        v-model.trim="
                                                            data.natio
                                                        "
                                                    />

                                                </div>
                                            </div> -->
                                            <!-- <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>
                                                        Addresse :


                                                    </label>
                                                    <input
                                                        type="text"
                                                        class="form-control required"
                                                        v-model.trim="
                                                            data.address
                                                        "
                                                    />

                                                </div>
                                            </div> -->

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>
                                                        Profession:
                                                        <span class="danger">*</span>
                                                    </label>
                                                    <input type="text" class="form-control required" v-model.trim="
                                                        data.profession
                                                    " />
                                                    <span class="text-danger" v-if="
                                                        !$v.data.profession
                                                            .required &&
                                                        $v.data.profession
                                                            .$dirty
                                                    ">
                                                        La profession du parent
                                                        est
                                                        requise
                                                    </span>
                                                </div>
                                            </div>



                                            <!-- <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="wlastName2">
                                                        Login :
                                                        <span class="danger">*</span>
                                                    </label>
                                                    <input type="text" class="form-control required" v-model.trim="
                                                        data.loginAdmin
                                                    " />
                                                    <span class="text-danger" v-if="
                                                        !$v.data.loginAdmin
                                                            .required &&
                                                        $v.data
                                                            .loginAdmin
                                                            .$dirty
                                                    ">
                                                        Le login est
                                                        requis</span>

                                                    <span class="text-danger" v-if="
                                                        !$v.data.loginAdmin
                                                            .minLength &&
                                                        $v.data
                                                            .loginAdmin
                                                            .$dirty
                                                    ">
                                                        Le login doit contenir
                                                        au moins 6 caracteres
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="wlastName2">
                                                        Mot de passe :
                                                        <span class="danger">*</span>
                                                    </label>
                                                    <input type="password" class="form-control required" v-model.trim="
                                                        data.passAdmin
                                                    " />
                                                    <span class="text-danger" v-if="
                                                        !$v.data.passAdmin
                                                            .required &&
                                                        $v.data
                                                            .passAdmin
                                                            .$dirty
                                                    ">
                                                        Le mot de passe est
                                                        requis</span>
                                                </div>
                                            </div> -->
                                            <!-- <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="wlastName2">
                                                        Mot de passe de
                                                        confirmation :
                                                        <span class="danger">*</span>
                                                    </label>
                                                    <input type="password" class="form-control required" v-model.trim="
                                                        data.CpassAdmin
                                                    " />

                                                    <span class="text-danger" v-if="
                                                        !$v.data.CpassAdmin
                                                            .required &&
                                                        $v.data
                                                            .CpassAdmin
                                                            .$dirty
                                                    ">
                                                        Le mot de passe de
                                                        confirmation est requis
                                                    </span>
                                                    <span class="text-danger" v-else-if="
                                                        $v.data.CpassAdmin
                                                            .$error &&
                                                        $v.data
                                                            .CpassAdmin
                                                            .$dirty
                                                    ">
                                                        Les mots de passe ne
                                                        sont pas identiques
                                                    </span>
                                                </div>
                                            </div> -->
                                            <div class="col-md-6">
                                                <input type="submit" class="btn btn-facebook" value="Enregistrer" />
                                            </div>
                                        </div>

                                    </section>

                                </form>
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

            data: {
                nomAdmin: "",
                PrenomAdmin: "",
                telAdmin: "",
                sexe: "",
                emailAdmin: "",
                loginAdmin: "",
                passAdmin: "",
                CpassAdmin: "",
                imageLogo: "",
                natio: "",
                address: "",
                profession: ""

            },

            EtabInfos: "",
            EcoleInfos: "",
            parentEleve:"",
            visible: false,
            uploadList: []
        };
    },



    validations: {
        data: {

            nomAdmin: {
                required
            },
            PrenomAdmin: {
                required
            },

            profession: {

                required

            },
            Cni: {
                required
            },
            // sexe: {
            //     required
            // },
            // emailAdmin: {
            //     required,
            //     email
            // },
            telAdmin: {
                required,
                maxLength: maxLength(9)
            },
            // loginAdmin: {
            //     required,
            //     minLength: minLength(6)
            // },
            // passAdmin: {
            //     required
            // },
            // CpassAdmin: {
            //     required,
            //     sameAs: sameAs("passAdmin")
            // }
        }
    },


    async mounted() {

        // Recuperer toutes les infos de cette ecole dans le storage

        if (!localStorage.users) {

            this.$router.push('login');
        }

        if (localStorage.EtabInfos) {

            this.EtabInfos = JSON.parse(localStorage.getItem("EtabInfos"));
        }

         if (localStorage.IdParentInfolocal) {
            this.parentEleve = JSON.parse(
                localStorage.getItem("IdParentInfolocal")

            );

            this.data=this.parentEleve

            this.data.nomAdmin = this.parentEleve.nomParent
            this.data.PrenomAdmin = this.parentEleve.prenomParent
            this.data.telAdmin = this.parentEleve.telParent
            this.data.profession = this.parentEleve.professionParent

        }


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
            this.w('Selectionner un jpg, png ou jpeg.')
        },
        handleFormatError(file) {
            this.w('Selectionner un jpg, png ou jpeg')
        },
        handleMaxSize(file) {
            this.w('Selctionner un fichier de moins de 2M.')
        },

        handleBeforeUpload() {
            const check = this.uploadList.length < 1;
            if (!check) {
                this.w('Le logo est requi...')
            }
            return check;
        },
        async onSubmit() {

            this.$v.$touch();

            if (this.$v.$invalid) {

                // Je rajoute les  information de l'ecole appartenant a l'utulisateur qui s'est logger a ma data qui ira dans l'api de creation de la session

                this.data.EcoleInfos = this.EtabInfos;

                const res = await this.callApi("post", "api/locale/updateParent", this.data);

                if (res.status == 400) {

                    this.e(" Un utilisateur  existe déja dans le systeme avec ce nom et se téléphone");


                }

                else if (res.status == 401) {

                    this.w(" Ce login est déja utilisé par une autre personne");

                }

                else if (res.status == 500) {

                    this.e("Erreure systeme interne ou addresse email  déja prise");

                }


                else if (res.status == 200) {

                    this.s("Parent modifié correctement");

                    this.$router.push('Parents');

                }


            } else {
                console.log("Errorrrrr");
            }
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
