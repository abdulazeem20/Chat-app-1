messaging = document.querySelector('#messaging')

let incomingId = $('#incomingId').val()
let outgoingId = $('#outgoingId').val()
let convId = $('#convId').val()

function getChat () {
  scrollToBottom()
  data = {
    senderId: outgoingId,
    receiverId: incomingId,
    type: 'getMessage'
  }
  $.ajax({
    method: 'POST',
    url: './api.php',
    data: data,
    dataType: 'JSON',
    success: function (response) {
      let output = ''
      if (response != '') {
        $.each(response, function (i, value) {
          if (value.sender_id == data.senderId) {
            output += outgoingMsg(value)
          } else {
            output += incomingMsg(value)
            saveSeen(convId, data.senderId)
          }
        })
      } else {
        output =
          '<h5 class="text-muted text-center" style="margin-top: auto;" >Message will show as soon as you start chatting</h5>'
      }
      $('#messaging').html(output)
    }
  })
}

function saveSeen (id, sessionId) {
  let data = {
    ussid: sessionId,
    convId: id,
    type: 'saveSeen'
  }
  $.ajax({
    method: 'POST',
    url: 'api.php',
    data: data,
    dataType: 'JSON',
    sucess: function (response) {
      console.log(response)
    }
  })
}

function sendChat (file, e) {
  e.preventDefault()
  let data = new FormData(file)
  if (data.get('textArea') !== '') {
    console.log(incomingId)
    console.log(outgoingId)
    data.append('type', 'saveMessage')
    data.append('incomingId', incomingId)
    data.append('outgoingId', outgoingId)
    $('#textArea').val('')
    scrollToBottom()
    $.ajax({
      method: 'POST',
      url: 'api.php',
      data: data,
      dataType: 'JSON',
      contentType: false,
      processData: false,
      cache: false,
      success: function (response) {
        getChat()
      }
    })
  }
}

function scrollToBottom () {
  messaging.scrollTop = messaging.scrollHeight
}

setInterval(() => {
  getChat()
}, 500)

function outgoingMsg (user) {
  return (
    '<div class="outgoing"><img src="src/template/static/images/' +
    user.sender_image +
    ' "class="" alt=""><div class="details"><p>' +
    user.message +
    '</p></div></div>'
  )
}

function incomingMsg (user) {
  return (
    '<div class="incoming"><img src="src/template/static/images/' +
    user.sender_image +
    '" class="" alt=""><div class="details"><p>' +
    user.message +
    '</p></div></div>'
  )
}
