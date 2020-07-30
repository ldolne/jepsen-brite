<?php

function showInfoMessage($infoMessage = NULL, $isPositive = true)
{
    if ($isPositive)
    {
        $formattedInfoMessage = '<p style="color: green;"><strong>' . $infoMessage . '</strong></p>';
    }
    else
    {
        $formattedInfoMessage = '<p style="color: red;"><strong>' . $infoMessage . '</strong></p>';
    }

    return $formattedInfoMessage;
}