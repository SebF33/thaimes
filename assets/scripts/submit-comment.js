// Pop-up confirmation de participation
$('#comment_form_submit').on('click', function (e) {
  e.preventDefault();
  var form = $('#comment_form');
  if (form.get(0).reportValidity()) {
    Swal.fire({
      title: "Transmettre votre participation ?",
      icon: "question",
      type: "warning",
      showCancelButton: true,
      cancelButtonColor: "#bd150b",
      cancelButtonText: "Non, pas encore",
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

window.onload = function () {
  var formError = document.getElementById('form-error-message');

  // Pop-up participation envoyée
  if (sessionStorage.getItem('submitted') == '1' && formError === null) {
    const Toast = Swal.mixin({
      toast: true,
      position: 'top',
      showConfirmButton: false,
      timer: 3000,
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

  // Pop-up erreur
  else
  if (sessionStorage.getItem('submitted') == '1' && typeof (formError) != 'undefined' && formError != null) {
    const Toast = Swal.mixin({
      toast: true,
      position: 'top',
      showConfirmButton: false,
      timer: 3000,
      timerProgressBar: true,
      didOpen: (toast) => {
        toast.addEventListener('mouseenter', Swal.stopTimer)
        toast.addEventListener('mouseleave', Swal.resumeTimer)
      }
    });
    Toast.fire({
      icon: 'error',
      title: "Votre participation n'a pas été transmise..."
    });
    sessionStorage.clear();
  }
};