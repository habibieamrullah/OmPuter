//Screen size reference
var bbRefScreen = {
	width : 1280,
	height : 720,
	maxAspectratio : 1.95,
	ultraWideAspectratio : 2.02157,
	maxWidth : 0,
};

var bbMagicX, bbMagicY;

function bbSwapRefScreenWH(){
	if(innerWidth > innerHeight){
		if(bbRefScreen.width < bbRefScreen.height){
			bbSwapRSWH();
		}
	}else{
		if(bbRefScreen.width > bbRefScreen.height){
			bbSwapRSWH();
		}
	}
}


//In case you need to swap width and height ?
function bbSwapRSWH(){
	var tmpw = bbRefScreen.height;
	var tmph = bbRefScreen.width;
	bbRefScreen.width = tmpw;
	bbRefScreen.height = tmph;
}


//Loading elements
function bbLoadElements(){
	$("body").css({ "margin" : "0px" });
	$(".bb").css({ "position" : "fixed", "box-sizing" : "border-box", });
	$(".bbTextField").css({ "box-sizing" : "border-box", "width" : "100%", });
	
	bbMagicX = innerHeight / bbRefScreen.height;
	bbMagicY = innerWidth / bbRefScreen.width;
	
	$(".bb").each(function(){
		
		//get properties
		var elProp = {
			image : $(this).attr("data-image"),
			width : $(this).attr("data-width"),
			height : $(this).attr("data-height"),
			x : $(this).attr("data-x"),
			y : $(this).attr("data-y"),
			pivotx : $(this).attr("data-pivotx"),
			pivoty : $(this).attr("data-pivoty"),
			scaletype : $(this).attr("data-scaletype"),
			anchor : $(this).attr("data-anchor"),
			parent : $(this).attr("data-parent"),			
			fontsize : $(this).attr("data-fontsize"),
			padding : $(this).attr("data-padding"),
			borderradius : $(this).attr("data-borderradius"),

		}
		
		
		if(elProp.image != undefined){
			$(this).html("");
			$(this).append("<img src='" +elProp.image+ "' style='width: 100%; height: 100%;'>");
		}
		
		if(elProp.pivotx == undefined){
			elProp.pivotx = 0.5;
		}
		
		if(elProp.pivoty == undefined){
			elProp.pivoty = 0.5;
		}
		
		if(elProp.x == undefined){
			elProp.x = 0;
		}
				
		if(elProp.y == undefined){
			elProp.y = 0;
		}
		
		if(elProp.borderradius != undefined){
			$(this).css({
				"border-radius" : elProp.borderradius*bbMagicX + "px",
			});
		}
		
		
		//Scale Modes 
		
		
		if(elProp.scaletype == "scaleonly"){
			var newWidth = innerWidth * (elProp.width/bbRefScreen.width);
			var newHeight = newWidth * (elProp.height/elProp.width);
			
			$(this).css({ 
				"width" : newWidth + "px", 
				"height" : newHeight + "px",
			});
		}
		
		
		//Horizontal scale to fit; calculate only when browser is resized horizontally
		if(elProp.scaletype == "scaletofitH"){
			var newWidth = innerWidth * (elProp.width/bbRefScreen.width);
			var newHeight = newWidth * (elProp.height/elProp.width);
			var newx = innerWidth * (elProp.x/bbRefScreen.width);
			var newy = newx * (elProp.y/elProp.x);

			var newFontsize = elProp.fontsize * bbMagicY;
			var newPadding = elProp.padding * bbMagicY;
			
			bbSetPivot(this, elProp, newx, newy, newWidth, newHeight);

			$(this).css({ 
				"width" : newWidth + "px", 
				"height" : newHeight + "px",
				"font-size" : newFontsize + "px",
				"padding" : newPadding + "px",
			});
		}
		
		
		//Vertical scale to fit; calculate only when browser is resized vertically
		if(elProp.scaletype == "scaletofitV"){

			var newHeight = innerHeight * (elProp.width/bbRefScreen.width);
			var newWidth = newHeight * (elProp.width/elProp.height);
			
			var newx = innerWidth * (elProp.x/bbRefScreen.width);
			var newy = newx * (elProp.y/elProp.x);
			
			$(this).css({ 
				"width" : newWidth + "px", 
				"height" : newHeight + "px",
			});
			
			bbSetPivot(this, elProp, newx, newy, newWidth, newHeight);
			
		}
		
		
		//Vertical scale to fit; but based on the center of the browser window
		if(elProp.scaletype == "scaletofitVMiddle"){

			var newHeight = elProp.height * bbMagicX;
			var newWidth = elProp.width * bbMagicX;		
			
			var newx = innerWidth/2;
			var newy = innerHeight/2;
			
			var newFontsize = elProp.fontsize * (innerHeight/bbRefScreen.height);
			var newPadding = elProp.padding * (innerHeight/bbRefScreen.height);
			
			$(this).css({ 
				"font-size" : newFontsize + "px",
				"padding" : newPadding + "px",
				"width" : newWidth + "px", 
				"height" : newHeight + "px",
				"left" : ((innerWidth / 2) + (elProp.x * bbMagicX)) - ((elProp.width * elProp.pivotx)) * bbMagicY + "px", 
				"top" : ((innerHeight / 2) + (elProp.y * bbMagicX)) - ((elProp.height * elProp.pivoty)) * bbMagicY + "px", 
			});
			
		}
		
		
		//Horizontal scale to fit for ultrawide bg, especially for parent, like basebg on the city, only resize on horizontal screen resize
		if(elProp.scaletype == "scaletofitVUltrawide"){

			var newHeight = innerHeight;
			var newWidth = innerHeight * (elProp.width/elProp.height);
			
			var newx = innerWidth * (elProp.x/bbRefScreen.width);
			var newy = newx * (elProp.y/elProp.x);
			
			
			$(this).css({ 
				"width" : newWidth + "px", 
				"height" : newHeight + "px",
			});
			
			bbSetPivot(this, elProp, newx, newy, newWidth, newHeight);
			
		}
		
		//insidetouch, this will fill the element to fit width or height of the screen 
		if(elProp.scaletype == "insidetouch"){
			
			var newWidth = innerWidth * (elProp.width/bbRefScreen.width);
			var newHeight = newWidth * (elProp.height/elProp.width);
			
			if(newHeight < innerHeight){
				newHeight = innerHeight;
				newWidth = newHeight / (elProp.height/elProp.width);
			}
			
			var newx = innerWidth * (elProp.x/bbRefScreen.width);
			var newy = newx * (elProp.y/elProp.x);
			
			bbSetPivot(this, elProp, newx, newy, newWidth, newHeight);
			
			$(this).css({ 
				"width" : newWidth + "px", 
				"height" : newHeight + "px",
			});
			
		}
		
		//fullstretch, stretch the element to fill the width and the height of browser window
		if(elProp.scaletype == "fullstretch"){
			var newWidth = innerWidth;
			var newHeight = innerHeight;
			
			var newx = innerWidth * (elProp.x/bbRefScreen.width);
			var newy = newx * (elProp.y/elProp.x);
			
			bbSetPivot(this, elProp, newx, newy, newWidth, newHeight);
			
			$(this).css({ 
				"width" : newWidth + "px", 
				"height" : newHeight + "px",
			});
		}
		
				
		//End Of Scale Modes
		
	});
}


