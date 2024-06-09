<?php
namespace Nichin79\Zendesk\Ticketing\Tickets;

use Nichin79\Curl\BasicCurl;

class Fields
{
  protected array $data = [];

  public function __construct(array $data)
  {
    $this->data = $data;
  }

  public function list(array $params = [])
  {
    $data = $this->data;
    $data['url'] = sprintf('%s/ticket_fields.json?%s', $data['baseurl'], http_build_query($params));
    return new BasicCurl($data);
  }

  public function count()
  {
    $data = $this->data;
    $data['url'] = sprintf('%s/ticket_fields/count', $data['baseurl']);
    return new BasicCurl($data);
  }

  public function show(int $fieldId)
  {
    $data = $this->data;
    $data['url'] = sprintf('%s/ticket_fields/%s.json', $data['baseurl'], $fieldId);
    return new BasicCurl($data);
  }

  public function create(array $body)
  {
    $data = $this->data;
    $data['method'] = 'POST';
    $data['url'] = sprintf('%s/ticket_fields.json', $data['baseurl']);
    $data['data'] = $body;
    return new BasicCurl($data);
  }

  public function update(int $fieldId, string $body)
  {
    $data = $this->data;
    $data['method'] = 'PUT';
    $data['url'] = sprintf('%s/ticket_fields/%s.json', $data['baseurl'], $fieldId);
    $data['data'] = $body;
    return new BasicCurl($data);
  }

  public function delete(int $fieldId)
  {
    $data = $this->data;
    $data['method'] = 'DELETE';
    $data['url'] = sprintf('%s/ticket_fields/%s.json', $data['baseurl'], $fieldId);
    return new BasicCurl($data);
  }

  public function options(int $fieldId)
  {
    $data = $this->data;
    $data['url'] = sprintf('%s/ticket_fields/%s/options.json', $data['baseurl'], $fieldId);
    return new BasicCurl($data);
  }

  public function show_option(int $fieldId, int $optionId)
  {
    $data = $this->data;
    $data['url'] = sprintf('%s/ticket_fields/%s/options/%s.json', $data['baseurl'], $fieldId, $optionId);
    return new BasicCurl($data);
  }

  public function create_or_update_option(int $fieldId, string $body)
  {
    $data = $this->data;
    $data['method'] = 'POST';
    $data['url'] = sprintf('%s/ticket_fields/%s/options.json', $data['baseurl'], $fieldId);
    $data['data'] = $body;
    return new BasicCurl($data);
  }

  public function delete_option(int $fieldId, int $optionId)
  {
    $data = $this->data;
    $data['method'] = 'DELETE';
    $data['url'] = sprintf('%s/ticket_fields/%s/options/%s.json', $data['baseurl'], $fieldId, $optionId);
    return new BasicCurl($data);
  }
}