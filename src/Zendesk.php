<?php
namespace Nichin79\Zendesk;

use Nichin79\Curl\BasicCurl;

class Zendesk
{
  protected array $data = [];

  public Tickets $tickets;
  public Search $search;
  public Users $users;

  public function __construct(array $conf)
  {
    $this->data['subdomain'] = $conf['subdomain'];

    if ((isset($conf['user']) && !empty($conf['user'])) && (isset($conf['pass']) && !empty($conf['pass']))) {
      $this->data['options']['userpwd'] = $conf['user'] . ':' . $conf['pass'];
    }

    if ((isset($conf['user']) && !empty($conf['user'])) && (isset($conf['token']) && !empty($conf['token']))) {
      $this->data['options']['userpwd'] = $conf['user'] . '/token:' . $conf['token'];
    }

    $this->tickets = new Tickets($this->data);
    $this->search = new Search($this->data);
    $this->users = new Users($this->data);
  }

  public function tickets()
  {
    $data = $this->data;
    $data['method'] = 'GET';
    $data['url'] = 'https://' . $data['subdomain'] . '.zendesk.com/api/v2/tickets/';
    return new BasicCurl($data);
  }

  public function users()
  {
    $data = $this->data;
    $data['method'] = 'GET';
    $data['url'] = 'https://' . $data['subdomain'] . '.zendesk.com/api/v2/users';
    return new BasicCurl($data);
  }
}