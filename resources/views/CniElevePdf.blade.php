<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'https://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
<html xmlns='https://www.w3.org/1999/xhtml'>
<head>
<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
<body style='font-family:Tahoma;font-size:12px;color: #5a4f4f;background-color:#FFFFFF;'>
<div style="border: solid black 0.5px;marging:5px;padding:5px">

 <table width='100%' cellspacing='0' cellpadding='0'>
    <tr>
      <td valign='top' width='30%' style='font-size:8px;'> <strong >

          République du CAMEROUN </strong> <br />

          Paix-Travail-Patrie <br>

          <strong> Ministeres des enseignements secondaires <br /> </strong>

          Arrondissement   <strong> {{$classeName->villeEtab}} </strong> <br>

        <img style="width:50px"src="{{public_path("/images/drapeau-cameroun.jpg")}}" alt="">

      </td>
      <td valign='top' width='45%'>

        <div align='center'>
            <img  src="{{public_path("/Photos/Logos/".$classeName->logoEtab)}}" style="border-radius:50%;height:80px;width:80px"/>
      </div>

      </td>
      <td valign='top' width='20%' style='font-size:8px;'>  <strong> {{$classeName->libelleEtab}} </strong> <br>

         <strong> {{$classeName->sloganEtab}} </strong> <br>
         <strong> Année scolaire :   {{$EleveData->session}}  </strong> <br>

      </td>

  </tr>
</table>
</div>

<div style="border: solid black 0.5px;marging:5px;padding:5px">

    <table width='100%' cellspacing='0' cellpadding='0'>
       <tr>
         <td valign='top' width='25%' style='font-size:13px;'> <strong >


         </td>
         <td valign='top' width='45%'>

           <div align='center'>
               <h3> CARTE D'IDENTITE SCOLAIRE  </h3>
           </div>

         </td>
         <td valign='top' width='20%' style='font-size:12px;'>

         </td>

     </tr>
   </table>
</div>

<table width='100%' cellspacing='0' cellpadding='0'>
    <tr>
      <td valign='top' width='25%' style='font-size:13px;'> <strong >


      </td>
      <td valign='top' width='45%'>

        <div align='center' >
            <h4 style="border: solid black 0.5px;marging:5px;padding:5px; border-radius:10px;background-color: rgb(221, 219, 219)">   <strong>   Session :  <strong>{{$EleveData->session}} </strong>  </h5>
        </div>

      </td> <br>
      <td valign='top' width='20%' style='font-size:12px;'>

      </td>

  </tr>
</table>

<div style="border: solid black 0.5px;marging:55px;padding:35px;border-radius:50px;">

    <table  width='100%' cellspacing='0' cellpadding='0'>
        <tr>


          <td valign='top' width='45%' style='font-size:10px;'>

            <img  style="width: 135px;height:135px" src="{{public_path("/Photos/Logos/".$EleveData->user->photo)}}" >

          </td>

          <td valign='top' width='65%' style='font-size:12px;'>

            Nom et   Prénom       : <strong> {{$EleveData->nom}}  {{$EleveData->prenom}} </strong>  <br>
            Matricule :  <strong> {{$EleveData->matricule}} </strong> <br>
            Date et lieu de naissance      : <strong> {{$EleveData->dateNaiss}}  à  {{$EleveData->lieuNaiss}} </strong> <br>
            Sexe      : <strong> {{$EleveData->sexe}}</strong> <br>
            Classe    : <strong> {{$EleveData->Classe->libelleClasse}} </strong> <br>
            Email     : <strong> {{$EleveData->email}}</strong> <br>
            Nom du parent    : <strong> {{$EleveData->Parent->nomParent}} {{$EleveData->Parent->prenomParent}}</strong> <br>
            Téléphone du parent    : <strong> {{$EleveData->Parent->telParent}} </strong> <br>
            Profession  du parent    : <strong> {{$EleveData->Parent->professionParent}} </strong> <br>

          </td>

      </tr>
    </table>

</div>
<br>

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
