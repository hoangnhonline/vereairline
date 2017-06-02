var divLoadingContent = '<div id="divLoadingContent"><div style="text-align:center;"><p>Hệ thống đang xử lý. Quý khách vui lòng đợi trong giây lát...</p><img src="/layout/airlines/images/loadingbar.gif" alt="Loading..." /></div></div>';
function clickIsReturn(value){
	if(value==0){
		if($('span.disable-field').attr('rel')==undefined)
			$('#return_1').append('<span class="disable-field" rel="disable-field" onclick="clickIsReturn(1);"></span>');		
		$("#cboDateToOS_date,#cboDateToOS_month").prop('disabled', 'disabled');
	}else{
		if($('span.disable-field').attr('rel')!=undefined) {
			$('span.disable-field').remove();
		}
		$("#cboDateToOS_date,#cboDateToOS_month").prop('disabled', '');
		$('#is_return_1').attr('checked','checked');
	}} 
function paging(group,page,page_size){
	var length = $('.direction_'+group).length;
	var start = (page-1)*page_size + 1;
	var end = (page)*page_size;
	for(i=1;i<=length;i++){		
		if(i>=start && i<=end){
			$('.direction_'+group).eq(i-1).show();
		}else{
			$('.direction_'+group).eq(i-1).hide();			
		}
	}
	$(".pagging").each(function (i) {
		$('#flightItem_Footer_'+group+' .page_'+i+' a').css('color','#000000');
		$('#flightItem_Footer_'+group+' .page_'+i+' a').css('font-weight','normal');
		if(i == page) {
			$('#flightItem_Footer_'+group+' .page_'+i+' a').css('color','#0283D4');
			$('#flightItem_Footer_'+group+' .page_'+i+' a').css('font-weight','bold');		
		}    
	});	
	$('#flightItem_Footer_'+group).show();}
function sortBy(Col,group,obj){
	$('#flightItem_Header_'+group+' .sort_arrow').hide();
	$(obj).children().eq(1).show();$(obj).children().eq(2).show();
	var length = $('.direction_'+group).length;
	var html =  new Array(); 
	var value = new Array();
	for(i=0;i<length;i++){
		html[i] = $('.direction_'+group).eq(i).outerHTML();
		value[i] = parseInt($('.direction_'+group).eq(i).attr(Col));
	}		
	for(i=0;i<length;i++){
		for(j=i;j<length;j++){
			if(value[i]>value[j]){
				var temp = value[i];
				value[i] = value[j];
				value[j] =  temp;					
				var str = html[i];
				html[i] = html[j];
				html[j] =  str;					
			}
		}		
	}
	var html_out = '';
	for(i=0;i<length;i++){
		html_out += html[i];
	}		
	$('.direction_outter_'+group).html(html_out);	
	paging(group,1,1000);}

