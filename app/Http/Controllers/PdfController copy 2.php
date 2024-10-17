<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Books;
use App\Models\Notes;
use App\Models\caisse;
use App\Models\Classe;
use App\Models\config;
use App\Models\Matiere;
use App\Models\Session;
use App\Models\Student;
use App\Models\Syllabs;
use App\Models\Matieres;
use App\Models\Moyennes;
use App\Models\salaires;
use App\Models\Presences;
use App\Models\Trimestre;
use App\Models\discipline;
use App\Models\Versements;
use App\Models\Enseignants;
use App\Models\Evaluations;
use App\Models\partiebooks;
use Codedge\Fpdf\Fpdf\Fpdf;
use App\Models\noteAnnuelle;
use Illuminate\Http\Request;
use App\Models\Etablissement;
use App\Models\MoyenneAnnuelle;
use App\Models\NotesTrimestres;
use App\Models\MoyenneTrimestres;

class PdfController extends Controller

{
    protected $fpdf;

    public function __construct()

    {
        $this->fpdf = new Fpdf;
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

    public function getAllProcesVerbalTrimestre2($idClasse)



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


        $this->fpdf->AddPage("P", ['375', '225']);

        // $this->fpdf->SetTextColor('44', '53', '61');

        $this->fpdf->SetXY(58, 50);
        $this->fpdf->Cell(100, 6, '', 1);

        $this->fpdf->SetFont('Arial', 'B', 9);

        $this->fpdf->Text(89, 54, utf8_decode("ANNEE SCOLAIRE : $session "));


        $this->fpdf->Image(public_path("/Photos/Logos/" . $entete), 5, 8, 215, 35, "");


        $this->fpdf->SetFont('Arial', 'B', 18);

        $this->fpdf->Text(37, 70, utf8_decode(" PROCES VERBAL DE CONSEIL DE CLASSE "));

        $this->fpdf->SetFont('Arial', 'B', 8);

        $this->fpdf->line(25, 84, 38, 84); // trait souligne classe



        $this->fpdf->Text(25, 82, utf8_decode("CLASSE :  $code->libelleClasse"));

        $this->fpdf->Text(150, 82, utf8_decode("TRIMESTRE :  $IdTrimmestre "));

        $this->fpdf->line(150, 84, 168, 84); // trait souligne trimstre



        $this->fpdf->SetXY(3, 90);
        $this->fpdf->SetFont('Arial', 'B', 8);
        // $this->fpdf->SetDrawColor(0, 0, 0);
        // $this->fpdf->SetFillColor('10', '75', '168');
        // $this->fpdf->SetTextColor('0', '0', '0');
        $this->fpdf->Cell(7, 12, utf8_decode('Nº'), 1, 0, 'L', 0);
        $this->fpdf->Cell(60, 12, 'NOMS et PRENOMS', 1, 0, 'C', 0);
        $this->fpdf->SetFont('Arial', 'B', 6);
        $this->fpdf->Cell(14, 12, 'NE(E) LE ', 1, 0, 'C', 0);
        $this->fpdf->SetFont('Arial', 'B', 5);
        $this->fpdf->Cell(7, 12, 'SEXE', 1, 0, 'L', 0);
        $this->fpdf->SetFont('Arial', 'B', 6);
        $this->fpdf->Cell(6, 12, 'N / R', 1, 0, 'C', 0);

        $this->fpdf->Cell(69, 6, '' . strtoupper('TRAVAIL'), 1, 0, 'C', 0);
        $this->fpdf->Cell(28, 6, '' . strtoupper('DISCIPLINE'), 1, 0, 'C', 0);

        $idEv1 = $idEval1 - 1;
        $idEv2 = $idEval2 - 1;

        $classeData = Student::with('user', 'classe')->where('classe_id', $IdClasse)
            ->where('session', $session)->where('codeEtab', $codeEtab)->orderBy('nom', 'ASC')->orderBy('prenom', 'ASC')->get();

        $moys = MoyenneTrimestres::with('student')->where('classe_id', $IdClasse)->where('trimestre_id', $IdTrimmestre)->where('session', $session)
            ->where('codeEtab', $codeEtab)->where('valeur', '>', 0)->orderBy('valeur', 'DESC')->get();




        $effectif = count($moys);


        $this->fpdf->SetXY(97, 96);
        $this->fpdf->Cell(11, 6, " MOY EV$idEv1", 1, 0, 'C', 0);
        $this->fpdf->Cell(11, 6, " MOY EV$idEv2", 1, 0, 'C', 0);
        $this->fpdf->Cell(13, 6, " MOY TRIM", 1, 0, 'C', 0);
        $this->fpdf->Cell(13, 6, "RANG / $effectif", 1, 0, 'L', 0);
        $this->fpdf->Cell(7, 6, "AVT", 1, 0, 'C', 0);
        $this->fpdf->Cell(7, 6, "BLT", 1, 0, 'C', 0);
        $this->fpdf->Cell(7, 6, "TH", 1, 0, 'C', 0);

        $this->fpdf->Cell(7, 6, "ANJ", 1, 0, 'C', 0);
        $this->fpdf->Cell(7, 6, "AVC", 1, 0, 'C', 0);
        $this->fpdf->Cell(7, 6, "BLC", 1, 0, 'C', 0);
        $this->fpdf->Cell(7, 6, "JE", 1, 0, 'C', 0);

        $this->fpdf->SetXY(194, 90);

        $this->fpdf->Cell(27, 12, 'DECISION DU CONSEIL', 1, 0, 'L', 0);

        $this->fpdf->SetY(102);






        foreach ($moys as $key => $student) {



            $this->fpdf->SetX(3);
            $this->fpdf->SetFont('Arial', 'B', 8);
            $this->fpdf->MultiCell(7, 6, $key + 1, 1, 'L');
        }

        $this->fpdf->SetY(102);

        foreach ($moys as $student) {

            $this->fpdf->SetX(10);
            $this->fpdf->SetFont('Arial', 'B', 7);
            $this->fpdf->MultiCell(60, 6, utf8_decode($student->student->nom) . ' ' . utf8_decode($student->student->prenom), 1, 'L');
        }


        $this->fpdf->SetY(102);

        foreach ($moys as $student) {

            $this->fpdf->SetX(70);
            $this->fpdf->SetFont('Arial', 'B', 6);
            $this->fpdf->MultiCell(14, 6, utf8_decode(date_format(date_create($student->student->dateNaiss), "d/m/Y")), 1, 'L');
        }


        $this->fpdf->SetY(102);

        foreach ($moys as $student) {

            $this->fpdf->SetX(84);
            $this->fpdf->SetFont('Arial', 'B', 7);
            $this->fpdf->MultiCell(7, 6, $student->student->sexe, 1, 'C');
        }



        $this->fpdf->SetY(102);


        foreach ($moys as $student) {

            $this->fpdf->SetX(91);
            $this->fpdf->SetFont('Arial', 'B', 7);

            if ($student->student->doublant == 'Nouveau') {

                $student->student->doublant = "N";
            } else {

                $student->student->doublant = "F";
            }
            $this->fpdf->MultiCell(6, 6, $student->student->doublant, 1, 'C');
        }

        $this->fpdf->SetY(102);

        // // MOY EV 1

        foreach ($moys as $student) {

            $moyEv1 = Moyennes::where('student_id', $student->student->id)->where('evaluation_id', $idEval1)->where('session', $session)
                ->where('codeEtab', $codeEtab)->first('valeur');

            $this->fpdf->SetX(97);
            $this->fpdf->SetFont('Arial', 'B', 7);
            $this->fpdf->MultiCell(11, 6,  $moyEv1->valeur, 1, 'C');
        }


        $this->fpdf->SetY(102);

        // MOY EV 2


        foreach ($moys as $student) {


            $moyEv2 = Moyennes::where('student_id', $student->student->id)->where('evaluation_id', $idEval2)->where('session', $session)
                ->where('codeEtab', $codeEtab)->first('valeur');

            $this->fpdf->SetX(108);
            $this->fpdf->SetFont('Arial', 'B', 7);
            $this->fpdf->MultiCell(11, 6, $moyEv2->valeur, 1, 'C');
        }

        // Moyenne trimstre


        $this->fpdf->SetY(102);

        foreach ($moys as $student) {

            $this->fpdf->SetX(119);
            $this->fpdf->SetFont('Arial', 'B', 7);


            $this->fpdf->MultiCell(13, 6, $student->valeur, 1, 'C');
        }


        // // Rang Trimestre


        $this->fpdf->SetY(102);

        foreach ($moys as $key => $student) {

            $moy = MoyenneTrimestres::where('classe_id', $IdClasse)->where('trimestre_id', $IdTrimmestre)->where('session', $session)
                ->where('codeEtab', $codeEtab)->orderBy('valeur', 'DESC')->get();


            $this->fpdf->SetX(132);
            $this->fpdf->SetFont('Arial', 'B', 7);

            $this->fpdf->MultiCell(13, 6,  $key + 1, 1, 'C');
        }

        $this->fpdf->SetY(102);

        foreach ($moys as $student) {

            $this->fpdf->SetX(145);
            $this->fpdf->SetFont('Arial', 'B', 7);
            $this->fpdf->MultiCell(7, 6, '', 1, 'C');
        }



        $this->fpdf->SetY(102);

        foreach ($moys as $student) {

            $this->fpdf->SetX(152);
            $this->fpdf->SetFont('Arial', 'B', 7);
            $this->fpdf->MultiCell(7, 6, '', 1, 'C');
        }




        $this->fpdf->SetY(102);

        foreach ($moys as $student) {

            $this->fpdf->SetX(159);
            $this->fpdf->SetFont('Arial', 'B', 7);
            $this->fpdf->MultiCell(7, 6, '', 1, 'C');
        }


        $this->fpdf->SetY(102);

        foreach ($moys as $student) {

            $this->fpdf->SetX(166);
            $this->fpdf->SetFont('Arial', 'B', 7);
            $this->fpdf->MultiCell(7, 6, '', 1, 'C');
        }

        $this->fpdf->SetY(102);

        foreach ($moys as $student) {

            $this->fpdf->SetX(173);
            $this->fpdf->SetFont('Arial', 'B', 7);
            $this->fpdf->MultiCell(7, 6, '', 1, 'C');
        }

        $this->fpdf->SetY(102);

        foreach ($moys as $student) {

            $this->fpdf->SetX(180);
            $this->fpdf->SetFont('Arial', 'B', 7);
            $this->fpdf->MultiCell(7, 6, '', 1, 'C');
        }

        $this->fpdf->SetY(102);

        foreach ($moys as $student) {

            $this->fpdf->SetX(187);
            $this->fpdf->SetFont('Arial', 'B', 7);
            $this->fpdf->MultiCell(7, 6, '', 1, 'C');
        }

        $this->fpdf->SetY(102);

        foreach ($moys as $student) {

            $this->fpdf->SetX(194);
            $this->fpdf->SetFont('Arial', 'B', 7);
            $this->fpdf->MultiCell(27, 6, '', 1, 'C');
        }













        $this->fpdf->Output();

        exit;
    }

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

        $this->fpdf->SetFont('Arial', 'B', 18);

        $this->fpdf->Text(37, 70, utf8_decode(" PROCES VERBAL ANNUEL DE CONSEIL DE CLASSE "));

        $this->fpdf->SetFont('Arial', 'B', 8);

        $this->fpdf->line(25, 84, 38, 84); // trait souligne classe

        $moys = MoyenneAnnuelle::with('student')->where('classe_id', $IdClasse)->where('session', $session)
            ->where('codeEtab', $codeEtab)->where('valeur', '>', 0)->orderBy('valeur', 'DESC')->get();

        $effectif = count($moys);

        $this->fpdf->Text(25, 82, utf8_decode("CLASSE :  $code->libelleClasse"));

        $this->fpdf->Text(150, 82, utf8_decode("Effectif : $effectif "));

        $this->fpdf->line(150, 84, 160, 84); // trait souligne Effectif



        $this->fpdf->SetXY(1, 90);
        $this->fpdf->SetFont('Arial', 'B', 8);
        // $this->fpdf->SetDrawColor(0, 0, 0);
        // $this->fpdf->SetFillColor('10', '75', '168');
        // $this->fpdf->SetTextColor('0', '0', '0');
        $this->fpdf->Cell(7, 12, utf8_decode('Nº'), 1, 0, 'L', 0);
        $this->fpdf->Cell(60, 12, 'NOMS et PRENOMS', 1, 0, 'C', 0);
        $this->fpdf->SetFont('Arial', 'B', 6);
        $this->fpdf->Cell(14, 12, 'NE(E) LE ', 1, 0, 'C', 0);
        $this->fpdf->SetFont('Arial', 'B', 5);
        $this->fpdf->Cell(7, 12, 'SEXE', 1, 0, 'L', 0);
        $this->fpdf->SetFont('Arial', 'B', 6);
        $this->fpdf->Cell(6, 12, 'N/R', 1, 0, 'C', 0);

        $this->fpdf->Cell(80, 6, '' . strtoupper('TRAVAIL'), 1, 0, 'C', 0);
        $this->fpdf->Cell(28, 6, '' . strtoupper('DISCIPLINE'), 1, 0, 'C', 0);


        $classeData = Student::with('user', 'classe')->where('classe_id', $IdClasse)
            ->where('session', $session)->where('codeEtab', $codeEtab)->orderBy('nom', 'ASC')->orderBy('prenom', 'ASC')->get();



        // dd($effectif);


        $this->fpdf->SetXY(95, 96);
        $this->fpdf->Cell(11, 6, " MOY T$idEval1", 1, 0, 'C', 0);
        $this->fpdf->Cell(11, 6, " MOY T$idEval2", 1, 0, 'C', 0);
        $this->fpdf->Cell(11, 6, " MOY T$idEval3", 1, 0, 'C', 0);

        $this->fpdf->Cell(13, 6, " ANNUELLE", 1, 0, 'C', 0);
        $this->fpdf->Cell(13, 6, "RANG", 1, 0, 'L', 0);
        $this->fpdf->Cell(7, 6, "AVT", 1, 0, 'C', 0);
        $this->fpdf->Cell(7, 6, "BLT", 1, 0, 'C', 0);
        $this->fpdf->Cell(7, 6, "TH", 1, 0, 'C', 0);

        $this->fpdf->Cell(7, 6, "ANJ", 1, 0, 'C', 0);
        $this->fpdf->Cell(7, 6, "AVC", 1, 0, 'C', 0);
        $this->fpdf->Cell(7, 6, "BLC", 1, 0, 'C', 0);
        $this->fpdf->Cell(7, 6, "JE", 1, 0, 'C', 0);

        $this->fpdf->SetXY(203, 90);

        $this->fpdf->Cell(21, 12, 'DECISION CONSEIL', 1, 0, 'L', 0);

        $this->fpdf->SetY(102);


        foreach ($moys as $key => $student) {

            $this->fpdf->SetX(1);
            $this->fpdf->SetFont('Arial', 'B', 8);
            $this->fpdf->MultiCell(7, 6, $key + 1, 1, 'L');
        }

        $this->fpdf->SetY(102);

        foreach ($moys as $student) {

            $this->fpdf->SetX(8);
            $this->fpdf->SetFont('Arial', 'B', 7);
            $this->fpdf->MultiCell(60, 6, utf8_decode($student->student->nom . ' ' . $student->student->prenom), 1, 'L');
        }


        $this->fpdf->SetY(102);

        foreach ($moys as $student) {

            $this->fpdf->SetX(68);
            $this->fpdf->SetFont('Arial', 'B', 6);
            $this->fpdf->MultiCell(14, 6, utf8_decode(date_format(date_create($student->student->dateNaiss), "d/m/Y")), 1, 'L');
        }


        $this->fpdf->SetY(102);

        foreach ($moys as $student) {

            $this->fpdf->SetX(82);
            $this->fpdf->SetFont('Arial', 'B', 7);
            $this->fpdf->MultiCell(7, 6, $student->student->sexe, 1, 'C');
        }



        $this->fpdf->SetY(102);


        foreach ($moys as $student) {

            $this->fpdf->SetX(89);
            $this->fpdf->SetFont('Arial', 'B', 7);

            if ($student->student->doublant == 'Nouveau') {

                $student->doublant = "N";
            } else {

                $student->doublant = "F";
            }
            $this->fpdf->MultiCell(6, 6, $student->doublant, 1, 'C');
        }

        $this->fpdf->SetY(102);

        // MOY EV 1

        foreach ($moys as $student) {

            $moyEv1 = MoyenneTrimestres::where('student_id', $student->student->id)->where('trimestre_id', $idEval1)->where('session', $session)
                ->where('codeEtab', $codeEtab)->first('valeur');

            $this->fpdf->SetX(95);
            $this->fpdf->SetFont('Arial', 'B', 7);

            if ($moyEv1->valeur == 0) {
                $this->fpdf->MultiCell(11, 6, "-", 1, 'C');
            } else {

                $this->fpdf->MultiCell(11, 6,  $moyEv1->valeur, 1, 'C');
            }
        }


        $this->fpdf->SetY(102);

        // MOY EV 2


        foreach ($moys as $student) {


            $moyEv2 =
                MoyenneTrimestres::where('student_id', $student->student->id)->where('trimestre_id', $idEval2)->where('session', $session)
                ->where('codeEtab', $codeEtab)->first('valeur');

            $this->fpdf->SetX(106);
            $this->fpdf->SetFont('Arial', 'B', 7);
            $this->fpdf->MultiCell(11, 6, $moyEv2->valeur, 1, 'C');
        }


        $this->fpdf->SetY(102);

        // MOY EV 3


        foreach ($moys as $student) {


            $moyEv3 =
                MoyenneTrimestres::where('student_id', $student->student->id)->where('trimestre_id', $idEval3)->where('session', $session)
                ->where('codeEtab', $codeEtab)->first('valeur');

            $this->fpdf->SetX(117);
            $this->fpdf->SetFont('Arial', 'B', 7);
            $this->fpdf->MultiCell(11, 6, $moyEv3->valeur, 1, 'C');
        }


        $this->fpdf->SetY(102);

        foreach ($moys as $student) {

            $moyEAnn = MoyenneAnnuelle::where('student_id', $student->student->id)->where('session', $session)
                ->where('codeEtab', $codeEtab)->first('valeur');

            $this->fpdf->SetX(128);
            $this->fpdf->SetFont('Arial', 'B', 7);
            $this->fpdf->MultiCell(13, 6, $moyEAnn->valeur, 1, 'C');
        }


        // Rang Annuel


        $this->fpdf->SetY(102);

        foreach ($moys as $key => $student) {

            $moy = MoyenneAnnuelle::where('student_id', $student->id)->where('classe_id', $IdClasse)->where('session', $session)
                ->where('codeEtab', $codeEtab)->orderBy('valeur', 'DESC')->get();


            $this->fpdf->SetX(141);
            $this->fpdf->SetFont('Arial', 'B', 7);

            $this->fpdf->MultiCell(13, 6,  $key + 1, 1, 'C');
        }







        $this->fpdf->SetY(102);

        foreach ($classeData as $student) {

            $this->fpdf->SetX(154);
            $this->fpdf->SetFont('Arial', 'B', 7);
            $this->fpdf->MultiCell(7, 6, '', 1, 'C');
        }



        $this->fpdf->SetY(102);

        foreach ($classeData as $student) {

            $this->fpdf->SetX(161);
            $this->fpdf->SetFont('Arial', 'B', 7);
            $this->fpdf->MultiCell(7, 6, '', 1, 'C');
        }




        $this->fpdf->SetY(102);

        foreach ($classeData as $student) {

            $this->fpdf->SetX(168);
            $this->fpdf->SetFont('Arial', 'B', 7);
            $this->fpdf->MultiCell(7, 6, '', 1, 'C');
        }


        $this->fpdf->SetY(102);

        foreach ($classeData as $student) {

            $this->fpdf->SetX(175);
            $this->fpdf->SetFont('Arial', 'B', 7);
            $this->fpdf->MultiCell(7, 6, '', 1, 'C');
        }

        $this->fpdf->SetY(102);

        foreach ($classeData as $student) {

            $this->fpdf->SetX(182);
            $this->fpdf->SetFont('Arial', 'B', 7);
            $this->fpdf->MultiCell(7, 6, '', 1, 'C');
        }

        $this->fpdf->SetY(102);

        foreach ($classeData as $student) {

            $this->fpdf->SetX(189);
            $this->fpdf->SetFont('Arial', 'B', 7);
            $this->fpdf->MultiCell(7, 6, '', 1, 'C');
        }

        $this->fpdf->SetY(102);

        foreach ($classeData as $student) {

            $this->fpdf->SetX(196);
            $this->fpdf->SetFont('Arial', 'B', 7);
            $this->fpdf->MultiCell(7, 6, '', 1, 'C');
        }



        $this->fpdf->SetY(102);

        foreach ($classeData as $student) {

            $this->fpdf->SetX(203);
            $this->fpdf->SetFont('Arial', 'B', 7);
            $this->fpdf->MultiCell(21, 6, '', 1, 'C');
        }


        $this->fpdf->Output();

