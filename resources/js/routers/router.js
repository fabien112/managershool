import Vue from "vue";
import Router from "vue-router";
import "vue-input-multiple/dist/vue-input-multiple.css";
import VueInputMultiple from "vue-input-multiple/dist/vue-input-multiple.common";
Vue.use(VueInputMultiple);
Vue.use(Router);
import Login from "../components/pages/Login";
import Etablissements from "../components/pages/admin/Etablissements";
import AddEtablissement from "../components/pages/admin/AddEtablissement";
import addLocal from "../components/pages/admin/AddLocal";
import EditEtablissement from "../components/pages/admin/EditEtablissement";
import EtablissementDash from "../components/pages/admin/EtablissementDash";
import Dashboard from "../components/pages/Dashboard";

//  Routes pour admin local

import DashboardLocal from "../components/pages/locale/DashboardLocal";
import Session from "../components/pages/locale/Session";
import Administration from "../components/pages/locale/Administration";
import Matieres from "../components/pages/locale/Matieres";
import Classes from "../components/pages/locale/Classes";
import Users from "../components/pages/locale/Users";
import addClasse from "../components/pages/locale/addClasse";
import Parents from "../components/pages/locale/Parents";
import Addparent from "../components/pages/locale/addparent";
import Enseignants from "../components/pages/locale/Enseignants";
import Addenseignant from "../components/pages/locale/addenseignant";
import Enseignements from "../components/pages/locale/Enseignements";
import students from "../components/pages/locale/students";
import inscriptionEleve from "../components/pages/locale/inscriptionEleve";
import enfantsParent from "../components/pages/locale/enfantsParent";
import listeEleve from "../components/pages/locale/listeEleve";
import Sms from "../components/pages/locale/Sms";
import messageDash from "../components/pages/locale/messageDash";
import emploiDuTemps from "../components/pages/locale/emploiDuTemps";
import detailsEleve from "../components/pages/locale/detailsEleve";
import Dashteacher from "../components/pages/teacher/Dashteacher";
import classe from "../components/pages/teacher/classe";
import listeEleveTeacher from "../components/pages/teacher/listeEleveTeacher";
import detailEleveTeacher from "../components/pages/teacher/detailEleveTeacher";
import emploiTempteacher from "../components/pages/teacher/emploiTempteacher";
import emploiTempteacher2 from "../components/pages/teacher/emploiTempteacher2";