function step1(){
	$("#step1").addClass("active");
	$("#step2").removeClass();
	$("#step3").removeClass();
	$("#step4").removeClass();
}
function step2(){
	change_step(1);	
	$('#frmBooking').show();
	$("#step1").removeClass();
	$("#step2").addClass("active");
	$("#step3").removeClass();
	$("#step4").removeClass();
	$("#stepResultFlight").show();
	$('#form_booking').hide();
	$('#completer').hide();
}
$(function(){
	$("#divFareRules").dialog({
		autoOpen: false, resizable: false, height: 450, width: 600, position: 'top',
		buttons: {
			"Đóng lại.": function() { $(this).dialog('close');}
		},
		open: function(event, ui) {
			$(this).parent().css('position', 'fixed');
			$(this).parent().css('top', (($(window).height()/2)-($(this).outerHeight()/2) - 45 +"px"));
			$(this).parent().css('left', (($(window).width() - $(this).outerWidth()) / 2) + $(window).scrollLeft() + "px");
		}
	});	
	$('#ctl00_cphContent_ucFareRules_ddlFareRulesLang').change(function () {
		var vLang = $('#ctl00_cphContent_ucFareRules_ddlFareRulesLang').val();
		if(vLang == ""){ return; }
		$.each(vArrOrigFareRules, function (index, originalText) {
			$.ajax({
				url: "/GetResultInternational.html",
				type: "POST",
				dataType: "xml",
				data: { action_type: "TRANSLATE", text: fcjs.htmlEncode(originalText), language: vLang },
				success: function (myXML) {
					$('#ctl00_cphContent_ucFareRules_ddlFareRulesLang').removeAttr('disabled');
					var translateSuccess = $(myXML).find("translate").attr('success');
					var translateRes = $(myXML).find("translate").text();
					$("#divFareRulesContentWrapper .divFareRulesContent:eq(" + index + ")").html(fcjs.htmlDecode(translateRes)); //decode
				}, beforeSend: function () {
					$('#ctl00_cphContent_ucFareRules_ddlFareRulesLang').attr('disabled','disabled');
					$("#divFareRulesContentWrapper .divFareRulesContent:eq("+ index +")").html("<div style='padding-top:100px;text-align:center'><img src='/layout/airlines/images/loadingbar.gif' alt='Loading...' style='margin:auto' /></div>");
				},
					error: function (jqXHR, textStatus, errorThrown) {
					alert("Lỗi trong quá trình dịch quy định giá vé. Lỗi: " + errorThrown);
				}
			});
		});
	});	
});
var vArrOrigFareRules; 
function GetFareRules(Index) {
	$.ajax({
		url: "/GetResultInternational.html",
		type: "POST",
		dataType: "xml",
		data: { action_type: "FARERULES", Index: Index},
		success: function (data) {
			$(data).find('status').each(function () {
				if ($(this).attr("code") == "1") {
					$('#ctl00_cphContent_ucFareRules_ddlFareRulesLang').removeAttr('disabled');
					$("#divFareRulesContentWrapper").html($(this).text());
					vArrOrigFareRules = new Array();
					$('#divFareRulesContentWrapper .divFareRulesContent').each(function(index) {
						vArrOrigFareRules.push($(this).html()); //use customize encode
					});
				}
			});
		}, beforeSend: function () {
			$("#divFareRules").dialog('open');
			$('#ctl00_cphContent_ucFareRules_ddlFareRulesLang').attr('disabled','disabled').val('');
			$("#divFareRulesContentWrapper").html("<div style='padding-top:150px;text-align:center'><img src='/layout/airlines/images/loadingbar.gif' alt='Loading...' style='margin:auto' /></div>");
		},
			error: function () {
			alert("Lỗi trong quá trình lấy dữ liệu quy định giá vé.");
		}
	});
} 
function showFlightDetail(id) {
	$("#trFlightDetail" + id).slideToggle('slow', function () {
		if ($("#trFlightDetail" + id).is(":visible")) {
			var temp = $("#aFlightDetail" + id).html();
			temp = temp.substring(0, temp.length - 1) + " -";
			$("#aFlightDetail" + id).html(temp);
		} else {
			var temp = $("#aFlightDetail" + id).html();
			temp = temp.substring(0, temp.length - 1) + " +";
			$("#aFlightDetail" + id).html(temp);
		}
	});} 
function showFareInfo(id, img) {
	$("#" + id).slideToggle('slow', function () {
		if ($("#" + img).hasClass("squareplus")) {
			$("#" + img).removeClass("squareplus");
			$("#" + img).addClass("squareminus");
		} else {
			$("#" + img).addClass("squareplus");
			$("#" + img).removeClass("squareminus");
		}
	});}  
