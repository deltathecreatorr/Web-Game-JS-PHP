# Web-Game-JS-PHP
This game is an emoji matching game, where emojis are placed on the back of cards. The cards are matched in pairs, but can also be matched in 3s or 4s depending on the complexity.

- Navigation Bar (navbar.php)
    - Links to the home page and the game page.
    - Changes depending on whether the user is registered, can only see leaderboard and see avatar if registered.

- Landing Page (index.php)
    - Prompts the user to log in if not registered, otherwise the user is given a button to press that takes them to game screen.

- Registration Page (registration.php)
    - Takes user input and allows the user to pick the complexity level.
    - Also allows user to create their emoji depending on their complexity.

- Pairs Game (pairs.php)
    - Button to start the game.
    - Cards are generated and then shuffled.
    - Simple 
        - 6 cards, 3 pairs with each card having a card flip effect.
        - Score dependent on attempts.
    - Medium 
        - 10 cards, 5 pairs with each card having a card flip effect.
        - Getting a higher score is harder than simple.
        - Score dependent on attempts and time.
    - Complex 
        - 3 levels, 
            - First level has 6 cards. 
            - Second level has 12 cards. 
            - Third level has 18 cards.
        - Background of each level turns gold if the user beats their high score.
        - Score dependent on attempts and time.

- Leaderboard Page (leaderboard.php)
    - Has username and score displayed if the user had submitted their score from the game.
    - Score shows for each level and the total score if complexity = complex.
    - Score updates if score is better than last score.


