<template>
    <div>
        <div class="wrapper">
            <Header />
            <Menu />
            <div class="content-wrapper">
                <div class="container-full">
                    <section class="content">
                        <div class="box box-default">
                            <div class="box-header with-border">
                                <h4 class="box-title">
                                    Formulaire de création d'un administrateur
                                </h4>
                                <!-- <h6 class="box-subtitle">You can us the validation like what we did</h6> -->
                            </div>
                            <!-- /.box-header -->
                            <div class="box-body wizard-content">
                                <form
                                    action="#"
                                    class=""
                                    @submit.prevent="onSubmit"
                                >
                                    <!-- Step 1 -->
                                     <h4 class="box-title text-info">
                                        <i class="ti-user mr-15"></i>
                                        Informations Administrateur
                                    </h4>
                                    <hr class="my-15" />
                                    
                                    <section>
                                        <div></div>
                                        <Upload
                                            multiple
                                            type="drag"
                                            action="api/admin/upload"
                                            :on-success="handleSuccess"
                                            :on-error="handleError"
                                            :format="['jpg', 'jpeg', 'png']"
                                            :max-size="2048"
                                            :on-format-error="handleFormatError"
                                            :on-exceeded-size="handleMaxSize"
                                            :headers="{
                                                'X-Requested-With':
                                                    'XMLHttpRequest'
                                            }"
                                        >
                                            <div style="padding: 20px 0">
                                                <Icon
                                                    type="ios-cloud-upload"
                                                    size="52"
                                                    style="color: #3399ff"
                                                ></Icon>
                                                <p class="text-center">
                                                    Cliquer ou glisser deposer
                                                    pour inserer votre logo
                                                </p>
                                            </div>
                                        </Upload>
                                        <Modal title="Image" v-model="visible">
                                            <img
                                                :src="
                                                     `/Photos/Logos/${data.imageLogo}`
                                                "
                                                v-if="visible"
                                                style="width: 100%"
                                            />
                                            <div slot="footer">
                                                <Button
                                                    type="primary"
                                                    @click="visible = false"
                                                    >Close</Button
                                                >
                                            </div>
                                        </Modal>
                                        <div
                                            class="demo-upload-list"
                                            v-if="data.imageLogo"
                                        >
                                            <img
                                                :src="
                                                    `/Photos/Logos/${data.imageLogo}`
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

                                         <div class="row">

                                   
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>
                                                        Nom :
                                                        <span class="danger"
                                                            >*</span
                                                        >
                                                    </label>
                                                    <input
                                                        type="text"
                                                        class="form-control required"
                                                        v-model.trim="
                                                            data.nomAdmin
                                                        "
                                                    />
                                                    <span
                                                        class="text-danger"
                                                        v-if="
                                                            !$v.data.nomAdmin
                                                                .required &&
                                                                $v.data.nomAdmin
                                                                    .$dirty
                                                        "
                                                    >
                                                        Le nom de
                                                        l'adminsitrateur est
                                                        requis
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>
                                                        Prénom :
                                                        <span class="danger"
                                                            >*</span
                                                        >
                                                    </label>
                                                    <input
                                                        type="text"
                                                        class="form-control required"
                                                        v-model.trim="
                                                            data.PrenomAdmin
                                                        "
                                                    />
                                                    <span
                                                        class="text-danger"
                                                        v-if="
                                                            !$v.data.PrenomAdmin
                                                                .required &&
                                                                $v.data
                                                                    .PrenomAdmin
                                                                    .$dirty
                                                        "
                                                    >
                                                        Le prénom de
                                                        l'adminsitrateur est
                                                        requis
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
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
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="wphoneNumber2"
                                                        >Téléphone secondaire
                                                        :</label
                                                    >
                                                    <span class="danger"
                                                        >*</span
                                                    >
                                                    <input
                                                        type="number"
                                                        class="form-control"
                                                        maxlength="9"
                                                        v-model="data.telAdmin"
                                                    />

                                                    <span
                                                        class="text-danger"
                                                        v-if="
                                                            !$v.data.telAdmin
                                                                .required &&
                                                                $v.data.telAdmin
                                                                    .$dirty
                                                        "
                                                    >
                                                        Le numéro de téléphone
                                                        de l'administrateur est
                                                        requis
                                                    </span>

                                                    <span
                                                        class="text-danger"
                                                        v-if="
                                                            !$v.data.telAdmin
                                                                .maxLength
                                                        "
                                                    >
                                                        Le numéro de téléphone
                                                        est incorrect
                                                    </span>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="wlocation2">
                                                        Fonction :
                                                        <span class="danger"
                                                            >*</span
                                                        >
                                                    </label>
                                                    <select
                                                        class="custom-select form-control required"
                                                        v-model="
                                                            data.fonctionAdmin
                                                        "
                                                    >
                                                        <option value=""
                                                            >Selectioner sa
                                                            fonction
                                                        </option>
                                                        <option value="India"
                                                            >India</option
                                                        >
                                                        <option value="USA"
                                                            >USA</option
                                                        >
                                                        <option value="Dubai"
                                                            >Dubai</option
                                                        >
                                                    </select>
                                                    <span
                                                        class="text-danger"
                                                        v-if="
                                                            !$v.data
                                                                .fonctionAdmin
                                                                .required &&
                                                                $v.data
                                                                    .fonctionAdmin
                                                                    .$dirty
                                                        "
                                                    >
                                                        La fonction est requise
                                                    </span>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="wlastName2">
                                                        Login :
                                                        <span class="danger"
                                                            >*</span
                                                        >
                                                    </label>
                                                    <input
                                                        type="text"
                                                        class="form-control required"
                                                        v-model.trim="
                                                            data.loginAdmin
                                                        "
                                                    />
                                                    <span
                                                        class="text-danger"
                                                        v-if="
                                                            !$v.data.loginAdmin
                                                                .required &&
                                                                $v.data
                                                                    .loginAdmin
                                                                    .$dirty
                                                        "
                                                    >
                                                        Le login est
                                                        requis</span
                                                    >

                                                    <span
                                                        class="text-danger"
                                                        v-if="
                                                            !$v.data.loginAdmin
                                                                .minLength &&
                                                                $v.data
                                                                    .loginAdmin
                                                                    .$dirty
                                                        "
                                                    >
                                                        Le login doit contenir
                                                        au moins 6 caracteres
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="wlastName2">
                                                        Mot de passe :
                                                        <span class="danger"
                                                            >*</span
                                                        >
                                                    </label>
                                                    <input
                                                        type="password"
                                                        class="form-control required"
                                                        v-model.trim="
                                                            data.passAdmin
                                                        "
                                                    />
                                                    <span
                                                        class="text-danger"
                                                        v-if="
                                                            !$v.data.passAdmin
                                                                .required &&
                                                                $v.data
                                                                    .passAdmin
                                                                    .$dirty
                                                        "
                                                    >
                                                        Le mot de passe est
                                                        requis</span
                                                    >
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="wlastName2">
                                                        Mot de passe de
                                                        confirmation :
                                                        <span class="danger"
                                                            >*</span
                                                        >
                                                    </label>
                                                    <input
                                                        type="password"
                                                        class="form-control required"
                                                        v-model.trim="
                                                            data.CpassAdmin
                                                        "
                                                    />

                                                    <span
                                                        class="text-danger"
                                                        v-if="
                                                            !$v.data.CpassAdmin
                                                                .required &&
                                                                $v.data
                                                                    .CpassAdmin
                                                                    .$dirty
                                                        "
                                                    >
                                                        Le mot de passe de
                                                        confirmation est requis
                                                    </span>
                                                    <span
                                                        class="text-danger"
                                                        v-else-if="
                                                            $v.data.CpassAdmin
                                                                .$error &&
                                                                $v.data
                                                                    .CpassAdmin
                                                                    .$dirty
                                                        "
                                                    >
                                                        Les mots de passe ne
                                                        sont pas identiques
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <input
                                                    type="submit"
                                                    class="btn btn-facebook"
                                                    value="Enregistrer"
                                                />
                                            </div>
                                        </div>

                                    </section>

                                    
                                    <!-- Step 4 -->
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
import Menu from "../../navs/Menu.vue";
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
    components: { Header, Menu, Chats },
    data() {
        return {
            UserData: [],
            BtnDisabled: "",
            Modal: false,
            data: {
                
                
                nomAdmin: "",
                PrenomAdmin: "",
                telAdmin: "",
                fonctionAdmin: "",
                emailAdmin: "",
                loginAdmin: "",
                passAdmin: "",
                CpassAdmin: "",
                imageLogo: "",
                type: "Admin_locale"
            },

            visible: false,
            uploadList: []
        };
    },

     computed:mapState(["datasUser"]),

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
            addressEtablissement:{
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
            //  Recuperer les donnees envoyees dans la store par computed:
             computed:mapState(["datasUser"]),

    // async mounted() {

    //     console.log("Component mounted.");
    //     if (localStorage.getItem("UserData")) {
    //         let thedata = JSON.parse(localStorage.getItem("UserData"));
    //         // console.log(thedata.data.data);
    //         this.UserData = thedata.data.data;
    //         // let data=JSON.parse(thedata);
    //         // console.log(data);
    //     }
    // },
   
    methods: {
        Savegroupe() {
            if (this.data.groupeName == "") {
                this.Modal = true;
                this.data.groupeName = ""

                this.e('Veillez saisir le  nom du groupe scolaire.')

            } else {
                this.Modal = false; 
            }
        },

        selected() {
            if (this.data.groupe == "Oui") {
                this.Modal = true;
            } else {
                this.Modal = false;
            }
        },
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

        handleBeforeUpload () {
                const check = this.uploadList.length < 1;
                if (!check) {
                    this.w('Le logo est requi...')
                }
                return check;
            },
        async onSubmit() {

            this.$v.$touch();
            if (this.$v.$invalid) {

                 const response = await this.callApi("post", "/api/admin/addAdmin", this.data); 
               
                    if(response.status==200) {

                         this.s('Admin ajoute correctement')

                             //this.$router.push("/Etablissements");

                    }

                      else if (response.status==500){

                         this.e('Cette addresse email est deja prise ')
                    }

                    else if (response.status!=200 && response.status!=422 ){

                         this.e('Une erreure est servenue lors de la procedure')
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
