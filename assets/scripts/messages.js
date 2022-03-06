/**
 * Gestion envoi de messages en temps réel avec Mercure
 */

// Défilement automatique en bas
function autoBottomScroll() {
  const objDiv = document.querySelector(".conversation");
  objDiv.scrollIntoView({
    block: "end",
    inline: "nearest"
  });
}

document.getElementById('bottom').scrollIntoView();
document.addEventListener('DOMContentLoaded', function () {

  let messageBox = document.querySelector('#message-box');
  let pathUri = window.location.pathname;

  messageBox.addEventListener('keyup', (event) => {
    if (event.keyCode === 13) {
      sendMessage(event.target.value);
      messageBox.value = "";
    }
  })

  document.getElementById("button-send").addEventListener("click", (event) => {
    sendMessage(messageBox.value);
    messageBox.value = "";
  })

  //console.log('URI = ' + pathUri);
  fetch(pathUri).then(result => {

    // Extract the hub URL from the Link header
    const hubUrl = new URL('http://127.0.0.1:3000/.well-known/mercure');
    //console.log("hubUrl = " + hubUrl);
    const url = new URL(hubUrl);

    // Append the topic(s) to subscribe as query parameter
    url.searchParams.append('topic', pathUri);
    //console.log('fetch = ' + pathUri);

    // Subscribe to updates
    const eventSource = new EventSource(url, {
      withCredentials: true //send cookies by browser
    });

    //console.debug(eventSource);

    if (typeof (eventSource !== undefined)) {
      eventSource.onmessage = (event) => {
        //console.dir(event);

        if (event.data !== null) {
          const data = JSON.parse(event.data);
          const newMessageHTML =
            '<div class="chat--message">' +
            '    <div class="d-flex flex-row">' +
            '        <div class="content bg-secondary p-1"><p class="text-white mb-0">' + data.message + '</p></div>' +
            '    </div>' +
            '    <div class="message--info--left">' +
            '        <div class="message--date">' + data.date + '</div>' +
            '    </div>' +
            '</div>';

          document.querySelector('.conversation').insertAdjacentHTML('beforeend', '<div class="row">' + newMessageHTML + '</div>');
          autoBottomScroll();
        }
      }
    }
  });

});

function sendMessage(data) {

  if (data === "")
    return;

  let formData = new FormData();
  //set URI path to add a message ex: /messages/1/add
  const pathUri = window.location.pathname + '/add'
  //get textarea value to save
  formData.append('message-box', data);
  console.log('ADD MESSAGE URI : ' + pathUri);

  fetch(pathUri, {
    method: 'POST',
    body: formData
  }).then(result => {
    // update chat-message
    let newMessageHTML =
      '<div class="chat--message">' +
      '<div class="d-flex flex-row-reverse">' +
      '   <div class="content bg-info p-1 mb-3">' +
      '       <p class="text-white mb-0">' + data + '</p>' +
      '   </div>' +
      '</div>' +
      '</div>';
    document.querySelector('.conversation').insertAdjacentHTML('beforeend', '<div class="row">' + newMessageHTML + '</div>');
    autoBottomScroll();
  });
}