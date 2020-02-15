<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>EZ-Timesheet Manager - My Account</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
        <link rel = "stylesheet" type="text/css" href ="css/main.css">
        <script src="/js/super.js"></script>
        <!--<script src="/js/user.js"></script>-->
        <!-- Styles -->
    </head>
    <body>
        <header >
            <div class="container block">
                <div id="page-title" class="block left">
                    <h1 >EZ-Timesheet Manager</h1>
                </div>
                <div class="block right">
                    <nav>
                        <a class="accountLinks" disabled>{{$empname or "Guest"}}</a>
                        <a class="accountLinks"><button class="messagesbutton" id="msgbtn"></button></a>
                        <a href="{{ route('logout') }}" class="accountLinks">Log Out</a>
                    </nav>
                </div>
            </div>
        </header>

        <div id="menudiv">
            <div class="container block">
                
                <div class="navbuttons" id="totals-button" ><p>Week Totals</p></div>
                <div class="navbuttons dropdown" ><p >Time sheets</p><div class="dropdown-content" ><p id="view-emp-ts-opt">View timesheets</p><p id="search-timesheet-opt">Search visit</p><p id="ur-date-btn">Restrict uploads</p></div></div>
                <div class="navbuttons dropdown" id="employees-button" ><p >Employees</p><div id="empdropdown" class="dropdown-content" ><p id="search-emp-btn">Search</p><p id="new-employee">Add New</p></div></div>
                <div class="navbuttons dropdown" id="location-button" ><p >Location</p><div id="locdropdown" class="dropdown-content" ><p id="search-locs-btn">Search</p><p id="new-location">Add Location</p></div></div>
                <div class="navbuttons dropdown" id="patients-button" ><p >Patients</p><div id="ptdropdown" class="dropdown-content" ><p id="search-pt-btn">Search</p><p id="new-patient">Add New</p></div></div>
                <div class="navbuttons dropdown" id="schedule-button" ><p >Schedules</p><div id="schdropdown" class="dropdown-content" ><p id="schedule-btn">Search</p><p id="schedreportbtn">Schedule Report</p><p id="add-sch-btn">Add New</p></div></div>
                <div class="navbuttons messagesbutton" id="messages-button"><p>Messages</p></div>
                <!--
                <div class="navbuttons" id="timesheet-button"><p>Time sheets</p></div>
                <div class="navbuttons" id="visits-button"><p>Review Time sheets</p></div>
                <div class="navbuttons messagesbutton" id="messages-button"><p>Messages</p></div>
                -->
            </div>
        </div>
        <div class="options container" id="options-section"></div>
        <div class="content container" id="main-content">
        @if(Session::has('message'))
            <p class="message" >{{ Session::get('message') }}</p>
        @endif
        </div>

        <footer id="footer-div">
            <p>&copy; 2014 - <span id="current-year" ><script >document.getElementById("current-year").innerHTML= new Date().getFullYear();</script></span> All rights reserved. </p>
        </footer>
    </body>
</html>
