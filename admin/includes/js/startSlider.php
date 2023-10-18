<script src="js/slider.js" type="text/javascript"></script>
<script type="text/javascript">
window.jssor_1_slider_init = function() 
{
	var jssor_1_SlideoTransitions = 
	[
		[{b:-1,d:1,ls:0.5},{b:0,d:1000,y:5,e:{y:6}}],
		[{b:-1,d:1,ls:0.5},{b:200,d:1000,y:25,e:{y:6}}],
		[{b:-1,d:1,ls:0.5},{b:400,d:1000,y:45,e:{y:6}}],
		[{b:-1,d:1,ls:0.5},{b:600,d:1000,y:65,e:{y:6}}],
		[{b:-1,d:1,ls:0.5},{b:800,d:1000,y:85,e:{y:6}}],
		[{b:-1,d:1,ls:0.5},{b:500,d:1000,y:195,e:{y:6}}],
		[{b:0,d:2000,y:30,e:{y:3}}],
		[{b:-1,d:1,rY:-15,tZ:100},{b:0,d:1500,y:30,o:1,e:{y:3}}],
		[{b:-1,d:1,rY:-15,tZ:-100},{b:0,d:1500,y:100,o:0.8,e:{y:3}}],
		[{b:500,d:1500,o:1}],
		[{b:0,d:1000,y:380,e:{y:6}}],
		[{b:300,d:1000,x:80,e:{x:6}}],
		[{b:300,d:1000,x:330,e:{x:6}}],
		[{b:-1,d:1,r:-110,sX:5,sY:5},{b:0,d:2000,o:1,r:-20,sX:1,sY:1,e:{o:6,r:6,sX:6,sY:6}}],
		[{b:0,d:600,x:150,o:0.5,e:{x:6}}],
		[{b:0,d:600,x:1140,o:0.6,e:{x:6}}],
		[{b:-1,d:1,sX:5,sY:5},{b:600,d:600,o:1,sX:1,sY:1,e:{sX:3,sY:3}}]
	];
	
	var jssor_1_options = 
	{
		$AutoPlay: 1,
		$LazyLoading: 1,
		$CaptionSliderOptions: 
		{
			$Class: $JssorCaptionSlideo$,
			$Transitions: jssor_1_SlideoTransitions
		},
		$ArrowNavigatorOptions: 
		{
			$Class: $JssorArrowNavigator$
		},
		$BulletNavigatorOptions: 
		{
			$Class: $JssorBulletNavigator$,
			$SpacingX: 20,
			$SpacingY: 20
		}
	};
	
	var jssor_1_slider = new $JssorSlider$("jssor_1", jssor_1_options);
	
	/*#region responsive code begin*/
	var MAX_WIDTH = 1280;
	
	function ScaleSlider() 
	{
		var containerElement = jssor_1_slider.$Elmt.parentNode;
		var containerWidth = containerElement.clientWidth;
		if (containerWidth) 
		{
			var expectedWidth = Math.min(MAX_WIDTH || containerWidth, containerWidth);
			jssor_1_slider.$ScaleWidth(expectedWidth);
		}
		else 
		{
			window.setTimeout(ScaleSlider, 30);
		}
	}
	
	ScaleSlider();
	$Jssor$.$AddEvent(window, "load", ScaleSlider);
	$Jssor$.$AddEvent(window, "resize", ScaleSlider);
	$Jssor$.$AddEvent(window, "orientationchange", ScaleSlider);
	/*#endregion responsive code end*/
};
</script>
<script type="text/javascript">
window.jssor_2_slider_init = function() 
{
	var jssor_2_SlideoTransitions = 
	[
		[{b:-1,d:1,ls:0.5},{b:0,d:1000,y:5,e:{y:6}}],
		[{b:-1,d:1,ls:0.5},{b:200,d:1000,y:25,e:{y:6}}],
		[{b:-1,d:1,ls:0.5},{b:400,d:1000,y:45,e:{y:6}}],
		[{b:-1,d:1,ls:0.5},{b:600,d:1000,y:65,e:{y:6}}],
		[{b:-1,d:1,ls:0.5},{b:800,d:1000,y:85,e:{y:6}}],
		[{b:-1,d:1,ls:0.5},{b:500,d:1000,y:195,e:{y:6}}],
		[{b:0,d:2000,y:30,e:{y:3}}],
		[{b:-1,d:1,rY:-15,tZ:100},{b:0,d:1500,y:30,o:1,e:{y:3}}],
		[{b:-1,d:1,rY:-15,tZ:-100},{b:0,d:1500,y:100,o:0.8,e:{y:3}}],
		[{b:500,d:1500,o:1}],
		[{b:0,d:1000,y:380,e:{y:6}}],
		[{b:300,d:1000,x:80,e:{x:6}}],
		[{b:300,d:1000,x:330,e:{x:6}}],
		[{b:-1,d:1,r:-110,sX:5,sY:5},{b:0,d:2000,o:1,r:-20,sX:1,sY:1,e:{o:6,r:6,sX:6,sY:6}}],
		[{b:0,d:600,x:150,o:0.5,e:{x:6}}],
		[{b:0,d:600,x:1140,o:0.6,e:{x:6}}],
		[{b:-1,d:1,sX:5,sY:5},{b:600,d:600,o:1,sX:1,sY:1,e:{sX:3,sY:3}}]
	];
	
	var jssor_2_options = 
	{
		$AutoPlay: 1,
		$LazyLoading: 1,
		$CaptionSliderOptions: 
		{
			$Class: $JssorCaptionSlideo$,
			$Transitions: jssor_2_SlideoTransitions
		},
		$ArrowNavigatorOptions: 
		{
			$Class: $JssorArrowNavigator$
		},
		$BulletNavigatorOptions: 
		{
			$Class: $JssorBulletNavigator$,
			$SpacingX: 20,
			$SpacingY: 20
		}
	};
	
	var jssor_2_slider = new $JssorSlider$("jssor_2", jssor_2_options);
	
	/*#region responsive code begin*/
	var MAX_WIDTH = 1280;
	
	function ScaleSlider() 
	{
		var containerElement = jssor_2_slider.$Elmt.parentNode;
		var containerWidth = containerElement.clientWidth;
		if (containerWidth) 
		{
			var expectedWidth = Math.min(MAX_WIDTH || containerWidth, containerWidth);
			jssor_2_slider.$ScaleWidth(expectedWidth);
		}
		else 
		{
			window.setTimeout(ScaleSlider, 30);
		}
	}
	
	ScaleSlider();
	$Jssor$.$AddEvent(window, "load", ScaleSlider);
	$Jssor$.$AddEvent(window, "resize", ScaleSlider);
	$Jssor$.$AddEvent(window, "orientationchange", ScaleSlider);
	/*#endregion responsive code end*/
};
</script>
<script type="text/javascript">
window.jssor_3_slider_init = function() 
{
	var jssor_3_SlideoTransitions = 
	[
		[{b:-1,d:1,ls:0.5},{b:0,d:1000,y:5,e:{y:6}}],
		[{b:-1,d:1,ls:0.5},{b:200,d:1000,y:25,e:{y:6}}],
		[{b:-1,d:1,ls:0.5},{b:400,d:1000,y:45,e:{y:6}}],
		[{b:-1,d:1,ls:0.5},{b:600,d:1000,y:65,e:{y:6}}],
		[{b:-1,d:1,ls:0.5},{b:800,d:1000,y:85,e:{y:6}}],
		[{b:-1,d:1,ls:0.5},{b:500,d:1000,y:195,e:{y:6}}],
		[{b:0,d:2000,y:30,e:{y:3}}],
		[{b:-1,d:1,rY:-15,tZ:100},{b:0,d:1500,y:30,o:1,e:{y:3}}],
		[{b:-1,d:1,rY:-15,tZ:-100},{b:0,d:1500,y:100,o:0.8,e:{y:3}}],
		[{b:500,d:1500,o:1}],
		[{b:0,d:1000,y:380,e:{y:6}}],
		[{b:300,d:1000,x:80,e:{x:6}}],
		[{b:300,d:1000,x:330,e:{x:6}}],
		[{b:-1,d:1,r:-110,sX:5,sY:5},{b:0,d:2000,o:1,r:-20,sX:1,sY:1,e:{o:6,r:6,sX:6,sY:6}}],
		[{b:0,d:600,x:150,o:0.5,e:{x:6}}],
		[{b:0,d:600,x:1140,o:0.6,e:{x:6}}],
		[{b:-1,d:1,sX:5,sY:5},{b:600,d:600,o:1,sX:1,sY:1,e:{sX:3,sY:3}}]
	];
	
	var jssor_3_options = 
	{
		$AutoPlay: 1,
		$LazyLoading: 1,
		$CaptionSliderOptions: 
		{
			$Class: $JssorCaptionSlideo$,
			$Transitions: jssor_3_SlideoTransitions
		},
		$ArrowNavigatorOptions: 
		{
			$Class: $JssorArrowNavigator$
		},
		$BulletNavigatorOptions: 
		{
			$Class: $JssorBulletNavigator$,
			$SpacingX: 20,
			$SpacingY: 20
		}
	};
	
	var jssor_3_slider = new $JssorSlider$("jssor_3", jssor_3_options);
	
	/*#region responsive code begin*/
	var MAX_WIDTH = 1280;
	
	function ScaleSlider() 
	{
		var containerElement = jssor_3_slider.$Elmt.parentNode;
		var containerWidth = containerElement.clientWidth;
		if (containerWidth) 
		{
			var expectedWidth = Math.min(MAX_WIDTH || containerWidth, containerWidth);
			jssor_3_slider.$ScaleWidth(expectedWidth);
		}
		else 
		{
			window.setTimeout(ScaleSlider, 30);
		}
	}
	
	ScaleSlider();
	$Jssor$.$AddEvent(window, "load", ScaleSlider);
	$Jssor$.$AddEvent(window, "resize", ScaleSlider);
	$Jssor$.$AddEvent(window, "orientationchange", ScaleSlider);
	/*#endregion responsive code end*/
};
</script>
<script type="text/javascript">
window.jssor_4_slider_init = function() 
{
	var jssor_4_SlideoTransitions = 
	[
		[{b:-1,d:1,ls:0.5},{b:0,d:1000,y:5,e:{y:6}}],
		[{b:-1,d:1,ls:0.5},{b:200,d:1000,y:25,e:{y:6}}],
		[{b:-1,d:1,ls:0.5},{b:400,d:1000,y:45,e:{y:6}}],
		[{b:-1,d:1,ls:0.5},{b:600,d:1000,y:65,e:{y:6}}],
		[{b:-1,d:1,ls:0.5},{b:800,d:1000,y:85,e:{y:6}}],
		[{b:-1,d:1,ls:0.5},{b:500,d:1000,y:195,e:{y:6}}],
		[{b:0,d:2000,y:30,e:{y:3}}],
		[{b:-1,d:1,rY:-15,tZ:100},{b:0,d:1500,y:30,o:1,e:{y:3}}],
		[{b:-1,d:1,rY:-15,tZ:-100},{b:0,d:1500,y:100,o:0.8,e:{y:3}}],
		[{b:500,d:1500,o:1}],
		[{b:0,d:1000,y:380,e:{y:6}}],
		[{b:300,d:1000,x:80,e:{x:6}}],
		[{b:300,d:1000,x:330,e:{x:6}}],
		[{b:-1,d:1,r:-110,sX:5,sY:5},{b:0,d:2000,o:1,r:-20,sX:1,sY:1,e:{o:6,r:6,sX:6,sY:6}}],
		[{b:0,d:600,x:150,o:0.5,e:{x:6}}],
		[{b:0,d:600,x:1140,o:0.6,e:{x:6}}],
		[{b:-1,d:1,sX:5,sY:5},{b:600,d:600,o:1,sX:1,sY:1,e:{sX:3,sY:3}}]
	];
	
	var jssor_4_options = 
	{
		$AutoPlay: 1,
		$LazyLoading: 1,
		$CaptionSliderOptions: 
		{
			$Class: $JssorCaptionSlideo$,
			$Transitions: jssor_4_SlideoTransitions
		},
		$ArrowNavigatorOptions: 
		{
			$Class: $JssorArrowNavigator$
		},
		$BulletNavigatorOptions: 
		{
			$Class: $JssorBulletNavigator$,
			$SpacingX: 20,
			$SpacingY: 20
		}
	};
	
	var jssor_4_slider = new $JssorSlider$("jssor_4", jssor_4_options);
	
	/*#region responsive code begin*/
	var MAX_WIDTH = 1280;
	
	function ScaleSlider() 
	{
		var containerElement = jssor_4_slider.$Elmt.parentNode;
		var containerWidth = containerElement.clientWidth;
		if (containerWidth) 
		{
			var expectedWidth = Math.min(MAX_WIDTH || containerWidth, containerWidth);
			jssor_4_slider.$ScaleWidth(expectedWidth);
		}
		else 
		{
			window.setTimeout(ScaleSlider, 30);
		}
	}
	
	ScaleSlider();
	$Jssor$.$AddEvent(window, "load", ScaleSlider);
	$Jssor$.$AddEvent(window, "resize", ScaleSlider);
	$Jssor$.$AddEvent(window, "orientationchange", ScaleSlider);
	/*#endregion responsive code end*/
};
</script>

