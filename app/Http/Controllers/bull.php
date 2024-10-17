<?php

namespace App\Http\Controllers;

use App\Models\Notes;
use App\Models\Classe;
use App\Models\Matiere;
use App\Models\Session;
use App\Models\Student;
use App\Models\Moyennes;
use Codedge\Fpdf\Fpdf\Fpdf;
use Illuminate\Http\Request;
use App\Models\Etablissement;

class PdfController extends Controller

{
    protected $fpdf;

    public function __construct()
    {
        $this->fpdf = new Fpdf;
    }

    public function index($id)
    {

        // Je recupere le codeEtab, la session et l'id de la classe

        // Je recupere le codeEtab, la session et l'id de la classe

        $data =  explode('*', $id);

        $IdClasse = $data[0];
        $codeEtab  = $data[1];

        // Information de cette ecole

        $classeName = Etablissement::where('codeEtab', $codeEtab)->first();

        $session = Session::where('codeEtab_sess', $codeEtab)->first('libelle_sess');

        $sessionEncour = $session->libelle_sess;

        $classeData = Student::where('classe_id', $IdClasse)->where('session', $sessionEncour)->where('codeEtab', $codeEtab)->get();

        foreach ($classeData as $key => $data) {

            $EleveData = Student::with('classe', 'user', 'parent')->where('id', $data->id)->get();
            $this->fpdf->AddPage("L", ['86', '55']);

            $fr = 7;
            $en = 5;
            $this->fpdf->Image(public_path("/Photos/Logos/drapeau-cameroun.jpg"), 7, 1, 10, 10, "JPG", "");

            $this->fpdf->Image(public_path("/Photos/Logos/" . $classeName->logoEtab), 67, 3, 10, 7, "");
            $this->fpdf->SetFont('Arial', 'B', $fr);
            $this->fpdf->Text(25, 5, "REPUBLIQUE DU CAMEROUN");
            $this->fpdf->SetFont('Arial', 'I', $en);
            $this->fpdf->Text(35, 8, "Paix-Travail-Patrie");

            $this->fpdf->SetFont('Helvetica', 'B', 8);

            $this->fpdf->Cell(0, 10, $classeName->libelleEtab, 0, 0, 'C');


            // $this->fpdf->SetXY(1,1);
            // $this->fpdf->Cell(0,40,'',1);

            $this->fpdf->Ln(3);

            $this->fpdf->SetFont('Arial', 'I', 5);

            $this->fpdf->Cell(0, 10, $classeName->sloganEtab, 0, 0, 'C');

            $this->fpdf->Ln(3);

            $this->fpdf->SetFont('Arial', 'I', 5);

            $this->fpdf->Cell(0, 10, "CARTE D'IDENTITE SCOLAIRE ", 0, 0, 'C');

            $this->fpdf->Ln(2);

            $this->fpdf->SetFont('Arial', 'B', 6);
            $this->fpdf->Cell(0, 13,  $data->session, 0, 0, 'C');


            // photo de l'enfant

            $this->fpdf->Image(
                public_path("/Photos/Logos/" . $data->user->photo),
                4,
                20,
                25,
                30,
                ""
            );

            // informations eleves

            $this->fpdf->SetFont('Arial', 'I', 5);
            $this->fpdf->Text(32, 29, "Matricule : ");
            $this->fpdf->SetFont('Arial', 'B', 6);
            $this->fpdf->Text(41, 29, $data->matricule);

            $this->fpdf->SetFont('Arial', 'I', 5);
            $this->fpdf->Text(32, 32, "Nom : ");
            $this->fpdf->SetFont('Arial', 'B', 6);
            $this->fpdf->Text(38, 32, $data->nom);

            $this->fpdf->SetFont('Arial', 'I', 5);
            $this->fpdf->Text(32, 35, "Prenom : ");
            $this->fpdf->SetFont('Arial', 'B', 6);
            $this->fpdf->Text(40, 35, $data->prenom);


            $this->fpdf->SetFont('Arial', 'I', 5);
            $this->fpdf->Text(32, 38, "Date de naissance : ");
            $this->fpdf->SetFont('Arial', 'B', 6);
            $this->fpdf->Text(48, 38, $data->dateNaiss);


            $this->fpdf->SetFont('Arial', 'I', 5);
            $this->fpdf->Text(32, 41, "Lieu de naissance : ");
            $this->fpdf->SetFont('Arial', 'B', 6);
            $this->fpdf->Text(48, 41, $data->lieuNaiss);


            $this->fpdf->SetFont('Arial', 'I', 5);
            $this->fpdf->Text(32, 44, "Sexe : ");
            $this->fpdf->SetFont('Arial', 'B', 6);
            $this->fpdf->Text(38, 44, $data->sexe);


            $this->fpdf->SetFont('Arial', 'I', 5);
            $this->fpdf->Text(32, 47, "Classe : ");
            $this->fpdf->SetFont('Arial', 'B', 6);
            $this->fpdf->Text(39, 47, $data->Classe->libelleClasse);


            $this->fpdf->SetFont('Arial', 'I', 5);
            $this->fpdf->Text(32, 50, "Tel du parent : ");
            $this->fpdf->SetFont('Arial', 'B', 6);
            $this->fpdf->Text(44, 50, $data->Parent->telParent);
        }

        $this->fpdf->Output();

        exit;
    }


