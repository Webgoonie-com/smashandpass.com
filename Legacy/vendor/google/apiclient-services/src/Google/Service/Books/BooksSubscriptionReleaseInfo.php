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

class Google_Service_Books_BooksSubscriptionReleaseInfo extends Google_Model
{
  public $amountInMicros;
  public $currencyCode;
  public $releaseNumber;
  public $releaseTimestampUs;

  public function setAmountInMicros($amountInMicros)
  {
    $this->amountInMicros = $amountInMicros;
  }
  public function getAmountInMicros()
  {
    return $this->amountInMicros;
  }
  public function setCurrencyCode($currencyCode)
  {
    $this->currencyCode = $currencyCode;
  }
  public function getCurrencyCode()
  {
    return $this->currencyCode;
  }
  public function setReleaseNumber($releaseNumber)
  {
    $this->releaseNumber = $releaseNumber;
  }
  public function getReleaseNumber()
  {
    return $this->releaseNumber;
  }
  public function setReleaseTimestampUs($releaseTimestampUs)
  {
    $this->releaseTimestampUs = $releaseTimestampUs;
  }
  public function getReleaseTimestampUs()
  {
    return $this->releaseTimestampUs;
  }
}
