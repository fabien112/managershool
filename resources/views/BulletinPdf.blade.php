<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'https://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
<html xmlns='https://www.w3.org/1999/xhtml'>
<head>
<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
<body style='font-family:Tahoma;font-size:12px;color: #5a4f4f;background-color:#FFFFFF;'>
<div style="marging:5px;padding:5px;marging:35px;padding:15px;">

 <table width='100%' cellspacing='0' cellpadding='0'>
    <tr>
      <td valign='top' width='30%' style='font-size:8px;'> <strong >

          République du CAMEROUN </strong> <br />

          <strong>Paix-Travail-Patrie  </strong><br>

          <strong> Ministeres des enseignements secondaires <br /> </strong>

            <strong> Arrondissement  {{$classeName->villeEtab}} </strong> <br>

        <img style="width:10%"src="{{public_path("/images/drapeau-cameroun.jpg")}}" alt="">

      </td>
      <td valign='top' width='45%'>

        <div align='center'>
            <img  src="{{public_path("/Photos/Logos/".$classeName->logoEtab)}}" style="border-radius:50%;height:80px;width:80px"/>
      </div>

      </td>
      <td valign='top' width='20%' style='font-size:8px;'>  <strong> {{$classeName->libelleEtab}} </strong> <br>

         <strong> {{$classeName->sloganEtab}} </strong> <br>
         <strong> Année scolaire :  2020-2021 </strong> <br>

      </td>

  </tr>
</table>
</div>  <br> <br>



<table width='100%' cellspacing='0' cellpadding='0'>
    <tr>

      <td valign='top' width='40%' style='font-size:8px;'>

        <strong > Nom et Prénom :   {{$eleves->nom}} {{$eleves->prenom}}   </strong> <br /> <br>
        <strong > Matricule       : {{$eleves->matricule}}   </strong> <br /> <br>
        <strong > Date et lieu de naissance       : {{$eleves->dateNaiss}} à {{$eleves->lieuNaiss}}    </strong> <br /> <br>
        <strong > Classe       : {{$eleves->Classe->libelleClasse}}   </strong> <br /> <br>
        <strong > Statut       : {{$eleves->doublant}}   </strong> <br /> <br>
        <img  style="width: 65px;height:55px" src="{{public_path("/Photos/Logos/".$eleves->user->photo)}}" >

     </td>
      <td valign='top' width='40%' >

        <h3  style="border:solid black 0.5px;marging:35px;padding:15px;border-radius:50px;text-align:center;background-color:#46D1FD"> BULLETIN {{$matiere[0]->evaluation->libelle}}</h3>

      </td>
      <td valign='top' width='20%' style='font-size:8px;'>

      </td>

  </tr>
</table> <br>
<br>
<br>





<table width='100%' cellspacing='0' cellpadding='2' border='0.001' bordercolor='#CCCCCC'>
    <tr>

      <td color='#fff' bgcolor='#46D1FD' style='font-size:13px;'><strong> Matieres </strong></td>
      <td color='#fff' bgcolor='#46D1FD' style='font-size:13px;'><strong> Notes</strong></td>
      <td color='#fff' bgcolor='#46D1FD' style='font-size:15px;'><strong> Coef</strong></td>
      <td color='#fff' bgcolor='#46D1FD' style='font-size:13px;'><strong> Notes x Coef</strong></td>
      <td width='15%' color='#fff' bgcolor='#46D1FD' style='font-size:13px;'><strong> Mentions </strong></td>
      <td width='15%' color='#fff' bgcolor='#46D1FD' style='font-size:13px;'><strong> Enseignants </strong></td>
      <td width='15%' color='#fff' bgcolor='#46D1FD' style='font-size:13px;'><strong> Signatures</strong></td>
      </tr>
      <tr style="display:none;">
        <td colspan="*">

            @foreach ($matiere as  $eleve)

                <tr>

                    <td valign='top' style='font-size:12px;'>{{$eleve->matiere->libelle}}</td>
                    <td valign='top' style='font-size:12px;'>{{$eleve->valeur}}</td>
                    <td valign='top' style='font-size:12px;'>{{$eleve->matiere->coef}}</td>
                    <td valign='top' style='font-size:12px;'>{{$eleve->matiere->coef*$eleve->valeur}}</td>
                    <td valign='top' style='font-size:12px;'>{{$eleve->mention}}</td>
                    <td valign='top' style='font-size:12px;'>{{$eleve->user->nom}} {{$eleve->user->prenom}}</td>
                    <td valign='top' style='font-size:12px;'> </td>


                </tr>

            @endforeach

            <tr bgcolor='#46D1FD'>

                <td valign='top' style='font-size:13px;font-weight:bold'> Moyenne </td>
                <td colspan="6" valign='top' style='font-size:13px;font-weight:bold'>{{$moyenne}}/20</td>

            </tr>

            <tr bgcolor='#46D1FD'>

                <td valign='top' style='font-size:13px;font-weight:bold'> Rang </td>
                <td colspan="6" valign='top' style='font-size:13px;font-weight:bold'> 12 <sup>e</sup> /120</td>


            </tr>

            {{-- <tr>

                <td valign='top' style='font-size:13px;font-weight:bold'> Effectif </td>
                <td colspan="6" valign='top' style='font-size:13px;font-weight:bold'> 120 </td>


            </tr> --}}

            <tr>

                <td valign='top' style='font-size:13px;font-weight:bold'> Moyenne generale <br>  de la classe </td>
                <td colspan="6" valign='top' style='font-size:13px;font-weight:bold'> 10/20 </td>


            </tr>

            <tr>

                <td valign='top' style='font-size:13px;font-weight:bold'> Moyenne  du premier  </td>
                <td colspan="6" valign='top' style='font-size:13px;font-weight:bold'> 17/20 </td>


            </tr>

            <tr>

                <td valign='top' style='font-size:13px;font-weight:bold'> Moyenne   du dernier  </td>
                <td colspan="6" valign='top' style='font-size:13px;font-weight:bold'> 05/20 </td>


            </tr>



        </td>
      </tr>
