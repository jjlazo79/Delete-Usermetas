jQuery('#js-reset-usermeta').submit(function() {
    var usermeta = jQuery('#user_usermeta').val();
    var c = confirm("This action will delete all data of  '" + usermeta + "'. Click OK to continue?");
    return c; //you can just return c because it will be true or false
});