<?php

require_once __DIR__.'/../bootstrap.php';

function unFollow() {
  if (empty($_POST['id']))
    return [
     'status' => 'error',
     'message' => 'The friend id is missing',
    ];

  $friendId = $_POST['id'];
  if (!User::isFollowing($friendId))
    return [
      'status' => 'error',
      'message' => 'You are not following this friend'
    ];

  if (!User::unFollow($friendId))
    return [
      'status' => 'error',
      'message' => 'You are still following this friend'
    ];
  
  return [
    'status' => 'success',
    'message' => 'You unfollowed this friend'
  ];
}

exit(json_encode(unFollow()));
