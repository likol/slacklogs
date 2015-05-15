// Infinite scrolling ---------------------------------------------- /

function prepareWaypoint(container, wpDirection) {

    var more = '.infinite-more-link-' + wpDirection;
    var $container = $(container);
    var offset;
    if (wpDirection == 'down') {
        offset = 'bottom-in-view';
    }
    else {
        offset = $('header').height();
    }

	var waypoint = new Waypoint({
		element: $container,
		offset: offset,
		handler: function (direction) {
            if (direction !== wpDirection) {
                return;
            }
			var $more = $(more);
			if (!$more.length) {
                return; // No way to disable only the up or the down waypoint
            }
			
			$.get($more.attr('href'), function (data) {
                $more.remove();
                if (direction === 'up') {
                    var scrollTo = $($('.logs').children()[0]);
                    $container.prepend(data);
                    moveTo(scrollTo, 0);
                } else if (direction === 'down') {
                    $container.append(data);
					waypoint.destroy();
					$container.trigger('contentChanged');
					prepareWaypoint('.logs', 'down');
                }
				
            });
		}
	});
}

prepareWaypoint('.logs', 'up');
prepareWaypoint('.logs', 'down');