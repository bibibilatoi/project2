<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="description" content="Do you want to work in a company that not only pays you well but also helps you grow. Well, welcome to SpeedX - the best IT and tech company in the universe">
        <meta name="keywords" content="HTML5, tags">
        <meta name="author" content="a group of students">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Exo+2">

        <link href="styles/common_styles.css" rel="stylesheet">
        <link href="styles/index_styles.css" rel="stylesheet">

        <title>Home Page</title>
    </head>

    <body>

        <?php include("header.inc") ?>
        <main id="index-main">
            <section id="index-intro">
                <h1>Welcome to SpeedX</h1>
                <p>
                    Founded in <strong>2050</strong>, SpeedX has been pioneering the future of space travel
                    for over <strong>75 years</strong>. What began as small team of engineers dreaming beyond Earth's horizon
                    has grown into a global leader in aerospace innovation.
                </p>
            </section>

            <section id="index-achievements">
                <h1>Our Achievements</h1>

                <section class="achievement-2060">
                    <p class="achievement-text">
                        <strong>2060</strong> - Launched the first reusable interplanetary shuttle.
                    </p>
                    <figure id="index-shuttle" class="achievement-figure">
                        <img alt="Reusable interplanetary shuttle" src="images/Space_Shuttle_Columbia_launching_cropped_2.jpg">
                        <figcaption>Our interplanetary shuttle</figcaption>
                    </figure>
                </section>

                <section class="achievement-2075">
                    <p class="achievement-text">
                        <strong>2075</strong> - Established the first lunar research base.
                    </p>
                    <figure id="index-research-base" class="achievement-figure">
                        <img alt="China research base" src="images/China-research-base.jpg">
                        <figcaption>Our research base</figcaption>
                    </figure>

                </section>

                <section class="achievement-2110">
                    <p class="achievement-text">
                        <strong>2110</strong> - Built the SpeedX Orbital City for civilian life orbit.
                    </p>
                    <figure id="index-orbital-cities" class="achievement-figure">
                        <img alt="Orbital cities" src="images/orbital-cities.jpg">
                        <figcaption>Our Orbital cities</figcaption>
                    </figure>
                </section>
            </section>

            <em id="index-aspiration">
                Today, SpeedX continues to push the boundaries of human innovation, connecting worlds and inspiration
                to look to the stars.
            </em>

            <section id="index-our-people">
                <h1 class="section-heading">Our People</h1>
                <p>
                    At SpeedX, we are more than engineers and scientists, astronauts, and scientists.
                </p>
                <p>
                    We are dreamers and builders who share one vision is to push technology beyond the limits of space.
                </p>
                <p>
                    From fresh graduates full of ambition to experienced aerospace veterans, everyone here contributes to
                    a common mission - is shaping the future among the stars.
                </p>
                <p>
                    The reason our people choose SpeedX is about a place where creativity is encouraged, ideas are valued, and passion drives innovation.
                    Every project is a new journey, and every jouney brings us one step closer to redefining humanity's in the universe.
                </p>
            </section>

            <section id="index-our-brilliant-minds">
                <h1 class="section-heading">Our Brilliant Minds</h1>

                <p>
                    Behind every successful mission at SpeedX the decication and genius of our software engineers.
                    They are the ones who turn imnagination into reality, building the codes that guide our rockets across the stars
                </p>

                <div class="engineer-row">
                    <p id="Daniel-Kross" class="engineer-profile">
                        <strong>Daniel Kross</strong>, the lead programmer who developed our "Astra Flight System". This is a navigation algorithm capable of calculating
                        interplanetary trajectories in real time. His work has reduced launch errors by 80% and set a new standard for deep space missions.
                    </p>
                    <figure id="astra-flight" class="engineer-figure">
                        <img alt="astra flight" src="images/Astra-flight.jpg">
                        <figcaption>Rocket powered by Astra flight system.</figcaption>
                    </figure>
                </div>

                <div class="engineer-row">
                    <p id="Leila-Tango" class="engineer-profile">
                        <strong>Leila Tango</strong>, she is a system architect who is known for designing the communication interface that allows
                        our spacecraft to send and receive data even millions of kilometers away from the Earth. Her code keeps every astronaut connected, no matter how far they travel.
                    </p>
                    <figure id="Space-communication-interfaces" class="engineer-figure">
                        <img alt="Space communication interfaces" src="images/Space-communication-interfaces.jpg">
                        <figcaption>Our futuristic communication interface technology</figcaption>
                    </figure>
                </div>

                <div class="engineer-row">
                    <p id="Kenji-Itoma" class="engineer-profile">
                        <strong>Kenji Itoma</strong>, one of our early developers, wrote the original "Cosmo Core". It is the software that simulates rocket behavior under zero gravity conditions.
                        This breakthrough helped SpeedX cut testing time in half and paved the way for our first successful Mars landing.
                    </p>
                    <figure id="cosmo-core" class="engineer-figure">
                        <img alt="cosmo core" src="images/cosmos-core.png">
                        <figcaption>Cosmo core application review</figcaption>
                    </figure>
                </div>


                <section id="index-our-brilliant-minds-together">
                    <em>
                        Together, these programmers form the digital backbone SpeedX, ensuring that every
                        mission is not only flies, but flies smarter. Their innovations remind us that sometimes, the most powerful engines are made of coding.
                    </em>
                </section>
            </section>

            <section id="Why-work-with-us">
                <h1 class="section-heading">Why Work With Us</h1>
                <ul>
                    <li class="work-with-us-item work-with-us-item--left">"A dynamic and inspiring work environment where ideas come to life."</li>
                    <li class="work-with-us-item work-with-us-item--right">"Access to cutting-edge aerospace technologies and research facilities."</li>
                    <li class="work-with-us-item work-with-us-item--left">"Continuous professional growth through hands-on projects and mentorship."</li>
                    <li class="work-with-us-item work-with-us-item--right">"Competitive benefits that support both career and personal well-being."</li>
                    <li class="work-with-us-item work-with-us-item--left">"Opportunities to collaborate with some of the brightest minds in space innovation."</li>
                </ul>

                <figure id="workplace-img-container">
                    <img alt="speedX workplace picture" src="images/good-workplace.jpg">
                    <figcaption>All of us, working as one.</figcaption>
                </figure>
            </section>

        </main>
        <?php include("footer.inc") ?>
    </body>
</html>

<!-- all sources
Banner:
https://worldspacefoundation.org/space/
Colombia lauchings.
https://www.thecivilengineer.org/news/china-to-construct-a-research-base-on-the-moon
https://maxpolyakov.com/futuristic-space-structures-orbital-cities/
https://www.theverge.com/2022/2/10/22922010/astra-launch-failure-cape-canaveral-florida-nasa-elana-41
https://www.researchgate.net/publication/272418376_New_Gateway_to_Space_for_Small_Satellites_by_the_Hawaii_Space_Flight_Laboratory
https://www.space.com/5926-nasa-50-shuttle-space-station.html
https://www.google.com/url?sa=i&url=https%3A%2F%2Fwww.vecteezy.com%2Ffree-vector%2Fsci-fi-hud-layout%3Fpage%3D3&psig=AOvVaw2pdvEKDM_U9AGZOSu86ewg&ust=1760345731183000&source=images&cd=vfe&opi=89978449&ved=0CBEQjRxqFwoTCPC29oGlnpADFQAAAAAdAAAAABAQ

our logo is made by ChatGPT

Font: google font Exo 2: https://fonts.google.com/specimen/Exo+2
-->
