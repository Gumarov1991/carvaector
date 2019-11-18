<script>
	const popupId = "#snackbar-popup-term-agree";

	function popupToggle_term(isVisible) {
		const $popup = $(popupId);
		const classShow = "show";
		if (isVisible) {
			$popup.addClass(classShow);
		} else {
			$popup.removeClass(classShow);
		}
	}

	function popupClose_term() {
		popupToggle_term(false);
	}
</script>
<div id="snackbar-popup-term-agree" class="snackbar-container --bottom">
    <div class="container">
        <div class="snackbar-window">
            <p>{$content_274}</p>
            <div class="btn" onclick="popupClose_term()">OK</div>
        </div>
    </div>
</div>