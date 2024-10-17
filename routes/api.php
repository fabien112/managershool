<?php

use App\Models\Classe;
use App\Models\Matieres;
use App\Models\CahierTexte;
use Illuminate\Http\Request;
use App\Models\Etablissement;
use App\Http\Middleware\loginCheck;
use App\Http\Middleware\Authenticate;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PdfController;
use App\Http\Controllers\SmsController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BankController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CoursController;
use App\Http\Controllers\NotesController;
use App\Http\Controllers\QuizzController;
use App\Http\Controllers\StatsController;
use App\Http\Controllers\CahierController;
use App\Http\Controllers\CaisseController;
use App\Http\Controllers\ClasseController;
use App\Http\Controllers\ParentController;
use App\Http\Controllers\DevoirsController;
use App\Http\Controllers\MatiereController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\AbsencesController;
use App\Http\Controllers\MoyennesController;
use App\Http\Controllers\SalairesController;
use App\Http\Controllers\SyllabusController;
use App\Http\Controllers\TrimestreController;
use App\Http\Controllers\DisciplineController;
use App\Http\Controllers\EnseignantController;
use App\Http\Controllers\VersementsController;
use App\Http\Controllers\CahierTexteController;
use App\Http\Controllers\EvaluationsController;
use App\Http\Controllers\ImportationsController;
use App\Http\Controllers\EtablissementController;
use App\Http\Controllers\NotificationsController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

//Route::middleware(['auth'])->group(function () {


Route::post('admin/upload', [EtablissementController::class, 'upload']);

Route::post('admin/upload2', [EtablissementController::class, 'upload2']);


Route::post('admin/uploadparent', [ImportationsController::class, 'uploadparent']);

Route::post('admin/uploadstudent', [ImportationsController::class, 'uploadstudent']);


Route::post('admin/uploadsmatieres', [ImportationsController::class, 'uploadsmatieres']);


Route::post('admin/uploadclasse', [ImportationsController::class, 'uploadclasse']);


Route::post('admin/uploadteacher', [ImportationsController::class, 'uploadteacher']);


Route::get('pdf', [PdfController::class, 'index']);

Route::post('admin/delateImage', [EtablissementController::class, 'delateImage']);

//  Ajouter un  etalissement

Route::post('admin/addEtablissement', [EtablissementController::class, 'addEtablissement']);

// Ajouter un admin a une ecole

Route::post('admin/addAdmin', [EtablissementController::class, 'addAdmin']);

//  Recuperer tous les etalissements

Route::get('admin/getAllEtablissement', [EtablissementController::class, 'getAllEtablissement']);

//  supprimer  un  etalissement

Route::post('admin/delateEtablissement', [EtablissementController::class, 'delateEtablissement']);

// Modifier un etablissement

Route::post('admin/updateEtablissement', [EtablissementController::class, 'updateEtablissement']);

Route::post('locale/delateEleve', [StudentController::class, 'delateEleve']);

//});


Route::post('/login', [AuthController::class, 'login']);


// Route::middleware(['ProtectedPage'])->group(function () {

/*    ROUTES LIEES A L"ADMIN LOCAL  */


Route::post('locale/changeClasse', [ClasseController::class, 'changeClasse']);

Route::post('locale/changeClasseTranfert', [ClasseController::class, 'changeClasseTranfert']);
Route::post('locale/BlamerNote', [NotesController::class, 'BlamerNote']);

Route::post('teacher/BlamerNote', [NotesController::class, 'BlamerNoteteacher']);

Route::post('locale/AnnulerSequence', [NotesController::class, 'AnnulerSequence']);

Route::post('locale/section', [SessionController::class, 'section']);

Route::post('locale/JustifierNote', [NotesController::class, 'JustifierNote']);

Route::post('teacher/JustifierNote', [NotesController::class, 'JustifierNoteteacher']);

Route::post('locale/updateMoyenneAnnuelle', [MoyennesController::class, 'updateMoyenneAnnuelle']);


Route::post('locale/getAllasseTeacherBylocale', [EnseignantController::class, 'getAllasseTeacherBylocale']);


