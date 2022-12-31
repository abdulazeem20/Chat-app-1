$(document).ready(function () {})

function saveData (form, type, e) {
  $('#siginup').attr('disabled', true)
  info =
    "<span class='spinner-border text-info spinner-border-sm' ></span> Loading..."
  $('#siginup').html(info)
  e.preventDefault()
  data = new FormData(form)
  data.append('type', type)
  $.ajax({
    type: 'POST',
    url: 'api.php',
    data: data,
    dataType: 'JSON',
    contentType: false,
    cache: false,
    processData: false,
    success: function (response) {
      if (response.status == 'success') {
        let output =
          ' <div class="alert alert-dismissible alert-success fade show">   <p><strong>' +
          response.output +
          ' !!!!</strong></p><button class="btn-close" data-bs-dismiss="alert"></button></div>'
        $('#siginup').attr('disabled', false)
        $('#siginup').text('Sigin-up')
        $('#response').html(output)
        window.location = 'signin.php'
      } else if (response.status == 'error') {
        let output =
          ' <div class="alert alert-dismissible alert-danger fade show">   <p><strong>' +
          response.output +
          ' !!!!</strong></p><button class="btn-close" data-bs-dismiss="alert"></button></div>'
        $('#response').html(output)
        $('#siginup').attr('disabled', false)
        $('#siginup').text('Sigin-up')
      }
    }
  })
}

function checkIfExists (id, type) {
  value = $('#' + id).val()
  data = {
    [id]: value,
    type: type
  }
  //   console.log(data)
  $.ajax({
    type: 'POST',
    url: 'api.php',
    data: data,
    dataType: 'JSON',
    success: function (response) {
      if (response == 1) {
        $('#siginup').attr('disabled', true)
        $('#' + id).addClass('is-invalid')
      } else {
        $('#siginup').attr('disabled', false)
        $('#' + id).removeClass('is-invalid')
      }
    }
  })
}
