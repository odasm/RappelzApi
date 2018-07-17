<?php

$router->post('GetShopPoint','Api@GetShopPoint');
$router->post('PlayerShopPoint','Api@PlayerShopPoint');
$router->post('BuyAllItem','Api@BuyAllItem');
$router->post('CreateUser','Api@CreateUser');
$router->post('UpdatePassword','Api@UpdatePassword');
$router->post('GetPlayersRank/{id?}','Api@GetPlayersRank');
$router->post('GetPlayers','Api@GetPlayers');
$router->post('UpdateUserInfo','Api@UpdateUserInfo');
$router->post('DeleteUser','Api@DeleteUser');
$router->post('unDeleteUser','Api@unDeleteUser');
$router->post('GetHome','Api@gethomedata');
$router->post('GetItemInfo','Api@GetItemInfo');