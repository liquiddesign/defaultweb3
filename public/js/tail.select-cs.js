/*
 |  tail.select - The vanilla solution to make your HTML select fields AWESOME!
 |  @file       ./langs/tail.select-de.js
 |  @author     SamBrishes <sam@pytes.net>
 |  @version    0.5.15 - Beta
 |
 |  @website    https://github.com/pytesNET/tail.select
 |  @license    X11 / MIT License
 |  @copyright  Copyright © 2014 - 2019 SamBrishes, pytesNET <info@pytes.net>
 */
/*
 |  Translator:     SamBrishes - (https://www.pytes.net)
 |  GitHub:         <internal>
 */
;(function(factory){
	if(typeof(define) == "function" && define.amd){
		define(function(){
			return function(select){ factory(select); };
		});
	} else {
		if(typeof(window.tail) != "undefined" && window.tail.select){
			factory(window.tail.select);
		}
	}
}(function(select){
	select.strings.register("cz", {
		all: "Všechny",
		none: "Žádné",
		empty: "Nejsou dostupné žádné možnosti",
		emptySearch: "Nenašli se žádné možnosti",
		limit: "Žádné další možnosti nejsou k dispozici",
		placeholder: "Vyberte možnost...",
		placeholderMulti: "Vyberte více možností...",
		search: "Začněte psát",
		disabled: "Toto pole není aktivní"
	});
	return select;
}));
