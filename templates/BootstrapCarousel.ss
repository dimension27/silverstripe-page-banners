<div id="$DOMId" class="carousel slide">
	<% if ShowIndicators %>
		<ol class="carousel-indicators">
			<% control CarouselItems %>
				<li data-target="#$DOMId" data-slide-to="$Pos" class="<% if First %>active<% end_if %>"></li>
			<% end_control %>
		</ol>
	<% end_if %>
	<div class="carousel-inner">
		<% control CarouselItems %>
			<div class="item<% if First %> active<% end_if %>">
				<% if LinkURL %><a href="$LinkURL" title="$Title"><% end_if %>
					$CarouselImage.SizedTag
				<% if LinkURL %></a><% end_if %>
				<% if Content %>
					<div class="caption">
						<div class="bd">$Content</div>
					</div>
				<% end_if %>
			</div>
	</div>
	<a href="#$DomId" data-slide="prev" class="carousel-control left">‹</a>
	<a href="#$DomId" data-slide="next" class="carousel-control right">›</a>
</div>