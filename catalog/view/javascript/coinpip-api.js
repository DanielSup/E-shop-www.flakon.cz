/*
* $ lightbox_me
* By: Buck Wilson
* Version : 2.4
*
* Licensed under the Apache License, Version 2.0 (the "License");
* you may not use this file except in compliance with the License.
* You may obtain a copy of the License at
*
*     http://www.apache.org/licenses/LICENSE-2.0
*
* Unless required by applicable law or agreed to in writing, software
* distributed under the License is distributed on an "AS IS" BASIS,
* WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
* See the License for the specific language governing permissions and
* limitations under the License.
*/


(function($) {

    $.fn.lightbox_me = function(options) {

        return this.each(function() {

            var
                opts = $.extend({}, $.fn.lightbox_me.defaults, options),
                $overlay = $(),
                $self = $(this),
                $iframe = $('<iframe id="foo" style="z-index: ' + (opts.zIndex + 1) + ';border: none; margin: 0; padding: 0; position: absolute; width: 100%; height: 100%; top: 0; left: 0; filter: mask();"/>');

            if (opts.showOverlay) {
                //check if there's an existing overlay, if so, make subequent ones clear
               var $currentOverlays = $(".js_lb_overlay:visible");
                if ($currentOverlays.length > 0){
                    $overlay = $('<div class="lb_overlay_clear js_lb_overlay"/>');
                } else {
                    $overlay = $('<div class="' + opts.classPrefix + '_overlay js_lb_overlay"/>');
                }
            }

            /*----------------------------------------------------
               DOM Building
            ---------------------------------------------------- */
            $('body').append($self.hide()).append($overlay);


            /*----------------------------------------------------
               Overlay CSS stuffs
            ---------------------------------------------------- */

            // set css of the overlay
            if (opts.showOverlay) {
                setOverlayHeight(); // pulled this into a function because it is called on window resize.
                $overlay.css({ position: 'absolute', width: '100%', top: 0, left: 0, right: 0, bottom: 0, zIndex: (opts.zIndex + 2), display: 'none' });
				if (!$overlay.hasClass('lb_overlay_clear')){
                	$overlay.css(opts.overlayCSS);
                }
            }

            /*----------------------------------------------------
               Animate it in.
            ---------------------------------------------------- */
               //
            if (opts.showOverlay) {
                $overlay.fadeIn(opts.overlaySpeed, function() {
                    setSelfPosition();
                    $self[opts.appearEffect](opts.lightboxSpeed, function() { setOverlayHeight(); setSelfPosition(); opts.onLoad()});
                });
            } else {
                setSelfPosition();
                $self[opts.appearEffect](opts.lightboxSpeed, function() { opts.onLoad()});
            }

            /*----------------------------------------------------
               Hide parent if parent specified (parentLightbox should be jquery reference to any parent lightbox)
            ---------------------------------------------------- */
            if (opts.parentLightbox) {
                opts.parentLightbox.fadeOut(200);
            }


            /*----------------------------------------------------
               Bind Events
            ---------------------------------------------------- */

            $(window).resize(setOverlayHeight)
                     .resize(setSelfPosition)
                     .scroll(setSelfPosition);

            $(window).bind('keyup.lightbox_me', observeKeyPress);

            if (opts.closeClick) {
                $overlay.click(function(e) { closeLightbox(); e.preventDefault; });
            }
            $self.delegate(opts.closeSelector, "click", function(e) {
                closeLightbox(); e.preventDefault();
            });
            $self.bind('close', closeLightbox);
            $self.bind('reposition', setSelfPosition);



            /*--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
              -------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- */


            /*----------------------------------------------------
               Private Functions
            ---------------------------------------------------- */

            /* Remove or hide all elements */
            function closeLightbox() {
                var s = $self[0].style;
                if (opts.destroyOnClose) {
                    $self.add($overlay).remove();
                } else {
                    $self.add($overlay).hide();
                }

                //show the hidden parent lightbox
                if (opts.parentLightbox) {
                    opts.parentLightbox.fadeIn(200);
                }
                if (opts.preventScroll) {
                    $('body').css('overflow', '');
                }
                $iframe.remove();

				        // clean up events.
                $self.undelegate(opts.closeSelector, "click");
                $self.unbind('close', closeLightbox);
                $self.unbind('repositon', setSelfPosition);
                
                $(window).unbind('resize', setOverlayHeight);
                $(window).unbind('resize', setSelfPosition);
                $(window).unbind('scroll', setSelfPosition);
                $(window).unbind('keyup.lightbox_me');
                opts.onClose();
            }


            /* Function to bind to the window to observe the escape/enter key press */
            function observeKeyPress(e) {
                if((e.keyCode == 27 || (e.DOM_VK_ESCAPE == 27 && e.which==0)) && opts.closeEsc) closeLightbox();
            }


            /* Set the height of the overlay
                    : if the document height is taller than the window, then set the overlay height to the document height.
                    : otherwise, just set overlay height: 100%
            */
            function setOverlayHeight() {
                if ($(window).height() < $(document).height()) {
                    $overlay.css({height: $(document).height() + 'px'});
                     $iframe.css({height: $(document).height() + 'px'});
                } else {
                    $overlay.css({height: '100%'});
                }
            }


            /* Set the position of the modal'd window ($self)
                    : if $self is taller than the window, then make it absolutely positioned
                    : otherwise fixed
            */
            function setSelfPosition() {
                var s = $self[0].style;

                // reset CSS so width is re-calculated for margin-left CSS
                $self.css({left: '50%', marginLeft: ($self.outerWidth() / 2) * -1,  zIndex: (opts.zIndex + 3) });


                /* we have to get a little fancy when dealing with height, because lightbox_me
                    is just so fancy.
                 */

                // if the height of $self is bigger than the window and self isn't already position absolute
                if (($self.height() + 80  >= $(window).height()) && ($self.css('position') != 'absolute')) {

                    // we are going to make it positioned where the user can see it, but they can still scroll
                    // so the top offset is based on the user's scroll position.
                    var topOffset = $(document).scrollTop() + 40;
                    $self.css({position: 'absolute', top: topOffset + 'px', marginTop: 0})
                } else if ($self.height()+ 80  < $(window).height()) {
                    //if the height is less than the window height, then we're gonna make this thing position: fixed.
                    if (opts.centered) {
                        $self.css({ position: 'fixed', top: '50%', marginTop: ($self.outerHeight() / 2) * -1})
                    } else {
                        $self.css({ position: 'fixed'}).css(opts.modalCSS);
                    }
                    if (opts.preventScroll) {
                        $('body').css('overflow', 'hidden');
                    }
                }
            }

        });



    };

    $.fn.lightbox_me.defaults = {

        // animation
        appearEffect: "fadeIn",
        appearEase: "",
        overlaySpeed: 250,
        lightboxSpeed: 300,

        // close
        closeSelector: ".coinpip_close",
        closeClick: true,
        closeEsc: true,

        // behavior
        destroyOnClose: false,
        showOverlay: true,
        parentLightbox: false,
        preventScroll: false,

        // callbacks
        onLoad: function() {},
        onClose: function() {},

        // style
        classPrefix: 'lb',
        zIndex: 999,
        centered: false,
        modalCSS: {top: '40px'},
        overlayCSS: {background: 'black', opacity: .3}
    }
})(jQuery);

				Number.prototype.formatMoney = function(c, d, t){
var n = this, 
    c = isNaN(c = Math.abs(c)) ? 2 : c, 
    d = d == undefined ? "." : d, 
    t = t == undefined ? "," : t, 
    s = n < 0 ? "-" : "", 
    i = parseInt(n = Math.abs(+n || 0).toFixed(c)) + "", 
    j = (j = i.length) > 3 ? j % 3 : 0;
    var format_result = s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");

   var afterDot = format_result.substr(format_result.indexOf(".") + 1);

   console.log("ad: " + afterDot)

   if(afterDot.length > 2)
   		{
   			for ( var i = afterDot.length-1; i >= 2 ; i-- )
			{
				if(afterDot.charAt(i) == '0')
					format_result = format_result.slice(0, -1);
				else
					break;
			}
   		}
	else if(afterDot.length == 1)
		format_result += "0";
	else if(afterDot.length == 0)
		format_result += ".00";
		
   return format_result;
 };


