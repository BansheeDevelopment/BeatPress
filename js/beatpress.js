/**
 * BeatPress
 * Copyright (C) Banshee Development (https://www.banshee.pro)
 * Auxiliar code from NARENDRA PADALA (https://scripthere.com)
 */

jQuery.noConflict($);

(function($) {
	$("#hide").click(function(){
		$("#bottomplayer").html("Replaced");
	});
}(jQuery));

//Modal Close Button
(function($) {
	$(".cwidget").click(function(){
		$('.bnbuttons').slideUp();
	});
}(jQuery));

//Modal Close Button
(function($) {
	$(".bpmodal").click(function(){
		if ( !$(".bpmodal").closest('.bpmodal-content').length ) {
			if ( $(".bpmodal").closest('.modcloser').length ) {
				$('.bnbuttons').slideUp(); //BUG Despliega doble
			}
		}
	});

}(jQuery));

//Load More Beats Landing Pages Beats
(function($) {
$("#bpLoadStatic").click(function () {
	
	//Analytics Event
	if (typeof ga === 'function') {
		ga('send', 'event', 'Beat Page', 'Listen More Beats > Click');
	} else {
		console.warn("Google Analytics code wasn't found in the website, skipping event tracking.");
	}

	$("#bpLoadStatic").html('<span class="loadholder" id="loadMoreLoading"><span id="loadt" class="loadmoreBtn"><div class="spinnyk"></div></span></span>');
});
}(jQuery));

