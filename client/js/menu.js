setTimeout(() => {
    $('.b1').addClass('active')
    setTimeout(() => {
        $('.b2').addClass('active')
        setTimeout(() => {
            $('.b3').addClass('active')
            setTimeout(() => {
                $('.b4').addClass('active')
            }, 200);
        }, 200);
    }, 200);
}, 1000);


function htp(){
    $('.howToPlay').toggleClass('active');
    $('.b1').toggleClass('active');
    $('.b2').toggleClass('active');
    $('.b3').toggleClass('active');
    $('.b4').toggleClass('active');

};

function score(){
    $('.score').toggleClass('active');
    $('.b1').toggleClass('active');
    $('.b2').toggleClass('active');
    $('.b3').toggleClass('active');
    $('.b4').toggleClass('active');

};