import EnseignementTeacher from "../components/pages/teacher/EnseignementTeacher";
import absenceDashTeacher from "../components/pages/teacher/absenceDashTeacher";
import emploiTempTeacherForAclass from "../components/pages/teacher/emploiTempTeacherForAclass";
import appelTeacher from "../components/pages/teacher/appelTeacher";
import teacherclasse from "../components/pages/teacher/teacherclasse";
import classeofTeacher from "../components/pages/locale/classeofTeacher";
import Dashparent from "../components/pages/parent/Dashparent";
import messagerie from "../components/pages/locale/messagerie";
import messageDashParent from "../components/pages/parent/messageDashParent";
import detailsMessageParent from "../components/pages/parent/detailsMessageParent";
import messageDashTeacher from "../components/pages/teacher/messageDashTeacher";
import detailsMessageSendByLocal from "../components/pages/locale/detailsMessageSendByLocal";
import detailsMessageTeacher from "../components/pages/teacher/detailsMessageTeacher";
import AbsencesDash from "../components/pages/locale/AbsencesDash";
import RecapAbsence from "../components/pages/locale/RecapAbsence";
import recapAbsenceTeacher from "../components/pages/teacher/recapAbsenceTeacher";
import DashParentGeneralites from "../components/pages/parent/DashParentGeneralites";
import DetailsAbsenceByParent from "../components/pages/parent/DetailsAbsenceByParent";
import EmploiTempsByParent from "../components/pages/parent/EmploiTempsByParent";
import detailsMessageReceiveByLocal from "../components/pages/locale/detailsMessageReceiveByLocal";
import detailsMessageSendParent from "../components/pages/parent/detailsMessageSendParent";
import createDevoir from "../components/pages/teacher/createDevoir";
import devoirsDashTeacher from "../components/pages/teacher/devoirsDashTeacher";
import detailsDevoirTeacher from "../components/pages/teacher/detailsDevoirTeacher";
import devoirsDashLocal from "../components/pages/locale/devoirsDashLocal";
import detailsDevoirLocal from "../components/pages/locale/detailsDevoirLocal";
import devoirsDashParent from "../components/pages/parent/devoirsDashParent";
import detailsDevoirParent from "../components/pages/parent/detailsDevoirParent";
import cahierDashTeacher from "../components/pages/teacher/cahierDashTeacher";
import cahierLocal from "../components/pages/locale/cahierLocal";
import cahierParent from "../components/pages/parent/cahierParent";
import classeFinance from "../components/pages/locale/classeFinance";
import listeStudenversement from "../components/pages/locale/listeStudenversement";
import listeStudentNote from "../components/pages/locale/listeStudentNote";
import detailsEleveFinance from "../components/pages/locale/detailsEleveFinance";
import detailsEleveFinance2 from "../components/pages/locale/detailsEleveFinance2";
import financesDash from "../components/pages/locale/financesDash";
import htmlpdf from "../components/pages/locale/htmlpdf";
import detailsFinancesByParent from "../components/pages/parent/detailsFinancesByParent";
import dashExamenTeacher from "../components/pages/teacher/dashExamenTeacher";
import dashExamen from "../components/pages/locale/dashExamen";
import evaluations from "../components/pages/locale/evaluations";
import addNote from "../components/pages/teacher/addNote";
import notesTeacher from "../components/pages/teacher/notesTeacher";
import notes from "../components/pages/locale/notes";
import moyenne from "../components/pages/locale/moyenne";
import moyenneParent from "../components/pages/parent/moyenneParent";
import BulletinEleve from "../components/pages/locale/BulletinEleve";
import listeClassePdf from "../components/pages/locale/listeClassePdf";
import quizz from "../components/pages/teacher/quizz";
import addQuizz from "../components/pages/teacher/addQuizz";
import detailQuizz from "../components/pages/teacher/detailQuizz";
import quizzDashLocal from "../components/pages/locale/quizzDashLocal";
import detailsQuizzParent from "../components/pages/parent/detailsQuizzParent";
import detailsQuizzLocal from "../components/pages/locale/detailsQuizzLocal";
import quizzParent from "../components/pages/parent/quizzParent";
import EleveDash from "../components/pages/eleve/EleveDash";
import absencesEleve from "../components/pages/eleve/absencesEleve";
import cahierEleve from "../components/pages/eleve/cahierEleve";
import EmploiTempsEleve from "../components/pages/eleve/EmploiTempsEleve";
import paiementEleve from "../components/pages/eleve/paiementEleve";
import devoirEleve from "../components/pages/eleve/devoirEleve";
import DeailsdevoirEleve from "../components/pages/eleve/DeailsdevoirEleve";
import quizzEleve from "../components/pages/eleve/quizzEleve";
import detailsquizzEleve from "../components/pages/eleve/detailsquizzEleve";
import cours from "../components/pages/teacher/cours";
import coursParent from "../components/pages/parent/coursParent";
import coursEleve from "../components/pages/eleve/coursEleve";
import coursDashLocal from "../components/pages/locale/coursDashLocal";
import BulletinsEvaluation from "../components/pages/locale/BulletinsEvaluation";
import BulletinsTrimestre from "../components/pages/locale/BulletinsTrimestre";
import addSyllabus from "../components/pages/teacher/addSyllabus";
import syllabus from "../components/pages/teacher/syllabus";
import notesPerso from "../components/pages/teacher/notesPerso";
import salaires from "../components/pages/locale/salaires";
import cahierNew from "../components/pages/teacher/cahierNew";
import cahierNewAll from "../components/pages/teacher/cahierNewAll";
import salairedash from "../components/pages/locale/salairedash";
import payersalaire from "../components/pages/locale/payersalaire";
import histsalaire from "../components/pages/locale/histsalaire";
import importations from "../components/pages/locale/importations";
import importParent from "../components/pages/locale/importParent";
import importTeacher from "../components/pages/locale/importTeacher";
import importEleve from "../components/pages/locale/importEleve";
import importClasse from "../components/pages/locale/importClasse";
import tableauhonneur from "../components/pages/locale/tableauhonneur";
import cycle from "../components/pages/locale/cycle";
import cycle2 from "../components/pages/locale/cycle2";
import addcaissiere from "../components/pages/locale/addcaissiere";
import caisse from "../components/pages/locale/caisse";

