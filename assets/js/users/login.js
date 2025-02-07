const form = document.querySelector(".login-form");

const loginMethodField = document.querySelector(".login-method");
const labelUsernameEmail = document.querySelector(
	".login-username-email-label"
);
const fieldUsernameEmail = document.querySelector(
	".login-username-email-field"
);
const fieldPassword = document.querySelector(".login-password-field");
const btnChangeMethod = document.querySelector(".btn-change-method");

const btnTextEmail = "Use Email Instead";
const btnTextUsername = "Use Username Instead";

function swapLoginMethod(currentMethod) {
	if (currentMethod === "username") {
		labelUsernameEmail.setAttribute("for", "email");
		labelUsernameEmail.innerText = "Email:";
		fieldUsernameEmail.setAttribute("name", "email");
		fieldUsernameEmail.setAttribute("placeholder", "Email");
		loginMethodField.value = "email";
		btnChangeMethod.innerText = btnTextUsername;
		return;
	}

	if (currentMethod === "email") {
		labelUsernameEmail.setAttribute("for", "username");
		labelUsernameEmail.innerText = "Username:";
		fieldUsernameEmail.setAttribute("name", "username");
		fieldUsernameEmail.setAttribute("placeholder", "Username");
		loginMethodField.value = "username";
		btnChangeMethod.innerText = btnTextEmail;
	}
}

btnChangeMethod.addEventListener("click", () => {
	const loginMethod = loginMethodField.value;
	swapLoginMethod(loginMethod);
});

form.addEventListener("submit", (e) => {
	e.preventDefault();
	// Do necessary client-side validation before making a request to login
	// Example:
	fieldUsernameEmail.value = fieldUsernameEmail.value.trim();
	fieldPassword.value = fieldPassword.value.trim();

	if (fieldUsernameEmail.value === "" || fieldPassword.value === "") {
		alert("Both fields are required!");
		return;
	}

	form.submit();
});
