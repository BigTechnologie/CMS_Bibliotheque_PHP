<?php
require_once '../security/security.php';

require_once '../../helper/request.php';
require_once '../../helper/bdd.php';

// Recuperation de la valeur du paramètre de requete
$query = query('q');
$field = query('field');
// On recupère la valeur du paramètre de requête 'sort' en utilisant la fonction query()
$sort = query('sort', "asc");

// connection à la base de données
$c = connection();

// On verifie si le parametre 'q' existe dans la chaine de requête
$sql = "SELECT id, titre, date_parution FROM livre";

if($query != null) {  
    $sql .= " WHERE titre LIKE '%".mysqli_real_escape_string($c, $query)."%'"; 
}

if($field != null && $sort != null) {
    if($sort != "asc" && $sort != "desc") {
        $sort = "asc";
    }

    $sql .= " ORDER BY ".mysqli_real_escape_string($c, $field)." ".mysqli_real_escape_string($c, $sort); 
}

// On execute la requete SQL 
$result = mysqli_query($c, $sql);
// On recupère tous les resultats de la requete sous forme d'un tableau associatif
$livres = mysqli_fetch_all($result, MYSQLI_ASSOC); 

$fmt = datefmt_create('fr_FR', IntlDateFormatter::FULL, IntlDateFormatter::NONE); 



require '../header.php'; ?>

<h2>Liste des livres</h2>

<form method="get" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    <div class="input-group mb-3">
        <input type="search" name="q" class="form-control" aria-label="Rechercher par le titre"
               placeholder="Rechercher par le titre" value="<?php echo $query; ?>" />
        <?php if($query): ?>
        <a href="/bibliotheque/livre/" class="btn btn-outline-secondary">Réinitialiser le filtre</a>
        <?php endif ?>
        <button class="btn btn-outline-secondary">Rechercher</button>
    </div>
</form>

<table class="table">
    <thead>
    <tr>
        <th>Numero</th>
        <th>Titre Du Livre</th>
        <th>
            <a href="<?php echo $_SERVER['PHP_SELF']; ?>?field=date_parution&sort=<?php echo $sort === "asc" ? "desc": "asc" ?>">
                Date de parution
            </a>
        </th>
        <th></th>
    </tr>
    </thead>
    <tbody>
    <?php if($livres): ?>
        <?php foreach ($livres as $livre): ?>
        <tr>
            <td><?php echo htmlentities($livre['id']); ?></td>
            <td><?php echo htmlentities($livre['titre']); ?></td>
            <td><?php echo $livre['date_parution'] != null ? datefmt_format($fmt, date_create($livre['date_parution'])) : '-'; ?></td>
            <td class="text-end">
                <a href="/bibliotheque/livre/detail.php?id=<?php echo $livre['id'] ?>">Détail</a> -
                <a href="/bibliotheque/livre/modifier.php?id=<?php echo $livre['id'] ?>">Modifier</a> -
                <a href="/bibliotheque/livre/supprimer.php?id=<?php echo $livre['id'] ?>">Supprimer</a>
            </td>
        </tr>
        <?php endforeach; ?>
    <?php else: ?>
        <tr>
            <td colspan="4" class="text-center">Aucun livre</td>
        </tr>
    <?php endif; ?>
    </tbody>
</table>

<?php require '../footer.php'; ?>
