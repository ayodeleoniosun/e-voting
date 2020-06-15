function chk_text(text)
{
	var text_length = $.trim((text).val()).length;
	return text_length;
}

function check_text(text)
{
	var text_length = str.trim((text).value).length;
	return text_length;
}

function filter_text(text)
{
	var textfield = document.getElementById(text);
	//var regex = /[^a-z 0-9?!.,]/gi;
	var regex = /[^0-9]/gi;
	if(textfield.value.search(regex) > -1) 
	{
		textfield.value = textfield.value.replace(regex, "");
    }
}

function isNumberKey(evt)
{
    var charCode = (evt.which) ? evt.which : event.keyCode;
    
    if (charCode > 31 && (charCode < 48 || charCode > 57) )
    { 
      return false;
 	}
}

function filter_text_options(text)
{
	var textfield = document.getElementById(text);
	//var regex = /[^a-z 0-9?!.,]/gi;
	var regex = /[^2-9]/gi;
	if(textfield.value.search(regex) > -1) 
	{
		textfield.value = textfield.value.replace(regex, "");
    }
}

function Print($survey_details)
{
	$survey_details = document.getElementById($survey_details).innerHTML;
	document.body.innerHTML = $survey_details;
	window.print();
}


function CheckAllBoxes(master,checkbox)
{
	var all_checkbox = document.getElementsByName(checkbox);
		
	for(i=0;i<all_checkbox.length;i++)
	{
		all_checkbox[i].checked = master.checked;
	}
}

$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();   
});

