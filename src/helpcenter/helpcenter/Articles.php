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

  public function list(string $locale = null, int $category_id = null, int $section_id = null, int $user_id = null, int $start_time = null)
  {
    $data = $this->data;

    $data['url'] = sprintf('%s/help_center/articles', $data['baseurl']);

    if ($locale && $category_id) {
      $data['url'] = sprintf('%s/help_center/%s/categories/%s/articles', $data['baseurl'], $locale, $category_id);
    }

    if ($locale && $section_id) {
      $data['url'] = sprintf('%s/help_center/%s/sections/%s/articles', $data['baseurl'], $locale, $section_id);
    }

    if ($locale) {
      $data['url'] = sprintf('%s/help_center/%s/articles', $data['baseurl'], $locale);
    }

    if ($category_id) {
      $data['url'] = sprintf('%s/help_center/categories/%s/articles', $data['baseurl'], $category_id);
    }

    if ($section_id) {
      $data['url'] = sprintf('%s/help_center/sections/%s/articles', $data['baseurl'], $section_id);
    }

    if ($user_id) {
      $data['url'] = sprintf('%s/help_center/users/%s/articles', $data['baseurl'], $user_id);
    }

    if ($start_time) {
      $data['url'] = sprintf('%s/help_center/incremental/articles?start_time=%s', $data['baseurl'], $start_time);
    }

    return new BasicCurl($data);
  }

  public function show(int $article_id, string $locale = null)
  {
    $data = $this->data;

    $data['url'] = sprintf('%s/help_center/articles/%s', $data['baseurl'], $article_id);

    if ($locale) {
      $data['url'] = sprintf('%s/help_center/%s/articles/%s', $data['baseurl'], $locale, $article_id);
    }

    return new BasicCurl($data);
  }

  public function create(int $section_id, string $body, string $locale = null, bool $draft = false, bool $notify_subscribers = true)
  {
    $data = $this->data;

    $params = ['draft' => $draft, 'notify_subscribers' => $notify_subscribers];

    $data['method'] = 'POST';
    $data['url'] = sprintf('%s/help_center/sections/%s/articles?%s', $data['baseurl'], $section_id, http_build_query($params));

    if ($locale) {
      $data['url'] = sprintf('%s/help_center/%s/sections/%s/articles?s', $data['baseurl'], $locale, $section_id, http_build_query($params));
    }

    $data['data'] = $body;
    return new BasicCurl($data);
  }

  public function update(int $article_id, string $body, string $locale = null)
  {
    $data = $this->data;

    $data['method'] = 'PUT';
    $data['url'] = sprintf('%s/help_center/articles/%s', $data['baseurl'], $article_id);

    if ($locale) {
      $data['url'] = sprintf('%s/help_center/%s/articles/%s', $data['baseurl'], $locale, $article_id);
    }

    $data['data'] = $body;
    return new BasicCurl($data);
  }

  public function update_article_source_locale(int $article_id, string $source_locale, string $locale = null)
  {
    $data = $this->data;

    $data['method'] = 'PUT';
    $data['url'] = sprintf('%s/help_center/articles/%s/source_locale', $data['baseurl'], $article_id);

    if ($locale) {
      $data['url'] = sprintf('%s/help_center/%s/articles/%s/source_locale', $data['baseurl'], $locale, $article_id);
    }

    $data['data'] = '{"article_locale": "' . $source_locale . '"}';
    return new BasicCurl($data);
  }

  public function associate_attachments_bulk(int $article_id, array $attachment_ids, string $locale = null)
  {
    $data = $this->data;

    $data['method'] = 'PUT';
    $data['url'] = sprintf('%s/help_center/articles/%s/bulk_attachments', $data['baseurl'], $article_id);

    if ($locale) {
      $data['url'] = sprintf('%s/help_center/%s/articles/%s/bulk_attachments', $data['baseurl'], $locale, $article_id);
    }

    $data['data'] = '{"attachment_ids": "' . implode(', ', $attachment_ids) . '"}';
    return new BasicCurl($data);
  }

  public function archive(int $article_id, string $locale = null)
  {
    $data = $this->data;

    $data['method'] = 'DELETE';
    $data['url'] = sprintf('%s/help_center/articles/%s', $data['baseurl'], $article_id);

    if ($locale) {
      $data['url'] = sprintf('%s/help_center/%s/articles/%s', $data['baseurl'], $locale, $article_id);
    }

    return new BasicCurl($data);
  }
}