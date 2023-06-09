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
    $data['method'] = 'GET';
    $data['url'] = 'https://' . $data['subdomain'] . '.zendesk.com/api/v2/search.json?' . http_build_query($params);
    return new BasicCurl($data);
  }

  public function count(array $params)
  {
    $data = $this->data;
    $data['method'] = 'GET';
    $data['url'] = 'https://' . $data['subdomain'] . '.zendesk.com/api/v2/search/count?' . http_build_query($params);
    return new BasicCurl($data);
  }

  public function export(array $params)
  {
    $data = $this->data;
    $data['method'] = 'GET';
    $data['url'] = 'https://' . $data['subdomain'] . '.zendesk.com/api/v2/search/export?' . http_build_query($params);
    return new BasicCurl($data);
  }
}