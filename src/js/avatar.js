$(document).ready(function() {
    // jquery to load all functions when the document is ready

    let currentIndex = 0; // Index for the medium complexity avatar
    let skinIndex = 0; // skin index for complex complexity
    let mouthIndex = 0; // mouth index for complex complexity
    let eyeIndex = 0; // eye index for complex complexity

    $(".avatar_section").hide();
    // hide all the avatar sections initially

    // jquery event listener to check if the value for the selected variable changes
    $('#avatar_complexity').change(function() {
        var avatar = $(this).val();

        // hide the sections to make sure only the relevant section for the select button is shown
        $(".avatar_section").hide();

     
        if (avatar === "simple") {
            $(".simple_choice").show();
        } else if (avatar === "medium") {
            $(".medium_choice").show();
            medium_changeEmoji(currentIndex);
        } else if (avatar === "complex") {
            $(".complex_choice").show();
            complex_changeEmoji(skinIndex, mouthIndex, eyeIndex);
        }
    });

    // trigger the change event using jquery to show the correct avatar picking
    $('#avatar_complexity').trigger('change')

    function medium_changeEmoji(currentIndex){
        // function to update the html content for the medium complexity
        // jquery to directly target the medium complexity div
        $('.medium_choice').html(`
            <div class="centered">
                <h1> Click to Pick Avatar </h1>
                <div class="image-wrapper">
                    <img src="${medium_avatar_list[currentIndex][2]}" class="overlayImage skin">
                    <img src="${medium_avatar_list[currentIndex][1]}" class="overlayImage mouth">
                    <img src="${medium_avatar_list[currentIndex][0]}" class="overlayImage eyes">
                </div>
            </div>
        `);
    }

    // event listener to check if the avatar is being clicked on
    $('.medium_choice').click(function(){
        // iterate through the list on click
        currentIndex = (currentIndex + 1) % medium_avatar_list.length;
        medium_changeEmoji(currentIndex);
    });

    function complex_changeEmoji(skIndex, mouIndex, eyIndex){
        // function to change the individual features of the emoji
        $('.complex_choice').html(`
            <div class="centered">
                <div class="image-wrapper">
                    <img src="${complex_avatar_list[2][skIndex]}" class="overlayImage skin">
                    <img src="${complex_avatar_list[1][mouIndex]}" class="overlayImage mouth">
                    <img src="${complex_avatar_list[0][eyIndex]}" class="overlayImage eyes">
                </div>
            </div>
            <button type="button" id="skin_button" class="btn btn-primary btn">Next Color</button>
            <button type="button" id="mouth_button" class="btn btn-primary btn">Next Mouth</button>
            <button type="button" id="eye_button" class="btn btn-primary btn">Next Eyes</button>
        `)
        
        // event listeners on each button to iterate through the list of features for each part
        // set an index for each features and update each individual one
        $('#skin_button').click(function(){
            skinIndex = (skinIndex + 1) % complex_avatar_list[2].length;
            complex_changeEmoji(skinIndex, mouthIndex, eyeIndex);
        });
    
        $('#mouth_button').click(function(){
            mouthIndex = (mouthIndex + 1) % complex_avatar_list[1].length;
            complex_changeEmoji(skinIndex, mouthIndex, eyeIndex);
        });
    
        $('#eye_button').click(function(){
            eyeIndex = (eyeIndex + 1) % complex_avatar_list[0].length;
            complex_changeEmoji(skinIndex, mouthIndex, eyeIndex);
        });
    }

    // event listener for the submission form
    $('#registration_form').submit(function(event) {
        // stop the default submit form behaviour
        event.preventDefault();
        
        const complexity = $('#avatar_complexity').val();
        
        // initialise an object to store the avatar configuration
        let avatar_config;
        // depending on the complexity, use the indexes to update the avatar_config object with the src of each img
        if (complexity === 'medium') {
            const currentAvatar = medium_avatar_list[currentIndex];
            avatar_config = {
                complexity: complexity,
                skin: currentAvatar[2],
                mouth: currentAvatar[1], 
                eyes: currentAvatar[0], 
            };
        } else if (complexity === 'complex') {
            avatar_config = {
                complexity: complexity,
                skin: complex_avatar_list[2][skinIndex],
                mouth: complex_avatar_list[1][mouthIndex],
                eyes: complex_avatar_list[0][eyeIndex], 
            };
        } else {
            avatar_config = {
                complexity: complexity,
                skin: simple_avatar_list[2],
                mouth: simple_avatar_list[1],
                eyes: simple_avatar_list[0]
            };
        }

        //save the avatar configuration in a cookie and then submit the form using javascript
        document.cookie = `avatar_config=${JSON.stringify(avatar_config)}; path=/; max-age=${86400 * 30};`;
        this.submit();

    });

});