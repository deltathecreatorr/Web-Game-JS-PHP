
$(document).ready(function(){
    // load functions once document is ready using jquery

    let attempts = 0; // attempts that user takes to match
    let score = 200; // default score, which is updated depending on attempts and time
    let checking = false; // checking if cards are currently matching
    let flipped_cards = []; // list to store the number of flipped card, the max size of the list can be 
                            // changed depending on the complexity of the object
    let level_points = []; // list to store the number of points that the user has on each level for complex complexity

    var start_time, end_time, seconds = 0; // time variables which are updated when the user starts the game


    function add_user(username, level1, level2, level3){
        // function to add the user into the database by sending a post request to add_user.php
        if (complexity === "complex"){
            // if complex, the user sends the scores for all three levels
            const data = {
                username: username,
                level1: level1,
                level2: level2,
                level3: level3
            };
            
            // sending a post request to add the user
            fetch('add_user.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(data)
            })
            .then(response => response.text())
            .then(() => {
                window.location.reload();
            });
        } else {
            // else, the user only needs to send the score for level1
            const data = {
                username: username,
                level1: level1
            };
        
            fetch('add_user.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(data)
            })
            .then(response => response.text())
            .then(() => {
                window.location.reload();
            });
        }
        
    }

    function start_timer () {
        // start the timer by getting the current time
        start_time = new Date();
    }

    function end_timer() {
        // end the timer by getting the new current time and then calculating the difference between events to see the seconds elapsed
        end_time = new Date();
        var difference = end_time - start_time;

        difference /= 1000;

        seconds = Math.round(difference);
        // update the scorebaord with the time
        $('.scoreboard #time').html('Time: ' + seconds);
    }

    function update_score(){
        // function to update the scoreboard based on complexity
        if (complexity === 'simple'){
            score = score - (attempts * 2)
            if (attempts > 10){
                // if the attempts passes a certain point, the user should not be able to click on more cards and the game would end
                $(".game-card").off('click');
                final_score();
            }
        } else if (complexity === 'medium'){
            score = score - ((attempts * 2) + (seconds)) // score for each complexity is different
            if (attempts > 20){
                $(".game-card").off('click');
                final_score();
                end_timer();
            } 
        } else {
            score = score - (attempts) - (seconds * 2)
            if (attempts > 20){
                $(".game-card").off('click');
                final_score();
                end_timer();
            }
        }

        if (score < 0) {
            score = 0;
        }

        // if the user has a new high score, update the game area to gold
        if (complexity === 'complex'){
            if (score > bestscore){
                $(".start-game-area").css("background-color", '#FFD700');
            } else {
                $(".start-game-area").css("background-color", 'gray');
            }
        }
    };

    function final_score() {
        // the function to calculate the final score
        // depending on attempts, the final score is adjusted
        let points = 0;
        if (attempts < 10) {
            points = 50;
        } else if (attempts < 20) {
            points = 25;
        } else {
            points = 0;
        }

        // if the complexity is not simple, the score also depends on the time
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
            if (complexity === 'complex'){
                level_points.push(points);
            }
        }
        
        // update the score
        $(".scoreboard #score").html('Score: ' + score);
    };

    function check_win(){
        // function to check if all cards are matched
        var allmatched = true;

        $(".game-card").each(function(){
            if (!$(this).hasClass("matched")){
                allmatched = false;
                return false;
            }
        });

        if (allmatched) {
            // if all the cards matched, a submit button needs to be added
            $(".game-card").off('click');
            if (complexity === 'simple'){
                final_score();
                $('#game-square').append("<button id='submit-leaderboard' class='btn btn-warning' type='button'> Submit </button>");
            } else if (complexity === 'medium'){
                end_timer();
                final_score();
                $('#game-square').append("<button id='submit-leaderboard' class='btn btn-warning' type='button'> Submit </button>");
            } else {
                end_timer();
                final_score();

                if (current_level < 3 ){
                    $('#game-square').append("<button id='next-level-button' class='btn btn-warning' type='button'> Next Level </button>");
                } else {
                    $('#game-square').append("<button id='submit-leaderboard' class='btn btn-warning' type='button'> Submit </button>");
                }
            }
            
        } else {
            return false;
        }
    };

    function display_cards() {
        // remove the hidden cards
        $('#game-square').removeClass('hidden');
    };

    $(document).on('click','.game-card', function(){
        // jquery event listener to check for card clicks on the cards
        if ( checking || $(this).hasClass('flipped') || $(this).hasClass('matched')){
            return;
        }

        $(this).addClass('flipped');
        flipped_cards.push($(this));

        // if cards are being checked time out the cards, so there are no more cards being added to the list
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

    // event listener for the remove button, then call the display_cards function
    $('#remove-button').on('click', function(){
        $('#remove-button').remove();
        if (complexity === 'simple'){
            display_cards();
        } else {
            display_cards();
            start_timer();
        }
    })

    // event listener for the submit leaderboard button
    $(document).on('click', '#submit-leaderboard', function(){
        // add user to the database and pass the point for each level
        if (complexity === 'complex'){
            add_user(username, level_points[0], level_points[1], level_points[2]);
        } else {
            add_user(username, score, 0, 0);
        }

        level_points.length = 0;
    });

    function check_cards() {
        // function to check if cards are matching
        // if complex, iterate through the flipped_cards list
        // emojis are compared by checking the img sources
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
                
                //  if cards match, check if the user has won, and empty the flipped_cards list and update the checking value
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
            // if complexity, cards aer checked only for two
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

    // shuffle the cards by passing all the cards in an array and randomizing positions and then return the shuffled array
    function shuffle(array) {
        for (let i = array.length - 1; i >= 0; i--){
            const j = Math.floor(Math.random() * (i + 1));
            [array[i],array[j]] = [array[j], array[i]];
        }
        return array;
    }
    
    // function to start a new level for the complex complexity
    function new_level(complex_list){
        console.log("New Level");
        current_level += 1;
        // using ajax to update the level without completely reloading the page
        $.ajax({
            // post request sent to server to update the level
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
            // check if there are anymore levels
            alert("You have completed all levels");
            $('#game-square').append("<button id='submit-leaderboard' class='btn btn-warning' type='button'> Next Level </button>");
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

    // event listener to check if the next-level-button is clicked
    $(document).on('click', '#next-level-button', function () {
        console.log("Next Level Button Clicked");
        $('#next-level-button').remove();
        new_level(complex_random_array);
    });

    function generate_cards(random_list) {
        // function to generate the all the cards for the complex complexity for each level
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
    
    // shuffle the cards when they load
    var shuffled = shuffle($("#game-board").children().toArray());
    $('#game-board').empty().append(shuffled);

});