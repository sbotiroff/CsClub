<?php
include APP_PATH . '/views/includes/head.php';

include APP_PATH . '/views/includes/header.php';
?>



<main class="full-main home">
    <section class="home-header animated ">
        <canvas id="c"></canvas>
        <h2 class="animated">
            Computer Science Club
        </h2>
    </section>
    <div class="top-bar"> 
<?php foreach($payload['announcements'] as $announcement){
    $timestamp = strtotime($announcement['timestamp']);
    $timestamp =  date('d F Y, h:i A',$timestamp);
    $title = $announcement['title'];
    echo"<div><h3> $title</h3>";
    echo"<p>$timestamp</p></div>";
}
?>
    </div>
    <div class="sub-main">
        <div class="allEvents">

            <!-- Upcoming events -->
            <div class="slideshow" data-aos="fade-up" data-aos-duration="1000">
                <h3>Upcoming Events</h3>
                <div id="slideshow-container">

                    <?php
$count = 1;
foreach ($payload['upcomingEvents'] as $upcomingevent) {
    $timestamp = strtotime($upcomingevent['timestamp']);
    $timestamp =  date('d F Y, h:i A',$timestamp);
    ?>
                    <div class="mySlides animated pulse">
                        <div class="slideNumberText"><?=$count?> / 3</div>
                        <div class="event-date">
                            <p><?=$timestamp?></p>
                        </div>
                        <img src="./public/images/events/<?=$count?>.jpeg" style="width:100%">
                        <div class="text">
                            <h2><?=$upcomingevent['title']?></h2>
                            <p><?=$upcomingevent['description']?></p>
                        </div>
                    </div>
                    <?php $count++;}?>
                    <a class="prevButton" onclick="plusSlides(-1)">&#10094;</a>
                    <a class="nextButton" onclick="plusSlides(1)">&#10095;</a>

                </div>

                <div style="text-align:center" class="dots-container">
                    <span class="slideDot" onclick="currentSlide(1)">1</span>
                    <span class="slideDot" onclick="currentSlide(2)">2</span>
                    <span class="slideDot" onclick="currentSlide(3)">3</span>
                </div>
            </div>

            <!-- ------------------------------------------------------------------------- -->

            <!-- past events -->
            <div class="past-slideshow" data-aos="fade-up" data-aos-duration="1000">
                <h3>Previous Events</h3>
                <div id="past-slideshow-container">

                    <?php
