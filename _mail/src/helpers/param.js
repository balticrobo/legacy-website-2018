/**
 * Handlebars block helper that print event name in proper locale
 * @param {string} param - param name
 * @returns {string} param in braces
 */
module.exports = function(param) {
  return '{{ ' + param + ' }}';
};
