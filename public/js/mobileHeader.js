const toggleBtn = document.querySelector('[data-menu-toggle]');
const mobileMenu = document.querySelector('[data-mobile-menu]');

toggleBtn.addEventListener('click', () => {
    const isOpen = mobileMenu.style.display === 'block';
    mobileMenu.style.display = isOpen ? 'none' : 'block';
    toggleBtn.setAttribute('aria-expanded', !isOpen);
    toggleBtn.querySelector('span').textContent = isOpen ? 'Menu' : 'Luk';
});