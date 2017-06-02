$(document).ready(function() {
	//NCTAdvancedSearch.load();
	/*$('.advLeft, .advRight').advScroll({
		easing:'easeOutBack',
		timer:1000
	});
	
	jQuery('.box_skitter_large').skitter({numbers_align:'right', interval: 3000, preview: true, velocity: 2, animation: "random", label: false});
*/
    $('#national_type2').click(function(){
        $('#nuocngoai').show();
        $('#noidia').hide();
    });
    $('#national_type1').click(function(){
        $('#nuocngoai').hide();
        $('#noidia').show();
    });
	$( "#dialog-form" ).dialog({
	      autoOpen: false,
	      resizable: false,
	      width: 550,
	      modal: false,
	      buttons: {
	        Cancel: function() {
	          $( this ).dialog( "close" );
	        }
	      },
	      close: function() {
	    	  $( this ).dialog( "close" );
	      } 
	    });
	 
	    $( "#departureCity, #arrivalCity" ).click(function() {
	    	var title = '';
	    	if($(this).attr('id') == "departureCity"){
                $('#dialog-form').find('.inter-city-arrival').val('');
                $('#dialog-form').find('.inter-city-arrival').attr('data-type','departureCity');
	    		title = 'Lựa chọn thành phố hoặc sân bay xuất phát';
	    	}else if($(this).attr('id') == "arrivalCity"){
                $('#dialog-form').find('.inter-city-arrival').val('');
                $('#dialog-form').find('.inter-city-arrival').attr('data-type','arrivalCity');
	    		title = 'Lựa chọn thành phố hoặc sân bay đến';
	    	}
	    	$( "#dialog-form" ).dialog( {title: title}).dialog( "open");
	    	    	
	    	var deOffset = $(this).offset();
	        //var arrOffset = $("#departureCity").offset();
	        var inputHeight = $(this).height() + 4 - $(window).scrollTop();
	        
	        $( "#dialog-form" ).attr('data-id', $(this).attr('id'));
	        $( "#dialog-form" ).dialog( "option", 'position', [deOffset.left, deOffset.top + inputHeight] );
	      });

    $('#btnChooseLocation').click(function(){
        var selector = $('.inter-city-arrival').attr('data-type');
        $('#'+selector).val($('.inter-city-arrival').val());
        $( "#dialog-form" ).dialog( "close" );
    });

	    /*$( "#depatureDate" ).datepicker({
	        changeMonth: true,
	        changeYear: true,
	        dateFormat: "dd-mm-yy",
	        time24h:true,
	        showTime: true,
	        minDate: 0,
			maxDate: "+12m",
            dayNames: ["Chủ nhật", "Thứ 2", "Thứ 3", "Thứ 4", "Thứ 5", "Thứ 6", "Thứ 7"],
            dayNamesShort: ["CN","T2", "T3", "T4", "T5", "T6", "T7"],
            dayNamesMin: ["CN","T2", "T3", "T4", "T5", "T6", "T7"],
            showOn: 'both',
            buttonImageOnly: true,
            //buttonImage: "/libs/img/bg-select-date.png",
            onSelect: function( selectedDate ) {
                $("#returnDate" ).datepicker( "option", "minDate", selectedDate);
            }
	      });
	    
	    $( "#returnDate" ).datepicker({
	        changeMonth: true,
	        changeYear: true,
	        dateFormat: "dd-mm-yy",
	        minDate: $('#depatureDate').val(),
			maxDate: "+12m",
            dayNames: ["Chủ nhật", "Thứ 2", "Thứ 3", "Thứ 4", "Thứ 5", "Thứ 6", "Thứ 7"],
            dayNamesShort: ["CN","T2", "T3", "T4", "T5", "T6", "T7"],
            dayNamesMin: ["CN","T2", "T3", "T4", "T5", "T6", "T7"],
            showOn: 'both',
            buttonImageOnly: true,
            //buttonImage: "/libs/img/bg-select-date.png",
            onClose: function (value) {
                //$('input.hasDatepicker').val(value);
            }
	      });*/
	    
	    $('.location-link').on('click', function(){
	    	var dataId = $( "#dialog-form" ).attr('data-id');
	    	var value = $(this).attr('data-val');
	    	var code = $(this).attr('data-code');
	    	
	    	if(dataId == "departureCity"){
		    	$('#departureCityCode').val(code);
		    	$('#departureCity').val(value);
	    	}else if(dataId == "arrivalCity"){
	    		$('#arrivalCityCode').val(code);
		    	$('#arrivalCity').val(value);
	    	}
	    	$( "#dialog-form" ).dialog('close');
	    });
	    
	    $('.select-province').change(function(){
	        var id = $(this).find(':selected').attr('data-id');
	        var $this = $(this);

	        $.ajax({
	          type: 'POST',
	          url: '/ajax.html',
	          data: ({action: 'getDistrict', province_id:id}),
	          success: function(data){
	            response = jQuery.parseJSON(data);
	            var html = '';

	            jQuery.each(response, function(index, value) {
	              //alert( index + ": " + value.name_vi );
	              html += '<option value="'+value.name_vi+'">'+value.name_vi+'</option>';
	            });

	            $('#DistrictId').html(html);
	          }
	        });
        });



    if($(window).width() > 480){
        showPopup();
    }


    $('a#closepopup').click(function(){
        $('#popup').hide();
        $('body').removeClass('popup');

    });


    // The slider being synced must be initialized first
    $('#carousel').flexslider({
        animation: "slide",
        controlNav: false,
        animationLoop: false,
        slideshow: false,
        slideshowSpeed: 3000,
        itemWidth: 79,
        itemMargin: 2,
        asNavFor: '#slider'
    });

    $('#slider').flexslider({
        animation: "slide",
        controlNav: false,
        animationLoop: false,
        slideshow: true,
        slideshowSpeed: 3000,
        sync: "#carousel"
    });


    $('#main-menu .navbar-nav li.active').prev().css('border-right', '0px');
    $('#main-menu .navbar-nav li.active').prev().children('a').css('border-right', '0px');

    $('.datepicker').datepicker({
        minDate:0
    });


    $('#myTab a').click(function (e) {
        e.preventDefault()
        $(this).tab('show')
    });

    DropDown.prototype = {
        initEvents: function () {
            var obj = this;

            obj.dd.on('click', function (event) {
                $(this).toggleClass('active');
                return false;
            });

            obj.opts.on('click', function () {
                var opt = $(this);
                obj.val = opt.text();
                obj.index = opt.index();
                obj.placeholder.text(obj.val);
            });
        },
        getValue: function () {
            return this.val;
        },
        getIndex: function () {
            return this.index;
        }
    }

    $(function () {

        var dd = new DropDown($('#dd'));
        var dd = new DropDown($('#dd1'));
        var dd = new DropDown($('#dd2'));

        $(document).click(function () {
            // all dropdowns
            $('.wrapper-dropdown-1').removeClass('active');
        });

    });

    $('.wrapper-dropdown-1 .dropdown a').click(function(){
        var value = $(this).text();
        $(this).parents('.wrapper-dropdown-1').find("input[type='hidden']").val(value);
    });

    setInterval(function(){
        if($('#box-header .dk').hasClass('main-color2'))
            $('#box-header .dk').removeClass('main-color2');
        else
            $('#box-header .dk').addClass('main-color2');

    }, 500);

    //snowFall.snow(document.body, {image : "/libs/images/flake1.png", minSize: 10, maxSize:28,flakeCount : 90, maxSpeed : 7});
    //snowFall.snow(document.body, {round : true, minSize: 5, maxSize:8});
    santaGo();
/*
    var t = setInterval(
        function(){
            var documentHeight 		= $(document).height();
            var startPositionLeft 	= Math.random() * $(document).width() - 100;
            var startOpacity		= 0.5 + Math.random();
            var sizeFlake			= 10 + Math.random() * 20;
            var endPositionTop		= documentHeight - 40;
            var endPositionLeft		= startPositionLeft - 100 + Math.random() * 200;
            var durationFall		= documentHeight * 10 + Math.random() * 5000;
            $('#flake')
                .clone()
                .appendTo('body')
                .css(
                {
                    left: startPositionLeft,
                    opacity: startOpacity,
                    'font-size': sizeFlake
                }
            )
                .animate(
                {
                    top: endPositionTop,
                    left: endPositionLeft,
                    opacity: 0.5
                },
                durationFall,
                'linear',
                function() {
                    $(this).remove()
                }
            );
        }, 500);




		
    var snow = {};
    var snowflex = {};

    snowflex.create  = function(){
        var flex = document.createElement('div');
        flex.innerHTML		 	= "&#10052;";
        flex.style.fontSize 	= 12 + Math.random() * 20 + 'px';
        flex.style.top 			= - 50 + Math.random() * 20 + 'px';
        flex.style.left 		= Math.random() * 1500 + 'px';
        flex.style.position 	= "absolute";
        flex.style.color 		= "#fff";
        flex.style.opacity		= Math.random();
        document.getElementsByTagName('body')[0].appendChild(flex);
        return flex;
    };


    snow.snowflex = function(){
        var flex = snowflex.create();
        var x = -1 + Math.random() * 2;
        var t = setInterval(
            function(){
                flex.style.top 	= parseInt(flex.style.top) +  5 + 'px';
                flex.style.left = parseInt(flex.style.left) +  x + 'px';
                if (parseInt(flex.style.top) > 1500) {
                    clearInterval(t);
                    document.getElementsByTagName('body')[0].removeChild(flex);
                }
            }, 45 + Math.random() * 20);
    };

    snow.storm = function(){
        var t	= setInterval(
            function(){
                snow.snowflex();
            }, 500);
    };

    //snow.storm();

    var fog = {};

    fog.draw = function(ctx, x, y){

        ctx.fillStyle = "rgba( 255, 255, 255, " + Math.random() + " )";
        ctx.arc( x, y, 10,0,Math.PI*2,true);
        ctx.closePath();
        ctx.fill();

    };


    fog.start = function(){
        var ctx = document.getElementById('canvas').getContext("2d");
        var x = 0;
        var y = 0;
        var t = setInterval(
            function(){

                x = 300 + 300*Math.sin(x);
                y = 300 + 300* -Math.cos(x);

                x += 2;
                fog.draw(ctx, x, y);

            }, 100);

    };
	*/
 setInterval(function(){
                if($('#box-header .dk').hasClass('main-color2'))
                    $('#box-header .dk').removeClass('main-color2');
                else
                    $('#box-header .dk').addClass('main-color2');
    
        }, 500);
        //js theme tet
        
if (!Date.now)
    Date.now = function() { return new Date().getTime(); };

(function() {
    'use strict';
    
    var vendors = ['webkit', 'moz'];
    for (var i = 0; i < vendors.length && !window.requestAnimationFrame; ++i) {
        var vp = vendors[i];
        window.requestAnimationFrame = window[vp+'RequestAnimationFrame'];
        window.cancelAnimationFrame = (window[vp+'CancelAnimationFrame']
                                   || window[vp+'CancelRequestAnimationFrame']);
    }
    if (/iP(ad|hone|od).*OS 6/.test(window.navigator.userAgent) // iOS6 is buggy
        || !window.requestAnimationFrame || !window.cancelAnimationFrame) {
        var lastTime = 0;
        window.requestAnimationFrame = function(callback) {
            var now = Date.now();
            var nextTime = Math.max(lastTime + 16, now);
            return setTimeout(function() { callback(lastTime = nextTime); },
                              nextTime - now);
        };
        window.cancelAnimationFrame = clearTimeout;
    }
}());

var snowFalls = (function(){
    function jSnow(){
        // local methods
        var defaults = {
                flakeCount : 35,
                flakeColor : '#ffffff',
                flakeIndex: 999999,
                flakePosition: 'absolute',
                minSize : 1,
                maxSize : 2,
                minSpeed : 1,
                maxSpeed : 5,
                round : false,
                shadow : false,
                collection : false,
                image : false,
                collectionHeight : 40
            },
            flakes = [],
            element = {},
            elHeight = 0,
            elWidth = 0,
            widthOffset = 0,
            snowTimeout = 0,
            // For extending the default object with properties
            extend = function(obj, extObj){
                for(var i in extObj){
                    if(obj.hasOwnProperty(i)){
                        obj[i] = extObj[i];
                    }
                }
            },
            // random between range
            random = function random(min, max){
                return Math.round(min + Math.random()*(max-min)); 
            },
            // Set multiple styles at once.
            setStyle = function(element, props)
            {
                for (var property in props){
                    element.style[property] = props[property] + ((property == 'width' || property == 'height') ? 'px' : '');
                }
            },
            // snowflake
            flake = function(_el, _size, _speed)
            {
                // Flake properties
                this.x  = random(widthOffset, elWidth - widthOffset);
                this.y  = random(0, elHeight);
                this.size = _size;
                this.speed = _speed;
                this.step = 0;
                this.stepSize = random(1,10) / 100;

                if(defaults.collection){
                    this.target = canvasCollection[random(0,canvasCollection.length-1)];
                }
                
                var flakeObj = null;
                
                if(defaults.image){
                    flakeObj = new Image();
                    flakeObj.src = defaults.image;
                }else{
                    flakeObj = document.createElement('div');
                    setStyle(flakeObj, {'background' : defaults.flakeColor});
                }
                
                
                flakeObj.className = 'snowfall-flakes';
                setStyle(flakeObj, {'width' : this.size, 'height' : this.size, 'position' : defaults.flakePosition, 'top' : this.y, 'left' : this.x, 'fontSize' : 0, 'zIndex' : defaults.flakeIndex});
                
        
                // This adds the style to make the snowflakes round via border radius property 
                if(defaults.round){
                    setStyle(flakeObj,{'-moz-border-radius' : ~~(defaults.maxSize) + 'px', '-webkit-border-radius' : ~~(defaults.maxSize) + 'px', 'borderRadius' : ~~(defaults.maxSize) + 'px'});
                }
            
                // This adds shadows just below the snowflake so they pop a bit on lighter colored web pages
                if(defaults.shadow){
                    setStyle(flakeObj,{'-moz-box-shadow' : '1px 1px 1px #555', '-webkit-box-shadow' : '1px 1px 1px #555', 'boxShadow' : '1px 1px 1px #555'});
                }

                if(_el.tagName === document.body.tagName){
                    document.body.appendChild(flakeObj);
                }else{
                    _el.appendChild(flakeObj);
                }

                
                this.element = flakeObj;
                
                // Update function, used to update the snow flakes, and checks current snowflake against bounds
                this.update = function(){
                    this.y += this.speed;

                    if(this.y > elHeight - (this.size  + 6)){
                        this.reset();
                    }
                    
                    this.element.style.top = this.y + 'px';
                    this.element.style.left = this.x + 'px';

                    this.step += this.stepSize;
                    this.x += Math.cos(this.step);
                    
                    if(this.x + this.size > elWidth - widthOffset || this.x < widthOffset){
                        this.reset();
                    }
                }
                
                // Resets the snowflake once it reaches one of the bounds set
                this.reset = function(){
                    this.y = 0;
                    this.x = random(widthOffset, elWidth - widthOffset);
                    this.stepSize = random(1,10) / 100;
                    this.size = random((defaults.minSize * 100), (defaults.maxSize * 100)) / 100;
                    this.element.style.width = this.size + 'px';
                    this.element.style.height = this.size + 'px';
                    this.speed = random(defaults.minSpeed, defaults.maxSpeed);
                }
            },
            // this controls flow of the updating snow
            animateSnow = function(){
                for(var i = 0; i < flakes.length; i += 1){
                    flakes[i].update();
                }
                snowTimeout = requestAnimationFrame(function(){animateSnow()});
            }
        return{
            snow : function(_element, _options){
                extend(defaults, _options);
                
                //init the element vars
                element = _element;
                elHeight = element.offsetHeight;
                elWidth = element.offsetWidth;

                element.snow = this;
                
                // if this is the body the offset is a little different
                if(element.tagName.toLowerCase() === 'body'){
                    widthOffset = 25;
                }
                
                // Bind the window resize event so we can get the innerHeight again
                window.addEventListener('resize', function(){
                    elHeight = element.clientHeight;
                    elWidth = element.offsetWidth;
                }, true);
                
                // initialize the flakes
                for(i = 0; i < defaults.flakeCount; i+=1){
                    flakes.push(new flake(element, random((defaults.minSize * 100), (defaults.maxSize * 100)) / 100, random(defaults.minSpeed, defaults.maxSpeed)));
                }
                // start the snow
                animateSnow();
            },
            clear : function(){
                var flakeChildren = null;

                if(!element.getElementsByClassName){
                    flakeChildren = element.querySelectorAll('.snowfall-flakes');
                }else{
                    flakeChildren = element.getElementsByClassName('snowfall-flakes');
                }

                var flakeChilLen = flakeChildren.length;
                while(flakeChilLen--){
                    if(flakeChildren[flakeChilLen].parentNode === element){
                        element.removeChild(flakeChildren[flakeChilLen]);
                    }
                }

                cancelAnimationFrame(snowTimeout);
            }
        }
    };
    return{
        snow : function(elements, options){
            if(typeof(options) == 'string'){
                if(elements.length > 0){
                    for(var i = 0; i < elements.length; i++){
                        if(elements[i].snow){
                            elements[i].snow.clear();
                        }
                    }
                }else{
                    elements.snow.clear();
                }
            }else{
                if(elements.length > 0){
                    for(var i = 0; i < elements.length; i++){
                        new jSnow().snow(elements[i], options);
                    }
                }else{
                    new jSnow().snow(elements, options);
                }
            }
        }
    }
    
})();
	//snowFall.snow(document.body, {image : "/libs/image/h1.png", minSize: 15, maxSize:21,flakeCount : 7, maxSpeed : 5});
        //snowFall.snow(document.body, {image : "/libs/image/h2.png", minSize: 18, maxSize:23,flakeCount : 6, maxSpeed : 5});
        //snowFall.snow(document.body, {image : "/libs/image/h2.png", minSize: 23, maxSize:35,flakeCount : 5, maxSpeed : 6});
        //snowFall.snow(document.body, {image : "/libs/image/h3.png", minSize: 12, maxSize:17,flakeCount : 7, maxSpeed : 4});
        //snowFall.snow(document.body, {image : "/libs/image/h4.png", minSize: 18, maxSize:28,flakeCount : 9, maxSpeed : 6});
        //snowFall.snow(document.body, {image : "/libs/image/h4.png", minSize: 13, maxSize:21,flakeCount : 8, maxSpeed : 8});
        //snowFall.snow(document.body, {image : "/libs/image/h4.png", minSize: 18, maxSize:40,flakeCount : 4, maxSpeed : 3});
        //snowFall.snow(document.body, {image : "/libs/image/h4.png", minSize: 25, maxSize:50,flakeCount : 3, maxSpeed : 7});
//        snowFall.snow(document.body, {image : "/libs/image/l1.png", minSize: 8, maxSize:13,flakeCount : 11, maxSpeed : 2});
 //       snowFallowF.snow(document.body, {image : "/libs/image/l2.png", minSize: 6, maxSize:9,flakeCount : 12, maxSpeed : 4});
        //ket thuc js theme tet
});



function mycarousel_initCallback(carousel){

    // Pause autoscrolling if the user moves with the cursor over the clip.

    carousel.clip.hover(function() {

        carousel.stopAuto();

    }, function() {

        carousel.startAuto();

    });

};

function showPopup(){
    $('#popup').delay(10000).fadeIn(500, function() {
        $('body').addClass('popup');
    });

}
function DropDown(el) {
    this.dd = el;
    this.placeholder = this.dd.children('span');
    this.opts = this.dd.find('ul.dropdown > li');
    this.val = '';
    this.index = -1;
    this.initEvents();
}

function santaGo(){
    $(".santa-claus").delay(2000).animate({
        left:"+=2600px"}, 16000, function(){
        $(".santa-claus").css('left','2600px');
        $(".santa-claus").addClass('santa-claus-mirror');
    });
    $(".santa-claus").delay(1000).animate({left:"-=3500px"}, 21000, function(){
        $(".santa-claus").css('left','-630px');
        $(".santa-claus").removeClass('santa-claus-mirror');
        setTimeout(santaGo, 1000);
    });

}
