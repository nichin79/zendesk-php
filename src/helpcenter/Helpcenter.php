<?php
namespace Nichin79\Zendesk\Helpcenter;

use Nichin79\Curl\BasicCurl;
use Nichin79\Zendesk\Helpcenter\Helpcenter\Articles;

class Helpcenter
{
  protected array $data = [];

  public Helpcenter\Articles $articles;

  public function __construct(array $data)
  {
    $this->data = $data;

    foreach (\Nichin79\Zendesk\Zendesk::get_modules($this->data['modules']['helpcenter']['helpcenter']) as $module) {
      switch ($module) {
        case 'articles';
          $this->articles = new Articles($this->data);
          break;
      }
    }
  }

  public function list()
  {
    $data = $this->data;
    $data['url'] = sprintf('%s/help_center/articles', $data['baseurl']);
    return new BasicCurl($data);
  }
}