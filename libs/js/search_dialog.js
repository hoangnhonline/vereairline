var NCTAdvancedSearch =  {
    isLoading: false,
    validatesentmail: function () {
        var isValidEmail = true;
        var email = $('#emailCustomer').val();
        if (email !== '' && !share.flight_search_dialog.isValidEmailCustom(email)) {
            isValidEmail = false;
        }
        return isValidEmail;
    },

    isValidEmailCustom: function (email) {
       // var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        var re = /^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$/;
        return re.test(email);
    },
    
    
    
    load: function () {

        //initLocationCookie();
        
        $("input[name=JourneyType]:radio").on("change", function () {
            if ($(this).is(':checked') && $(this).attr('id') === 'radioOneWay') {
                $('#returnDate').attr('disabled', 'disabled');
                $('#returnDate').val('');
            } else
                $('#returnDate').removeAttr('disabled');
        });

        $('.mooncalendar').bind('click', function () {
            //var win = window.open('http://www.informatik.uni-leipzig.de/~duc/amlich/PHP/index.php', 'Tra cứu lịch âm', 'width=500,height=550');
            $('#popup')
                .html("<iframe src='http://www.informatik.uni-leipzig.de/~duc/amlich/PHP/index.php\' width='500' height='600'></iframe>")
                .dialog(
                {
                    title: 've24h.vn',
                    width: 550,
                    height: 600,
                    modal: true
                }).dialog("open");
        });

        $('.dateicon').bind('click', function () {
            var $input = $(this).prev();
            if ($input.attr('disabled') !== 'disabled')
                $input.datepicker('show');
        });

        $('#flightSearchForm').submit(function (event) {
            
            var msg = '';
            var success = true;
            var count = 0;
            if ($('#DepartureCity').val() == '') {
                msg += 'Vui lòng chọn điểm khởi hành <br />';
                success = false;
                count++;
                $('#search-error-dlg').attr('data-error', '1');
            }
            if ($('#ArrivalCity').val() == '') {
                msg += 'Vui lòng chọn điểm đến <br />';
                success = false;
                if (count == 0) {
                    count=2;
                    $('#search-error-dlg').attr('data-error', '2');
                }
            }
            if ($('#depatureDate').val() == '') {
                msg += 'Vui lòng chọn ngày đi <br />';
                success = false;
                if (count == 0) {
                    count = 3;
                    $('#search-error-dlg').attr('data-error', '3');
                }
            }
           
            if ($('#radioRoundTrip').is(':checked') && ($('#returnDate').val() == 'Ngày về' || $('#returnDate').val() == '')) {                
                msg += 'Vui lòng chọn ngày về <br />';
                success = false;
                if (count == 0) {
                    count = 4;
                    $('#search-error-dlg').attr('data-error', '4');
                }                
            }

            if (!success) {
                $("#search-error-dlg #errormessage").html(msg);
                event.preventDefault();
                //window.dialog.display(msg, 'Error');
                $dialogerorr.dialog('option', 'title', 'Lỗi phát sinh');
                //$dialogerorr.dialog('option', 'position', { my: "left top", at: "left bottom", of: e.target });
                $dialogerorr.dialog('open');
                
            } else {
                saveLocationCookie();

                $("#search-error-dlg #errormessage").html("");
                $('#search-error-dlg').attr('data-error', '0');
            }            
        });
        
        function initLocationCookie() {
            
            // Do not save cookie for mobile layout
            if ($('#DepartureCity-Holder').prop('tagName') == 'SELECT')
                return;

            if ($.cookie('departureCityHolder') == null) {
                $.cookie('departureCityHolder', 'Hồ Chí Minh (SGN)');
            }
            if ($.cookie('arrivalCityHolder') == null) {
                $.cookie('arrivalCityHolder', 'Hà Nội (HAN)');
            }
            if ($.cookie('journeyType') == null) {
                $.cookie('journeyType', '1');
            }

            $('#DepartureCity-Holder').val($.cookie('departureCityHolder'));
            var departureLoc = $('#DepartureCity-Holder').val();
            var departureLocationId = departureLoc.substring(departureLoc.indexOf('(') + 1, departureLoc.lastIndexOf(')'));
            $('#DepartureCity').val(departureLocationId);

            $('#ArrivalCity-Holder').val($.cookie('arrivalCityHolder'));
            var arrivalLoc = $('#ArrivalCity-Holder').val();
            var arrivalLocationId = arrivalLoc.substring(arrivalLoc.indexOf('(') + 1, arrivalLoc.lastIndexOf(')'));
            $('#ArrivalCity').val(arrivalLocationId);
            
            if ($.cookie('depatureDate') != null)
            {
                $('#depatureDate').val($.cookie('depatureDate'));
            }
            if ($.cookie('returnDate') != null && $("input[name='JourneyType']:checked").val() == '2') {
                $('#returnDate').val($.cookie('returnDate'));
            }
            if ($.cookie('adultNo') != null) {
                $('#adultNo').val($.cookie('adultNo'));
            }
            if ($.cookie('childNo') != null) {
                $('#childNo').val($.cookie('childNo'));
            }
            if ($.cookie('infantNo') != null) {
                $('#infantNo').val($.cookie('infantNo'));
            }

            // This code has no effect
            //if ($.cookie('journeyType') != null) {
            //    $("input[name=JourneyType][value=" + $.cookie('journeyType') + "]").prop('checked', true);
            //}

            
        }
        
        function saveLocationCookie() {
            $.cookie('departureCityHolder', $('#DepartureCity-Holder').val());
            $.cookie('arrivalCityHolder', $('#ArrivalCity-Holder').val());
            $.cookie('depatureDate', $('#depatureDate').val());
            $.cookie('returnDate', $('#returnDate').val());
            $.cookie('adultNo', $('#adultNo').val());
            $.cookie('childNo', $('#childNo').val());
            $.cookie('infantNo', $('#infantNo').val());
            $.cookie('journeyType', $("input[name='JourneyType']:checked").val());
        }

        /*$('.sponsor-holder').carouFredSel({
            direction: 'right',
            scroll: {
                items: 1
            },
            duration:3000
        });*/
        

        var choseLocationFromDialog = false;

        var $dialog = $('#departure-location-dlg').dialog(
                {
                    modal: false,
                    width: 530,
                    autoOpen: false,
                    resizable: false,
                    open: function () {
                        $('#inter-city-departure').focus();
                    },
                    close: function () {
                        $dialog.dialog('close');
                        
                        //****************************************************************************************
                        // Fix bugs: some do not auto popup the next component after selecting current component 
                        //****************************************************************************************
                        //debugger;
                        var keySearch = $("#UseSearchAutoFocusComponent").val().toLowerCase();                       
                        if (keySearch == "true") {
                            var mode = $('#departure-location-dlg').attr('data-mode');
                            if (mode == "Departure") {
                                if ($('#DepartureCity-Holder').val() != "Điểm khởi hành") {
                                    $('#ArrivalCity-Holder').select();
                                } else {
                                    $('#DepartureCity-Holder').focus();
                                }
                            } else {
                                if ($('#ArrivalCity-Holder').val() != "Nơi đến") {
                                    $('#depatureDate').focus();
                                } else {
                                    $('#ArrivalCity-Holder').focus();
                                }
                            }
                        }
                    }
                });
        
        var $dialogerorr = $('#search-error-dlg').dialog(
                {
                    modal: false,
                    width: 300,
                    autoOpen: false,
                    resizable: false,
                    open: function () {
                        
                    },
                    close: function () {
                        $dialogerorr.dialog('close');
                        var count = $('#search-error-dlg').attr('data-error');
                        switch (count) {
                            case '1':
                                $('#DepartureCity-Holder').focus();
                                break;
                            case '2':
                                $('#ArrivalCity-Holder').focus();
                                break;
                            case '3':
                                $('#depatureDate').focus();
                                break;
                            case '4':
                                $('#returnDate').focus();
                                break;
                        }
                    }
                });
        

        $('#DepartureCity-Holder').bind('click', function (e) {
            $('.location-link').each(function () {
                $(this).show();
            });
            
            $('#departure-location-dlg').attr('data-mode', 'Departure');
            var dataTitleDeparture = $('#departure-location-dlg').attr('data-title-departure');
            $dialog.dialog('option', 'title', dataTitleDeparture);
            $dialog.dialog('option', 'position', { my: "left top", at: "left bottom", of: e.target });
            $('#departure-location-dlg').attr('data-id', this.id);
            $dialog.dialog('open');
        });

        $('#ArrivalCity-Holder').bind('click', function (e) {
            var theme = $('#Theme').val();
            var departureCity = $('#DepartureCity').val();

            if (theme == 'LienLucDia' || theme == 'Go365') {
                var flightConnection = [];
                $('#FlightConnection > option').each(function() {   
                    var fconnection = $(this).val();
                    if (fconnection == departureCity) {
                        flightConnection.push($(this).text());
                    }
                });

                $('.location-link').each(function () {                    
                    var locationId = $(this).attr('data-code');
                    var flag = false;
                    for (var i = 0; i < flightConnection.length; i++) {
                        if (locationId == flightConnection[i]) {                           
                            flag = true;
                            break;
                        }
                    }
                    if (flag == false) {
                        $(this).hide();
                    } else {
                        $(this).show();
                    }
                });
            }
            if (theme == 'Ve24h' || theme == 'CanhChimViet' || theme == 'EnViet') {
                $('.location-link').each(function () {
                    var locationId = $(this).attr('data-code');
                        if (locationId == departureCity) {
                            $(this).hide();
                        }
                });
            }
            $('#departure-location-dlg').attr('data-mode', 'Arrival');
            var dataTitleArrival = $('#departure-location-dlg').attr('data-title-arrival');
            $dialog.dialog('option', 'title', dataTitleArrival);
            $dialog.dialog('option', 'position', { my: "left top", at: "left bottom", of: e.target });
            $('#departure-location-dlg').attr('data-id', this.id);
            $dialog.dialog('open');
        });
        
        $('#ArrivalCity-Holder').bind('select', function (e) {            
            var theme = $('#Theme').val();
            var departureCity = $('#DepartureCity').val();

            if (theme == 'LienLucDia' || theme == 'Go365') {
                var flightConnection = [];
                $('#FlightConnection > option').each(function() {
                    var fconnection = $(this).val();
                    if (fconnection == departureCity) {
                        flightConnection.push($(this).text());
                    }
                });

                $('.location-link').each(function() {
                    var locationId = $(this).attr('data-code');                    
                    var flag = false;
                    for (var i = 0; i < flightConnection.length; i++) {
                        if (locationId == flightConnection[i]) {
                            flag = true;
                            break;
                        }
                    }
                    if (flag == false) {
                        $(this).hide();
                    } else {
                        $(this).show();
                    }
                });
            }
            if (theme == 'Ve24h' || theme == 'CanhChimViet' || theme == 'EnViet') {
                $('.location-link').each(function () {
                    var locationId = $(this).attr('data-code');
                    if (locationId == departureCity) {
                        $(this).hide();
                    }
                });
            }
            $('#departure-location-dlg').attr('data-mode', 'Arrival');//hang ghe
            var dataTitleArrival = $('#departure-location-dlg').attr('data-title-arrival');
            $dialog.dialog('option', 'title', dataTitleArrival);
            $dialog.dialog('option', 'position', { my: "left top", at: "left bottom", of: e.target });
            $('#departure-location-dlg').attr('data-id', this.id);
            $dialog.dialog('open');
        });
        
        $('#depatureDate').on('focus', function (e) {
            $('#departure-location-dlg').attr('data-date-mode', 'depaturedatefocus');
        });
        
        $('#returnDate').on('focus', function (e) {
            $('#departure-location-dlg').attr('data-date-mode', 'returndatefocus');
        });        
        
        $('#ui-datepicker-div').bind('mouseleave', function (e) {
            //************************************************************************************
            // Fix bugs: some do not auto popup the next component after selecting current component 
            //************************************************************************************
            var keySearch = $("#UseSearchAutoFocusComponent").val().toLowerCase();            
            if (keySearch == "true") {
                var focusvalue = $('#departure-location-dlg').attr('data-date-mode');
                if (focusvalue == "depaturedatefocus") {
                    if ($("input[name='JourneyType']:checked").val() == '2') {
                        $('#returnDate').focus();
                    }
                }
            }                       
        });

        $('.location-link').bind('click', function () {            
            var element = $('#departure-location-dlg').attr('data-id');
            $('#' + element).val($(this).attr('data-val'));
            var valuedElement = element.split('-')[0];
            $('#' + valuedElement).val($(this).attr('data-code'));
            $dialog.dialog('close');
        });                

        $("#inter-city-departure").autocomplete({
            delay: 100,
            source: '/Home/SearchLocation',
            select: function (event, ui) {
                $("#inter-city-departure").val(ui.item.label);                
                choseLocationFromDialog = true;
                return false;
            },
        });
        
        $('#inter-city-departure').bind('keydown', function (event) {
            if (event.which == 13 || event.keyCode == 13) {
                var location = $('#inter-city-departure');
                var loc = location.val();
                if (loc.length > 0 && choseLocationFromDialog) {
                    var element = $('#departure-location-dlg').attr('data-id');
                    $('#' + element).val(loc);
                    var valuedElement = element.split('-')[0];
                    var locationId = loc.substring(loc.indexOf('(') + 1, loc.lastIndexOf(')'));
                    $('#' + valuedElement).val(locationId);
                    $('#inter-city-departure').val('');
                }
                
                $dialog.dialog('close');
            }
        });

        $('#btnChooseLocation').bind('click', function () {
            var location = $('#inter-city-departure');
            var loc = location.val();
            if (location.prop('tagName') == 'SELECT') {
                if (location.val() == null || location.val() == '-1')
                    return;
                loc = $('#inter-city-departure option:selected').text();
                choseLocationFromDialog = true;
            }
            
            if (loc.length > 0 && choseLocationFromDialog) {
                var element = $('#departure-location-dlg').attr('data-id');
                $('#' + element).val(loc);
                var valuedElement = element.split('-')[0];
                var locationId = loc.substring(loc.indexOf('(') + 1, loc.lastIndexOf(')'));
                $('#' + valuedElement).val(locationId);
                $('#inter-city-departure').val('');
            }
            $dialog.dialog('close');
        });

        $('.show-detail-flight').bind('click', function () {
            var $link = $(this);
            $('#DepartureCity').val($link.attr('data-departure-code'));
            $('#ArrivalCity').val($link.attr('data-arrival-code'));
            $('#adultNo').val(1);
            $('#childNo #infantNo').val(0);
            $('#depatureDate').val($link.attr('data-date'));
            $('#radioOneWay').click();
            $('#IsDetailAction').val(true);
            $('form').submit();
        });
        
        $('#btnSentEmail').bind('click', function () {
            var email = $('#emailCustomer').val();
            var validationResult = share.flight_search_dialog.validatesentmail();
            if (!validationResult) {
                var msg = "Nhập Email không đúng định dạng!";
                window.dialog.display(msg, 'Error');
                return false;
            } else {
                var url = "/Home/SaveEmailRegistration";
                var datasend = {
                    Email: email
                };

                $.ajax({
                    type: "POST",
                    url: url,
                    data: JSON.stringify(datasend),
                    dataType: "json",
                    contentType: "application/json;charset=utf-8",
                    success: function (response) {
                        if (response.Success) {
                            window.dialog.display("Đăng ký Email thành công!", 'Thông báo');
                        } else {
                            window.dialog.display("Đăng ký Email không thành công!", 'Lỗi phát sinh');
                        }
                    },
                    complete: function () {
                        $.unblockUI();
                    }
                });
            }
        });
        
    },
    
    showNoteYearOldArticle: function (articleId) {
        //
        var $dialogNoteYearOld = $('#NoteYearOldDialog').dialog({
            title: '',
            close: function () {
                $dialogNoteYearOld.dialog("destroy");
            },
            modal: true,
            autoOpen: false,
            width: 520
        });
        $dialogNoteYearOld.dialog('open');
        $('#YearOldDialogCondition').addClass('hide');
        $('#YearOldDialogConditionContent').text('');
        $.ajax({
            url: '/Home/GetNoteYearOldArticle',
            type: 'POST',
            data: {
                articleId: articleId
            },
            //contentType: 'application/json; charset=UTF-8',
            success: function (response) {
                if (response.HasData) {
                    $('#YearOldDialogCondition').removeClass('hide');
                    $('#YearOldDialogConditionContent').html(response.Content);
                }
            }
        });
    }
    
}