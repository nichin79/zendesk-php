<?php
namespace Nichin79\Zendesk\Ticketing\Tickets;

use Nichin79\Curl\BasicCurl;

class Comments
{
  protected array $data = [];

  public function __construct(array $data)
  {
    $this->data = $data;
  }

  public function list(int $ticketId)
  {
    $data = $this->data;
    $data['url'] = sprintf('%s/tickets/%s/comments', $data['baseurl'], $ticketId);
    return new BasicCurl($data);
  }

  public function count(int $ticketId)
  {
    $data = $this->data;
    $data['url'] = sprintf('%s/tickets/%s/comments/count.json', $data['baseurl'], $ticketId);
    return new BasicCurl($data);
  }

  public function make_private(int $ticketId, int $commentId)
  {
    $data = $this->data;
    $data['method'] = 'PUT';
    $data['url'] = sprintf('%s/tickets/%s/comments/%s/make_private', $data['baseurl'], $ticketId, $commentId);
    $data['data'] = '{}';
    return new BasicCurl($data);
  }

  public function comment_redactions(int $commentId, string $body)
  {
    $data = $this->data;
    $data['method'] = 'PUT';
    $data['url'] = sprintf('%s/comment_redactions/%s', $data['baseurl'], $commentId);
    $data['data'] = $body;
    return new BasicCurl($data);
  }

  public function chat_redactions(int $ticketId, string $body)
  {
    $data = $this->data;
    $data['method'] = 'PUT';
    $data['url'] = sprintf('%s/chat_redactions/%s', $data['baseurl'], $ticketId);
    $data['data'] = $body;
    return new BasicCurl($data);
  }

  public function chat_file_redactions(int $ticketId)
  {
    $data = $this->data;
    $data['method'] = 'PUT';
    $data['url'] = sprintf('%s/chat_file_redactions/%s', $data['baseurl'], $ticketId);
    return new BasicCurl($data);
  }

  public function redact_string(int $ticketId, int $commentId, string $body)
  {
    $data = $this->data;
    $data['method'] = 'PUT';
    $data['url'] = sprintf('%s/tickets/%s/comments/%s/redact.json', $data['baseurl'], $ticketId, $commentId);
    $data['data'] = $body;
    return new BasicCurl($data);
  }
}