import dashboardCaisse from "../components/pages/caisse/dashboardCaisse";
import cycle3 from "../components/pages/caisse/cycle3";
import classeFinanceCaisse from "../components/pages/caisse/classeFinanceCaisse";

import listeStudenversementCaisse from "../components/pages/caisse/listeStudenversementCaisse";

import detailsEleveFinanceCaisse from "../components/pages/caisse/detailsEleveFinanceCaisse";

import financesDashCaisse from "../components/pages/caisse/financesDashCaisse";

import detailsEleveFinance2Caisse from "../components/pages/caisse/detailsEleveFinance2Caisse";

import salairedashCaisse from "../components/pages/caisse/salairedashCaisse";
import salairesCaisse from "../components/pages/caisse/salairesCaisse";
import payersalaireCaisse from "../components/pages/caisse/payersalaireCaisse";
import payersalaireCaissePersonnel from "../components/pages/caisse/payersalaireCaissePersonnel";
import salairePersonnel from "../components/pages/caisse/salairePersonnel";
import histsalaireCaisse from "../components/pages/caisse/histsalaireCaisse";
import depenseCaisse from "../components/pages/caisse/depenseCaisse";
import adddepense from "../components/pages/caisse/adddepense";
import depenseLocal from "../components/pages/locale/depenseLocal";
import salairePersonnelLocal from "../components/pages/locale/salairePersonnelLocal";
import histPersonnelLocal from "../components/pages/locale/histPersonnelLocal";
import historiquePersonnelCaisse from "../components/pages/caisse/historiquePersonnelCaisse";
import updateRecu from "../components/pages/caisse/updateRecu";

import comptajournal from "../components/pages/caisse/comptajournal";
import navdepense from "../components/pages/caisse/navdepense";

import comptajournelocal from "../components/pages/locale/comptajournelocal";

import histHeure from "../components/pages/locale/histHeure";

import navdepenseLocal from "../components/pages/locale/navdepenseLocal";
import editStudent from "../components/pages/locale/editStudent";
import editTeacher from "../components/pages/locale/editTeacher";
import updateParent from "../components/pages/locale/updateParent";
import editPersonnel from "../components/pages/locale/editPersonnel";
import updateMatiere from "../components/pages/locale/updateMatiere";
import dashboardsg from "../components/pages/sg/dashboardsg";
import RecapAbsenceSg from "../components/pages/sg/RecapAbsenceSg";
import cycleSg from "../components/pages/sg/cycleSg";
import classeSg from "../components/pages/sg/classeSg";
import listeEleveSg from "../components/pages/sg/listeEleveSg";
import messagerieSG from "../components/pages/sg/messagerieSG";
import cycle4 from "../components/pages/locale/cycle4";
import cycle5 from "../components/pages/locale/cycle5";
import classesSgm from "../components/pages/locale/classesSgm";
import disciplineSg from "../components/pages/sg/disciplineSg";
import classeDiscipline from "../components/pages/locale/classeDiscipline";

import listeEleveDiscipline from "../components/pages/locale/listeEleveDiscipline";
import histDiscipline from "../components/pages/locale/histDiscipline";
import consigneParent from "../components/pages/parent/consigneParent";
import detailsCahierTexte from "../components/pages/parent/detailsCahierTexte";
import retard from "../components/pages/teacher/retard";
import autreentree from "../components/pages/caisse/autreentree";
import addautreVersement from "../components/pages/caisse/addautreVersement";
import autreentreelocal from "../components/pages/locale/autreentreelocal";
import banque from "../components/pages/caisse/banque";
import addVersementBanque from "../components/pages/caisse/addVersementBanque";
import retraitBanque from "../components/pages/caisse/retraitBanque";
import bankLocal from "../components/pages/locale/bankLocal";
import addAbsenceSg from "../components/pages/sg/addAbsenceSg";
import absenceSelect from "../components/pages/sg/absenceSelect";
import absenceSeg2 from "../components/pages/sg/absenceSeg2";
import horaireAdmin from "../components/pages/locale/horaireAdmin";
import histHeure2 from "../components/pages/locale/histHeure2";
import addNoteLocal from "../components/pages/locale/addNoteLocal";
import prestataire from "../components/pages/locale/prestataire";
import prestataire2 from "../components/pages/locale/prestataire2";
import statTrimestre from "../components/pages/locale/statTrimestre";
import typeEmploi from "../components/pages/locale/typeEmploi";
import emploiTemps2 from "../components/pages/locale/emploiTemps2";
import emploiTempc from "../components/pages/locale/emploiTempc";
import horaires from "../components/pages/locale/horaires";
import times from "../components/pages/locale/times";
import bulletinAnnuelle from "../components/pages/locale/bulletinAnnuelle";

