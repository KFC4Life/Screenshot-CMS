<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ env('APP_NAME') }}</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <style>
        body {
            background: #AFDCEB;
        }

        .camera {
            width: 500px;
            height: 500px;
            overflow: hidden;
            background: #fff;
            margin: 100px auto;
            -moz-border-radius: 20%;
            -webkit-border-radius: 20%;
            border-radius: 20%;
            position: relative;
            -moz-box-shadow: #ddd 0px 6px 10px;
            -webkit-box-shadow: #ddd 0px 6px 10px;
            box-shadow: #ddd 0px 6px 10px;
        }
        .camera .one {
            background: #afdceb;
            width: 75%;
            height: 75%;
            margin-left: -37.5%;
            margin-top: -37.5%;
            position: absolute;
            left: 50%;
            top: 50%;
            background: #fff;
            -moz-box-shadow: #eee 0px 10px 10px;
            -webkit-box-shadow: #eee 0px 10px 10px;
            box-shadow: #eee 0px 10px 10px;
            -moz-transition-property: all;
            -o-transition-property: all;
            -webkit-transition-property: all;
            transition-property: all;
            -moz-transition-duration: 1s;
            -o-transition-duration: 1s;
            -webkit-transition-duration: 1s;
            transition-duration: 1s;
        }
        .camera .two {
            background: #afdceb;
            width: 70%;
            height: 70%;
            margin-left: -35%;
            margin-top: -35%;
            position: absolute;
            left: 50%;
            top: 50%;
        }
        .camera .three {
            background: #86cae1;
            width: 50%;
            height: 50%;
            margin-left: -25%;
            margin-top: -25%;
            position: absolute;
            left: 50%;
            top: 50%;
        }
        .camera .four {
            background: #1a5468;
            width: 45%;
            height: 45%;
            margin-left: -22.5%;
            margin-top: -22.5%;
            position: absolute;
            left: 50%;
            top: 50%;
        }
        .camera .five {
            background: #154453;
            width: 30%;
            height: 30%;
            margin-left: -15%;
            margin-top: -15%;
            position: absolute;
            left: 50%;
            top: 50%;
            -moz-transition-property: all;
            -o-transition-property: all;
            -webkit-transition-property: all;
            transition-property: all;
            -moz-transition-duration: 1s;
            -o-transition-duration: 1s;
            -webkit-transition-duration: 1s;
            transition-duration: 1s;
        }
        .camera .six {
            background: #174a5b;
            width: 28.75%;
            height: 28.75%;
            margin-left: -14.375%;
            margin-top: -14.375%;
            position: absolute;
            left: 50%;
            top: 50%;
        }
        .camera .seven {
            background: #0b222a;
            width: 17.5%;
            height: 17.5%;
            margin-left: -8.75%;
            margin-top: -8.75%;
            position: absolute;
            left: 50%;
            top: 50%;
            -moz-transition-property: all;
            -o-transition-property: all;
            -webkit-transition-property: all;
            transition-property: all;
            -moz-transition-duration: 1s;
            -o-transition-duration: 1s;
            -webkit-transition-duration: 1s;
            transition-duration: 1s;
        }
        .camera .eight {
            background: #5db8d7;
            width: 1.5%;
            height: 1.5%;
            margin-left: -0.75%;
            margin-top: -0.75%;
            position: absolute;
            left: 50%;
            top: 50%;
            top: 51%;
            left: 45%;
        }
        .camera .nine {
            background: #1f657c;
            width: 4%;
            height: 4%;
            margin-left: -2%;
            margin-top: -2%;
            position: absolute;
            left: 50%;
            top: 50%;
            top: 48%;
            left: 54%;
        }
        .camera .ten {
            background: #1f657c;
            width: 4%;
            height: 4%;
            margin-left: -2%;
            margin-top: -2%;
            position: absolute;
            left: 50%;
            top: 50%;
            background: #ca0000;
            top: 89%;
            left: 89%;
            -moz-transition-property: all;
            -o-transition-property: all;
            -webkit-transition-property: all;
            transition-property: all;
            -moz-transition-duration: 1s;
            -o-transition-duration: 1s;
            -webkit-transition-duration: 1s;
            transition-duration: 1s;
        }
        .camera .line {
            -moz-transform: rotate(-45deg);
            -ms-transform: rotate(-45deg);
            -webkit-transform: rotate(-45deg);
            transform: rotate(-45deg);
            height: 90%;
            width: 40%;
            margin-top: 20%;
            margin-left: 18%;
            position: absolute;
            background-color: rgba(255, 255, 255, 0.2);
            z-index: 10;
            -moz-transition-property: margin-top, margin-left;
            -o-transition-property: margin-top, margin-left;
            -webkit-transition-property: margin-top, margin-left;
            transition-property: margin-top, margin-left;
            -moz-transition-duration: 1s;
            -o-transition-duration: 1s;
            -webkit-transition-duration: 1s;
            transition-duration: 1s;
        }
        .camera .circle {
            -moz-border-radius: 400px;
            -webkit-border-radius: 400px;
            border-radius: 400px;
        }
        .camera:hover {
            -moz-box-shadow: #ddd 6px 0px 10px;
            -webkit-box-shadow: #ddd 6px 0px 10px;
            box-shadow: #ddd 6px 0px 10px;
        }
        .camera:hover .one {
            background: #afdceb;
            width: 82%;
            height: 82%;
            margin-left: -41%;
            margin-top: -41%;
            position: absolute;
            left: 50%;
            top: 50%;
            background: #fff;
            -moz-box-shadow: #eee 10px 0px 10px;
            -webkit-box-shadow: #eee 10px 0px 10px;
            box-shadow: #eee 10px 0px 10px;
        }
        .camera:hover .five {
            background: #1a5468;
            width: 35%;
            height: 35%;
            margin-left: -17.5%;
            margin-top: -17.5%;
            position: absolute;
            left: 50%;
            top: 50%;
        }
        .camera:hover .seven {
            background: #0b222a;
            width: 25%;
            height: 25%;
            margin-left: -12.5%;
            margin-top: -12.5%;
            position: absolute;
            left: 50%;
            top: 50%;
        }
        .camera:hover .ten {
            background: green;
        }
        .camera:hover .line {
            -moz-transform: rotate(135deg);
            -ms-transform: rotate(135deg);
            -webkit-transform: rotate(135deg);
            transform: rotate(135deg);
            margin-top: -10%;
            margin-left: 47%;
            position: absolute;
            background-color: rgba(255, 255, 255, 0.2);
            z-index: 10;
        }

    </style>
</head>
<body>
<div class="camera">
    <div class="circle one"></div>
    <div class="circle two"></div>
    <div class="circle three"></div>
    <div class="circle four"></div>
    <div class="circle five"></div>
    <div class="circle six"></div>
    <div class="circle seven"></div>
    <div class="circle eight"></div>
    <div class="circle nine"></div>
    <div class="circle ten"></div>
    <div class="line"></div>
</div>
</html>
