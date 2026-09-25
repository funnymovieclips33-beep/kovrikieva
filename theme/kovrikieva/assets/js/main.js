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
	function setMenu(open) {
		burger.setAttribute('aria-expanded', open);
		nav.classList.toggle('is-open', open);
		d.documentElement.classList.toggle('kv-menu-open', open);
	}
	if (burger && nav) {
		burger.addEventListener('click', function () { setMenu(burger.getAttribute('aria-expanded') !== 'true'); });
		var ov = $('[data-kv-overlay]');
		if (ov) ov.addEventListener('click', function () { setMenu(false); });
		d.addEventListener('keydown', function (e) { if (e.key === 'Escape' && nav.classList.contains('is-open')) setMenu(false); });
		$$('.kv-subtoggle', nav).forEach(function (b) {
			b.addEventListener('click', function () {
				var li = b.parentNode, open = !li.classList.contains('is-sub-open');
				$$('.is-sub-open', nav).forEach(function (o) { if (o !== li) { o.classList.remove('is-sub-open'); $('.kv-subtoggle', o).setAttribute('aria-expanded', 'false'); } });
				li.classList.toggle('is-sub-open', open);
				b.setAttribute('aria-expanded', open);
			});
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

	/* ---------- Сторис с фото работ ---------- */
	var sd = d.getElementById('kv-stories');
	if (sd) {
		var sImg = $('[data-st-img]', sd), sBg = $('[data-st-bg]', sd), sBars = $('[data-st-bars]', sd);
		var sList = [], sI = 0, sT = null, SD = 4500;
		function sShow(i) {
			if (i >= sList.length) { sd.close(); return; }
			sI = Math.max(0, i);
			sImg.src = sList[sI];
			sBg.style.backgroundImage = 'url("' + sList[sI] + '")';
			$$('i', sBars).forEach(function (b, k) {
				b.className = k < sI ? 'is-done' : (k === sI ? 'is-run' : '');
			});
			clearTimeout(sT); sT = setTimeout(function () { sShow(sI + 1); }, SD);
			if (sList[sI + 1]) { var pre = new Image(); pre.src = sList[sI + 1]; }
		}
		d.addEventListener('click', function (e) {
			var b = e.target.closest('[data-stories]');
			if (!b) return;
			sList = JSON.parse(b.getAttribute('data-stories'));
			sImg.alt = 'Коврики для ' + b.getAttribute('data-brand');
			$('[data-st-brand]', sd).textContent = b.getAttribute('data-brand');
			sBars.innerHTML = sList.map(function () { return '<span><i></i></span>'; }).join('');
			sBars.style.setProperty('--dur', SD + 'ms');
			sd.showModal(); sShow(0);
			goal('gallery_brand', { brand: b.getAttribute('data-brand') });
		});
		sd.addEventListener('click', function (e) {
			var n = e.target.closest('[data-st]');
			if (n) sShow(sI + +n.getAttribute('data-st'));
		});
		sd.addEventListener('keydown', function (e) {
			if (e.key === 'ArrowRight') sShow(sI + 1);
			if (e.key === 'ArrowLeft') sShow(sI - 1);
		});
		sd.addEventListener('close', function () { clearTimeout(sT); sImg.removeAttribute('src'); });
		var tx = 0;
		sd.addEventListener('touchstart', function (e) { tx = e.touches[0].clientX; clearTimeout(sT); }, { passive: true });
		sd.addEventListener('touchend', function (e) {
			var dx = e.changedTouches[0].clientX - tx;
			if (Math.abs(dx) > 40) sShow(sI + (dx < 0 ? 1 : -1));
			else if (!e.target.closest('button')) sShow(sI + (e.changedTouches[0].clientX > innerWidth / 2 ? 1 : -1));
		});
	}

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
			var fr = $('.kv-lightbox__video', lb); if (fr) fr.remove();
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
		lb.addEventListener('close', function () { var fr = $('.kv-lightbox__video', lb); if (fr) fr.remove(); lbImg.removeAttribute('src'); });
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
		var src = v.getAttribute('data-video').trim(), fr, m;
		if (/\.(mp4|webm|mov)(\?|$)/i.test(src)) {
			fr = d.createElement('video');
			fr.src = src; fr.controls = true; fr.autoplay = true; fr.playsInline = true;
		} else {
			fr = d.createElement('iframe');
			if ((m = src.match(/(?:youtu\.be\/|shorts\/|[?&]v=|embed\/)([\w-]{11})/))) src = 'https://www.youtube.com/embed/' + m[1] + '?autoplay=1&playsinline=1';
			else if ((m = src.match(/^(?:https?:\/\/)?(?:player\.)?vimeo\.com\/(?:video\/)?(\d+)/) || src.match(/^(\d+)$/))) src = 'https://player.vimeo.com/video/' + m[1] + '?autoplay=1';
			fr.src = src;
			fr.allow = 'autoplay; fullscreen; picture-in-picture';
			fr.allowFullscreen = true;
		}
		fr.className = 'kv-lightbox__video' + (v.getAttribute('data-ratio') === 'vertical' ? '' : ' kv-lightbox__video--wide');
		lbImg.hidden = true;
		$$('.kv-lightbox__nav', lb).forEach(function (b) { b.hidden = true; });
		lb.appendChild(fr);
		lb.showModal();
		goal('video');
	});

	/* ---------- FAQ: открыт только один вопрос (фолбэк для старых браузеров) ---------- */
	$$('.kv-faq__item').forEach(function (dt) {
		dt.addEventListener('toggle', function () {
			if (!dt.open) return;
			$$('.kv-faq__item').forEach(function (o) { if (o !== dt && o.open) o.open = false; });
		});
	});

	/* ---------- Конструктор коврика ---------- */
	$$('[data-kvc-root]').forEach(function (root) {
		var svg = $('.kvc__svg', root), cta = $('[data-kvc-cta]', root);
		var st = { set: 'Полный комплект', tex: 'Соты', mat: 'Черный', kant: 'Красный', heel: 'Полимерный (+15 р.)' };
		svg.setAttribute('data-tex', 'honey'); svg.setAttribute('data-heel', 'poly');
		function sync() {
			var sb = $('[data-kvc=set].is-on', root), hb = $('[data-kvc=heel].is-on', root);
			var tot = (sb ? +sb.getAttribute('data-price') : 0) + (hb ? +hb.getAttribute('data-price') : 0);
			var tEl = $('[data-kvc-total]', root); if (tEl) tEl.textContent = tot;
			var gEl = $('[data-kvc-gift]', root); if (gEl) gEl.hidden = !(sb && sb.getAttribute('data-gift') === '1');
			cta.setAttribute('data-product', st.set + ' ЭВА: ' + st.tex + ', материал ' + st.mat.toLowerCase() + ', кант ' + st.kant.toLowerCase() + ', ' + st.heel.replace(/ \(.*\)/, '').toLowerCase() + (st.heel.indexOf('Без') === 0 ? '' : ' подпятник'));
		}
		root.addEventListener('click', function (e) {
			var b = e.target.closest('[data-kvc]');
			if (!b) return;
			var t = b.getAttribute('data-kvc');
			$$('[data-kvc="' + t + '"]', root).forEach(function (x) { x.classList.toggle('is-on', x === b); x.setAttribute('aria-pressed', x === b); });
			st[t] = b.getAttribute('data-name');
			if (t === 'mat' || t === 'kant') {
				svg.style.setProperty('--' + t, b.getAttribute('data-hex'));
				var o = $('[data-kvc-out="' + t + '"]', root); if (o) o.textContent = st[t];
			} else if (t !== 'set') {
				svg.setAttribute('data-' + t, b.getAttribute('data-val'));
			}
			sync();
			goal('constructor');
		});
		sync();
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
