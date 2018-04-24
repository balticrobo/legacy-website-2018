/**
 * Handlebars block helper that print event name in proper locale
 * @param {string} locale - 2 letter locale code (pl or en)
 * @returns {string} Event name
 */
module.exports = function(locale) {
  if (locale === 'pl') {
    return 'Bałtyckie Bitwy Robotów';
  } else if (locale === 'en') {
    return 'Baltic Robo Battles';
  }

  return '';
};
