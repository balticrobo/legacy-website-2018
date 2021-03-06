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
$('#sidenavToggler').click(() => {
  console.log('click');
  console.log(getCookie('admin_menu_collapse') === '1');
  if (getCookie('admin_menu_collapse') === '1') {
    setCookie('admin_menu_collapse', 0);
  } else {
    setCookie('admin_menu_collapse', 1);
  }
});

$(function () {
  $('[data-toggle="tooltip"]').tooltip();
});

function setCookie(cname, cvalue, exdays = 30) {
  let d = new Date();
  d.setTime(d.getTime() + (exdays*24*60*60*1000));
  let expires = "expires="+ d.toUTCString();
  document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}
function getCookie(cname) {
  let name = cname + "=";
  let decodedCookie = decodeURIComponent(document.cookie);
  let ca = decodedCookie.split(';');
  for(let i = 0; i <ca.length; i++) {
    let c = ca[i];
    while (c.charAt(0) == ' ') {
      c = c.substring(1);
    }
    if (c.indexOf(name) == 0) {
      return c.substring(name.length, c.length);
    }
  }
  return "";
}
