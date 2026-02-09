<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Liste des Objets</h1>
    <ul>
        <?php foreach ($objets as $objet){ ?>
            <li><?= $objet['nom_objet'] ?> </li>
            <li><?= $objet['description_objet'] ?> </li>
            <button><a href="/ch"></a></button>
        <?php } ?>
    </ul>
</body>
</html>