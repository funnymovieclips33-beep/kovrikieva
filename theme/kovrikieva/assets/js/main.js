/* KovrikiEVA — весь JS темы, без зависимостей. */
(function () {
	'use strict';
	var d = document;
	var cfg = window.KV || {};
	var $ = function (s, c) { return (c || d).querySelector(s); };
	var $$ = function (s, c) { return Array.prototype.slice.call((c || d).querySelectorAll(s)); };

	/* ---------- Цели аналитики ---------- */
	function goal(name, params) {
		try { if (window.ym && cfg.metrika) ym(+cfg.metrika, 'reachGoal', name, params || {}); } catch (e) {}
		try { if (window.gtag) gtag('event', name, params || {}); } catch (e) {}
	}
	d.addEventListener('click', function (e) {
		var a = e.target.closest('[data-goal]');
		if (a) goal(a.getAttribute('data-goal'));
	});

	/* ---------- Шапка ---------- */
	var header = $('[data-kv-header]');
	if (header) {
		var onScroll = function () { header.classList.toggle('is-scrolled', window.scrollY > 10); };
		addEventListener('scroll', onScroll, { passive: true });
		onScroll();
	}
	var burger = $('[data-kv-burger]');
	var nav = $('#kv-nav');
	if (burger && nav) {
		burger.addEventListener('click', function () {
			var open = burger.getAttribute('aria-expanded') !== 'true';
			burger.setAttribute('aria-expanded', open);
			nav.classList.toggle('is-open', open);
			d.documentElement.style.overflow = open ? 'hidden' : '';
		});
	}

	/* ---------- Модальные окна ---------- */
	function openModal(id, trigger) {
		var m = d.getElementById('kv-modal-' + id);
		if (!m || typeof m.showModal !== 'function') return;
		if (id === 'order' && trigger) {
			var product = trigger.getAttribute('data-product');
			var sub = $('[data-order-product]', m);
			var sel = $('select[name=product]', m);
			if (product) {
				if (sub) sub.textContent = product;
				if (sel) {
					var found = false;
					$$('option', sel).forEach(function (o) { if (o.value === product) { sel.value = product; found = true; } });
					if (!found) {
						var o = d.createElement('option'); o.textContent = product; sel.insertBefore(o, sel.firstChild); sel.value = product;
					}
				} else {
					var h = $('input[name=product]', m);
					if (!h) { h = d.createElement('input'); h.type = 'hidden'; h.name = 'product'; $('form', m).appendChild(h); }
					h.value = product;
				}
			}
		}
		m.showModal();
		goal('open_' + id);
		var f = $('input[type=tel]', m) || $('input[type=search]', m);
		if (f && matchMedia('(pointer:fine)').matches) setTimeout(function () { f.focus(); }, 50);
	}
	d.addEventListener('click', function (e) {
		var t = e.target.closest('[data-modal]');
		if (t) { e.preventDefault(); openModal(t.getAttribute('data-modal'), t); return; }
		var c = e.target.closest('[data-close]');
		if (c) { c.closest('dialog').close(); return; }
		// клик по подложке
		if (e.target.tagName === 'DIALOG') e.target.close();
	});

	/* ---------- Выбор продукта на /zakazat/ ---------- */
	d.addEventListener('click', function (e) {
		var p = e.target.closest('[data-pick]');
		if (!p) return;
		var box = $('#order-form');
		var sel = box && $('select[name=product]', box);
		if (sel) sel.value = p.getAttribute('data-pick');
		if (box) box.scrollIntoView({ behavior: 'smooth', block: 'start' });
	});

	/* ---------- Поиск города ---------- */
	var cf = $('[data-city-filter]');
	if (cf) {
		cf.addEventListener('input', function () {
			var q = cf.value.trim().toLowerCase().replace(/ё/g, 'е');
			$$('[data-city-list] li').forEach(function (li) {
				li.hidden = q && li.textContent.toLowerCase().replace(/ё/g, 'е').indexOf(q) === -1;
			});
		});
	}

	/* ---------- Маска телефона +375 (XX) XXX-XX-XX ---------- */
	function formatPhone(v) {
		var n = v.replace(/\D/g, '');
		if (n.indexOf('375') !== 0) {
			if (n.indexOf('80') === 0) n = '375' + n.slice(2);
			else if (n.length) n = '375' + n;
		}
		n = n.slice(0, 12);
		var r = '+375';
		if (n.length > 3) r += ' (' + n.slice(3, 5);
		if (n.length >= 5) r += ')';
		if (n.length > 5) r += ' ' + n.slice(5, 8);
		if (n.length > 8) r += '-' + n.slice(8, 10);
		if (n.length > 10) r += '-' + n.slice(10, 12);
		return r;
	}
	d.addEventListener('input', function (e) {
		if (e.target.type === 'tel') {
			e.target.value = formatPhone(e.target.value);
			e.target.classList.remove('is-invalid');
		}
	});
	d.addEventListener('focusin', function (e) {
		if (e.target.type === 'tel' && !e.target.value) e.target.value = '+375 (';
		var f = e.target.closest('[data-kv-form]');
		if (f && !f.dataset.started) { f.dataset.started = 1; goal('form_start'); }
	});

	/* ---------- Отправка форм ---------- */
	var t0 = Date.now();
	function utm() {
		try {
			var s = sessionStorage.getItem('kv_utm');
			if (!s && location.search.indexOf('utm_') > -1) { s = location.search.slice(1); sessionStorage.setItem('kv_utm', s); }
			return s || '';
		} catch (e) { return ''; }
	}
	utm();
	$$('[data-kv-form]').forEach(function (form) {
		form.addEventListener('submit', function (e) {
			e.preventDefault();
			var tel = $('input[type=tel]', form);
			var msg = $('.kv-form__msg', form);
			if (tel.value.replace(/\D/g, '').length < 12) {
				tel.classList.add('is-invalid');
				msg.className = 'kv-form__msg is-err';
				msg.textContent = 'Введите номер полностью: +375 (XX) XXX-XX-XX';
				tel.focus();
				return;
			}
			var data = new FormData(form);
			data.set('t', t0);
			data.set('page', location.href.split('#')[0]);
			data.set('utm', utm());
			form.classList.add('is-loading');
			msg.className = 'kv-form__msg';
			msg.textContent = '';
			fetch(cfg.rest, { method: 'POST', body: data, credentials: 'same-origin' })
				.then(function (r) { return r.json().then(function (j) { return { ok: r.ok, j: j }; }); })
				.then(function (res) {
					form.classList.remove('is-loading');
					if (res.ok && res.j.ok) {
						form.classList.add('is-sent');
						msg.className = 'kv-form__msg is-ok';
						msg.textContent = 'Спасибо! Заявка принята — мы свяжемся с вами в ближайшее время.';
						goal('lead', { form: data.get('form') });
						try { if (window.gtag && cfg.gads) gtag('event', 'conversion', { send_to: cfg.gads }); } catch (e) {}
					} else {
						throw new Error(res.j && res.j.error);
					}
				})
				.catch(function (err) {
					form.classList.remove('is-loading');
					msg.className = 'kv-form__msg is-err';
					msg.textContent = (err && err.message) || 'Не удалось отправить. Позвоните нам или напишите в Viber.';
				});
		});
	});

	/* ---------- Табы галереи (фото грузятся только при открытии вкладки) ---------- */
	d.addEventListener('click', function (e) {
		var tab = e.target.closest('[data-tab]');
		if (!tab) return;
		var sec = tab.closest('section');
		var id = tab.getAttribute('data-tab');
		$$('[data-tab]', sec).forEach(function (b) { b.setAttribute('aria-selected', b === tab); });
		var panel = $('[data-panel]', sec);
		var tpl = $('[data-panel-tpl="' + id + '"]', sec);
		if (!panel.dataset.first) {
			// сохраняем первую вкладку в шаблон, чтобы можно было вернуться
			var keep = d.createElement('template');
			keep.setAttribute('data-panel-tpl', panel.getAttribute('data-panel'));
			keep.innerHTML = panel.innerHTML;
			panel.parentNode.insertBefore(keep, panel);
			panel.dataset.first = 1;
		}
		if (tpl) {
			panel.innerHTML = tpl.innerHTML;
			panel.setAttribute('data-panel', id);
		}
	});

	/* ---------- Лайтбокс ---------- */
	var lb = d.getElementById('kv-lightbox');
	var lbImg = lb && $('[data-lb-img]', lb);
	var lbList = [], lbIdx = 0;
	function lbShow(i) {
		lbIdx = (i + lbList.length) % lbList.length;
		lbImg.src = lbList[lbIdx].href;
		var im = $('img', lbList[lbIdx]);
		lbImg.alt = im ? im.alt : '';
	}
	d.addEventListener('click', function (e) {
		var a = e.target.closest('[data-lightbox]');
		if (a && lb) {
			e.preventDefault();
			var g = a.closest('[data-gallery-group]');
			lbList = g ? $$('[data-lightbox]', g) : [a];
			var fr = $('iframe', lb); if (fr) fr.remove();
			lbImg.hidden = false;
			$$('.kv-lightbox__nav', lb).forEach(function (b) { b.hidden = lbList.length < 2; });
			lbShow(lbList.indexOf(a));
			lb.showModal();
			return;
		}
		var nav = e.target.closest('[data-lb]');
		if (nav) lbShow(lbIdx + +nav.getAttribute('data-lb'));
	});
	if (lb) {
		lb.addEventListener('keydown', function (e) {
			if (e.key === 'ArrowRight') lbShow(lbIdx + 1);
			if (e.key === 'ArrowLeft') lbShow(lbIdx - 1);
		});
		lb.addEventListener('close', function () { var fr = $('iframe', lb); if (fr) fr.remove(); lbImg.removeAttribute('src'); });
		var sx = 0;
		lb.addEventListener('touchstart', function (e) { sx = e.touches[0].clientX; }, { passive: true });
		lb.addEventListener('touchend', function (e) {
			var dx = e.changedTouches[0].clientX - sx;
			if (Math.abs(dx) > 50 && lbList.length > 1) lbShow(lbIdx + (dx < 0 ? 1 : -1));
		});
	}

	/* ---------- Видео (Vimeo грузится только по клику) ---------- */
	d.addEventListener('click', function (e) {
		var v = e.target.closest('[data-video]');
		if (!v || !lb) return;
		var fr = d.createElement('iframe');
		fr.src = 'https://player.vimeo.com/video/' + encodeURIComponent(v.getAttribute('data-video')) + '?autoplay=1';
		fr.allow = 'autoplay; fullscreen';
		fr.allowFullscreen = true;
		lbImg.hidden = true;
		$$('.kv-lightbox__nav', lb).forEach(function (b) { b.hidden = true; });
		lb.appendChild(fr);
		lb.showModal();
		goal('video');
	});

	/* ---------- Карта: загрузка по клику или при приближении ---------- */
	function loadMap(box) {
		if (box.dataset.loaded) return;
		box.dataset.loaded = 1;
		var fr = d.createElement('iframe');
		fr.src = box.getAttribute('data-map-src');
		fr.title = 'Карта проезда';
		fr.loading = 'lazy';
		box.innerHTML = '';
		box.appendChild(fr);
	}
	d.addEventListener('click', function (e) {
		var b = e.target.closest('[data-map-load]');
		if (b) loadMap(b.closest('[data-map-src]'));
	});
})();
