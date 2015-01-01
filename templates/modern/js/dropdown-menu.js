/*
CSS for the demo: jQuery Media Rich Dropdown Menu
Demo: jQuery Media Rich Dropdown Menu
Author: Ian Lunn
Author URL: http://www.ianlunn.co.uk/
Demo URL: http://www.ianlunn.co.uk/demos/jquery-media-rich-drop-down-menu/
Tutorial URL: http://www.ianlunn.co.uk/blog/code-tutorials/jquery-media-rich-dropdown-menu/

License: http://creativecommons.org/licenses/by-sa/3.0/ (Attribution Share Alike). Please attribute work to Ian Lunn simply by leaving these comments in the source code or if you'd prefer, place a link on your website to http://www.ianlunn.co.uk/.

Dual licensed under the MIT and GPL licenses:
http://www.opensource.org/licenses/mit-license.php
http://www.gnu.org/licenses/gpl.html
*/

$(document).ready(function() {
	
	/*lots of IE6 fixes for lack of child selector support*/
	
	$("#nav > li").css({"display": "inline"});
	$("#nav > li > ul").css({"padding": "5px", "position": "absolute", "width": "auto"});
	$("#nav > li > ul > li").css({"color": "black", "height": "100%", "padding": "0 0 0 5px", "width": "175px"});
	
	/*end of IE6 fixes*/
	
	
	/*set up the styles for the Javascript dropdowns - the CSS stylesheet is setup for when JavaScript is disabled, the following lines change that CSS for when JavaScript is enabled*/
	
	$("#nav li > ul").css({"background": "white", "border": "#ccc solid 2px"});
	$("#nav ul ul").css({"background": "none", "border": "none"});
	$("#nav li > ul").css({"color": "#999", "display": "block", "float": "left", "margin": 0, "padding": "10px", "left": "auto"});
	$("span").css("display","block"); /* show category titles */
	$("#nav li").css({"display": "inline"});
	$("li li").css({"float": "left", "margin": "0", "font-size": "12px"});
	$(".show ul li ul").css({"display":"block"}); /* show all child links */
	   
   $(function() {
   $('#nav > li').hover( function(){ /* when the user hovers over the main navigation links, change the colour */
      $(this).css('background-color', '#ff88e');
   },
   function(){ /* when they move out of that navigation link, change the colour back */
      $(this).css('background-color', '#ff88e');
   });
});

	/*end of CSS setup*/
	
	/*once the JavaScript has loaded and the CSS is set up...*/
	
	$("#nav ul").css("display", "block"); //show the navigation menu
	$("#nav > li").children("ul").css("display", "none");  //hide all dropdowns
	var top = $("#nav > li").position().top + $("#nav > li").height(); //find the top position for the dropdown menu by adding the top position of the navigation links to their height (giving the bottom position for the navigation links)		
			
	$("#nav > li").hover( //when the user hovers of the navigation link...
  	function () {
		var left = $(this).position().left; //get the postion of the main link relative to the <body>
		var offset = $(this).offset().left; //get the position of the main link relative to the document
		var width = $(this).children("ul").width(); //get the width of the dropdown
		var over = (left + width) - 940; //work out how much the dropdown hangs over the <body> (as we don't want it to do that)
		
		if(left + width > 940){ //if the position of the main link + the width of the dropdown menu is more than the <body> width...
			$(this).children("ul").css("display", "block"); //show the dropdown menu
			$(this).children("ul").css({left:left-over, top:top}); //set the position of the dropdown minus the overhang to keep it viewable, inside the <body>
		}else{
			$(this).children("ul").css("display", "block"); //show the dropdown menu
			$(this).children("ul").css({left:left, top:top}); //set the position of the dropdown
		}
  	}, 
  	function () { //if the user moves the cursor outside of the dropdown menu...
		$(this).children("ul").css("display", "none");  //hide the menu	
  	}
);

});