document.addEventListener("DOMContentLoaded", function () {
	var showPasswordCheckbox = document.getElementById("showPasswordCheckbox");
	var passwordInput = document.getElementById("password");

	showPasswordCheckbox.addEventListener("change", function () {
		if (showPasswordCheckbox.checked) {
			passwordInput.type = "text";
		} else {
			passwordInput.type = "password";
		}
	});
});
