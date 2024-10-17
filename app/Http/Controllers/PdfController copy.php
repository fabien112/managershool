<?php

namespace App\Http\Controllers;

use Fpdf\Fpdf;
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
            $this->fpdf->Text(137, 76, $data->student->doublant);
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

            $this->fpdf->SetFont('Arial', 'B', 7);
            $this->fpdf->SetTextColor(0, 0, 0);
            // Tire cadre a cote
            // $this->fpdf->Text(135, 72, strtoupper($classeName->libelleEtab));

            $this->fpdf->SetXY(10, 85);
            // $this->fpdf->SetFont('Arial', 'B', 7);
            $this->fpdf->SetDrawColor(0, 0, 0);
            $this->fpdf->SetFillColor('166', '166', '166');
            $this->fpdf->Cell(60, 7, utf8_decode('Matières'), 1, 0, 'C', 1);
            $this->fpdf->Cell(10, 7, "DEV " . ($idEval1 - 1), 1, 0, 'C', 1);
            $this->fpdf->Cell(10, 7, "DEV " . ($idEval2 - 1), 1, 0, 'C', 1);
            $this->fpdf->SetFont('Arial', 'B', $tailleNote);


            $this->fpdf->Cell(40, 4, '                   ' . strtoupper($libelleTrimestre), 1, 0, 'L', 1);

            $this->fpdf->SetFont('Arial', 'B', 7);

            $this->fpdf->SetXY(90, 89);

            $this->fpdf->Cell(10, 3, 'Notes', 1, 0, 'C', 1);
            $this->fpdf->Cell(10, 3, 'Coef', 1, 0, 'C', 1);
            $this->fpdf->Cell(10, 3, 'N*C', 1, 0, 'C', 1);
            $this->fpdf->Cell(10, 3, 'Rang', 1, 0, 'C', 1);
            $this->fpdf->SetXY(130, 85);
            $this->fpdf->Cell(10, 7, 'Appreciations', 1, 0, 'C', 1);
            $this->fpdf->Cell(53, 7, 'Enseignant (e) ', 1, 0, 'C', 1);

            $this->fpdf->Ln();
            $this->fpdf->SetX(20);


            // Pour la note seq1


            foreach ($Note[$data->student->id] as $note) {

                $this->fpdf->SetX(10);
                $this->fpdf->SetFont('Arial', 'B', 6);
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


            $this->fpdf->SetFont('Arial', 'B', 7);


            foreach ($Note[$data->student->id] as $note) {

                if ($note->valeur < $couleurRouge) {

                    $this->fpdf->SetTextColor('237', '28', '36');
                } else {

                    $this->fpdf->SetTextColor('0', '0', '0');
                }
                $this->fpdf->SetX(70);

                if ($MoyenneDevoir1[$data->student->id]->valeur == 0) {


                    $this->fpdf->MultiCell(10, 7, '', 1, 'C');
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

                $this->fpdf->SetX(80);
                if ($MoyenneDevoir2[$data->student->id]->valeur == 0) {

                    $this->fpdf->MultiCell(10, 7, '', 1, 'C');
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


                $this->fpdf->SetX(90);
                $this->fpdf->MultiCell(10, 7, $note->valeur, 1, 'C');
            }

            $this->fpdf->SetTextColor('0', '0', '0');


            // // // les coef

            $this->fpdf->SetY(92);
            foreach ($NoteTrimestre[$data->student->id] as $note) {
                $this->fpdf->SetX(100);

                $this->fpdf->MultiCell(10, 7, $note->matiere->coef, 1, 'C');
            }


            $this->fpdf->SetY(92);
            foreach ($NoteTrimestre[$data->student->id] as $note) {

                if ($note->valeur < $couleurRouge) {

                    $this->fpdf->SetTextColor('237', '28', '36');
                } else {

                    $this->fpdf->SetTextColor('0', '0', '0');
                }


                $this->fpdf->SetX(110);
                $this->fpdf->MultiCell(10, 7, ($note->valeur) * $note->matiere->coef, 1, 'C');
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
                            $labelRang = "e";
                        }
                    }
                }


                $this->fpdf->SetX(120);
                $this->fpdf->MultiCell(10, 7, $rank + 1 . $labelRang, 1, 'C');
            }


            $this->fpdf->SetY(92);
            foreach ($NoteTrimestre[$data->student->id] as $note) {

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

                $this->fpdf->SetX(130);
                $this->fpdf->MultiCell(20, 7, utf8_decode($note->mention), 1, 'C');
            }

            // je cherche les infos sur le proef


            $this->fpdf->SetTextColor('0', '0', '0');

            $this->fpdf->SetY(92);
            foreach ($Note[$data->student->id] as $note) {

                $this->fpdf->SetFont('Arial', 'B', 7);

                $this->fpdf->SetX(150);
                $this->fpdf->MultiCell(53, 7, utf8_decode($note->user->nom . ' ' . $note->user->prenom), 1, 'L');
            }


            // Moy trimestre  du groupe 1



            foreach ($NoteTrimestre[$data->student->id] as $data2) {


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



            $this->fpdf->SetX(10);
            $this->fpdf->SetFont('Arial', 'B', 6);
            $this->fpdf->Cell(60, 6, utf8_decode('Enseignement Général'), 1, 0, 'C', 1);
            $this->fpdf->Cell(10, 6,  $moyenneD1Cat1[$data->student->id], 1, 0, 'C', 1);
            $this->fpdf->Cell(10, 6, $moyenneD2Cat1[$data->student->id], 1, 0, 'C', 1);
            $this->fpdf->Cell(10, 6,  $moyenne1[$data->student->id], 1, 0, 'C', 1);
            $this->fpdf->Cell(10, 6, $sommeCoef1, 1, 0, 'C', 1);
            $this->fpdf->Cell(10, 6, $sommeNoteCoef1, 1, 0, 'C', 1);
            $this->fpdf->Cell(83, 6, '', 1, 0, 'C', 1);


            $this->fpdf->Ln();


            foreach ($Notecat2[$data->student->id] as $note) {

                $this->fpdf->SetX(10);
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


                $this->fpdf->SetX(70);
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

                $this->fpdf->SetX(80);
                if ($MoyenneDevoir2[$data->student->id]->valeur == 0) {

                    $this->fpdf->MultiCell(10, 7, '', 1, 'C');
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

                $this->fpdf->SetX(90);
                $this->fpdf->MultiCell(10, 7, $note->valeur, 1, 'C');
            }

            $this->fpdf->SetTextColor('0', '0', '0');


            $this->fpdf->Ln(-7 * $val3);

            foreach ($Note2cat2[$data->student->id] as $note) {

                $this->fpdf->SetX(100);

                $this->fpdf->MultiCell(10, 7, $note->matiere->coef, 1, 'C');
            }

            $this->fpdf->Ln(-7 * $val3);
            foreach ($NoteTrimestrecat2[$data->student->id] as $note) {

                if ($note->valeur < $couleurRouge) {

                    $this->fpdf->SetTextColor('237', '28', '36');
                } else {

                    $this->fpdf->SetTextColor('0', '0', '0');
                }


                $this->fpdf->SetX(110);
                $this->fpdf->MultiCell(10, 7, ($note->valeur) * $note->matiere->coef, 1, 'C');
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
                        $labelRang = "e";
                    }
                }


                $this->fpdf->SetX(120);
                $this->fpdf->MultiCell(10, 7, $rank + 1 . $labelRang, 1, 'C');
            }

            $this->fpdf->SetTextColor('0', '0', '0');



            $this->fpdf->Ln(-7 * $val3);

            foreach ($NoteTrimestre2[$data->student->id] as $note2) {

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


                $this->fpdf->SetX(130);
                $this->fpdf->MultiCell(20, 7, utf8_decode($note2->mention), 1, 'C');
            }

            $this->fpdf->SetTextColor('0', '0', '0');


            $this->fpdf->Ln(-7 * $val3);

            foreach ($NoteTrimestre2[$data->student->id] as $note2) {
                $this->fpdf->SetFont('Arial', 'B', 7);
                $this->fpdf->SetX(150);
                $this->fpdf->MultiCell(53, 7, utf8_decode($note2->user->nom . ' ' . $note2->user->prenom), 1, 'L');
            }

            $this->fpdf->SetX(10);

            // Moy trimestre  du groupe 2

            foreach ($NoteTrimestre2[$data->student->id] as $data2) {


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



            $this->fpdf->SetFont('Arial', 'B', 6);
            $this->fpdf->Cell(60, 6, utf8_decode('Enseignement Professionnel'), 1, 0, 'C', 1);
            $this->fpdf->Cell(10, 6, $moyenneD1Cat2[$data->student->id], 1, 0, 'C', 1);
            $this->fpdf->Cell(10, 6, $moyenneD2Cat2[$data->student->id], 1, 0, 'C', 1);
            $this->fpdf->Cell(10, 6,  $moyenne2[$data->student->id], 1, 0, 'C', 1);
            $this->fpdf->Cell(10, 6,  $sommeCoef2, 1, 0, 'C', 1);
            $this->fpdf->Cell(10, 6, $sommeNoteCoef2, 1, 0, 'C', 1);
            $this->fpdf->Cell(83, 6, '', 1, 0, 'C', 1);

            $this->fpdf->Ln();



            foreach ($Notecat3[$data->student->id] as $note) {

                $this->fpdf->SetX(10);
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

                $this->fpdf->SetX(70);
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

                $this->fpdf->SetX(80);
                if ($MoyenneDevoir2[$data->student->id]->valeur == 0) {

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

                $this->fpdf->SetX(90);


                $this->fpdf->MultiCell(10, 7, $note3->valeur, 1, 'C');
            }


            $this->fpdf->SetTextColor('0', '0', '0');



            $this->fpdf->Ln(-$val4 * 7);
            foreach ($NoteTrimestrecat3[$data->student->id] as $note) {

                $this->fpdf->SetX(100);
                $this->fpdf->MultiCell(10, 7, $note->matiere->coef, 1, 'C');
            }

            $this->fpdf->Ln(-7 * $val4);
            foreach ($NoteTrimestrecat3[$data->student->id] as $note) {

                if ($note->valeur < $couleurRouge) {

                    $this->fpdf->SetTextColor('237', '28', '36');
                } else {

                    $this->fpdf->SetTextColor('0', '0', '0');
                }
                $this->fpdf->SetX(110);
                $this->fpdf->MultiCell(10, 7, ($note->valeur) * $note->matiere->coef, 1, 'C');
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
                            $labelRang = "e";
                        }
                    }
                }


                $this->fpdf->SetX(120);
                $this->fpdf->MultiCell(10, 7, $rank + 1 . $labelRang, 1, 'C');
            }

            $this->fpdf->Ln(-$val4 * 7);

            foreach ($NoteTrimestrecat3[$data->student->id] as $note3) {

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



                $this->fpdf->SetX(130);

                $this->fpdf->SetFont('Arial', 'B', 7);
                $this->fpdf->MultiCell(20, 7, utf8_decode($note3->mention), 1, 'C');
            }

            $this->fpdf->SetTextColor('0', '0', '0');

            $this->fpdf->Ln(-$val4 * 7);


            foreach ($NoteTrimestrecat3[$data->student->id] as $note) {
                $this->fpdf->SetFont('Arial', 'B', 7);
                $this->fpdf->SetX(150);
                $this->fpdf->MultiCell(53, 7, utf8_decode($note->user->nom . ' ' . $note->user->prenom), 1, 'L');
            }



            $this->fpdf->SetX(10);

            // Moy trimestre  du groupe 3

            foreach ($NoteTrimestre3[$data->student->id] as $data2) {


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


            $this->fpdf->SetFont('Arial', 'B', 6);
            $this->fpdf->Cell(60, 6, utf8_decode('Enseignement Complémentaire '), 1, 0, 'C', 1);
            $this->fpdf->Cell(10, 6,  $moyenneD1Cat3[$data->student->id], 1, 0, 'C', 1);
            $this->fpdf->Cell(10, 6, $moyenneD2Cat3[$data->student->id], 1, 0, 'C', 1);
            $this->fpdf->Cell(10, 6,  $moyenne3[$data->student->id], 1, 0, 'C', 1);
            $this->fpdf->Cell(10, 6, $sommeCoef3, 1, 0, 'C', 1);
            $this->fpdf->Cell(10, 6, $sommeNoteCoef3, 1, 0, 'C', 1);
            $this->fpdf->Cell(83, 6, '', 1, 0, 'C', 1);


            $this->fpdf->Ln(12);

            $this->fpdf->SetX(10);
            $this->fpdf->SetFont('Arial', 'B', 6);
            $this->fpdf->Cell(40, 5, utf8_decode('RAPPEL'), 1, 0, 'C', 1);
            $this->fpdf->Cell(35, 5, utf8_decode('TRAVAIL DE LA CLASSE'), 1, 0, 'C', 1);
            $this->fpdf->Cell(35, 5, 'TRAVAIL' . utf8_decode(strtoupper($libelleTrimestre)), 1, 0, 'C', 1);
            $this->fpdf->Cell(46, 5, utf8_decode('CONDUITE'), 1, 0, 'C', 1);
            $this->fpdf->Cell(37, 5, utf8_decode('TRAVAIL'), 1, 0, 'C', 1);


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
            $this->fpdf->SetX(10);
            $this->fpdf->Cell(25, 5, utf8_decode('MOY' . ' ' . $libelleEval1), 1, 0, 'L', 0);

            $rankEval1[$data->student->id] = $rankEval1[$data->student->id];


            // if ($MoyenneDevoir1[$data->student->id]->valeur == 0) {
            //     $MoyenneDevoir1[$data->student->id]->valeur = '';
            //     $rankEval1[$data->student->id] = '';
            // } else {

            $rankEval1[$data->student->id] = $rankEval1[$data->student->id];


            // }


            $this->fpdf->Cell(15, 5,  $MoyenneDevoir1[$data->student->id]->valeur . ' /20', 1, 0, 'C', 0);
            $this->fpdf->Cell(25, 5, utf8_decode('MOY CLASSE / 20'), 1, 0, 'L', 0);
            $this->fpdf->Cell(10, 5, number_format($moyenneSommeClasse / $nombreEleves, 2), 1, 0, 'C', 1);
            $this->fpdf->SetX(85);
            $this->fpdf->Cell(25, 5, utf8_decode('TOTAL POINTS'), 1, 0, 'L', 0);
            $this->fpdf->Cell(10, 5,  $sommeNoteCoef1 + $sommeNoteCoef2 + $sommeNoteCoef3, 1, 0, 'C', 0);
            $this->fpdf->SetX(120);
            $this->fpdf->Cell(33, 5, utf8_decode('ABSENCES (h)'), 1, 0, 'L', 0);
            $this->fpdf->Cell(13, 5, $heureTrimestreNonJustifies, 1, 0, 'C', 0); // $heureTrimestre
            $this->fpdf->Cell(27, 5, utf8_decode('FELICITATIONS'), 1, 0, 'L', 1);
            $this->fpdf->Cell(10, 5, '', 1, 0, 'C', 0);


            // Rang Eval1

            $moyenneEval1[$data->student->id] = Moyennes::where('evaluation_id', $idEval1);


            $this->fpdf->Ln();
            $this->fpdf->SetX(10);
            $this->fpdf->Cell(25, 5, utf8_decode('Rang' . ' ' . $libelleEval1), 1, 0, 'L', 0);

            if ($rankEval1[$data->student->id] == 1) {

                $label1 = 'er';
            } else {
                $label1 = 'eme';
            }
            $this->fpdf->Cell(15, 5, $rankEval1[$data->student->id] . ' ' . $label1, 1, 0, 'C', 1);
            $this->fpdf->Cell(25, 5, utf8_decode('MOY PREMIER / 20 '), 1, 0, 'L', 0);
            $this->fpdf->Cell(10, 5, $MoyPremier, 1, 0, 'C', 0);
            $this->fpdf->Cell(25, 5, utf8_decode('TOTAL COEFS'), 1, 0, 'L', 0);
            $this->fpdf->Cell(10, 5, $sommeCoef1 + $sommeCoef2 + $sommeCoef3, 1, 0, 'C', 0);
            $this->fpdf->Cell(33, 5, utf8_decode('CONSIGNE (h)'), 1, 0, 'L', 1);
            $this->fpdf->Cell(13, 5, '', 1, 0, 'C', 0); // $heureConsigneTrimestre
            $this->fpdf->Cell(27, 5, utf8_decode('ENCOURAGEMENTS'), 1, 0, 'L', 0);
            $this->fpdf->Cell(10, 5, '', 1, 0, 'C', 0);


            $this->fpdf->Ln();
            $this->fpdf->SetX(10);




            $this->fpdf->SetFont('Arial', 'B', 6);
            $this->fpdf->Cell(25, 5, utf8_decode('MOY' . ' ' . $libelleEval2), 1, 0, 'L', 0);

            $rankEval2[$data->student->id] = $rankEval2[$data->student->id];


            // if ($MoyenneDevoir2[$data->student->id]->valeur == 0) {
            //     $MoyenneDevoir2[$data->student->id]->valeur = '-';
            //     $rankEval2[$data->student->id] = '-';
            // } else {

            //     $rankEval2[$data->student->id] = $rankEval2[$data->student->id];
            // }
            $this->fpdf->Cell(15, 5, $MoyenneDevoir2[$data->student->id]->valeur . ' /20', 1, 0, 'C', 0);
            $this->fpdf->Cell(25, 5, utf8_decode('MOY Dernier / 20 '), 1, 0, 'L', 0);
            $this->fpdf->Cell(10, 5, $MoyDernier, 1, 0, 'C', 0);
            $this->fpdf->Cell(25, 5, 'MOYENNE / 20 ', 1, 0, 'C', 1);
            $this->fpdf->Cell(10, 5, $data->valeur, 1, 0, 'C', 0);

            $this->fpdf->Cell(33, 5, utf8_decode('AVERTISSEMENT CONDUITE'), 1, 0, 'L', 0);
            $this->fpdf->Cell(13, 5, '', 1, 0, 'C', 0);
            $this->fpdf->Cell(27, 5, utf8_decode("TABLEAU D'HONNEUR "), 1, 0, 'L', 0);
            $this->fpdf->Cell(10, 5, '', 1, 0, 'C', 0);

            $rankEval2[$data->student->id] = $rankEval2[$data->student->id];

            // if ($MoyenneDevoir2[$data->student->id]->valeur == 0) {
            //     $MoyenneDevoir2[$data->student->id]->valeur = '';
            //     $rankEval2[$data->student->id] = '';
            // } else {

            //     $rankEval2[$data->student->id] = $rankEval2[$data->student->id];
            // }
            $this->fpdf->Ln();
            $this->fpdf->SetX(10);
            $this->fpdf->SetFont('Arial', 'B', 6);
            $this->fpdf->Cell(25, 5, utf8_decode('Rang' . ' ' . $libelleEval2), 1, 0, 'L', 0);

            if ($rankEval2[$data->student->id] == 1) {

                $label2 = 'er';
            } else {
                $label2 = 'eme';
            }


            $this->fpdf->Cell(15, 5,   $rankEval2[$data->student->id] . ' ' . $label2, 1, 0, 'C', 1);
            $this->fpdf->Cell(35, 5, utf8_decode(''), 1, 0, 'L', 0);

            $this->fpdf->Cell(25, 5, 'RANG', 1, 0, 'C', 0);
            $this->fpdf->Cell(10, 5, ($ley + 1) . ' ' . $e, 1, 0, 'C', 1);

            $this->fpdf->Cell(33, 5, utf8_decode('EXCLUSIONS ( jrs )'), 1, 0, 'L', 0);
            $this->fpdf->Cell(13, 5, '', 1, 0, 'C', 1); // $ExclusionTrimestre
            $this->fpdf->Cell(27, 5, utf8_decode("BLAME TRAVAIL "), 1, 0, 'L', 0);
            $this->fpdf->Cell(10, 5, '', 1, 0, 'C', 0);


            $this->fpdf->Ln();
            $this->fpdf->SetX(120);
            $this->fpdf->Cell(33, 5, utf8_decode('BLAME CONDUITE'), 1, 0, 'L', 0);
            $this->fpdf->Cell(13, 5, '', 1, 0, 'C', 0);
            $this->fpdf->Cell(27, 5, utf8_decode('BLAME TRAVAIL'), 1, 0, 'L', 0);
            $this->fpdf->Cell(10, 5, '', 1, 0, 'C', 0);


            $this->fpdf->Ln();
            $this->fpdf->SetX(10);


            $this->fpdf->Cell(50, 5, utf8_decode('VISA DU PARENT '), 1, 0, 'C', 1);
            $this->fpdf->Cell(93, 5, utf8_decode('OBSERVATION DU CONSEIL DE CLASSE'), 1, 0, 'C', 1);
            $this->fpdf->Cell(50, 5, 'VISA DU CHEF D\'ETABLISSEMENT', 1, 0, 'C', 1);


            $this->fpdf->SetX(10);
            $this->fpdf->Cell(50, 20, '', 0, 0, 'L', 0);
            $this->fpdf->Cell(93, 20, utf8_decode(''), 0, 0, 'L', 0);
            $this->fpdf->Cell(50, 21, '       Douala le _______________________', 0, 0, 'L', 0);

            $this->fpdf->SetX(10);
            $this->fpdf->Cell(50, 45, '', 1, 0, 'L', 0);
            $this->fpdf->Cell(93, 45, utf8_decode(''), 1, 0, 'L', 0);
            $this->fpdf->Cell(50, 45, '    ', 1, 0, 'L', 0);

            $sommeNoteCoef1 = $sommeNoteCoef2 = $sommeNoteCoef3 = 0;

            $sommeCoef1 = $sommeCoef2 = $sommeCoef3 = 0;
        }

        $this->fpdf->Output();
        exit;
    }
}
