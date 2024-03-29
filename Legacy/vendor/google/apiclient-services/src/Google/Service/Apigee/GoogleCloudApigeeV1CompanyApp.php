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

class Google_Service_Apigee_GoogleCloudApigeeV1CompanyApp extends Google_Collection
{
  protected $collection_key = 'scopes';
  public $apiProducts;
  public $appFamily;
  public $appId;
  protected $attributesType = 'Google_Service_Apigee_GoogleCloudApigeeV1Attribute';
  protected $attributesDataType = 'array';
  public $callbackUrl;
  public $companyName;
  public $createdAt;
  protected $credentialsType = 'Google_Service_Apigee_GoogleCloudApigeeV1Credential';
  protected $credentialsDataType = 'array';
  public $keyExpiresIn;
  public $lastModifiedAt;
  public $name;
  public $scopes;
  public $status;

  public function setApiProducts($apiProducts)
  {
    $this->apiProducts = $apiProducts;
  }
  public function getApiProducts()
  {
    return $this->apiProducts;
  }
  public function setAppFamily($appFamily)
  {
    $this->appFamily = $appFamily;
  }
  public function getAppFamily()
  {
    return $this->appFamily;
  }
  public function setAppId($appId)
  {
    $this->appId = $appId;
  }
  public function getAppId()
  {
    return $this->appId;
  }
  /**
   * @param Google_Service_Apigee_GoogleCloudApigeeV1Attribute
   */
  public function setAttributes($attributes)
  {
    $this->attributes = $attributes;
  }
  /**
   * @return Google_Service_Apigee_GoogleCloudApigeeV1Attribute
   */
  public function getAttributes()
  {
    return $this->attributes;
  }
  public function setCallbackUrl($callbackUrl)
  {
    $this->callbackUrl = $callbackUrl;
  }
  public function getCallbackUrl()
  {
    return $this->callbackUrl;
  }
  public function setCompanyName($companyName)
  {
    $this->companyName = $companyName;
  }
  public function getCompanyName()
  {
    return $this->companyName;
  }
  public function setCreatedAt($createdAt)
  {
    $this->createdAt = $createdAt;
  }
  public function getCreatedAt()
  {
    return $this->createdAt;
  }
  /**
   * @param Google_Service_Apigee_GoogleCloudApigeeV1Credential
   */
  public function setCredentials($credentials)
  {
    $this->credentials = $credentials;
  }
  /**
   * @return Google_Service_Apigee_GoogleCloudApigeeV1Credential
   */
  public function getCredentials()
  {
    return $this->credentials;
  }
  public function setKeyExpiresIn($keyExpiresIn)
  {
    $this->keyExpiresIn = $keyExpiresIn;
  }
  public function getKeyExpiresIn()
  {
    return $this->keyExpiresIn;
  }
  public function setLastModifiedAt($lastModifiedAt)
  {
    $this->lastModifiedAt = $lastModifiedAt;
  }
  public function getLastModifiedAt()
  {
    return $this->lastModifiedAt;
  }
  public function setName($name)
  {
    $this->name = $name;
  }
  public function getName()
  {
    return $this->name;
  }
  public function setScopes($scopes)
  {
    $this->scopes = $scopes;
  }
  public function getScopes()
  {
    return $this->scopes;
  }
  public function setStatus($status)
  {
    $this->status = $status;
  }
  public function getStatus()
  {
    return $this->status;
  }
}
