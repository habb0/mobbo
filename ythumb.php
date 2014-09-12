<?php
// Youtube Thumbail Script
// by bi0s
@header('Content-type: image/jpeg');
@readfile("http://i1.ytimg.com/vi/".$_GET['Video']."/default.jpg");
?>