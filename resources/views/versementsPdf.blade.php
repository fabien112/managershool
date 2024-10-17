<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'https://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
<html xmlns='https://www.w3.org/1999/xhtml'>
<head>
<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
<body style='font-family:Tahoma;font-size:12px;color: #5a4f4f;background-color:#FFFFFF;'>
<div style="border: solid black 0.5px;marging:5px;padding:5px">

 <table width='100%' cellspacing='0' cellpadding='0'>
    <tr>
        <td valign='top' width='25%' style='font-size:8px;'> <strong >

            République du CAMEROUN </strong> <br />

            Paix-Travail-Patrie <br>

            <strong> Ministeres des enseignements secondaires <br /> </strong>

            Arrondissement   <strong> {{$classeName->villeEtab}} </strong> <br>

          <img style="width: 50px"src="{{public_path("/images/drapeau-cameroun.jpg")}}" alt="">

        </td>
      <td valign='top' width='45%'>

        <div align='center'>
            <img src="{{public_path("/Photos/Logos/".$classeName->logoEtab)}}" style="border-radius:50%;height:80px;width:80px" />
      </div>

      </td>

      <td valign='top' width='15%' style='font-size:12px;'> Année scolaire : <strong> {{$VersementsData->session}}</strong>

        <br/>

        <strong> {{$classeName->libelleEtab}}</strong>

      </td>


  </tr>
</table>
</div>

<br>

<h2 style="text-align:center; text-decoration:underline;"> RECU DU VERSEMENT  {{strtoupper($VersementsData->motif)}} </h2> <br><br>


<div style="border: solid black 0.5px;marging:25px;padding:20px;">


    <h2 style="text-align:center">  <strong> N<sup>o</sup> {{$VersementsData->code}} </strong>  </h2> <br>


    <table  width='100%' cellspacing='0' cellpadding='0'>

        <tr>

          <td valign='top' width='65%' style='font-size:15px;'>


            Date et heure  du versement   <br>
            Deposant                 <br>
            Reception                <br>
            Somme versée             <br>
            Mode de versement        <br>
            Payement pour l'élève

          </td>

          <td valign='top' width='5%' style='font-size:15px;'>

           : <br> : <br> : <br> : <br> : <br> : <br>

          </td>

          <td width='75%' style='font-size:15px;'>


                                      {{$VersementsData->date}}  <br>
                                      {{$VersementsData->deposant}}   <br>
                                      {{$VersementsData->receptionneur}} <br>
                                      {{$VersementsData->montantverser}} FCFA  <br>
                                      {{$VersementsData->mode}} <br>
                                      {{$VersementsData->student->nom}} {{$VersementsData->student->prenom}} en classe de {{$VersementsData->classe->libelleClasse}}

        </td>

      </tr>
    </table>

</div> <br> <br>

<table width='100%' cellspacing='0' cellpadding='0'>
    <tr>
      <td valign='top' width='45%' style='font-size:10px;font-style: italic;'> <strong >

          Ce document est valide uniquement l'année en cours  </strong>
      </td>
      <td valign='top' width='45%'>



      </td>
      <td valign='top' width='20%' style='font-size:10px;'>

         Visa  du  chef d'etablissement

      </td>

  </tr>
</table>
</body>
</html>
