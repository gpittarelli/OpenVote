(function() {
	DATE_FORMAT = "yyyy-MM-dd";
	DATE_FORMAT_ALTS = [DATE_FORMAT
					   ,"yyyy-dd-MM"
					   ,"yy-dd-MM"];
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
