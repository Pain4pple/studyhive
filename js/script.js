   
    const upvoteCounter = document.getElementById("upvote-count");
    const upvoteCounterInt = parseInt(document.getElementById("upvote-count").innerHTML);
    const upvoteBtn = document.getElementById("upvote");
    const upvoteSVG = document.getElementById("upvote-svg");
    const downvoteBtn = document.getElementById("downvote");
    const downvoteSVG = document.getElementById("downvote-svg");
    upvoteBtn.onclick = function(){

        upvoteSVG.style.fill="#8BC34A";
        downvoteSVG.style.fill="#6C6C6C";
        upvoteCounter.style.color="#8BC34A";
        upvoteCounter.innerHTML = upvoteCounterInt + 1;
    }

    downvoteBtn.onclick = function(){
        downvoteSVG.style.fill="#bc6641";
        upvoteSVG.style.fill="#6C6C6C";
        upvoteCounter.style.color="#bc6641";
        upvoteCounter.innerHTML = upvoteCounterInt - 1;
    }