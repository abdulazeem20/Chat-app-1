let id = $('#sessionId').val()

function searchFriend (id, location, target) {
  let search = $('#' + id).val()
  $('#' + target).hide()
  $('#inner').hide()
  data = {
    search: search,
    type: 'search'
  }

  if (search == '') {
    $('#' + target).show()
    $('#inner').show()
    $('#' + location).hide()
    $('#searchResultU').hide()
  } else if (search !== '') {
    $.ajax({
      type: 'POST',
      url: 'api.php',
      data: data,
      dataType: 'JSON',
      success: function (response) {
        if (response != '') {
          $('#' + location).show()
          $('#searchResultU').show()
          let output = ''
          $.each(response, function (i, value) {
            output += getChat(value)
          })
          $('#' + location).html(output)
          $('#searchResultU').html(output)
        } else {
          output = '<h5 class="text-muted">No Result Found</h5>'
          $('#' + location).show()
          $('#searchResultU').show()
          $('#' + location).html(output)
          $('#searchResultU').html(output)
        }
      }
    })
  }
}

function get () {
  output =
    '<div class="spinner-border spinner-border-sm text-success"></div> Loading'
  $('#homeChat').html(output)

  data = {
    id: id,
    type: 'getChat'
  }
  $.ajax({
    type: 'POST',
    url: 'api.php',
    data: data,
    dataType: 'JSON',
    success: function (response) {
      if (response != '') {
        let output = ''
        $.each(response, function (i, value) {
          let item = {
            ussid: id,
            convId: value.conv_id,
            type: 'getUnreadMessage'
          }
          $.ajax({
            method: 'POST',
            url: 'api.php',
            data: item,
            dataType: 'JSON',
            success: function (unread) {
              if (value.sender_id == id) {
                if (unread != 0) {
                  output +=
                    ' <a href="chat.php?ussid=' +
                    value.receiver_id +
                    '&username=' +
                    value.receiver_username +
                    '"class="nav-link"><label class="p-0" style="cursor: pointer;"><img src="src/template/static/images/' +
                    value.receiver_image +
                    '" class="rounded-circle" alt="">          <label class="view text-dark" style="cursor: pointer;">            ' +
                    value.receiver_username +
                    '  <span class="badge bg-info rounded-circle">' +
                    value +
                    '</span></label></label><hr class="dropdown-divider"></a>'

                  saveReceived(id)
                } else {
                  output +=
                    ' <a href="chat.php?ussid=' +
                    value.receiver_id +
                    '&username=' +
                    value.receiver_username +
                    '"class="nav-link"><label class="p-0" style="cursor: pointer;"><img src="src/template/static/images/' +
                    value.receiver_image +
                    '" class="rounded-circle" alt="">          <label class="view text-dark" style="cursor: pointer;">            ' +
                    value.receiver_username +
                    '</label></label><hr class="dropdown-divider"></a>'
                  saveReceived(id)
                }
              } else {
                if (unread != 0) {
                  output +=
                    ' <a href="chat.php?ussid=' +
                    value.sender_id +
                    '&username=' +
                    value.sender_username +
                    '"class="nav-link"><label class="p-0" style="cursor: pointer;"><img src="src/template/static/images/' +
                    value.sender_image +
                    '" class="rounded-circle" alt="">          <label class="view text-dark" style="cursor: pointer;">            ' +
                    value.sender_username +
                    '  <span class="badge bg-info rounded-circle" >' +
                    unread +
                    '</span></label></label><hr class="dropdown-divider"></a>'
                  saveReceived(id)
                } else {
                  output +=
                    ' <a href="chat.php?ussid=' +
                    value.sender_id +
                    '&username=' +
                    value.sender_username +
                    '"class="nav-link"><label class="p-0" style="cursor: pointer;"><img src="src/template/static/images/' +
                    value.sender_image +
                    '" class="rounded-circle" alt="">          <label class="view text-dark" style="cursor: pointer;">            ' +
                    value.sender_username +
                    '</label></label><hr class="dropdown-divider"></a>';
                  saveReceived(id)
                }
              }

              $('#homeChat').html(output)
            }
          })
        })
      } else {
        output = '<h5 class="text-muted">No Conversations</h5>'
        $('#homeChat').html(output)
      }
    }
  })
}

function saveReceived (sessionId) {
  let data = {
    ussid: sessionId,
    type: 'saveReceived'
  }
  $.ajax({
    method: 'POST',
    url: './api.php',
    data: data,
    dataType: 'JSON',
    success: function (response) {
      // console.log(response)
    }
  })
}

function getUnreadMessage (convId, sessionId) {}

function getChat (user) {
  return (
    `<a href="chat.php?ussid=${user.ussid}&username=${user.username}" class="nav-link"><label class="p-0" style="cursor: pointer;"><img src="src/template/static/images/${user.image}" style="width: 30px;" class="rounded-circle" alt=""><label class="view text-dark" style="cursor: pointer; margin-left: 5px;">${user.username}</label></label><hr class="dropdown-divider"></a>`
  )
}
