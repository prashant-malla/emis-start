<?php

namespace App\Services;

use App\Models\SchoolSetting;

class SchoolSettingService
{
  private $setting;

  public function getSetting()
  {
    if (is_null($this->setting)) {
      $this->setting = SchoolSetting::find(1);
    }

    return $this->setting;
  }
}
