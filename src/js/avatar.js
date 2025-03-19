$(document).ready(function() {

    let currentIndex = 0;
    let skinIndex = 0;
    let mouthIndex = 0;
    let eyeIndex = 0;

    $(".avatar_section").hide();

    $('#avatar_complexity').change(function() {
        var avatar = $(this).val();

 
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

    $('#avatar_complexity').trigger('change')


    function medium_changeEmoji(currentIndex){
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

    $('.medium_choice').click(function(){
        currentIndex = (currentIndex + 1) % medium_avatar_list.length;
        medium_changeEmoji(currentIndex);
    });

    function complex_changeEmoji(skIndex, mouIndex, eyIndex){
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

    $('#registration_form').submit(function(event) {
        event.preventDefault();
    
        const complexity = $('#avatar_complexity').val();
    
        let avatar_config;
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

        document.cookie = `avatar_config=${JSON.stringify(avatar_config)}; path=/; max-age=${86400 * 30};`;
        this.submit();

    });

});