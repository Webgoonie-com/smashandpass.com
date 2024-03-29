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

class Google_Service_FirebaseML_ModelState extends Google_Model
{
  public $published;
  protected $validationErrorType = 'Google_Service_FirebaseML_Status';
  protected $validationErrorDataType = '';

  public function setPublished($published)
  {
    $this->published = $published;
  }
  public function getPublished()
  {
    return $this->published;
  }
  /**
   * @param Google_Service_FirebaseML_Status
   */
  public function setValidationError(Google_Service_FirebaseML_Status $validationError)
  {
    $this->validationError = $validationError;
  }
  /**
   * @return Google_Service_FirebaseML_Status
   */
  public function getValidationError()
  {
    return $this->validationError;
  }
}
