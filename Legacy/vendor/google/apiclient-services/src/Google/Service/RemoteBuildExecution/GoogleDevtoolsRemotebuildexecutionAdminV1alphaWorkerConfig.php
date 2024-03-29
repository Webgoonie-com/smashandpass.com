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

class Google_Service_RemoteBuildExecution_GoogleDevtoolsRemotebuildexecutionAdminV1alphaWorkerConfig extends Google_Model
{
  protected $acceleratorType = 'Google_Service_RemoteBuildExecution_GoogleDevtoolsRemotebuildexecutionAdminV1alphaAcceleratorConfig';
  protected $acceleratorDataType = '';
  public $diskSizeGb;
  public $diskType;
  public $labels;
  public $machineType;
  public $maxConcurrentActions;
  public $minCpuPlatform;
  public $networkAccess;
  public $reserved;

  /**
   * @param Google_Service_RemoteBuildExecution_GoogleDevtoolsRemotebuildexecutionAdminV1alphaAcceleratorConfig
   */
  public function setAccelerator(Google_Service_RemoteBuildExecution_GoogleDevtoolsRemotebuildexecutionAdminV1alphaAcceleratorConfig $accelerator)
  {
    $this->accelerator = $accelerator;
  }
  /**
   * @return Google_Service_RemoteBuildExecution_GoogleDevtoolsRemotebuildexecutionAdminV1alphaAcceleratorConfig
   */
  public function getAccelerator()
  {
    return $this->accelerator;
  }
  public function setDiskSizeGb($diskSizeGb)
  {
    $this->diskSizeGb = $diskSizeGb;
  }
  public function getDiskSizeGb()
  {
    return $this->diskSizeGb;
  }
  public function setDiskType($diskType)
  {
    $this->diskType = $diskType;
  }
  public function getDiskType()
  {
    return $this->diskType;
  }
  public function setLabels($labels)
  {
    $this->labels = $labels;
  }
  public function getLabels()
  {
    return $this->labels;
  }
  public function setMachineType($machineType)
  {
    $this->machineType = $machineType;
  }
  public function getMachineType()
  {
    return $this->machineType;
  }
  public function setMaxConcurrentActions($maxConcurrentActions)
  {
    $this->maxConcurrentActions = $maxConcurrentActions;
  }
  public function getMaxConcurrentActions()
  {
    return $this->maxConcurrentActions;
  }
  public function setMinCpuPlatform($minCpuPlatform)
  {
    $this->minCpuPlatform = $minCpuPlatform;
  }
  public function getMinCpuPlatform()
  {
    return $this->minCpuPlatform;
  }
  public function setNetworkAccess($networkAccess)
  {
    $this->networkAccess = $networkAccess;
  }
  public function getNetworkAccess()
  {
    return $this->networkAccess;
  }
  public function setReserved($reserved)
  {
    $this->reserved = $reserved;
  }
  public function getReserved()
  {
    return $this->reserved;
  }
}
