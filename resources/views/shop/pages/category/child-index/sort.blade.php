@php
     use App\Helper\URL;
@endphp
<div id="sort-by" class="hidden-xs">
    <label class="left hidden-xs" for="sort-select">Sắp xếp theo: </label>
    <form class="form-inline form-viewpro">
        <div class="form-group">
            @if ($action == 'category')
                <select id="sortControl" class="form-select" data-url="{{ URL::linkCategory($params['category_id'],$params['category_name']).'?sort_by=default' }}">
            @else
                <select id="sortControl" class="form-select" data-url="{{ route('category/index').'?sort_by=default' }}">
            @endif
            
                @php
                    $sortValues = config('myconf.template.sort');
                    $xhtml = '';
                    
                    foreach ($sortValues as $key => $value) {
                        if($key == $params['filter']['sort_by']){
                            $xhtml .= '<option value="'.$key.'" selected>'.$value['name'].'</option>';
                        }else{
                            $xhtml .= '<option value="'.$key.'">'.$value['name'].'</option>';
                        }
                    }       
                
                @endphp   
                {!! $xhtml !!}
            </select>
        </div>
    </form>
</div>