var coinpip = new Object;


coinpip.websocket = null;
coinpip.accepted_amount = 0.00;
coinpip.expected_amount = 0.00;
coinpip.mBTC = false;
coinpip.socket_open = false;
coinpip.is_error = false;
coinpip.payment_done = false;
coinpip.RequestId = "";
coinpip.Receipt = "";
coinpip.BitcoinAddress = "";
coinpip.Environment = {
    isAndroid: function() {
        return navigator.userAgent.match(/Android/i);
    },
    isBlackBerry: function() {
        return navigator.userAgent.match(/BlackBerry/i);
    },
    isIOS: function() {
        return navigator.userAgent.match(/iPhone|iPad|iPod/i);
    },
    isOpera: function() {
        return navigator.userAgent.match(/Opera Mini/i);
    },
    isWindows: function() {
        return navigator.userAgent.match(/IEMobile/i);
    },
    isMobile: function() {
        return (coinpip.Environment.isAndroid() || coinpip.Environment.isBlackBerry() || coinpip.Environment.isIOS() || coinpip.Environment.isOpera() || coinpip.Environment.isWindows());
    }
};

coinpip.mins = 4;
coinpip.expired_ = false;
coinpip.stopTimer = false;
coinpip.secs = coinpip.mins * 60 + 59;

