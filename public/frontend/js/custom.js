
$(document).on("click", ".formbold-next", function(){
    let stepId = $('.wizard-form.active').attr('step-id');
    $('.formbold-back-btn').addClass("active");
    $('.formbold-form-step-'+stepId).removeClass("active");
    $('.formbold-form-step-'+stepId).next().addClass("active");

    if(stepId==8) {
        $(".formbold-next").text('Submit');    
    }

    if(stepId==9) {
        $(".formbold-next").hide();   
        // $('.formbold-back-btn').hide(); 
        $('.formbold-back-btn').removeClass("active");
        $('.formbold-edit-btn').show(); 
    }

    
    if(stepId==2) {
        // $(".formbold-next").addClass("disabled");
    }
});


$(document).on("click", ".formbold-back-btn", function(){
    let stepId = $('.wizard-form.active').attr('step-id');
    $(".formbold-next").text('Next Step');
    if (stepId == 2) $('.formbold-back-btn').removeClass("active");
    $('.active').prev().addClass("active");
    $('.formbold-form-step-'+stepId).removeClass("active");
});

$(document).on("click", ".formbold-edit-btn", function(){
    let stepId = $('.wizard-form.active').attr('step-id');
    if (stepId == 2) $('.formbold-back-btn').removeClass("active");
    $('.formbold-edit-btn').hide(); 
    $(".formbold-next").text('Next Step');
    $(".formbold-next").show();  
    $('.formbold-form-step-10').removeClass("active");
    $('.formbold-form-step-1').addClass("active");
});
