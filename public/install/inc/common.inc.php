<?php
function renderFile($_file, $_params=array())
{
    extract($_params);
    require($_file);
}