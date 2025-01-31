// Function to set a session-based cookie
function setSessionCookie(name, value) {
    document.cookie = `${name}=${value}; path=/; SameSite=Lax`;
}

// Function to get a cookie value by name
function getCookie(name) {
    const cookieString = document.cookie;
    const cookies = cookieString.split('; ');
    for (const cookie of cookies) {
        const [cookieName, cookieValue] = cookie.split('=');
        if (cookieName === name) {
            return cookieValue;
        }
    }
    return null;
}

// Function to hide the cookie banner
function hideCookieBanner() {
    const banner = document.getElementById('cookieBanner');
    banner.style.display = 'none';
}

// Function to handle user consent
function handleConsent() {
    const acceptButton = document.getElementById('acceptCookie');
    const declineButton = document.getElementById('declineCookie');

    if (!getCookie('DigES')) {
        const banner = document.getElementById('cookieBanner');
        banner.style.display = 'block'; // Show the banner
    }

    acceptButton.addEventListener('click', () => {
        setSessionCookie('DigES', 'true');
        hideCookieBanner();
        console.log('Consent granted. Session cookie set.');
    });

    declineButton.addEventListener('click', () => {
        hideCookieBanner();
        console.log('Consent not granted.');
    });
}

// Check consent when the page loads
document.addEventListener('DOMContentLoaded', handleConsent);