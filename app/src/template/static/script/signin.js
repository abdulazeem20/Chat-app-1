function login (file, type, e) {
  $('#signin').attr('disabled', true)
  info =
    "<span class='spinner-border text-info spinner-border-sm' ></span> Loading..."
  $('#signin').html(info)
  e.preventDefault()
  data = new FormData(file)
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
        $('#signin').attr('disabled', false)
        $('#signin').text('Sign-in')
        $('#response').html(output)
        window.location = 'home.php'
      } else if (response.status == 'error') {
        let output =
          ' <div class="alert alert-dismissible alert-danger fade show">   <p><strong>' +
          response.output +
          ' !!!!</strong></p><button class="btn-close" data-bs-dismiss="alert"></button></div>'
        $('#response').html(output)
        $('#signin').attr('disabled', false)
        $('#signin').text('Sigin-in')
      }
    }
  })
}
