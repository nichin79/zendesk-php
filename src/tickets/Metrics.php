<?php
namespace Nichin79\Zendesk\Tickets;

use Nichin79\Curl\BasicCurl;

class Metrics
{
  protected array $data = [];

  public function __construct(array $data)
  {
    $this->data = $data;
  }

  public function list()
  {
    $data = $this->data;
    $data['url'] = sprintf('%s/ticket_metrics', $data['baseurl']);
    return new BasicCurl($data);
  }

  public function show(int $metricId)
  {
    $data = $this->data;
    $data['url'] = sprintf('%s/ticket_metrics/%s', $data['baseurl'], $metricId);
    return new BasicCurl($data);
  }
}