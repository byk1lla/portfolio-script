const upload = document.getElementById("uploadimg"),
image = document.getElementById('image');

upload.addEventListener('change',function() {

    [... this.files].map(file => {
        const reader = new FileReader();
            reader.addEventListener('load',function() {
                image.src = this.result;
            }) 
            reader.readAsDataURL(file);
    })
});

document.addEventListener("DOMContentLoaded", function () {

    document.querySelector("form").addEventListener("submit", function (event) {
      event.preventDefault(); 

      const formData = new FormData(this);
      const xhr = new XMLHttpRequest();
      xhr.open("POST", "api/edit");
      xhr.onload = function () {
        if (xhr.status === 200) {
            const response = JSON.parse(xhr.responseText);
          if (response.status === "success") {
            success("Success!","Portfolio updated successfully!");
          } else {

            error("Error",response.message);
          }
        } else {
          error("Error",xhr.statusText);
        }
      };
      xhr.onerror = function () {
        error("Error","XHR request failed.");
      };
      xhr.send(formData);
    });
  });
  