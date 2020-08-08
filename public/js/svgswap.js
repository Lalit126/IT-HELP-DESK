$(document).ready(function() {
	$('img.svg').each(function(){
        var img = $(this);
        var imgID = img.attr('id');
        var imgClass = img.attr('class');
        var imgURL = img.attr('src');
        var imgDataToggle = img.attr('data-toggle');
        var imgDataPlacement = img.attr('data-placement');
        var imgDataOriginalTitle = img.attr('data-original-title');
        var imgTitle = img.attr('title');

        $.get(imgURL, function(data) {
            // Get the SVG tag, ignore the rest
            var svg = $(data).find('svg');
            var svgClass = svg.attr('class');

            // Add replaced image's ID to the new SVG
            if(typeof imgID !== 'undefined') {
                svg = svg.attr('id', imgID);
            }
            // Add replaced image's classes to the new SVG
            if(typeof imgClass !== 'undefined') {
                svg = svg.attr('class', svgClass + ' ' + imgClass);
            }
            
            // Add replaced image's data toggle to the new SVG
            if(typeof imgDataToggle !== 'undefined') {
                svg = svg.attr('data-toggle', imgDataToggle);
            }
            
            // Add replaced image's data placement to the new SVG
            if(typeof imgDataPlacement !== 'undefined') {
                svg = svg.attr('data-placement', imgDataPlacement);
            }
            
            // Add replaced image's data original title to the new SVG
            if(typeof imgDataOriginalTitle !== 'undefined') {
                svg = svg.attr('data-original-title', imgDataOriginalTitle);
            }
            
            // Add replaced image's title to the new SVG
            if(typeof imgTitle !== 'undefined') {
                svg = svg.attr('title', imgTitle);
            }

            // Remove any invalid XML tags as per http://validator.w3.org
            svg = svg.removeAttr('xmlns:a');

            // Replace image with new SVG
            img.replaceWith(svg);

        }, 'xml');
    });
	
	$('[data-toggle="tooltip"]').tooltip({
		trigger: 'hover'
	});
});