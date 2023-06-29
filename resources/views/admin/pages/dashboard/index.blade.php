@extends('admin.main')
@section('content')
@php
    use App\Models\OrderModel;
    use App\Models\OrderDetailModel;
    $Morder = new OrderModel();
    $MorderDetail = new OrderDetailModel();
    $d=getdate();
    $year=$d['year'];
    $total = 0; $cost = 0;
    
    for ($i=1; $i <= 12 ; $i++) 
    {   
        $list_orrders = $Morder->listItems(['year'=>$year,'month'=>$i], ['task'=>'list-order-follow-month']);
        
        $sum = 0;
          foreach ($list_orrders as $row_orrder) 
          {
            $order_detail = $MorderDetail->getItem($row_orrder,['task'=>'get-item']);
            $quantities = json_decode($order_detail['quantities']);
            foreach ($quantities as $value) {
            $sum += $value;
            }
            $total += $row_orrder['money'];
          }
    }
    
@endphp

<div class="page-header zvn-page-header clearfix">
    <div class="zvn-page-header-title">
        <h3>Dashboard</h3>
    </div>
    
</div>
<div class="row">
    <div class="col-lg-3 col-xs-6">
        <div class="small-box bg-blue">
            <div class="inner">
                <h3>{{count($product)}}</h3>
                <p>Sản phẩm</p>
                <div class="icon">
                    <i class="fa fa-shopping-bag"></i>
                </div>
            </div>
            <a href="{{route('product')}}" class="small-box-footer">Danh sách sản phẩm</a>
        </div>
    </div>
    <div class="col-lg-3 col-xs-6">
        <div class="small-box bg-green">
            <div class="inner">
                <h3>{{count($news)}}</h3>
                <p>Bài viết</p>
                <div class="icon">
                    <i class="fa fa-comments-o"></i>
                </div>
            </div>
            <a href="{{route('news')}}" class="small-box-footer">Danh sách bài viết</a>
        </div>
    </div>
    <div class="col-lg-3 col-xs-6">
        <div class="small-box bg-orange">
            <div class="inner">
                <h3>{{count($contact)}}</h3>
                <p>Liên hệ</p>
                <div class="icon">
                    <i class="fa fa-envelope"></i>
                </div>
            </div>
            <a href="{{route('contact')}}" class="small-box-footer">Liên hệ</a>
        </div>
    </div>
    <div class="col-lg-3 col-xs-6">
        <div class="small-box bg-red">
            <div class="inner">
                <h3>{{count($order)}}</h3>
                <p>Đơn hàng</p>
                <div class="icon">
                    <i class="fa fa-cube"></i>
                </div>
            </div>
            <a href="{{route('order')}}" class="small-box-footer">Danh sách đơn hàng</a>
        </div>
    </div>
</div>
<section class="content">
    <div class="row">
      <!-- /.col (LEFT) -->
      <div class="col-md-12">
        <!-- LINE CHART -->
        <div class="boxx box-info">
          <div class="box-header with-border">
            <h3 class="box-title">Bán hàng & Doanh thu</h3>
            <div class="box-tools pull-right">
              <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
              </button>
              <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
            </div>
          </div>
          <div class="box-body">
            <div class="chartx">
              <div id="chart_div" style="width: 100%; height: 250px;"></div>
            </div>
          </div>
          <div class="box-footer">
            <div class="row">
              <div class="col-sm-4 col-xs-6">
                <div class="description-block border-right">
                  <h5 class="description-header" style="color: #e90000;">{{ number_format($total)}} VNĐ</h5>
                  <span class="description-text">Tổng doanh thu</span>
                </div>
                <!-- /.description-block -->
              </div>
              <!-- /.col -->
            </div>
            <?php
          $d=getdate();
          $year=$d['year'];
          for ($i=1; $i <= 12 ; $i++) 
          {   
            $list_orrders = $Morder->listItems(['year'=>$year,'month'=>$i], ['task'=>'list-order-follow-month']);
            $total_month = 0;
            foreach ($list_orrders as $row_orrder) 
            {
              $total_month += $row_orrder['money'];
            }
            echo '<div class="col-sm-4 col-xs-6">
                <div class="description-block border-right" style="display: inline-flex;">
                  <span class="description-text">Doanh thu tháng '.$i.' :  </span> 
                  <h5 class="description-header" style="color: #e90000;padding-left: 10px;">'.number_format($total_month).' VNĐ</h5>
                </div>
                <!-- /.description-block -->
              </div>';
          }
          ?>
            <!-- /.row -->
          </div>
          <!-- /.box-body -->
        </div>
      </div> 
    </section>
    <script src="https://www.gstatic.com/charts/loader.js"></script>
    <script>
        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(drawVisualization);
     
        function drawVisualization() {
         var data = google.visualization.arrayToDataTable([
          ['Month', 'Bán ra', 'Đơn hàng'],
          <?php
          $d=getdate();
          $year=$d['year'];
          for ($i=1; $i <= 12 ; $i++) 
          {   
           $list_orrders = $Morder->listItems(['year'=>$year,'month'=>$i], ['task'=>'list-order-follow-month']);
           $sum = 0;
          
          foreach ($list_orrders as $row_orrder) 
          {
            $order_detail = $MorderDetail->getItem($row_orrder,['task'=>'get-item']);
            $quantities = json_decode($order_detail['quantities']);
            foreach ($quantities as $value) {
                $sum += $value;
            }
          }
           
          
           if($i >= 1 && $i <=9)
           {
             echo "['0".$i.'/'.$year."',".$sum.",".count($list_orrders)."],";
           }
           else
           {
             echo "['".$i.'/'.$year."',".$sum.",".count($list_orrders)."],";
           }
         }
         ?>
     
         ]);
         var year = new Date().getFullYear();
         var options = {
           title: 'Số lượng bán ra từ 01/'+year+' - 12/'+year,
           seriesType: 'bars'
         };
     
         var chart = new google.visualization.ComboChart(document.getElementById('chart_div'));
         chart.draw(data, options);
       } 
     </script>
@endsection