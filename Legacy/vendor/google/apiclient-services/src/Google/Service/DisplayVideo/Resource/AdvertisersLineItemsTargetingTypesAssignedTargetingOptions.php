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
 * The "assignedTargetingOptions" collection of methods.
 * Typical usage is:
 *  <code>
 *   $displayvideoService = new Google_Service_DisplayVideo(...);
 *   $assignedTargetingOptions = $displayvideoService->assignedTargetingOptions;
 *  </code>
 */
class Google_Service_DisplayVideo_Resource_AdvertisersLineItemsTargetingTypesAssignedTargetingOptions extends Google_Service_Resource
{
  /**
   * Assigns a targeting option to a line item. Returns the assigned targeting
   * option if successful. (assignedTargetingOptions.create)
   *
   * @param string $advertiserId Required. The ID of the advertiser the line item
   * belongs to.
   * @param string $lineItemId Required. The ID of the line item the assigned
   * targeting option will belong to.
   * @param string $targetingType Required. Identifies the type of this assigned
   * targeting option.
   * @param Google_Service_DisplayVideo_AssignedTargetingOption $postBody
   * @param array $optParams Optional parameters.
   * @return Google_Service_DisplayVideo_AssignedTargetingOption
   */
  public function create($advertiserId, $lineItemId, $targetingType, Google_Service_DisplayVideo_AssignedTargetingOption $postBody, $optParams = array())
  {
    $params = array('advertiserId' => $advertiserId, 'lineItemId' => $lineItemId, 'targetingType' => $targetingType, 'postBody' => $postBody);
    $params = array_merge($params, $optParams);
    return $this->call('create', array($params), "Google_Service_DisplayVideo_AssignedTargetingOption");
  }
  /**
   * Deletes an assigned targeting option from a line item.
   * (assignedTargetingOptions.delete)
   *
   * @param string $advertiserId Required. The ID of the advertiser the line item
   * belongs to.
   * @param string $lineItemId Required. The ID of the line item the assigned
   * targeting option belongs to.
   * @param string $targetingType Required. Identifies the type of this assigned
   * targeting option.
   * @param string $assignedTargetingOptionId Required. The ID of the assigned
   * targeting option to delete.
   * @param array $optParams Optional parameters.
   * @return Google_Service_DisplayVideo_DisplayvideoEmpty
   */
  public function delete($advertiserId, $lineItemId, $targetingType, $assignedTargetingOptionId, $optParams = array())
  {
    $params = array('advertiserId' => $advertiserId, 'lineItemId' => $lineItemId, 'targetingType' => $targetingType, 'assignedTargetingOptionId' => $assignedTargetingOptionId);
    $params = array_merge($params, $optParams);
    return $this->call('delete', array($params), "Google_Service_DisplayVideo_DisplayvideoEmpty");
  }
  /**
   * Gets a single targeting option assigned to a line item.
   * (assignedTargetingOptions.get)
   *
   * @param string $advertiserId Required. The ID of the advertiser the line item
   * belongs to.
   * @param string $lineItemId Required. The ID of the line item the assigned
   * targeting option belongs to.
   * @param string $targetingType Required. Identifies the type of this assigned
   * targeting option.
   * @param string $assignedTargetingOptionId Required. An identifier unique to
   * the targeting type in this line item that identifies the assigned targeting
   * option being requested.
   * @param array $optParams Optional parameters.
   * @return Google_Service_DisplayVideo_AssignedTargetingOption
   */
  public function get($advertiserId, $lineItemId, $targetingType, $assignedTargetingOptionId, $optParams = array())
  {
    $params = array('advertiserId' => $advertiserId, 'lineItemId' => $lineItemId, 'targetingType' => $targetingType, 'assignedTargetingOptionId' => $assignedTargetingOptionId);
    $params = array_merge($params, $optParams);
    return $this->call('get', array($params), "Google_Service_DisplayVideo_AssignedTargetingOption");
  }
  /**
   * Lists the targeting options assigned to a line item. (assignedTargetingOption
   * s.listAdvertisersLineItemsTargetingTypesAssignedTargetingOptions)
   *
   * @param string $advertiserId Required. The ID of the advertiser the line item
   * belongs to.
   * @param string $lineItemId Required. The ID of the line item to list assigned
   * targeting options for.
   * @param string $targetingType Required. Identifies the type of assigned
   * targeting options to list.
   * @param array $optParams Optional parameters.
   *
   * @opt_param int pageSize Requested page size. Must be between `1` and `100`.
   * If unspecified will default to `100`. Returns error code `INVALID_ARGUMENT`
   * if an invalid value is specified.
   * @opt_param string orderBy Field by which to sort the list. Acceptable values
   * are:
   *
   * * `assignedTargetingOptionId` (default)
   *
   * The default sorting order is ascending. To specify descending order for a
   * field, a suffix "desc" should be added to the field name. Example:
   * `assignedTargetingOptionId desc`.
   * @opt_param string filter Allows filtering by assigned targeting option
   * properties.
   *
   * Supported syntax:
   *
   * * Filter expressions are made up of one or more restrictions. * Restrictions
   * can be combined by the logical operator `OR`. * A restriction has the form of
   * `{field} {operator} {value}`. * The operator must be `EQUALS (=)`. *
   * Supported fields:     - `assignedTargetingOptionId`     - `inheritance`
   *
   * Examples:
   *
   * * AssignedTargetingOptions with ID 1 or 2 `assignedTargetingOptionId="1" OR
   * assignedTargetingOptionId="2"` * AssignedTargetingOptions with inheritance
   * status of NOT_INHERITED or   INHERITED_FROM_PARTNER
   * `inheritance="NOT_INHERITED" OR inheritance="INHERITED_FROM_PARTNER"`
   *
   * The length of this field should be no more than 500 characters.
   * @opt_param string pageToken A token identifying a page of results the server
   * should return. Typically, this is the value of next_page_token returned from
   * the previous call to `ListLineItemAssignedTargetingOptions` method. If not
   * specified, the first page of results will be returned.
   * @return Google_Service_DisplayVideo_ListLineItemAssignedTargetingOptionsResponse
   */
  public function listAdvertisersLineItemsTargetingTypesAssignedTargetingOptions($advertiserId, $lineItemId, $targetingType, $optParams = array())
  {
    $params = array('advertiserId' => $advertiserId, 'lineItemId' => $lineItemId, 'targetingType' => $targetingType);
    $params = array_merge($params, $optParams);
    return $this->call('list', array($params), "Google_Service_DisplayVideo_ListLineItemAssignedTargetingOptionsResponse");
  }
}
