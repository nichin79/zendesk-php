<?php
namespace Nichin79\Zendesk\Helpcenter\Helpcenter;

use Nichin79\Curl\BasicCurl;

class Articles
{
  protected array $data = [];

  public function __construct(array $data)
  {
    $this->data = $data;
  }


}