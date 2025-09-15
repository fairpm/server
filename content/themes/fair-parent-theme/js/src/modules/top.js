/* eslint-disable max-len */

const backToTop = () => {
  // Back to top button
  const topButton = document.getElementById('top');
  const focusableElements = document.querySelectorAll(
    'button, a, input, select, textarea, [tabindex]:not([tabindex="-1"])',
  );

  function trackScroll() {
    const scrolled = window.pageYOffset;
    const scrollAmount = document.documentElement.clientHeight;

    if (scrolled > scrollAmount) {
      topButton.classList.add('is-visible');
    }

    if (scrolled < scrollAmount) {
      topButton.classList.remove('is-visible');
    }
  }

  function scroll(focusVisible) {
    // Check if user prefers reduced motion, if so, just scroll to top
    focusableElements[0].focus({ focusVisible });
    return;
  }

  if (topButton) {
    topButton.addEventListener('click', (event) => {
      // Don't add hash in the end of the url
      event.preventDefault();

      // Focus without visibility (as user is not using keyboard)
      scroll(false);
    });

    topButton.addEventListener('keydown', (event) => {
      // Don't propagate keydown event to click event
      event.preventDefault();

      // Scroll with focus visible
      scroll(true);
    });
  }

  window.addEventListener('scroll', trackScroll);
};

export default backToTop;
