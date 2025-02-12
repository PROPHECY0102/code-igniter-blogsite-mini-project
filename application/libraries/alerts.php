<?php
defined('BASEPATH') or exit('No direct script access allowed');

class alerts
{
  public function __construct()
  {
    $this->CI = &get_instance();
    $this->CI->load->library("session");
  }

  public function redirect_and_alert($params)
  {
    $this->CI->session->set_flashdata(array(
      "notify" => true,
      "notify_message" => $params['message'] ?? "",
      "notify_type" => $params["type"] ?? "feedback",
      "prev_route" => $params["prev_route"] ?? uri_string()
    ));
    redirect($params["destination"] ?? "");
  }
}