Route::post('locale/getAllasseTeacherBylocale2', [EnseignantController::class, 'getAllasseTeacherBylocale2']);


Route::post('locale/loadEleveExcel', [ImportationsController::class, 'loadEleveExcel']);

Route::post('caisse/payerAutredepense', [SalairesController::class, 'payerAutredepense']);

Route::post('caisse/getAllSalairesMoisAutre', [SalairesController::class, 'getAllSalairesMoisAutre']);


Route::post('caisse/upadteSalaire', [SalairesController::class, 'upadteSalaire']);


Route::post('caisse/rechercher', [StudentController::class, 'rechercher']);

Route::post('caisse/delateVersement', [VersementsController::class, 'delateVersement']);

Route::post('locale/getAllTrimestre', [TrimestreController::class, 'getAllTrimestre']);

Route::post('locale/getAllFinancesJour', [SalairesController::class, 'getAllFinancesJour']);


Route::post('locale/delateBook', [CahierTexteController::class, 'delateBook']);


Route::post('locale/getFileres', [ClasseController::class, 'getFileres']);

Route::post('locale/getSpectialites', [ClasseController::class, 'getSpectialites']);

Route::post('locale/getTotaldepense', [SalairesController::class, 'getTotaldepense']);



Route::post('caisse/getAllSalairesPersonnelMois', [SalairesController::class, 'getAllSalairesPersonnelMois']);

Route::post('locale/getAllSalairesMois', [SalairesController::class, 'getAllSalairesMois']);


Route::post('locale/getAllHistorique', [SalairesController::class, 'getAllHistorique']);

Route::post('caisse/getAllHistorique2', [SalairesController::class, 'getAllHistorique2']);


Route::post('locale/getAllTotalSalairesMois', [SalairesController::class, 'getAllTotalSalairesMois']);


Route::post('locale/getTeacherBylocale', [EnseignantController::class, 'getTeacherBylocale']);

Route::post('locale/payersalaireProf', [SalairesController::class, 'payersalaireProf']);

Route::post('caisse/payersalairePersonnel', [SalairesController::class, 'payersalairePersonnel']);


Route::post('locale/Addclasse', [ClasseController::class, 'Addclasse']);


// Recuperer toutes les sessions d'une ecole

Route::post('locale/regulstudent', [StudentController::class, 'regulstudent']);


Route::post('locale/getParentByIdClasse', [StudentController::class, 'getParentByIdClasse']);

Route::post('locale/getSessionEtablissement', [SessionController::class, 'getSessionEtablissement']);


// Recuperer tous les trimestres de la session  en cour d'une ecole

Route::post('locale/getTrimestreEtablissement', [SessionController::class, 'getTrimestreEtablissement']);

// Recuperer toutes les classe de la session  en cour d'une ecole

Route::post('locale/getClasseEtablissementSurveillant', [ClasseController::class, 'getClasseEtablissementSurveillant']);

Route::post('locale/getClasseEtablissement', [ClasseController::class, 'getClasseEtablissement']);


Route::post('locale/getClasseEtablissementTest', [ClasseController::class, 'getClasseEtablissementTest']);

Route::post('locale/getClasseEtablissementBySg', [ClasseController::class, 'getClasseEtablissementBySg']);

Route::post('teacher/updateNote', [NotesController::class, 'updateNote']);

Route::post('locale/getStatClasse', [StatsController::class, 'getStatClasse']);

Route::post('locale/getStatClasseTrimestre', [StatsController::class, 'getStatClasseTrimestre']);


Route::post('teacher/updateNote2', [NotesController::class, 'updateNote2']);

Route::post('teacher/AddNoteAlone', [NotesController::class, 'AddNoteAlone']);

Route::post('locale/getAlldiscipline', [DisciplineController::class, 'getAlldiscipline']);

Route::post('locale/addSencion', [DisciplineController::class, 'addSencion']);

Route::post('parent/listeNotifications', [NotificationsController::class, 'listeNotifications']);

Route::post('parent/updateNotifications', [NotificationsController::class, 'updateNotifications']);


Route::post('locale/doProfPrincipal', [ClasseController::class, 'doProfPrincipal']);

