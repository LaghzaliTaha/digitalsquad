<?php

function valideemail($em)
{
    if (!filter_var($em ,FILTER_VALIDATE_EMAIL))
    {
        return false;
    }
    return true;
}
?>