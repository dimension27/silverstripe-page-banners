<% require themedCSS(SlidesCarousel) %>
<div class="slides-carousel image-carousel">
	<div class="slides_container">
	<% control CarouselItems %>
		<div class="slide">
			<% if LinkURL %><a href="$LinkURL" title="$Title"><% end_if %>
				$CarouselImage.SizedTag
			<% if LinkURL %></a><% end_if %>
			<% if Content %>
			<div class="caption">
				<div class="bd">$Content</div>
			</div>
			<% end_if %>
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