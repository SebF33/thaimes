// Pop-up confirmation de participation
$('#comment_form_submit').on('click', function (e) {
  e.preventDefault();
  var form = $('#comment_form');
  if (form.get(0).reportValidity()) {
    Swal.fire({
      title: "Transmettre votre participation ?",
      type: "warning",
      showCancelButton: true,
      confirmButtonColor: "#0a8558",
      confirmButtonText: "Oui, allons-y !",
    }).then(function (result) {
      if (result.value === true) {
        sessionStorage.setItem('submitted', '1');
        form.submit();
      }
    })
  }
})

// Pop-up participation envoyée
window.onload = function () {
  if (sessionStorage.getItem('submitted') == '1') {
    const Toast = Swal.mixin({
      toast: true,
      position: 'top',
      showConfirmButton: false,
      timer: 2800,
      timerProgressBar: true,
      didOpen: (toast) => {
        toast.addEventListener('mouseenter', Swal.stopTimer)
        toast.addEventListener('mouseleave', Swal.resumeTimer)
      }
    });
    Toast.fire({
      icon: 'success',
      title: 'Votre participation a été transmise !'
    });
    sessionStorage.clear();
  }
};