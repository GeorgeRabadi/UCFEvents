<?php

session_start();

if (!isset($_SESSION['userID'])){  
    header("Location: registration/register.php");
    die;}
else{
echo "<script>You are now Logged in!<script>alert";
header("Location: homepage/homepage.php");}


?>