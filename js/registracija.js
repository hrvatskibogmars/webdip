
function onlyLetters(input_name) {
	var name = input_name;
	if(name === undefined || name === null){return false;}
    for (var i = 0; i < name.length; i++)
    {if (!isNaN(name[i])){return false;}}
    return true;
}

function isUpperCase(input_name){
    var name = input_name[0];

	if(name === undefined || name === null){
		return false;
	}

    if (name !== name.toUpperCase()){
    	return false;
    }
    return true;
}

function nameCheck(){
	var name = $("#user_name").val();
    if (isUpperCase(name) && onlyLetters(name)) {
			//.ime = true;
    	$("#name").removeClass("has-error").addClass("has-success has-feedback");
    	$("#alert_name").empty();
    }

    else{

    	if(!name) {
			//.ime = false;
			$("#name").removeClass("has-success").addClass("has-error has-feedback");
	    	$("#alert_name").text("Ime mora biti unseno!").show();
	    	return;
		}

		$("#name").removeClass("has-success").addClass("has-error has-feedback");
    	$("#alert_name").text("Ime zapocinje velikim slovom...i samo slova!").show();
    }
}

function surnameCheck(){
	var name = $("#user_surname").val();
    if (isUpperCase(name) && onlyLetters(name)) {
			//.prezime = true;
    	$("#surname").removeClass("has-error").addClass("has-success has-feedback");
    	$("#alert_surname").hide().empty();
    }

    else{

    	if(!name){
	    		//.prezime = false;
				$("#surname").removeClass("has-error").addClass("has-error has-feedback");
		    $("#alert_surname").text("Prezime mora biti uneseno!").show();
	    
	    	return;
	    }
	    
	    $("#surname").removeClass("has-success").addClass("has-error has-feedback");
    	$("#alert_surname").text("Prezimena se pišu velikim početnim slovima i smiju sadržavati samo slova!").show();
    }
}





function name_remove_Warning(){
	$("#name").removeClass("has-error has-feedback");
    $("#user_name").next().hide();
    $("#alert_name").hide();
}

function surname_remove_Warning(){
	$("#surname").removeClass("has-error has-feedback");
    $("#user_surname").next().hide();
    $("#alert_surname").hide();
}

function email_remove_Warning(){
	$("#email").removeClass("has-error has-feedback");
    $("#user_email").next().hide();
    $("#alert_email").hide();
}
function password_remove_Warning(){
    $("#password").removeClass("has-error has-feedback");
    $("#glyph_password").hide();
    $("#alert_password").hide();
}
function password2_remove_Warning(){
    $("#password2").removeClass("has-error has-feedback");
    $("#glyph_password2").hide();
    $("#alert_password2").hide();
}



function checkPassword2()
{
    var user_password = $('#user_password').val();
    var user_password2 = $('#user_password2').val();
    
    if(!user_password2)
    {
        $("#password2").removeClass("has-success").addClass("has-error has-feedback");
        $("#alert_password2").text("Ponovljena lozinka mora biti unesena!").show();
        return;
    }

    if(user_password === user_password2)
    {
        $("#password").removeClass("has-error").addClass("has-success has-feedback");
        $("#password2").removeClass("has-error").addClass("has-success has-feedback");
        $("#alert_password").hide();
        $("#alert_password2").hide();
    }
    else
    {
        $("#password").removeClass("has-success").addClass("has-error has-feedback");
        $("#password2").removeClass("has-success").addClass("has-error has-feedback");
        $("#alert_password").text("Lozinke nisu identične!").show();
        $("#alert_password2").text("Lozinke nisu identične!").show();
    }
}


function checkPassword()
{
    var user_password = $('#user_password').val();
    var user_password2 = $('#user_password2').val();

    if(!user_password)
    {
        $("#password").removeClass("has-success").addClass("has-error has-feedback");
        $("#alert_password").text("Lozinka mora biti unesena!").show();
        return;
    }
    if(user_password === user_password2) {
        $("#password").removeClass("has-error").addClass("has-success has-feedback");
        $("#password2").removeClass("has-error").addClass("has-success has-feedback");
        $("#alert_password").hide();
        $("#alert_password2").hide();
        return;
    }
    if(user_password2 || (user_password === user_password2))
    {
        $("#password").removeClass("has-success").addClass("has-error has-feedback");
        $("#password2").removeClass("has-success").addClass("has-error has-feedback");
        $("#alert_password").text("Lozinke nisu identične!").show();
        $("#alert_password2").text("Lozinke nisu identične!").show();

    }
}


function provjeri_mail(event) {
    var emailRegex = new RegExp(/^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/);
    console.log("user_email focusout");
    var email = $('#user_email').val();

    if(!email) {
            $("#email").removeClass("has-error").addClass("has-error has-feedback");
            $("#alert_email").text("Email adresa mora biti unesena!").show();
            return;
    }


    if (!email.match(emailRegex)) {

        $("#alert_email").text("Neispravno formatirana email adresa!").show();
        $("#email").removeClass("has-success").addClass("has-error has-feedback").show();
    }

    else
    {
        $.post("skripte/check_email.php",{email: email},function(data) {
            console.log("checkiramo mail....");
            console.log(data);

            if (data == 1) {
                $("#alert_email").text("E-mail adresa je zauzeta").show();
                $("#email").removeClass("has-success").addClass("has-error has-feedback").show();
            }
            else {
                $("#email").removeClass("has-error").addClass("has-success has-feedback");
            }
        });
    }
}



$("#user_username").focusout(function(event) {
    var username = $("#user_username").val();
    if(!username){
        $("#username").removeClass("has-success").addClass("has-error has-feedback");
        $("#alert_username").text("Korisničko ime mora biti uneseno!").show();
        return;
    }
    $.post("skripte/check_user.php",{ username: $("#user_username").val()}, function(data) {
        console.log(data);
        if (data == 1) {
            $("#alert_username").text("Korisničko ime je zauzeto!").show();
            $("#username").removeClass("has-success").addClass("has-error has-feedback").show();
        }
        else {

            $("#username").removeClass("has-error").addClass("has-success has-feedback");
            $("#alert_username").hide();
        }

    });
});


$(document).ready(function() {
    var city = new Array();
    $.get("http://arka.foi.hr/WebDiP/2013/materijali/dz3_dio2/gradovi.json", function(data) {
        $.each(data, function(key, val) {
           city.push(val);
        });
    },'json');

    $('#user_city').autocomplete({
        source: city
    });

    $('#user_name').focusout(nameCheck);
    $('#user_surname').focusout(surnameCheck);

    $('#user_name').keydown(name_remove_Warning);
    $('#user_surname').keydown(surname_remove_Warning);
    $('#user_email').keydown(email_remove_Warning);
    
    $('#user_password').keydown(password_remove_Warning);
    $('#user_password2').keydown(password2_remove_Warning);

    $('#user_password').focusout(checkPassword);
    $('#user_password2').focusout(checkPassword2);

    $("#user_email").focusout(provjeri_mail);
});