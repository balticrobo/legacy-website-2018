import '../../node_modules/startbootstrap-sb-admin/js/sb-admin';
import '../../node_modules/trumbowyg/dist/trumbowyg';

$('.wysiwyg').trumbowyg({
  svgPath: '/wysiwyg_icons.svg',
  btns: [
    ['viewHTML'],
    ['strong', 'em'],
    ['link'],
    ['justifyLeft', 'justifyCenter', 'justifyRight'],
    ['unorderedList', 'orderedList'],
  ],
  autogrow: true,
});