Route::post('locale/getClasseEtablissement2', [ClasseController::class, 'getClasseEtablissement2']);


Route::post('admin/getclassesadmin', [ClasseController::class, 'getclassesadmin']);

Route::post('locale/getRecapFinances', [VersementsController::class, 'getRecapFinances']);

Route::post('parent/updateMessagesParent', [MessageController::class, 'updateMessagesParent']);

Route::post('parent/getMessagesParent', [MessageController::class, 'getMessagesParent']);


Route::post('parent/getMessagesTeacher', [MessageController::class, 'getMessagesTeacher']);

// Recuperer toutes les infos d'une ecole

Route::post('locale/getEtabinfos', [EtablissementController::class, 'getEtabinfos']);


Route::post('locale/getstatsEtab', [EtablissementController::class, 'getstatsEtab']);

// Ajouter une session a une ecole

Route::post('locale/addSession', [SessionController::class, 'addSession']);

// clotruer une session cloturerSession

Route::post('locale/cloturerSession', [SessionController::class, 'cloturerSession']);

Route::post('locale/addVersement', [VersementsController::class, 'addVersement']);

Route::post('locale/getAstudentFinancesInfos', [VersementsController::class, 'getAstudentFinancesInfos']);

Route::post('locale/getAstudentDatailsFinancesInfos', [VersementsController::class, 'getAstudentDatailsFinancesInfos']);

Route::post('locale/getAstudentDatailsFinancesDashboard', [VersementsController::class, 'getAstudentDatailsFinancesDashboard']);


Route::post('locale/addEvaluations', [EvaluationsController::class, 'addEvaluations']);

Route::post('locale/getAllEvaluations', [EvaluationsController::class, 'getAllEvaluations']);

Route::post('locale/getAllEvaluations2', [EvaluationsController::class, 'getAllEvaluations2']);


Route::post('teacher/getAllEvaluationsByParent', [EvaluationsController::class, 'getAllEvaluationsByParent']);

Route::post('locale/delateEvaluation', [EvaluationsController::class, 'delateEvaluation']);

Route::post('locale/activateEvaluation', [EvaluationsController::class, 'activateEvaluation']);

Route::post('teacher/getEvaluationActif', [EvaluationsController::class, 'getEvaluationActif']);

Route::post('teacher/getTrimestreActif', [TrimestreController::class, 'getTrimestreActif']);

Route::post('teacher/getEvaluationAll', [EvaluationsController::class, 'getEvaluationAll']);

Route::post('locale/getStudentBySg', [StudentController::class, 'getStudentBySg']);

Route::post('locale/getStudentBySg2', [DisciplineController::class, 'getStudentBySg2']);

Route::post('locale/AddabsenceSg', [DisciplineController::class, 'AddabsenceSg']);

Route::post('surveillant/justifierabsence', [DisciplineController::class, 'justifierabsence']);







/* ROUTES POUR LES PARENTS */


// Ajouter un parent a une ecole

Route::post('locale/addParent', [ParentController::class, 'addParent']);

Route::post('parent/getInfosParent', [ParentController::class, 'getInfosParent']);

// Recuperer les parents d'une ecole

Route::post('locale/getParent', [ParentController::class, 'getParent']);


/* Routes pour les enseignants  */

// Faire l'appel pour une classe

Route::post('teacher/DoAppelByTeacher', [EnseignantController::class, 'DoAppelByTeacher']);

Route::post('teacher/DoRetardByTeacher', [EnseignantController::class, 'DoRetardByTeacher']);


// Ajouter un enseigant  a une ecole

Route::post('locale/addEnseignant', [EnseignantController::class, 'addEnseignant']);

Route::post('locale/editEnseignant', [EnseignantController::class, 'editEnseignant']);

Route::post('locale/updateParent', [ParentController::class, 'updateParent']);

Route::post('locale/updatecaissiere', [CaisseController::class, 'updatecaissiere']);

Route::post('locale/delateMatiere', [MatiereController::class, 'delateMatiere']);





// Recuperer les enseignants  d'une ecole