coinpip.close = function () {  };
coinpip.open = function (request_id) {  };
coinpip.done = function (receipt) {  };

coinpip.MainUrl = "https://back-office.coinpip.com";
coinpip.SocketUri = "wss://api.coinpip.com:8182/Notification";
coinpip.RedirectUrl = null;
coinpip.Ready = false;
coinpip.Loading = false;

coinpip.CoinpipModalDialog = ' <div class="coinpip" id="coinpip_modal" > \
     				 <div id="coinpip_modal_form"> \
                <h3 id="coinpip_pay_title"> ... </h3> ';
 coinpip.CoinpipModalDialog += '               <h2>&nbsp;</h2> \
                 <label>';
coinpip.CoinpipModalDialog += '<span style="top:30px;"><u id="coinpip_pay_description">...</u></span> \
                </label> \
    <div id="coinpip_payment_content"> ';
coinpip.LoadingContentHtml = '<center><img height="100" src="https://back-office.coinpip.com/assets/images/loading.gif"></center>';
coinpip.PaymentContentHtml = ' <div id="actions"> \
                <span>Please send exactly <strong id="coinpip_btc_amount">...</strong> (worth <i id="coinpip_fiat_amount">...</i>) to this bitcoin address \
                <a id="coinpip_address_link" title="Click here to open wallet" target="_blank" href="#"><small style="color: #067dd7; font-weight: bold; font-size: 0.85em;" id="coinpip_address">...</small></a> to complete the payment.</span> \
                </div> \
                <br/> \
                <center> \
                <label>Received <i id="coinpip_btc">...</i>: <i style="color:red;" id="coinpip_accepted_btc">0.00</i> / <i style="color:green;" id="coinpip_expected_btc">...</i> </label> \
               	 <img id="coinpip_qr_code" height="160" src="" /><br/> \
               	 <label> <button id="coinpip_copy-address" data-clipboard-text="" title="copy bitcoin address to clipboard" >Copy Address</button> </label> \
               	 </center> \
               	 <span style="float: right; position:relative;"><small style="color:darkgrey;"><i id="coinpip_minutes" style="color:darkgrey;">5</i>:<i id="coinpip_seconds" style="color:darkgrey;">00</i></small></span> \
               	 <span><a id="coinpip_loading_button" href="javascript: coinpip.CheckStatus(false);" title="update payment status" ><img height="20" id="coinpip_loading" src="' + coinpip.MainUrl + '/assets/images/refresh_.gif"></a></span> ';
