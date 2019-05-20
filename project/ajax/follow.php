<?php

/* FEATURE 12 klikken op  username voor detailpagina + “follow” */
//	Wat is je empty state als je nog geen vrienden volgt? Bedenk een goede oplossing

// https://vimeo.com/showcase/5967979/video/334691780

require_once __DIR__.'/../bootstrap.php';  // import Classes
//require_once '../classes/User.class.php';
//require_once 'bootstrap.php';

$friendid = $_POST['id']; // komt van front-end
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

echo json_encode($res); //json terug geven als formaat
