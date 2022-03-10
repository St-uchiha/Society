<?php require_once('_header.phtml'); ?>


<div class="header">
  <h1 class="white"><?= TITLE ?></h1>
  <?php if(isset($_SESSION['user'])): ?>
  <p>Salut <?= $_SESSION['user']['firstName'] ?> </p>
  <?php endif; ?>
</div>

<?= $content ?>
    


    
<?php require_once('_footer.phtml'); ?>



