<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>

    <h3 style="color:rgb(0, 60, 255)"> ABSENCE EN COUR </h3>

    <h4> Mr/Mme {{ $data['nomParent'] }} </h4>

    <span>
        <h1> <strong>{{ $data['nomEcole'] }} </strong> , </h1>
    </span>


    <p> Vous informe que votre enfant <span style="font-weight: bold"> {{ $data['nomEleve'] }}
            {{ $data['prenomEleve'] }} </span>

        a été absent(e) au cour de <span style="font-weight: bold"> {{ $data['matiere'] }} </span> le

        <span style="font-weight: bold"> {{ $data['dateCour'] }}</span> à <span
            style="font-weight: bold">{{ $data['heureCour'] }} </span>.Ce cour a durée

        <span style="font-weight: bold"> {{ $data['duree'] }} heure(s)</span>

    </p>

    <P></P>
    <P></P>
    <P></P>
    <P></P>
    <P></P>
    <P></P>
    <P></P>
    <P></P>
    <P></P>





</body>

</html>
