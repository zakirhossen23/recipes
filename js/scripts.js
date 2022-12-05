!function () { this.MyThemeMobileMenu = function () { "use strict"; this.toggle = null, this.menu = null, this.menu_container = null, this.overlay = null, this.menu_open = !1; arguments[0] && "object" == typeof arguments[0] && (this.options = function (e, t) { for (var n in t) t.hasOwnProperty(n) && (e[n] = t[n]); return e }({ toggle_selector: ".mytheme-mobile-menu-nav-toggle", menu_selector: ".mytheme-mobile-menu-nav-main-ul", menu_container_selector: ".mytheme-mobile-menu-nav-main", callback_menu_open: function () { }, callback_menu_close: function () { } }, arguments[0])), this.toggle = document.querySelectorAll(this.options.toggle_selector)[0], this.menu = document.querySelectorAll(this.options.menu_selector)[0], this.menu_container = document.querySelectorAll(this.options.menu_container_selector)[0], null != this.toggle && null != this.menu && null != this.menu_container ? function () { this.toggle && this.toggle.addEventListener("click", this.toggleMenu.bind(this)) }.call(this) : console.log("Please check MyThemeMobileMenu settings") }, MyThemeMobileMenu.prototype = { toggleMenu: function () { return this.menu_open ? this.closeMenu() : this.openMenu(), this.menu_open }, openMenu: function () { this.menu_open = !0, this.menu.classList.add("is-active"), this.toggle.setAttribute("aria-expanded", "true"), this.toggle.classList.add("is-active"), document.querySelector("body").classList.add("mobile-menu-is-active"), this.options.callback_menu_open() }, closeMenu: function () { this.menu_open = !1, this.toggle.setAttribute("aria-expanded", "false"), this.toggle.classList.remove("is-active"), this.menu.classList.remove("is-active"), document.querySelector("body").classList.remove("mobile-menu-is-active"), this.options.callback_menu_close() } } }();
!function () { this.MyThemeDropdownMenu = function (e) { "use strict"; var t, r, a, d, i = null; function u(e) { e = e.currentTarget; r && e !== r && n(r), n(e) } function n(e) { var t, n = document.getElementById(e.getAttribute("aria-controls")); r = "true" === e.getAttribute("aria-expanded") ? (e.setAttribute("aria-expanded", !1), n.setAttribute("aria-hidden", !0), !1) : (e.setAttribute("aria-expanded", !0), n.setAttribute("aria-hidden", !1), t = n, n = window.innerWidth || document.documentElement.clientWidth || document.body.clientWidth, t.offsetParent.getBoundingClientRect().left + t.offsetWidth + 32 > n && t.classList.add("sub-menu--right"), e) } function l(e) { 27 === e.keyCode && (null !== e.target.closest('ul[aria-hidden="false"]') ? (r.focus(), n(r)) : "true" === e.target.getAttribute("aria-expanded") && n(r)) } null != (i = document.querySelectorAll(e)[0]) ? (null == (t = i.parentElement).getAttribute("id") && t.setAttribute("id", "mytheme-dropdown-menu-1"), function () { i.classList.remove("no-js"); var e = i.querySelectorAll("ul"); if (0 < e.length) for (var t = 0; t < e.length; t++) { var n = e[t], r = n.parentElement; void 0 !== n && (r = function (e) { var t = e.getElementsByTagName("a")[0], n = t.innerHTML, r = t.attributes, i = document.createElement("button"); if (null !== t) { for (i.innerHTML = n.trim(), a = 0, d = r.length; a < d; a++) { var u = r[a]; "href" !== u.name && i.setAttribute(u.name, u.value) } e.replaceChild(i, t) } return i }(r), function (e, t) { var n; n = null === e.getAttribute("id") ? t.textContent.trim().replace(/\s+/g, "-").toLowerCase() + "-submenu" : menuItemId + "-submenu"; t.setAttribute("aria-controls", n), t.setAttribute("aria-expanded", !1), e.setAttribute("id", n), e.setAttribute("aria-hidden", !0) }(n, r), r.addEventListener("click", u), i.addEventListener("keyup", l)) } }(), document.addEventListener("click", function (e) { r && !e.target.closest("#" + t.id) && n(r) })) : console.log("Please check MyThemeDropdownMenu settings") } }();
document.addEventListener("DOMContentLoaded", function () { "use strict"; var e = document.querySelectorAll(['iframe[src*="youtube.com"]', 'iframe[src*="youtube-nocookie.com"]', 'iframe[src*="vimeo.com"]'].join(",")); if (e.length) for (var t = 0; t < e.length; t++) { var o, i, r = e[t], n = r.parentNode; n.classList.contains("wp-block-embed") || n.classList.contains("wp-block-embed__wrapper") || (i = r.getAttribute("width"), o = r.getAttribute("height") / i, (i = document.createElement("div")).className = "fluid-width-video-wrapper", i.style.paddingBottom = 100 * o + "%", n.insertBefore(i, r), r.remove(), i.appendChild(r), r.removeAttribute("height"), r.removeAttribute("width")) } });
document.addEventListener("DOMContentLoaded", function () { "use strict"; var r = document.querySelectorAll('[data-js-action="rcps-vote"]'), d = document.querySelectorAll(".rcps-vote-box")[0], c = document.querySelectorAll(".rcps-rating-stars-single")[0], i = "rcps-rating-updated-animation", l = "rcps-rating-stars-hidden"; if (0 != r.length && void 0 !== d && void 0 !== c) for (var p = c.querySelectorAll(".rcps-5-stars-rating")[0], u = document.querySelectorAll(".rcps-rating-value")[0], v = document.querySelectorAll('[data-vote-count-type="rcps-vote-count-up"]')[0], y = document.querySelectorAll('[data-vote-count-type="rcps-vote-count-down"]')[0], e = d.dataset.postId, t = (function () { var n = new XMLHttpRequest; n.open("POST", ajax_var.url, !0), n.setRequestHeader("Content-type", "application/x-www-form-urlencoded"), n.onreadystatechange = function () { if (n.readyState == XMLHttpRequest.DONE && 200 == n.status) { for (var t = JSON.parse(n.responseText), e = 0; e < r.length; e++) { var a = r[e]; t.what_voted === a.dataset.voteType && a.classList.add("rcps-btn-on"), "up" == a.dataset.voteType ? a.querySelectorAll("b")[0].innerText = t.up_votes : "down" == a.dataset.voteType && (a.querySelectorAll("b")[0].innerText = t.down_votes) } d.setAttribute("data-has-voted", t.what_voted), void 0 !== u && (u.innerText = t.percent + "%"), void 0 !== p && (p.style.width = t.rating_stars_width + "px"), 0 < t.percent && c.classList.remove(l) } }; var t = "action=rcps_voting_setup&post_id=" + e + "&nonce=" + ajax_var.nonce; n.send(t) }(), 0); t < r.length; t++) { var a = r[t]; a.disabled = !1, a.addEventListener("click", function () { h(!0); var t = this.dataset.voteType; d.dataset.hasVoted != t ? (c.classList.remove(i), function (t) { var e = d.dataset.postId, a = t.dataset.voteType, n = new XMLHttpRequest; n.open("POST", ajax_var.url, !0), n.setRequestHeader("Content-type", "application/x-www-form-urlencoded"), n.onreadystatechange = function () { n.readyState == XMLHttpRequest.DONE && 200 == n.status && function (t, e) { if ("-1" != t) { var a = e.dataset.voteType, n = document.querySelectorAll('[data-js-action="rcps-vote"]:not([data-vote-type="' + a + '"]')[0].querySelectorAll('[data-vote-count="rcps-vote-count"]')[0], o = parseInt(n.innerText, 10); if (e.querySelectorAll('[data-vote-count="rcps-vote-count"]')[0].innerText = t, 0 == e.classList.contains(".rcps-btn-on")) for (var s = 0; s < r.length; s++)r[s].classList.remove("rcps-btn-on"); ("up" == d.dataset.hasVoted || "down" == d.dataset.hasVoted) && 0 < o && (n.innerText = parseInt(o, 10) - 1), d.setAttribute("data-has-voted", a), e.classList.add("rcps-btn-on"), function () { var t = parseInt(v.innerText, 10), e = parseInt(y.innerText, 10), t = t / (t + e) * 100; 0 == (t = t.toFixed([0])) ? c.classList.add(l) : (void 0 !== u && (u.innerText = t + "%"), void 0 !== p && (e = Math.round(t / 100 * 70), e = 7 * Math.ceil(e / 7), e -= 1, p.style.width = e + "px"), 0 < t && c.classList.remove(l), c.classList.add(i)) }() } h(!1) }(JSON.parse(n.responseText), t) }; a = "action=rcps_post_vote&post_id=" + e + "&vote_type=" + a + "&nonce=" + ajax_var.nonce; n.send(a) }(this)) : h(!1) }) } function h(t) { for (var e = 0; e < r.length; e++)r[e].disabled = t } });
document.addEventListener('DOMContentLoaded', function () {
	'use strict';

	/**
	 * Image lazy loading polyfill.
	 * Load lazysizes library only if the browser does not support lazy loading.
	 * If browser has support replace data attributes to allow loading images.
	 */
	if ('loading' in HTMLImageElement.prototype) {
		var images = document.querySelectorAll('img[loading="lazy"]');
		for (var i = 0; i < images.length; i++) {
			if (images[i].src == undefined || images[i].src == "") {
				images[i].src = images[i].dataset.src;

				if (images[i].dataset.srcset !== undefined) {
					images[i].srcset = images[i].dataset.srcset;
				}
			}

		}
	} else {
		// Dynamically import the LazySizes library.
		var script = document.createElement('script');
		script.src = 'https://cdnjs.cloudflare.com/ajax/libs/lazysizes/5.3.0/lazysizes.min.js';
		document.body.appendChild(script);
	}

	// Define options for the mobile menu.
	var mobileMenuOptions = {
		toggle_selector: '.rcps-nav-toggle',
		menu_selector: '.rcps-nav-main-ul',
		menu_container_selector: '.rcps-nav-main'
	}

	// Use callback functions to change the SVG icon on mobile menu toggle button.
	var menu_svg = document.querySelectorAll('.rcps-nav-toggle svg use')[0];
	if (typeof (menu_svg) !== 'undefined' && menu_svg != null) {

		mobileMenuOptions.callback_menu_open = function () {
			menu_svg.setAttribute('xlink:href', menu_svg.getAttribute('xlink:href').replace('-menu', '-close'));
			;
		};
		mobileMenuOptions.callback_menu_close = function () {
			menu_svg.setAttribute('xlink:href', menu_svg.getAttribute('xlink:href').replace('-close', '-menu'));
			;
		};
	}

	// Mobile navigation.
	var MobileMenu = new MyThemeMobileMenu(mobileMenuOptions);

	// Drop-down navigation.
	var DropdownMenu = new MyThemeDropdownMenu('.rcps-nav-main-ul');

	/**
	 * ingredient list items clickable.
	 */
	var ingredient_tds = document.querySelectorAll('.rcps-table-ingredients td');
	if (ingredient_tds.length) {
		for (var x = 0; x < ingredient_tds.length; x++) {
			if (typeof (ingredient_tds[x].closest('tr')) !== 'undefined' && ingredient_tds[x].querySelector('input[type="checkbox"]') === null) {
				ingredient_tds[x].addEventListener('click', function () {
					this.closest('tr').classList.toggle('rcps-checked');
				});
			} else {
				ingredient_tds[x].addEventListener('click', function () {
					if (this.querySelector('input[type="checkbox"]').checked){
						this.closest('tr').classList.add('rcps-checked');
					}
					updateHaveIt();
					updateCostPerServing();
					updateOverbuyInvestment();
				});
			}
		}
	}

	/**
	 * Adds more input fields for ingredient list in the submit recipe form.
	 */
	var add_field_buttons = document.querySelectorAll('[data-js-action="rcps-add-field"]');
	if (add_field_buttons.length) {
		for (var i = 0; i < add_field_buttons.length; i++) {
			add_field_buttons[i].addEventListener('click', function (event) {
				event.preventDefault();
				var id = this.getAttribute('id').replace('rcps-add-field-', '');
				var wrapper = document.querySelector('#rcps-ingredient-list-wrapper-' + id);
				var table = wrapper.querySelector('table');
				var items = table.querySelectorAll('tr.rcps-tr-ingredient');
				var last_item = items[items.length - 1];

				var cloned_item = last_item.cloneNode(true);
				table.appendChild(cloned_item);
				var inputs = cloned_item.getElementsByTagName('input');
				if (inputs.length) {
					for (var i = 0; i < inputs.length; i++) {
						inputs[i].value = '';

						var new_input_name = inputs[i].getAttribute('name').replace(/[0-9]+(?!.*[0-9])/, function (match) {
							return parseInt(match, 10) + 1;
						});

						inputs[i].setAttribute('name', new_input_name);
					}
				}
			});
		}
	}

	/**
	 * Reveals more ingredient lists in the submit recipe form.
	 */
	var ingredient_list_wrappers = document.querySelectorAll('div[id^=rcps-ingredient-list-wrapper-]');
	var ingredient_list_add_buttons = document.querySelectorAll('[data-js-action="rcps-add-ingredient-list"]');

	if (ingredient_list_wrappers.length && ingredient_list_add_buttons.length) {
		for (var i = 0; i < ingredient_list_add_buttons.length; i++) {
			ingredient_list_add_buttons[i].addEventListener('click', function (event) {
				event.preventDefault();
				this.style.display = 'none';

				for (var i = 1; i <= ingredient_list_wrappers.length; i++) {
					var target = document.querySelector('#rcps-ingredient-list-wrapper-' + String(i));
					if (target.classList.contains('rcps-hidden')) {
						target.classList.remove('rcps-hidden');
						break;
					}
				}
			});
		}
	}

	/**
	 * Tabs.
	 */
	var $tabs = getAll('.rcps-tab-submit');
	if ($tabs.length > 1) {
		$tabs[1].style.display = 'none';
	}

	var $tab_lis = getAll('.rcps-tabs-nav-submit li');
	if ($tab_lis.length > 0) {
		$tab_lis[0].classList.add('rcps-tabs-nav-active');
		$tabs[0].style.display = 'block';

		$tab_lis.forEach(function ($el, index) {
			var $link = $tab_lis[index].getElementsByTagName('a')[0];

			$link.addEventListener('click', function (event) {
				event.preventDefault();

				for (var y = 0; y < $tab_lis.length; y++) {
					$tab_lis[y].classList.remove('rcps-tabs-nav-active');
				}

				$el.classList.add('rcps-tabs-nav-active');

				for (var y = 0; y < $tabs.length; y++) {
					$tabs[y].style.display = 'none';
				}

				var activeTabId = $link.getAttribute('href');
				var activeTab = document.getElementById(activeTabId.replace('#', ''));
				activeTab.style.display = 'block';
				return false;
			});
		});
	}

	if ($tab_lis.length > 1 && $tabs.length > 1) {
		if ($tab_lis[1].classList.contains('rcps-tabs-nav-active')) {
			$tabs[0].style.display = 'none';
			$tabs[1].style.display = 'block';
			$tab_lis[0].classList.remove('rcps-tabs-nav-active');
		}
	}

	/**
	 * Opens the share links in a new window.
	 */
	var $share_links = getAll('.rcps-share-link');
	if ($share_links.length > 0) {
		$share_links.forEach(function ($el) {
			$el.addEventListener('click', function (event) {
				event.preventDefault();
				window.open(this.href, 'newWindow', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=300,width=600');
				return false;
			});
		});
	}

	// Hidden elements.
	var $hide_on_load_elements = getAll('.hide-on-load');
	if ($hide_on_load_elements.length > 0) {
		$hide_on_load_elements.forEach(function ($el) {
			$el.style.display = 'none';
		});
	}

	function getAll(selector) {
		return Array.prototype.slice.call(document.querySelectorAll(selector), 0);
	}

	var $toggle_elements = getAll('[data-target-element]');
	if ($toggle_elements.length > 0) {
		$toggle_elements.forEach(function ($el) {
			$el.addEventListener('click', function (event) {

				var target_data_value = $el.dataset.targetElement;

				// Get the target element by the data attribute.
				var target = document.querySelector('[data-target="' + target_data_value + '"]');

				if (null !== target) {
					var computedStyle = getComputedStyle(target);

					if (computedStyle.display === 'none') {
						target.style.display = "block";
					} else {
						target.style.display = "none";
					}

					// Add class to the clicked element.
					$el.classList.toggle('active');

					// Hide the clicked element.
					if ($el.dataset.hideOnClick === 'true') {
						$el.style.display = "none";
					}
				}
			});
		});
	}

	// Dropdowns.
	var $dropdowns = getAll('.rcps-btn-has-dropdown');
	if ($dropdowns.length > 0) {
		$dropdowns.forEach(function ($el, index) {
			$el.addEventListener('click', function (event) {
				event.stopPropagation();
				// Close all dropdowns before showing the wanted one. If another dropdown is open, this closes it.
				// Pass index to not close the clicked dropdown, as it is closed in any case.
				closeDropdowns($dropdowns, index);
				$el.classList.toggle('active');
				$el.parentElement.querySelectorAll('.rcps-dropdown-content')[0].classList.toggle('show');
			});
		});

		// Close all dropdowns when clicking elsewhere.
		document.addEventListener('click', function () {
			closeDropdowns($dropdowns);
		});
	}

	function closeDropdowns($dropdowns, index) {
		$dropdowns.forEach(function ($el, i) {
			if (index == i) {
				return;
			}
			$el.classList.remove('active');
			$el.parentElement.querySelectorAll('.rcps-dropdown-content')[0].classList.remove('show');
		});
	}

	// AJAX.
	var ajax_args = {
		'page': 1,
	};

	// Submit form. Equal to adding onchange="this.form.submit().
	var search_form = document.querySelectorAll(".rcps-ajax-form")[0];
	if (typeof search_form !== 'undefined') {
		search_form.addEventListener('change', function (event) {
			search_form.classList.add('is-loading');
			search_form.submit();
		});
	}

	// Load more posts.
	document.querySelector('body').addEventListener('click', function (event) {
		if (event.target.classList.contains('rcps-ajax-load-more-button')) {
			event.preventDefault();

			var button = event.target;

			button.textContent = ajax_var.text_loading;
			ajax_args.current_page = ajax_var.current_page;

			refreshGrid(ajax_args);
		}
	});
});

function refreshedGrid(refreshed) {
	var form = document.querySelectorAll('.rcps-ajax-form')[0];

	if (typeof form !== 'undefined') {
		form.classList.remove('is-loading');
	}

	var button = document.querySelectorAll('.rcps-ajax-load-more-button')[0];

	if (true === refreshed) {
		ajax_var.current_page++;
		button.textContent = ajax_var.text_load_more;

		if (ajax_var.current_page == ajax_var.max_page) {
			button.parentNode.removeChild(button); // For IE compatibility.
		}
	} else {
		// If no data, remove the button as well.
		button.parentNode.removeChild(button); // For IE compatibility.
	}
}

function refreshGrid(ajax_args) {

	var ajax_target = 'rcps-ajax-target-loadmore';

	var ajax_target_div = document.getElementsByClassName(ajax_target)[0];

	// Get the search form.
	var form = document.querySelectorAll(".rcps-ajax-form")[0];

	if (typeof ajax_target_div === 'undefined') {
		console.log('RCPS AJAX target element undefined.');
		return;
	}

	args_json = JSON.stringify(ajax_args);

	if (typeof form !== 'undefined') {
		form.classList.add('is-loading');

		// Build form data.
		var form_data = {};
		if (typeof form !== 'undefined') {
			form_data = buildFormData(form.elements);
		}

		// Convert object to JSON.
		form_data_json = JSON.stringify(form_data);
	} else {
		form_data_json = '';
	}

	// AJAX.
	var xhr = new XMLHttpRequest();
	xhr.open('POST', ajax_var.url, true);

	// Send the proper header information along with the request.
	xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

	// Call a function when the state changes.
	xhr.onreadystatechange = function () {
		if (xhr.readyState == XMLHttpRequest.DONE && xhr.status == 200) {
			var response = JSON.parse(xhr.responseText);
			ajax_target_div.innerHTML = ajax_target_div.innerHTML + response.recipes_html;
			refreshedGrid(true);
		} else if (xhr.readyState == XMLHttpRequest.DONE && xhr.status == 400) {
			refreshedGrid(false);
		}
	};

	var data = 'action=rcps_ajax_query_recipes&form_data=' + form_data_json + '&args=' + args_json + '&_ajax_nonce=' + ajax_var.nonce;
	xhr.send(data);
}

function buildFormData(form_elements) {
	// Create object.
	var form_data = {};

	// Loop through form elements to push the name and value of elements into the object.
	if (typeof form_elements !== 'undefined' && form_elements.length > 0) {
		for (var i = 0; i < form_elements.length; i++) {
			var element = form_elements[i];
			if (element.name && element.value) {
				if (element.type == 'radio' || element.type == 'checkbox') {
					if (element.name.indexOf('[]') > -1) { // For IE compatibility.
						var input_group = [];
						if (undefined == form_elements[element.name].length) {
							input_group.push(form_elements[element.name]);
						} else {
							input_group = form_elements[element.name];
						}
						var input_group_values = [];
						for (var x = 0; x < input_group.length; x++) {
							var input = input_group[x];
							if (input.checked) {
								input_group_values.push(input.value);
							}
						}
						form_data[element.name.replace('[]', '')] = [];
						form_data[element.name.replace('[]', '')] = input_group_values;
					} else {
						if (element.checked) {
							form_data[element.name] = element.value;
						}
					}
				} else {
					form_data[element.name] = element.value;
				}
			}
		}
	}
	return form_data;
}

// Polyfill for Element.closest().
if (!Element.prototype.matches) {
	Element.prototype.matches =
		Element.prototype.msMatchesSelector ||
		Element.prototype.webkitMatchesSelector;
}

if (!Element.prototype.closest) {
	Element.prototype.closest = function (s) {
		var el = this;

		do {
			if (Element.prototype.matches.call(el, s)) return el;
			el = el.parentElement || el.parentNode;
		} while (el !== null && el.nodeType === 1);
		return null;
	};
}

//# sourceMappingURL=scripts.js.map
