<?php require_once 'core/init.php'; ?>

<footer class="bg-light mt-5 p-2">
    <p class="text-dark text-center">Copyright &copy; Michael Ndue
        <?php 
        $currentDate= new DateTime();
        $year = $currentDate->format("Y");
        echo $year; ?>
</footer>