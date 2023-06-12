<?php
namespace Nichin79\Zendesk;

class Zendesk
{
  protected array $data = [];

  public Tickets $tickets;
  public Search $search;
  public Users $users;

  public function __construct(array $conf)
  {
    /* Check for subdomain or throw error */
    if (isset($conf['subdomain']) || !empty($conf['subdomain'])) {
      $this->data['baseurl'] = sprintf('https://%s.zendesk.com/api/v2', $conf['subdomain']);
    } else {
      throw new \InvalidArgumentException('Zendesk subdomain missing or not set');
    }

    /* Check for credentials or throw error */
    if ((isset($conf['user']) && !empty($conf['user'])) && (isset($conf['pass']) && !empty($conf['pass']))) {
      $this->data['options']['userpwd'] = $conf['user'] . ':' . $conf['pass'];
    } else if ((isset($conf['user']) && !empty($conf['user'])) && (isset($conf['token']) && !empty($conf['token']))) {
      $this->data['options']['userpwd'] = $conf['user'] . '/token:' . $conf['token'];
    } else {
      throw new \InvalidArgumentException('Zendesk credentials missing or not set');
    }

    $this->data['headers'] = ["Content-Type: application/json"];
    $this->data['modules'] = $conf['modules'];

    foreach ($this->data['modules'] as $key => $value) {
      if (gettype($conf['modules'][$key]) === 'array') {
        $class = ucfirst(strtolower($key));
      }
      if (gettype($conf['modules'][$key]) === 'string') {
        $class = ucfirst(strtolower($value));
      }

      switch ($class) {
        case 'Tickets';
          $this->tickets = new Tickets($this->data);
          break;
        case 'Search';
          $this->search = new Search($this->data);
          break;
        case 'Users';
          $this->users = new Users($this->data);
          break;
      }
    }

  }

  public function tickets()
  {
    return $this->tickets->list();
  }

  public function users()
  {
    return $this->users->list();
  }
}