coinpip.CoinpipModalDialog += '</div> \
			</div> \
			 <center> \
                	<label id="coinpip_rate_label"><small>The rate of exchange:  </small><strong><b id="coinpip_rate">...</b></strong></label> \
                	<a target="_blank" title="Powered by CoinPip" href="http://acceptbitcoin.coinpip.com/"><img height="25" src="https://back-office.coinpip.com/assets/images/coinpip-logo.png"/></a> \
                </center> \
                <a id="coinpip_close_x" class="coinpip_close coinpip_sprited" href="#">close</a> \
            </div>';
            
coinpip.CoinpipModalDialog += "<form id='coinpip-request-action'> \
                       <input type='hidden' id='coinpip-api-id' name='apiID' /> \
                       <input type='hidden' id='coinpip-local-amount' name='localAmount'  /> \
                       <input type='hidden' id='coinpip-btc-amount' name='btcAmount'  /> \
                       <input type='hidden' id='coinpip-customer-email' name='customerEmail' /> \
                       <input type='hidden' id='coinpip-customer-phone' name='customerPhone' /> \
                       <input type='hidden' id='coinpip-reference' name='reference' /> \
                       <input type='hidden' id='coinpip-currency' name='currency' /> \
                       <input type='hidden' id='coinpip-send-request' name='sendRequest' value='false' /> \
                       </form>";


coinpip.loadjscssfile = function(filename, filetype){
 if (filetype=="js"){ //if filename is a external JavaScript file
  var fileref=document.createElement('script')
  fileref.setAttribute("type","text/javascript")
  fileref.setAttribute("src", filename)
 }
 else if (filetype=="css"){ //if filename is an external CSS file
  var fileref=document.createElement("link")
  fileref.setAttribute("rel", "stylesheet")
  fileref.setAttribute("type", "text/css")
  fileref.setAttribute("href", filename)
 }
 if (typeof fileref!="undefined")
  document.getElementsByTagName("head")[0].appendChild(fileref)
};


$(document).ready(function() {
	var zc_lib = coinpip.MainUrl + '/assets/javascripts/ZeroClipboard.min.js';
	var css = coinpip.MainUrl + '/Content/coinpip-modal.css';
	coinpip.loadjscssfile(css, 'css');
 	coinpip.loadjscssfile(zc_lib, 'js');
 	//console.log(zc_lib);

 	setTimeout(function() {
			$('body').append(coinpip.CoinpipModalDialog);
			coinpip.Ready = true;
		}, 2000);

});

coinpip.OpenPaymentModal = function(payment_state, request_id) {
	
	$("#coinpip_modal").lightbox_me( {
                						centered: true, 
                						preventScroll: true, 
                						onLoad: function() {
											coinpip.expired_ = false;
											if(payment_state){
												console.log(request_id);
												coinpip.open(request_id);
												}
										},
										onClose: function() {
											coinpip.expired_ = true;
											coinpip.is_error = false;
											coinpip.Loading = false;
											if(payment_state){
												coinpip.close();
												if(coinpip.payment_done && coinpip.RedirectUrl != null)
													location.href = coinpip.RedirectUrl;
											} 

										} 
				
			    });
	
	if(payment_state)
		setTimeout(function() {
			coinpip.Loading = false;
		}, 1000);

};

coinpip.InitZeroClipboard = function (address) {

	/*var url = coinpip.MainUrl + '/assets/javascripts/ZeroClipboard.swf';
	
  	ZeroClipboard.config({
    	swfPath: url
  	});*/
  	
  	//console.log(url);
  	var client = new ZeroClipboard($("#coinpip_copy-address"));

  	client.on( "ready", function( readyEvent ) {
 		console.log( 'ZeroClipboard loaded' );
  		client.on( "aftercopy", function( event ) {
   			 alert("Bitcoin address successfully copied into clipboard");
  		} );

  	});
};

