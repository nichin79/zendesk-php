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

    foreach (Zendesk::get_modules($this->data['modules']) as $module) {
      switch ($module) {
        case 'tickets';
          $this->tickets = new Tickets($this->data);
          break;
        case 'search';
          $this->search = new Search($this->data);
          break;
        case 'users';
          $this->users = new Users($this->data);
          break;
      }
    }
  }

  public static function get_modules(array $array)
  {
    $modules = [];
    foreach ($array as $key => $value) {
      if (gettype($array[$key]) === 'array') {
        $modules[] = strtolower($key);
      }

      if (gettype($array[$key]) === 'string') {
        $modules[] = strtolower($value);
      }
    }
    return $modules;
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