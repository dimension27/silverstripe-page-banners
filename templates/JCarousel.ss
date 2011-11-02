<% require themedCSS(JCarousel) %>
<ul class="jcarousel image-carousel">
	<% control CarouselItems %>
	<li>
		<a href="$LinkURL" title="$Title">$Image.SizedTag</a>
	</li>
	<% end_control %>
</ul>
<% if IncludeScriptInBody %>
<script type="text/javascript">
jQuery(function($) {
	$('.jcarousel').jcarousel($CarouselOptions);
});
</script>
<% end_if %>
