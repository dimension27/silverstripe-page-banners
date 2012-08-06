<% require themedCSS(SlidesCarousel) %>
<div class="slides-carousel image-carousel">
	<div class="slides_container">
	<% control CarouselItems %>
		<div class="slide">
			<% if HasLink %>
			<a href="$LinkURL" title="$Title">$CarouselImage.SizedTag</a>
			<% else %>
			$CarouselImage.SizedTag
			<% end_if %>
			<div class="caption">
				<div class="bd">$Content</div>
			</div>
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