function GoBook(index,groupSize){
	$.ajax({
		url: "/GetResultInternational.html",
		type: "POST",
		dataType: "html",
		data: { action_type: "FLIGHTREVIEW", index: index},
		beforeSend: function () {
			$('html, body').animate({ scrollTop: 100 }, 'slow');
			$("#flightResultMainContentInter").html('<div id="divLoadingContent"><div style="text-align:center;"><p>Hệ thống đang xử lý. Quý khách vui lòng đợi trong giây lát...</p><img src="/layout/airlines/images/loadingbar.gif" alt="Loading..." /></div></div>');
			$("#tabs_1 #flightResultMainContent").html('<center><p><a href="javascript:void(0);" onClick="window.location.reload();" title="Tải lại trang">Tải lại trang</a></p></center>');
		},
		success: function (data) {
			change_step(2);
			var result = '<div id="divTabFlightSeparate"><div id="divTabFlightSeparateResult">'+data+'</div></div>';
			$("#flightResultMainContentInter").html(result);
		},
		error: function () {
			var msg = "FAIL";
			$("#flightResultMainContentInter").html(msg);
		}
	});
	//location.href = "flight-review.php?index="+index;
} 
function detectSearch(from,to){
	var dateTo = '';
	var airportLocal = ['8772','8758','8786','8775','8902','8761','8763','8903','8779','8785','8769','8766','8764','8756','8781','8760','8777','8782','8755','8906'];
	if($('#is_return_1').attr('checked')){
		dateTo = $('input[name=\'txtDateTo\']').val();
	}
	if(($.inArray(from,airportLocal)>-1 && $.inArray(to,airportLocal)>-1)) {
		var divLoadingContent = '<div id="divLoadingContent"><div style="text-align:center;"><p>Hệ thống đang xử lý. Quý khách vui lòng đợi trong giây lát...</p><img src="/layout/airlines/images/loadingbar.gif" alt="Loading..." /></div></div>';
		$.ajax({
			type: 'POST',
			url: '/ve-may-bay-truc-tuyen/',
			data: 'mode=2&isAjaxCall=true&is_return=' + encodeURIComponent($('input[name=\'is_return\']:checked').val()) + '&txtFrom=' + encodeURIComponent($('input[name=\'txtFrom\']').attr('datavalue')) + '&txtTo=' + encodeURIComponent($('input[name=\'txtTo\']').attr('datavalue'))+ '&txtDateFrom=' + encodeURIComponent($('input[name=\'txtDateFrom\']').val())+ '&txtDateTo=' + encodeURIComponent(dateTo)+ '&cboAdults=' + encodeURIComponent($('input[name=\'cboAdults\']').val())+ '&cboChildren=' + encodeURIComponent($('input[name=\'cboChildren\']').val())+ '&cboInfant=' + encodeURIComponent($('input[name=\'cboInfant\']').val()),
			beforeSend: function() {
				$(".desc").html('Vui lòng đợi...');
				$("#btnSearch").attr('disabled', true);
				step1();						
				$("#cart").html("");
				$("#flightResultMainContent").html(divLoadingContent);
				$("#show_banner").show();
			},
			complete: function() {
				$(".desc").html('Tìm chuyến bay');
				$("#btnSearch").attr('disabled', false);
				stopMarqueUp();
				step2();
				$('.block_id_339').hide();
				$('.block_id_279').hide();
				$('.block_id_401').hide();
			},
			success: function(data) {
				$("#show_banner").hide();
				$('#flightResultMainContent').html(data);
				if($('#flightItem_Header_start .Col_Price'))
					sortBy('ticketprice','start',$('#flightItem_Header_start .Col_Price'));	
				if($('#flightItem_Header_return .Col_Price'))
					sortBy('ticketprice','return',$('#flightItem_Header_return .Col_Price'));								
			}
		});	
	} 
}
var reload_die = 0;
function InternationalSearch(){
	var page = 1;
	var pagesize = 50;
	var is_return = encodeURIComponent($('input[name=\'is_return\']:checked').val())	
	var txtFrom = encodeURIComponent($('#txtFrom').attr('datavalue'));
	var txtTo = encodeURIComponent($('#txtTo').attr('datavalue'));
	var txtDateFrom = encodeURIComponent($('#txtDateFrom').val());
	var txtDateTo = encodeURIComponent($('#txtDateTo').val());
	var cboAdults = encodeURIComponent($('#cboAdults').val());
	var cboChildren = encodeURIComponent($('#cboChildren').val());
	var cboInfant = encodeURIComponent($('#cboInfant').val());
	var divLoadingContent = '<div id="divLoadingContent"><div style="text-align:center;"><p>Hệ thống đang xử lý. Quý khách vui lòng đợi trong giây lát...</p><img src="/layout/airlines/images/loadingbar.gif" alt="Loading..." /></div></div>';
	$.ajax({
		url: "/GetResultInternational.html",
		type: "POST",
		dataType: "xml",
		data: { action_type: "SEARCHDEPART", page: page, pagesize: pagesize, is_return: is_return, txtFrom: txtFrom, txtTo: txtTo, txtDateFrom: txtDateFrom, txtDateTo: txtDateTo, cboAdults: cboAdults, cboChildren: cboChildren, cboInfant: cboInfant},
		success: function (data) {
			$("#show_banner").hide();
			$(data).find('status').each(function () {
				if ($(this).attr("code") == "1") {
					var result = '<div id="divTabFlightSeparate"><div id="divTabFlightSeparateResult">'+$(this).text()+'</div></div>';
					$("#flightResultMainContentInter").html(result);
					if($("#flightResultMainContent #stepResultFlight").text() == '')
						$('#tbs li a').last().click();
				} else {
					var result = '<div id="divTabFlightSeparate"><div id="divTabFlightSeparateResult"><div style="text-align:center;padding:80px 20px;text-align:center">Không có lịch bay cho ngày này hoặc Tất cả các chuyến bay đã hết chỗ.<br>Quý khách có thể chọn xem các ngày lân cận hoặc liên hệ VLINK để có thêm thông tin chi tiết!</div></div></div>';
                    $("#flightResultMainContentInter").html(result);
				}
			});
		}, beforeSend: function () {
			$('html, body').animate({ scrollTop: 100 }, 'slow');
			$("#flightResultMainContentInter").html(divLoadingContent);
			$("#show_banner").show();
		},
		error: function () {
			/*reload_die += 1;
			if(reload_die<3)
				InternationalSearch();
			var msg = "FAIL";
			$("#flightResultMainContentInter").html(msg);*/
		}
	});	
	return false;}
