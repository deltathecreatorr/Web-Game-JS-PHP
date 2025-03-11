

$(document).ready(function(){

    function display_cards() {
        $('#game-square').removeClass('hidden');
    }

    $(document).on('click','.game-card', function(){
        if (!$(this).hasClass('flipped')) {
            $(this).addClass('flipped');

            setTimeout(check_cards(), 500);
        }
    })

    $('#remove-button').on('click', function(){
        $('#remove-button').remove();
        display_cards();
    })

    function check_cards() {
        var $cards = $(".game-card.flipped");
        if ($cards.length === 2) {
            var first_card = $cards.eq(0).find(".back img.overlayImage").attr("src");
            var second_card = $cards.eq(1).find(".back img.overlayImage").attr("src");

            if (first_card === second_card) {
                console.log("Match Found");
            } else {
                console.log("No Match");
                setTimeout(() => {
                    $cards.removeClass("flipped");
                }, 1000);
            }
        } 
    }
})