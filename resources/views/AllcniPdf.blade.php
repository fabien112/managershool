

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
                <h4 style="border: solid black 0.5px;marging:5px;padding:5px; border-radius:10px;background-color: rgb(221, 219, 219)">   <strong>   Session :  <strong> </strong>  </h5>
            </div>

          </td> <br>
          <td valign='top' width='20%' style='font-size:12px;'>

          </td>

      </tr>
    </table>
{{--
@endforeach --}}
