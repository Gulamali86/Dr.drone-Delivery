<?php
session_start();
session_destroy();
header("Location: ../logo.html");
?>