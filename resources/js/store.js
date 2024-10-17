import Vue from "vue";
import Vuex from "vuex";

Vue.use(Vuex);

export default new Vuex.Store({
    state: {

        userDatas:0,

        dataToEdit: {
            groupeName: "",
            groupe: "Non",
            mixte: "Oui",
            codeEtablissement: "",
            libelleEtablissement: "",
            sigleEtablissement: "",
            typeEtablissement: "",
            dateCreation: "",
            emailEtablissement: "",
            telephoneEtablissement: "",
            telephoneEtablissementSecond: "",
            paysEtablissement: "",
            villeEtablissement: "",
            siteInternetEtablissement: "",
            sloganEtablissement: "",
            directeurEtablissement: "",
            telephoneDirecteurEtablissement: "",
            addressEtablissement:"",
            nomAdmin: "",
            PrenomAdmin: "",
            telAdmin: "",
            fonctionAdmin: "",
            emailAdmin: "",
            loginAdmin: "",
            passAdmin: "",
            CpassAdmin: "",
            imageProfil: ""
        },

    },

    mutations: { 

        muttation(state, playload) {

           state.dataToEdit = playload

           console.log(playload)
        },

        SaveUser (state, playload) {

             state.userDatas = playload
             console.log(playload) 


         },
 


    },

    // actions: {
    //     changemuttationAction({ commit }, data) {
    //         commit("changemuttation", data);
    //     }
    // }
});
