/**
 * Handlebars block helper that print event details in proper locale
 * @param {string} locale - 2 letter locale code (pl or en)
 * @returns {string} Event name
 */
module.exports = function(locale) {
  if (locale === 'pl') {
    return '26 - 27 maja 2018r.<br/>GPNT, Trzy Lipy 3<br/>Gdańsk';
  } else if (locale === 'en') {
    return 'May 26-27, 2018<br/>GPNT, Trzy Lipy 3<br/>Gdansk, POLAND';
  }

  return '';
};
