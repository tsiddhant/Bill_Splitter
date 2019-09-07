<?php include "includes/db.php"; ?>
<?php include "includes/admin_header.php"; ?>

<?php include "includes/admin_navigation.php"; ?>

<div class="container py-5">

    <div class="row text-center text-white mb-5">
        <div class="col-lg-8 mx-auto">
            <h1 class="display-4">Timeline</h1>
        </div>
        </div>


        <div class="row">
            <div class="col-lg-7 mx-auto">
                
                <ul class="timeline">
                    <li class="timeline-item bg-white rounded ml-3 p-4 shadow">
                        <div class="timeline-arrow"></div>
                        <h2 class="h5 mb-0">Title of section 1</h2><span class="small text-gray"><i class="fa fa-clock-o mr-1"></i>21 March, 2019</span>
                        <p class="text-small mt-2 font-weight-light">Event.</p>
                    </li>
                    <li class="timeline-item bg-white rounded ml-3 p-4 shadow">
                        <div class="timeline-arrow"></div>
                        <h2 class="h5 mb-0">Title of section 2</h2><span class="small text-gray"><i class="fa fa-clock-o mr-1"></i>5 April, 2019</span>
                        <p class="text-small mt-2 font-weight-light">Event</p>
                    </li>
                    <li class="timeline-item bg-white rounded ml-3 p-4 shadow">
                        <div class="timeline-arrow"></div>
                        <h2 class="h5 mb-0">Title of section 3</h2><span class="small text-gray"><i class="fa fa-clock-o mr-1"></i>18 August, 2019</span>
                        <p class="text-small mt-2 font-weight-light">Event.</p>
                    </li>
                    <li class="timeline-item bg-white rounded ml-3 p-4 shadow">
                        <div class="timeline-arrow"></div>
                        <h2 class="h5 mb-0">Title of section 4</h2><span class="small text-gray"><i class="fa fa-clock-o mr-1"></i>10 October, 2019</span>
                        <p class="text-small mt-2 font-weight-light">Event.</p>
                    </li>
                </ul>

            </div>
        </div>
    </div>


<style>

ul.timeline {
    list-style-type: none;
    position: relative;
    padding-left: 1.5rem;
}

ul.timeline:before {
    content: ' ';
    background: #fff;
    display: inline-block;
    position: absolute;
    left: 16px;
    width: 4px;
    height: 100%;
    z-index: 400;
    border-radius: 1rem;
}

li.timeline-item {
    margin: 20px 0;
}

.timeline-arrow {
    border-top: 0.5rem solid transparent;
    border-right: 0.5rem solid #fff;
    border-bottom: 0.5rem solid transparent;
    display: block;
    position: absolute;
    left: 2rem;
}

li.timeline-item::before {
    content: ' ';
    background: #ddd;
    display: inline-block;
    position: absolute;
    border-radius: 50%;
    border: 3px solid #fff;
    left: 11px;
    width: 14px;
    height: 14px;
    z-index: 400;
    box-shadow: 0 0 5px rgba(0, 0, 0, 0.2);
}


body {
    background: #E8CBC0;
    background: -webkit-linear-gradient(to right, #E8CBC0, #636FA4);
    background: linear-gradient(to right, #E8CBC0, #636FA4);
    min-height: 100vh;
}

.text-gray {
    color: #999;
}


</style>