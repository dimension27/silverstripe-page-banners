<% require themedCSS(SlidesCarousel) %>
<div id="slides-carousel" class="slides-carousel">
	<div id="slides-carousel-overlay"></div>
	<div class="slides_container">
	<% control CarouselItems %>
		<div><a href="$LinkURL" title="$Title">$Image.SizedTag</a></div>
	<% end_control %>
	</div>
	<div class="carousel-navigation" style="width: $NumItemsBy(100, px)">
		<a href="#" class="prev">prev</a>
		<ul class="carousel-pagination">
		<% control CarouselItems %>
		<li><a href="#">$Pos</a></li>
		<% end_control %>
		</ul>
		<a href="#" class="next">next</a>
	</div>
</div>
<% if IncludeScriptInBody %>
<script type="text/javascript">
jQuery(function($) {
	$('#slides-carousel').slides($CarouselOptions);
});
</script>
<% end_if %>
