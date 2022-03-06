/**
 * Boîtes de dialogue pour la participation
 */

// Langage (en/fr)
var participation = document.querySelector('#participation-form');
if (typeof (participation) != 'undefined' && participation != null) {
  if (participation.dataset.userLanguage == '"en"') {
    var confTitle = "Submit your participation?";
    var successTitle = "Your participation has been submitted! 😃";
    var errorTitle = "Your participation has not been submitted... 😒";
    var cancelButtonText = "Not yet";
    var confirmButtonText = "Yes let's go !";
  } else
  if (participation.dataset.userLanguage == '"fr"') {
    var confTitle = "Transmettre votre participation ?";
    var successTitle = "Votre participation a été transmise ! 😃";
    var errorTitle = "Votre participation n'a pas été transmise... 😒";
    var cancelButtonText = "Non, pas encore";
    var confirmButtonText = "Oui, allons-y !";
  }
};


// Pop-up confirmation de participation
$('#comment_form_submit').on('click', function (e) {

  e.preventDefault();

  var form = $('#comment_form');

  if (form.get(0).reportValidity()) {
    Swal.fire({
      title: confTitle,
      icon: 'question',
      type: 'warning',
      showCancelButton: true,
      cancelButtonColor: '#ca525e',
      cancelButtonText: cancelButtonText,
      confirmButtonColor: '#0a8558',
      confirmButtonText: confirmButtonText,
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
      timer: 4600,
      timerProgressBar: true,
      didOpen: (toast) => {
        toast.addEventListener('mouseenter', Swal.stopTimer)
        toast.addEventListener('mouseleave', Swal.resumeTimer)
      }
    });
    Toast.fire({
      icon: 'success',
      title: successTitle
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
      timer: 4600,
      timerProgressBar: true,
      didOpen: (toast) => {
        toast.addEventListener('mouseenter', Swal.stopTimer)
        toast.addEventListener('mouseleave', Swal.resumeTimer)
      }
    });
    Toast.fire({
      icon: 'error',
      title: errorTitle
    });
    sessionStorage.clear();
  }
};