        exit;
    }


    // public function getAllProcesVerbalTrimestre($idClasse)



    // {

    //     $conf = config::first();

    //     $entete = $conf->header;


    //     // IdEvalauation = IdTrimestre (normalement)

    //     $data =  explode('*', $idClasse);
    //     $IdClasse = $data[0];
    //     $IdTrimmestre  = $data[1];

    //     $code = Classe::where('id', $IdClasse)->first();
    //     $codeEtab = $code->codeEtabClasse;
    //     $session = $code->sessionClasse;



    //     $Evalutions = Evaluations::with('trimestre')->where('trimestre_id', $IdTrimmestre)->where('session', $session)
    //         ->where('codeEtab', $codeEtab)->get();



    //     $idEval1 = $Evalutions[0]->id;
    //     $libelleEval1 = $Evalutions[0]->libelle;

    //     $idEval2 = $Evalutions[1]->id;
    //     $libelleEval2 = $Evalutions[1]->libelle;

    //     $libelleTrimestre = $Evalutions[0]->trimestre->libelle_semes;


    //     $this->fpdf->AddPage("P", ['375', '225']);

    //     // $this->fpdf->SetTextColor('44', '53', '61');

    //     $this->fpdf->SetXY(58, 50);
    //     $this->fpdf->Cell(100, 6, '', 1);

    //     $this->fpdf->SetFont('Arial', 'B', 9);

    //     $this->fpdf->Text(89, 54, utf8_decode("ANNEE SCOLAIRE : $session "));


    //     $this->fpdf->Image(public_path("/Photos/Logos/" . $entete), 5, 8, 215, 35, "");

    //     $this->fpdf->SetFont('Arial', 'B', 18);

    //     $this->fpdf->Text(37, 70, utf8_decode(" PROCES VERBAL DE CONSEIL DE CLASSE "));

    //     $this->fpdf->SetFont('Arial', 'B', 8);

    //     $this->fpdf->line(25, 84, 38, 84); // trait souligne classe



    //     $this->fpdf->Text(25, 82, utf8_decode("CLASSE :  $code->libelleClasse"));

    //     $this->fpdf->Text(150, 82, utf8_decode("TRIMESTRE :  $IdTrimmestre "));

    //     $this->fpdf->line(150, 84, 168, 84); // trait souligne trimstre



    //     $this->fpdf->SetXY(3, 90);
    //     $this->fpdf->SetFont('Arial', 'B', 8);
    //     // $this->fpdf->SetDrawColor(0, 0, 0);
    //     // $this->fpdf->SetFillColor('10', '75', '168');
    //     // $this->fpdf->SetTextColor('0', '0', '0');
    //     $this->fpdf->Cell(7, 12, utf8_decode('Nº'), 1, 0, 'L', 0);
    //     $this->fpdf->Cell(60, 12, 'NOMS et PRENOMS', 1, 0, 'C', 0);
    //     $this->fpdf->SetFont('Arial', 'B', 6);
    //     $this->fpdf->Cell(14, 12, 'NE(E) LE ', 1, 0, 'C', 0);
    //     $this->fpdf->SetFont('Arial', 'B', 5);
    //     $this->fpdf->Cell(7, 12, 'SEXE', 1, 0, 'L', 0);
    //     $this->fpdf->SetFont('Arial', 'B', 6);
    //     $this->fpdf->Cell(6, 12, 'N / R', 1, 0, 'C', 0);

    //     $this->fpdf->Cell(69, 6, '' . strtoupper('TRAVAIL'), 1, 0, 'C', 0);
    //     $this->fpdf->Cell(28, 6, '' . strtoupper('DISCIPLINE'), 1, 0, 'C', 0);

    //     $idEv1 = $idEval1 - 1;
    //     $idEv2 = $idEval2 - 1;

    //     $classeData = Student::with('user', 'classe')->where('classe_id', $IdClasse)->where('id', '<', 314)
    //         ->where('session', $session)->where('codeEtab', $codeEtab)->orderBy('nom', 'ASC')->orderBy('prenom', 'ASC')->get();

    //     $effectif = count($classeData);


    //     $this->fpdf->SetXY(97, 96);
    //     $this->fpdf->Cell(11, 6, " MOY EV$idEv1", 1, 0, 'C', 0);
    //     $this->fpdf->Cell(11, 6, " MOY EV$idEv2", 1, 0, 'C', 0);
    //     $this->fpdf->Cell(13, 6, " MOY TRIM", 1, 0, 'C', 0);
    //     $this->fpdf->Cell(13, 6, "RANG / $effectif", 1, 0, 'L', 0);
    //     $this->fpdf->Cell(7, 6, "AVT", 1, 0, 'C', 0);
    //     $this->fpdf->Cell(7, 6, "BLT", 1, 0, 'C', 0);
    //     $this->fpdf->Cell(7, 6, "TH", 1, 0, 'C', 0);

    //     $this->fpdf->Cell(7, 6, "ANJ", 1, 0, 'C', 0);
    //     $this->fpdf->Cell(7, 6, "AVC", 1, 0, 'C', 0);
    //     $this->fpdf->Cell(7, 6, "BLC", 1, 0, 'C', 0);
    //     $this->fpdf->Cell(7, 6, "JE", 1, 0, 'C', 0);

    //     $this->fpdf->SetXY(194, 90);

    //     $this->fpdf->Cell(27, 12, 'DECISION DU CONSEIL', 1, 0, 'L', 0);

    //     $this->fpdf->SetY(102);


    //     foreach ($classeData as $key => $student) {

    //         $this->fpdf->SetX(3);
    //         $this->fpdf->SetFont('Arial', 'B', 8);
    //         $this->fpdf->MultiCell(7, 6, $key + 1, 1, 'L');
    //     }

    //     $this->fpdf->SetY(102);

    //     foreach ($classeData as $student) {

    //         $this->fpdf->SetX(10);
    //         $this->fpdf->SetFont('Arial', 'B', 7);
    //         $this->fpdf->MultiCell(60, 6, utf8_decode($student->nom . ' ' . $student->prenom), 1, 'L');
    //     }


    //     $this->fpdf->SetY(102);

    //     foreach ($classeData as $student) {

    //         $this->fpdf->SetX(70);
    //         $this->fpdf->SetFont('Arial', 'B', 6);
    //         $this->fpdf->MultiCell(14, 6, utf8_decode(date_format(date_create($student->dateNaiss), "d/m/Y")), 1, 'L');
    //     }


    //     $this->fpdf->SetY(102);

    //     foreach ($classeData as $student) {

    //         $this->fpdf->SetX(84);
    //         $this->fpdf->SetFont('Arial', 'B', 7);
    //         $this->fpdf->MultiCell(7, 6, $student->sexe, 1, 'C');
    //     }



    //     $this->fpdf->SetY(102);


    //     foreach ($classeData as $student) {

    //         $this->fpdf->SetX(91);
    //         $this->fpdf->SetFont('Arial', 'B', 7);

    //         if ($student->doublant == 'Nouveau') {

    //             $student->doublant = "N";
    //         } else {

    //             $student->doublant = "F";
    //         }
    //         $this->fpdf->MultiCell(6, 6, $student->doublant, 1, 'C');
    //     }

    //     $this->fpdf->SetY(102);

    //     // MOY EV 1

    //     foreach ($classeData as $student) {

    //         $moyEv1 = Moyennes::where('student_id', $student->id)->where('evaluation_id', $idEval1)->where('session', $session)
    //             ->where('codeEtab', $codeEtab)->first('valeur');

    //         $this->fpdf->SetX(97);
    //         $this->fpdf->SetFont('Arial', 'B', 7);
    //         $this->fpdf->MultiCell(11, 6,  $moyEv1->valeur, 1, 'C');
    //     }


    //     $this->fpdf->SetY(102);

    //     // MOY EV 2


    //     foreach ($classeData as $student) {


    //         $moyEv2 = Moyennes::where('student_id', $student->id)->where('evaluation_id', $idEval2)->where('session', $session)
    //             ->where('codeEtab', $codeEtab)->first('valeur');

    //         $this->fpdf->SetX(108);
    //         $this->fpdf->SetFont('Arial', 'B', 7);
    //         $this->fpdf->MultiCell(11, 6, $moyEv2->valeur, 1, 'C');
    //     }


    //     $this->fpdf->SetY(102);

    //     foreach ($classeData as $student) {

    //         $moyEv2 = MoyenneTrimestres::where('student_id', $student->id)->where('trimestre_id', $IdTrimmestre)->where('session', $session)
    //             ->where('codeEtab', $codeEtab)->first('valeur');

    //         $this->fpdf->SetX(119);
    //         $this->fpdf->SetFont('Arial', 'B', 7);
    //         $this->fpdf->MultiCell(13, 6, $moyEv2->valeur, 1, 'C');
    //     }


    //     // Rang Trimestre


    //     $this->fpdf->SetY(102);

    //     foreach ($classeData as $student) {

    //         $moy = MoyenneTrimestres::where('classe_id', $IdClasse)->where('trimestre_id', $IdTrimmestre)->where('session', $session)
    //             ->where('codeEtab', $codeEtab)->orderBy('valeur', 'DESC')->get();


    //         foreach ($moy as $key => $num) {

    //             if ($num->student_id == $student->id) {

    //                 $rang[$student->id] = $key + 1;
    //             }
    //         }


    //         $this->fpdf->SetX(132);
    //         $this->fpdf->SetFont('Arial', 'B', 7);
    //         $this->fpdf->MultiCell(13, 6, $rang[$student->id], 1, 'C');
    //     }

    //     $this->fpdf->SetY(102);

    //     foreach ($classeData as $student) {

    //         $this->fpdf->SetX(145);
    //         $this->fpdf->SetFont('Arial', 'B', 7);
    //         $this->fpdf->MultiCell(7, 6, '', 1, 'C');
    //     }



    //     $this->fpdf->SetY(102);

    //     foreach ($classeData as $student) {

    //         $this->fpdf->SetX(152);
    //         $this->fpdf->SetFont('Arial', 'B', 7);
    //         $this->fpdf->MultiCell(7, 6, '', 1, 'C');
    //     }




    //     $this->fpdf->SetY(102);

    //     foreach ($classeData as $student) {

    //         $this->fpdf->SetX(159);
    //         $this->fpdf->SetFont('Arial', 'B', 7);
    //         $this->fpdf->MultiCell(7, 6, '', 1, 'C');
    //     }


    //     $this->fpdf->SetY(102);

    //     foreach ($classeData as $student) {

    //         $this->fpdf->SetX(166);
    //         $this->fpdf->SetFont('Arial', 'B', 7);
    //         $this->fpdf->MultiCell(7, 6, '', 1, 'C');
    //     }

    //     $this->fpdf->SetY(102);

    //     foreach ($classeData as $student) {

    //         $this->fpdf->SetX(173);
    //         $this->fpdf->SetFont('Arial', 'B', 7);
    //         $this->fpdf->MultiCell(7, 6, '', 1, 'C');
    //     }

    //     $this->fpdf->SetY(102);

    //     foreach ($classeData as $student) {

    //         $this->fpdf->SetX(180);
    //         $this->fpdf->SetFont('Arial', 'B', 7);
    //         $this->fpdf->MultiCell(7, 6, '', 1, 'C');
    //     }

    //     $this->fpdf->SetY(102);

    //     foreach ($classeData as $student) {

    //         $this->fpdf->SetX(187);
    //         $this->fpdf->SetFont('Arial', 'B', 7);
    //         $this->fpdf->MultiCell(7, 6, '', 1, 'C');
    //     }

    //     $this->fpdf->SetY(102);

    //     foreach ($classeData as $student) {

    //         $this->fpdf->SetX(194);
    //         $this->fpdf->SetFont('Arial', 'B', 7);
    //         $this->fpdf->MultiCell(27, 6, '', 1, 'C');
    //     }


    //     $this->fpdf->Output();

    //     exit;
    // }


    public function NonInsolvablesPdf($idClasse)


    {
        $conf = config::first();

        $entete = $conf->header;


        $session = Session::where('encours_sess', 1)->first();

        $sessionEncour = $session->libelle_sess;

        $codeEtab = $session->codeEtab_sess;

        // La classe et le total de ses finances


        $classesInfos = Classe::where('id', $idClasse)->first();

        $etab =  Etablissement::where('codeEtab', $codeEtab)->first();



        // Liste de ceux qui ont tout paye  c-a-d statut==2


        $datas = Student::with('classe')->where('classe_id', $idClasse)
            ->where('codeEtab', $codeEtab)
            ->where('session', $sessionEncour)->where('statut', 2)
            ->orderBy('nom')->orderBy('prenom')->get();


        // nombre inscrits


        $datasNombre  = Student::with('classe')->where('classe_id', $idClasse)
            ->where('codeEtab', $codeEtab)
            ->where('session', $sessionEncour)->where('statut', 2)
            ->orderBy('nom')->orderBy('prenom')->count();


        // nombre eleve


        $datasEffectif = Student::with('classe')->where('classe_id', $idClasse)
            ->where('codeEtab', $codeEtab)
            ->where('session', $sessionEncour)
            ->orderBy('nom')->orderBy('prenom')->count();

        // en regles


        $vonRedevables = $datasEffectif - $datasNombre;


        foreach ($datas as $data) {


            $tranche1 = Versements::where('classe_id', $idClasse)->where('student_id', $data->id)->where('motif', 'tranche1')

                ->where('codeEtab', $codeEtab)->where('session', $sessionEncour)->sum('montantverser');


            $tranche2 = Versements::where('classe_id', $idClasse)->where('student_id', $data->id)->where('motif', 'tranche2')

                ->where('codeEtab', $codeEtab)->where('session',  $sessionEncour)->sum('montantverser');

            $ape = Versements::where('classe_id', $idClasse)->where('student_id', $data->id)->where('motif', 'APE')

                ->where('codeEtab', $codeEtab)->where('session', $sessionEncour)->sum('montantverser');

            $datasTranches[$data->id] =  array(

                'tranche1' =>  $tranche1,
                'tranche2' =>  $tranche2,
                'ape' =>  $ape,

            );

            $data['scolarite'] = $datasTranches[$data->id];
        }

        // La page en PDF


        $this->fpdf->AddPage("P", ['297', '210']);

        // $this->fpdf->SetTextColor('44', '53', '61');

        $this->fpdf->SetFont('Arial', 'B', 6);

        $this->fpdf->Text(80, 20, utf8_decode(" Année-scolaire : $classesInfos->sessionClasse"));

        $this->fpdf->SetFont('Arial', 'B', 20);


        // $this->fpdf->Text(65, 12, utf8_decode($etab->libelleEtab));

        $this->fpdf->Image(public_path("/Photos/Logos/" . $entete), 0, 0, 210, 27, "");



        $this->fpdf->SetXY(10, 27);
        $this->fpdf->Cell(175, 12, '', 1);

        $this->fpdf->SetFont('Arial', 'B', 15);

        $this->fpdf->Text(55, 35, utf8_decode("Liste des non redevables en $classesInfos->libelleClasse  "));

        $this->fpdf->SetFont('Arial', 'B', 10);
        $this->fpdf->Text(60, 46, utf8_decode("Non redevables : $datasNombre  ;  Insolvables : $vonRedevables  ;  Effectifs : $datasEffectif "));


        $this->fpdf->SetXY(10, 50);
        $this->fpdf->SetFont('Arial', 'B', 6);
        $this->fpdf->SetDrawColor(0, 0, 0);
        $this->fpdf->SetFillColor('10', '75', '168');
        $this->fpdf->SetTextColor('0', '0', '0');
        $this->fpdf->Cell(5, 6, '', 1, 0, 'L', 1);
        $this->fpdf->Cell(50, 6, 'Matricule', 1, 0, 'L', 1);
        $this->fpdf->Cell(60, 6, 'NOMS', 1, 0, 'L', 1);
        $this->fpdf->Cell(60, 6, 'PRENOMS', 1, 0, 'L', 1);
        // $this->fpdf->Cell(35, 6, 'Reste inscription', 1, 0, 'L', 1);
        // $this->fpdf->Cell(35, 6, 'Reste tranche 1', 1, 0, 'L', 1);
        // $this->fpdf->Cell(35, 6, 'Bilan tranche 2', 1, 0, 'L', 1);
        $this->fpdf->Ln();
        $this->fpdf->SetTextColor('0', '0', '0');

        $this->fpdf->SetFont('Arial', 'B', 8);

        foreach ($datas as $key => $eleve) {


            $this->fpdf->SetX(10);
            $this->fpdf->MultiCell(5, 6, $key + 1, 1, 'L');
        }

        $this->fpdf->SetY(56);

        foreach ($datas as $key => $eleve) {


            $this->fpdf->SetX(15);
            $this->fpdf->MultiCell(50, 6, $eleve->matricule, 1, 'L');
        }


        $this->fpdf->SetY(56);

        foreach ($datas as $key => $eleve) {

            $this->fpdf->SetX(65);
            $this->fpdf->MultiCell(60, 6, utf8_decode($eleve->nom), 1, 'L');
        }


        $this->fpdf->SetY(56);

        foreach ($datas as $key => $eleve) {

            $this->fpdf->SetX(125);

            $this->fpdf->MultiCell(60, 6, utf8_decode($eleve->prenom), 1, 'L');
        }













        $this->fpdf->Output();

        exit;


        // return response()->json($datas);
    }



    public function InsolvablesPdf($idClasse)


    {

        $conf = config::first();

        $entete = $conf->header;


        $session = Session::where('encours_sess', 1)->first();

        $sessionEncour = $session->libelle_sess;

        $codeEtab = $session->codeEtab_sess;

        // La classe et le total de ses finances


        $classesInfos = Classe::where('id', $idClasse)->first();

        $etab =  Etablissement::where('codeEtab', $codeEtab)->first();



        // Liste de ceux qui ont juste avance la pension c-a-d statut==1


        $datas = Student::with('classe')->where('classe_id', $idClasse)
            ->where('codeEtab', $codeEtab)
            ->where('session', $sessionEncour)->where('statut', '!=', 2)
            ->orderBy('nom')->orderBy('prenom')->get();


        // nombre non inscrits


        $datasNombre  = Student::with('classe')->where('classe_id', $idClasse)
            ->where('codeEtab', $codeEtab)
            ->where('session', $sessionEncour)->where('statut', '!=', 2)
            ->orderBy('nom')->orderBy('prenom')->count();


        // nombre eleve


        $datasEffectif = Student::with('classe')->where('classe_id', $idClasse)
            ->where('codeEtab', $codeEtab)
            ->where('session', $sessionEncour)
            ->orderBy('nom')->orderBy('prenom')->count();

        // en regles


        $vonRedevables = $datasEffectif - $datasNombre;


        foreach ($datas as $data) {


            $tranche1 = Versements::where('classe_id', $idClasse)->where('student_id', $data->id)->where('motif', 'tranche1')

                ->where('codeEtab', $codeEtab)->where('session', $sessionEncour)->sum('montantverser');


            $tranche2 = Versements::where('classe_id', $idClasse)->where('student_id', $data->id)->where('motif', 'tranche2')

                ->where('codeEtab', $codeEtab)->where('session',  $sessionEncour)->sum('montantverser');

            $ape = Versements::where('classe_id', $idClasse)->where('student_id', $data->id)->where('motif', 'APE')

                ->where('codeEtab', $codeEtab)->where('session', $sessionEncour)->sum('montantverser');

            $datasTranches[$data->id] =  array(

                'tranche1' =>  $tranche1,
                'tranche2' =>  $tranche2,
                'ape' =>  $ape,

            );

            $data['scolarite'] = $datasTranches[$data->id];
        }

        // La page en PDF


        $this->fpdf->AddPage("P", ['397', '210']);

        // $this->fpdf->SetTextColor('44', '53', '61');

        $this->fpdf->SetFont('Arial', 'B', 6);

        $this->fpdf->Text(80, 20, utf8_decode(" Année-scolaire : $classesInfos->sessionClasse"));

        $this->fpdf->SetFont('Arial', 'B', 20);


        // $this->fpdf->Text(65, 12, utf8_decode($etab->libelleEtab));

        $this->fpdf->Image(public_path("/Photos/Logos/" . $entete), 0, 0, 210, 20,  "");

        $TotalResteInscrip = 0;
        $TotalResteTranch1 = 0;
        $TotalResteTranch2 = 0;

        $this->fpdf->SetXY(20, 27);
        $this->fpdf->Cell(170, 12, '', 1);

        $this->fpdf->SetFont('Arial', 'B', 15);

        $this->fpdf->Text(55, 35, utf8_decode("  Liste des insolvables en $classesInfos->libelleClasse  "));

        $this->fpdf->SetFont('Arial', 'B', 10);

        $this->fpdf->Text(60, 46, utf8_decode("Insolvables : $datasNombre ; En regle  : $vonRedevables ; Effectifs : $datasEffectif "));



        $this->fpdf->SetXY(3, 50);
        $this->fpdf->SetFont('Arial', 'B', 6);
        $this->fpdf->SetDrawColor(0, 0, 0);
        $this->fpdf->SetFillColor('10', '75', '168');
        $this->fpdf->SetTextColor('0', '0', '0');
        $this->fpdf->Cell(5, 6, '', 1, 0, 'L', 1);
        $this->fpdf->Cell(60, 6, 'NOMS', 1, 0, 'L', 1);
        $this->fpdf->Cell(60, 6, 'PRENOMS', 1, 0, 'L', 1);
        $this->fpdf->Cell(20, 6, 'RESTE INSCRIP', 1, 0, 'L', 1);
        $this->fpdf->Cell(30, 6, 'RESTE T1', 1, 0, 'L', 1);
        $this->fpdf->Cell(30, 6, 'RESTE T2', 1, 0, 'L', 1);
        $this->fpdf->Ln();
        $this->fpdf->SetTextColor('0', '0', '0');

        $this->fpdf->SetFont('Arial', 'B', 6);



        foreach ($datas as $key => $eleve) {


            $this->fpdf->SetX(3);
            $this->fpdf->MultiCell(5, 6, $key + 1, 1, 'L');
        }

        $this->fpdf->SetY(56);

        $this->fpdf->SetFont('Arial', 'B', 8);


        foreach ($datas as $key => $eleve) {
            $this->fpdf->SetX(8);
            $this->fpdf->MultiCell(60, 6, $eleve->nom, 1, 'L');
        }


        $this->fpdf->SetY(56);

        foreach ($datas as $key => $eleve) {

            $this->fpdf->SetX(68);
            $this->fpdf->MultiCell(60, 6, utf8_decode($eleve->prenom), 1, 'L');
        }


        $this->fpdf->SetY(56);

        foreach ($datas as $key => $eleve) {

            $this->fpdf->SetX(128);


            $this->fpdf->MultiCell(20, 6,  utf8_decode($classesInfos->scolariteaff_Classe - $eleve->scolarite['ape']), 1, 'C');

            $TotalResteInscrip = $TotalResteInscrip + utf8_decode($classesInfos->scolariteaff_Classe - $eleve->scolarite['ape']);
        }

        $this->fpdf->SetY(56);

        foreach ($datas as $key => $eleve) {

            $this->fpdf->SetX(148);


            $this->fpdf->MultiCell(30, 6,  utf8_decode($classesInfos->scolarite_Classe - $eleve->scolarite['tranche1']), 1, 'C');

            $TotalResteTranch1 = $TotalResteTranch1 + utf8_decode($classesInfos->scolarite_Classe - $eleve->scolarite['tranche1']);
        }

        $this->fpdf->SetY(56);

        foreach ($datas as $key => $eleve) {

            $this->fpdf->SetX(178);


            $this->fpdf->MultiCell(30, 6,  utf8_decode($classesInfos->inscription_Classe - $eleve->scolarite['tranche2']), 1, 'C');

            $TotalResteTranch2 = $TotalResteTranch2 + utf8_decode($classesInfos->inscription_Classe - $eleve->scolarite['tranche2']);
        }


        $this->fpdf->SetFont('Arial', 'B', 10);
        $this->fpdf->SetX(8);
        $this->fpdf->Cell(120, 8, 'TOTAUX ', 1, 0, ' C');
        $this->fpdf->Cell(20, 8, $TotalResteInscrip, 1, 0, 'C');
        $this->fpdf->Cell(30, 8, $TotalResteTranch1, 1, 0, 'C');
        $this->fpdf->Cell(30, 8, $TotalResteTranch2, 1, 0, 'C');


        $this->fpdf->SetFont('Arial', 'B', 13);

        $this->fpdf->Output();

        exit;


        // return response()->json($datas);
    }



    public function getAllTBTrimestre($id)


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
            ->where('classe_id',  $IdClasse)->where('valeur', '>=', 12)->orderBy('valeur', 'DESC')->get();


        $classeStudent = Classe::where('id', $IdClasse)->first('libelleClasse');


        $conf = config::first();

        $entete = $conf->header;


        foreach ($moyData as $moy) {

            if ($moy->valeur >= 12 && $moy->valeur < 14) {

                $mention = "ENCOURAGEMENTS";
            }

            if ($moy->valeur >= 14 && $moy->valeur <= 20) {

                $mention = "FELICITATIONS";
            }

            $userData = Student::with('user')->where('id', $moy->student->id)->first();


            $this->fpdf->AddPage("L", ['210', '297']);


            $this->fpdf->Image(public_path("/Photos/Logos/" . $entete), 5, 3, 290, 65, "");

            $this->fpdf->Image(public_path("/Photos/Logos/footer.jpeg"), 0, 201, 340, 10,  "");






            // $this->fpdf->SetTextColor('44', '53', '61');

            // $this->fpdf->SetFont('Arial', 'B', 23);

            // $this->fpdf->Text(50, 20, utf8_decode("MINISTERE DES ENSEIGNEMENTS SECONDAIRES "));

            // $this->fpdf->SetFont('Arial', 'B', 15);


            // $this->fpdf->Text(75, 30, utf8_decode("*******************************************************************"));

            // $this->fpdf->Text(85, 40, utf8_decode("DELEGATION REGIONALE DU LITTORAL"));

            // $this->fpdf->Text(85, 50, utf8_decode("***************************************************"));
            // $this->fpdf->SetFont('Arial', 'B', 17);

            // $this->fpdf->Text(105, 60, utf8_decode($classeName->libelleEtab));

            // $this->fpdf->Text(110, 70, utf8_decode("*********************"));








            $this->fpdf->SetTextColor('255', '255', '255');
            $this->fpdf->SetFillColor('10', '75', '168');
            $this->fpdf->SetFont('Arial', 'B', 10);




            $this->fpdf->SetXY(0, 73);


            $this->fpdf->SetFont('Arial', 'B', 30);

            $this->fpdf->Cell(297, 17, "TABLEAU D'HONNEUR" . ' ', 0, 0, 'C', 1);


            $this->fpdf->SetTextColor('44', '53', '61');

            $this->fpdf->SetFont('Arial', 'I', 15);

            $this->fpdf->Text(10, 110, utf8_decode(" A  l'éleve  :  "));

            $this->fpdf->SetFont('Arial', 'B', 24);

            $this->fpdf->Text(75, 110, utf8_decode($moy->student->nom . " " . $moy->student->prenom));

            // *********************** //


            $this->fpdf->SetFont('Arial', 'I', 15);

            $this->fpdf->Text(10, 125, utf8_decode(" de la classe de :  "));

            $this->fpdf->SetFont('Arial', 'B', 27);

            $this->fpdf->SetTextColor('10', '75', '168');

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

            $this->fpdf->SetTextColor('10', '75', '168');

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


            $this->fpdf->Image(public_path("/Photos/Logos/" . $entete), 5, 3, 290, 65, "");

            if ($moy->valeur >= 13 && $moy->valeur <= 14) {


                $this->fpdf->Image(public_path("/Photos/Logos/footer4.png"), 0, 201, 340, 10,  "");
            }

            if ($moy->valeur >= 14 && $moy->valeur <= 20) {

                $this->fpdf->Image(public_path("/Photos/Logos/footer2.png"), 0, 201, 340, 10,  "");
            }




            // $this->fpdf->SetTextColor('44', '53', '61');

            // $this->fpdf->SetFont('Arial', 'B', 23);

            // $this->fpdf->Text(50, 20, utf8_decode("MINISTERE DES ENSEIGNEMENTS SECONDAIRES "));

            // $this->fpdf->SetFont('Arial', 'B', 15);


            // $this->fpdf->Text(75, 30, utf8_decode("*******************************************************************"));

            // $this->fpdf->Text(85, 40, utf8_decode("DELEGATION REGIONALE DU LITTORAL"));

            // $this->fpdf->Text(85, 50, utf8_decode("***************************************************"));
            // $this->fpdf->SetFont('Arial', 'B', 17);

            // $this->fpdf->Text(105, 60, utf8_decode($classeName->libelleEtab));

            // $this->fpdf->Text(110, 70, utf8_decode("*********************"));








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

        // $EleveData = Student::with('user)->where('codeEtab', $codeEtab)->where('session', $sessionEncour)->where('classe_id', $idclasse)->orderBy('id', 'desc')->get();

        $EleveData = Student::with('classe', 'user')->where('codeEtab', $codeEtab)->where('session', $sessionEncour)->where('classe_id',  $IdClasse)->orderBy('nom', 'asc')->orderBy('prenom', 'asc')->get();

        $Classes = Classe::where('codeEtabClasse', $codeEtab)->where('sessionClasse', $sessionEncour)->where('id',  $IdClasse)->first('libelleClasse');

        $classeName = Etablissement::where('codeEtab', $codeEtab)->first();

        // $libelleName = $classeName->libelleEtab;

        $this->fpdf->AddPage("P", ['397', '210']);

        $this->fpdf->Image(public_path("/Photos/Logos/" . $entete), 0, 0, 210, 27,  "");

        $this->fpdf->SetTextColor('10', '75', '168');
        $this->fpdf->SetFillColor('10', '75', '168');
        $this->fpdf->SetFont('Arial', 'B', 13);

        $this->fpdf->Cell(0, 70, utf8_decode("$Classes->libelleClasse en $sessionEncour "), 0, 0, 'C');

        $this->fpdf->SetY(20);

        $this->fpdf->SetFont('Arial', 'B', 10);

        // $this->fpdf->Cell(0, 70, utf8_decode("Année-scolaire : ") . utf8_decode($sessionEncour), 0, 0, 'C');


        $this->fpdf->Cell(0, 70, utf8_decode("Evaluation ........"), 0, 0, 'C');



        $this->fpdf->SetXY(10, 60);
        $this->fpdf->SetFont('Arial', 'B', 10);
        $this->fpdf->SetDrawColor(0, 0, 0);
        $this->fpdf->SetFillColor('10', '75', '168');
        $this->fpdf->SetTextColor('0', '0', '0');
        $this->fpdf->Cell(10, 10, '', 1, 0, 'C', 1);
        $this->fpdf->Cell(20, 10, 'Matricule', 1, 0, 'C', 1);
        $this->fpdf->Cell(70, 10, 'NOMS', 1, 0, 'L', 1);
        $this->fpdf->Cell(70, 10, 'PRENOMS', 1, 0, 'L', 1);
        $this->fpdf->Cell(20, 10, 'NOTE/20', 1, 0, 'L', 1);

        $this->fpdf->Ln();
        $this->fpdf->SetTextColor('0', '0', '0');


        foreach ($EleveData as $key => $eleve) {

            $this->fpdf->SetFont('Arial', 'B', 8);
            $this->fpdf->SetX(10);
            $this->fpdf->MultiCell(10, 5, $key + 1, 1, 'L');
        }

        $this->fpdf->SetY(70);


        $this->fpdf->SetFont('Arial', 'B', 7);



        foreach ($EleveData as $key => $eleve) {

            $this->fpdf->SetX(20);
            $this->fpdf->MultiCell(20, 5, utf8_decode($eleve->matricule), 1, 'L');
        }

        $this->fpdf->SetY(70);


        $this->fpdf->SetFont('Arial', 'B', 7);



        foreach ($EleveData as $key => $eleve) {

            $this->fpdf->SetX(40);
            $this->fpdf->MultiCell(70, 5, utf8_decode($eleve->nom), 1, 'L');
        }

        $this->fpdf->SetY(70);

        foreach ($EleveData as $key => $eleve) {

            $this->fpdf->SetX(110);
            $this->fpdf->MultiCell(70, 5, utf8_decode($eleve->prenom), 1, 'L');
        }

        $this->fpdf->SetY(70);

        foreach ($EleveData as $key => $eleve) {

            $this->fpdf->SetX(180);
            $this->fpdf->MultiCell(20, 5, utf8_decode(""), 1, 'L');
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

        // Recuperer les eleves d'une classes, on couple avec la table user pour pouvoir recuperer les photos

        // $EleveData = Student::with('user)->where('codeEtab', $codeEtab)->where('session', $sessionEncour)->where('classe_id', $idclasse)->orderBy('id', 'desc')->get();

        $EleveData = Student::with('classe', 'user')->where('codeEtab', $codeEtab)->where('session', $sessionEncour)->where('classe_id',  $IdClasse)->orderBy('nom', 'asc')->orderBy('prenom', 'asc')->get();

        $Classes = Classe::where('codeEtabClasse', $codeEtab)->where('sessionClasse', $sessionEncour)->where('id',  $IdClasse)->first('libelleClasse');

        $classeName = Etablissement::where('codeEtab', $codeEtab)->first();

        // $libelleName = $classeName->libelleEtab;

        $this->fpdf->AddPage("P", ['350', '210']);

        $this->fpdf->Image(public_path("/Photos/Logos/" . $entete), 0, 0, 210, 27,  "");

        $this->fpdf->SetTextColor('10', '75', '168');
        $this->fpdf->SetFillColor('10', '75', '168');
        $this->fpdf->SetFont('Arial', 'B', 13);

        //  $this->fpdf->Text(30, 50, "LISTE DE LA CLASSE DE ". ' '.$Classes->libelleClasse);


        $this->fpdf->Cell(0, 70, 'LISTE DE LA CLASSE DE : ' . ' ' . utf8_decode($Classes->libelleClasse), 0, 0, 'C');
        $this->fpdf->SetY(20);

        $this->fpdf->SetFont('Arial', 'B', 10);
        $this->fpdf->Cell(0, 70, utf8_decode("Année-scolaire : ") . utf8_decode($sessionEncour), 0, 0, 'C');


        $this->fpdf->SetXY(10, 60);
        $this->fpdf->SetFont('Arial', 'B', 10);
        $this->fpdf->SetDrawColor(0, 0, 0);
        $this->fpdf->SetFillColor('10', '75', '168');
        $this->fpdf->SetTextColor('0', '0', '0');
        $this->fpdf->Cell(10, 10, '', 1, 0, 'C', 1);
        $this->fpdf->Cell(20, 10, 'Matricule', 1, 0, 'C', 1);
        $this->fpdf->Cell(80, 10, 'NOMS', 1, 0, 'L', 1);
        $this->fpdf->Cell(80, 10, 'PRENOMS', 1, 0, 'L', 1);
        $this->fpdf->Ln();
        $this->fpdf->SetTextColor('0', '0', '0');


        foreach ($EleveData as $key => $eleve) {

            $this->fpdf->SetFont('Arial', 'B', 8);
            $this->fpdf->SetX(10);
            $this->fpdf->MultiCell(10, 5, $key + 1, 1, 'L');
        }

        $this->fpdf->SetY(70);


        $this->fpdf->SetFont('Arial', 'B', 7);



        foreach ($EleveData as $key => $eleve) {

            $this->fpdf->SetX(20);
            $this->fpdf->MultiCell(20, 5, utf8_decode($eleve->matricule), 1, 'L');
        }

        $this->fpdf->SetY(70);


        $this->fpdf->SetFont('Arial', 'B', 7);



        foreach ($EleveData as $key => $eleve) {

            $this->fpdf->SetX(40);
            $this->fpdf->MultiCell(80, 5, utf8_decode($eleve->nom), 1, 'L');
        }

        $this->fpdf->SetY(70);

        foreach ($EleveData as $key => $eleve) {

            $this->fpdf->SetX(120);
            $this->fpdf->MultiCell(80, 5, utf8_decode($eleve->prenom), 1, 'L');
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


        $this->fpdf->AddPage("P", ['310', '148']);

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


        $this->fpdf->Text(105, 35, utf8_decode("ANNEE SCOLAIRE : " . utf8_decode($session)));


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

        $classeData = Student::where('classe_id', $IdClasse)->where('session', $sessionEncour)->where('codeEtab', $codeEtab)->orderBy('nom', 'asc')->orderBy('prenom', 'asc')->get();


        foreach ($classeData as $key => $data) {


            $this->fpdf->AddPage("L", ['90', '60']);

            $fr = 7;
            $en = 5;



            $this->fpdf->Image(public_path("/Photos/Logos/" . $entete), 0, 0, 90, 15,  "");



            $this->fpdf->Ln(1);

            $this->fpdf->SetFont('Arial', 'B', 7);
            $this->fpdf->SetTextColor('10', '75', '168');

            $this->fpdf->Cell(0, 13, utf8_decode($classeName->libelleEtab), 0, 0, 'C');

            $this->fpdf->SetFont('Arial', 'B', 6);

            $this->fpdf->Text(33, 22, utf8_decode("Carte d'identité scolaire"));


            $this->fpdf->Ln(2);

            $this->fpdf->SetTextColor('44', '53', '61');



            $this->fpdf->SetFont('Arial', 'B', 8);

            if (file_exists(public_path("/Photos/Logos/" . $data->user->photo))) {


                $this->fpdf->Image(
                    public_path("/Photos/Logos/" . $data->user->photo),
                    3,
                    25,
                    15,
                    19,
                    ""
                );
            }




            // informations eleves

            // $this->fpdf->RotatedText(35,190,'texte filigrane',45);


            $this->fpdf->SetFont('Arial', 'IB', 5);
            $this->fpdf->Text(20, 26, utf8_decode("Année-Scolaire : "));
            $this->fpdf->SetFont('Arial', 'I', 6);
            $this->fpdf->Text(34, 26, $data->session);

            $this->fpdf->SetFont('Arial', 'IB', 5);
            $this->fpdf->Text(20, 29, "Matricule : ");
            $this->fpdf->SetFont('Arial', 'I', 6);
            $this->fpdf->Text(30, 29, $data->matricule);

            $this->fpdf->SetFont('Arial', 'IB', 5);
            $this->fpdf->Text(20, 32, utf8_decode("Noms et prénoms : "));
            $this->fpdf->SetFont('Arial', 'I', 5);
            $this->fpdf->Text(37, 32, utf8_decode($data->nom) . ' ' . utf8_decode($data->prenom));

            // $this->fpdf->SetFont('Arial', 'IB', 5);
            // $this->fpdf->Text(20, 35, "Prenom : ");
            // $this->fpdf->SetFont('Arial', 'IB', 6);
            // $this->fpdf->Text(40, 35, utf8_decode($data->prenom));

            $this->fpdf->SetFont('Arial', 'IB', 5);
            $this->fpdf->Text(20, 35, "Date de et lieu de naissance : ");
            $this->fpdf->SetFont('Arial', 'I', 5);
            $this->fpdf->Text(45, 35, date_format(date_create($data->dateNaiss), "d-m-Y") . " " . utf8_decode("à $data->lieuNaiss"));

            // $data->dateNaiss
            // $this->fpdf->SetFont('Arial', 'IB', 5);
            // $this->fpdf->Text(20, 41, "Lieu de naissance : ");
            // $this->fpdf->SetFont('Arial', 'I', 6);
            // $this->fpdf->Text(48, 41, utf8_decode($data->lieuNaiss).''.);


            $this->fpdf->SetFont('Arial', 'IB', 5);
            $this->fpdf->Text(20, 38, "Sexe : ");
            $this->fpdf->SetFont('Arial', 'I', 6);
            $this->fpdf->Text(26, 38, $data->sexe);


            $this->fpdf->SetFont('Arial', 'IB', 5);
            $this->fpdf->Text(20, 41, "Classe : ");
            $this->fpdf->SetFont('Arial', 'I', 6);
            $this->fpdf->Text(27, 41, utf8_decode($data->Classe->libelleClasse));



            $this->fpdf->SetFont('Arial', 'IB', 5);
            $this->fpdf->Text(20, 44, "Parent  : ");
            $this->fpdf->SetFont('Arial', 'I', 5);
            // $this->fpdf->Text(28, 44, utf8_decode($data->Parent->nomParent . ' ' . $data->Parent->prenomParent . ' - ' . $data->Parent->telParent));

            $this->fpdf->Text(28, 44, utf8_decode($data->Parent->telParent));

            $this->fpdf->SetFont('Arial', 'IB', 5);
            //  $this->fpdf->Text(20, 47, "Tel parent : ");
            $this->fpdf->SetFont('Arial', 'I', 6);
            //  $this->fpdf->Text(30, 47, utf8_decode($data->Parent->telParent));


            $this->fpdf->SetFont('Arial', 'IB', 5);
            // $this->fpdf->Text(32, 50, utf8_decode("Téléphone du parent : "));
            // $this->fpdf->SetFont('Arial', 'I', 6);
            // $this->fpdf->Text(50, 50, $data->Parent->telParent);

            $this->fpdf->Text(64, 50, utf8_decode("Le chef d'établissement "));

            $this->fpdf->Image(public_path("/Photos/Logos/footer.jpeg"), 0, 56, 90, 4);

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

        $this->fpdf->AddPage("L", ['86', '55']);

        $fr = 7;
        $en = 5;
        $this->fpdf->Image(public_path("/Photos/Logos/" . $entete), 0, 0, 86, 15,  "");

        $this->fpdf->Ln(2);

        $this->fpdf->SetFont('Arial', 'B', 10);
        $this->fpdf->SetTextColor('10', '75', '168');

        $this->fpdf->Cell(0, 10, utf8_decode($classeName->libelleEtab), 0, 0, 'C');

        $this->fpdf->SetFont('Arial', 'B', 6);

        $this->fpdf->Text(30, 22, utf8_decode("Carte d'identité scolaire"));

        $this->fpdf->Ln(2);

        $this->fpdf->SetTextColor('44', '53', '61');


        $this->fpdf->SetFont('Arial', 'B', 8);



        $this->fpdf->Image(
            public_path("/Photos/Logos/" . $data->user->photo),
            4,
            23,
            13,
            17,
            ""
        );

        // informations eleves


        $this->fpdf->SetFont('Arial', 'IB', 5);
        $this->fpdf->Text(20, 26, utf8_decode("Année-scolaire : "));
        $this->fpdf->SetFont('Arial', 'I', 6);
        $this->fpdf->Text(34, 26, $data->session);

        $this->fpdf->SetFont('Arial', 'IB', 5);
        $this->fpdf->Text(20, 29, "Matricule : ");
        $this->fpdf->SetFont('Arial', 'B', 6);
        $this->fpdf->Text(30, 29, $data->matricule);

        $this->fpdf->SetFont('Arial', 'IB', 5);
        $this->fpdf->Text(20, 32, utf8_decode("Noms et prénoms : "));
        $this->fpdf->SetFont('Arial', 'B', 5);
        $this->fpdf->Text(37, 32, utf8_decode($data->nom) . ' ' . utf8_decode($data->prenom));

        $this->fpdf->SetFont('Arial', 'IB', 5);
        $this->fpdf->Text(20, 35, "Date de et lieu de naissance : ");
        $this->fpdf->SetFont('Arial', 'B', 5);
        $this->fpdf->Text(45, 35, date_format(date_create($data->dateNaiss), "d-m-Y") . " " . utf8_decode("à $data->lieuNaiss"));

        // $data->dateNaiss


        $this->fpdf->SetFont('Arial', 'IB', 5);
        $this->fpdf->Text(20, 38, "Sexe : ");
        $this->fpdf->SetFont('Arial', 'B', 6);
        $this->fpdf->Text(26, 38, $data->sexe);


        $this->fpdf->SetFont('Arial', 'IB', 5);
        $this->fpdf->Text(20, 41, "Classe : ");
        $this->fpdf->SetFont('Arial', 'B', 6);
        $this->fpdf->Text(27, 41, utf8_decode($data->Classe->libelleClasse));


        $this->fpdf->Text(50, 50, utf8_decode("Signature du chef d'établissement "));



        // $this->fpdf->Ln(3);

        // $this->fpdf->SetFont('Arial', 'B', 10);
        // $this->fpdf->SetTextColor('10', '75', '168');

        // $this->fpdf->Cell(0, 10, "CARTE D'IDENTITE SCOLAIRE ", 0, 0, 'C');

        // $this->fpdf->Ln(2);

        // $this->fpdf->SetTextColor('44', '53', '61');


        // $this->fpdf->SetFont('Arial', 'B', 8);
        // $this->fpdf->Cell(0, 18,  $data->session, 0, 0, 'C');


        // // photo de l'enfant

        // $this->fpdf->Image(
        //     public_path("/Photos/Logos/" . $data->user->photo),
        //     4,
        //     30,
        //     25,
        //     20,
        //     ""
        // );

        // // informations eleves

        // $this->fpdf->SetFont('Arial', 'I', 5);
        // $this->fpdf->Text(32, 29, "Matricule : ");
        // $this->fpdf->SetFont('Arial', 'B', 6);
        // $this->fpdf->Text(41, 29, $data->matricule);

        // $this->fpdf->SetFont('Arial', 'I', 5);
        // $this->fpdf->Text(32, 32, "Nom : ");
        // $this->fpdf->SetFont('Arial', 'B', 6);
        // $this->fpdf->Text(38, 32, utf8_decode($data->nom));

        // $this->fpdf->SetFont('Arial', 'I', 5);
        // $this->fpdf->Text(32, 35, "Prenom : ");
        // $this->fpdf->SetFont('Arial', 'B', 6);
        // $this->fpdf->Text(40, 35, utf8_decode($data->prenom));


        // $this->fpdf->SetFont('Arial', 'I', 5);
        // $this->fpdf->Text(32, 38, "Date de naissance : ");
        // $this->fpdf->SetFont('Arial', 'B', 6);
        // $this->fpdf->Text(48, 38, $data->dateNaiss);


        // $this->fpdf->SetFont('Arial', 'I', 5);
        // $this->fpdf->Text(32, 41, "Lieu de naissance : ");
        // $this->fpdf->SetFont('Arial', 'B', 6);
        // $this->fpdf->Text(48, 41, utf8_decode($data->lieuNaiss));


        // $this->fpdf->SetFont('Arial', 'I', 5);
        // $this->fpdf->Text(32, 44, "Sexe : ");
        // $this->fpdf->SetFont('Arial', 'B', 6);
        // $this->fpdf->Text(38, 44, $data->sexe);


        // $this->fpdf->SetFont('Arial', 'I', 5);
        // $this->fpdf->Text(32, 47, "Classe : ");
        // $this->fpdf->SetFont('Arial', 'B', 6);
        // $this->fpdf->Text(39, 47, utf8_decode($data->Classe->libelleClasse));


        // $this->fpdf->SetFont('Arial', 'I', 5);
        // $this->fpdf->Text(32, 50, utf8_decode("Téléphone du parent : "));
        // $this->fpdf->SetFont('Arial', 'B', 6);
        // $this->fpdf->Text(50, 50, $data->Parent->telParent);

        $this->fpdf->Output();

        exit;
    }


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

        $libelleClasse = $code->libelleClasse;
        // je recupere le premier chiffre de la classe qui va decrementer si l'enfant passe en classe superieure

        $labelClasseChiffre = (int)($libelleClasse[0]);

        // Je recupere les lettres restantes

        $labelSuiteClasse = substr($libelleClasse, 1);

        // dd($labelSuiteClasse);



        $Trimestres = Trimestre::where('codeEta_semes', $codeEtab)->get();

        $idTrim1 = $Trimestres[0]->id;
        $idTrim2 = $Trimestres[1]->id;
        $idTrim3 = $Trimestres[2]->id;


        $classeName = Etablissement::where('codeEtab', $codeEtab)->first();

        $rest = Classe::where('id', $IdClasse)->first();

        $teach = Enseignants::where('id', $rest->principale_Classe)->first();


        // Tous les eleves


        $classeData = Student::with('user', 'classe')->where('classe_id', $IdClasse)

            ->where('session', $session)->where('codeEtab', $codeEtab)->get();

        $moyData =   MoyenneAnnuelle::with('student')->where('session', $session)
            ->where('codeEtab', $codeEtab)->where('classe_id', $IdClasse)->where('valeur', '>', 0)
            ->orderBy('valeur', 'DESC')->get();




        // Nombre deleves  dans cette classe


        $effectif = Student::where('classe_id', $IdClasse)->where('session', $session)
            ->where('codeEtab', $codeEtab)->count();

        //  $effectif = count($moyData);

        // Nombre deleves ayant une moyenne dans cette classe dans le trimestre

        $nombreEleves =  MoyenneAnnuelle::where('classe_id', $IdClasse)->where('valeur', '>', 0)
            ->where('session', $session)->where('codeEtab', $codeEtab)->count();


        // Mpyenne gen de la classe


        $moyenneSommeClasse =  MoyenneAnnuelle::where('classe_id', $IdClasse)
            ->where('session', $session)->where('codeEtab', $codeEtab)->sum('valeur');


        // dump($moyData);


        // Je recupere les notes de trim  1


        $noteData1 =   NotesTrimestres::where('trimestre_id', $idTrim1)->where('classe_id', $IdClasse)->where('session', $session)->where('codeEtab', $codeEtab)->get();


        // Moyenne du dernier

        $MoyDernier = MoyenneAnnuelle::where('classe_id', $IdClasse)->min('valeur');


        // // Moyenne du premier

        $MoyPremier = MoyenneAnnuelle::where('classe_id', $IdClasse)->max('valeur');


        foreach ($moyData   as $ley => $data) {



            if ($ley == 0) {

                $e = 'er';
            } else {

                $e = 'eme';
            }


            $this->fpdf->AddPage("P", ['335', '210']); // 315


            //**************************************categorie1 ******************************************* //


            // note trim1 de la cat1


            $Note[$data->student->id] = NotesTrimestres::with('matiere', 'student', 'evaluation', 'user')

                ->where('trimestre_id', $idTrim1)
                ->where('classe_id', $IdClasse)
                ->where('cat_id', 1)
                ->where('student_id', $data->student->id)
                ->where('codeEtab', $codeEtab)
                ->where('session', $session)->orderBy('matiere_id')->get();


            // note trim2 de la cat1

            $Note2[$data->student->id] = NotesTrimestres::with('matiere', 'student', 'evaluation', 'user')
                ->where('trimestre_id', $idTrim2)
                ->where('classe_id', $IdClasse)
                ->where('cat_id', 1)
                ->where('student_id', $data->student->id)
                ->where('codeEtab', $codeEtab)
                ->where('session', $session)->orderBy('matiere_id')->get();

            // note trim3 de la cat1

            $Note3[$data->student->id] = NotesTrimestres::with('matiere', 'student', 'evaluation', 'user')

                ->where('trimestre_id', $idTrim3)
                ->where('classe_id', $IdClasse)
                ->where('cat_id', 1)
                ->where('student_id', $data->student->id)
                ->where('codeEtab', $codeEtab)
                ->where('session', $session)->orderBy('matiere_id')->get();


            // note annuelle de la cat1

            $noteAnnuelle[$data->student->id] = noteAnnuelle::with('matiere', 'student', 'evaluation', 'user')

                ->where('classe_id', $IdClasse)
                ->where('cat_id', 1)
                ->where('student_id', $data->student->id)
                ->where('codeEtab', $codeEtab)
                ->where('session', $session)->get();




            //     $NoteTrimestre3[$data->student->id] = NotesTrimestres::with('matiere', 'student', 'evaluation', 'user')



            //         ->where('trimestre_id', $IdTrimmestre)
            //         ->where('classe_id', $IdClasse)
            //         ->where('cat_id', 3)
            //         ->where('student_id', $data->student->id)
            //         ->where('codeEtab', $codeEtab)
            //         ->where('session', $session)->get();


            $val  = NotesTrimestres::with('matiere', 'student', 'evaluation', 'user')
                ->where('trimestre_id', $idTrim1)
                ->where('classe_id', $IdClasse)
                ->where('cat_id', 1)
                ->where('student_id', $data->student->id)
                ->where('codeEtab', $codeEtab)
                ->where('session', $session)->count();


            $val3  = NotesTrimestres::with('matiere', 'student', 'evaluation', 'user')
                ->where('trimestre_id', $idTrim1)
                ->where('classe_id', $IdClasse)
                ->where('cat_id', 2)
                ->where('student_id', $data->student->id)
                ->where('codeEtab', $codeEtab)
                ->where('session', $session)->count();


            $val4  = NotesTrimestres::with('matiere', 'student', 'evaluation', 'user')
                ->where('trimestre_id', $idTrim1)
                ->where('classe_id', $IdClasse)
                ->where('cat_id', 3)
                ->where('student_id', $data->student->id)
                ->where('codeEtab', $codeEtab)
                ->where('session', $session)->count();


            //     //     $heureTrimestre  = Presences::where('classe_id', $IdClasse)
            //     //         ->where('mois_id', $IdTrimmestre)->where('student_id', $data->student->id)
            //     //         ->where('codeEtab', $codeEtab)
            //     //         ->where('session', $session)->sum('duree');


            // Absences non justifies

            // $heureTrimestreNonJustifies = Presences::where('classe_id', $IdClasse)
            //     ->where('student_id', $data->student->id)
            //     ->where('codeEtab', $codeEtab)->where('etat', 0)
            //     ->where('session', $session)->sum('duree');


            $heureTrim1 = Presences::where('classe_id', $IdClasse)
                ->where('student_id', $data->student->id)
                ->where('codeEtab', $codeEtab)->where('etat', 0)
                ->where('mois_id', $idTrim1)
                ->where('session', $session)->sum('duree');


            $heureTrim2 = Presences::where('classe_id', $IdClasse)
                ->where('student_id', $data->student->id)
                ->where('codeEtab', $codeEtab)->where('etat', 0)
                ->where('mois_id', $idTrim2)
                ->where('session', $session)->sum('duree');

            $heureTrim3 = Presences::where('classe_id', $IdClasse)
                ->where('student_id', $data->student->id)
                ->where('codeEtab', $codeEtab)->where('etat', 0)
                ->where('mois_id', $idTrim3)
                ->where('session', $session)->sum('duree');



            // Je cherche les consigne et les jour d'exusion du trimestre

            $heureConsigneTrimestre  = discipline::where('classe_id', $IdClasse)
                ->where('student_id', $data->student->id)->where('type', 'con')
                ->where('codeEtab', $codeEtab)
                ->where('session', $session)->sum('duree');


            $ExclusionTrimestre  = discipline::where('classe_id', $IdClasse)
                ->where('student_id', $data->student->id)->where('type', 'ex')
                ->where('codeEtab', $codeEtab)
                ->where('session', $session)->sum('duree');







            //**************************************categorie 2******************************************* //


            // Note devoir 1 de la cat 2


            $Notecat2[$data->student->id] = NotesTrimestres::with('matiere', 'student', 'evaluation', 'user')

                ->where('trimestre_id', $idTrim1)
                ->where('classe_id', $IdClasse)
                ->where('cat_id', 2)
                ->where('student_id', $data->student->id)
                ->where('codeEtab', $codeEtab)
                ->where('session', $session)->orderBy('matiere_id')->get();


            // Note devoir 2 de la cat 2

            $Note2cat2[$data->student->id] = NotesTrimestres::with('matiere', 'student', 'evaluation', 'user')
                ->where('trimestre_id', $idTrim2)
                ->where('classe_id', $IdClasse)
                ->where('cat_id', 2)
                ->where('student_id', $data->student->id)
                ->where('codeEtab', $codeEtab)
                ->where('session', $session)->orderBy('matiere_id')->get();



            // Note devoir 3 de la cat 2

            $Note3cat2[$data->student->id] = NotesTrimestres::with('matiere', 'student', 'evaluation', 'user')
                ->where('trimestre_id', $idTrim3)
                ->where('classe_id', $IdClasse)
                ->where('cat_id', 2)
                ->where('student_id', $data->student->id)
                ->where('codeEtab', $codeEtab)
                ->where('session', $session)->orderBy('matiere_id')->get();



            // Note annuelle   de la cat 2

            $NoteAnnuellecat2[$data->student->id] = noteAnnuelle::with('matiere', 'student', 'evaluation', 'user')
                ->where('classe_id', $IdClasse)
                ->where('cat_id', 2)
                ->where('student_id', $data->student->id)
                ->where('codeEtab', $codeEtab)
                ->where('session', $session)->get();




            // Note annuelle   de la cat 3

            $NoteAnnuellecat3[$data->student->id] = noteAnnuelle::with('matiere', 'student', 'evaluation', 'user')
                ->where('classe_id', $IdClasse)
                ->where('cat_id', 3)
                ->where('student_id', $data->student->id)
                ->where('codeEtab', $codeEtab)
                ->where('session', $session)->get();


            // dump( $NoteTrimestrecat2[$data->student->id]);





            //     //     // Note trimestre  de la cat 2 ( meme role que la requette du haut )


            //     //     $NoteTrimestre2[$data->student->id] = NotesTrimestres::with('matiere', 'student', 'evaluation', 'user')
            //     //         ->where('trimestre_id', $IdTrimmestre)
            //     //         ->where('classe_id', $IdClasse)
            //     //         ->where('cat_id', 2)
            //     //         ->where('student_id', $data->student->id)
            //     //         ->where('codeEtab', $codeEtab)
            //     //         ->where('session', $session)->get();





            //     /*************************************** categorie 3  **********************************  /     //


            // Note devoir 1 de la cat 3


            $Notecat3[$data->student->id] = NotesTrimestres::with('matiere', 'student', 'evaluation', 'user')
                ->where('trimestre_id', $idTrim1)
                ->where('classe_id', $IdClasse)
                ->where('cat_id', 3)
                ->where('student_id', $data->student->id)
                ->where('codeEtab', $codeEtab)
                ->where('session', $session)->orderBy('matiere_id')->get();

            // Note devoir 2 de la cat 3

            $Note2cat3[$data->student->id] = NotesTrimestres::with('matiere', 'student', 'evaluation', 'user')
                ->where('trimestre_id', $idTrim2)
                ->where('classe_id', $IdClasse)
                ->where('cat_id', 3)
                ->where('student_id', $data->student->id)
                ->where('codeEtab', $codeEtab)
                ->where('session', $session)->orderBy('matiere_id')->get();


            // Note devoir 3 de la cat 3

            $Note3cat3[$data->student->id] = NotesTrimestres::with('matiere', 'student', 'evaluation', 'user')
                ->where('trimestre_id', $idTrim3)
                ->where('classe_id', $IdClasse)
                ->where('cat_id', 3)
                ->where('student_id', $data->student->id)
                ->where('codeEtab', $codeEtab)
                ->where('session', $session)->orderBy('matiere_id')->get();

            //     //     // Note trimestre  de la cat 3

            //     //     $NoteTrimestrecat3[$data->student->id] = NotesTrimestres::with('matiere', 'student', 'evaluation', 'user')
            //     //         ->where('trimestre_id', $IdTrimmestre)
            //     //         ->where('classe_id', $IdClasse)
            //     //         ->where('cat_id', 3)
            //     //         ->where('student_id', $data->student->id)
            //     //         ->where('codeEtab', $codeEtab)
            //     //         ->where('session', $session)->get();


            // je recupere les photo des eleves dans user

            // je recupere les photo des eleves dans user

            $EleveData[$data->student->id] = Student::with('user')->where('id', $data->student->id)->get();


            //$this->fpdf->SetXY(20,115);


            $this->fpdf->Image(public_path("/Photos/Logos/" . $entete), 5, 6, 200, 36, "");




            $tailleNote = 7;
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
            $this->fpdf->Text(137, 68, utf8_decode(date_format(date_create($Note[$data->student->id][0]->student->dateNaiss), "d-m-Y")));
            $this->fpdf->SetFont('Arial', 'B', 7);

            $this->fpdf->Text(105, 72, 'Sexe  : ');
            $this->fpdf->SetFont('Arial', 'B', 7);
            $this->fpdf->Text(137, 72, $data->student->sexe);
            $this->fpdf->SetFont('Arial', 'B', 7);

            $this->fpdf->Text(105, 76, 'Situatuion  : ');
            $this->fpdf->SetFont('Arial', 'B', 7);
            $this->fpdf->Text(137, 76, $data->student->doublant);
            $this->fpdf->SetFont('Arial', 'B', 7);



            // // deuxiemme


            $this->fpdf->Text(37, 58, utf8_decode('Anneé-Scolaire  : '));
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


            $this->fpdf->Text(37, 71, 'Prof principal  :');
            $this->fpdf->SetFont('Arial', 'B', 6);
            $this->fpdf->Text(59, 71, utf8_decode($teach->nom . ' ' . $teach->prenom));


            if (file_exists(public_path("/Photos/Logos/" . $EleveData[$data->student->id][0]->user->photo))) {


                $this->fpdf->Image(public_path("/Photos/Logos/" . $EleveData[$data->student->id][0]->user->photo), 5, 52, 30, 27,  "");
            }






            // // Cadre information eleve



            $this->fpdf->SetXY(5, 52);
            $this->fpdf->Cell(30, 27, '', 1);

            $this->fpdf->SetXY(35, 52);
            $this->fpdf->Cell(23, 27, '', 1);


            $this->fpdf->SetXY(58, 52);
            $this->fpdf->Cell(45, 27, '', 1);


            $this->fpdf->SetXY(103, 52);
            $this->fpdf->Cell(33, 27, '', 1);


            $this->fpdf->SetXY(136, 52);
            $this->fpdf->Cell(70, 27, '', 1);




            $libelleTrimestre  = " ANNUEL";


            $this->fpdf->SetFillColor('130', '130', '130');
            $this->fpdf->SetFont('Arial', 'B', 10);
            $this->fpdf->SetXY(71, 41);
            $this->fpdf->Cell(70, 8, 'BULLETIN DE NOTES ' . '' . strtoupper($libelleTrimestre), 1, 0, 'C', 1);

            // $this->fpdf->SetFont('Arial', 'B', 12);
            // $this->fpdf->SetXY(10, 45);
            // $this->fpdf->Cell(0, 0, utf8_decode("BULLETIN DE FIN D'ANNEE "), 1, 0, 'C');



            // Cadre pour le titre de l'ecole

            // $this->fpdf->SetXY(50,39);
            // $this->fpdf->Cell(100,10,'',1);

            $this->fpdf->SetFont('Arial', 'B', 7);
            $this->fpdf->SetTextColor(0, 0, 0);
            // Tire cadre a cote
            // $this->fpdf->Text(135, 72, strtoupper($classeName->libelleEtab));

            $this->fpdf->SetXY(5, 85);
            // $this->fpdf->SetFont('Arial', 'B', 7);
            $this->fpdf->SetDrawColor(0, 0, 0);
            $this->fpdf->SetFillColor('166', '166', '166');
            $this->fpdf->Cell(60, 7, utf8_decode('Matières'), 1, 0, 'C', 1);
            $this->fpdf->Cell(10, 7, "TRIM " . ($idTrim1), 1, 0, 'C', 1);
            $this->fpdf->Cell(10, 7, "TRIM " . ($idTrim2), 1, 0, 'C', 1);
            $this->fpdf->Cell(10, 7, "TRIM " . ($idTrim3), 1, 0, 'C', 1);

            $this->fpdf->SetFont('Arial', 'B', $tailleNote);


            $this->fpdf->Cell(40, 4, '                   ' . strtoupper($libelleTrimestre), 1, 0, 'L', 1);

            $this->fpdf->SetFont('Arial', 'B', 7);

            $this->fpdf->SetXY(95, 89);

            $this->fpdf->Cell(10, 3, 'Notes', 1, 0, 'C', 1);
            $this->fpdf->Cell(10, 3, 'Coef', 1, 0, 'C', 1);
            $this->fpdf->Cell(10, 3, 'N*C', 1, 0, 'C', 1);
            $this->fpdf->Cell(10, 3, 'Rang', 1, 0, 'C', 1);
            $this->fpdf->SetXY(135, 85);
            $this->fpdf->Cell(20, 7, 'Appreciations', 1, 0, 'C', 1);
            $this->fpdf->Cell(51, 7, 'Enseignant (e) ', 1, 0, 'C', 1);

            $this->fpdf->Ln();
            $this->fpdf->SetX(20);


            // Pour la note seq1


            foreach ($Note[$data->student->id] as $note) {

                $this->fpdf->SetX(5);
                $this->fpdf->SetFont('Arial', 'B', 6);
                $this->fpdf->MultiCell(60, 7, utf8_decode($note->matiere->libelle), 1, 'L');
            }



            $this->fpdf->SetY(92);


            // Moyenne Trim  1


            $MoyenneDevoir1[$data->student->id] = MoyenneTrimestres::where('trimestre_id', $idTrim1)
                ->where('classe_id', $IdClasse)
                ->where('student_id', $data->student->id)
                ->where('codeEtab', $codeEtab)
                ->where('session', $session)->first();


            // Moyenne devoir 2


            $MoyenneDevoir2[$data->student->id] = MoyenneTrimestres::where('trimestre_id', $idTrim2)
                ->where('classe_id', $IdClasse)
                ->where('student_id', $data->student->id)
                ->where('codeEtab', $codeEtab)
                ->where('session', $session)->first();


            $this->fpdf->SetFont('Arial', 'B', 7);


            // Moyenne devoir 3


            $MoyenneDevoir3[$data->student->id] = MoyenneTrimestres::where('trimestre_id', $idTrim3)
                ->where('classe_id', $IdClasse)
                ->where('student_id', $data->student->id)
                ->where('codeEtab', $codeEtab)
                ->where('session', $session)->first();


            $this->fpdf->SetFont('Arial', 'B', 7);


            foreach ($Note[$data->student->id] as $note) {

                if ($note->valeur < $couleurRouge) {

                    $this->fpdf->SetTextColor('237', '28', '36');
                } else {

                    $this->fpdf->SetTextColor('0', '0', '0');
                }
                $this->fpdf->SetX(65);

                if ($MoyenneDevoir1[$data->student->id]->valeur == 0) {


                    $this->fpdf->MultiCell(10, 7, '', 1, 'C');
                } else {

                    $this->fpdf->MultiCell(10, 7, $note->valeur, 1, 'C');
                }
            }

            $this->fpdf->SetTextColor('0', '0', '0');



            // Note seq2

            $this->fpdf->SetY(92);

            foreach ($Note2[$data->student->id] as $note) {

                if ($note->valeur < $couleurRouge) {

                    $this->fpdf->SetTextColor('237', '28', '36');
                } else {

                    $this->fpdf->SetTextColor('0', '0', '0');
                }

                $this->fpdf->SetX(75);
                if ($MoyenneDevoir2[$data->student->id]->valeur == 0) {

                    $this->fpdf->MultiCell(10, 7, '', 1, 'C');
                } else {

                    $this->fpdf->MultiCell(10, 7, $note->valeur, 1, 'C');
                }
            }

            $this->fpdf->SetTextColor('0', '0', '0');


            // Note seq3

            $this->fpdf->SetY(92);

            foreach ($Note3[$data->student->id] as $note) {

                if ($note->valeur < $couleurRouge) {

                    $this->fpdf->SetTextColor('237', '28', '36');
                } else {

                    $this->fpdf->SetTextColor('0', '0', '0');
                }

                $this->fpdf->SetX(85);
                if ($MoyenneDevoir2[$data->student->id]->valeur == 0) {

                    $this->fpdf->MultiCell(10, 7, '', 1, 'C');
                } else {

                    $this->fpdf->MultiCell(10, 7, $note->valeur, 1, 'C');
                }
            }

            $this->fpdf->SetTextColor('0', '0', '0');

            // Note Annuelle


            //     // // // ici je rcupere la note du trimstre

            $this->fpdf->SetY(92);

            foreach ($noteAnnuelle[$data->student->id] as $key => $note) {


                if ($note->valeur < $couleurRouge) {

                    $this->fpdf->SetTextColor('237', '28', '36');
                } else {

                    $this->fpdf->SetTextColor('0', '0', '0');
                }


                $this->fpdf->SetX(95);
                $this->fpdf->MultiCell(10, 7, round($note->valeur, 2), 1, 'C');
            }

            $this->fpdf->SetTextColor('0', '0', '0');


            // // // les coef

            $this->fpdf->SetY(92);
            foreach ($noteAnnuelle[$data->student->id] as $note) {
                $this->fpdf->SetX(105);

                $this->fpdf->MultiCell(10, 7, $note->matiere->coef, 1, 'C');
            }


            $this->fpdf->SetY(92);
            foreach ($noteAnnuelle[$data->student->id] as $note) {

                if ($note->valeur < $couleurRouge) {

                    $this->fpdf->SetTextColor('237', '28', '36');
                } else {

                    $this->fpdf->SetTextColor('0', '0', '0');
                }


                $this->fpdf->SetX(115);
                $this->fpdf->MultiCell(10, 7, round(($note->valeur) * $note->matiere->coef, 2), 1, 'C');
            }

            $this->fpdf->SetTextColor('0', '0', '0');

            $this->fpdf->SetY(92);


            // Rang des matieres

            foreach ($noteAnnuelle[$data->student->id] as $note) {


                $all  = noteAnnuelle::where('matiere_id', $note->matiere->id)
                    ->where('classe_id', $IdClasse)
                    ->where('codeEtab', $codeEtab)
                    ->where('session', $session)
                    ->orderBy('valeur', 'desc')->get();

                foreach ($all as $ket => $test) {

                    if ($test->id == $note->id) {
                        $rank = $ket;

                        if ($rank + 1 == 1) {

                            $lab = "er";
                        } else {

                            $lab = "e";
                        }
                    }
                }


                $this->fpdf->SetX(125);
                $this->fpdf->MultiCell(10, 7, $rank + 1 . $lab, 1, 'C');
            }


            $this->fpdf->SetY(92);
            foreach ($noteAnnuelle[$data->student->id] as $note) {

                if ($note->valeur >= 0 && $note->valeur < 2) {
                    $note->mention = "Nul";
                }

                if ($note->valeur >= 2 && $note->valeur < 7) {

                    $note->mention = "Très Faible";
                }

                if ($note->valeur >= 7 && $note->valeur < 8) {

                    $note->mention = "Faible";
                }

                if ($note->valeur >= 8 && $note->valeur < 9) {

                    $note->mention = "Insuffisant";
                }
                if ($note->valeur >= 9 && $note->valeur < 10) {

                    $note->mention = "Médiocre";
                }


                if ($note->valeur >= 10 && $note->valeur < 12) {

                    $note->mention = "Passable";
                }

                if ($note->valeur >= 12 && $note->valeur < 14) {

                    $note->mention = "Assez-Bien";
                }

                if ($note->valeur >= 14 && $note->valeur < 16) {

                    $note->mention = "Bien";
                }

                if ($note->valeur >= 16 && $note->valeur < 18) {

                    $note->mention = "Très Bien";
                }

                if ($note->valeur >= 18 && $note->valeur <= 20) {

                    $note->mention = "Excellent";
                }

                if ($note->valeur < $couleurRouge) {

                    $this->fpdf->SetTextColor('237', '28', '36');
                } else {

                    $this->fpdf->SetTextColor('0', '0', '0');
                }

                $this->fpdf->SetFont('Arial', 'B', 7);

                $this->fpdf->SetX(135);
                $this->fpdf->MultiCell(20, 7, utf8_decode($note->mention), 1, 'C');
            }

            // je cherche les infos sur le proef


            $this->fpdf->SetTextColor('0', '0', '0');

            $this->fpdf->SetY(92);
            foreach ($Note[$data->student->id] as $note) {

                $this->fpdf->SetFont('Arial', 'B', 6);

                $this->fpdf->SetX(155);
                $this->fpdf->MultiCell(51, 7, utf8_decode($note->user->nom . ' ' . $note->user->prenom), 1, 'L');
            }


            // Moy trimestre  du groupe 1



            foreach ($noteAnnuelle[$data->student->id] as $data2) {


                $sommeNoteCoef1 = $sommeNoteCoef1 + ($data2->valeur * $data2->matiere->coef);

                $sommeCoef1 = $sommeCoef1 + $data2->matiere->coef;
            }


            $moyenne1[$data->student->id] =  number_format($sommeNoteCoef1 / $sommeCoef1, 2);



            // Moyenne cat1 du devoir 1


            $sommeNoteCoefD1cat1 = 0;

            $sommeCoef1D1 = 0;


            foreach ($Note[$data->student->id] as $data1) {


                $sommeNoteCoefD1cat1 = $sommeNoteCoefD1cat1 + ($data1->valeur * $data1->matiere->coef);

                $sommeCoef1D1 = $sommeCoef1D1 + $data1->matiere->coef;
            }

            $moyenneD1Cat1[$data->student->id] =  number_format($sommeNoteCoefD1cat1 / $sommeCoef1D1, 2);



            // Moyenne  devoir 2 de la cat1


            $sommeNoteCoefD2cat1 = 0;

            $sommeCoef2D2 = 0;


            foreach ($Note2[$data->student->id] as $data1) {


                $sommeNoteCoefD2cat1 = $sommeNoteCoefD2cat1 + ($data1->valeur * $data1->matiere->coef);

                $sommeCoef2D2 = $sommeCoef2D2 + $data1->matiere->coef;
            }

            $moyenneD2Cat1[$data->student->id] =  number_format($sommeNoteCoefD2cat1 / $sommeCoef2D2, 2);



            // Moyenne  devoir 3 de la cat1


            $sommeNoteCoefD3cat1 = 0;

            $sommeCoef2D3 = 0;


            foreach ($Note3[$data->student->id] as $data1) {


                $sommeNoteCoefD3cat1 = $sommeNoteCoefD3cat1 + ($data1->valeur * $data1->matiere->coef);

                $sommeCoef2D3 = $sommeCoef2D3 + $data1->matiere->coef;
            }

            $moyenneD3Cat1[$data->student->id] =  number_format($sommeNoteCoefD2cat1 / $sommeCoef2D2, 2);



            $this->fpdf->SetX(5);
            $this->fpdf->SetFont('Arial', 'B', 6);
            $this->fpdf->Cell(60, 6, utf8_decode('Enseignement Général'), 1, 0, 'C', 1);
            $this->fpdf->Cell(10, 6,  $moyenneD1Cat1[$data->student->id], 1, 0, 'C', 1);
            $this->fpdf->Cell(10, 6, $moyenneD2Cat1[$data->student->id], 1, 0, 'C', 1);
            $this->fpdf->Cell(10, 6, $moyenneD3Cat1[$data->student->id], 1, 0, 'C', 1);
            $this->fpdf->Cell(10, 6,  $moyenne1[$data->student->id], 1, 0, 'C', 1);
            $this->fpdf->Cell(10, 6, $sommeCoef1, 1, 0, 'C', 1);
            $this->fpdf->Cell(10, 6, round($sommeNoteCoef1, 2), 1, 0, 'C', 1);
            $this->fpdf->Cell(81, 6, '', 1, 0, 'C', 1);


            $this->fpdf->Ln();


            foreach ($Notecat2[$data->student->id] as $note) {

                $this->fpdf->SetX(5);
                $this->fpdf->SetFont('Arial', 'B', 6);
                $this->fpdf->MultiCell(60, 7, utf8_decode($note->matiere->libelle), 1, 'L');
            }


            $this->fpdf->Ln(-7 * $val3);

            $this->fpdf->SetFont('Arial', 'B', 7);

            // Les note de la sequence 1 cat 2
            foreach ($Notecat2[$data->student->id] as $note) {

                if ($note->valeur < $couleurRouge) {

                    $this->fpdf->SetTextColor('237', '28', '36');
                } else {

                    $this->fpdf->SetTextColor('0', '0', '0');
                }


                $this->fpdf->SetX(65);
                if ($MoyenneDevoir1[$data->student->id]->valeur == 0) {

                    $this->fpdf->MultiCell(10, 7, '', 1, 'C');
                } else {

                    $this->fpdf->MultiCell(10, 7, $note->valeur, 1, 'C');
                }
            }

            $this->fpdf->SetTextColor('0', '0', '0');


            $this->fpdf->Ln(-7 * $val3);

            // Les notes de la sequence 2 cat 2

            foreach ($Note2cat2[$data->student->id] as $note) {

                if ($note->valeur < $couleurRouge) {

                    $this->fpdf->SetTextColor('237', '28', '36');
                } else {

                    $this->fpdf->SetTextColor('0', '0', '0');
                }

                $this->fpdf->SetX(75);
                if ($MoyenneDevoir2[$data->student->id]->valeur == 0) {

                    $this->fpdf->MultiCell(10, 7, '', 1, 'C');
                } else {

                    $this->fpdf->MultiCell(10, 7, $note->valeur, 1, 'C');
                }
            }

            $this->fpdf->SetTextColor('0', '0', '0');



            $this->fpdf->Ln(-7 * $val3);


            // Les notes de la sequence 3 cat 2

            foreach ($Note3cat2[$data->student->id] as $note) {

                if ($note->valeur < $couleurRouge) {

                    $this->fpdf->SetTextColor('237', '28', '36');
                } else {

                    $this->fpdf->SetTextColor('0', '0', '0');
                }

                $this->fpdf->SetX(85);
                if ($MoyenneDevoir2[$data->student->id]->valeur == 0) {

                    $this->fpdf->MultiCell(10, 7, '', 1, 'C');
                } else {

                    $this->fpdf->MultiCell(10, 7, $note->valeur, 1, 'C');
                }
            }

            $this->fpdf->SetTextColor('0', '0', '0');



            $this->fpdf->Ln(-7 * $val3);

            foreach ($NoteAnnuellecat2[$data->student->id] as $note) {

                if ($note->valeur < $couleurRouge) {

                    $this->fpdf->SetTextColor('237', '28', '36');
                } else {

                    $this->fpdf->SetTextColor('0', '0', '0');
                }

                $this->fpdf->SetX(95);
                $this->fpdf->MultiCell(10, 7, round($note->valeur, 2), 1, 'C');
            }

            $this->fpdf->SetTextColor('0', '0', '0');


            $this->fpdf->Ln(-7 * $val3);

            foreach ($Note2cat2[$data->student->id] as $note) {

                $this->fpdf->SetX(105);

                $this->fpdf->MultiCell(10, 7, $note->matiere->coef, 1, 'C');
            }

            $this->fpdf->Ln(-7 * $val3);
            foreach ($NoteAnnuellecat2[$data->student->id] as $note) {

                if ($note->valeur < $couleurRouge) {

                    $this->fpdf->SetTextColor('237', '28', '36');
                } else {

                    $this->fpdf->SetTextColor('0', '0', '0');
                }


                $this->fpdf->SetX(115);
                $this->fpdf->MultiCell(10, 7, round(($note->valeur) * $note->matiere->coef, 2), 1, 'C');
            }

            $this->fpdf->Ln(-7 * $val3);

            $this->fpdf->SetTextColor('0', '0', '0');

            foreach ($NoteAnnuellecat2[$data->student->id] as $note) {


                $all  = noteAnnuelle::where('matiere_id', $note->matiere->id)
                    ->where('classe_id', $IdClasse)
                    ->where('codeEtab', $codeEtab)
                    ->where('session', $session)
                    ->orderBy('valeur', 'desc')->get();

                foreach ($all as $ket => $test) {

                    if ($test->id == $note->id) {
                        $rank = $ket;

                        if ($rank + 1 == 1) {

                            $lab = "er";
                        } else {

                            $lab = "e";
                        }
                    }
                }


                $this->fpdf->SetX(125);
                $this->fpdf->MultiCell(10, 7, $rank + 1 . $lab, 1, 'C');
            }

            $this->fpdf->SetTextColor('0', '0', '0');



            $this->fpdf->Ln(-7 * $val3);

            foreach ($NoteAnnuellecat2[$data->student->id] as $note2) {

                if ($note2->valeur >= 0 && $note2->valeur < 2) {
                    $note2->mention = "Nul";
                }

                if ($note2->valeur >= 2 && $note2->valeur < 7) {

                    $note2->mention = "Très Faible";
                }

                if ($note2->valeur >= 7 && $note2->valeur < 8) {

                    $note2->mention = "Faible";
                }

                if ($note2->valeur >= 8 && $note2->valeur < 9) {

                    $note2->mention = "Insuffisant";
                }
                if ($note2->valeur >= 9 && $note2->valeur < 10) {

                    $note2->mention = "Médiocre";
                }


                if ($note2->valeur >= 10 && $note2->valeur < 12) {

                    $note2->mention = "Passable";
                }

                if ($note2->valeur >= 12 && $note2->valeur < 14) {

                    $note2->mention = "Assez-Bien";
                }

                if ($note2->valeur >= 14 && $note2->valeur < 16) {

                    $note2->mention = "Bien";
                }

                if ($note2->valeur >= 16 && $note2->valeur < 18) {

                    $note2->mention = "Très Bien";
                }

                if ($note2->valeur >= 18 && $note2->valeur <= 20) {

                    $note2->mention = "Excellent";
                }

                if ($note2->valeur < $couleurRouge) {

                    $this->fpdf->SetTextColor('237', '28', '36');
                } else {

                    $this->fpdf->SetTextColor('0', '0', '0');
                }

                $this->fpdf->SetFont('Arial', 'B', 7);


                $this->fpdf->SetX(135);
                $this->fpdf->MultiCell(20, 7, utf8_decode($note2->mention), 1, 'C');
            }

            $this->fpdf->SetTextColor('0', '0', '0');


            $this->fpdf->Ln(-7 * $val3);

            foreach ($NoteAnnuellecat2[$data->student->id] as $note2) {
                $this->fpdf->SetFont('Arial', 'B', 7);
                $this->fpdf->SetX(155);
                $this->fpdf->MultiCell(51, 7, utf8_decode($note2->user->nom . ' ' . $note2->user->prenom), 1, 'L');
            }

            $this->fpdf->SetX(5);

            // Moy trimestre  du groupe 2

            foreach ($NoteAnnuellecat2[$data->student->id] as $data2) {


                $sommeNoteCoef2 = $sommeNoteCoef2 + ($data2->valeur * $data2->matiere->coef);

                $sommeCoef2 = $sommeCoef2 + $data2->matiere->coef;
            }

            $moyenne2[$data->student->id] =  number_format($sommeNoteCoef2 / $sommeCoef2, 2);



            // Moyenne cat2 du devoir 1


            $sommeNoteCoefD1cat2 = 0;

            $sommeCoef2D1 = 0;


            foreach ($Notecat2[$data->student->id] as $data1) {


                $sommeNoteCoefD1cat2 = $sommeNoteCoefD1cat2 + ($data1->valeur * $data1->matiere->coef);

                $sommeCoef2D1  = $sommeCoef2D1  + $data1->matiere->coef;
            }

            $moyenneD1Cat2[$data->student->id] =  number_format($sommeNoteCoefD1cat2 / $sommeCoef2D1, 2);



            // Moyenne cat2 du devoir 2


            $sommeNoteCoefD2cat2 = 0;

            $sommeCoef2D2 = 0;


            foreach ($Note2cat2[$data->student->id] as $data1) {


                $sommeNoteCoefD2cat2 = $sommeNoteCoefD2cat2 + ($data1->valeur * $data1->matiere->coef);

                $sommeCoef2D2  = $sommeCoef2D2  + $data1->matiere->coef;
            }

            $moyenneD2Cat2[$data->student->id] =  number_format($sommeNoteCoefD2cat2 / $sommeCoef2D2, 2);



            // Moyenne cat2 du devoir 3


            $sommeNoteCoefD3cat2 = 0;

            $sommeCoef2D3 = 0;


            foreach ($Note3cat2[$data->student->id] as $data1) {


                $sommeNoteCoefD3cat2 = $sommeNoteCoefD3cat2 + ($data1->valeur * $data1->matiere->coef);

                $sommeCoef2D3  = $sommeCoef2D3  + $data1->matiere->coef;
            }

            $moyenneD3Cat2[$data->student->id] =  number_format($sommeNoteCoefD3cat2 / $sommeCoef2D3, 2);






            $this->fpdf->SetFont('Arial', 'B', 6);
            $this->fpdf->Cell(60, 6, utf8_decode('Enseignement Professionnel'), 1, 0, 'C', 1);
            $this->fpdf->Cell(10, 6, $moyenneD1Cat2[$data->student->id], 1, 0, 'C', 1);
            $this->fpdf->Cell(10, 6, $moyenneD2Cat2[$data->student->id], 1, 0, 'C', 1);
            $this->fpdf->Cell(10, 6, $moyenneD3Cat2[$data->student->id], 1, 0, 'C', 1);
            $this->fpdf->Cell(10, 6,  $moyenne2[$data->student->id], 1, 0, 'C', 1);
            $this->fpdf->Cell(10, 6,  $sommeCoef2D2, 1, 0, 'C', 1);
            $this->fpdf->Cell(10, 6, round($sommeNoteCoef2, 2), 1, 0, 'C', 1);
            $this->fpdf->Cell(81, 6, '', 1, 0, 'C', 1);

            $this->fpdf->Ln();


            foreach ($Notecat3[$data->student->id] as $note) {

                $this->fpdf->SetX(5);
                $this->fpdf->SetFont('Arial', 'B', 6);
                $this->fpdf->MultiCell(60, 7, utf8_decode($note->matiere->libelle), 1, 'L');
            }

            $this->fpdf->SetFont('Arial', 'B', 7);


            $this->fpdf->Ln(-$val4 * 7);

            foreach ($Notecat3[$data->student->id] as $note) {

                if ($note->valeur < $couleurRouge) {

                    $this->fpdf->SetTextColor('237', '28', '36');
                } else {

                    $this->fpdf->SetTextColor('0', '0', '0');
                }

                $this->fpdf->SetX(65);
                if ($MoyenneDevoir1[$data->student->id]->valeur == 0) {

                    $this->fpdf->MultiCell(10, 7, '', 1, 'C');
                } else {

                    $this->fpdf->MultiCell(10, 7, $note->valeur, 1, 'C');
                }
            }

            $this->fpdf->SetTextColor('0', '0', '0');



            $this->fpdf->Ln(-$val4 * 7);

            foreach ($Note2cat3[$data->student->id] as $note) {

                if ($note->valeur < $couleurRouge) {

                    $this->fpdf->SetTextColor('237', '28', '36');
                } else {

                    $this->fpdf->SetTextColor('0', '0', '0');
                }

                $this->fpdf->SetX(75);
                if ($MoyenneDevoir2[$data->student->id]->valeur == 0) {

                    $this->fpdf->MultiCell(10, 7, '-', 1, 'C');
                } else {

                    $this->fpdf->MultiCell(10, 7, $note->valeur, 1, 'C');
                }
            }

            $this->fpdf->SetTextColor('0', '0', '0');


            $this->fpdf->Ln(-$val4 * 7);


            foreach ($Note3cat3[$data->student->id] as $note) {

                if ($note->valeur < $couleurRouge) {

                    $this->fpdf->SetTextColor('237', '28', '36');
                } else {

                    $this->fpdf->SetTextColor('0', '0', '0');
                }

                $this->fpdf->SetX(85);
                if ($MoyenneDevoir2[$data->student->id]->valeur == 0) {

                    $this->fpdf->MultiCell(10, 7, '-', 1, 'C');
                } else {

                    $this->fpdf->MultiCell(10, 7, $note->valeur, 1, 'C');
                }
            }

            $this->fpdf->Ln(-$val4 * 7);

            foreach ($NoteAnnuellecat3[$data->student->id] as $note3) {

                if ($note3->valeur < $couleurRouge) {

                    $this->fpdf->SetTextColor('237', '28', '36');
                } else {

                    $this->fpdf->SetTextColor('0', '0', '0');
                }

                $this->fpdf->SetX(95);


                $this->fpdf->MultiCell(10, 7, round($note3->valeur, 2), 1, 'C');
            }


            $this->fpdf->SetTextColor('0', '0', '0');



            $this->fpdf->Ln(-$val4 * 7);
            foreach ($NoteAnnuellecat3[$data->student->id] as $note) {

                $this->fpdf->SetX(105);
                $this->fpdf->MultiCell(10, 7, $note->matiere->coef, 1, 'C');
            }

            $this->fpdf->Ln(-7 * $val4);
            foreach ($NoteAnnuellecat3[$data->student->id] as $note) {

                if ($note->valeur < $couleurRouge) {

                    $this->fpdf->SetTextColor('237', '28', '36');
                } else {

                    $this->fpdf->SetTextColor('0', '0', '0');
                }
                $this->fpdf->SetX(115);
                $this->fpdf->MultiCell(10, 7, round(($note->valeur) * $note->matiere->coef, 2), 1, 'C');
            }

            $this->fpdf->Ln(-7 * $val4);

            $this->fpdf->SetTextColor('0', '0', '0');


            foreach ($NoteAnnuellecat3[$data->student->id] as $note) {


                $all  = noteAnnuelle::where('matiere_id', $note->matiere->id)

                    ->where('classe_id', $IdClasse)
                    ->where('codeEtab', $codeEtab)
                    ->where('session', $session)
                    ->orderBy('valeur', 'desc')->get();

                foreach ($all as $ket => $test) {

                    if ($test->id == $note->id) {
                        $rank = $ket;

                        if ($rank + 1 == 1) {

                            $lab = "er";
                        } else {

                            $lab = "e";
                        }
                    }
                }


                $this->fpdf->SetX(125);
                $this->fpdf->MultiCell(10, 7, $rank + 1 . $lab, 1, 'C');
            }

            $this->fpdf->Ln(-$val4 * 7);

            foreach ($NoteAnnuellecat3[$data->student->id] as $note3) {

                if ($note3->valeur >= 0 && $note3->valeur < 2) {
                    $note3->mention = "Nul";
                }

                if ($note3->valeur >= 2 && $note3->valeur < 7) {

                    $note3->mention = "Très Faible";
                }

                if ($note3->valeur >= 7 && $note3->valeur < 8) {

                    $note3->mention = "Faible";
                }

                if ($note3->valeur >= 8 && $note3->valeur < 9) {

                    $note3->mention = "Insuffisant";
                }
                if ($note3->valeur >= 9 && $note3->valeur < 10) {

                    $note3->mention = "Médiocre";
                }


                if ($note3->valeur >= 10 && $note3->valeur < 12) {

                    $note3->mention = "Passable";
                }

                if ($note3->valeur >= 12 && $note3->valeur < 14) {

                    $note3->mention = "Assez-Bien";
                }

                if ($note3->valeur >= 14 && $note3->valeur < 16) {

                    $note3->mention = "Bien";
                }

                if ($note3->valeur >= 16 && $note3->valeur < 18) {

                    $note3->mention = "Très Bien";
                }

                if ($note3->valeur >= 18 && $note3->valeur <= 20) {

                    $note3->mention = "Excellent";
                }

                if ($note3->valeur < $couleurRouge) {

                    $this->fpdf->SetTextColor('237', '28', '36');
                } else {

                    $this->fpdf->SetTextColor('0', '0', '0');
                }

                $this->fpdf->SetX(135);

                $this->fpdf->SetFont('Arial', 'B', 7);
                $this->fpdf->MultiCell(20, 7, utf8_decode($note3->mention), 1, 'C');
            }

            $this->fpdf->SetTextColor('0', '0', '0');

            $this->fpdf->Ln(-$val4 * 7);


            foreach ($NoteAnnuellecat3[$data->student->id] as $note) {
                $this->fpdf->SetFont('Arial', 'B', 6);
                $this->fpdf->SetX(155);
                $this->fpdf->MultiCell(51, 7, utf8_decode($note->user->nom . ' ' . $note->user->prenom), 1, 'L');
            }



            $this->fpdf->SetX(5);

            // Moy trimestre  du groupe 3

            foreach ($NoteAnnuellecat3[$data->student->id] as $data2) {


                $sommeNoteCoef3 = $sommeNoteCoef3 + ($data2->valeur * $data2->matiere->coef);

                $sommeCoef3 = $sommeCoef3 + $data2->matiere->coef;
            }

            $moyenne3[$data->student->id] =  number_format($sommeNoteCoef3 / $sommeCoef3, 2);




            // Moyenne cat3 du devoir 1


            $sommeNoteCoefD1cat3 = 0;

            $sommeCoef3D1 = 0;


            foreach ($Notecat3[$data->student->id] as $data1) {


                $sommeNoteCoefD1cat3 = $sommeNoteCoefD1cat3 + ($data1->valeur * $data1->matiere->coef);

                $sommeCoef3D1  =  $sommeCoef3D1  + $data1->matiere->coef;
            }

            $moyenneD1Cat3[$data->student->id] =  number_format($sommeNoteCoefD1cat3 / $sommeCoef3D1, 2);


            // Moyenne cat3 du devoir 2


            $sommeNoteCoefD2cat3 = 0;

            $sommeCoef3D2 = 0;


            foreach ($Note2cat3[$data->student->id] as $data1) {


                $sommeNoteCoefD2cat3 =  $sommeNoteCoefD2cat3 + ($data1->valeur * $data1->matiere->coef);

                $sommeCoef3D2  = $sommeCoef3D2  + $data1->matiere->coef;
            }

            $moyenneD2Cat3[$data->student->id] =  number_format($sommeNoteCoefD2cat3 / $sommeCoef3D2, 2);



            // Moyenne cat3 du devoir 3


            $sommeNoteCoefD3cat3 = 0;

            $sommeCoef3D2 = 0;


            foreach ($Note3cat3[$data->student->id] as $data1) {


                $sommeNoteCoefD3cat3 =  $sommeNoteCoefD3cat3 + ($data1->valeur * $data1->matiere->coef);

                $sommeCoef3D2  = $sommeCoef3D2  + $data1->matiere->coef;
            }

            $moyenneD3Cat3[$data->student->id] =  number_format($sommeNoteCoefD3cat3 / $sommeCoef3D2, 2);


            $this->fpdf->SetFont('Arial', 'B', 6);
            $this->fpdf->Cell(60, 6, utf8_decode('Enseignement Complémentaire '), 1, 0, 'C', 1);
            $this->fpdf->Cell(10, 6,  $moyenneD1Cat3[$data->student->id], 1, 0, 'C', 1);
            $this->fpdf->Cell(10, 6, $moyenneD2Cat3[$data->student->id], 1, 0, 'C', 1);
            $this->fpdf->Cell(10, 6, $moyenneD3Cat3[$data->student->id], 1, 0, 'C', 1);
            $this->fpdf->Cell(10, 6,  $moyenne3[$data->student->id], 1, 0, 'C', 1);
            $this->fpdf->Cell(10, 6, $sommeCoef3, 1, 0, 'C', 1);
            $this->fpdf->Cell(10, 6, $sommeNoteCoef3, 1, 0, 'C', 1);
            $this->fpdf->Cell(81, 6, '', 1, 0, 'C', 1);


            $this->fpdf->Ln(12);

            $this->fpdf->SetX(5);
            $this->fpdf->SetFont('Arial', 'B', 6);
            $this->fpdf->Cell(45, 5, utf8_decode('RAPPEL'), 1, 0, 'C', 1);
            $this->fpdf->Cell(35, 5, utf8_decode('TRAVAIL DE LA CLASSE'), 1, 0, 'C', 1);
            $this->fpdf->Cell(35, 5, 'TRAVAIL' . utf8_decode(strtoupper($libelleTrimestre)), 1, 0, 'C', 1);
            $this->fpdf->Cell(46, 5, utf8_decode('CONDUITE'), 1, 0, 'C', 1);
            $this->fpdf->Cell(40, 5, utf8_decode('TRAVAIL'), 1, 0, 'C', 1);


            // Moyenne et rang du devoir 1



            // dd( $MoyenneDevoir1[$data->student->id]->student_id);

            //  Ran du devoir 1

            $moyDevoir1 = MoyenneTrimestres::where('session', $session)->where('codeEtab', $codeEtab)
                ->where('trimestre_id', $idTrim1)
                ->where('classe_id', $IdClasse)
                ->orderBy('valeur', 'DESC')->get();


            // // dd(  $moyDevoir1);


            foreach ($moyDevoir1   as $key => $dataa) {


                if ($dataa->student_id == $MoyenneDevoir1[$data->student->id]->student_id) {

                    $rankEval1[$dataa->student->id] = $key + 1;
                }
            }



            //  Ran du devoir 2


            $moyDevoir2 = MoyenneTrimestres::where('session', $session)
                ->where('codeEtab', $codeEtab)
                ->where('trimestre_id', $idTrim2)
                ->where('classe_id', $IdClasse)
                ->orderBy('valeur', 'DESC')->get();

            foreach ($moyDevoir2   as $key => $dataa) {


                if ($dataa->student_id == $MoyenneDevoir2[$data->student->id]->student_id) {

                    $rankEval2[$dataa->student->id] = $key + 1;
                }
            }


            //  Ran du devoir 3


            $moyDevoir3 = MoyenneTrimestres::where('session', $session)
                ->where('codeEtab', $codeEtab)
                ->where('trimestre_id', $idTrim3)
                ->where('classe_id', $IdClasse)
                ->orderBy('valeur', 'DESC')->get();

            foreach ($moyDevoir3   as $key => $dataa) {


                if ($dataa->student_id == $MoyenneDevoir3[$data->student->id]->student_id) {

                    $rankEval3[$dataa->student->id] = $key + 1;
                }
            }

            $this->fpdf->Ln();
            $this->fpdf->SetX(5);
            $this->fpdf->Cell(9, 5, utf8_decode(''), 1, 0, 'C', 0);
            $this->fpdf->Cell(12, 5, utf8_decode('MOY'), 1, 0, 'C', 1);
            $this->fpdf->Cell(12, 5, utf8_decode('Rang'), 1, 0, 'C', 1);
            $this->fpdf->Cell(12, 5, utf8_decode('ABS'), 1, 0, 'C', 1);

            $rankEval1[$data->student->id] = $rankEval1[$data->student->id];


            if ($MoyenneDevoir1[$data->student->id]->valeur == 0) {

                $MoyenneDevoir1[$data->student->id]->valeur = '#';
                $rankEval1[$data->student->id] = '#';
            } else {

                $rankEval1[$data->student->id] = $rankEval1[$data->student->id];
            }

            //$this->fpdf->Cell(15, 5,  $MoyenneDevoir1[$data->student->id]->valeur, 1, 0, 'C', 0);
            $this->fpdf->Cell(25, 5, utf8_decode('MOY CLASSE / 20'), 1, 0, 'L', 0);
            $this->fpdf->Cell(10, 5, number_format($moyenneSommeClasse / $nombreEleves, 2), 1, 0, 'C', 0);
            $this->fpdf->SetX(85);
            $this->fpdf->Cell(25, 5, utf8_decode('TOTAL POINTS'), 1, 0, 'L', 0);
            $this->fpdf->Cell(10, 5,  $sommeNoteCoef1 + $sommeNoteCoef2 + $sommeNoteCoef3, 1, 0, 'C', 0);
            $this->fpdf->SetX(120);
            $this->fpdf->Cell(33, 5, utf8_decode('ABSENCES (h)'), 1, 0, 'L', 0);
            $this->fpdf->Cell(13, 5, $heureTrim1 + $heureTrim2 + $heureTrim3, 1, 0, 'C', 0); // $heureTrimestre
            $this->fpdf->Cell(27, 5, utf8_decode('FELICITATIONS'), 1, 0, 'L', 0);
            $this->fpdf->Cell(13, 5, '', 1, 0, 'C', 0);


            // Rang Eval1

            // $moyenneEval1[$data->student->id] = Moyennes::where('evaluation_id',$idEval1);
            if ($rankEval1[$data->student->id] == 1) {

                $label1 = 'er';
            } else {
                $label1 = 'eme';
            }

            $this->fpdf->Ln();
            $this->fpdf->SetX(5);
            $this->fpdf->Cell(9, 5, utf8_decode('TRIM ' . $idTrim1), 1, 0, 'L', 1);

            $this->fpdf->Cell(12, 5, utf8_decode($MoyenneDevoir1[$data->student->id]->valeur . ' / 20'), 1, 0, 'C', 0);
            $this->fpdf->Cell(12, 5, utf8_decode($rankEval1[$data->student->id] . ' ' . $label1), 1, 0, 'C', 0);

            $this->fpdf->Cell(12, 5, utf8_decode($heureTrim1), 1, 0, 'C', 0);



            // if ($rankEval1[$data->student->id] == 1) {

            //     $label = 'er';
            // } else {
            //     $label = 'eme';
            // }
            //$this->fpdf->Cell(15, 5, $rankEval1[$data->student->id] . ' ' . $label, 1, 0, 'C', 0);
            $this->fpdf->Cell(25, 5, utf8_decode('MOY PREMIER / 20 '), 1, 0, 'L', 0);
            $this->fpdf->Cell(10, 5, $MoyPremier, 1, 0, 'C', 0);
            $this->fpdf->Cell(25, 5, utf8_decode('TOTAL COEFS'), 1, 0, 'L', 0);
            $this->fpdf->Cell(10, 5, $sommeCoef1 + $sommeCoef2 + $sommeCoef3, 1, 0, 'C', 0);
            $this->fpdf->Cell(33, 5, utf8_decode('CONSIGNE (h)'), 1, 0, 'L', 1);
            $this->fpdf->Cell(13, 5, '', 1, 0, 'C', 0); // $heureConsigneTrimestre
            $this->fpdf->Cell(27, 5, utf8_decode('ENCOURAGEMENTS'), 1, 0, 'L', 0);
            $this->fpdf->Cell(13, 5, '', 1, 0, 'C', 0);


            $this->fpdf->Ln();
            $this->fpdf->SetX(5);

            $rankEval2[$data->student->id] = $rankEval2[$data->student->id];



            // if ($MoyenneDevoir2[$data->student->id]->valeur == 0) {
            //     $MoyenneDevoir2[$data->student->id]->valeur = '-';
            //     $rankEval2[$data->student->id] = '-';
            // } else {

            //     $rankEval2[$data->student->id] = $rankEval2[$data->student->id];
            // }

            if ($rankEval2[$data->student->id] == 1) {

                $label2 = 'er';
            } else {
                $label2 = 'eme';
            }


            $this->fpdf->SetFont('Arial', 'B', 6);
            // $this->fpdf->Cell(30, 5, utf8_decode('MOYENNE' . ' TRIMESTRE ' . $idTrim2), 1, 0, 'L', 0);

            $this->fpdf->Cell(9, 5, utf8_decode('TRIM ' . $idTrim2), 1, 0, 'L', 1);

            $this->fpdf->Cell(12, 5, utf8_decode($MoyenneDevoir2[$data->student->id]->valeur . ' / 20'), 1, 0, 'C', 0);
            $this->fpdf->Cell(12, 5, utf8_decode($rankEval2[$data->student->id] . ' ' . $label2), 1, 0, 'C', 0);

            $this->fpdf->Cell(12, 5, utf8_decode($heureTrim2), 1, 0, 'C', 0);


            // $this->fpdf->Cell(15, 5, $MoyenneDevoir2[$data->student->id]->valeur, 1, 0, 'C', 0);
            $this->fpdf->Cell(25, 5, utf8_decode('MOY Dernier / 20 '), 1, 0, 'L', 0);
            $this->fpdf->Cell(10, 5, $MoyDernier, 1, 0, 'C', 0);
            $this->fpdf->Cell(25, 5, 'MOYENNE / 20 ', 1, 0, 'C', 1);
            $this->fpdf->Cell(10, 5, $data->valeur, 1, 0, 'C', 0);



            $this->fpdf->Cell(33, 5, utf8_decode('AVERTISSEMENT CONDUITE'), 1, 0, 'L', 0);
            $this->fpdf->Cell(13, 5, '', 1, 0, 'C', 0);
            $this->fpdf->Cell(27, 5, utf8_decode("TABLEAU D'HONNEUR "), 1, 0, 'L', 0);
            $this->fpdf->Cell(13, 5, '', 1, 0, 'C', 0);

            // if ($MoyenneDevoir3[$data->student->id]->valeur == 0) {
            //     $MoyenneDevoir3[$data->student->id]->valeur = '';
            //     $rankEval3[$data->student->id] = '';
            // } else {

            //     $rankEval2[$data->student->id] = $rankEval2[$data->student->id];
            // }


            if ($rankEval3[$data->student->id] == 1) {

                $label3 = 'er';
            } else {
                $label3 = 'eme';
            }

            $this->fpdf->Ln();
            $this->fpdf->SetX(5);
            $this->fpdf->Cell(9, 5, utf8_decode('TRIM ' . $idTrim3), 1, 0, 'L', 1);

            $this->fpdf->Cell(12, 5, utf8_decode($MoyenneDevoir3[$data->student->id]->valeur . ' / 20'), 1, 0, 'C', 0);
            $this->fpdf->Cell(12, 5, utf8_decode($rankEval3[$data->student->id] . ' ' .  $label3), 1, 0, 'C', 0);

            $this->fpdf->Cell(12, 5, utf8_decode($heureTrim3), 1, 0, 'C', 0);





            // $this->fpdf->Cell(15, 5,   $rankEval2[$data->student->id] . ' ' . $label, 1, 0, 'C', 0);

            $this->fpdf->Cell(35, 5, utf8_decode(''), 1, 0, 'L', 0);

            $this->fpdf->Cell(25, 5, 'RANG', 1, 0, 'C', 0);
            $this->fpdf->Cell(10, 5, ($ley + 1) . ' ' . $e, 1, 0, 'C', 1);

            $this->fpdf->Cell(33, 5, utf8_decode('EXCLUSIONS ( jrs )'), 1, 0, 'L', 0);
            $this->fpdf->Cell(13, 5, '', 1, 0, 'C', 1); // $ExclusionTrimestre
            $this->fpdf->Cell(27, 5, utf8_decode("BLAME TRAVAIL "), 1, 0, 'L', 0);
            $this->fpdf->Cell(13, 5, '', 1, 0, 'C', 0);



            $this->fpdf->Ln();
            $this->fpdf->SetX(120);
            $this->fpdf->Cell(33, 5, utf8_decode('BLAME CONDUITE'), 1, 0, 'L', 0);
            $this->fpdf->Cell(13, 5, '', 1, 0, 'C', 0);
            $this->fpdf->Cell(27, 5, utf8_decode('BLAME TRAVAIL'), 1, 0, 'L', 0);
            $this->fpdf->Cell(13, 5, '', 1, 0, 'C', 0);

            $this->fpdf->SetX(5);
            $this->fpdf->SetFont('Arial', 'B', 8);
            // $this->fpdf->Cell(30, 5, utf8_decode('MOYENNE' . ' TRIMESTRE' . $idTrim3), 1, 0, 'L', 0);

            // $this->fpdf->Cell(15, 5, $MoyenneDevoir3[$data->student->id]->valeur, 1, 0, 'C', 0);


            // Recuperons les id des evaluations correspondant au trimestre dont on a l'id en haut



            if (($libelleClasse[0] == "P" || $libelleClasse[0] == "T")) {

                $this->fpdf->SetTextColor('206', '0', '0');
                $this->fpdf->Cell(161, 5, utf8_decode(' Redouble si Echec '), 1, 0, 'C', 0);
            } else if ($libelleClasse[0] != "P" && $libelleClasse[0] != "T") {

                if ($data->valeur >= 10) {

                    $this->fpdf->SetTextColor('0', '128', '64');

                    $this->fpdf->Cell(161, 5, utf8_decode('Admis(e) en classe supérieure'), 1, 0, 'C', 0);
                } else {

                    $this->fpdf->SetTextColor('206', '0', '0');
                    $this->fpdf->Cell(161, 5, utf8_decode('Redouble la classe de ' . $libelleClasse), 1, 0, 'C', 0);
                }
            }







            // if ($data->valeur >= 14) {

            //     $this->fpdf->SetTextColor('0', '128', '64');

            //     $this->fpdf->Cell(161, 5, utf8_decode('PROMU(E) EN CLASSE DE ' . ($labelClasseChiffre - 1) . '' . $labelSuiteClasse), 1, 0, 'C', 0);
            // } else {

            //     $this->fpdf->SetTextColor('206', '0', '0');


            //     $this->fpdf->Cell(161, 5, utf8_decode('REDOUBLE LA CLASSE DE ' . $libelleClasse), 1, 0, 'C', 0);
            // }


            $this->fpdf->SetTextColor('0', '0', '0');



            //  Ran du devoir 3


            $moyDevoir3 = MoyenneTrimestres::where('session', $session)
                ->where('codeEtab', $codeEtab)
                ->where('trimestre_id', $idTrim3)
                ->where('classe_id', $IdClasse)
                ->orderBy('valeur', 'DESC')->get();

            // foreach ($moyDevoir3   as $key => $dataa) {


            //     if ($dataa->student_id == $MoyenneDevoir3[$data->student->id]->student_id) {

            //         $rankEval3[$dataa->student->id] = $key + 1;
            //     }
            // }

            // if ($MoyenneDevoir3[$data->student->id]->valeur == 0) {
            //     $MoyenneDevoir3[$data->student->id]->valeur = '-';
            //     $rankEval3[$data->student->id] = '-';
            // } else {

            //     $rankEval3[$data->student->id] = $rankEval3[$data->student->id];
            // }



            $this->fpdf->Ln();
            $this->fpdf->SetX(5);
            $this->fpdf->SetFont('Arial', 'B', 6);
            // $this->fpdf->Cell(30, 5, utf8_decode('Rang' . ' TRIMESTRE' . $idTrim3), 1, 0, 'L', 0);
            // $this->fpdf->Cell(15, 5,   $rankEval3[$data->student->id] . ' ' . $label, 1, 0, 'C', 0);



            $this->fpdf->SetX(5);

            $this->fpdf->Cell(45, 5, utf8_decode('VISA DU PARENT '), 1, 0, 'C', 1);
            $this->fpdf->Cell(103, 5, utf8_decode('OBSERVATION DU CONSEIL DE CLASSE'), 1, 0, 'C', 1);
            $this->fpdf->Cell(53, 5, 'VISA DU CHEF D\'ETABLISSEMENT', 1, 0, 'C', 1);


            $this->fpdf->SetX(10);
            $this->fpdf->Cell(45, 20, '', 0, 0, 'L', 0);
            $this->fpdf->Cell(103, 20, utf8_decode(''), 0, 0, 'L', 0);
            $this->fpdf->Cell(53, 21, '       Douala le _______________________', 0, 0, 'L', 0);

            $this->fpdf->SetX(5);
            $this->fpdf->Cell(45, 45, '', 1, 0, 'L', 0);
            $this->fpdf->Cell(103, 45, utf8_decode(''), 1, 0, 'L', 0);
            $this->fpdf->Cell(53, 45, '    ', 1, 0, 'L', 0);

            $sommeNoteCoef1 = $sommeNoteCoef2 = $sommeNoteCoef3 = 0;

            $sommeCoef1 = $sommeCoef2 = $sommeCoef3 = 0;
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
            ->where('codeEtab', $codeEtab)->get();

        $effectif = Student::where('classe_id', $IdClasse)->where('session', $session)
            ->where('codeEtab', $codeEtab)->count();

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





            $this->fpdf->AddPage("P", ['375', '215']);

            $Note[$data->student->id] = Notes::with('matiere', 'student', 'evaluation', 'user')
                ->where('evaluation_id', $IdEvaluation)
                ->where('classe_id', $IdClasse)
                ->where('cat_id', 1)
                ->where('student_id', $data->student->id)
                ->where('codeEtab', $codeEtab)

                ->where('session', $session)->orderBy('matiere_id', 'ASC')->get();







            // Moyenne du groupe 1


            foreach ($Note[$data->student->id] as $data1) {



                // $sommeNoteCoef1 = $sommeNoteCoef1 + ($data1->valeur * $data1->matiere->coef);

                // $sommeCoef1 = $sommeCoef1 + $data1->matiere->coef;

                if ($data1->status == null) {

                    $sommeNoteCoef1 = $sommeNoteCoef1 + ($data1->valeur * $data1->matiere->coef);

                    $sommeCoef1 = $sommeCoef1 + $data1->matiere->coef;
                }
            }


            // dump($moyenne1[$data->student->id]);

            if ($sommeCoef1 == 0) {
                $moyenne1[$data->student->id] = 0;
            } else {

                $moyenne1[$data->student->id] =  number_format($sommeNoteCoef1 / $sommeCoef1, 2);
            }








            // Ici je calcule le nombre de matiere de la category 2 et 3 car comme dan le bulletin elle sort au milieur ( enseigmnt professionels), son
            // decalage gate l'appercu, duc coup je dois je dois faire ce nomdre * (-5) pour le bon decalage
            // Le groupe 1 derange pas dans le decalage


            $val  = Notes::where('classe_id', $IdClasse)
                ->where('cat_id', 2)->where('student_id', $data->student->id)
                ->where('evaluation_id', $IdEvaluation)
                ->where('codeEtab', $codeEtab)
                ->where('session', $session)->count();


            $val3  = Notes::where('classe_id', $IdClasse)
                ->where('cat_id', 3)->where('student_id', $data->student->id)
                ->where('evaluation_id', $IdEvaluation)
                ->where('codeEtab', $codeEtab)
                ->where('session', $session)->count();






            // Moyenne du dernier

            $MoyDernier = Moyennes::where('evaluation_id', $IdEvaluation)->where('classe_id', $IdClasse)->where('valeur', '>', 0)->min('valeur');


            // // Moyenne du premier

            $MoyPremier = Moyennes::where('evaluation_id', $IdEvaluation)->where('classe_id', $IdClasse)->max('valeur');


            // // Moyenne du premier

            $NombreAdmis = count(Moyennes::where('evaluation_id', $IdEvaluation)->where('classe_id', $IdClasse)->where('valeur', '>=', 10)->get());





            // Je cherche les heures dans cette sequence

            $trimestre  = Evaluations::where('id', $IdEvaluation)->first();

            // Absences total

            $heureTrimestre  = Presences::where('classe_id', $IdClasse)
                ->where('evaluation_id', $IdEvaluation)->where('student_id', $data->student->id)
                ->where('codeEtab', $codeEtab)
                ->where('session', $session)->sum('duree');


            // Absences non justifies

            $heureTrimestreNonJustifies = Presences::where('classe_id', $IdClasse)
                ->where('evaluation_id', $IdEvaluation)->where('student_id', $data->student->id)
                ->where('codeEtab', $codeEtab)->where('etat', 0)
                ->where('session', $session)->sum('duree');


            // Je cherche les consigne et les jour d'exusion du trimestre

            $heureConsigneTrimestre  = discipline::where('classe_id', $IdClasse)
                ->where('evaluation_id', $IdEvaluation)->where('student_id', $data->student->id)->where('type', 'con')
                ->where('codeEtab', $codeEtab)
                ->where('session', $session)->sum('duree');


            $ExclusionTrimestre  = discipline::where('classe_id', $IdClasse)
                ->where('evaluation_id', $IdEvaluation)->where('student_id', $data->student->id)->where('type', 'ex')
                ->where('codeEtab', $codeEtab)
                ->where('session', $session)->sum('duree');




            // je recupere les photo des eleves dans user

            $EleveData[$data->student->id] = Student::with('user')->where('id', $data->student->id)->get();


            //$this->fpdf->SetXY(20,115);


            $this->fpdf->Image(public_path("/Photos/Logos/" . $entete), 5, 3, 205, 32, "");

            // $this->fpdf->Image(public_path("/Photos/Logos/footer.jpeg"), 0, 293, 220, 5,  "");



            // Informations de l'eleve

            $this->fpdf->SetFont('Arial', 'B', $tailleLIbelleMatiere);
            $this->fpdf->Text(105, 55, 'Matricule : ');
            $this->fpdf->SetFont('Arial', 'B',  $tailleLIbelleMatiere);
            $this->fpdf->Text(137, 55, $Note[$data->student->id][0]->student->matricule);



            $this->fpdf->SetFont('Arial', 'B',  $tailleLIbelleMatiere);
            $this->fpdf->Text(105, 60, utf8_decode('Noms et prénoms :  '));
            $this->fpdf->SetFont('Arial', 'B',  $tailleLIbelleMatiere);
            $this->fpdf->Text(137, 60, utf8_decode($Note[$data->student->id][0]->student->nom . ' ' . $Note[$data->student->id][0]->student->prenom));

            $this->fpdf->SetFont('Arial', 'B',  $tailleLIbelleMatiere);
            $this->fpdf->Text(105, 65, utf8_decode('Née le :'));
            $this->fpdf->SetFont('Arial', 'B',  $tailleLIbelleMatiere);
            $this->fpdf->Text(137, 65, utf8_decode(date_format(date_create($Note[$data->student->id][0]->student->dateNaiss), "d-m-Y") . ' ' . ' à  ' . ' '  . $Note[$data->student->id][0]->student->lieuNaiss));
            $this->fpdf->SetFont('Arial', 'B',  $tailleLIbelleMatiere);

            $this->fpdf->Text(105, 70, 'Sexe : ');
            $this->fpdf->SetFont('Arial', 'B',  $tailleLIbelleMatiere);
            $this->fpdf->Text(137, 70, $data->student->sexe);
            $this->fpdf->SetFont('Arial', 'B', $tailleLIbelleMatiere);

            $this->fpdf->Text(105, 75, 'Redoublant : ');
            $this->fpdf->SetFont('Arial', 'B', 7);

            if ($data->student->doublant == "REDOUBLANT") {
                $this->fpdf->Text(
                    137,
                    75,
                    "Oui"
                );
            } else {

                $this->fpdf->Text(
                    137,
                    75,
                    "Non"
                );
            }




            $this->fpdf->SetFont('Arial', 'B', $tailleLIbelleMatiere);



            // // // // deuxiemme


            $this->fpdf->Text(37, 55, utf8_decode('Anneé-Scolaire  : '));
            $this->fpdf->SetFont('Arial', 'B', $tailleLIbelleMatiere);
            $this->fpdf->Text(59, 55, utf8_decode($session));
            $this->fpdf->SetFont('Arial', 'B', $tailleLIbelleMatiere);




            $this->fpdf->Text(37, 60, 'Classe  : ');
            $this->fpdf->SetFont('Arial', 'B',  $tailleLIbelleMatiere);
            $this->fpdf->Text(59, 60, utf8_decode($Note[$data->student->id][0]->Classe->libelleClasse));
            $this->fpdf->SetFont('Arial', 'B',  $tailleLIbelleMatiere);

            $this->fpdf->Text(37, 65, 'Effectif  :  ');
            $this->fpdf->SetFont('Arial', 'B',  $tailleLIbelleMatiere);
            $this->fpdf->Text(59, 65, $effectif);
            $this->fpdf->SetFont('Arial', 'B',  $tailleLIbelleMatiere);


            $this->fpdf->Text(37, 70, 'Prof principal  :');
            $this->fpdf->SetFont('Arial', 'B',  $tailleLIbelleMatiere);
            $this->fpdf->Text(59, 70, utf8_decode($teach->nom . ' ' . $teach->prenom));


            if (file_exists(public_path("/Photos/Logos/" . $EleveData[$data->student->id][0]->user->photo))) {


                $this->fpdf->Image(public_path("/Photos/Logos/" . $EleveData[$data->student->id][0]->user->photo), 10, 52, 25, 27,  "");
            }





            // // Cadre information eleve



            $this->fpdf->SetXY(10, 52);
            $this->fpdf->Cell(25, 27, '', 1);

            $this->fpdf->SetXY(35, 52);
            $this->fpdf->Cell(23, 27, '', 1);


            $this->fpdf->SetXY(58, 52);
            $this->fpdf->Cell(45, 27, '', 1);


            $this->fpdf->SetXY(103, 52);
            $this->fpdf->Cell(33, 27, '', 1);


            $this->fpdf->SetXY(136, 52);
            $this->fpdf->Cell(67, 27, '', 1);





            // Cadre totale

            // $this->fpdf->SetDrawColor(0, 0, 0);
            $this->fpdf->SetTextColor('10', '75', '168');
            // $this->fpdf->SetXY(10, 10);
            // $this->fpdf->Cell(191, 266, '', 1);

            $this->fpdf->SetFont('Arial', 'B', 13);
            $this->fpdf->SetXY(10, 43);
            $this->fpdf->Cell(0, 0, utf8_decode('BULLETIN DES EVALUATIONS N°') . '' . strtoupper($Note[$data->student->id][0]->evaluation->id - 1), 0, 0, 'C');

            // Cadre pour le titre de l'ecole

            // $this->fpdf->SetXY(50,39);
            // $this->fpdf->Cell(100,10,'',1);

            $this->fpdf->SetFont('Arial', 'B', 7);
            $this->fpdf->SetTextColor(0, 0, 0);
            // Tire cadre a cote
            // $this->fpdf->Text(135, 72, strtoupper($classeName->libelleEtab));

            $this->fpdf->SetXY(10, 85);
            // $this->fpdf->SetFont('Arial', 'B', 7);
            $this->fpdf->SetDrawColor(0, 0, 0);
            $this->fpdf->SetFillColor('166', '166', '166');
            $this->fpdf->Cell(70, 7, utf8_decode('Matières'), 1, 0, 'C', 1);

            $this->fpdf->SetFont('Arial', 'B', 8);
            $this->fpdf->Cell(10, 7, 'Notes', 1, 0, 'C', 1);
            $this->fpdf->Cell(10, 7, 'Coef', 1, 0, 'C', 1);
            $this->fpdf->Cell(10, 7, 'N*C', 1, 0, 'C', 1);
            $this->fpdf->Cell(10, 7, 'Rang', 1, 0, 'C', 1);
            $this->fpdf->Cell(11, 7, utf8_decode('Appré'), 1, 0, 'C', 1);
            $this->fpdf->Cell(10, 7, utf8_decode('Max'), 1, 0, 'C', 1);
            $this->fpdf->Cell(10, 7, utf8_decode('Min'), 1, 0, 'C', 1);
            $this->fpdf->Cell(53, 7, 'Responsable et signature', 1, 0, 'L', 1);
            // $this->fpdf->Cell(20, 10, 'Signature prof', 1, 0, 'C', 1);
            $this->fpdf->Ln();
            $this->fpdf->SetX(20);




            foreach ($Note[$data->student->id] as $note) {

                $this->fpdf->SetX(10);
                $this->fpdf->SetFont('Arial', 'B',  $tailleLIbelleMatiere);
                $this->fpdf->MultiCell(70, 8, utf8_decode($note->matiere->libelle), 1, 'L');
            }

            $this->fpdf->SetTextColor('0', '0', '0');

            $this->fpdf->SetY(92);


            foreach ($Note[$data->student->id] as $note) {

                $this->fpdf->SetFont('Arial', 'B', $tailleNote - 1);

                if ($note->valeur < $couleurRouge) {

                    $this->fpdf->SetTextColor('237', '28', '36');
                } else {

                    $this->fpdf->SetTextColor('0', '0', '0');
                }

                $this->fpdf->SetX(80);

                if ($note->status == 1) {

                    $this->fpdf->MultiCell(10, 8, "-", 1, 'C');
                } else {

                    $this->fpdf->MultiCell(10, 8, $note->valeur, 1, 'C');
                }
            }


            $this->fpdf->SetTextColor('0', '0', '0');



            $this->fpdf->SetY(92);
            foreach ($Note[$data->student->id] as $note) {

                $this->fpdf->SetX(90);


                $this->fpdf->MultiCell(10, 8, $note->matiere->coef, 1, 'C');
            }


            $this->fpdf->SetY(92);
            foreach ($Note[$data->student->id] as $note) {


                //dd($note);

                if ($note->valeur < $couleurRouge) {

                    $this->fpdf->SetTextColor('237', '28', '36');
                } else {

                    $this->fpdf->SetTextColor('0', '0', '0');
                }

                $this->fpdf->SetX(100);

                if ($note->status == 1) {

                    $this->fpdf->MultiCell(10, 8, '-', 1, 'C');
                } else {

                    $this->fpdf->MultiCell(10, 8, $note->valeur * $note->matiere->coef, 1, 'C');
                }
            }

            $this->fpdf->SetTextColor('0', '0', '0');


            $this->fpdf->SetY(92);
            foreach ($Note[$data->student->id] as $note) {


                if ($note->valeur >= 0 && $note->valeur < 10) {
                    $note->mention = "NA";
                }

                if ($note->valeur >= 10 && $note->valeur < 15) {
                    $note->mention = "ECA";
                }

                if ($note->valeur >= 15) {
                    $note->mention = "Acquis";
                }


                if ($note->valeur < $couleurRouge) {

                    $this->fpdf->SetTextColor('237', '28', '36');
                } else {

                    $this->fpdf->SetTextColor('0', '0', '0');
                }


                $this->fpdf->SetX(120);


                if ($note->status == 1) {

                    $this->fpdf->MultiCell(11, 8, '-', 1, 'C');
                } else {

                    $this->fpdf->MultiCell(11, 8, utf8_decode($note->mention), 1, 'C');
                }
            }

            $this->fpdf->SetTextColor('0', '0', '0');


            $this->fpdf->SetY(92);
            foreach ($Note[$data->student->id] as $note) {


                $all  = Notes::where('matiere_id', $note->matiere->id)
                    ->where('evaluation_id', $IdEvaluation)
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
                            $labelRang = utf8_decode("è");
                        }
                    }
                }


                $this->fpdf->SetX(110);
                $this->fpdf->SetFont('Arial', 'B',  7);

                if ($note->status == 1) {

                    $this->fpdf->MultiCell(10, 8, "-", 1, 'C');
                } else {

                    $this->fpdf->MultiCell(10, 8, $rank + 1 . $labelRang, 1, 'C');
                }
            }

            $this->fpdf->SetY(92);
            foreach ($Note[$data->student->id] as $note) {

                $max = Notes::where('evaluation_id', $IdEvaluation)->where('classe_id', $IdClasse)
                    ->where('matiere_id', $note->matiere->id)->where('status', null)->max('valeur');

                $this->fpdf->SetX(131);
                $this->fpdf->MultiCell(10, 8, $max, 1, 'C');
            }


            $this->fpdf->SetY(92);
            foreach ($Note[$data->student->id] as $note) {

                $min = Notes::where('evaluation_id', $IdEvaluation)->where('classe_id', $IdClasse)
                    ->where('matiere_id', $note->matiere->id)->where('status', null)->min('valeur');

                $this->fpdf->SetX(141);
                $this->fpdf->MultiCell(10, 8, $min, 1, 'C');
            }




            $this->fpdf->SetTextColor('0', '0', '0');
            $this->fpdf->SetY(92);
            $this->fpdf->SetFont('Arial', 'B',   $tailleLIbelleMatiere - 1);
            foreach ($Note[$data->student->id] as $note) {

                $this->fpdf->SetX(151);
                $this->fpdf->MultiCell(53, 8, utf8_decode($note->user->nom) . ' ' . utf8_decode($note->user->prenom) . ' ', 1, 'L');
            }

            // // Rank c'est le rang par matiere et key le rang en classe par rapport a la moyenne






            $this->fpdf->SetX(10);

            $this->fpdf->SetFont('Arial', 'B', 6);
            $this->fpdf->Cell(70, 6, utf8_decode('Enseignement Général'), 1, 0, 'C', 1);
            $this->fpdf->Cell(10, 6, $moyenne1[$data->student->id], 1, 0, 'C', 1);
            $this->fpdf->Cell(10, 6, $sommeCoef1, 1, 0, 'C', 1);
            $this->fpdf->Cell(10, 6, $sommeNoteCoef1, 1, 0, 'C', 1);
            $this->fpdf->Cell(94, 6, '', 1, 0, 'C', 1);

            $this->fpdf->SetX(20);

            // Moy du groupe 2

            $Note2[$data->student->id] = Notes::with('matiere', 'student', 'evaluation', 'user')
                ->where('evaluation_id', $IdEvaluation)
                ->where('classe_id', $IdClasse)
                ->where('cat_id', 2)
                ->where('student_id', $data->student->id)
                ->where('codeEtab', $codeEtab)
                ->where('session', $session)->orderBy('matiere_id', 'ASC')->get();


            // dd($Note2[$data->student->id] );




            foreach ($Note2[$data->student->id] as $data2) {



                if ($data2->status == null) {

                    $sommeNoteCoef2 = $sommeNoteCoef2 + ($data2->valeur * $data2->matiere->coef);

                    $sommeCoef2 = $sommeCoef2 + $data2->matiere->coef;
                }
            }

            if ($sommeCoef2 == 0) {
                $moyenne2[$data->student->id] = 0;
            } else {

                $moyenne2[$data->student->id] =  number_format($sommeNoteCoef2 / $sommeCoef2, 2);
            }




            $this->fpdf->Ln();


            foreach ($Note2[$data->student->id] as $note2) {




                $this->fpdf->SetX(10);
                $this->fpdf->SetFont('Arial', 'B',   $tailleLIbelleMatiere);
                $this->fpdf->MultiCell(70, 8, utf8_decode($note2->matiere->libelle), 1, 'L');
            }

            $this->fpdf->SetTextColor('0', '0', '0');


            $this->fpdf->Ln(-8 * $val);

            foreach ($Note2[$data->student->id] as $note2) {

                if ($note2->valeur < $couleurRouge) {

                    $this->fpdf->SetTextColor('237', '28', '36');
                } else {

                    $this->fpdf->SetTextColor('0', '0', '0');
                }
                $this->fpdf->SetX(80);



                if ($note2->status == 1) {

                    $this->fpdf->MultiCell(10, 8, "-", 1, 'C');
                } else {
                    $this->fpdf->MultiCell(10, 8, $note2->valeur, 1, 'C');
                }
            }

            $this->fpdf->SetTextColor('0', '0', '0');

            $this->fpdf->Ln(-8 * $val);


            foreach ($Note2[$data->student->id] as $note2) {




                $this->fpdf->SetX(90);

                $this->fpdf->MultiCell(10, 8, $note2->matiere->coef, 1, 'C');
            }


            $this->fpdf->SetTextColor('0', '0', '0');


            $this->fpdf->Ln(-8 * $val);
            foreach ($Note2[$data->student->id] as $note2) {

                if ($note2->valeur < $couleurRouge) {

                    $this->fpdf->SetTextColor('237', '28', '36');
                } else {

                    $this->fpdf->SetTextColor('0', '0', '0');
                }

                $this->fpdf->SetX(100);

                if ($note2->status == 1) {

                    $this->fpdf->MultiCell(10, 8, "-", 1, 'C');
                } else {
                    $this->fpdf->MultiCell(10, 8, $note2->valeur * $note2->matiere->coef, 1, 'C');
                }
            }

            $this->fpdf->SetTextColor('0', '0', '0');

            $this->fpdf->Ln(-8 * $val);
            foreach ($Note2[$data->student->id] as $note2) {



                if ($note2->valeur >= 0 && $note2->valeur < 10) {
                    $note2->mention = "NA";
                }

                if ($note2->valeur >= 10 && $note2->valeur < 15) {
                    $note2->mention = "ECA";
                }

                if ($note2->valeur >= 15) {
                    $note2->mention = "Acquis";
                }



                if ($note2->valeur < $couleurRouge) {

                    $this->fpdf->SetTextColor('237', '28', '36');
                } else {

                    $this->fpdf->SetTextColor('0', '0', '0');
                }


                $this->fpdf->SetFont('Arial', 'B', 7);

                $this->fpdf->SetX(120);


                if ($note2->status == 1) {
                    $this->fpdf->MultiCell(11, 8, "-", 1, 'C');
                } else {

                    $this->fpdf->MultiCell(11, 8, utf8_decode($note2->mention), 1, 'C');
                }
            }

            $this->fpdf->SetTextColor('0', '0', '0');


            $this->fpdf->Ln(-8 * $val);
            foreach ($Note2[$data->student->id] as $note) {


                $all  = Notes::where('matiere_id', $note->matiere->id)
                    ->where('evaluation_id', $IdEvaluation)
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
                            $labelRang
                                = utf8_decode("è");
                        }
                    }
                }


                $this->fpdf->SetX(110);
                $this->fpdf->SetFont('Arial', 'B',  7);

                if ($note->status == 1) {

                    $this->fpdf->MultiCell(10, 8, "-", 1, 'C');
                } else {

                    $this->fpdf->MultiCell(10, 8, $rank + 1 . $labelRang, 1, 'C');
                }
            }




            $this->fpdf->Ln(-8 * $val);
            foreach ($Note2[$data->student->id] as $note2) {

                $max = Notes::where('evaluation_id', $IdEvaluation)->where('classe_id', $IdClasse)
                    ->where('matiere_id', $note2->matiere->id)->max('valeur');

                $this->fpdf->SetX(131);
                $this->fpdf->MultiCell(10, 8, $max, 1, 'C');
            }


            $this->fpdf->Ln(-8 * $val);
            foreach ($Note2[$data->student->id] as $note2) {

                $min = Notes::where('evaluation_id', $IdEvaluation)->where('classe_id', $IdClasse)
                    ->where('matiere_id', $note2->matiere->id)->min('valeur');

                $this->fpdf->SetX(141);
                $this->fpdf->MultiCell(
                    10,
                    8,
                    $min,
                    1,
                    'C'
                );
            }


            $this->fpdf->Ln(-8 * $val);
            foreach ($Note2[$data->student->id] as $note2) {


                $this->fpdf->SetFont('Arial', 'B', $tailleLIbelleMatiere - 1);
                $this->fpdf->SetX(151);
                $this->fpdf->MultiCell(53, 8, utf8_decode($note2->user->nom) . ' ' . utf8_decode($note2->user->prenom) . ' ', 1, 'L');
            }

            $this->fpdf->SetX(10);

            $this->fpdf->SetFont('Arial', 'B', 6);
            $this->fpdf->Cell(70, 6, utf8_decode('Enseignement Professionnel'), 1, 0, 'C', 1);
            $this->fpdf->Cell(10, 6,  $moyenne2[$data->student->id], 1, 0, 'C', 1);
            $this->fpdf->Cell(10, 6, $sommeCoef2, 1, 0, 'C', 1);
            $this->fpdf->Cell(10, 6, $sommeNoteCoef2, 1, 0, 'C', 1);
            $this->fpdf->Cell(94, 6, '', 1, 0, 'C', 1);




            $this->fpdf->SetX(10);


            $this->fpdf->SetFont('Arial', 'B', 8);



            $Note3[$data->student->id] = Notes::with('matiere', 'student', 'evaluation', 'user')
                ->where('evaluation_id', $IdEvaluation)
                ->where('classe_id', $IdClasse)
                ->where('cat_id', 3)
                ->where('student_id', $data->student->id)
                ->where('codeEtab', $codeEtab)
                ->where('session', $session)->orderBy('matiere_id', 'ASC')->get();

            // Moyenne du groupe 3


            foreach ($Note3[$data->student->id] as $data3) {



                if ($data3->status == null) {

                    $sommeNoteCoef3 = $sommeNoteCoef3 + ($data3->valeur * $data3->matiere->coef);

                    $sommeCoef3 = $sommeCoef3 + $data3->matiere->coef;
                }
            }

            if ($sommeCoef3 == 0) {
                $moyenne3[$data->student->id] = 0;
            } else {

                $moyenne3[$data->student->id] =  number_format($sommeNoteCoef3 / $sommeCoef3, 2);
            }


            $this->fpdf->Ln();


            foreach ($Note3[$data->student->id] as $note3) {


                $this->fpdf->SetX(10);

                $this->fpdf->SetFont('Arial', 'B', $tailleLIbelleMatiere);

                $this->fpdf->MultiCell(70, 8, utf8_decode($note3->matiere->libelle), 1, 'L');
            }

            $this->fpdf->SetTextColor('0', '0', '0');


            $this->fpdf->Ln(-8 * $val3);

            foreach ($Note3[$data->student->id] as $note3) {

                if ($note3->valeur < $couleurRouge) {

                    $this->fpdf->SetTextColor('237', '28', '36');
                } else {

                    $this->fpdf->SetTextColor('0', '0', '0');
                }
                $this->fpdf->SetX(80);

                if ($note3->status == 1) {

                    $this->fpdf->MultiCell(10, 8, "-", 1, 'C');
                } else {

                    $this->fpdf->MultiCell(10, 8, $note3->valeur, 1, 'C');
                }
            }

            $this->fpdf->SetTextColor('0', '0', '0');


            $this->fpdf->Ln(-8 * $val3);
            foreach ($Note3[$data->student->id] as $note3) {

                $this->fpdf->SetX(90);
                $this->fpdf->SetTextColor('0', '0', '0');
                $this->fpdf->MultiCell(10, 8, $note3->matiere->coef, 1, 'C');
            }


            $this->fpdf->SetTextColor('0', '0', '0');


            $this->fpdf->Ln(-8 * $val3);
            foreach ($Note3[$data->student->id] as $note3) {

                if ($note3->valeur < $couleurRouge) {

                    $this->fpdf->SetTextColor('237', '28', '36');
                } else {

                    $this->fpdf->SetTextColor('0', '0', '0');
                }

                $this->fpdf->SetX(100);

                if ($note3->status == 1) {

                    $this->fpdf->MultiCell(10, 8, "-", 1, 'C');
                } else {

                    $this->fpdf->MultiCell(10, 8, $note3->valeur * $note3->matiere->coef, 1, 'C');
                }
            }

            $this->fpdf->SetTextColor('0', '0', '0');


            $this->fpdf->Ln(-8 * $val3);
            foreach ($Note3[$data->student->id] as $note3) {



                if ($note3->valeur >= 0 && $note3->valeur < 10) {
                    $note3->mention = "NA";
                }

                if ($note3->valeur >= 10 && $note3->valeur < 15) {
                    $note3->mention = "ECA";
                }

                if ($note3->valeur >= 15) {
                    $note3->mention = "Acquis";
                }

                if ($note3->valeur < $couleurRouge) {

                    $this->fpdf->SetTextColor('237', '28', '36');
                } else {

                    $this->fpdf->SetTextColor('0', '0', '0');
                }

                $this->fpdf->SetFont('Arial', 'B', 7);
                $this->fpdf->SetX(120);

                if ($note3->status == 1) {

                    $this->fpdf->MultiCell(11, 8, "-", 1, 'C');
                } else {

                    $this->fpdf->MultiCell(11, 8, utf8_decode($note3->mention), 1, 'C');
                }
            }


            $this->fpdf->SetTextColor('0', '0', '0');


            $this->fpdf->Ln(-8 * $val3);
            foreach ($Note3[$data->student->id] as $note) {


                $all  = Notes::where('matiere_id', $note->matiere->id)
                    ->where('evaluation_id', $IdEvaluation)
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
                            $labelRang = utf8_decode('è');
                        }
                    }
                }
                $this->fpdf->SetFont('Arial', 'B',  7);
                $this->fpdf->SetX(110);

                if ($note->status == 1) {

                    $this->fpdf->MultiCell(10, 8, "-", 1, 'C');
                } else {

                    $this->fpdf->MultiCell(10, 8, $rank + 1 . $labelRang, 1, 'C');
                }
            }


            $this->fpdf->Ln(-8 * $val3);
            foreach ($Note3[$data->student->id] as $note3) {

                $max = Notes::where('evaluation_id', $IdEvaluation)->where('classe_id', $IdClasse)
                    ->where('matiere_id', $note3->matiere->id)->max('valeur');

                $this->fpdf->SetX(131);
                $this->fpdf->MultiCell(
                    10,
                    8,
                    $max,
                    1,
                    'C'
                );
            }




            $this->fpdf->Ln(-8 * $val3);
            foreach ($Note3[$data->student->id] as $note3) {

                $min = Notes::where('evaluation_id', $IdEvaluation)->where('classe_id', $IdClasse)
                    ->where('matiere_id', $note3->matiere->id)->min('valeur');

                $this->fpdf->SetX(141);
                $this->fpdf->MultiCell(
                    10,
                    8,
                    $max,
                    1,
                    'C'
                );
            }

            $this->fpdf->Ln(-8 * $val3);

            foreach ($Note3[$data->student->id] as $note3) {

                $this->fpdf->SetFont('Arial', 'B', $tailleLIbelleMatiere - 1);
                $this->fpdf->SetX(151);
                $this->fpdf->MultiCell(53, 8, utf8_decode($note3->user->nom . ' ' . $note3->user->prenom) . ' ', 1, 'L');
            }





            $this->fpdf->SetX(10);
            $this->fpdf->SetFont('Arial', 'B', 6);
            $this->fpdf->Cell(70, 6, utf8_decode('Enseignement Complémentaire'), 1, 0, 'C', 1);
            $this->fpdf->Cell(10, 6,  $moyenne3[$data->student->id], 1, 0, 'C', 1);
            $this->fpdf->Cell(10, 6, $sommeCoef3, 1, 0, 'C', 1);
            $this->fpdf->Cell(10, 6, $sommeNoteCoef3, 1, 0, 'C', 1);
            $this->fpdf->Cell(94, 6, '', 1, 0, 'C', 1);



            $this->fpdf->SetX(20);
            $this->fpdf->Ln(15);


            $this->fpdf->SetX(10);
            $this->fpdf->SetFont('Arial', 'B', 6);
            $this->fpdf->Cell(50, 5, utf8_decode('TRAVAIL DE LA CLASSE'), 1, 0, 'C', 1);
            $this->fpdf->Cell(40, 5,  utf8_decode(strtoupper($Note[$data->student->id][0]->evaluation->libelle)), 1, 0, 'C', 1);
            $this->fpdf->Cell(53, 5, utf8_decode('DISCIPLINE'), 1, 0, 'C', 1);
            $this->fpdf->Cell(50, 5, utf8_decode('TRAVAIL'), 1, 0, 'C', 1);



            $this->fpdf->Ln();
            $this->fpdf->SetX(10);
            $this->fpdf->Cell(35, 5, utf8_decode('MOYENNE CLASSE / 20 '), 1, 0, 'L', 0);
            $this->fpdf->Cell(15, 5,  number_format($moyenneSommeClasse / ($nombreEleves), 2), 1, 0, 'C', 0);
            $this->fpdf->SetX(60);
            $this->fpdf->Cell(25, 5, utf8_decode('TOTAL POINTS'), 1, 0, 'L', 0);
            $this->fpdf->Cell(15, 5,  $sommeNoteCoef1 + $sommeNoteCoef2 + $sommeNoteCoef3, 1, 0, 'C', 0);
            $this->fpdf->SetX(100);
            $this->fpdf->Cell(42, 5, utf8_decode('ABSENCES (H)'), 1, 0, 'L', 0);
            $this->fpdf->Cell(11, 5, $heureTrimestreNonJustifies, 1, 0, 'C', 0);  //$heureTrimestre
            $this->fpdf->Cell(30, 5, utf8_decode('FELICITATIONS'), 1, 0, 'L', 0);
            $this->fpdf->Cell(20, 5, '', 1, 0, 'C', 0);


            $this->fpdf->Ln();
            $this->fpdf->SetX(10);
            $this->fpdf->Cell(35, 5, utf8_decode('MOYENNE PREMIER / 20'), 1, 0, 'L', 0);
            $this->fpdf->Cell(15, 5, $MoyPremier, 1, 0, 'C', 0);
            $this->fpdf->Cell(25, 5, utf8_decode('TOTAL COEFS'), 1, 0, 'L', 0);
            $this->fpdf->Cell(15, 5, $sommeCoef1 + $sommeCoef2 + $sommeCoef3, 1, 0, 'C', 0);
            $this->fpdf->Cell(42, 5, utf8_decode('CONSIGNES (H)'), 1, 0, 'L', 1);
            $this->fpdf->Cell(11, 5, '', 1, 0, 'C', 0); // $heureConsigneTrimestre
            $this->fpdf->Cell(30, 5, utf8_decode('ENCOURAGEMENTS'), 1, 0, 'L', 1);
            $this->fpdf->Cell(20, 5, '', 1, 0, 'C', 0);




            $this->fpdf->Ln();
            $this->fpdf->SetX(10);
            $this->fpdf->Cell(35, 5, utf8_decode('MOYENNE DERNIER / 20'), 1, 0, 'L', 0);
            $this->fpdf->Cell(15, 5, $MoyDernier, 1, 0, 'C', 0);
            $this->fpdf->Cell(25, 5, utf8_decode('MOYENNE / 20 '), 1, 0, 'L', 1);
            $this->fpdf->Cell(15, 5, $data->valeur, 1, 0, 'C', 0);
            $this->fpdf->Cell(42, 5, utf8_decode('AVERTISSEMENT CONDUITE'), 1, 0, 'L', 0);
            $this->fpdf->Cell(11, 5, '', 1, 0, 'C', 0);
            $this->fpdf->Cell(30, 5, utf8_decode('TABLEAU D\'HONNEUR'), 1, 0, 'L', 0);
            $this->fpdf->Cell(20, 5, '', 1, 0, 'C', 1);




            $this->fpdf->Ln();
            $this->fpdf->Cell(35, 5, utf8_decode(' TAUX DE REUISSITE'), 1, 0, 'L', 1);


            $this->fpdf->Cell(15, 5, number_format($NombreAdmis / ($nombreEleves), 2) * 100 . " " . "%", 1, 0, 'C', 0);
            $this->fpdf->SetX(60);
            $this->fpdf->Cell(25, 5, utf8_decode('RANG'), 1, 0, 'L', 0);

            if ($data->valeur == 0) {

                $this->fpdf->Cell(15, 5, utf8_decode('Non classé'), 1, 0, 'C', 1);
            } else {

                $this->fpdf->Cell(15, 5, ($key + 1) . '' . $e, 1, 0, 'C', 1);
            }
            // $this->fpdf->Cell(15, 5, ($key + 1) . '' . $e. ' / ' . count($classeData) , 1, 0, 'C',1);
            $this->fpdf->Cell(42, 5, utf8_decode('EXCLUSIONS ( jrs )'), 1, 0, 'L', 0);
            $this->fpdf->Cell(11, 5, '', 1, 0, 'C', 0); // $ExclusionTrimestre
            $this->fpdf->Cell(30, 5, utf8_decode('AVERTISSEMENT TRAVAIL'), 1, 0, 'L', 0);
            $this->fpdf->Cell(20, 5, '', 1, 0, 'C', 0);

            $this->fpdf->Ln();
            $this->fpdf->SetX(100);

            $this->fpdf->Cell(42, 5, utf8_decode('BLAME CONDUITE'), 1, 0, 'L', 0);
            $this->fpdf->Cell(11, 5, '', 1, 0, 'C', 0);
            $this->fpdf->Cell(30, 5, utf8_decode('BLAME TRAVAIL'), 1, 0, 'L', 0);
            $this->fpdf->Cell(20, 5, '', 1, 0, 'C', 0);



            $this->fpdf->SetX(10);
            $this->fpdf->Ln();

            $this->fpdf->Cell(50, 5, utf8_decode('VISA DU PARENT'), 1, 0, 'C', 1);
            $this->fpdf->Cell(93, 5, utf8_decode('OBSERVATION DU CONSEIL DE CLASSE'), 1, 0, 'C', 1);
            $this->fpdf->Cell(50, 5, 'VISA DU CHEF D\'ETABLISSEMENT', 1, 0, 'C', 1);


            $this->fpdf->SetX(10);
            $this->fpdf->Cell(50, 20, '', 0, 0, 'L', 0);
            $this->fpdf->Cell(93, 20, utf8_decode(''), 0, 0, 'L', 0);
            $this->fpdf->Cell(50, 20, '        Manengole le ________________________', 0, 0, 'L', 0);

            $this->fpdf->SetX(10);
            $this->fpdf->Cell(50, 35, '', 1, 0, 'L', 0);
            $this->fpdf->Cell(93, 35, utf8_decode(''), 1, 0, 'L', 0);
            $this->fpdf->Cell(50, 35, '    ', 1, 0, 'L', 0);
            $sommeNoteCoef1 = $sommeNoteCoef2 = $sommeNoteCoef3 = 0;

            $sommeCoef1 = $sommeCoef2 = $sommeCoef3 = 0;
        }



        $this->fpdf->Output();
        exit;
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
            ->where('session', $session)->where('codeEtab', $codeEtab)->get();



        $moyData =   MoyenneTrimestres::with('student')->where('session', $session)
            ->where('codeEtab', $codeEtab)->where('trimestre_id',  $IdTrimmestre)->where('classe_id', $IdClasse)->where('valeur', '>=', 0)
            ->orderBy('valeur', 'DESC')->get();



        // Nombre deleves  dans cette classe


        $effectif = Student::where('classe_id', $IdClasse)->where('session', $session)
            ->where('codeEtab', $codeEtab)->count();

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

                $e = 'eme';
            }


            $this->fpdf->AddPage("P", ['350', '210']); // 315


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
                ->where('mois_id', $IdTrimmestre)->where('student_id', $data->student->id)
                ->where('codeEtab', $codeEtab)
                ->where('session', $session)->sum('duree');


            // Absences non justifies

            $heureTrimestreNonJustifies = Presences::where('classe_id', $IdClasse)
                ->where('mois_id', $IdTrimmestre)->where('student_id', $data->student->id)
                ->where('codeEtab', $codeEtab)->where('etat', 0)
                ->where('session', $session)->sum('duree');


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


            $this->fpdf->Image(public_path("/Photos/Logos/" . $entete), 5, 6, 200, 35, "");




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
            $this->fpdf->Text(137, 72, $data->student->sexe);
            $this->fpdf->SetFont('Arial', 'B', 7);

            $this->fpdf->Text(105, 76, 'Redoublant  : ');
            $this->fpdf->SetFont('Arial', 'B', 7);
            if ($data->student->doublant == "REDOUBLANT") {
                $this->fpdf->Text(
                    137,
                    76,
                    "Oui"
                );
            } else {

                $this->fpdf->Text(
                    137,
                    76,
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


            $this->fpdf->Text(37, 71, 'Prof principal  :');
            $this->fpdf->SetFont('Arial', 'B', 6);
            $this->fpdf->Text(59, 71, utf8_decode($teach->nom . ' ' . $teach->prenom));


            if (file_exists(public_path("/Photos/Logos/" . $EleveData[$data->student->id][0]->user->photo))) {


                $this->fpdf->Image(public_path("/Photos/Logos/" . $EleveData[$data->student->id][0]->user->photo), 10, 52, 25, 27,  "");
            }






            //     // // Cadre information eleve



            $this->fpdf->SetXY(10, 52);
            $this->fpdf->Cell(25, 27, '', 1);

            $this->fpdf->SetXY(35, 52);
            $this->fpdf->Cell(23, 27, '', 1);


            $this->fpdf->SetXY(58, 52);
            $this->fpdf->Cell(45, 27, '', 1);


            $this->fpdf->SetXY(103, 52);
            $this->fpdf->Cell(33, 27, '', 1);


            $this->fpdf->SetXY(136, 52);
            $this->fpdf->Cell(67, 27, '', 1);




            // Cadre pour le titre du trimestre

            $this->fpdf->SetFillColor('130', '130', '130');
            $this->fpdf->SetFont('Arial', 'B', 10);
            $this->fpdf->SetXY(71, 41);
            $this->fpdf->Cell(70, 8, 'BULLETIN DE NOTES ' . '' . strtoupper($libelleTrimestre), 1, 0, 'C', 1);






            // $this->fpdf->SetXY(50,39);
            // $this->fpdf->Cell(100,10,'',1);

            $this->fpdf->SetFont('Arial', 'B', $tailleNote + 1);
            $this->fpdf->SetTextColor(0, 0, 0);
            // Tire cadre a cote
            // $this->fpdf->Text(135, 72, strtoupper($classeName->libelleEtab));

            $this->fpdf->SetXY(3, 85);
            // $this->fpdf->SetFont('Arial', 'B', 7);
            $this->fpdf->SetDrawColor(0, 0, 0);
            $this->fpdf->SetFillColor('166', '166', '166');
            $this->fpdf->Cell(60, 7, utf8_decode('Matières'), 1, 0, 'C', 1);
            $this->fpdf->Cell(10, 7, "DEV " . ($idEval1 - 1), 1, 0, 'C', 1);
            $this->fpdf->Cell(10, 7, "DEV " . ($idEval2 - 1), 1, 0, 'C', 1);
            $this->fpdf->SetFont('Arial', 'B', $tailleNote);


            $this->fpdf->Cell(40, 4, '                   ' . strtoupper($libelleTrimestre), 1, 0, 'L', 1);

            $this->fpdf->SetFont('Arial', 'B', $tailleNote + 1);

            $this->fpdf->SetXY(83, 89);

            $this->fpdf->Cell(10, 3, 'Notes', 1, 0, 'C', 1);
            $this->fpdf->Cell(10, 3, 'Coef', 1, 0, 'C', 1);
            $this->fpdf->Cell(10, 3, 'N*C', 1, 0, 'C', 1);
            $this->fpdf->Cell(10, 3, 'Rang', 1, 0, 'C', 1);
            $this->fpdf->SetXY(123, 85);
            $this->fpdf->Cell(11, 7, 'Appre', 1, 0, 'C', 1);
            $this->fpdf->Cell(10, 7, 'Max', 1, 0, 'C', 1);
            $this->fpdf->Cell(10, 7, 'Min', 1, 0, 'C', 1);
            $this->fpdf->Cell(53, 7, 'Enseignant (e) et signature', 1, 0, 'C', 1);

            $this->fpdf->Ln();
            $this->fpdf->SetX(20);


            // Pour la note seq1


            foreach ($Note[$data->student->id] as $note) {

                $this->fpdf->SetX(3);
                $this->fpdf->SetFont('Arial', 'B', $tailleNote);
                $this->fpdf->MultiCell(60, 7, utf8_decode($note->matiere->libelle), 1, 'L');
            }



            $this->fpdf->SetY(92);


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


            $this->fpdf->SetFont('Arial', 'B', $tailleNote + 1);


            foreach ($Note[$data->student->id] as $note) {

                if ($note->valeur < $couleurRouge) {

                    $this->fpdf->SetTextColor('237', '28', '36');
                } else {

                    $this->fpdf->SetTextColor('0', '0', '0');
                }
                $this->fpdf->SetX(63);

                if ($MoyenneDevoir1[$data->student->id]->valeur == 0 || $note->status == 1) {


                    $this->fpdf->MultiCell(10, 7, '-', 1, 'C');
                } else {

                    $this->fpdf->MultiCell(10, 7, $note->valeur, 1, 'C');
                }
            }

            $this->fpdf->SetTextColor('0', '0', '0');



            // // // Note seq2

            $this->fpdf->SetY(92);

            foreach ($Note2[$data->student->id] as $note) {

                if ($note->valeur < $couleurRouge) {

                    $this->fpdf->SetTextColor('237', '28', '36');
                } else {

                    $this->fpdf->SetTextColor('0', '0', '0');
                }

                $this->fpdf->SetX(73);
                if ($MoyenneDevoir2[$data->student->id]->valeur == 0 || $note->status == 1) {

                    $this->fpdf->MultiCell(10, 7, '-', 1, 'C');
                } else {

                    $this->fpdf->MultiCell(10, 7, $note->valeur, 1, 'C');
                }
            }

            $this->fpdf->SetTextColor('0', '0', '0');

            // Note trimestre


            // // // ici je rcupere la note du trimstre

            $this->fpdf->SetY(92);
            foreach ($NoteTrimestre[$data->student->id] as $key => $note) {


                if ($note->valeur < $couleurRouge) {

                    $this->fpdf->SetTextColor('237', '28', '36');
                } else {

                    $this->fpdf->SetTextColor('0', '0', '0');
                }


                $this->fpdf->SetX(83);


                if ($note->status == 1) {

                    $this->fpdf->MultiCell(10, 7, '-', 1, 'C');
                } else {

                    $this->fpdf->MultiCell(10, 7, $note->valeur, 1, 'C');
                }
            }

            $this->fpdf->SetTextColor('0', '0', '0');


            // // // les coef

            $this->fpdf->SetY(92);
            foreach ($NoteTrimestre[$data->student->id] as $note) {
                $this->fpdf->SetX(93);


                if ($note->status == 1) {

                    $this->fpdf->MultiCell(10, 7, '-', 1, 'C');
                } else {

                    $this->fpdf->MultiCell(10, 7, $note->matiere->coef, 1, 'C');
                }
            }


            $this->fpdf->SetY(92);
            foreach ($NoteTrimestre[$data->student->id] as $note) {

                if ($note->valeur < $couleurRouge) {

                    $this->fpdf->SetTextColor('237', '28', '36');
                } else {

                    $this->fpdf->SetTextColor('0', '0', '0');
                }


                $this->fpdf->SetX(103);

                if ($note->status == 1) {

                    $this->fpdf->MultiCell(10, 7, '-', 1, 'C');
                } else {

                    $this->fpdf->MultiCell(10, 7, ($note->valeur) * $note->matiere->coef, 1, 'C');
                }
            }

            $this->fpdf->SetTextColor('0', '0', '0');

            $this->fpdf->SetY(92);


            // Rang des matieres

            foreach ($NoteTrimestre[$data->student->id] as $note) {


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


                $this->fpdf->SetX(113);

                if ($note->status == 1) {

                    $this->fpdf->MultiCell(10, 7, '-', 1, 'C');
                } else {
                    $this->fpdf->MultiCell(10, 7, $rank + 1 . $labelRang, 1, 'C');
                }
            }

            $this->fpdf->SetTextColor('0', '0', '0');

            $this->fpdf->SetTextColor('0', '0', '0');


            $this->fpdf->SetY(92);
            foreach ($Note[$data->student->id] as $note) {


                if ($note->valeur >= 0 && $note->valeur < 10) {
                    $note->mention = "NA";
                }

                if ($note->valeur >= 10 && $note->valeur < 15) {
                    $note->mention = "ECA";
                }

                if ($note->valeur >= 15) {
                    $note->mention = "Acquis";
                }


                if ($note->valeur < $couleurRouge) {

                    $this->fpdf->SetTextColor('237', '28', '36');
                } else {

                    $this->fpdf->SetTextColor('0', '0', '0');
                }


                $this->fpdf->SetX(123);


                if ($note->status == 1) {

                    $this->fpdf->MultiCell(11, 7, '-', 1, 'C');
                } else {

                    $this->fpdf->MultiCell(11, 7, utf8_decode($note->mention), 1, 'C');
                }
            }

            $this->fpdf->SetTextColor('0', '0', '0');


            $this->fpdf->SetY(92);
            foreach ($Note[$data->student->id] as $note) {

                $max = NotesTrimestres::where('trimestre_id', $IdTrimmestre)->where('classe_id', $IdClasse)
                    ->where('matiere_id', $note->matiere->id)->where('status', null)->max('valeur');

                $this->fpdf->SetX(134);
                $this->fpdf->MultiCell(10, 7, $max, 1, 'C');
            }


            $this->fpdf->SetY(92);

            foreach ($Note[$data->student->id] as $note) {

                $min = NotesTrimestres::where('trimestre_id', $IdTrimmestre)->where('classe_id', $IdClasse)
                    ->where('matiere_id', $note->matiere->id)->where('status', null)->min('valeur');

                $this->fpdf->SetX(144);
                $this->fpdf->MultiCell(10, 7, $min, 1, 'C');
            }
            // je cherche les infos sur le proef


            $this->fpdf->SetTextColor('0', '0', '0');

            $this->fpdf->SetY(92);
            foreach ($Note[$data->student->id] as $note) {

                $this->fpdf->SetFont('Arial', 'B', $tailleNote);

                $this->fpdf->SetX(154);
                $this->fpdf->MultiCell(53, 7, utf8_decode($note->user->nom . ' ' . $note->user->prenom), 1, 'L');
            }


            // Moy trimestre  du groupe 1

            $sommeNoteCoef1 = $sommeCoef1 = 0;

            foreach ($NoteTrimestre[$data->student->id] as $data2) {


                if ($data2->status == null) {

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
            $this->fpdf->SetFont('Arial', 'B', $tailleNote - 1);
            $this->fpdf->Cell(60, 6, utf8_decode('Enseignement Général'), 1, 0, 'C', 1);
            $this->fpdf->Cell(10, 6,  $moyenneD1Cat1[$data->student->id], 1, 0, 'C', 1);
            $this->fpdf->Cell(10, 6, $moyenneD2Cat1[$data->student->id], 1, 0, 'C', 1);
            $this->fpdf->Cell(10, 6,  $moyenne1[$data->student->id], 1, 0, 'C', 1);
            $this->fpdf->Cell(10, 6, $sommeCoef1, 1, 0, 'C', 1);
            $this->fpdf->Cell(10, 6, $sommeNoteCoef1, 1, 0, 'C', 1);
            $this->fpdf->Cell(94, 6, '', 1, 0, 'C', 1);


            $this->fpdf->Ln();


            foreach ($Notecat2[$data->student->id] as $note) {

                $this->fpdf->SetX(3);
                $this->fpdf->SetFont('Arial', 'B', $tailleNote);
                $this->fpdf->MultiCell(60, 7, utf8_decode($note->matiere->libelle), 1, 'L');
            }


            $this->fpdf->Ln(-7 * $val3);

            $this->fpdf->SetFont('Arial', 'B', 7);

            // Les note de la sequence 1 cat 2
            foreach ($Notecat2[$data->student->id] as $note) {

                if ($note->valeur < $couleurRouge) {

                    $this->fpdf->SetTextColor('237', '28', '36');
                } else {

                    $this->fpdf->SetTextColor('0', '0', '0');
                }


                $this->fpdf->SetX(63);
                if ($MoyenneDevoir1[$data->student->id]->valeur == 0 || $note->status == 1) {

                    $this->fpdf->MultiCell(10, 7, '-', 1, 'C');
                } else {

                    $this->fpdf->MultiCell(10, 7, $note->valeur, 1, 'C');
                }
            }

            $this->fpdf->SetTextColor('0', '0', '0');


            $this->fpdf->Ln(-7 * $val3);

            // Les notes de la sequence 2 cat 2
            foreach ($Note2cat2[$data->student->id] as $note) {

                if ($note->valeur < $couleurRouge) {

                    $this->fpdf->SetTextColor('237', '28', '36');
                } else {

                    $this->fpdf->SetTextColor('0', '0', '0');
                }

                $this->fpdf->SetX(73);
                if ($MoyenneDevoir2[$data->student->id]->valeur == 0 || $note->status == 1) {

                    $this->fpdf->MultiCell(10, 7, '-', 1, 'C');
                } else {

                    $this->fpdf->MultiCell(10, 7, $note->valeur, 1, 'C');
                }
            }

            $this->fpdf->SetTextColor('0', '0', '0');



            $this->fpdf->Ln(-7 * $val3);

            foreach ($NoteTrimestrecat2[$data->student->id] as $note) {

                if ($note->valeur < $couleurRouge) {

                    $this->fpdf->SetTextColor('237', '28', '36');
                } else {

                    $this->fpdf->SetTextColor('0', '0', '0');
                }

                $this->fpdf->SetX(83);


                if ($note->status == 1) {

                    $this->fpdf->MultiCell(10, 7, '-', 1, 'C');
                } else {

                    $this->fpdf->MultiCell(10, 7, $note->valeur, 1, 'C');
                }
            }

            $this->fpdf->SetTextColor('0', '0', '0');


            $this->fpdf->Ln(-7 * $val3);

            foreach ($Note2cat2[$data->student->id] as $note) {

                $this->fpdf->SetX(93);

                if ($note->status == 1) {

                    $this->fpdf->MultiCell(10, 7, '-', 1, 'C');
                } else {

                    $this->fpdf->MultiCell(10, 7, $note->matiere->coef, 1, 'C');
                }
            }

            $this->fpdf->Ln(-7 * $val3);


            foreach ($NoteTrimestrecat2[$data->student->id] as $note) {

                if ($note->valeur < $couleurRouge) {

                    $this->fpdf->SetTextColor('237', '28', '36');
                } else {

                    $this->fpdf->SetTextColor('0', '0', '0');
                }


                $this->fpdf->SetX(103);
                if ($note->status == 1) {

                    $this->fpdf->MultiCell(10, 7, '-', 1, 'C');
                } else {

                    $this->fpdf->MultiCell(10, 7, ($note->valeur) * $note->matiere->coef, 1, 'C');
                }
            }

            $this->fpdf->Ln(-7 * $val3);

            $this->fpdf->SetTextColor('0', '0', '0');

            foreach ($NoteTrimestre2[$data->student->id] as $note) {


                $all  = NotesTrimestres::where('matiere_id', $note->matiere->id)
                    ->where('trimestre_id', $IdTrimmestre)
                    ->where('classe_id', $IdClasse)
                    ->where('codeEtab', $codeEtab)
                    ->where('session', $session)
                    ->orderBy('valeur', 'desc')->get();

                foreach ($all as $ket => $test) {

                    if ($test->id == $note->id) {
                        $rank = $ket;
                    }

                    if ($rank + 1 == 1) {
                        $labelRang = 'er';
                    } else {
                        $labelRang = utf8_decode("è");
                    }
                }


                $this->fpdf->SetX(113);
                if ($note->status == 1) {

                    $this->fpdf->MultiCell(10, 7, '-', 1, 'C');
                } else {
                    $this->fpdf->MultiCell(10, 7, $rank + 1 . $labelRang, 1, 'C');
                }
            }

            $this->fpdf->SetTextColor('0', '0', '0');



            $this->fpdf->Ln(-7 * $val3);

            foreach ($NoteTrimestre2[$data->student->id] as $note2) {


                if ($note2->valeur >= 0 && $note2->valeur < 10) {
                    $note2->mention = "NA";
                }

                if ($note2->valeur >= 10 && $note2->valeur < 15) {
                    $note2->mention = "ECA";
                }

                if ($note2->valeur >= 15) {
                    $note2->mention = "Acquis";
                }


                if ($note2->valeur < $couleurRouge) {

                    $this->fpdf->SetTextColor('237', '28', '36');
                } else {

                    $this->fpdf->SetTextColor('0', '0', '0');
                }




                $this->fpdf->SetFont('Arial', 'B', 7);


                $this->fpdf->SetX(123);

                if ($note2->status == 1) {

                    $this->fpdf->MultiCell(11, 7, '-', 1, 'C');
                } else {

                    $this->fpdf->MultiCell(11, 7, utf8_decode($note2->mention), 1, 'C');
                }
            }

            $this->fpdf->SetTextColor('0', '0', '0');

            $this->fpdf->Ln(-7 * $val3);

            foreach ($NoteTrimestre2[$data->student->id] as $note2) {

                $max = NotesTrimestres::where('trimestre_id', $IdTrimmestre)->where('classe_id', $IdClasse)
                    ->where('matiere_id', $note2->matiere->id)->where('status', null)->max('valeur');

                $this->fpdf->SetX(134);
                $this->fpdf->MultiCell(10, 7, $max, 1, 'C');
            }


            $this->fpdf->Ln(-7 * $val3);

            foreach ($NoteTrimestre2[$data->student->id] as $note2) {

                $min = NotesTrimestres::where('trimestre_id', $IdTrimmestre)->where('classe_id', $IdClasse)
                    ->where('matiere_id', $note2->matiere->id)->where('status', null)->min('valeur');

                $this->fpdf->SetX(144);
                $this->fpdf->MultiCell(10, 7, $min, 1, 'C');
            }

            $this->fpdf->Ln(-7 * $val3);
            foreach ($NoteTrimestre2[$data->student->id] as $note2) {
                $this->fpdf->SetFont('Arial', 'B', $tailleNote);
                $this->fpdf->SetX(154);
                $this->fpdf->MultiCell(53, 7, utf8_decode($note2->user->nom . ' ' . $note2->user->prenom), 1, 'L');
            }

            $this->fpdf->SetX(3);

            // Moy trimestre  du groupe 2

            $sommeNoteCoef2 = $sommeCoef2 = 0;

            foreach ($NoteTrimestre2[$data->student->id] as $data2) {


                if ($data2->status == null) {

                    $sommeNoteCoef2 = $sommeNoteCoef2 + ($data2->valeur * $data2->matiere->coef);

                    $sommeCoef2 = $sommeCoef2 + $data2->matiere->coef;
                }
            }

            if ($sommeCoef2 == 0) {

                $moyenne1[$data->student->id] =  '-';
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




            $this->fpdf->SetFont('Arial', 'B', 6);
            $this->fpdf->Cell(60, 6, utf8_decode('Enseignement Professionnel'), 1, 0, 'C', 1);
            $this->fpdf->Cell(10, 6, $moyenneD1Cat2[$data->student->id], 1, 0, 'C', 1);
            $this->fpdf->Cell(10, 6, $moyenneD2Cat2[$data->student->id], 1, 0, 'C', 1);
            $this->fpdf->Cell(10, 6,  $moyenne2[$data->student->id], 1, 0, 'C', 1);
            $this->fpdf->Cell(10, 6,  $sommeCoef2, 1, 0, 'C', 1);
            $this->fpdf->Cell(10, 6, $sommeNoteCoef2, 1, 0, 'C', 1);
            $this->fpdf->Cell(94, 6, '', 1, 0, 'C', 1);

            $this->fpdf->Ln();



            foreach ($Notecat3[$data->student->id] as $note) {

                $this->fpdf->SetX(3);
                $this->fpdf->SetFont('Arial', 'B', $tailleNote);
                $this->fpdf->MultiCell(60, 7, utf8_decode($note->matiere->libelle), 1, 'L');
            }

            $this->fpdf->SetFont('Arial', 'B', $tailleNote + 1);


            $this->fpdf->Ln(-$val4 * 7);

            foreach ($Notecat3[$data->student->id] as $note) {

                if ($note->valeur < $couleurRouge) {

                    $this->fpdf->SetTextColor('237', '28', '36');
                } else {

                    $this->fpdf->SetTextColor('0', '0', '0');
                }

                $this->fpdf->SetX(63);
                if ($MoyenneDevoir1[$data->student->id]->valeur == 0 || $note->status == 1) {


                    $this->fpdf->MultiCell(10, 7, '-', 1, 'C');
                } else {

                    $this->fpdf->MultiCell(10, 7, $note->valeur, 1, 'C');
                }
            }

            $this->fpdf->SetTextColor('0', '0', '0');



            $this->fpdf->Ln(-$val4 * 7);

            foreach ($Note2cat3[$data->student->id] as $note) {

                if ($note->valeur < $couleurRouge) {

                    $this->fpdf->SetTextColor('237', '28', '36');
                } else {

                    $this->fpdf->SetTextColor('0', '0', '0');
                }

                $this->fpdf->SetX(73);
                if ($MoyenneDevoir2[$data->student->id]->valeur == 0 || $note->status == 1) {

                    $this->fpdf->MultiCell(10, 7, '-', 1, 'C');
                } else {

                    $this->fpdf->MultiCell(10, 7, $note->valeur, 1, 'C');
                }
            }

            $this->fpdf->SetTextColor('0', '0', '0');


            $this->fpdf->Ln(-$val4 * 7);


            foreach ($NoteTrimestrecat3[$data->student->id] as $note3) {

                if ($note3->valeur < $couleurRouge) {

                    $this->fpdf->SetTextColor('237', '28', '36');
                } else {

                    $this->fpdf->SetTextColor('0', '0', '0');
                }

                $this->fpdf->SetX(83);

                if ($note3->status == 1) {

                    $this->fpdf->MultiCell(10, 7, "-", 1, 'C');
                } else {

                    $this->fpdf->MultiCell(10, 7, $note3->valeur, 1, 'C');
                }
            }


            $this->fpdf->SetTextColor('0', '0', '0');



            $this->fpdf->Ln(-$val4 * 7);
            foreach ($NoteTrimestrecat3[$data->student->id] as $note) {

                $this->fpdf->SetX(93);

                if ($note->status == 1) {

                    $this->fpdf->MultiCell(10, 7, "-", 1, 'C');
                } else {

                    $this->fpdf->MultiCell(10, 7, $note->matiere->coef, 1, 'C');
                }
            }

            $this->fpdf->Ln(-7 * $val4);
            foreach ($NoteTrimestrecat3[$data->student->id] as $note) {

                if ($note->valeur < $couleurRouge) {

                    $this->fpdf->SetTextColor('237', '28', '36');
                } else {

                    $this->fpdf->SetTextColor('0', '0', '0');
                }
                $this->fpdf->SetX(103);

                if ($note->status == 1) {
                    $this->fpdf->MultiCell(10, 7, "-", 1, 'C');
                } else {
                    $this->fpdf->MultiCell(10, 7, ($note->valeur) * $note->matiere->coef, 1, 'C');
                }
            }

            $this->fpdf->Ln(-7 * $val4);

            $this->fpdf->SetTextColor('0', '0', '0');


            foreach ($NoteTrimestre3[$data->student->id] as $note) {


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
                                utf8_decode("è");;
                        }
                    }
                }


                $this->fpdf->SetX(113);

                if ($note->status == 1) {

                    $this->fpdf->MultiCell(10, 7, "-", 1, 'C');
                } else {

                    $this->fpdf->MultiCell(10, 7, $rank + 1 . $labelRang, 1, 'C');
                }
            }

            $this->fpdf->Ln(-$val4 * 7);
            $this->fpdf->SetTextColor('0', '0', '0');

            foreach ($NoteTrimestrecat3[$data->student->id] as $note3) {

                if ($note3->valeur < $couleurRouge) {

                    $this->fpdf->SetTextColor('237', '28', '36');
                } else {

                    $this->fpdf->SetTextColor('0', '0', '0');
                }

                if ($note3->valeur >= 0 && $note3->valeur < 10) {
                    $note3->mention = "NA";
                }

                if ($note3->valeur >= 10 && $note3->valeur < 15) {
                    $note3->mention = "ECA";
                }

                if ($note3->valeur >= 15) {
                    $note3->mention = "Acquis";
                }


                $this->fpdf->SetX(123);

                $this->fpdf->SetTextColor('0', '0', '0');

                $this->fpdf->SetFont('Arial', 'B', 7);

                if ($note3->status == 1) {

                    $this->fpdf->MultiCell(11, 7, '-', 1, 'C');
                } else {

                    $this->fpdf->MultiCell(11, 7, utf8_decode($note3->mention), 1, 'C');
                }
            }

            // $this->fpdf->SetTextColor('0', '0', '0');

            // $this->fpdf->Ln(-$val4 * 7);


            // foreach ($NoteTrimestrecat3[$data->student->id] as $note) {
            //     $this->fpdf->SetFont('Arial', 'B', 7);
            //     $this->fpdf->SetX(150);
            //     $this->fpdf->MultiCell(53, 7, utf8_decode($note->user->nom . ' ' . $note->user->prenom), 1, 'L');
            // }



            // $this->fpdf->SetX(10);

            // // Moy trimestre  du groupe 3

            // foreach ($NoteTrimestre3[$data->student->id] as $data2) {


            //     $sommeNoteCoef3 = $sommeNoteCoef3 + ($data2->valeur * $data2->matiere->coef);

            //     $sommeCoef3 = $sommeCoef3 + $data2->matiere->coef;
            // }


            // $moyenne3[$data->student->id] =  number_format($sommeNoteCoef3 / $sommeCoef3, 2);




            // // Moyenne cat3 du devoir 1


            // $sommeNoteCoefD1cat3 = 0;

            // $sommeCoef3D1 = 0;


            // foreach ($Notecat3[$data->student->id] as $data1) {


            //     $sommeNoteCoefD1cat3 = $sommeNoteCoefD1cat3 + ($data1->valeur * $data1->matiere->coef);

            //     $sommeCoef3D1  =  $sommeCoef3D1  + $data1->matiere->coef;
            // }

            // $moyenneD1Cat3[$data->student->id] =  number_format($sommeNoteCoefD1cat3 / $sommeCoef3D1, 2);


            // // Moyenne cat3 du devoir 2


            // $sommeNoteCoefD2cat3 = 0;

            // $sommeCoef3D2 = 0;


            // foreach ($Note2cat3[$data->student->id] as $data1) {


            //     $sommeNoteCoefD2cat3 =  $sommeNoteCoefD2cat3 + ($data1->valeur * $data1->matiere->coef);

            //     $sommeCoef3D2  = $sommeCoef3D2  + $data1->matiere->coef;
            // }

            // $moyenneD2Cat3[$data->student->id] =  number_format($sommeNoteCoefD2cat3 / $sommeCoef3D2, 2);


            // $this->fpdf->SetFont('Arial', 'B', 6);
            // $this->fpdf->Cell(60, 6, utf8_decode('Enseignement Complémentaire '), 1, 0, 'C', 1);
            // $this->fpdf->Cell(10, 6,  $moyenneD1Cat3[$data->student->id], 1, 0, 'C', 1);
            // $this->fpdf->Cell(10, 6, $moyenneD2Cat3[$data->student->id], 1, 0, 'C', 1);
            // $this->fpdf->Cell(10, 6,  $moyenne3[$data->student->id], 1, 0, 'C', 1);
            // $this->fpdf->Cell(10, 6, $sommeCoef3, 1, 0, 'C', 1);
            // $this->fpdf->Cell(10, 6, $sommeNoteCoef3, 1, 0, 'C', 1);
            // $this->fpdf->Cell(83, 6, '', 1, 0, 'C', 1);


            // $this->fpdf->Ln(12);

            // $this->fpdf->SetX(10);
            // $this->fpdf->SetFont('Arial', 'B', 6);
            // $this->fpdf->Cell(40, 5, utf8_decode('RAPPEL'), 1, 0, 'C', 1);
            // $this->fpdf->Cell(35, 5, utf8_decode('TRAVAIL DE LA CLASSE'), 1, 0, 'C', 1);
            // $this->fpdf->Cell(35, 5, 'TRAVAIL' . utf8_decode(strtoupper($libelleTrimestre)), 1, 0, 'C', 1);
            // $this->fpdf->Cell(46, 5, utf8_decode('CONDUITE'), 1, 0, 'C', 1);
            // $this->fpdf->Cell(37, 5, utf8_decode('TRAVAIL'), 1, 0, 'C', 1);


            // // Moyenne et rang du devoir 1



            // // dd( $MoyenneDevoir1[$data->student->id]->student_id);

            // //  Ran du devoir 1

            // $moyDevoir1 = Moyennes::where('session', $session)->where('codeEtab', $codeEtab)
            //     ->where('evaluation_id', $idEval1)
            //     ->where('classe_id', $IdClasse)
            //     ->orderBy('valeur', 'DESC')->get();


            // // dd(  $moyDevoir1);


            // foreach ($moyDevoir1   as $key => $dataa) {


            //     if ($dataa->student_id == $MoyenneDevoir1[$data->student->id]->student_id) {

            //         $rankEval1[$dataa->student->id] = $key + 1;
            //     }
            // }



            // //  Ran du devoir 2


            // $moyDevoir2 = Moyennes::where('session', $session)->where('codeEtab', $codeEtab)
            //     ->where('evaluation_id', $idEval2)
            //     ->where('classe_id', $IdClasse)
            //     ->orderBy('valeur', 'DESC')->get();

            // foreach ($moyDevoir2   as $key => $dataa) {


            //     if ($dataa->student_id == $MoyenneDevoir1[$data->student->id]->student_id) {

            //         $rankEval2[$dataa->student->id] = $key + 1;
            //     }
            // }

            // $this->fpdf->Ln();
            // $this->fpdf->SetX(10);
            // $this->fpdf->Cell(25, 5, utf8_decode('MOY' . ' ' . $libelleEval1), 1, 0, 'L', 0);

            // $rankEval1[$data->student->id] = $rankEval1[$data->student->id];


            // // if ($MoyenneDevoir1[$data->student->id]->valeur == 0) {
            // //     $MoyenneDevoir1[$data->student->id]->valeur = '';
            // //     $rankEval1[$data->student->id] = '';
            // // } else {

            // $rankEval1[$data->student->id] = $rankEval1[$data->student->id];


            // // }


            // $this->fpdf->Cell(15, 5,  $MoyenneDevoir1[$data->student->id]->valeur . ' /20', 1, 0, 'C', 0);
            // $this->fpdf->Cell(25, 5, utf8_decode('MOY CLASSE / 20'), 1, 0, 'L', 0);
            // $this->fpdf->Cell(10, 5, number_format($moyenneSommeClasse / $nombreEleves, 2), 1, 0, 'C', 1);
            // $this->fpdf->SetX(85);
            // $this->fpdf->Cell(25, 5, utf8_decode('TOTAL POINTS'), 1, 0, 'L', 0);
            // $this->fpdf->Cell(10, 5,  $sommeNoteCoef1 + $sommeNoteCoef2 + $sommeNoteCoef3, 1, 0, 'C', 0);
            // $this->fpdf->SetX(120);
            // $this->fpdf->Cell(33, 5, utf8_decode('ABSENCES (h)'), 1, 0, 'L', 0);
            // $this->fpdf->Cell(13, 5, $heureTrimestreNonJustifies, 1, 0, 'C', 0); // $heureTrimestre
            // $this->fpdf->Cell(27, 5, utf8_decode('FELICITATIONS'), 1, 0, 'L', 1);
            // $this->fpdf->Cell(10, 5, '', 1, 0, 'C', 0);


            // // Rang Eval1

            // $moyenneEval1[$data->student->id] = Moyennes::where('evaluation_id', $idEval1);


            // $this->fpdf->Ln();
            // $this->fpdf->SetX(10);
            // $this->fpdf->Cell(25, 5, utf8_decode('Rang' . ' ' . $libelleEval1), 1, 0, 'L', 0);

            // if ($rankEval1[$data->student->id] == 1) {

            //     $label1 = 'er';
            // } else {
            //     $label1 = 'eme';
            // }
            // $this->fpdf->Cell(15, 5, $rankEval1[$data->student->id] . ' ' . $label1, 1, 0, 'C', 1);
            // $this->fpdf->Cell(25, 5, utf8_decode('MOY PREMIER / 20 '), 1, 0, 'L', 0);
            // $this->fpdf->Cell(10, 5, $MoyPremier, 1, 0, 'C', 0);
            // $this->fpdf->Cell(25, 5, utf8_decode('TOTAL COEFS'), 1, 0, 'L', 0);
            // $this->fpdf->Cell(10, 5, $sommeCoef1 + $sommeCoef2 + $sommeCoef3, 1, 0, 'C', 0);
            // $this->fpdf->Cell(33, 5, utf8_decode('CONSIGNE (h)'), 1, 0, 'L', 1);
            // $this->fpdf->Cell(13, 5, '', 1, 0, 'C', 0); // $heureConsigneTrimestre
            // $this->fpdf->Cell(27, 5, utf8_decode('ENCOURAGEMENTS'), 1, 0, 'L', 0);
            // $this->fpdf->Cell(10, 5, '', 1, 0, 'C', 0);


            // $this->fpdf->Ln();
            // $this->fpdf->SetX(10);




            // $this->fpdf->SetFont('Arial', 'B', 6);
            // $this->fpdf->Cell(25, 5, utf8_decode('MOY' . ' ' . $libelleEval2), 1, 0, 'L', 0);

            // $rankEval2[$data->student->id] = $rankEval2[$data->student->id];


            // // if ($MoyenneDevoir2[$data->student->id]->valeur == 0) {
            // //     $MoyenneDevoir2[$data->student->id]->valeur = '-';
            // //     $rankEval2[$data->student->id] = '-';
            // // } else {

            // //     $rankEval2[$data->student->id] = $rankEval2[$data->student->id];
            // // }
            // $this->fpdf->Cell(15, 5, $MoyenneDevoir2[$data->student->id]->valeur . ' /20', 1, 0, 'C', 0);
            // $this->fpdf->Cell(25, 5, utf8_decode('MOY Dernier / 20 '), 1, 0, 'L', 0);
            // $this->fpdf->Cell(10, 5, $MoyDernier, 1, 0, 'C', 0);
            // $this->fpdf->Cell(25, 5, 'MOYENNE / 20 ', 1, 0, 'C', 1);
            // $this->fpdf->Cell(10, 5, $data->valeur, 1, 0, 'C', 0);

            // $this->fpdf->Cell(33, 5, utf8_decode('AVERTISSEMENT CONDUITE'), 1, 0, 'L', 0);
            // $this->fpdf->Cell(13, 5, '', 1, 0, 'C', 0);
            // $this->fpdf->Cell(27, 5, utf8_decode("TABLEAU D'HONNEUR "), 1, 0, 'L', 0);
            // $this->fpdf->Cell(10, 5, '', 1, 0, 'C', 0);

            // $rankEval2[$data->student->id] = $rankEval2[$data->student->id];

            // // if ($MoyenneDevoir2[$data->student->id]->valeur == 0) {
            // //     $MoyenneDevoir2[$data->student->id]->valeur = '';
            // //     $rankEval2[$data->student->id] = '';
            // // } else {

            // //     $rankEval2[$data->student->id] = $rankEval2[$data->student->id];
            // // }
            // $this->fpdf->Ln();
            // $this->fpdf->SetX(10);
            // $this->fpdf->SetFont('Arial', 'B', 6);
            // $this->fpdf->Cell(25, 5, utf8_decode('Rang' . ' ' . $libelleEval2), 1, 0, 'L', 0);

            // if ($rankEval2[$data->student->id] == 1) {

            //     $label2 = 'er';
            // } else {
            //     $label2 = 'eme';
            // }


            // $this->fpdf->Cell(15, 5,   $rankEval2[$data->student->id] . ' ' . $label2, 1, 0, 'C', 1);
            // $this->fpdf->Cell(35, 5, utf8_decode(''), 1, 0, 'L', 0);

            // $this->fpdf->Cell(25, 5, 'RANG', 1, 0, 'C', 0);
            // $this->fpdf->Cell(10, 5, ($ley + 1) . ' ' . $e, 1, 0, 'C', 1);

            // $this->fpdf->Cell(33, 5, utf8_decode('EXCLUSIONS ( jrs )'), 1, 0, 'L', 0);
            // $this->fpdf->Cell(13, 5, '', 1, 0, 'C', 1); // $ExclusionTrimestre
            // $this->fpdf->Cell(27, 5, utf8_decode("BLAME TRAVAIL "), 1, 0, 'L', 0);
            // $this->fpdf->Cell(10, 5, '', 1, 0, 'C', 0);


            // $this->fpdf->Ln();
            // $this->fpdf->SetX(120);
            // $this->fpdf->Cell(33, 5, utf8_decode('BLAME CONDUITE'), 1, 0, 'L', 0);
            // $this->fpdf->Cell(13, 5, '', 1, 0, 'C', 0);
            // $this->fpdf->Cell(27, 5, utf8_decode('BLAME TRAVAIL'), 1, 0, 'L', 0);
            // $this->fpdf->Cell(10, 5, '', 1, 0, 'C', 0);


            // $this->fpdf->Ln();
            // $this->fpdf->SetX(10);


            // $this->fpdf->Cell(50, 5, utf8_decode('VISA DU PARENT '), 1, 0, 'C', 1);
            // $this->fpdf->Cell(93, 5, utf8_decode('OBSERVATION DU CONSEIL DE CLASSE'), 1, 0, 'C', 1);
            // $this->fpdf->Cell(50, 5, 'VISA DU CHEF D\'ETABLISSEMENT', 1, 0, 'C', 1);


            // $this->fpdf->SetX(10);
            // $this->fpdf->Cell(50, 20, '', 0, 0, 'L', 0);
            // $this->fpdf->Cell(93, 20, utf8_decode(''), 0, 0, 'L', 0);
            // $this->fpdf->Cell(50, 21, '       Douala le _______________________', 0, 0, 'L', 0);

            // $this->fpdf->SetX(10);
            // $this->fpdf->Cell(50, 45, '', 1, 0, 'L', 0);
            // $this->fpdf->Cell(93, 45, utf8_decode(''), 1, 0, 'L', 0);
            // $this->fpdf->Cell(50, 45, '    ', 1, 0, 'L', 0);

            // $sommeNoteCoef1 = $sommeNoteCoef2 = $sommeNoteCoef3 = 0;

            // $sommeCoef1 = $sommeCoef2 = $sommeCoef3 = 0;
        }

        $this->fpdf->Output();
        exit;
    }
}