coinpip.RequestPayment  = function(id, params) {
    
    if(!coinpip.Ready || coinpip.Loading)
    	return;
    
	coinpip.is_error = false;
    coinpip.expired_ = false;
    coinpip.stopTimer = true;
	coinpip.Loading = true;
     $( "#coinpip-api-id" ).val(id);
     $( "#coinpip-local-amount" ).val(params.FiatAmount);
     $( "#coinpip-btc-amount" ).val(params.BtcAmount);
     $( "#coinpip-customer-email" ).val(params.CustomerEmail);
     $( "#coinpip-customer-phone" ).val(params.CustomerPhone);
     $( "#coinpip-reference" ).val(params.Reference);
     $( "#coinpip-currency" ).val(params.Currency);
     if(typeof params.SendRequest != 'undefined')
     	$( "#coinpip-send-request" ).val(params.SendRequest);
  
  $( "#coinpip_pay_description").text('This may take a while, please wait...');
   $( "#coinpip_pay_title").text('');
   $( "#coinpip_rate").text('');
   $( "#coinpip_rate_label").hide();
   $( "#coinpip_payment_content").html(coinpip.LoadingContentHtml);
  
 
  	if(typeof params.mBTC != 'undefined')
		coinpip.mBTC = params.mBTC;
		
var btc = (coinpip.mBTC) ? 'mBTC' : 'BTC';

			
		coinpip.OpenPaymentModal(false);	 
		
                
var post_data = $( "#coinpip-request-action" ).serialize();
if(typeof params.CurrencyConversion != 'undefined')
   post_data += "&autoCurrencyConversion=" + params.CurrencyConversion;
console.log(post_data);
 
$.post( coinpip.MainUrl + "/API/Payment/CreateRequest", post_data)
                    .done(function( data ) {

			coinpip.stopTimer = false;
                    	if(coinpip.expired_){
                    		coinpip.Loading = false;
                    		return;
                    	}

                    	coinpip.mins = 4;
						coinpip.expired_ = false;
						coinpip.secs = coinpip.mins * 60 + 59;  
						coinpip.accepted_amount = 0.00;  
						coinpip.payment_done = false; 

						console.log(data.Status);
						if(data.Status == "error")
						{
							$( "#coinpip_pay_description").text('');
							coinpip.showError("Invalid gateway ID");
							return;
						}            
                    
                       $(".coinpip_close").click();                   
                    	$( "#coinpip_pay_description").text(params.Title);
			$( "#coinpip_pay_description").html($( "#coinpip_pay_description").html().replace(/\n/g,'<br/>'));
                       $( "#coinpip_payment_content").html(coinpip.PaymentContentHtml);
                       
                       $("#coinpip_copy-address").attr('data-clipboard-text', data.Address);
                       
                       
                      coinpip.InitZeroClipboard(data.Address);
                         
                       
                       if(coinpip.Environment.isMobile())
                       		$( "#coinpip_copy-address" ).click(function() {
                       			window.prompt("Copy to clipboard. Then press OK.", data.Address);
                       		});
    			coinpip.BitcoinAddress = data.Address;		
                       var amount = ((coinpip.mBTC) ? (data.BtcAmount * 1000).formatMoney(5) : data.BtcAmount.formatMoney(8));
                       $( "#coinpip_btc").text(btc);
                       $( "#coinpip_accepted_btc").text(((coinpip.mBTC) ? (coinpip.accepted_amount * 1000).formatMoney(5) : coinpip.accepted_amount.formatMoney(8)));
                       $( "#coinpip_expected_btc").text(amount);
                       //console.log( data.PaymentUriString);
                      $( "#coinpip_qr_code").attr('src', 'https://back-office.coinpip.com/API/Payment/QrCode/' + coinpip.guid() + '?size=160&data=' + data.PaymentUriString);
                       $( "#coinpip_pay_title").text('Pay to ' + data.PaymentTo);
                       $( "#coinpip_rate_label").show();
                        $( "#coinpip_rate").text('1 ' + btc + ' = ' + ((coinpip.mBTC) ? (data.Rate / 1000).formatMoney(2) : data.Rate.formatMoney(2)) + ' ' + data.Currency);
                         $( "#coinpip_btc_amount").text(amount + ' ' + btc);
                         $( "#coinpip_fiat_amount").text(data.FiatAmount.formatMoney(2) + ' ' + data.Currency);
                          $( "#coinpip_address_link").attr('href', decodeURIComponent(data.PaymentUriString));
                          $( "#coinpip_address").text(data.Address);
                        coinpip.RequestId = data.RequestId;
                        coinpip.expected_amount = data.BtcAmount;
                        coinpip.Receipt = data.Receipt;
                        coinpip.RedirectUrl = data.RedirectUrl;
                        coinpip.OpenPaymentModal(true, data.RequestId);
                        setTimeout(function () {coinpip.countdown(); }, 1500);
			 coinpip.PaymentContentHtml = $('#coinpip_payment_content').html();
                        coinpip.connectWebSocket(coinpip.SocketUri);
 					})
 					.fail(function(xhr, textStatus, errorThrown) {
 						coinpip.Loading = false;
 						 $( "#coinpip_pay_description").text('');
   						coinpip.showError('Oops! Something went wrong :( Please try again later!');
						console.log(xhr.responseText);
  111					});
    
  }
  
