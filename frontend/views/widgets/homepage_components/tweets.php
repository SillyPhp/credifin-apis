<section class="j-tweets">
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-sm-6">
                <h1 class="heading-style" id="tweetHeading">Tweets</h1>
            </div>
            <div class="col-md-6 col-sm-6">
                <div class="tweetLinks">
                    <a href="/tweets/jobs" id="tweetAllLink">View All</a>
                    <a href="/tweets/job/create" id="tweetPostLink">Post Tweet</a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="tweet-btn">
                    <button type="button" id="jobtweet" onclick="jobTweet()">Jobs</button>
                    /
                    <button type="button" id="interntweet" onclick="internTweet()">Internships</button>
                </div>
            </div>
        </div>
        <?=
        $this->render('/widgets/twitter-masonry', [
            'tweets' => $tweets
        ]);
        ?>
<!--        --><?//=
//        $this->render('/widgets/preloaders/tweet-job-preloader');
//        ?>
    </div>
</section>
<script>
    var twitterTweets = document.querySelectorAll('.twitter-cards');
    const settings = {
        jobs: {
            color: "#00a0e3",
            title: "Job Tweets",
            viewAllLink: "/tweets/jobs",
            postLink: "/tweets/job/create"
        },
        internships: {
            color: "#00a0e3",
            title: "Internship Tweets",
            viewAllLink: "/tweets/internships",
            postLink: "/tweets/internship/create"
        }
    };

    function jobTweet() {
        document.getElementById('jobtweet').style.color = "#00a0e3";
        document.getElementById('interntweet').style.color = "#000";
        document.getElementById('tweetHeading').innerHTML = "Job Tweets";
        document.getElementById('tweetAllLink').href = "/tweets/jobs";
        document.getElementById('tweetPostLink').href = "/tweets/job/create";

        for (var i = 0; i < twitterTweets.length; i++) {
            if (twitterTweets[i].getAttribute('data-id') == "Internships") {
                twitterTweets[i].style.display = "none";
            } else if (twitterTweets[i].getAttribute('data-id') == "Jobs") {
                twitterTweets[i].style.display = "block";
            }
        }
    }

    function internTweet() {
        document.getElementById('interntweet').style.color = "#00a0e3";
        document.getElementById('jobtweet').style.color = "#000";
        document.getElementById('tweetHeading').innerHTML = "Internship Tweets";
        document.getElementById('tweetAllLink').href = "/tweets/internships";
        document.getElementById('tweetPostLink').href = "/tweets/internship/create";

        for (var i = 0; i < twitterTweets.length; i++) {
            if (twitterTweets[i].getAttribute('data-id') == "Jobs") {
                twitterTweets[i].style.display = "none";
            } else if (twitterTweets[i].getAttribute('data-id') == "Internships") {
                twitterTweets[i].style.display = "block";
            }
        }
    }
    // window.onload = function () {
        jobTweet();
    // }
</script>