$pastEventCount = 1;
foreach ($payload['prevEvent'] as $pastEvent) {
    $timestamp = strtotime($pastEvent['timestamp']);
    $timestamp =  date('d F Y, h:i A',$timestamp);
    ?>
                    <div class="past-mySlides animated pulse">
                        <div class="past-slideNumberText"><?=$pastEventCount?> / 3</div>
                        <div class="past-event-date">
                            <p><?=$timestamp?></p>
                        </div>
                        <img src="./public/images/events/<?=$pastEventCount?>.jpeg" style="width:100%">
                        <div class="past-text">
                            <h2><?=$pastEvent['title']?></h2>
                            <p><?=$pastEvent['description']?></p>
                        </div>
                    </div>
                    <?php $pastEventCount++;}?>
                    <a class="past-prevButton" onclick="pastPlusSlides(-1)">&#10094;</a>
                    <a class="past-nextButton" onclick="pastPlusSlides(1)">&#10095;</a>

                </div>

                <div style="text-align:center" class="past-dots-container">
                    <span class="past-slideDot" onclick="pastCurrentSlide(1)">1</span>
                    <span class="past-slideDot" onclick="pastCurrentSlide(2)">2</span>
                    <span class="past-slideDot" onclick="pastCurrentSlide(3)">3</span>
                </div>
            </div>
        </div>

        <div class="event-calendar " data-aos="fade-up" data-aos-duration="1000">
            <h3>Event Calendar</h3>
            <div id="calendar"></div>
        </div>
    </div>



    <script>
    var slideIndex = 1;
    showSlides(slideIndex);

    function plusSlides(n) {
        showSlides(slideIndex += n);
    }

    function currentSlide(n) {
        showSlides(slideIndex = n);
    }

    function showSlides(n) {
        var i;
        var slides = document.getElementsByClassName("mySlides");
        var slideDots = document.getElementsByClassName("slideDot");
        if (n > slides.length) {
            slideIndex = 1
        }
        if (n < 1) {
            slideIndex = slides.length
        }
        for (i = 0; i < slides.length; i++) {
            slides[i].style.display = "none";
        }
        for (i = 0; i < slideDots.length; i++) {
            slideDots[i].className = slideDots[i].className.replace(" slideActive", "");
        }
        slides[slideIndex - 1].style.display = "block";
        slideDots[slideIndex - 1].className += " slideActive";
    }
    </script>

    <script>
    var slideIndex = 1;
    pastShowSlides(slideIndex);

    function pastPlusSlides(n) {
        pastShowSlides(slideIndex += n);
    }

    function pastCurrentSlide(n) {
        pastShowSlides(slideIndex = n);
    }

    function pastShowSlides(n) {
        var i;
        var slides = document.getElementsByClassName("past-mySlides");
        var slideDots = document.getElementsByClassName("past-slideDot");
        if (n > slides.length) {
            slideIndex = 1
        }
        if (n < 1) {
            slideIndex = slides.length
        }
        for (i = 0; i < slides.length; i++) {
            slides[i].style.display = "none";
        }
        for (i = 0; i < slideDots.length; i++) {
            slideDots[i].className = slideDots[i].className.replace(" past-slideActive", "");
        }
        slides[slideIndex - 1].style.display = "block";
        slideDots[slideIndex - 1].className += " past-slideActive";
    }
    </script>



</main>


<?php
// echo "<img src='data:image/*;base64," . $upcomingevent['image'] . "' width ='100px' />";
//getting calendar events data from db and creating new array to insert into the calendar
foreach ($payload['calendarEvents'] as $key) {
    // converting string to timestamp with millisecond ($date*1000)
    $date = strtotime($key['timestamp']);
    $date = $date * 1000;
    $newArray[] = array("title" => $key['title'], "date" => $date);
}
//converting array to json data
$upcomingEvents = json_encode($newArray);
?>

<script>
(function() {

    var c = document.getElementById("c"),
        ctx = c.getContext("2d");

    c.width = innerWidth;
    c.height = innerHeight;

    var lines = [],
        maxSpeed = 1,
        spacing = 5,
        xSpacing = 2,
        n = innerWidth / spacing,
        colors = ["#864A2B", "#79BD9A", "#A8DBA8", "#864A2B"],
        i;

    for (i = 0; i < n; i++) {
        xSpacing += spacing;
        lines.push({
            x: xSpacing,
            y: Math.round(Math.random() * c.height),
            width: 0.5,
            height: Math.round(Math.random() * (innerHeight / 30)),
            speed: Math.random() * maxSpeed + 1,
            color: colors[Math.floor(Math.random() * colors.length)]
        });
    }


    function draw() {
        var i;
        ctx.clearRect(0, 0, c.width, c.height);

        for (i = 0; i < n; i++) {
            ctx.fillStyle = lines[i].color;
            ctx.fillRect(lines[i].x, lines[i].y, lines[i].width, lines[i].height);
            lines[i].y += lines[i].speed;

            if (lines[i].y > c.height)
                lines[i].y = 0 - lines[i].height;
        }

        requestAnimationFrame(draw);

    }

    draw();

}());
</script>

<script src="./public/js/mini-event-calendar.min.js"></script>
<script>
var result = <?php if (isset($upcomingEvents)) {echo $upcomingEvents;} else {echo "0";}?>;
if (result != "0") {
    var db_events = result;
} else
    var db_events = [

    ]
$(document).ready(function() {
    $("#calendar").MEC({
        calendar_link: "",
        events: db_events
    });
    //calling animations
    AOS.init();



});
</script>

<?php
include APP_PATH . '/views/includes/footer.php';
?>