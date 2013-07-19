	<!-- @ JAVASCRIPT @ -->
	<script>
		function changeVideo(id, video){
			var cadena= '<embed id="'+id+'" type="application/x-shockwave-flash" src="./js/video/flvplayer.swf" pluginspage="http://www.macromedia.com/go/getflashplayer" flashvars="file='+video+'&autoStart=false" height="260" width="320">'
					
			$("#contentVideos_"+id).html(cadena);
		}
	</script>
	<!-- @ JAVASCRIPT @ -->

	<!-- @ CSSS @ -->
	<!-- @ CSSS @ -->
	
	
	<!-- {js} -->
	<!-- {css} -->
	
	
	<div id='contentVideos_<!-- {name} -->'
	<embed id="<!-- {name} -->" type="application/x-shockwave-flash" src="./js/video/flvplayer.swf" pluginspage="http://www.macromedia.com/go/getflashplayer" flashvars="file=<!-- {video} -->&autoStart=false" height="260" width="320">
	</div>
	
	<ul>
		<!-- @ ROW @ -->
		<li><a href="javascript:changeVideo('<!-- {name} -->', '<!-- {video} -->');"><!-- {text} --></a></li>
		<!-- @ ROW @ -->
		<!-- {rows} -->
	</ul>
	

</body>
</html>