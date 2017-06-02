<div class="col-md-4 mg-topclt">
       
  <style>
   div#users-contain { width: 350px; margin: 20px 0; }
    div#users-contain table { margin: 1em 0; border-collapse: collapse; width: 100%; }
    div#users-contain table td, div#users-contain table th { border: 1px solid #eee; padding: .6em 10px; text-align: left; }
    .ui-dialog .ui-state-error { padding: .3em; }
    .validateTips { border: 1px solid transparent; padding: 0.3em; }
  </style>
<div class="main-color block-title rps"> ĐẶT VÉ </div>
<div class="stripe-line"></div>

<div class="form-search block-article">
    <form action="/ve-may-bay.html" method="POST" id="flightSearchForm">
        <div class=" left-col">
            <div class="form-content">
                <div class="form-checkbox">
                    <label><input name="journeyType" id="journeyType2" type="radio" checked value="1"> Một chiều</label>
                    <label><input name="journeyType" id="journeyType1" type="radio" value="2"> Khứ hồi</label>
                </div>
                <div class="form-filter">
                    <div>
                        <div class="col-md-6 formfilter">
                            <div class="filter-title main-color">Bạn sẽ đi đâu?</div>
                            <div class="col">
                                <label>ĐIỂM KHỞI HÀNH</label>
                                <input name="departureCityCode" id="departureCityCode" type="hidden">
                                <input name="departureCity" id="departureCity" type="text" readonly="true"><span class="icon-select"></span>
                            </div>
                            <div class="col">
                                <label>ĐIỂM ĐẾN</label>
                                <input name="arrivalCityCode" id="arrivalCityCode" type="hidden">
                                <input name="arrivalCity" id="arrivalCity" type="text" readonly="true"><span class="icon-select icon-arrivalCity"></span>
                            </div>
                        </div>
                        <div class="col-md-6 formfilter">
                            <div class="filter-title  main-color">Khi nào?</div>

                            <div class="">
                                <label>THỜI GIAN ĐI</label>
                                <div class="input-group">
                                    <input name="depatureDate" id="depatureDate" class="datepicker" type="text" value="">
                                    <span class="input-group-addon "><i class="glyphicon glyphicon-calendar"></i></span>
                                </div>
                            </div>
                            <div class="">
                                <label>THỜI GIAN VỀ</label>
                                <div class="input-group">
                                    <input name="returnDate" id="returnDate" class="datepicker" type="text" value="">
                                    <span class="input-group-addon "><i class="glyphicon glyphicon-calendar"></i></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="ps-with formfilter">
                        <span class="filter-title main-color">Với ai?</span>
                        <div class="row">
                            <div class="col-md-6">
                                <label>NGƯỜI LỚN</label>
                                <div id="dd" class="wrapper-dropdown-1" tabindex="1">
                                    <span>1</span>
                                    <ul class="dropdown" tabindex="1">
                                        <li><a href="#">1</a></li>
                                        <li><a href="#">2</a></li>
                                        <li><a href="#">3</a></li>
                                        <li><a href="#">4</a></li>
                                    </ul>
                                </div>
                            </div>

                            <div class="col-md-6"><label>TRẺ EM (2-12 Tuổi)</label>
                                <div id="dd1" class="wrapper-dropdown-1" tabindex="1">
                                    <span>0</span>
                                    <ul class="dropdown" tabindex="1">
                                        <li><a href="#">0</a></li>
                                        <li><a href="#">1</a></li>
                                        <li><a href="#">2</a></li>
                                        <li><a href="#">3</a></li>
                                        <li><a href="#">4</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6"><label>TRẺ EM (0-2 Tuổi)</label>
                                <div id="dd2" class="wrapper-dropdown-1" tabindex="1">
                                    <span>0</span>
                                    <ul class="dropdown" tabindex="1">
                                        <li><a href="#">0</a></li>
                                        <li><a href="#">1</a></li>
                                        <li><a href="#">2</a></li>
                                        <li><a href="#">3</a></li>
                                        <li><a href="#">4</a></li>
                                    </ul>
                                </div>

                            </div>

                            <div class="col-md-6"><button class="btn-search">TÌM CHUYẾN BAY</button></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<div id="service">
    <div class="main-color block-title">
        HỖ TRỢ TRỰC TUYẾN
    </div>
    <div class="stripe-line"></div>
    <div class="block-article left-col">
        <div class="tab-pane" id="sptructuyen">
            <div class="row-fluid">
                <div class="hotro">
                    <div class="box-hotro">                        
                        <span class="hotro-number">
                            <span class="hotro-name">Phạm Phượng -</span>
                            <span class="hotro-phone">&nbsp;0938 874 129</span>
                        </span>
                        <a href="ymsgr:sendIM?pham.phuong003"><span class="hotro-yahoo "></span></a>
                    </div>
                </div>
            </div>
            <div class="row-fluid">
                <div class="hotro">
                    <div class="box-hotro">                        
                        <span class="hotro-number">
                            <span class="hotro-name">Ms Oanh -</span>
                            <span class="hotro-phone">&nbsp;0979 961 122</span>
                        </span>
                        <a href="ymsgr:sendIM?pham.phuong003"><span class="hotro-yahoo "></span></a>
                    </div>
                </div>
            </div> 
        </div>
    </div>
</div>  
<?php //include "blocks/fanpage.php"; ?>
</div>