<style>
/* jssor slider loading skin spin css */
.jssorl-009-spin img 
{
	animation-name: jssorl-009-spin;
	animation-duration: 1.6s;
	animation-iteration-count: infinite;
	animation-timing-function: linear;
}
@keyframes jssorl-009-spin 
{
	from 
	{
		transform: rotate(0deg);
	}
	to 
	{
		transform: rotate(360deg);
	}
}
/*jssor slider bullet skin 132 css*/
.jssorb132 
{
	position:absolute;
}
.jssorb132 .i 
{
	position:absolute;
	cursor:pointer;
}
.jssorb132 .i .b 
{
	fill:#fff;
	fill-opacity:0.8;
	stroke:#000;
	stroke-width:1600;
	stroke-miterlimit:10;
	stroke-opacity:0.7;
}
.jssorb132 .i:hover .b 
{
	fill:#000;
	fill-opacity:.7;
	stroke:#fff;
	stroke-width:2000;
	stroke-opacity:0.8;
}
.jssorb132 .iav .b 
{
	fill:#000;
	stroke:#fff;
	stroke-width:2400;
	fill-opacity:0.8;
	stroke-opacity:1;
}
.jssorb132 .i.idn 
{
	opacity:0.3;
}
.jssora051 
{
	display:block;
	position:absolute;
	cursor:pointer;
}
.jssora051 .a 
{
	fill:none;
	stroke:#fff;
	stroke-width:360;
	stroke-miterlimit:10;
}
.jssora051:hover 
{
	opacity:.8;
}
.jssora051.jssora051dn 
{
	opacity:.5;
}
.jssora051.jssora051ds 
{
	opacity:.3;
	pointer-events:none;
}
</style>