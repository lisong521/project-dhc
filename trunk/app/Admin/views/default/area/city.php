<!--{@page layout="base"}-->
<!--{content head}-->
<link rel="stylesheet" href="<?php echo MONK::include_css('area-city','/Admin/source/styles/area/city.css',false,true); ?>">
<!--{/content}--> 
<!--{content body}-->
<h2>星铺分类</h2>
<div class="main">
    <dl>
        <?php if(!empty($status)){ ?>
        <dd>
            <div class="<?php echo $status; ?>"><p><?php echo $message; ?></p><div>
        </dd>
        <?php } ?>
        <dt>
            <ul>
                <li class="city-id">ID</li>
                <li class="city-name">城市名</li>
                <li class="parent-province">上级</li>
                <li class="start-with">字母</li>
                <li class="long-lat">经纬度</li>
                <li class="date">创建时间</li>
                <li class="date">更新时间</li>
                <li>操作</li>
            </ul>
        </dt>
        <?php foreach($list as $city){ ?>
        <dd>
            <ul>
                <li class="city-id"><?php echo $city['city_id']; ?></li>
                <li class="city-name"><?php echo $city['city_name']; ?></li>
                <li class="parent-province"><?php echo $china_provinces[$city['parent_province']]; ?></li>
                <li class="start-with"><?php echo $city['start_with']; ?></li>
                <li class="long-lat"><?php echo $city['long_lat']; ?></li>
                <li class="date"><?php echo date('y-m-d',$city['created']); ?></li>
                <li class="date"><?php echo date('y-m-d',$city['updated']); ?></li>
                <li><a href="<?php echo MONK::_url('*/editCity',array('city_id'=>$city['city_id'])); ?>">编辑</a> | <a href="<?php echo MONK::_url('*/deleteCity',array('city_id'=>$city['city_id'])); ?>">删除</a></li>
            </ul>
        </dd>
        <?php } ?>
    </dl>
    <div class="page-bar"><?php echo $pageBar; ?></div>
<div>
<!--{/content}-->