Route::post('locale/getAllEnseignant', [EnseignantController::class, 'getAllEnseignant']);


// Recuperer les enseignants  d'une ecole pour affectation

Route::post('locale/getAllEnseignantAffect', [EnseignantController::class, 'getAllEnseignantAffect']);

// Recuperer les enseignants  de l'ecole  avec enseigant respectifs

Route::post('locale/getAllEnseignantAffectMatieres', [EnseignantController::class, 'getAllEnseignantAffectMatieres']);

// Recuperer les enfants d'un parent dans le compte admin

Route::post('locale/getAllStudentofeParentByLocal', [ParentController::class, 'getAllStudentofeParentByLocal']);






/* ROUTES POUR LES MATIERS */


// Ajouter un libelle

Route::post('locale/addLibelle', [MatiereController::class, 'addLibelle']);


// Recuperer tous les  libelles

Route::post('locale/getLibelles', [MatiereController::class, 'getLibelles']);

Route::post('locale/getcat', [MatiereController::class, 'getcat']);


Route::post('locale/Addconfig', [MatiereController::class, 'Addconfig']);



// Ajouter une matiere

Route::post('locale/addMatiere', [MatiereController::class, 'addMatiere']);

Route::post('locale/getCaisse', [CaisseController::class, 'getCaisse']);

Route::post('locale/getCaissep', [CaisseController::class, 'getCaissep']);

Route::post('locale/addcaissiere', [CaisseController::class, 'addcaissiere']);

Route::post('locale/delateCaissiere', [CaisseController::class, 'delateCaissiere']);

Route::post('caisse/getEtabinfosCaisse', [CaisseController::class, 'getEtabinfosCaisse']);

Route::post('caisse/delatePaiement', [SalairesController::class, 'delatePaiement']);






// Recuperer toutes les classes pour creer des matieres

Route::post('locale/getClasses', [MatiereController::class, 'getClasses']);

// Recuperer toutes les matieres d'une  classe precise

Route::post('locale/getMatieresClasse', [MatiereController::class, 'getMatieresClasse']);

Route::post('locale/getMatieresClasse2', [MatiereController::class, 'getMatieresClasse2']);

Route::post('locale/createHoraires', [MatiereController::class, 'createHoraires']);

Route::post('locale/getHeures', [MatiereController::class, 'getHeures']);
Route::get('locale/getEleveclassePdf3/{id}', [PdfController::class, 'getEleveclassePdf3']);

Route::post('locale/createEmpldoiTempsDash', [MatiereController::class, 'createEmpldoiTempsDash']);
Route::post('locale/createEmpldoiTempsDashvrai', [MatiereController::class, 'createEmpldoiTempsDashvrai']);


Route::post('locale/getTimestabs', [MatiereController::class, 'getTimestabs']);

Route::post('locale/delatimetable', [MatiereController::class, 'delatimetable']);



// Recuperer toutes les matieres d'une  classe precise

Route::post('locale/affecterTeacher', [MatiereController::class, 'affecterTeacher']);

Route::post('locale/affecterTeacher2', [MatiereController::class, 'affecterTeacher2']);


Route::post('locale/getBulletinEleve', [NotesController::class, 'getBulletinEleve']);

Route::post('teacher/getBulletinEleveByParent', [NotesController::class, 'getBulletinEleveByParent']);


Route::post('teacher/getBulletinEleveByParentTrimestre', [NotesController::class, 'getBulletinEleveByParentTrimestre']);

// Recuperer tous les emplois du temps

Route::post('locale/getAllTimetable', [ClasseController::class, 'getAllTimetable']);

Route::post('locale/updateTimetable', [ClasseController::class, 'updateTimetable']);


Route::post('teacher/getLibelleMatiereclasseById', [ClasseController::class, 'getLibelleMatiereclasseById']);

Route::post('teacher/getPartieByMatiereAndclasse', [CahierController::class, 'getPartieByMatiereAndclasse']);

Route::post('locale/getLibelleMatiereclasseLocaleById', [ClasseController::class, 'getLibelleMatiereclasseLocaleById']);

Route::post('locale/AddNotelocale', [NotesController::class, 'AddNotelocale']);