</table>


<br><br> <br><br>


<table width='100%' cellspacing='0' cellpadding='2' border='0.001' bordercolor='#CCCCCC'>
    <tr>

        <td color='#fff' bgcolor='#46D1FD' style='font-size:13px;'><strong> Blâme </strong></td>
        <td color='#fff' bgcolor='#46D1FD' style='font-size:13px;'><strong> Conduite </strong></td>
        <td color='#fff' bgcolor='#46D1FD' style='font-size:13px;'><strong> Un effort s'impose en  </strong></td>
        <td color='#fff' bgcolor='#46D1FD' style='font-size:13px;'><strong> Absence</strong></td>
    </tr>
      <tr style="display:none;">
        <td colspan="*">

                <tr>

                    <td valign='top' style='font-size:12px;'></td>
                    <td valign='top' style='font-size:12px;'> <br> </td>
                    <td valign='top' style='font-size:10px;'>

                        @foreach ( $matiere as  $eleve )

                         @if ($eleve->valeur<10)

                         {{$eleve->matiere->libelle.''.''.''.''.''.''}}

                         @endif

                        @endforeach <br><br>

                    </td>
                    <td valign='top' style='font-size:12px;'> 10 heure(s)</td>


                </tr>


        </td>
      </tr>
</table>



<br><br>

<table width='50%' cellspacing='0' cellpadding='2' border='0.001' bordercolor='#CCCCCC'>
    <tr>

        <td color='#fff' bgcolor='#46D1FD' style='font-size:13px;'><strong> Decision </strong></td>
        <td color='#fff' bgcolor='#46D1FD' style='font-size:13px;'><strong>Tableau d'honneur </strong></td>
        <td color='#fff' bgcolor='#46D1FD' style='font-size:13px;'><strong>Exclu </strong></td>

    </tr>
      <tr style="display:none;">
        <td colspan="*">

                <tr>

                    <td valign='top' style='font-size:12px;'>

                        @if ($moyenne>=10)

                        <span>
                            Admis(e)
                        </span>

                        @endif

                        @if ($moyenne<10)

                        <span>
                            Echoué(e)
                        </span>

                        @endif

                    </td>


                    <td valign='top' style='font-size:12px;'>


                    @if ($moyenne>=12)

                    <span>
                        Oui
                    </span>

                    @endif

                    @if ($moyenne<12)

                    <span>
                       Non
                    </span>

                    @endif

                    </td>

                    <td>
                        Non
                    </td>


                </tr>


        </td>
      </tr>
</table>


<br><br>


<table width='50%' cellspacing='0' cellpadding='2' border='0.001' bordercolor='#CCCCCC'>
    <tr>

        <td color='#fff' bgcolor='#46D1FD' style='font-size:13px;'><strong> Visa du parent  </strong></td>

    </tr>
      <tr style="display:none;">
        <td colspan="*">

                <tr>

                    <td valign='top' style='font-size:12px;'> <br>
                    <br>
                    <br>

                    </td>

                </tr>


        </td>
      </tr>
</table>




</body>
</html>
