<?php

function showInfoMessage($infoMessage = NULL, $isPositive = true)
{
    if ($isPositive)
    {
        $formattedInfoMessage = '<p style="color: #D7FFB2;"><strong>' . $infoMessage . '</strong></p>';
    }
    else
    {
        $formattedInfoMessage = '<p style="color: #FEA190;"><strong>' . $infoMessage . '</strong></p>';
    }

    return $formattedInfoMessage;
}