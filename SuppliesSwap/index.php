<?php
$titre = "";

require 'header.php';
?>

<script src="js/index.js" defer></script>

   <script src="https://cdnjs.cloudflare.com/ajax/libs/Glide.js/3.6.0/glide.min.js" integrity="sha512-2sI5N95oT62ughlApCe/8zL9bQAXKsPPtZZI2KE3dznuZ8HpE2gTMHYzyVN7OoSPJCM1k9ZkhcCo3FvOirIr2A==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
   <link href="https://fonts.googleapis.com/css2?family=Ubuntu+Mono&display=swap" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.gstatic.com">

<link rel="stylesheet" href="css/general.css">
<link rel="stylesheet" href="css/accueil.css">
<link rel="stylesheet" href="css/index.css">
<link rel="stylesheet" href="css/commentaire.css">

<body>
<section class="presentation">
    <p>
    <?php echo _("Bienvenue sur Supplies Swap, la plateforme incontournable pour échanger et acquérir des fournitures scolaires de manière simple et efficace au sein du Cégep de Matane !"); ?>
    </p>
    <p>
    <?php echo _("Faites partie de cette communauté dynamique qui valorise l'échange et la solidarité étudiante."); ?>
    </p>
    <p>
    <?php echo _("N'hésitez pas à parcourir les différentes pages afin de découvrir tous nos services !"); ?>
    </p>

</section>



<!-- Categorie -->
<div class="catégories">
            <div class="catégorie">
                <img src="images/math-icon.png" alt="Mathématiques">
                <p class="titre"><?php echo _("Mathématiques"); ?></p>
        
            </div>
            <div class="catégorie">
                <img src="images/litterature_icon.png" alt="Littérature">
                <p class="titre"><?php echo _("Littérature"); ?></p>
              
            </div>
            <div class="catégorie">
                <img src="images/anglais_icon.png" alt="Anglais">
                <p class="titre"><?php echo _("Anglais"); ?></p>
            
            </div>
            <div class="catégorie">
                <img src="images/physique_icon.png" alt="Physique">
                <p class="titre"><?php echo _("Physique"); ?></p>
              
            </div>
            <div class="catégorie">
                <img src="images/chimie_icon.png" alt="Chimie">
                <p class="titre"><?php echo _("Chimie"); ?></p>
            </div>
            
            </div>
        </div>
    </div>

 
<!-- Carrousel -->
<div class="carousel-wrapper"> 
  <button id="prevBtn"><</button>
  <div class="carousel-container">
    <div class="carousel-slide">
   
        <img src="images/conteEnfant.jpg" alt="Image 1 ">
        <img src="images/lire.jpg" alt="Image 2">
        <img src="images/Sac.jpg" alt="Image 3">
    </div>
</div>
<button id="nextBtn">></button>

</div>

<script src="scripts/carousel.js"></script>

<div class="text-center">
<?php if (!isset($_SESSION['membre']['nom'])) { ?>
    <a href="authentification.php">
        <button class="btn-commentaire"><?php echo _("Laissez un commentaire"); ?></button>
    </a> 
<?php } else { ?>
    <a href="commentaire.php">
        <button class="btn-commentaire"><?php echo _("Laissez un commentaire"); ?></button>
    </a>
<?php } ?>
</div>

</body>



<?php include 'footer.php'; ?>