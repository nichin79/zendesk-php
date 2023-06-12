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
    $this->load_modules(__NAMESPACE__, $conf['modules']);
  }

  public function load_modules(string $namespace, mixed $modules)
  {
    foreach ($modules as $key => $value) {
      if (gettype($modules[$key]) === 'array') {
        $this->init_module($namespace, $key);
      }

      if (gettype($modules[$key]) === 'string') {
        $this->init_module($namespace, $value);
      }
    }
  }

  public function init_module(string $namespace, string $module)
  {
    $module = strtolower($module);
    $class = $namespace . '\\' . ucfirst(strtolower($module));
    $this->$module = new $class($this->data);
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