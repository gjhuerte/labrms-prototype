@extends('layouts.master-plain')
@section('title')
Laboratory Resource Management System
@stop
@section('style')
<style>
    #page-top{
        display: none;
    }
	.navbar-default{
		padding: 0;
		margin: 0;
	}
    header{
        background-image: url('{{ asset('images/header.jpg')  }}');
    }
</style>
@stop
@section('style-include')
    <!-- Custom Fonts -->
    <link href="{{ asset('css/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet" type="text/css">
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Merriweather:400,300,300italic,400italic,700,700italic,900,900italic' rel='stylesheet' type='text/css'>

    <!-- Plugin CSS -->
    <link href="{{ asset('css/magnific-popup/magnific-popup.css') }}" rel="stylesheet">

    <!-- Theme CSS -->
    <link href="{{ asset('css/creative.min.css') }}" rel="stylesheet">
@stop
@section('content')
    <nav id="mainNav" class="navbar navbar-default navbar-fixed-top">
        <div class="container-fluid">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span> Menu <i class="fa fa-bars"></i>
                </button>
                <a class="navbar-brand page-scroll" href="#page-top">LabRMS</a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav navbar-right">
                    <li>
                        <a class="page-scroll" href="#about">About</a>
                    </li>
                    <li>
                        <a class="page-scroll" href="#services">Services</a>
                    </li>
                    <li>
                        <a class="page-scroll" href="#portfolio">Features</a>
                    </li>
                    <li>
                        <a class="page-scroll" href="#contact">Contact</a>
                    </li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container-fluid -->
    </nav>

    <header>
        <div class="header-content">
            <div class="header-content-inner">
                <h1 id="homeHeading">Laboratory Resource Management System</h1>
                <hr>
                <p>A New Innovative System made for the Laboratory Operations Office of CCIS. Takes Reservation, Room  Scheduling and Item Management into a whole new level!</p>
                <a href="#about" class="btn btn-primary btn-xl page-scroll">Find Out More!</a>
            </div>
        </div>
    </header>

    <section class="bg-primary" id="about">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-lg-offset-2 text-center">
                    <h2 class="section-heading">We've got what you need!</h2>
                    <hr class="light">
                    <p class="text-faded">LabRMS has everything you need in order to start reserving an item and scheduling a room from CCIS - LOO. All items  under reservation are listed and ready for lending. Notification comes handy when checking reservation notice</p>
                    <a href="#services" class="page-scroll btn btn-default btn-xl sr-button">Get Started!</a>
                </div>
            </div>
        </div>
    </section>

    <section id="services">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h2 class="section-heading">At Your Service</h2>
                    <hr class="primary">
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-6 text-center">
                    <div class="service-box">
                        <i class="fa fa-4x fa-diamond text-primary sr-icons"></i>
                        <h3>Item Reservation</h3>
                        <p class="text-muted">Items for reservation are listed and ready for lending.</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 text-center">
                    <div class="service-box">
                        <i class="fa fa-4x fa-paper-plane text-primary sr-icons"></i>
                        <h3>Room Scheduling</h3>
                        <p class="text-muted">You can use this to check if a room is available for scheduling!</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 text-center">
                    <div class="service-box">
                        <i class="fa fa-4x fa-newspaper-o text-primary sr-icons"></i>
                        <h3>Complaints</h3>
                        <p class="text-muted">Just type your complaints and the staff will come at your aide.</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 text-center">
                    <div class="service-box">
                        <i class="fa fa-4x fa-heart text-primary sr-icons"></i>
                        <h3>Lost and Found</h3>
                        <p class="text-muted">Items under lost and found are posted in our site!</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="no-padding" id="portfolio">
        <div class="container-fluid">
            <div class="row no-gutter popup-gallery">
                <div class="col-lg-4 col-sm-6">
                    <a href="{{ asset('images/portfolio/fullsize/1.jpg') }}" class="portfolio-box">
                        <img src="{{ asset('images/portfolio/thumbnails/1.jpg') }}" class="img-responsive" alt="">
                        <div class="portfolio-box-caption">
                            <div class="portfolio-box-caption-content">
                                <div class="project-category text-faded">
                                    Item Reservation
                                </div>
                                <div class="project-name">
                                    Reservation
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-lg-4 col-sm-6">
                    <a href="{{ asset('images/portfolio/fullsize/2.jpg') }}" class="portfolio-box">
                        <img src="{{ asset('images/portfolio/thumbnails/2.jpg') }}" class="img-responsive" alt="">
                        <div class="portfolio-box-caption">
                            <div class="portfolio-box-caption-content">
                                <div class="project-category text-faded">
                                    Room Scheduling
                                </div>
                                <div class="project-name">
                                    Scheduling
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-lg-4 col-sm-6">
                    <a href="{{ asset('images/portfolio/fullsize/3.jpg') }}" class="portfolio-box">
                        <img src="{{ asset('images/portfolio/thumbnails/3.jpg') }}" class="img-responsive" alt="">
                        <div class="portfolio-box-caption">
                            <div class="portfolio-box-caption-content">
                                <div class="project-category text-faded">
                                    Complaints and Incidents
                                </div>
                                <div class="project-name">
                                    Ticketing
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-lg-4 col-sm-6">
                    <a href="{{ asset('images/portfolio/fullsize/4.jpg') }}" class="portfolio-box">
                        <img src="{{ asset('images/portfolio/thumbnails/4.jpg') }}" class="img-responsive" alt="">
                        <div class="portfolio-box-caption">
                            <div class="portfolio-box-caption-content">
                                <div class="project-category text-faded">
                                    Items Retrieved from Laboratories
                                </div>
                                <div class="project-name">
                                    Lost and Found
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-lg-4 col-sm-6">
                    <a href="{{ asset('images/portfolio/fullsize/5.jpg') }}" class="portfolio-box">
                        <img src="{{ asset('images/portfolio/thumbnails/5.jpg') }}" class="img-responsive" alt="">
                        <div class="portfolio-box-caption">
                            <div class="portfolio-box-caption-content">
                                <div class="project-category text-faded">
                                    Donation and Payment
                                </div>
                                <div class="project-name">
                                    Transaction
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-lg-4 col-sm-6">
                    <a href="{{ asset('images/portfolio/fullsize/6.jpg') }}" class="portfolio-box">
                        <img src="{{ asset('images/portfolio/thumbnails/6.jpg') }}" class="img-responsive" alt="">
                        <div class="portfolio-box-caption">
                            <div class="portfolio-box-caption-content">
                                <div class="project-category text-faded">
                                    Reservation and Scheduling Notice
                                </div>
                                <div class="project-name">
                                    Notification
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <aside class="bg-dark">
        <div class="container text-center">
            <div class="call-to-action">
                <h2>No account yet? Approach a personnel to create one for you.</h2>
                <a href="{{ url('login') }}" class="btn btn-default btn-xl sr-button">Login</a>
            </div>
        </div>
    </aside>

    <section id="contact">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-lg-offset-2 text-center">
                    <h2 class="section-heading">Let's Get In Touch!</h2>
                    <hr class="primary">
                    <p>Feedback and Suggestion? That's great! Give us a call or send us an email and we will get back to you as soon as possible!</p>
                </div>
                <div class="col-lg-4 col-lg-offset-2 text-center">
                    <i class="fa fa-phone fa-3x sr-contact"></i>
                    <p>xxx-xxx-xxxxx</p>
                </div>
                <div class="col-lg-4 text-center">
                    <i class="fa fa-envelope-o fa-3x sr-contact"></i>
                    <p><a href="mailto:labrms.ccis.loo@gmail.com">labrms.ccis.loo@gmail.com</a></p>
                </div>
            </div>
        </div>
    </section>
    <!-- Plugin JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js"></script>
    <script src="{{ asset('js/scrollreveal.min.js') }}"></script>
    <script src="{{ asset('js/jquery.magnific-popup.min.js') }}"></script>

    <!-- Theme JavaScript -->
    <script src="{{ asset('js/creative.min.js') }}"></script>
@stop
@section('script-include')
<script>
    $(document).ready(function(){
        $('#page-top').fadeIn(400);
    });
</script>
@stop