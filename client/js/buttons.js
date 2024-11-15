function register(){
    $('#sign').css('transform','translate(-50%,-380%)');
    $('.form.sign').css('opacity','0');
    setTimeout(() => {
        $('.form.sign').css('display','none');

        $('#sign').css('display','none');
        $('#sign').css('transform','translate(-50%,-200%)');

        $('.form.signUp').css('display','block');

        //setTimeout(() => {

            $('.form.signUp').css('opacity','1');
            $('#reg').css('display','flex');
        //}, 100);

    }, 500);
}
function signIn(){
    $('#reg').css('transform','translate(-50%,-380%)');
    $('.form.signUp').css('opacity','0');
    setTimeout(() => {
        $('.form.signUp').css('display','none');

        $('#reg').css('display','none');
        $('#reg').css('transform','translate(-50%,-200%)');

        $('.form.sign').css('display','block');

        //setTimeout(() => {

            $('.form.sign').css('opacity','1');
            $('#sign').css('display','flex');
        //}, 100);

    }, 500);
}