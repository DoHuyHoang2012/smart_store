<?php
    namespace App\Helper;
    use Config;
    class Form {
        public static function show($elements){
            $xhtml = null;
            foreach($elements as $element){
                $xhtml .= self::formGroup($element);
            }
                
            
            return $xhtml;
        }

        public static function formGroup($element, $params = null) {
            $type = (isset($element['type']))? $element['type'] : 'input';
            $xhtml = null;
            switch($type){
                case 'input':
                    $xhtml = sprintf(
                        '<div class="form-group">
                            %s
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                %s
                            </div>
                        </div>',$element['label'], $element['element']);
                    break;
                case 'keyword':
                    $xhtml = sprintf(
                        '<div class="form-group">
                            %s
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                %s
                                <span style="font-style: italic; line-height: 32px;">%s</span>
                            </div>
                        </div>
                        ',$element['label'], $element['element'], $element['suggest']);
                    break;
                case 'img':
                    $xhtml = sprintf(
                        '<div class="form-group">
                        %s
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            %s
                            <p style="margin-top: 50px;">%s</p>
                        </div>
                    </div>',$element['label'], $element['element'], $element['thumb']);
                    break;
                case 'avatar':
                    $xhtml = sprintf(
                        '<div class="form-group">
                        %s
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            %s
                            <p style="margin-top: 50px;">%s</p>
                        </div>
                    </div>',$element['label'], $element['element'], $element['avatar']);
                    break;
                case 'btn-submit':
                        $xhtml = sprintf(
                            '<div class="ln_solid"></div>
                            <div class="form-group">
                                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                    %s
                                </div>
                            </div>',$element['element']);
                    break;
                case 'btn-submit-edit':
                    $xhtml = sprintf(
                        '<div class="ln_solid"></div>
                        <div class="form-group">
                            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-4">
                                %s
                            </div>
                        </div>',$element['element']);
                break;
            }
            return $xhtml;
        }

    }


  