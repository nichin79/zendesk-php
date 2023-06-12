<?php
namespace Nichin79\Zendesk;

use Nichin79\Curl\BasicCurl;

class Search
{
  protected array $data = [];
  public function __construct(array $data)
  {
    $this->data = $data;
  }

  public function search(array $params)
  {
    $data = $this->data;
    $data['url'] = sprintf('%s/search.json?%s', $data['baseurl'], http_build_query($params));
    return new BasicCurl($data);
  }

  public function count(array $params)
  {
    $data = $this->data;
    $data['url'] = sprintf('%s/search/count?%s', $data['baseurl'], http_build_query($params));
    return new BasicCurl($data);
  }

  public function export(array $params)
  {
    $data = $this->data;
    $data['url'] = sprintf('%s/search/export?%s', $data['baseurl'], http_build_query($params));
    return new BasicCurl($data);
  }
}