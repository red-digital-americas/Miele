/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
define(['jquery', 'alerts', 'validator', 'exceptions'], function($, alerts, validator, exceptions){
    var Login = function(){
        var loginContainer = $('#login-container');
        this.init = function(){
            $(document).ready(function(){
                $('#btnLogin').click(function(e){
                    e.preventDefault();
                    validateFields();
                });
            });
        };
                
        var validateFields = function(){
            var inputUserName = $('#inputEmail');
            var inputPassword = $('#inputPassword');
            
            removeAlerts();
            
            if(inputUserName.val().length === 0){
                addAlerts("*El email es obligatorio");
                alerts.addFormError(inputUserName);
            }
            else if(!validator.email(inputUserName.val())){
                addAlerts("*Debe introducir un email válido");
                alerts.addFormError(inputUserName);
            }
                
            if(inputPassword.val().length === 0){
                addAlerts('*El password es obligatorio');
                alerts.addFormError(inputPassword);
            }

            if(isHasErrors())
                return 0;
            
            loginRequest();
        };
        
        var loginRequest = function(){
            removeAlerts();
            $.ajax({
                method: "POST",
                async: false,
                cache: false,
                data: loginContainer.closest('form').serialize(),
                url: document.location.origin+"/auth/login",
//                contents: "json",
                success: function(response, textStatus, jqXHR) {
                    manageResponse(response);
                },
                error: function( jqXHR, textStatus, errorThrown){
                    var response = jqXHR.responseJSON;
                    if(response === undefined)
                        return addAlerts(exceptions.INTERNAL_SERVER_ERROR+". without response");

                    if(response.message !== undefined)
                        addAlerts(response.message);
                    else
                        addAlerts(response.responseText);
                }
            });
        };
        
        var manageResponse = function(response){
            if (typeof response !== 'object')
                return denyAccess("internal server error. "+response);
            
            if(response.status !== true){
                if (response.message !== undefined)
                    denyAccess(response.message);
                else
                    denyAccess(exceptions.INTERNAL_SERVER_ERROR);
            }else{
                login(response);
            }
            
        };
        
        var login = function(response){           
            window.location.href = document.location.origin+"/home/?token="+response.token;
        };
        
        var denyAccess = function(message){
            addAlerts(message);
        };
        
        var isHasErrors = function(){
            var status = 0;
            $(loginContainer).find('input').each(function(){
                if(alerts.isHasFormError($(this)))
                    status =  1;
            });
            
            return status;
        };
        
        var removeAlerts = function(){
            $(loginContainer).find('input').each(function(){
                alerts.removeFormError(this);
            });
            
            $('.login-alerts').hide().empty();
        };
        
        var addAlerts = function(message){
           $('.login-alerts').show().append("<p>"+message+"</p>");
        };
    };
    
    var login = new Login();
    login.init();
    
    return true;
});
