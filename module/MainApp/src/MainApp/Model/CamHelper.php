<?php
/* * ***************************************************************************
* Copyright (C) 2016 {KAOM Vibolrith} <{vibolrith@gmail.com}>
*
* This file is part of CAMEMIS App.
*
* {CAMEMIS App} can not be copied and/or distributed without the express
* permission of {KAOM Vibolrith, CAMEMIS Germany}
* ************************************************************************** */

namespace MainApp\Model;

class CamHelper
{

    public function secondToHour($seconds)
    {
        $hours = floor($seconds / 3600);
        $minutes = floor(($seconds - ($hours * 3600)) / 60);
        $seconds = round($seconds - ($hours * 3600) - ($minutes * 60), 0);

        if ($hours <= 9) {
            $strHours = "0" . $hours;
        } else {
            $strHours = $hours;
        }

        if ($minutes <= 9) {
            $strMinutes = "0" . $minutes;
        } else {
            $strMinutes = $minutes;
        }

        if ($seconds <= 9) {
            $strSeconds = "0" . $seconds;
        } else {
            $strSeconds = $seconds;
        }
        return "$strHours:$strMinutes";
    }
}