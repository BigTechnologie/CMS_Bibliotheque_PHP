<?php
require_once '../security/security.php';

require_once '../../helper/form_helper.php';
require_once '../../helper/bdd.php';
require_once '../../helper/response.php';
require_once '../../validator/validators.php';
require_once '../../helper/request.php';
require_once '../../helper/session.php';

// permet de se connecter à la BD
$c = connection(); 
// On intancie un tableau vide d'erreurs
$errors = [];      

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $titre = request('titre');
    $resume = request('resume');
    $date_parution = request('date_parution');

    if (!notBlank($titre)) {
        $errors['titre'][] = "Le titre est obligatoire";
    }

    if (count($errors) === 0) {  //
        // https://www.php.net/manual/fr/datetime.format.php
        if($date_parution != null) {
            $date_parution = date_format(date_create($date_parution), 'Y-m-d');
        }

        // mysqli_real_escape_string: protection contre les injections SQL
        $titre = mysqli_real_escape_string($c, $titre);
        $resume = mysqli_real_escape_string($c, $resume);
        $date_parution = mysqli_real_escape_string($c, $date_parution);

        $sql = "INSERT INTO livre (`titre`, `resume`, `date_parution`) VALUE ('".$titre."'";
        $sql .= ($resume != null) ? ", '".$resume."'" : ", NULL";
        $sql .= ($date_parution != null) ? ", '".$date_parution."'" : ", NULL";
        $sql .= ")";

        mysqli_query($c, $sql);
        mysqli_close($c);

        create_message_flash('success', 'Le livre a bien été ajouté');

        // pattern Post-redirect-get (redirection)
        redirect('/bibliotheque/livre/index.php');
    }
}

require '../header.php' ?>

<h2>Ajouter un livre</h2>

<form method="post" action="">
    <div class="mb-3">
        <label for="titre" class="form-label">Titre: </label>
        <input type="text" class="form-control" id="titre" name="titre"
               placeholder="Titre du livre" value=""/>
        <?php echo form_errors('titre', $errors); ?> 
    </div>
    <div class="mb-3">
        <label for="resume" class="form-label">Résumé: </label>
        <textarea name="resume" id="resume" class="form-control" placeholder="Résumé du livre"></textarea>
    </div>
    <div class="mb-3">
        <label for="date_parution" class="form-label">Date de parution: </label>
        <input type="date" class="form-control" id="date_parution" name="date_parution" value=""/>
    </div>

    <button class="btn btn-outline-primary">Ajouter</button>
</form>

<?php require '../footer.php' ?>
