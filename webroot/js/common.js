(function($){
	'use strict';
    if(typeof window.ui === 'undefined'){
		var ui = window.ui = {}
	}
    ui.init = (function(_){
        (function deviceCheck(md){
			/* check device */
			_.isDevice   = md.mobile();		/* smart device	: ui.isDevice */
			_.isMobile   = md.phone();		/* mobile		: ui.isMobile */
			_.isTablet   = md.tablet();		/* tablet		: ui.isTablet */
			_.isDesktop  = !md.mobile();	/* desktop		: ui.isDesktop */
		})(new MobileDetect(window.navigator.userAgent));

		(function setViewport(viewport){
			if(_.isDesktop){
				/* set desktop viewport */
				//viewport.attr({'content':'width=1360, user-scalable=no'});
			}
			if(_.isTablet){
				/* set tablet viewport */
				/*viewport.attr({'content':'width=750, user-scalable=no'});*/
			}
			if(_.isMobile){
				/* set mobile viewport */
				// viewport.attr({'content':'width=750, user-scalable=no'});
			}
		})($('meta[name=viewport]'));

        var getElements = function(){
			_.$html			=	$('html');
			_.$body			=	$('body');
			_.$wrap			=	$('#wrap');
			_.$header		=	$('#header');
            _.$aside        =   $('#aside')
			_.$nav			=	$('#nav');
			_.$container	=	$('#container');
			_.$main			=	$('.main');
			_.$contents		=	$('#contents');
			_.$footer		=	$('#footer');
			_.$motion		=	$('.n-motion');
		}

        var getWindowSize = function(){
			_.winsizeW = $(window).outerWidth();
			_.winsizeH = $(window).outerHeight();
		}

        return{
            onLoad : function(){
                getElements();
                getWindowSize();
                ui.asideHeight();
                ui.selectDesign();
                _.headerAction();
                ui.actions();
                ui.tabSlide();		
                ui.tabSlide2();   
            },
            onResize : function(){
                getWindowSize();
                ui.asideHeight();
            },
            onScroll : function(){

            }
        }
    })(ui);
   
        
    ui.slider = (function(_){
        return {
            mainVisual :function(){                
               var total = $('.main-visual').find('.swiper-slide').length;    
                var mySwiper = new Swiper(".main-visual .swiper-container", {
                    slidesPerView: "auto",
                    autoplay: {
                        delay: 5000,
                        disableOnInteraction: false,
                    },
                    spaceBetween: 40,
                    loop:true,
                    centeredSlides: true,
                    navigation: {
                        nextEl: ".main-visual .swiper-button-next",
                        prevEl: ".main-visual .swiper-button-prev",
                    },
                    pagination: {
                        el: '.swiper-pagination.pagination-bottom, .swiper-pagination.pagination-num',
                        //type:'bullets, fraction',
                        clickable: true,
                        renderBullet: function (index, className) {
                            return '<span class="' + className + '">' + (index + 1) + '/'+ (total)+ '</span>';
                        },               
                    },    
                });       
            },    

            mainSlider2 : function(){    
                var $slider2 = new Swiper(".main-slider2 .swiper-container", {
                    slidesPerView: "auto",
                    spaceBetween: 20,   
                    navigation: {
                        nextEl: ".main-slider2 .swiper-button-next",
                        prevEl: ".main-slider2 .swiper-button-prev",
                    },
                    breakpoints: {                        
                        768: {
                            slidesPerView: 'auto',
                            spaceBetween: 20,
                        },
                        1024: {
                            slidesPerView: 'auto',
                            spaceBetween: 20,
                        },
                        1200: {
                            slidesPerView: 4,
                            spaceBetween: 20,
                        },
                    },
                });    
            },
            mainSlider3 : function(){    
                var $slider3 = new Swiper(".main-slider3 .swiper-container", {
                    slidesPerView: 1,
                    spaceBetween: 10,
                    pagination: {
                        el: ".swiper-pagination",
                        clickable: true,
                    }
                });    
            },
            mainSlider4 : function(){    
                var $slider4 = new Swiper(".main-slider4 .swiper-container", {
                    slidesPerView: 'auto',
                    spaceBetween: 20,
                    navigation: {
                        nextEl: ".main-slider4 .swiper-button-next",
                        prevEl: ".main-slider4 .swiper-button-prev",
                    },
                    breakpoints: {
                        768: {
                            slidesPerView: 'auto',
                            spaceBetween: 20,
                        },  
                        1024: {
                            slidesPerView: 'auto',
                            spaceBetween: 20,
                        },
                        1200: {
                            slidesPerView: 3,
                            spaceBetween: 10,
                        },
                    },
                });    
            },
            mainSlider5 : function(){    
                var $slider5 = new Swiper(".main-slider5 .swiper-container", {
                    slidesPerView: 'auto',
                    spaceBetween: 20,
                    navigation: {
                        nextEl: ".main-slider5 .swiper-button-next",
                        prevEl: ".main-slider5 .swiper-button-prev",
                    },
                    breakpoints: {  
                        768: {
                            slidesPerView: 'auto',
                            spaceBetween: 20,
                        },
                        1024: {
                            slidesPerView:'auto',
                            spaceBetween: 20,
                        },
                        1200: {
                            slidesPerView: 3,
                            spaceBetween: 10,
                        },
                    },
                });    
            },
            photoSlider : function(){    
                var $photoSlider = new Swiper(".apply-sect3-photos .swiper-container", {                   
                    slidesPerView: 'auto',
                    spaceBetween: 20,
                    freeMode: true,
                    slidesPerGroup:1,
                    pagination: {
                        el: ".swiper-pagination",
                        clickable: true,
                      },
                });    
            }
        }
    })(ui);

    ui.asideHeight =function(){
		var asideTopHt = $('#aside').find('.aside-head').outerHeight();		
		var asideBodyHt = $(window).outerHeight() - asideTopHt
		$('#aside').find('.aside-body').css('height',asideBodyHt);	
        
        var wHt = $(window).outerHeight();
        var hHt = $('#header').outerHeight();
        var cHt = wHt - hHt;
        var wbHt = $('.webinar-tab-top').outerHeight();        

        var _ = this;
        if(_.isDesktop && (_.winsizeW >= 1024)){     
            console.log('pc');
            $('#container').css('min-height',cHt);
            $('.section-webinar4').css('min-height',cHt);
            $('.section-webinar4 .webinar-tab-body').css('height',cHt - wbHt-10);

        } else {
            //console.log('모바일');            
            var movHt =$('.section-webinar4 .webinar-cont').outerHeight();           
            $('.section-webinar4').css('min-height',cHt);
            $('.section-webinar4 .webinar-tab').removeClass('close')            
            $('.section-webinar4 .webinar-tab-body').css('height',wHt - hHt - wbHt - movHt-10);
            $('.section-webinar4 .wb-cont1').on('click',function(){               

                if($('.section-webinar4 .wb-cont2').hasClass('open')){
                    $('.section-webinar4 .wb-cont2').removeClass('open');  
                    var wbht2 = $('.section-webinar4 .webinar-tab-body').outerHeight();
                    var wbht3 = $('.section-webinar4 .wb-cont2').outerHeight();    
                    $('.section-webinar4 .webinar-tab-body').css('height',wbht2 + wbht3)

                } else {
                    $('.section-webinar4 .wb-cont2').addClass('open');  
                    var wbht2 = $('.section-webinar4 .webinar-tab-body').outerHeight();
                    var wbht3 = $('.section-webinar4 .wb-cont2').outerHeight();    
                    $('.section-webinar4 .webinar-tab-body').css('height',wbht2 - wbht3)
                }

            })
            if ($('.main').length) {
                $('.static-mo').css('border-bottom','0')
            }
        }
	}

    ui.headerAction = function(_){
        var _ = this;
		var ts;

        _.$nav.find('> li').on({
			'click': function(){
				$(this).toggleClass('on').siblings().removeClass('on');				
			}
		});

        _.$header.find('.tg-menu').on({
			'click': function(){
				_.$aside .addClass('open');
				_.$html.addClass('asideOpen');
			}
		})	
        
        _.$aside.find('.tg-close').on({
			'click': function(){
				_.$aside .removeClass('open')
				_.$html.removeClass('asideOpen');
			}
	    });
    }

    ui.addOnAction = function(elm, getSib){
		// getSib이 true면 형제들 removeClass on
		if (getSib == false) {
			$(elm).on('click', function(){
				$(this).toggleClass('on');
			});
		} else {
			$(elm).on('click', function(){
				$(this).toggleClass('on').siblings().removeClass('on');
			});
		}
	}

    ui.tabSlide = function () {		
		var $tabSlide  = $('.sub-menu');
		if ($tabSlide.length > 0) {
			var $tabMenuInner = $('.sub-menu .sub-menu-inner');
			var $menuLi		  = $('.sub-menu .sub-menu-inner .tab li');
			var $current 	  = $('.sub-menu .sub-menu-inner .tab li.active');

			var menuWidth     = $tabMenuInner.outerWidth();
			var viewportWidth = $tabMenuInner.width();
			var viewportLeft  = $tabMenuInner.scrollLeft();
			var viewportRight = viewportLeft + viewportWidth;			

			var currentLeft  = $current.position().left + viewportLeft;
			var currentRight = currentLeft + $current.width();
			var totalWidth	  = 0;			

			$menuLi.each(function (idx, obj) {
				totalWidth = totalWidth + $(obj).width();
			});
			
			if (menuWidth > totalWidth) {
				$tabSlide.addClass('center');
			}
			if (!$('.sub-menu .sub-menu-inner').hasClass('center')) {
				if (currentLeft - 50 < viewportLeft) {
					$tabMenuInner.animate({ 'scrollLeft': currentLeft - 200 }, 0);
				}

				if (currentRight + 50 > viewportRight) {
					$tabMenuInner.animate({ 'scrollLeft': currentRight - viewportWidth + 200 }, 0);
				}
			}      
		}			
	}

    ui.tabSlide2 = function () {		
		var $tabSlide  = $('.w-tab-wrap');
		if ($tabSlide.length > 0) {
			var $tabMenuInner = $('.w-tab-wrap .w-tab-wrap-inner');
			var $menuLi		  = $('.w-tab-wrap .w-tab-wrap-inner .w-tab li');
			var $current 	  = $('.w-tab-wrap .w-tab-wrap-inner .w-tab li.active');

			var menuWidth     = $tabMenuInner.outerWidth();
			var viewportWidth = $tabMenuInner.width();
			var viewportLeft  = $tabMenuInner.scrollLeft();
			var viewportRight = viewportLeft + viewportWidth;			

			var currentLeft  = $current.position().left + viewportLeft;
			var currentRight = currentLeft + $current.width();
			var totalWidth	  = 0;			

			$menuLi.each(function (idx, obj) {
				totalWidth = totalWidth + $(obj).width();
			});
			
			if (menuWidth > totalWidth) {
				$tabSlide.addClass('center');
			}
			if (!$('.w-tab-wrap .w-tab-wrap-inner').hasClass('center')) {
				if (currentLeft - 50 < viewportLeft) {
					$tabMenuInner.animate({ 'scrollLeft': currentLeft - 200 }, 0);
				}

				if (currentRight + 50 > viewportRight) {
					$tabMenuInner.animate({ 'scrollLeft': currentRight - viewportWidth + 200 }, 0);
				}
			}      
		}			
	}

    ui.selectDesign =function(){
        $(".select-box").click(function() {
            var select = $(this);                       
            //드롭다운 열기
            select.addClass("open").next('.select-box-dropDown').slideDown(100).addClass("open");            
            //다른영역 클릭 시 닫기
            $(document).mouseup(function(e) {
              var seting = $(".select-box-dropDown");
              if (seting.has(e.target).length === 0) {
                seting.removeClass("open").slideUp(100);
                select.removeClass("open");
              }
            });
          
            //select.find('.select-box-dropDown button')    
            select.next('.select-box-dropDown').find('button').click(function() {
              var option = $(this).text();                           
              //클릭 시 드롭다운 닫기
              select.next('.select-box-dropDown').find('button').removeClass('selected');
              $(".select-box-dropDown").removeClass("open").slideUp(100);
              select.removeClass("open");
              $(this).addClass('selected');              
              //select에  text 넣기
              select.text(option);
            });
          });
    }

    ui.actions = function(){
        $('.tg-btns>.btn-ty3').on('click',function(){
            $(this).parent().toggleClass('open');            
        });
        $('.tg-btns>ul>li>.btn-ty3').on('click',function(){            
			$('.tg-btns').removeClass('open');
        });

        $('.cs-cate ul>li>button').on('click',function(){
            $(this).parent().addClass('active').siblings().removeClass('active');            
        });

        $('.static-mo .tg-search').on('click',function(){
            $('.header-search-mo').addClass('active');
        })

        $('.header-search-mo .cancel').on('click',function(){
            $('.header-search-mo').removeClass('active');
        });

        $('.section-webinar3 .webinar-tab-tg').on('click',function(){
            $('.webinar-tab').toggleClass('close');  
        });

        $('.section-webinar4 .webinar-tab-tg').on('click',function(){
            $('.webinar-tab').toggleClass('close'); 
            $('.section-webinar4').toggleClass('wide')
        });

        


    }

    ui.tabAction = function(navi, cont){
		var _ = ui;
		function action(tab, idx){
			tab.def.$navi.eq(idx).addClass('on').siblings().removeClass('on');
			tab.def.$cont.eq(idx).addClass('on').siblings().removeClass('on');
			tab.def.offsetTop = tab.def.$navi.offset().top;
			tab.def.idx = idx;
		}

		var tabAction = (function(){
			return {
				def : {
					idx : 0,
					$navi : $(navi).children(),
					$cont : $(cont).children()
				},
				init : function(){
					var _this = this;
					_this.def.$navi.on('click', function(){
						action(_this, $(this).index());
					});

					return _this;
				},
				setIndex : function(idx){
					action(this, idx);
					$('html, body').animate({scrollTop : this.def.offsetTop-_.$header.outerHeight()}, 300);
				}
			};
		})();
		return tabAction.init();
	}

    $(window).on({
		'load' : function(){
			ui.init.onLoad();
		},
		'resize' : function(){
			ui.init.onResize();
		},
		'scroll' : function(){
			ui.init.onScroll();
		}
	});    

})(jQuery);