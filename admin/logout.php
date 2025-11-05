<?php
    include_once('./config/all.php');

    session_destroy();

    Func::LinkTo("./login");