$(document).ready(function()
{
	$("form#add_post_form").submit(function(e)
	{
		e.preventDefault();
		var check_post = chk_text($("#post"));
		var data = $(this).serialize();
		var support_ajax_status = $("#support_ajax_status");
		var ajax_status = $("#ajax_status");
		support_ajax_status.show();
	
		if(check_post == 0)
		{
			support_ajax_status.html("<i class='icon-remove'></i> Please enter the post name").delay(4000).fadeOut("slow");
			$("#post").focus();
		}
		else
		{
			$.ajaxSetup(
			{
				beforeSend: function()
				{
					support_ajax_status.html("Adding post <img src='../images/loading_bar.gif'/>");
				},
				complete: function()
				{
					support_ajax_status.html("").delay(4000).fadeOut("slow");
				}
			});
				
			$.ajax(
			{
				type: "POST",
				url: "../confirm?AddPost",
				data: data,
				cache: false,
				
				success:function(msg)
				{
					ajax_status.show();
					ajax_status.html("<div align='center'>"+msg+"</div>").delay(4000).fadeOut("slow");
				}
			});
		}
	});
	
	$("form#add_dept_form").submit(function(e)
	{
		e.preventDefault();
		var data = $(this).serialize();
		var support_ajax_status = $("#support_ajax_status");
		var ajax_status = $("#ajax_status");
		support_ajax_status.show();
	
		$.ajaxSetup(
		{
			beforeSend: function()
			{
				support_ajax_status.html("Adding department <img src='../images/loading_bar.gif'/>");
			},
			complete: function()
			{
				support_ajax_status.html("").hide("fast");
			}
		});
			
		$.ajax(
		{
			type: "POST",
			url: "../confirm?AddDepartment",
			data: data,
			cache: false,
			
			success:function(msg)
			{
				ajax_status.show();
				ajax_status.html("<div align='center'>"+msg+"</div>").delay(4000).fadeOut("slow");
			}
		});
	});
	
	$("form#add_voters_single_form").submit(function(e)
	{
		e.preventDefault();
		var data = $(this).serialize();
		var support_ajax_status = $("#support_ajax_status");
		var ajax_status = $("#ajax_status");
		support_ajax_status.show();
		
		$.ajaxSetup(
		{
			beforeSend: function()
			{
				support_ajax_status.html("Adding voter <img src='../images/loading_bar.gif'/>");
			},
			complete: function()
			{
				support_ajax_status.html("").hide("fast");
			}
		});
			
		$.ajax(
		{
			type: "POST",
			url: "../confirm?AddVoterSingle",
			data: data,
			cache: false,
			
			success:function(msg)
			{
				ajax_status.show();
				ajax_status.html("<div align='center'>"+msg+"</div>").delay(4000).fadeOut("slow");
			}
		});
	});
	
	$("form#accredit_form").submit(function(e)
	{
		e.preventDefault();
		var data = $(this).serialize();
		var ajax_status = $("#ajax_status");
		support_ajax_status.show();
		
		$.ajaxSetup(
		{
			beforeSend: function()
			{
				support_ajax_status.html("Accrediting voter <img src='../images/loading_bar.gif'/>");
			},
			complete: function()
			{
				support_ajax_status.html("").hide("fast");
			}
		});
			
		$.ajax(
		{
			type: "POST",
			url: "../confirm?AccreditVoter",
			data: data,
			cache: false,
			
			success:function(msg)
			{
				ajax_status.show();
				ajax_status.html("<div align='center'>"+msg+"</div>").delay(4000).fadeOut("slow");
			}
		});
	});
	
	$("form#generate_keys_form").submit(function(e)
	{
		e.preventDefault();
		var key_num = $("#key_num").val();
		var data = $(this).serialize();
		var support_ajax_status = $("#support_ajax_status");
		var status = $("#show_keys");
		support_ajax_status.show();
		
		if(key_num.length == 0)
		{
			support_ajax_status.html("<i class='icon-remove'></i> Please enter the number of voting keys you want to generate.");
		}
		else
		{
			$.ajaxSetup(
			{
				beforeSend: function()
				{
					support_ajax_status.html("Generating "+key_num+" voting keys <img src='../images/loading_bar.gif'/>");
				},
				complete: function()
				{
					support_ajax_status.html("").delay(2000).fadeOut("slow");
				}
			});
				
			$.ajax(
			{
				type: "POST",
				url: "../confirm?GenerateVotingKeys",
				data: data,
				cache: false,
				
				success:function(msg)
				{
					status.html(msg);
				}
			});	
		}
	});
	
	$("form#add_voters_bulk_form").submit(function(e)
	{
		e.preventDefault();
		var data = new FormData($(this)[0]);;
		var support_ajax_status = $("#support_ajax_status");
		var ajax_status = $("#ajax_status");
		support_ajax_status.show();
		
		$.ajaxSetup(
		{
			beforeSend: function()
			{
				support_ajax_status.html("Adding voters <img src='../images/loading_bar.gif'/>");
			},
			complete: function()
			{
				support_ajax_status.html("").hide("fast");
			}
		});
			
		$.ajax(
		{
			type: "POST",
			url: "../confirm?AddVotersBulk",
			data: data,
			cache: false,
			contentType: false,
            processData: false,
				
			success:function(msg)
			{
				ajax_status.show();
				ajax_status.html("<div align='center'>"+msg+"</div>").delay(4000).fadeOut("slow");
			}
		});
	});
	
	$("form#add_aspirant_form").submit(function(e)
	{
		e.preventDefault();
		var data = new FormData($(this)[0]);;
		var support_ajax_status = $("#support_ajax_status");
		var ajax_status = $("#ajax_status");
		support_ajax_status.show();
		
		$.ajaxSetup(
		{
			beforeSend: function()
			{
				support_ajax_status.html("Adding aspirant <img src='../images/loading_bar.gif'/>");
			},
			complete: function()
			{
				support_ajax_status.html("").hide("fast");
			}
		});
			
		$.ajax(
		{
			type: "POST",
			url: "../confirm?AddAspirant",
			data: data,
			cache: false,
			contentType: false,
            processData: false,
				
			success:function(msg)
			{
				ajax_status.show();
				ajax_status.html("<div align='center'>"+msg+"</div>").delay(4000).fadeOut("slow");
			}
		});
	});
	
	$("form#add_rep_form").submit(function(e)
	{
		e.preventDefault();
		var data = new FormData($(this)[0]);;
		var support_ajax_status = $("#support_ajax_status");
		var ajax_status = $("#ajax_status");
		support_ajax_status.show();
	
		$.ajaxSetup(
		{
			beforeSend: function()
			{
				support_ajax_status.html("Adding floor rep <img src='../images/loading_bar.gif'/>");
			},
			complete: function()
			{
				support_ajax_status.html("").hide("fast");
			}
		});
			
		$.ajax(
		{
			type: "POST",
			url: "../confirm?AddFloorRep",
			data: data,
			cache: false,
			contentType: false,
            processData: false,
				
			success:function(msg)
			{
				ajax_status.show();
				ajax_status.html("<div align='center'>"+msg+"</div>").delay(4000).fadeOut("slow");
			}
		});
	});
	
	$("#add_admin").click(function()
	{
		var data = $("#add_admin_form").serialize();
        var support_ajax_status = $("#support_ajax_status");
		var ajax_status = $("#ajax_status");
		support_ajax_status.show();

		$.ajaxSetup(
		{
			beforeSend: function()
			{
				support_ajax_status.html("Adding administrator <img src='../images/loading_bar.gif'/>");
			},
			complete: function()
			{
				support_ajax_status.html("").delay(4000).fadeOut("slow");
			}
		});
		
		$.ajax(
		{
			type: "POST",
			url: "../confirm?AddAdmin",
			data: data,
			cache: false,
			
			success:function(msg)
			{
				ajax_status.show();
				ajax_status.html("<div align='center'>"+msg+"</div>").delay(4000).fadeOut("slow");
			}
		});
	});

	$("form#settings_form").submit(function(e)
	{
		e.preventDefault();
		var data = $(this).serialize();
		var support_ajax_status = $("#support_ajax_status");
		var ajax_status = $("#ajax_status");
		
		$.ajaxSetup(
		{
			beforeSend: function()
			{
				support_ajax_status.show();
				support_ajax_status.html("Please wait <img src='../images/loading_bar.gif'/>");
			},
			complete: function()
			{
				support_ajax_status.show();
				support_ajax_status.html("").delay(4000).fadeOut("slow");
			}
		});
		
		$.ajax(
		{
			type: "POST",
			url: "../confirm?UpdateElectionSettings",
			data: data,
			cache: false,
				
			success:function(msg)
			{
				ajax_status.show();
				ajax_status.html("<div align='center'>"+msg+"</div>").delay(4000).fadeOut("slow");
			}
		});
	});
	
	$("form#change_password_form").submit(function(e)
	{
		e.preventDefault();
		var data = $(this).serialize();
		var support_ajax_status = $("#support_ajax_status");
		var ajax_status = $("#ajax_status");
		
		$.ajaxSetup(
		{
			beforeSend: function()
			{
				support_ajax_status.show();
				support_ajax_status.html("Verifying password <img src='../images/loading_bar.gif'/>");
			},
			complete: function()
			{
				support_ajax_status.show();
				support_ajax_status.html("").delay(4000).fadeOut("slow");
			}
		});
		
		$.ajax(
		{
			type: "POST",
			url: "../confirm?ChangePassword",
			data: data,
			cache: false,
				
			success:function(msg)
			{
				ajax_status.show();
				ajax_status.html("<div align='center'>"+msg+"</div>").delay(4000).fadeOut("slow");
			}
		});
	});
	
	$("form#login_form").submit(function(e)
	{
		e.preventDefault();
		var username = $("#username").val();
		var pass = $("#password").val();
		var data = $(this).serialize();
		var support_ajax_status = $("#support_ajax_status");
		var ajax_status = $("#ajax_status");
		support_ajax_status.show();
	
		if(username == "" || pass == "") 
		{
			support_ajax_status.html("<i class='icon-remove'></i> Incorrect login details").delay(4000).fadeOut("slow");
		}
		else
		{
			$.ajaxSetup(
			{
				beforeSend: function()
				{
					support_ajax_status.html("Verifying login details <img src='../assets/images/loading_bar.gif'/>");
				},
				complete: function()
				{
					support_ajax_status.hide("fast");
				}
			});
				
			$.ajax(
			{
				type: "POST",
				url: "../confirm?AdminLogin",
				data: data,
				cache: false,
				
				success:function(msg)
				{
					ajax_status.show();
					ajax_status.html("<div align='center'>"+msg+"</div>").delay(4000).fadeOut("slow");
				}
			});
		}
	});

	$("form#student_login_form").submit(function(e)
	{
		e.preventDefault();
		var username = $("#matric").val();
		var pass = $("#key").val();
		var data = $(this).serialize();
		var support_ajax_status = $("#support_ajax_status");
		var ajax_status = $("#ajax_status");
		support_ajax_status.show();
	
		if(username == "" || pass == "") 
		{
			support_ajax_status.html("<i class='icon-remove'></i> Incorrect login details").delay(4000).fadeOut("slow");
		}
		else
		{
			$.ajaxSetup(
			{
				beforeSend: function()
				{
					support_ajax_status.html("Verifying login details <img src='../images/loading_bar.gif'/>");
				},
				complete: function()
				{
					support_ajax_status.hide("fast");
				}
			});
				
			$.ajax(
			{
				type: "POST",
				url: "../confirm?StudentLogin",
				data: data,
				cache: false,
				
				success:function(msg)
				{
					ajax_status.show();
					ajax_status.html("<div align='center'>"+msg+"</div>");
				}
			});
		}
	});
});