<% require themedCSS(bxSlider) %>
<ul class="bxSlider image-carousel">
	<% control CarouselItems %>
	<li style="width: {$Image.Width}px"><a href="$LinkURL" title="$Title">$Image.SizedTag</a></li>
	<% end_control %>
</ul>
<% if IncludeScriptInBody %>
<script type="text/javascript">
jQuery(function($) {
	$('.bxSlider').bxSlider($CarouselOptions);
});
</script>
<% end_if %>
