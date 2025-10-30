(function () {
	const TOAST_TYPES = ['success', 'error', 'warning', 'info'];

	function ensureToastContainer() {
		let container = document.getElementById('toastContainer');
		if (!container) {
			container = document.createElement('div');
			container.id = 'toastContainer';
			container.className = 'toast-container';
			document.body.appendChild(container);
		}
		return container;
	}

	function getIconForType(type) {
		switch (type) {
			case 'success':
				return '✅';
			case 'error':
				return '❌';
			case 'warning':
				return '⚠️';
			default:
				return 'ℹ️';
		}
	}

	function closeToast(toast) {
		if (!toast) return;
		toast.classList.remove('show');
		setTimeout(function () {
			if (toast.parentNode) {
				toast.parentNode.removeChild(toast);
			}
		}, 300);
	}

	function normalizeArgs(a, b, c) {
		// Suporta dois formatos:
		// 1) (type, title, message)
		// 2) (title, message, type)
		if (typeof a === 'string' && TOAST_TYPES.includes(a)) {
			return { type: a, title: b || '', message: c || '' };
		}
		return { title: a || '', message: b || '', type: c && TOAST_TYPES.includes(c) ? c : 'info' };
	}

	function showToastUniversal(a, b, c) {
		const { type, title, message } = normalizeArgs(a, b, c);
		const container = ensureToastContainer();

		const toast = document.createElement('div');
		toast.className = 'toast ' + type;
		toast.innerHTML =
			'<div class="toast-icon">' + getIconForType(type) + '</div>' +
			'<div class="toast-content">' +
				'<div class="toast-title">' + title + '</div>' +
				'<div class="toast-message">' + message + '</div>' +
			'</div>' +
			'<button class="toast-close" aria-label="Fechar">×</button>';

		const closeBtn = toast.querySelector('.toast-close');
		closeBtn.addEventListener('click', function () { closeToast(toast); });

		container.appendChild(toast);

		setTimeout(function () { toast.classList.add('show'); }, 10);
		setTimeout(function () { closeToast(toast); }, 5000);
	}

	// Expõe globalmente
	window.showToast = showToastUniversal;
})();


