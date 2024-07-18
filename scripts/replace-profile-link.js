/**
 * Event listener for DOMContentLoaded to change the avatar link URL.
 *
 * This script listens for the DOMContentLoaded event to ensure the DOM is fully loaded before execution.
 * It then selects the avatar link element within the Ultimate Member header and updates its href attribute 
 * to point to the specified URL ('https://careservice.ca/account'). 
 * This effectively changes the destination of the avatar link.
 */
document.addEventListener("DOMContentLoaded", function () {
    var avatarLink = document.querySelector('.um-header-avatar a');
    if (avatarLink) {
        avatarLink.setAttribute('href', 'https://careservice.ca/account');
    }
});
