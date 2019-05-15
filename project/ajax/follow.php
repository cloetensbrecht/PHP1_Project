<?php

/* FEATURE 12 klikken op  username voor detailpagina + “follow” */
//	Wat is je empty state als je nog geen vrienden volgt? Bedenk een goede oplossing

// https://vimeo.com/showcase/5967979/video/334691780

require_once '/../bootstrap.php';  // import Classes
//require_once '../classes/User.class.php';
//require_once 'bootstrap.php';

$friendid = $_POST[friendid];
if (User::follow($friendid)) {
    $res = [
        'status' => 'succes',
        'message' => 'You are following',
    ];
} else {
    $res = [
        'status' => 'error',
        'message' => 'You are not following',
    ];
}

echo json_decode($res); //json terug geven als formaat
