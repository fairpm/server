/* eslint-disable max-len, no-param-reassign, no-unused-vars */
/**
 * FAIR Parent theme JavaScript.
 */

// Import modules
import { styleExternalLinks, initExternalLinkLabels } from './modules/external-link.js';
import backToTop from './modules/top.js';
import initA11yFocusSearchField from './modules/a11y-focus-search-field.js';
import {
  navSticky, navClick, navDesktop, navMobile,
} from './modules/navigation.js';

// Define Javascript is active by changing the body class
document.body.classList.remove('no-js');
document.body.classList.add('js');

document.addEventListener('DOMContentLoaded', () => {
  backToTop();
  styleExternalLinks();
  initExternalLinkLabels();
  initA11yFocusSearchField();

  // Init navigation
  // If you want to enable click based navigation, comment navDesktop() and uncomment navClick()
  // Remember to enable styles in sass/navigation/navigation.scss
  navDesktop();
  navMobile();
});
