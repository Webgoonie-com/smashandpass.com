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

class Google_Service_DisplayVideo_GeoRegionAssignedTargetingOptionDetails extends Google_Model
{
  public $displayName;
  public $geoRegionType;
  public $negative;
  public $targetingOptionId;

  public function setDisplayName($displayName)
  {
    $this->displayName = $displayName;
  }
  public function getDisplayName()
  {
    return $this->displayName;
  }
  public function setGeoRegionType($geoRegionType)
  {
    $this->geoRegionType = $geoRegionType;
  }
  public function getGeoRegionType()
  {
    return $this->geoRegionType;
  }
  public function setNegative($negative)
  {
    $this->negative = $negative;
  }
  public function getNegative()
  {
    return $this->negative;
  }
  public function setTargetingOptionId($targetingOptionId)
  {
    $this->targetingOptionId = $targetingOptionId;
  }
  public function getTargetingOptionId()
  {
    return $this->targetingOptionId;
  }
}
