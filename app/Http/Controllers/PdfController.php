<?php

namespace App\Http\Controllers;

use DateTime;
use Fpdf\Fpdf;
use App\Models\User;
use App\Models\Books;
use App\Models\Heure;
use App\Models\Jours;
use App\Models\Notes;
use App\Models\caisse;
use App\Models\Classe;
use App\Models\config;
use App\Models\Matiere;
use App\Models\Parents;
use App\Models\Session;
use App\Models\Student;
use App\Models\Syllabs;
use App\Models\Matieres;
use App\Models\Moyennes;
use App\Models\salaires;
use App\Models\Presences;
use App\Models\Trimestre;
use App\Models\discipline;
use App\Models\tabletimes;
use App\Models\Versements;
use App\Models\Enseignants;
use App\Models\Evaluations;
use App\Models\partiebooks;
use App\Models\noteAnnuelle;
use Illuminate\Http\Request;
use App\Models\Etablissement;
use App\Models\MoyenneAnnuelle;
use App\Models\NotesTrimestres;
use App\Models\MoyenneTrimestres;
use SimpleSoftwareIO\QrCode\Facades\QrCode;



class PdfController extends Controller

{
    protected $fpdf;

    public function __construct()

    {
        $this->fpdf = new Fpdf;
    }


    public function listepourpaiement($id)

    {

        // Je recupere le codeEtab, la session et l'id de la classe




        $conf = config::first();

        $entete = $conf->header;


        $session = Session::where('encours_sess', 1)->first();

        $sessionEncour = $session->libelle_sess;



        $classes =   Classe::with('eleves')->where('id', $id)->get();


        foreach ($classes as $classe) {


            $this->fpdf->AddPage(
                "P",
                ['297', '210']
            );

            $this->fpdf->Image(public_path("/Photos/Logos/" . $entete), 10, 3, 190, 32,  "");


            $this->fpdf->SetFont('Arial', 'B', 10);


            $this->fpdf->Cell(0, 70, utf8_decode(" ANNEE ACADEMIQUE : $sessionEncour  "  . "SCHOOL YEAR"), 0, 0, 'C');
            $this->fpdf->SetFont('Arial', 'B', 20);
            $this->fpdf->Text(15, 62, utf8_decode("FICHE DE RENSEIGNEMENT / INFORMATION SHEET "), 0, 0, 'C');
            $this->fpdf->SetFont('Arial', 'B', 10);





            $this->fpdf->Text(15, 180, 'NOMS DE L\'ELEVE : ', 1, 0, 'C', 1);

            $this->fpdf->Text(15, 190, 'Sexe', 1, 0, 'C', 1);

            $this->fpdf->Text(15, 200, 'Date de  naissance', 1, 0, 'C', 1);







            // $this->fpdf->Ln();

            // $taille = 10;


            // foreach ($classe->eleves as $key => $student) {



            //     $this->fpdf->SetX(2);
            //     $this->fpdf->Cell(10, 10,
            //         $key + 1,
            //         1,
            //         0,
            //         'C'
            //     );
            //     $this->fpdf->SetFont('Arial', 'B', 9);
            //     $this->fpdf->Cell(117, $taille, utf8_decode($student->nom . " " . $student->prenom), 1, 0, 'L');
            //     $this->fpdf->Cell(10, $taille, utf8_decode($student->sexe), 1, 0,
            //         'C'
            //     );
            //     $this->fpdf->Cell(35, $taille, utf8_decode($student->dateNaiss), 1, 0, 'C');
            //     $this->fpdf->Cell(35, $taille, utf8_decode(substr(($student->lieuNaiss), 0, 15)), 1, 0, 'C');




            //     $this->fpdf->SetTextColor('0', '0', '0');


            //     $this->fpdf->Ln($taille);
            // }
        }





        $this->fpdf->Output();



        exit;
    }

    public function getEleveclassePdf10()

    {

        // Je recupere le codeEtab, la session et l'id de la classe



        $conf = config::first();

        $entete = $conf->header;


        $session = Session::where('encours_sess', 1)->first();

        $sessionEncour = $session->libelle_sess;

        // $classes = Classe::with(['eleves' => function ($query) {
        //     $query->orderBy('nom')->orderBy('prenom');
        // }])->get();


        $classes =   Classe::with(['eleves' => function ($query) {
            $query->where('statut', '!=', 3)->orderBy('nom')->orderBy('prenom');
        }])->get();


        foreach ($classes as $classe) {


            $this->fpdf->AddPage("P", ['297', '210']);

            $this->fpdf->Image(public_path("/Photos/Logos/" . $entete), 0, 0, 210, 37,  "");


            $this->fpdf->SetFont('Arial', 'B', 12);


            $this->fpdf->Cell(0, 70, utf8_decode(" ANNEE ACADEMIQUE : $sessionEncour  "), 0, 0, 'C');
            $this->fpdf->SetFont('Arial', 'B', 20);
            $this->fpdf->Text(10, 62, utf8_decode(" LISTE DES ELEVES EN CLASSE DE : $classe->libelleClasse => " . " " . count($classe->eleves)), 0, 0, 'C');
            $this->fpdf->SetFont('Arial', 'B', 10);

            $this->fpdf->Text(40, 72, utf8_decode(" Rapport  automatiquement  par l'application le :  " . date('j/m/Y  H:i:s')), 0, 'C', 1);


            $this->fpdf->SetY(20);

            $this->fpdf->SetFont('Arial', 'B', 10);

            $this->fpdf->SetXY(2, 80);

            $this->fpdf->SetDrawColor(0, 0, 0);
            $this->fpdf->SetFillColor('159', '159', '159');
            $this->fpdf->SetTextColor('0', '0', '0');
            $this->fpdf->Cell(10, 10, '', 1, 0, 'C', 1);
            $this->fpdf->Cell(100, 10, 'NOMS ET PRENOMS', 1, 0, 'C', 1);

            $this->fpdf->Cell(10, 10, 'Sexe', 1, 0, 'C', 1);

            $this->fpdf->Cell(35, 10, 'Date de  naissance', 1, 0, 'C', 1);

            $this->fpdf->Cell(35, 10, 'Lieu de naissance', 1, 0, 'C', 1);

            $this->fpdf->Cell(17, 10, 'Statut', 1, 0, 'C', 1);




            $this->fpdf->Ln();

            $taille = 10;


            foreach ($classe->eleves as $key => $student) {



                $this->fpdf->SetX(2);
                $this->fpdf->Cell(10, 10, $key + 1, 1, 0, 'C');
                $this->fpdf->SetFont('Arial', 'B', 9);
                $this->fpdf->Cell(100, $taille, utf8_decode($student->nom . " " . $student->prenom), 1, 0, 'L');
                $this->fpdf->Cell(10, $taille, utf8_decode($student->sexe), 1, 0, 'C');
                $this->fpdf->Cell(35, $taille, utf8_decode($student->dateNaiss), 1, 0, 'C');
                $this->fpdf->Cell(35, $taille, utf8_decode(substr(($student->lieuNaiss), 0, 15)), 1, 0, 'C');

                if ($student->statut == 2) {


                    $this->fpdf->SetTextColor('0', '60', '0');


                    $this->fpdf->Cell(
                        17,
                        $taille,
                        utf8_decode("En regle"),
                        1,
                        'C'
                    );
                }



                if ($student->statut == 0) {


                    $this->fpdf->SetTextColor('237', '28', '36');


                    $this->fpdf->Cell(
                        17,
                        $taille,
                        utf8_decode("Insolvable"),
                        1,
                        'C'
                    );
                }


                $this->fpdf->SetTextColor('0', '0', '0');


                $this->fpdf->Ln($taille);
            }
        }


        // Recuperer les eleves d'une classes, on couple avec la table user pour pouvoir recuperer les photos

        $this->fpdf->Output();
        exit;
    }

    public function getEleveclassePdf11()

    {

        // Je recupere le codeEtab, la session et l'id de la classe



        $conf = config::first();

        $entete = $conf->header;


        $session = Session::where('encours_sess', 1)->first();

        $sessionEncour = $session->libelle_sess;

        // $classes = Classe::with(['eleves' => function ($query) {
        //     $query->orderBy('nom')->orderBy('prenom');
        // }])->get();


        $classes =   Classe::with(['eleves' => function ($query) {
            $query->where('statut', 2)->orderBy('nom')->orderBy('prenom');
        }])->get();


        foreach ($classes as $classe) {


            $this->fpdf->AddPage("P", ['297', '210']);

            $this->fpdf->Image(public_path("/Photos/Logos/" . $entete), 0, 0, 210, 37,  "");


            $this->fpdf->SetFont('Arial', 'B', 12);


            $this->fpdf->Cell(0, 70, utf8_decode(" ANNEE ACADEMIQUE : $sessionEncour  "), 0, 0, 'C');
            $this->fpdf->SetFont('Arial', 'B', 20);
            $this->fpdf->Text(10, 62, utf8_decode("LISTE DES ELEVES EN REGLE : $classe->libelleClasse => " . " " . count($classe->eleves)), 0, 0, 'C');
            $this->fpdf->SetFont('Arial', 'B', 10);

            $this->fpdf->Text(40, 72, utf8_decode(" Rapport  automatiquement  par l'application le :  " . date('j/m/Y  H:i:s')), 0, 'C', 1);


            $this->fpdf->SetY(20);

            $this->fpdf->SetFont('Arial', 'B', 10);

            $this->fpdf->SetXY(2, 80);

            $this->fpdf->SetDrawColor(0, 0, 0);
            $this->fpdf->SetFillColor('159', '159', '159');
            $this->fpdf->SetTextColor('0', '0', '0');
            $this->fpdf->Cell(10, 10, '', 1, 0, 'C', 1);
            $this->fpdf->Cell(117, 10, 'NOMS ET PRENOMS', 1, 0, 'C', 1);

            $this->fpdf->Cell(10, 10, 'Sexe', 1, 0, 'C', 1);

            $this->fpdf->Cell(35, 10, 'Date de  naissance', 1, 0, 'C', 1);

            $this->fpdf->Cell(35, 10, 'Lieu de naissance', 1, 0, 'C', 1);





            $this->fpdf->Ln();

            $taille = 10;


            foreach ($classe->eleves as $key => $student) {



                $this->fpdf->SetX(2);
                $this->fpdf->Cell(10, 10, $key + 1, 1, 0, 'C');
                $this->fpdf->SetFont('Arial', 'B', 9);
                $this->fpdf->Cell(117, $taille, utf8_decode($student->nom . " " . $student->prenom), 1, 0, 'L');
                $this->fpdf->Cell(10, $taille, utf8_decode($student->sexe), 1, 0, 'C');
                $this->fpdf->Cell(35, $taille, utf8_decode($student->dateNaiss), 1, 0, 'C');
                $this->fpdf->Cell(35, $taille, utf8_decode(substr(($student->lieuNaiss), 0, 15)), 1, 0, 'C');




                $this->fpdf->SetTextColor('0', '0', '0');


                $this->fpdf->Ln($taille);
            }
        }


        // Recuperer les eleves d'une classes, on couple avec la table user pour pouvoir recuperer les photos

        $this->fpdf->Output();
        exit;
    }



    public function getAllstatresultmeilleur($id)
    {

        $idTrim = $id;



        $conf = config::first();

        $entete = $conf->header;


        $session = Session::where('encours_sess', 1)->first();

        $sessionEncour = $session->libelle_sess;



        $tailletext = 9;

        $tailleLongCell = 8;

        $nbr = 0;

        $this->fpdf->AddPage("P", ['290', '210']);


        $this->fpdf->SetFont('Arial', 'B', 15);

        $this->fpdf->Image(public_path("/Photos/Logos/" . $entete), 5, 3, 205, 35, "");

        $this->fpdf->SetFont('Arial', 'B', 20);


        $session = Session::where('encours_sess', 1)->first();

        $sessionEncour = $session->libelle_sess;


        $etabs = Etablissement::first();

        $etabsLabel = $etabs->libelleEtab;

        $this->fpdf->Text(50, 52, utf8_decode("PERFORMANCE DU TRIMESTRE $id "), 0, 'C', 1);


        $this->fpdf->SetFont('Arial', 'B', 10);


        $this->fpdf->Text(83, 60, utf8_decode("ANNEE-SCOLAIRE :  $sessionEncour"), 0, 'C', 1);

        $this->fpdf->SetFont('Arial', 'B', 15);


        $this->fpdf->Text(63, 75, utf8_decode("PERFORMANCES GENERALES "), 0, 'C', 1);



        $alls = Student::where('statut', '!=', 3)->get();

        $nbreMarks = MoyenneTrimestres::where('trimestre_id', $id)->get();

        $nbrePassed = MoyenneTrimestres::where('trimestre_id', $id)->where('valeur', '>=', 10)->get();

        $percentpassed = (count($nbrePassed) / count($alls)) * 100;


        $this->fpdf->SetFont('Arial', 'B', 10);
        $classes = Classe::orderBy('libelleClasse', 'ASC')->get();

        $this->fpdf->Text(83, 85, utf8_decode("REUISSITE :  " . '' . round($percentpassed, 2) . ' % '), 0, 'C', 1);


        $this->fpdf->Text(83, 90, utf8_decode("ECHEC :  " . '' . (100 - round($percentpassed, 2) . ' % ')), 0, 'C', 1);


        $this->fpdf->SetFont('Arial', 'B', 15);

        $this->fpdf->Text(61, 105, utf8_decode("MEILLEUR (E) DE L'ETABLISSEMENT "), 0, 'C', 1);



        // MEILLEURE FILLE DU LYCEE


        $moyenne = MoyenneTrimestres::join('students', 'moyenne_trimestres.student_id', '=', 'students.id')
            ->where('students.sexe', 'F')
            ->where('trimestre_id', $id)
            ->max('valeur');
        $eleve = MoyenneTrimestres::with('student', 'classe')->where('valeur', $moyenne)->first();

        $this->fpdf->SetFont('Arial', 'B', 10);

        $this->fpdf->SetXY(25, 120);
        $this->fpdf->SetFillColor('159', '159', '159');
        $this->fpdf->SetTextColor('0', '0', '0');
        $this->fpdf->Cell(80, 5, 'FILLE', 1, 0, 'C', 1);
        $this->fpdf->Cell(80, 5, utf8_decode('GARÇON'), 1, 0, 'C', 1);


        $this->fpdf->Ln();
        $this->fpdf->SetX(25);
        $this->fpdf->Cell(80, 8, utf8_decode("" . $eleve->student->nom . " " . $eleve->student->prenom), 1, 0, 'C', 0);
        $this->fpdf->Cell(80, 8, utf8_decode("" . $eleve->student->nom . " " . $eleve->student->prenom), 1, 0, 'C', 0);


        $this->fpdf->Ln(8);
        $this->fpdf->SetX(25);
        $this->fpdf->Cell(80, 8, utf8_decode($eleve->student->clase->libelleClasse), 1, 0, 'C', 0);
        $this->fpdf->Cell(80, 8, '', 1, 0, 'C', 0);

        $this->fpdf->Ln(8);
        $this->fpdf->SetX(25);
        $this->fpdf->Cell(80, 8, '', 1, 0, 'C', 0);
        $this->fpdf->Cell(80, 8, '', 1, 0, 'C', 0);




        // $this->fpdf->Text(23, 88, utf8_decode("FILLE : " . $eleve->student->nom . " " . $eleve->student->prenom) . " :  " .  utf8_decode($moyenne . " / 20 " . '') . " , " . utf8_decode($eleve->classe->libelleClasse), 0, 'C', 1);


        // $moyenne = MoyenneTrimestres::join('students', 'moyenne_trimestres.student_id', '=', 'students.id')
        //     ->where('students.sexe', 'M')
        //     ->where('trimestre_id', $id)
        //     ->max('valeur');

        // $eleve = MoyenneTrimestres::with('student', 'classe')->where('valeur', $moyenne)->first();

        // $this->fpdf->SetFont('Arial', 'B', 10);


        // $this->fpdf->Text(23, 95, utf8_decode(" GARÇON :  " . $eleve->student->nom . " " . $eleve->student->prenom) . " :  " .  utf8_decode($moyenne . " / 20 ") . " , " . utf8_decode($eleve->classe->libelleClasse), 0, 'C', 1);





        // $this->fpdf->SetFont('Arial', 'B', 15);


        // $this->fpdf->Text(23, 105, utf8_decode("SECTEUR STT"), 0, 'C', 1);






        // $valeurMax1 = MoyenneTrimestres::join('students', 'moyenne_trimestres.student_id', '=', 'students.id')
        //     ->where('students.sexe', 'F')
        //     ->where('trimestre_id', $id)
        //     ->join('classes', 'moyenne_trimestres.classe_id', '=', 'classes.id')
        //     ->where('classes.statutClasse', 1)

        //     ->max('valeur');

        // $valeurMax2 = MoyenneTrimestres::join('students', 'moyenne_trimestres.student_id', '=', 'students.id')
        //     ->where('students.sexe', 'F')
        //     ->where('trimestre_id', $id)
        //     ->join('classes', 'moyenne_trimestres.classe_id', '=', 'classes.id')
        //     ->where('classes.statutClasse', 2)

        //     ->max('valeur');


        // $MaxFille = max($valeurMax1, $valeurMax2);


        // $eleve = MoyenneTrimestres::with('student', 'classe')->where('valeur', $MaxFille)->first();

        // $this->fpdf->SetFont('Arial', 'B', 10);


        // $this->fpdf->Text(23, 115, utf8_decode(" FILLE : " . $eleve->student->nom . " " . $eleve->student->prenom) . " :  " .  utf8_decode($moyenne . " / 20 ") . " , " . utf8_decode($eleve->classe->libelleClasse), 0, 'C', 1);


        // $this->fpdf->SetFont('Arial', 'B', 15);


        // $valeurMax1 = MoyenneTrimestres::join('students', 'moyenne_trimestres.student_id', '=', 'students.id')
        //     ->where('students.sexe', 'M')
        //     ->where('trimestre_id', $id)
        //     ->join('classes', 'moyenne_trimestres.classe_id', '=', 'classes.id')
        //     ->where('classes.statutClasse', 1)

        //     ->max('valeur');

        // $valeurMax2 = MoyenneTrimestres::join('students', 'moyenne_trimestres.student_id', '=', 'students.id')
        //     ->where('students.sexe', 'M')
        //     ->where('trimestre_id', $id)
        //     ->join('classes', 'moyenne_trimestres.classe_id', '=', 'classes.id')
        //     ->where('classes.statutClasse', 2)

        //     ->max('valeur');


        // $ManGarcon = max($valeurMax1, $valeurMax2);

        // $eleve = MoyenneTrimestres::with('student', 'classe')->where('valeur', $ManGarcon)->first();


        // $this->fpdf->SetFont('Arial', 'B', 10);


        // $this->fpdf->Text(23, 122, utf8_decode("GARÇON : " . $eleve->student->nom . " " . $eleve->student->prenom) . " :  " .  utf8_decode($ManGarcon . " / 20 ") . " , " . utf8_decode($eleve->classe->libelleClasse), 0, 'C', 1);





        // $this->fpdf->SetFont('Arial', 'B', 15);


        // $this->fpdf->Text(23, 135, utf8_decode("SECTEUR INDUSTRIEL"), 0, 'C', 1);



        // // $moyenne = MoyenneTrimestres::join('students', 'moyenne_trimestres.student_id', '=', 'students.id')

        // //     ->where('students.sexe', 'F')

        // //     ->join('classes', 'moyenne_trimestres.classe_id', '=', 'classes.id')

        // //     ->where('classes.statutClasse', 3)
        // //     ->Orwhere('classes.statutClasse', 4)

        // //     ->max('valeur');


        // $valeurMax1 = MoyenneTrimestres::join('students', 'moyenne_trimestres.student_id', '=', 'students.id')
        //     ->where('students.sexe', 'F')
        //     ->where('trimestre_id', $id)
        //     ->join('classes', 'moyenne_trimestres.classe_id', '=', 'classes.id')
        //     ->where('classes.statutClasse', 3)

        //     ->max('valeur');

        // $valeurMax2 = MoyenneTrimestres::join('students', 'moyenne_trimestres.student_id', '=', 'students.id')
        //     ->where('students.sexe', 'F')
        //     ->where('trimestre_id', $id)
        //     ->join('classes', 'moyenne_trimestres.classe_id', '=', 'classes.id')
        //     ->where('classes.statutClasse', 4)

        //     ->max('valeur');


        // $Max = max($valeurMax1, $valeurMax2);


        // $eleve = MoyenneTrimestres::with('student', 'classe')->where('valeur', $Max)->first();

        // $this->fpdf->SetFont('Arial', 'B', 10);


        // $this->fpdf->Text(23, 145, utf8_decode(" FILLE : " . $eleve->student->nom . " " . $eleve->student->prenom) . " :  " .  utf8_decode($Max . " / 20 ") . " , " . utf8_decode($eleve->classe->libelleClasse), 0, 'C', 1);


        // $valeurMax1 = MoyenneTrimestres::join('students', 'moyenne_trimestres.student_id', '=', 'students.id')
        //     ->where('students.sexe', 'M')
        //     ->where('trimestre_id', $id)
        //     ->join('classes', 'moyenne_trimestres.classe_id', '=', 'classes.id')
        //     ->where('classes.statutClasse', 3)

        //     ->max('valeur');

        // $valeurMax2 = MoyenneTrimestres::join('students', 'moyenne_trimestres.student_id', '=', 'students.id')
        //     ->where('students.sexe', 'M')
        //     ->where('trimestre_id', $id)
        //     ->join('classes', 'moyenne_trimestres.classe_id', '=', 'classes.id')
        //     ->where('classes.statutClasse', 4)

        //     ->max('valeur');


        // $Max = max($valeurMax1, $valeurMax2);



        // $eleve = MoyenneTrimestres::with('student', 'classe')->where('valeur',   $Max)->first();

        // $this->fpdf->SetFont('Arial', 'B', 10);


        // $this->fpdf->Text(23, 152, utf8_decode("GARÇON : " . $eleve->student->nom . " " . $eleve->student->prenom) . " :  " .  utf8_decode($moyenne . " / 20 ") . " , " . utf8_decode($eleve->classe->libelleClasse), 0, 'C', 1);



        // $this->fpdf->SetFont('Arial', 'B', 15);


        // $this->fpdf->Text(23, 165, utf8_decode("SPECIALITE : ESCOM / CG "), 0, 'C', 1);


        // $tabs = [75, 76, 77, 78, 83, 84, 115, 85];
        // $moys = [];


        // foreach ($tabs as $key => $tab) {


        //     $moys[$key] = MoyenneTrimestres::join('students', 'moyenne_trimestres.student_id', '=', 'students.id')

        //         ->where('students.sexe', 'F')
        //         ->where('trimestre_id', $id)
        //         ->join('classes', 'moyenne_trimestres.classe_id', '=', 'classes.id')
        //         ->where('classes.id', $tab)
        //         ->max('valeur');
        // }

        // $moyenne = max($moys);

        // $eleve = MoyenneTrimestres::with('student', 'classe')->where('valeur', $moyenne)->first();

        // $this->fpdf->SetFont('Arial', 'B', 10);

        // $this->fpdf->Text(23, 175, utf8_decode(" FILLE : " . $eleve->student->nom . " " . $eleve->student->prenom) . " :  " .  utf8_decode($moyenne . " / 20 ") . " , " . utf8_decode($eleve->classe->libelleClasse), 0, 'C', 1);


        // $moys = [];

        // foreach ($tabs as $key => $tab) {


        //     $moys[$key] = MoyenneTrimestres::join('students', 'moyenne_trimestres.student_id', '=', 'students.id')

        //         ->where('students.sexe', 'M')
        //         ->where('trimestre_id', $id)

        //         ->join('classes', 'moyenne_trimestres.classe_id', '=', 'classes.id')

        //         ->where('classes.id', $tab)
        //         ->max('valeur');
        // }


        // $moyenne = max($moys);

        // $eleve = MoyenneTrimestres::with('student', 'classe')->where('valeur', $moyenne)->first();

        // $this->fpdf->Text(23, 182, utf8_decode("GARÇON : " . $eleve->student->nom . " " . $eleve->student->prenom) . " :  " .  utf8_decode($moyenne . " / 20 ") . " , " . utf8_decode($eleve->classe->libelleClasse), 0, 'C', 1);




        // //  SPECILAITE ESF

        // $this->fpdf->SetFont('Arial', 'B', 15);


        // $this->fpdf->Text(23, 195, utf8_decode("SPECIALITE : ESF "), 0, 'C', 1);

        // $tabs = [79, 80, 81, 82, 84, 86, 87];
        // $moys = [];


        // foreach ($tabs as $key => $tab) {


        //     $moys[$key] = MoyenneTrimestres::join('students', 'moyenne_trimestres.student_id', '=', 'students.id')

        //         ->where('students.sexe', 'F')
        //         ->where('trimestre_id', $id)

        //         ->join('classes', 'moyenne_trimestres.classe_id', '=', 'classes.id')

        //         ->where('classes.id', $tab)
        //         ->max('valeur');
        // }



        // $moyenne = max($moys);

        // $eleve = MoyenneTrimestres::with('student', 'classe')->where('valeur', $moyenne)->first();

        // $this->fpdf->SetFont('Arial', 'B', 10);


        // $this->fpdf->Text(23, 205, utf8_decode(" FILLE : " . $eleve->student->nom . " " . $eleve->student->prenom) . " :  " .  utf8_decode($moyenne . " / 20 ") . " , " . utf8_decode($eleve->classe->libelleClasse), 0, 'C', 1);


        // $moys = [];


        // foreach ($tabs as $key => $tab) {


        //     $moys[$key] = MoyenneTrimestres::join('students', 'moyenne_trimestres.student_id', '=', 'students.id')

        //         ->where('students.sexe', 'M')
        //         ->where('trimestre_id', $id)

        //         ->join('classes', 'moyenne_trimestres.classe_id', '=', 'classes.id')

        //         ->where('classes.id', $tab)
        //         ->max('valeur');
        // }



        // $moyenne = max($moys);


        // $eleve = MoyenneTrimestres::with('student', 'classe')->where('valeur', $moyenne)->first();

        // $this->fpdf->Text(23, 212, utf8_decode(" GARÇON : " . $eleve->student->nom . " " . $eleve->student->prenom) . " :  " .  utf8_decode($moyenne . " / 20 ") . " , " . utf8_decode($eleve->classe->libelleClasse), 0, 'C', 1);




        // // MACO/f4



        // $this->fpdf->SetFont('Arial', 'B', 15);


        // $this->fpdf->Text(23, 225, utf8_decode("SPECIALITE : MACO / F4 "), 0, 'C', 1);

        // $tabs =
        //     [119, 120, 121, 122, 126, 127, 128];

        // $moys = [];

        // foreach ($tabs as $key => $tab) {


        //     $moys[$key] = MoyenneTrimestres::join('students', 'moyenne_trimestres.student_id', '=', 'students.id')

        //         ->where('students.sexe', 'F')
        //         ->where('trimestre_id', $id)
        //         ->join('classes', 'moyenne_trimestres.classe_id', '=', 'classes.id')
        //         ->where('classes.id', $tab)
        //         ->max('valeur');
        // }


        // $moyenne = max($moys);

        // $eleve = MoyenneTrimestres::with('student', 'classe')->where('valeur', $moyenne)->first();


        // $this->fpdf->SetFont('Arial', 'B', 10);


        // $this->fpdf->Text(23, 235, utf8_decode(" FILLE : " . $eleve->student->nom . " " . $eleve->student->prenom) . " :  " .  utf8_decode($moyenne . " / 20 ") . " , " . utf8_decode($eleve->classe->libelleClasse), 0, 'C', 1);



        // $moys = [];


        // foreach ($tabs as $key => $tab) {
        //     $moys[$key] = MoyenneTrimestres::join('students', 'moyenne_trimestres.student_id', '=', 'students.id')

        //         ->where('students.sexe', 'M')
        //         ->where('trimestre_id', $id)
        //         ->join('classes', 'moyenne_trimestres.classe_id', '=', 'classes.id')
        //         ->where('classes.id', $tab)
        //         ->max('valeur');
        // }


        // $moyenne = max($moys);


        // $eleve = MoyenneTrimestres::with('student', 'classe')->where('valeur', $moyenne)->first();

        // $this->fpdf->SetFont('Arial', 'B', 10);

        // $this->fpdf->Text(23, 243, utf8_decode(" GARÇON : " . $eleve->student->nom . " " . $eleve->student->prenom) . " :  " .  utf8_decode($moyenne . " / 20 ") . " , " . utf8_decode($eleve->classe->libelleClasse), 0, 'C', 1);


        // $this->fpdf->SetFont('Arial', 'B', 15);


        // // MENU

        // $this->fpdf->Text(23, 255, utf8_decode("SPECIALITE : MENU / AMEB "), 0, 'C', 1);

        // $tabs = [90, 91, 92, 105, 106, 107];

        // $moys = [];

        // foreach ($tabs as $key => $tab) {


        //     $moys[$key] = MoyenneTrimestres::join('students', 'moyenne_trimestres.student_id', '=', 'students.id')

        //         ->where('students.sexe', 'F')
        //         ->where('trimestre_id', $id)
        //         ->join('classes', 'moyenne_trimestres.classe_id', '=', 'classes.id')
        //         ->where('classes.id', $tab)
        //         ->max('valeur');
        // }

        // $moyenne = max($moys);

        // $eleve = MoyenneTrimestres::with('student', 'classe')->where('valeur', $moyenne)->first();


        // $this->fpdf->SetFont('Arial', 'B', 10);

        // if ($moyenne == null) {

        //     $this->fpdf->Text(23, 265, utf8_decode("AUCUNE FILLE DANS CETTE SPECIALITE"), 0, 'C', 1);
        // } else {
        //     $this->fpdf->Text(23, 265, utf8_decode(" FILLE : " . $eleve->student->nom . " " . $eleve->student->prenom) . " :  " .  utf8_decode($moyenne . " / 20 ") . " , " . utf8_decode($eleve->classe->libelleClasse), 0, 'C', 1);
        // }

        // $moys = [];

        // foreach ($tabs as $key => $tab) {

        //     $moys[$key] = MoyenneTrimestres::join('students', 'moyenne_trimestres.student_id', '=', 'students.id')

        //         ->where('students.sexe', 'M')
        //         ->where('trimestre_id', $id)
        //         ->join('classes', 'moyenne_trimestres.classe_id', '=', 'classes.id')
        //         ->where('classes.id', $tab)
        //         ->max('valeur');
        // }



        // $moyenne = max($moys);


        // $eleve = MoyenneTrimestres::with('student', 'classe')->where('valeur', $moyenne)->get()[1];



        // $this->fpdf->SetFont('Arial', 'B', 10);


        // $this->fpdf->Text(23, 272, utf8_decode("GARÇON : " . $eleve->student->nom . " " . $eleve->student->prenom) . " :  " .  utf8_decode($moyenne . " / 20 ") . " , " . utf8_decode($eleve->classe->libelleClasse), 0, 'C', 1);

        // $this->fpdf->AddPage("P", ['290', '210']);


        // // COME/IH sur la nouvele page    ATOUD



        // $this->fpdf->SetFont('Arial', 'B', 15);


        // $this->fpdf->Text(23, 20, utf8_decode("SPECIALITE : COME / IH "), 0, 'C', 1);


        // $moys = [];
        // $tabs = [101, 116, 117, 118, 123, 124, 125];

        // foreach ($tabs as $key => $tab) {

        //     $moys[$key] = MoyenneTrimestres::join('students', 'moyenne_trimestres.student_id', '=', 'students.id')

        //         ->where('students.sexe', 'F')
        //         ->where('trimestre_id', $id)
        //         ->join('classes', 'moyenne_trimestres.classe_id', '=', 'classes.id')
        //         ->where('classes.id', $tab)
        //         ->max('valeur');
        // }

        // $moyenne = max($moys);


        // $eleve = MoyenneTrimestres::with('student', 'classe')->where('valeur', $moyenne)->first();

        // $this->fpdf->SetFont('Arial', 'B', 10);


        // $this->fpdf->Text(23, 30, utf8_decode(" FILLE : " . $eleve->student->nom . " " . $eleve->student->prenom) . " :  " .  utf8_decode($moyenne . " / 20 ") . " , " . utf8_decode($eleve->classe->libelleClasse), 0, 'C', 1);


        // $moys = [];

        // foreach ($tabs as $key => $tab) {

        //     $moys[$key] = MoyenneTrimestres::join('students', 'moyenne_trimestres.student_id', '=', 'students.id')

        //         ->where('students.sexe', 'M')
        //         ->where('trimestre_id', $id)
        //         ->join('classes', 'moyenne_trimestres.classe_id', '=', 'classes.id')
        //         ->where('classes.id', $tab)
        //         ->max('valeur');
        // }



        // $moyenne = max($moys);

        // $eleve = MoyenneTrimestres::with('student', 'classe')->where('valeur', $moyenne)->first();

        // $this->fpdf->Text(23, 37, utf8_decode(" GARÇON : " . $eleve->student->nom . " " . $eleve->student->prenom) . " :  " .  utf8_decode($moyenne . " / 20 ") . " , " . utf8_decode($eleve->classe->libelleClasse), 0, 'C', 1);



        // // // MARE/MVT




        // $this->fpdf->SetFont('Arial', 'B', 15);


        // $this->fpdf->Text(23, 47, utf8_decode("SPECIALITE : CMA / MVT "), 0, 'C', 1);


        // $moys = [];
        // $tabs = [97, 102, 103, 104, 109, 110, 111];

        // foreach ($tabs as $key => $tab) {

        //     $moys[$key] = MoyenneTrimestres::join('students', 'moyenne_trimestres.student_id', '=', 'students.id')

        //         ->where('students.sexe', 'F')
        //         ->where('trimestre_id', $id)
        //         ->join('classes', 'moyenne_trimestres.classe_id', '=', 'classes.id')
        //         ->where('classes.id', $tab)
        //         ->max('valeur');
        // }

        // $moyenne = max($moys);


        // $eleve = MoyenneTrimestres::with('student', 'classe')->where('valeur', $moyenne)->first();

        // $this->fpdf->SetFont('Arial', 'B', 10);


        // $this->fpdf->Text(23, 59, utf8_decode(" FILLE : " . $eleve->student->nom . " " . $eleve->student->prenom) . " :  " .  utf8_decode($moyenne . " / 20 ") . " , " . utf8_decode($eleve->classe->libelleClasse), 0, 'C', 1);


        // $this->fpdf->SetFont('Arial', 'B', 10);

        // $moys = [];

        // foreach ($tabs as $key => $tab) {

        //     $moys[$key] = MoyenneTrimestres::join('students', 'moyenne_trimestres.student_id', '=', 'students.id')

        //         ->where('students.sexe', 'M')
        //         ->where('trimestre_id', $id)
        //         ->join('classes', 'moyenne_trimestres.classe_id', '=', 'classes.id')
        //         ->where('classes.id', $tab)
        //         ->max('valeur');
        // }

        // $moyenne = max($moys);

        // $eleve = MoyenneTrimestres::with('student', 'classe')->where('valeur', $moyenne)->first();

        // $this->fpdf->Text(23, 65, utf8_decode(" GARÇON : " . $eleve->student->nom . " " . $eleve->student->prenom) . " :  " .  utf8_decode($moyenne . " / 20 ") . " , " . utf8_decode($eleve->classe->libelleClasse), 0, 'C', 1);


        // // // F3


        // $this->fpdf->SetFont('Arial', 'B', 15);


        // $this->fpdf->Text(23, 80, utf8_decode("SPECIALITE : F3 / ELEQ "), 0, 'C', 1);


        // $moys = [];
        // $tabs = [93, 94, 95, 96, 112, 108, 113, 114];

        // foreach ($tabs as $key => $tab) {

        //     $moys[$key] = MoyenneTrimestres::join('students', 'moyenne_trimestres.student_id', '=', 'students.id')

        //         ->where('students.sexe', 'F')
        //         ->where('trimestre_id', $id)
        //         ->join('classes', 'moyenne_trimestres.classe_id', '=', 'classes.id')
        //         ->where('classes.id', $tab)
        //         ->max('valeur');
        // }

        // $moyenne = max($moys);


        // $eleve = MoyenneTrimestres::with('student', 'classe')->where('valeur', $moyenne)->first();
        // $this->fpdf->SetFont('Arial', 'B', 10);
        // $this->fpdf->Text(23, 90, utf8_decode(" FILLE : " . $eleve->student->nom . " " . $eleve->student->prenom) . " :  " .  utf8_decode($moyenne . " / 20 ") . " , " . utf8_decode($eleve->classe->libelleClasse), 0, 'C', 1);

        // $moys = [];


        // foreach ($tabs as $key => $tab) {

        //     $moys[$key] = MoyenneTrimestres::join('students', 'moyenne_trimestres.student_id', '=', 'students.id')

        //         ->where('students.sexe', 'M')
        //         ->where('trimestre_id', $id)
        //         ->join('classes', 'moyenne_trimestres.classe_id', '=', 'classes.id')
        //         ->where('classes.id', $tab)
        //         ->max('valeur');
        // }

        // $moyenne = max($moys);


        // $eleve = MoyenneTrimestres::with('student', 'classe')->where('valeur', $moyenne)->first();

        // $this->fpdf->SetFont('Arial', 'B', 10);


        // $this->fpdf->Text(23, 97, utf8_decode(" GARÇON : " . $eleve->student->nom . " " . $eleve->student->prenom) . " :  " .  utf8_decode($moyenne . " / 20 ") . " , " . utf8_decode($eleve->classe->libelleClasse), 0, 'C', 1);




        // $this->fpdf->SetFont('Arial', 'B', 15);







        $this->fpdf->Output();

        exit;
    }



    public function getAllstatresult($id)
    {

        $conf = config::first();

        $entete = $conf->header;





        $session = Session::where('encours_sess', 1)->first();

        $sessionEncour = $session->libelle_sess;



        $tailletext = 9;

        $tailleLongCell = 8;

        $nbr = 0;

        $this->fpdf->AddPage("L", ['290', '210']);


        $this->fpdf->Image(public_path("/Photos/Logos/" . $entete), 5, 3, 205, 35, "");

        $this->fpdf->SetFont('Arial', 'B', 15);

        $this->fpdf->Text(80, 45, utf8_decode("STATISTIQUE DES RESULTATS TRIMESTRIELS"), 0, 'C', 1);

        $this->fpdf->Text(77, 55, utf8_decode(" ( RESULTATS DES EVALUATIONS SOMMATIVES ) "), 0, 'C', 1);



        $session = Session::where('encours_sess', 1)->first();

        $sessionEncour = $session->libelle_sess;


        $etabs = Etablissement::first();

        $etabsLabel = $etabs->libelleEtab;

        $this->fpdf->Text(10, 70, utf8_decode("ETABLISSEMENT : " . $etabsLabel . " " . ",  TRIMESTRE " . $id . ", " . "  ANNEE-SCOLAIRE : " . $sessionEncour), 0, 'C', 1);


        $classes = Classe::orderBy('libelleClasse', 'ASC')->get();


        // $this->fpdf->Cell(10, $tailleLongCell, "No", 1, 0, 'C');

        $decalage = 80 + $tailleLongCell;

        $this->fpdf->SetY($decalage);


        foreach ($classes as $ley => $classe) {

            $this->fpdf->SetFont('Arial', 'B', $tailletext + 3);


            $this->fpdf->SetX(5);
            $this->fpdf->Cell(10, $tailleLongCell, $ley + 1, 1, 0, 'C');
            $this->fpdf->Cell(30, $tailleLongCell, utf8_decode($classe->libelleClasse), 1, 0, 'C');




            $this->fpdf->Ln($tailleLongCell);
        }



        $this->fpdf->Output();

        exit;
    }


    public function generateListeProf()

    {

        $conf = config::first();

        $entete = $conf->header;


        $tearchers = Enseignants::orderBy('nom', 'ASC')->orderBy('prenom', 'ASC')->get();


        $session = Session::where('encours_sess', 1)->first();

        $sessionEncour = $session->libelle_sess;



        $tailletext = 9;

        $tailleLongCell = 8;

        $nbr = 0;

        $this->fpdf->AddPage("P", ['290', '210']);


        $this->fpdf->SetFont('Arial', 'B', 15);

        $this->fpdf->Image(public_path("/Photos/Logos/" . $entete), 3, 3, 205, 30, "");

        $this->fpdf->SetFont('Arial', 'B', 25);
        $this->fpdf->SetTextColor('35', '107', '153');
        $this->fpdf->Text(55, 52, utf8_decode("LISTE DES ENSEIGNANTS"), 0, 'C', 1);


        $this->fpdf->SetFont('Arial', 'B', 8);

        $this->fpdf->SetTextColor('0', '0', '0');

        $this->fpdf->Text(85, 62, utf8_decode("ANNEE-SCOLAIRE :  $sessionEncour "), 0, 'C', 1);






        $this->fpdf->SetTextColor('0', '0', '0');

        $this->fpdf->SetFont('Arial', 'B', 10);

        $this->fpdf->SetFillColor('166', '166', '166');

        $this->fpdf->SetXY(3, 70);


        //Noms liste

        $this->fpdf->Cell(10, $tailleLongCell, utf8_decode('Nº'), 1, 0, 'C', 1);

        $this->fpdf->Cell(27, $tailleLongCell, utf8_decode('MATRICULE'), 1, 0, 'C', 1);

        $this->fpdf->Cell(120, $tailleLongCell, utf8_decode(' NOMS ET PRENOMS '), 1, 0, 'L', 1);

        $this->fpdf->Cell(15, $tailleLongCell, utf8_decode('SEXE'), 1, 0, 'C', 1);

        $this->fpdf->Cell(25, $tailleLongCell, utf8_decode('TEL'), 1, 0, 'C', 1);

        $decalage = 70 + $tailleLongCell;

        $this->fpdf->SetY($decalage);


        foreach ($tearchers as $ley => $teacher) {



            $this->fpdf->SetFont('Arial', 'B', $tailletext + 3);


            $this->fpdf->SetX(3);
            $this->fpdf->Cell(10, $tailleLongCell, $ley + 1, 1, 0, 'C');
            $this->fpdf->Cell(27, $tailleLongCell, $teacher->matricule, 1, 0, 'L');

            $this->fpdf->Cell(120, $tailleLongCell, utf8_decode($teacher->nom . " " . $teacher->prenom), 1, 0, 'L');

            $this->fpdf->Cell(15, $tailleLongCell, $teacher->sexe, 1, 0, 'C');

            $this->fpdf->Cell(25, $tailleLongCell, $teacher->tel, 1, 0, 'C');


            $this->fpdf->Ln($tailleLongCell);
        }


        $this->fpdf->Output();

        exit;
    }


    public function getAllBilanClasseNonSaisie($id)

    {

        $conf = config::first();

        $entete = $conf->header;


        $classes = Classe::orderBy('libelleClasse', 'ASC')->get();


        $session = Session::where('encours_sess', 1)->first();

        $sessionEncour = $session->libelle_sess;



        $tailletext = 9;

        $tailleLongCell = 8;

        $nbr = 0;

        $this->fpdf->AddPage("P", ['290', '210']);


        $this->fpdf->Image(public_path("/Photos/Logos/" . $entete), 3, 3, 105, 30, "");

        $this->fpdf->SetFont('Arial', 'B', 20);
        $this->fpdf->SetTextColor('35', '107', '153');
        $this->fpdf->Text(50, 50, utf8_decode("LISTE DES MATIERES ENCORE VIDES"), 0, 'C', 1);

        $this->fpdf->SetFont('Arial', 'B', 8);

        $this->fpdf->SetTextColor('0', '0', '0');

        $this->fpdf->Text(75, 60, utf8_decode("ANNEE-SCOLAIRE :  $sessionEncour " . "    ;     " . "EVALUATION " . ($id - 1)), 0, 'C', 1);

        // $this->fpdf->Text(105, 60, utf8_decode("EVALUATION : " . ($id - 1)), 0, 'C', 1);


        $this->fpdf->Text(60, 65, utf8_decode(" RAPPORT FAIT automatiquement  par l'application Le :  " . date('j/m/Y  H:i:s')), 0, 'C', 1);



        $this->fpdf->SetTextColor('0', '0', '0');

        $this->fpdf->SetFont('Arial', 'B', 10);

        $this->fpdf->SetFillColor('166', '166', '166');

        $this->fpdf->SetXY(35, 75);






        foreach ($classes as $ley => $classe) {



            $matiere = Matieres::with('Enseignants')->where('classe_id', $classe->id)->get();


            $enseignantPrincipal = Enseignants::where('id', $classe->principale_Classe)->first()['nom'];





            $this->fpdf->SetFont('Arial', 'B', $tailletext + 3);






            $this->fpdf->Ln($tailleLongCell);
            $this->fpdf->SetX(2);



            $this->fpdf->Cell(105, $tailleLongCell, utf8_decode($classe->libelleClasse), 1, 0, 'C', 1);

            $this->fpdf->Cell(100, $tailleLongCell, utf8_decode($enseignantPrincipal), 1, 0, 'C', 1);


            //$this->fpdf->Ln(5);

            $this->fpdf->SetX(2);

            // $this->fpdf->Cell(100, $tailleLongCell, utf8_decode('Matieres'), 1, 0, 'C', 0);

            // $this->fpdf->Cell(100, $tailleLongCell, utf8_decode(' Enseignants '), 1, 0, 'C', 0);

            $this->fpdf->Ln($tailleLongCell);

            $nbr = 0;


            foreach ($matiere as $mat) {



                $note[$mat->id] = Notes::with('user')->where('matiere_id', $mat->id)->where('classe_id', $classe->id)
                    ->where('evaluation_id', $id)
                    ->first();





                if ($note[$mat->id] == null) {


                    $this->fpdf->SetFont('Arial', 'B', 10);

                    $this->fpdf->SetX(2);




                    $this->fpdf->Cell(105, $tailleLongCell, utf8_decode($mat->libelle), 1, 0, 'L');

                    $this->fpdf->Cell(100, $tailleLongCell, utf8_decode($mat->Enseignants->nom), 1, 0, 'L');

                    $this->fpdf->Ln($tailleLongCell);
                }
            }
        }


        $this->fpdf->Output();

        exit;
    }


    public function getAllBilanClasse($id)

    {

        $conf = config::first();

        $entete = $conf->header;


        // $classes = Classe::orderBy('libelleClasse', 'ASC')->get();

        $classes = Classe::orderBy('id', 'ASC')->get();


        $session = Session::where('encours_sess', 1)->first();

        $sessionEncour = $session->libelle_sess;



        $tailletext = 9;

        $tailleLongCell = 8;

        $nbr = 0;

        $this->fpdf->AddPage("P", ['290', '210']);


        $this->fpdf->SetFont('Arial', 'B', 15);

        $this->fpdf->Image(public_path("/Photos/Logos/" . $entete), 3, 3, 205, 30, "");

        $this->fpdf->SetFont('Arial', 'B', 20);
        $this->fpdf->SetTextColor('35', '107', '153');
        $this->fpdf->Text(20, 45, utf8_decode("POURCENTAGE DE REMPLISSAGE PAR CLASSE"), 0, 'C', 1);


        $this->fpdf->SetFont('Arial', 'B', 8);

        $this->fpdf->SetTextColor('0', '0', '0');

        $this->fpdf->Text(75, 60, utf8_decode("ANNEE-SCOLAIRE :  $sessionEncour " . "    ;     " . "EVALUATION " . ($id - 1)), 0, 'C', 1);

        // $this->fpdf->Text(105, 60, utf8_decode("EVALUATION : " . ($id - 1)), 0, 'C', 1);


        $this->fpdf->Text(60, 65, utf8_decode(" RAPPORT FAIT automatiquement  par l'application Le :  " . date('j/m/Y  H:i:s')), 0, 'C', 1);



        $this->fpdf->SetTextColor('0', '0', '0');

        $this->fpdf->SetFont('Arial', 'B', 10);

        $this->fpdf->SetFillColor('166', '166', '166');

        $this->fpdf->SetXY(35, 75);


        //Noms liste

        $this->fpdf->Cell(17, $tailleLongCell, utf8_decode('Nº'), 1, 0, 'C', 1);

        $this->fpdf->Cell(70, $tailleLongCell, utf8_decode(' CLASSE '), 1, 0, 'C', 1);

        $this->fpdf->Cell(30, $tailleLongCell, utf8_decode(' Evolution '), 1, 0, 'C', 1);


        $this->fpdf->Cell(30, $tailleLongCell, utf8_decode('%'), 1, 0, 'C', 1);





        foreach ($classes as $ley => $classe) {



            $matiere = Matieres::where('classe_id', $classe->id)->get();




            $this->fpdf->SetFont('Arial', 'B', $tailletext + 3);


            $decalage = 70 + $tailleLongCell;



            $this->fpdf->Ln($tailleLongCell);
            $this->fpdf->SetX(35);

            $this->fpdf->Cell(17, $tailleLongCell, $ley + 1, 1, 0, 'C');

            $this->fpdf->Cell(70, $tailleLongCell, utf8_decode($classe->libelleClasse), 1, 0, 'C');


            $nbr = 0;


            foreach ($matiere as $mat) {



                $note[$mat->id] = Notes::where('matiere_id', $mat->id)->where('classe_id', $classe->id)
                    ->where('evaluation_id', $id)
                    ->first();

                // dd($note[$mat->id]);

                if ($note[$mat->id] != null) {

                    $nbr++;
                }
            }



            $this->fpdf->SetFont('Arial', 'B', $tailletext + 4);

            $this->fpdf->Cell(30, $tailleLongCell, $nbr . ' ' . ' / ' . count($matiere), 1, 0, 'C');


            $this->fpdf->Cell(30, $tailleLongCell, number_format((($nbr / count($matiere)) * 100), 2) . " %", 1, 0, 'C');



            // if (count($matiere) == 0) {

            //     $this->fpdf->Cell(30, $tailleLongCell, "0 % ", 1, 0, 'C');
            // } else {


            //     $this->fpdf->Cell(30, $tailleLongCell, number_format((($nbr / count($matiere)) * 100), 2) . " %", 1, 0, 'C');
            // }
        }


        $this->fpdf->Output();

        exit;
    }



    public function getAllBilan($id)

    {

        $conf = config::first();

        $entete = $conf->header;


        $tearchers = Enseignants::orderBy('nom', 'ASC')->orderBy('prenom', 'ASC')->get();


        $session = Session::where('encours_sess', 1)->first();

        $sessionEncour = $session->libelle_sess;



        $tailletext = 9;

        $tailleLongCell = 8;

        $nbr = 0;

        $this->fpdf->AddPage("P", ['290', '210']);


        $this->fpdf->SetFont('Arial', 'B', 15);

        $this->fpdf->Image(public_path("/Photos/Logos/" . $entete), 3, 3, 205, 30, "");

        $this->fpdf->SetFont('Arial', 'B', 20);
        $this->fpdf->SetTextColor('35', '107', '153');
        $this->fpdf->Text(45, 45, utf8_decode("POURCENTAGE DE REMPLISSAGE"), 0, 'C', 1);


        $this->fpdf->SetFont('Arial', 'B', 8);

        $this->fpdf->SetTextColor('0', '0', '0');

        $this->fpdf->Text(75, 60, utf8_decode("ANNEE-SCOLAIRE :  $sessionEncour " . "    ;     " . "EVALUATION " . ($id - 1)), 0, 'C', 1);

        // $this->fpdf->Text(105, 60, utf8_decode("EVALUATION : " . ($id - 1)), 0, 'C', 1);


        $this->fpdf->Text(60, 65, utf8_decode(" RAPPORT FAIT automatiquement  par l'application Le :  " . date('j/m/Y  H:i:s')), 0, 'C', 1);



        $this->fpdf->SetTextColor('0', '0', '0');

        $this->fpdf->SetFont('Arial', 'B', 10);

        $this->fpdf->SetFillColor('166', '166', '166');

        $this->fpdf->SetXY(3, 70);


        //Noms liste

        $this->fpdf->Cell(17, $tailleLongCell, utf8_decode('Nº'), 1, 0, 'C', 1);

        $this->fpdf->Cell(140, $tailleLongCell, utf8_decode(' NOMS ET PRENOMS '), 1, 0, 'L', 1);

        $this->fpdf->Cell(20, $tailleLongCell, utf8_decode('Evolution'), 1, 0, 'C', 1);
        $this->fpdf->Cell(25, $tailleLongCell, utf8_decode('%'), 1, 0, 'C', 1);





        foreach ($tearchers as $ley => $teacher) {



            $matiere = Matieres::with('Classe')->where('enseignants_id', $teacher->id)->get();




            $this->fpdf->SetFont('Arial', 'B', $tailletext + 3);


            $decalage = 70 + $tailleLongCell;



            $this->fpdf->Ln($tailleLongCell);
            $this->fpdf->SetX(3);

            $this->fpdf->Cell(17, $tailleLongCell, $ley + 1, 1, 0, 'C');


            $this->fpdf->Cell(140, $tailleLongCell, utf8_decode($teacher->nom . " " . $teacher->prenom), 1, 0, 'L');

            $nbr = 0;


            foreach ($matiere as $mat) {



                $note[$mat->id] = Notes::where('matiere_id', $mat->id)
                    ->where('evaluation_id', $id)
                    ->first();

                // dd($note[$mat->id]);

                if ($note[$mat->id] != null) {

                    $nbr++;
                }
            }



            $this->fpdf->SetFont('Arial', 'B', $tailletext + 4);

            $this->fpdf->Cell(20, $tailleLongCell, $nbr . " / " . count($matiere), 1, 0, 'C');



            if (count($matiere) == 0) {

                $this->fpdf->Cell(25, $tailleLongCell, "0 % ", 1, 0, 'C');
            } else {


                $this->fpdf->Cell(25, $tailleLongCell, number_format((($nbr / count($matiere)) * 100), 2) . " %", 1, 0, 'C');
            }
        }


        $this->fpdf->Output();

        exit;
    }



    public function listerelenote($id)
    {



        $conf = config::first();

        $entete = $conf->header;


        $matieres = Matieres::with('Enseignants')->where('classe_id', $id)->get();

        $classe = Classe::with('eleves')->where('id', $id)->first();

        $nombreEleve = count(($classe->eleves));

        $tailletext = 10;

        $tailleLongCell = 6;


        foreach ($matieres as $matiere) {

            $this->fpdf->SetMargins(0, 0, 0, 0);

            $nomComplet = $matiere->Enseignants['nom'] . ' ' . $matiere->Enseignants['prenom'];


            $this->fpdf->AddPage("P", ['290', '210']);

            $this->fpdf->SetFont('Arial', 'B', 15);

            $this->fpdf->Image(public_path("/Photos/Logos/" . $entete), 5, 3, 205, 35, "");

            $this->fpdf->SetFont('Arial', 'B', 22);
            $this->fpdf->SetTextColor('40', '107', '153');
            $this->fpdf->Text(70, 50, utf8_decode("RELEVE DE NOTES"), 0, 'C', 1);
            $this->fpdf->SetTextColor('0', '0', '0');

            $this->fpdf->SetFont('Arial', 'B', 10);

            $this->fpdf->SetFillColor('166', '166', '166');
            $this->fpdf->SetXY(5, 57);

            $this->fpdf->Cell(30, $tailleLongCell, utf8_decode('Annee-Scolaire'), 1, 0, 'C', 1);
            $this->fpdf->Cell(50, $tailleLongCell, $classe->sessionClasse, 1, 0, 'C', 0);
            $this->fpdf->SetFont('Arial', 'B', 8);
            $this->fpdf->Cell(30, $tailleLongCell, utf8_decode('Matière'), 1, 0, 'C', 1);
            $this->fpdf->Cell(88, $tailleLongCell,   utf8_decode(substr($matiere['libelle'], 0, 50)), 1, 0, 'L', 0);
            $this->fpdf->Ln();


            // Rubrique des 4 ( MAtiere et Prof  et leur champs de data)

            $this->fpdf->SetX(5);
            $this->fpdf->Cell(30, $tailleLongCell, utf8_decode('Classe'), 1, 0, 'C', 0);

            $this->fpdf->Cell(50, $tailleLongCell, utf8_decode($classe->libelleClasse), 1, 0, 'C', 0);


            $this->fpdf->Cell(30, $tailleLongCell, utf8_decode('Professeur'), 1, 0, 'C', 0);

            $this->fpdf->Cell(88, $tailleLongCell, utf8_decode(substr($nomComplet, 0, 40)), 1, 0, 'L', 0);


            $this->fpdf->SetXY(5, 80);


            //Noms liste

            $this->fpdf->Cell(17, $tailleLongCell, utf8_decode('Nº'), 1, 0, 'C', 1);
            // $this->fpdf->Cell(20, $tailleLongCell, 'MAT', 1, 0, 'C', 1);
            $this->fpdf->Cell(90, $tailleLongCell, 'NOMS et PRENOMS', 1, 0, 'L', 1);

            $this->fpdf->Cell(18, $tailleLongCell, utf8_decode('EV 1'), 1, 0, 'C', 1);
            $this->fpdf->Cell(18, $tailleLongCell, utf8_decode('EV 2'), 1, 0, 'C', 1);
            $this->fpdf->Cell(18, $tailleLongCell, utf8_decode('EV 3'), 1, 0, 'C', 1);
            $this->fpdf->Cell(18, $tailleLongCell, utf8_decode('EV 4'), 1, 0, 'C', 1);
            $this->fpdf->Cell(20, $tailleLongCell, utf8_decode('EV 5'), 1, 0, 'C', 1);

            $this->fpdf->SetFont('Arial', 'B', $tailletext);


            $decalage = 80 + $tailleLongCell;


            $this->fpdf->SetY($decalage);


            foreach ($classe->eleves as $ley => $stu) {

                $this->fpdf->SetX(5);


                $this->fpdf->Cell(17, $tailleLongCell, $ley + 1, 1, 0, 'C');


                $this->fpdf->Cell(90, $tailleLongCell, utf8_decode(substr(($stu['nom'] . " " . $stu['prenom']), 0, 30)), 1, 0, 'L');


                $this->fpdf->Cell(18, $tailleLongCell, "", 1, 0, 'C');

                $this->fpdf->Cell(18, $tailleLongCell, "", 1, 0, 'C');


                $this->fpdf->Cell(18, $tailleLongCell, "", 1, 0, 'C');


                $this->fpdf->Cell(18, $tailleLongCell, "", 1, 0, 'C');


                $this->fpdf->Cell(20, $tailleLongCell, "", 1, 0, 'C');

                $this->fpdf->Ln($tailleLongCell);
            }
        }


        $this->fpdf->Output();

        exit;
    }


    public function getAllProfilTrimestre($idClasse)
    {

        $conf = config::first();

        $entete = $conf->header;


        // IdEvalauation = IdTrimestre (normalement)

        $data =  explode('*', $idClasse);
        $IdClasse = $data[0];
        $IdTrimmestre  = $data[1];

        $code = Classe::where('id', $IdClasse)->first();
        $codeEtab = $code->codeEtabClasse;
        $session = $code->sessionClasse;



        $Evalutions = Evaluations::with('trimestre')->where('trimestre_id', $IdTrimmestre)->where('session', $session)
            ->where('codeEtab', $codeEtab)->get();



        $idEval1 = $Evalutions[0]->id;
        $libelleEval1 = $Evalutions[0]->libelle;

        $idEval2 = $Evalutions[1]->id;
        $libelleEval2 = $Evalutions[1]->libelle;

        $libelleTrimestre = $Evalutions[0]->trimestre->libelle_semes;


        $this->fpdf->AddPage("L", ['215', '290']);

        // $this->fpdf->SetTextColor('44', '53', '61');

        $this->fpdf->SetXY(105, 40);
        $this->fpdf->Cell(70, 8, '', 1, 1); // trait cadre annee-scolaire

        $this->fpdf->SetFont('Arial', 'B', 9);

        $this->fpdf->Text(119, 45, utf8_decode("ANNEE SCOLAIRE : $session "));


        $this->fpdf->Image(public_path("/Photos/Logos/" . $entete), 15, 3, 250, 30, "");

        $this->fpdf->SetTextColor('40', '107', '153');
        $this->fpdf->SetFont('Arial', 'B', 25);

        $this->fpdf->Text(20, 60, utf8_decode("PROFIL DE LA CLASSE PAR MATIERE [ TRIMETRE $IdTrimmestre ]"));

        $this->fpdf->SetFont('Arial', 'B', 8);

        // $this->fpdf->line(25, 84, 38, 84); // trait souligne classe

        $this->fpdf->SetTextColor('0', '0', '0');
        $moys = MoyenneTrimestres::with('student')->where('classe_id', $IdClasse)->where('trimestre_id', $IdTrimmestre)->where('session', $session)
            ->where('codeEtab', $codeEtab)->where('valeur', '>', 0)->orderBy('valeur', 'DESC')->get();


        $classe = Classe::where('id', $IdClasse)->first();

        $profPricin = Enseignants::where('id', $classe['principale_Classe'])->first();


        // $effectif = count($moys);

        $this->fpdf->SetFont('Arial', 'B', 12);

        $this->fpdf->Text(5, 72, utf8_decode("CLASSE :  $code->libelleClasse"));

        $this->fpdf->Text(100, 72, utf8_decode("PROF Titulaire : " . $profPricin['nom'] . " " . $profPricin['prenom']));

        $this->fpdf->Text(245, 72, utf8_decode("EFFECTIF :  $effectif "));



        // $this->fpdf->line(150, 84, 168, 84); // trait souligne trimstre



        $this->fpdf->SetXY(0, 80);
        $this->fpdf->SetFont('Arial', 'B', 8);
        $this->fpdf->SetDrawColor(0, 0, 0);


        $this->fpdf->SetFillColor('40', '107', '153');
        $this->fpdf->SetTextColor('0', '0', '0');
        $this->fpdf->Cell(7, 8, utf8_decode('Nº'), 1, 0, 'L', 1);
        $this->fpdf->Cell(60, 8, utf8_decode('Matières'), 1, 0, 'C', 1);


        $this->fpdf->Cell(10, 8, utf8_decode('EFF'), 1, 0, 'C', 1);
        $this->fpdf->Cell(10, 8, 'Gar', 1, 0, 'C', 1);
        $this->fpdf->Cell(10, 8, 'Fille', 1, 0, 'C', 1);
        $this->fpdf->Cell(10, 8, 'Red', 1, 0, 'C', 1);
        $this->fpdf->Cell(15, 8, 'Moyenne', 1, 0, 'C', 1);
        $this->fpdf->Cell(16, 8, 'Nb_Moy_G', 1, 0, 'C', 1);
        $this->fpdf->Cell(16, 8, 'Nb_Moy_F', 1, 0, 'C', 1);
        $this->fpdf->Cell(16, 8, 'Nb_My_Rd', 1, 0, 'C', 1);
        $this->fpdf->Cell(16, 8, 'Sous_Moy', 1, 0, 'C', 1);
        $this->fpdf->Cell(16, 8, 'Moy_Mati', 1, 0, 'C', 1);
        $this->fpdf->Cell(15, 8, 'Moy_Pre', 1, 0, 'C', 1);
        $this->fpdf->Cell(15, 8, 'Moy_Der', 1, 0, 'C', 1);


        $this->fpdf->Cell(15, 8, '% Re_Red', 1, 0, 'C', 1);
        $this->fpdf->Cell(14, 8, '% Re_Ga', 1, 0, 'C', 1);
        $this->fpdf->Cell(14, 8, '% Re_Fi', 1, 0, 'C', 1);
        $this->fpdf->Cell(16, 8, '% Re_Gen', 1, 0, 'C', 1);





        $moys   = Matieres::with('Enseignants')->where('classe_id', $idClasse)->get();


        $longcell = 10;

        $tailletext = 8;



        $this->fpdf->SetY(88);
        foreach ($moys as $key => $student) {

            $this->fpdf->SetX(0);
            $this->fpdf->SetFont('Arial', 'B', $tailletext + 2);
            $this->fpdf->Cell(7,  $longcell, $key + 1, 1, 0, 'C', 0);

            $this->fpdf->SetFont('Arial', 'B', $tailletext - 1);

            // MAtieres Labelles
            $this->fpdf->Cell(60, $longcell, substr(utf8_decode($student->libelle), 0, 39), 1, 0, 'L');

            // Effectifs

            $this->fpdf->SetFont('Arial', 'B', $tailletext + 2);

            $note[$student->id] = count(NotesTrimestres::where('trimestre_id', $IdTrimmestre)->where('matiere_id', $student->id)->get());

            $this->fpdf->Cell(10, $longcell, $note[$student->id], 1, 0, 'C', 0);

            // Garcon

            $note[$student->id] = NotesTrimestres::with('student')
                ->where('trimestre_id', $IdTrimmestre)->where('matiere_id', $student->id)->get();


            $garEff = 0;
            $fillEff = 0;

            foreach ($note[$student->id] as $dat) {

                if ($dat->student->sexe == "M") {

                    $garEff =  $garEff + 1;
                }
            }

            $this->fpdf->Cell(10, $longcell, $garEff, 1, 0, 'C');

            // Fiile

            $fillEff = 0;


            $note[$student->id] = NotesTrimestres::with('student')->where('trimestre_id', $IdTrimmestre)->where('matiere_id', $student->id)->get();


            foreach ($note[$student->id] as $dat) {

                if ($dat->student->sexe == "F") {

                    $fillEff =  $fillEff + 1;
                }
            }


            $this->fpdf->Cell(10, $longcell, $fillEff, 1, 0, 'C');

            // Redoublant

            $redEff = 0;
            $note[$student->id] = NotesTrimestres::with('student')->where('trimestre_id', $IdTrimmestre)->where('matiere_id', $student->id)->get();

            foreach ($note[$student->id] as $dat) {

                if ($dat->student->doublant == "ANCIENNE") {

                    $redEff =  $redEff + 1;
                }
            }

            $this->fpdf->Cell(10, $longcell, $redEff, 1, 0, 'C', 1);

            // Moyenne

            $note[$student->id] = count(NotesTrimestres::where('valeur', '>=', 10)->where('trimestre_id', $IdTrimmestre)->where('matiere_id', $student->id)->get());

            $this->fpdf->Cell(15, $longcell,  $note[$student->id], 1, 0, 'C', 0);


            // Nbr Moy Gar


            $N_Moy_Ga = 0;


            $note[$student->id] = NotesTrimestres::with('student')->where('trimestre_id', $IdTrimmestre)->where('matiere_id', $student->id)->where('valeur', '>=', 10)->get();

            foreach ($note[$student->id] as $dat) {

                if ($dat->student->sexe == "M") {

                    $N_Moy_Ga =  $N_Moy_Ga + 1;
                }
            }

            $this->fpdf->Cell(16, $longcell, $N_Moy_Ga, 1, 0, 'C');


            // Nbr Moy File

            $N_Moy_Fi = 0;


            $note[$student->id] = NotesTrimestres::with('student')->where('trimestre_id', $IdTrimmestre)->where('matiere_id', $student->id)->where('valeur', '>=', 10)->get();

            foreach ($note[$student->id] as $dat) {

                if ($dat->student->sexe == "F") {

                    $N_Moy_Fi =  $N_Moy_Fi + 1;
                }
            }

            $this->fpdf->Cell(16, $longcell, $N_Moy_Fi, 1, 0, 'C');

            // Nbr Moy Red

            $N_Moy_Re = 0;


            $note[$student->id] = NotesTrimestres::with('student')->where('trimestre_id', $IdTrimmestre)->where('matiere_id', $student->id)->where('valeur', '>=', 10)->get();

            foreach ($note[$student->id] as $dat) {

                if ($dat->student->doublant == "ANCIENNE") {

                    $N_Moy_Re =  $N_Moy_Re + 1;
                }
            }

            $this->fpdf->Cell(16, $longcell, $N_Moy_Re, 1, 0, 'C');


            // Sous Moyenne

            $note[$student->id] = count(NotesTrimestres::where('valeur', '<', 10)->where('trimestre_id', $IdTrimmestre)->where('matiere_id', $student->id)->get());;

            $this->fpdf->Cell(16, $longcell,  $note[$student->id], 1, 0, 'C', 0);

            //  Moyenne  Matiere ( pas encore pret)

            $note[$student->id] = count(NotesTrimestres::where('trimestre_id', $IdTrimmestre)->where('matiere_id', $student->id)->get());

            $note1[$student->id] = NotesTrimestres::where('trimestre_id', $IdTrimmestre)->where('matiere_id', $student->id)->sum('valeur');

            $this->fpdf->Cell(16, $longcell, number_format(($note1[$student->id] /  $note[$student->id]), 2), 1, 0, 'C', 1);


            // Moyenne premier
            $note[$student->id] = NotesTrimestres::where('trimestre_id', $IdTrimmestre)->where('matiere_id', $student->id)->max('valeur');
            $this->fpdf->Cell(15, $longcell,  $note[$student->id], 1, 0, 'C', 0);


            //  MOYEN DU DERNIER


            $note[$student->id] = NotesTrimestres::where('trimestre_id', $IdTrimmestre)->where('matiere_id', $student->id)->min('valeur');

            $this->fpdf->Cell(15, $longcell,  $note[$student->id], 1, 0, 'C', 1);



            // % RESSUITE DES REDOUBLANTS




            $Nmbr_Redblnt = 0;
            $Nmbr_RedblntAdmns = 0;

            $note1[$student->id] = NotesTrimestres::with('student')->where('trimestre_id', $IdTrimmestre)->where('matiere_id', $student->id)->get();

            foreach ($note1[$student->id]  as $dat1) {

                if ($dat1->student->doublant == "ANCIENNE") {

                    $Nmbr_Redblnt = $Nmbr_Redblnt + 1;
                }




                $note[$student->id] = NotesTrimestres::with('student')->where('trimestre_id', $IdTrimmestre)->where('matiere_id', $student->id)->where('valeur', '>=', 10)->get();

                foreach ($note[$student->id] as $dat) {

                    if ($dat->student->doublant == "ANCIENNE") {

                        $Nmbr_RedblntAdmns = $Nmbr_RedblntAdmns = +1;
                    }
                }
            }

            if ($Nmbr_Redblnt != 0) {

                $this->fpdf->Cell(15, $longcell,  number_format((($Nmbr_RedblntAdmns / $Nmbr_Redblnt) * 100), 2), 1, 0, 'C');
            } else {

                $this->fpdf->Cell(15, $longcell, 0.00, 1, 0, 'C');
            }


            // REUISSITE GARCON


            $PerR_Gar = 0;
            $totalGarcon = 0;

            $note1[$student->id] = NotesTrimestres::where('trimestre_id', $IdTrimmestre)
                ->where('matiere_id', $student->id)->get();


            foreach ($note1[$student->id] as $dat) {

                if ($dat->student->sexe == "M") {

                    $totalGarcon =  $totalGarcon + 1;
                }
            }
            $note[$student->id] = NotesTrimestres::with('student')->where('trimestre_id', $IdTrimmestre)->where('matiere_id', $student->id)->where('valeur', '>=', 10)->get();

            foreach ($note[$student->id] as $dat) {

                if ($dat->student->sexe == "M") {

                    $PerR_Gar =   $PerR_Gar + 1;
                }
            }
            if ($totalGarcon == 0) {

                $this->fpdf->Cell(14, 6, 0, 1, 0, 'C');
            } else {

                $this->fpdf->Cell(14, $longcell, number_format((($PerR_Gar / $totalGarcon) * 100), 2), 1, 0, 'C');
            }


            //  % REUISSITE FILLE



            $PerR_Fill = 0;
            $Total_Fill = 0;


            $note1[$student->id] = NotesTrimestres::where('trimestre_id', $IdTrimmestre)->where('matiere_id', $student->id)->get();


            foreach ($note1[$student->id] as $dat) {

                if ($dat->student->sexe == "F") {

                    $Total_Fill = $Total_Fill + 1;
                }
            }
            $note[$student->id] = NotesTrimestres::with('student')->where('trimestre_id', $IdTrimmestre)->where('matiere_id', $student->id)->where('valeur', '>=', 10)->get();

            foreach ($note[$student->id] as $dat) {

                if ($dat->student->sexe == "F") {

                    $PerR_Fill =  $PerR_Fill + 1;
                }
            }

            if ($Total_Fill != 0) {

                $this->fpdf->Cell(14, $longcell, number_format((($PerR_Fill / $Total_Fill) * 100), 2), 1, 0, 'C');
            } else {
                $this->fpdf->MultiCell(14, $longcell, 0, 1, 0, 'C');
            }


            // % REUISSITE GENERAL





            $Re_Gen = 0;
            $Total = 0;
            $result  = 0;


            $Total = count(NotesTrimestres::where('trimestre_id', $IdTrimmestre)->where('matiere_id', $student->id)->get());

            $Re_Gen = count(NotesTrimestres::with('student')->where('trimestre_id', $IdTrimmestre)->where('matiere_id', $student->id)->where('valeur', '>=', 10)->get());

            $this->fpdf->Cell(16, $longcell, number_format(((($Re_Gen / $Total)) * 100), 2), 1, 0, 'C', 1);





            $this->fpdf->Ln($longcell);
        }










        $this->fpdf->Output();

        exit;
    }

    public function listeprof($idClasse)

    {



        $conf = config::first();

        $entete = $conf->header;

        $classe = Classe::where('id', $idClasse)->first();

        $profPricin = Enseignants::where('id', $classe['principale_Classe'])->first();

        $IdTrimmestre = 1;

        $IdClasse = $idClasse;

        $code = Classe::where('id', $IdClasse)->first();
        $codeEtab = $code->codeEtabClasse;
        $session = $code->sessionClasse;

        $this->fpdf->AddPage("P", ['290', '210']);

        // $this->fpdf->SetTextColor('46', '133', '61');

        // $this->fpdf->SetFillColor('10', '75', '168');

        $this->fpdf->SetXY(78, 50);


        $this->fpdf->SetFillColor('40', '107', '153');
        $this->fpdf->Cell(70, 6, '', 1);

        $this->fpdf->SetFont('Arial', 'B', 9);


        $this->fpdf->Text(89, 54, utf8_decode("ANNEE-SCOLAIRE : $session "));


        $this->fpdf->Image(public_path("/Photos/Logos/" . $entete), 5, 8, 215, 35, "");


        $this->fpdf->SetFont('Arial', 'B', 25);

        $this->fpdf->SetTextColor('10', '75', '168');


        $this->fpdf->Text(35, 67, utf8_decode("RAPPORT CONSEIL DE CLASSE "));

        $this->fpdf->SetFont('Arial', 'B', 10);

        // $this->fpdf->line(25, 84, 38, 84); // trait souligne classe

        $this->fpdf->SetTextColor('0', '0', '0');


        $this->fpdf->Text(85, 75, utf8_decode("CLASSE :  $code->libelleClasse"));



        $this->fpdf->Text(68, 85, utf8_decode("PROF Titulaire : " . $profPricin['nom'] . " " . $profPricin['prenom']));



        // $this->fpdf->line(150, 84, 168, 84); // trait souligne trimstre



        $this->fpdf->SetXY(3, 90);
        $this->fpdf->SetFont('Arial', 'B', 10);
        $this->fpdf->SetDrawColor(0, 0, 0);
        $this->fpdf->SetFillColor('166', '166', '166');
        $this->fpdf->SetTextColor('0', '0', '0');
        $this->fpdf->Cell(8, 8, utf8_decode('Nº'), 1, 0, 'L', 1);
        $this->fpdf->Cell(60, 8, utf8_decode('Matières'), 1, 0, 'C', 1);
        $this->fpdf->Cell(10, 8, utf8_decode('Coef'), 1, 0, 'C', 1);
        $this->fpdf->Cell(70, 8, 'Enseignants', 1, 0, 'C', 1);
        $this->fpdf->Cell(30, 8, 'Matricules', 1, 0, 'C', 1);
        $this->fpdf->Cell(25, 8, 'Visa', 1, 0, 'C', 1);


        $taillecell = 10;
        $tailleText = 10;






        $moys     = Matieres::with('Enseignants')->where('classe_id', $idClasse)->get();

        $this->fpdf->SetY(98);
        foreach ($moys as $key => $student) {

            $this->fpdf->SetX(3);
            $this->fpdf->SetFont('Arial', 'B', $tailleText);
            $this->fpdf->Cell(8, $taillecell, $key + 1, 1, 'C');
            $this->fpdf->Cell(60,  $taillecell, substr(utf8_decode($student->libelle), 0, 26), 1, 'C');
            $this->fpdf->Cell(10,  $taillecell, $student->coef, 1, 0, 'C');

            $nom = utf8_decode($student->Enseignants->nom . " " . $student->Enseignants->prenom);
            $this->fpdf->Cell(70,  $taillecell, utf8_decode(substr($nom, 0, 29)), 1, 0, 'L');
            $this->fpdf->Cell(30,  $taillecell, utf8_decode($student->Enseignants->matricule), 1, 0, 'L');
            $this->fpdf->Cell(25,  $taillecell, utf8_decode($student->Enseignants->tel), 1, 0, 'L');



            $this->fpdf->Ln($taillecell);
        }





        $this->fpdf->Output();

        exit;
    }




    public function generateficheNotePdf($id)


    {


        $conf = config::first();

        $entete = $conf->header;

        $datas = Enseignants::with('Classe', 'Matieres')->where('id', $id)->get();



        $Etabs = Etablissement::where('codeEtab', $datas[0]->codeEtab)->get()[0];


        $SessionLabel = Session::where('codeEtab_sess',  $datas[0]->codeEtab)->get()[0]['libelle_sess'];


        $NomEtab = $Etabs['libelleEtab'];




        $this->fpdf->SetFillColor('166', '166', '166');



        foreach ($datas as $data) {



            $nomComplet = $data->nom . " " . $data->prenom;


            foreach ($data->Matieres as $key => $matiere) {

                $classe = Classe::with('eleves')->where('id', $matiere['classe_id'])->get();


                $libelleClasse = $classe[0]['libelleClasse'];


                $this->fpdf->AddPage("P", ['210', '357']);

                $this->fpdf->SetFont('Arial', 'B', 15);

                $this->fpdf->Image(public_path("/Photos/Logos/" . $entete), 5, 3, 180, 25, "");


                // $this->fpdf->SetXY(5, 10);
                // $this->fpdf->SetFont('Arial', 'B', 8);

                // // Rubrique Ecole

                // $this->fpdf->Cell(30, 10, utf8_decode('Etablissement'), 1, 0, 'C', 0);
                // $this->fpdf->SetFont('Arial', 'B', 12);
                // $this->fpdf->Cell(168, 10, $NomEtab, 1, 0, 'C', 0);
                // $this->fpdf->Ln();


                $this->fpdf->SetFont('Arial', 'B', 17);
                $this->fpdf->SetTextColor('40', '107', '153');
                $this->fpdf->Text(75, 40, utf8_decode("RELEVE DE NOTES"), 0, 'C', 1);
                $this->fpdf->SetTextColor('0', '0', '0');

                $this->fpdf->SetFont('Arial', 'B', 12);


                // Rubrique des 4 ( Classe Annee et leur champs de data)

                $this->fpdf->SetXY(5, 50);

                $this->fpdf->SetFont('Arial', 'B', 8);
                $this->fpdf->SetX(5);
                $this->fpdf->Cell(30, 6, utf8_decode('Annee-Scolaire'), 1, 0, 'C', 1);
                $this->fpdf->Cell(50, 6, $SessionLabel, 1, 0, 'C', 0);

                $this->fpdf->Cell(30, 6, utf8_decode('Matière'), 1, 0, 'C', 1);
                $this->fpdf->Cell(88, 6,   utf8_decode(substr($matiere['libelle'], 0, 50)), 1, 0, 'C', 0);
                $this->fpdf->Ln();


                // // Rubrique des 4 ( MAtiere et Prof  et leur champs de data)

                $this->fpdf->SetX(5);
                $this->fpdf->Cell(30, 6, utf8_decode('Classe'), 1, 0, 'C', 0);

                $this->fpdf->Cell(50, 6, utf8_decode($libelleClasse), 1, 0, 'C', 0);


                $this->fpdf->Cell(30, 6, utf8_decode('Enseignant (e)'), 1, 0, 'C', 0);

                $this->fpdf->Cell(88, 6, utf8_decode(substr($nomComplet, 0, 29)), 1, 0, 'C', 0);
                $this->fpdf->Ln(15);

                $this->fpdf->SetXY(5, 70);




                //Noms liste

                $this->fpdf->Cell(7, 6, utf8_decode('Nº'), 1, 0, 'L', 1);
                $this->fpdf->Cell(20, 6, 'MATRICULE', 1, 0, 'C', 1);
                $this->fpdf->Cell(80, 6, 'NOMS et PRENOMS', 1, 0, 'C', 1);


                $this->fpdf->Cell(18, 6, utf8_decode('Séqence 1'), 1, 0, 'L', 1);
                $this->fpdf->Cell(18, 6, utf8_decode('Séqence  2'), 1, 0, 'L', 1);
                $this->fpdf->Cell(18, 6, utf8_decode('Séqence  3'), 1, 0, 'L', 1);
                $this->fpdf->Cell(18, 6, utf8_decode('Séqence  4'), 1, 0, 'L', 1);
                $this->fpdf->Cell(18, 6, utf8_decode('Séqence 5'), 1, 0, 'L', 1);

                $this->fpdf->SetFont('Times', 'B', 7);


                $decalage = 76;
                foreach ($classe as $ley => $student) {



                    $stuentClasses = Student::where('classe_id', $student->id)->orderBy('nom', 'ASC')->orderBy('prenom', 'ASC')->get();



                    $this->fpdf->SetY($decalage);
                    foreach (
                        $stuentClasses
                        as $ley => $stu
                    ) {

                        $this->fpdf->SetX(5);
                        $this->fpdf->MultiCell(7, 6, $ley + 1, 1, 'C');
                    }

                    $this->fpdf->SetY($decalage);
                    foreach (
                        $stuentClasses
                        as $ley => $stu
                    ) {
                        $this->fpdf->SetX(12);
                        $this->fpdf->MultiCell(20, 6,  utf8_decode($stu->matricule), 1, 'C');
                    }

                    $this->fpdf->SetY($decalage);
                    foreach (
                        $stuentClasses
                        as $ley => $stu
                    ) {
                        $this->fpdf->SetX(32);
                        $stu['name'] = $stu->nom . " " . $stu->prenom;

                        if (strlen($stu['name']) > 40) {

                            $this->fpdf->MultiCell(80, 6, utf8_decode(substr($stu['name'], 0, 25))  . " ...", 1, 'L');
                        } else {
                            $this->fpdf->MultiCell(80, 6,  utf8_decode($stu['name']), 1, 'L');
                        }
                    }

                    $this->fpdf->SetY($decalage);
                    foreach (
                        $stuentClasses
                        as $ley => $stu
                    ) {
                        $this->fpdf->SetX(112);
                        $this->fpdf->MultiCell(18, 6, " ", 1, 'L');
                    }

                    $this->fpdf->SetY($decalage);
                    foreach (
                        $stuentClasses
                        as $ley => $stu
                    ) {
                        $this->fpdf->SetX(130);
                        $this->fpdf->MultiCell(18, 6, " ", 1, 'L');
                    }

                    $this->fpdf->SetY($decalage);
                    foreach (
                        $stuentClasses
                        as $ley => $stu
                    ) {
                        $this->fpdf->SetX(148);
                        $this->fpdf->MultiCell(18, 6, " ", 1, 'L');
                    }

                    $this->fpdf->SetY($decalage);
                    foreach (
                        $stuentClasses
                        as $ley => $stu
                    ) {
                        $this->fpdf->SetX(166);
                        $this->fpdf->MultiCell(18, 6, " ", 1, 'L');
                    }

                    $this->fpdf->SetY($decalage);
                    foreach (
                        $stuentClasses
                        as $ley => $stu
                    ) {
                        $this->fpdf->SetX(184);
                        $this->fpdf->MultiCell(18, 6, " ", 1, 'L');
                    }
                }
            }

            $this->fpdf->Output();

            exit;
        }
    }

    public function getEleveclassePdf3($id)

    {



        //QrCode::generate('Make me into a QrCode!');



        $data =  explode('*', $id);

        $IdClasse = $data[0];
        $codeEtab  = $data[1];

        // Information de cette ecole

        $classeName = Etablissement::where('codeEtab', $codeEtab)->first();






        $session = Session::where('codeEtab_sess', $codeEtab)->first('libelle_sess');

        $sessionEncour = $session->libelle_sess;

        $etabName = $classeName->libelleEtab;


        $conf = config::first();


        $entete = $conf->header;

        $classeData = Student::with('classe', 'parent')->where('classe_id', $IdClasse)->where('session', $sessionEncour)->where('codeEtab', $codeEtab)->orderBy('nom', 'asc')->orderBy('prenom', 'asc')->get();




        foreach ($classeData as $key => $data) {


            $data->parent2 = Parents::where('id', $data['parent2_id'])->first();

            // Allons chercher le deuxieme parent





            $this->fpdf->AddPage("L", ['297', '210']);

            $fr = 7;
            $en = 5;





            $this->fpdf->SetXY(50, 30);

            $this->fpdf->SetFont('Arial', 'B', 70);

            // $this->fpdf->Cell(5, 5, QrCode::generate('this is should generate QR'), 1, 1);


            // $this->fpdf->Rect(50, 20, 230, 145);


            $this->fpdf->SetFillColor('10', '75', '168');


            $this->fpdf->SetFont('Times', "B");

            $this->fpdf->SetTextColor('10', '75', '168');

            // $this->fpdf->Image(public_path("/Photos/Logos/test.svg"), 0, 0, 10, 20);

            $this->fpdf->Multicell(186, 60, utf8_decode("CERTIFICAT"), 0, 'C');

            $this->fpdf->SetTextColor('0', '0', '0');



            $this->fpdf->SetFont('Arial', 'B', 18);
            $this->fpdf->SetXY(50, 62);

            $this->fpdf->Multicell(183, 30, utf8_decode("DE SCOLARITE "), 0, 'C');


            $this->fpdf->SetFont('Arial', 'B', 14);
            $this->fpdf->SetXY(20, 80);

            $this->fpdf->Text(20, 90, utf8_decode("Je soussigné MME MAKANDA ESTHER GISÈLE LOUISE , PROVISEUR  du $classeName->libelleEtab  "), 0, 'C');
            $this->fpdf->Text(20, 100, utf8_decode("BP 32 MANJO , Tel : +237 691 52 46 88  atteste que :  "), 0, 'C');


            // QrCode::format('png')->size(399)->color(40, 40, 40)->generate("$etabName , session $sessionEncour , utf8_decode($data->nom) . ' ' . utf8_decode($data->prenom) ,  utf8_decode($data->classe->libelleClasse) ", public_path("/Photos/Logos/Qrcode.png"));





            if (!file_exists(public_path("/Photos/Qrcodes/" . $data->id . ".png"))) {

                $dataToEncode = mb_convert_encoding(
                    $data->nom . " " .
                        $data->prenom . ',' .
                        utf8_decode(date_format(date_create($data->dateNaiss), "d /m/ Y")) . "," .
                        $data->lieuNaiss . "," .
                        $classeName->libelleEtab  . ":",

                    'utf-8',
                    // Specify the original encoding of the data here
                );

                QrCode::format('png')
                    ->size(299)
                    ->color(40, 40, 40)
                    ->encoding('utf-8') // Only needed if using option 1
                    ->generate($dataToEncode, public_path("/Photos/Qrcodes" . $data->id . ".png"));

                $this->fpdf->Image(public_path("/Photos/Qrcodes" . $data->id . ".png"), 1, 170, 20, 20);
            }






            if ($data->sexe == "M") {

                $this->fpdf->Text(20, 110, utf8_decode("Le nommé  :  "), 0, 'C');
            } else {
                $this->fpdf->Text(20, 110, utf8_decode("La nommée :  "), 0, 'C');
            }


            $this->fpdf->SetTextColor('10', '75', '168');

            $this->fpdf->Text(55, 110, utf8_decode($data->nom) . ' ' . utf8_decode($data->prenom), 0, 'C');

            $this->fpdf->SetTextColor('0', '0', '0');
            $this->fpdf->Text(190, 110, utf8_decode("Sexe   :   $data->sexe "), 0, 'C');


            $this->fpdf->Text(20, 120, utf8_decode("Ne(e) le        :  ") . '  ' . date_format(date_create($data->dateNaiss), "d/m/Y"), 0, 'C');



            $this->fpdf->Text(190, 120, utf8_decode("A         :   $data->lieuNaiss "), 0, 'C');

            $this->fpdf->Text(20, 130, "Fils de          : " . "   " .  utf8_decode($data->parent['nomParent'] . " " . $data->parent['prenomParent']), 0, 'C');

            if ($data->parent2 != null) {
                $this->fpdf->Text(190, 130, "Et de  :   " . "   " .  utf8_decode($data->parent2['nomParent'] . " " . $data->parent2['prenomParent']), 0, 'C');
            } else {
                $this->fpdf->Text(190, 130, "Et de  :  ", 0, 'C');
            }




            $this->fpdf->SetFont('Arial', 'B', 13);

            $this->fpdf->SetXY(20, 125);

            $this->fpdf->SetTextColor('0', '0', '0');

            $this->fpdf->Multicell(270, 30, utf8_decode("est élève dans son établissement en classe de  ") . " " . utf8_decode($data->classe->libelleClasse) . " " . utf8_decode(" pour l'année scolaire" . " " . utf8_decode($data->session) . ' ' . "sous le matricule $data->matricule" . "."), 0, 'L');


            $this->fpdf->SetFont('Arial', 'BI', 12);

            $this->fpdf->Text(20, 150, utf8_decode("En foi de quoi le présent Certificat de Scolarité lui est délivré pour servir et faire valoir ce que de droit ."), 0, 'C');


            $this->fpdf->SetFont('Arial', 'B', 13);

            $this->fpdf->Text(190, 170, utf8_decode("Fait à Manengole le  ................................."), 0, 'C');

            $this->fpdf->Text(190, 182, utf8_decode("Le Proviseur "), 0, 'C');




            // $this->fpdf->Image(public_path("/Photos/Logos/testupp.PNG"), 0, 0, 50, 50);

            $this->fpdf->Image(public_path("/Photos/Logos/" . $entete), 20, 10, 260, 35, "");

            $this->fpdf->Image(public_path("/Photos/Logos/footer.PNG"), 0, 0, 310, 5);


            $this->fpdf->Image(public_path("/Photos/Logos/footer.PNG"), 0, 205, 310, 8);


            $this->fpdf->Image(public_path("/Photos/Logos/testuu.png"), 230, 50, 40, 25);
        }



        $this->fpdf->Output();

        exit;
    }



    public function getEmploiTempPdf($id)

    {

        $conf = config::first();

        $entete = $conf->header;


        $Idclasse = $id;

        $code = Classe::where('id', $id)->first();
        $codeEtab = $code->codeEtabClasse;
        $session = $code->sessionClasse;





        $this->fpdf->AddPage("L", ['210', '297']);

        // $this->fpdf->SetTextColor('44', '53', '61');

        $this->fpdf->SetXY(98, 50);
        $this->fpdf->Cell(100, 6, '', 1);

        $this->fpdf->SetFont('Arial', 'B', 9);

        $this->fpdf->Text(126, 54, utf8_decode("ANNEE-SCOLAIRE : $session "));


        $this->fpdf->Image(public_path("/Photos/Logos/" . $entete), 5, 8, 290, 35, "");


        $this->fpdf->SetFont('Arial', 'B', 21);

        $this->fpdf->Text(114, 70, utf8_decode(" EMPLOI DU TEMPS "));

        $this->fpdf->SetFont('Arial', 'B', 15);

        $this->fpdf->Text(145, 85, utf8_decode("$code->libelleClasse"));

        $jours = Jours::get();

        $heures = Heure::get();
        $this->fpdf->SetFillColor('166', '166', '166');

        $this->fpdf->SetXY(3, 95);

        $this->fpdf->Cell(46, 10, "Horaires", 1, 0, 'C', 0);


        $this->fpdf->SetXY(49, 95);
        foreach ($jours as $key =>  $jour) {

            $this->fpdf->SetFillColor('166', '166', '166');
            $this->fpdf->SetFont('Arial', 'B', 14);
            $this->fpdf->Cell(49, 10, $jour->jour, 1, 0, 'C', 1);
        }

        $this->fpdf->SetXY(10, 105);


        foreach ($heures as $heure) {

            $this->fpdf->SetFillColor('166', '166', '166');

            $this->fpdf->SetX(3);
            $this->fpdf->SetFont('Arial', 'B', 10);

            $this->fpdf->MultiCell(46, 12, $heure->heure_D . " - " . $heure->heure_F, 1,  'C', 0);
        }

        $this->fpdf->SetY(105);

        foreach ($jours as $key => $jour) {


            $cours[$jour->id] = tabletimes::with('enseignant')->where('id_jour', $jour->id)->where('classe_id', $Idclasse)->get();

            $this->fpdf->SetY(105);
            foreach ($cours[$jour->id] as $ley => $cour) {




                $this->fpdf->SetX(49 * ($key + 1));
                $this->fpdf->SetFont('Arial', 'B', 8);

                if ($cour['matiere'] == "PAUSE") {

                    $this->fpdf->MultiCell(49, 12,  substr(utf8_decode($cour['matiere']), 0, 22), 1, 'C', 1);
                } else {

                    $this->fpdf->SetFont('Arial', 'B', 8);


                    if (strlen($cour['matiere']) >= 20) {

                        $this->fpdf->MultiCell(49, 6,  substr(utf8_decode($cour['matiere']), 0, 20) . "..." . "\n" . "( " . utf8_decode($cour['enseignant']['nom']) . "." . substr(utf8_decode($cour['enseignant']['prenom']), 0, 1) . " )", 1, 'C');
                    } else {

                        $this->fpdf->MultiCell(49, 6,  utf8_decode($cour['matiere']) . "\n" . "( " . utf8_decode($cour['enseignant']['nom']) . ". " . substr(utf8_decode($cour['enseignant']['prenom']), 0, 1) . " )", 1, 'C');
                    }
                }
            }
        }


        $this->fpdf->Output();

        exit;
    }

    public function getBilanJourRecuPdf2($date)
    {


        $conf = config::first();

        $entete = $conf->header;


        $this->fpdf->AddPage("P", ['375', '225']);

        // $this->fpdf->SetTextColor('44', '53', '61');

        $this->fpdf->SetXY(58, 50);
        $this->fpdf->Cell(110, 6, '', 1);

        $this->fpdf->SetFont('Arial', 'B', 10);


        $this->fpdf->Text(89, 54, utf8_decode("Bilan globale jusqu'au  " . date('d-m-Y', strtotime($date))));


        $this->fpdf->Image(public_path("/Photos/Logos/" . $entete), 5, 8, 215, 35, "");



        $classeData = classe::with('eleves')->where('statutClasse', 3)->get();

        // $classeData = classe::with('eleves')->get();



        foreach ($classeData as $classe) {

            if (count($classe->eleves) > 0) {

                $classeDat[$classe->id] = $classe;
            }
        }


        $this->fpdf->SetXY(3, 70);
        $this->fpdf->SetFont('Arial', 'B', 8);
        $this->fpdf->Cell(15, 6, utf8_decode('Eff'), 1, 0, 'C', 0);
        $this->fpdf->Cell(30, 6, 'Classe', 1, 0, 'C', 0);

        $this->fpdf->Cell(33, 6, 'Inscription', 1, 0, 'C', 0);
        $this->fpdf->Cell(33, 6, 'Tranche 1 percu', 1, 0, 'C', 0);
        $this->fpdf->Cell(33, 6, 'Tranche 1 attendu', 1, 0, 'C', 0);

        $this->fpdf->Cell(33, 6, 'Tranche 2 percu', 1, 0, 'C', 0);
        $this->fpdf->Cell(33, 6, 'Tranche 2 attendu', 1, 0, 'C', 0);


        $totalApe =  0;
        $totalApe1 =  0;
        $totalT1 =  0;
        $totalT11 =  0;
        $totalT2 =  0;
        $totalT21 =  0;



        $nmr = 0;



        $this->fpdf->SetY(76);
        foreach ($classeDat as $student) {

            $this->fpdf->SetX(3);
            $this->fpdf->SetFont('Arial', 'B', 8);

            $nmr = $nmr + count($student->eleves);

            $this->fpdf->MultiCell(15, 6, count($student->eleves), 1, 'C');
        }



        $this->fpdf->SetY(76);
        foreach ($classeDat as $student) {

            $this->fpdf->SetX(18);
            $this->fpdf->SetFont('Arial', 'B', 8);

            $this->fpdf->MultiCell(30, 6, utf8_decode($student->libelleClasse), 1, 'C');
        }


        $this->fpdf->SetY(76);
        foreach ($classeDat as $student) {

            $this->fpdf->SetX(48);
            $this->fpdf->SetFont('Arial', 'B', 8);

            $var = versements::where('classe_id', $student->id)->where('date', '<=', $date)->where('motif', "APE")->sum('montantverser');

            $totalApe = $totalApe + $var;

            $this->fpdf->MultiCell(33, 6, utf8_decode($var), 1, 'C');
        }

        $this->fpdf->SetY(76);
        foreach ($classeDat as $student) {

            $this->fpdf->SetX(81);
            $this->fpdf->SetFont('Arial', 'B', 8);

            $var = versements::where('classe_id', $student->id)->where('date', '<=', $date)->where('motif', "tranche1")->sum('montantverser');


            $totalT1 = $totalT1 + $var;


            $this->fpdf->MultiCell(33, 6, utf8_decode($var), 1, 'C');
        }

        $this->fpdf->SetY(76);
        foreach ($classeDat as $student) {

            $this->fpdf->SetX(114);
            $this->fpdf->SetFont('Arial', 'B', 8);

            $totalT11 = $totalT11 + $student->scolarite_Classe * count($student->eleves);
            $this->fpdf->MultiCell(33, 6, utf8_decode($student->scolarite_Classe * count($student->eleves)), 1, 'C');
        }

        $this->fpdf->SetY(76);
        foreach ($classeDat as $student) {

            $this->fpdf->SetX(147);
            $this->fpdf->SetFont('Arial', 'B', 8);

            $var = versements::where('classe_id', $student->id)->where('date', '<=', $date)->where('motif', "tranche2")->sum('montantverser');

            $totalT21 = $totalT21 + $var;
            $this->fpdf->MultiCell(33, 6, utf8_decode($var), 1, 'C');
        }

        $this->fpdf->SetY(76);
        foreach ($classeDat as $student) {

            $this->fpdf->SetX(180);
            $this->fpdf->SetFont('Arial', 'B', 8);

            $var = versements::where('classe_id', $student->id)->where('date', '<=', $date)->where('motif', "tranche2")->sum('montantverser');

            $totalT2 = $totalT2 + $student->inscription_Classe * count($student->eleves);
            $this->fpdf->MultiCell(33, 6, utf8_decode($student->inscription_Classe * count($student->eleves)), 1, 'C');
        }


        $this->fpdf->SetFont('Arial', 'B', 9);
        $this->fpdf->SetX(3);
        $this->fpdf->Cell(15, 10, $nmr, 1, 0, 'C');
        $this->fpdf->Cell(30, 10, '', 1, 0, 'C');
        $this->fpdf->Cell(33, 10, $totalApe, 1, 0, 'C');
        $this->fpdf->Cell(33, 10, $totalT1, 1, 0, 'C');
        $this->fpdf->Cell(33, 10, $totalT11, 1, 0, 'C');
        $this->fpdf->Cell(33, 10, $totalT21, 1, 0, 'C');
        $this->fpdf->Cell(33, 10, $totalT2, 1, 0, 'C');



        //  CYCLE 2



        $eData = classe::with('eleves')->where('statutClasse', 4)->get();


        foreach ($eData as $classe) {

            if (count($classe->eleves) > 0) {

                $eDat[$classe->id] = $classe;
            }
        }


        $totalApeaCycle2 =  0;
        $nmra = 0;
        $totalT1cycle2 =  0;
        $totalT1cycle2attend =  0;
        $totalT1Cycle2 =  0;
        $totalT2Cycle2 =  0;
        $totalT2Cycle2attend =  0;





        $this->fpdf->SetY(145);
        foreach ($eDat as $student) {

            $this->fpdf->SetX(3);
            $this->fpdf->SetFont('Arial', 'B', 8);

            $nmra = $nmra + count($student->eleves);

            $this->fpdf->MultiCell(15, 6, count($student->eleves), 1, 'C');
        }


        $this->fpdf->SetY(145);
        foreach ($eDat as $student) {

            $this->fpdf->SetX(18);
            $this->fpdf->SetFont('Arial', 'B', 8);
            $this->fpdf->MultiCell(30, 6, $student->libelleClasse, 1, 'C');
        }


        $this->fpdf->SetY(145);
        foreach ($eDat as $student) {

            $this->fpdf->SetX(48);
            $this->fpdf->SetFont('Arial', 'B', 8);

            $var = versements::where('classe_id', $student->id)->where('date', '<=', $date)->where('motif', "APE")->sum('montantverser');

            $totalApeaCycle2 = $totalApeaCycle2 + $var;

            $this->fpdf->MultiCell(33, 6, utf8_decode($var), 1, 'C');
        }


        $this->fpdf->SetY(145);
        foreach ($eDat as $student) {

            $this->fpdf->SetX(81);
            $this->fpdf->SetFont('Arial', 'B', 8);

            $var = versements::where('classe_id', $student->id)->where('date', '<=', $date)->where('motif', "tranche1")->sum('montantverser');
            $totalT1cycle2 = $totalT1cycle2 + $var;
            $this->fpdf->MultiCell(33, 6, utf8_decode($var), 1, 'C');
        }


        $this->fpdf->SetY(145);
        foreach ($eDat as $student) {

            $this->fpdf->SetX(114);
            $this->fpdf->SetFont('Arial', 'B', 8);

            $totalT1cycle2attend = $totalT1cycle2attend + $student->scolarite_Classe * count($student->eleves);

            $this->fpdf->MultiCell(33, 6, utf8_decode($student->scolarite_Classe * count($student->eleves)), 1, 'C');
        }


        $this->fpdf->SetY(145);
        foreach ($eDat as $student) {

            $this->fpdf->SetX(147);
            $this->fpdf->SetFont('Arial', 'B', 8);

            $var = versements::where('classe_id', $student->id)->where('date', '<=', $date)->where('motif', "tranche2")->sum('montantverser');

            $totalT2Cycle2 = $totalT2Cycle2 + $var;
            $this->fpdf->MultiCell(33, 6, utf8_decode($var), 1, 'C');
        }

        $this->fpdf->SetY(145);
        foreach ($eDat as $student) {

            $this->fpdf->SetX(180);
            $this->fpdf->SetFont('Arial', 'B', 8);

            $var = versements::where('classe_id', $student->id)->where('date', '<=', $date)->where('motif', "tranche2")->sum('montantverser');

            $totalT2Cycle2attend = $totalT2Cycle2attend + $student->inscription_Classe * count($student->eleves);
            $this->fpdf->MultiCell(33, 6, utf8_decode($student->inscription_Classe * count($student->eleves)), 1, 'C');
        }


        $this->fpdf->SetFont('Arial', 'B', 9);
        $this->fpdf->SetX(3);
        $this->fpdf->Cell(15, 10, $nmra, 1, 0, 'C');
        $this->fpdf->Cell(30, 10, '', 1, 0, 'C');
        $this->fpdf->Cell(33, 10, $totalApeaCycle2, 1, 0, 'C');
        $this->fpdf->Cell(33, 10, $totalT1cycle2, 1, 0, 'C');
        $this->fpdf->Cell(33, 10, $totalT1cycle2attend, 1, 0, 'C');
        $this->fpdf->Cell(33, 10, $totalT2Cycle2, 1, 0, 'C');
        $this->fpdf->Cell(33, 10, $totalT2Cycle2attend, 1, 0, 'C');
        $this->fpdf->Ln();

        // $this->fpdf->SetY(230);



        $this->fpdf->SetFont('Arial', 'B', 10);
        $this->fpdf->SetX(3);
        $this->fpdf->Cell(15, 10, $nmra + $nmr, 1, 0, 'C');
        $this->fpdf->Cell(30, 10, '', 1, 0, 'C');
        $this->fpdf->Cell(33, 10, $totalApe + $totalApeaCycle2, 1, 0, 'C');
        $this->fpdf->Cell(33, 10, $totalT1 + $totalT1cycle2, 1, 0, 'C');
        $this->fpdf->Cell(33, 10, $totalT11 + $totalT1cycle2attend, 1, 0, 'C');
        $this->fpdf->Cell(33, 10, $totalT21 + $totalT2Cycle2, 1, 0, 'C');
        $this->fpdf->Cell(33, 10,   $totalT2 + $totalT2Cycle2attend, 1, 0, 'C');



        $this->fpdf->Output();
        exit;
    }

    public function getBilanJourRecuPdf($date)
    {



        $conf = config::first();

        $entete = $conf->header;


        $this->fpdf->AddPage("P", ['375', '225']);

        // $this->fpdf->SetTextColor('44', '53', '61');

        $this->fpdf->SetXY(58, 50);
        $this->fpdf->Cell(100, 6, '', 1);

        $this->fpdf->SetFont('Arial', 'B', 10);


        $this->fpdf->Text(89, 54, utf8_decode("Bilan du : " . date('d-m-Y', strtotime($date))));


        $this->fpdf->Image(public_path("/Photos/Logos/" . $entete), 5, 8, 215, 35, "");



        $classeData = classe::with('eleves')->get();


        foreach ($classeData as $classe) {

            if (count($classe->eleves) > 0) {

                $classeDat[$classe->id] = $classe;
            }
        }


        $this->fpdf->SetXY(3, 70);
        $this->fpdf->SetFont('Arial', 'B', 8);
        $this->fpdf->Cell(10, 6, utf8_decode('Eff'), 1, 0, 'C', 0);
        $this->fpdf->Cell(30, 6, 'Classe', 1, 0, 'C', 0);

        $this->fpdf->Cell(60, 6, 'Inscription', 1, 0, 'C', 0);
        $this->fpdf->Cell(60, 6, 'Tranche 1', 1, 0, 'C', 0);
        $this->fpdf->Cell(60, 6, 'Tranche 2', 1, 0, 'C', 0);


        $totalApe =  0;
        $totalT1 =  0;
        $totalT2 =  0;
        $nbr = 0;



        $this->fpdf->SetY(76);
        foreach ($classeDat as $student) {

            $this->fpdf->SetX(3);
            $this->fpdf->SetFont('Arial', 'B', 8);
            $nbr = $nbr + count($student->eleves);
            $this->fpdf->MultiCell(10, 6, count($student->eleves), 1, 'C');
        }



        $this->fpdf->SetY(76);
        foreach ($classeDat as $student) {

            $this->fpdf->SetX(13);
            $this->fpdf->SetFont('Arial', 'B', 8);

            $this->fpdf->MultiCell(30, 6, utf8_decode($student->libelleClasse), 1, 'C');
        }


        $this->fpdf->SetY(76);
        foreach ($classeDat as $student) {

            $this->fpdf->SetX(43);
            $this->fpdf->SetFont('Arial', 'B', 8);

            $var = versements::where('classe_id', $student->id)->where('date', $date)->where('motif', "APE")->sum('montantverser');

            $totalApe = $totalApe + $var;

            $this->fpdf->MultiCell(60, 6, utf8_decode($var), 1, 'C');
        }

        $this->fpdf->SetY(76);
        foreach ($classeDat as $student) {

            $this->fpdf->SetX(103);
            $this->fpdf->SetFont('Arial', 'B', 8);

            $var = versements::where('classe_id', $student->id)->where('date', $date)->where('motif', "tranche1")->sum('montantverser');

            $totalT1 = $totalT1 + $var;

            $this->fpdf->MultiCell(60, 6, utf8_decode($var), 1, 'C');
        }

        $this->fpdf->SetY(76);
        foreach ($classeDat as $student) {

            $this->fpdf->SetX(163);
            $this->fpdf->SetFont('Arial', 'B', 8);

            $var = versements::where('classe_id', $student->id)->where('date', $date)->where('motif', "tranche2")->sum('montantverser');

            $totalT2 = $totalT2 + $var;
            $this->fpdf->MultiCell(60, 6, utf8_decode($var), 1, 'C');
        }


        $this->fpdf->SetFont('Arial', 'B', 10);
        $this->fpdf->SetX(3);
        $this->fpdf->Cell(10, 10,  $nbr, 1, 0, 'C');
        $this->fpdf->Cell(30, 10, "", 1, 0, 'C');
        $this->fpdf->Cell(60, 10, $totalApe, 1, 0, 'C');
        $this->fpdf->Cell(60, 10, $totalT1, 1, 0, 'C');
        $this->fpdf->Cell(60, 10, $totalT2, 1, 0, 'C');

















        $this->fpdf->Output();

        exit;
    }

    public function getAllProcesVerbalTrimestre2($idtrim)

    {

        $conf = config::first();

        $entete = $conf->header;




        $data =  explode('*', $idtrim);



        $IdClasse = $data[0];
        $IdTrimmestre  = $data[1];


        $code  =   Classe::with(['eleves' => function ($query) {
            $query->where('statut', '!=', 3)->orderBy('nom')->orderBy('prenom');
        }])->where('id', $IdClasse)->first();



        $codeEtab = $code['codeEtabClasse'];
        $session = $code['sessionClasse'];



        $Evalutions = Evaluations::with('trimestre')->where('trimestre_id', $IdTrimmestre)->where('session', $session)
            ->where('codeEtab', $codeEtab)->get();


        $idEval1 = $Evalutions[0]->id;
        $libelleEval1 = $Evalutions[0]->libelle;

        $idEval2 = $Evalutions[1]->id;
        $libelleEval2 = $Evalutions[1]->libelle;

        $libelleTrimestre = $Evalutions[0]->trimestre->libelle_semes;





        $this->fpdf->AddPage("P", ['290', '215']);


        $this->fpdf->SetXY(78, 50);
        $this->fpdf->Cell(65, 6, '', 1);

        $this->fpdf->SetFont('Arial', 'B', 9);

        $this->fpdf->Text(89, 54, utf8_decode("ANNEE-SCOLAIRE : $session "));


        $this->fpdf->Image(public_path("/Photos/Logos/" . $entete), 5, 8, 215, 35, "");


        $this->fpdf->SetFont('Arial', 'B', 20);


        $this->fpdf->SetTextColor('10', '75', '168');
        $this->fpdf->Text(10, 70, utf8_decode("PROCES VERBAL DE CONSEIL DE CLASSE [ TRIMESTRE $IdTrimmestre ]"));

        $this->fpdf->SetFont('Arial', 'B', 8);


        $this->fpdf->SetTextColor('0', '0', '0');
        $classe = Classe::where('id', $IdClasse)->first();


        $moyGen = MoyenneTrimestres::where('classe_id', $IdClasse)->where('trimestre_id', $IdTrimmestre)->where('session', $session)
            ->where('codeEtab', $codeEtab)->sum('valeur');


        $profPricin = Enseignants::where('id', $classe['principale_Classe'])->first();

        $effectif = count($code['eleves']);





        $this->fpdf->SetFont('Arial', 'B', 10);



        $this->fpdf->Text(10, 82, utf8_decode("Classe : " . $code['libelleClasse']));




        $this->fpdf->Text(75, 82, utf8_decode("PROF TITULAIRE : " . $profPricin['nom'] . " " . $profPricin['prenom']));


        $this->fpdf->Text(195, 82, utf8_decode("EFF :  $effectif "));


        $this->fpdf->SetXY(3, 90);
        $this->fpdf->SetFont('Arial', 'B', 8);
        // $this->fpdf->SetDrawColor(0, 0, 0);
        $this->fpdf->SetFillColor('159', '159', '159');
        $this->fpdf->SetTextColor('0', '0', '0');
        $this->fpdf->Cell(7, 12, utf8_decode('Nº'), 1, 0, 'C', 1);
        $this->fpdf->Cell(60, 12, utf8_decode('Noms et prénoms'), 1, 0, 'C', 1);
        $this->fpdf->SetFont('Arial', 'B', 6);
        $this->fpdf->Cell(16, 12, 'Date Naiss', 1, 0, 'C', 1);
        $this->fpdf->SetFont('Arial', 'B', 6);
        $this->fpdf->Cell(10, 12, 'SEXE', 1, 0, 'C', 1);
        $this->fpdf->SetFont('Arial', 'B', 6);
        $this->fpdf->Cell(10, 12, 'RED', 1, 0, 'C', 1);

        $this->fpdf->Cell(48, 6, '' . strtoupper('TRAVAIL DU TRIMESTRE'), 1, 0, 'C', 1);
        $this->fpdf->Cell(20, 6, '' . strtoupper('DISCIPLINE'), 1, 0, 'C', 1);

        $idEv1 = $idEval1 - 1;
        $idEv2 = $idEval2 - 1;

        // $classeData = Student::with('user', 'classe')->where('classe_id', $IdClasse)
        //     ->where('session', $session)->where('codeEtab', $codeEtab)->orderBy('nom', 'ASC')->orderBy('prenom', 'ASC')->get();



        $this->fpdf->SetXY(106, 96);
        $this->fpdf->Cell(11, 6, " Moy EV$idEv1", 1, 0, 'C', 1);
        $this->fpdf->Cell(11, 6, " Moy EV$idEv2", 1, 0, 'C', 1);
        $this->fpdf->Cell(13, 6, " Moy  T$IdTrimmestre", 1, 0, 'C', 1);
        $this->fpdf->Cell(13, 6, " Rang ", 1, 0, 'C', 1);


        $this->fpdf->Cell(10, 6, "ABS", 1, 0, 'C', 1);
        $this->fpdf->Cell(10, 6, "ANJ", 1, 0, 'C', 1);

        $this->fpdf->SetXY(174, 90);

        $this->fpdf->Cell(40, 12, 'DECISION DU CONSEIL', 1, 0, 'C', 1);

        $this->fpdf->SetY(102);



        // KEY

        $Taillecell = 10;
        $TailleText = 8;



        foreach ($code->eleves as $key => $student) {





            $this->fpdf->SetX(3);

            $this->fpdf->SetFont('Arial', 'B', $TailleText);

            $this->fpdf->Cell(7, $Taillecell, $key + 1, 1, 0, 'C');

            $nm = $student->nom . ' ' . $student->prenom;

            $this->fpdf->Cell(60, $Taillecell, substr(utf8_decode($nm), 0, 30), 1, 0, 'L');

            $this->fpdf->Cell(16, $Taillecell, utf8_decode(date_format(date_create($student->dateNaiss), "d/m/Y")), 1, 0, 'L');

            $this->fpdf->Cell(10, $Taillecell, utf8_decode($student->sexe), 1, 0, 'C');

            if ($student->doublant == 'ANCIENNE') {

                $student->doublant = "Oui";
            } else {

                $student->doublant = "Non";
            }

            $this->fpdf->Cell(10, $Taillecell, utf8_decode($student->doublant), 1, 0, 'C');

            $moyEv1 = Moyennes::where('student_id', $student->id)->where('evaluation_id', $idEval1)->where('session', $session)
                ->where('codeEtab', $codeEtab)->first();

            $moyEv2 = Moyennes::where('student_id', $student->id)->where('evaluation_id', $idEval2)->where('session', $session)
                ->where('codeEtab', $codeEtab)->first();

            $this->fpdf->SetFont('Arial', 'B', $TailleText + 2);


            $this->fpdf->Cell(11, $Taillecell, $moyEv1['valeur'], 1, 0, 'C');


            $this->fpdf->Cell(11, $Taillecell, $moyEv2['valeur'], 1, 0, 'C');



            $moyTrimAll = MoyenneTrimestres::where('classe_id', $IdClasse)->where('trimestre_id', $IdTrimmestre)->where('session', $session)
                ->where('codeEtab', $codeEtab)->where('valeur', '>=', 0)->orderBy('valeur', 'DESC')->get();


            foreach ($moyTrimAll as $key => $moy) {


                if ($moy->student_id == $student->id) {


                    $this->fpdf->Cell(13, $Taillecell, $moy->valeur, 1, 0, 'C');
                    if ($key + 1 == 1) {
                        $label = utf8_decode("er");
                    } else {
                        $label = utf8_decode("è");
                    }

                    $this->fpdf->Cell(13, $Taillecell,  $key + 1 . "" . $label, 1, 0, 'C');
                }
            }



            // ABSENCES

            $heureTrimestre  = Presences::where('classe_id', $IdClasse)
                ->where('trimestre_id', $IdTrimmestre)->where('student_id', $student->id)
                ->where('codeEtab', $codeEtab)
                ->where('session', $session)->sum('duree');


            // Absences  justifies

            $heureTrimestreJustifies = Presences::where('classe_id',  $IdClasse)
                ->where('trimestre_id', $IdTrimmestre)->where('student_id', $student->id)
                ->where('codeEtab', $codeEtab)
                ->where('session', $session)->sum('etat');

            $this->fpdf->Cell(10, $Taillecell, $heureTrimestre, 1, 0, 'C');
            $this->fpdf->Cell(10, $Taillecell, ($heureTrimestre - $heureTrimestreJustifies), 1, 0, 'C');
            $this->fpdf->Cell(40, $Taillecell, '', 1, 0, 'C');

            $this->fpdf->Ln($Taillecell);
        }



        $this->fpdf->Ln(10);

        $this->fpdf->SetX(3);



        $pourcent =  0;


        foreach ($moyTrimAll as $key => $moy) {
            if ($moy->valeur >= 10) {
                $pourcent++;
            }
        }


        $this->fpdf->Cell(70, 5, ' MOYENNE GENERALE ', 1, 0, 'C', 1);


        $this->fpdf->Cell(70, 5, ' POURCENTAGE REUSSITE ', 1, 0, 'C', 1);

        $this->fpdf->Cell(70, 5, ' POURCENTAGE ECHEC ', 1, 0, 'C', 1);

        $this->fpdf->Ln();

        $this->fpdf->SetFont('Arial', 'B', 20);

        $this->fpdf->SetX(3);




        $this->fpdf->Cell(70, 12, (number_format(($moyGen / $effectif), 2)) . "  / 20 ", 1, 0, 'C');



        $this->fpdf->Cell(70, 12, number_format(($pourcent / $effectif) * 100, 2) . " % ", 1, 0, 'C');

        $this->fpdf->Cell(70, 12, (100 - number_format(($pourcent / $effectif) * 100, 2)) . " % ", 1, 0, 'C');









        // // Rang Trimestre






        $this->fpdf->Output();

        exit;
    }

    // public function getAllProcesVerbalTrimestre2($idtrim)

    // {

    //     $conf = config::first();

    //     $entete = $conf->header;



    //     // $data =  explode('*', $idClasse);
    //     // $IdClasse = $data[0];
    //     $code  =   Classe::with(['eleves' => function ($query) {
    //         $query->where('statut', '!=', 3)->orderBy('nom')->orderBy('prenom');
    //     }])->get();

    //     $IdTrimmestre  = $idtrim;












    //     $codeEtab = $code[0]->codeEtabClasse;
    //     $session = $code[0]->sessionClasse;



    //     $Evalutions = Evaluations::with('trimestre')->where('trimestre_id', $IdTrimmestre)->where('session', $session)
    //         ->where('codeEtab', $codeEtab)->get();



    //     $idEval1 = $Evalutions[0]->id;
    //     $libelleEval1 = $Evalutions[0]->libelle;

    //     $idEval2 = $Evalutions[1]->id;
    //     $libelleEval2 = $Evalutions[1]->libelle;

    //     $libelleTrimestre = $Evalutions[0]->trimestre->libelle_semes;







    //     foreach ($code as $class) {


    //         $this->fpdf->AddPage("P", ['290', '215']);


    //         $this->fpdf->SetXY(78, 50);
    //         $this->fpdf->Cell(65, 6, '', 1);

    //         $this->fpdf->SetFont('Arial', 'B', 9);

    //         $this->fpdf->Text(89, 54, utf8_decode("ANNEE-SCOLAIRE : $session "));


    //         $this->fpdf->Image(public_path("/Photos/Logos/" . $entete), 5, 8, 215, 35, "");


    //         $this->fpdf->SetFont('Arial', 'B', 20);


    //         $this->fpdf->SetTextColor('10', '75', '168');
    //         $this->fpdf->Text(10, 70, utf8_decode("PROCES VERBAL DE CONSEIL DE CLASSE [ TRIMETRE $IdTrimmestre ]"));

    //         $this->fpdf->SetFont('Arial', 'B', 8);

    //         // $this->fpdf->line(25, 84, 38, 84); // trait souligne classe



    //         // $this->fpdf->SetTextColor('0', '0', '0');
    //         // $classe = Classe::where('id', $class->id)->first();


    //         $moyGen[$class->id] = MoyenneTrimestres::where('classe_id', $class->id)->where('trimestre_id', $IdTrimmestre)->where('session', $session)
    //             ->where('codeEtab', $codeEtab)->sum('valeur');


    //         $profPricin = Enseignants::where('id', $class['principale_Classe'])->first();




    //         $effectif = count($class->eleves);

    //         $this->fpdf->SetFont('Arial', 'B', 10);

    //         $this->fpdf->Text(10, 82, utf8_decode("Classe : $class->libelleClasse"));




    //         $this->fpdf->Text(75, 82, utf8_decode("PROF TITULAIRE : " . $profPricin['nom'] . " " . $profPricin['prenom']));


    //         $this->fpdf->Text(195, 82, utf8_decode("EFF :  $effectif "));



    //         // $this->fpdf->line(150, 84, 168, 84); // trait souligne trimstre



    //         $this->fpdf->SetXY(3, 90);
    //         $this->fpdf->SetFont('Arial', 'B', 8);
    //         // $this->fpdf->SetDrawColor(0, 0, 0);
    //         $this->fpdf->SetFillColor('159', '159', '159');
    //         $this->fpdf->SetTextColor('0', '0', '0');
    //         $this->fpdf->Cell(7, 12, utf8_decode('Nº'), 1, 0, 'C', 1);
    //         $this->fpdf->Cell(60, 12, utf8_decode('Noms et prénoms'), 1, 0, 'C', 1);
    //         $this->fpdf->SetFont('Arial', 'B', 6);
    //         $this->fpdf->Cell(16, 12, 'Date Naiss', 1, 0, 'C', 1);
    //         $this->fpdf->SetFont('Arial', 'B', 6);
    //         $this->fpdf->Cell(10, 12, 'SEXE', 1, 0, 'C', 1);
    //         $this->fpdf->SetFont('Arial', 'B', 6);
    //         $this->fpdf->Cell(10, 12, 'RED', 1, 0, 'C', 1);

    //         $this->fpdf->Cell(48, 6, '' . strtoupper('TRAVAIL'), 1, 0, 'C', 1);
    //         $this->fpdf->Cell(20, 6, '' . strtoupper('DISCIPLINE'), 1, 0, 'C', 1);

    //         $idEv1 = $idEval1 - 1;
    //         $idEv2 = $idEval2 - 1;

    //         // $classeData = Student::with('user', 'classe')->where('classe_id', $IdClasse)
    //         //     ->where('session', $session)->where('codeEtab', $codeEtab)->orderBy('nom', 'ASC')->orderBy('prenom', 'ASC')->get();



    //         $this->fpdf->SetXY(106, 96);
    //         $this->fpdf->Cell(11, 6, " Moy EV$idEv1", 1, 0, 'C', 1);
    //         $this->fpdf->Cell(11, 6, " Moy EV$idEv2", 1, 0, 'C', 1);
    //         $this->fpdf->Cell(13, 6, " Moy  T$IdTrimmestre", 1, 0, 'C', 1);
    //         $this->fpdf->Cell(13, 6, " Rang ", 1, 0, 'C', 1);


    //         $this->fpdf->Cell(10, 6, "ABS", 1, 0, 'C', 1);
    //         $this->fpdf->Cell(10, 6, "ANJ", 1, 0, 'C', 1);

    //         $this->fpdf->SetXY(174, 90);

    //         $this->fpdf->Cell(54, 12, 'DECISION DU CONSEIL', 1, 0, 'L', 1);

    //         $this->fpdf->SetY(102);



    //         // KEY

    //         $Taillecell = 10;
    //         $TailleText = 8;



    //         foreach ($class->eleves as $key => $student) {





    //             $this->fpdf->SetX(3);

    //             $this->fpdf->SetFont('Arial', 'B', $TailleText);

    //             $this->fpdf->Cell(7, $Taillecell, $key + 1, 1, 0, 'C');

    //             $nm = $student->nom . ' ' . $student->prenom;

    //             $this->fpdf->Cell(60, $Taillecell, substr(utf8_decode($nm), 0, 30), 1, 0, 'L');

    //             $this->fpdf->Cell(16, $Taillecell, utf8_decode(date_format(date_create($student->dateNaiss), "d/m/Y")), 1, 0, 'L');

    //             $this->fpdf->Cell(10, $Taillecell, utf8_decode($student->sexe), 1, 0, 'C');

    //             if ($student->doublant == 'ANCIENNE') {

    //                 $student->doublant = "Oui";
    //             } else {

    //                 $student->doublant = "Non";
    //             }

    //             $this->fpdf->Cell(10, $Taillecell, utf8_decode($student->doublant), 1, 0, 'C');

    //             $moyEv1 = Moyennes::where('student_id', $student->id)->where('evaluation_id', $idEval1)->where('session', $session)
    //                 ->where('codeEtab', $codeEtab)->first();

    //             $moyEv2 = Moyennes::where('student_id', $student->id)->where('evaluation_id', $idEval2)->where('session', $session)
    //                 ->where('codeEtab', $codeEtab)->first();



    //             $this->fpdf->Cell(11, $Taillecell, $moyEv1['valeur'], 1, 0, 'C');


    //             $this->fpdf->Cell(11, $Taillecell, $moyEv2['valeur'], 1, 0, 'C');



    //             $moyTrimAll = MoyenneTrimestres::where('classe_id', $class->id)->where('trimestre_id', $IdTrimmestre)->where('session', $session)
    //                 ->where('codeEtab', $codeEtab)->where('valeur', '>=', 0)->orderBy('valeur', 'DESC')->get();


    //             foreach ($moyTrimAll as $key => $moy) {
    //                 if ($moy->student_id == $student->id) {

    //                     $this->fpdf->Cell(13, $Taillecell, $moy->valeur, 1, 0, 'C');

    //                     if ($key + 1 == 1) {
    //                         $label = utf8_decode("er");
    //                     } else {
    //                         $label = utf8_decode("è");
    //                     }

    //                     $this->fpdf->Cell(13, $Taillecell,  $key + 1 . " " . $label, 1, 0, 'C');
    //                 }
    //             }



    //             // ABSENCES

    //             $heureTrimestre  = Presences::where('classe_id', $class->id)
    //                 ->where('trimestre_id', $IdTrimmestre)->where('student_id', $student->id)
    //                 ->where('codeEtab', $codeEtab)
    //                 ->where('session', $session)->sum('duree');


    //             // Absences  justifies

    //             $heureTrimestreJustifies = Presences::where('classe_id',  $class->id)
    //                 ->where('trimestre_id', $IdTrimmestre)->where('student_id', $student->id)
    //                 ->where('codeEtab', $codeEtab)
    //                 ->where('session', $session)->sum('etat');

    //             $this->fpdf->Cell(10, $Taillecell, $heureTrimestre, 1, 0, 'C');
    //             $this->fpdf->Cell(10, $Taillecell, ($heureTrimestre - $heureTrimestreJustifies), 1, 0, 'C');
    //             $this->fpdf->Cell(54, $Taillecell, '', 1, 0, 'C');

    //             $this->fpdf->Ln($Taillecell);
    //         }



    //         $this->fpdf->Ln(10);

    //         $this->fpdf->SetX(3);



    //         $pourcent =  0;


    //         foreach ($moyTrimAll as $key => $moy) {
    //             if ($moy->valeur >= 10) {
    //                 $pourcent++;
    //             }
    //         }


    //         $this->fpdf->Cell(70, 5, ' MOYENNE GENERALE DE LA CLASSE', 1, 0, 'C', 1);


    //         $this->fpdf->Cell(70, 5, ' POURCENTAGE REUSSITE DE LA CLASSE', 1, 0, 'C', 1);

    //         $this->fpdf->Cell(70, 5, ' POURCENTAGE ECHEC DE LA CLASSE', 1, 0, 'C', 1);

    //         $this->fpdf->Ln();

    //         $this->fpdf->SetFont('Arial', 'B', 20);

    //         $this->fpdf->SetX(3);




    //         $this->fpdf->Cell(70, 12, (number_format(($moyGen[$class->id] / $effectif), 2)) . "  / 20 ", 1, 0, 'C');



    //         $this->fpdf->Cell(70, 12, number_format(($pourcent / $effectif) * 100, 2) . " % ", 1, 0, 'C');

    //         $this->fpdf->Cell(70, 12, (100 - number_format(($pourcent / $effectif) * 100, 2)) . " % ", 1, 0, 'C');
    //     }













    //     // // Rang Trimestre






    //     $this->fpdf->Output();

    //     exit;
    // }






    public function getAllProcesVerbalAnnuel($idClasse)

    {

        $conf = config::first();

        $entete = $conf->header;


        // IdEvalauation = IdTrimestre (normalement)

        $data =  explode('*', $idClasse);
        $IdClasse = $data[0];


        $code = Classe::where('id', $IdClasse)->first();
        $codeEtab = $code->codeEtabClasse;
        $session = $code->sessionClasse;



        $Trimestres  = Trimestre::where('codeEta_semes', $codeEtab)->get();





        // Les Id des trimestres

        $idEval1 = $Trimestres[0]->id;
        $idEval2 = $Trimestres[1]->id;
        $idEval3 = $Trimestres[2]->id;






        $this->fpdf->AddPage("P", ['375', '225']);

        // $this->fpdf->SetTextColor('44', '53', '61');

        $this->fpdf->SetXY(58, 50);
        $this->fpdf->Cell(100, 6, '', 1);

        $this->fpdf->SetFont('Arial', 'B', 9);

        $this->fpdf->Text(89, 54, utf8_decode("ANNEE SCOLAIRE : $session "));


        $this->fpdf->Image(public_path("/Photos/Logos/" . $entete), 5, 8, 215, 35, "");

        $this->fpdf->SetFont('Arial', 'B', 22);

        $this->fpdf->Text(8, 70, utf8_decode(" PROCES VERBAL ANNUEL DE CONSEIL DE CLASSE "));

        $this->fpdf->SetFont('Arial', 'B', 10);

        //  $this->fpdf->line(25, 84, 38, 84); // trait souligne classe

        $moys = MoyenneAnnuelle::with('student')->where('classe_id', $IdClasse)->where('session', $session)
            ->where('codeEtab', $codeEtab)->where('valeur', '>', 0)->orderBy('valeur', 'DESC')->get();

        $effectif = count($moys);

        $this->fpdf->Text(10, 82, utf8_decode("CLASSE :  $code->libelleClasse"));

        $this->fpdf->Text(70, 82, utf8_decode("Effectif : $effectif "));




        $classe = Classe::where('id', $IdClasse)->first();

        $profPricin = Enseignants::where('id', $classe['principale_Classe'])->first();


        $this->fpdf->Text(120, 82, utf8_decode("Prof. principal :  $profPricin->nom"));


        // $this->fpdf->line(150, 84, 160, 84); // trait souligne Effectif



        $this->fpdf->SetXY(1, 90);
        $this->fpdf->SetFont('Arial', 'B', 8);
        // $this->fpdf->SetDrawColor(0, 0, 0);
        $this->fpdf->SetFillColor('10', '75', '168');
        // $this->fpdf->SetTextColor('0', '0', '0');
        $this->fpdf->Cell(7, 12, utf8_decode(''), 1, 0, 'L', 1);
        $this->fpdf->Cell(60, 12, 'NOMS et PRENOMS', 1, 0, 'L', 1);
        $this->fpdf->SetFont('Arial', 'B', 6);
        $this->fpdf->Cell(14, 12, 'NE(E) LE ', 1, 0, 'C', 1);

        $this->fpdf->Cell(7, 12, 'SEXE', 1, 0, 'L', 1);
        $this->fpdf->SetFont('Arial', 'B', 6);
        $this->fpdf->Cell(6, 12, 'RED', 1, 0, 'C', 1);

        $this->fpdf->Cell(77, 6, '' . strtoupper('TRAVAIL GLOBAL ANNUEL'), 1, 0, 'C', 1);
        $this->fpdf->Cell(14, 6, '' . strtoupper('DISCIPLINE'), 1, 0, 'C', 1);


        $classeData = Student::with('user', 'classe')->where('classe_id', $IdClasse)
            ->where('session', $session)->where('codeEtab', $codeEtab)->orderBy('nom', 'ASC')->orderBy('prenom', 'ASC')->get();



        // dd($effectif);


        $this->fpdf->SetXY(95, 96);

        $this->fpdf->SetFont('Arial', 'B', 9);
        $this->fpdf->Cell(11, 6, " ME1", 1, 0, 'C', 0);
        $this->fpdf->Cell(11, 6, " ME2", 1, 0, 'C', 0);
        $this->fpdf->Cell(11, 6, " ME3", 1, 0, 'C', 0);
        $this->fpdf->Cell(11, 6, " ME4", 1, 0, 'C', 0);
        $this->fpdf->Cell(11, 6, " ME5", 1, 0, 'C', 0);

        $this->fpdf->Cell(11, 6, "MA", 1, 0, 'C', 0);
        $this->fpdf->Cell(11, 6, "RA", 1, 0, 'C', 0);
        $this->fpdf->Cell(7, 6, "AJ", 1, 0, 'C', 0);
        $this->fpdf->Cell(7, 6, "ANJ", 1, 0, 'C', 0);
        // $this->fpdf->Cell(7, 6, "TH", 1, 0, 'C', 0);

        // $this->fpdf->Cell(7, 6, "ANJ", 1, 0, 'C', 0);
        // $this->fpdf->Cell(7, 6, "AVC", 1, 0, 'C', 0);
        // $this->fpdf->Cell(7, 6, "BLC", 1, 0, 'C', 0);
        // $this->fpdf->Cell(7, 6, "JE", 1, 0, 'C', 0);

        $this->fpdf->SetXY(186, 90);
        $this->fpdf->SetFont('Arial', 'B', 8);
        $this->fpdf->Cell(38, 12, 'DECISION CONSEIL', 1, 0, 'C', 1);

        // $this->fpdf->SetY(102);


        $long  = 6;
        $larg  = 7;
        $this->fpdf->SetY(102);

        $MoysE1 = $this->getAllMoyenneSequenveByIdEval($idEval = 2, $idClasse = $IdClasse);
        $MoysE2 = $this->getAllMoyenneSequenveByIdEval($idEval = 3, $idClasse = $IdClasse);
        $MoysE3 = $this->getAllMoyenneSequenveByIdEval($idEval = 4, $idClasse = $IdClasse);
        $MoysE4 = $this->getAllMoyenneSequenveByIdEval($idEval = 5, $idClasse = $IdClasse);
        $MoysE5 = $this->getAllMoyenneSequenveByIdEval($idEval = 6, $idClasse = $IdClasse);





        foreach ($moys as $key => $student) {


            $this->fpdf->SetX(1);
            $this->fpdf->SetFont('Arial', 'B', 8);
            $this->fpdf->Cell($larg, $long, $key + 1, 1, 'C');

            $this->fpdf->SetFont('Arial', 'B', 7);

            $this->fpdf->Cell(60, $long, $student->student->nom . ' ' . $student->student->prenom, 1, 'C');



            $this->fpdf->Cell(14, $long, $student->student->dateNaiss, 1, 0, 'C', 0);
            $this->fpdf->Cell(7, $long, $student->student->sexe, 1, 0, 'C', 0);
            $this->fpdf->Cell(6, $long, $student->student->doublant, 1, 0, 'C', 0);



            $results1 = $this->getMoyEvalStudentAndRankAnnuelById($idStudent = $student->student_id, $EvalId = 2, $idClasse = $idClasse, $moyEval = $MoysE1);
            $results2 = $this->getMoyEvalStudentAndRankAnnuelById($idStudent = $student->student_id, $EvalId = 3, $idClasse = $idClasse, $moyEval = $MoysE2);
            $results3 = $this->getMoyEvalStudentAndRankAnnuelById($idStudent = $student->student_id, $EvalId = 4, $idClasse = $idClasse, $moyEval = $MoysE3);
            $results4 = $this->getMoyEvalStudentAndRankAnnuelById($idStudent = $student->student_id, $EvalId = 5, $idClasse = $idClasse, $moyEval = $MoysE4);
            $results5 = $this->getMoyEvalStudentAndRankAnnuelById($idStudent = $student->student_id, $EvalId = 6, $idClasse = $idClasse, $moyEval = $MoysE5);


            $this->fpdf->SetFont('Arial', 'B', 9);
            $this->fpdf->Cell(11, $long,  $results1['moy'] ? $results1['moy'] : '-', 1, 0, 'C', 1);
            $this->fpdf->Cell(11, $long,  $results2['moy'] ? $results2['moy'] : '-', 1, 0, 'C', 1);
            $this->fpdf->Cell(11, $long,  $results3['moy'] ? $results3['moy'] : '-', 1, 0, 'C', 1);
            $this->fpdf->Cell(11, $long,  $results4['moy'] ? $results4['moy'] : '-', 1, 0, 'C', 1);
            $this->fpdf->Cell(11, $long,  $results5['moy'] ? $results5['moy'] : '-', 1, 0, 'C', 1);

            $this->fpdf->Cell(11, $long, $student->valeur, 1, 0, 'C', 1);

            $this->fpdf->Cell(11, $long, $key + 1, 1, 0, 'C', 1);


            // ABSENCES

            $heureTrimestre  = Presences::where('classe_id', $IdClasse)
                ->where('student_id', $student->student->id)
                ->sum('duree');


            // Absences  justifies

            $heureTrimestreJustifies = Presences::where('classe_id',  $IdClasse)
                ->where('student_id', $student->student->id)
                ->sum('etat');


            $this->fpdf->Cell(7, $long, $heureTrimestreJustifies, 1, 0, 'C', 1);

            $this->fpdf->Cell(7, $long, $heureTrimestre, 1, 0, 'C', 1);

            $this->fpdf->Cell(38, $long, '', 1, 0, 'C', 0);

            $this->fpdf->Ln($long);
        }


        $code  =   Classe::with(['eleves' => function ($query) {
            $query->where('statut', '!=', 3)->orderBy('nom')->orderBy('prenom');
        }])->where('id', $IdClasse)->first();

        $this->fpdf->Ln(10);

        $this->fpdf->SetX(3);



        $pourcent =  0;


        foreach ($moys as $key => $moy) {
            if ($moy->valeur >= 10) {
                $pourcent++;
            }
        }


        $this->fpdf->Cell(70, 5, ' MOYENNE GENERALE ', 1, 0, 'C', 1);


        $this->fpdf->Cell(70, 5, ' POURCENTAGE REUSSITE ', 1, 0, 'C', 1);

        $this->fpdf->Cell(70, 5, ' POURCENTAGE ECHEC ', 1, 0, 'C', 1);

        $this->fpdf->Ln();

        $this->fpdf->SetFont('Arial', 'B', 20);

        $this->fpdf->SetX(3);


        $moyGen = MoyenneAnnuelle::where('classe_id', $IdClasse)->where('session', $session)
            ->where('codeEtab', $codeEtab)->sum('valeur');




        $this->fpdf->Cell(70, 12, (number_format(($moyGen / $effectif), 2)) . "  / 20 ", 1, 0, 'C');



        $this->fpdf->Cell(70, 12, number_format(($pourcent / $effectif) * 100, 2) . " % ", 1, 0, 'C');

        $this->fpdf->Cell(70, 12, (100 - number_format(($pourcent / $effectif) * 100, 2)) . " % ", 1, 0, 'C');






        $this->fpdf->Output();

        exit;
    }


    public function DemissionairePdf($idClasse)

    {




        $conf = config::first();

        $entete = $conf->header;


        $session = Session::where('encours_sess', 1)->first();

        $sessionEncour = $session->libelle_sess;

        $codeEtab = $session->codeEtab_sess;

        // La classe et le total de ses finances


        //  $classesInfos = Classe::get();


        $classesInfos =   Student::with('classe')->where('statut', 3)->get();



        $etab =  Etablissement::where('codeEtab', $codeEtab)->first();


        $this->fpdf->AddPage("P", ['297', '210']);



        $this->fpdf->SetFont('Arial', 'B', 12);

        $this->fpdf->Text(80, 65, utf8_decode(" Année-scolaire : $sessionEncour "));

        $this->fpdf->SetFont('Arial', 'B', 20);



        $this->fpdf->Image(public_path("/Photos/Logos/" . $entete), 0, 0, 210, 40,  "");

        $this->fpdf->SetFont('Arial', 'B', 20);

        $this->fpdf->Text(25, 55, utf8_decode("  LISTE DES ELEVES DEMISSIONAIRES"));

        $this->fpdf->SetFont('Arial', 'B', 7);
        $this->fpdf->Text(65, 70, utf8_decode(" Rapport fait automatiquement  par l'application Le :  " . date('j/m/Y  H:i:s')));






        $this->fpdf->SetXY(3, 75);
        $this->fpdf->SetFont('Arial', 'B', 10);
        $this->fpdf->SetDrawColor(0, 0, 0);
        $this->fpdf->SetFillColor('159', '159', '159');
        $this->fpdf->SetTextColor('0', '0', '0');
        $this->fpdf->Cell(10, 15, '', 1, 0, 'C', 1);
        $this->fpdf->Cell(30, 15, 'MATRICULE', 1, 0, 'C', 1);
        $this->fpdf->Cell(125, 15, 'NOMS ET PRENOMS', 1, 0, 'C', 1);
        $this->fpdf->Cell(40, 15, 'CLASSE', 1, 0, 'C', 1);


        $this->fpdf->Ln();
        foreach ($classesInfos as $key => $eleve) {



            $Taillecell = 10;


            $this->fpdf->SetFont('Arial', 'B', 9);

            $this->fpdf->SetX(3);
            $this->fpdf->Cell(10, $Taillecell, $key + 1, 1, 0, 'C');
            $this->fpdf->Cell(30, $Taillecell, $eleve->matricule, 1, 0, 'C');
            $this->fpdf->Cell(125, $Taillecell, $eleve->nom . ' ' . $eleve->prenom, 1, 0, 'L');
            $this->fpdf->Cell(40, $Taillecell, $eleve->classe->libelleClasse, 1, 0, 'C');
            // $this->fpdf->Cell(55, $Taillecell, $eleve->lieuNaiss, 1, 0, 'C');

            $this->fpdf->Ln($Taillecell);
        }

        $this->fpdf->Output();

        exit;
    }

    public function InsolvablesPdf($idClasse)
    {




        $conf = config::first();

        $entete = $conf->header;


        $session = Session::where('encours_sess', 1)->first();

        $sessionEncour = $session->libelle_sess;

        $codeEtab = $session->codeEtab_sess;

        // La classe et le total de ses finances


        //  $classesInfos = Classe::get();


        $classesInfos =   Classe::with(['eleves' => function ($query) {
            $query->where('statut', '!=', 2)->orderBy('nom')->orderBy('prenom');
        }])->get();

        $etab =  Etablissement::where('codeEtab', $codeEtab)->first();


        foreach ($classesInfos as $classe) {



            $this->fpdf->AddPage("P", ['297', '210']);



            $this->fpdf->SetFont('Arial', 'B', 12);

            $this->fpdf->Text(80, 65, utf8_decode(" Année-scolaire : $classe->sessionClasse "));

            $this->fpdf->SetFont('Arial', 'B', 20);



            $this->fpdf->Image(public_path("/Photos/Logos/" . $entete), 0, 0, 210, 40,  "");

            $this->fpdf->SetFont('Arial', 'B', 20);

            $this->fpdf->Text(25, 55, utf8_decode("  LISTE INSOLVABLES  EN : $classe->libelleClasse  "));

            $this->fpdf->SetFont('Arial', 'B', 7);
            $this->fpdf->Text(65, 70, utf8_decode(" Rapport fait automatiquement  par l'application Le :  " . date('j/m/Y  H:i:s')));



            $this->fpdf->SetXY(3, 75);
            $this->fpdf->SetFont('Arial', 'B', 10);
            $this->fpdf->SetDrawColor(0, 0, 0);
            $this->fpdf->SetFillColor('159', '159', '159');
            $this->fpdf->SetTextColor('0', '0', '0');
            $this->fpdf->Cell(10, 15, '', 1, 0, 'C', 1);
            $this->fpdf->Cell(30, 15, 'MATRICULE', 1, 0, 'C', 1);
            $this->fpdf->Cell(95, 15, 'NOMS ET PRENOMS', 1, 0, 'C', 1);
            $this->fpdf->Cell(20, 15, 'DATE', 1, 0, 'C', 1);
            $this->fpdf->Cell(55, 15, 'LIEUX', 1, 0, 'C', 1);

            $Taillecell = 10;

            $this->fpdf->Ln();

            $this->fpdf->SetFont('Arial', 'B', 9);


            foreach ($classe->eleves as $key => $eleve) {


                $this->fpdf->SetX(3);
                $this->fpdf->Cell(10, $Taillecell, $key + 1, 1, 0, 'C');
                $this->fpdf->Cell(30, $Taillecell, $eleve->matricule, 1, 0, 'C');
                $this->fpdf->Cell(95, $Taillecell, $eleve->nom . ' ' . $eleve->prenom, 1, 0, 'L');
                $this->fpdf->Cell(20, $Taillecell, $eleve->dateNaiss, 1, 0, 'C');
                $this->fpdf->Cell(55, $Taillecell, $eleve->lieuNaiss, 1, 0, 'C');

                $this->fpdf->Ln($Taillecell);



                // nombre non inscrits


                $datasNombre  = Student::with('classe')->where('classe_id', $classe->id)
                    ->where('statut', 2)
                    ->orderBy('nom')->orderBy('prenom')->count();


                // nombre eleve


                $datasEffectif = Student::with('classe')->where('classe_id', $classe->id)

                    ->orderBy('nom')->orderBy('prenom')->count();

                // en regles





            }


            $vonRedevables = $datasEffectif - $datasNombre;


            $this->fpdf->Ln(10);

            $this->fpdf->SetFont('Arial', 'B', 10);


            $this->fpdf->Cell(80, 10, 'EFFECTIFS', 1, 0, 'C', 1);
            $this->fpdf->Cell(50, 10, 'INSOLVABLES', 1, 0, 'C', 1);
            $this->fpdf->Cell(50, 10, 'EN REGLE', 1, 0, 'C', 1);


            $this->fpdf->Ln();

            $this->fpdf->Cell(80, 10, $datasEffectif, 1, 0, 'C');

            $this->fpdf->Cell(50, 10, $datasEffectif - $datasNombre, 1, 0, 'C');
            $this->fpdf->Cell(50, 10, $datasNombre, 1, 0, 'C');
        }









        // La page en PDF



        // $Taillecell = 10;

        // $this->fpdf->SetXY(3, 75);
        // $this->fpdf->SetFont('Arial', 'B', 10);
        // $this->fpdf->SetDrawColor(0, 0, 0);
        // $this->fpdf->SetFillColor('159', '159', '159');
        // $this->fpdf->SetTextColor('0', '0', '0');
        // $this->fpdf->Cell(10, 10, '', 1, 0, 'C', 1);
        // $this->fpdf->Cell(30, 10, 'MATRICULE', 1, 0, 'C', 1);
        // $this->fpdf->Cell(165, 10, 'NOMS ET PRENOMS', 1, 0, 'L', 1);

        // $this->fpdf->Ln();




        // foreach ($datas as $key => $eleve) {


        //     $this->fpdf->SetX(3);
        //     $this->fpdf->Cell(10, $Taillecell, $key + 1, 1, 0, 'C');

        //     $this->fpdf->Cell(30, $Taillecell, $eleve->matricule, 1, 0, 'C');
        //     $this->fpdf->Cell(165, $Taillecell, $eleve->nom . ' ' . $eleve->prenom, 1, 0, 'L');


        //     $this->fpdf->Ln($Taillecell);
        // }


        // $this->fpdf->Ln(10);

        // $this->fpdf->Cell(30, 10, 'EFFECTIFS', 1, 0, 'C', 1);
        // $this->fpdf->Cell(30, 10, 'INSOLVABLES', 1, 0, 'C', 1);
        // $this->fpdf->Cell(30, 10, 'EN REGLE', 1, 0, 'C', 1);


        // $this->fpdf->Ln();

        // $this->fpdf->Cell(30, 10, $datasEffectif, 1, 0, 'C');

        // $this->fpdf->Cell(30, 10, $datasEffectif - $datasNombre, 1, 0, 'C');
        // $this->fpdf->Cell(30, 10, $datasNombre, 1, 0, 'C');













        $this->fpdf->Output();

        exit;


        // return response()->json($datas);
    }



    // public function InsolvablesPdf($idClasse)


    // {

    //     $conf = config::first();

    //     $entete = $conf->header;


    //     $session = Session::where('encours_sess', 1)->first();

    //     $sessionEncour = $session->libelle_sess;

    //     $codeEtab = $session->codeEtab_sess;

    //     // La classe et le total de ses finances


    //     $classesInfos = Classe::where('id', $idClasse)->first();

    //     $etab =  Etablissement::where('codeEtab', $codeEtab)->first();



    //     // Liste de ceux qui ont juste avance la pension c-a-d statut==1


    //     $datas = Student::with('classe')->where('classe_id', $idClasse)
    //         ->where('codeEtab', $codeEtab)
    //         ->where('session', $sessionEncour)->where('statut', '!=', 2)
    //         ->orderBy('nom')->orderBy('prenom')->get();


    //     // nombre non inscrits


    //     $datasNombre  = Student::with('classe')->where('classe_id', $idClasse)
    //         ->where('codeEtab', $codeEtab)
    //         ->where('session', $sessionEncour)->where('statut', '!=', 2)
    //         ->orderBy('nom')->orderBy('prenom')->count();


    //     // nombre eleve


    //     $datasEffectif = Student::with('classe')->where('classe_id', $idClasse)
    //         ->where('codeEtab', $codeEtab)
    //         ->where('session', $sessionEncour)
    //         ->orderBy('nom')->orderBy('prenom')->count();

    //     // en regles


    //     $vonRedevables = $datasEffectif - $datasNombre;


    //     foreach ($datas as $data) {


    //         $tranche1 = Versements::where('classe_id', $idClasse)->where('student_id', $data->id)->where('motif', 'tranche1')

    //             ->where('codeEtab', $codeEtab)->where('session', $sessionEncour)->sum('montantverser');


    //         $tranche2 = Versements::where('classe_id', $idClasse)->where('student_id', $data->id)->where('motif', 'tranche2')

    //             ->where('codeEtab', $codeEtab)->where('session',  $sessionEncour)->sum('montantverser');

    //         $ape = Versements::where('classe_id', $idClasse)->where('student_id', $data->id)->where('motif', 'APE')

    //             ->where('codeEtab', $codeEtab)->where('session', $sessionEncour)->sum('montantverser');

    //         $datasTranches[$data->id] =  array(

    //             'tranche1' =>  $tranche1,
    //             'tranche2' =>  $tranche2,
    //             'ape' =>  $ape,

    //         );

    //         $data['scolarite'] = $datasTranches[$data->id];
    //     }

    //     // La page en PDF


    //     $this->fpdf->AddPage("P", ['397', '210']);

    //     // $this->fpdf->SetTextColor('44', '53', '61');

    //     $this->fpdf->SetFont('Arial', 'B', 6);

    //     $this->fpdf->Text(80, 20, utf8_decode(" Année-scolaire : $classesInfos->sessionClasse"));

    //     $this->fpdf->SetFont('Arial', 'B', 20);


    //     // $this->fpdf->Text(65, 12, utf8_decode($etab->libelleEtab));

    //     $this->fpdf->Image(public_path("/Photos/Logos/" . $entete), 0, 0, 210, 20,  "");

    //     $TotalResteInscrip = 0;
    //     $TotalResteTranch1 = 0;
    //     $TotalResteTranch2 = 0;

    //     $this->fpdf->SetXY(20, 27);
    //     $this->fpdf->Cell(170, 12, '', 1);

    //     $this->fpdf->SetFont('Arial', 'B', 15);

    //     $this->fpdf->Text(55, 35, utf8_decode("  Liste des insolvables en $classesInfos->libelleClasse  "));

    //     $this->fpdf->SetFont('Arial', 'B', 10);

    //     $this->fpdf->Text(60, 46, utf8_decode("Insolvables : $datasNombre ; En regle  : $vonRedevables ; Effectifs : $datasEffectif "));



    //     $this->fpdf->SetXY(3, 50);
    //     $this->fpdf->SetFont('Arial', 'B', 6);
    //     $this->fpdf->SetDrawColor(0, 0, 0);
    //     $this->fpdf->SetFillColor('10', '75', '168');
    //     $this->fpdf->SetTextColor('0', '0', '0');
    //     $this->fpdf->Cell(5, 6, '', 1, 0, 'L', 1);
    //     $this->fpdf->Cell(60, 6, 'NOMS', 1, 0, 'L', 1);
    //     $this->fpdf->Cell(60, 6, 'PRENOMS', 1, 0, 'L', 1);
    //     $this->fpdf->Cell(20, 6, 'RESTE INSCRIP', 1, 0, 'L', 1);
    //     $this->fpdf->Cell(30, 6, 'RESTE T1', 1, 0, 'L', 1);
    //     $this->fpdf->Cell(30, 6, 'RESTE T2', 1, 0, 'L', 1);
    //     $this->fpdf->Ln();
    //     $this->fpdf->SetTextColor('0', '0', '0');

    //     $this->fpdf->SetFont('Arial', 'B', 6);



    //     foreach ($datas as $key => $eleve) {


    //         $this->fpdf->SetX(3);
    //         $this->fpdf->MultiCell(5, 6, $key + 1, 1, 'L');
    //     }

    //     $this->fpdf->SetY(56);

    //     $this->fpdf->SetFont('Arial', 'B', 8);


    //     foreach ($datas as $key => $eleve) {
    //         $this->fpdf->SetX(8);
    //         $this->fpdf->MultiCell(60, 6, $eleve->nom, 1, 'L');
    //     }


    //     $this->fpdf->SetY(56);

    //     foreach ($datas as $key => $eleve) {

    //         $this->fpdf->SetX(68);
    //         $this->fpdf->MultiCell(60, 6, utf8_decode($eleve->prenom), 1, 'L');
    //     }


    //     $this->fpdf->SetY(56);

    //     foreach ($datas as $key => $eleve) {

    //         $this->fpdf->SetX(128);


    //         $this->fpdf->MultiCell(20, 6,  utf8_decode($classesInfos->scolariteaff_Classe - $eleve->scolarite['ape']), 1, 'C');

    //         $TotalResteInscrip = $TotalResteInscrip + utf8_decode($classesInfos->scolariteaff_Classe - $eleve->scolarite['ape']);
    //     }

    //     $this->fpdf->SetY(56);

    //     foreach ($datas as $key => $eleve) {

    //         $this->fpdf->SetX(148);


    //         $this->fpdf->MultiCell(30, 6,  utf8_decode($classesInfos->scolarite_Classe - $eleve->scolarite['tranche1']), 1, 'C');

    //         $TotalResteTranch1 = $TotalResteTranch1 + utf8_decode($classesInfos->scolarite_Classe - $eleve->scolarite['tranche1']);
    //     }

    //     $this->fpdf->SetY(56);

    //     foreach ($datas as $key => $eleve) {

    //         $this->fpdf->SetX(178);


    //         $this->fpdf->MultiCell(30, 6,  utf8_decode($classesInfos->inscription_Classe - $eleve->scolarite['tranche2']), 1, 'C');

    //         $TotalResteTranch2 = $TotalResteTranch2 + utf8_decode($classesInfos->inscription_Classe - $eleve->scolarite['tranche2']);
    //     }


    //     $this->fpdf->SetFont('Arial', 'B', 10);
    //     $this->fpdf->SetX(8);
    //     $this->fpdf->Cell(120, 8, 'TOTAUX ', 1, 0, ' C');
    //     $this->fpdf->Cell(20, 8, $TotalResteInscrip, 1, 0, 'C');
    //     $this->fpdf->Cell(30, 8, $TotalResteTranch1, 1, 0, 'C');
    //     $this->fpdf->Cell(30, 8, $TotalResteTranch2, 1, 0, 'C');


    //     $this->fpdf->SetFont('Arial', 'B', 13);

    //     $this->fpdf->Output();

    //     exit;


    //     // return response()->json($datas);
    // }


    // public function InsolvablesPdf($idClasse)


    // {

    //     $conf = config::first();

    //     $entete = $conf->header;


    //     $session = Session::where('encours_sess', 1)->first();

    //     $sessionEncour = $session->libelle_sess;

    //     $codeEtab = $session->codeEtab_sess;

    //     // La classe et le total de ses finances


    //     $classesInfos = Classe::where('id', $idClasse)->first();

    //     $etab =  Etablissement::where('codeEtab', $codeEtab)->first();



    //     // Liste de ceux qui ont juste avance la pension c-a-d statut==1


    //     // $datas = Student::with('classe')->where('classe_id', $idClasse)
    //     //     ->where('codeEtab', $codeEtab)
    //     //     ->where('session', $sessionEncour)->where('statut', '!=', 2)
    //     //     ->orderBy('nom')->orderBy('prenom')->get();



    //     $datas = Student::with('classe')->where('statut', '!=', 2)
    //         ->orderBy('classe_id', 'asc')->orderBy('students.nom', 'asc')->orderBy('students.prenom', 'asc')->get();



    //     // nombre non inscrits


    //     $datasNombre  = Student::with('classe')
    //         ->where('codeEtab', $codeEtab)
    //         ->where('session', $sessionEncour)->where('statut', '!=', 2)
    //         ->orderBy('nom')->orderBy('prenom')->count();


    //     // nombre eleve


    //     $datasEffectif = Student::with('classe')
    //         ->where('codeEtab', $codeEtab)
    //         ->where('session', $sessionEncour)
    //         ->orderBy('nom')->orderBy('prenom')->count();

    //     // en regles


    //     $vonRedevables = $datasEffectif - $datasNombre;



    //     // La page en PDF


    //     $this->fpdf->AddPage("P", ['297', '210']);



    //     $this->fpdf->SetFont('Arial', 'B', 12);

    //     $this->fpdf->Text(80, 63, utf8_decode(" ANNEE-SCOLAIRE : $classesInfos->sessionClasse"));

    //     $this->fpdf->SetFont('Arial', 'B', 20);



    //     $this->fpdf->Image(public_path("/Photos/Logos/" . $entete), 0, 0, 210, 40,  "");

    //     $this->fpdf->SetFont('Arial', 'B', 30);

    //     $this->fpdf->Text(25, 55, utf8_decode("  LISTE DES INSOLVABLES   "));

    //     $this->fpdf->SetFont('Arial', 'B', 10);
    //     $this->fpdf->Text(45, 70, utf8_decode(" Rapport fait automatiquement  par l'application Le :  " . date('j/m/Y  H:i:s')));



    //     $Taillecell = 10;

    //     $this->fpdf->SetXY(3, 75);
    //     $this->fpdf->SetFont('Arial', 'B', 10);
    //     $this->fpdf->SetDrawColor(0, 0, 0);
    //     $this->fpdf->SetFillColor('159', '159', '159');
    //     $this->fpdf->SetTextColor('0', '0', '0');
    //     $this->fpdf->Cell(10, 10, '', 1, 0, 'C', 1);
    //     $this->fpdf->Cell(30, 10, 'MATRICULE', 1, 0, 'C', 1);
    //     $this->fpdf->Cell(135, 10, 'NOMS', 1, 0, 'L', 1);

    //     $this->fpdf->Cell(25, 10, 'CLASSE', 1, 0, 'L', 1);

    //     $this->fpdf->Ln();




    //     foreach ($datas as $key => $eleve) {


    //         $this->fpdf->SetX(3);
    //         $this->fpdf->Cell(10, $Taillecell, $key + 1, 1, 0, 'C');

    //         $this->fpdf->Cell(30, $Taillecell, $eleve->matricule, 1, 0, 'C');

    //         $this->fpdf->Cell(135, $Taillecell, $eleve->nom . ' ' . $eleve->prenom, 1, 0, 'L');

    //         $this->fpdf->Cell(25, $Taillecell, $eleve->classe->libelleClasse, 1, 0, 'C');


    //         $this->fpdf->Ln($Taillecell);
    //     }


    //     $this->fpdf->Ln(10);

    //     $this->fpdf->Cell(30, 10, 'EFFECTIFS', 1, 0, 'C', 1);
    //     $this->fpdf->Cell(30, 10, 'INSOLVABLES', 1, 0, 'C', 1);
    //     $this->fpdf->Cell(30, 10, 'EN REGLE', 1, 0, 'C', 1);

    //     $this->fpdf->Cell(50, 10, 'POURCENTAGE INSOLVABLE', 1, 0, 'C', 1);

    //     $this->fpdf->Cell(60, 10, 'POURCENTAGE EN REGLE', 1, 0, 'C', 1);


    //     $this->fpdf->Ln();

    //     $this->fpdf->Cell(30, 10, $datasEffectif, 1, 0, 'C');
    //     $this->fpdf->Cell(30, 10, $datasNombre, 1, 0, 'C');
    //     $this->fpdf->Cell(30, 10, $datasEffectif - $datasNombre, 1, 0, 'C');

    //     $this->fpdf->Cell(50, 10, number_format(($datasNombre / $datasEffectif) * 100, 2) . " %", 1, 0, 'C');

    //     $this->fpdf->Cell(60, 10, number_format(100 - ($datasNombre / $datasEffectif) * 100, 2) . " %", 1, 0, 'C');









    //     $this->fpdf->Output();

    //     exit;
    // }






    public function getAllTHAnnuel()


    {


        $code = Classe::first();

        $codeEtab = $code->codeEtabClasse;

        $session = $code->sessionClasse;

        $classeName = Etablissement::where('codeEtab', $codeEtab)->first();


        $moyData =   MoyenneAnnuelle::with('student', 'classe')->where('session', $session)
            ->where('codeEtab', $codeEtab)
            ->where('valeur', '>=', 12)->orderBy('valeur', 'DESC')->get();



        $conf = config::first();

        $entete = $conf->header;


        foreach ($moyData as $moy) {





            $heureTrimestre  = Presences::where('student_id', $moy->student->id)

                ->where('session', $session)->sum('duree');


            // Absences  justifies

            $heureTrimestreJustifies = Presences::where('student_id', $moy->student->id)

                ->where('session', $session)->sum('etat');



            if ($heureTrimestre - $heureTrimestreJustifies <= 10) {


                $this->fpdf->AddPage("L", 'A5');



                $this->fpdf->SetMargins(0, 0, 0, 0);

                $userData = Student::with('user')->where('id', $moy->student->id)->first();





                $this->fpdf->Image(public_path("/Photos/Logos/" . $entete), 1, 1, 205, 25, "");

                $this->fpdf->Image(public_path("/Photos/Logos/footer.jpeg"), 0, 139, 217, 13,  "");


                $this->fpdf->SetTextColor('255', '255', '255');
                $this->fpdf->SetFillColor('10', '75', '168');
                $this->fpdf->SetFont('Arial', 'B', 10);



                $this->fpdf->SetMargins(0, 0, 0, 0);
                $this->fpdf->SetXY(0, 29);


                $this->fpdf->SetFont('Arial', 'B', 20);

                $this->fpdf->Cell(210, 11, "TABLEAU D'HONNEUR" . ' ', 0, 0, 'C', 1);

                $this->fpdf->SetFont('Arial', 'BI', 12);

                $this->fpdf->SetTextColor('0', '0', '0');

                $this->fpdf->Text(88, 45, utf8_decode("HONNOR ROLL"));

                $this->fpdf->SetFont('Arial', 'B', 11);

                $this->fpdf->Text(10, 52, utf8_decode(" Le conseil de classe en vertu des pouvoirs qui lui sont conférés, décerne le TABLEAU D'HONNEUR "));

                $this->fpdf->SetFont('Arial', 'BI', 9);
                $this->fpdf->Text(35, 59, utf8_decode("The Class Council, by virtue of the powers vested in it, awards the TABLE OF HONOUR  "));


                $this->fpdf->SetFont('Arial', 'B', 11);

                $this->fpdf->Text(25, 67, utf8_decode(" A  l'éleve "));

                $this->fpdf->SetFont('Arial', 'BI', 9);

                $this->fpdf->Text(25, 72, utf8_decode(" To the student "));


                $this->fpdf->SetFont('Arial', 'B', 12);

                $this->fpdf->Text(52, 69, utf8_decode($moy->student->nom . " " . $moy->student->prenom));

                $this->fpdf->SetFont('Arial', 'B', 11);

                $this->fpdf->Text(52, 78, utf8_decode("Matricule" . " " . $moy->student->matricule . " né(e) le " . utf8_decode(date_format(date_create($moy->student->dateNaiss), "d/m/Y")) . " à " . $moy->student->lieuNaiss));


                $this->fpdf->SetFont('Arial', 'BI', 8);

                $this->fpdf->Text(55, 84, utf8_decode("Registration nº" . " " . $moy->student->matricule . " born on the " . utf8_decode(date_format(date_create($moy->student->dateNaiss), "d/m/Y")) . " at " . $moy->student->lieuNaiss));



                $this->fpdf->SetFont('Arial', 'B', 11);
                $this->fpdf->Text(10, 92, utf8_decode(" De la classe de : " . $moy->classe->libelleClasse . " pour son bon travail au cour de l'année scolaire " . $moy->student->session));

                $this->fpdf->SetFont('Arial', 'BI', 8);

                $this->fpdf->Text(40, 98, utf8_decode(" From the class of : " . $moy->classe->libelleClasse . " for its good work during  the " . $moy->student->session . "  school year"));


                $this->fpdf->SetFont('Arial', 'B', 10);
                $this->fpdf->Text(10, 105, utf8_decode(" Moyenne obtenue : " . utf8_decode(" $moy->valeur / 20 ")));


                $this->fpdf->SetFont('Arial', 'BI', 9);

                $this->fpdf->Text(10, 110, utf8_decode(" Avreage obtained : "));


                $this->fpdf->SetFont('Arial', 'B', 10);
                $this->fpdf->Text(130, 105, utf8_decode(" Fait à MANENGOLE  le _____________"));

                $this->fpdf->SetFont('Arial', 'BI', 8);
                $this->fpdf->Text(130, 110, utf8_decode(" Done at MANENGOLE on "));



                $fel = $encou  = "";


                if ($moy->valeur >= 13 && $moy->valeur < 14) {

                    $fel = "  ";

                    $encou = "X";
                }

                if ($moy->valeur >= 14) {

                    $fel = "X";

                    $encou = "  ";
                }

                $this->fpdf->SetXY(10, 115);
                $this->fpdf->SetFont('Arial', 'B', 12);
                $this->fpdf->Cell(10, 8, $encou, 1, 0, 'C', 0);

                $this->fpdf->SetFont('Arial', 'B', 10);
                $this->fpdf->Text(24, 118, utf8_decode("Avec ENCOURAGEMENTS "));
                $this->fpdf->SetFont('Arial', 'BI', 8);
                $this->fpdf->Text(24, 122, utf8_decode("With CREDIT "));





                $this->fpdf->SetXY(72, 115);
                $this->fpdf->SetFont('Arial', 'B', 12);
                $this->fpdf->Cell(10, 8, $fel, 1, 0, 'C', 0);

                $this->fpdf->SetFont('Arial', 'B', 10);
                $this->fpdf->Text(84, 118, utf8_decode("Avec FELICITATIONS "));
                $this->fpdf->SetFont('Arial', 'BI', 8);
                $this->fpdf->Text(84, 122, utf8_decode("With DISTINCTION "));


                $this->fpdf->SetFont('Arial', 'B', 11);



                $this->fpdf->Text(150, 118,  utf8_decode(" Le PROVISEUR"));

                $this->fpdf->SetFont('Arial', 'BI', 8);

                $this->fpdf->Text(150, 122,  utf8_decode(" THE PRINCIPAL"));
            }
        }






        $this->fpdf->Output();

        exit;
    }

    public function getAllTBTrimestre($id)


    {


        $data =  explode('*', $id);
        // $IdClasse = $data[0];
        $IdTrimestre  = $data[0];

        // Je trouve le codeEtab et la session

        $code = Classe::first();


        $codeEtab = $code->codeEtabClasse;


        $session = $code->sessionClasse;

        $classeName = Etablissement::where('codeEtab', $codeEtab)->first();

        $Evalutions = Evaluations::with('trimestre')->where('trimestre_id', $IdTrimestre)->where('session', $session)
            ->where('codeEtab', $codeEtab)->get();

        $libelleTrimestre = $Evalutions[0]->trimestre->libelle_semes;


        $moyData =   MoyenneTrimestres::with('student', 'classe')->where('session', $session)
            ->where('codeEtab', $codeEtab)->where('trimestre_id',  $IdTrimestre)
            ->where('valeur', '>=', 12)->orderBy('valeur', 'DESC')->get();


        // $classeStudent = Classe::where('id', $IdClasse)->first('libelleClasse');


        $conf = config::first();

        $entete = $conf->header;


        foreach ($moyData as $moy) {





            $heureTrimestre  = Presences::where('trimestre_id', $Evalutions[0]->trimestre->id)->where('student_id', $moy->student->id)

                ->where('session', $session)->sum('duree');


            // Absences  justifies

            $heureTrimestreJustifies = Presences::where('trimestre_id', $Evalutions[0]->trimestre->id)->where('student_id', $moy->student->id)

                ->where('session', $session)->sum('etat');



            if ($heureTrimestre - $heureTrimestreJustifies <= 10) {


                $this->fpdf->AddPage("L", 'A5');



                $this->fpdf->SetMargins(0, 0, 0, 0);

                $userData = Student::with('user')->where('id', $moy->student->id)->first();





                $this->fpdf->Image(public_path("/Photos/Logos/" . $entete), 1, 1, 205, 25, "");

                $this->fpdf->Image(public_path("/Photos/Logos/footer.jpeg"), 0, 139, 217, 13,  "");









                $this->fpdf->SetTextColor('255', '255', '255');
                $this->fpdf->SetFillColor('10', '75', '168');
                $this->fpdf->SetFont('Arial', 'B', 10);



                $this->fpdf->SetMargins(0, 0, 0, 0);
                $this->fpdf->SetXY(0, 29);


                $this->fpdf->SetFont('Arial', 'B', 20);

                $this->fpdf->Cell(210, 11, "TABLEAU D'HONNEUR" . ' ', 0, 0, 'C', 1);

                $this->fpdf->SetFont('Arial', 'BI', 12);

                $this->fpdf->SetTextColor('0', '0', '0');

                $this->fpdf->Text(88, 45, utf8_decode("HONNOR ROLL"));

                $this->fpdf->SetFont('Arial', 'B', 11);

                $this->fpdf->Text(10, 52, utf8_decode(" Le conseil de classe en vertu des pouvoirs qui lui sont conférés, décerne le TABLEAU D'HONNEUR "));

                $this->fpdf->SetFont('Arial', 'BI', 9);
                $this->fpdf->Text(35, 59, utf8_decode("The Class Council, by virtue of the powers vested in it, awards the TABLE OF HONOUR  "));


                $this->fpdf->SetFont('Arial', 'B', 11);

                $this->fpdf->Text(25, 67, utf8_decode(" A  l'éleve "));

                $this->fpdf->SetFont('Arial', 'BI', 9);

                $this->fpdf->Text(25, 72, utf8_decode(" To the student "));


                $this->fpdf->SetFont('Arial', 'B', 12);

                $this->fpdf->Text(52, 69, utf8_decode($moy->student->nom . " " . $moy->student->prenom));

                $this->fpdf->SetFont('Arial', 'B', 11);

                $this->fpdf->Text(52, 78, utf8_decode("Matricule" . " " . $moy->student->matricule . " né(e) le " . utf8_decode(date_format(date_create($moy->student->dateNaiss), "d/m/Y")) . " à " . $moy->student->lieuNaiss));


                $this->fpdf->SetFont('Arial', 'BI', 8);

                $this->fpdf->Text(55, 84, utf8_decode("Registration nº" . " " . $moy->student->matricule . " born on the " . utf8_decode(date_format(date_create($moy->student->dateNaiss), "d/m/Y")) . " at " . $moy->student->lieuNaiss));



                $this->fpdf->SetFont('Arial', 'B', 11);
                $this->fpdf->Text(10, 92, utf8_decode(" De la classe de : " . $moy->classe->libelleClasse . " pour son bon travail au cour du TRIMETRE " . $Evalutions[0]->trimestre->id . " de l'année scolaire " . $moy->student->session));

                $this->fpdf->SetFont('Arial', 'BI', 8);

                $this->fpdf->Text(40, 98, utf8_decode(" From the class of : " . $moy->classe->libelleClasse . " for its good work during the TRIMETER " . $Evalutions[0]->trimestre->id . "of the " . $moy->student->session . "  school year"));


                $this->fpdf->SetFont('Arial', 'B', 10);
                $this->fpdf->Text(10, 105, utf8_decode(" Moyenne obtenue : " . utf8_decode(" $moy->valeur / 20 ")));


                $this->fpdf->SetFont('Arial', 'BI', 9);

                $this->fpdf->Text(10, 110, utf8_decode(" Avreage obtained : "));


                $this->fpdf->SetFont('Arial', 'B', 10);
                $this->fpdf->Text(130, 105, utf8_decode(" Fait à MANENGOLE  le _____________"));

                $this->fpdf->SetFont('Arial', 'BI', 8);
                $this->fpdf->Text(130, 110, utf8_decode(" Done at MANENGOLE on "));



                $fel = $encou  = "";


                if ($moy->valeur >= 13 && $moy->valeur < 14) {

                    $fel = "  ";

                    $encou = "X";
                }

                if ($moy->valeur >= 14) {

                    $fel = "X";

                    $encou = "  ";
                }

                $this->fpdf->SetXY(10, 115);
                $this->fpdf->SetFont('Arial', 'B', 12);
                $this->fpdf->Cell(10, 8, $encou, 1, 0, 'C', 0);

                $this->fpdf->SetFont('Arial', 'B', 10);
                $this->fpdf->Text(24, 118, utf8_decode("Avec ENCOURAGEMENTS "));
                $this->fpdf->SetFont('Arial', 'BI', 8);
                $this->fpdf->Text(24, 122, utf8_decode("With CREDIT "));





                $this->fpdf->SetXY(72, 115);
                $this->fpdf->SetFont('Arial', 'B', 12);
                $this->fpdf->Cell(10, 8, $fel, 1, 0, 'C', 0);

                $this->fpdf->SetFont('Arial', 'B', 10);
                $this->fpdf->Text(84, 118, utf8_decode("Avec FELICITATIONS "));
                $this->fpdf->SetFont('Arial', 'BI', 8);
                $this->fpdf->Text(84, 122, utf8_decode("With DISTINCTION "));


                $this->fpdf->SetFont('Arial', 'B', 11);



                $this->fpdf->Text(150, 118,  utf8_decode(" Le PROVISEUR"));

                $this->fpdf->SetFont('Arial', 'BI', 8);

                $this->fpdf->Text(150, 122,  utf8_decode(" THE PRINCIPAL"));
            }
        }






        $this->fpdf->Output();

        exit;
    }



    public function getAllTBTrimestre2($id)


    {

        $data =  explode('*', $id);
        $IdClasse = $data[0];
        $IdTrimestre  = $data[1];

        // Je trouve le codeEtab et la session

        $code = Classe::where('id', $IdClasse)->first();
        $codeEtab = $code->codeEtabClasse;
        $session = $code->sessionClasse;

        $classeName = Etablissement::where('codeEtab', $codeEtab)->first();

        $Evalutions = Evaluations::with('trimestre')->where('trimestre_id', $IdTrimestre)->where('session', $session)
            ->where('codeEtab', $codeEtab)->get();

        $libelleTrimestre = $Evalutions[0]->trimestre->libelle_semes;


        $moyData =   MoyenneTrimestres::with('student')->where('session', $session)
            ->where('codeEtab', $codeEtab)->where('trimestre_id',  $IdTrimestre)
            ->where('classe_id',  $IdClasse)->where('valeur', '>=', 13)->orderBy('valeur', 'DESC')->get();




        $classeStudent = Classe::where('id', $IdClasse)->first('libelleClasse');


        $conf = config::first();

        $entete = $conf->header;


        foreach ($moyData as $moy) {

            if ($moy->valeur >= 13 && $moy->valeur <= 14) {

                $mention = "ENCOURAGEMENTS";

                //     $couleur =  "'0','128','0'";

                // if()
                $this->fpdf->SetFillColor('255', '201', '14');
                $couleur =  $this->fpdf->SetFont('Arial', 'B', 10);

                //$this->fpdf->Image(public_path("/Photos/Logos/footer2.png"), 0, 201, 340, 10,  "");
            }

            if ($moy->valeur >= 14 && $moy->valeur <= 20) {

                $mention = "FELICITATIONS";

                $couleur =  $this->fpdf->SetFillColor('0', '128', '0');
                $this->fpdf->SetFont('Arial', 'B', 10);

                // $this->fpdf->Image(public_path("/Photos/Logos/footer3.png"), 0, 201, 340, 10,  "");
            }

            $userData = Student::with('user')->where('id', $moy->student->id)->first();


            $this->fpdf->AddPage("L", ['210', '297']);


            // $this->fpdf->Image(public_path("/Photos/Logos/" . $entete), 5, 3, 290, 65, "");

            if ($moy->valeur >= 13 && $moy->valeur <= 14) {


                // $this->fpdf->Image(public_path("/Photos/Logos/footer4.png"), 0, 201, 340, 10,  "");
            }

            if ($moy->valeur >= 14 && $moy->valeur <= 20) {

                // $this->fpdf->Image(public_path("/Photos/Logos/footer2.png"), 0, 201, 340, 10,  "");
            }










            $this->fpdf->SetTextColor('255', '255', '255');





            $this->fpdf->SetXY(0, 73);


            $this->fpdf->SetFont('Arial', 'B', 30);

            $this->fpdf->Cell(297, 17,  $mention . ' ', 0, 0, 'C', 1);


            $this->fpdf->SetTextColor('44', '53', '61');

            $this->fpdf->SetFont('Arial', 'I', 15);

            $this->fpdf->Text(10, 110, utf8_decode(" A  l'éleve  :  "));

            $this->fpdf->SetFont('Arial', 'B', 24);

            $this->fpdf->Text(75, 110, utf8_decode($moy->student->nom . " " . $moy->student->prenom));

            // *********************** //


            $this->fpdf->SetFont('Arial', 'I', 15);

            $this->fpdf->Text(10, 125, utf8_decode(" de la classe de :  "));

            $this->fpdf->SetFont('Arial', 'B', 27);

            // $this->fpdf->SetTextColor('10', '75', '168');

            $this->fpdf->Text(75, 125,  utf8_decode("$classeStudent->libelleClasse"));


            // *********************** //

            $this->fpdf->SetTextColor('0', '0', '0');
            $this->fpdf->SetFont('Arial', 'I', 15);

            $this->fpdf->Text(10, 140, utf8_decode("pour son travail obtenu au : "));

            $this->fpdf->SetFont('Arial', 'B', 27);

            $this->fpdf->Text(73, 140,  utf8_decode("$libelleTrimestre"));

            // *********************** //



            $this->fpdf->SetFont('Arial', 'I', 15);

            $this->fpdf->Text(10, 155, utf8_decode(" de l'année-scolaire :  "));

            $this->fpdf->SetFont('Arial', 'B', 27);

            // $this->fpdf->SetTextColor('10', '75', '168');

            $this->fpdf->Text(75, 155,  utf8_decode(" $session "));


            // *********************** //


            $this->fpdf->SetTextColor('0', '0', '0');
            $this->fpdf->SetFont('Arial', 'I', 15);

            $this->fpdf->Text(10, 170, utf8_decode("Moyenne obtenue :  "));

            $this->fpdf->SetFont('Arial', 'B', 27);

            $this->fpdf->Text(75, 170,  utf8_decode(" $moy->valeur / 20 "));



            // *********************** //


            $this->fpdf->SetFont('Arial', 'IB', 9);





            if (file_exists(public_path("/Photos/Logos/" . $userData->user->photo))) {


                $this->fpdf->Image(public_path("/Photos/Logos/" . $userData->user->photo), 190, 125, 54, 50,  "");
            }
            $this->fpdf->Text(240, 195,  utf8_decode(" Le chef d'établissement "));
        }






        $this->fpdf->Output();

        exit;
    }

    public function getSalaireAutreRecuPdf($id)

    {

        // Je recupere l'id du user(table user) de l'enseignant , le mntant et le date de paiement



        $conf = config::first();
        $entete = $conf->header;
        $Idversement  = $id;

        // je cherche le nom du prof dans la table user

        $Name = salaires::where('id', $Idversement)->first();

        $nom = $Name->nom;
        $pnom = $Name->prenom;


        // Je recupere le nom de son ecole

        $Etab = Etablissement::where('codeEtab', $Name->codeEtab)->first();

        $libelleEtab = $Etab->libelleEtab;

        $ville = $Etab->villeEtab;

        // Je recupere le montant

        $salary = salaires::with('mois')->where('id', $Idversement)->first();

        // for ($i = 0; $i < 2; $i++) {

        $this->fpdf->AddPage("P", ['210', '148']);

        $this->fpdf->SetTextColor('44', '53', '61');

        $this->fpdf->SetFont('Arial', 'B', 12);

        $this->fpdf->Image(public_path("/Photos/Logos/" . $entete), 0, 0, 148, 25, "");

        $this->fpdf->Text(55, 37, utf8_decode('PIECE DE CAISSE'));

        $this->fpdf->SetXY(5, 30);
        $this->fpdf->Cell(138, 58, '', 1);

        $this->fpdf->SetFont('Arial', 'I', 8);

        $this->fpdf->Text(15, 50, utf8_decode('Bénéficiaire : '));

        $this->fpdf->Text(45, 50, 'M ou Mme   ........................................................................................');

        $this->fpdf->Text(15, 55, 'Montant : ');

        $this->fpdf->Text(45, 55, $salary->montant . ' Fcfa');


        $this->fpdf->Text(15, 60, 'Somme en lettre : ');

        $this->fpdf->Text(45, 60, '..........................................................................................................');




        $this->fpdf->Text(15, 65, 'Motif : ');

        $this->fpdf->Text(45, 65, $salary->motif);



        $this->fpdf->SetFont('Arial', 'I', 7);


        $this->fpdf->Text(97, 71, utf8_decode('Fait à ') . ' ' . $ville . '  le ' . '' . $salary->created_at->format('d/m/Y'));


        $this->fpdf->Text(15, 76, utf8_decode("Signature du bénéficiare "));

        $this->fpdf->Text(97, 76, utf8_decode('Signature du comptable'));

        // deuxieme recu



        $this->fpdf->Image(public_path("/Photos/Logos/" . $entete), 0, 98, 148, 25, "");

        $this->fpdf->SetFont('Arial', 'B', 12);


        $this->fpdf->SetXY(5, 125);
        $this->fpdf->Cell(138, 62, '', 1);


        $this->fpdf->Text(58, 132, utf8_decode('PIECE DE CAISSE'));

        $this->fpdf->SetFont('Arial', 'I', 8);

        $this->fpdf->Text(15, 145, utf8_decode('Bénéficiaire : '));

        $this->fpdf->Text(45, 145, 'M ou Mme   ........................................................................................');

        $this->fpdf->Text(15, 150, 'Montant : ');

        $this->fpdf->Text(45, 150, $salary->montant . ' Fcfa');

        $this->fpdf->Text(15, 155, 'Somme en lettre : ');

        $this->fpdf->Text(45, 155, '..........................................................................................................');


        $this->fpdf->Text(15, 160, 'Motif : ');

        $this->fpdf->Text(45, 160, $salary->motif);


        $this->fpdf->Text(97, 168, utf8_decode('Fait à ') . ' ' . $ville . '  le ' . '' . $salary->created_at->format('d/m/Y'));


        $this->fpdf->Text(15, 173, utf8_decode("Signature du bénéficiare "));

        $this->fpdf->Text(97, 173, utf8_decode('Signature du comptable'));


        $this->fpdf->Output();
        exit;
    }

    public function getSalairePersonnelRecuPdf($id)

    {

        // Je recupere l'id du user(table user) de l'enseignant , le mntant et le date de paiement

        $data =  explode('*', $id);


        $conf = config::first();

        $entete = $conf->header;
        $IdUser = $data[1];
        $Idversement  = $data[0];

        // je cherche le nom du prof dans la table user

        $Name = caisse::where('id', $IdUser)->first();

        $nom = $Name->nom;
        $pnom = $Name->prenom;


        // Je recupere le nom de son ecole

        $Etab = Etablissement::where('codeEtab', $Name->codeEtab)->first();

        $libelleEtab = $Etab->libelleEtab;

        $ville = $Etab->villeEtab;

        // Je recupere le montant

        $salary = salaires::with('mois')->where('id', $Idversement)->first();

        // for ($i = 0; $i < 2; $i++) {

        $this->fpdf->AddPage("P", ['210', '148']);

        $this->fpdf->SetTextColor('44', '53', '61');

        $this->fpdf->SetFont('Arial', 'B', 12);

        $this->fpdf->Image(public_path("/Photos/Logos/" . $entete), 0, 0, 148, 25, "");

        $this->fpdf->Text(35, 37, utf8_decode('REÇU DE PAIEMENT DES SALAIRES'));

        $this->fpdf->SetFont('Arial', 'B', 8);

        $this->fpdf->Text(15, 50, utf8_decode('Je soussigné(e)  M ou Mme') . ' ' . $nom . ' ' . $pnom . ' ' . utf8_decode('reconnait avoir reçu la somme de '));

        $this->fpdf->Text(15, 55, '' . utf8_decode($salary->montant . ' Fcfa  relative au  paiement de mon salaire du  mois de ' . $salary->mois->nom . ' , somme reçue'));

        $this->fpdf->Text(15, 60, '' . utf8_decode("de mon employeur l'établissement ") . utf8_decode($libelleEtab));


        $this->fpdf->SetFont('Arial', 'I', 7);


        $this->fpdf->Text(97, 78, utf8_decode('Fait à ') . ' ' . $ville . '  le ' . '' . $salary->created_at->format('d/m/Y'));


        $this->fpdf->Text(15, 85, utf8_decode("Signature du bénéficiare "));

        $this->fpdf->Text(97, 85, utf8_decode('Signature du comptable'));

        // deuxieme recu



        $this->fpdf->Image(public_path("/Photos/Logos/" . $entete), 0, 98, 148, 25,  "");

        $this->fpdf->SetFont('Arial', 'B', 12);


        $this->fpdf->Text(38, 132, utf8_decode('REÇU DE PAIEMENT DES SALAIRES'));

        $this->fpdf->SetFont('Arial', 'B', 8);


        $this->fpdf->Text(15, 145, utf8_decode('Je soussigné(e)  M ou Mme') . ' ' . $nom . ' ' . $pnom . ' ' . utf8_decode('reconnait avoir reçu la somme de'));

        $this->fpdf->Text(15, 150, '' . utf8_decode($salary->montant . ' Fcfa  relative au  paiement de mon salaire du  mois de ' . $salary->mois->nom . ' , somme reçue'));

        $this->fpdf->Text(15, 155, '' . utf8_decode("de mon employeur l'établissement ") . utf8_decode($libelleEtab));

        // $this->fpdf->Text(10, 160, utf8_decode($libelleEtab));

        $this->fpdf->SetFont('Arial', 'I', 8);


        $this->fpdf->Text(97, 168, utf8_decode('Fait à ') . ' ' . $ville . '  le ' . '' . $salary->created_at->format('d/m/Y'));


        $this->fpdf->Text(15, 175, utf8_decode("Signature de l'enseigant(e)"));

        $this->fpdf->Text(97, 175, utf8_decode('Signature de comptable'));




        // }


        $this->fpdf->Output();
        exit;
    }

    public function getSalaireRecuPdf($id)

    {

        // Je recupere l'id du user(table user) de l'enseignant , le mntant et le date de paiement

        $data =  explode('*', $id);


        $conf = config::first();

        $entete = $conf->header;



        $IdUser = $data[1];
        $Idversement  = $data[0];

        // je cherche le nom du prof dans la table user

        $Name = Enseignants::where('user_id', $IdUser)->first();

        $nom = $Name->nom;
        $pnom = $Name->prenom;

        // Je recupere le nom de son ecole

        $Etab = Etablissement::where('codeEtab', $Name->codeEtab)->first();

        $libelleEtab = $Etab->libelleEtab;

        $ville = $Etab->villeEtab;

        // Je recupere le montant

        $salary = salaires::with('mois')->where('id', $Idversement)->first();

        // for ($i = 0; $i < 2; $i++) {

        $this->fpdf->AddPage("P", ['210', '148']);

        $this->fpdf->SetTextColor('44', '53', '61');

        $this->fpdf->SetFont('Arial', 'B', 12);

        $this->fpdf->Image(public_path("/Photos/Logos/" . $entete), 0, 0, 148, 25,  "");

        $this->fpdf->Text(35, 37, utf8_decode('REÇU DE PAIEMENT DES HONORAIRES'));

        $this->fpdf->SetFont('Arial', 'B', 9);

        $this->fpdf->Text(10, 50, utf8_decode('Je soussigné(e) M/Mme') . ' ' . utf8_decode($nom) . ' ' . utf8_decode($pnom) . ' ' . utf8_decode(' enseignant(e) , reconnait avoir reçu la  '));

        $this->fpdf->Text(10, 55, '' . utf8_decode('somme de ' . $salary->montant . ' Fcfa  relative au  paiement des mes honoraires comptant pour '));

        $this->fpdf->Text(10, 60, '' . utf8_decode("le mois de " . $salary->mois->nom . " , somme reçue  de mon employeur l'établissement"));

        $this->fpdf->Text(10, 65, utf8_decode($libelleEtab));

        $this->fpdf->SetFont('Arial', 'I', 8);


        $this->fpdf->Text(97, 78, utf8_decode('Fait à ') . ' ' . $ville . '  le ' . '' . $salary->created_at->format('d/m/Y'));


        $this->fpdf->Text(10, 85, utf8_decode("Signature de l'enseigant(e)"));

        $this->fpdf->Text(97, 85, utf8_decode('Signature du comptable'));

        // deuxieme recu



        $this->fpdf->Image(public_path("/Photos/Logos/" . $entete), 0, 98, 148, 25,  "");

        $this->fpdf->SetFont('Arial', 'B', 12);


        $this->fpdf->Text(38, 132, utf8_decode('REÇU DE PAIEMENT DES HONORAIRES'));

        $this->fpdf->SetFont('Arial', 'B', 9);

        $this->fpdf->Text(10, 145, utf8_decode('Je soussigné(e) M/Mme') . ' ' . utf8_decode($nom) . ' ' . utf8_decode($pnom) . ' ' . utf8_decode(' enseignant(e) , reconnait avoir reçu la  '));

        $this->fpdf->Text(10, 150, '' . utf8_decode('somme de ' . $salary->montant . ' Fcfa  relative au  paiement des mes honoraires comptant pour '));

        $this->fpdf->Text(10, 155, '' . utf8_decode("le mois de " . $salary->mois->nom . " , somme reçue  de mon employeur l'établissement"));

        $this->fpdf->Text(10, 160, utf8_decode($libelleEtab));

        $this->fpdf->SetFont('Arial', 'I', 8);


        $this->fpdf->Text(97, 168, utf8_decode('Fait à  ') . ' ' . $ville . '  le ' . '' . $salary->created_at->format('d/m/Y'));


        $this->fpdf->Text(10, 175, utf8_decode("Signature de l'enseigant(e)"));

        $this->fpdf->Text(97, 175, utf8_decode('Signature du comptable'));




        // }


        $this->fpdf->Output();
        exit;
    }


    public function generateBooktextePdf($id)


    {

        // Recuperer les donnees de ce syllabus



        $syllabus = Books::with('Matiere', 'User', 'Classe')->where('id', $id)->first();


        // le chapitre


        $chapitre  = Syllabs::with('Matiere', 'User', 'Classe')->where('id', $syllabus->syllabs_id)->first();

        $titre = $chapitre->chapitre;

        $this->fpdf->AddPage("P", ['297', '210']);

        $this->fpdf->SetFont('Arial', 'I', 9);

        // $this->fpdf->Image(public_path("/Photos/Logos/entete.jpeg"), 0, 0, 210, 27,  "");

        // dd($syllabus->chapitre);

        $this->fpdf->SetXY(0, 5);
        //$this->fpdf->SetTextColor('112', '114', '110');
        $this->fpdf->SetTextColor('10', '75', '168');
        $this->fpdf->SetDrawColor('10', '75', '168');
        $this->fpdf->SetFillColor('10', '75', '168');

        // $this->fpdf->Text(20, 10, 'Le '. $syllabus->date);

        $this->fpdf->Text(20, 17, 'Cahier de texte du  ' . $syllabus->created_at . ' , ' . '' . strtoupper($syllabus->Classe->libelleClasse) . utf8_decode(', dispensé par ' . $syllabus->user->nom . ' ' . $syllabus->user->prenom));

        if ($syllabus->duree == '') {

            $this->fpdf->Text(20, 23,  utf8_decode('Durée du cour  : non  spécifiée'));
        } else {

            $this->fpdf->Text(20, 23, utf8_decode('Durée du cour  :') . ' ' . $syllabus->duree . ' heure(s)');
        }




        $this->fpdf->SetTextColor('255', '255', '255');
        $this->fpdf->SetFont('Arial', 'B', 20);
        $this->fpdf->SetXY(0, 30);
        $this->fpdf->Cell(210, 12, '     ' . 'CAHIER DE TEXTE ', 1, 1, 'C', 1);
        $this->fpdf->SetFont('Arial', 'B', 16);
        $this->fpdf->SetTextColor('0', '0', '0');
        $this->fpdf->SetXY(10, 50);
        $this->fpdf->Cell(175, 10, utf8_decode(strtoupper($titre)), 0, 0, 'C', 0);


        // // Les partie du cour

        $parties  = partiebooks::where('books_id', $syllabus->id)->get();

        $this->fpdf->SetFont('Arial', 'B', 13);
        $this->fpdf->SetTextColor('255', '255', '255');
        // $this->fpdf->Cell(210,12,'     '.'PLAN DU COURS',1,1,'C',1);
        $this->fpdf->SetXY(20, 60);
        $this->fpdf->Ln(7);


        $this->fpdf->SetTextColor('0', '0', '0');

        foreach ($parties as $key => $partie) {

            $this->fpdf->SetFont('Arial', 'B', 14);
            $this->fpdf->SetX(15);
            $this->fpdf->MultiCell(150, 8, utf8_decode(strtoupper($partie->partie)), 0, 'C');

            $this->fpdf->Ln(3);

            $sousParties = explode('#', $partie->souspartie);

            foreach ($sousParties as $keys => $sous) {

                $this->fpdf->Ln(3);
                $this->fpdf->SetX(80);
                $this->fpdf->SetFont('Arial', 'B', 10);
                $this->fpdf->MultiCell(170, 2,  '. ' . utf8_decode($sous), 0, 'L');
            }

            $this->fpdf->Ln(3);
        }

        $this->fpdf->Output();
        exit;
    }


    public function generateSyllabusPdf($id)
    {

        // Recuperer les donnees de ce syllabus

        $syllabus = Syllabs::with('Matiere', 'User', 'Classe', 'Objectif', 'Partie')->where('id', $id)->first();



        $this->fpdf->AddPage("P", ['297', '210']);

        $this->fpdf->SetFont('Arial', 'I', 9);

        // $this->fpdf->Image(public_path("/Photos/Logos/entete.jpeg"), 0, 0, 210, 27,  "");

        // dd($syllabus->chapitre);

        $this->fpdf->SetXY(0, 5);
        //$this->fpdf->SetTextColor('112', '114', '110');
        $this->fpdf->SetTextColor('10', '75', '168');
        $this->fpdf->SetDrawColor('10', '75', '168');
        $this->fpdf->SetFillColor('10', '75', '168');

        $this->fpdf->Text(20, 10, 'Syllabus , classe : ' . '' . strtoupper($syllabus->Classe->libelleClasse));

        $this->fpdf->Text(20, 17, 'Cour : ' . '' . strtoupper($syllabus->chapitre) . utf8_decode(', dispensé par ' . $syllabus->user->nom . ' ' . $syllabus->user->prenom));

        if ($syllabus->duree == '') {

            $this->fpdf->Text(20, 23,  utf8_decode('Durée : non  spécifiée'));
        } else {

            $this->fpdf->Text(20, 23, utf8_decode('Durée :') . ' ' . $syllabus->duree . ' heure(s)');
        }



        $this->fpdf->SetFont('Arial', 'B', 17);

        // $this->fpdf->Cell(200,12,strtoupper($syllabus->chapitre),0,0,'C',0);

        //$this->fpdf->Cell(200,12,'     '.strtoupper($syllabus->chapitre),1,1,'L',1);
        $this->fpdf->SetTextColor('255', '255', '255');
        $this->fpdf->SetFont('Arial', 'B', 18);
        $this->fpdf->SetXY(0, 30);
        $this->fpdf->Cell(210, 12, '     ' . '  OBJECTIFS', 1, 1, 'C', 1);

        $this->fpdf->SetFont('Arial', 'B', 11);
        $this->fpdf->SetTextColor('0', '0', '0');
        $this->fpdf->SetXY(10, 45);
        $this->fpdf->Cell(210, 12, utf8_decode("A la fin de la période d'enseignement et d'apprentissage, l'élève devra être capable de : "), 0, 0, 'L', 0);

        $this->fpdf->SetXY(20, 60);

        // dd($syllabus->Objectif);



        foreach ($syllabus->Objectif as $key => $syllabu) {

            $this->fpdf->SetFont('Arial', 'I', 9);
            $this->fpdf->SetX(20);
            $this->fpdf->MultiCell(150, 5, ' *  ' . utf8_decode($syllabu->libelle), 0, 'L');
        }

        // Les partie du cour

        $this->fpdf->Ln(35);
        $this->fpdf->SetX(0);
        $this->fpdf->SetFont('Arial', 'B', 18);
        $this->fpdf->SetTextColor('255', '255', '255');
        $this->fpdf->Cell(210, 12, '     ' . 'PLAN DU COURS', 1, 1, 'C', 1);
        $this->fpdf->SetXY(20, 60);
        $this->fpdf->Ln(80);
        $this->fpdf->SetTextColor('10', '75', '168');

        foreach ($syllabus->Partie as $key => $partie) {

            $this->fpdf->SetFont('Arial', 'B', 15);
            $this->fpdf->SetX(20);
            $this->fpdf->MultiCell(150, 5, 'PARTIE' . ' ' . ($key + 1) . ' :  ' . utf8_decode(strtoupper($partie->libelle)), 0, 'L');
            $this->fpdf->Ln(3);
            $this->fpdf->SetX(30);

            if ($partie->exercice == '') {
                $partie->exercice = 'Aucun exercice';
            }

            $this->fpdf->SetFont('Arial', 'I', 10);
            $this->fpdf->SetTextColor('0', '0', '0');
            $this->fpdf->MultiCell(150, 5,  utf8_decode($partie->exercice), 0, 'L');
            $this->fpdf->Ln(5);
            $this->fpdf->SetTextColor('10', '75', '168');
        }







        $this->fpdf->Output();
        exit;
    }

    public function getEleveclassePdf4($id)

    {

        // Je recupere le codeEtab, la session et l'id de la classe

        $data =  explode('*', $id);

        $IdClasse = $data[0];
        $codeEtab  = $data[1];


        $conf = config::first();

        $entete = $conf->header;



        $session = Session::where('codeEtab_sess', $codeEtab)->first('libelle_sess');

        $sessionEncour = $session->libelle_sess;

        // Recuperer les eleves d'une classes, on couple avec la table user pour pouvoir recuperer les photos


        $EleveData = Student::join('users', 'students.user_id', '=', 'users.id')
            ->where('users.photo', '=', "test.jpg")
            ->orderBy('students.nom', 'asc')->orderBy('students.prenom', 'asc')->get();





        $this->fpdf->AddPage("P", ['297', '210']);

        $this->fpdf->Image(public_path("/Photos/Logos/" . $entete), 0, 0, 210, 37,  "");


        $this->fpdf->SetFont('Arial', 'B', 12);


        $this->fpdf->Cell(0, 70, utf8_decode(" ANNEE ACADEMIQUE : $sessionEncour "), 0, 0, 'C');

        $this->fpdf->Text(60, 55, utf8_decode(" LISTE DES ELEVES N' AYANT PAS  DE PHOTO "), 0, 0, 'C');


        $this->fpdf->SetY(20);

        $this->fpdf->SetFont('Arial', 'B', 10);

        $this->fpdf->SetXY(2, 60);

        $this->fpdf->SetDrawColor(0, 0, 0);
        $this->fpdf->SetFillColor('10', '75', '168');
        $this->fpdf->SetTextColor('0', '0', '0');
        $this->fpdf->Cell(10, 10, '', 1, 0, 'C', 1);
        $this->fpdf->Cell(130, 10, 'Noms', 1, 0, 'L', 1);

        $this->fpdf->Cell(22, 10, 'Classe', 1, 0, 'L', 1);





        $this->fpdf->Ln();

        $taille = 10;




        // $Classes = Classe::get();


        foreach ($EleveData as $key => $Class) {


            $this->fpdf->SetX(2);
            $this->fpdf->Cell(10, $taille, $key + 1, 1, 0, 'C');
            $this->fpdf->SetFont('Arial', 'B', 9);
            $this->fpdf->Cell(130, $taille, utf8_decode($Class->nom . " " . $Class->prenom), 1, 0, 'L');

            $this->fpdf->Cell(22, $taille, utf8_decode(''), 1, 0, 'L');












            $this->fpdf->Ln($taille);
        }
















        $this->fpdf->Output();
        exit;
    }

    public function getEleveclassePdf2($id)

    {

        // Je recupere le codeEtab, la session et l'id de la classe

        $data =  explode('*', $id);

        $IdClasse = $data[0];
        $codeEtab  = $data[1];


        $conf = config::first();

        $entete = $conf->header;



        $session = Session::where('codeEtab_sess', $codeEtab)->first('libelle_sess');

        $sessionEncour = $session->libelle_sess;

        // Recuperer les eleves d'une classes, on couple avec la table user pour pouvoir recuperer les photos



        // $EleveData = Student::join(
        //     'users',
        //     'students.user_id',
        //     '=',
        //     'users.id'
        // )
        //     ->where('dateNaiss', '.')
        //     ->where('students.statut', '!=', 3)
        //     ->Orwhere('lieuNaiss', '.')
        //     ->Orwhere('sexe', '.')
        //     ->Orwhere('users.photo', '=', "test.jpg")

        //     ->orderBy('classe_id', 'asc')
        //     ->orderBy('students.nom', 'asc')
        //     ->orderBy('students.prenom', 'asc')->get();



        $EleveData = Student::join(
            'users',
            'students.user_id',
            '=',
            'users.id'
        )
            ->where(function ($query) {
                $query->where('dateNaiss', '.')
                    ->Orwhere('lieuNaiss', '.')
                    ->Orwhere('sexe', '.')
                    ->Orwhere('users.photo', '=', "test.jpg");
            })
            ->where('students.statut', '!=', 3)
            ->orderBy('classe_id', 'asc')
            ->orderBy('students.nom', 'asc')
            ->orderBy('students.prenom', 'asc')
            ->get();



        $this->fpdf->AddPage("P", ['297', '210']);

        $this->fpdf->Image(public_path("/Photos/Logos/" . $entete), 0, 0, 210, 37,  "");


        $this->fpdf->SetFont('Arial', 'B', 12);


        $this->fpdf->Cell(0, 70, utf8_decode(" ANNEE ACADEMIQUE : $sessionEncour  "), 0, 0, 'C');

        $this->fpdf->Text(5, 55, utf8_decode(" LISTE DES ELEVES AYANT DES PROBLEMES DE SEXE , PHOTO , DATE , LIEU DE NAISSSANCE "), 0, 0, 'C');
        $this->fpdf->SetFont('Arial', 'B', 10);

        $this->fpdf->Text(40, 65, utf8_decode(" Rapport  automatiquement  par l'application Le :  " . date('j/m/Y  H:i:s')), 0, 'C', 1);


        $this->fpdf->SetY(20);

        $this->fpdf->SetFont('Arial', 'B', 10);

        $this->fpdf->SetXY(2, 80);

        $this->fpdf->SetDrawColor(0, 0, 0);
        $this->fpdf->SetFillColor('159', '159', '159');
        $this->fpdf->SetTextColor('0', '0', '0');
        $this->fpdf->Cell(10, 10, '', 1, 0, 'C', 1);
        $this->fpdf->Cell(90, 10, 'Noms', 1, 0, 'L', 1);

        $this->fpdf->Cell(22, 10, 'Classe', 1, 0, 'L', 1);

        $this->fpdf->Cell(10, 10, 'Sexe', 1, 0, 'L', 1);



        $this->fpdf->Cell(10, 10, 'Date', 1, 0, 'L', 1);

        $this->fpdf->Cell(10, 10, 'Lieu', 1, 0, 'L', 1);

        $this->fpdf->Cell(25, 10, 'Photo', 1, 0, 'L', 1);






        $this->fpdf->Ln();

        $taille = 10;




        // $Classes = Classe::get();


        foreach ($EleveData as $key => $Class) {




            $this->fpdf->SetX(2);
            $this->fpdf->Cell(10, $taille, $key + 1, 1, 0, 'C');
            $this->fpdf->SetFont('Arial', 'B', 9);
            $this->fpdf->Cell(90, $taille, utf8_decode($Class->nom . " " . $Class->prenom), 1, 0, 'L');

            $this->fpdf->Cell(22, $taille, utf8_decode($Class->classe->libelleClasse), 1, 0, 'L');





            if ($Class->sexe == '.') {

                $this->fpdf->SetTextColor('255', '0', '0');

                $this->fpdf->Cell(10, $taille, utf8_decode('NOK'), 1, 0, 'C');
            } else {


                $this->fpdf->Cell(10, $taille, utf8_decode('OK'), 1, 0, 'C');
            }



            $this->fpdf->SetTextColor('0', '0', '0');


            if ($Class->dateNaiss == '.') {

                $this->fpdf->SetTextColor('255', '0', '0');

                $this->fpdf->Cell(10, $taille, utf8_decode("NOK"), 1, 0, 'C');
            } else {

                $this->fpdf->Cell(10, $taille, utf8_decode("OK"), 1, 0, 'C');
            }

            $this->fpdf->SetTextColor('0', '0', '0');


            if ($Class->lieNaiss == '.') {
                $this->fpdf->SetTextColor('255', '0', '0');

                $this->fpdf->Cell(10, $taille, utf8_decode("NOK"), 1, 0, 'C');
            } else {

                $this->fpdf->Cell(10, $taille, utf8_decode("OK"), 1, 0, 'C');
            }

            $this->fpdf->SetTextColor('0', '0', '0');

            if ($Class->photo == 'test.jpg') {

                $this->fpdf->SetTextColor('255', '0', '0');

                $this->fpdf->Cell(25, $taille, utf8_decode("NOK"), 1, 0, 'C');
            } else {

                $this->fpdf->Cell(25, $taille, utf8_decode("OK"), 1, 0, 'C');
            }

            $this->fpdf->SetTextColor('0', '0', '0');



            $this->fpdf->Ln($taille);
        }



        $this->fpdf->AddPage("P", ['297', '210']);

        $this->fpdf->Image(public_path("/Photos/Logos/" . $entete), 0, 0, 210, 37,  "");


        $this->fpdf->SetFont('Arial', 'B', 12);


        $this->fpdf->Cell(0, 70, utf8_decode(" ANNEE ACADEMIQUE : $sessionEncour  "), 0, 0, 'C');

        $this->fpdf->Text(10, 55, utf8_decode(" LISTE DES ELEVES AYANT DES PROBLEMES DE PARENTS ( PERE OU MERE OU LES DEUX ) "), 0, 0, 'C');
        $this->fpdf->SetFont('Arial', 'B', 9);

        $this->fpdf->Text(50, 65, utf8_decode(" Rapport  automatiquement  par l'application Le :  " . date('j/m/Y  H:i:s')), 0, 'C', 1);


        $this->fpdf->SetY(20);

        $this->fpdf->SetFont('Arial', 'B', 10);

        $this->fpdf->SetXY(2, 80);

        $this->fpdf->SetDrawColor(0, 0, 0);
        $this->fpdf->SetFillColor('159', '159', '159');
        $this->fpdf->SetTextColor('0', '0', '0');
        $this->fpdf->Cell(10, 10, '', 1, 0, 'C', 1);
        $this->fpdf->Cell(90, 10, 'Noms', 1, 0, 'L', 1);

        $this->fpdf->Cell(22, 10, 'Classe', 1, 0, 'L', 1);

        $this->fpdf->Cell(40, 10, 'PARENT 1', 1, 0, 'L', 1);

        $this->fpdf->Cell(40, 10, 'PARENT 2', 1, 0, 'L', 1);




        $EleveData2 = Student::join(
            'users',
            'students.user_id',
            '=',
            'users.id'
        )
            ->where(function ($query) {
                $query->where('students.parent_id', '=', 310)
                    ->orwhere('students.parent2_id', '=', 0);
            })
            ->where('students.statut', '!=', 3)
            ->orderBy('classe_id', 'asc')
            ->orderBy('students.nom', 'asc')
            ->orderBy('students.prenom', 'asc')
            ->get();



        // $EleveData2 = Student::join(
        //     'users',
        //     'students.user_id',
        //     '=',
        //     'users.id'
        // )->where('students.statut', '!=', 3)
        //     ->where('students.parent_id', '=', 310)

        //     ->Orwhere('students.parent2_id', '=', 0)

        //     ->orderBy('classe_id', 'asc')
        //     ->orderBy('students.nom', 'asc')
        //     ->orderBy('students.prenom', 'asc')->get();



        $this->fpdf->Ln();


        foreach ($EleveData2 as $key => $Class) {





            $this->fpdf->SetX(2);
            $this->fpdf->Cell(10, $taille, $key + 1, 1, 0, 'C');
            $this->fpdf->SetFont('Arial', 'B', 9);
            $this->fpdf->Cell(90, $taille, utf8_decode($Class->nom . " " . $Class->prenom), 1, 0, 'L');

            $this->fpdf->Cell(22, $taille, utf8_decode($Class->classe->libelleClasse), 1, 0, 'L');



            $this->fpdf->SetTextColor('0', '0', '0');


            if ($Class->parent_id == 310) {

                $this->fpdf->SetTextColor('255', '0', '0');

                $this->fpdf->Cell(40, $taille, utf8_decode("NOK"), 1, 0, 'C');
            } else {

                $this->fpdf->Cell(40, $taille, utf8_decode("OK"), 1, 0, 'C');
            }

            $this->fpdf->SetTextColor('0', '0', '0');


            if ($Class->parent2_id == 0) {

                $this->fpdf->SetTextColor('255', '0', '0');

                $this->fpdf->Cell(40, $taille, utf8_decode("NOK"), 1, 0, 'C');
            } else {

                $this->fpdf->Cell(40, $taille, utf8_decode("OK"), 1, 0, 'C');
            }

            $this->fpdf->SetTextColor('0', '0', '0');


            $this->fpdf->Ln($taille);
        }


        $this->fpdf->AddPage("P", ['297', '210']);

        $this->fpdf->Image(public_path("/Photos/Logos/" . $entete), 0, 0, 210, 37,  "");


        $this->fpdf->SetFont('Arial', 'B', 12);


        $this->fpdf->Cell(0, 70, utf8_decode(" ANNEE ACADEMIQUE : $sessionEncour  "), 0, 0, 'C');

        $this->fpdf->Text(10, 55, utf8_decode(" LISTE DES ELEVES AYANT DONT LES NOMS DES PARENTS SONT MAL ECRITS "), 0, 0, 'C');
        $this->fpdf->SetFont('Arial', 'B', 9);

        $this->fpdf->Text(50, 65, utf8_decode(" Rapport  automatiquement  par l'application Le :  " . date('j/m/Y  H:i:s')), 0, 'C', 1);


        // $parents  = Parents::where('nomParent','=' , '.')->Orwhere('nomParent','=' , '..')->Orwhere('nomParent','=' , '...')->get();



        // $students = Parents::
        //   join('Students', 'parents.id', '=', 'Students.parent_id')

        // ->where('parents.nomParent', '=', '.')
        // ->orWhere('parents.nomParent', '=', '..')
        // ->orWhere('parents.nomParent', '=', '...')
        // ->with('classes')
        // ->get();


        $students = Student::join('parents', 'students.parent_id', '=', 'parents.id')
            ->join('classes', 'students.classe_id', '=', 'classes.id')

            ->where(function ($query) {
                $query->where('nomParent', '=', '.')
                    ->orWhere('nomParent', '=', '..')
                    ->orWhere('nomParent', '=', '...')
                    ->orwhere('students.parent_id', '=', 310)
                    ->orwhere('students.parent2_id', '=', 0);;
            })->where('statut', '!=', 3)

            ->orderBy('students.nom', 'asc')
            ->orderBy('students.prenom', 'asc')
            ->get();







        $this->fpdf->SetY(20);

        $this->fpdf->SetFont('Arial', 'B', 10);

        $this->fpdf->SetXY(2, 80);

        $this->fpdf->SetDrawColor(0, 0, 0);
        $this->fpdf->SetFillColor('159', '159', '159');
        $this->fpdf->SetTextColor('0', '0', '0');
        $this->fpdf->Cell(10, 10, '', 1, 0, 'C', 1);
        $this->fpdf->Cell(130, 10, 'Noms', 1, 0, 'L', 1);

        $this->fpdf->Cell(42, 10, 'Classe', 1, 0, 'L', 1);


        $this->fpdf->Ln();




        foreach ($students as $key => $student) {




            $this->fpdf->SetX(2);
            $this->fpdf->Cell(10, $taille, $key + 1, 1, 0, 'C');
            $this->fpdf->SetFont('Arial', 'B', 12);


            $this->fpdf->Cell(130, $taille, utf8_decode($student->nom . " " . $student->prenom), 1, 0, 'L');

            $this->fpdf->Cell(42, $taille, utf8_decode($student->libelleClasse), 1, 0, 'L');



            $this->fpdf->Ln($taille);
        }



        $this->fpdf->Output();
        exit;
    }


    public function getAllBourse()
    {

        $conf = config::first();

        $entete = $conf->header;

        $codeEtab = $conf->codeEtab;

        $session = Session::where('codeEtab_sess', $codeEtab)->first('libelle_sess');

        $sessionEncour = $session->libelle_sess;

        $classeName = Etablissement::where('codeEtab', $codeEtab)->first();

        $libelleName = $classeName->libelleEtab;

        $this->fpdf->AddPage("P", ['290', '210']);

        $this->fpdf->Image(public_path("/Photos/Logos/" . $entete), 0, 0, 205, 35,  "");

        $this->fpdf->SetTextColor('0', '0', '0');
        $this->fpdf->SetFont('Arial', 'B', 16);

        $this->fpdf->Cell(0, 68, "LISTE  DES BOURSIERS ", 0, 0, 'C');

        $this->fpdf->SetY(17);

        $this->fpdf->SetFont('Arial', 'B', 8);
        $this->fpdf->Cell(0, 69,  utf8_decode("ANNEE-SCOLAIRE : " . $sessionEncour), 0, 0, 'C');

        $tailleLongCell = 9;
        $taile = 9;

        $this->fpdf->SetY(22);
        // $this->fpdf->Cell(0, 63,  utf8_decode("EFFECTIF : " . count($EleveData)), 0, 0, 'C');


        $this->fpdf->SetXY(5, 60);
        $this->fpdf->SetFont('Arial', 'B', 8);
        $this->fpdf->SetFillColor(13, 183, 255);

        $this->fpdf->SetTextColor(0, 0, 0);
        $this->fpdf->Cell(10, 10, '', 1, 0, 'C', 1);
        $this->fpdf->Cell(93, 10, 'NOMS', 1, 0, 'L', 1);
        $this->fpdf->Cell(65, 10, 'Date et lieu de naissance', 1, 0, 'L', 1);
        $this->fpdf->Cell(10, 10, 'Sexe', 1, 0, 'L', 1);
        $this->fpdf->Cell(20, 10, 'Moy.Ann / 20 ', 1, 0, 'L', 1);


        $EleveData = MoyenneAnnuelle::with('classe', 'student')->where('valeur', '>=', 12)
            ->orderBy('valeur', 'desc')->get();

        $this->fpdf->Ln(10);
        foreach ($EleveData as $key => $eleve) {

            $this->fpdf->SetFont('Arial', 'B', $taile);
            $this->fpdf->SetX(5);
            $this->fpdf->Cell(10, $tailleLongCell, $key + 1, 1, 0, 'C');
            $this->fpdf->Cell(
                93,
                $tailleLongCell,
                utf8_decode($eleve->student->nom . " " . $eleve->student->prenom . "    " . '(  ' . $eleve->classe->libelleClasse . '  )'),
                1,
                'C'
            );

            $this->fpdf->Cell(
                65,
                $tailleLongCell,
                utf8_decode(date_format(date_create($eleve->student->dateNaiss), "d-m-Y") . ' à ' . $eleve->student->lieuNaiss),
                1,
                'C'
            );

            $this->fpdf->Cell(
                10,
                $tailleLongCell,
                utf8_decode($eleve->student->sexe),
                1,
                'C'
            );


            $this->fpdf->Cell(
                20,
                $tailleLongCell,
                utf8_decode($eleve->valeur),
                1,
                'C'
            );




            $this->fpdf->Ln($tailleLongCell);
        }




        $this->fpdf->Output();
        exit;
    }

    public function getEleveclassePdf($id)

    {

        // Je recupere le codeEtab, la session et l'id de la classe

        $data =  explode('*', $id);

        $IdClasse = $data[0];
        $codeEtab  = $data[1];


        $conf = config::first();

        $entete = $conf->header;



        $session = Session::where('codeEtab_sess', $codeEtab)->first('libelle_sess');

        $sessionEncour = $session->libelle_sess;



        $EleveData = Student::with('classe', 'user')
            ->where('statut', "!=", 3)
            ->where('session', $sessionEncour)
            ->where('classe_id',  $IdClasse)
            ->orderBy('nom', 'asc')
            ->orderBy('prenom', 'asc')->get();

        $Classes = Classe::where('codeEtabClasse', $codeEtab)->where('sessionClasse', $sessionEncour)->where('id',  $IdClasse)->first('libelleClasse');

        $classeName = Etablissement::where('codeEtab', $codeEtab)->first();

        // $dateTest = date(2024-08-09) ;

        // $libelleName = $classeName->libelleEtab;

        $this->fpdf->AddPage("P", ['290', '210']);

        // $this->fpdf->Image(public_path("/Photos/Logos/" . $entete), 0, 0, 205, 35,  "");

        $this->fpdf->SetTextColor('0', '0', '0');
        $this->fpdf->SetFont('Arial', 'B', 16);

        //  $this->fpdf->Text(30, 50, "LISTE DE LA CLASSE DE ". ' '.$Classes->libelleClasse);


        $this->fpdf->Cell(0, 62, 'LISTE DES ELEVES  : ' . ' ' . utf8_decode($Classes->libelleClasse), 0, 0, 'C');
        $this->fpdf->SetY(17);

        $this->fpdf->SetFont('Arial', 'B', 10);
        $this->fpdf->Cell(0, 64,  utf8_decode("ANNEE-SCOLAIRE : " . $sessionEncour), 0, 0, 'C');

        $this->fpdf->SetY(22);
        $this->fpdf->Cell(0, 66,  utf8_decode("EFFECTIF : " . count($EleveData)), 0, 0, 'C');
        $this->fpdf->SetFont('Arial', 'B', 8);
        $this->fpdf->SetY(29);
        $this->fpdf->Cell(0, 69,  utf8_decode("Liste générée automatiquement par le logiciel de gestion scolaire Xschoolink le " . date('j/m/Y  H:i:s')), 0, 0, 'C');


        $this->fpdf->SetXY(5, 76);
        $this->fpdf->SetFont('Arial', 'B', 8);
        $this->fpdf->SetFillColor(7, 120, 145);

        $this->fpdf->SetTextColor(0, 0, 0);
        $this->fpdf->Cell(10, 5, '', 1, 0, 'C', 1);
        $this->fpdf->Cell(20, 5, 'Matricule', 1, 0, 'C', 1);
        $this->fpdf->Cell(73, 5, 'NOMS des eleves', 1, 0, 'L', 1);
        $this->fpdf->Cell(20, 5, 'Date', 1, 0, 'L', 1);
        $this->fpdf->Cell(47, 5, 'Lieu', 1, 0, 'L', 1);
        $this->fpdf->Cell(10, 5, 'Sexe', 1, 0, 'L', 1);
        $this->fpdf->Cell(10, 5, 'Redbl', 1, 0, 'L', 1);
        $this->fpdf->Cell(10, 5, 'Status', 1, 0, 'L', 1);

        $this->fpdf->Ln();

        $tailleLongCell = 5;
        $taile = 7;





        foreach ($EleveData as $key => $eleve) {

            $this->fpdf->SetFont('Arial', 'B', $taile);
            $this->fpdf->SetX(5);
            $this->fpdf->Cell(10, $tailleLongCell, $key + 1, 1, 0, 'C');

            $this->fpdf->Cell(20, $tailleLongCell, utf8_decode($eleve->matricule), 1, 'C');


            $this->fpdf->Cell(
                73,
                $tailleLongCell,
                utf8_decode($eleve->nom . " " . $eleve->prenom),
                1,
                'C'
            );


            $this->fpdf->Cell(
                20,
                $tailleLongCell,
                utf8_decode(date_format(date_create($eleve->dateNaiss), "d-m-Y")),
                1,
                'C'
            );


            $this->fpdf->SetFont('Arial', 'B', $taile - 2);

            $this->fpdf->Cell(
                47,
                $tailleLongCell,
                utf8_decode($eleve->lieuNaiss),
                1,
                'C'
            );


            $this->fpdf->SetFont('Arial', 'B', $taile);

            $this->fpdf->Cell(
                10,
                $tailleLongCell,
                utf8_decode($eleve->sexe),
                1,
                0,
                'C'
            );
            $this->fpdf->SetFont('Arial', 'B', $taile);

            $this->fpdf->Cell(
                10,
                $tailleLongCell,
                utf8_decode($eleve->doublant),
                1,
                'C'
            );


            // Compare the two DateTime objects


            if ($eleve->id >= 2263) {
                $resp = "N";
            } else {
                $resp = "A";
            }



            $this->fpdf->Cell(10, $tailleLongCell, $resp, 1, 0, 'C', 0);
            $this->fpdf->Ln($tailleLongCell);
        }









        $this->fpdf->Output();
        exit;
    }

    public function getEleveRecuPdf($id)

    {

        // Je recupere le codeEtab, la session et l'id de la classe


        $IdRecu = $id;





        $conf = config::first();

        $entete = $conf->header;

        $VersementsData = Versements::with('student', 'classe')->where('id', $IdRecu)->first();

        $codeEtab = $VersementsData->codeEtab;

        $session = $VersementsData->session;

        // dd($VersementsData);

        $classeName = Etablissement::where('codeEtab', $codeEtab)->first();


        $conf = config::first();

        $entete = $conf->header;










        // for ($i = 0; $i < 2; $i++) {


        $this->fpdf->AddPage("P", ['210', '148']);

        $this->fpdf->Image(public_path("/Photos/Logos/" . $entete), 3, 5, 140, 27,  "");

        //$this->fpdf->Image(public_path("/Photos/Logos/footer.jpeg"), 0, 97, 210, 8, "JPG", "");

        // $this->fpdf->SetTextColor('255', '255', '255');
        $this->fpdf->SetFillColor('176', '176', '176');
        $this->fpdf->SetFont('Arial', 'B', 12);
        $this->fpdf->SetXY(0, 38);

        if ($VersementsData->id < 10) {

            $code = '0' . $VersementsData->id;
        } else {
            $code = $VersementsData->id;
        }

        $this->fpdf->Cell(150, 7, utf8_decode("Reçu Nº " . $code), 0, 0, 'C', 1);


        // $this->fpdf->SetXY(10, 65);
        // $this->fpdf->Cell(123, 15, '', 1);



        // // Les libelles
        $this->fpdf->SetFont('Arial', 'B', 6);


        $this->fpdf->Text(105, 35, utf8_decode("ANNEE-SCOLAIRE : " . utf8_decode($session)));


        // //$this->fpdf->Text(40, 30, utf8_decode(""));

        $this->fpdf->SetFont('Arial', 'B', 6);

        $this->fpdf->Text(15, 50, utf8_decode("Matricule : "));

        $this->fpdf->Text(15, 55, utf8_decode("Noms et prénoms : "));

        $this->fpdf->Text(15, 60, utf8_decode("Classe :"));

        // // Trait se separation


        $this->fpdf->Line(0, 105, 193, 105);
        $this->fpdf->Line(0, 105, 193, 105);


        $this->fpdf->Text(15, 65, utf8_decode("Montant versée : "));

        $this->fpdf->Text(95, 65, utf8_decode("Pour :  "));

        $this->fpdf->Text(15, 70, utf8_decode("Scolarité restante totale  : "));


        $this->fpdf->Text(15, 75, utf8_decode("Délai de paiement première tranche : "));

        $this->fpdf->Text(85, 75, utf8_decode("Délai de paiement deuxième tranche :  "));


        if ($VersementsData->motif == "APE") {

            $VersementsData->motif = "INSCRIPTION";
        } else {

            $VersementsData->motif = $VersementsData->motif;
        }




        $VersementsRestant = Versements::where('student_id', $VersementsData->student->id)->sum('montantverser');





        // // Les variables

        $this->fpdf->SetFont('Arial', 'B', 7);

        $this->fpdf->Text(65, 50, utf8_decode('' . $VersementsData->student->matricule));

        $this->fpdf->Text(65, 55, utf8_decode('' . $VersementsData->student->nom . ' ' . $VersementsData->student->prenom));

        $this->fpdf->Text(65, 60, utf8_decode(''  . $VersementsData->classe->libelleClasse));

        $this->fpdf->Text(65, 65, utf8_decode(''  . $VersementsData->montantverser . '  F'));

        $this->fpdf->Text(65, 70, utf8_decode(''  . ($VersementsData->classe->inscription_Classe +
            $VersementsData->classe->scolarite_Classe +
            $VersementsData->classe->scolariteaff_Classe)
            - $VersementsRestant . '  F'));

        $this->fpdf->Text(65, 75, utf8_decode(' 15/10/2022 '));

        $this->fpdf->Text(123, 75, utf8_decode(' 15/12/2022 '));

        $this->fpdf->Text(103, 65, utf8_decode('Frais de paiement ' . strtoupper($VersementsData->motif)));


        // annnee scolaire
        // $this->fpdf->Text(125, 20, utf8_decode($session));

        $this->fpdf->SetFont('Arial', 'B', 7);



        $this->fpdf->Text(15, 85, utf8_decode(' La caisse    '));


        $date = date_create($VersementsData->date);

        // $this->fpdf->SetFont('Arial', 'B', 7);


        $this->fpdf->Text(105, 85, utf8_decode('Fait au CDM le ') . date_format($date, "d/m/Y"));

        $this->fpdf->SetFont('Arial', 'I', 6);



        $this->fpdf->Text(95, 98, utf8_decode('Ce reçu doit être présenté pour toute réclamation '));




        // Deuxieme partie

        $this->fpdf->Ln(15);



        $this->fpdf->Image(public_path("/Photos/Logos/" . $entete), 0, 112, 148, 27,  "");

        $this->fpdf->SetFont('Arial', 'B', 6);



        // Les libelles


        $this->fpdf->Text(105, 142, utf8_decode("ANNEE SCOLAIRE : ") . utf8_decode($session));

        $this->fpdf->SetFont('Arial', 'B', 12);

        $this->fpdf->SetXY(0, 145);

        $this->fpdf->Cell(150, 7, utf8_decode("Reçu Nº " . $code), 0, 0, 'C', 1);


        $this->fpdf->SetFont('Arial', 'B', 6);

        $this->fpdf->Text(15, 157, utf8_decode("Matricule : "));

        $this->fpdf->Text(15, 162, utf8_decode("Noms et Prénoms : "));

        $this->fpdf->Text(15, 167, utf8_decode("Classe  :"));

        $this->fpdf->Text(15, 172, utf8_decode("Montant versée : "));

        $this->fpdf->Text(95, 172, utf8_decode("Pour : "));

        $this->fpdf->Text(15, 177, utf8_decode("Scolarité restante totale : "));


        $this->fpdf->Text(15, 182, utf8_decode("Délai de paiement première tranche : "));

        $this->fpdf->Text(85, 182, utf8_decode("Délai de paiement deuxième tranche : "));




        // // Les variables

        $this->fpdf->SetFont('Arial', 'B', 6);

        $this->fpdf->Text(65, 157, utf8_decode('' . $VersementsData->student->matricule));

        $this->fpdf->Text(65, 162, utf8_decode('' . $VersementsData->student->nom . ' ' . $VersementsData->student->prenom));
        // claase pour recu 1

        $this->fpdf->Text(65, 167, utf8_decode(''  . $VersementsData->classe->libelleClasse));

        $this->fpdf->Text(65, 172, utf8_decode(''  . $VersementsData->montantverser . '  F'));

        $this->fpdf->Text(105, 172, utf8_decode('Frais de paiement ' . strtoupper($VersementsData->motif)));

        $this->fpdf->Text(65, 177, utf8_decode(''  . ($VersementsData->classe->inscription_Classe +
            $VersementsData->classe->scolarite_Classe +
            $VersementsData->classe->scolariteaff_Classe)
            - $VersementsRestant . '  F'));

        $this->fpdf->Text(65, 182, utf8_decode(' 15/10/2022 '));

        $this->fpdf->Text(122, 182, utf8_decode(' 15/12/2022 '));




        $this->fpdf->SetFont('Arial', 'B', 7);


        $this->fpdf->Text(15, 192, utf8_decode(' La caisse    '));


        $date = date_create($VersementsData->date);

        // $this->fpdf->SetFont('Arial', 'B', 7);


        $this->fpdf->Text(105, 192, utf8_decode('Fait au CDM le ') . date_format($date, "d/m/Y"));

        $this->fpdf->SetFont('Arial', 'I', 6);



        $this->fpdf->Text(95, 203, utf8_decode('Ce reçu doit être présenté pour toute réclamation '));





        $this->fpdf->Output();
        exit;
    }

    public function index($id)




    {





        // carte scolaire de toute une classe

        // Je recupere le codeEtab, la session et l'id de la classe

        // Je recupere le codeEtab, la session et l'id de la classe

        $data =  explode('*', $id);

        $IdClasse = $data[0];
        $codeEtab  = $data[1];

        // Information de cette ecole

        $classeName = Etablissement::where('codeEtab', $codeEtab)->first();

        $session = Session::where('codeEtab_sess', $codeEtab)->first('libelle_sess');

        $sessionEncour = $session->libelle_sess;

        $conf = config::first();


        $entete = $conf->header;

        // $classeData = Student::with('parent')->where('classe_id', $IdClasse)
        //     ->where('statut', '!=', 3)
        //     ->orderBy('nom', 'asc')
        //     ->orderBy('prenom', 'asc')->get();


        $classeData = Student::with('parent', 'user')


            ->where('statut', '!=', 3)





            // Toutes les P et TLe STT

            // ->whereIn('classe_id', [115, 84, 87, 85, 88])


            // Toutes les P INDUS

            // ->whereIn('classe_id', [106, 113, 127, 124, 110])


            // ->whereIn('classe_id', [107, 114, 128, 125, 111])


            // Les 4eme annees

            // ->whereIn('classe_id', [118, 96, 122, 104, 92])


            // Les  stt interm

            ->where('classe_id', $IdClasse)


            // 118, 96, 122, 104, 92


            ->orderBy('classe_id', 'asc')
            ->orderBy('nom', 'asc')
            ->orderBy('prenom', 'asc')

            ->get();

        // ->get()
        // ->slice(300, 350);



        // foreach ($classeData as $key => $data) {


        //     $parent2 = Parents::where('id', $data->parent2_id)->first();

        //     if (isset($parent2['nomParent']) && $parent2['nomParent'] === '.') {
        //         unset($classeData[$key]);
        //     }
        // }


        foreach ($classeData as $key => $data) {


            $parent2 = Parents::where('id', $data->parent2_id)->first();

            // dd($parent2->nomParent);





            $this->fpdf->AddPage("L", ['90', '60']);

            $fr = 7;
            $en = 5;


            $this->fpdf->Image(public_path("/Photos/Logos/footer2.PNG"), 0, 0, 90, 2); //haut


            $this->fpdf->Image(public_path("/Photos/Logos/signature.jpg"), 46, 25, 39, 30); // gauche

            $this->fpdf->Image(public_path("/Photos/Logos/footer.PNG"), 89, 0, 1, 80); // Droit



            $this->fpdf->Image(public_path("/Photos/Logos/" . $entete), 2, 2, 85, 15,  "");

            $this->fpdf->Ln(1);

            $this->fpdf->SetFont('Arial', 'B', 13,);
            $this->fpdf->SetTextColor('10', '75', '168');




            $this->fpdf->Cell(0, 18, utf8_decode($classeName->libelleEtab), 0, 0, 'C');

            $this->fpdf->SetFont('Arial', 'B', 6);

            $this->fpdf->SetTextColor('237', '28', '36');


            $this->fpdf->Text(20, 25, utf8_decode("ANNEE-SCOLAIRE : $data->session "));


            $this->fpdf->Ln(2);

            $this->fpdf->SetTextColor('44', '53', '61');





            $this->fpdf->SetFont('Arial', 'B', 8);

            if (file_exists(public_path("/Photos/Logos/" . $data->user->photo))) {


                // $this->fpdf->SetAlpha(0.5);

                $this->fpdf->Image(
                    public_path("/Photos/Logos/" . $data->user->photo),
                    3,
                    29,
                    15,
                    19,
                    ""
                );
            }




            // informations eleves

            // $this->fpdf->RotatedText(35,190,'texte filigrane',45);


            // $this->fpdf->SetFont('Arial', 'IB', 5);
            // $this->fpdf->Text(20, 26, utf8_decode("Année-Scolaire  "));
            // $this->fpdf->SetFont('Arial', 'B', 6);
            // $this->fpdf->Text(35, 26, $data->session);

            $label = 5;

            $taille = 6;

            $this->fpdf->SetFont('Arial', 'IB', $label);
            $this->fpdf->Text(20, 29, "Matricule");
            $this->fpdf->SetFont('Arial', 'B', $taille);
            $this->fpdf->Text(35, 29, $data->matricule);

            $this->fpdf->SetFont('Arial', 'IB', $label);
            $this->fpdf->Text(20, 32, utf8_decode("Noms "));
            $this->fpdf->SetFont('Arial', 'B', $taille);
            $this->fpdf->Text(35, 32, utf8_decode($data->nom) . ' ' . utf8_decode($data->prenom));



            $this->fpdf->SetFont('Arial', 'I', $label);
            $this->fpdf->Text(20, 35, "Date et Lieu  ");
            $this->fpdf->SetFont('Arial', 'B', $taille);
            $this->fpdf->Text(35, 35, date_format(date_create($data->dateNaiss), "d-m-Y") . " " . utf8_decode(" à $data->lieuNaiss"));


            $this->fpdf->SetFont('Arial', 'IB', $label);
            $this->fpdf->Text(20, 38, "Sexe  ");
            $this->fpdf->SetFont('Arial', 'B', $taille);
            $this->fpdf->Text(35, 38, $data->sexe);


            $this->fpdf->SetFont('Arial', 'IB', $label);
            $this->fpdf->Text(20, 41, "Classe  ");
            $this->fpdf->SetFont('Arial', 'B', $taille);
            $this->fpdf->Text(35, 41, utf8_decode($data->Classe->libelleClasse));



            $this->fpdf->SetFont('Arial', 'IB', $label);
            $this->fpdf->Text(20, 44, "Fils  / Fille  de  ");
            $this->fpdf->SetFont('Arial', 'B', $taille);
            $this->fpdf->Text(35, 44, utf8_decode($data->parent->nomParent . ' ' . $data->parent->prenomParent));


            $this->fpdf->SetFont('Arial', 'IB', $label);
            $this->fpdf->Text(20, 47, "Et de  ");
            $this->fpdf->SetFont('Arial', 'B', $taille);
            if ($parent2 == null) {

                $this->fpdf->Text(35, 47, utf8_decode(""));
            } else {
                $this->fpdf->Text(35, 47, utf8_decode($parent2['nomParent'] . ' ' . $parent2['prenomParent']));
            }



            $this->fpdf->SetFont('Arial', 'IB', $label);
            $this->fpdf->Text(20, 50, "Tel du parent ");
            $this->fpdf->SetFont('Arial', 'B', $taille);


            if ($data->Parent->telParent == '111111' || $data->Parent->telParent == 0) {

                $this->fpdf->Text(35, 47, utf8_decode(""));
            } else {
                $this->fpdf->Text(35, 50, utf8_decode($data->Parent->telParent));
            }







            $this->fpdf->SetFont('Arial', 'B', 6);

            $this->fpdf->Text(53, 54, utf8_decode("LE PROVISEUR "));

            $this->fpdf->Image(public_path("/Photos/Logos/footer2.PNG"), 0, 58, 90, 2);



            // $this->fpdf->Image(public_path("/Photos/Logos/footer.jpeg"), 0, 0, 60, 90, 4);

            // $this->fpdf->Image(public_path("/Photos/Logos/cni.PNG"), 0, 58, 110, 2);

        }

        $this->fpdf->Output();

        exit;
    }



    public function getEleveCniPdf($id)

    {

        // Je recupere le codeEtab, la session et l'id de la classe

        $IdEleve = $id;

        $conf = config::first();

        $entete = $conf->header;


        $data = Student::with('classe', 'user', 'parent')->where('id', $IdEleve)->first();

        $codeEtab = $data->codeEtab;

        $classeName = Etablissement::where('codeEtab', $codeEtab)->first();




        $data->parent2 = Parents::where('id', $data['parent2_id'])->first();

        // Allons chercher le deuxieme parent





        $data->parent2 = Parents::where('id', $data['parent2_id'])->first();

        // Allons chercher le deuxieme parent





        $this->fpdf->AddPage("L", ['297', '210']);

        $fr = 7;
        $en = 5;





        $this->fpdf->SetXY(50, 30);

        $this->fpdf->SetFont('Arial', 'B', 70);

        // $this->fpdf->Cell(5, 5, QrCode::generate('this is should generate QR'), 1, 1);


        // $this->fpdf->Rect(50, 20, 230, 145);


        $this->fpdf->SetFillColor('10', '75', '168');


        $this->fpdf->SetFont('Times', "B");

        $this->fpdf->SetTextColor('10', '75', '168');

        // $this->fpdf->Image(public_path("/Photos/Logos/test.svg"), 0, 0, 10, 20);

        $this->fpdf->Multicell(186, 60, utf8_decode("CERTIFICAT"), 0, 'C');

        $this->fpdf->SetTextColor('0', '0', '0');



        $this->fpdf->SetFont('Arial', 'B', 18);
        $this->fpdf->SetXY(50, 62);

        $this->fpdf->Multicell(183, 30, utf8_decode("DE SCOLARITE "), 0, 'C');


        $this->fpdf->SetFont('Arial', 'B', 14);
        $this->fpdf->SetXY(20, 80);

        $this->fpdf->Text(
            20,
            90,
            utf8_decode("Je soussigné MME MAKANDA ESTHER GISÈLE LOUISE , PROVISEUR  du $classeName->libelleEtab  "),
            0,
            'C'
        );
        $this->fpdf->Text(20, 100, utf8_decode("BP 32 MANJO , Tel : +237 691 52 46 88  atteste que :  "), 0, 'C');


        // QrCode::format('png')->size(399)->color(40, 40, 40)->generate("$etabName , session $sessionEncour , utf8_decode($data->nom) . ' ' . utf8_decode($data->prenom) ,  utf8_decode($data->classe->libelleClasse) ", public_path("/Photos/Logos/Qrcode.png"));





        if (!file_exists(public_path("/Photos/Qrcodes/" . $data->id . ".png"))) {

            $dataToEncode = mb_convert_encoding(
                $data->nom . " " .
                    $data->prenom . ',' .
                    utf8_decode(date_format(
                        date_create($data->dateNaiss),
                        "d /m/ Y"
                    )) . "," .
                    $data->lieuNaiss . "," .
                    $classeName->libelleEtab  . ":",

                'utf-8',
                // Specify the original encoding of the data here
            );

            QrCode::format('png')
                ->size(299)
                ->color(40, 40, 40)
                ->encoding('utf-8') // Only needed if using option 1
                ->generate($dataToEncode, public_path("/Photos/Qrcodes" . $data->id . ".png"));

            $this->fpdf->Image(public_path("/Photos/Qrcodes" . $data->id . ".png"), 1, 170, 20, 20);
        }






        if ($data->sexe == "M") {

            $this->fpdf->Text(
                20,
                110,
                utf8_decode("Le nommé  :  "),
                0,
                'C'
            );
        } else {
            $this->fpdf->Text(20, 110, utf8_decode("La nommée :  "), 0, 'C');
        }


        $this->fpdf->SetTextColor('10', '75', '168');

        $this->fpdf->Text(55, 110, utf8_decode($data->nom) . ' ' . utf8_decode($data->prenom), 0, 'C');

        $this->fpdf->SetTextColor('0', '0', '0');
        $this->fpdf->Text(190, 110, utf8_decode("Sexe   :   $data->sexe "), 0, 'C');


        $this->fpdf->Text(20, 120, utf8_decode("Ne(e) le        :  ") . '  ' . date_format(date_create($data->dateNaiss), "d/m/Y"), 0, 'C');



        $this->fpdf->Text(190, 120, utf8_decode("A         :   $data->lieuNaiss "), 0, 'C');

        $this->fpdf->Text(20, 130, "Fils de          : " . "   " .  utf8_decode($data->parent['nomParent'] . " " . $data->parent['prenomParent']), 0, 'C');

        if ($data->parent2 != null) {
            $this->fpdf->Text(190, 130, "Et de  :   " . "   " .  utf8_decode($data->parent2['nomParent'] . " " . $data->parent2['prenomParent']), 0, 'C');
        } else {
            $this->fpdf->Text(
                190,
                130,
                "Et de  :  ",
                0,
                'C'
            );
        }




        $this->fpdf->SetFont('Arial', 'B', 13);

        $this->fpdf->SetXY(20, 125);

        $this->fpdf->SetTextColor('0', '0', '0');

        $this->fpdf->Multicell(270, 30, utf8_decode("est élève dans son établissement en classe de  ") . " " . utf8_decode($data->classe->libelleClasse) . " " . utf8_decode(" pour l'année scolaire" . " " . utf8_decode($data->session) . ' ' . "sous le matricule $data->matricule" . "."), 0, 'L');


        $this->fpdf->SetFont('Arial', 'BI', 12);

        $this->fpdf->Text(20, 150, utf8_decode("En foi de quoi le présent Certificat de Scolarité lui est délivré pour servir et faire valoir ce que de droit ."), 0, 'C');


        $this->fpdf->SetFont('Arial', 'B', 13);

        $this->fpdf->Text(190, 170, utf8_decode("Fait à MANENGOLE Le  ................................."), 0, 'C');

        $this->fpdf->Text(190, 182, utf8_decode("Le Proviseur "), 0, 'C');




        // $this->fpdf->Image(public_path("/Photos/Logos/testupp.PNG"), 0, 0, 50, 50);

        $this->fpdf->Image(public_path("/Photos/Logos/" . $entete), 20, 10, 260, 35, "");

        $this->fpdf->Image(
            public_path("/Photos/Logos/footer.PNG"),
            0,
            0,
            310,
            5
        );


        $this->fpdf->Image(public_path("/Photos/Logos/footer.PNG"), 0, 205, 310, 8);


        $this->fpdf->Image(
            public_path("/Photos/Logos/testuu.png"),
            230,
            50,
            40,
            25
        );










        $this->fpdf->Output();

        exit;
    }


    // public function getAllBulletinAnnuelle($id)

    // {



    //     $conf = config::first();

    //     $entete = $conf->header;

    //     $IdClasse = $id;

    //     $sommeNoteCoef1 = $sommeNoteCoef2 = $sommeNoteCoef3 = 0;

    //     $sommeCoef1 = $sommeCoef2 = $sommeCoef3 = 0;

    //     $couleurRouge = 10;

    //     // Je trouve le codeEtab et la session

    //     $code = Classe::where('id', $IdClasse)->first();
    //     $codeEtab = $code->codeEtabClasse;
    //     $session = $code->sessionClasse;

    //     $libelleClasse = $code->libelleClasse;
    //     // je recupere le premier chiffre de la classe qui va decrementer si l'enfant passe en classe superieure

    //     $labelClasseChiffre = (int)($libelleClasse[0]);

    //     // Je recupere les lettres restantes

    //     $labelSuiteClasse = substr($libelleClasse, 1);

    //     // dd($labelSuiteClasse);



    //     $Trimestres = Trimestre::where('codeEta_semes', $codeEtab)->get();

    //     $idTrim1 = $Trimestres[0]->id;
    //     $idTrim2 = $Trimestres[1]->id;
    //     $idTrim3 = $Trimestres[2]->id;


    //     $classeName = Etablissement::where('codeEtab', $codeEtab)->first();

    //     $rest = Classe::where('id', $IdClasse)->first();

    //     $teach = Enseignants::where('id', $rest->principale_Classe)->first();


    //     // Tous les eleves


    //     $classeData = Student::with('user', 'classe')->where('classe_id', $IdClasse)

    //         ->where('session', $session)->where('codeEtab', $codeEtab)->get();

    //     $moyData =   MoyenneAnnuelle::with('student')->where('session', $session)
    //         ->where('codeEtab', $codeEtab)->where('classe_id', $IdClasse)->where('valeur', '>', 0)
    //         ->orderBy('valeur', 'DESC')->get();




    //     // Nombre deleves  dans cette classe


    //     $effectif = Student::where('classe_id', $IdClasse)
    //         ->where('session', $session)
    //         ->where('statut', "!=", 3)
    //         ->where('codeEtab', $codeEtab)->count();

    //     //  $effectif = count($moyData);

    //     // Nombre deleves ayant une moyenne dans cette classe dans le trimestre

    //     $nombreEleves =  MoyenneAnnuelle::where('classe_id', $IdClasse)->where('valeur', '>', 0)
    //         ->where('session', $session)->where('codeEtab', $codeEtab)->count();


    //     // Mpyenne gen de la classe


    //     $moyenneSommeClasse =  MoyenneAnnuelle::where('classe_id', $IdClasse)
    //         ->where('session', $session)->where('codeEtab', $codeEtab)->sum('valeur');


    //     // dump($moyData);


    //     // Je recupere les notes de trim  1


    //     $noteData1 =   NotesTrimestres::where('trimestre_id', $idTrim1)->where('classe_id', $IdClasse)->where('session', $session)->where('codeEtab', $codeEtab)->get();


    //     // Moyenne du dernier

    //     $MoyDernier = MoyenneAnnuelle::where('classe_id', $IdClasse)->min('valeur');


    //     // // Moyenne du premier

    //     $MoyPremier = MoyenneAnnuelle::where('classe_id', $IdClasse)->max('valeur');


    //     foreach ($moyData   as $ley => $data) {



    //         if ($ley == 0) {

    //             $e = 'er';
    //         } else {

    //             $e = 'eme';
    //         }


    //         $this->fpdf->AddPage("P", ['335', '210']); // 315


    //         //**************************************categorie1 ******************************************* //


    //         // note trim1 de la cat1


    //         $Note[$data->student->id] = NotesTrimestres::with('matiere', 'student', 'evaluation', 'user')

    //             ->where('trimestre_id', $idTrim1)
    //             ->where('classe_id', $IdClasse)
    //             ->where('cat_id', 1)
    //             ->where('student_id', $data->student->id)
    //             ->where('codeEtab', $codeEtab)
    //             ->where('session', $session)->orderBy('matiere_id')->get();


    //         // note trim2 de la cat1

    //         $Note2[$data->student->id] = NotesTrimestres::with('matiere', 'student', 'evaluation', 'user')
    //             ->where('trimestre_id', $idTrim2)
    //             ->where('classe_id', $IdClasse)
    //             ->where('cat_id', 1)
    //             ->where('student_id', $data->student->id)
    //             ->where('codeEtab', $codeEtab)
    //             ->where('session', $session)->orderBy('matiere_id')->get();

    //         // note trim3 de la cat1

    //         $Note3[$data->student->id] = NotesTrimestres::with('matiere', 'student', 'evaluation', 'user')

    //             ->where('trimestre_id', $idTrim3)
    //             ->where('classe_id', $IdClasse)
    //             ->where('cat_id', 1)
    //             ->where('student_id', $data->student->id)
    //             ->where('codeEtab', $codeEtab)
    //             ->where('session', $session)->orderBy('matiere_id')->get();


    //         // note annuelle de la cat1

    //         $noteAnnuelle[$data->student->id] = noteAnnuelle::with('matiere', 'student', 'evaluation', 'user')

    //             ->where('classe_id', $IdClasse)
    //             ->where('cat_id', 1)
    //             ->where('student_id', $data->student->id)
    //             ->where('codeEtab', $codeEtab)
    //             ->where('session', $session)->get();




    //         //     $NoteTrimestre3[$data->student->id] = NotesTrimestres::with('matiere', 'student', 'evaluation', 'user')



    //         //         ->where('trimestre_id', $IdTrimmestre)
    //         //         ->where('classe_id', $IdClasse)
    //         //         ->where('cat_id', 3)
    //         //         ->where('student_id', $data->student->id)
    //         //         ->where('codeEtab', $codeEtab)
    //         //         ->where('session', $session)->get();


    //         $val  = NotesTrimestres::with('matiere', 'student', 'evaluation', 'user')
    //             ->where('trimestre_id', $idTrim1)
    //             ->where('classe_id', $IdClasse)
    //             ->where('cat_id', 1)
    //             ->where('student_id', $data->student->id)
    //             ->where('codeEtab', $codeEtab)
    //             ->where('session', $session)->count();


    //         $val3  = NotesTrimestres::with('matiere', 'student', 'evaluation', 'user')
    //             ->where('trimestre_id', $idTrim1)
    //             ->where('classe_id', $IdClasse)
    //             ->where('cat_id', 2)
    //             ->where('student_id', $data->student->id)
    //             ->where('codeEtab', $codeEtab)
    //             ->where('session', $session)->count();


    //         $val4  = NotesTrimestres::with('matiere', 'student', 'evaluation', 'user')
    //             ->where('trimestre_id', $idTrim1)
    //             ->where('classe_id', $IdClasse)
    //             ->where('cat_id', 3)
    //             ->where('student_id', $data->student->id)
    //             ->where('codeEtab', $codeEtab)
    //             ->where('session', $session)->count();


    //         //     //     $heureTrimestre  = Presences::where('classe_id', $IdClasse)
    //         //     //         ->where('mois_id', $IdTrimmestre)->where('student_id', $data->student->id)
    //         //     //         ->where('codeEtab', $codeEtab)
    //         //     //         ->where('session', $session)->sum('duree');


    //         // Absences non justifies

    //         // $heureTrimestreNonJustifies = Presences::where('classe_id', $IdClasse)
    //         //     ->where('student_id', $data->student->id)
    //         //     ->where('codeEtab', $codeEtab)->where('etat', 0)
    //         //     ->where('session', $session)->sum('duree');


    //         // $heureTrim1 = Presences::where('classe_id', $IdClasse)
    //         //     ->where('student_id', $data->student->id)
    //         //     ->where('codeEtab', $codeEtab)->where('etat', 0)
    //         //     ->where('mois_id', $idTrim1)
    //         //     ->where('session', $session)->sum('duree');


    //         // $heureTrim2 = Presences::where('classe_id', $IdClasse)
    //         //     ->where('student_id', $data->student->id)
    //         //     ->where('codeEtab', $codeEtab)->where('etat', 0)
    //         //     ->where('mois_id', $idTrim2)
    //         //     ->where('session', $session)->sum('duree');

    //         // $heureTrim3 = Presences::where('classe_id', $IdClasse)
    //         //     ->where('student_id', $data->student->id)
    //         //     ->where('codeEtab', $codeEtab)->where('etat', 0)
    //         //     ->where('mois_id', $idTrim3)
    //         //     ->where('session', $session)->sum('duree');



    //         // Je cherche les consigne et les jour d'exusion du trimestre

    //         // $heureConsigneTrimestre  = discipline::where('classe_id', $IdClasse)
    //         //     ->where('student_id', $data->student->id)->where('type', 'con')
    //         //     ->where('codeEtab', $codeEtab)
    //         //     ->where('session', $session)->sum('duree');


    //         // $ExclusionTrimestre  = discipline::where('classe_id', $IdClasse)
    //         //     ->where('student_id', $data->student->id)->where('type', 'ex')
    //         //     ->where('codeEtab', $codeEtab)
    //         //     ->where('session', $session)->sum('duree');







    //         //**************************************categorie 2******************************************* //


    //         // Note devoir 1 de la cat 2


    //         $Notecat2[$data->student->id] = NotesTrimestres::with('matiere', 'student', 'evaluation', 'user')

    //             ->where('trimestre_id', $idTrim1)
    //             ->where('classe_id', $IdClasse)
    //             ->where('cat_id', 2)
    //             ->where('student_id', $data->student->id)
    //             ->where('codeEtab', $codeEtab)
    //             ->where('session', $session)->orderBy('matiere_id')->get();


    //         // Note devoir 2 de la cat 2

    //         $Note2cat2[$data->student->id] = NotesTrimestres::with('matiere', 'student', 'evaluation', 'user')
    //             ->where('trimestre_id', $idTrim2)
    //             ->where('classe_id', $IdClasse)
    //             ->where('cat_id', 2)
    //             ->where('student_id', $data->student->id)
    //             ->where('codeEtab', $codeEtab)
    //             ->where('session', $session)->orderBy('matiere_id')->get();



    //         // Note devoir 3 de la cat 2

    //         $Note3cat2[$data->student->id] = NotesTrimestres::with('matiere', 'student', 'evaluation', 'user')
    //             ->where('trimestre_id', $idTrim3)
    //             ->where('classe_id', $IdClasse)
    //             ->where('cat_id', 2)
    //             ->where('student_id', $data->student->id)
    //             ->where('codeEtab', $codeEtab)
    //             ->where('session', $session)->orderBy('matiere_id')->get();



    //         // Note annuelle   de la cat 2

    //         $NoteAnnuellecat2[$data->student->id] = noteAnnuelle::with('matiere', 'student', 'evaluation', 'user')
    //             ->where('classe_id', $IdClasse)
    //             ->where('cat_id', 2)
    //             ->where('student_id', $data->student->id)
    //             ->where('codeEtab', $codeEtab)
    //             ->where('session', $session)->get();




    //         // Note annuelle   de la cat 3

    //         $NoteAnnuellecat3[$data->student->id] = noteAnnuelle::with('matiere', 'student', 'evaluation', 'user')
    //             ->where('classe_id', $IdClasse)
    //             ->where('cat_id', 3)
    //             ->where('student_id', $data->student->id)
    //             ->where('codeEtab', $codeEtab)
    //             ->where('session', $session)->get();


    //         // dump( $NoteTrimestrecat2[$data->student->id]);





    //         //     //     // Note trimestre  de la cat 2 ( meme role que la requette du haut )


    //         //     //     $NoteTrimestre2[$data->student->id] = NotesTrimestres::with('matiere', 'student', 'evaluation', 'user')
    //         //     //         ->where('trimestre_id', $IdTrimmestre)
    //         //     //         ->where('classe_id', $IdClasse)
    //         //     //         ->where('cat_id', 2)
    //         //     //         ->where('student_id', $data->student->id)
    //         //     //         ->where('codeEtab', $codeEtab)
    //         //     //         ->where('session', $session)->get();





    //         //     /*************************************** categorie 3  **********************************  /     //


    //         // Note devoir 1 de la cat 3


    //         $Notecat3[$data->student->id] = NotesTrimestres::with('matiere', 'student', 'evaluation', 'user')
    //             ->where('trimestre_id', $idTrim1)
    //             ->where('classe_id', $IdClasse)
    //             ->where('cat_id', 3)
    //             ->where('student_id', $data->student->id)
    //             ->where('codeEtab', $codeEtab)
    //             ->where('session', $session)->orderBy('matiere_id')->get();

    //         // Note devoir 2 de la cat 3

    //         $Note2cat3[$data->student->id] = NotesTrimestres::with('matiere', 'student', 'evaluation', 'user')
    //             ->where('trimestre_id', $idTrim2)
    //             ->where('classe_id', $IdClasse)
    //             ->where('cat_id', 3)
    //             ->where('student_id', $data->student->id)
    //             ->where('codeEtab', $codeEtab)
    //             ->where('session', $session)->orderBy('matiere_id')->get();


    //         // Note devoir 3 de la cat 3

    //         $Note3cat3[$data->student->id] = NotesTrimestres::with('matiere', 'student', 'evaluation', 'user')
    //             ->where('trimestre_id', $idTrim3)
    //             ->where('classe_id', $IdClasse)
    //             ->where('cat_id', 3)
    //             ->where('student_id', $data->student->id)
    //             ->where('codeEtab', $codeEtab)
    //             ->where('session', $session)->orderBy('matiere_id')->get();

    //         //     //     // Note trimestre  de la cat 3

    //         //     //     $NoteTrimestrecat3[$data->student->id] = NotesTrimestres::with('matiere', 'student', 'evaluation', 'user')
    //         //     //         ->where('trimestre_id', $IdTrimmestre)
    //         //     //         ->where('classe_id', $IdClasse)
    //         //     //         ->where('cat_id', 3)
    //         //     //         ->where('student_id', $data->student->id)
    //         //     //         ->where('codeEtab', $codeEtab)
    //         //     //         ->where('session', $session)->get();


    //         // je recupere les photo des eleves dans user

    //         // je recupere les photo des eleves dans user

    //         $EleveData[$data->student->id] = Student::with('user')->where('id', $data->student->id)->get();


    //         //$this->fpdf->SetXY(20,115);


    //         $this->fpdf->Image(public_path("/Photos/Logos/" . $entete), 5, 6, 200, 36, "");




    //         $tailleNote = 7;
    //         $libelle = 7;
    //         // Informations de l'eleve

    //         $this->fpdf->SetFont('Arial', 'B', 7);
    //         $this->fpdf->Text(105, 58, 'Matricule : ');
    //         $this->fpdf->SetFont('Arial', 'B', 7);
    //         $this->fpdf->Text(137, 58, $Note[$data->student->id][0]->student->matricule);

    //         $this->fpdf->SetFont('Arial', 'B', 7);
    //         $this->fpdf->Text(105, 63, utf8_decode('Noms et prénoms :  '));
    //         $this->fpdf->SetFont('Arial', 'B', 7);
    //         $this->fpdf->Text(137, 63, utf8_decode($Note[$data->student->id][0]->student->nom . ' ' . $Note[$data->student->id][0]->student->prenom));

    //         $this->fpdf->SetFont('Arial', 'B', 7);
    //         $this->fpdf->Text(105, 68, utf8_decode('Née le : '));
    //         $this->fpdf->SetFont('Arial', 'B', 7);
    //         $this->fpdf->Text(137, 68, utf8_decode(date_format(date_create($Note[$data->student->id][0]->student->dateNaiss), "d-m-Y")));
    //         $this->fpdf->SetFont('Arial', 'B', 7);

    //         $this->fpdf->Text(105, 72, 'Sexe  : ');
    //         $this->fpdf->SetFont('Arial', 'B', 7);
    //         $this->fpdf->Text(137, 72, $data->student->sexe);
    //         $this->fpdf->SetFont('Arial', 'B', 7);

    //         $this->fpdf->Text(105, 76, 'Situatuion  : ');
    //         $this->fpdf->SetFont('Arial', 'B', 7);
    //         $this->fpdf->Text(137, 76, $data->student->doublant);
    //         $this->fpdf->SetFont('Arial', 'B', 7);



    //         // // deuxiemme


    //         $this->fpdf->Text(37, 58, utf8_decode('Anneé-Scolaire  : '));
    //         $this->fpdf->SetFont('Arial', 'B', 7);
    //         $this->fpdf->Text(59, 58, utf8_decode($session));
    //         $this->fpdf->SetFont('Arial', 'B', 7);


    //         $this->fpdf->Text(37, 63, 'Classe  : ');
    //         $this->fpdf->SetFont('Arial', 'B', 7);
    //         $this->fpdf->Text(59, 63, utf8_decode($Note[$data->student->id][0]->Classe->libelleClasse));
    //         $this->fpdf->SetFont('Arial', 'B', 7);

    //         $this->fpdf->Text(37, 67, 'Effectif  :  ');
    //         $this->fpdf->SetFont('Arial', 'B', 7);
    //         $this->fpdf->Text(59, 67, $effectif);
    //         $this->fpdf->SetFont('Arial', 'B', 7);


    //         $this->fpdf->Text(37, 71, 'Prof principal  :');
    //         $this->fpdf->SetFont('Arial', 'B', 6);
    //         $this->fpdf->Text(59, 71, utf8_decode($teach->nom . ' ' . $teach->prenom));


    //         if (file_exists(public_path("/Photos/Logos/" . $EleveData[$data->student->id][0]->user->photo))) {


    //             $this->fpdf->Image(public_path("/Photos/Logos/" . $EleveData[$data->student->id][0]->user->photo), 5, 52, 30, 27,  "");
    //         }






    //         // // Cadre information eleve



    //         $this->fpdf->SetXY(5, 52);
    //         $this->fpdf->Cell(30, 27, '', 1);

    //         $this->fpdf->SetXY(35, 52);
    //         $this->fpdf->Cell(23, 27, '', 1);


    //         $this->fpdf->SetXY(58, 52);
    //         $this->fpdf->Cell(45, 27, '', 1);


    //         $this->fpdf->SetXY(103, 52);
    //         $this->fpdf->Cell(33, 27, '', 1);


    //         $this->fpdf->SetXY(136, 52);
    //         $this->fpdf->Cell(70, 27, '', 1);




    //         $libelleTrimestre  = " ANNUEL";


    //         $this->fpdf->SetFillColor('130', '130', '130');
    //         $this->fpdf->SetFont('Arial', 'B', 10);
    //         $this->fpdf->SetXY(71, 41);
    //         $this->fpdf->Cell(70, 8, 'BULLETIN DE NOTES ' . '' . strtoupper($libelleTrimestre), 1, 0, 'C', 1);

    //         // $this->fpdf->SetFont('Arial', 'B', 12);
    //         // $this->fpdf->SetXY(10, 45);
    //         // $this->fpdf->Cell(0, 0, utf8_decode("BULLETIN DE FIN D'ANNEE "), 1, 0, 'C');



    //         // Cadre pour le titre de l'ecole

    //         // $this->fpdf->SetXY(50,39);
    //         // $this->fpdf->Cell(100,10,'',1);

    //         $this->fpdf->SetFont('Arial', 'B', 7);
    //         $this->fpdf->SetTextColor(0, 0, 0);
    //         // Tire cadre a cote
    //         // $this->fpdf->Text(135, 72, strtoupper($classeName->libelleEtab));

    //         $this->fpdf->SetXY(5, 85);
    //         // $this->fpdf->SetFont('Arial', 'B', 7);
    //         $this->fpdf->SetDrawColor(0, 0, 0);
    //         $this->fpdf->SetFillColor('166', '166', '166');
    //         $this->fpdf->Cell(60, 7, utf8_decode('Matières'), 1, 0, 'C', 1);
    //         $this->fpdf->Cell(10, 7, "TRIM " . ($idTrim1), 1, 0, 'C', 1);
    //         $this->fpdf->Cell(10, 7, "TRIM " . ($idTrim2), 1, 0, 'C', 1);
    //         $this->fpdf->Cell(10, 7, "TRIM " . ($idTrim3), 1, 0, 'C', 1);

    //         $this->fpdf->SetFont('Arial', 'B', $tailleNote);


    //         $this->fpdf->Cell(40, 4, '                   ' . strtoupper($libelleTrimestre), 1, 0, 'L', 1);

    //         $this->fpdf->SetFont('Arial', 'B', 7);

    //         $this->fpdf->SetXY(95, 89);

    //         $this->fpdf->Cell(10, 3, 'Notes', 1, 0, 'C', 1);
    //         $this->fpdf->Cell(10, 3, 'Coef', 1, 0, 'C', 1);
    //         $this->fpdf->Cell(10, 3, 'N*C', 1, 0, 'C', 1);
    //         $this->fpdf->Cell(10, 3, 'Rang', 1, 0, 'C', 1);
    //         $this->fpdf->SetXY(135, 85);
    //         $this->fpdf->Cell(20, 7, 'Appreciations', 1, 0, 'C', 1);
    //         $this->fpdf->Cell(51, 7, 'Enseignant (e) ', 1, 0, 'C', 1);

    //         $this->fpdf->Ln();
    //         $this->fpdf->SetX(20);


    //         // Pour la note seq1


    //         foreach ($Note[$data->student->id] as $note) {

    //             $this->fpdf->SetX(5);
    //             $this->fpdf->SetFont('Arial', 'B', 6);
    //             $this->fpdf->MultiCell(60, 7, utf8_decode($note->matiere->libelle), 1, 'L');
    //         }



    //         $this->fpdf->SetY(92);


    //         // Moyenne Trim  1


    //         $MoyenneDevoir1[$data->student->id] = MoyenneTrimestres::where('trimestre_id', $idTrim1)
    //             ->where('classe_id', $IdClasse)
    //             ->where('student_id', $data->student->id)
    //             ->where('codeEtab', $codeEtab)
    //             ->where('session', $session)->first();


    //         // Moyenne devoir 2


    //         $MoyenneDevoir2[$data->student->id] = MoyenneTrimestres::where('trimestre_id', $idTrim2)
    //             ->where('classe_id', $IdClasse)
    //             ->where('student_id', $data->student->id)
    //             ->where('codeEtab', $codeEtab)
    //             ->where('session', $session)->first();


    //         $this->fpdf->SetFont('Arial', 'B', 7);


    //         // Moyenne devoir 3


    //         $MoyenneDevoir3[$data->student->id] = MoyenneTrimestres::where('trimestre_id', $idTrim3)
    //             ->where('classe_id', $IdClasse)
    //             ->where('student_id', $data->student->id)
    //             ->where('codeEtab', $codeEtab)
    //             ->where('session', $session)->first();


    //         $this->fpdf->SetFont('Arial', 'B', 7);


    //         foreach ($Note[$data->student->id] as $note) {

    //             if ($note->valeur < $couleurRouge) {

    //                 $this->fpdf->SetTextColor('237', '28', '36');
    //             } else {

    //                 $this->fpdf->SetTextColor('0', '0', '0');
    //             }
    //             $this->fpdf->SetX(65);

    //             if ($MoyenneDevoir1[$data->student->id]->valeur == 0) {


    //                 $this->fpdf->MultiCell(10, 7, '', 1, 'C');
    //             } else {

    //                 $this->fpdf->MultiCell(10, 7, $note->valeur, 1, 'C');
    //             }
    //         }

    //         $this->fpdf->SetTextColor('0', '0', '0');



    //         // Note seq2

    //         $this->fpdf->SetY(92);

    //         foreach ($Note2[$data->student->id] as $note) {

    //             if ($note->valeur < $couleurRouge) {

    //                 $this->fpdf->SetTextColor('237', '28', '36');
    //             } else {

    //                 $this->fpdf->SetTextColor('0', '0', '0');
    //             }

    //             $this->fpdf->SetX(75);
    //             if ($MoyenneDevoir2[$data->student->id]->valeur == 0) {

    //                 $this->fpdf->MultiCell(10, 7, '', 1, 'C');
    //             } else {

    //                 $this->fpdf->MultiCell(10, 7, $note->valeur, 1, 'C');
    //             }
    //         }

    //         $this->fpdf->SetTextColor('0', '0', '0');


    //         // Note seq3

    //         $this->fpdf->SetY(92);

    //         foreach ($Note3[$data->student->id] as $note) {

    //             if ($note->valeur < $couleurRouge) {

    //                 $this->fpdf->SetTextColor('237', '28', '36');
    //             } else {

    //                 $this->fpdf->SetTextColor('0', '0', '0');
    //             }

    //             $this->fpdf->SetX(85);
    //             if ($MoyenneDevoir2[$data->student->id]->valeur == 0) {

    //                 $this->fpdf->MultiCell(10, 7, '', 1, 'C');
    //             } else {

    //                 $this->fpdf->MultiCell(10, 7, $note->valeur, 1, 'C');
    //             }
    //         }

    //         $this->fpdf->SetTextColor('0', '0', '0');

    //         // Note Annuelle


    //         //     // // // ici je rcupere la note du trimstre

    //         $this->fpdf->SetY(92);

    //         foreach ($noteAnnuelle[$data->student->id] as $key => $note) {


    //             if ($note->valeur < $couleurRouge) {

    //                 $this->fpdf->SetTextColor('237', '28', '36');
    //             } else {

    //                 $this->fpdf->SetTextColor('0', '0', '0');
    //             }


    //             $this->fpdf->SetX(95);
    //             $this->fpdf->MultiCell(10, 7, round($note->valeur, 2), 1, 'C');
    //         }

    //         $this->fpdf->SetTextColor('0', '0', '0');


    //         // // // les coef

    //         $this->fpdf->SetY(92);
    //         foreach ($noteAnnuelle[$data->student->id] as $note) {
    //             $this->fpdf->SetX(105);

    //             $this->fpdf->MultiCell(10, 7, $note->matiere->coef, 1, 'C');
    //         }


    //         $this->fpdf->SetY(92);
    //         foreach ($noteAnnuelle[$data->student->id] as $note) {

    //             if ($note->valeur < $couleurRouge) {

    //                 $this->fpdf->SetTextColor('237', '28', '36');
    //             } else {

    //                 $this->fpdf->SetTextColor('0', '0', '0');
    //             }


    //             $this->fpdf->SetX(115);
    //             $this->fpdf->MultiCell(10, 7, round(($note->valeur) * $note->matiere->coef, 2), 1, 'C');
    //         }

    //         $this->fpdf->SetTextColor('0', '0', '0');

    //         $this->fpdf->SetY(92);


    //         // Rang des matieres

    //         foreach ($noteAnnuelle[$data->student->id] as $note) {


    //             $all  = noteAnnuelle::where('matiere_id', $note->matiere->id)
    //                 ->where('classe_id', $IdClasse)
    //                 ->where('codeEtab', $codeEtab)
    //                 ->where('session', $session)
    //                 ->orderBy('valeur', 'desc')->get();

    //             foreach ($all as $ket => $test) {

    //                 if ($test->id == $note->id) {
    //                     $rank = $ket;

    //                     if ($rank + 1 == 1) {

    //                         $lab = "er";
    //                     } else {

    //                         $lab = "e";
    //                     }
    //                 }
    //             }


    //             $this->fpdf->SetX(125);
    //             $this->fpdf->MultiCell(10, 7, $rank + 1 . $lab, 1, 'C');
    //         }


    //         $this->fpdf->SetY(92);
    //         foreach ($noteAnnuelle[$data->student->id] as $note) {

    //             if ($note->valeur >= 0 && $note->valeur < 2) {
    //                 $note->mention = "Nul";
    //             }

    //             if ($note->valeur >= 2 && $note->valeur < 7) {

    //                 $note->mention = "Très Faible";
    //             }

    //             if ($note->valeur >= 7 && $note->valeur < 8) {

    //                 $note->mention = "Faible";
    //             }

    //             if ($note->valeur >= 8 && $note->valeur < 9) {

    //                 $note->mention = "Insuffisant";
    //             }
    //             if ($note->valeur >= 9 && $note->valeur < 10) {

    //                 $note->mention = "Médiocre";
    //             }


    //             if ($note->valeur >= 10 && $note->valeur < 12) {

    //                 $note->mention = "Passable";
    //             }

    //             if ($note->valeur >= 12 && $note->valeur < 14) {

    //                 $note->mention = "Assez-Bien";
    //             }

    //             if ($note->valeur >= 14 && $note->valeur < 16) {

    //                 $note->mention = "Bien";
    //             }

    //             if ($note->valeur >= 16 && $note->valeur < 18) {

    //                 $note->mention = "Très Bien";
    //             }

    //             if ($note->valeur >= 18 && $note->valeur <= 20) {

    //                 $note->mention = "Excellent";
    //             }

    //             if ($note->valeur < $couleurRouge) {

    //                 $this->fpdf->SetTextColor('237', '28', '36');
    //             } else {

    //                 $this->fpdf->SetTextColor('0', '0', '0');
    //             }

    //             $this->fpdf->SetFont('Arial', 'B', 7);

    //             $this->fpdf->SetX(135);
    //             $this->fpdf->MultiCell(20, 7, utf8_decode($note->mention), 1, 'C');
    //         }

    //         // je cherche les infos sur le proef


    //         $this->fpdf->SetTextColor('0', '0', '0');

    //         $this->fpdf->SetY(92);
    //         foreach ($Note[$data->student->id] as $note) {

    //             $this->fpdf->SetFont('Arial', 'B', 6);

    //             $this->fpdf->SetX(155);
    //             $this->fpdf->MultiCell(51, 7, utf8_decode($note->user->nom . ' ' . $note->user->prenom), 1, 'L');
    //         }


    //         // Moy trimestre  du groupe 1



    //         foreach ($noteAnnuelle[$data->student->id] as $data2) {


    //             $sommeNoteCoef1 = $sommeNoteCoef1 + ($data2->valeur * $data2->matiere->coef);

    //             $sommeCoef1 = $sommeCoef1 + $data2->matiere->coef;
    //         }


    //         $moyenne1[$data->student->id] =  number_format($sommeNoteCoef1 / $sommeCoef1, 2);



    //         // Moyenne cat1 du devoir 1


    //         $sommeNoteCoefD1cat1 = 0;

    //         $sommeCoef1D1 = 0;


    //         foreach ($Note[$data->student->id] as $data1) {


    //             $sommeNoteCoefD1cat1 = $sommeNoteCoefD1cat1 + ($data1->valeur * $data1->matiere->coef);

    //             $sommeCoef1D1 = $sommeCoef1D1 + $data1->matiere->coef;
    //         }

    //         $moyenneD1Cat1[$data->student->id] =  number_format($sommeNoteCoefD1cat1 / $sommeCoef1D1, 2);



    //         // Moyenne  devoir 2 de la cat1


    //         $sommeNoteCoefD2cat1 = 0;

    //         $sommeCoef2D2 = 0;


    //         foreach ($Note2[$data->student->id] as $data1) {


    //             $sommeNoteCoefD2cat1 = $sommeNoteCoefD2cat1 + ($data1->valeur * $data1->matiere->coef);

    //             $sommeCoef2D2 = $sommeCoef2D2 + $data1->matiere->coef;
    //         }

    //         $moyenneD2Cat1[$data->student->id] =  number_format($sommeNoteCoefD2cat1 / $sommeCoef2D2, 2);



    //         // Moyenne  devoir 3 de la cat1


    //         $sommeNoteCoefD3cat1 = 0;

    //         $sommeCoef2D3 = 0;


    //         foreach ($Note3[$data->student->id] as $data1) {


    //             $sommeNoteCoefD3cat1 = $sommeNoteCoefD3cat1 + ($data1->valeur * $data1->matiere->coef);

    //             $sommeCoef2D3 = $sommeCoef2D3 + $data1->matiere->coef;
    //         }

    //         $moyenneD3Cat1[$data->student->id] =  number_format($sommeNoteCoefD2cat1 / $sommeCoef2D2, 2);



    //         $this->fpdf->SetX(5);
    //         $this->fpdf->SetFont('Arial', 'B', 6);
    //         $this->fpdf->Cell(60, 6, utf8_decode('Enseignement Général'), 1, 0, 'C', 1);
    //         $this->fpdf->Cell(10, 6,  $moyenneD1Cat1[$data->student->id], 1, 0, 'C', 1);
    //         $this->fpdf->Cell(10, 6, $moyenneD2Cat1[$data->student->id], 1, 0, 'C', 1);
    //         $this->fpdf->Cell(10, 6, $moyenneD3Cat1[$data->student->id], 1, 0, 'C', 1);
    //         $this->fpdf->Cell(10, 6,  $moyenne1[$data->student->id], 1, 0, 'C', 1);
    //         $this->fpdf->Cell(10, 6, $sommeCoef1, 1, 0, 'C', 1);
    //         $this->fpdf->Cell(10, 6, round($sommeNoteCoef1, 2), 1, 0, 'C', 1);
    //         $this->fpdf->Cell(81, 6, '', 1, 0, 'C', 1);


    //         $this->fpdf->Ln();


    //         foreach ($Notecat2[$data->student->id] as $note) {

    //             $this->fpdf->SetX(5);
    //             $this->fpdf->SetFont('Arial', 'B', 6);
    //             $this->fpdf->MultiCell(60, 7, utf8_decode($note->matiere->libelle), 1, 'L');
    //         }


    //         $this->fpdf->Ln(-7 * $val3);

    //         $this->fpdf->SetFont('Arial', 'B', 7);

    //         // Les note de la sequence 1 cat 2
    //         foreach ($Notecat2[$data->student->id] as $note) {

    //             if ($note->valeur < $couleurRouge) {

    //                 $this->fpdf->SetTextColor('237', '28', '36');
    //             } else {

    //                 $this->fpdf->SetTextColor('0', '0', '0');
    //             }


    //             $this->fpdf->SetX(65);
    //             if ($MoyenneDevoir1[$data->student->id]->valeur == 0) {

    //                 $this->fpdf->MultiCell(10, 7, '', 1, 'C');
    //             } else {

    //                 $this->fpdf->MultiCell(10, 7, $note->valeur, 1, 'C');
    //             }
    //         }

    //         $this->fpdf->SetTextColor('0', '0', '0');


    //         $this->fpdf->Ln(-7 * $val3);

    //         // Les notes de la sequence 2 cat 2

    //         foreach ($Note2cat2[$data->student->id] as $note) {

    //             if ($note->valeur < $couleurRouge) {

    //                 $this->fpdf->SetTextColor('237', '28', '36');
    //             } else {

    //                 $this->fpdf->SetTextColor('0', '0', '0');
    //             }

    //             $this->fpdf->SetX(75);
    //             if ($MoyenneDevoir2[$data->student->id]->valeur == 0) {

    //                 $this->fpdf->MultiCell(10, 7, '', 1, 'C');
    //             } else {

    //                 $this->fpdf->MultiCell(10, 7, $note->valeur, 1, 'C');
    //             }
    //         }

    //         $this->fpdf->SetTextColor('0', '0', '0');



    //         $this->fpdf->Ln(-7 * $val3);


    //         // Les notes de la sequence 3 cat 2

    //         foreach ($Note3cat2[$data->student->id] as $note) {

    //             if ($note->valeur < $couleurRouge) {

    //                 $this->fpdf->SetTextColor('237', '28', '36');
    //             } else {

    //                 $this->fpdf->SetTextColor('0', '0', '0');
    //             }

    //             $this->fpdf->SetX(85);
    //             if ($MoyenneDevoir2[$data->student->id]->valeur == 0) {

    //                 $this->fpdf->MultiCell(10, 7, '', 1, 'C');
    //             } else {

    //                 $this->fpdf->MultiCell(10, 7, $note->valeur, 1, 'C');
    //             }
    //         }

    //         $this->fpdf->SetTextColor('0', '0', '0');



    //         $this->fpdf->Ln(-7 * $val3);

    //         foreach ($NoteAnnuellecat2[$data->student->id] as $note) {

    //             if ($note->valeur < $couleurRouge) {

    //                 $this->fpdf->SetTextColor('237', '28', '36');
    //             } else {

    //                 $this->fpdf->SetTextColor('0', '0', '0');
    //             }

    //             $this->fpdf->SetX(95);
    //             $this->fpdf->MultiCell(10, 7, round($note->valeur, 2), 1, 'C');
    //         }

    //         $this->fpdf->SetTextColor('0', '0', '0');


    //         $this->fpdf->Ln(-7 * $val3);

    //         foreach ($Note2cat2[$data->student->id] as $note) {

    //             $this->fpdf->SetX(105);

    //             $this->fpdf->MultiCell(10, 7, $note->matiere->coef, 1, 'C');
    //         }

    //         $this->fpdf->Ln(-7 * $val3);
    //         foreach ($NoteAnnuellecat2[$data->student->id] as $note) {

    //             if ($note->valeur < $couleurRouge) {

    //                 $this->fpdf->SetTextColor('237', '28', '36');
    //             } else {

    //                 $this->fpdf->SetTextColor('0', '0', '0');
    //             }


    //             $this->fpdf->SetX(115);
    //             $this->fpdf->MultiCell(10, 7, round(($note->valeur) * $note->matiere->coef, 2), 1, 'C');
    //         }

    //         $this->fpdf->Ln(-7 * $val3);

    //         $this->fpdf->SetTextColor('0', '0', '0');

    //         foreach ($NoteAnnuellecat2[$data->student->id] as $note) {


    //             $all  = noteAnnuelle::where('matiere_id', $note->matiere->id)
    //                 ->where('classe_id', $IdClasse)
    //                 ->where('codeEtab', $codeEtab)
    //                 ->where('session', $session)
    //                 ->orderBy('valeur', 'desc')->get();

    //             foreach ($all as $ket => $test) {

    //                 if ($test->id == $note->id) {
    //                     $rank = $ket;

    //                     if ($rank + 1 == 1) {

    //                         $lab = "er";
    //                     } else {

    //                         $lab = "e";
    //                     }
    //                 }
    //             }


    //             $this->fpdf->SetX(125);
    //             $this->fpdf->MultiCell(10, 7, $rank + 1 . $lab, 1, 'C');
    //         }

    //         $this->fpdf->SetTextColor('0', '0', '0');



    //         $this->fpdf->Ln(-7 * $val3);

    //         foreach ($NoteAnnuellecat2[$data->student->id] as $note2) {

    //             if ($note2->valeur >= 0 && $note2->valeur < 2) {
    //                 $note2->mention = "Nul";
    //             }

    //             if ($note2->valeur >= 2 && $note2->valeur < 7) {

    //                 $note2->mention = "Très Faible";
    //             }

    //             if ($note2->valeur >= 7 && $note2->valeur < 8) {

    //                 $note2->mention = "Faible";
    //             }

    //             if ($note2->valeur >= 8 && $note2->valeur < 9) {

    //                 $note2->mention = "Insuffisant";
    //             }
    //             if ($note2->valeur >= 9 && $note2->valeur < 10) {

    //                 $note2->mention = "Médiocre";
    //             }


    //             if ($note2->valeur >= 10 && $note2->valeur < 12) {

    //                 $note2->mention = "Passable";
    //             }

    //             if ($note2->valeur >= 12 && $note2->valeur < 14) {

    //                 $note2->mention = "Assez-Bien";
    //             }

    //             if ($note2->valeur >= 14 && $note2->valeur < 16) {

    //                 $note2->mention = "Bien";
    //             }

    //             if ($note2->valeur >= 16 && $note2->valeur < 18) {

    //                 $note2->mention = "Très Bien";
    //             }

    //             if ($note2->valeur >= 18 && $note2->valeur <= 20) {

    //                 $note2->mention = "Excellent";
    //             }

    //             if ($note2->valeur < $couleurRouge) {

    //                 $this->fpdf->SetTextColor('237', '28', '36');
    //             } else {

    //                 $this->fpdf->SetTextColor('0', '0', '0');
    //             }

    //             $this->fpdf->SetFont('Arial', 'B', 7);


    //             $this->fpdf->SetX(135);
    //             $this->fpdf->MultiCell(20, 7, utf8_decode($note2->mention), 1, 'C');
    //         }

    //         $this->fpdf->SetTextColor('0', '0', '0');


    //         $this->fpdf->Ln(-7 * $val3);

    //         foreach ($NoteAnnuellecat2[$data->student->id] as $note2) {
    //             $this->fpdf->SetFont('Arial', 'B', 7);
    //             $this->fpdf->SetX(155);
    //             $this->fpdf->MultiCell(51, 7, utf8_decode($note2->user->nom . ' ' . $note2->user->prenom), 1, 'L');
    //         }

    //         $this->fpdf->SetX(5);

    //         // Moy trimestre  du groupe 2

    //         foreach ($NoteAnnuellecat2[$data->student->id] as $data2) {


    //             $sommeNoteCoef2 = $sommeNoteCoef2 + ($data2->valeur * $data2->matiere->coef);

    //             $sommeCoef2 = $sommeCoef2 + $data2->matiere->coef;
    //         }

    //         $moyenne2[$data->student->id] =  number_format($sommeNoteCoef2 / $sommeCoef2, 2);



    //         // Moyenne cat2 du devoir 1


    //         $sommeNoteCoefD1cat2 = 0;

    //         $sommeCoef2D1 = 0;


    //         foreach ($Notecat2[$data->student->id] as $data1) {


    //             $sommeNoteCoefD1cat2 = $sommeNoteCoefD1cat2 + ($data1->valeur * $data1->matiere->coef);

    //             $sommeCoef2D1  = $sommeCoef2D1  + $data1->matiere->coef;
    //         }

    //         $moyenneD1Cat2[$data->student->id] =  number_format($sommeNoteCoefD1cat2 / $sommeCoef2D1, 2);



    //         // Moyenne cat2 du devoir 2


    //         $sommeNoteCoefD2cat2 = 0;

    //         $sommeCoef2D2 = 0;


    //         foreach ($Note2cat2[$data->student->id] as $data1) {


    //             $sommeNoteCoefD2cat2 = $sommeNoteCoefD2cat2 + ($data1->valeur * $data1->matiere->coef);

    //             $sommeCoef2D2  = $sommeCoef2D2  + $data1->matiere->coef;
    //         }

    //         $moyenneD2Cat2[$data->student->id] =  number_format($sommeNoteCoefD2cat2 / $sommeCoef2D2, 2);



    //         // Moyenne cat2 du devoir 3


    //         $sommeNoteCoefD3cat2 = 0;

    //         $sommeCoef2D3 = 0;


    //         foreach ($Note3cat2[$data->student->id] as $data1) {


    //             $sommeNoteCoefD3cat2 = $sommeNoteCoefD3cat2 + ($data1->valeur * $data1->matiere->coef);

    //             $sommeCoef2D3  = $sommeCoef2D3  + $data1->matiere->coef;
    //         }

    //         $moyenneD3Cat2[$data->student->id] =  number_format($sommeNoteCoefD3cat2 / $sommeCoef2D3, 2);






    //         $this->fpdf->SetFont('Arial', 'B', 6);
    //         $this->fpdf->Cell(60, 6, utf8_decode('Enseignement Professionnel'), 1, 0, 'C', 1);
    //         $this->fpdf->Cell(10, 6, $moyenneD1Cat2[$data->student->id], 1, 0, 'C', 1);
    //         $this->fpdf->Cell(10, 6, $moyenneD2Cat2[$data->student->id], 1, 0, 'C', 1);
    //         $this->fpdf->Cell(10, 6, $moyenneD3Cat2[$data->student->id], 1, 0, 'C', 1);
    //         $this->fpdf->Cell(10, 6,  $moyenne2[$data->student->id], 1, 0, 'C', 1);
    //         $this->fpdf->Cell(10, 6,  $sommeCoef2D2, 1, 0, 'C', 1);
    //         $this->fpdf->Cell(10, 6, round($sommeNoteCoef2, 2), 1, 0, 'C', 1);
    //         $this->fpdf->Cell(81, 6, '', 1, 0, 'C', 1);

    //         $this->fpdf->Ln();


    //         foreach ($Notecat3[$data->student->id] as $note) {

    //             $this->fpdf->SetX(5);
    //             $this->fpdf->SetFont('Arial', 'B', 6);
    //             $this->fpdf->MultiCell(60, 7, utf8_decode($note->matiere->libelle), 1, 'L');
    //         }

    //         $this->fpdf->SetFont('Arial', 'B', 7);


    //         $this->fpdf->Ln(-$val4 * 7);

    //         foreach ($Notecat3[$data->student->id] as $note) {

    //             if ($note->valeur < $couleurRouge) {

    //                 $this->fpdf->SetTextColor('237', '28', '36');
    //             } else {

    //                 $this->fpdf->SetTextColor('0', '0', '0');
    //             }

    //             $this->fpdf->SetX(65);
    //             if ($MoyenneDevoir1[$data->student->id]->valeur == 0) {

    //                 $this->fpdf->MultiCell(10, 7, '', 1, 'C');
    //             } else {

    //                 $this->fpdf->MultiCell(10, 7, $note->valeur, 1, 'C');
    //             }
    //         }

    //         $this->fpdf->SetTextColor('0', '0', '0');



    //         $this->fpdf->Ln(-$val4 * 7);

    //         foreach ($Note2cat3[$data->student->id] as $note) {

    //             if ($note->valeur < $couleurRouge) {

    //                 $this->fpdf->SetTextColor('237', '28', '36');
    //             } else {

    //                 $this->fpdf->SetTextColor('0', '0', '0');
    //             }

    //             $this->fpdf->SetX(75);
    //             if ($MoyenneDevoir2[$data->student->id]->valeur == 0) {

    //                 $this->fpdf->MultiCell(10, 7, '-', 1, 'C');
    //             } else {

    //                 $this->fpdf->MultiCell(10, 7, $note->valeur, 1, 'C');
    //             }
    //         }

    //         $this->fpdf->SetTextColor('0', '0', '0');


    //         $this->fpdf->Ln(-$val4 * 7);


    //         foreach ($Note3cat3[$data->student->id] as $note) {

    //             if ($note->valeur < $couleurRouge) {

    //                 $this->fpdf->SetTextColor('237', '28', '36');
    //             } else {

    //                 $this->fpdf->SetTextColor('0', '0', '0');
    //             }

    //             $this->fpdf->SetX(85);
    //             if ($MoyenneDevoir2[$data->student->id]->valeur == 0) {

    //                 $this->fpdf->MultiCell(10, 7, '-', 1, 'C');
    //             } else {

    //                 $this->fpdf->MultiCell(10, 7, $note->valeur, 1, 'C');
    //             }
    //         }

    //         $this->fpdf->Ln(-$val4 * 7);

    //         foreach ($NoteAnnuellecat3[$data->student->id] as $note3) {

    //             if ($note3->valeur < $couleurRouge) {

    //                 $this->fpdf->SetTextColor('237', '28', '36');
    //             } else {

    //                 $this->fpdf->SetTextColor('0', '0', '0');
    //             }

    //             $this->fpdf->SetX(95);


    //             $this->fpdf->MultiCell(10, 7, round($note3->valeur, 2), 1, 'C');
    //         }


    //         $this->fpdf->SetTextColor('0', '0', '0');



    //         $this->fpdf->Ln(-$val4 * 7);
    //         foreach ($NoteAnnuellecat3[$data->student->id] as $note) {

    //             $this->fpdf->SetX(105);
    //             $this->fpdf->MultiCell(10, 7, $note->matiere->coef, 1, 'C');
    //         }

    //         $this->fpdf->Ln(-7 * $val4);
    //         foreach ($NoteAnnuellecat3[$data->student->id] as $note) {

    //             if ($note->valeur < $couleurRouge) {

    //                 $this->fpdf->SetTextColor('237', '28', '36');
    //             } else {

    //                 $this->fpdf->SetTextColor('0', '0', '0');
    //             }
    //             $this->fpdf->SetX(115);
    //             $this->fpdf->MultiCell(10, 7, round(($note->valeur) * $note->matiere->coef, 2), 1, 'C');
    //         }

    //         $this->fpdf->Ln(-7 * $val4);

    //         $this->fpdf->SetTextColor('0', '0', '0');


    //         foreach ($NoteAnnuellecat3[$data->student->id] as $note) {


    //             $all  = noteAnnuelle::where('matiere_id', $note->matiere->id)

    //                 ->where('classe_id', $IdClasse)
    //                 ->where('codeEtab', $codeEtab)
    //                 ->where('session', $session)
    //                 ->orderBy('valeur', 'desc')->get();

    //             foreach ($all as $ket => $test) {

    //                 if ($test->id == $note->id) {
    //                     $rank = $ket;

    //                     if ($rank + 1 == 1) {

    //                         $lab = "er";
    //                     } else {

    //                         $lab = "e";
    //                     }
    //                 }
    //             }


    //             $this->fpdf->SetX(125);
    //             $this->fpdf->MultiCell(10, 7, $rank + 1 . $lab, 1, 'C');
    //         }

    //         $this->fpdf->Ln(-$val4 * 7);

    //         foreach ($NoteAnnuellecat3[$data->student->id] as $note3) {

    //             if ($note3->valeur >= 0 && $note3->valeur < 2) {
    //                 $note3->mention = "Nul";
    //             }

    //             if ($note3->valeur >= 2 && $note3->valeur < 7) {

    //                 $note3->mention = "Très Faible";
    //             }

    //             if ($note3->valeur >= 7 && $note3->valeur < 8) {

    //                 $note3->mention = "Faible";
    //             }

    //             if ($note3->valeur >= 8 && $note3->valeur < 9) {

    //                 $note3->mention = "Insuffisant";
    //             }
    //             if ($note3->valeur >= 9 && $note3->valeur < 10) {

    //                 $note3->mention = "Médiocre";
    //             }


    //             if ($note3->valeur >= 10 && $note3->valeur < 12) {

    //                 $note3->mention = "Passable";
    //             }

    //             if ($note3->valeur >= 12 && $note3->valeur < 14) {

    //                 $note3->mention = "Assez-Bien";
    //             }

    //             if ($note3->valeur >= 14 && $note3->valeur < 16) {

    //                 $note3->mention = "Bien";
    //             }

    //             if ($note3->valeur >= 16 && $note3->valeur < 18) {

    //                 $note3->mention = "Très Bien";
    //             }

    //             if ($note3->valeur >= 18 && $note3->valeur <= 20) {

    //                 $note3->mention = "Excellent";
    //             }

    //             if ($note3->valeur < $couleurRouge) {

    //                 $this->fpdf->SetTextColor('237', '28', '36');
    //             } else {

    //                 $this->fpdf->SetTextColor('0', '0', '0');
    //             }

    //             $this->fpdf->SetX(135);

    //             $this->fpdf->SetFont('Arial', 'B', 7);
    //             $this->fpdf->MultiCell(20, 7, utf8_decode($note3->mention), 1, 'C');
    //         }

    //         $this->fpdf->SetTextColor('0', '0', '0');

    //         $this->fpdf->Ln(-$val4 * 7);


    //         foreach ($NoteAnnuellecat3[$data->student->id] as $note) {
    //             $this->fpdf->SetFont('Arial', 'B', 6);
    //             $this->fpdf->SetX(155);
    //             $this->fpdf->MultiCell(51, 7, utf8_decode($note->user->nom . ' ' . $note->user->prenom), 1, 'L');
    //         }



    //         $this->fpdf->SetX(5);

    //         // Moy trimestre  du groupe 3

    //         foreach ($NoteAnnuellecat3[$data->student->id] as $data2) {


    //             $sommeNoteCoef3 = $sommeNoteCoef3 + ($data2->valeur * $data2->matiere->coef);

    //             $sommeCoef3 = $sommeCoef3 + $data2->matiere->coef;
    //         }

    //         $moyenne3[$data->student->id] =  number_format($sommeNoteCoef3 / $sommeCoef3, 2);




    //         // Moyenne cat3 du devoir 1


    //         $sommeNoteCoefD1cat3 = 0;

    //         $sommeCoef3D1 = 0;


    //         foreach ($Notecat3[$data->student->id] as $data1) {


    //             $sommeNoteCoefD1cat3 = $sommeNoteCoefD1cat3 + ($data1->valeur * $data1->matiere->coef);

    //             $sommeCoef3D1  =  $sommeCoef3D1  + $data1->matiere->coef;
    //         }

    //         $moyenneD1Cat3[$data->student->id] =  number_format($sommeNoteCoefD1cat3 / $sommeCoef3D1, 2);


    //         // Moyenne cat3 du devoir 2


    //         $sommeNoteCoefD2cat3 = 0;

    //         $sommeCoef3D2 = 0;


    //         foreach ($Note2cat3[$data->student->id] as $data1) {


    //             $sommeNoteCoefD2cat3 =  $sommeNoteCoefD2cat3 + ($data1->valeur * $data1->matiere->coef);

    //             $sommeCoef3D2  = $sommeCoef3D2  + $data1->matiere->coef;
    //         }

    //         $moyenneD2Cat3[$data->student->id] =  number_format($sommeNoteCoefD2cat3 / $sommeCoef3D2, 2);



    //         // Moyenne cat3 du devoir 3


    //         $sommeNoteCoefD3cat3 = 0;

    //         $sommeCoef3D2 = 0;


    //         foreach ($Note3cat3[$data->student->id] as $data1) {


    //             $sommeNoteCoefD3cat3 =  $sommeNoteCoefD3cat3 + ($data1->valeur * $data1->matiere->coef);

    //             $sommeCoef3D2  = $sommeCoef3D2  + $data1->matiere->coef;
    //         }

    //         $moyenneD3Cat3[$data->student->id] =  number_format($sommeNoteCoefD3cat3 / $sommeCoef3D2, 2);


    //         $this->fpdf->SetFont('Arial', 'B', 6);
    //         $this->fpdf->Cell(60, 6, utf8_decode('Enseignement Complémentaire '), 1, 0, 'C', 1);
    //         $this->fpdf->Cell(10, 6,  $moyenneD1Cat3[$data->student->id], 1, 0, 'C', 1);
    //         $this->fpdf->Cell(10, 6, $moyenneD2Cat3[$data->student->id], 1, 0, 'C', 1);
    //         $this->fpdf->Cell(10, 6, $moyenneD3Cat3[$data->student->id], 1, 0, 'C', 1);
    //         $this->fpdf->Cell(10, 6,  $moyenne3[$data->student->id], 1, 0, 'C', 1);
    //         $this->fpdf->Cell(10, 6, $sommeCoef3, 1, 0, 'C', 1);
    //         $this->fpdf->Cell(10, 6, $sommeNoteCoef3, 1, 0, 'C', 1);
    //         $this->fpdf->Cell(81, 6, '', 1, 0, 'C', 1);


    //         $this->fpdf->Ln(12);

    //         $this->fpdf->SetX(5);
    //         $this->fpdf->SetFont('Arial', 'B', 6);
    //         $this->fpdf->Cell(45, 5, utf8_decode('RAPPEL'), 1, 0, 'C', 1);
    //         $this->fpdf->Cell(35, 5, utf8_decode('TRAVAIL DE LA CLASSE'), 1, 0, 'C', 1);
    //         $this->fpdf->Cell(35, 5, 'TRAVAIL' . utf8_decode(strtoupper($libelleTrimestre)), 1, 0, 'C', 1);
    //         $this->fpdf->Cell(46, 5, utf8_decode('CONDUITE'), 1, 0, 'C', 1);
    //         $this->fpdf->Cell(40, 5, utf8_decode('TRAVAIL'), 1, 0, 'C', 1);


    //         // Moyenne et rang du devoir 1



    //         // dd( $MoyenneDevoir1[$data->student->id]->student_id);

    //         //  Ran du devoir 1

    //         $moyDevoir1 = MoyenneTrimestres::where('session', $session)->where('codeEtab', $codeEtab)
    //             ->where('trimestre_id', $idTrim1)
    //             ->where('classe_id', $IdClasse)
    //             ->orderBy('valeur', 'DESC')->get();


    //         // // dd(  $moyDevoir1);


    //         foreach ($moyDevoir1   as $key => $dataa) {


    //             if ($dataa->student_id == $MoyenneDevoir1[$data->student->id]->student_id) {

    //                 $rankEval1[$dataa->student->id] = $key + 1;
    //             }
    //         }



    //         //  Ran du devoir 2


    //         $moyDevoir2 = MoyenneTrimestres::where('session', $session)
    //             ->where('codeEtab', $codeEtab)
    //             ->where('trimestre_id', $idTrim2)
    //             ->where('classe_id', $IdClasse)
    //             ->orderBy('valeur', 'DESC')->get();

    //         foreach ($moyDevoir2   as $key => $dataa) {


    //             if ($dataa->student_id == $MoyenneDevoir2[$data->student->id]->student_id) {

    //                 $rankEval2[$dataa->student->id] = $key + 1;
    //             }
    //         }


    //         //  Ran du devoir 3


    //         $moyDevoir3 = MoyenneTrimestres::where('session', $session)
    //             ->where('codeEtab', $codeEtab)
    //             ->where('trimestre_id', $idTrim3)
    //             ->where('classe_id', $IdClasse)
    //             ->orderBy('valeur', 'DESC')->get();

    //         foreach ($moyDevoir3   as $key => $dataa) {


    //             if ($dataa->student_id == $MoyenneDevoir3[$data->student->id]->student_id) {

    //                 $rankEval3[$dataa->student->id] = $key + 1;
    //             }
    //         }

    //         $this->fpdf->Ln();
    //         $this->fpdf->SetX(5);
    //         $this->fpdf->Cell(9, 5, utf8_decode(''), 1, 0, 'C', 0);
    //         $this->fpdf->Cell(12, 5, utf8_decode('MOY'), 1, 0, 'C', 1);
    //         $this->fpdf->Cell(12, 5, utf8_decode('Rang'), 1, 0, 'C', 1);
    //         $this->fpdf->Cell(12, 5, utf8_decode('ABS'), 1, 0, 'C', 1);

    //         $rankEval1[$data->student->id] = $rankEval1[$data->student->id];


    //         if ($MoyenneDevoir1[$data->student->id]->valeur == 0) {

    //             $MoyenneDevoir1[$data->student->id]->valeur = '#';
    //             $rankEval1[$data->student->id] = '#';
    //         } else {

    //             $rankEval1[$data->student->id] = $rankEval1[$data->student->id];
    //         }

    //         //$this->fpdf->Cell(15, 5,  $MoyenneDevoir1[$data->student->id]->valeur, 1, 0, 'C', 0);
    //         $this->fpdf->Cell(25, 5, utf8_decode('MOY CLASSE / 20'), 1, 0, 'L', 0);
    //         $this->fpdf->Cell(10, 5, number_format($moyenneSommeClasse / $nombreEleves, 2), 1, 0, 'C', 0);
    //         $this->fpdf->SetX(85);
    //         $this->fpdf->Cell(25, 5, utf8_decode('TOTAL POINTS'), 1, 0, 'L', 0);
    //         $this->fpdf->Cell(10, 5,  $sommeNoteCoef1 + $sommeNoteCoef2 + $sommeNoteCoef3, 1, 0, 'C', 0);
    //         $this->fpdf->SetX(120);
    //         $this->fpdf->Cell(33, 5, utf8_decode('ABSENCES (h)'), 1, 0, 'L', 0);
    //         $this->fpdf->Cell(13, 5, $heureTrim1 + $heureTrim2 + $heureTrim3, 1, 0, 'C', 0); // $heureTrimestre
    //         $this->fpdf->Cell(27, 5, utf8_decode('FELICITATIONS'), 1, 0, 'L', 0);
    //         $this->fpdf->Cell(13, 5, '', 1, 0, 'C', 0);


    //         // Rang Eval1

    //         // $moyenneEval1[$data->student->id] = Moyennes::where('evaluation_id',$idEval1);
    //         if ($rankEval1[$data->student->id] == 1) {

    //             $label1 = 'er';
    //         } else {
    //             $label1 = 'eme';
    //         }

    //         $this->fpdf->Ln();
    //         $this->fpdf->SetX(5);
    //         $this->fpdf->Cell(9, 5, utf8_decode('TRIM ' . $idTrim1), 1, 0, 'L', 1);

    //         $this->fpdf->Cell(12, 5, utf8_decode($MoyenneDevoir1[$data->student->id]->valeur . ' / 20'), 1, 0, 'C', 0);
    //         $this->fpdf->Cell(12, 5, utf8_decode($rankEval1[$data->student->id] . ' ' . $label1), 1, 0, 'C', 0);

    //         $this->fpdf->Cell(12, 5, utf8_decode($heureTrim1), 1, 0, 'C', 0);



    //         // if ($rankEval1[$data->student->id] == 1) {

    //         //     $label = 'er';
    //         // } else {
    //         //     $label = 'eme';
    //         // }
    //         //$this->fpdf->Cell(15, 5, $rankEval1[$data->student->id] . ' ' . $label, 1, 0, 'C', 0);
    //         $this->fpdf->Cell(25, 5, utf8_decode('MOY PREMIER / 20 '), 1, 0, 'L', 0);
    //         $this->fpdf->Cell(10, 5, $MoyPremier, 1, 0, 'C', 0);
    //         $this->fpdf->Cell(25, 5, utf8_decode('TOTAL COEFS'), 1, 0, 'L', 0);
    //         $this->fpdf->Cell(10, 5, $sommeCoef1 + $sommeCoef2 + $sommeCoef3, 1, 0, 'C', 0);
    //         $this->fpdf->Cell(33, 5, utf8_decode('CONSIGNE (h)'), 1, 0, 'L', 1);
    //         $this->fpdf->Cell(13, 5, '', 1, 0, 'C', 0); // $heureConsigneTrimestre
    //         $this->fpdf->Cell(27, 5, utf8_decode('ENCOURAGEMENTS'), 1, 0, 'L', 0);
    //         $this->fpdf->Cell(13, 5, '', 1, 0, 'C', 0);


    //         $this->fpdf->Ln();
    //         $this->fpdf->SetX(5);

    //         $rankEval2[$data->student->id] = $rankEval2[$data->student->id];



    //         // if ($MoyenneDevoir2[$data->student->id]->valeur == 0) {
    //         //     $MoyenneDevoir2[$data->student->id]->valeur = '-';
    //         //     $rankEval2[$data->student->id] = '-';
    //         // } else {

    //         //     $rankEval2[$data->student->id] = $rankEval2[$data->student->id];
    //         // }

    //         if ($rankEval2[$data->student->id] == 1) {

    //             $label2 = 'er';
    //         } else {
    //             $label2 = 'eme';
    //         }


    //         $this->fpdf->SetFont('Arial', 'B', 6);
    //         // $this->fpdf->Cell(30, 5, utf8_decode('MOYENNE' . ' TRIMESTRE ' . $idTrim2), 1, 0, 'L', 0);

    //         $this->fpdf->Cell(9, 5, utf8_decode('TRIM ' . $idTrim2), 1, 0, 'L', 1);

    //         $this->fpdf->Cell(12, 5, utf8_decode($MoyenneDevoir2[$data->student->id]->valeur . ' / 20'), 1, 0, 'C', 0);
    //         $this->fpdf->Cell(12, 5, utf8_decode($rankEval2[$data->student->id] . ' ' . $label2), 1, 0, 'C', 0);

    //         $this->fpdf->Cell(12, 5, utf8_decode($heureTrim2), 1, 0, 'C', 0);


    //         // $this->fpdf->Cell(15, 5, $MoyenneDevoir2[$data->student->id]->valeur, 1, 0, 'C', 0);
    //         $this->fpdf->Cell(25, 5, utf8_decode('MOY Dernier / 20 '), 1, 0, 'L', 0);
    //         $this->fpdf->Cell(10, 5, $MoyDernier, 1, 0, 'C', 0);
    //         $this->fpdf->Cell(25, 5, 'MOYENNE / 20 ', 1, 0, 'C', 1);
    //         $this->fpdf->Cell(10, 5, $data->valeur, 1, 0, 'C', 0);



    //         $this->fpdf->Cell(33, 5, utf8_decode('AVERTISSEMENT CONDUITE'), 1, 0, 'L', 0);
    //         $this->fpdf->Cell(13, 5, '', 1, 0, 'C', 0);
    //         $this->fpdf->Cell(27, 5, utf8_decode("TABLEAU D'HONNEUR "), 1, 0, 'L', 0);
    //         $this->fpdf->Cell(13, 5, '', 1, 0, 'C', 0);

    //         // if ($MoyenneDevoir3[$data->student->id]->valeur == 0) {
    //         //     $MoyenneDevoir3[$data->student->id]->valeur = '';
    //         //     $rankEval3[$data->student->id] = '';
    //         // } else {

    //         //     $rankEval2[$data->student->id] = $rankEval2[$data->student->id];
    //         // }


    //         if ($rankEval3[$data->student->id] == 1) {

    //             $label3 = 'er';
    //         } else {
    //             $label3 = 'eme';
    //         }

    //         $this->fpdf->Ln();
    //         $this->fpdf->SetX(5);
    //         $this->fpdf->Cell(9, 5, utf8_decode('TRIM ' . $idTrim3), 1, 0, 'L', 1);

    //         $this->fpdf->Cell(12, 5, utf8_decode($MoyenneDevoir3[$data->student->id]->valeur . ' / 20'), 1, 0, 'C', 0);
    //         $this->fpdf->Cell(12, 5, utf8_decode($rankEval3[$data->student->id] . ' ' .  $label3), 1, 0, 'C', 0);

    //         $this->fpdf->Cell(12, 5, utf8_decode($heureTrim3), 1, 0, 'C', 0);





    //         // $this->fpdf->Cell(15, 5,   $rankEval2[$data->student->id] . ' ' . $label, 1, 0, 'C', 0);

    //         $this->fpdf->Cell(35, 5, utf8_decode(''), 1, 0, 'L', 0);

    //         $this->fpdf->Cell(25, 5, 'RANG', 1, 0, 'C', 0);
    //         $this->fpdf->Cell(10, 5, ($ley + 1) . ' ' . $e, 1, 0, 'C', 1);

    //         $this->fpdf->Cell(33, 5, utf8_decode('EXCLUSIONS ( jrs )'), 1, 0, 'L', 0);
    //         $this->fpdf->Cell(13, 5, '', 1, 0, 'C', 1); // $ExclusionTrimestre
    //         $this->fpdf->Cell(27, 5, utf8_decode("BLAME TRAVAIL "), 1, 0, 'L', 0);
    //         $this->fpdf->Cell(13, 5, '', 1, 0, 'C', 0);



    //         $this->fpdf->Ln();
    //         $this->fpdf->SetX(120);
    //         $this->fpdf->Cell(33, 5, utf8_decode('BLAME CONDUITE'), 1, 0, 'L', 0);
    //         $this->fpdf->Cell(13, 5, '', 1, 0, 'C', 0);
    //         $this->fpdf->Cell(27, 5, utf8_decode('BLAME TRAVAIL'), 1, 0, 'L', 0);
    //         $this->fpdf->Cell(13, 5, '', 1, 0, 'C', 0);

    //         $this->fpdf->SetX(5);
    //         $this->fpdf->SetFont('Arial', 'B', 8);
    //         // $this->fpdf->Cell(30, 5, utf8_decode('MOYENNE' . ' TRIMESTRE' . $idTrim3), 1, 0, 'L', 0);

    //         // $this->fpdf->Cell(15, 5, $MoyenneDevoir3[$data->student->id]->valeur, 1, 0, 'C', 0);


    //         // Recuperons les id des evaluations correspondant au trimestre dont on a l'id en haut



    //         if (($libelleClasse[0] == "P" || $libelleClasse[0] == "T")) {

    //             $this->fpdf->SetTextColor('206', '0', '0');
    //             $this->fpdf->Cell(161, 5, utf8_decode(' Redouble si Echec '), 1, 0, 'C', 0);
    //         } else if ($libelleClasse[0] != "P" && $libelleClasse[0] != "T") {

    //             if ($data->valeur >= 10) {

    //                 $this->fpdf->SetTextColor('0', '128', '64');

    //                 $this->fpdf->Cell(161, 5, utf8_decode('Admis(e) en classe supérieure'), 1, 0, 'C', 0);
    //             } else {

    //                 $this->fpdf->SetTextColor('206', '0', '0');
    //                 $this->fpdf->Cell(161, 5, utf8_decode('Redouble la classe de ' . $libelleClasse), 1, 0, 'C', 0);
    //             }
    //         }







    //         // if ($data->valeur >= 14) {

    //         //     $this->fpdf->SetTextColor('0', '128', '64');

    //         //     $this->fpdf->Cell(161, 5, utf8_decode('PROMU(E) EN CLASSE DE ' . ($labelClasseChiffre - 1) . '' . $labelSuiteClasse), 1, 0, 'C', 0);
    //         // } else {

    //         //     $this->fpdf->SetTextColor('206', '0', '0');


    //         //     $this->fpdf->Cell(161, 5, utf8_decode('REDOUBLE LA CLASSE DE ' . $libelleClasse), 1, 0, 'C', 0);
    //         // }


    //         $this->fpdf->SetTextColor('0', '0', '0');



    //         //  Ran du devoir 3


    //         $moyDevoir3 = MoyenneTrimestres::where('session', $session)
    //             ->where('codeEtab', $codeEtab)
    //             ->where('trimestre_id', $idTrim3)
    //             ->where('classe_id', $IdClasse)
    //             ->orderBy('valeur', 'DESC')->get();

    //         // foreach ($moyDevoir3   as $key => $dataa) {


    //         //     if ($dataa->student_id == $MoyenneDevoir3[$data->student->id]->student_id) {

    //         //         $rankEval3[$dataa->student->id] = $key + 1;
    //         //     }
    //         // }

    //         // if ($MoyenneDevoir3[$data->student->id]->valeur == 0) {
    //         //     $MoyenneDevoir3[$data->student->id]->valeur = '-';
    //         //     $rankEval3[$data->student->id] = '-';
    //         // } else {

    //         //     $rankEval3[$data->student->id] = $rankEval3[$data->student->id];
    //         // }



    //         $this->fpdf->Ln();
    //         $this->fpdf->SetX(5);
    //         $this->fpdf->SetFont('Arial', 'B', 6);
    //         // $this->fpdf->Cell(30, 5, utf8_decode('Rang' . ' TRIMESTRE' . $idTrim3), 1, 0, 'L', 0);
    //         // $this->fpdf->Cell(15, 5,   $rankEval3[$data->student->id] . ' ' . $label, 1, 0, 'C', 0);



    //         $this->fpdf->SetX(5);

    //         $this->fpdf->Cell(45, 5, utf8_decode('VISA DU PARENT '), 1, 0, 'C', 1);
    //         $this->fpdf->Cell(103, 5, utf8_decode('OBSERVATION DU CONSEIL DE CLASSE'), 1, 0, 'C', 1);
    //         $this->fpdf->Cell(53, 5, 'VISA DU CHEF D\'ETABLISSEMENT', 1, 0, 'C', 1);


    //         $this->fpdf->SetX(10);
    //         $this->fpdf->Cell(45, 20, '', 0, 0, 'L', 0);
    //         $this->fpdf->Cell(103, 20, utf8_decode(''), 0, 0, 'L', 0);
    //         $this->fpdf->Cell(53, 21, '       Douala le _______________________', 0, 0, 'L', 0);

    //         $this->fpdf->SetX(5);
    //         $this->fpdf->Cell(45, 45, '', 1, 0, 'L', 0);
    //         $this->fpdf->Cell(103, 45, utf8_decode(''), 1, 0, 'L', 0);
    //         $this->fpdf->Cell(53, 45, '    ', 1, 0, 'L', 0);

    //         $sommeNoteCoef1 = $sommeNoteCoef2 = $sommeNoteCoef3 = 0;

    //         $sommeCoef1 = $sommeCoef2 = $sommeCoef3 = 0;
    //     }

    //     $this->fpdf->Output();
    //     exit;
    // }


    public function getAllBulletinAnnuelle($id)
    {

        $conf = config::first();
        $entete = $conf->header;
        $IdClasse = $id;
        $sommeNoteCoef1 = $sommeNoteCoef2 = $sommeNoteCoef3 = 0;
        $sommeCoef1 = $sommeCoef2 = $sommeCoef3 = 0;
        $couleurRouge = 10;

        // Je trouve le codeEtab et la session

        $code = Classe::where('id', $IdClasse)->first();
        $codeEtab = $code->codeEtabClasse;
        $session = $code->sessionClasse;

        // Recuperons les id des evaluations correspondant au trimestre dont on a l'id en haut

        $Evalutions = Evaluations::with('trimestre')->where('session', $session)
            ->where('codeEtab', $codeEtab)->get();



        $idEval1 = $Evalutions[0]->id;
        $libelleEval1 = $Evalutions[0]->libelle;

        $idEval2 = $Evalutions[1]->id;
        $libelleEval2 = $Evalutions[1]->libelle;

        $idEval3 = $Evalutions[2]->id;
        $libelleEval3 = $Evalutions[2]->libelle;

        $idEval4 = $Evalutions[3]->id;
        $libelleEval4 = $Evalutions[3]->libelle;

        $idEval5 = $Evalutions[4]->id;
        $libelleEval5 = $Evalutions[4]->libelle;


        ##  RECUPERER TOUTES LES MOYENNES DES EVALS  ###



        $MoysE1 = $this->getAllMoyenneSequenveByIdEval($idEval = $idEval1, $idClasse = $IdClasse);
        $MoysE2 = $this->getAllMoyenneSequenveByIdEval($idEval = $idEval2, $idClasse = $IdClasse);
        $MoysE3 = $this->getAllMoyenneSequenveByIdEval($idEval = $idEval3, $idClasse = $IdClasse);
        $MoysE4 = $this->getAllMoyenneSequenveByIdEval($idEval = $idEval4, $idClasse = $IdClasse);
        $MoysE5 = $this->getAllMoyenneSequenveByIdEval($idEval = $idEval5, $idClasse = $IdClasse);



        # RECUPERER TOUTES LES NOTES DU TRIMESTRES DE CETTE CLASSE

        $MoyT1 = $this->getMoyenneTrimByIdTrim($idTrim = 1, $idClasse = $IdClasse);
        $MoyT2 = $this->getMoyenneTrimByIdTrim($idTrim = 2, $idClasse = $IdClasse);
        $MoyT3 = $this->getMoyenneTrimByIdTrim($idTrim = 3, $idClasse = $IdClasse);











        $classeName = Etablissement::where('codeEtab', $codeEtab)->first();

        $rest = Classe::where('id', $IdClasse)->first();

        $teach = Enseignants::where('id', $rest->principale_Classe)->first();


        // Tous les eleves


        $classeData = Student::with('user', 'classe')->where('classe_id', $IdClasse)
            ->where('statut', "!=", 3)
            ->where('session', $session)->where('codeEtab', $codeEtab)->get();

        $NombreAdmis = count(MoyenneAnnuelle::where('classe_id', $IdClasse)->where('valeur', '>=', 10)->get());


        $moyData =   MoyenneAnnuelle::with('student')->where('session', $session)
            ->where('codeEtab', $codeEtab)->where('classe_id', $IdClasse)->where('valeur', '>=', 0)
            ->orderBy('valeur', 'DESC')->get();


        $moyTotalAnnuelClasse =   MoyenneAnnuelle::where('classe_id', $IdClasse)->where('valeur', '>=', 0)
            ->sum('valeur');





        // Nombre deleves  dans cette classe


        $effectif = Student::where('classe_id', $IdClasse)
            ->where('session', $session)
            ->where('codeEtab', $codeEtab)
            ->where('statut', "!=", 3)
            ->count();

        // Nombre deleves ayant une moyenne dans cette classe dans le trimestre

        $nombreEleves =  MoyenneAnnuelle::where('classe_id', $IdClasse)->where('valeur', '>', 0)
            ->where('session', $session)->where('codeEtab', $codeEtab)->count();

        // Mpyenne gen de la classe

        $moyenneSommeClasse =  MoyenneAnnuelle::where('classe_id', $IdClasse)
            ->where('session', $session)->where('codeEtab', $codeEtab)->sum('valeur');

        // Moyenne du dernier

        $MoyDernier = MoyenneAnnuelle::where('valeur', '>', 0)->where('classe_id', $IdClasse)->min('valeur');

        // // Moyenne du premier

        $MoyPremier = MoyenneAnnuelle::where('valeur', '>=', 0)->where('classe_id', $IdClasse)->max('valeur');



        // // NBRS de Moyenne

        $NbreMoyenne = count(MoyenneAnnuelle::where('valeur', '>=', 10)->where('classe_id', $IdClasse)->get());



        foreach ($moyData as $key => $data) {






            // ABSENCES

            $heureTrimestre  = Presences::where('classe_id', $IdClasse)->where('trimestre_id', 3)
                ->where('student_id', $data->student->id)
                ->sum('duree');


            // Absences  justifies

            $heureTrimestreJustifies = Presences::where('classe_id',  $IdClasse)
                ->where('student_id', $data->student->id)->where('trimestre_id', 3)
                ->sum('etat');



            // dd($data->valeur);



            if ($key == 0) {

                $e = 'er';
            } else {

                $e = utf8_decode('è');
            }


            $this->fpdf->AddPage("P", [
                '290',
                '210'
            ]); // 315

            $Note1[$data->student->id] = $this->getNoteValueByCatId($data, $idEval1, $IdClasse, $codeEtab, $session, 1);


            $EleveData[$data->student->id] = Student::with('user')->where('id', $data->student->id)->get();


            $this->fpdf->Image(public_path("/Photos/Logos/" . $entete), 8, 2, 190, 33, "");


            $tailleNote = 6;
            $libelle = 7;
            // Informations de l'eleve

            $this->fpdf->SetFont('Arial', 'B', 7);
            $this->fpdf->Text(105, 58, 'Matricule : ');
            $this->fpdf->SetFont('Arial', 'B', 7);
            $this->fpdf->Text(130, 58, $Note1[$data->student->id][0]->student->matricule);



            $this->fpdf->SetFont('Arial', 'B', 7);
            $this->fpdf->Text(105, 63, utf8_decode('Noms et prénoms :  '));
            $this->fpdf->SetFont('Arial', 'B', 9);
            $this->fpdf->Text(130, 63, utf8_decode($Note1[$data->student->id][0]->student->nom . ' ' . $Note1[$data->student->id][0]->student->prenom));

            $this->fpdf->SetFont('Arial', 'B', 7);
            $this->fpdf->Text(105, 68, utf8_decode('Née le : '));
            $this->fpdf->SetFont('Arial', 'B', 7);
            $this->fpdf->Text(130, 68, utf8_decode(date_format(date_create($Note1[$data->student->id][0]->student->dateNaiss), "d /m/ Y")));
            $this->fpdf->SetFont('Arial', 'B', 7);

            $this->fpdf->Text(105, 72, 'Sexe  : ');
            $this->fpdf->SetFont('Arial', 'B', 7);
            $this->fpdf->Text(130, 72, $data->student->sexe);
            $this->fpdf->SetFont('Arial', 'B', 7);

            $this->fpdf->Text(105, 76, 'Redoublant    : ');
            $this->fpdf->SetFont('Arial', 'B', 7);
            if ($data->student->doublant == "REDOUBLANT") {
                $this->fpdf->Text(
                    130,
                    76,
                    "Oui"
                );
            } else {

                $this->fpdf->Text(
                    130,
                    76,
                    "Non"
                );
            }

            $this->fpdf->SetFont('Arial', 'B', 7);

            $this->fpdf->SetFont('Arial', 'B', 7);


            // // deuxiemme


            $this->fpdf->Text(37, 58, utf8_decode('Année-Scolaire  : '));
            $this->fpdf->SetFont('Arial', 'B', 7);
            $this->fpdf->Text(59, 58, utf8_decode($session));
            $this->fpdf->SetFont('Arial', 'B', 7);


            $this->fpdf->Text(37, 63, 'Classe  : ');
            $this->fpdf->SetFont('Arial', 'B', 7);
            $this->fpdf->Text(59, 63, utf8_decode($Note1[$data->student->id][0]->Classe->libelleClasse));
            $this->fpdf->SetFont('Arial', 'B', 7);

            $this->fpdf->Text(37, 67, 'Effectif  :  ');
            $this->fpdf->SetFont('Arial', 'B', 7);
            $this->fpdf->Text(59, 67, $effectif);
            $this->fpdf->SetFont('Arial', 'B', 7);


            $this->fpdf->Text(37, 71, 'Prof Principal  :');
            $this->fpdf->SetFont('Arial', 'B', 6);


            $this->fpdf->Text(59, 71, substr(
                utf8_decode($teach->nom . ' ' . $teach->prenom,),
                0,
                42
            ));


            if (file_exists(public_path("/Photos/Logos/" . $EleveData[$data->student->id][0]->user->photo))) {


                $this->fpdf->Image(public_path("/Photos/Logos/" . $EleveData[$data->student->id][0]->user->photo), 2, 50, 25, 27,  "");
            }




            if (!file_exists(public_path("/Photos/Qrcodes/Qrcode" . $data->student->id . ".png"))) {


                $dataToEncode = mb_convert_encoding(
                    $data->student->nom . " " .
                        $data->student->prenom . ',' .
                        utf8_decode(date_format(date_create($data->student->dateNaiss), "d /m/ Y")) . "," .
                        $data->student->lieuNaiss . "," .
                        'Moy Annuel' . ":" .
                        $data->valeur . '/20',
                    'utf-8',
                    // Specify the original encoding of the data here
                );

                QrCode::format('png')
                    ->size(299)
                    ->color(40, 40, 40)
                    ->encoding('utf-8') // Only needed if using option 1
                    ->generate($dataToEncode, public_path("/Photos/Qrcodes/Qrcode" . $data->student->id . ".png"));
            }


            $this->fpdf->Image(public_path("/Photos/Qrcodes/Qrcode" . $data->student->id . ".png"), 186, 270, 20, 20, "");





            //     // // Cadre information eleve



            // $this->fpdf->SetXY(3, 52);
            // $this->fpdf->Cell(32, 24, '', 1);

            $this->fpdf->SetXY(35, 50);
            $this->fpdf->Cell(23, 27, '', 1);


            $this->fpdf->SetXY(58, 50);
            $this->fpdf->Cell(45, 27, '', 1);


            $this->fpdf->SetXY(103, 50);
            $this->fpdf->Cell(26, 27, '', 1);


            $this->fpdf->SetXY(129, 50);
            $this->fpdf->Cell(80, 27, '', 1);




            // Cadre pour le titre du trimestre

            // $this->fpdf->SetFillColor('130', '130', '130');
            $this->fpdf->SetFillColor(
                '41',
                '155',
                '199'
            );
            $this->fpdf->SetFont('Arial', 'B', 13);
            $this->fpdf->SetXY(71, 39);
            $this->fpdf->Cell(70, 8, ' BULLETIN DE NOTES ANNUEL ', 1, 0, 'C', 1);







            // $this->fpdf->SetXY(50,39);
            // $this->fpdf->Cell(100,10,'',1);

            $this->fpdf->SetFont('Arial', 'B', $tailleNote + 1);
            $this->fpdf->SetTextColor(0, 0, 0);
            // Tire cadre a cote
            // $this->fpdf->Text(135, 72, strtoupper($classeName->libelleEtab));

            $this->fpdf->SetXY(1, 80);
            // $this->fpdf->SetFont('Arial', 'B', 7);
            $this->fpdf->SetDrawColor(0, 0, 0);

            $this->fpdf->SetFillColor('41', '155', '199');
            // $this->fpdf->SetFillColor('111', '111', '111');
            $this->fpdf->Cell(60, 7, utf8_decode('MATIERES'), 1, 0, 'C', 1);
            $this->fpdf->Cell(7, 7, "D" . ($idEval1 - 1), 1, 0, 'C', 1);
            $this->fpdf->Cell(7, 7, "D" . ($idEval2 - 1), 1, 0, 'C', 1);
            $this->fpdf->Cell(7, 7, "D" . ($idEval3 - 1), 1, 0, 'C', 1);
            $this->fpdf->Cell(7, 7, "D" . ($idEval4 - 1), 1, 0, 'C', 1);
            $this->fpdf->Cell(7, 7, "D" . ($idEval5 - 1), 1, 0, 'C', 1);


            $this->fpdf->SetFont('Arial', 'B', $tailleNote);

            $this->fpdf->SetFont('Arial', 'B', $tailleNote);


            $this->fpdf->Cell(30, 4, '   ' . strtoupper("   TRAVAIL ANNUEL"), 1, 0, 'L', 1);

            $this->fpdf->SetFont('Arial', 'B', $tailleNote + 1);

            $this->fpdf->SetXY(96, 84);

            $this->fpdf->Cell(10, 3, 'Notes', 1, 0, 'C', 1);
            $this->fpdf->Cell(5, 3, 'C', 1, 0, 'C', 1);
            $this->fpdf->Cell(10, 3, 'N*C', 1, 0, 'C', 1);
            $this->fpdf->Cell(5, 3, 'Rg', 1, 0, 'C', 1);
            $this->fpdf->SetXY(126, 80);
            $this->fpdf->Cell(11, 7, 'Appre', 1, 0, 'C', 1);
            $this->fpdf->Cell(7, 7, 'Max', 1, 0, 'C', 1);
            $this->fpdf->Cell(7, 7, 'Min', 1, 0, 'C', 1);
            $this->fpdf->Cell(8, 7, 'Moy', 1, 0, 'C', 1);
            $this->fpdf->Cell(50, 7, 'Professeurs et Visas', 1, 0, 'C', 1);



            // CATEGORIE 1 ET  DEVOIR 1

            $tailleCelleLong  =  5;
            $tailleLargCell = 7;

            $val1  = noteAnnuelle::with('matiere', 'student', 'evaluation', 'user')

                ->where('classe_id', $IdClasse)
                ->where('cat_id', 1)
                ->where('student_id', $data->student->id)
                ->where('codeEtab', $codeEtab)
                ->where('session', $session)->count();




            $val2  = noteAnnuelle::with('matiere', 'student', 'evaluation', 'user')

                ->where('classe_id', $IdClasse)
                ->where('cat_id', 2)
                ->where('student_id', $data->student->id)
                ->where('codeEtab', $codeEtab)
                ->where('session', $session)->count();


            $val3  = noteAnnuelle::with('matiere', 'student', 'evaluation', 'user')

                ->where('classe_id', $IdClasse)
                ->where('cat_id', 3)
                ->where('student_id', $data->student->id)
                ->where('codeEtab', $codeEtab)
                ->where('session', $session)->count();

            $this->fpdf->Ln();

            $cat = 1;

            $Note1[$data->student->id]  =  $this->getNoteValueByCatId($data, $idEval1, $IdClasse, $codeEtab, $session,  $cat);
            $Note2[$data->student->id]  =  $this->getNoteValueByCatId($data, $idEval2, $IdClasse, $codeEtab, $session,  $cat);
            $Note3[$data->student->id]  =  $this->getNoteValueByCatId($data, $idEval3, $IdClasse, $codeEtab, $session,  $cat);
            $Note4[$data->student->id]  =  $this->getNoteValueByCatId($data, $idEval4, $IdClasse, $codeEtab, $session,  $cat);
            $Note5[$data->student->id]  =  $this->getNoteValueByCatId($data, $idEval5, $IdClasse, $codeEtab, $session, $cat);




            // Affichange Note seq 1 de la cat 1
            $this->generateNoteReportDataAnnuel(
                $notes = $Note1[$data->student->id],
                $idEval1,
                $IdClasse,
                ""
            );






            //  Affichange Note seq 2 de la cat 1





            $this->generateNoteReportDataAnnuelNote(
                $notes = $Note2[$data->student->id],
                $idEval2,
                $IdClasse,
                "",
                68
            );

            // Affichange Note seq 3 de la cat 1

            $this->fpdf->Ln(-$tailleCelleLong * $val1);


            $this->generateNoteReportDataAnnuelNote(
                $notes = $Note3[$data->student->id],
                $idEval3,
                $IdClasse,
                "",
                68 + (1 * $tailleLargCell)
            );


            // Affichange Note seq 4 de la cat 1



            $this->fpdf->Ln(-$tailleCelleLong * $val1);

            $this->generateNoteReportDataAnnuelNote(
                $notes = $Note4[$data->student->id],
                $idEval4,
                $IdClasse,
                " ",
                68 + (2 * $tailleLargCell)
            );


            // Affichange Note seq 5 de la cat 1


            $this->fpdf->Ln(-$tailleCelleLong * $val1);
            $this->generateNoteReportDataAnnuelNote(
                $notes = $Note5[$data->student->id],
                $idEval5,
                $IdClasse,
                "",
                68 + (3 * $tailleLargCell)
            );





            // TRAVAIL ANNUELLE

            $this->fpdf->Ln(-$tailleCelleLong * $val1);
            $Note[$data->student->id]  =  $this->getNoteValueByCatIdAnnuelle($data, $IdClasse, $codeEtab, $session, $cat);

            $this->generateNoteReportDataAnnuelTravail($Note[$data->student->id], $IdClasse, "MODULES DES COMPETENCES COMPLEMENTAIRES");








            // ################################   PARTIE 2 ####################################



            $cat = 2;
            $Note1[$data->student->id]  =  $this->getNoteValueByCatId($data, $idEval1, $IdClasse, $codeEtab, $session,  $cat);
            $Note2[$data->student->id]  =  $this->getNoteValueByCatId($data, $idEval2, $IdClasse, $codeEtab, $session,  $cat);
            $Note3[$data->student->id]  =  $this->getNoteValueByCatId($data, $idEval3, $IdClasse, $codeEtab, $session,  $cat);
            $Note4[$data->student->id]  =  $this->getNoteValueByCatId($data, $idEval4, $IdClasse, $codeEtab, $session,  $cat);
            $Note5[$data->student->id]  =  $this->getNoteValueByCatId($data, $idEval5, $IdClasse, $codeEtab, $session, $cat);
            $this->fpdf->Ln();



            // Affichange Note seq 1 de la cat 2
            $this->generateNoteReportDataAnnuel(
                $notes = $Note1[$data->student->id],
                $idEval1,
                $IdClasse,
                ""
            );



            //  Affichange Note seq 2 de la cat 1


            $this->fpdf->Ln(($val1 * $tailleCelleLong) + 6); //  6 est la hauteur  du gros cadran de synthese des groupe




            $this->generateNoteReportDataAnnuelNote(
                $notes = $Note2[$data->student->id],
                $idEval2,
                $IdClasse,
                "",
                68
            );


            //  Affichange Note seq 3 de la cat 1


            $this->fpdf->Ln((-$val2 * $tailleCelleLong));
            $this->generateNoteReportDataAnnuelNote(
                $notes = $Note3[$data->student->id],
                $idEval3,
                $IdClasse,
                "",
                68 + (1 * $tailleLargCell)
            );


            //  Affichange Note seq 4 de la cat 1

            $this->fpdf->Ln((-$val2 * $tailleCelleLong));
            $this->generateNoteReportDataAnnuelNote(
                $notes = $Note4[$data->student->id],
                $idEval4,
                $IdClasse,
                "",
                68 + (2 * $tailleLargCell)
            );


            //  Affichange Note seq 4 de la cat 1

            $this->fpdf->Ln((-$val2 * $tailleCelleLong));
            $this->generateNoteReportDataAnnuelNote(

                $notes = $Note5[$data->student->id],
                $idEval5,
                $IdClasse,
                "",
                68 + (3 * $tailleLargCell)
            );



            $this->fpdf->Ln(-$tailleCelleLong * $val2);
            $Note[$data->student->id]  =  $this->getNoteValueByCatIdAnnuelle($data, $IdClasse, $codeEtab, $session, $cat);

            $this->generateNoteReportDataAnnuelTravail($Note[$data->student->id], $IdClasse, "MODULES DES COMPETENCES GENERALES");





            // ################################   PARTIE 3 ####################################



            $cat = 3;
            $Note1[$data->student->id]  =  $this->getNoteValueByCatId($data, $idEval1, $IdClasse, $codeEtab, $session,  $cat);
            $Note2[$data->student->id]  =  $this->getNoteValueByCatId($data, $idEval2, $IdClasse, $codeEtab, $session,  $cat);
            $Note3[$data->student->id]  =  $this->getNoteValueByCatId($data, $idEval3, $IdClasse, $codeEtab, $session,  $cat);
            $Note4[$data->student->id]  =  $this->getNoteValueByCatId($data, $idEval4, $IdClasse, $codeEtab, $session,  $cat);
            $Note5[$data->student->id]  =  $this->getNoteValueByCatId($data, $idEval5, $IdClasse, $codeEtab, $session, $cat);
            $this->fpdf->Ln();



            // Affichange Note seq 1 de la cat 2
            $this->generateNoteReportDataAnnuel(
                $notes = $Note1[$data->student->id],
                $idEval1,
                $IdClasse,
                ""
            );



            //  Affichange Note seq 2 de la cat 1


            $this->fpdf->Ln($val1 * $tailleCelleLong +  $val2 * $tailleCelleLong  + 12); //  6 est la hauteur  du gros cadran de synthese des groupe

            $this->generateNoteReportDataAnnuelNote(
                $notes = $Note2[$data->student->id],
                $idEval2,
                $IdClasse,
                "",
                68
            );


            //  Affichange Note seq 3 de la cat 1


            $this->fpdf->Ln((-$val3 * $tailleCelleLong));
            $this->generateNoteReportDataAnnuelNote(
                $notes = $Note3[$data->student->id],
                $idEval3,
                $IdClasse,
                "",
                68 + (1 * $tailleLargCell)
            );


            //  Affichange Note seq 4 de la cat 1

            $this->fpdf->Ln((-$val3 * $tailleCelleLong));
            $this->generateNoteReportDataAnnuelNote(
                $notes = $Note4[$data->student->id],
                $idEval4,
                $IdClasse,
                "",
                68 + (2 * $tailleLargCell)
            );


            //  Affichange Note seq 4 de la cat 1

            $this->fpdf->Ln((-$val3 * $tailleCelleLong));
            $this->generateNoteReportDataAnnuelNote(

                $notes = $Note5[$data->student->id],
                $idEval5,
                $IdClasse,
                "",
                68 + (3 * $tailleLargCell)
            );



            $this->fpdf->Ln(-$tailleCelleLong * $val3);
            $Note[$data->student->id]  =  $this->getNoteValueByCatIdAnnuelle($data, $IdClasse, $codeEtab, $session, $cat);

            $this->generateNoteReportDataAnnuelTravail($Note[$data->student->id], $IdClasse, "MODULES DES ENSEIGNEMENTS COMPLEMENTAIRES");


            // *******************************  LE BAS DU BULLETIN ANNUEL **********************************


            $this->fpdf->SetFont('Arial', 'B', $tailleNote + 3);

            $this->fpdf->Ln(15);

            $this->fpdf->SetX(1);


            // ### LE PREMIER BLOC ###########################


            $taille = 5;


            // Recuperer toutes les moyennes Trimestrielles

            $moyTrim1 = $this->getStudentMoyenneTrimestreByIdStudent($data->student->id, $MoyT1);
            $moyTrim2 = $this->getStudentMoyenneTrimestreByIdStudent($data->student->id, $MoyT2);
            $moyTrim3 = $this->getStudentMoyenneTrimestreByIdStudent($data->student->id, $MoyT3);






            // $moysAnnuels = $this->getStudentMoyenneAnnuelleByIdStudent($data->student->id, $IdClasse);

            // dd($moysAnnuels);
            //  $this->fpdf->SetFillColor('111', '111', '111');
            $this->fpdf->SetFillColor('41', '155', '199');
            $this->fpdf->Cell(40,   $taille, utf8_decode('Résultat annuel'), 1, 0, 'C', 1);
            $this->fpdf->Ln();
            $this->fpdf->SetX(1);
            $this->fpdf->Cell(28,   $taille, "Trimestre " . ($idEval1 - 1), 1, 0, 'L', 0);


            // $this->fpdf->Cell(12, $taille, $moyTrim1['moy'], 1, 0, 'L', 0);
            // $this->fpdf->Ln();
            // $this->fpdf->SetX(1);
            // $this->fpdf->Cell(28,   $taille, "Trimestre " . ($idEval2 - 1), 1, 0, 'L', 0);
            // $this->fpdf->Cell(12,   $taille, $moyTrim2['moy'], 1, 0, 'L', 0);
            // $this->fpdf->Ln();
            // $this->fpdf->SetX(1);
            // $this->fpdf->Cell(28,   $taille, "Trimestre " . ($idEval3 - 1), 1, 0, 'L', 0);
            // $this->fpdf->Cell(12,  $taille, $moyTrim3['moy'], 1, 0, 'L', 0);
            $this->fpdf->Cell(
                12,
                $taille,
                $moyTrim1['moy'] ? $moyTrim1['moy'] : '-',
                1,
                0,
                'C',
                0
            );
            $this->fpdf->Ln();
            $this->fpdf->SetX(1);
            $this->fpdf->Cell(
                28,
                $taille,
                "Trimestre " . ($idEval2 - 1),
                1,
                0,
                'L',
                0
            );
            $this->fpdf->Cell(12, $taille, $moyTrim2['moy'] ? $moyTrim2['moy'] : '-', 1, 0, 'C', 0);
            $this->fpdf->Ln();
            $this->fpdf->SetX(1);
            $this->fpdf->Cell(
                28,
                $taille,
                "Trimestre " . ($idEval3 - 1),
                1,
                0,
                'L',
                0
            );
            $this->fpdf->Cell(
                12,
                $taille,
                $moyTrim3['moy'] ? $moyTrim3['moy'] : '-',
                1,
                0,
                'C',
                0
            );

            $this->fpdf->Ln();
            $this->fpdf->SetX(1);
            $this->fpdf->Cell(28,   $taille, "Moy. Annuelle ", 1, 0, 'L', 1);
            $this->fpdf->Cell(12,   $taille, $data->valeur, 1, 0, 'L', 0);
            $this->fpdf->Ln();
            $this->fpdf->SetX(1);
            $this->fpdf->Cell(28,   $taille, "Rang Annuel ", 1, 0, 'L', 1);


            $label = '';

            if ($key + 1 == 1) {
                $label = 'er';
            } else {
                $label =  utf8_decode('è');
            }
            $this->fpdf->Cell(12,   $taille, ($key + 1) . $label, 1, 0, 'L', 0);



            // ### LE DEUXIEME BLOC ###########################


            $this->fpdf->Ln(-$taille * 5);

            $this->fpdf->SetX(41);

            $this->fpdf->Cell(40, $taille, utf8_decode('Profil annuel de la classe'), 1, 0, 'C', 1);
            $this->fpdf->Ln();
            $this->fpdf->SetX(41);
            $this->fpdf->Cell(25, $taille, "Moy. Premier ", 1, 0, 'L', 0);
            $this->fpdf->Cell(
                15,
                $taille,
                $MoyPremier,
                1,
                0,
                'C',
                0
            );

            $this->fpdf->Ln();
            $this->fpdf->SetX(41);
            $this->fpdf->Cell(25, $taille, "Moy. Dernier ", 1, 0, 'L', 0);
            $this->fpdf->Cell(
                15,
                $taille,
                $MoyDernier,
                1,
                0,
                'C',
                0
            );

            $this->fpdf->Ln();
            $this->fpdf->SetX(41);
            $this->fpdf->Cell(25, $taille, "Nbre Moyenne", 1, 0, 'L', 0);
            $this->fpdf->Cell(
                15,
                $taille,
                $NbreMoyenne,
                1,
                0,
                'C',
                0
            );

            $this->fpdf->Ln();
            $this->fpdf->SetX(41);
            $this->fpdf->Cell(25, $taille, utf8_decode("Taux réussite"), 1, 0, 'L', 1);
            $this->fpdf->Cell(
                15,
                $taille,
                number_format(100 * $NbreMoyenne / $effectif, 2) . " %",
                1,
                0,
                'C',
                0
            );

            $this->fpdf->Ln();
            $this->fpdf->SetX(41);
            $this->fpdf->Cell(25, $taille, utf8_decode("Moy. Classe"), 1, 0, 'L', 1);
            $this->fpdf->Cell(
                15,
                $taille,



                number_format($moyTotalAnnuelClasse / $effectif, 2),
                1,
                0,
                'C',
                0
            );



            // ### LE TROISIEME  BLOC ###########################


            $results1 = $this->getMoyEvalStudentAndRankAnnuelById($idStudent = $data->student_id, $EvalId = $idEval1, $idClasse = $idClasse, $moyEval = $MoysE1);
            $results2 = $this->getMoyEvalStudentAndRankAnnuelById($idStudent = $data->student_id, $EvalId = $idEval2, $idClasse = $idClasse, $moyEval = $MoysE2);
            $results3 = $this->getMoyEvalStudentAndRankAnnuelById($idStudent = $data->student_id, $EvalId = $idEval3, $idClasse = $idClasse, $moyEval = $MoysE3);
            $results4 = $this->getMoyEvalStudentAndRankAnnuelById($idStudent = $data->student_id, $EvalId = $idEval4, $idClasse = $idClasse, $moyEval = $MoysE4);
            $results5 = $this->getMoyEvalStudentAndRankAnnuelById($idStudent = $data->student_id, $EvalId = $idEval5, $idClasse = $idClasse, $moyEval = $MoysE5);


            $labelRank = '';


            // if (
            //     $results1['rank'] == 1 ||
            //     $results2['rank'] == 1 ||
            //     $results3['rank'] == 1 ||
            //     $results4['rank'] == 1 ||
            //     $results5['rank'] == 1
            // ) {

            //     $labelRank = 'er';
            // } else {
            //     $labelRank = utf8_decode('è');
            // }


            $this->fpdf->Ln(-$taille * 5);

            $this->fpdf->SetX(86);

            $this->fpdf->Cell(70, $taille, utf8_decode('Rappel des moyennes des évaluations'), 1, 0, 'C', 1);

            $this->fpdf->Ln();
            $this->fpdf->SetX(86);
            $this->fpdf->Cell(25, $taille, "Moyenne D" . ($idEval1 - 1), 1, 0, 'L', 0);
            $this->fpdf->Cell(
                15,
                $taille,
                $results1['moy'] ? $results1['moy'] : '-',
                1,
                0,
                'C',
                0
            );
            $this->fpdf->Ln();
            $this->fpdf->SetX(86);
            $this->fpdf->Cell(25, $taille, "Moyenne D" . ($idEval2 - 1), 1, 0, 'L', 0);
            $this->fpdf->Cell(
                15,
                $taille,
                $results2['moy'] ? $results2['moy'] : '-',
                1,
                0,
                'C',
                0
            );
            $this->fpdf->Ln();
            $this->fpdf->SetX(86);
            $this->fpdf->Cell(25, $taille, "Moyenne D" . ($idEval3 - 1), 1, 0, 'L', 0);
            $this->fpdf->Cell(
                15,
                $taille,
                $results3['moy'] ? $results3['moy'] : '-',
                1,
                0,
                'C',
                0
            );
            $this->fpdf->Ln();
            $this->fpdf->SetX(86);
            $this->fpdf->Cell(25, $taille, "Moyenne D" . ($idEval4 - 1), 1, 0, 'L', 0);
            $this->fpdf->Cell(
                15,
                $taille,
                $results4['moy'] ? $results4['moy'] : '-',
                1,
                0,
                'C',
                0
            );


            $this->fpdf->Ln();
            $this->fpdf->SetX(86);
            $this->fpdf->Cell(25, $taille, "Moyenne D" . ($idEval5 - 1), 1, 0, 'L', 0);
            $this->fpdf->Cell(
                15,
                $taille,
                $results5['moy'] ? $results5['moy'] : '-',
                1,
                0,
                'C',
                0
            );


            $this->fpdf->Ln(-$taille * 5);



            $this->fpdf->Ln();
            $this->fpdf->SetX(126);
            $this->fpdf->Cell(20, $taille, "Rang D" . ($idEval1 - 1), 1, 0, 'L', 0);

            if (
                $results1['rank'] == 1
            ) {

                $labelRank = 'er';
            } else {
                $labelRank = utf8_decode('è');
            }

            $this->fpdf->Cell(
                10,
                $taille,
                $results1['moy'] ? $results1['rank'] . $labelRank : '- ',
                1,
                0,
                'C',
                0
            );

            $this->fpdf->Ln();
            $this->fpdf->SetX(126);
            $this->fpdf->Cell(20, $taille, "Rang D" . ($idEval2 - 1), 1, 0, 'L', 0);
            if (
                $results2['rank'] == 1
            ) {

                $labelRank = 'er';
            } else {
                $labelRank = utf8_decode('è');
            }
            $this->fpdf->Cell(
                10,
                $taille,
                $results2['moy'] ? $results2['rank'] . $labelRank : '- ',
                1,
                0,
                'C',
                0
            );

            $this->fpdf->Ln();
            $this->fpdf->SetX(126);
            $this->fpdf->Cell(20, $taille, "Rang D" . ($idEval3 - 1), 1, 0, 'L', 0);
            if (
                $results3['rank'] == 1
            ) {

                $labelRank = 'er';
            } else {
                $labelRank = utf8_decode('è');
            }
            $this->fpdf->Cell(
                10,
                $taille,
                $results3['moy'] ? $results3['rank'] . $labelRank : '- ',
                1,
                0,
                'C',
                0
            );

            $this->fpdf->Ln();
            $this->fpdf->SetX(126);
            $this->fpdf->Cell(20, $taille, "Rang D" . ($idEval4 - 1), 1, 0, 'L', 0);
            if (
                $results4['rank'] == 1
            ) {

                $labelRank = 'er';
            } else {
                $labelRank = utf8_decode('è');
            }
            $this->fpdf->Cell(
                10,
                $taille,
                $results4['moy'] ? $results4['rank'] . $labelRank : '- ',
                1,
                0,
                'C',
                0
            );

            $this->fpdf->Ln();
            $this->fpdf->SetX(126);
            $this->fpdf->Cell(20, $taille, "Rang D" . ($idEval5 - 1), 1, 0, 'L', 0);
            if (
                $results5['rank'] == 1
            ) {

                $labelRank = 'er';
            } else {
                $labelRank = utf8_decode('è');
            }
            $this->fpdf->Cell(
                10,
                $taille,
                $results5['moy'] ? $results5['rank'] . $labelRank : '- ',
                1,
                0,
                'C',
                0
            );

            //  LE QUATRIEME  BLOC ###########################


            $this->fpdf->Ln(-$taille * 5);

            $this->fpdf->SetX(165);

            $this->fpdf->Cell(40, $taille, utf8_decode('Bilan disciplinaire'), 1, 0, 'C', 1);

            $this->fpdf->Ln();
            $this->fpdf->SetX(165);
            $this->fpdf->Cell(30, $taille, "Abs. Justif ", 1, 0, 'L', 0);
            $this->fpdf->Cell(
                10,
                $taille,
                $heureTrimestreJustifies,
                1,
                0,
                'C',
                0
            );

            $this->fpdf->Ln();
            $this->fpdf->SetX(165);
            $this->fpdf->Cell(30, $taille, "Abs.  Non Justif ", 1, 0, 'L', 1);
            $this->fpdf->Cell(
                10,
                $taille,
                $heureTrimestre - $heureTrimestreJustifies,
                1,
                0,
                'C',
                0
            );

            $this->fpdf->Ln();
            $this->fpdf->SetX(165);
            $this->fpdf->Cell(30, $taille, "Exclusion(s) ", 1, 0, 'L', 0);
            $this->fpdf->Cell(
                10,
                $taille,
                "",
                1,
                0,
                'C',
                0
            );

            $this->fpdf->Ln();
            $this->fpdf->SetX(165);
            $this->fpdf->Cell(30, $taille, "/", 1, 0, 'C', 0);
            $this->fpdf->Cell(
                10,
                $taille,
                "/",
                1,
                0,
                'C',
                0
            );

            $this->fpdf->Ln();
            $this->fpdf->SetX(165);
            $this->fpdf->Cell(30, $taille, "/", 1, 0, 'C', 0);
            $this->fpdf->Cell(
                10,
                $taille,
                "/",
                1,
                0,
                'C',
                0
            );


            // ******************** LE SIXIEME BLOC ********************************** //


            $this->fpdf->Ln(20);

            $this->fpdf->SetX(1);

            $this->fpdf->Cell(145, $taille, utf8_decode("Décision du conseil de classe de fin d'année"), 1, 0, 'C', 1);
            $this->fpdf->Ln();

            $this->fpdf->SetX(1);
            $this->fpdf->Cell(145, 34, '', 1);

            $this->fpdf->Text(3, 244, "Tableau d'honneur   [_] ");

            $this->fpdf->Text(60, 244, "Encouragements    [_] ");

            $this->fpdf->Text(110, 244, utf8_decode("Félicitations    [_] "));


            $this->fpdf->Text(
                3,
                249,
                utf8_decode("Redouble la classe   [_]")
            );

            $this->fpdf->Text(
                60,
                249,
                utf8_decode("Promu(e) en classe de ______________")
            );


            $this->fpdf->Text(
                3,
                255,
                utf8_decode("EXCLU(e) pour  :  ")
            );


            $this->fpdf->Text(
                3,
                261,
                utf8_decode("Absentéisme  [_]     Mauvais Travail   [_]     Conduite déplorable  [_]")
            );



            $this->fpdf->Text(
                3,
                265,
                utf8_decode("Age avancé     [_]     Ne peut tripler     [_]      Autre _________________")
            );






            $this->fpdf->Ln(-$taille);
            $this->fpdf->SetX(147);


            $this->fpdf->Cell(58, $taille, utf8_decode("Visa du Chef d'Etablissement"), 1, 0, 'C', 1);
            $this->fpdf->Ln();
            $this->fpdf->SetX(147);

            $this->fpdf->Text(
                150,
                244,
                utf8_decode("Manengole ________________")
            );



            $this->fpdf->Text(
                150,
                260,
                utf8_decode("LE PROVISEUR")
            );

            $this->fpdf->Cell(58, 34, '', 1);



            $this->fpdf->SetFont('Arial', 'B', $tailleNote + 2);

            $this->fpdf->Text(
                3,
                280,
                utf8_decode("NB: La moyenne annuelle est la moyenne de cinq (05) évaluations | NA = Non Aquis ; ECA = En cours d'acquisition ; Acquis")
            );
            $this->fpdf->Text(
                3,
                285,
                utf8_decode("Logiciel  mis en place par Ing EKOUTE FABIEN  ; Email : fabienekoute@gmail.com  ; Téléphone : 693333163 / 679901213 ( WhatsApp ) ")
            );
        }


        $this->fpdf->Output();
        exit;
    }




    public function getAllBulletinEval($id)

    {


        $tailleLIbelleMatiere =  7;


        $tailleNote =  8;


        $conf = config::first();

        $entete = $conf->header;

        $data =  explode('*', $id);
        $IdClasse = $data[0];
        $IdEvaluation  = $data[1];

        // Je trouve le codeEtab et la session

        $code = Classe::where('id', $IdClasse)->first();
        $codeEtab = $code->codeEtabClasse;
        $session = $code->sessionClasse;

        $classeName = Etablissement::where('codeEtab', $codeEtab)->first();

        // Tous les eleves

        $classeData = Student::with('user', 'classe')->where('classe_id', $IdClasse)->where('session', $session)
            ->where('codeEtab', $codeEtab)->where('statut', "!=", 3)->get();

        $effectif = Student::where('classe_id', $IdClasse)->where('session', $session)
            ->where('codeEtab', $codeEtab)->where('statut', "!=", 3)->count();

        $moyData = Moyennes::with('student')->where('session', $session)->where('codeEtab', $codeEtab)
            ->where('evaluation_id', $IdEvaluation)->where('classe_id', $IdClasse)->orderBy('valeur', 'DESC')->get();



        // cherchons les non classes , cest a dire ceux qui ont eu 0 de moyenne


        // $nonClasse = Moyennes::where('valeur', 0)->count();




        $noteData =   Notes::where('evaluation_id', $IdEvaluation)->where('classe_id', $IdClasse)
            ->where('session', $session)->where('codeEtab', $codeEtab)->get();



        $moyenneSommeClasse =  Moyennes::where('evaluation_id', $IdEvaluation)->where('classe_id', $IdClasse)
            ->where('session', $session)->where('codeEtab', $codeEtab)->sum('valeur');


        // nombre deleve ayant une moyenne sans les non classes


        $nombreEleves =  Moyennes::where('evaluation_id', $IdEvaluation)->where('classe_id', $IdClasse)->where('valeur', '>', 0)
            ->where('session', $session)->where('codeEtab', $codeEtab)->count();


        // prof principal classe

        $rest = Classe::where('id', $IdClasse)->first();

        $teach = Enseignants::where('id', $rest->principale_Classe)->first();


        $sommeNoteCoef1 = $sommeNoteCoef2 = $sommeNoteCoef3 = 0;

        $sommeCoef1 = $sommeCoef2 = $sommeCoef3 = 0;

        $couleurRouge = 10;


        foreach ($moyData   as $key => $data) {


            // dd($data->valeur);



            if ($key == 0) {

                $e = 'er';
            } else {

                $e = utf8_decode('è');
            }


            $this->fpdf->AddPage("P", [
                '290',
                '210'
            ]); // 315

            $Note[$data->student->id]   =  $this->getNoteValueByCatId($data, $IdEvaluation, $IdClasse, $codeEtab, $session, 1);




            $EleveData[$data->student->id] = Student::with('user')->where('id', $data->student->id)->get();


            $this->fpdf->Image(public_path("/Photos/Logos/" . $entete), 8, 2, 190, 33, "");



            // INFORMATION STUDENT EN HAUT


            $tailleNote = 6;
            $libelle = 7;
            // Informations de l'eleve

            $this->fpdf->SetFont('Arial', 'B', 7);
            $this->fpdf->Text(105, 58, 'Matricule : ');
            $this->fpdf->SetFont('Arial', 'B', 7);
            $this->fpdf->Text(137, 58, $Note[$data->student->id][0]->student->matricule);



            $this->fpdf->SetFont('Arial', 'B', 7);
            $this->fpdf->Text(105, 63, utf8_decode('Noms et prénoms :  '));
            $this->fpdf->SetFont('Arial', 'B', 7);
            $this->fpdf->Text(137, 63, utf8_decode($Note[$data->student->id][0]->student->nom . ' ' . $Note[$data->student->id][0]->student->prenom));

            $this->fpdf->SetFont('Arial', 'B', 7);
            $this->fpdf->Text(105, 68, utf8_decode('Née le : '));
            $this->fpdf->SetFont('Arial', 'B', 7);
            $this->fpdf->Text(137, 68, utf8_decode(date_format(date_create($Note[$data->student->id][0]->student->dateNaiss), "d /m/ Y")));
            $this->fpdf->SetFont('Arial', 'B', 7);

            $this->fpdf->Text(105, 72, 'Sexe  : ');
            $this->fpdf->SetFont('Arial', 'B', 7);
            $this->fpdf->Text(137, 72, $data->student->sexe . '                , ');
            $this->fpdf->SetFont('Arial', 'B', 7);

            $this->fpdf->Text(155, 72, 'Redoublant    : ');
            $this->fpdf->SetFont('Arial', 'B', 7);
            if ($data->student->doublant == "REDOUBLANT") {
                $this->fpdf->Text(
                    175,
                    72,
                    "Oui"
                );
            } else {

                $this->fpdf->Text(
                    175,
                    72,
                    "Non"
                );
            }

            $this->fpdf->SetFont('Arial', 'B', 7);


            // // deuxiemme



            $this->fpdf->Text(37, 58, utf8_decode('Année-Scolaire  : '));
            $this->fpdf->SetFont('Arial', 'B', 7);
            $this->fpdf->Text(59, 58, utf8_decode($session));
            $this->fpdf->SetFont('Arial', 'B', 7);


            $this->fpdf->Text(37, 63, 'Classe  : ');
            $this->fpdf->SetFont('Arial', 'B', 7);
            $this->fpdf->Text(59, 63, utf8_decode($Note[$data->student->id][0]->Classe->libelleClasse));
            $this->fpdf->SetFont('Arial', 'B', 7);

            $this->fpdf->Text(37, 67, 'Effectif  :  ');
            $this->fpdf->SetFont('Arial', 'B', 7);
            $this->fpdf->Text(59, 67, $effectif);
            $this->fpdf->SetFont('Arial', 'B', 7);


            $this->fpdf->Text(37, 71, 'Prof Principal  :');
            $this->fpdf->SetFont('Arial', 'B', 6);


            $this->fpdf->Text(59, 71, substr(
                utf8_decode($teach->nom . ' ' . $teach->prenom,),
                0,
                42
            ));


            if (file_exists(public_path("/Photos/Logos/" . $EleveData[$data->student->id][0]->user->photo))) {


                $this->fpdf->Image(public_path("/Photos/Logos/" . $EleveData[$data->student->id][0]->user->photo), 6, 50, 25, 27,  "");
            }




            if (!file_exists(public_path("/Photos/Qrcodes/Qrcode" . $data->student->id . ".png"))) {



                $dataToEncode = mb_convert_encoding(
                    $data->student->nom . " " .
                        $data->student->prenom . ',' .
                        utf8_decode(date_format(date_create($data->student->dateNaiss), "d /m/ Y")) . "," .
                        $data->student->lieuNaiss . "," .
                        "EVALUATION " . ":" .
                        $data->valeur . '/20',
                    'utf-8',
                    // Specify the original encoding of the data here
                );

                QrCode::format('png')
                    ->size(299)
                    ->color(40, 40, 40)
                    ->encoding('utf-8') // Only needed if using option 1
                    ->generate($dataToEncode, public_path("/Photos/Qrcodes/Qrcode" . $data->student->id . ".png"));
            }


            $this->fpdf->Image(public_path("/Photos/Qrcodes/Qrcode" . $data->student->id . ".png"), 190, 265, 15, 15, "");


            //     // // Cadre information eleve


            $this->fpdf->SetXY(35, 50);
            $this->fpdf->Cell(23, 27, '', 1);


            $this->fpdf->SetXY(58, 50);
            $this->fpdf->Cell(45, 27, '', 1);


            $this->fpdf->SetXY(103, 50);
            $this->fpdf->Cell(33, 27, '', 1);


            $this->fpdf->SetXY(136, 50);
            $this->fpdf->Cell(71, 27, '', 1);




            // Cadre pour le titre du trimestre

            $this->fpdf->SetFillColor(
                '255',
                '255',
                '255'
            );
            $this->fpdf->SetFont('Times', 'B', 19);
            $this->fpdf->SetXY(50, 39);
            $this->fpdf->Cell(120, 8, utf8_decode('BULLETIN DES EVALUATIONS N°' . '' . strtoupper($IdEvaluation - 1)), 1, 0, 'C', 1);


            // $this->fpdf->Cell(70, 8, utf8_decode('BULLETIN DES EVALUATIONS N°') . '' . strtoupper($Note[$data->student->id][0]->evaluation->id - 1), 0, 0, 'C', 0);


            // $this->fpdf->SetXY(50,39);
            // $this->fpdf->Cell(100,10,'',1);

            $this->fpdf->SetFont('Arial', 'B', $tailleNote + 1);
            $this->fpdf->SetTextColor(0, 0, 0);
            // Tire cadre a cote
            // $this->fpdf->Text(135, 72, strtoupper($classeName->libelleEtab));

            $this->fpdf->SetXY(3, 90);
            // $this->fpdf->SetFont('Arial', 'B', 7);
            $this->fpdf->SetDrawColor(0, 0, 0);
            // $this->fpdf->SetFillColor('61', '169', '209');
            $this->fpdf->SetFillColor('111', '111', '111');
            $this->fpdf->Cell(70, 7, utf8_decode('MATIERES'), 1, 0, 'C', 1);

            $this->fpdf->Cell(
                10,
                7,
                'Notes',
                1,
                0,
                'C',
                1
            );
            $this->fpdf->Cell(10, 7, 'Coef', 1, 0, 'C', 1);
            $this->fpdf->Cell(10, 7, 'N*C', 1, 0, 'C', 1);
            $this->fpdf->Cell(10, 7, 'Rang', 1, 0, 'C', 1);

            $this->fpdf->Cell(
                11,
                7,
                'Appre',
                1,
                0,
                'C',
                1
            );
            $this->fpdf->Cell(8, 7, 'Max', 1, 0, 'C', 1);
            $this->fpdf->Cell(8, 7, 'Min', 1, 0, 'C', 1);
            $this->fpdf->Cell(10, 7, 'Moy', 1, 0, 'C', 1);
            $this->fpdf->Cell(
                40,
                7,
                'Professeurs',
                1,
                0,
                'C',
                1
            );
            $this->fpdf->Cell(18, 7, 'VISA', 1, 0, 'C', 1);

            $this->fpdf->Ln();
            $this->fpdf->SetX(20);


            // Pour la note seq1

            $tailleCelleLong = 7;
            $tailleText = 8;
            $tailleTextChiffre = 8;

            $this->fpdf->SetFont('Arial', 'B', $tailleText);


            // CATEGORIE 1

            $Note[$data->student->id]  =  $this->getNoteValueByCatId($data, $IdEvaluation, $IdClasse, $codeEtab, $session, 1);

            $this->generateNoteReportData($Note[$data->student->id], $IdEvaluation, $IdClasse, "MODULE DES ENSEIGNEMENTS GENERAUX ");

            $this->fpdf->Ln();

            // CATEGORIE 2

            $Note[$data->student->id]  =  $this->getNoteValueByCatId($data, $IdEvaluation, $IdClasse, $codeEtab, $session, 2);

            $this->generateNoteReportData($Note[$data->student->id], $IdEvaluation, $IdClasse, "MODULES DES COMPETENCES GENERALES");


            $this->fpdf->Ln();


            // CATEGORIE 3

            $Note[$data->student->id]  =  $this->getNoteValueByCatId($data, $IdEvaluation, $IdClasse, $codeEtab, $session, 3);

            $this->generateNoteReportData($Note[$data->student->id], $IdEvaluation, $IdClasse, "MODULES DES COMPETENCES COMPLEMENTAIRES");





            // DERNIERE PARTIE DU BULLETIN



            $this->fpdf->Ln(12);

            $this->fpdf->SetX(3);
            $this->fpdf->SetFont('Arial', 'B', $tailleText);


            // PREMIER BOLC ENTETE

            $tailleText = 5;

            $this->fpdf->Cell(70, $tailleText, utf8_decode('TRAVAIL DE LA CLASSE'), 1, 0, 'C', 1);
            $this->fpdf->Cell(45, $tailleText,  utf8_decode(strtoupper("EVALUATION" . " " . ($IdEvaluation - 1))), 1, 0, 'C', 1);
            $this->fpdf->Cell(45, $tailleText, utf8_decode('CONDUITE'), 1, 0, 'C', 1);
            $this->fpdf->Cell(45, $tailleText, utf8_decode('TRAVAIL'), 1, 0, 'C', 1);

            $this->fpdf->Ln();
            $this->fpdf->SetX(3);

            //  VARIABLE ET VALEUR PREMIER BOLC ENTETE (PREMIERE LIGNE)

            $this->fpdf->Cell(45, $tailleText, utf8_decode('MOYENNE GEN CLASSSE'), 1, 0, 'L', 0);
            $this->fpdf->Cell(25, $tailleText, utf8_decode(''), 1, 0, 'C', 1);

            $this->fpdf->Cell(25, $tailleText, utf8_decode('TOTAL POINTS'), 1, 0, 'L', 0);
            $this->fpdf->Cell(20, $tailleText, utf8_decode(''), 1, 0, 'C', 0);

            $this->fpdf->Cell(35, $tailleText, utf8_decode('ABSENCES JUSTIF'), 1, 0, 'L', 0);
            $this->fpdf->Cell(10, $tailleText, utf8_decode(''), 1, 0, 'C', 0);

            $this->fpdf->Cell(35, $tailleText, utf8_decode("TABLEAU D'HONNEUR"), 1, 0, 'L', 1);
            $this->fpdf->Cell(10, $tailleText, utf8_decode(''), 1, 0, 'C', 0);


            //  VARIABLE ET VALEUR DEUXIEM  BOLC ENTETE (DEUXIEME LIGNE)


            $this->fpdf->Ln();
            $this->fpdf->SetX(3);

            $this->fpdf->Cell(45, $tailleText, utf8_decode('MOYENNE GEN CLASSSE'), 1, 0, 'L', 0);
            $this->fpdf->Cell(25, $tailleText, utf8_decode(''), 1, 0, 'C', 0);

            $this->fpdf->Cell(25, $tailleText, utf8_decode('TOTAL COEFS '), 1, 0, 'L', 0);
            $this->fpdf->Cell(20, $tailleText, utf8_decode(''), 1, 0, 'C', 0);

            $this->fpdf->Cell(35, $tailleText, utf8_decode('ABSENCE NON JUSTIF'), 1, 0, 'L', 1);
            $this->fpdf->Cell(10, $tailleText, utf8_decode(''), 1, 0, 'C', 0);

            $this->fpdf->Cell(35, $tailleText, utf8_decode("FELICITATIONS"), 1, 0, 'L', 0);
            $this->fpdf->Cell(10, $tailleText, utf8_decode(''), 1, 0, 'C', 0);


            //  VARIABLE ET VALEUR DEUXIEM  BOLC ENTETE (TROISIEME LIGNE)


            $this->fpdf->Ln();
            $this->fpdf->SetX(3);

            $this->fpdf->Cell(45, $tailleText, utf8_decode('MOY DERNIER / 20'), 1, 0, 'L', 0);
            $this->fpdf->Cell(25, $tailleText, utf8_decode(''), 1, 0, 'C', 0);

            $this->fpdf->Cell(25, $tailleText, utf8_decode('MOYENNE / 20'), 1, 0, 'L', 1);
            $this->fpdf->Cell(20, $tailleText, utf8_decode(''), 1, 0, 'C', 0);

            $this->fpdf->Cell(35, $tailleText, utf8_decode(' AVERTISSEMENT CDTE'), 1, 0, 'L', 0);
            $this->fpdf->Cell(10, $tailleText, utf8_decode(''), 1, 0, 'C', 0);

            $this->fpdf->Cell(35, $tailleText, utf8_decode("AVERTISSEMENT CDTE"), 1, 0, 'L', 0);
            $this->fpdf->Cell(10, $tailleText, utf8_decode(''), 1, 0, 'C', 0);


            //  VARIABLE ET VALEUR DEUXIEM  BOLC ENTETE ( QUATRIEME LIGNE )


            $this->fpdf->Ln();
            $this->fpdf->SetX(3);

            $this->fpdf->Cell(45, $tailleText, utf8_decode('TAUX REUSSITE'), 1, 0, 'L', 1);
            $this->fpdf->Cell(25, $tailleText, utf8_decode(''), 1, 0, 'C', 0);

            $this->fpdf->Cell(25, $tailleText, utf8_decode('RANG'), 1, 0, 'L', 0);
            $this->fpdf->Cell(20, $tailleText, utf8_decode(''), 1, 0, 'C', 0);

            $this->fpdf->Cell(35, $tailleText, utf8_decode('EXCLUSIONS'), 1, 0, 'L', 0);
            $this->fpdf->Cell(10, $tailleText, utf8_decode(''), 1, 0, 'C', 0);

            $this->fpdf->Cell(35, $tailleText, utf8_decode("AVERTISSEMT TRAVAIL"), 1, 0, 'L', 0);
            $this->fpdf->Cell(10, $tailleText, utf8_decode(''), 1, 0, 'C', 0);



            $this->fpdf->Ln();
            $this->fpdf->SetX(118);
            $this->fpdf->Cell(35, $tailleText, utf8_decode('BLAME CONDUITE'), 1, 0, 'L', 1);
            $this->fpdf->Cell(10, $tailleText, "", 1, 0, 'C', 0);
            $this->fpdf->Cell(35, $tailleText, utf8_decode('BLAME TRAVAIL'), 1, 0, 'L', 0);
            $this->fpdf->Cell(
                10,
                $tailleText,
                "",
                1,
                0,
                'C',
                1
            );
            $this->fpdf->SetFont('Arial', 'B', 7);

            $this->fpdf->Ln();
            $this->fpdf->SetX(3);


            $this->fpdf->Cell(75, 5, utf8_decode('VISA DU PARENT '), 1, 0, 'C', 1);
            $this->fpdf->Cell(82, 5, utf8_decode('OBSERVATION DU CONSEIL DE CLASSE'), 1, 0, 'C', 1);
            $this->fpdf->Cell(48, 5, 'VISA DU CHEF D\'ETABLISSEMENT', 1, 0, 'C', 1);


            $this->fpdf->SetX(7);
            $this->fpdf->Cell(75, 20, '', 0, 0, 'L', 0);
            $this->fpdf->Cell(82, 20, utf8_decode(''), 0, 0, 'L', 0);
            $this->fpdf->Cell(48, 21, 'MANENGOLE Le ____________', 0, 0, 'L', 0);

            $this->fpdf->SetX(3);
            $this->fpdf->Cell(75, 20, '', 1, 0, 'L', 0);
            $this->fpdf->Cell(82, 20, utf8_decode(''), 1, 0, 'L', 0);
            $this->fpdf->Cell(
                48,
                20,
                '    ',
                1,
                0,
                'L',
                0
            );


            $this->fpdf->Ln(18);

            $this->fpdf->SetX(2);

            // $this->fpdf->Cell(0, 10, "NA : Non Aquis |   ECA : En cours d'acquisition", 0, 0, 'L', 0);

            $this->fpdf->SetFont('Arial', 'B', 6);
            $this->fpdf->Cell(0, 12, "Conception du logiciel : Ingenieur EKOUTE  FABIEN | fabienekoute@gmail.com | 693333163 - 679901213 |  NA : Non Aquis | ECA : En cours d'acquisition | LYCEE TECHNIQUE DE MANENGOLE", 0, 0, 'L', 0);







            // a partir de la boucle initial

            $moyenne[$data->student->id] = $data->vleur;

            $rank[$data->student->id] = $key + 1;
        }



        $this->fpdf->Output();
        exit;
    }



    public function getNoteValueByCatId($data, $IdEvaluation, $IdClasse, $codeEtab, $session, $cat_id)

    {




        $note = Notes::with('matiere', 'student', 'evaluation', 'user')
            ->where('evaluation_id', $IdEvaluation)
            ->where('classe_id', $IdClasse)
            ->where('cat_id', $cat_id) // Catégorie variable
            ->where('student_id', $data->student->id)
            ->where('codeEtab', $codeEtab)
            ->where('session', $session)
            ->orderBy('matiere_id', 'ASC')
            ->get();

        return $note;
    }


    public function getNoteValueByCatIdAnnuelle($data, $IdClasse, $codeEtab, $session, $cat_id)

    {




        $note = noteAnnuelle::with('matiere', 'student', 'evaluation', 'user')
            ->where('classe_id', $IdClasse)
            ->where('cat_id', $cat_id) // Catégorie variable
            ->where('student_id', $data->student->id)
            ->where('codeEtab', $codeEtab)
            ->where('session', $session)
            ->orderBy('matiere_id', 'ASC')
            ->get();

        return $note;
    }







    function generateNoteReportDataAnnuel($notes, $IdEvaluation, $IdClasse, $labelGeneraux)

    {

        $tailleCelleLong = 5;
        $tailleText = 8;
        $tailleTextChiffre = 8;
        $couleurRouge = 10;
        $tailleNote = 6;

        foreach ($notes as $note) {
            $this->fpdf->SetX(1);

            $this->fpdf->SetFont('Arial', 'B', $tailleText - 1);
            $this->fpdf->Cell(
                60,
                $tailleCelleLong,
                utf8_decode(substr($note->matiere->libelle, 0, 38)),
                1,
                0,
                'L'
            );

            //  Note


            if ($note->status == 1) {

                //  Pas de note

                $this->fpdf->Cell(7, $tailleCelleLong, '-', 1, 0, 'C');
            } else {



                if ($note->valeur < $couleurRouge) {

                    $this->fpdf->SetTextColor('237', '28', '36');
                } else {

                    $this->fpdf->SetTextColor('0', '0', '0');
                }

                $this->fpdf->SetFont('Arial', 'B', $tailleText);

                $this->fpdf->Cell(7, $tailleCelleLong, $note->valeur, 1, 0, 'C');
            }



            $this->fpdf->SetTextColor('0', '0', '0');


            $this->fpdf->Ln($tailleCelleLong);
        }


        $this->fpdf->SetFont('Arial', 'B', $tailleText);


        $this->fpdf->SetY(87);
    }


    function generateNoteReportDataAnnuelNote($notes, $IdEvaluation, $IdClasse, $labelGeneraux, $espace)

    {




        $tailleCelleLong = 5;
        $tailleText = 8;
        $tailleTextChiffre = 8;
        $couleurRouge = 10;
        $tailleNote = 6;

        foreach ($notes as $note) {


            $this->fpdf->SetX($espace);


            //  Note

            if ($note->status == 1) {

                //  Pas de note

                $this->fpdf->Cell(7, $tailleCelleLong, '-', 1, 0, 'C');
            } else {

                $this->fpdf->SetFont('Arial', 'B', $tailleTextChiffre);

                if ($note->valeur < $couleurRouge) {

                    $this->fpdf->SetTextColor('237', '28', '36');
                } else {

                    $this->fpdf->SetTextColor('0', '0', '0');
                }



                $this->fpdf->Cell(7, $tailleCelleLong, $note->valeur, 1, 0, 'C');
            }

            $this->fpdf->SetFont('Arial', 'B', $tailleText);

            $this->fpdf->SetTextColor('0', '0', '0');


            $this->fpdf->Ln($tailleCelleLong);
        }
    }


    function generateNoteReportData($notes, $IdEvaluation, $IdClasse, $labelGeneraux)

    {


        $tailleCelleLong = 5;
        $tailleText = 8;
        $tailleTextChiffre = 8;
        $couleurRouge = 10;
        $tailleNote = 6;

        foreach ($notes as $note) {
            $this->fpdf->SetX(3);

            $this->fpdf->Cell(
                70,
                $tailleCelleLong,
                utf8_decode(substr($note->matiere->libelle, 0, 38)),
                1,
                0,
                'L'
            );

            // Note

            if ($note->status == 1) {

                //  Pas de note

                $this->fpdf->Cell(10, $tailleCelleLong, '-', 1, 0, 'C');
            } else {

                $this->fpdf->SetFont('Arial', 'B', $tailleTextChiffre);

                if ($note->valeur < $couleurRouge) {

                    $this->fpdf->SetTextColor('237', '28', '36');
                } else {

                    $this->fpdf->SetTextColor('0', '0', '0');
                }



                $this->fpdf->Cell(10, $tailleCelleLong, $note->valeur, 1, 0, 'C');
            }

            $this->fpdf->SetFont('Arial', 'B', $tailleText);

            $this->fpdf->SetTextColor('0', '0', '0');

            //  COEF

            $this->fpdf->Cell(10, $tailleCelleLong, $note->matiere->coef, 1, 0, 'C');

            // Coef * Note trimestre cat 1


            if ($note->status == 1) {

                //  Pas de note
                $this->fpdf->Cell(10, $tailleCelleLong, '-', 1, 0, 'C');
            } else {

                $this->fpdf->SetFont('Arial', 'B', $tailleTextChiffre);

                if ($note->valeur < $couleurRouge) {

                    $this->fpdf->SetTextColor('237', '28', '36');
                } else {

                    $this->fpdf->SetTextColor('0', '0', '0');
                }

                $this->fpdf->Cell(10, $tailleCelleLong, $note->valeur * $note->matiere->coef, 1, 0, 'C');
                $this->fpdf->SetTextColor('0', '0', '0');
            }

            // RANG DES MATIERES CAT 1

            $all  = Notes::where('matiere_id', $note->matiere->id)
                ->where('evaluation_id', $IdEvaluation)
                ->where('classe_id', $IdClasse)
                ->orderBy('valeur', 'desc')->get();

            foreach ($all as $ket => $test) {

                if ($test->id == $note->id) {
                    $rank = $ket;

                    if ($rank + 1 == 1) {
                        $labelRang = 'er';
                    } else {
                        $labelRang =
                            utf8_decode("è");
                    }
                }
            }


            if ($note->status == 1) {

                $this->fpdf->Cell(10, $tailleCelleLong, '-', 1, 0, 'C');
            } else {
                $this->fpdf->Cell(10, $tailleCelleLong, $rank + 1 . $labelRang, 1, 0, 'C');
            }





            // APPRECIATIONS DES MATIERES CAT 1

            if ($note->status == 1) {

                //  Pas de note

                $this->fpdf->SetFont('Arial', 'B', $tailleTextChiffre);

                $this->fpdf->Cell(11, $tailleCelleLong, '-', 1, 0, 'C');
            } else {

                $this->fpdf->SetFont('Arial', 'B', $tailleTextChiffre);

                if ($note->valeur < $couleurRouge) {

                    $this->fpdf->SetTextColor('237', '28', '36');
                } else {

                    $this->fpdf->SetTextColor('0', '0', '0');
                }

                if ($note->valeur >= 0 && $note->valeur < 10) {
                    $note->mention = "NA";
                }

                if ($note->valeur >= 10 && $note->valeur < 15) {
                    $note->mention = "ECA";
                }

                if ($note->valeur >= 15) {
                    $note->mention = "Acquis";
                }

                $this->fpdf->Cell(11, $tailleCelleLong, $note->mention, 1, 0, 'C');
            }



            $this->fpdf->SetTextColor('0', '0', '0');


            $max = Notes::where('evaluation_id', $IdEvaluation)->where('classe_id', $IdClasse)
                ->where('matiere_id', $note->matiere->id)->where('status', null)->max('valeur');


            $this->fpdf->Cell(8, $tailleCelleLong, $max, 1, 0, 'C');



            // MIN NOTE  CAT 1

            $this->fpdf->SetFont('Arial', 'B', $tailleTextChiffre);


            $min = Notes::where('evaluation_id', $IdEvaluation)->where('classe_id', $IdClasse)
                ->where('matiere_id', $note->matiere->id)->where('status', null)->min('valeur');


            $this->fpdf->Cell(8, $tailleCelleLong, $min, 1, 0, 'C');

            //  MOYENNE NOTE MATIERE


            $allMoyMat  = Notes::where('matiere_id', $note->matiere->id)
                ->where('evaluation_id', $IdEvaluation)
                ->where('classe_id', $IdClasse)

                ->where('status', null)
                ->orderBy('valeur', 'desc')->get();

            $num = 0;

            foreach ($allMoyMat as $va) {

                $num = $num + $va->valeur;
            }


            if (count($allMoyMat) == 0) {

                $this->fpdf->Cell(10, $tailleCelleLong, "-", 1, 0, 'C');
            } else {


                $this->fpdf->Cell(10, $tailleCelleLong, number_format($num / count($allMoyMat), 2), 1, 0, 'C');
            }


            $this->fpdf->SetFont('Arial', 'B', $tailleText);

            $this->fpdf->Cell(40, $tailleCelleLong, utf8_decode(substr($note->user->nom . ' ' . $note->user->prenom, 0, 18)), 1, 0, 'L');

            $this->fpdf->Cell(18, $tailleCelleLong, ' ', 1, 0, 'L');


            $this->fpdf->SetFont('Arial', 'B', $tailleText);






            $this->fpdf->Ln($tailleCelleLong);
        }


        // Moy trimestre  du groupe 1

        $sommeNoteCoef = $sommeCoef = 0;

        foreach ($notes as $data) {


            if ($data->status == null) {

                // je ne calcul que les matieres consiedre c'est a dire non justifier , on a les note de 1 a 20 et les notes 0 avec un statut null

                $sommeNoteCoef = $sommeNoteCoef + ($data->valeur * $data->matiere->coef);

                $sommeCoef = $sommeCoef + $data->matiere->coef;
            }
        }


        if ($sommeCoef == 0) {

            $moyenne =  '-';
        } else {

            $moyenne =  number_format($sommeNoteCoef / $sommeCoef, 2);
        }


        $this->fpdf->SetX(3);
        $this->fpdf->SetFont('Arial', 'B', $tailleNote);
        $this->fpdf->Cell(70, 6, utf8_decode($labelGeneraux), 1, 0, 'C', 1);
        $this->fpdf->SetFont('Arial', 'B', $tailleText + 2);
        $this->fpdf->Cell(10, 6,  $moyenne, 1, 0, 'C', 1);
        $this->fpdf->Cell(10, 6, $sommeCoef, 1, 0, 'C', 1);
        $this->fpdf->Cell(10, 6, $sommeNoteCoef, 1, 0, 'C', 1);
        $this->fpdf->Cell(
            105,
            6,
            '',
            1,
            0,
            'C',
            1
        );


        $this->fpdf->SetFont('Arial', 'B', $tailleText);
    }



    function generateNoteReportDataAnnuelTravail($notes, $IdClasse, $labelGeneraux)

    {


        $tailleCelleLong = 5;
        $tailleText = 8;
        $tailleTextChiffre = 8;
        $couleurRouge = 10;
        $tailleNote = 6;

        foreach ($notes as $note) {

            $this->fpdf->SetX(96);

            $this->fpdf->SetFont('Arial', 'B', $tailleTextChiffre);

            if ($note->valeur < $couleurRouge) {

                $this->fpdf->SetTextColor('237', '28', '36');
            } else {

                $this->fpdf->SetTextColor('0', '0', '0');
            }

            $this->fpdf->Cell(10, $tailleCelleLong, $note->valeur, 1, 0, 'C');


            $this->fpdf->SetFont('Arial', 'B', $tailleText);

            $this->fpdf->SetTextColor('0', '0', '0');

            //  COEF

            $this->fpdf->Cell(5, $tailleCelleLong, $note->matiere->coef, 1, 0, 'C');


            $this->fpdf->SetFont('Arial', 'B', $tailleTextChiffre);

            if ($note->valeur < $couleurRouge) {

                $this->fpdf->SetTextColor('237', '28', '36');
            } else {

                $this->fpdf->SetTextColor('0', '0', '0');
            }

            $this->fpdf->Cell(10, $tailleCelleLong, $note->valeur * $note->matiere->coef, 1, 0, 'C');
            $this->fpdf->SetTextColor('0', '0', '0');



            // RANG DES MATIERES CAT 1

            $all  = noteAnnuelle::where('matiere_id', $note->matiere->id)

                ->where('classe_id', $IdClasse)
                ->orderBy('valeur', 'desc')->get();

            foreach ($all as $ket => $test) {

                if ($test->id == $note->id) {
                    $rank = $ket;

                    if ($rank + 1 == 1) {
                        $labelRang = 'er';
                    } else {
                        $labelRang =
                            utf8_decode("è");
                    }
                }
            }

            $this->fpdf->Cell(5, $tailleCelleLong, $rank + 1 . $labelRang, 1, 0, 'C');




            // // APPRECIATIONS DES MATIERES CAT 1


            $this->fpdf->SetFont('Arial', 'B', $tailleTextChiffre);

            if ($note->valeur < $couleurRouge) {

                $this->fpdf->SetTextColor('237', '28', '36');
            } else {

                $this->fpdf->SetTextColor('0', '0', '0');
            }

            if ($note->valeur >= 0 && $note->valeur < 10) {
                $note->mention = "NA";
            }

            if ($note->valeur >= 10 && $note->valeur < 15) {
                $note->mention = "ECA";
            }

            if ($note->valeur >= 15) {
                $note->mention = "Acquis";
            }

            $this->fpdf->Cell(11, $tailleCelleLong, $note->mention, 1, 0, 'C');


            $this->fpdf->SetTextColor('0', '0', '0');


            $max = noteAnnuelle::where('classe_id', $IdClasse)
                ->where('matiere_id', $note->matiere->id)->max('valeur');


            $this->fpdf->Cell(7, $tailleCelleLong, $max, 1, 0, 'C');



            // MIN NOTE  CAT 1

            $this->fpdf->SetFont('Arial', 'B', $tailleTextChiffre);


            $min = noteAnnuelle::where('classe_id', $IdClasse)
                ->where('matiere_id', $note->matiere->id)->min('valeur');


            $this->fpdf->Cell(7, $tailleCelleLong, $min, 1, 0, 'C');

            //  MOYENNE NOTE MATIERE


            $allMoyMat  = noteAnnuelle::where('matiere_id', $note->matiere->id)

                ->where('classe_id', $IdClasse)


                ->orderBy('valeur', 'desc')->get();

            $num = 0;

            foreach ($allMoyMat as $va) {

                $num = $num + $va->valeur;
            }


            if (count($allMoyMat) == 0) {

                $this->fpdf->Cell(8, $tailleCelleLong, "-", 1, 0, 'C');
            } else {


                $this->fpdf->Cell(8, $tailleCelleLong, number_format($num / count($allMoyMat), 2), 1, 0, 'C');
            }


            $this->fpdf->SetFont('Arial', 'B', $tailleText - 1);

            $this->fpdf->Cell(50, $tailleCelleLong, utf8_decode(ucfirst(strtolower(substr($note->user->nom . ' ' . $note->user->prenom, 0, 30)))), 1, 0, 'L');











            $this->fpdf->Ln($tailleCelleLong);
        }


        // Moy trimestre  du groupe 1

        $sommeNoteCoef = $sommeCoef = 0;

        foreach ($notes as $data) {


            if ($data->status == null) {

                // je ne calcul que les matieres consiedre c'est a dire non justifier , on a les note de 1 a 20 et les notes 0 avec un statut null

                $sommeNoteCoef = $sommeNoteCoef + ($data->valeur * $data->matiere->coef);

                $sommeCoef = $sommeCoef + $data->matiere->coef;
            }
        }


        if ($sommeCoef == 0) {

            $moyenne =  '-';
        } else {

            $moyenne =  number_format($sommeNoteCoef / $sommeCoef, 2);
        }


        $this->fpdf->SetX(1);
        $this->fpdf->SetFont('Arial', 'B', $tailleNote + 2);
        $this->fpdf->Cell(95, 6, utf8_decode($labelGeneraux), 1, 0, 'C', 1);
        $this->fpdf->SetFont('Arial', 'B', $tailleText);
        $this->fpdf->Cell(10, 6,  $moyenne, 1, 0, 'C', 1);
        $this->fpdf->Cell(5, 6, $sommeCoef, 1, 0, 'C', 1);
        $this->fpdf->Cell(10, 6, $sommeNoteCoef, 1, 0, 'C', 1);
        $this->fpdf->Cell(
            88,
            6,
            '',
            1,
            0,
            'C',
            1
        );


        $this->fpdf->SetFont('Arial', 'B', $tailleNote + 1);
    }







    public function getAllMoyennes($data, $IdEvaluation, $IdClasse)

    {


        $moyenne = Moyennes::with('matiere', 'student', 'evaluation', 'user')
            ->where('evaluation_id', $IdEvaluation)
            ->where('classe_id', $IdClasse)
            ->where('student_id', $data->student->id)
            ->orderBy('valeur', 'DESC')
            ->get();

        return $moyenne;
    }


    public function getAllMoyennesAll($IdEvaluation, $IdClasse)

    {


        $moyennes = Moyennes::with('student')
            ->where('evaluation_id', $IdEvaluation)
            ->where('classe_id', $IdClasse)
            ->orderBy('valeur', 'DESC')
            ->get();

        return $moyennes;
    }






    public function getMoyennRangStudent($moyennes, $IdClasse, $IdEvaluation, $Idstudent)

    {

        foreach ($moyennes as $key =>  $moyenne) {


            $MoyenneUniqueEleve[$Idstudent] =  $moyenne->valeur;
        }

        foreach ($moyennes as $key => $moyenne) {

            if ($moyenne->student_id == $Idstudent) {

                $rankEval[$Idstudent] = $key + 1;
            }
        }

        return $MoyenneUniqueEleve[$Idstudent] . "*" . $rankEval[$Idstudent];
    }


    public function getAllBulletinExamTrimestre($id)

    {



        $conf = config::first();

        $entete = $conf->header;


        // IdEvalauation = IdTrimestre (normalement)

        $data =  explode('*', $id);
        $IdClasse = $data[0];
        $IdTrimmestre  = $data[1];

        $sommeNoteCoef1 = $sommeNoteCoef2 = $sommeNoteCoef3 = 0;

        $sommeCoef1 = $sommeCoef2 = $sommeCoef3 = 0;

        $couleurRouge = 10;

        // Je trouve le codeEtab et la session

        $code = Classe::where('id', $IdClasse)->first();
        $codeEtab = $code->codeEtabClasse;
        $session = $code->sessionClasse;

        // Recuperons les id des evaluations correspondant au trimestre dont on a l'id en haut

        $Evalutions = Evaluations::with('trimestre')->where('trimestre_id', $IdTrimmestre)->where('session', $session)
            ->where('codeEtab', $codeEtab)->get();



        $idEval1 = $Evalutions[0]->id;
        $libelleEval1 = $Evalutions[0]->libelle;

        $idEval2 = $Evalutions[1]->id;
        $libelleEval2 = $Evalutions[1]->libelle;

        $libelleTrimestre = $Evalutions[0]->trimestre->libelle_semes;

        $classeName = Etablissement::where('codeEtab', $codeEtab)->first();

        $rest = Classe::where('id', $IdClasse)->first();

        $teach = Enseignants::where('id', $rest->principale_Classe)->first();


        // Tous les eleves


        $classeData = Student::with('user', 'classe')->where('classe_id', $IdClasse)
            ->where('statut', "!=", 3)
            ->where('session', $session)->where('codeEtab', $codeEtab)->get();

        $NombreAdmis = count(MoyenneTrimestres::where('trimestre_id',  $IdTrimmestre)->where('classe_id', $IdClasse)->where('valeur', '>=', 10)->get());


        $moyData =   MoyenneTrimestres::with('student')->where('session', $session)
            ->where('codeEtab', $codeEtab)->where('trimestre_id',  $IdTrimmestre)->where('classe_id', $IdClasse)->where('valeur', '>=', 0)
            ->orderBy('valeur', 'DESC')->get();



        // Nombre deleves  dans cette classe


        $effectif = Student::where('classe_id', $IdClasse)->where('session', $session)
            ->where('codeEtab', $codeEtab)
            ->where('statut', "!=", 3)
            ->count();

        //  $effectif = count($moyData);


        // Nombre deleves ayant une moyenne dans cette classe dans le trimestre


        $nombreEleves =  MoyenneTrimestres::where('trimestre_id',  $IdTrimmestre)->where('classe_id', $IdClasse)->where('valeur', '>', 0)
            ->where('session', $session)->where('codeEtab', $codeEtab)->count();



        // Mpyenne gen de la classe



        $moyenneSommeClasse =  MoyenneTrimestres::where('trimestre_id',  $IdTrimmestre)->where('classe_id', $IdClasse)
            ->where('session', $session)->where('codeEtab', $codeEtab)->sum('valeur');







        // dump($moyData);


        // Je recupere les notes de sequence 1


        $noteData1 =   Notes::where('evaluation_id', $idEval1)->where('classe_id', $IdClasse)


            ->where('session', $session)->where('codeEtab', $codeEtab)->get();


        // Moyenne du dernier

        $MoyDernier = MoyenneTrimestres::where('trimestre_id',  $IdTrimmestre)->where('valeur', '>', 0)->where('classe_id', $IdClasse)->min('valeur');


        // // Moyenne du premier

        $MoyPremier = MoyenneTrimestres::where('trimestre_id', $IdTrimmestre)->where('valeur', '>=', 0)->where('classe_id', $IdClasse)->max('valeur');


        foreach ($moyData   as $ley => $data) {



            if ($ley == 0) {

                $e = 'er';
            } else {

                $e = utf8_decode('è');
            }


            $this->fpdf->AddPage("P", ['290', '210']); // 315


            // categorie 1


            // note devoir1 de la cat1


            $Note[$data->student->id] = Notes::with('matiere', 'student', 'evaluation', 'user')
                ->where('evaluation_id', $idEval1)
                ->where('classe_id', $IdClasse)
                ->where('cat_id', 1)
                ->where('student_id', $data->student->id)
                ->where('codeEtab', $codeEtab)
                ->where('session', $session)->orderBy('matiere_id')->get();


            // note devoir2 de la cat1

            $Note2[$data->student->id] = Notes::with('matiere', 'student', 'evaluation', 'user')
                ->where('evaluation_id', $idEval2)
                ->where('classe_id', $IdClasse)
                ->where('cat_id', 1)
                ->where('student_id', $data->student->id)
                ->where('codeEtab', $codeEtab)
                ->where('session', $session)->orderBy('matiere_id')->get();


            // note trimestre  de la cat1

            $NoteTrimestre[$data->student->id] = NotesTrimestres::with('matiere', 'student', 'evaluation', 'user')
                ->where('trimestre_id', $IdTrimmestre)
                ->where('classe_id', $IdClasse)
                ->where('cat_id', 1)
                ->where('student_id', $data->student->id)
                ->where('codeEtab', $codeEtab)
                ->where('session', $session)->get();

            $NoteTrimestre3[$data->student->id] = NotesTrimestres::with('matiere', 'student', 'evaluation', 'user')
                ->where('trimestre_id', $IdTrimmestre)
                ->where('classe_id', $IdClasse)
                ->where('cat_id', 3)
                ->where('student_id', $data->student->id)
                ->where('codeEtab', $codeEtab)
                ->where('session', $session)->get();

            $val  = NotesTrimestres::with('matiere', 'student', 'evaluation', 'user')
                ->where('trimestre_id', $IdTrimmestre)
                ->where('classe_id', $IdClasse)
                ->where('cat_id', 1)
                ->where('student_id', $data->student->id)
                ->where('codeEtab', $codeEtab)
                ->where('session', $session)->count();


            $val3  = NotesTrimestres::with('matiere', 'student', 'evaluation', 'user')
                ->where('trimestre_id', $IdTrimmestre)
                ->where('classe_id', $IdClasse)
                ->where('cat_id', 2)
                ->where('student_id', $data->student->id)
                ->where('codeEtab', $codeEtab)
                ->where('session', $session)->count();


            $val4  = NotesTrimestres::with('matiere', 'student', 'evaluation', 'user')
                ->where('trimestre_id', $IdTrimmestre)
                ->where('classe_id', $IdClasse)
                ->where('cat_id', 3)
                ->where('student_id', $data->student->id)
                ->where('codeEtab', $codeEtab)
                ->where('session', $session)->count();


            $heureTrimestre  = Presences::where('classe_id', $IdClasse)
                ->where('trimestre_id', $IdTrimmestre)->where('student_id', $data->student->id)
                ->where('codeEtab', $codeEtab)
                ->where('session', $session)->sum('duree');


            // Absences  justifies

            $heureTrimestreJustifies = Presences::where('classe_id', $IdClasse)
                ->where('trimestre_id', $IdTrimmestre)->where('student_id', $data->student->id)
                ->where('codeEtab', $codeEtab)
                ->where('session', $session)->sum('etat');


            // Je cherche les consigne et les jour d'exusion du trimestre

            $heureConsigneTrimestre  = discipline::where('classe_id', $IdClasse)
                ->where('mois_id', $IdTrimmestre)->where('student_id', $data->student->id)->where('type', 'con')
                ->where('codeEtab', $codeEtab)
                ->where('session', $session)->sum('duree');


            $ExclusionTrimestre  = discipline::where('classe_id', $IdClasse)
                ->where('mois_id', $IdTrimmestre)->where('student_id', $data->student->id)->where('type', 'ex')
                ->where('codeEtab', $codeEtab)
                ->where('session', $session)->sum('duree');







            // categorie 2


            // Note devoir 1 de la cat 2


            $Notecat2[$data->student->id] = Notes::with('matiere', 'student', 'evaluation', 'user')
                ->where('evaluation_id', $idEval1)
                ->where('classe_id', $IdClasse)
                ->where('cat_id', 2)
                ->where('student_id', $data->student->id)
                ->where('codeEtab', $codeEtab)
                ->where('session', $session)->orderBy('matiere_id')->get();


            // Note devoir 2 de la cat 2

            $Note2cat2[$data->student->id] = Notes::with('matiere', 'student', 'evaluation', 'user')
                ->where('evaluation_id', $idEval2)
                ->where('classe_id', $IdClasse)
                ->where('cat_id', 2)
                ->where('student_id', $data->student->id)
                ->where('codeEtab', $codeEtab)
                ->where('session', $session)->orderBy('matiere_id')->get();


            // Note trimestre  de la cat 2

            $NoteTrimestrecat2[$data->student->id] = NotesTrimestres::with('matiere', 'student', 'evaluation', 'user')
                ->where('trimestre_id', $IdTrimmestre)
                ->where('classe_id', $IdClasse)
                ->where('cat_id', 2)
                ->where('student_id', $data->student->id)
                ->where('codeEtab', $codeEtab)
                ->where('session', $session)->get();


            // dump( $NoteTrimestrecat2[$data->student->id]);





            // Note trimestre  de la cat 2 ( meme role que la requette du haut )


            $NoteTrimestre2[$data->student->id] = NotesTrimestres::with('matiere', 'student', 'evaluation', 'user')
                ->where('trimestre_id', $IdTrimmestre)
                ->where('classe_id', $IdClasse)
                ->where('cat_id', 2)
                ->where('student_id', $data->student->id)
                ->where('codeEtab', $codeEtab)
                ->where('session', $session)->get();


            // categorie 3


            // Note devoir 1 de la cat 3


            $Notecat3[$data->student->id] = Notes::with('matiere', 'student', 'evaluation', 'user')
                ->where('evaluation_id', $idEval1)
                ->where('classe_id', $IdClasse)
                ->where('cat_id', 3)
                ->where('student_id', $data->student->id)
                ->where('codeEtab', $codeEtab)
                ->where('session', $session)->orderBy('matiere_id')->get();

            // Note devoir 2 de la cat 3

            $Note2cat3[$data->student->id] = Notes::with('matiere', 'student', 'evaluation', 'user')
                ->where('evaluation_id', $idEval2)
                ->where('classe_id', $IdClasse)
                ->where('cat_id', 3)
                ->where('student_id', $data->student->id)
                ->where('codeEtab', $codeEtab)
                ->where('session', $session)->orderBy('matiere_id')->get();

            // Note trimestre  de la cat 3

            $NoteTrimestrecat3[$data->student->id] = NotesTrimestres::with('matiere', 'student', 'evaluation', 'user')
                ->where('trimestre_id', $IdTrimmestre)
                ->where('classe_id', $IdClasse)
                ->where('cat_id', 3)
                ->where('student_id', $data->student->id)
                ->where('codeEtab', $codeEtab)
                ->where('session', $session)->get();


            // je recupere les photo des eleves dans user

            // je recupere les photo des eleves dans user

            $EleveData[$data->student->id] = Student::with('user')->where('id', $data->student->id)->get();


            //$this->fpdf->SetXY(20,115);


            // $this->fpdf->Image(public_path("/Photos/Logos/" . $entete), 5, 6, 200, 35, "");


            $this->fpdf->Image(public_path("/Photos/Logos/" . $entete), 8, 2, 190, 33, "");




            //$this->fpdf->Image(public_path("/Photos/Logos/footer.jpeg"), 0, 280, 210, 18, "JPG", "");


            $tailleNote = 6;
            $libelle = 7;
            // Informations de l'eleve

            $this->fpdf->SetFont('Arial', 'B', 7);
            $this->fpdf->Text(105, 58, 'Matricule : ');
            $this->fpdf->SetFont('Arial', 'B', 7);
            $this->fpdf->Text(137, 58, $Note[$data->student->id][0]->student->matricule);



            $this->fpdf->SetFont('Arial', 'B', 7);
            $this->fpdf->Text(105, 63, utf8_decode('Noms et prénoms :  '));
            $this->fpdf->SetFont('Arial', 'B', 7);
            $this->fpdf->Text(137, 63, utf8_decode($Note[$data->student->id][0]->student->nom . ' ' . $Note[$data->student->id][0]->student->prenom));

            $this->fpdf->SetFont('Arial', 'B', 7);
            $this->fpdf->Text(105, 68, utf8_decode('Née le : '));
            $this->fpdf->SetFont('Arial', 'B', 7);
            $this->fpdf->Text(137, 68, utf8_decode(date_format(date_create($Note[$data->student->id][0]->student->dateNaiss), "d /m/ Y")));
            $this->fpdf->SetFont('Arial', 'B', 7);

            $this->fpdf->Text(105, 72, 'Sexe  : ');
            $this->fpdf->SetFont('Arial', 'B', 7);
            $this->fpdf->Text(137, 72, $data->student->sexe . '                , ');
            $this->fpdf->SetFont('Arial', 'B', 7);

            $this->fpdf->Text(155, 72, 'Redoublant    : ');
            $this->fpdf->SetFont('Arial', 'B', 7);
            if ($data->student->doublant == "REDOUBLANT") {
                $this->fpdf->Text(
                    175,
                    72,
                    "Oui"
                );
            } else {

                $this->fpdf->Text(
                    175,
                    72,
                    "Non"
                );
            }

            $this->fpdf->SetFont('Arial', 'B', 7);


            // // deuxiemme


            $this->fpdf->Text(37, 58, utf8_decode('Année-Scolaire  : '));
            $this->fpdf->SetFont('Arial', 'B', 7);
            $this->fpdf->Text(59, 58, utf8_decode($session));
            $this->fpdf->SetFont('Arial', 'B', 7);


            $this->fpdf->Text(37, 63, 'Classe  : ');
            $this->fpdf->SetFont('Arial', 'B', 7);
            $this->fpdf->Text(59, 63, utf8_decode($Note[$data->student->id][0]->Classe->libelleClasse));
            $this->fpdf->SetFont('Arial', 'B', 7);

            $this->fpdf->Text(37, 67, 'Effectif  :  ');
            $this->fpdf->SetFont('Arial', 'B', 7);
            $this->fpdf->Text(59, 67, $effectif);
            $this->fpdf->SetFont('Arial', 'B', 7);


            $this->fpdf->Text(37, 71, 'Prof Principal  :');
            $this->fpdf->SetFont('Arial', 'B', 6);


            $this->fpdf->Text(59, 71, substr(
                utf8_decode($teach->nom . ' ' . $teach->prenom,),
                0,
                42
            ));


            if (file_exists(public_path("/Photos/Logos/" . $EleveData[$data->student->id][0]->user->photo))) {


                $this->fpdf->Image(public_path("/Photos/Logos/" . $EleveData[$data->student->id][0]->user->photo), 6, 50, 25, 27,  "");
            }




            if (!file_exists(public_path("/Photos/Qrcodes/Qrcode" . $data->student->id . ".png"))) {




                // QrCode::format('png')->size(299)->color(40, 40, 40)
                //     ->generate(
                //         $data->student->nom . " " .
                //             $data->student->prenom . ',' .
                //             utf8_decode(date_format(date_create($data->student->dateNaiss), "d /m/ Y"))
                //             . "," .
                //             $data->student->lieuNaiss . "," .
                //             $libelleTrimestre . ":" .
                //             $data->valeur . '/20',
                //         public_path("/Photos/Qrcodes/Qrcode" . $data->student->id . ".png")
                //     );

                $dataToEncode = mb_convert_encoding(
                    $data->student->nom . " " .
                        $data->student->prenom . ',' .
                        utf8_decode(date_format(date_create($data->student->dateNaiss), "d /m/ Y")) . "," .
                        $data->student->lieuNaiss . "," .
                        $libelleTrimestre . ":" .
                        $data->valeur . '/20',
                    'utf-8',
                    // Specify the original encoding of the data here
                );

                QrCode::format('png')
                    ->size(299)
                    ->color(40, 40, 40)
                    ->encoding('utf-8') // Only needed if using option 1
                    ->generate($dataToEncode, public_path("/Photos/Qrcodes/Qrcode" . $data->student->id . ".png"));
            }


            $this->fpdf->Image(public_path("/Photos/Qrcodes/Qrcode" . $data->student->id . ".png"), 190, 265, 15, 15, "");








            //     // // Cadre information eleve



            // $this->fpdf->SetXY(3, 52);
            // $this->fpdf->Cell(32, 24, '', 1);

            $this->fpdf->SetXY(35, 50);
            $this->fpdf->Cell(23, 27, '', 1);


            $this->fpdf->SetXY(58, 50);
            $this->fpdf->Cell(45, 27, '', 1);


            $this->fpdf->SetXY(103, 50);
            $this->fpdf->Cell(33, 27, '', 1);


            $this->fpdf->SetXY(136, 50);
            $this->fpdf->Cell(71, 27, '', 1);




            // Cadre pour le titre du trimestre

            // $this->fpdf->SetFillColor('130', '130', '130');
            $this->fpdf->SetFont('Arial', 'B', 10);
            $this->fpdf->SetXY(71, 39);
            $this->fpdf->Cell(70, 8, 'BULLETIN DE NOTES ' . '' . strtoupper($libelleTrimestre), 1, 0, 'C', 0);






            // $this->fpdf->SetXY(50,39);
            // $this->fpdf->Cell(100,10,'',1);

            $this->fpdf->SetFont('Arial', 'B', $tailleNote + 1);
            $this->fpdf->SetTextColor(0, 0, 0);
            // Tire cadre a cote
            // $this->fpdf->Text(135, 72, strtoupper($classeName->libelleEtab));

            $this->fpdf->SetXY(3, 80);
            // $this->fpdf->SetFont('Arial', 'B', 7);
            $this->fpdf->SetDrawColor(0, 0, 0);
            // $this->fpdf->SetFillColor('61', '169', '209');
            $this->fpdf->SetFillColor('111', '111', '111');
            $this->fpdf->Cell(60, 7, utf8_decode('MATIERES'), 1, 0, 'C', 1);
            $this->fpdf->Cell(10, 7, "DEV " . ($idEval1 - 1), 1, 0, 'C', 1);
            $this->fpdf->Cell(10, 7, "DEV " . ($idEval2 - 1), 1, 0, 'C', 1);
            $this->fpdf->SetFont('Arial', 'B', $tailleNote);


            $this->fpdf->Cell(40, 4, '                   ' . strtoupper($libelleTrimestre), 1, 0, 'L', 1);

            $this->fpdf->SetFont('Arial', 'B', $tailleNote + 1);

            $this->fpdf->SetXY(83, 84);

            $this->fpdf->Cell(10, 3, 'Notes', 1, 0, 'C', 1);
            $this->fpdf->Cell(10, 3, 'Coef', 1, 0, 'C', 1);
            $this->fpdf->Cell(10, 3, 'N*C', 1, 0, 'C', 1);
            $this->fpdf->Cell(10, 3, 'Rang', 1, 0, 'C', 1);
            $this->fpdf->SetXY(123, 80);
            $this->fpdf->Cell(11, 7, 'Appre', 1, 0, 'C', 1);
            $this->fpdf->Cell(8, 7, 'Max', 1, 0, 'C', 1);
            $this->fpdf->Cell(8, 7, 'Min', 1, 0, 'C', 1);
            $this->fpdf->Cell(10, 7, 'Moy', 1, 0, 'C', 1);
            $this->fpdf->Cell(30, 7, 'Professeurs', 1, 0, 'C', 1);
            $this->fpdf->Cell(18, 7, 'VISA', 1, 0, 'C', 1);

            $this->fpdf->Ln();
            $this->fpdf->SetX(20);


            // Pour la note seq1

            $tailleCelleLong = 5;
            $tailleText = 7;
            $tailleTextChiffre = 8;

            $this->fpdf->SetFont('Arial', 'B', $tailleText);


            // Moyenne devoir 1


            $MoyenneDevoir1[$data->student->id] = Moyennes::where('evaluation_id', $idEval1)
                ->where('classe_id', $IdClasse)
                ->where('student_id', $data->student->id)
                ->where('codeEtab', $codeEtab)
                ->where('session', $session)->first();


            // Moyenne devoir 2


            $MoyenneDevoir2[$data->student->id] = Moyennes::where('evaluation_id', $idEval2)
                ->where('classe_id', $IdClasse)
                ->where('student_id', $data->student->id)
                ->where('codeEtab', $codeEtab)
                ->where('session', $session)->first();


            // Boucles des matieres de  cat 1 Ev1


            foreach ($Note[$data->student->id] as $note) {

                $this->fpdf->SetX(3);


                // Matiere

                $this->fpdf->Cell(
                    60,
                    $tailleCelleLong,
                    utf8_decode(substr($note->matiere->libelle, 0, 38)),
                    1,
                    0,
                    'L'
                );


                // Note Ev2

                if ($note->status == 1) {

                    //  Pas de note

                    $this->fpdf->Cell(10, $tailleCelleLong, '-', 1, 0, 'C');
                } else {

                    $this->fpdf->SetFont('Arial', 'B', $tailleTextChiffre);

                    if ($note->valeur < $couleurRouge) {

                        $this->fpdf->SetTextColor('237', '28', '36');
                    } else {

                        $this->fpdf->SetTextColor('0', '0', '0');
                    }



                    $this->fpdf->Cell(10, $tailleCelleLong, $note->valeur, 1, 0, 'C');
                }

                $this->fpdf->SetFont('Arial', 'B', $tailleText);



                $this->fpdf->Ln($tailleCelleLong);


                $this->fpdf->SetTextColor('0', '0', '0');
            }


            // Boucles des notes de la cat 1 Ev2

            $this->fpdf->SetY(87);  // c'est 84 qui vient de setxy(x,89) + 7 la taille des entete . ca nous place net dans le contenu du bulletin


            foreach ($Note2[$data->student->id] as $note) {

                $this->fpdf->SetX(3 + 60 + 10);


                // Note Ev2

                if ($note->status == 1) {

                    //  Pas de note

                    $this->fpdf->Cell(10, $tailleCelleLong, '-', 1, 0, 'C');
                } else {

                    $this->fpdf->SetFont('Arial', 'B', $tailleTextChiffre);

                    if ($note->valeur < $couleurRouge) {

                        $this->fpdf->SetTextColor('237', '28', '36');
                    } else {

                        $this->fpdf->SetTextColor('0', '0', '0');
                    }



                    $this->fpdf->Cell(10, $tailleCelleLong, $note->valeur, 1, 0, 'C');
                }

                $this->fpdf->SetFont('Arial', 'B', $tailleText);



                $this->fpdf->Ln($tailleCelleLong);


                $this->fpdf->SetTextColor('0', '0', '0');
            }


            // Boucles des notes TRIMETRE de la cat 1

            $this->fpdf->SetY(87);



            foreach ($NoteTrimestre[$data->student->id] as $note) {

                $this->fpdf->SetX(3 + 60 + 10 + 10);


                // Note TRIMESTRE CAT1

                if ($note->status == 1) {

                    //  Pas de note

                    $this->fpdf->Cell(10, $tailleCelleLong, '-', 1, 0, 'C');
                } else {

                    $this->fpdf->SetFont('Arial', 'B', $tailleTextChiffre);

                    if ($note->valeur < $couleurRouge) {

                        $this->fpdf->SetTextColor('237', '28', '36');
                    } else {

                        $this->fpdf->SetTextColor('0', '0', '0');
                    }



                    $this->fpdf->Cell(10, $tailleCelleLong, $note->valeur, 1, 0, 'C');
                }


                $this->fpdf->SetTextColor('0', '0', '0');

                // Coef Trimestre cat 1

                $this->fpdf->Cell(10, $tailleCelleLong, $note->matiere->coef, 1, 0, 'C');


                // Coef * Note trimestre cat 1

                if ($note->status == 1) {

                    //  Pas de note

                    $this->fpdf->Cell(
                        10,
                        $tailleCelleLong,
                        '-',
                        1,
                        0,
                        'C'
                    );
                } else {

                    $this->fpdf->SetFont('Arial', 'B', $tailleTextChiffre);

                    if ($note->valeur < $couleurRouge) {

                        $this->fpdf->SetTextColor('237', '28', '36');
                    } else {

                        $this->fpdf->SetTextColor('0', '0', '0');
                    }

                    $this->fpdf->Cell(10, $tailleCelleLong, $note->valeur * $note->matiere->coef, 1, 0, 'C');
                    $this->fpdf->SetTextColor('0', '0', '0');
                }


                // RANG DES MATIERES CAT 1

                $all  = NotesTrimestres::where('matiere_id', $note->matiere->id)
                    ->where('trimestre_id', $IdTrimmestre)
                    ->where('classe_id', $IdClasse)
                    ->where('codeEtab', $codeEtab)
                    ->where('session', $session)
                    ->orderBy('valeur', 'desc')->get();




                foreach ($all as $ket => $test) {

                    if ($test->id == $note->id) {
                        $rank = $ket;

                        if ($rank + 1 == 1) {
                            $labelRang = 'er';
                        } else {
                            $labelRang =
                                utf8_decode("è");
                        }
                    }
                }


                if ($note->status == 1) {

                    $this->fpdf->Cell(10, $tailleCelleLong, '-', 1, 'C');
                } else {
                    $this->fpdf->Cell(10, $tailleCelleLong, $rank + 1 . $labelRang, 1, 0, 'C');
                }

                // APPRECIATIONS DES MATIERES CAT 1

                if ($note->status == 1) {

                    //  Pas de note

                    $this->fpdf->SetFont('Arial', 'B', $tailleTextChiffre);

                    $this->fpdf->Cell(11, $tailleCelleLong, '-', 1, 0, 'C');
                } else {

                    $this->fpdf->SetFont('Arial', 'B', $tailleTextChiffre);

                    if ($note->valeur < $couleurRouge) {

                        $this->fpdf->SetTextColor('237', '28', '36');
                    } else {

                        $this->fpdf->SetTextColor('0', '0', '0');
                    }

                    if ($note->valeur >= 0 && $note->valeur < 10) {
                        $note->mention = "NA";
                    }

                    if ($note->valeur >= 10 && $note->valeur < 15) {
                        $note->mention = "ECA";
                    }

                    if ($note->valeur >= 15) {
                        $note->mention = "Acquis";
                    }

                    $this->fpdf->Cell(11, $tailleCelleLong, $note->mention, 1, 0, 'C');
                }


                // MAX NOTE  CAT 1

                $this->fpdf->SetFont('Arial', 'B', $tailleTextChiffre);
                $this->fpdf->SetTextColor('0', '0', '0');


                $max = NotesTrimestres::where('trimestre_id', $IdTrimmestre)->where('classe_id', $IdClasse)
                    ->where('matiere_id', $note->matiere->id)->where('status', null)->max('valeur');


                $this->fpdf->Cell(8, $tailleCelleLong, $max, 1, 0, 'C');



                // MIN NOTE  CAT 1

                $this->fpdf->SetFont('Arial', 'B', $tailleTextChiffre);


                $min = NotesTrimestres::where('trimestre_id', $IdTrimmestre)->where('classe_id', $IdClasse)
                    ->where('matiere_id', $note->matiere->id)->where('status', null)->min('valeur');


                $this->fpdf->Cell(8, $tailleCelleLong, $min, 1, 0, 'C');



                $allMoyMat  = NotesTrimestres::where('matiere_id', $note->matiere->id)
                    ->where('trimestre_id', $IdTrimmestre)
                    ->where('classe_id', $IdClasse)
                    ->where('codeEtab', $codeEtab)
                    ->where('session', $session)
                    ->where('status', null)
                    ->orderBy('valeur', 'desc')->get();

                $num = 0;

                foreach ($allMoyMat as $va) {

                    $num = $num + $va->valeur;
                }






                if (count($allMoyMat) == 0) {

                    $this->fpdf->Cell(10, $tailleCelleLong, "-", 1, 0, 'C');
                } else {


                    $this->fpdf->Cell(10, $tailleCelleLong, number_format($num / count($allMoyMat), 2), 1, 0, 'C');
                }



                $this->fpdf->SetFont('Arial', 'B', $tailleText);

                $this->fpdf->Cell(30, $tailleCelleLong, utf8_decode(substr($note->user->nom . ' ' . $note->user->prenom, 0, 18)), 1, 0, 'L');

                $this->fpdf->Cell(18, $tailleCelleLong, ' ', 1, 0, 'L');


                $this->fpdf->SetFont('Arial', 'B', $tailleText);
                $this->fpdf->Ln($tailleCelleLong);
            }




            // Moy trimestre  du groupe 1

            $sommeNoteCoef1 = $sommeCoef1 = 0;

            foreach ($NoteTrimestre[$data->student->id] as $data2) {


                if ($data2->status == null) {

                    // je ne calcul que les matieres consiedre c'est a dire non justifier , on a les note de 1 a 20 et les notes 0 avec un statut null

                    $sommeNoteCoef1 = $sommeNoteCoef1 + ($data2->valeur * $data2->matiere->coef);

                    $sommeCoef1 = $sommeCoef1 + $data2->matiere->coef;
                }
            }


            if ($sommeCoef1 == 0) {

                $moyenne1[$data->student->id] =  '-';
            } else {

                $moyenne1[$data->student->id] =  number_format($sommeNoteCoef1 / $sommeCoef1, 2);
            }






            // Moyenne cat1 du devoir 1


            $sommeNoteCoefD1cat1 = 0;

            $sommeCoef1D1 = 0;


            foreach ($Note[$data->student->id] as $data1) {


                if ($data1->status == null) {

                    $sommeNoteCoefD1cat1 = $sommeNoteCoefD1cat1 + ($data1->valeur * $data1->matiere->coef);

                    $sommeCoef1D1 = $sommeCoef1D1 + $data1->matiere->coef;
                }
            }


            if ($sommeCoef1D1 == 0) {

                $moyenneD1Cat1[$data->student->id] =  '-';
            } else {

                $moyenneD1Cat1[$data->student->id] =  number_format($sommeNoteCoefD1cat1 / $sommeCoef1D1, 2);
            }



            // Moyenne  devoir 2 de la cat1


            $sommeNoteCoefD2cat1 = 0;

            $sommeCoef2D2 = 0;


            foreach ($Note2[$data->student->id] as $data1) {



                if ($data1->status == null) {

                    $sommeNoteCoefD2cat1 = $sommeNoteCoefD2cat1 + ($data1->valeur * $data1->matiere->coef);

                    $sommeCoef2D2 = $sommeCoef2D2 + $data1->matiere->coef;
                }
            }


            if ($sommeCoef2D2 == 0) {

                $moyenneD2Cat1[$data->student->id] =  '-';
            } else {

                $moyenneD2Cat1[$data->student->id] =  number_format($sommeNoteCoefD2cat1 / $sommeCoef2D2, 2);
            }




            $this->fpdf->SetX(3);
            $this->fpdf->SetFont('Arial', 'B', $tailleNote);
            $this->fpdf->Cell(60, 6, utf8_decode('MODULE DES ENSEIGNEMENTS GENERAUX'), 1, 0, 'C', 1);

            $this->fpdf->SetFont('Arial', 'B', $tailleText + 2);
            $this->fpdf->Cell(10, 6,  $moyenneD1Cat1[$data->student->id], 1, 0, 'C', 1);
            $this->fpdf->Cell(10, 6, $moyenneD2Cat1[$data->student->id], 1, 0, 'C', 1);
            $this->fpdf->Cell(10, 6,  $moyenne1[$data->student->id], 1, 0, 'C', 1);
            $this->fpdf->Cell(10, 6, $sommeCoef1, 1, 0, 'C', 1);
            $this->fpdf->Cell(10, 6, $sommeNoteCoef1, 1, 0, 'C', 1);
            $this->fpdf->Cell(95, 6, '', 1, 0, 'C', 1);

            $this->fpdf->Ln();



            // // /*   ******************************************* PARTIE DU BULLETIN DE LA CATEGORIE 2 *************************************************************/





            // Note Ev1 de cat 2 et libelle matiere cat 2

            $this->fpdf->SetFont('Arial', 'B', $tailleText);



            foreach ($Notecat2[$data->student->id] as $note) {

                $this->fpdf->SetX(3);


                // Matiere

                $this->fpdf->Cell(
                    60,
                    $tailleCelleLong,
                    utf8_decode(substr($note->matiere->libelle, 0, 39)),
                    1,
                    0,
                    'L'
                );


                // Note Ev1

                if ($note->status == 1) {

                    //  Pas de note

                    $this->fpdf->Cell(10, $tailleCelleLong, '-', 1, 0, 'C');
                } else {

                    $this->fpdf->SetFont('Arial', 'B', $tailleTextChiffre);

                    if ($note->valeur < $couleurRouge) {

                        $this->fpdf->SetTextColor('237', '28', '36');
                    } else {

                        $this->fpdf->SetTextColor('0', '0', '0');
                    }



                    $this->fpdf->Cell(10, $tailleCelleLong, $note->valeur, 1, 0, 'C');
                }

                $this->fpdf->SetFont('Arial', 'B', $tailleText);



                $this->fpdf->Ln($tailleCelleLong);


                $this->fpdf->SetTextColor('0', '0', '0');
            }


            // Note Ev 2 de cat 2


            $this->fpdf->Ln(-$tailleCelleLong * $val3);

            foreach ($Note2cat2[$data->student->id] as $note) {

                $this->fpdf->SetX(3 + 60 + 10);


                // Note Ev2

                if ($note->status == 1) {

                    //  Pas de note

                    $this->fpdf->Cell(10, $tailleCelleLong, '-', 1, 0, 'C');
                } else {

                    $this->fpdf->SetFont('Arial', 'B', $tailleTextChiffre);

                    if ($note->valeur < $couleurRouge) {

                        $this->fpdf->SetTextColor('237', '28', '36');
                    } else {

                        $this->fpdf->SetTextColor('0', '0', '0');
                    }



                    $this->fpdf->Cell(10, $tailleCelleLong, $note->valeur, 1, 0, 'C');
                }

                $this->fpdf->SetFont('Arial', 'B', $tailleText);



                $this->fpdf->Ln($tailleCelleLong);


                $this->fpdf->SetTextColor('0', '0', '0');
            }


            $this->fpdf->SetTextColor('0', '0', '0');


            $this->fpdf->Ln(-$tailleCelleLong * $val3);

            // Note TRIMESTRE CAT2

            foreach ($NoteTrimestrecat2[$data->student->id] as $note) {

                $this->fpdf->SetX(3 + 60 + 10 + 10);




                if ($note->status == 1) {

                    //  Pas de note

                    $this->fpdf->Cell(10, $tailleCelleLong, '-', 1, 0, 'C');
                } else {

                    $this->fpdf->SetFont('Arial', 'B', $tailleTextChiffre);

                    if ($note->valeur < $couleurRouge) {

                        $this->fpdf->SetTextColor('237', '28', '36');
                    } else {

                        $this->fpdf->SetTextColor('0', '0', '0');
                    }



                    $this->fpdf->Cell(10, $tailleCelleLong, $note->valeur, 1, 0, 'C');
                }


                $this->fpdf->SetTextColor('0', '0', '0');

                // Coef Trimestre cat 1

                $this->fpdf->Cell(10, $tailleCelleLong, $note->matiere->coef, 1, 0, 'C');


                // Coef * Note trimestre cat 1

                if ($note->status == 1) {

                    //  Pas de note

                    $this->fpdf->Cell(
                        10,
                        $tailleCelleLong,
                        '-',
                        1,
                        0,
                        'C'
                    );
                } else {

                    $this->fpdf->SetFont('Arial', 'B', $tailleTextChiffre);

                    if ($note->valeur < $couleurRouge) {

                        $this->fpdf->SetTextColor('237', '28', '36');
                    } else {

                        $this->fpdf->SetTextColor('0', '0', '0');
                    }

                    $this->fpdf->Cell(10, $tailleCelleLong, $note->valeur * $note->matiere->coef, 1, 0, 'C');
                    $this->fpdf->SetTextColor('0', '0', '0');
                }


                // RANG DES MATIERES CAT 1

                $all  = NotesTrimestres::where('matiere_id', $note->matiere->id)
                    ->where('trimestre_id', $IdTrimmestre)
                    ->where('classe_id', $IdClasse)
                    ->where('codeEtab', $codeEtab)
                    ->where('session', $session)
                    ->orderBy('valeur', 'desc')->get();




                foreach ($all as $ket => $test) {

                    if ($test->id == $note->id) {
                        $rank = $ket;

                        if ($rank + 1 == 1) {
                            $labelRang = 'er';
                        } else {
                            $labelRang =
                                utf8_decode("è");
                        }
                    }
                }


                if ($note->status == 1) {

                    $this->fpdf->Cell(10, $tailleCelleLong, '-', 1, 'C');
                } else {
                    $this->fpdf->Cell(10, $tailleCelleLong, $rank + 1 . $labelRang, 1, 0, 'C');
                }

                // APPRECIATIONS DES MATIERES CAT 1

                if ($note->status == 1) {

                    //  Pas de note

                    $this->fpdf->SetFont('Arial', 'B', $tailleTextChiffre);

                    $this->fpdf->Cell(11, $tailleCelleLong, '-', 1, 0, 'C');
                } else {

                    $this->fpdf->SetFont('Arial', 'B', $tailleTextChiffre);

                    if ($note->valeur < $couleurRouge) {

                        $this->fpdf->SetTextColor('237', '28', '36');
                    } else {

                        $this->fpdf->SetTextColor('0', '0', '0');
                    }

                    if ($note->valeur >= 0 && $note->valeur < 10) {
                        $note->mention = "NA";
                    }

                    if ($note->valeur >= 10 && $note->valeur < 15) {
                        $note->mention = "ECA";
                    }

                    if ($note->valeur >= 15) {
                        $note->mention = "Acquis";
                    }

                    $this->fpdf->Cell(11, $tailleCelleLong, $note->mention, 1, 0, 'C');
                }


                // MAX NOTE  CAT 1

                $this->fpdf->SetFont('Arial', 'B', $tailleTextChiffre);
                $this->fpdf->SetTextColor('0', '0', '0');


                $max = NotesTrimestres::where('trimestre_id', $IdTrimmestre)->where('classe_id', $IdClasse)
                    ->where('matiere_id', $note->matiere->id)->where('status', null)->max('valeur');


                $this->fpdf->Cell(8, $tailleCelleLong, $max, 1, 0, 'C');



                // MIN NOTE  CAT 1

                $this->fpdf->SetFont('Arial', 'B', $tailleTextChiffre);


                $min = NotesTrimestres::where('trimestre_id', $IdTrimmestre)->where('classe_id', $IdClasse)
                    ->where('matiere_id', $note->matiere->id)->where('status', null)->min('valeur');


                $this->fpdf->Cell(8, $tailleCelleLong, $min, 1, 0, 'C');



                $allMoyMat  = NotesTrimestres::where('matiere_id', $note->matiere->id)
                    ->where('trimestre_id', $IdTrimmestre)
                    ->where('classe_id', $IdClasse)
                    ->where('codeEtab', $codeEtab)
                    ->where('session', $session)
                    ->where('status', null)
                    ->orderBy('valeur', 'desc')->get();

                $num = 0;

                foreach ($allMoyMat as $va) {

                    $num = $num + $va->valeur;
                }

                if (count($allMoyMat) == 0) {

                    $this->fpdf->Cell(10, $tailleCelleLong, "-", 1, 0, 'C');
                } else {

                    $this->fpdf->Cell(10, $tailleCelleLong, number_format($num / count($allMoyMat), 2), 1, 0, 'C');
                }



                $this->fpdf->SetFont('Arial', 'B', $tailleText);

                $this->fpdf->Cell(30, $tailleCelleLong, utf8_decode(substr($note->user->nom . ' ' . $note->user->prenom, 0, 18)), 1, 0, 'L');

                $this->fpdf->Cell(18, $tailleCelleLong, '', 1, 0, 'L');


                $this->fpdf->SetFont('Arial', 'B', $tailleText);
                $this->fpdf->Ln($tailleCelleLong);
            }







            // Moy trimestre  du groupe 2

            $sommeNoteCoef2 = $sommeCoef2 = 0;

            foreach ($NoteTrimestrecat2[$data->student->id] as $data2) {


                if ($data2->status == null) {

                    $sommeNoteCoef2 = $sommeNoteCoef2 + ($data2->valeur * $data2->matiere->coef);

                    $sommeCoef2 = $sommeCoef2 + $data2->matiere->coef;
                }
            }

            if ($sommeCoef2 == 0) {

                $moyenne2[$data->student->id] =  '-';
            } else {

                $moyenne2[$data->student->id] =  number_format($sommeNoteCoef2 / $sommeCoef2, 2);
            }





            // Moyenne cat2 du devoir 1


            $sommeNoteCoefD1cat2 = 0;

            $sommeCoef2D1 = 0;


            foreach ($Notecat2[$data->student->id] as $data1) {


                if ($data1->status == null) {


                    $sommeNoteCoefD1cat2 = $sommeNoteCoefD1cat2 + ($data1->valeur * $data1->matiere->coef);

                    $sommeCoef2D1  = $sommeCoef2D1  + $data1->matiere->coef;
                }
            }


            if ($sommeCoef2D1 == 0) {

                $moyenneD1Cat2[$data->student->id] =  '-';
            } else {

                $moyenneD1Cat2[$data->student->id] =  number_format($sommeNoteCoefD1cat2 / $sommeCoef2D1, 2);
            }




            // Moyenne cat2 du devoir 2


            $sommeNoteCoefD2cat2 = 0;

            $sommeCoef2D2 = 0;


            foreach ($Note2cat2[$data->student->id] as $data1) {


                if ($data1->status == null) {

                    $sommeNoteCoefD2cat2 = $sommeNoteCoefD2cat2 + ($data1->valeur * $data1->matiere->coef);

                    $sommeCoef2D2  = $sommeCoef2D2  + $data1->matiere->coef;
                }
            }


            if ($sommeCoef2D2 == 0) {

                $moyenneD2Cat2[$data->student->id] =  '-';
            } else {

                $moyenneD2Cat2[$data->student->id] =  number_format($sommeNoteCoefD2cat2 / $sommeCoef2D2, 2);
            }

            $this->fpdf->SetX(3);
            $this->fpdf->SetFont('Arial', 'B', 6);
            $this->fpdf->Cell(60, 6, utf8_decode('MODULES DES COMPETENCES GENERALES'), 1, 0, 'C', 1);
            $this->fpdf->SetFont('Arial', 'B', $tailleText + 2);
            $this->fpdf->Cell(10, 6, $moyenneD1Cat2[$data->student->id], 1, 0, 'C', 1);
            $this->fpdf->Cell(10, 6, $moyenneD2Cat2[$data->student->id], 1, 0, 'C', 1);
            $this->fpdf->Cell(10, 6,  $moyenne2[$data->student->id], 1, 0, 'C', 1);
            $this->fpdf->Cell(10, 6,  $sommeCoef2, 1, 0, 'C', 1);
            $this->fpdf->Cell(10, 6, $sommeNoteCoef2, 1, 0, 'C', 1);
            $this->fpdf->Cell(95, 6, '', 1, 0, 'C', 1);

            $this->fpdf->Ln();


            // // /*   ******************************************* PARTIE DU BULLETIN DE LA CATEGORIE 3 *************************************************************/





            // Note Ev1 de cat 3 et libelle matiere cat 3


            foreach ($Notecat3[$data->student->id] as $note) {

                $this->fpdf->SetX(3);


                // Matiere

                $this->fpdf->SetFont('Arial', 'B', $tailleText);


                $this->fpdf->Cell(
                    60,
                    $tailleCelleLong,
                    utf8_decode(substr($note->matiere->libelle, 0, 39)),
                    1,
                    0,
                    'L'
                );


                // Note Ev1

                if ($note->status == 1) {

                    //  Pas de note

                    $this->fpdf->Cell(10, $tailleCelleLong, '-', 1, 0, 'C');
                } else {

                    $this->fpdf->SetFont('Arial', 'B', $tailleTextChiffre);

                    if ($note->valeur < $couleurRouge) {

                        $this->fpdf->SetTextColor('237', '28', '36');
                    } else {

                        $this->fpdf->SetTextColor('0', '0', '0');
                    }



                    $this->fpdf->Cell(10, $tailleCelleLong, $note->valeur, 1, 0, 'C');
                }

                $this->fpdf->SetFont('Arial', 'B', $tailleText);



                $this->fpdf->Ln($tailleCelleLong);


                $this->fpdf->SetTextColor('0', '0', '0');
            }


            // Note Ev 2 de cat 3


            $this->fpdf->Ln(-$tailleCelleLong * $val4);

            foreach ($Note2cat3[$data->student->id] as $note) {

                $this->fpdf->SetX(3 + 60 + 10);


                // Note Ev2

                if ($note->status == 1) {

                    //  Pas de note

                    $this->fpdf->Cell(10, $tailleCelleLong, '-', 1, 0, 'C');
                } else {

                    $this->fpdf->SetFont('Arial', 'B', $tailleTextChiffre);

                    if ($note->valeur < $couleurRouge) {

                        $this->fpdf->SetTextColor('237', '28', '36');
                    } else {

                        $this->fpdf->SetTextColor('0', '0', '0');
                    }



                    $this->fpdf->Cell(10, $tailleCelleLong, $note->valeur, 1, 0, 'C');
                }

                $this->fpdf->SetFont('Arial', 'B', $tailleText);



                $this->fpdf->Ln($tailleCelleLong);


                $this->fpdf->SetTextColor('0', '0', '0');
            }


            // NoteTRIMESTRE  de cat 3


            $this->fpdf->SetTextColor('0', '0', '0');


            $this->fpdf->Ln(-$tailleCelleLong * $val4);

            foreach ($NoteTrimestrecat3[$data->student->id] as $note) {

                $this->fpdf->SetX(3 + 60 + 10 + 10);


                // Note TRIMESTRE CAT1

                if ($note->status == 1) {

                    //  Pas de note

                    $this->fpdf->Cell(10, $tailleCelleLong, '-', 1, 0, 'C');
                } else {

                    $this->fpdf->SetFont('Arial', 'B', $tailleTextChiffre);

                    if ($note->valeur < $couleurRouge) {

                        $this->fpdf->SetTextColor('237', '28', '36');
                    } else {

                        $this->fpdf->SetTextColor('0', '0', '0');
                    }



                    $this->fpdf->Cell(10, $tailleCelleLong, $note->valeur, 1, 0, 'C');
                }


                $this->fpdf->SetTextColor('0', '0', '0');

                // Coef Trimestre cat 1

                $this->fpdf->Cell(10, $tailleCelleLong, $note->matiere->coef, 1, 0, 'C');


                // Coef * Note trimestre cat 1

                if ($note->status == 1) {

                    //  Pas de note

                    $this->fpdf->Cell(
                        10,
                        $tailleCelleLong,
                        '-',
                        1,
                        0,
                        'C'
                    );
                } else {

                    $this->fpdf->SetFont('Arial', 'B', $tailleTextChiffre);

                    if ($note->valeur < $couleurRouge) {

                        $this->fpdf->SetTextColor('237', '28', '36');
                    } else {

                        $this->fpdf->SetTextColor('0', '0', '0');
                    }

                    $this->fpdf->Cell(10, $tailleCelleLong, $note->valeur * $note->matiere->coef, 1, 0, 'C');
                    $this->fpdf->SetTextColor('0', '0', '0');
                }


                // RANG DES MATIERES CAT 1

                $all  = NotesTrimestres::where('matiere_id', $note->matiere->id)
                    ->where('trimestre_id', $IdTrimmestre)
                    ->where('classe_id', $IdClasse)
                    ->where('codeEtab', $codeEtab)
                    ->where('session', $session)
                    ->orderBy('valeur', 'desc')->get();




                foreach ($all as $ket => $test) {

                    if ($test->id == $note->id) {
                        $rank = $ket;

                        if ($rank + 1 == 1) {
                            $labelRang = 'er';
                        } else {
                            $labelRang =
                                utf8_decode("è");
                        }
                    }
                }


                if ($note->status == 1) {

                    $this->fpdf->Cell(10, $tailleCelleLong, '-', 1, 'C');
                } else {
                    $this->fpdf->Cell(10, $tailleCelleLong, $rank + 1 . $labelRang, 1, 0, 'C');
                }

                // APPRECIATIONS DES MATIERES CAT 1

                if ($note->status == 1) {

                    //  Pas de note

                    $this->fpdf->SetFont('Arial', 'B', $tailleTextChiffre);

                    $this->fpdf->Cell(11, $tailleCelleLong, '-', 1, 0, 'C');
                } else {

                    $this->fpdf->SetFont('Arial', 'B', $tailleTextChiffre);

                    if ($note->valeur < $couleurRouge) {

                        $this->fpdf->SetTextColor('237', '28', '36');
                    } else {

                        $this->fpdf->SetTextColor('0', '0', '0');
                    }

                    if ($note->valeur >= 0 && $note->valeur < 10) {
                        $note->mention = "NA";
                    }

                    if ($note->valeur >= 10 && $note->valeur < 15) {
                        $note->mention = "ECA";
                    }

                    if ($note->valeur >= 15) {
                        $note->mention = "Acquis";
                    }

                    $this->fpdf->Cell(11, $tailleCelleLong, $note->mention, 1, 0, 'C');
                }


                // MAX NOTE  CAT 1

                $this->fpdf->SetFont('Arial', 'B', $tailleTextChiffre);
                $this->fpdf->SetTextColor('0', '0', '0');


                $max = NotesTrimestres::where('trimestre_id', $IdTrimmestre)->where('classe_id', $IdClasse)
                    ->where('matiere_id', $note->matiere->id)->where('status', null)->max('valeur');


                $this->fpdf->Cell(8, $tailleCelleLong, $max, 1, 0, 'C');



                // MIN NOTE  CAT 1

                $this->fpdf->SetFont('Arial', 'B', $tailleTextChiffre);


                $min = NotesTrimestres::where('trimestre_id', $IdTrimmestre)->where('classe_id', $IdClasse)
                    ->where('matiere_id', $note->matiere->id)->where('status', null)->min('valeur');


                $this->fpdf->Cell(8, $tailleCelleLong, $min, 1, 0, 'C');



                $allMoyMat  = NotesTrimestres::where('matiere_id', $note->matiere->id)
                    ->where('trimestre_id', $IdTrimmestre)
                    ->where('classe_id', $IdClasse)
                    ->where('codeEtab', $codeEtab)
                    ->where('session', $session)
                    ->where('status', null)
                    ->orderBy('valeur', 'desc')->get();

                $num = 0;

                foreach ($allMoyMat as $va) {

                    $num = $num + $va->valeur;
                }

                if (count($allMoyMat) == 0) {

                    $this->fpdf->Cell(10, $tailleCelleLong, '-', 1, 0, 'C');
                } else {
                    $this->fpdf->Cell(10, $tailleCelleLong, number_format($num / count($allMoyMat), 2), 1, 0, 'C');
                }



                $this->fpdf->SetFont('Arial', 'B', $tailleText);

                $this->fpdf->Cell(30, $tailleCelleLong, utf8_decode(substr($note->user->nom . ' ' . $note->user->prenom, 0, 18)), 1, 0, 'L');
                $this->fpdf->Cell(18, $tailleCelleLong, '', 1, 0, 'L');



                $this->fpdf->SetFont('Arial', 'B', $tailleText);
                $this->fpdf->Ln($tailleCelleLong);
            }








            $this->fpdf->SetX(3);

            // Moy trimestre  du groupe 3

            $sommeNoteCoef3 = $sommeCoef3 = 0;

            foreach ($NoteTrimestre3[$data->student->id] as $data2) {


                if ($data2->status == null) {

                    $sommeNoteCoef3 = $sommeNoteCoef3 + ($data2->valeur * $data2->matiere->coef);

                    $sommeCoef3 = $sommeCoef3 + $data2->matiere->coef;
                }
            }


            if ($sommeCoef3 == 0) {

                $moyenne3[$data->student->id] =  '-';
            } else {

                $moyenne3[$data->student->id] =  number_format($sommeNoteCoef3 / $sommeCoef3, 2);
            }






            // Moyenne cat3 du devoir 1


            $sommeNoteCoefD1cat3 = 0;

            $sommeCoef3D1 = 0;


            foreach ($Notecat3[$data->student->id] as $data1) {

                if ($data1->status == null) {

                    $sommeNoteCoefD1cat3 = $sommeNoteCoefD1cat3 + ($data1->valeur * $data1->matiere->coef);

                    $sommeCoef3D1  =  $sommeCoef3D1  + $data1->matiere->coef;
                }
            }

            if ($sommeCoef3D1 == 0) {

                $moyenneD1Cat3[$data->student->id] =  '-';
            } else {

                $moyenneD1Cat3[$data->student->id] =  number_format($sommeNoteCoefD1cat3 / $sommeCoef3D1, 2);
            }



            // Moyenne cat3 du devoir 2


            $sommeNoteCoefD2cat3 = 0;

            $sommeCoef3D2 = 0;


            foreach ($Note2cat3[$data->student->id] as $data1) {


                if ($data1->status == null) {

                    $sommeNoteCoefD2cat3 =  $sommeNoteCoefD2cat3 + ($data1->valeur * $data1->matiere->coef);

                    $sommeCoef3D2  = $sommeCoef3D2  + $data1->matiere->coef;
                }
            }

            if ($sommeCoef3D2 == 0) {
                $moyenneD2Cat3[$data->student->id] = '-';
            } else {

                $moyenneD2Cat3[$data->student->id] =  number_format($sommeNoteCoefD2cat3 / $sommeCoef3D2, 2);
            }



            $this->fpdf->SetFont('Arial', 'B', 6);
            $this->fpdf->Cell(60, 6, utf8_decode('MODULES DES ENSEIGNEMENTS COMPLEMENTAIRES'), 1, 0, 'C', 1);
            $this->fpdf->SetFont('Arial', 'B', $tailleText + 2);
            $this->fpdf->Cell(10, 6, $moyenneD1Cat3[$data->student->id], 1, 0, 'C', 1);
            $this->fpdf->Cell(10, 6, $moyenneD2Cat3[$data->student->id], 1, 0, 'C', 1);
            $this->fpdf->Cell(10, 6, $moyenne3[$data->student->id], 1, 0, 'C', 1);
            $this->fpdf->Cell(10, 6, $sommeCoef3, 1, 0, 'C', 1);
            $this->fpdf->Cell(10, 6, $sommeNoteCoef3, 1, 0, 'C', 1);
            $this->fpdf->Cell(95, 6, '', 1, 0, 'C', 1);


            $this->fpdf->Ln(12);

            $this->fpdf->SetX(3);
            $this->fpdf->SetFont('Arial', 'B', $tailleText);
            $this->fpdf->Cell(44, 5, utf8_decode('RAPPEL'), 1, 0, 'C', 1);
            $this->fpdf->Cell(35, 5, utf8_decode('TRAVAIL DE LA CLASSE'), 1, 0, 'C', 1);
            $this->fpdf->Cell(35, 5, 'TRAVAIL' . utf8_decode(strtoupper($libelleTrimestre)), 1, 0, 'C', 1);
            $this->fpdf->Cell(46, 5, utf8_decode('CONDUITE'), 1, 0, 'C', 1);
            $this->fpdf->Cell(44, 5, utf8_decode('TRAVAIL'), 1, 0, 'C', 1);


            // Moyenne et rang du devoir 1



            // dd( $MoyenneDevoir1[$data->student->id]->student_id);

            //  Ran du devoir 1




            $moyDevoir1 = Moyennes::where('session', $session)->where('codeEtab', $codeEtab)
                ->where('evaluation_id', $idEval1)
                ->where('classe_id', $IdClasse)
                ->orderBy('valeur', 'DESC')->get();


            // dd(  $moyDevoir1);











            foreach ($moyDevoir1   as $key => $dataa) {


                if ($dataa->student_id == $MoyenneDevoir1[$data->student->id]->student_id) {

                    $rankEval1[$dataa->student->id] = $key + 1;
                }
            }



            //  Ran du devoir 2


            $moyDevoir2 = Moyennes::where('session', $session)->where('codeEtab', $codeEtab)
                ->where('evaluation_id', $idEval2)
                ->where('classe_id', $IdClasse)
                ->orderBy('valeur', 'DESC')->get();

            foreach ($moyDevoir2   as $key => $dataa) {


                if ($dataa->student_id == $MoyenneDevoir1[$data->student->id]->student_id) {

                    $rankEval2[$dataa->student->id] = $key + 1;
                }
            }

            $this->fpdf->Ln();
            $this->fpdf->SetX(3);
            $this->fpdf->Cell(29, 5, utf8_decode('MOY' . ' ' . $libelleEval1), 1, 0, 'L', 0);

            $rankEval1[$data->student->id] = $rankEval1[$data->student->id];



            if ($MoyenneDevoir1[$data->student->id]->valeur == 0) {
                $MoyenneDevoir1[$data->student->id]->valeur = '';
                $rankEval1[$data->student->id] = '';
            } else {

                $rankEval1[$data->student->id] = $rankEval1[$data->student->id];
            }


            $TH = $ENC = $FEL = $BLMTVL = $AVTRAI = " ";


            if ($data->valeur >= 14) {

                $TH = "";
                $ENC = "";
                $FEL = "X";
                $BLMTVL = "";
                $AVTRAI = " ";
            }

            if ($data->valeur > 13 && $data->valeur < 14) {

                $TH = "";
                $ENC = "X";
                $FEL = "";
                $BLMTVL = "";
                $AVTRAI = "";
            }

            if ($data->valeur >= 12 && $data->valeur < 13) {

                $TH = "X";
                $ENC = "";
                $FEL = "";
                $BLMTVL = "";
                $AVTRAI = "";
            }

            if ($data->valeur >= 7 && $data->valeur < 9) {

                $TH = "";
                $ENC = "";
                $FEL = "";
                $BLMTVL = "";
                $AVTRAI = "X";
            }

            if ($data->valeur >= 0 && $data->valeur < 7) {

                $TH = "";
                $ENC = "";
                $FEL = "";
                $BLMTVL = "";
                $AVTRAI = "X";
            }


            $this->fpdf->SetFont('Arial', 'B', $tailleText + 1);
            $this->fpdf->Cell(15, 5,  $MoyenneDevoir1[$data->student->id]->valeur . ' /20', 1, 0, 'C', 0);

            $this->fpdf->SetFont('Arial', 'B', $tailleText);

            $this->fpdf->Cell(25, 5, utf8_decode('MOY CLASSE / 20'), 1, 0, 'L', 0);
            $this->fpdf->SetFont('Arial', 'B', $tailleText + 1);
            $this->fpdf->Cell(10, 5, number_format($moyenneSommeClasse / $nombreEleves, 2), 1, 0, 'C', 1);
            $this->fpdf->SetX(82);
            $this->fpdf->Cell(25, 5, utf8_decode('TOTAL POINTS'), 1, 0, 'L', 0);
            $this->fpdf->SetFont('Arial', 'B', $tailleText + 1);
            $this->fpdf->Cell(10, 5,  $sommeNoteCoef1 + $sommeNoteCoef2 + $sommeNoteCoef3, 1, 0, 'C', 0);
            $this->fpdf->SetX(117);
            $this->fpdf->Cell(33, 5, utf8_decode('ABSENCES JUSTIF'), 1, 0, 'L', 0);
            $this->fpdf->Cell(13, 5, $heureTrimestreJustifies, 1, 0, 'C', 0); // $heureTrimestre


            // $this->fpdf->Cell(34, 5, utf8_decode('FELICITATIONS'), 1, 0, 'L', 1);
            $this->fpdf->Cell(34, 5, utf8_decode('TABLEAU D\'HONNEUR'), 1, 0, 'L', 1);
            $this->fpdf->SetFont('Arial', 'B', $tailleText);
            $this->fpdf->Cell(10, 5, $TH, 1, 0, 'C', 0);

            $this->fpdf->SetFont('Arial', 'B', $tailleText);


            // $sentionAvert = $sentionBlame =  $sentionJrs = $sentionConduite =  "";



            // // Rang Eval1

            // $moyenneEval1[$data->student->id] = Moyennes::where('evaluation_id', $idEval1);


            $this->fpdf->Ln();
            $this->fpdf->SetX(3);
            $this->fpdf->SetFont('Arial', 'B', $tailleText + 1);
            $this->fpdf->Cell(29, 5, utf8_decode('Rang' . ' ' . $libelleEval1), 1, 0, 'L', 0);
            $this->fpdf->SetFont('Arial', 'B', $tailleText);
            if ($rankEval1[$data->student->id] == 1) {

                $label1 = 'er';
            } else {
                $label1 =
                    utf8_decode('è');;
            }




            $this->fpdf->Cell(15, 5, $rankEval1[$data->student->id] . '' . $label1, 1, 0, 'C', 1);



            $this->fpdf->Cell(25, 5, utf8_decode('MOY PREMIER / 20 '), 1, 0, 'L', 0);
            $this->fpdf->SetFont('Arial', 'B', $tailleText + 1);
            $this->fpdf->Cell(10, 5, $MoyPremier, 1, 0, 'C', 0);
            $this->fpdf->Cell(25, 5, utf8_decode('TOTAL COEFS'), 1, 0, 'L', 0);
            $this->fpdf->Cell(10, 5, $sommeCoef1 + $sommeCoef2 + $sommeCoef3, 1, 0, 'C', 0);
            $this->fpdf->Cell(33, 5, utf8_decode('ABSENCE NON JUSTIF'), 1, 0, 'L', 1);
            $this->fpdf->Cell(13, 5, $heureTrimestre - $heureTrimestreJustifies, 1, 0, 'C', 0); // $heureConsigneTrimestre


            // $this->fpdf->Cell(34, 5, utf8_decode('ENCOURAGEMENTS'), 1, 0, 'L', 0);

            $this->fpdf->Cell(34, 5, utf8_decode('FELICITATIONS'), 1, 0, 'L', 0);


            $this->fpdf->SetFont('Arial', 'B', $tailleText);
            $this->fpdf->Cell(10, 5, $FEL, 1, 0, 'C', 0);

            $this->fpdf->SetFont('Arial', 'B', $tailleText);


            $this->fpdf->Ln();
            $this->fpdf->SetX(3);



            $this->fpdf->SetFont('Arial', 'B', $tailleText);
            $this->fpdf->Cell(29, 5, utf8_decode('MOY' . ' ' . $libelleEval2), 1, 0, 'L', 0);

            $rankEval2[$data->student->id] = $rankEval2[$data->student->id];


            if ($MoyenneDevoir2[$data->student->id]->valeur == 0) {
                $MoyenneDevoir2[$data->student->id]->valeur = '';
                $rankEval2[$data->student->id] = '';
            } else {

                $rankEval2[$data->student->id] = $rankEval2[$data->student->id];
            }

            $this->fpdf->SetFont('Arial', 'B', $tailleText + 1);
            $this->fpdf->Cell(15, 5, $MoyenneDevoir2[$data->student->id]->valeur . ' /20', 1, 0, 'C', 0);


            $this->fpdf->SetFont('Arial', 'B', $tailleText);
            $this->fpdf->Cell(25, 5, utf8_decode('MOY Dernier / 20 '), 1, 0, 'L', 0);
            $this->fpdf->SetFont('Arial', 'B', $tailleText + 1);
            $this->fpdf->Cell(10, 5, $MoyDernier, 1, 0, 'C', 0);


            $this->fpdf->Cell(25, 5, 'MOYENNE / 20 ', 1, 0, 'L', 1);

            if ($data->valeur == 0) {

                $this->fpdf->Cell(10, 5, '-', 1, 0, 'C', 0);
            } else {

                $this->fpdf->SetFont('Arial', 'B', $tailleText + 2);


                $this->fpdf->Cell(10, 5, $data->valeur, 1, 0, 'C', 0);

                $this->fpdf->SetFont('Arial', 'B', $tailleText);
            }


            $sentionJrs = "";
            $sentionAvert = "";
            $sentionConduite = "";





            if (($heureTrimestre - $heureTrimestreJustifies) >= 0 && ($heureTrimestre - $heureTrimestreJustifies) <= 7) {

                $sentionAvert = " ";
            }
            if (($heureTrimestre - $heureTrimestreJustifies) >= 8 && ($heureTrimestre - $heureTrimestreJustifies) <= 15) {

                $sentionAvert = " X ";
                $sentionConduite = "";
                $sentionJrs = "";
            }

            if (($heureTrimestre - $heureTrimestreJustifies) > 15  && ($heureTrimestre - $heureTrimestreJustifies) <= 20) {

                $sentionConduite = " X ";

                $sentionAvert = "";
                $sentionJrs = "";
            }

            if (($heureTrimestre - $heureTrimestreJustifies) > 20  && ($heureTrimestre - $heureTrimestreJustifies) <= 25) {

                $sentionJrs = utf8_decode("3j + Corvée");
                $sentionAvert = "";
                $sentionConduite = "";
            }

            if (($heureTrimestre - $heureTrimestreJustifies) > 25  && ($heureTrimestre - $heureTrimestreJustifies) < 30) {

                $sentionJrs =
                    utf8_decode("(5j + Corvée");
                $sentionAvert = "";
                $sentionConduite = "";
            }

            if (($heureTrimestre - $heureTrimestreJustifies) > 30) {

                $sentionJrs =
                    utf8_decode("8j + Excep");;
                $sentionAvert = "";
                $sentionConduite = "";
            }










            $this->fpdf->Cell(33, 5, utf8_decode('AVERTISSEMENT CDTE'), 1, 0, 'L', 0);

            $this->fpdf->Cell(13, 5, $sentionAvert, 1, 0, 'C', 0);

            // $this->fpdf->Cell(34, 5, utf8_decode("TABLEAU D'HONNEUR "), 1, 0, 'L', 0);


            $this->fpdf->Cell(34, 5, utf8_decode("ENCOURAGEMENTS "), 1, 0, 'L', 0);


            $this->fpdf->SetFont('Arial', 'B', $tailleText + 1);
            $this->fpdf->Cell(10, 5, $ENC, 1, 0, 'C', 0);




            $rankEval2[$data->student->id] = $rankEval2[$data->student->id];


            $this->fpdf->Ln();
            $this->fpdf->SetX(3);
            $this->fpdf->SetFont('Arial', 'B', $tailleText + 1);
            $this->fpdf->Cell(29, 5, utf8_decode('Rang' . ' ' . $libelleEval2), 1, 0, 'L', 0);

            if ($rankEval2[$data->student->id] == 1) {

                $label2 = 'er';
            } else {
                $label2 = utf8_decode('è');
            }


            $this->fpdf->Cell(15, 5,   $rankEval2[$data->student->id] . '' . $label2, 1, 0, 'C', 1);
            $this->fpdf->Cell(25, 5, utf8_decode('TAUX REUSSITE'), 1, 0, 'L', 0);
            $this->fpdf->SetFont('Arial', 'B', $tailleText + 1);
            $this->fpdf->Cell(10, 5, number_format($NombreAdmis / ($nombreEleves), 2) * 100 . " " . "%", 1, 0, 'C', 1);

            $this->fpdf->Cell(25, 5, 'RANG', 1, 0, 'C', 0);

            if ($data->valeur == 0) {
                $this->fpdf->Cell(10, 5, '-' . $e, 1, 0, 'C', 1);
            } else {

                $this->fpdf->SetFont('Arial', 'B', $tailleText + 2);
                $this->fpdf->Cell(10, 5, ($ley + 1) . '' . $e, 1, 0, 'C', 1);
            }

            $this->fpdf->SetFont('Arial', 'B', $tailleText);

            $this->fpdf->Cell(33, 5, utf8_decode('EXCLUSIONS'), 1, 0, 'L', 0);
            $this->fpdf->SetFont('Arial', 'B', $tailleText);
            $this->fpdf->Cell(13, 5, $sentionJrs, 1, 0, 'C', 1); // $ExclusionTrimestre
            $this->fpdf->Cell(34, 5, utf8_decode("AVERTISSEMT TRAVAIL "), 1, 0, 'L', 0);
            $this->fpdf->SetFont('Arial', 'B', 12);
            $this->fpdf->Cell(10, 5, $AVTRAI, 1, 0, 'C', 0);


            $this->fpdf->SetFont('Arial', 'B', $tailleText);


            $this->fpdf->Ln();
            $this->fpdf->SetX(117);
            $this->fpdf->Cell(33, 5, utf8_decode('BLAME CONDUITE'), 1, 0, 'L', 0);
            $this->fpdf->Cell(13, 5, $sentionConduite, 1, 0, 'C', 0);
            $this->fpdf->Cell(34, 5, utf8_decode('BLAME TRAVAIL'), 1, 0, 'L', 0);
            $this->fpdf->SetFont('Arial', 'B', 12);
            $this->fpdf->Cell(10, 5, $BLMTVL, 1, 0, 'C', 0);
            $this->fpdf->SetFont('Arial', 'B', $tailleText);

            $this->fpdf->Ln();
            $this->fpdf->SetX(3);


            $this->fpdf->Cell(79, 5, utf8_decode('VISA DU PARENT '), 1, 0, 'C', 1);
            $this->fpdf->Cell(81, 5, utf8_decode('OBSERVATION DU CONSEIL DE CLASSE'), 1, 0, 'C', 1);
            $this->fpdf->Cell(44, 5, 'VISA DU CHEF D\'ETABLISSEMENT', 1, 0, 'C', 1);


            $this->fpdf->SetX(7);
            $this->fpdf->Cell(79, 20, '', 0, 0, 'L', 0);
            $this->fpdf->Cell(81, 20, utf8_decode(''), 0, 0, 'L', 0);
            $this->fpdf->Cell(44, 21, 'MANENGOLE Le ____________', 0, 0, 'L', 0);

            $this->fpdf->SetX(3);
            $this->fpdf->Cell(79, 20, '', 1, 0, 'L', 0);
            $this->fpdf->Cell(81, 20, utf8_decode(''), 1, 0, 'L', 0);
            $this->fpdf->Cell(44, 20, '    ', 1, 0, 'L', 0);

            $sommeNoteCoef1 = $sommeNoteCoef2 = $sommeNoteCoef3 = 0;

            $sommeCoef1 = $sommeCoef2 = $sommeCoef3 = 0;


            $this->fpdf->Ln(18);

            $this->fpdf->SetX(2);

            // $this->fpdf->Cell(0, 10, "NA : Non Aquis |   ECA : En cours d'acquisition", 0, 0, 'L', 0);



            $this->fpdf->SetFont('Arial', 'B', $tailleText - 1);
            $this->fpdf->Cell(0, 12, "Conception du  logiciel  : Ingenieur EKOUTE FABIEN | fabienekoute@gmail.com | 693333163 - 679901213 |  NA : Non Aquis | ECA : En cours d'acquisition | LYCEE TECHNIQUE DE MANENGOLE", 0, 0, 'L', 0);
        }

        $this->fpdf->Output();
        exit;
    }

    public function getStudentMoyenneTrimestreByIdStudent($idStudent, $MoysTrim)


    {



        $resuluts = [];



        foreach ($MoysTrim as $moy) {

            if ($moy->student_id == $idStudent) {

                $resuluts['moy'] = $moy->valeur;
            }
        }

        return  $resuluts;
    }


    public function getMoyenneTrimByIdTrim($idTrim, $idClasse)
    {

        $moyennes  = MoyenneTrimestres::where('trimestre_id', $idTrim)->where('classe_id', $idClasse)->orderBy('valeur', 'DESC')->get();


        return $moyennes;
    }


    // public function getStudentMoyenneAnnuelleByIdStudent($idEleve, $idClasse)


    // {

    //     $MoysAnnuelles = MoyenneAnnuelle::where('classe_id', $idClasse)->get();
    //     foreach ($MoysAnnuelles as $moy) {

    //         if($moy->student_id==$idEleve) {



    //         }
    //     }
    //     return  $MoysAnnuelles;
    // }



    public function getMoyEvalStudentAndRankAnnuelById($idStudent, $EvalId, $idClasse, $moyEval)


    {




        $results = [];


        foreach ($moyEval as $key => $data) {


            if ($data->student_id == $idStudent) {

                $results['moy'] = $data->valeur;

                $results['rank'] = $key + 1;
            }
        }


        return $results;
    }





    public function getAllMoyenneSequenveByIdEval($idEval, $idClasse)


    {


        $moys = Moyennes::where('classe_id', $idClasse)->where('evaluation_id', $idEval)->orderBy('valeur', 'DESC')->get();

        return  $moys;
    }

    public function getAbsenceAnnuelStudent($studentId, $IdClasse)
    {

        $totalStudentPresenceHours = Presences::where('classe_id', $IdClasse)

            ->where('student_id', $studentId)
            ->sum('etat');
    }

    public function getMoyenneGeneAnnuelClasse($IdClasse) {}
}