coinpip.guid = function() {
  function s4() {
    return Math.floor((1 + Math.random()) * 0x10000)
      .toString(16)
      .substring(1);
  }
  return s4() + s4() + '-' + s4() + '-' + s4() + '-' +
    s4() + '-' + s4() + s4() + s4();
}

coinpip.showError = function(message)
 {
 		$('#coinpip_payment_content').html('<center><label><span><strong style="color:red;">' + message + '</strong></span></label></center>');
 		coinpip.is_error = true;
 	
 };
 
 coinpip.showSuccess = function(message)
 {
 		$('#coinpip_payment_content').html('<center><label><span><strong style="color:green;">' + message + '</strong></span></label></center>');
 		console.log(coinpip.Receipt);
 	
 }; 
 
 coinpip.Decrement = function() {

	//console.log(coinpip.secs);
	if(coinpip.secs < 0 || coinpip.expired_ || coinpip.payment_done || coinpip.stopTimer)
	{
		if(coinpip.secs > -10 && !coinpip.stopTimer)
			coinpip.expired();
		return;
	}
	
	if(coinpip.is_error) {
			setTimeout(function() { coinpip.Decrement(); }, 1000);
			return;
		}

	if (document.getElementById) {
		var minutes = document.getElementById("coinpip_minutes");
		var seconds = document.getElementById("coinpip_seconds");
		
		
		if (seconds < 59) {
			seconds.innerHTML = (coinpip.secs.toString().length == 1) ? "0" + coinpip.secs : coinpip.secs;
		} else {
			var s = coinpip.getseconds().toString();
			if(s == "-1")
				s = "59";
			var m = coinpip.getminutes().toString();
			
			minutes.innerHTML = (m.length == 1) ? "0" + m : m;
			seconds.innerHTML = (s.length == 1) ? "0" + s : s;
		}
		coinpip.secs--;
		setTimeout(function() { coinpip.Decrement(); }, 1000);
	}
};

 coinpip.getminutes = function() {
	
	coinpip.mins = Math.floor(coinpip.secs / 60);
	return coinpip.mins;
};

 coinpip.getseconds = function() {
	
	return (coinpip.secs-Math.round(coinpip.mins * 60));
};

 coinpip.expired = function() {
	if(!coinpip.payment_done && !coinpip.expired_)
		coinpip.showError("The payment request is timeout. You can request new one if you still need to do the payment");
	coinpip.expired_ = true;
};

coinpip.countdown = function() {
	setTimeout(function() { coinpip.Decrement(); }, 1000);
};


coinpip.onOpen = function(evt) {
	coinpip.socket_open = true;
	if(coinpip.is_error){
		$('#coinpip_payment_content').html(coinpip.PaymentContentHtml);
		coinpip.is_error = false;
		
	     $("#coinpip_copy-address").attr('data-clipboard-text', coinpip.BitcoinAddress);    
         coinpip.InitZeroClipboard(coinpip.BitcoinAddress);          
         if(coinpip.Environment.isMobile())
          $( "#coinpip_copy-address" ).click(function() {
            window.prompt("Copy to clipboard. Then press OK.", coinpip.BitcoinAddress);
          });
	}
	console.log(coinpip.websocket);
	coinpip.websocket.send('{"Value": "' + coinpip.RequestId + '"}');
};

