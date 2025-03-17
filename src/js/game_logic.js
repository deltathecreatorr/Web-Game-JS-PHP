

$(document).ready(function(){

    let attempts = 0;
    let score = 200;
    let checking = false;
    let flipped_cards = [];

    var start_time, end_time, seconds = 0;

    function start_timer () {
        start_time = new Date();
    }

    function end_timer() {
        end_time = new Date();
        var difference = end_time - start_time;

        difference /= 1000;

        seconds = Math.round(difference);
        $('.scoreboard #time').html('Time: ' + seconds);
    }

    function update_score(){
        if (complexity === 'simple'){
            score = score - (attempts * 2)
            if (attempts > 10){
                $(".game-card").off('click');
                final_score();
            }
        } else if (complexity === 'medium'){
            score = score - ((attempts * 2) + (seconds))
            if (attempts > 20){
                $(".game-card").off('click');
                final_score();
                end_timer();
            } 
        } else {
            score = score - (attempts * 2) - (seconds * 2)
            if (attempts > 30){
                $(".game-card").off('click');
                final_score();
                end_timer();
            }
        }

        if (score < 0) {
            score = 0;
        }
    };

    function final_score() {
        let points = 0;
        if (attempts < 10) {
            points = 50;
        } else if (attempts < 20) {
            points = 25;
        } else {
            points = 0;
        }

        if (complexity === 'simple'){
            score = score + points;
        } else {
            if (seconds < 10) {
                points += 50;
            } else if (seconds < 30) {
                points += 25;
            } else {
                points = 0;
            }

            score = score + points;
            
        }
        if (score > bestscore){
            $("#game-board").css("background-color", '#FFD700');
        }

        $(".scoreboard #score").html('Score: ' + score);
    };

    function check_win(){
        var allmatched = true;

        $(".game-card").each(function(){
            if (!$(this).hasClass("matched")){
                allmatched = false;
                return false;
            }
        });

        if (allmatched) {
            $(".game-card").off('click');
            if (complexity === 'simple'){
                final_score();
            } else if (complexity === 'medium'){
                end_timer();
                final_score();
            } else {
                $('#game-square').append("<button id='next-level-button' class='btn btn-warning' type='button'> Next Level </button>");
                end_timer();
                final_score();
            }
            
        } else {
            return false;
        }
    };

    function display_cards() {
        $('#game-square').removeClass('hidden');
    };

    $(document).on('click','.game-card', function(){
        if ( checking || $(this).hasClass('flipped') || $(this).hasClass('matched')){
            return;
        }

        $(this).addClass('flipped');
        flipped_cards.push($(this));

        if (complexity !== 'complex') {
            if (flipped_cards.length === 2) {
                checking = true;
                setTimeout(check_cards, 500);
            } else {
                checking = false;
            }
        } else {
            if (flipped_cards.length === complex_match_array[current_level - 1]) {
                checking = true;
                setTimeout(check_cards, 500);
            } else {
                checking = false;
            }
        }

    })

    $('#remove-button').on('click', function(){
        $('#remove-button').remove();
        if (complexity === 'simple'){
            display_cards();
        } else {
            display_cards();
            start_timer();
        }
    })

    function check_cards() {
        if (complexity === 'complex' && complex_match_array[current_level - 1] > 2) {
            if (flipped_cards.length === complex_match_array[current_level - 1]) {
                attempts++;
                update_score();

                let match = true;

                const first_card = flipped_cards[0];

                const first_card_features = {
                    skin: first_card.find('.back .skin').attr('src'),
                    mouth: first_card.find('.back .mouth').attr('src'),
                    eyes: first_card.find('.back .eyes').attr('src')
                };

                for ($index = 0; $index < flipped_cards.length; $index++) {
                    const card = flipped_cards[$index];
                    const card_features = {
                        skin: card.find('.back .skin').attr('src'),
                        mouth: card.find('.back .mouth').attr('src'),
                        eyes: card.find('.back .eyes').attr('src')
                    };

                    if (card_features.skin !== first_card_features.skin || 
                        card_features.mouth !== first_card_features.mouth ||
                        card_features.eyes !== first_card_features.eyes) {
                            match = false;
                            break;
                        } else {
                            match = true;
                        }
                }
                
                if (match === true){
                    console.log("Match Found");
                    flipped_cards.forEach((card_in_list) => {
                        card_in_list.addClass('matched');
                    });
                    check_win();
                    flipped_cards = [];
                    checking = false;

                } else {
                    console.log("No Match");
                    setTimeout(() => {
                        flipped_cards.forEach((card_in_list) => {
                            console.log("Card Classes Before Removal:", card_in_list.attr('class'));
                            card_in_list.removeClass('flipped');
                            console.log("Card Classes After Removal:", card_in_list.attr('class'));
                        });
                        flipped_cards = [];
                        checking = false;
                    }, 500);
                }
            }
                    

        } else {
            var first_card = flipped_cards[0];
            var second_card = flipped_cards[1];

            if (flipped_cards.length === 2) {

                attempts++;
                update_score();

                var first_cardimg = {
                    skin: first_card.find('.back .skin').attr('src'),
                    mouth: first_card.find('.back .mouth').attr('src'),
                    eyes: first_card.find('.back .eyes').attr('src')
                }
                var second_cardimg = {
                    skin: second_card.find('.back .skin').attr('src'),
                    mouth: second_card.find('.back .mouth').attr('src'),
                    eyes: second_card.find('.back .eyes').attr('src')
                }

                if (first_cardimg.skin === second_cardimg.skin && 
                    first_cardimg.mouth === second_cardimg.mouth &&
                    first_cardimg.eyes === second_cardimg.eyes) {
                        console.log("Match Found");
                        first_card.addClass('matched');
                        second_card.addClass('matched');
                        check_win();
                } else {
                    console.log("No Match");
                    setTimeout(() => {
                        first_card.removeClass('flipped');
                        second_card.removeClass('flipped');
                    }, 500);
                }
            }
            flipped_cards = [];
            checking = false; 
        }
    }

    function shuffle(array) {
        for (let i = array.length - 1; i >= 0; i--){
            const j = Math.floor(Math.random() * (i + 1));
            [array[i],array[j]] = [array[j], array[i]];
        }
        return array;
    }
    

    function new_level(complex_list){
        console.log("New Level");
        current_level += 1;

        $.ajax({
            url: 'update_level.php',
            method: 'POST',
            data: { current_level: current_level},
            success: function(response){
                console.log("Success" + response);
            },

            error: function(response){
                console.log("Error" + response);
            }
        });

        if (current_level - 1 >= complex_list.length) {
            alert("You have completed all levels");
        } else {
            console.log("Level Generation")
            $('.scoreboard #score').html('Score: ' + score);
            $('.scoreboard #time').html('Time: ' + seconds);

            attempts = 0;
            score = 200;
            seconds = 0;

            generate_cards(complex_list[current_level - 1]);
            start_timer();

            var shuffled = shuffle($("#game-board").children().toArray());
            $('#game-board').empty().append(shuffled);
        }
    }

    $(document).on('click', '#next-level-button', function () {
        console.log("Next Level Button Clicked");
        $('#next-level-button').remove();
        new_level(complex_random_array);
    });

    function generate_cards(random_list) {
        $('#game-board').empty()

        random_list.forEach((image, index) => {
            const html = `
            <div class="game-card-container">
                <div class="game-card">
                    <div class="front">
                        <img src="../images/q_mark.png">
                    </div>
                    <div class="back">
                        <div class="image-wrapper">
                            <img src="${image[2]}" class="overlayImage skin">
                            <img src="${image[1]}" class="overlayImage mouth">
                            <img src="${image[0]}" class="overlayImage eyes">
                        </div>
                    </div>
                </div>
            </div>`;

            $('#game-board').append(html);
            }
        );
    }
    
    var shuffled = shuffle($("#game-board").children().toArray());
    $('#game-board').empty().append(shuffled);

});