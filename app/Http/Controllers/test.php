public function getAllBulletinEval($id)

    {


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
            ->where('evaluation_id', $IdEvaluation)->orderBy('valeur', 'DESC')->get();




        $noteData =   Notes::where('evaluation_id', $IdEvaluation)->where('classe_id', $IdClasse)
            ->where('session', $session)->where('codeEtab', $codeEtab)->get();



        $moyenneSommeClasse =  Moyennes::where('evaluation_id', $IdEvaluation)->where('classe_id', $IdClasse)
        ->where('session', $session)->where('codeEtab', $codeEtab)->sum('valeur');


        // nombre deleve ayant une moyenne


        $nombreEleves =  Moyennes::where('evaluation_id', $IdEvaluation)->where('classe_id', $IdClasse)
        ->where('session', $session)->where('codeEtab', $codeEtab)->count();


        // prof principal classe

        $rest = Classe::where('id', $IdClasse)->first();

        $teach = Enseignants::where('id',$rest->principale_Classe)->first();





            $sommeNoteCoef1=$sommeNoteCoef2=$sommeNoteCoef3=0;

            $sommeCoef1=$sommeCoef2=$sommeCoef3=0;

            $couleurRouge = 10;


        foreach ($moyData   as $key => $data) {



            if ($key == 0) {

                $e = 'er';
            } else {

                $e = 'eme';
            }




            $this->fpdf->AddPage("P", ['297', '210']);
            $Note[$data->student->id] = Notes::with('matiere', 'student', 'evaluation', 'user')
                ->where('evaluation_id', $IdEvaluation)
                ->where('classe_id', $IdClasse)
                ->where('cat_id',1)
                ->where('student_id', $data->student->id)
                ->where('codeEtab', $codeEtab)
                ->where('session', $session)->get();


                  // Moyenne du groupe 1


            foreach ($Note[$data->student->id] as $data1) {


                $sommeNoteCoef1 = $sommeNoteCoef1 + ($data1->valeur * $data1->matiere->coef);

                $sommeCoef1 = $sommeCoef1 + $data1->matiere->coef;
            }

            $moyenne1[$data->student->id] =  number_format($sommeNoteCoef1/$sommeCoef1, 2);



            // Ici je calcule le nombre de matiere de la category 2 car comme dan le bulletin elle sort au milieur ( enseigmnt professionels), son
            // decalage gate l'appercu, duc coup je dois je dois faire ce nomdre * (-5) pour le bon decalage
            // Le groupe 1 derange pas dans le decalage


             $val  = Notes::where('classe_id', $IdClasse)
            ->where('cat_id',2)->where('student_id', $data->student->id)
            ->where('evaluation_id', $IdEvaluation)
            ->where('codeEtab', $codeEtab)
            ->where('session', $session)->count();


            $val3  = Notes::where('classe_id', $IdClasse)
            ->where('cat_id',3)->where('student_id', $data->student->id)
            ->where('evaluation_id', $IdEvaluation)
            ->where('codeEtab', $codeEtab)
            ->where('session', $session)->count();



            // Je cherche les heures dans ce trimstre

            $trimestre  = Evaluations::where('id',$IdEvaluation)->first();

            $heureTrimestre  = Presences::where('classe_id', $IdClasse)
            ->where('mois_id', $trimestre->trimestre_id)->where('student_id', $data->student->id)
            ->where('codeEtab', $codeEtab)
            ->where('session', $session)->sum('duree');



            // je recupere les photo des eleves dans user

            $EleveData[$data->student->id] = Student::with('user')->where('id', $data->student->id)->get();


            //$this->fpdf->SetXY(20,115);


            $this->fpdf->Image(public_path("/Photos/Logos/" . $entete), 13, -1, 182, 17, "JPG", "");

            //$this->fpdf->Image(public_path("/Photos/Logos/footer.jpeg"), 0, 280, 210, 18, "JPG", "");



            // Informations de l'eleve

            $this->fpdf->SetFont('Arial', 'B', 7);
            $this->fpdf->Text(115, 35, 'Matricule : '.$Note[$data->student->id][0]->student->matricule);

            $this->fpdf->Text(115, 40, utf8_decode('Noms et prénoms : '.$Note[$data->student->id][0]->student->nom . ' ' . $Note[$data->student->id][0]->student->prenom));

            $this->fpdf->Text(115, 45, 'Date et lieu de naissance : '.utf8_decode($Note[$data->student->id][0]->student->dateNaiss . ' ' . ' à  ' . ' '  . $Note[$data->student->id][0]->student->lieuNaiss));

            $this->fpdf->Text(115, 50, 'Sexe : '.$data->student->sexe);

            $this->fpdf->Text(115, 55, 'Situatuion : '.$data->student->doublant);

            // deuxiemme


            $this->fpdf->Text(47, 35, utf8_decode('Anneé-Scolaire : '.$session));

            $this->fpdf->Text(47, 40, 'Classe : '.$Note[$data->student->id][0]->Classe->libelleClasse);

            $this->fpdf->Text(47, 45, 'Effectif : '.$effectif );


            $this->fpdf->Text(47, 50, 'Prof principal : '.$teach->nom.' '.$teach->prenom);


            $this->fpdf->Image(public_path("/Photos/Logos/" . $EleveData[$data->student->id][0]->user->photo), 20, 39, 25, 15, "JPG", "");



            // // Cadre information eleve



            $this->fpdf->SetXY(20, 30);
            $this->fpdf->Cell(172, 27, '', 1);


            $this->fpdf->SetXY(45, 30);
            $this->fpdf->Cell(68, 27, '', 1);



            // Cadre totale

            // $this->fpdf->SetDrawColor(0, 0, 0);
            $this->fpdf->SetTextColor('10', '75', '168');
            // $this->fpdf->SetXY(10, 10);
            // $this->fpdf->Cell(191, 266, '', 1);

            $this->fpdf->SetFont('Arial', 'B', 14);
            $this->fpdf->SetXY(10, 22);
            $this->fpdf->Cell(0, 0, 'BULLETIN DE NOTES ' . '' . strtoupper($Note[$data->student->id][0]->evaluation->libelle), 0, 0, 'C');






            // Cadre pour le titre de l'ecole

            // $this->fpdf->SetXY(50,39);
            // $this->fpdf->Cell(100,10,'',1);

            $this->fpdf->SetFont('Arial', 'B', 7);
            $this->fpdf->SetTextColor(0, 0, 0);
            // Tire cadre a cote
           // $this->fpdf->Text(135, 72, strtoupper($classeName->libelleEtab));

            $this->fpdf->SetXY(20, 60);
            // $this->fpdf->SetFont('Arial', 'B', 7);
            $this->fpdf->SetDrawColor(0, 0, 0);
            $this->fpdf->SetFillColor('10', '75', '168');
            $this->fpdf->Cell(50, 7, utf8_decode('Matières'), 1, 0, 'C', 1);

            $this->fpdf->SetFont('Arial', 'B', 6);
            $this->fpdf->Cell(10, 7, 'Notes/20', 1, 0, 'C', 1);
            $this->fpdf->Cell(10, 7, 'Coef', 1, 0, 'C', 1);
            $this->fpdf->Cell(10, 7, 'NxC', 1, 0, 'C', 1);
            $this->fpdf->Cell(30, 7, 'Appreciations', 1, 0, 'C', 1);
             $this->fpdf->Cell(10, 7, 'Rang', 1, 0, 'C', 1);
            $this->fpdf->Cell(53, 7, 'Nom et signature enseignant (e) ', 1, 0, 'C', 1);
            // $this->fpdf->Cell(20, 10, 'Signature prof', 1, 0, 'C', 1);
            $this->fpdf->Ln();
            $this->fpdf->SetX(20);


            foreach ($Note[$data->student->id] as $note) {

                if($note->valeur<$couleurRouge) {

                    $this->fpdf->SetTextColor('237', '28', '36');

                }

                else {

                    $this->fpdf->SetTextColor('0', '0', '0');


                }

                $this->fpdf->SetX(20);
                $this->fpdf->SetFont('Arial', 'B', 5);
                $this->fpdf->MultiCell(50, 5, utf8_decode($note->matiere->libelle), 1, 'L');
            }

            $this->fpdf->SetTextColor('0', '0', '0');

            $this->fpdf->SetY(67);


            foreach ($Note[$data->student->id] as $note) {

                if($note->valeur<$couleurRouge) {

                    $this->fpdf->SetTextColor('237', '28', '36');

                }

                else {

                    $this->fpdf->SetTextColor('0', '0', '0');


                }

                $this->fpdf->SetX(70);

                $this->fpdf->MultiCell(10, 5, $note->valeur, 1, 'C');
            }


            $this->fpdf->SetTextColor('0', '0', '0');



            $this->fpdf->SetY(67);
            foreach ($Note[$data->student->id] as $note) {

                if($note->valeur<$couleurRouge) {

                    $this->fpdf->SetTextColor('237', '28', '36');

                }

                else {

                    $this->fpdf->SetTextColor('0', '0', '0');


                }

                $this->fpdf->SetX(80);
                $this->fpdf->MultiCell(10, 5, $note->matiere->coef, 1, 'C');
            }

            $this->fpdf->SetTextColor('0', '0', '0');





            $this->fpdf->SetY(67);
            foreach ($Note[$data->student->id] as $note) {


                //dd($note);

                if($note->valeur<$couleurRouge) {

                    $this->fpdf->SetTextColor('237', '28', '36');
                }

                else {

                    $this->fpdf->SetTextColor('0', '0', '0');


                }

                $this->fpdf->SetX(90);
                $this->fpdf->MultiCell(10, 5, $note->valeur * $note->matiere->coef, 1, 'C');;
            }

            $this->fpdf->SetTextColor('0', '0', '0');


            $this->fpdf->SetY(67);
            foreach ($Note[$data->student->id] as $note) {

                if($note->valeur<$couleurRouge) {

                    $this->fpdf->SetTextColor('237', '28', '36');

                }

                else {

                    $this->fpdf->SetTextColor('0', '0', '0');


                }

                $this->fpdf->SetX(100);
                $this->fpdf->MultiCell(30, 5, $note->mention, 1, 'C');
            }

            $this->fpdf->SetTextColor('0', '0', '0');


            $this->fpdf->SetY(67);
            foreach ($Note[$data->student->id] as $note) {


                $this->fpdf->SetX(130);
                $this->fpdf->MultiCell(10, 5, '-- ' . '/' . ' ' . count($classeData), 1, 'C');
            }

            $this->fpdf->SetTextColor('0', '0', '0');
            $this->fpdf->SetY(67);
            foreach ($Note[$data->student->id] as $note) {

                $this->fpdf->SetX(140);
                $this->fpdf->MultiCell(53, 5, $note->user->nom . ' ' . $note->user->prenom .' ', 1, 'L');
            }




            // Moyenne du dernier

            $MoyDernier = Moyennes::min('valeur');


            // // Moyenne du premier

            $MoyPremier = Moyennes::max('valeur');


            $this->fpdf->SetX(20);

            $this->fpdf->SetFont('Arial', 'B', 7);
            $this->fpdf->Cell(50, 5, utf8_decode('Enseignement Générale') , 1, 0, 'C',1);
            $this->fpdf->Cell(10, 5, $moyenne1[$data->student->id]  , 1, 0, 'C', 1);
            $this->fpdf->Cell(10, 5, $sommeCoef1  , 1, 0, 'C', 1);
            $this->fpdf->Cell(10, 5, $sommeNoteCoef1  , 1, 0, 'C', 1);
            $this->fpdf->Cell(93, 5, ''  , 1, 0, 'C', 1);

            $this->fpdf->SetX(20);


             $this->fpdf->Ln(2);



            $Note2[$data->student->id] = Notes::with('matiere', 'student', 'evaluation', 'user')
                ->where('evaluation_id', $IdEvaluation)
                ->where('classe_id', $IdClasse)
                ->where('cat_id',2)
                ->where('student_id', $data->student->id)
                ->where('codeEtab', $codeEtab)
                ->where('session', $session)->get();

                // dd($Note2[$data->student->id] );


                // Moy du groupe 2

                foreach ($Note2[$data->student->id] as $data2) {


                    $sommeNoteCoef2 = $sommeNoteCoef2 + ($data2->valeur * $data2->matiere->coef);

                    $sommeCoef2 = $sommeCoef2 + $data2->matiere->coef;
                }

                $moyenne2[$data->student->id] =  number_format($sommeNoteCoef2 / $sommeCoef2, 2);



                $this->fpdf->Ln(3);


                foreach ($Note2[$data->student->id] as $note2) {

                    if($note2->valeur<$couleurRouge) {

                        $this->fpdf->SetTextColor('237', '28', '36');

                    }

                    else {

                        $this->fpdf->SetTextColor('0', '0', '0');


                    }


                    $this->fpdf->SetX(20);
                    $this->fpdf->SetFont('Arial', 'B', 5);
                    $this->fpdf->MultiCell(50, 5, utf8_decode($note2->matiere->libelle), 1, 'L');
                }

                $this->fpdf->SetTextColor('0', '0', '0');


                $this->fpdf->Ln(-5*$val);

                foreach ($Note2[$data->student->id] as $note2) {

                if($note2->valeur<$couleurRouge) {

                    $this->fpdf->SetTextColor('237', '28', '36');

                }

                else {

                    $this->fpdf->SetTextColor('0', '0', '0');


                }
                $this->fpdf->SetX(70);
                $this->fpdf->MultiCell(10, 5, $note2->valeur, 1, 'C');
            }

            $this->fpdf->SetTextColor('0', '0', '0');


            $this->fpdf->Ln(-5*$val);
            foreach ($Note2[$data->student->id] as $note2) {

                if($note2->valeur<$couleurRouge) {

                    $this->fpdf->SetTextColor('237', '28', '36');

                }

                else {

                    $this->fpdf->SetTextColor('0', '0', '0');


                }


                $this->fpdf->SetX(80);
                $this->fpdf->MultiCell(10, 5, $note2->matiere->coef, 1, 'C');
            }

            $this->fpdf->SetTextColor('0', '0', '0');


            $this->fpdf->Ln(-5*$val);
            foreach ($Note2[$data->student->id] as $note2) {

                if($note2->valeur<$couleurRouge) {

                    $this->fpdf->SetTextColor('237', '28', '36');

                }

                else {

                    $this->fpdf->SetTextColor('0', '0', '0');


                }

                $this->fpdf->SetX(90);
                $this->fpdf->MultiCell(10, 5, $note2->valeur * $note2->matiere->coef, 1, 'C');;
            }

            $this->fpdf->SetTextColor('0', '0', '0');

            $this->fpdf->Ln(-5*$val);
            foreach ($Note2[$data->student->id] as $note2) {

                if($note2->valeur<$couleurRouge) {

                    $this->fpdf->SetTextColor('237', '28', '36');

                }

                else {

                    $this->fpdf->SetTextColor('0', '0', '0');


                }

                $this->fpdf->SetX(100);
                $this->fpdf->MultiCell(30, 5, $note->mention, 1, 'C');
            }

            $this->fpdf->SetTextColor('0', '0', '0');

            $this->fpdf->Ln(-5*$val);
            foreach ($Note2[$data->student->id] as $note2) {

                $this->fpdf->SetX(130);
                $this->fpdf->MultiCell(10, 5, ' ' . '-- /' . ' ' . count($classeData), 1, 'C');
            }


            $this->fpdf->Ln(-5*$val);
            foreach ($Note2[$data->student->id] as $note2) {

                $this->fpdf->SetX(140);
                $this->fpdf->MultiCell(53, 5, $note2->user->nom . ' ' . $note2->user->prenom .' ', 1, 'L');
            }

            $this->fpdf->SetX(20);

            $this->fpdf->SetFont('Arial', 'B', 7);
            $this->fpdf->SetFont('Arial', 'B', 7);
            $this->fpdf->Cell(50, 5, utf8_decode('Enseignement Professionnel') , 1, 0, 'C',1);
            $this->fpdf->Cell(10, 5,  $moyenne2[$data->student->id]  , 1, 0, 'C', 1);
            $this->fpdf->Cell(10, 5, $sommeCoef2  , 1, 0, 'C', 1);
            $this->fpdf->Cell(10, 5, $sommeNoteCoef2  , 1, 0, 'C', 1);
            $this->fpdf->Cell(93, 5, ''  , 1, 0, 'C', 1);




            //$this->fpdf->Ln(4);
            $this->fpdf->SetX(20);


            $this->fpdf->SetFont('Arial', 'B', 8);

            // $this->fpdf->Cell(173, 8, utf8_decode('Enseignements Complémentaires'), 1, 0, 'C', 1);

            $Note3[$data->student->id] = Notes::with('matiere', 'student', 'evaluation', 'user')
            ->where('evaluation_id', $IdEvaluation)
            ->where('classe_id', $IdClasse)
            ->where('cat_id',3)
            ->where('student_id', $data->student->id)
            ->where('codeEtab', $codeEtab)
            ->where('session', $session)->get();

            // Moyenne du groupe 3


            foreach ($Note3[$data->student->id] as $data3) {


                $sommeNoteCoef3 = $sommeNoteCoef3 + ($data3->valeur * $data3->matiere->coef);

                $sommeCoef3 = $sommeCoef3 + $data3->matiere->coef;
            }

            $moyenne3[$data->student->id] =  number_format($sommeNoteCoef3 / $sommeCoef3, 2);

            $this->fpdf->Ln();


            foreach ($Note3[$data->student->id] as $note3) {

                if($note3->valeur<$couleurRouge) {

                    $this->fpdf->SetTextColor('237', '28', '36');

                }

                else {

                    $this->fpdf->SetTextColor('0', '0', '0');


                }


                $this->fpdf->SetX(20);
                $this->fpdf->SetFont('Arial', 'B', 5);
                $this->fpdf->MultiCell(50, 5, utf8_decode($note3->matiere->libelle), 1, 'L');
            }


            $this->fpdf->Ln(-5*$val3);

            foreach ($Note3[$data->student->id] as $note3) {

                if($note3->valeur<$couleurRouge) {

                    $this->fpdf->SetTextColor('237', '28', '36');

                }

                else {

                    $this->fpdf->SetTextColor('0', '0', '0');


                }
                $this->fpdf->SetX(70);
                $this->fpdf->MultiCell(10, 5, $note3->valeur, 1, 'C');
            }

            $this->fpdf->SetTextColor('0', '0', '0');


            $this->fpdf->Ln(-5*$val3);
            foreach ($Note3[$data->student->id] as $note3) {

                if($note3->valeur<$couleurRouge) {

                    $this->fpdf->SetTextColor('237', '28', '36');

                }

                else {

                    $this->fpdf->SetTextColor('0', '0', '0');


                }


                $this->fpdf->SetX(80);
                $this->fpdf->MultiCell(10, 5, $note3->matiere->coef, 1, 'C');
            }


            $this->fpdf->SetTextColor('0', '0', '0');


            $this->fpdf->Ln(-5*$val3);
            foreach ($Note3[$data->student->id] as $note3) {

                if($note3->valeur<$couleurRouge) {

                    $this->fpdf->SetTextColor('237', '28', '36');

                }

                else {

                    $this->fpdf->SetTextColor('0', '0', '0');


                }

                $this->fpdf->SetX(90);
                $this->fpdf->MultiCell(10, 5, $note3->valeur * $note3->matiere->coef, 1, 'C');;
            }

            $this->fpdf->SetTextColor('0', '0', '0');


            $this->fpdf->Ln(-5*$val3);
            foreach ($Note3[$data->student->id] as $note3) {

                if($note3->valeur<$couleurRouge) {

                    $this->fpdf->SetTextColor('237', '28', '36');

                }

                else {

                    $this->fpdf->SetTextColor('0', '0', '0');


                }

                $this->fpdf->SetX(100);
                $this->fpdf->MultiCell(30, 5, $note3->mention, 1, 'C');
            }


            $this->fpdf->SetTextColor('0', '0', '0');


            $this->fpdf->Ln(-5*$val3);
            foreach ($Note3[$data->student->id] as $note3) {

                $this->fpdf->SetX(130);
                $this->fpdf->MultiCell(10, 5, ' ' . '-- /' . ' ' . count($classeData), 1, 'C');
            }

            $this->fpdf->Ln(-5*$val3);

            foreach ($Note3[$data->student->id] as $note3) {
                $this->fpdf->SetX(140);
                $this->fpdf->MultiCell(53, 5, $note3->user->nom . ' ' . $note3->user->prenom .' ', 1, 'L');
            }


            $this->fpdf->SetX(20);
            $this->fpdf->SetFont('Arial', 'B', 7);
            $this->fpdf->Cell(50, 5, utf8_decode('Enseignement Complémenataire') , 1, 0, 'C',1);
            $this->fpdf->Cell(10, 5,  $moyenne3[$data->student->id]  , 1, 0, 'C', 1);
            $this->fpdf->Cell(10, 5, $sommeCoef3  , 1, 0, 'C', 1);
            $this->fpdf->Cell(10, 5, $sommeNoteCoef3 , 1, 0, 'C', 1);
            $this->fpdf->Cell(93, 5, ''  , 1, 0, 'C', 1);



            $this->fpdf->SetX(20);
            $this->fpdf->Ln(10);



            $this->fpdf->SetX(20);
            $this->fpdf->SetFont('Arial', 'B', 7);
            $this->fpdf->Cell(40, 5, utf8_decode('TRAVAIL DE LA CLASSE') , 1, 0, 'C',1);
            $this->fpdf->Cell(40, 5,  utf8_decode(strtoupper($Note[$data->student->id][0]->evaluation->libelle))  , 1, 0, 'C', 1);
            $this->fpdf->Cell(53, 5, utf8_decode('CONDUITE')  , 1, 0, 'C', 1);
            $this->fpdf->Cell(40, 5, utf8_decode('CONSEIL DE CLASSE')  , 1, 0, 'C', 1);



            $this->fpdf->Ln();
            $this->fpdf->SetX(20);
            $this->fpdf->Cell(25, 5, utf8_decode('MOY CLASSE') , 1, 0, 'L',0);
            $this->fpdf->Cell(15, 5,  number_format($moyenneSommeClasse/$nombreEleves, 2).' / 20' , 1, 0, 'C',0);
            $this->fpdf->SetX(60);
            $this->fpdf->Cell(25, 5, utf8_decode('TOTAL POINTS') , 1, 0, 'L',0);
            $this->fpdf->Cell(15, 5,  $sommeNoteCoef1+ $sommeNoteCoef2+ $sommeNoteCoef3 , 1, 0, 'C',0);
            $this->fpdf->SetX(100);
            $this->fpdf->Cell(42, 5, utf8_decode('ABSENCES TOTALES (H)') , 1, 0, 'L',0);
            $this->fpdf->Cell(11, 5, $heureTrimestre , 1, 0, 'C',0);
            $this->fpdf->Cell(30, 5, utf8_decode('FELICITATIONS') , 1, 0, 'L',0);
            $this->fpdf->Cell(10, 5, '' , 1, 0, 'C',0);


            $this->fpdf->Ln();
            $this->fpdf->SetX(20);
            $this->fpdf->Cell(25, 5, utf8_decode('MOY PREMIER') , 1, 0, 'L',0);
            $this->fpdf->Cell(15, 5, $MoyPremier . ' / 20' , 1, 0, 'C',0);
            $this->fpdf->Cell(25, 5, utf8_decode('TOTAL COEF') , 1, 0, 'L',0);
            $this->fpdf->Cell(15, 5, $sommeCoef1+ $sommeCoef2+ $sommeCoef3 , 1, 0, 'C',0);
            $this->fpdf->Cell(42, 5, utf8_decode('ABSENCES NON JUSTIFIEES (H)') , 1, 0, 'L',0);
            $this->fpdf->Cell(11, 5, '' , 1, 0, 'C',0);
            $this->fpdf->Cell(30, 5, utf8_decode('ENCOURAGEMENTS') , 1, 0, 'L',0);
            $this->fpdf->Cell(10, 5, '' , 1, 0, 'C',0);




            $this->fpdf->Ln();
            $this->fpdf->SetX(20);
            $this->fpdf->Cell(25, 5, utf8_decode('MOY DERNIER') , 1, 0, 'L',0);
            $this->fpdf->Cell(15, 5, $MoyDernier . ' / 20' , 1, 0, 'C',0);
            $this->fpdf->Cell(25, 5, utf8_decode('MOYENNE') , 1, 0, 'L',1);
            $this->fpdf->Cell(15, 5, $data->valeur.' / 20' , 1, 0, 'C',0);
            $this->fpdf->Cell(42, 5, utf8_decode('CONSIGNES (H)') , 1, 0, 'L',0);
            $this->fpdf->Cell(11, 5, '' , 1, 0, 'C',0);
            $this->fpdf->Cell(30, 5, utf8_decode('TABLEAU D\'HONNEUR') , 1, 0, 'L',0);
            $this->fpdf->Cell(10, 5, '' , 1, 0, 'C',0);




            $this->fpdf->Ln();
            $this->fpdf->SetX(60);
            $this->fpdf->Cell(25, 5, utf8_decode('RANG') , 1, 0, 'L',0);
            $this->fpdf->Cell(15, 5, ($key + 1) . '' . $e. ' / ' . count($classeData) , 1, 0, 'C',1);
            $this->fpdf->Cell(42, 5, utf8_decode('EXCLUSIONS ( jrs )') , 1, 0, 'L',0);
            $this->fpdf->Cell(11, 5, '' , 1, 0, 'C',0);
            $this->fpdf->Cell(30, 5, utf8_decode('BLAME TRAVAIL') , 1, 0, 'L',0);
            $this->fpdf->Cell(10, 5, '' , 1, 0, 'C',0);

            $this->fpdf->Ln();
            $this->fpdf->SetX(153);
            $this->fpdf->Cell(30, 5, utf8_decode('BLAME CONDUITE') , 1, 0, 'L',0);
            $this->fpdf->Cell(10, 5, '' , 1, 0, 'C',0);


            $this->fpdf->Ln();
            $this->fpdf->SetX(20);


            $this->fpdf->Cell(122, 5, utf8_decode('OBSERVATION DU CONSEIL DE CLASSE') , 1, 0, 'C',1);
            $this->fpdf->Cell(51, 5, 'VISA DU CHEF D\'ETABLISSEMENT'  , 1, 0, 'C', 1);

            $this->fpdf->Ln(5);
            $this->fpdf->SetX(20);

            $this->fpdf->Cell(122, 15, utf8_decode('') , 1, 0, 'L',0);
            $this->fpdf->Cell(51, 15, ''  , 1, 0, 'L', 0);






        }



        $this->fpdf->Output();
        exit;
    }
