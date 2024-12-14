// Load the contacts table when the page loads
window.addEventListener('load', () => {
    filterContacts('all');
});

function filterContacts(filterType) {
    fetch(`getContacts.php?filter=${filterType}`)
    .then(response => response.text())
    .then(html => {
        document.getElementById('contactsTable').innerHTML = html;
    })
    .catch(error => {
        console.error('Error fetching filtered contacts:', error);
    });
}