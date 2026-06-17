<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

    <select name="" id="" >
        
        <option value="">Produit</option>
        <option value="">Produit</option>
        <option value="">Produit</option>


    <?php foreach($produits as $produit): ?>
         <option value="<?= $produit['id'] ?>"><?= $produit['libelle'] ?></option>
    <?php endforeach; ?>
        
    </select>

    <table border="1">

    <tr>
        <th>ID</th>
        <th>Désignation</th>
        <th>Catégorie</th>
    </tr>

    <?php foreach($produits as $produit): ?>

        <tr>
            <td><?= $produit['id'] ?></td>

            <td><?= $produit['designation'] ?></td>

            <td><?= $produit['libelle'] ?></td>
        </tr>

    <?php endforeach; ?>

    
    
</body>
</html>


<!-- /*

saisie achat ::


selectionner le produit

entrer quantite

puis valider 


Tableaux :

Produit .Prix_Unitaire,Quantite ,Montant


Produit 
*/ -->