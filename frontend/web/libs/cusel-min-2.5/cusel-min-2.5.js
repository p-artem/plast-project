/* -------------------------------------

	cusel version 2.5
	last update: 31.10.11
	СЃРјРµРЅР° РѕР±С‹С‡РЅРѕРіРѕ СЃРµР»РµРєС‚ РЅР° СЃС‚РёР»СЊРЅС‹Р№
	autor: Evgen Ryzhkov
	updates by:
		- Alexey Choporov
		- Roman Omelkovitch
	using libs:
		- jScrollPane
		- mousewheel
	www.xiper.net
----------------------------------------	
*/
function cuselScrollToCurent(a) {
	var b = null;
	if (a.find(".cuselOptHover").eq(0).is("span")) b = a.find(".cuselOptHover").eq(0);
	else if (a.find(".cuselActive").eq(0).is("span")) b = a.find(".cuselActive").eq(0);
	if (a.find(".jScrollPaneTrack").eq(0).is("div") && b) {
		var c = b.position(),
			d = a.find(".cusel-scroll-pane").eq(0).attr("id");
		jQuery("#" + d)[0].scrollTo(c.top) } }

function cuselShowList(a) {
	var b = a.parent(".cusel");
	if (a.css("display") == "none") { $(".cusel-scroll-wrap").css("display", "none");
		$(".cuselOpen").removeClass("cuselOpen");
		b.addClass("cuselOpen");
		a.css("display", "block");
		var c = false;
		if (b.prop("class").indexOf("cuselScrollArrows") != -1) c = true;
		//if (!a.find(".jScrollPaneContainer").eq(0).is("div")) { a.find("div").eq(0).jScrollPaneCusel({ showArrows: c }) }
		cuselScrollToCurent(a) } else { a.css("display", "none");
		b.removeClass("cuselOpen") } }

function cuSelRefresh(a) {
	var b = a.refreshEl.split(","),
		c = b.length,
		d;
	for (d = 0; d < c; d++) {
		var e = jQuery(b[d]).parents(".cusel").find(".cusel-scroll-wrap").eq(0);
		e.find(".cusel-scroll-pane").jScrollPaneRemoveCusel();
		e.css({ visibility: "hidden", display: "block" });
		var f = e.find("span"),
			g = f.eq(0).outerHeight();
		if (f.length > a.visRows) { e.css({ height: g * a.visRows + "px", display: "none", visibility: "visible" }).children(".cusel-scroll-pane").css("height", g * a.visRows + "px") } else { e.css({ display: "none", visibility: "visible" }) } } }

