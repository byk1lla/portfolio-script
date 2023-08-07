document.getElementById("signup-form").addEventListener("submit", function (event) {
  event.preventDefault();

  const username = document.getElementById("username").value;
  const email = document.getElementById("email").value;
  const password = document.getElementById("password").value;
  const password2 = document.getElementById("password2").value;

  const xhr = new XMLHttpRequest();

  const url = "api/register";

  
  if (password != password2) {
    error("Error", "Passwords Not Match");
  } else {
    if(username == password){
      error("Error","Username and Password cant be same!");
    }
    else{
    xhr.open("POST", url, true);

    xhr.onload = function () {
      if (xhr.status === 200) {
        const response = JSON.parse(xhr.responseText);
        if (response.status === "success") {
          success("Success", response.message);
        } else if (response.status === "error") {
          error("Error", response.message);
        }
      } else {
        error("Error", "An error occurred while processing the request.");
      }
    };

    xhr.onerror = function () {
      error("Error", "An error occurred while making the request.");
    };

    const formData = new FormData();
    formData.append("username", username);
    formData.append("email", email);
    formData.append("password", password);
    xhr.send(formData);
  }
}
});

function togglePasswordVisibility() {
  const passwordInput = document.getElementById("password");
  const eyeIcon = document.getElementById("show-password-icon");

  if (passwordInput.type === "password") {
    passwordInput.type = "text";
    eyeIcon.classList.remove("fa-eye");
    eyeIcon.classList.add("fa-eye-slash");
  } else {
    passwordInput.type = "password";
    eyeIcon.classList.remove("fa-eye-slash");
    eyeIcon.classList.add("fa-eye");
  }
}