Route::post('teacher/AddNote', [NotesController::class, 'AddNote']);


Route::post('teacher/getChapitreByMatiereAndclasse', [CahierController::class, 'getChapitreByMatiereAndclasse']);

Route::post('parent/sendMessageByParent', [MessageController::class, 'sendMessageByParent']);

Route::post('locale/sendMessage', [MessageController::class, 'sendMessage']);

Route::post('locale/getMessageSendByParents', [MessageController::class, 'getMessageSendByParents']);

Route::post('teacher/createDevoir', [DevoirsController::class, 'createDevoir']);

Route::post('teacher/createCahier', [CahierController::class, 'createCahier']);

Route::post('teacher/createCours', [CoursController::class, 'createCours']);


Route::post('teacher/createQuizz', [QuizzController::class, 'createQuizz']);

Route::post('teacher/createSyllabus', [SyllabusController::class, 'createSyllabus']);




// RECUPERER LA BOITE D"ENVOI DE L"ADMIN

Route::post('locale/getMessageEnvoyes', [MessageController::class, 'getMessageEnvoyes']);


Route::post('locale/getMessageEnvoyesParent', [MessageController::class, 'getMessageEnvoyesParent']);

/*   ROUTES POUR LES ELEVES    */

// Recuperer un parent grace a son telephone

Route::post('locale/SearchParent', [StudentController::class, 'SearchParent']);

Route::post('locale/updateMoyenne', [MoyennesController::class, 'updateMoyenne']);

Route::post('locale/updateNoteTrimestre', [MoyennesController::class, 'updateNoteTrimestre']);

Route::post('caisse/addAutreversement', [VersementsController::class, 'addAutreversement']);


// INCRIRE UN ELEVE

Route::post('locale/inscripEleve', [StudentController::class, 'inscripEleve']);

Route::post('locale/getEntressAutre', [BankController::class, 'getEntressAutre']);

Route::post('caisse/addVersementBanque', [BankController::class, 'addVersementBanque']);

Route::post('caisse/retraitBanque', [BankController::class, 'retraitBanque']);


Route::post('caisse/delateBanque', [BankController::class, 'delateBanque']);



Route::post('locale/getEntressAutre2', [VersementsController::class, 'getEntressAutre2']);

// Route::post('local/sms', [SmsController::class, 'sendTw']);


Route::post('local/sms', [SmsController::class, 'sendCmr']);

Route::post('locale/updateinscripEleve', [StudentController::class, 'updateinscripEleve']);


Route::get('locale/index2/{id}', [PdfController::class, 'index']);

Route::get('locale/listeprof/{id}', [PdfController::class, 'listeprof']);

Route::get('locale/listerelenote/{id}', [PdfController::class, 'listerelenote']);



Route::get('locale/generateListeProf', [PdfController::class, 'generateListeProf']);

Route::get('locale/generateficheNotePdf/{id}', [PdfController::class, 'generateficheNotePdf']);


Route::get('locale/getEleveCniPdf/{id}', [PdfController::class, 'getEleveCniPdf']);


Route::get('teacher/generateSyllabusPdf/{id}', [PdfController::class, 'generateSyllabusPdf']);


Route::get('teacher/generateBooktextePdf/{id}', [PdfController::class, 'generateBooktextePdf']);


Route::get('locale/getEmploiTempPdf/{id}', [PdfController::class, 'getEmploiTempPdf']);


Route::get('locale/getAllBulletinEval/{id}', [PdfController::class, 'getAllBulletinEval']);

Route::get('locale/getAllBulletinEval2/{id}', [PdfController::class, 'getAllBilan']);

Route::get('locale/getAllBulletinEval3/{id}', [PdfController::class, 'getAllBilanClasse']);

Route::get('locale/getAllBulletinEval4/{id}', [PdfController::class, 'getAllBilanClasseNonSaisie']);


Route::get('locale/getAllstatresult/{id}', [PdfController::class, 'getAllstatresult']);

Route::get('locale/getAllstatresultmeilleur/{id}', [PdfController::class, 'getAllstatresultmeilleur']);


