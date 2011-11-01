<% require javascript(http://gsgd.co.uk/sandbox/jquery/easing/jquery.easing.1.3.js) %>
<% require javascript(banners/js/slides.min.jquery.js) %>
<% require themedCSS(BannerCarousel) %>
<div id="banner-carousel" class="banner-carousel">
	<div id="banner-carousel-overlay"></div>
	<div class="slides_container">
	<% control AllBanners %>
		<div><a href="$LinkURL" title="$Title">$SizedTag(340)</a></div>
	<% end_control %>
	</div>
	<div class="carousel-navigation">
		<a href="#" class="prev">&lt;</a>
		<ul class="carousel-pagination"></ul>
		<a href="#" class="next">&gt;</a>
	</div>
</div>
<script type="text/javascript">
jQuery(function($) {
	$('#banner-carousel').slides($CarouselOptions);
});
</script>