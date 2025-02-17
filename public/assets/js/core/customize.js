//=================================== Cookies ==================================================//
let setCookie = (cookie,value) => {
  let setCookie;
  let authacno = $('meta[name="auth-acno"]').attr('content');
  if (authacno!='') {
    setCookie = $.cookie(`${cookie}-${authacno}`,value);
  }
  return setCookie;
};
let getCookie = (cookie) => {
  let getCookie;
  let authacno = $('meta[name="auth-acno"]').attr('content');
  if (authacno!='') {
    getCookie = $.cookie(`${cookie}-${authacno}`);
  }
  return getCookie;
};
let removeCookie = (cookie) => {
  let removeCookie;
  let authacno = $('meta[name="auth-acno"]').attr('content');
  if (authacno!='') {
    removeCookie = $.removeCookie(`${cookie}-${authacno}`);
  }
  return removeCookie;
};
//=================================== Cookies ==================================================//
//==================================== bell animation and dot toggling ====================================
setInterval(function() {
  var bellIcon = $('#bell-icon');
  var dotIcon = $('#dot-icon');
  bellIcon.toggleClass('ringing');
  dotIcon.css('opacity', dotIcon.css('opacity') === '1' ? '0' : '1');
}, 1000);
//==================================== bell animation and dot toggling ====================================
//=================================== Search Bar ==================================================//
function search() {
  var input, filter, ul, li, a, i;
  input = $("#search-nav");
  if (input.val() === "") {
    $("#search-option").hide();
  } else {
    $("#search-option").show();
  }
  filter = input.val().toUpperCase();
  div = $("#search-option");
  a = div.find("a");
  for (i = 0; i < a.length; i++) {
    var txtValue = $(a[i]).text();
    if (txtValue.toUpperCase().indexOf(filter) > -1) {
      $(a[i]).show();
    } else {
      $(a[i]).hide();
    }
  }
}
//=================================== Search Bar ==================================================//
//=================================== Active Menu ==================================================//
$("ul.m-menu__nav > li.m-menu__item a").click(function(e) {
  var link = $(this);
  var item = link.parent("li.m-menu__item");
  if (item.children("ul").length > 0) {
    var href = link.attr("href");
    link.attr("href", "#");
    setTimeout(function() {
      link.attr("href", href);
    }, 300);
    e.preventDefault();
  }
}).each(function() {
  var link = $(this);
  if (getCookie('sidebarCollapsed')=='Yes') {
    $("body").addClass("sidebar-collapsed");
  }else{
    $("body").removeClass("sidebar-collapsed");
  }
  if (location.href == "/home") {
    $(".hamburger--elastic.toggle-sidebar").removeClass("is-active");
    link.parent("li.m-menu__item").addClass("mm-active").parents("li.m-menu__item.m-menu__item--submenu").children("ul").addClass("mm-show");
    return false;
  }
  if (link.get(0).href === location.href) {
    link.parent("li.m-menu__item").addClass("mm-active").parents("li.m-menu__item.m-menu__item--submenu").children("ul").addClass("mm-show");
    $(".hamburger--elastic.toggle-sidebar").addClass("is-active");
    return false;
  }
});
//=================================== Active Menu ==================================================//
//=================================== FileName ==================================================//
$(document).on('change','.uploadFile',function() {
  let file = $('.uploadFile')[0].files[0].name;
  $("#outputFile").text(file);
});
//=================================== FileName ==================================================//
//=================================== Validation ==================================================//
// Textarea Validation
$('textarea, input[type=text]').on('keypress', function (event) {
  if (event.charCode != 13) {
    var regex = new RegExp("^[a-zA-Z0-9- ,_.?+]+$");
    var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
    if (!regex.test(key)) {
       event.preventDefault();
       return false;
    }
  }
});
// Email Validation
$('input[type=email]').on('keypress', function (event) {
  var regex = new RegExp("^[a-zA-Z0-9@_.-]+$");
  var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
  if (!regex.test(key)) {
    event.preventDefault();
    return false;
  }
});
$('textarea, input').on('drop', function(e) {
  e.preventDefault();
});
// For Only Digits
$(document).on('keypress', '.digits', function() {
  var regex = new RegExp("^[0-9.+]+$");
  var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
  if (!regex.test(key)) {
   event.preventDefault();
   return false;
  }
});
// Only Alphabets
$(function() {
  $(".alphabets").keydown(function(e) {
    if (e.altKey) {
      e.preventDefault();
    } else {
      var key = e.keyCode;
      if (!(key == 8 || key == 9 || key == 32 || key == 46 || (key >= 35 && key <= 40) || (key >= 65 && key <= 90))) {
          e.preventDefault();
      }
    }
  });
});
//=================================== Validation ==================================================//
//=================================== Adjust DataTable ==================================================//
$(document).ready(function() {
  if (location.pathname!='/home') {
    if($('.table').length){
      setTimeout(() => {
        if (($('.table tbody tr').length)>1) {
          $($.fn.dataTable.tables( true ) ).DataTable().columns.adjust().draw().responsive.recalc();
          console.log(`Adjust DataTable`);
        }
      }, 4000);
    }
  }
});
$(document).on('click','.toggle-sidebar',function () {
  let sidebarCollapsed = ($('body').hasClass('sidebar-collapsed'))?'Yes':'No';
  setCookie('sidebarCollapsed',sidebarCollapsed);
  if (location.pathname!='/home') {
    if($('.table').length){
      setTimeout(() => {
        $($.fn.dataTable.tables( true ) ).DataTable().columns.adjust().draw().responsive.recalc();
        console.log(`Adjust DataTable`);
      }, 2000);
    }
  }
});
//=================================== Adjust DataTable ==================================================//
//=================================== CNIC ==================================================//
$(function() {
  $(".inputCNIC").keydown(function(e) {
    var key = e.charCode || e.keyCode || 0;
    $text = $(this);
    if (key !== 8 && key !== 9) {
      if ($text.val().length === 5) {
        $text.val($text.val() + "-");
      }
      if ($text.val().length === 13) {
        $text.val($text.val() + "-");
      }
    }
  });
});
//=================================== CNIC ==================================================//
//=================================== LAST URI ==================================================//
setCookie('lastURI', window.location.href);
//=================================== LAST URI ==================================================//
//=================================== Trial Period ==================================================//
// $(document).ready(function() {
//   let acno = $("#trialPeriod").attr('acno');
//   let user_id = $("#trialPeriod").attr('user_id');
//   let data = {
//     acno:acno,
//     user_id:user_id,
//     requestType: 'CountTrialPeriod'
//   }
//   $.post('datafiles/customer', data, function(result) {
//     let row = JSON.parse(result);
//     if (row.approved=='N') {
//       if (row.trial_time>=row.trial_period) {
//         window.open(row.url, "_self");
//       }else{
//         let finalTimeLeft;
//         let countDownDate = new Date(row.expire).getTime();
//         let x = setInterval(function() {
//           let now = new Date().getTime();
//           let distance = countDownDate - now; 
//           let days = Math.floor(distance / (1000 * 60 * 60 * 24));
//           let hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
//           let minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
//           let seconds = Math.floor((distance % (1000 * 60)) / 1000); 
//           finalTimeLeft = `${days} Days ${hours} Hours left for your Trial Period`;
//           if (distance < 0) {
//             clearInterval(x);
//             finalTimeLeft = 'EXPIRED';
//           }
//           $("#trialPeriod a").html(`${row.trial_period_left} days left of your Trial Period`);
//           $("#trialPeriod").attr('data-original-title',`${row.trial_period_left} days left of your Trial Period`);
//         }, 1000);
//         $("#trialPeriod").removeClass('d-none');
//       }
//     }else{
//       $("#trialPeriod").addClass('d-none');
//     }
//   });
// });
//=================================== Trial Period ==================================================//
//=================================== Open With Post ==================================================//
let OpenWindowWithPost = (url, name, params) => {
  var form = document.createElement("form");
  form.setAttribute("method", "post");
  form.setAttribute("action", url);
  form.setAttribute("target", name);
  for (var i in params) {
    if (params.hasOwnProperty(i)) {
      var input = document.createElement('input');
      input.type = 'hidden';
      input.name = i;
      input.value = params[i];
      form.appendChild(input);
    }
  }
  document.body.appendChild(form);
  if (name == '_blank') {} else {
    window.open("post.htm", name);
  }
  form.submit();
  document.body.removeChild(form);
};
//=================================== Open With Post ==================================================//
//=================================== Number Format ==================================================//
let formatNumberCommas = (number)=> {
  var parts = number.toString().split(".");
  parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
  return parts.join(".");
}
//=================================== Number Format ==================================================//
//=================================== INIT & Destroy LOADER ==================================================//
let initLoader = (id,text,className,type='N')=>{
  $(`#${id}`).html('');
  $(`#${id}`).removeClass(className);
  if (type=='N') {
    $(`#${id}`).css('min-width', '100%');
    $(`#${id}`).css('text-align', 'center');
  }
  let loaderClass = (type=='S')?'spinner_loader':'';
  $(`#${id}`).html(`<div class="spinner-border text-primary ${loaderClass}" role="status" id="initLoader">
  <span class="sr-only">Loading...</span>
  </div>`);
};
let destroyLoader = (id,text,className,style='N')=>{
  $(`#${id}`).html('');
  $(`#${id}`).addClass(className);
  if (style=='N') {
    $(`#${id}`).removeAttr("style");
  }
  setTimeout(() => {
    $(`#${id}`).html(text);
  }, 100);
};
//=================================== INIT & Destroy LOADER ==================================================//
//=================================== INIT Multiple Select ==================================================//
let initmultipleSelect = (ids)=>{
  $(ids).attr('multiple','multiple');
};
initmultipleSelect("#filter_destination_city,#filter_status_id");
//=================================== INIT Multiple Select ==================================================//
//=================================== Select2 Function ==================================================//
let init_select2 = ()=>{
  $((function () {
    $('[data-toggle="custom-select2"]').each((function () {
      $(this).select2({
        theme: 'bootstrap4',
        width: 'element',
        placeholder: $(this).attr('placeholder'),
        allowClear: Boolean($(this).data('allow-clear'))
      });
    }));
  }));
};
//=================================== Select2 Function ==================================================//
//=================================== INIT Popover ==================================================//
let init_popover = (props)=>{
  if (props=='popover') {
    $('[data-toggle="popover"]').popover();
  }else if(props=='custom_popover'){
    $('.popover-custom').each((function() {
      $(this).popover({
        html: true,
        content: function () {
          return $('#' + $(this).data('tip')).html();
        }
      });
    }));
  }
};
//=================================== INIT Popover ==================================================//
//=================================== INIT Tooltip ==================================================//
let init_tooltip = ()=>{
  $('[data-toggle="tooltip"]').tooltip();
};
//=================================== INIT Tooltip ==================================================//
//=================================== Notify Function ==================================================//
let Notification = (type,title,message='')=> {
  let icon;
  icon = (type=='danger') ? 'exclamation-circle' : (type=='warning') ? 'exclamation-triangle' : 'check-circle';
  $.notify({
    // options
    icon: 'glyphicon glyphicon-warning-sign',
    title: title,
    message: message,
    target: '_blank',
    url: '#example'
  }, {
    // settings
    type: type,
    newest_on_top: true,
    allow_dismiss: true,
    showProgressbar: true,
    animate: {
      enter: 'animated zoomIn',
      exit: 'animated zoomOut'
    },
    placement: {
      from: "top",
      align: "center"
    },
    offset: {
      x: 15,
      y: 15
    },
    spacing: 10,
    z_index: 1080,
    delay: 1500,
    timer: 2500,
    url_target: "_blank",
    mouse_over: !1,
    template: '<div data-notify="container" class="alert alert-dismissible text-white-50 shadow-sm alert-notify" role="alert">\n' +
      '    <div class="alert-wrapper-bg bg-{0}"></div>\n' +
      '    <div class="alert-content-wrapper">\n' +
      '        <i class="fas fa-'+icon+'"></i>\n' +
      '        <div class="pl-3">\n' +
      '            <span class="alert-title text-white" data-notify="title">{1}</span>\n' +
      '            <div data-notify="message" class="alert-text">{2}</div>\n' +
      '        </div>\n' +
      '    </div>\n' +
      '<button type="button" class="close" data-notify="dismiss" aria-label="Close"><span aria-hidden="true">×</span></button>\n' +
      '</div>'
  });
};
//=================================== Notify Function ==================================================//
//=================================== Copy ==================================================//
let copyToClipboard = (element) => {
  var $temp = $("<input>");
  $("body").append($temp);
  $temp.val($(element).val()).select();
  document.execCommand("copy");
  $temp.remove();
  Notification('success','Copied')
}
//=================================== Copy ==================================================//