Route::get('locale/getAllstatresultmeilleurAnnuel', [PdfController::class, 'getAllstatresultmeilleurAnnuel']);


Route::get('locale/getAllBourse', [PdfController::class, 'getAllBourse']);


Route::get('locale/getAllTHAnnuel', [PdfController::class, 'getAllTHAnnuel']);





Route::get('locale/getAllBulletinAnnuelle/{id}', [PdfController::class, 'getAllBulletinAnnuelle']);

Route::get('locale/getAllBulletinExam/{id}', [PdfController::class, 'getAllBulletinExam']);

Route::get('locale/getAllBulletinExamTrimestre/{id}', [PdfController::class, 'getAllBulletinExamTrimestre']);


Route::get('locale/getAllProfilTrimestre/{id}', [PdfController::class, 'getAllProfilTrimestre']);

Route::get('locale/getAllTBTrimestre/{id}', [PdfController::class, 'getAllTBTrimestre']);

Route::get('locale/getAllTBTrimestre2/{id}', [PdfController::class, 'getAllTBTrimestre2']);


Route::get('locale/getAllProcesVerbalTrimestre/{id}', [PdfController::class, 'getAllProcesVerbalTrimestre']);

Route::get('locale/getAllProcesVerbalTrimestre2/{id}', [PdfController::class, 'getAllProcesVerbalTrimestre2']);

Route::get('locale/getAllProcesVerbalAnnuel/{id}', [PdfController::class, 'getAllProcesVerbalAnnuel']);





// Recuperer tous les eleves d'une classe

Route::post('locale/getEleveclasse', [StudentController::class, 'getEleveclasse']);

Route::post('admin/getEleveclasse', [StudentController::class, 'getEleveclasseadmin']);

Route::post('locale/updatelibelle', [MatiereController::class, 'updatelibelle']);


Route::get('locale/getEleveclassePdf/{id}', [PdfController::class, 'getEleveclassePdf']);

Route::get('locale/getEleveclassePdf2/{id}', [PdfController::class, 'getEleveclassePdf2']);


Route::get('locale/getEleveclassePdf4/{id}', [PdfController::class, 'getEleveclassePdf4']);

Route::get('locale/getEleveclassePdf10', [PdfController::class, 'getEleveclassePdf10']);

Route::get('locale/getEleveclassePdf11', [PdfController::class, 'getEleveclassePdf11']);



Route::post('locale/getpermission', [EnseignantController::class, 'getpermission']);


Route::post('locale/getpermissionAll', [EnseignantController::class, 'getpermissionAll']);




// Route::get('locale/getEleveclassePdf/{id}', [PdfControlle::class, 'getEleveclassePdf']);


Route::get('locale/getAllCniPdf/{id}', [StudentController::class, 'getAllCniPdf']);

Route::get('locale/NonInsolvablesPdf/{id}', [PdfController::class, 'NonInsolvablesPdf']);

Route::get('locale/InsolvablesPdf/{id}', [PdfController::class, 'InsolvablesPdf']);

Route::get('locale/DemissionairePdf/{id}', [PdfController::class, 'DemissionairePdf']);



Route::get('locale/getEleveRecuPdf/{id}', [PdfController::class, 'getEleveRecuPdf']);


Route::get('locale/getSalaireRecuPdf/{id}', [PdfController::class, 'getSalaireRecuPdf']);

Route::get('locale/getSalairePersonnelRecuPdf/{id}', [PdfController::class, 'getSalairePersonnelRecuPdf']);

Route::get('locale/getSalaireAutreRecuPdf/{id}', [PdfController::class, 'getSalaireAutreRecuPdf']);

Route::get('caisse/getBilanJourRecuPdf/{id}', [PdfController::class, 'getBilanJourRecuPdf']);

Route::get('caisse/getBilanJourRecuPdf2/{id}', [PdfController::class, 'getBilanJourRecuPdf2']);


Route::get('caisse/getBulletinPdf/{id}', [NotesController::class, 'getBulletinPdf']);


Route::post('locale/delateClasse', [ClasseController::class, 'delateClasse']);

Route::post('locale/updateClasse', [ClasseController::class, 'updateClasse']);

