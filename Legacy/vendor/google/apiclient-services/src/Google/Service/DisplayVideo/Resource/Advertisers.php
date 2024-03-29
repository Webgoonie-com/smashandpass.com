<?php
/*
 * Copyright 2014 Google Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License"); you may not
 * use this file except in compliance with the License. You may obtain a copy of
 * the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS, WITHOUT
 * WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied. See the
 * License for the specific language governing permissions and limitations under
 * the License.
 */

/**
 * The "advertisers" collection of methods.
 * Typical usage is:
 *  <code>
 *   $displayvideoService = new Google_Service_DisplayVideo(...);
 *   $advertisers = $displayvideoService->advertisers;
 *  </code>
 */
class Google_Service_DisplayVideo_Resource_Advertisers extends Google_Service_Resource
{
  /**
   * Creates a new advertiser. Returns the newly created advertiser if successful.
   * This method can take up to 180 seconds to complete. (advertisers.create)
   *
   * @param Google_Service_DisplayVideo_Advertiser $postBody
   * @param array $optParams Optional parameters.
   * @return Google_Service_DisplayVideo_Advertiser
   */
  public function create(Google_Service_DisplayVideo_Advertiser $postBody, $optParams = array())
  {
    $params = array('postBody' => $postBody);
    $params = array_merge($params, $optParams);
    return $this->call('create', array($params), "Google_Service_DisplayVideo_Advertiser");
  }
  /**
   * Deletes an advertiser. Deleting an advertiser will delete all of its child
   * resources, for example, campaigns, insertion orders and line items. A deleted
   * advertiser cannot be recovered. (advertisers.delete)
   *
   * @param string $advertiserId The ID of the advertiser we need to delete.
   * @param array $optParams Optional parameters.
   * @return Google_Service_DisplayVideo_DisplayvideoEmpty
   */
  public function delete($advertiserId, $optParams = array())
  {
    $params = array('advertiserId' => $advertiserId);
    $params = array_merge($params, $optParams);
    return $this->call('delete', array($params), "Google_Service_DisplayVideo_DisplayvideoEmpty");
  }
  /**
   * Gets an advertiser. (advertisers.get)
   *
   * @param string $advertiserId Required. The ID of the advertiser to fetch.
   * @param array $optParams Optional parameters.
   * @return Google_Service_DisplayVideo_Advertiser
   */
  public function get($advertiserId, $optParams = array())
  {
    $params = array('advertiserId' => $advertiserId);
    $params = array_merge($params, $optParams);
    return $this->call('get', array($params), "Google_Service_DisplayVideo_Advertiser");
  }
  /**
   * Lists advertisers that are accessible to the current user.
   *
   * The order is defined by the order_by parameter.
   *
   * A single partner_id is required. Cross-partner listing is not supported.
   * (advertisers.listAdvertisers)
   *
   * @param array $optParams Optional parameters.
   *
   * @opt_param string pageToken A token identifying a page of results the server
   * should return. Typically, this is the value of next_page_token returned from
   * the previous call to `ListAdvertisers` method. If not specified, the first
   * page of results will be returned.
   * @opt_param string orderBy Field by which to sort the list. Acceptable values
   * are:
   *
   * * `displayName` (default) * `entityStatus`
   *
   * The default sorting order is ascending. To specify descending order for a
   * field, a suffix "desc" should be added to the field name. For example,
   * `displayName desc`.
   * @opt_param int pageSize Requested page size. Must be between `1` and `100`.
   * If unspecified will default to `100`.
   * @opt_param string partnerId Required. The ID of the partner that the fetched
   * advertisers should all belong to. The system only supports listing
   * advertisers for one partner at a time.
   * @opt_param string filter Allows filtering by advertiser properties.
   *
   * Supported syntax:
   *
   * * Filter expressions are made up of one or more restrictions. * Restrictions
   * can be combined by `AND` or `OR` logical operators. A sequence of
   * restrictions implicitly uses `AND`. * A restriction has the form of `{field}
   * {operator} {value}`. * The operator must be `EQUALS (=)`. * Supported fields:
   * - `entityStatus`
   *
   * Examples:
   *
   * * All active advertisers under a partner:
   * `entityStatus="ENTITY_STATUS_ACTIVE"`
   *
   * The length of this field should be no more than 500 characters.
   * @return Google_Service_DisplayVideo_ListAdvertisersResponse
   */
  public function listAdvertisers($optParams = array())
  {
    $params = array();
    $params = array_merge($params, $optParams);
    return $this->call('list', array($params), "Google_Service_DisplayVideo_ListAdvertisersResponse");
  }
  /**
   * Updates an existing advertiser. Returns the updated advertiser if successful.
   * (advertisers.patch)
   *
   * @param string $advertiserId Output only. The unique ID of the advertiser.
   * Assigned by the system.
   * @param Google_Service_DisplayVideo_Advertiser $postBody
   * @param array $optParams Optional parameters.
   *
   * @opt_param string updateMask Required. The mask to control which fields to
   * update.
   * @return Google_Service_DisplayVideo_Advertiser
   */
  public function patch($advertiserId, Google_Service_DisplayVideo_Advertiser $postBody, $optParams = array())
  {
    $params = array('advertiserId' => $advertiserId, 'postBody' => $postBody);
    $params = array_merge($params, $optParams);
    return $this->call('patch', array($params), "Google_Service_DisplayVideo_Advertiser");
  }
}
