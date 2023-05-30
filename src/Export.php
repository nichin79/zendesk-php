<?php
namespace Nichin79\Zendesk;

use Nichin79\Curl\Curl;

class Export
{
  protected array $payload = [];
  public function __construct(array $payload)
  {
    $this->payload = $payload;
  }

  public function tickets(array $params)
  {
    $params['filter[type]'] = 'ticket';

    $payload = $this->payload;
    $payload['method'] = 'GET';
    $payload['url'] = 'https://' . $payload['subdomain'] . '.zendesk.com/api/v2/search/export?' . http_build_query($params);

    return Curl::exec($payload);
  }
}