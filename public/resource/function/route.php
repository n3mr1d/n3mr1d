<?php 
function route(){
    $url = $_SERVER['REQUEST_URI'];
    if($url == "/"){
        showhome();
    }
}