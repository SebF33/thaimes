/**
 * Gestion envoi de messages en temps réel avec Mercure
 */

function autoBottomScroll() {
  const objDiv = document.querySelector(".conversation");
  objDiv.scrollIntoView({
    block: "end",
    inline: "nearest"
  });
}

document.getElementById('bottom').scrollIntoView();

document.addEventListener('DOMContentLoaded', function () {

  const messageBox = document.querySelector('#message-box');
  const pathUri = window.location.pathname;

  // Extraire l'id
  const pathParts = pathUri.split('/').filter(Boolean);
  const conversationId = pathParts[pathParts.length - 1];
  const topic = '/messages/' + conversationId;

  //console.log('🔍 topic souscrit:', topic);

  // Forcer l'enregistrement du cookie avant l'EventSource
  fetch(pathUri, {
    credentials: 'include'
  }).then(() => {

    const hubUrl = new URL('http://127.0.0.1:3000/.well-known/mercure');
    hubUrl.searchParams.append('topic', topic);

    //console.log('🔍 Hub URL:', hubUrl.toString());

    const eventSource = new EventSource(hubUrl, {
      withCredentials: true
    });

    eventSource.onopen = () => {
      //console.log('✅ EventSource connecté:', hubUrl.toString());
    };

    eventSource.addEventListener('message', (event) => {
      //console.log('📨 Message reçu:', event.data);
      if (!event.data) return;

      const data = JSON.parse(event.data);
      const isMe = (data.from === currentUsername);

      // supprime le message "vide" s'il existe
      const chatEmpty = document.querySelector('.chat-empty');
      if (chatEmpty) chatEmpty.remove();

      const wrapper = document.createElement('div');
      wrapper.className = 'chat--message ' + (isMe ? 'mine' : 'theirs') + ' chat--message--new';

      wrapper.innerHTML =
        '<div class="bubble">' +
        '<span class="sender">' + data.from + '</span>' +
        data.message +
        '</div>' +
        '<div class="message--date">' + data.date + '</div>';

      document.querySelector('.conversation').appendChild(wrapper);

      wrapper.addEventListener('animationend', () => {
        wrapper.classList.remove('chat--message--new');
      }, {
        once: true
      });

      autoBottomScroll();
    });

    eventSource.onerror = () => {
      console.error('❌ EventSource erreur, readyState:', eventSource.readyState);
    };

  }).catch(error => {
    console.error('❌ Erreur fetch initialisation cookie:', error);
  });

  // envoi via touche Entrée (sans Shift pour permettre le retour à la ligne)
  messageBox.addEventListener('keydown', (event) => {
    if (event.key === 'Enter' && !event.shiftKey) {
      event.preventDefault();
      sendMessage(messageBox.value);
      messageBox.value = "";
    }
  });

  // envoi via bouton
  document.getElementById("button-send").addEventListener("click", () => {
    sendMessage(messageBox.value);
    messageBox.value = "";
  });

});

function sendMessage(data) {
  if (data.trim() === "") return;

  const pathUri = window.location.pathname;
  const formData = new FormData();
  formData.append('message-box', data);

  // l'affichage est géré par l'EventSource pour tout le monde
  fetch(pathUri + '/add', {
    method: 'POST',
    body: formData,
    credentials: 'include'
  }).catch(error => {
    console.error('❌ Erreur envoi message:', error);
  });
}