    public function getEleveCniPdf($id)

    {

        // Je recupere le codeEtab, la session et l'id de la classe

        $IdEleve = $id;

        $data = Student::with('classe', 'user', 'parent')->where('id', $IdEleve)->first();

        $codeEtab = $data->codeEtab;

        $classeName = Etablissement::where('codeEtab', $codeEtab)->first();

        $this->fpdf->AddPage("L", ['86', '55']);

        $fr = 7;
        $en = 5;
        $this->fpdf->Image(public_path("/Photos/Logos/drapeau-cameroun.jpg"), 7, 1, 10, 10, "JPG", "");
        $this->fpdf->Image(public_path("/Photos/Logos/" . $classeName->logoEtab), 67, 3, 10, 7, "");
        $this->fpdf->SetFont('Arial', 'B', $fr);
        $this->fpdf->Text(25, 5, "REPUBLIQUE DU CAMEROUN");
        $this->fpdf->SetFont('Arial', 'I', $en);
        $this->fpdf->Text(35, 8, "Paix-Travail-Patrie");

        $this->fpdf->SetFont('Helvetica', 'B', 8);

        $this->fpdf->Cell(0, 10, $classeName->libelleEtab, 0, 0, 'C');

        $this->fpdf->Ln(3);

        $this->fpdf->SetFont('Arial', 'I', 5);

        $this->fpdf->Cell(0, 10, $classeName->sloganEtab, 0, 0, 'C');

        $this->fpdf->Ln(3);

        $this->fpdf->SetFont('Arial', 'I', 5);

        $this->fpdf->Cell(0, 10, "CARTE D'IDENTITE SCOLAIRE ", 0, 0, 'C');

        $this->fpdf->Ln(2);

        $this->fpdf->SetFont('Arial', 'B', 6);
        $this->fpdf->Cell(0, 13,  $data->session, 0, 0, 'C');


        // photo de l'enfant

        $this->fpdf->Image(
            public_path("/Photos/Logos/" . $data->user->photo),
            4,
            20,
            25,
            30,
            ""
        );

        // informations eleves

        $this->fpdf->SetFont('Arial', 'I', 5);
        $this->fpdf->Text(32, 29, "Matricule : ");
        $this->fpdf->SetFont('Arial', 'B', 6);
        $this->fpdf->Text(41, 29, $data->matricule);

        $this->fpdf->SetFont('Arial', 'I', 5);
        $this->fpdf->Text(32, 32, "Nom : ");
        $this->fpdf->SetFont('Arial', 'B', 6);
        $this->fpdf->Text(38, 32, $data->nom);

        $this->fpdf->SetFont('Arial', 'I', 5);
        $this->fpdf->Text(32, 35, "Prenom : ");
        $this->fpdf->SetFont('Arial', 'B', 6);
        $this->fpdf->Text(40, 35, $data->prenom);


        $this->fpdf->SetFont('Arial', 'I', 5);
        $this->fpdf->Text(32, 38, "Date de naissance : ");
        $this->fpdf->SetFont('Arial', 'B', 6);
        $this->fpdf->Text(48, 38, $data->dateNaiss);


        $this->fpdf->SetFont('Arial', 'I', 5);
        $this->fpdf->Text(32, 41, "Lieu de naissance : ");
        $this->fpdf->SetFont('Arial', 'B', 6);
        $this->fpdf->Text(48, 41, $data->lieuNaiss);


        $this->fpdf->SetFont('Arial', 'I', 5);
        $this->fpdf->Text(32, 44, "Sexe : ");
        $this->fpdf->SetFont('Arial', 'B', 6);
        $this->fpdf->Text(38, 44, $data->sexe);


        $this->fpdf->SetFont('Arial', 'I', 5);
        $this->fpdf->Text(32, 47, "Classe : ");
        $this->fpdf->SetFont('Arial', 'B', 6);
        $this->fpdf->Text(39, 47, $data->Classe->libelleClasse);


        $this->fpdf->SetFont('Arial', 'I', 5);
        $this->fpdf->Text(32, 50, "Tel du parent : ");
        $this->fpdf->SetFont('Arial', 'B', 6);
        $this->fpdf->Text(44, 50, $data->Parent->telParent);

        $this->fpdf->Output();

        exit;
    }

