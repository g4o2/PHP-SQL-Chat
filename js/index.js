particlesJS.load('particles-js', './particles/particles.json', function() {
    console.log('callback - particles.js config loaded');
});
$(document).ready(function() {

    console.log('%c Why are you here in the console?', 'background: #000; color: #ffa500');
    console.log('%c Dont try anything sus', 'background: #000; color: #ffa500');
    console.log("%c                                      \n    .->                .->            \n ,---(`-')   .---.(`-')----.  .----.  \n'  .-(OO )  / .  |( OO).-.  '\\_,-.  | \n|  | .-, \\ / /|  |( _) | |  |   .' .' \n|  | '.(_// '-'  ||\\|  |)|  | .'  /_  \n|  '-'  | `---|  |' '  '-'  '|      | \n `-----'      `--'   `-----' `------' ", 'background: #000; color: #ffa500')

    setTimeout(function() {
        document.querySelector('.popup-msg').style.display = "none";
    }, 2200);
})

function closeProfile() {
    document.getElementById("profile").style.opacity = '0';
    document.getElementById("close-btn").style.opacity = '0';
    document.getElementById("close-btn-two").style.opacity = '1';
}

function openProfile() {
    document.getElementById("profile").style.opacity = '1';
    document.getElementById("close-btn").style.opacity = '1';
    document.getElementById("close-btn-two").style.opacity = '0';
}
