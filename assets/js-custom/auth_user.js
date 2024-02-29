function previewImage(event, imageContainerId) {
	const imageInput = event.target;
	const imageContainer = document.getElementById(imageContainerId);

	if (imageInput.files && imageInput.files[0]) {
		const reader = new FileReader();

		reader.onload = function (e) {
			imageContainer.innerHTML = `<img src="${e.target.result}" alt="Preview Image" class="img-thumbnail" style="width: 100px; height: auto;">`;
		};

		reader.readAsDataURL(imageInput.files[0]);
	} else {
		imageContainer.innerHTML = "";
	}
}

document.addEventListener("DOMContentLoaded", function () {
	var showPasswordCheckbox = document.getElementById("showPasswordCheckbox");
	var passwordInput = document.getElementById("password");
	var passwordInput1 = document.getElementById("password1");

	showPasswordCheckbox.addEventListener("change", function () {
		if (showPasswordCheckbox.checked) {
			passwordInput.type = "text";
			passwordInput1.type = "text";
		} else {
			passwordInput.type = "password";
			passwordInput1.type = "password";
		}
	});
});