jQuery(document).ready(function($) {

	$(document).on("click",".bpmodal", function(){
		if ( !$(event.target).closest('.bpmodal-content').length ) {
			if ( !$(event.target).closest('.modcloser').length ) {
				$('.bnbuttons').slideUp(); //BUG Despliega doble
			}
		}
	});
			
	$(document).on("click",".cwidget", function(){
		$('.bnbuttons').slideUp(); //BUG Despliega doble
	});	

	// Set Loading Var to False on Start
	var loading = false;
	
	// Load More Bar Click Event Handler
	$("#bpLoadAjax").on('click', function(e) {
        //init
        var that = $(this);
        var page = $(this).data('page');
        var newPage = page + 1;
        var ajaxurl = that.data('url');
        //ajax call
		if ( loading == false ) {
				loading = true;
		
		
		//Analytics Event
		if (typeof ga === 'function') {
			ga('send', 'event', 'Catalog', 'Load More Beats > Click');
		} else {
			console.warn("Google Analytics code wasn't found in the website, skipping event tracking.");
		}

		$("#bpLoadAjax").html('<span class="loadholder" id="loadMoreLoading"><span id="loadt" class="loadmoreBtn"><div class="spinnyk"></div></span></span>');
        $.ajax({
            url: ajaxurl,
            type: 'post',
            data: {
                page: page,
                action: 'ajax_script_load_more'

            },
            error: function(response) {
                console.log(response);
            },
            success: function(response) {
                //check
                if (response == 0) {
					$("#bpLoadAjax").fadeOut( "slow" );
                } else {
                    that.data('page', newPage);
                    $('#ajax-content').append(response);
					loading = false;
					
					$("#bpLoadAjax").html('<span class="loadholder" id="bpLoadAjax" data-page="1" data-url="/wp-admin/admin-ajax.php" style="display: flex;"><p id="loadt" class="loadmoreBtn"><i class="fas fa-caret-down"></i> Load More Beats <i class="fas fa-caret-down"></i></p></span>');
                }
            }
        });
		}//HERE
    });
	
	// Add To Cart Button Handler
	$(document).on("click",".purchaselink", function(){
		
		$ppp = $(this);
				
		$ppp = $(this).parents('div').first();
		
		$ppp = $ppp.next();
		
		if( $ppp.css('display') == 'block') {
			$ppp.slideToggle(400, function () {
			});
		} else {
			$('.bnbuttons').slideUp(); //BUG Despliega doble
			$ppp.slideToggle(400, function () {
			});
		}

	});

	// jQuery Player Initialization
	$("#jquery_jplayer_1").jPlayer({
		cssSelectorAncestor: "#jp_container_1",
		volume: "100",
        swfPath: "/js",
        supplied: "mp3",
        useStateClassSkin: true,
        autoBlur: false,
        smoothPlayBar: true,
        keyEnabled: true,
        remainingDuration: true,
        toggleDuration: true
	});
	
	
	/* Volume Dragging */
	$(".jp-volume-bar").mousedown(function() {
		var parentOffset = $(this).offset(), width = $(this).width();
		$(window).mousemove(function(e) {
			var x = e.pageX - parentOffset.left, volume = x / width;
			if (volume > 1) {
				$("#jquery_jplayer_1").jPlayer("volume", 1);
			} else if (volume <= 0) {
				$("#jquery_jplayer_1").jPlayer("mute");
			} else {
				$("#jquery_jplayer_1").jPlayer("volume", volume);
				$("#jquery_jplayer_1").jPlayer("unmute");
			}
		});
		return false;
	})
	.mouseup(function() {
		$(window).unbind("mousemove");
	});
	
	
	/* Enable Dragging */

	var timeDrag = false; /* Drag status */
	$(".jp-play-bar").mousedown(function(e) {
		timeDrag = true;
		updatebar(e.pageX);
	});
	$(document).mouseup(function(e) {
		if (timeDrag) {
			timeDrag = false;
			updatebar(e.pageX);
		}
	});
	$(document).mousemove(function(e) {
		if (timeDrag) {
			updatebar(e.pageX);
		}
	});

	//Update Progress Bar Controls
	var updatebar = function(x) {
		var progress = $(".jp-progress");
		//var maxduration = myPlaylist.duration; //audio duration

        var position = x - progress.offset().left; //Click pos
        var percentage = 100 * position / progress.width();

        //Check the range of the progress bar
        if (percentage > 100) {
			percentage = 100;
        }
        if (percentage < 0) {
			percentage = 0;
        }

        $("#jquery_jplayer_1").jPlayer("playHead", percentage);

        //Update Progress Bar
        $(".jp-play-bar").css("width", percentage + "%");
	};	
		
	// BeatHolder DIV Event Handler	Player
	$(document).on("click",".beatholder", function(event){

		if (!$(event.target).closest('.iBk').length) {
			
			
			//Begin Ripple
			$(".ripple").remove();

			// Set Up The Ripple
			var posX = $(this).offset().left,
				posY = $(this).offset().top,
				buttonWidth = $(this).width(),
				buttonHeight =  $(this).height();

			// Add the Ripple
			$(this).prepend("<span class='ripple'></span>");

			// Make Ripple Round
			if(buttonWidth >= buttonHeight) {
				buttonHeight = buttonWidth;
			} else {
				buttonWidth = buttonHeight; 
			}

			// Get the center of the clicked element
			var x = $(this).pageX - posX - buttonWidth / 2;
			var y = $(this).pageY - posY - buttonHeight / 2;

			// Add CSS and start
			$(".ripple").css({
				width: buttonWidth,
				height: buttonHeight,
				top: y + 'px',
				left: x + 'px'
			}).addClass("rippleEffect");
			
			//End Ripple
			
			$xHnSel = $('.audio-player').attr("xHn");
			if ($xHnSel == '1'){
				$('.button-badge').css("bottom","102px");
				$('.audio-player').slideToggle();
				$(".audio-player").attr({"xHn" : '0'});
			}
			var varimg = $(this).children('.imgcont').children('.attachment-beatpress-playlist-image-size').attr('src');
			$('.bp_beatimg').attr('src', varimg);
			
			$('.ppplistening').stop();
			$('.ppplistening').fadeOut(100);
			
			$(this).children('.imgcont').children('.ppplistening').stop();
			$(this).children('.imgcont').children('.ppplistening').fadeIn(100);
		
			$(this).children('.imgcont').children('.ppplistening').fadeOut(10000, function() {
				$(this).children('.imgcont').children('.ppplistening').stop();
			});			
			
			$(".beatholder").css("background-color","");

			//Store Theme Values			
			var bpthemecolor = $('.jp-play-bar').css( "background-color" );
			
			//First Restore Changes
			$(".bp_titledot").css("color", "");
			$(".cattb").css("background-color", "");
			$(".cattb").css("color", "");
			$(".cattb").css("border", "");
			$(".cat").css("color", "");
			$(".ppplistening").css("color", "");
			$(".ppplink").css("color", "");
			$(".pldownload").css("color", "");
			$(".purchaselink").css("border", "");
			$(".purchaselink").css("background-color", "");
			$(".bp_pppseparator").css("border", "");
			$(".bp_pppseparator").css("background-color", "");
			$(".purchaselink_sold").css("border", "");
			$(".purchaselink_sold").css("background-color", "");
			$(".icon_cont").css("color", "");
			$(".text_cont").css("color", "");
			
			//Then Set Changes
			$(this).css("background-color", bpthemecolor);
			$(this).children('.titleholder').children('.bp_titledot').css("color", "#FFF");
			$(this).children('.beat-category').children('.cattb').css("background-color", "#FFF");
			$(this).children('.beat-category').children('.cattb').css("border", "1px solid " + "#fff");
			$(this).children('.beat-category').children('.cattb').css("color", bpthemecolor);
			$(this).children('.beat-category').children('.cat').css("color", "#FFF");
			$(this).children('.bp_addbuttons').children('.ppplistening').css("color", "#FFF");
			$(this).children('.bp_addbuttons').children('.ppplink').css("color", "#FFF");
			$(this).children('.bp_addbuttons').children('.pldownload').css("color", "#FFF");
			$(this).children('.bp_addbuttons').children('.purchaselink').css("border", "2px solid #FFF");
			$(this).children('.bp_addbuttons').children('.purchaselink').css("background-color", "#FFF");
			$(this).children('.bp_addbuttons').children('.purchaselink').children('.icon_cont').css("color", bpthemecolor);
			$(this).children('.bp_addbuttons').children('.purchaselink').children('.text_cont').css("color", bpthemecolor);
			$(this).children('.bp_addbuttons').children('.bp_pppseparator').css("border", "2px solid #FFF");
			$(this).children('.bp_addbuttons').children('.bp_pppseparator').css("background-color", "#FFF");
			$(this).children('.bp_addbuttons').children('.bp_pppseparator').children('.icon_cont').css("color", bpthemecolor);
			$(this).children('.bp_addbuttons').children('.bp_pppseparator').children('.text_cont').css("color", bpthemecolor);
			$(this).children('.bp_addbuttons').children('.purchaselink_sold').css("border", "2px solid #000");
			$(this).children('.bp_addbuttons').children('.purchaselink_sold').css("background-color", "#000");
			$(this).children('.bp_addbuttons').children('.purchaselink_sold').children('.icon_cont').css("color", "#FFF");
			$(this).children('.bp_addbuttons').children('.purchaselink_sold').children('.text_cont').css("color", "#FFF");

			$currentlyPlayingBeat = $("#jquery_jplayer_1").attr("xNd");
			$src = $(this).attr("xId");
			$name = $(this).attr("xNd");
			$("#jquery_jplayer_1").attr({"xNd" : $name});
			$(".jp-track-name").text($name);

			if ($name == $currentlyPlayingBeat) {
			} else {
				$('.jp-progress').css("background-image", "url(/wp-content/plugins/beatpress/imgs/system/loadbar.gif)");  
				$('.jp-seek-bar').css("background-image", "url(/wp-content/plugins/beatpress/imgs/system/loadbar.gif)");  
				var $pre = '/?listen=1&code=';
				var $src = $pre + $src;

				$("#jquery_jplayer_1").jPlayer("setMedia", {
					artist: "BeatPress",
					title: $name,
					mp3: $src,
					poster: varimg
				});
				
				//Analytics Event
				if (typeof ga === 'function') {
					ga('send', 'event', 'Instrumental', 'Play', $name);
				} else {
					console.warn("Google Analytics code wasn't found in the website, skipping event tracking.");
				}
								
				$("#jquery_jplayer_1").jPlayer("play");		

			}
		}

	});
	


	
	
	
	
	// Featured Beat Event Handler
	$(document).on("click","#featured_cont", function(event){

		if (!$(event.target).closest('.iBk').length) {
			
			$xHnSel = $('.audio-player').attr("xHn");
			if ($xHnSel == '1'){
				$('.button-badge').css("bottom","102px");
				$('.audio-player').slideToggle();
				$(".audio-player").attr({"xHn" : '0'});
			}
			var varimg = $(this).children('.featyfeat').children('.ftimaged').attr('src');
			$('.bp_beatimg').attr('src', varimg);

			$('.ppplistening').stop();
			$('.ppplistening').fadeOut(100);
			
			$(this).children('#image_featured_beat').children('.ppplistening').stop();
			$(this).children('#image_featured_beat').children('.ppplistening').fadeIn(100);
			
			$(this).children('#image_featured_beat').children('.ppplistening').fadeOut(10000, function() {
				$(this).children('#image_featured_beat').children('.ppplistening').stop();
			});	
			$(".beatholder").css("background-color","");
			
			//Store Theme Values			
			var bpthemecolor = $('.jp-play-bar').css( "background-color" );
			
			//First Restore Changes
			$(".bp_titledot").css("color", "");
			$(".cattb").css("background-color", "");
			$(".cattb").css("color", "");
			$(".cattb").css("border", "");
			$(".cat").css("color", "");
			$(".ppplistening").css("color", "");
			$(".ppplink").css("color", "");
			$(".pldownload").css("color", "");
			$(".purchaselink").css("border", "");
			$(".purchaselink").css("background-color", "");
			$(".bp_pppseparator").css("border", "");
			$(".bp_pppseparator").css("background-color", "");
			$(".purchaselink_sold").css("border", "");
			$(".purchaselink_sold").css("background-color", "");
			$(".icon_cont").css("color", "");
			$(".text_cont").css("color", "");

			$currentlyPlayingBeat = $("#jquery_jplayer_1").attr("xNd");
			$src = $(this).attr("xId");
			$name = $(this).attr("xNd");
			$("#jquery_jplayer_1").attr({"xNd" : $name});
			$(".jp-track-name").text($name);

			if ($name == $currentlyPlayingBeat) {
			} else {
				 
				$('.jp-progress').css("background-image", "url(/wp-content/plugins/beatpress/imgs/system/loadbar.gif)");  
				$('.jp-seek-bar').css("background-image", "url(/wp-content/plugins/beatpress/imgs/system/loadbar.gif)");  
				var $pre = '/?listen=1&code=';
				var $src = $pre + $src;
				//alert($src);
				$("#jquery_jplayer_1").jPlayer("setMedia", {
					artist: "BeatPress",
					title: $name,
					mp3: $src,
					poster: varimg
				});
				
				//Analytics Event
				if (typeof ga === 'function') {
					ga('send', 'event', 'Instrumental', 'Play', $name);
				} else {
					console.warn("Google Analytics code wasn't found in the website, skipping event tracking.");
				}				

				$("#jquery_jplayer_1").jPlayer("play");		
			}
		}

	});


	
	
	
	// Featured Beat > Add To Cart Event Handler
	$(document).on("click",".purchaselinkfeatured", function(){
		
		$ppp = $(this);
		
		$ppp = $(this).parents('div').first();
		
		$ppp = $ppp.next();
		
		if( $ppp.css('display') == 'block') {
			$ppp.slideToggle(400, function () {
			});
		} else {
			$('.bnbuttons').slideUp(); //BUG Despliega doble
			$ppp.slideToggle(400, function () {
			});
		}

	});


	
	// BottomPlayer Event Handler From Modal Box
	$(document).on("click","#bottomplayer", function(){

		$xHnSel = $('.audio-player').attr("xHn");
		if ($xHnSel == '1'){
			$('.button-badge').css("bottom","102px");
			$('.audio-player').slideToggle();
			$(".audio-player").attr({"xHn" : '0'});
		}
		
		$name = $(this).attr("xNd");
		//var varimg = $(this).children('.featyfeat')
		var varimg = $(this).parent().next('.bpmodal-content').children('.bp-beat-desc').children('.title_desc_catalog').children('.tinydescimg').attr('src');

		$('.bp_beatimg').attr('src', varimg);
		
		$('.ppplistening').stop();
		$('.ppplistening').fadeOut(100);
			
		$holding = $('.beatholder[xnd="' + $name + '"]');

		$holding.children('.imgcont').children('.ppplistening').stop();
		$holding.children('.imgcont').children('.ppplistening').fadeIn(100);
		
		
		$holding.children('.imgcont').children('.ppplistening').fadeOut(10000, function() {
			$holding.children('.imgcont').children('.ppplistening').stop();
		});			

		$(".beatholder").css("background-color","");

		//Begin Ripple
			
		//Remove Old Ripples
		$(".ripple").remove();

		//Setup The Ripple In The Right Beatholder Class
		var posX = $holding.offset().left,
			posY = $holding.offset().top,
			buttonWidth = $holding.width(),
			buttonHeight =  $holding.height();

		//Add The Ripple
		$holding.prepend("<span class='ripple'></span>");

		//Make the Ripple Round
		if(buttonWidth >= buttonHeight) {
			buttonHeight = buttonWidth;
		} else {
			buttonWidth = buttonHeight; 
		}

		// Get The Center of the Selected Element
		var x = $holding.pageX - posX - buttonWidth / 2;
		var y = $holding.pageY - posY - buttonHeight / 2;

		// Add the ripples CSS and start the animation
		$(".ripple").css({
			width: buttonWidth,
			height: buttonHeight,
			top: y + 'px',
			left: x + 'px'
		}).addClass("rippleEffect");
			
		//End Ripple

		//Store Theme Values			
		var bpthemecolor = $('.jp-play-bar').css( "background-color" );
		
		//First Restore Changes
		$(".bp_titledot").css("color", "");
		$(".cattb").css("background-color", "");
		$(".cattb").css("color", "");
		$(".cattb").css("border", "");
		$(".cat").css("color", "");
		$(".ppplistening").css("color", "");
		$(".ppplink").css("color", "");
		$(".pldownload").css("color", "");
		$(".purchaselink").css("border", "");
		$(".purchaselink").css("background-color", "");
		$(".bp_pppseparator").css("border", "");
		$(".bp_pppseparator").css("background-color", "");
		$(".purchaselink_sold").css("border", "");
		$(".purchaselink_sold").css("background-color", "");
		$(".icon_cont").css("color", "");
		$(".text_cont").css("color", "");
	
		//Then Set Changes
		$holding.css("background-color", bpthemecolor);
		$holding.children('.titleholder').children('.bp_titledot').css("color", "#FFF");
		$holding.children('.beat-category').children('.cattb').css("background-color", "#FFF");
		$holding.children('.beat-category').children('.cattb').css("color", bpthemecolor);
		$holding.children('.beat-category').children('.cattb').css("border", "1px solid " + "#fff");
		$holding.children('.beat-category').children('.cat').css("color", "#FFF");
		$holding.children('.bp_addbuttons').children('.ppplistening').css("color", "#FFF");
		$holding.children('.bp_addbuttons').children('.ppplink').css("color", "#FFF");
		$holding.children('.bp_addbuttons').children('.pldownload').css("color", "#FFF");
		$holding.children('.bp_addbuttons').children('.purchaselink').css("border", "2px solid #FFF");
		$holding.children('.bp_addbuttons').children('.purchaselink').css("background-color", "#FFF");
		$holding.children('.bp_addbuttons').children('.purchaselink').children('.icon_cont').css("color", bpthemecolor);
		$holding.children('.bp_addbuttons').children('.purchaselink').children('.text_cont').css("color", bpthemecolor);
		$holding.children('.bp_addbuttons').children('.bp_pppseparator').css("border", "2px solid #FFF");
		$holding.children('.bp_addbuttons').children('.bp_pppseparator').css("background-color", "#FFF");
		$holding.children('.bp_addbuttons').children('.bp_pppseparator').children('.icon_cont').css("color", bpthemecolor);
		$holding.children('.bp_addbuttons').children('.bp_pppseparator').children('.text_cont').css("color", bpthemecolor);
		$holding.children('.bp_addbuttons').children('.purchaselink_sold').css("border", "2px solid #000");
		$holding.children('.bp_addbuttons').children('.purchaselink_sold').css("background-color", "#000");
		$holding.children('.bp_addbuttons').children('.purchaselink_sold').children('.icon_cont').css("color", "#FFF");
		$holding.children('.bp_addbuttons').children('.purchaselink_sold').children('.text_cont').css("color", "#FFF");

		$("#jquery_jplayer_1").jPlayer({
			cssSelectorAncestor: "#jp_container_1",
			volume: "100",
			swfPath: "/js",
			supplied: "mp3",
			useStateClassSkin: true,
			autoBlur: false,
			smoothPlayBar: true,
			keyEnabled: true,
			remainingDuration: true,
			toggleDuration: true
		});
		
		$(".jp-track-name").text($name);		

		$currentlyPlayingBeat = $("#jquery_jplayer_1").attr("xNd");
		$src = $(this).attr("xId");
		$name = $(this).attr("xNd");
		$("#jquery_jplayer_1").attr({"xNd" : $name});

		if ($name == $currentlyPlayingBeat) {
		} else {
			
			$('.jp-progress').css("background-image", "url(/wp-content/plugins/beatpress/imgs/system/loadbar.gif)");  
			$('.jp-seek-bar').css("background-image", "url(/wp-content/plugins/beatpress/imgs/system/loadbar.gif)");  
			$('.button-badge').css("bottom","102px");
			//$('.audio-player').slideToggle();
			var $pre = '/?listen=1&code=';
			var $src = $pre + $src;
			//alert($src);
			$("#jquery_jplayer_1").jPlayer("setMedia", {
				artist: "BeatPress",
				title: $name,
				mp3: $src,
				poster: varimg
			});
			
			//Analytics Event
			if (typeof ga === 'function') {
				ga('send', 'event', 'Instrumental', 'Play', $name);
			} else {
				console.warn("Google Analytics code wasn't found in the website, skipping event tracking.");
			}	
			
			$("#jquery_jplayer_1").jPlayer("play");		
		}
	});
	
	
	//Listener for playing the beat
	$("#jquery_jplayer_1").bind($.jPlayer.event.playing, function(event) {
		$('.jp-progress').css("background-image", "none");  
		$('.jp-seek-bar').css("background-image", "none");  
	});
	
	//Cart Animation when EDD purchase mode is active
	$('body').on("click",".edd-add-to-cart", function(event){

		$('.button-badge').animateRotate(360);
		$('.badgex').fadeIn(50).delay(1000).fadeOut(50).fadeIn(50).fadeOut(50).fadeIn(50);

		/* DRAG TO BUTTON BADGE
		NEED TO USE JQUERYUI 
		ENQUEUE IN NEXT VERSION script src='http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.5/jquery-ui.min.js 

		var cart = $('.button-badge');
        var imgtodrag = $(this);
        if (imgtodrag) {
            var imgclone = imgtodrag.clone()
                .offset({
                top: imgtodrag.offset().top,
                left: imgtodrag.offset().left
            })
                .css({
                'opacity': '0.5',
                'background-color': 'black',
                'background-color': 'black',
                'position': 'absolute',
                'height': '136',
                'width': '257',
				'z-index': '999999'
					
            })
                .appendTo($('body'))
                .animate({
                'top': cart.offset().top + 10,
                'left': cart.offset().left + 10,
                'width': 35,
                'height': 35
            }, 1000, 'easeInOutExpo');
            
            imgclone.animate({
                'width': 0,
				'width': 0,
                'opacity': '0'
            }, function () {
                $(this).detach();
				$('.button-badge').animateRotate(360);
				$('.badgex').fadeIn(50).delay(1000).fadeOut(50).fadeIn(50).fadeOut(50).fadeIn(50);;
            });
        }
		*/
		
		
	});
		
});

(function($){
	$.fn.animateRotate = function(angle, duration, easing, complete) {
		return this.each(function() {
			var $elem = $(this);

			$({deg: 0}).animate({deg: angle}, {
				duration: duration,
				easing: easing,
				step: function(now) {
					$elem.css({
						transform: 'rotate(' + now + 'deg)'
					});
				},
				complete: complete || $.noop
			});
		});
	};
})(jQuery);

(function($){
    $.fn.shake = function(settings) {
        if(typeof settings.interval == 'undefined'){
            settings.interval = 100;
        }

        if(typeof settings.distance == 'undefined'){
            settings.distance = 10;
        }

        if(typeof settings.times == 'undefined'){
            settings.times = 4;
        }

        if(typeof settings.complete == 'undefined'){
            settings.complete = function(){};
        }

        for(var iter=0; iter<(settings.times+1); iter++){
            $(this).animate({ marginLeft:((iter%2 == 0 ? settings.distance : settings.distance * -1)) }, settings.interval);
        }

        $(this).animate({ marginLeft: 0}, settings.interval, settings.complete);  
    }; 

})(jQuery);
        
