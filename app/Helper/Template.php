<?php
namespace App\Helper;
use Config;

class Template {
    public static function showItemThumb($controllerName, $thumbName, $thumbAlt){
        $xhtml = sprintf('<img src="%s" alt="%s" class="adm-thumb" />', asset("images/$controllerName/$thumbName"), $thumbAlt);
        return $xhtml;
    }

    public static function showItemStatus($controllerName, $id, $statusValue){
        $tmplStatus = Config::get('myconf.template.status');
        
        $statusValue = array_key_exists($statusValue, $tmplStatus)? $statusValue : 'default';
        $currentTemplateStatus = $tmplStatus[$statusValue];
        $link = route($controllerName.'/status', ['status' => $statusValue, 'id' => $id]);

        $xhtml = sprintf('<button data-url="%s" data-class="%s" type="button" class="btn btn-round %s status-ajax">%s</button>'
        , $link, $currentTemplateStatus['class'], $currentTemplateStatus['class'], $currentTemplateStatus['name']);
        return $xhtml;
    }

    public static function showButtonHandle($controllerName, $id, $statusValue){
        $tmplStatus = Config::get('myconf.template.order');
        
        if(array_key_exists($statusValue, $tmplStatus)){
            $currentTemplateStatus = $tmplStatus[$statusValue];
            $link = route($controllerName.'/status', ['status' => $statusValue, 'id' => $id]);

            $xhtml = sprintf('<button data-url="%s" data-class="%s" type="button" class="btn btn-round %s status-order">%s</button>
            <a href="%s" type="button" class="btn btn-round btn-danger" data-toggle="tooltip" data-placement="top"  onclick="return confirm(\'Xác nhận hủy đơn hàng này ?\')" >Hủy đơn</a>'
            , $link, $currentTemplateStatus['class'], $currentTemplateStatus['class'], $currentTemplateStatus['name'],route('order/cancel',['id' => $id]));
        }else {
            $xhtml = '';
        }
        
        return $xhtml;
    }

