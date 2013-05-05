<?php
class Admin_Model_Area extends model {
    public function __construct(){
        parent::__construct();
    }

    private $sqls = array(
        'create_city'   => 'insert into `area_city`(`city_name`,`parent_province`,`start_with`,`long_lat`,`latitude`,`longitude`,`created`,`updated`) values([@city_name],[@parent_province],[@start_with],[@long_lat],[@latitude],[@longitude],[@created],[@updated])',
        'update_city'   => 'update `area_city` set `city_name`=[@city_name],`parent_province`=[@parent_province],`start_with`=[@start_with],`long_lat`=[@long_lat],`latitude`=[@latitude],`longitude`=[@longitude],`updated`=[@updated] where `city_id` = [@city_id]',
        'delete_city'   => 'delete from `area_city` where `city_id` = [@city_id]',
        'get_city_page' => 'select `city_id`,`city_name`,`parent_province`,`start_with`,`long_lat` from `area_city` order by `updated` desc limit [@page_index],[@page_size];',
        'get_city_all_count'    => 'select count(1) as c from `area_city`;',
        'get_city_by_id'    => 'select `city_id`,`city_name`,`parent_province`,`start_with`,`long_lat` from `area_city` where `city_id` = [@city_id];',
        'get_district_all'  => 'select `district_id`,`district_name`,`city_id`,(select `city_name` from `area_city` where `city_id` = [@city_id]) as `city_name`,`start_with`,`long_lat` from `area_district` where `city_id` = [@city_id] order by `updated` desc;',
        'create_district'   => 'insert into `area_district`(`district_name`,`city_id`,`start_with`,`long_lat`,`latitude`,`longitude`,`created`,`updated`) values([@district_name],[@city_id],[@start_with],[@long_lat],[@latitude],[@longitude],[@created],[@updated])',
        'get_district_by_id'    => 'select `district_id`,`district_name`,`start_with`,`long_lat` from `area_district` where `district_id` = [@district_id];',
        'update_district'   => 'update `area_district` set `district_name`=[@district_name],`start_with`=[@start_with],`long_lat`=[@long_lat],`latitude`=[@latitude],`longitude`=[@longitude],`updated`=[@updated] where `district_id` = [@district_id]',
        'delete_district'   => 'delete from `area_district` where `district_id` = [@district_id]',
        'get_place_page'    => 'select `place_id`,`place_name`,`district_id`,`place_type`,`start_with`,`long_lat` from `area_place` where `district_id` = [@district_id] order by `updated` desc limit [@page_index],[@page_size];',
        'get_place_count'   => 'select count(1) as c from `area_place` where `district_id` = [@district_id];',
        'create_place'  => 'insert into `area_place`(`place_name`,`place_info`,`city_id`,`district_id`,`place_type`,`start_with`,`long_lat`,`latitude`,`longitude`,`created`,`updated`) values([@place_name],[@place_info],[@city_id],[@district_id],[@place_type],[@start_with],[@long_lat],[@latitude],[@longitude],[@created],[@updated])',
        'get_place_by_id'    => 'select `place_id`,`place_name`,`place_info`,`place_type`,`start_with`,`long_lat` from `area_place` where `place_id` = [@place_id];',
        'update_place'   => 'update `area_place` set `place_name`=[@place_name],`place_info`=[@place_info],`place_type`=[@place_type],`start_with`=[@start_with],`long_lat`=[@long_lat],`latitude`=[@latitude],`longitude`=[@longitude],`updated`=[@updated] where `place_id` = [@place_id]',
        'delete_place'   => 'delete from `area_place` where `place_id` = [@place_id]',
    );

    public $_china_provinces = array(
        '1' => '北京市',
        '2' => '上海市',
        '3' => '天津市',
        '4' => '重庆市',
        '5' => '浙江省',
        '6' => '广东省',
        '7' => '江苏省',
        '8' => '山东省',
        '12' => '河北省',
        '13' => '辽宁省',
        '14' => '四川省',
        '15' => '河南省',
        '16' => '湖北省',
        '17' => '福建省',
        '18' => '湖南省',
        '19' => '黑龙江省',
        '20' => '山西省',
        '21' => '安徽省',
        '23' => '吉林省',
        '25' => '江西省',
        '26' => '陕西省',
        '27' => '云南省',
        '29' => '贵州省',
        '30' => '甘肃省',
        '31' => '海南省',
        '33' => '青海省',
        '22' => '内蒙古自治区',
        '28' => '新疆维吾尔自治区',
        '24' => '广西壮族自治区',
        '32' => '宁夏回族自治区',
        '34' => '西藏自治区',
        '9'  => '香港',
        '10' => '澳门',
        '11' => '台湾',
    );

