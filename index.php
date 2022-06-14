<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>What A Review</title>
    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
    <!-- Bootstrap icons-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" type="text/css" />
    <!-- Google fonts-->
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,300italic,400italic,700italic" rel="stylesheet" type="text/css" />
    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="css/styles.css" rel="stylesheet" />

    <!-- Bootstrap core CSS -->
    <link rel="canonical" href="https://getbootstrap.com/docs/5.1/examples/features/">

    <script src='https://code.jquery.com/jquery-3.1.1.min.js'></script>



</head>

<body>
    <!-- Navigation-->
    <nav class="navbar navbar-light bg-light static-top">
        <div class="container">
            <a class="navbar-brand" href="#!">What A Review!</a>
            <a class="btn btn-primary" href="#writeReview">Write A Review</a>
        </div>
    </nav>

    <main class="container" id="writeReview">
        <div class="bg-light p-5 mt-5 rounded">
            <h2>Type Your Review Here</h2>
            <p class="lead">Once you type your review, click the submit button to perform text-summarization and sarcasm detection.</p>
            <textarea name="message" id="message" style="width:100%" rows="11"></textarea>
            <button onclick="summarizeReview()" class="btn btn-primary">Submit</button>
        </div>
    </main>

    <main class="container">
        <div class="row m-1">
            <div class="bg-light p-5 mt-4 rounded col-md-7">
                <h2>Summary of the text you typed</h2>
                <p class="lead">This is not the actual summary. This is based on NLP algorithms. So there can be mistakes.</p>
                <textarea disabled id="summarizedReview" style="width:100%;" rows="10" placeholder="Please enter your review."></textarea>
            </div>
            <div class="bg-light p-5 mt-4 rounded col-md-5">
                <h2>Sarcasm Detector</h2>
                <p id="sarcasmDetectedTitle">This detector is based on Machine Learning algorithms. Therefore, the prediction would not be 100% accurate.</p>
                <button disabled class="btn-success" id="sarcasmDetectedButton" style="width:100%;height:auto">Please enter your review.</button>
                <br><br>
                <h2>Our Rating For Your Review</h2>
                <p>This rating is based on Machine Learning algorithms. Therefore, the prediction would not be 100% accurate.</p>
                <h4 id="ratingDetected" style="border: 1px rgb(179, 179, 179) solid;">No Review Posted Yet!</h4>
            </div>
        </div>
    </main>



    <script>
        async function summarizeReview() {
            let summarizedReview = await sendReviewToSummarize();
            var textSum = document.getElementById("message").value;
            if (summarizedReview.length == 0) {
                document.getElementById("summarizedReview").innerHTML = "Your review is too small to be summarized.";
            } else {
                document.getElementById("summarizedReview").innerHTML = summarizedReview;
            }

            console.log(summarizedReview)
            detectSarcasm();
            getRating();
        }


        async function sendReviewToSummarize() {
            var actualReview = document.getElementById("message").value;
            let url = 'http://127.0.0.1:8000/summarize/';
            try {
                let res = await fetch(url + actualReview);
                return await res.json();
            } catch (error) {
                console.log(error);
            }
        }


        //sarcasm detection
        async function sendReview() {
            var actualReview = document.getElementById("message").value;
            let url = 'http://127.0.0.1:8000/detectSarcasm/';
            try {
                let res = await fetch(url + actualReview);
                return await res.json();
            } catch (error) {
                console.log(error);
            }
        }

        async function detectSarcasm() {
            let sarcasmIdentifier = await sendReview();
            if (sarcasmIdentifier == "It's a sarcasm!") {
                $("#sarcasmDetectedButton").html("Sarcasm Detected");
                $("#sarcasmDetectedButton").removeClass('btn-success').addClass('btn-warning');
            } else {
                $("#sarcasmDetectedButton").html("Sarcasm Not Detected");
                $("#sarcasmDetectedButton").removeClass('btn-warning').addClass('btn-success');
            }
            console.log(sarcasmIdentifier)
        }


        //rating calculation
        async function sendReviewToGetRating() {
            var actualReview = document.getElementById("message").value;
            let url = 'http://127.0.0.1:8000/getRating/';
            try {
                let res = await fetch(url + actualReview);
                return await res.json();
            } catch (error) {
                console.log(error);
            }
        }

        async function getRating() {
            let ratingGenerated = await sendReviewToGetRating();
            console.log(ratingGenerated)
            document.getElementById("ratingDetected").innerHTML = ratingGenerated;
        }
    </script>
</body>

</html>