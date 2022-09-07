$(document).ready(function() //раскрывающиеся блоки
{
    $('.spoiler').css({'display':'none'});
    $('.zagolovok').click(function(){
        $(this).next('.spoiler').slideToggle(500)
    });
});