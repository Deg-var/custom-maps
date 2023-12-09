$(document).ready(function () {
    $(function () {
        $('.real-show-hint').on("mouseover mouseout", function(e){
            e = e || window.event;
            e.preventDefault();
            var ypos = $(this).offset().top-50;
            var xpos = $(this).offset().left;
            var RealHint =  $(this).data('hint');
            $(RealHint).css('top',ypos);
            $(RealHint).css('left',xpos);
            $(RealHint).toggle('fast');
            return;
        });

        $('.prm-cross').on('click', function(){
            $(this).parent().hide('fast');
            return false;
        });

        document.onclick = function(e){
            if ($(e.target).hasClass('real-hint')===false)
                $('.real-hint').hide('fast');
            return;
        }
    });
})