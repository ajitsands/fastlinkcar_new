$(document).ready(function() {
    
    
$('#btn_login').click(function() {
    var username = $('#username').val().trim();
    var password = $('#password').val().trim();

    if (username === '' || password === '') {
      $('#responseMsg').html('Please enter both username and password.');
      return;
    }

          $.ajax({
          url: '/LoginController',
          type: 'POST',
          dataType: 'json',  
          data: { username: username, password: password, action:'login' },
          beforeSend: function() {
            $('#btn_login').prop('disabled', true).text('Logging in...');
          },
          success: function(response) {
            $('#btn_login').prop('disabled', false).text('Login');
            
            if (response.status === 'success') {
             
              window.location.href = '/Home';
            } else {
              $('#responseMsg').html(response.message);
            }
          },
          error: function(xhr, status, err) {
            $('#btn_login').prop('disabled', false).text('Login');
            $('#responseMsg').html('AJAX error: ' + status);
            console.error(xhr, err);
          }
        });
     });
 
});