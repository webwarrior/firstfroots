(function(document){
window.MBP = window.MBP || {}; 
MBP.viewportmeta = document.querySelector && document.querySelector('meta[name="viewport"]');
MBP.ua = navigator.userAgent;
MBP.scaleFix = function () {
  if (MBP.viewportmeta && /iPhone|iPad/.test(MBP.ua) && !/Opera Mini/.test(MBP.ua)) {
    MBP.viewportmeta.content = "width=device-width, minimum-scale=1.0, maximum-scale=1.0";
    document.addEventListener("gesturestart", MBP.gestureStart, false);
  }
};
MBP.gestureStart = function () {
    MBP.viewportmeta.content = "width=device-width, minimum-scale=0.25, maximum-scale=1.6";
};

MBP.hideUrlBar = function () {
	var win = window,
		doc = win.document;
	if( !location.hash || !win.addEventListener ){

		window.scrollTo( 0, 1 );
		var scrollTop = 1,


		bodycheck = setInterval(function(){
			if( doc.body ){
				clearInterval( bodycheck );
				scrollTop = "scrollTop" in doc.body ? doc.body.scrollTop : 1;
				win.scrollTo( 0, scrollTop === 1 ? 0 : 1 );
			}	
		}, 15 );

		win.addEventListener( "load", function(){
			setTimeout(function(){
				win.scrollTo( 0, scrollTop === 1 ? 0 : 1 );
			}, 0);
		}, false );
	}
};


MBP.fastButton = function(element, handler) {
    this.handler = handler;

    if(element.length && element.length > 1) {
        for(var singleElIdx in element) {
            if(element[singleElIdx].addEventListener) {
                this.addClickEvent(element[singleElIdx]);
            }
        }
    } else if(element.addEventListener) {
      this.addClickEvent(element);
    }
};

MBP.fastButton.prototype.handleEvent = function(event) {
    switch (event.type) {
        case 'touchstart': this.onTouchStart(event); break;
        case 'touchmove': this.onTouchMove(event); break;
        case 'touchend': this.onClick(event); break;
        case 'click': this.onClick(event); break;
    }
};

MBP.fastButton.prototype.onTouchStart = function(event) {
    event.stopPropagation();
    var element = event.srcElement;
    element.addEventListener('touchend', this, false);
    document.body.addEventListener('touchmove', this, false);
    this.startX = event.touches[0].clientX;
    this.startY = event.touches[0].clientY;
};

MBP.fastButton.prototype.onTouchMove = function(event) {
    var element = event.srcElement;
    if(Math.abs(event.touches[0].clientX - this.startX) > 10 || 
       Math.abs(event.touches[0].clientY - this.startY) > 10    ) {
        this.reset(element);
    }
};

MBP.fastButton.prototype.onClick = function(event) {
    event.stopPropagation();
    var element = event.srcElement;

    this.reset(element);
    this.handler.apply(event.currentTarget, [event]);

    if(event.type == 'touchend') {
        MBP.preventGhostClick(this.startX, this.startY);
    }
};

MBP.fastButton.prototype.reset = function(srcElement) {
    srcElement.removeEventListener('touchend', this, false);
    document.body.removeEventListener('touchmove', this, false);
};

MBP.fastButton.prototype.addClickEvent = function(element) {
    element.addEventListener('touchstart', this, false);
    element.addEventListener('click', this, false);
};

MBP.preventGhostClick = function (x, y) {
    MBP.coords.push(x, y);
    window.setTimeout(function (){
        MBP.coords.splice(0, 2);
    }, 2500);
};

MBP.ghostClickHandler = function (event) {
    for(var i = 0, len = MBP.coords.length; i < len; i += 2) {
        var x = MBP.coords[i];
        var y = MBP.coords[i + 1];
        if(Math.abs(event.clientX - x) < 25 && Math.abs(event.clientY - y) < 25) {
            event.stopPropagation();
            event.preventDefault();
        }
    }
};

if (document.addEventListener) {
    document.addEventListener('click', MBP.ghostClickHandler, true);
}
                            
MBP.coords = [];

MBP.autogrow = function (element, lh) {

    function handler(e){
        var newHeight = this.scrollHeight,
            currentHeight = this.clientHeight;
        if (newHeight > currentHeight) {
            this.style.height = newHeight + 3 * textLineHeight + "px";
        }
    }

    var setLineHeight = (lh) ? lh : 12,
        textLineHeight = element.currentStyle ? element.currentStyle.lineHeight : 
                         getComputedStyle(element, null).lineHeight;

    textLineHeight = (textLineHeight.indexOf("px") == -1) ? setLineHeight :
                     parseInt(textLineHeight, 10);

    element.style.overflow = "hidden";
    element.addEventListener ? element.addEventListener('keyup', handler, false) :
                               element.attachEvent('onkeyup', handler);
};

})(document);