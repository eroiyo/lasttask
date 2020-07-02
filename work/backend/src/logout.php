<?php

session_start();

session_unset();

session_destroy();

header('Location: /work/frontend/views/index.php');
//just for the logout button in index
?>