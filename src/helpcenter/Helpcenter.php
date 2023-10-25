<?php
namespace Nichin79\Zendesk\Helpcenter;

use Nichin79\Curl\BasicCurl;
use Nichin79\Zendesk\Helpcenter\Helpcenter\Articles;

class Users
{
  protected array $data = [];
  public Helpcenter\Articles $articles;

  public function __construct(array $data)
  {
    $this->data = $data;

    foreach (\Nichin79\Zendesk\Zendesk::get_modules($this->data['modules']['helpcenter']['articles']) as $module) {
      switch ($module) {
        case 'articles';
          $this->articles = new Articles($this->data);
          break;
      }
    }
  }

}