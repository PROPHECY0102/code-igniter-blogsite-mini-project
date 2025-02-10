<?php

class Pages extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->library("session");
    $this->load->model("user_model");
    $this->load->library("auth");
  }

  public function view($page = 'home')
  {
    if (!file_exists(APPPATH . 'views/pages/' . $page . '.php')) {
      show_404();
    }

    $data["auth"] = $this->auth->login_info;

    $data["title"] = "Home";
    $this->load->view('templates/header', $data);
    $this->load->view("pages/$page", $data);
    $this->load->view('templates/footer', $data);
  }
}