function InternationalSearchV1(url){
	var linkUrl = '/GetResultInternational.html';
	var dateTo = '';
	if($('#is_return_1').attr('checked')){
		dateTo = $('#txtDateTo').val();
	}
	var divLoadingContent = '<div id="divLoadingContent"><div style="text-align:center;"><p>Hệ thống đang xử lý. Quý khách vui lòng đợi trong giây lát...</p><img src="/layout/airlines/images/loadingbar.gif" alt="Loading..." /></div></div>';
	$.ajax({
		type: 'POST',
		url: linkUrl,
		data: 'mode=2&isAjaxCall=true&is_return=' + encodeURIComponent($('input[name=\'is_return\']:checked').val()) + '&txtFrom=' + encodeURIComponent($('#txtFrom').attr('datavalue')) + '&txtTo=' + encodeURIComponent($('#txtTo').attr('datavalue'))+ '&txtDateFrom=' + encodeURIComponent($('#txtDateFrom').val())+ '&txtDateTo=' + encodeURIComponent(dateTo)+ '&cboAdults=' + encodeURIComponent($('#cboAdults').val())+ '&cboChildren=' + encodeURIComponent($('#cboChildren').val())+ '&cboInfant=' + encodeURIComponent($('#cboInfant').val()),
		beforeSend: function() {
			$(".desc").html('Vui lòng đợi...');
			$("#btnSearch").attr('disabled', true);
			$("#flightResultMainContent").html(divLoadingContent);
			$("#show_banner").show();
		},
		complete: function() {
			$(".desc").html('Tìm chuyến bay');
			$("#btnSearch").attr('disabled', false);
			stopMarqueUp();
			step2();
		},
		success: function(data) {
			$("#show_banner").hide();
			$(".block_id_422").show();
			$('#flightResultMainContent').html(data);							
		}
	});
	return false;
}
function TigerAirwaysSearch(){
	var dateTo = '';
	if($('#is_return_1').attr('checked')){
		dateTo = $('#txtDateTo').val();
	}
	var divLoadingContent = '<div id="divLoadingContent"><div style="text-align:center;"><p>Hệ thống đang xử lý. Quý khách vui lòng đợi trong giây lát...</p><img src="/layout/airlines/images/loadingbar.gif" alt="Loading..." /></div></div>';
	var time = (new Date).getTime();
	$.ajax({
		type: 'POST',
		url: '/ve-may-bay-truc-tuyen.html',
		data: 'mode=2&isAjaxCall=true&is_return=' + encodeURIComponent($('input[name=\'is_return\']:checked').val()) + '&txtFrom=' + encodeURIComponent($('#txtFrom').attr('datavalue')) + '&txtTo=' + encodeURIComponent($('#txtTo').attr('datavalue'))+ '&txtDateFrom=' + encodeURIComponent($('#txtDateFrom').val())+ '&txtDateTo=' + encodeURIComponent(dateTo)+ '&cboAdults=' + encodeURIComponent($('#cboAdults').val())+ '&cboChildren=' + encodeURIComponent($('#cboChildren').val())+ '&cboInfant=' + encodeURIComponent($('#cboInfant').val())+'&RequestTime='+time,
		beforeSend: function() {
			$(".desc").html('Vui lòng đợi...');
			$("#btnSearch").attr('disabled', true);
			$("#flightResultMainContent").html(divLoadingContent);
			$("#show_banner").show();
		},
		complete: function() {
			$(".desc").html('Tìm chuyến bay');
			$("#btnSearch").attr('disabled', false);
			stopMarqueUp();
			step2();
		},
		success: function(data) {
			$("#show_banner").hide();
			$(".block_id_422").show();
			$('#flightResultMainContent').html(data);
			if($('#flightItem_Header_start .Col_Price'))
				sortBy('ticketprice','start',$('#flightItem_Header_start .Col_Price'));	
			if($('#flightItem_Header_return .Col_Price'))
				sortBy('ticketprice','return',$('#flightItem_Header_return .Col_Price'));								
		}
	});
	return false;}

