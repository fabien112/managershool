<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'https://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
<html xmlns='https://www.w3.org/1999/xhtml'>
<head>
<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
<body style='font-family:Tahoma;font-size:12px;color: #5a4f4f;background-color:#FFFFFF;'>
<div style="border: solid black 0.5px;marging:5px;padding:5px">
 <table width='100%' cellspacing='0' cellpadding='0' >
    <tr>
        <td valign='top' width='25%' style='font-size:8px;'> <strong >

            République du CAMEROUN </strong> <br />

            Paix-Travail-Patrie <br>

            <strong> Ministeres des enseignements secondaires <br /> </strong>

            Arrondissement   <strong> {{$classeName->villeEtab}} </strong> <br>

          <img style="width:30px" src="{{public_path("/images/drapeau-cameroun.jpg")}}" alt="">

        </td>
      <td valign='top' width='45%'>

        <div align='center'>
            <img src="{{public_path("/Photos/Logos/".$classeName->logoEtab)}}" style="border-radius:50%;height:80px;width:80px" />
      </div>

      </td>
      <td valign='top' width='20%' style='font-size:12px;'> Année scolaire : <strong> {{$EleveData[0]->session}}</strong>
        <br/>
        Classe : <strong>  {{$EleveData[0]->Classe->libelleClasse}} </strong> <br>

        Effectif : <strong> {{count($EleveData)}} </strong>


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
               <h3> {{$classeName->libelleEtab}} </h3>

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

        <div align='center'>
            <h5 style="border: solid black 0.5px;marging:5px;padding:5px; border-radius:10px;">  LISTE DE LA CLASSE : <strong>  {{$EleveData[0]->Classe->libelleClasse}}  </strong>  </h5>
        </div>

      </td> <br>
      <td valign='top' width='20%' style='font-size:12px;'>

      </td>

  </tr>
</table>
<table width='100%' cellspacing='0' cellpadding='2' border='0.5' bordercolor='#CCCCCC'>
    <tr>
        <td bordercolor='#ccc' bgcolor='#46D1FD' style='font-size:15px;'><strong> Numéros</strong></td>

      <td bordercolor='#ccc' bgcolor='#46D1FD' style='font-size:15px;'><strong> Noms et  Prénoms</strong></td>
      <td width='35%' bordercolor='#ccc' bgcolor='#46D1FD' style='font-size:15px;'><strong> Statut </strong></td>


      </tr>
    <tr style="display:none;">
        <td colspan="*">

            @foreach ($EleveData as  $key => $eleve )



                <tr>



                    <td valign='top' style='font-size:12px;'> {{$key+1}}  </td>

                    <td valign='top' style='font-size:12px;'>{{$eleve->nom}} {{$eleve->prenom}}</td>

                    <td valign='top' style='font-size:12px;'> {{$eleve->doublant}}  </td>
                </tr>


            @endforeach

        </td>
   </tr>


</table>
</body>
</html>
