<?php

if (htmlspecialchars($_POST['password1']) == htmlspecialchars($_POST['password2'])
        && htmlspecialchars($_POST['password1']) != ''){
    echo htmlspecialchars($_POST['firstName']) . PHP_EOL;
    echo htmlspecialchars($_POST['lastName']) . PHP_EOL;
    echo htmlspecialchars($_POST['username']) . PHP_EOL;
    echo htmlspecialchars($_POST['email']) . PHP_EOL;
    if (htmlspecialchars($_POST['check']) == 'on'){
        echo 'You turn ON checkbox';
    }
} else {
    echo "Wrong password!" . PHP_EOL;
}