export default function getLocalization(stringKey) {
  if (typeof window.fair_parent_screenReaderText === 'undefined' || typeof window.fair_parent_screenReaderText[stringKey] === 'undefined') {
    // eslint-disable-next-line no-console
    console.error(`Missing translation for ${stringKey}`);
    return '';
  }
  return window.fair_parent_screenReaderText[stringKey];
}
