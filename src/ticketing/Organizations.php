<?php
namespace Nichin79\Zendesk\Ticketing;

use Nichin79\Curl\BasicCurl;

class Organizations
{
  protected array $data = [];
  public function __construct(array $data)
  {
    $this->data = $data;
  }

  /**
   * If the agent has a custom agent role that restricts their access to only users in their own organization, a 403 Forbidden error is returned. See Creating custom agent roles in Zendesk help.
   * @param mixed $user_id
   * @return BasicCurl
   */
  public function list($user_id = null)
  {
    $data = $this->data;
    if ($user_id) {
      $data['url'] = sprintf('%s/users/%s/organizations.json', $data['baseurl'], $user_id);
    } else {
      $data['url'] = sprintf('%s/organizations', $data['baseurl']);
    }
    return new BasicCurl($data);
  }

  /**
   * Returns an approximate count of organizations. If the count exceeds 100,000, it is updated every 24 hours.
   * The refreshed_at property of the count object is a timestamp that indicates when the count was last updated.
   * When the count exceeds 100,000, the refreshed_at property may occasionally be null. This indicates that the count is being updated in the background and the value property of the count object is limited to 100,000 until the update is complete.
   * 
   * @param mixed $user_id
   * @return BasicCurl
   */
  public function count($user_id = null)
  {
    $data = $this->data;
    if ($user_id) {
      $data['url'] = sprintf('%s/users/%s/organizations/count.json', $data['baseurl'], $user_id);
    } else {
      $data['url'] = sprintf('%s/organizations/count', $data['baseurl']);
    }
    return new BasicCurl($data);
  }

  /**
   * Returns an array of organizations whose name starts with the value specified in the name parameter.
   * 
   * @param array $params field_id, name, source
   * @return BasicCurl
   */
  public function autocomplete(array $params = [])
  {
    $data = $this->data;
    $data['url'] = sprintf('%s/organizations/autocomplete?%s', $data['baseurl'], http_build_query($params));
    return new BasicCurl($data);
  }

  /**
   * Returns an array of organizations matching the criteria. You may search by an organization's external_id or name, but not both
   * 
   * @param array $params external_id, name - ['key' => 'value']
   * @return BasicCurl
   */
  public function search(array $params = [])
  {
    $data = $this->data;
    $data['url'] = sprintf('%s/organizations/search?%s', $data['baseurl'], http_build_query($params));
    return new BasicCurl($data);
  }

  /**
   * Returns an organization specified by id
   * 
   * @param int $orgId
   * @return BasicCurl
   */
  public function show(int $orgId)
  {
    $data = $this->data;
    $data['url'] = sprintf('%s/organizations/%s', $data['baseurl'], $orgId);
    return new BasicCurl($data);
  }

  /**
   * Returns an organization's related information
   * 
   * @param int $orgId
   * @return BasicCurl
   */
  public function show_related(int $orgId)
  {
    $data = $this->data;
    $data['url'] = sprintf('%s/organizations/%s/related', $data['baseurl'], $orgId);
    return new BasicCurl($data);
  }

  /**
   * Accepts a comma-separated list of up to 100 organization ids or external ids.
   * 
   * @param array $params ids, external_ids - [ 'ids' => '1,2,3' ]
   * @return BasicCurl
   */
  public function show_many(array $params)
  {
    $data = $this->data;
    $data['url'] = sprintf('%s/organizations/show_many.json?%s', $data['baseurl'], http_build_query($params));
    return new BasicCurl($data);
  }

  /**
   * You must provide a unique name for each organization. Normally the system doesn't allow records to be created with identical names. However, a race condition can occur if you make two or more identical POSTs very close to each other, causing the records to have identical organization names.
   * 
   * @param string $body json formatted string of organization to create
   * @return BasicCurl
   */
  public function create(string $body)
  {
    $data = $this->data;
    $data['method'] = 'POST';
    $data['url'] = sprintf('%s/organizations.json', $data['baseurl']);
    $data['data'] = $body;
    return new BasicCurl($data);
  }

  /**
   * Accepts a json formatted string of up to 100 organization objects.
   * 
   * @param string $body json formatted string of organizations to create
   * @return BasicCurl This endpoint returns a job_status JSON object and queues a background job to do the work. Use the Show Job Status endpoint to check for the job's completion. Only a certain number of jobs can be queued or running at the same time. See Job limit for more information.
   */
  public function create_many(string $body)
  {
    $data = $this->data;
    $data['method'] = 'POST';
    $data['url'] = sprintf('%s/organizations/create_many.json', $data['baseurl']);
    $data['data'] = $body;
    return new BasicCurl($data);
  }

  /**
   * Creates an organization if it doesn't already exist, or updates an existing organization. Using this method means one less call to check if an organization exists before creating it. You need to specify the id or external id when updating an organization to avoid a duplicate error response. Name is not available as a matching criteria.
   * 
   * @param string $body json formatted string of organization to create/update
   * @return BasicCurl
   */
  public function create_or_update(string $body)
  {
    $data = $this->data;
    $data['method'] = 'POST';
    $data['url'] = sprintf('%s/organizations/create_or_update.json', $data['baseurl']);
    $data['data'] = $body;
    return new BasicCurl($data);
  }

  /**
   * Agents with no permissions restrictions can only update "notes" on organizations.
   * Note: Updating an organization's domain_names property overwrites all existing domain_names values. To prevent this, submit a complete list of domain_names for the organization in your request.
   * 
   * @param string $orgId Organization to update
   * @param string $body json formatted string of data to update
   * @return BasicCurl
   */
  public function update(int $orgId, string $body)
  {
    $data = $this->data;
    $data['method'] = 'PUT';
    $data['url'] = sprintf('%s/organizations/%s.json', $data['baseurl'], $orgId);
    $data['data'] = $body;
    return new BasicCurl($data);
  }

  /**
   * Bulk or batch updates up to 100 organizations.
   * Bulk update: To make the same change to multiple organizations. Id's must be included as comma separated list in $orgId's.
   * Batch update: To make different changes to multiple organizations. Id's must be included in json body.
   * 
   * @param string $body json formatted string of data to update
   * @param array|null $params Only used for bulk update, ignore this for batch update
   *    $params =  [
   *      'ids'          => '(string) 1,2,3'
   *      'external_ids' => '(string) 1,2,3'
   *    ]
   * @return BasicCurl This endpoint returns a job_status JSON object and queues a background job to do the work. Use the Show Job Status endpoint to check for the job's completion. Only a certain number of jobs can be queued or running at the same time. See Job limit for more information.
   */
  public function update_many(string $body, array $params = null)
  {
    $ids = '';
    if ($params) {
      $ids = sprintf('?%s', http_build_query($params));
    }

    $data = $this->data;
    $data['method'] = 'PUT';
    $data['url'] = sprintf('%s/organizations/update_many.json%s', $data['baseurl'], $ids);
    $data['data'] = $body;
    return new BasicCurl($data);
  }

  /**
   * Deletes specified organization.
   * 
   * @param int $orgId The ID of an organization
   * @return BasicCurl
   */
  public function delete(int $orgId)
  {
    $data = $this->data;
    $data['method'] = 'DELETE';
    $data['url'] = sprintf('%s/organizations/%s.json', $data['baseurl'], $orgId);
    return new BasicCurl($data);
  }

  /*
   * ALIAS FUNCTIONS
   */
  // public function deleted()
  // {
  //   return $this->list_deleted();
  // }
}