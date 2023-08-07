document.getElementById("login-form").addEventListener("submit", function (event) {
  event.preventDefault();

  const username = document.getElementById("username").value;
  const password = document.getElementById("password").value;
  let userAgent = navigator.userAgent;
  let browserName;
  
  if(userAgent.match(/chrome|chromium|crios/i)){
      browserName = "Chrome";
    }else if(userAgent.match(/firefox|fxios/i)){
      browserName = "Firefox";
    }  else if(userAgent.match(/safari/i)){
      browserName = "Safari";
    }else if(userAgent.match(/opr\//i)){
      browserName = "Opera";
    } else if(userAgent.match(/edg/i)){
      browserName = "Edge";
    }else{
      browserName="No browser detection";
    }
  const device = navigator.platform;
  const xhr = new XMLHttpRequest();
  const url = "../api/login";
  
  xhr.open("POST", url, true);
  xhr.onload = function () {
    if (xhr.status === 200) {
      const response = JSON.parse(xhr.responseText);
      if (response.success) {
        location.href = "./dashboard"

      } else {
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
  formData.append("password", password);
  formData.append("browser", browserName);
  formData.append("device", device);
  xhr.send(formData);
});