function TabsFlightSearch(air){
	var dateTo = '';
	if($('#is_return_1').attr('checked')){
		dateTo = $('#txtDateTo').val();
	}
	var divLoadingContent = '<div id="divLoadingContent"><div style="text-align:center;"><p>Hệ thống đang xử lý. Quý khách vui lòng đợi trong giây lát...</p><img src="/layout/airlines/images/loadingbar.gif" alt="Loading..." /></div></div>';
	$.ajax({
		type: 'POST',
		url: '/ve-may-bay-truc-tuyen.html',
		data: 'mode=2&isAjaxCall=true&AirlineCode='+air+'&is_return=' + encodeURIComponent($('input[name=\'is_return\']:checked').val()) + '&txtFrom=' + encodeURIComponent($('#txtFrom').attr('datavalue')) + '&txtTo=' + encodeURIComponent($('#txtTo').attr('datavalue'))+ '&txtDateFrom=' + encodeURIComponent($('#txtDateFrom').val())+ '&txtDateTo=' + encodeURIComponent(dateTo)+ '&cboAdults=' + encodeURIComponent($('#cboAdults').val())+ '&cboChildren=' + encodeURIComponent($('#cboChildren').val())+ '&cboInfant=' + encodeURIComponent($('#cboInfant').val()),
		beforeSend: function() {
			$(".desc").html('Vui lòng đợi...');
			$("#btnSearch").attr('disabled', true);
			$("#flightResultMainContent").html(divLoadingContent);
			$("#show_banner").show();
		},
		complete: function() {
			$(".desc").html('Tìm chuyến bay');
			$("#btnSearch").attr('disabled', false);
			stopMarqueUp();
			step2();
		},
		success: function(data) {
			$("#show_banner").hide();
			$('#flightResultMainContent').html(data);
			if($('#flightItem_Header_start .Col_Price'))
				sortBy('ticketprice','start',$('#flightItem_Header_start .Col_Price'));	
			if($('#flightItem_Header_return .Col_Price'))
				sortBy('ticketprice','return',$('#flightItem_Header_return .Col_Price'));								
		}
	});
	return false;
}
function convert_dmy2ymd(dmy){
	var Str = ""+dmy;
	var dmy_arr  =  Array();
	dmy_arr = Str.split('-');
	return dmy_arr[2]+'-'+dmy_arr[1]+'-'+dmy_arr[0];		
}
var SubmitID = '';

