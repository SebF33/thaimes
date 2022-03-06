/*
 * Mercure hub
 */

// Extract the hub URL from the Link header
const url = new URL('http://127.0.0.1:3000/.well-known/mercure');

// Définir les topic à écouter : utilisation du template messages/{id} pour écouter plusieurs sujets
url.searchParams.append('topic', '/messages/{id}');
url.searchParams.append('topic', '/ping/{id}');

// listen to the HUB.
//MODE authorization, cookie or header
const eventSource = new EventSource(url, {
  withCredentials: true
});
//MODE anonymous
//const eventSource = new EventSource(url);
eventSource.addEventListener('ping', (event) => {
  if (event.type === 'ping')
    document.querySelector('h1').insertAdjacentHTML('afterend', `<div class="alert alert-success">Ping !</div> `);
}, false);

eventSource.onmessage = (event) => {
  console.dir(event);

  if (event.type === 'message') {
    const data = JSON.parse(event.data);
    document.querySelector('h1').insertAdjacentHTML('afterend', `<div class="alert alert-success">Nouveau message de ${data.from}</div> `);
  }

  window.setTimeout(() => {
    const alert = document.querySelector('.alert');
    alert.parentNode.removeChild(alert);
  }, 2000)
}