Route::post('locale/updateMatiere', [MatiereController::class, 'updateMatiere']);

Route::post('locale/updatecahier', [CahierController::class, 'updatecahier']);


Route::post('locale/delateLibelle', [MatiereController::class, 'delateLibelle']);

Route::post('locale/delateTeacher', [EnseignantController::class, 'delateTeacher']);

Route::post('locale/delateParent', [ParentController::class, 'delateParent']);

Route::post('locale/delateAbsence', [AbsencesController::class, 'delateAbsence']);

Route::post('locale/updateAbsence', [AbsencesController::class, 'updateAbsence']);

Route::post('locale/updateCension', [DisciplineController::class, 'updateCension']);

Route::post('locale/delateCension', [DisciplineController::class, 'delateCension']);

Route::post('locale/getAdminHeure', [SalairesController::class, 'getAdminHeure']);

Route::post('locale/getEleveclasseFinances', [VersementsController::class, 'getEleveclasseFinances']);

Route::post('locale/getEleveclasseById', [StudentController::class, 'getEleveclasseById']);

Route::post('locale/getAbensesOfEleveclasseById', [AbsencesController::class, 'getAbensesOfEleveclasseById']);

Route::post('locale/getAbensesOfEleveclasseByParent', [AbsencesController::class, 'getAbensesOfEleveclasseByParent']);

Route::post('locale/getAbensesOfEleveclasseByEleve', [AbsencesController::class, 'getAbensesOfEleveclasseByEleve']);

// Recuperer tous les eleves d'une classe pour faure l'appel

Route::post('teacher/getStudentByTeacherForAppel', [StudentController::class, 'getStudentByTeacherForAppel']);

Route::post('teacher/getStudentByTeacherVoirNote', [NotesController::class, 'getStudentByTeacherVoirNote']);


/* ROUTES POUR LES ENSEIGNANTS */

// Recuperer les emplois du temps de chaque enseigant

Route::post('locale/getAllTimetableTeacher', [ClasseController::class, 'getAllTimetableTeacher']);

//   Route::post('parent/getAllTimetableByParent', [ClasseController::class, 'getAllTimetableByParent']);

// Recuperer toutes les infos de cet enseigants avec ses classes

Route::post('locale/getInfosTeacher', [EnseignantController::class, 'getInfosTeacher']);

Route::post('teacher/delateDevoir', [DevoirsController::class, 'delateDevoir']);


Route::get('locale/listepourpaiement/{id}', [PDFController::class, 'listepourpaiement']);

// Recuperer toutes les classes d'un enseignant listepourpaiement

Route::post('teacher/getAllClasseOfTeacher', [ClasseController::class, 'getAllClasseOfTeacher']);

Route::post('teacher/getAcllasseTeacher', [ClasseController::class, 'getAcllasseTeacher']);

Route::post('locale/getAllDevoirsLocal', [DevoirsController::class, 'getAllDevoirsLocal']);

Route::post('locale/getAllQuizzLocal', [QuizzController::class, 'getAllQuizzLocal']);

Route::post('locale/getAllSurveillant', [CaisseController::class, 'getAllSurveillant']);

Route::post('locale/affecterSurveillant', [CaisseController::class, 'affecterSurveillant']);

Route::post('locale/affecterSurveillant2', [CaisseController::class, 'affecterSurveillant2']);

Route::post('locale/getAllCahiersLocal', [CahierController::class, 'getAllCahiersLocal']);

Route::post('locale/getAllCoursLocal', [CoursController::class, 'getAllCoursLocal']);

Route::post('locale/getAllCoursLocalParClasse', [CoursController::class, 'getAllCoursLocalParClasse']);

Route::post('parent/getAllDevoirsParentParClasse', [DevoirsController::class, 'getAllDevoirsParentParClasse']);

Route::post('parent/getAllQuizzParentParClasse', [QuizzController::class, 'getAllQuizzParentParClasse']);


Route::post('locale/getAllQuizzLocalParClasse', [QuizzController::class, 'getAllQuizzLocalParClasse']);

