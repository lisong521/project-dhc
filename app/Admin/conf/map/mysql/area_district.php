<?php
if (!defined('DHC_VERSION')) exit('Access is no allowed.');

return array(
    'table' => 'area_district',
    'field'   => array(
        'district_id'   => PARAM_UINT,
        'district_name' => PARAM_STRING,
        'city_id'   => PARAM_UINT,
        'start_with'=> PARAM_STRING,
        'long_lat'  => PARAM_STRING,
        'created'   => PARAM_DATETIME,
        'updated'   => PARAM_DATETIME,
    )
);