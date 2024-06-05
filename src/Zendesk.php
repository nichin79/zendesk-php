<?php
namespace Nichin79\Zendesk;

class Zendesk
{
  protected array $data = [];

  public Ticketing\Tickets $tickets;
  public Ticketing\Search $search;
  public Ticketing\Users $users;
  public Ticketing\Organizations $organizations;
  public Ticketing\Groups $groups;
  public Helpcenter\Helpcenter $helpcenter;

  public string $baseProtocol = "https";
  public string $basePath = ".zendesk.com/api/v2";

  public function __construct(array $conf)
  {
    /* Check for subdomain or throw error */
    if (isset($conf['subdomain']) || !empty($conf['subdomain'])) {
      $this->data['baseprotocol'] = $this->baseProtocol;
      $this->data['basepath'] = $this->basePath;
      $this->data['subdomain'] = $conf['subdomain'];
      $this->data['baseurl'] = sprintf('%s://%s%s', $this->baseProtocol, $conf['subdomain'], $this->basePath);
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
        case 'ticketing':
          foreach (Zendesk::get_modules($this->data['modules'][$module]) as $subModule) {
            switch ($subModule) {
              case 'tickets';
                $this->tickets = new Ticketing\Tickets($this->data);
                break;
              case 'search';
                $this->search = new Ticketing\Search($this->data);
                break;
              case 'users';
                $this->users = new Ticketing\Users($this->data);
                break;
              case 'organizations';
                $this->organizations = new Ticketing\Organizations($this->data);
                break;
              case 'groups';
                $this->groups = new Ticketing\Groups($this->data);
                break;
            }
          }
          break;

        case 'helpcenter':
          foreach (Zendesk::get_modules($this->data['modules'][$module]) as $subModule) {
            switch ($subModule) {
              case 'helpcenter';
                $this->helpcenter = new Helpcenter\Helpcenter($this->data);
                break;
            }
          }
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
}