Route::post('parent/getDetailsCahierTexte', [CahierController::class, 'getDetailsCahierTexte']);

Route::post('parent/getAllCahierParentParClasse', [CahierController::class, 'getAllCahierParentParClasse']);

Route::post('parent/getAllCoursParentParClasse', [CoursController::class, 'getAllCoursParentParClasse']);

Route::post('locale/getAllDevoirsLocalParClasse', [DevoirsController::class, 'getAllDevoirsLocalParClasse']);

Route::post('locale/getAllCahiersLocalParClasse', [CahierController::class, 'getAllCahiersLocalParClasse']);

Route::post('teacher/getAllDevoirsTeacher', [DevoirsController::class, 'getAllDevoirsTeacher']);

Route::post('teacher/getAllCahierByATeacher', [CahierController::class, 'getAllCahierByATeacher']);

Route::post('teacher/getAllCoursByATeacher', [CoursController::class, 'getAllCoursByATeacher']);

Route::post('teacher/getAllQuizzByATeacher', [QuizzController::class, 'getAllQuizzByATeacher']);

Route::post('teacher/getAllSyllabusByATeacher', [SyllabusController::class, 'getAllSyllabusByATeacher']);

Route::post('teacher/getAllCahierNewByATeacher', [CahierTexteController::class, 'getAllCahierNewByATeacher']);

Route::post('teacher/updateDevoirsTeacher', [DevoirsController::class, 'updateDevoirsTeacher']);

Route::post('teacher/getAllHeures', [DevoirsController::class, 'getAllHeures']);

Route::post('teacher/updateQuizz', [QuizzController::class, 'updateQuizz']);

Route::post('teacher/delateQuizz', [QuizzController::class, 'delateQuizz']);

Route::post('teacher/delateSyllabus', [SyllabusController::class, 'delateSyllabus']);

Route::post('teacher/delateNewBook', [CahierController::class, 'delateNewBook']);

Route::post('teacher/createCahierTexte', [CahierTexteController::class, 'createCahierTexte']);

Route::post('teacher/updateCahierTeacher', [CahierController::class, 'updateCahierTeacher']);

Route::post('teacher/delateCahierTeacher', [CahierController::class, 'delateteCahierTeacher']);

Route::post('teacher/updateCoursTeacher', [CoursController::class, 'updateCoursTeacher']);

Route::post('teacher/delateCoursTeacher', [CoursController::class, 'delateCoursTeacher']);


Route::post('teacher/posterCorrectionDevoirsTeacher', [DevoirsController::class, 'posterCorrectionDevoirsTeacher']);

// Recuperer tous les classes d'un enseignant avec les eleves a l'interieur

Route::post('teacher/getAllasseByATeacher', [ClasseController::class, 'getAllasseByATeacher']);

Route::post('teacher/getEploiTempsTeacherForAclasse', [EnseignantController::class, 'getEploiTempsTeacherForAclasse']);


// Recuperes les eleves  des classes par un enseignants (ses classes )

Route::post('locale/getEleveclasseByTeacher', [EnseignantController::class, 'getEleveclasseByTeacher']);

Route::post('locale/getAllMois', [EnseignantController::class, 'getAllMois']);

Route::post('locale/getEleveclasseByTeacher', [EnseignantController::class, 'getEleveclasseByTeacher']);

// Recuperes les info eleve et son parent dans le compte local

Route::post('locale/getEleveAndParentInfos', [StudentController::class, 'getEleveAndParentInfos']);

// Recuperes les info eleve et son parent dans le compte teacher

Route::post('teacher/getEleveAndParentInfosTeacher', [StudentController::class, 'getEleveAndParentInfosTeacher']);


Route::post('eleve/getEleveInfos', [StudentController::class, 'getEleveInfos']);



Route::get('/', [AuthController::class, 'start']);


Route::post('/upload-photo', [StudentController::class, 'upload']);

Route::post('locale/Addcycle', [ClasseController::class, 'Addcycle']);
Route::post('locale/cycle', [ClasseController::class, 'Getcycle']);








// });





// Route::post('/login', [UserController::class, 'login']);

// Route::get('/login', [UserController::class, 'index']);
