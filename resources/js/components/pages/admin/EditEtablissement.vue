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
                                    Formulaire de modication d'un
                                    établissement {{$store.state.counter}}
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
                                        <i class="ti-home mr-15"></i>
                                        Informations Etablissement 
                                    </h4>
                                    <hr class="my-15" />
                                    <section>
                                        <div></div>
                                        <!-- <Upload
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
                                                     `/Photos/Logos/${data.imageProfil}`
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
                                            v-if="data.imageProfil"
                                        >
                                            <img
                                                :src="
                                                    `/Photos/Logos/${data.imageProfil}`
                                                "
                                            />
                                            <div class="demo-upload-list-cover">
                                                <Icon
                                                    type="ios-eye-outline"
                                                    @click.native="
                                                        handleView(
                                                            data.imageProfil
                                                        )
                                                    "
                                                ></Icon>
                                                <Icon
                                                    type="ios-trash-outline"
                                                    @click.native="
                                                        handleRemove(
                                                            data.imageProfil
                                                        )
                                                    "
                                                ></Icon>
                                            </div>
                                        </div>

                                        <br />

                                        <div class="row">
                                            <div class="col-md-6">
                                                <label for="">
                                                    Votre etablissement est t'il
                                                    un groupe scolaire ?
                                                </label>

                                                <div class="form-group">
                                                    <RadioGroup
                                                        v-model="data.groupe"
                                                        type="button"
                                                        button-style="solid"
                                                        @input="selected"
                                                    >
                                                        <Radio
                                                            label="Non"
                                                        ></Radio>
                                                        <Radio
                                                            label="Oui"
                                                        ></Radio>
                                                    </RadioGroup>
                                                </div>
                                            </div>

                                            <Modal
                                                v-model="Modal"
                                                title="Ajouter le nom du groupe scolaire  "
                                                :closable="false"
                                            >
                                                <Input
                                                    v-model="data.groupeName"
                                                    placeholder="Saisir le nom de votre groupe scolaire"
                                                />

                                                <div slot="footer">
                                                    <Button
                                                        type="primary"
                                                        @click="Savegroupe"
                                                        >Enregistrer</Button
                                                    >
                                                </div>
                                            </Modal>

                                            <div class="col-md-6">
                                                <label for="">
                                                    Votre etablissement est t'il
                                                    mixte ?
                                                </label>

                                                <div class="form-group">
                                                    <RadioGroup
                                                        v-model="data.mixte"
                                                        type="button"
                                                        button-style="solid"
                                                    >
                                                        <Radio
                                                            label="Oui"
                                                        ></Radio>
                                                        <Radio
                                                            label="Non"
                                                        ></Radio>
                                                    </RadioGroup>
                                                </div>
                                            </div>
                                        </div> -->

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="wlastName2">
                                                        Code Etablissement :
                                                        <span class="danger"
                                                            >*</span
                                                        >
                                                    </label>
                                                    <input
                                                        type="text"
                                                        class="form-control required"
                                                        v-model="
                                                            dataToEdit.codeEtab
                                                        "
                                                    />
                                                    <span
                                                        class="text-danger"
                                                        v-if="
                                                            !$v.dataToEdit
                                                                .codeEtab
                                                                .required &&
                                                                $v.dataToEdit
                                                                    .codeEtab
                                                                    .$dirty
                                                        "
                                                    >
                                                        Le code établissement
                                                        est requis
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="wlastName2">
                                                        Libellé :
                                                        <span class="danger"
                                                            >*</span
                                                        >
                                                    </label>
                                                    <input
                                                        type="text"
                                                        class="form-control required"
                                                        v-model.trim="
                                                            dataToEdit.libelleEtab
                                                        "
                                                    />
                                                    <span
                                                        class="text-danger"
                                                        v-if="
                                                            !$v.dataToEdit
                                                                .libelleEtab
                                                                .required &&
                                                                $v.dataToEdit
                                                                    .libelleEtab
                                                                    .$dirty
                                                        "
                                                    >
                                                        Le libellé établissement
                                                        est requis</span
                                                    >
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="wlastName2">
                                                        Sigle Etablissment :
                                                        <span class="danger"
                                                            >*</span
                                                        >
                                                    </label>
                                                    <input
                                                        type="text"
                                                        class="form-control required"
                                                        v-model.trim="
                                                            dataToEdit.sigleEtab
                                                        "
                                                    />
                                                    <span
                                                        class="text-danger"
                                                        v-if="
                                                            !$v.dataToEdit
                                                                .sigleEtab
                                                                .required &&
                                                                $v.dataToEdit
                                                                    .sigleEtab
                                                                    .$dirty
                                                        "
                                                    >
                                                        Le sigle de
                                                        l'établissement est
                                                        requis
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="wlastName2">
                                                        Slogan Etablissment :
                                                        <span class="danger"
                                                            >*</span
                                                        >
                                                    </label>
                                                    <input
                                                        type="text"
                                                        class="form-control required"
                                                        v-model.trim="
                                                            dataToEdit.sloganEtab
                                                        "
                                                    />
                                                    <span
                                                        class="text-danger"
                                                        v-if="
                                                            !$v.dataToEdit
                                                                .sloganEtab
                                                                .required &&
                                                                $v.dataToEdit
                                                                    .sloganEtab
                                                                    .$dirty
                                                        "
                                                    >
                                                        Le slogan de
                                                        l'établissement est
                                                        requis
                                                    </span>
                                                </div>
                                            </div>
                                        </div> 

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="wdate2">
                                                        Date création :</label
                                                    >
                                                    <span class="danger"
                                                        >*</span
                                                    >
                                                    <input
                                                        type="date"
                                                        class="form-control"
                                                        v-model.trim="
                                                            dataToEdit.datecreationEtab
                                                        "
                                                    />
                                                    <span
                                                        class="text-danger"
                                                        v-if="
                                                            !$v.dataToEdit
                                                                .datecreationEtab
                                                                .required &&
                                                                $v.dataToEdit
                                                                    .datecreationEtab
                                                                    .$dirty
                                                        "
                                                    >
                                                        La date de creation est
                                                        requise
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
                                                        type="text"
                                                        class="form-control required"
                                                        v-model="
                                                            dataToEdit. emailEtab
                                                        "
                                                    />
                                                    <span
                                                        class="text-danger mt-2"
                                                        v-if="
                                                            (!$v.dataToEdit
                                                                . emailEtab
                                                                .required ||
                                                                !$v.dataToEdit
                                                                    . emailEtab
                                                                    .email) &&
                                                                $v.dataToEdit
                                                                    . emailEtab
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
                                                        >Téléphone principal
                                                        :</label
                                                    >
                                                    <span class="danger"
                                                        >*</span
                                                    >

                                                    <input
                                                        type="number"
                                                        class="form-control"
                                                        v-model="
                                                            dataToEdit.principaltelEtab
                                                        "
                                                    />

                                                    <span
                                                        class="text-danger"
                                                        v-if="
                                                            !$v.dataToEdit
                                                                .principaltelEtab
                                                                .required &&
                                                                $v.dataToEdit
                                                                    .principaltelEtab
                                                                    .$dirty
                                                        "
                                                    >
                                                        Le numéro de téléphone
                                                        est requis
                                                    </span>

                                                    <span
                                                        class="text-danger"
                                                        v-if="
                                                            !$v.dataToEdit
                                                                .principaltelEtab
                                                                .maxLength
                                                        "
                                                    >
                                                        Le numéro de téléphone
                                                        doit contenir 9 chiffres
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
                                                        v-model="
                                                            dataToEdit.secondairetelEtab
                                                        "
                                                    />

                                                    <span
                                                        class="text-danger"
                                                        v-if="
                                                            !$v.dataToEdit
                                                                .secondairetelEtab
                                                                .required &&
                                                                $v.dataToEdit
                                                                    .secondairetelEtab
                                                                    .$dirty
                                                        "
                                                    >
                                                        Le numéro de téléphone
                                                        secondaire est requis
                                                    </span>

                                                    <span
                                                        class="text-danger"
                                                        v-if="
                                                            !$v.dataToEdit
                                                                .secondairetelEtab
                                                                .maxLength
                                                        "
                                                    >
                                                        Le numéro de téléphone
                                                        secondaire est incorrect
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                         <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="wlocation2">
                                                        Pays:
                                                        <span class="danger"
                                                            >*</span
                                                        >
                                                    </label>
                                                    <select
                                                        class="custom-select form-control required"
                                                        v-model="
                                                            dataToEdit.paysEtab
                                                        "
                                                    >
                                                        <option value=""
                                                            >Selecter un pays
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
                                                            !$v.dataToEdit
                                                                .paysEtab
                                                                .required &&
                                                                $v.dataToEdit
                                                                    .paysEtab
                                                                    .$dirty
                                                        "
                                                    >
                                                        Le pays est requis
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="wlocation2">
                                                        Ville :
                                                        <span class="danger"
                                                            >*</span
                                                        >
                                                    </label>
                                                    <input type="text" 
                                                        class="form-control required"
                                                        v-model="
                                                            dataToEdit.villeEtab
                                                        "
                                                    />
                                                       
                                                  
                                                    <span
                                                        class="text-danger"
                                                        v-if="
                                                            !$v.dataToEdit
                                                                .villeEtab
                                                                .required &&
                                                                $v.dataToEdit
                                                                    .villeEtab
                                                                    .$dirty
                                                        "
                                                    >
                                                        La ville est requise
                                                    </span>
                                                </div>
                                            </div>
                                        </div> 
                                    </section>

                                    <!-- Step 2 -->

                                    <section>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="webUrl3"
                                                        >Site internet :</label
                                                    >
                                                    <input
                                                        type="text"
                                                        class="form-control required"
                                                        v-model="
                                                            dataToEdit.sitewebEtab
                                                        "
                                                    />
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="jobTitle3"
                                                        >Directeur des
                                                        études</label
                                                    >
                                                    <span class="danger"
                                                        >*</span
                                                    >
                                                    <input
                                                        type="text"
                                                        class="form-control required"
                                                        v-model="
                                                            dataToEdit.directeurEtab
                                                        "
                                                    />
                                                    <span
                                                        class="text-danger"
                                                        v-if="
                                                            !$v.dataToEdit
                                                                .directeurEtab
                                                                .required &&
                                                                $v.dataToEdit
                                                                    .directeurEtab
                                                                    .$dirty
                                                        "
                                                    >
                                                        La directeur
                                                        d'etablissement est
                                                        requis
                                                    </span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="wphoneNumber2"
                                                        >Téléphone du directeur
                                                        des etudes :</label
                                                    >
                                                    <span class="danger"
                                                        >*</span
                                                    >

                                                    <input
                                                        type="number"
                                                        class="form-control"
                                                        v-model="
                                                            dataToEdit.principalteldirecteurEtab
                                                        "
                                                    />

                                                    <span
                                                        class="text-danger"
                                                        v-if="
                                                            !$v.dataToEdit
                                                                .principalteldirecteurEtab
                                                                .required &&
                                                                $v.dataToEdit
                                                                    .principalteldirecteurEtab
                                                                    .$dirty
                                                        "
                                                    >
                                                        Le numéro de téléphone
                                                        est requis
                                                    </span>

                                                    <span
                                                        class="text-danger"
                                                        v-if="
                                                            !$v.dataToEdit
                                                                .principalteldirecteurEtab
                                                                .maxLength
                                                        "
                                                    >
                                                        Le numéro de téléphone
                                                        doit contenir 9 chiffres
                                                    </span>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="wphoneNumber2">
                                                        Adrresse de
                                                        l'etablissement :</label
                                                    >
                                                    <span class="danger"
                                                        >*</span
                                                    >

                                                    <input
                                                        type="text"
                                                        class="form-control"
                                                        v-model="
                                                            dataToEdit.adresseEtab
                                                        "
                                                    />

                                                    <span
                                                        class="text-danger"
                                                        v-if="
                                                            !$v.dataToEdit
                                                                .adresseEtab
                                                                .required &&
                                                                $v.dataToEdit
                                                                    .adresseEtab
                                                                    .$dirty
                                                        "
                                                    >
                                                        L'addresse de
                                                        l'etablissment est
                                                        requise
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </section>
                                    <!-- Step 3 -->
                                    <h4 class="box-title text-info">
                                        <i class="ti-user mr-15"></i>
                                        Informations Administrateur
                                    </h4>
                                    <hr class="my-15" />
                                    <!-- 
                                    <section>
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
                                                    pour inserer une photo de l'admin
                                                </p>
                                            </div>
                                        </Upload>

                                         <Modal title="Image" v-model="visible">
                                            <img
                                                :src="
                                                    `/Photos/admins/${dataToEdit.imageProfil}`
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
                                            v-if="dataToEdit.imageProfil"
                                        >
                                            <img
                                                :src="
                                                    `/Photos/admins/${dataToEdit.imageProfil}`
                                                "
                                            />
                                            <div class="demo-upload-list-cover">
                                                <Icon
                                                    type="ios-eye-outline"
                                                    @click.native="
                                                        handleView(
                                                            dataToEdit.imageProfil
                                                        )
                                                    "
                                                ></Icon>
                                                <Icon
                                                    type="ios-trash-outline"
                                                    @click.native="
                                                        handleRemove(
                                                            dataToEdit.imageProfil
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
                                                            dataToEdit.nomAdmin
                                                        "
                                                    />
                                                    <span
                                                        class="text-danger"
                                                        v-if="
                                                            !$v.dataToEdit.nomAdmin
                                                                .required &&
                                                                $v.dataToEdit.nomAdmin
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
                                                            dataToEdit.PrenomAdmin
                                                        "
                                                    />
                                                    <span
                                                        class="text-danger"
                                                        v-if="
                                                            !$v.dataToEdit.PrenomAdmin
                                                                .required &&
                                                                $v.dataToEdit
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
                                                            dataToEdit.emailAdmin
                                                        "
                                                    />
                                                    <span
                                                        class="text-danger mt-2"
                                                        v-if="
                                                            (!$v.dataToEdit.emailAdmin
                                                                .required ||
                                                                !$v.dataToEdit
                                                                    .emailAdmin
                                                                    .email) &&
                                                                $v.dataToEdit
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
                                                        v-model="dataToEdit.telAdmin"
                                                    />

                                                    <span
                                                        class="text-danger"
                                                        v-if="
                                                            !$v.dataToEdit.telAdmin
                                                                .required &&
                                                                $v.dataToEdit.telAdmin
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
                                                            !$v.dataToEdit.telAdmin
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
                                                            dataToEdit.fonctionAdmin
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
                                                            !$v.dataToEdit
                                                                .fonctionAdmin
                                                                .required &&
                                                                $v.dataToEdit
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
                                                            dataToEdit.loginAdmin
                                                        "
                                                    />
                                                    <span
                                                        class="text-danger"
                                                        v-if="
                                                            !$v.dataToEdit.loginAdmin
                                                                .required &&
                                                                $v.dataToEdit
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
                                                            !$v.dataToEdit.loginAdmin
                                                                .minLength &&
                                                                $v.dataToEdit
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
                                                            dataToEdit.passAdmin
                                                        "
                                                    />
                                                    <span
                                                        class="text-danger"
                                                        v-if="
                                                            !$v.dataToEdit.passAdmin
                                                                .required &&
                                                                $v.dataToEdit
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
                                                            dataToEdit.CpassAdmin
                                                        "
                                                    />

                                                    <span
                                                        class="text-danger"
                                                        v-if="
                                                            !$v.dataToEdit.CpassAdmin
                                                                .required &&
                                                                $v.dataToEdit
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
                                                            $v.dataToEdit.CpassAdmin
                                                                .$error &&
                                                                $v.dataToEdit
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
                                    </section> -->

                                    <div class="col-md-6">
                                        <input
                                            type="submit"
                                            class="btn btn-facebook"
                                            value="Enregistrer"
                                        />
                                    </div>
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
            visible: false
        };
    },

    computed:mapState(["dataToEdit"]),

    validations: {
        dataToEdit: {
            codeEtab: {
                required
            },
            libelleEtab: {
                required
            },
            datecreationEtab: {
                required
            },
            sigleEtab: {
                required
            },

            typeEtab: {
                required
            },

            emailEtab: {
                required,
                email
            },
            principaltelEtab: {
                required,
                maxLength: maxLength(9)
            },
            secondairetelEtab: {
                required,
                maxLength: maxLength(9)
            },
            paysEtab: {
                required
            },
            villeEtab: {
                required
            },
            siteInternetEtablissement: {
                required
            },
            sloganEtab: {
                required
            },
            adresseEtab: {
                required
            },
            directeurEtab: {
                required
            },
            principalteldirecteurEtab: {
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

    mounted() {
        
        // console.log("Component mounted.");
        // if (localStorage.getItem("UserData")) {
        //     let thedata = JSON.parse(localStorage.getItem("UserData"));
        //     // console.log(thedata.data.data);
        //     this.UserData = thedata.data.data;
        //     // let data=JSON.parse(thedata);
        //     // console.log(data);
        // }
    },
  
   
    methods: {
        Savegroupe() {
            if (this.dataToEdit.groupeName == "") {
                this.Modal = true;
                this.dataToEdit.groupeName = "";

                this.$Notice.warning({
                    title: "Attention !",
                    desc: "Veillez saisir le  nom du groupe scolaire."
                });
            } else {
                this.Modal = false;
            }
        },

        selected() {
            if (this.dataToEdit.groupe == "Oui") {
                this.Modal = true;
            } else {
                this.Modal = false;
            }
        },
        async handleRemove(file) {
            const image = this.dataToEdit;

            this.dataToEdit.imageProfil = "";

            this.$refs.uploads.clearFiles();

            try {
                await axios.post("api/admin/delateImage", image);
            } catch (e) {
                this.generalError = e.response.data.errors;
            }
        },

        handleView(name) {
            this.dataToEdit.imageProfil = name;
            this.visible = true;
        },

        handleSuccess(res, file) {
            this.dataToEdit.imageProfil = res;
            console.log(res);
        },

        handleError(res, file) {
            this.$Notice.warning({
                title: "Erreure du serveur  ",
                desc: "Selectionner un jpg, png ou jpeg."
            });
        },
        handleFormatError(file) {
            this.$Notice.warning({
                title: "Le format du fichier est incorrect ",
                desc: "Selectionner un jpg, png ou jpeg."
            });
        },
        handleMaxSize(file) {
            this.$Notice.warning({
                title: "Le fihcier est trop volumineux ",
                desc: "Selctionner un fichier de moins de 2M."
            });
        },
        async onSubmit() {
            this.$v.$touch();
            if (this.$v.$invalid) {
                try {
                    const response = await axios.post(
                        "api/admin/updateEtablissement",
                        this.dataToEdit
                    );

                    if (response.status == 200) {
                        this.$Notice.success({
                            title: "Felecitations",
                            desc: "Modification correctement éffectuée."
                        });

                         this.$router.push("/Etablissements");
                    }

                    if (response.status != 200) {
                        this.$Notice.warning({
                            title: "Echec ",
                            desc:
                                "Une erreure est survenue lors de la procédure."
                        });
                    }

                    //     .then(response => console.log(response.dataToEdit));
                    // //.then(response => (this.tasks = response.dataToEdit))
                } catch (e) {
                    this.generalError = e.response.data.errors;
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
