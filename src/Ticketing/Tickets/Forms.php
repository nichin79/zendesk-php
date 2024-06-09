<?php
namespace Nichin79\Zendesk\Ticketing\Tickets;

use Nichin79\Curl\BasicCurl;

class Forms
{
  protected array $data = [];

  public function __construct(array $data)
  {
    $this->data = $data;
  }

  public function list(array $params = [])
  {
    $data = $this->data;
    $data['url'] = sprintf('%s/ticket_forms?%s', $data['baseurl'], http_build_query($params));
    return new BasicCurl($data);
  }

  public function show(int $formId)
  {
    $data = $this->data;
    $data['url'] = sprintf('%s/ticket_forms/%s.json', $data['baseurl'], $formId);
    return new BasicCurl($data);
  }

  public function show_many(array $formIds)
  {
    $data = $this->data;
    $data['url'] = sprintf('%s/ticket_forms/show_many.json?ids%s', $data['baseurl'], implode(',', $formIds));
    return new BasicCurl($data);
  }

  public function create(string $body)
  {
    $data = $this->data;
    $data['method'] = 'POST';
    $data['url'] = sprintf('%s/ticket_forms.json', $data['baseurl']);
    $data['data'] = $body;
    return new BasicCurl($data);
  }

  public function update(int $formId, string $body)
  {
    $data = $this->data;
    $data['method'] = 'PUT';
    $data['url'] = sprintf('%s/ticket_forms/%s.json', $data['baseurl'], $formId);
    $data['data'] = $body;
    return new BasicCurl($data);
  }

  public function delete(int $formId)
  {
    $data = $this->data;
    $data['method'] = 'DELETE';
    $data['url'] = sprintf('%s/ticket_forms/%s.json', $data['baseurl'], $formId);
    return new BasicCurl($data);
  }

  public function clone (int $formId)
  {
    $data = $this->data;
    $data['method'] = 'POST';
    $data['url'] = sprintf('%s/ticket_forms/%s/clone.json', $data['baseurl'], $formId);
    $data['data'] = '{ "prepend_clone_title": true }';
    return new BasicCurl($data);
  }

  public function reorder(array $formIds)
  {
    $data = $this->data;
    $data['method'] = 'PUT';
    $data['url'] = sprintf('%s/ticket_forms/reorder.json', $data['baseurl']);
    $data['data'] = '{"ticket_form_ids": [' . implode(',', $formIds) . ']}';
    return new BasicCurl($data);
  }
}