coinpip.onClose = function(evt) {

	if(coinpip.socket_open){
		coinpip.showError("Connection with payment gateway is closed. Trying to reconnect...");
		setTimeout(function() { coinpip.connectWebSocket(coinpip.SocketUri); } , 2000);
	}
};

coinpip.onMessage = function(evt) {

	console.log(evt.data);
	var json = JSON.parse(evt.data);
	
	if(json.Result != "success")
	{
		coinpip.showError("Oops! There are problem to connect the payment gateway :(");
		return;
	}
	
	if(json.Message == "Bundled")
	{
		var amnt = parseFloat(json.Data);
		coinpip.accepted_amount = coinpip.accepted_amount + amnt;
		console.log(coinpip.accepted_amount + ":" + coinpip.expected_amount);
		if(coinpip.accepted_amount.toFixed(8) >= coinpip.expected_amount) {
			coinpip.done(coinpip.Receipt);
			$('#coinpip_accepted_btc').css("color", "green");
			$('#coinpip_accepted_btc').text(((coinpip.mBTC) ? (coinpip.accepted_amount * 1000).formatMoney(5) : coinpip.accepted_amount.formatMoney(8)));							
			coinpip.socket_open = false;
			coinpip.websocket.close();
			coinpip.payment_done = true;
			setTimeout(function() { coinpip.CheckStatus(true); } , 4500);
			
		} else {
			$('#coinpip_accepted_btc').text(((coinpip.mBTC) ? (coinpip.accepted_amount * 1000).formatMoney(5) : coinpip.accepted_amount.formatMoney(8)));
			coinpip.socket_open = false;
			coinpip.websocket.close();
			coinpip.connectWebSocket(coinpip.SocketUri);
		}
	} 
};

coinpip.onError = function(evt) {
	coinpip.showError("Oops! There are problem to connect to the payment gateway. Trying to reconnect...");
	setTimeout(function() { coinpip.connectWebSocket(coinpip.SocketUri); } , 2000);
};

coinpip.connectWebSocket = function(wsUri) { 
            
            coinpip.websocket = new WebSocket(wsUri); 
            console.log(coinpip.websocket);
            coinpip.websocket.onopen = function(evt) { 
                coinpip.onOpen(evt);
            }; 
            
            coinpip.websocket.onclose = function(evt) { 
                coinpip.onClose(evt); 
            }; 
        
            coinpip.websocket.onmessage = function(evt) { 
                coinpip.onMessage(evt);
            }; 
        
            coinpip.websocket.onerror = function(evt) { 
                coinpip.onError(evt);
            };
}; 


coinpip.CheckStatus = function(r) {
	$('#coinpip_loading_button').css('pointer-events', 'none');
	$('#coinpip_loading_button').css('cursor', 'default');
	$('#coinpip_loading').attr('src', coinpip.MainUrl + '/assets/images/loading_small_.gif');

	$.get( coinpip.MainUrl + "/API/REST/CheckRequest/" + coinpip.RequestId, function( data ) {
  		
  		$('#coinpip_loading').attr('src', coinpip.MainUrl + '/assets/images/refresh_.gif');
  		$('#coinpip_loading_button').removeAttr('style');
  		coinpip.accepted_amount = parseFloat(data.AcceptedAmount);
		if(coinpip.accepted_amount > 0)
		    $('#coinpip_accepted_btc').text(((coinpip.mBTC) ? (coinpip.accepted_amount * 1000).formatMoney(5) : coinpip.accepted_amount.formatMoney(8)));

  		if(data.Status == "Paid")
  		{
			coinpip.done(coinpip.Receipt);
  			$('#coinpip_accepted_btc').css("color", "green");
			coinpip.socket_open = false;
			coinpip.websocket.close();
			coinpip.payment_done = true;
			setTimeout(function() { coinpip.showSuccess("Thank you! Your payment was received successfully"); } , 1500);
  		}
		else{
		    if(r){
		console.log('restart');
		setTimeout(function() { coinpip.CheckStatus(true); } , 4000);
	    }
		    $('#coinpip_accepted_btc').css("color", "red");
		}
	});
};