    public static function showItemHistory($by, $time){
        $xhtml = sprintf('<p><i class="fa fa-user"></i> %s</p>
        <p><i class="fa fa-clock-o"></i> %s</p>', $by, date(Config::get('myconf.format.long_time'),strtotime($time)));
        return $xhtml;
    }

    public static function showButtonAction($controllerName, $id, $index = true){
        $tmplButton = Config::get('myconf.template.button');

        $buttonInArea = Config::get('myconf.config.button');

        $controllerName = array_key_exists($controllerName, $buttonInArea)? $controllerName : 'default';  
        $xhtml = '<div class="adm-box-btn-filter">';          
        if($index == true){
            $listButtons = $buttonInArea[$controllerName];          
            foreach($listButtons as $btn){ 
                if(session('userInfo')['role'] != 'admin') {
                    if($controllerName != 'news') {
                        if($btn == 'edit' || $btn == 'import') continue;
                    } 
                }
                $currentButton = $tmplButton[$btn];
                
                   
                $link = route($controllerName . $currentButton['route'], ['id' => $id]);
                $xhtml .= sprintf('<a href="%s" type="button" class="btn btn-icon %s" data-toggle="tooltip" data-placement="top"
                                    data-original-title="%s">
                                    <i class="fa %s"></i>
                                </a>', $link, $currentButton['class'], $currentButton['title'], $currentButton['icon']);
            }          
        } else {
            $listButtons = Config::get('myconf.config.button.recycle_bin');
            
            foreach($listButtons as $btn){
                if(session('userInfo')['role'] != 'admin') {
                    if($btn == 'delete') continue;
                }
                $currentButton = $tmplButton[$btn];
                $link = route($controllerName . $currentButton['route'], ['id' => $id]);
                $xhtml .= sprintf('<a href="%s" type="button" class="btn btn-icon %s" data-toggle="tooltip" data-placement="top"
                                    data-original-title="%s">
                                    <i class="fa %s"></i>
                                </a>', $link, $currentButton['class'], $currentButton['title'], $currentButton['icon']);
            }
           
        }
        $xhtml .='</div>';

        return $xhtml;
    }

    public static function showButtonFilter ($controllerName, $itemsStatusCount, $currentFilterStatus, $paramsSearch) { 
        $xhtml = null;
        $tmplStatus = Config::get('myconf.template.status');
        if($controllerName == 'order') $tmplStatus = Config::get('myconf.template.status_order');
        if (count($itemsStatusCount) > 0) {
            array_unshift($itemsStatusCount , [
                'count'   => array_sum(array_column($itemsStatusCount, 'count')),
                'status'  => 'all'
            ]);

            foreach ($itemsStatusCount as $item) {  
                $statusValue = $item['status'];  
                $statusValue = array_key_exists($statusValue, $tmplStatus ) ? $statusValue : 'default';

                $currentTemplateStatus = $tmplStatus[$statusValue]; 
                $link = route($controllerName) . "?filter_status=" .  $statusValue;

                if($paramsSearch['value'] !== ''){
                    $link .= "&search_field=" . $paramsSearch['field'] . "&search_value=" .  $paramsSearch['value'];
                }

                $class  = ($currentFilterStatus == $statusValue) ? 'btn-danger' : 'btn-info';
                $xhtml  .= sprintf('<a href="%s" type="button" class="btn %s">
                                    %s <span class="badge bg-white">%s</span>
                                </a>', $link, $class, $currentTemplateStatus['name'], $item['count']);
            }
        }

        return $xhtml;
    }

    public static function showAreaSearch($controllerName, $paramsSearch){
        $xhtml = null;
        $tmplField = Config::get('myconf.template.search');
        $fieldInController = Config::get('myconf.config.search');

        $controllerName = array_key_exists($controllerName, $fieldInController)? $controllerName : 'default';
        $xhtmlField = null;
        foreach($fieldInController[$controllerName] as $field) {
            $xhtmlField .= sprintf('<li><a href="#" class="select-field" data-field="%s">%s</a></li>', $field, $tmplField[$field]['name']);
        }
        $searchField = in_array($paramsSearch['field'], $fieldInController[$controllerName])? $paramsSearch['field'] : 'all';
        $xhtml .= sprintf(
            '<div class="input-group">
                <div class="input-group-btn">
                    <button type="button" class="btn btn-default dropdown-toggle btn-active-field" data-toggle="dropdown" aria-expanded="false">%s <span class="caret"></span></button>
                    <ul class="dropdown-menu dropdown-menu-right" role="menu">%s</ul>
                </div>
                <input type="text" class="form-control" name="search_value" value="%s">
                <input type="hidden" name="search_field" value="%s">
                <span class="input-group-btn">
                    <button id="btn-clear-search" type="button" class="btn btn-success" style="margin-right: 0px">Xóa tìm kiếm</button>
                    <button id="btn-search" type="button" class="btn btn-primary">Tìm kiếm</button>
                </span>
            </div>',$tmplField[$searchField]['name'],$xhtmlField, $paramsSearch['value'],$searchField);
        return $xhtml;
    }

    public static function showItemSelect($controllerName, $id, $displayValue, $fieldName){
        $link = route($controllerName. '/' . $fieldName, [$fieldName => 'value_new', 'id' => $id]);
        $tmplDisplay = Config::get('myconf.template.'.$fieldName);
        $xhtml = sprintf('<select name="select_change_attr" data-url="%s" class="form-control">',$link);
        foreach($tmplDisplay as $key => $value){
            $xhtmlSelected ='';
            if($key == $displayValue) $xhtmlSelected ='selected="seclected"';
            $xhtml .= sprintf('<option value="%s" %s">%s</option>', $key, $xhtmlSelected, $value['name']);
        }
        $xhtml .='</select>';
        return $xhtml;
    }
}