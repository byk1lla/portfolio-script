function success(title, message) {
    Swal.fire({
      title: title,
      html: message,
      icon: 'success',
      confirmButtonText: 'Great!',
      customClass: {
        confirmButton: 'ok-button',
    cancelButton: 'error-button'
      }      
    });
  }
  
   function error(title, message) {
    Swal.fire({
      title: title,
      html: message,
      icon: 'error',
      confirmButtonText: 'Okay',
      customClass: {
        confirmButton: 'ok-button',
    regretButton: 'error-button'
      } 
    });
  }
function wait(title,message){
  let timerInterval
  Swal.fire({
    title: title,
    html: message + "<br><b></b> Left!",
    timer: 10000,
    timerProgressBar: true,
    didOpen: () => {
      Swal.showLoading()
      const b = Swal.getHtmlContainer().querySelector('b')
      timerInterval = setInterval(() => {
        const timeLeft = Swal.getTimerLeft() / 1000; 
        const minutes = Math.floor((timeLeft % 3600) / 60); 
        const seconds = Math.floor(timeLeft % 60);   
        b.textContent = `${minutes}m ${seconds}s`; 
      }, 1000)
    },
    willClose: () => {
      clearInterval(timerInterval)
    }
  }).then((result) => {
    if (result.dismiss === Swal.DismissReason.timer) {
      success("Success!", "Your First Portfolio Page Created Has Been Successfully!");
    }
  })
  
}
