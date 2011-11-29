<% require themedCSS(SlidesCarousel) %>
<div class="slides-carousel image-carousel">
	<div class="slides_container">
	<% control CarouselItems %>
		<div>
			<a href="$LinkURL" title="$Title">$Image.SizedTag</a>
			<div class="caption">$Caption</div>
		</div>
	<% end_control %>
	</div>
	<div class="carousel-navigation">
		<a href="#" class="prev">Previous</a>
		<ul class="carousel-pagination"><% control CarouselItems %>
			<li><a href="#">$Pos</a></li><% end_control %>
		</ul>
		<a href="#" class="next">Next</a>
	</div>
</div>
<% if IncludeScriptInBody %>
<script type="text/javascript">
jQuery(function($) {
	$('.slides-carousel').slides($CarouselOptions);
});
</script>
<% end_if %>