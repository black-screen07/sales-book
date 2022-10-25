<?php
namespace controller;

use model\User;


/**
 * DashboardController
 */
class DashboardController
{
  function __construct()
  {
    User::isLogOut();
  }

  public function dashboard_view()
  {

    $param = [
      "title" => "Tableau de bord",
      "pIndex" => "dashboard"
    ];

    return _view('dashboard', $param);
  }
}
