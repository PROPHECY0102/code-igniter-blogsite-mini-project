console.log("script.js loaded in " + window.location.href);

const notificationPopup = document.querySelector(".notification-container");

function hideNotification(ms) {
	setTimeout(() => {
		notificationPopup.setAttribute("data-hide", "");
	}, ms);
}

function dismissPopup() {
	document.addEventListener("click", (e) => {
		if (!notificationPopup.contains(e.target)) {
			notificationPopup.setAttribute("data-hide", "");
		}
	});
}

if (notificationPopup) {
	hideNotification(5000);
	dismissPopup();
}
