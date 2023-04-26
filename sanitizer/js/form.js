$(function() {

  var form = $('.form');

  var formMessages = $('#form-messages');
  var lang = $('html').attr("lang");

  $(form).submit(function(event) {
    event.preventDefault();

    grecaptcha.ready(function() {
      grecaptcha.execute('6Lc-WM0ZAAAAAJ1T0hh252ZGYXypPNkfSK1ZohVM', {action: 'submit'}).then(function(token) {
        var formData = $(form).serialize();
        formData += `&token=${token}`;
        formData += `&action=submit`;

        $.ajax({
          type: 'POST',
          url: 'mail.php',
          data: formData
        })
        .done(function(response) {
          var res = JSON.parse(response);
          $(formMessages).removeClass('error');
          $(formMessages).addClass('success');
      

          $(formMessages).text(res[lang]);
      
          $('#name').val('');
          $('#email').val('');
          $('#company').val('');
          $('#message').val('');
        })
        .fail(function(response) {
          var err = JSON.parse(response)

          $(formMessages).removeClass('success');
          $(formMessages).addClass('error');
      

          $(formMessages).text(err[lang]);
        });
      });
    });

  });
});