import ChangeClasse from "../components/pages/locale/ChangeClasse";

import horairetimetable from "../components/pages/locale/horairetimetable";

import niveau from "../components/pages/locale/niveau";

const routes = [
    {
        name: "niveau",
        path: "/niveau",
        component: niveau
    },
    {
        name: "horairetimetable",
        path: "/horairetimetable",
        component: horairetimetable
    },
    {
        name: "ChangeClasse",
        path: "/ChangeClasse",
        component: ChangeClasse
    },

    {
        name: "bulletinAnnuelle",
        path: "/bulletinAnnuelle",
        component: bulletinAnnuelle
    },

    {
        name: "times",
        path: "/times",
        component: times
    },
    {
        name: "horaires",
        path: "/horaires",
        component: horaires
    },

    {
        name: "emploiTempc",
        path: "/emploiTempc",
        component: emploiTempc
    },

    {
        name: "emploiTemps2",
        path: "/emploiTemps2",
        component: emploiTemps2
    },

    {
        name: "typeEmploi",
        path: "/typeEmploi",
        component: typeEmploi
    },
    {
        name: "statTrimestre",
        path: "/statTrimestre",
        component: statTrimestre
    },

    {
        name: "prestataire2",
        path: "/prestataire2",
        component: prestataire2
    },

    {
        name: "prestataire",
        path: "/prestataire",
        component: prestataire
    },

    {
        name: "addNoteLocal",
        path: "/addNoteLocal",
        component: addNoteLocal
    },

    {
        name: "histHeure2",
        path: "/histHeure2",
        component: histHeure2
    },

    {
        name: "horaireAdmin",
        path: "/horaireAdmin",
        component: horaireAdmin
    },

    {
        name: "absenceSeg2",
        path: "/absenceSeg2",
        component: absenceSeg2
    },

    {
        name: "absenceSelect",
        path: "/absenceSelect",
        component: absenceSelect
    },

    {
        name: "addAbsenceSg",
        path: "/addAbsenceSg",
        component: addAbsenceSg
    },

    {
        name: "bankLocal",
        path: "/bankLocal",
        component: bankLocal
    },

    {
        name: "retraitBanque",
        path: "/retraitBanque",
        component: retraitBanque
    },

    {
        name: "addVersementBanque",
        path: "/addVersementBanque",
        component: addVersementBanque
    },

    {
        name: "banque",
        path: "/banque",
        component: banque
    },

    {
        name: "autreentreelocal",
        path: "/autreentreelocal",
        component: autreentreelocal
    },

    {
        name: "addautreVersement",
        path: "/addautreVersement",
        component: addautreVersement
    },

    {
        name: "autreentree",
        path: "/autreentree",
        component: autreentree
    },

    {
        name: "retard",
        path: "/retard",
        component: retard
    },

    {
        name: "detailsCahierTexte",
        path: "/detailsCahierTexte",
        component: detailsCahierTexte
    },

    {
        name: "consigneParent",
        path: "/consigneParent",
        component: consigneParent
    },
    {
        name: "histDiscipline",
        path: "/histDiscipline",
        component: histDiscipline
    },

    {
        name: "classeDiscipline",
        path: "/classeDiscipline",
        component: classeDiscipline
    },

    {
        name: "listeEleveDiscipline",
        path: "/listeEleveDiscipline",
        component: listeEleveDiscipline
    },

    {
        name: "classesSgm",
        path: "/classesSgm",
        component: classesSgm
    },

    {
        name: "disciplineSg",
        path: "/disciplineSg",
        component: disciplineSg
    },

    {
        name: "cycle4",
        path: "/cycle4",
        component: cycle4
    },

    {
        name: "cycle5",
        path: "/cycle5",
        component: cycle5
    },

    {
        name: "messagerieSG",
        path: "/messagerieSG",
        component: messagerieSG
    },

    {
        name: "listeEleveSg",
        path: "/listeEleveSg",
        component: listeEleveSg
    },

    {
        name: "classeSg",
        path: "/classeSg",
        component: classeSg
    },

    {
        name: "cycleSg",
        path: "/cycleSg",
        component: cycleSg
    },

    {
        name: "RecapAbsenceSg",
        path: "/RecapAbsenceSg",
        component: RecapAbsenceSg
    },

    {
        name: "dashboardsg",
        path: "/dashboardsg",
        component: dashboardsg
    },

    {
        name: "updateMatiere",
        path: "/updateMatiere",
        component: updateMatiere
    },

    {
        name: "editPersonnel",
        path: "/editPersonnel",
        component: editPersonnel
    },

    {
        name: "updateParent",
        path: "/updateParent",
        component: updateParent
    },
    {
        name: "editTeacher",
        path: "/editTeacher",
        component: editTeacher
    },

    {
        name: "editStudent",
        path: "/editStudent",
        component: editStudent
    },
    {
        name: "histHeure",
        path: "/histHeure",
        component: histHeure
    },
    {
        name: "navdepenseLocal",
        path: "/navdepenseLocal",
        component: navdepenseLocal
    },
    {
        name: "comptajournelocal",
        path: "/comptajournelocal",
        component: comptajournelocal
    },
    {
        name: "navdepense",
        path: "/navdepense",
        component: navdepense
    },
    {
        name: "comptajournal",
        path: "/comptajournal",
        component: comptajournal
    },

    {
        name: "updateRecu",
        path: "/updateRecu",
        component: updateRecu
    },
    {
        name: "histPersonnelLocal",
        path: "/histPersonnelLocal",
        component: histPersonnelLocal
    },
    {
        name: "historiquePersonnelCaisse",
        path: "/historiquePersonnelCaisse",
        component: historiquePersonnelCaisse
    },
    {
        name: "salairePersonnelLocal",
        path: "/salairePersonnelLocal",
        component: salairePersonnelLocal
    },
    {
        name: "depenseLocal",
        path: "/depenseLocal",
        component: depenseLocal
    },
    {
        name: "adddepense",
        path: "/adddepense",
        component: adddepense
    },

    {
        name: "depenseCaisse",
        path: "/depenseCaisse",
        component: depenseCaisse
    },
    {
        name: "histsalaireCaisse",
        path: "/histsalaireCaisse",
        component: histsalaireCaisse
    },
    {
        name: "payersalaireCaissePersonnel",
        path: "/payersalaireCaissePersonnel",
        component: payersalaireCaissePersonnel
    },

    {
        name: "payersalaireCaisse",
        path: "/payersalaireCaisse",
        component: payersalaireCaisse
    },

    {
        name: "salairePersonnel",
        path: "/salairePersonnel",
        component: salairePersonnel
    },

    {
        name: "salairesCaisse",
        path: "/salairesCaisse",
        component: salairesCaisse
    },

    {
        name: "salairedashCaisse",
        path: "/salairedashCaisse",
        component: salairedashCaisse
    },
    {
        name: "detailsEleveFinance2Caisse",
        path: "/detailsEleveFinance2Caisse",
        component: detailsEleveFinance2Caisse
    },

    {
        name: "financesDashCaisse",
        path: "/financesDashCaisse",
        component: financesDashCaisse
    },

    {
        name: "detailsEleveFinanceCaisse",
        path: "/detailsEleveFinanceCaisse",
        component: detailsEleveFinanceCaisse
    },
    {
        name: "listeStudenversementCaisse",
        path: "/listeStudenversementCaisse",
        component: listeStudenversementCaisse
    },
    {
        name: "classeFinanceCaisse",
        path: "/classeFinanceCaisse",
        component: classeFinanceCaisse
    },

    {
        name: "cycle3",
        path: "/cycle3",
        component: cycle3
    },
    {
        name: "addcaissiere",
        path: "/addcaissiere",
        component: addcaissiere
    },

    {
        name: "dashboardCaisse",
        path: "/dashboardCaisse",
        component: dashboardCaisse
    },

    {
        name: "cycle",
        path: "/cycle",
        component: cycle
    },

    {
        name: "caisse",
        path: "/caisse",
        component: caisse
    },

    {
        name: "cycle2",
        path: "/cycle2",
        component: cycle2
    },
    {
        name: "tableauhonneur",
        path: "/tableauhonneur",
        component: tableauhonneur
    },
    {
        name: "importClasse",
        path: "/importClasse",
        component: importClasse
    },

    {
        name: "importEleve",
        path: "/importEleve",
        component: importEleve
    },

    {
        name: "importTeacher",
        path: "/importTeacher",
        component: importTeacher
    },

    {
        name: "importParent",
        path: "/importParent",
        component: importParent
    },

    {
        name: "importations",
        path: "/importations",
        component: importations
    },

    {
        name: "payersalaire",
        path: "/payersalaire",
        component: payersalaire
    },

    {
        name: "histsalaire",
        path: "/histsalaire",
        component: histsalaire
    },

    {
        name: "salairedash",
        path: "/salairedash",
        component: salairedash
    },
    {
        name: "cahierNewAll",
        path: "/cahierNewAll",
        component: cahierNewAll
    },

    {
        name: "cahierNew",
        path: "/cahierNew",
        component: cahierNew
    },

    {
        name: "salaires",
        path: "/salaires",
        component: salaires
    },

    {
        name: "notesPerso",
        path: "/notesPerso",
        component: notesPerso
    },

    {
        name: "addSyllabus",
        path: "/addSyllabus",
        component: addSyllabus
    },

    {
        name: "syllabus",
        path: "/syllabus",
        component: syllabus
    },

    {
        name: "coursDashLocal",
        path: "/coursDashLocal",
        component: coursDashLocal
    },

    {
        name: "BulletinsTrimestre",
        path: "/BulletinsTrimestre",
        component: BulletinsTrimestre
    },

    {
        name: "BulletinsEvaluation",
        path: "/BulletinsEvaluation",
        component: BulletinsEvaluation
    },
    {
        name: "coursEleve",
        path: "/coursEleve",
        component: coursEleve
    },
    {
        name: "cours",
        path: "/cours",
        component: cours
    },

    {
        name: "coursParent",
        path: "/coursParent",
        component: coursParent
    },

    {
        name: "detailsquizzEleve",
        path: "/detailsquizzEleve",
        component: detailsquizzEleve
    },

    {
        name: "quizzEleve",
        path: "/quizzEleve",
        component: quizzEleve
    },

    {
        name: "DeailsdevoirEleve",
        path: "/DeailsdevoirEleve",
        component: DeailsdevoirEleve
    },

    {
        name: "devoirEleve",
        path: "/devoirEleve",
        component: devoirEleve
    },

    {
        name: "paiementEleve",
        path: "/paiementEleve",
        component: paiementEleve
    },

    {
        name: "EmploiTempsEleve",
        path: "/EmploiTempsEleve",
        component: EmploiTempsEleve
    },

    {
        name: "cahierEleve",
        path: "/cahierEleve",
        component: cahierEleve
    },

    {
        name: "absencesEleve",
        path: "/absencesEleve",
        component: absencesEleve
    },

    {
        name: "EleveDash",
        path: "/EleveDash",
        component: EleveDash
    },

    {
        name: "quizzDashLocal",
        path: "/quizzDashLocal",
        component: quizzDashLocal
    },

    {
        name: "quizzParent",
        path: "/quizzParent",
        component: quizzParent
    },

    {
        name: "detailsQuizzParent",
        path: "/detailsQuizzParent",
        component: detailsQuizzParent
    },

    {
        name: "detailsQuizzLocal",
        path: "/detailsQuizzLocal",
        component: detailsQuizzLocal
    },

    {
        name: "quizz",
        path: "/quizz",
        component: quizz
    },

    {
        name: "detailQuizz",
        path: "/detailQuizz",
        component: detailQuizz
    },

    {
        name: "addQuizz",
        path: "/addQuizz",
        component: addQuizz
    },

    {
        name: "htmlpdf",
        path: "/htmlpdf",
        component: htmlpdf
    },

    {
        name: "listeClassePdf",
        path: "/listeClassePdf",
        component: listeClassePdf
    },

    {
        name: "BulletinEleve",
        path: "/BulletinEleve",
        component: BulletinEleve
    },

    {
        name: "moyenneParent",
        path: "/moyenneParent",
        component: moyenneParent
    },

    {
        name: "moyenne",
        path: "/moyenne",
        component: moyenne
    },

    {
        name: "notes",
        path: "/notes",
        component: notes
    },

    {
        name: "notesTeacher",
        path: "/notesTeacher",
        component: notesTeacher
    },

    {
        name: "addNote",
        path: "/addNote",
        component: addNote
    },

    {
        name: "dashExamenTeacher",
        path: "/dashExamenTeacher",
        component: dashExamenTeacher
    },

    {
        name: "evaluations",
        path: "/evaluations",
        component: evaluations
    },

    {
        name: "dashExamen",
        path: "/dashExamen",
        component: dashExamen
    },

    {
        name: "detailsFinancesByParent",
        path: "/detailsFinancesByParent",
        component: detailsFinancesByParent
    },

    {
        name: "financesDash",
        path: "/financesDash",
        component: financesDash
    },
    {
        name: "detailsEleveFinance2",
        path: "/detailsEleveFinance2",
        component: detailsEleveFinance2
    },

    {
        name: "detailsEleveFinance",
        path: "/detailsEleveFinance",
        component: detailsEleveFinance
    },

    {
        name: "listeStudenversement",
        path: "/listeStudenversement",
        component: listeStudenversement
    },

    {
        name: "listeStudentNote",
        path: "/listeStudentNote",
        component: listeStudentNote
    },

    {
        name: "classeFinance",
        path: "/classeFinance",
        component: classeFinance
    },

    {
        name: "cahierParent",
        path: "/cahierParent",
        component: cahierParent
    },

    {
        name: "cahierLocal",
        path: "/cahierLocal",
        component: cahierLocal
    },

    {
        name: "cahierDashTeacher",
        path: "/cahierDashTeacher",
        component: cahierDashTeacher
    },

    {
        name: "detailsDevoirParent",
        path: "/detailsDevoirParent",
        component: detailsDevoirParent
    },

    {
        name: "devoirsDashParent",
        path: "/devoirsDashParent",
        component: devoirsDashParent
    },

    {
        name: "detailsDevoirLocal",
        path: "/detailsDevoirLocal",
        component: detailsDevoirLocal
    },

    {
        name: "devoirsDashLocal",
        path: "/devoirsDashLocal",
        component: devoirsDashLocal
    },

    {
        name: "detailsDevoirTeacher",
        path: "/detailsDevoirTeacher",
        component: detailsDevoirTeacher
    },

    {
        name: "devoirsDashTeacher",
        path: "/devoirsDashTeacher",
        component: devoirsDashTeacher
    },

    {
        name: "createDevoir",
        path: "/createDevoir",
        component: createDevoir
    },

    {
        name: "detailsMessageSendParent",
        path: "/detailsMessageSendParent",
        component: detailsMessageSendParent
    },

    {
        name: "detailsMessageReceiveByLocal",
        path: "/detailsMessageReceiveByLocal",
        component: detailsMessageReceiveByLocal
    },

    {
        name: "EmploiTempsByParent",
        path: "/EmploiTempsByParent",
        component: EmploiTempsByParent
    },

    {
        name: "DetailsAbsenceByParent",
        path: "/DetailsAbsenceByParent",
        component: DetailsAbsenceByParent
    },
    {
        name: "DashParentGeneralites",
        path: "/DashParentGeneralites",
        component: DashParentGeneralites
    },

    {
        name: "RecapAbsence",
        path: "/RecapAbsence",
        component: RecapAbsence
    },

    {
        name: "recapAbsenceTeacher",
        path: "/recapAbsenceTeacher",
        component: recapAbsenceTeacher
    },

    {
        name: "AbsencesDash",
        path: "/AbsencesDash",
        component: AbsencesDash
    },
    {
        name: "detailsMessageTeacher",
        path: "/detailsMessageTeacher",
        component: detailsMessageTeacher
    },

    {
        name: "detailsMessageSendByLocal",
        path: "/detailsMessageSendByLocal",
        component: detailsMessageSendByLocal
    },

    {
        name: "detailsMessageParent",
        path: "/detailsMessageParent",
        component: detailsMessageParent
    },

    {
        name: "messageDashTeacher",
        path: "/messageDashTeacher",
        component: messageDashTeacher
    },

    {
        name: "emploiTempTeacherForAclass",
        path: "/emploiTempTeacherForAclass",
        component: emploiTempTeacherForAclass
    },

    {
        name: "messageDashParent",
        path: "/messageDashParent",
        component: messageDashParent
    },

    {
        name: "messagerie",
        path: "/messagerie",
        component: messagerie
    },

    {
        name: "Dashparent",
        path: "/Dashparent",
        component: Dashparent
    },

    {
        name: "classeofTeacher",
        path: "/classeofTeacher",
        component: classeofTeacher
    },

    {
        name: "appelTeacher",
        path: "/appelTeacher",
        component: appelTeacher
    },

    {
        name: "absenceDashTeacher",
        path: "/absenceDashTeacher",
        component: absenceDashTeacher
    },

    {
        name: "EnseignementTeacher",
        path: "/EnseignementTeacher",
        component: EnseignementTeacher
    },

    {
        name: "emploiTempteacher",
        path: "/emploiTempteacher",
        component: emploiTempteacher
    },

    {
        name: "emploiTempteacher2",
        path: "/emploiTempteacher2",
        component: emploiTempteacher2
    },

    {
        name: "detailEleveTeacher",
        path: "/detailEleveTeacher",
        component: detailEleveTeacher
    },

    {
        name: "emploiDuTemps",
        path: "/emploiDuTemps",
        component: emploiDuTemps
    },

    {
        name: "listeEleveTeacher",
        path: "/listeEleveTeacher",
        component: listeEleveTeacher
    },
    {
        name: "teacherclasse",
        path: "/teacherclasse",
        component: teacherclasse
    },

    {
        name: "Dashteacher",
        path: "/Dashteacher",
        component: Dashteacher
    },

    {
        name: "detailsEleve",
        path: "/detailsEleve",
        component: detailsEleve
    },

    {
        name: "messageDash",
        path: "/messageDash",
        component: messageDash
    },

    {
        name: "Sms",
        path: "/Sms",
        component: Sms
    },

    {
        name: "listeEleve",
        path: "/listeEleve",
        component: listeEleve
    },

    {
        name: "enfantsParent",
        path: "/enfantsParent",
        component: enfantsParent
    },

    {
        name: "inscriptionEleve",
        path: "/inscriptionEleve",
        component: inscriptionEleve
    },

    {
        name: "students",
        path: "/students",
        component: students
    },

    {
        name: "Enseignants",
        path: "/Enseignants",
        component: Enseignants
    },

    {
        name: "Enseignements",
        path: "/Enseignements",
        component: Enseignements
    },

    {
        name: "Addenseignant",
        path: "/addenseignant",
        component: Addenseignant
    },

    {
        name: "Parents",
        path: "/Parents",
        component: Parents
    },

    {
        name: "Addparent",
        path: "/addparent",
        component: Addparent
    },

    {
        name: "addClasse",
        path: "/addclasse",
        component: addClasse
    },

    {
        name: "Matieres",
        path: "/Matieres",
        component: Matieres
    },
    {
        name: "Classes",
        path: "/classes",
        component: Classes
    },
    {
        name: "Users",
        path: "/users",
        component: Users
    },

    {
        name: "Administration",
        path: "/administration",
        component: Administration
    },

    {
        name: "DashboardLocal",
        path: "/dashboardLocal",
        component: DashboardLocal
    },

    {
        name: "Session",
        path: "/session",
        component: Session,
        beforeEnter: (to, form, next) => {
            if (!localStorage.users) {
                next("/");
            } else {
                next();
            }
        }
    },

    {
        name: "addLocal",
        path: "/addLocal",
        component: addLocal
    },

    {
        name: "etablissementDash",
        path: "/etablissementDash",
        component: EtablissementDash
    },

    { name: "login", path: "/login", component: Login },

    {
        name: "home",
        path: "/",
        component: Login
    },
    {
        name: "dashboard",
        path: "/dashboard",
        component: Dashboard
    },
    {
        name: "etablissements",
        path: "/etablissements",
        component: Etablissements
    },
    {
        name: "addetab",
        path: "/addetablissement",
        component: AddEtablissement
    },

    {
        name: "editetab",
        path: "/editEtablissment",
        component: EditEtablissement
    }
];

export default new Router({
    base: process.env.BASE_URL,
    mode: "history",
    routes
});