function cuSel(a) {
	function b() { jQuery("html").unbind("click");
		jQuery("html").click(function(a) {
			var b = jQuery(a.target),
				c = b.attr("id"),
				d = b.prop("class");
			if ((d.indexOf("cuselText") != -1 || d.indexOf("cuselFrameRight") != -1) && b.parent().prop("class").indexOf("classDisCusel") == -1) {
				var e = b.parent().find(".cusel-scroll-wrap").eq(0);
				cuselShowList(e) } else if (d.indexOf("cusel") != -1 && d.indexOf("classDisCusel") == -1 && b.is("div")) {
				var e = b.find(".cusel-scroll-wrap").eq(0);
				cuselShowList(e) } else if (b.is(".cusel-scroll-wrap span") && d.indexOf("cuselActive") == -1) {
				var f;
				b.attr("val") == undefined ? f = b.text() : f = b.attr("val");
				b.parents(".cusel-scroll-wrap").find(".cuselActive").eq(0).removeClass("cuselActive").end().parents(".cusel-scroll-wrap").next().val(f).end().prev().text(b.text()).end().css("display", "none").parent(".cusel").removeClass("cuselOpen");
				b.addClass("cuselActive");
				b.parents(".cusel-scroll-wrap").find(".cuselOptHover").removeClass("cuselOptHover");
				if (d.indexOf("cuselActive") == -1) b.parents(".cusel").find(".cusel-scroll-wrap").eq(0).next("input").change() } else if (b.parents(".cusel-scroll-wrap").is("div")) {
				return } else { jQuery(".cusel-scroll-wrap").css("display", "none").parent(".cusel").removeClass("cuselOpen") } });
		jQuery(".cusel").unbind("keydown");
		jQuery(".cusel").keydown(function(a) {
			var b, c;
			if (window.event) b = window.event.keyCode;
			else if (a) b = a.which;
			if (b == null || b == 0 || b == 9) return true;
			if (jQuery(this).prop("class").indexOf("classDisCusel") != -1) return false;
			if (b == 40) {
				var d = jQuery(this).find(".cuselOptHover").eq(0);
				if (!d.is("span")) var e = jQuery(this).find(".cuselActive").eq(0);
				else var e = d;
				var f = e.next();
				if (f.is("span")) { jQuery(this).find(".cuselText").eq(0).text(f.text());
					e.removeClass("cuselOptHover");
					f.addClass("cuselOptHover");
					$(this).find("input").eq(0).val(f.attr("val"));
					cuselScrollToCurent($(this).find(".cusel-scroll-wrap").eq(0));
					return false } else return false }
			if (b == 38) {
				var d = $(this).find(".cuselOptHover").eq(0);
				if (!d.is("span")) var e = $(this).find(".cuselActive").eq(0);
				else var e = d;
				cuselActivePrev = e.prev();
				if (cuselActivePrev.is("span")) { $(this).find(".cuselText").eq(0).text(cuselActivePrev.text());
					e.removeClass("cuselOptHover");
					cuselActivePrev.addClass("cuselOptHover");
					$(this).find("input").eq(0).val(cuselActivePrev.attr("val"));
					cuselScrollToCurent($(this).find(".cusel-scroll-wrap").eq(0));
					return false } else return false }
			if (b == 27) {
				var g = $(this).find(".cuselActive").eq(0).text();
				$(this).removeClass("cuselOpen").find(".cusel-scroll-wrap").eq(0).css("display", "none").end().find(".cuselOptHover").eq(0).removeClass("cuselOptHover");
				$(this).find(".cuselText").eq(0).text(g) }
			if (b == 13) {
				var h = $(this).find(".cuselOptHover").eq(0);
				if (h.is("span")) { $(this).find(".cuselActive").removeClass("cuselActive");
					h.addClass("cuselActive") } else var i = $(this).find(".cuselActive").attr("val");
				$(this).removeClass("cuselOpen").find(".cusel-scroll-wrap").eq(0).css("display", "none").end().find(".cuselOptHover").eq(0).removeClass("cuselOptHover");
				$(this).find("input").eq(0).change() }
			if (b == 32 && $.browser.opera) {
				var j = $(this).find(".cusel-scroll-wrap").eq(0);
				cuselShowList(j) }
			if ($.browser.opera) return false });
		var a = [];
		jQuery(".cusel").keypress(function(b) {
			function g() {
				var b = [];
				for (var c in a) {
					if (window.event) b[c] = a[c].keyCode;
					else if (a[c]) b[c] = a[c].which;
					b[c] = String.fromCharCode(b[c]).toUpperCase() }
				var d = jQuery(e).find("span"),
					f = d.length,
					g, h;
				for (g = 0; g < f; g++) {
					var i = true;
					for (var j in a) { h = d.eq(g).text().charAt(j).toUpperCase();
						if (h != b[j]) { i = false } }
					if (i) { jQuery(e).find(".cuselOptHover").removeClass("cuselOptHover").end().find("span").eq(g).addClass("cuselOptHover").end().end().find(".cuselText").eq(0).text(d.eq(g).text());
						cuselScrollToCurent($(e).find(".cusel-scroll-wrap").eq(0));
						a = a.splice;
						a = [];
						break;
						return true } }
				a = a.splice;
				a = [] }
			var c, d;
			if (window.event) c = window.event.keyCode;
			else if (b) c = b.which;
			if (c == null || c == 0 || c == 9) return true;
			if (jQuery(this).prop("class").indexOf("classDisCusel") != -1) return false;
			var e = this;
			a.push(b);
			clearTimeout(jQuery.data(this, "timer"));
			var f = setTimeout(function() { g() }, 500);
			jQuery(this).data("timer", f);
			if (jQuery.browser.opera && window.event.keyCode != 9) return false }) }
	jQuery(a.changedEl).each(function(c) {
		var d = jQuery(this),
			e = d.outerWidth(),
			f = d.prop("class"),
			g = d.prop("id") ? d.prop("id") : "cuSel-" + c,
			h = d.prop("name"),
			j = d.val(),
			k = d.find("option[value='" + j + "']").eq(0),
			l = k.text(),
			m = d.prop("disabled"),
			n = a.scrollArrows,
			o = d.prop("onchange"),
			p = d.prop("tabindex"),
			q = d.prop("multiple");
		if (!g || q) return false;
		var r = d.data("events"),
			s = [];
		if (r && r["change"]) { $.each(r["change"], function(a, b) { s[s.length] = b }) }
		if (!m) { classDisCuselText = "", classDisCusel = "" } else { classDisCuselText = "classDisCuselLabel";
			classDisCusel = "classDisCusel" }
		if (n) { classDisCusel += " cuselScrollArrows" }
		k.addClass("cuselActive");
		var t = d.html(),
			u = t.replace(/option/ig, "span").replace(/value=/ig, "val=");
		if ($.browser && parseInt($.browser.version) < 9) {
			var v = /(val=)(.*?)(>)/g;
			u = u.replace(v, "$1'$2'$3") }

		// // style="width:' + e + 'px" Длинна селекта
		// var w = '<div class="cusel ' + f + " " + classDisCusel + '"' + " id=cuselFrame-" + g + ' style="width:' + e + 'px"' + ' tabindex="' + p + '"' + ">" + '<div class="cuselFrameRight"></div>' + '<div class="cuselText">' + l + "</div>" + '<div class="cusel-scroll-wrap"><div class="cusel-scroll-pane" id="cusel-scroll-' + g + '">' + u + "</div></div>" + '<input type="hidden" id="' + g + '" name="' + h + '" value="' + j + '" />' + "</div>";
		// d.replaceWith(w);

		var w = '<div class="cusel ' + f + " " + classDisCusel + '"' + " id=cuselFrame-" + g + ' ' + ' tabindex="' + p + '"' + ">" + '<div class="cuselFrameRight"></div>' + '<div class="cuselText">' + l + "</div>" + '<div class="cusel-scroll-wrap"><div class="cusel-scroll-pane" id="cusel-scroll-' + g + '">' + u + "</div></div>" + '<input type="hidden" id="' + g + '" name="' + h + '" value="' + j + '" />' + "</div>";
		d.replaceWith(w);

		if (o) jQuery("#" + g).bind("change", o);
		if (s.length) { $.each(s, function(a, b) { $("#" + g).bind("change", b) }) }
		var x = jQuery("#cuselFrame-" + g),
			y = x.find("span"),
			z;
		if (!y.eq(0).text()) { z = y.eq(1).innerHeight();
			y.eq(0).css("height", y.eq(1).height()) } else { z = y.eq(0).innerHeight() }
		if (y.length > a.visRows) { x.find(".cusel-scroll-wrap").eq(0).css({ height: z * a.visRows + "px", display: "none", visibility: "visible" }).children(".cusel-scroll-pane").css("height", z * a.visRows + "px") } else { x.find(".cusel-scroll-wrap").eq(0).css({ display: "none", visibility: "visible" }) }
		var A = jQuery("#cusel-scroll-" + g).find("span[addTags]"),
			B = A.length;
		for (i = 0; i < B; i++) A.eq(i).append(A.eq(i).attr("addTags")).removeAttr("addTags");
		b() });
	jQuery(".cusel").focus(function() { jQuery(this).addClass("cuselFocus") });
	jQuery(".cusel").blur(function() { jQuery(this).removeClass("cuselFocus") });
	jQuery(".cusel").hover(function() { jQuery(this).addClass("cuselFocus") }, function() { jQuery(this).removeClass("cuselFocus") }) }