<?php
namespace Nichin79\Zendesk;

use Nichin79\Curl\Curl;

class Search
{
  protected array $payload = [];
  public function __construct(array $payload)
  {
    $this->payload = $payload;
  }

  public function search(array $params)
  {
    $payload = $this->payload;
    $payload['method'] = 'GET';
    $payload['url'] = 'https://' . $payload['subdomain'] . '.zendesk.com/api/v2/search.json?' . http_build_query($params);
    return Curl::exec($payload);
  }

  public function count(array $params)
  {
    $payload = $this->payload;
    $payload['method'] = 'GET';
    $payload['url'] = 'https://' . $payload['subdomain'] . '.zendesk.com/api/v2/search/count?' . http_build_query($params);
    return Curl::exec($payload);
  }

  public function export(array $params)
  {
    $payload = $this->payload;
    $payload['method'] = 'GET';
    $payload['url'] = 'https://' . $payload['subdomain'] . '.zendesk.com/api/v2/search/export?' . http_build_query($params);
    return Curl::exec($payload);
  }
}