    public $_place_types = array(
        '1' => '写字楼',
        '2' => '住宅小区',
        '3' => '学校',
        '4' => '广场',
        '5' => '酒店',
        '6' => '其他',
    );

    //添加城市
    public function create_city($data){
        $data['created'] = $data['updated'] = time();
        mysql::execute('area_city', $this->sqls['create_city'], $data);
        return mysql::insertId();
    }

    //更新城市
    public function update_city($data){
        $data['updated'] = time();
        mysql::execute('area_city', $this->sqls['update_city'], $data);
        return true;
    }

    //删除城市
    public function delete_city($city_id){
        mysql::execute('area_city', $this->sqls['delete_city'], array('city_id'=>$city_id));
        return true;
    }

    //获取城市分页
    public function get_city_page($page = 1, $page_size = 30){
        $page_index = ($page>=1)?($page-1)*$page_size:0;
        $r = array();
        $r['list'] = array();
        $r['totalCount'] = 0;
        $r['list'] =  mysql::fetch('area_city', $this->sqls['get_city_page'], array('page_index'=>$page_index, 'page_size'=>$page_size));
        $c = mysql::fetch('area_city', $this->sqls['get_city_all_count'], array());
        if(count($c)) $r['totalCount'] = $c[0]['c'];
        return $r;
    }

    //根据ID获取单个城市
    public function get_city_by_id($city_id){
        $city = mysql::fetch('area_city', $this->sqls['get_city_by_id'], array('city_id'=>$city_id));
        if(count($city))
            return array_shift($city);
        else
            return false;
    }

    //根据城市ID获取区域
    public function get_district_all($city_id){
        return mysql::fetch('area_district', $this->sqls['get_district_all'], array('city_id'=>$city_id));
    }

    //添加区域
    public function create_district($data){
        $data['created'] = $data['updated'] = time();
        mysql::execute('area_district', $this->sqls['create_district'], $data);
        return mysql::insertId();
    }

    //根据ID获取单个区域
    public function get_district_by_id($district_id){
        $district = mysql::fetch('area_district', $this->sqls['get_district_by_id'], array('district_id'=>$district_id));
        if(count($district))
            return array_shift($district);
        else
            return false;
    }

    //更新区域
    public function update_district($data){
        $data['updated'] = time();
        mysql::execute('area_district', $this->sqls['update_district'], $data);
        return true;
    }

    //删除区域
    public function delete_district($district_id){
        mysql::execute('area_district', $this->sqls['delete_district'], array('district_id'=>$district_id));
        return true;
    }

    //获取城市分页
    public function get_place_page($district_id, $page = 1, $page_size = 30){
        $page_index = ($page>=1)?($page-1)*$page_size:0;
        $r = array();
        $r['list'] = array();
        $r['totalCount'] = 0;
        $r['list'] =  mysql::fetch('area_place', $this->sqls['get_place_page'], array('district_id'=>$district_id, 'page_index'=>$page_index, 'page_size'=>$page_size));
        $c = mysql::fetch('area_place', $this->sqls['get_place_count'], array('district_id'=>$district_id));
        if(count($c)) $r['totalCount'] = $c[0]['c'];
        return $r;
    }

    //添加地点
    public function create_place($data){
        $data['created'] = $data['updated'] = time();
        mysql::execute('area_place', $this->sqls['create_place'], $data);
        return mysql::insertId();
    }

    //根据ID获取单个地点
    public function get_place_by_id($place_id){
        $place = mysql::fetch('area_place', $this->sqls['get_place_by_id'], array('place_id'=>$place_id));
        if(count($place))
            return array_shift($place);
        else
            return false;
    }

    //更新区域
    public function update_place($data){
        $data['updated'] = time();
        mysql::execute('area_place', $this->sqls['update_place'], $data);
        return true;
    }

    //删除地点
    public function delete_place($place_id){
        mysql::execute('area_place', $this->sqls['delete_place'], array('place_id'=>$place_id));
        return true;
    }
}