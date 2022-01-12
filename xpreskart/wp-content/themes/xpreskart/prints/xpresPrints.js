
  updateList = function () {
    var input = document.getElementById('files');
    var output = document.getElementById('fileList');

    output.innerHTML = '<ul>';
    for (var i = 0; i < input.files.length; ++i) {
    output.innerHTML += '<li>' + input.files.item(i).name + '</li>';
    }
    output.innerHTML += '</ul>';
  }

  // JavaScript for disabling form submissions if there are invalid fields

  'use strict';
  $(function () {

    var $forms;
    var $upload;

    // Fetch all the forms we want to apply custom Bootstrap validation styles to
    var forms = document.querySelectorAll('.needs-validation')

    // Loop over them and prevent submission
    Array.prototype.slice.call(forms)
      .forEach(function (form) {
      form.addEventListener('submit', function (event) {
        if (!form.checkValidity()) {
        event.preventDefault()
        event.stopPropagation()
        }

        form.classList.add('was-validated')
      }, false)
      })
    var upload = new FileUploadWithPreview('mySecondImage')
  });
