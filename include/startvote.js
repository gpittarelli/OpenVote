(function() {
	DATE_FORMAT = "M-d-(y HH:mm:ss";
	DATE_FORMAT_ALTS = [DATE_FORMAT
					   ,"MM-dd-yyyy hh:mm:ssaa"
					   ,"MM-dd-yyyy hh:mm:ssaa"
					   ,"MM-dd-yyyy h:mm:ssaa"
					   ,"MM-dd-yyyy hh:mm:ssAA"
					   ,"MM-dd-yyyy h:mm:ssAA"];
	$(document).ready(function() {
		var $input = $("input#end_date");
		var $preview = $("div#end_date_preview");

		$input.keyup(function(e) {

			var val = $input.val(), date;
			if (val.length > 0) {

				$input.removeClass("fail")

				if (Date.parseExact(val, DATE_FORMAT) === null) {
					$input.addClass("fail")
				}

			}
		});
	});
})();