    public function getAllBulletinEval($id)
    {

        $data =  explode('*', $id);
        $IdClasse = $data[0];
        $IdEvaluation  = $data[1];

        // Je trouve le codeEtab et la session

        $code = Classe::where('id', $IdClasse)->first();
        $codeEtab = $code->codeEtabClasse;
        $session = $code->sessionClasse;

        $classeName = Etablissement::where('codeEtab', $codeEtab)->first();

        // Tous les eleves

        $classeData = Student::with('user', 'classe')->where('classe_id', $IdClasse)->where('session', $session)->where('codeEtab', $codeEtab)->get();

        $noteData =   Notes::where('evaluation_id', $IdEvaluation)->where('classe_id', $IdClasse)
            ->where('session', $session)->where('codeEtab', $codeEtab)->get();

        foreach ($classeData  as $key => $data) {


            $this->fpdf->AddPage("P", ['297', '210']);
            $Note[$data->id] = Notes::with('matiere', 'student', 'evaluation', 'user')
                ->where('evaluation_id', $IdEvaluation)
                ->where('classe_id', $IdClasse)
                ->where('student_id', $data->id)
                ->where('codeEtab', $codeEtab)
                ->where('session', $session)->get();

            // je recupere les photo des eleves dans user

            $EleveData[$data->id] = Student::with('user')->where('id', $data->id)->get();




            //$this->fpdf->SetXY(20,115);


            $this->fpdf->SetFont('Arial', 'B', 15);
            $this->fpdf->SetFont('Arial', 'B', 7);
            $this->fpdf->SetXY(10, 10);
            $this->fpdf->Text(20, 18, "REPUBLIQUE DU CAMEROUN");
            $this->fpdf->SetFont('Arial', 'I', 5);
            $this->fpdf->Text(20, 21, "Paix-Travail-Patrie");
            $this->fpdf->SetFont('Arial', 'B', 7);
            $this->fpdf->Text(20, 25, "MINISTERE DES ENSEIGNEMENTS SECONDAIRES");
            $this->fpdf->Image(public_path("/Photos/Logos/drapeau-cameroun.jpg"), 18, 25, 19, 15, "JPG", "");
            $this->fpdf->Image(public_path("/Photos/Logos/" . $classeName->logoEtab), 155, 27, 19, 15, "JPG", "");
            $this->fpdf->Text(157, 18, $classeName->libelleEtab);
            $this->fpdf->SetFont('Arial', 'I', 5);
            $this->fpdf->Text(157, 21, $classeName->sloganEtab);
            $this->fpdf->SetFont('Arial', 'B', 7);
            $this->fpdf->Text(157, 25, "ANNEE SCOLAIRE:");
            $this->fpdf->SetFont('Arial', 'I', 7);
            $this->fpdf->Text(180, 25, $session);

            // Informations de l'eleve

            $this->fpdf->SetFont('Arial', 'I', 5);
            $this->fpdf->Text(50, 75, 'Matricule : ');
            $this->fpdf->SetFont('Arial', 'B', 7);
            $this->fpdf->Text(62, 75, $Note[$data->id][0]->student->matricule);

            $this->fpdf->SetFont('Arial', 'I', 5);
            $this->fpdf->Text(50, 80, 'Nom : ');
            $this->fpdf->SetFont('Arial', 'B', 7);
            $this->fpdf->Text(57, 80, $Note[$data->id][0]->student->nom);

            $this->fpdf->SetFont('Arial', 'I', 5);
            $this->fpdf->Text(50, 85, 'Prenom: ');
            $this->fpdf->SetFont('Arial', 'B', 7);
            $this->fpdf->Text(59, 85,  $Note[$data->id][0]->student->prenom);

            $this->fpdf->SetFont('Arial', 'I', 5);
            $this->fpdf->Text(50, 90, 'Date et lieu de naissance : ');
            $this->fpdf->SetFont('Arial', 'B', 7);
            $this->fpdf->Text(72, 90,  $Note[$data->id][0]->student->dateNaiss);

            $this->fpdf->SetFont('Arial', 'I', 5);
            $this->fpdf->Text(86, 90, 'a');
            $this->fpdf->SetFont('Arial', 'B', 7);
            $this->fpdf->Text(89, 90,  $Note[$data->id][0]->student->lieuNaiss);

            $this->fpdf->SetFont('Arial', 'I', 5);
            $this->fpdf->Text(50, 95, 'Classe : ');
            $this->fpdf->SetFont('Arial', 'B', 7);
            $this->fpdf->SetFont('Arial', 'B', 7);
            $this->fpdf->Text(59, 95, $Note[$data->id][0]->Classe->libelleClasse);
            $this->fpdf->Image(public_path("/Photos/Logos/" . $EleveData[$data->id][0]->user->photo), 22, 72, 22, 28, "JPG", "");

            $this->fpdf->SetFont('Arial', 'I', 5);
            $this->fpdf->Text(50, 100, 'Sexe : ');
            $this->fpdf->SetFont('Arial', 'B', 7);
            $this->fpdf->SetFont('Arial', 'B', 7);
            $this->fpdf->Text(57, 100, $data->sexe);

            // Cadre information eleve
            $this->fpdf->SetXY(20, 70);
            $this->fpdf->Cell(173, 32, '', 1);
            // donnes eleves

            $this->fpdf->SetXY(20, 70);
            $this->fpdf->Cell(113, 32, '', 1);

            //PHOTO
            $this->fpdf->SetXY(20, 70);
            $this->fpdf->Cell(27, 32, '', 1);

            $this->fpdf->SetXY(133, 90);
            $this->fpdf->Cell(60, 12, 'BULLETIN DE NOTE : '.' '.$Note[$data->id][0]->evaluation->libelle, 1);


            // Cadre totale

            $this->fpdf->SetXY(10, 10);
            $this->fpdf->Cell(191, 265, '', 1);

            $this->fpdf->SetFont('Arial', 'I', 10);
            $this->fpdf->SetXY(10, 55);
            $this->fpdf->Cell(0, 0, $classeName->libelleEtab, 0, 0, 'C');

            // Cadre pour le titre de l'ecole

            // $this->fpdf->SetXY(20,50);
            // $this->fpdf->Cell(173,10,'',1);

            $this->fpdf->SetFont('Arial', 'I', 8);
            $this->fpdf->Text(150, 82, $session);
            $this->fpdf->SetXY(20, 115);
            $this->fpdf->SetFont('Arial', 'I', 7);
            $this->fpdf->SetDrawColor(0, 0, 0);
            $this->fpdf->SetFillColor('40', '164', '226');
            $this->fpdf->Cell(30, 10, 'Matieres', 1, 0, 'C', 1);
            $this->fpdf->Cell(10, 10, 'Notes', 1, 0, 'C', 1);
            $this->fpdf->Cell(10, 10, 'Coef', 1, 0, 'C', 1);
            $this->fpdf->Cell(20, 10, 'Note*Coef', 1, 0, 'C', 1);
            $this->fpdf->Cell(20, 10, 'Mentions', 1, 0, 'C', 1);
            $this->fpdf->Cell(10, 10, 'Rang', 1, 0, 'C', 1);
            $this->fpdf->Cell(43, 10, 'Enseignants', 1, 0, 'C', 1);
            $this->fpdf->Cell(30, 10, 'Signature prof', 1, 0, 'C', 1);
            $this->fpdf->Ln();



            foreach ($Note[$data->id] as $note) {

                $this->fpdf->SetX(20);
                $this->fpdf->SetFont('Arial', 'I', 6);
                $this->fpdf->MultiCell(30, 10, $note->matiere->libelle, 1, 'L');


            }

            $this->fpdf->SetY(125);

            foreach ($Note[$data->id] as $note) {
                $this->fpdf->SetX(50);
                $this->fpdf->MultiCell(10, 10, $note->valeur, 1, 'C');
            }

            $this->fpdf->SetY(125);
            foreach ($Note[$data->id] as $note) {

                $this->fpdf->SetX(60);
                $this->fpdf->MultiCell(10, 10, $note->matiere->coef, 1, 'C');
            }


            $this->fpdf->SetY(125);
            foreach ($Note[$data->id] as $note) {

                $this->fpdf->SetX(70);
                $this->fpdf->MultiCell(20, 10, $note->valeur * $note->matiere->coef, 1, 'C');;
            }

            $this->fpdf->SetY(125);
            foreach ($Note[$data->id] as $note) {

                $this->fpdf->SetX(90);
                $this->fpdf->MultiCell(20, 10, $note->mention, 1, 'C');
            }

            $this->fpdf->SetY(125);
            foreach ($Note[$data->id] as $note) {

                $this->fpdf->SetX(110);
                $this->fpdf->MultiCell(10, 10, ' ' . '/' . ' ' . count($classeData), 1, 'C');
            }


            $this->fpdf->SetY(125);
            foreach ($Note[$data->id] as $note) {

                $this->fpdf->SetX(110);
                $this->fpdf->MultiCell(53, 10, $note->user->nom . ' ' . $note->user->prenom, 1, 'C');
            }

            $this->fpdf->SetY(125);
            foreach ($Note[$data->id] as $note) {
                $this->fpdf->SetX(163);
                $this->fpdf->MultiCell(30, 10, ' ', 1, 'C');
            }

                // Toutes les moyennes

            $Moy[$data->id] = Moyennes::where('evaluation_id', $IdEvaluation)
            ->where('student_id', $data->id)->orderBy('valeur','DESC')->first();

            // Moyenne du dernier

            $MoyDernier = Moyennes::min('valeur');


             // Moyenne du premier

             $MoyPremier = Moyennes::max('valeur');




            //$this->fpdf->Ln(10);
            $this->fpdf->SetX(20);

            $this->fpdf->SetFont('Arial', 'I', 5);
            $this->fpdf->Cell(40, 10, 'Moyenne'.' '.$note->evaluation->libelle, 1, 0, 'C');
            $this->fpdf->Cell(20, 10, 'Rang', 1, 0, 'C', 1);
            $this->fpdf->Cell(40, 10, 'Moyenne du premier ', 1, 0, 'C');
            $this->fpdf->Cell(43, 10, 'Moyenne du dernier', 1, 0, 'C', 1);

            $this->fpdf->Ln();
            $this->fpdf->SetX(20);
            $this->fpdf->SetFont('Arial', 'I', 5);
            $this->fpdf->Cell(40, 10, $Moy[$data->id]->valeur.' / 20', 1, 0, 'C',1);
            $this->fpdf->Cell(20, 10, '', 1, 0, 'C');
            $this->fpdf->Cell(40, 10,  $MoyPremier.' / 20', 1, 0, 'C');
            $this->fpdf->Cell(43, 10,  $MoyDernier.' / 20', 1, 0, 'C');

            $this->fpdf->Ln(45);
            $this->fpdf->SetX(20);

            $this->fpdf->SetFont('Arial', 'I', 5);
            $this->fpdf->Cell(70, 10, 'Effort a fournier en ', 1, 0, 'C', 1);
            $this->fpdf->Cell(20, 10, 'Absences', 1, 0, 'C', 1);
            $this->fpdf->Cell(40, 10, 'Blame', 1, 0, 'C', 1);
            $this->fpdf->Cell(10, 10, 'TH', 1, 0, 'C', 1);
            $this->fpdf->Cell(20, 10, 'Decision', 1, 0, 'C', 1);

            $this->fpdf->Ln();
            $this->fpdf->SetX(20);
            $this->fpdf->SetFont('Arial', 'I', 5);
            $this->fpdf->Cell(70, 10, '', 1, 'C');
            $this->fpdf->Cell(20, 10, '', 1,  'C');
            $this->fpdf->Cell(40, 10, '', 1,  'C');
            $this->fpdf->Cell(10, 10, '', 1,  'C');
            $this->fpdf->Cell(20, 10, '', 1,  'C');

            $this->fpdf->Text(20, 261, "Signature du chef etablissement");
            $this->fpdf->Text(170, 261, "Signature du parent");


        }

        $Rang = Moyennes::where('evaluation_id', $IdEvaluation)
        ->where('classe_id', $IdClasse)->orderBy('valeur','DESC')->get();




         $this->fpdf->Output();
         exit;
    }
}