function getAirportCode(str){
	if(str) {
		var arrayStr = str.match(/([A-Z]{3,3})/g);
		return arrayStr[0];
	}
}
function sIter(from_code,to_code,date_depart,date_return,adult,children,infant){
	var formSubmit = '';
	var txtFrom = from_code.split(',')[1];
	var txtTo = to_code.split(',')[1];
	var tSt = '00_cphCon';
	$('#ctl00_cphCon'+'tent_txtFrom').val(txtFrom);			
	$('#ctl00_cphContent_txtTo').val(txtTo);
	SubmitID = getAirportCode(txtFrom)+','+getAirportCode(txtTo)+','+date_depart;	
	if(date_return)
		SubmitID = SubmitID + ',' + date_return;
	date_depart = convert_dmy2ymd(date_depart);
	if(date_return)
		date_return = convert_dmy2ymd(date_return);
			
	tSt=tSt+'tent_btnSearchTr';
	$('#ctl00_cphContent_hfDepartDate').val(date_depart);
	$('#ctl00_cphContent_hfReturnDate').val(date_return);
	$('#ctl00_cphContent_ddlPaxAdult').val(adult);
	$('#ctl00_cphContent_ddlPaxChild').val(children);
	$('#ctl00_cphCon'+'tent_ddlPaxInfant').val(infant);
	if(!date_return){$('#ctl00'+'_cphContent_rbOneWay').attr('checked','checked');} 
	else {$('#ctl00_cphContent_rbRoundTrip').attr('checked','checked');}
	$('#aspnetForm').attr('action','https://abacuswebstart.abacus.com.sg/vlink/flight-search.aspx');
	$('#ctl'+tSt).click();
	//$("#aspnetForm").submit();
}
function btnSearch_onClick(){
	var wait=0;
	if(checkValid()) {
		if(!wait){
			wait=1; 				
			var from = $.trim($('input[name=\'txtFrom\']').attr('datavalue').split(',')[0]);
			var to = $.trim($('input[name=\'txtTo\']').attr('datavalue').split(',')[0]);	
			detectSearch(from,to);
		} 
	}
	return false;
}
function btnSearchV1_onClick(){
	var wait=0;
	if(checkValid()) {
		if(!wait){
			wait=1; 				
			var from = $.trim($('input[name=\'txtFrom\']').attr('datavalue').split(',')[0]);
			var to = $.trim($('input[name=\'txtTo\']').attr('datavalue').split(',')[0]);	
			var dateTo = '';
			if($('#is_return_1').attr('checked')){
				dateTo = $('input[name=\'txtDateTo\']').val();
			}
			var divLoadingContent = '<div id="divLoadingContent"><div style="text-align:center;"><p>Hệ thống đang xử lý. Quý khách vui lòng đợi trong giây lát...</p><img src="/layout/airlines/images/loadingbar.gif" alt="Loading..." /></div></div>';
			$.ajax({
				type: 'POST',
				url: '/ve-may-bay-truc-tuyen-v1/',
				data: 'mode=2&isAjaxCall=true&is_return=' + encodeURIComponent($('input[name=\'is_return\']:checked').val()) + '&txtFrom=' + encodeURIComponent($('input[name=\'txtFrom\']').attr('datavalue')) + '&txtTo=' + encodeURIComponent($('input[name=\'txtTo\']').attr('datavalue'))+ '&txtDateFrom=' + encodeURIComponent($('input[name=\'txtDateFrom\']').val())+ '&txtDateTo=' + encodeURIComponent(dateTo)+ '&cboAdults=' + encodeURIComponent($('input[name=\'cboAdults\']').val())+ '&cboChildren=' + encodeURIComponent($('input[name=\'cboChildren\']').val())+ '&cboInfant=' + encodeURIComponent($('input[name=\'cboInfant\']').val()),
				beforeSend: function() {
					$(".desc").html('Vui lòng đợi...');
					$("#btnSearch").attr('disabled', true);
					step1();						
					$("#cart").html("");
					$('#flightResultMainContent').html(divLoadingContent);
				},
				complete: function() {
					$(".desc").html('Tìm chuyến bay');
					$("#btnSearch").attr('disabled', false);
					stopMarqueUp();
					step2();
					$('.block_id_339').hide();
					$('.block_id_279').hide();
					$('.block_id_401').hide();
				},
				success: function(data) {
					if (data) {
						$('#flightResultMainContent').html(data);
						if($('#flightItem_Header_start .Col_Price'))
							sortBy('ticketprice','start',$('#flightItem_Header_start .Col_Price'));	
						if($('#flightItem_Header_return .Col_Price'))
							sortBy('ticketprice','return',$('#flightItem_Header_return .Col_Price'));								
					} 
				}
			});
		} 
	}	
	return false;
}
function TigerAirwaysSearchV1(){
	var dateTo = '';
	if($('#is_return_1').attr('checked')){
		dateTo = $('#txtDateTo').val();
	}
	var divLoadingContent = '<div id="divLoadingContent"><div style="text-align:center;"><p>Hệ thống đang xử lý. Quý khách vui lòng đợi trong giây lát...</p><img src="/layout/airlines/images/loadingbar.gif" alt="Loading..." /></div></div>';
	$.ajax({
		type: 'POST',
		url: '/ve-may-bay-truc-tuyen-v1.html',
		data: 'mode=2&isAjaxCall=true&is_return=' + encodeURIComponent($('input[name=\'is_return\']:checked').val()) + '&txtFrom=' + encodeURIComponent($('#txtFrom').attr('datavalue')) + '&txtTo=' + encodeURIComponent($('#txtTo').attr('datavalue'))+ '&txtDateFrom=' + encodeURIComponent($('#txtDateFrom').val())+ '&txtDateTo=' + encodeURIComponent(dateTo)+ '&cboAdults=' + encodeURIComponent($('#cboAdults').val())+ '&cboChildren=' + encodeURIComponent($('#cboChildren').val())+ '&cboInfant=' + encodeURIComponent($('#cboInfant').val()),
		beforeSend: function() {
			$(".desc").html('Vui lòng đợi...');
			$("#btnSearch").attr('disabled', true);
			$("#flightResultMainContent").html(divLoadingContent);
			$("#show_banner").show();
		},
		complete: function() {
			$(".desc").html('Tìm chuyến bay');
			$("#btnSearch").attr('disabled', false);
			stopMarqueUp();
			step2();
		},
		success: function(data) {
			$("#show_banner").hide();
			$('#flightResultMainContent').html(data);
			if($('#flightItem_Header_start .Col_Price'))
				sortBy('ticketprice','start',$('#flightItem_Header_start .Col_Price'));	
			if($('#flightItem_Header_return .Col_Price'))
				sortBy('ticketprice','return',$('#flightItem_Header_return .Col_Price'));								
		}
	});
	return false;
}
function btnClickSearch_onClick(){
	var wait=0;
	if(checkValid()) {
		if(!wait){
			wait=1; 	
			var dateTo = '';
			if($('#is_return_1').attr('checked')){
				dateTo = $('#txtDateTo').val();
			}			
			var airlines = $('#airlines_id').val();
			var txtFrom = getAirportCode(encodeURIComponent($('#txtFrom').attr('datavalue').split(',')[1]));
			var txtTo = getAirportCode(encodeURIComponent($('#txtTo').attr('datavalue').split(',')[1]));
			var txtDateFrom = encodeURIComponent($('#txtDateFrom').val());
			var cboAdults = encodeURIComponent($('#cboAdults').val());
			var cboChildren = encodeURIComponent($('#cboChildren').val());
			var cboInfant = encodeURIComponent($('#cboInfant').val());
			var cat = encodeURIComponent($('#cat').val());
			var host = '';
			var wID = 1;
			if(wID == 1){
				host = 'http://booking.vlink.vn';	
			}
			var url = host+'/tim-chuyen-bay/tu/'+txtFrom.toLowerCase()+'/den/'+txtTo.toLowerCase()+'/di-ngay/'+txtDateFrom;
			if(dateTo)
				url += '/ve-ngay/'+dateTo;
			if(airlines){	
				url += '/hang-bay/'+airlines;
			}
			url += '/pax/'+cboAdults+cboChildren+cboInfant+'/';
			if(cat){
				url += 'cat/'+ cat+'/';	
			}
			window.location.href = url;
		} 
	}
}
function GotoTabs(i,url){
	window.open(url+i);
}
function GetMinPriceItinerary(obj,direction) {
	var delay = 500;
	var delayReturn = 10000;
	var sCall = function() {
		$.ajax({
			url: "/ve-may-bay-truc-tuyen/",
			cache:false,
			traditional: true,
			type: "POST",
			dataType: "html",
			data: 'server=VPS&mode=10&isAjaxCall=true&txtFrom='+obj.attr('from_code')+'&txtTo='+obj.attr('to_code')+'&txtDateFrom='+obj.attr('date_depart')+'&txtDateTo='+obj.attr('date_return')+'&cboAdults='+obj.attr('adult')+'&cboChildren='+obj.attr('children')+'&cboInfant='+obj.attr('infant')+'&direction='+direction,
			beforeSend: function () {
				$(obj).append('<br/><img align="absmiddle" class="img-waiting" alt="" src="/layout/airlines/images/ajax-loader-blue16x11.gif">');
			},
			success: function(output){
				$(obj).find(".img-waiting").remove();
				if(output == 0) 
					output = 'Hết vé';
				$(obj).append('<span class="price">'+output+'</span>');
				//clearTimeout(t);
			},
		});
	}
	switch($(obj).attr('class')) {
		case 'index_2':
			delay = 500;
			break;
		case 'index_4':
			delay = 4000;
			break;
		case 'index_1':
			delay = 6000;
			break;
		case 'index_5':
			delay = 8000;
			break;
		case 'index_0':
			delay = 10000;
			break;	
		case 'index_6':
			delay = 12000;
			break;
		default:
			delay = 500;
			break;						
	}
	if(direction == 'return')
		delay += delayReturn;
	t = setTimeout(sCall, delay);
	return false;} 
function getFlightRelated(){
	var DepartureAirportCode = $("#DepartureAirportCode").val();
	var ArrivalAirportCode = $("#ArrivalAirportCode").val();
	var DepartureAirportDate = $("#DepartureAirportDate").val();
	var ArrivalAirportDate = $("#ArrivalAirportDate").val();
	$.ajax({
		type: 'POST',
		url: '/gia-re-hang-ngay.html',
		data: 'do=related&from='+DepartureAirportCode+'&to='+ArrivalAirportCode+'&dfrom='+DepartureAirportDate+'&dto='+ArrivalAirportDate,
		beforeSend: function() {
			showProgress("#related","/layout/airlines/images/ajaxloader.gif");
		},
		complete: function() {
			hideProgress("#related");
		},
		success: function(data) {
			if (data) {
				$('#related').html(data);
			}
		}
	});	
}