//Resizing Text Fields
function bbResizeTextFields(){
	$(".bbTextField").each(function(){
		var textproperties = {
			fontsize : $(this).attr("data-fontsize"),
			padding : $(this).attr("data-padding"),
			margin : $(this).attr("data-margin"),
		}

		$(this).css({ 
			"font-size" : textproperties.fontsize * bbMagicY + "px",
			"padding" : textproperties.padding * bbMagicY + "px",
			"margin" : textproperties.margin * bbMagicY + "px",
		});
		
	});
}


//Set anchors and pivots
function bbSetPivot(elm, elProp, newx, newy, newWidth, newHeight){

	if(elProp.anchor == "topleft"){
		$(elm).css({ 
			"left" : (newx - newWidth*elProp.pivotx) + "px", 
			"top" :  (newy - newHeight*elProp.pivoty) + "px",
		});
	}else if(elProp.anchor == "topright"){
		$(elm).css({ 
			"right" : (newx - newWidth*elProp.pivotx) + "px", 
			"top" :  (newy - newHeight*elProp.pivoty) + "px",
		});
	}else if(elProp.anchor == "topmiddle"){
		$(elm).css({ 
			"left" : ((innerWidth/2) - newWidth*elProp.pivotx) + "px" ,
			"top" :  (elProp.y * bbMagicY) + "px",
		});
	}else if(elProp.anchor == "middle"){
		$(elm).css({ 
			"left" : ((innerWidth/2) + (elProp.x * bbMagicY) - newWidth*elProp.pivotx) + "px" ,
			"top" :  ((innerHeight/2) + (elProp.y * bbMagicX) - (newHeight*elProp.pivoty)) + "px",
		});
	}else if(elProp.anchor == "middleleft"){
		$(elm).css({ 
			"left" : (0 + (elProp.x * bbMagicY) - newWidth*elProp.pivotx) + "px" ,
			"top" :  ((innerHeight/2) + (elProp.y * bbMagicX) - (newHeight*elProp.pivoty)) + "px",
		});
	}else if(elProp.anchor == "middleright"){
		$(elm).css({ 
			"right" : (0 + (elProp.x * bbMagicY) - newWidth*elProp.pivotx) + "px" ,
			"top" :  ((innerHeight/2) + (elProp.y * bbMagicX) - (newHeight*elProp.pivoty)) + "px",
		});
	}else if(elProp.anchor == "bottomleft"){
		$(elm).css({ 
			"left" : (newx - newWidth*elProp.pivotx) + "px", 
			"bottom" : (0 - (newHeight*elProp.pivoty)) + (elProp.y * bbMagicY) + "px",
		});
	}else if(elProp.anchor == "bottomright"){
		$(elm).css({ 
			"right" : (newx - newWidth*elProp.pivotx) + "px", 
			"bottom" : (0 - (newHeight*elProp.pivoty)) + (elProp.y * bbMagicY) + "px",
		});
	}else if(elProp.anchor == "bottommiddle"){
		$(elm).css({ 
			"left" : (newx - newWidth*elProp.pivotx) + (innerWidth/2) + "px", 
			"bottom" : (0 - (newHeight*elProp.pivoty)) + (elProp.y * bbMagicX) + "px",
		});
	}else if(elProp.anchor == "middlev"){
		
		var newx;
		if(innerWidth > newWidth){
			newx = innerWidth - newWidth;
			newx = newx/2;
		}else if(innerWidth < newWidth){
			newx = newWidth - innerWidth;
			newx = newx/2;
			newx = newx * -1;
		}
		
		$(elm).css({ 
			"left" : newx + "px", 
			"top" : "0px",
		});
	}else if(elProp.anchor == "child"){
		
		var tmpparent = $("#" + elProp.parent);
		
		var tmpparentx = parseFloat(tmpparent.css("left")) + (parseFloat(tmpparent.attr("data-width")) * parseFloat(tmpparent.attr("data-pivotx")) * bbMagicY);		
		var tmpparenty = parseFloat(tmpparent.css("top")) + (parseFloat(tmpparent.attr("data-height")) * parseFloat(tmpparent.attr("data-pivoty")) * bbMagicY);

		
		$(elm).css({ 
			
			"left" :  tmpparentx + ((elProp.x - (elProp.width * elProp.pivotx)) * bbMagicY) + "px", 
			"top" :  tmpparenty + ((elProp.y - (elProp.height * elProp.pivoty)) * bbMagicY) + "px", 
			
		});
	}else if(elProp.anchor == "child-middlev"){
		
		$(elm).css({ 

			"left" : (innerWidth / 2) - ((elProp.width * elProp.pivotx)) * bbMagicY + "px", 
			"top" : (innerHeight / 2) - ((elProp.height * elProp.pivoty)) * bbMagicY + "px", 
		});
		
	}
}