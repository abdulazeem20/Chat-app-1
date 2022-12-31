function uploadProfileImage (file) {
  let data = new FormData()
  data.append('img', file[0])
  data.append('type', 'uploadImage')
  $.ajax({
    method: 'POST',
    url: 'api.php',
    data: data,
    dataType: 'JSON',
    contentType: false,
    cache: false,
    processData: false,
    success: function (response) {
      if (response.status == 'success') {
        let output =
          ' <label class="alert alert-dismissible alert-success fade show">   <p><strong>' +
          response.output +
          ' !!!!</strong></p><button class="btn-close" data-bs-dismiss="alert"></button></label>'
        $('#response').html(output)
      } else if (response.status == 'error') {
        let output =
          ' <label class="alert alert-dismissible alert-danger fade show">   <p><strong>' +
          response.output +
          ' !!!!</strong></p><button class="btn-close" data-bs-dismiss="alert"></button></label>'
        $('#response').html(output)
      }
    }
  })
}

$("#editUserProfile").on('submit', function (e) {
  e.preventDefault();
  let data = new FormData(this);
  data.append(document.forms.editUserProfile.editUserProfileButton.name, true)
    $("#editUserProfileButton").attr("disabled", true);
    info =
      "<span class='spinner-border text-info spinner-border-sm' ></span> Loading...";
    $("#editUserProfileButton").html(info);
  $.ajax({
    type: "POST",
    url: "./api.php",
    data: data,
    dataType: "JSON",
    contentType: false,
    cache: false,
    processData: false,
    success: function (response) {
       if (response.status == "success") {
         let output =
           ' <span class="alert alert-dismissible alert-success fade show">   <p><strong>' +
           response.output +
           ' !!!!</strong></p><button class="btn-close" data-bs-dismiss="alert"></button></span>';
         getResponse(output);
       } else if (response.status == "error") {
         let output =
           ' <span class="alert alert-dismissible alert-danger fade show">   <p><strong>' +
           response.output +
           ' !!!!</strong></p><button class="btn-close" data-bs-dismiss="alert"></button></span>';
         getResponse(response.output)
       }
    },
  });
});

function getResponse (output) {
  // $("#response").html(output);
  alert(output)
  $("#editUserProfileButton").attr("disabled", false)
  $("#editUserProfileButton").text("Edit");
}
