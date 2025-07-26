<!DOCTYPE html>
<html>

<head>
    <style>
        @font-face {
            font-family: 'Arial';
            font-weight: normal;
            font-style: normal;
            font-variant: normal;
            font-size: 14px;
            src: "{{ base_path() }}/storage/fonts/arial.ttf" format("truetype");
        }

        @page {
            margin: 0px;
            padding: 0px;
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 14px;
            margin-left: 0px;
            margin-right: 25px;
        }

        hr {
            color: #F37720;
        }

        td {
            width: 50%;
            vertical-align: top
        }

        p {
            text-align: justify;
            margin: 0;
        }

        .details {
            margin: 0
        }

        .footer {
            position: fixed;
            bottom: 50px;
            font-size: 11px;
            text-align: center;
            margin-top: 3px;
        }

        .footerPos {
            position: fixed;
            bottom: 115;
        }

        .headerPos {
            position: fixed;
            top: 0;
            padding-bottom: 10px;
        }

        .footer>p {
            text-align: center;
            margin-top: 0px;
        }

        .terms {
            font-size: 13px;
            text-align: left;
            margin: 0;
        }

        .plus_total {
            text-align: right;
            margin: 0;
        }

        table {
            border-collapse: collapse;
        }

        table td,
        table th {
            padding-top: 0px solid white;
            padding-left: 20px solid white;
            padding-right: 20px solid white;
            padding-bottom: 0px solid white;

        }

        table tr:first-child th {
            padding-top: 0px;
        }

        table tr:last-child td {
            padding-bottom: 0px;
        }

        table tr td:first-child,
        table tr th:first-child {
            padding-left: 0px;
        }

        table tr td:last-child,
        table tr th:last-child {
            padding-right: 0px;
        }

        * {
            box-sizing: border-box;
        }

        .column {
            float: left;
            padding: 0px;
            margin: 0px;
            height: 100%;

        }

        .left {
            width: 6%;
            background-color: #f4883c;
            z-index: 2;
        }

        .right {
            width: 94%;
            height: 95%;
            padding-top: 30px;
            padding-left: 10px;
            padding-right: 80px;
            padding-bottom: 0px;

        }

        .row {
            clear: both;
            position: relative;
        }

        /* Clear floats after the columns */
        .imageHeader {
            margin: auto;
            width: 35%;
            margin-left: 30px;
        }

        .inner-border {
            border: 2px solid black;
            margin-left: 60px;
            padding: 10px;
        }

        .center {
            text-align: center;
        }

        .center img {
            display: block;
        }

        /** Define the header rules **/
        header {
            position: fixed;
            top: 0cm;
            left: 0cm;
            right: 0cm;
            height: 3cm;
        }

        /** Define the footer rules **/
        footer {
            position: fixed;
            bottom: 0cm;
            left: 0cm;
            right: 0cm;
            height: 2cm;
        }

        .services_table{
            margin-left: 25;
            width:100%; border: 1px solid #CCC;
            border-collapse: collapse;
            font-size:11px;

        }

        .services_table tr{
            padding: 5px;
            border: 1px solid #CCC;
            border-collapse: collapse;
        }

        .services_table td{
            border: 1px solid #CCC;
            border-collapse: collapse;
        }

        .td_services{
            padding: 5px;
        }

    </style>
</head>

<body>
    <?php

    //use CotizadorHDMX\Service;

    date_default_timezone_set("America/Mexico_City");
    setlocale(LC_TIME, 'es_MX');

    $page = 1;
    ?>
    <div class="row">
        <div class="column">
             <img style="width: 105%; height: 1122px;" src="{{ base_path() }}/public/images/pdf/coverpage.jpg">
        </div>
    </div>
    <div class="row">
        <div class="column">
            <img style="width: 105%; height: 1122px;" src="{{ base_path() }}/public/images/pdf/page1.jpg">
        </div>
    </div>
    <div class="row">
        <div class="column">
            <img style="width: 105%; height: 1122px;" src="{{ base_path() }}/public/images/pdf/page2.jpg">
        </div>
    </div>
    <div class="row">
        <div class="column">
            <img style="width: 105%; height: 1122px;" src="{{ base_path() }}/public/images/pdf/page3.jpg">
        </div>
    </div>
    <div class="row">
        <div class="column">
            <img style="width: 105%; height: 1122px;" src="{{ base_path() }}/public/images/pdf/page4.jpg">
        </div>
    </div>
    <!-- Let's calculate how many pages we are going to need according to how many rows the array of services has-->
    <?php
    const MAX_LINES_PER_PAGES = 45;
    $currentLinePage = 5;
    ?>
    <div class="row">
        <div class="column" style="width:100%;">
            <!-- HEADER -->
            <div class="row">
                <img style="width: 105%; padding: 0px;" src="{{ base_path() }}/public/images/pdf/headerCot.jpg" height="200px">
            </div>
            <p style="text-align: right; margin-right: 32px; margin-top:10px;">Guadalajara, Jalisco, México a
                {{ strftime('%e de %B del %Y') }}
            </p>
            <div style="margin-left: 60px; margin-right: 60px; margin-bottom:20px; margin-top:20px;">
                <p><strong>Con atención a:</strong> Daniel Martinez.</p>
                <hr style="width:100%;">
            </div>

            <div style="margin-left: 30px; margin-right: 60px;">
                <table class='services_table' style="width:100%;"  >
                    <tr style='padding:3px;background-color: #FFA500;   font-weight: bold; font-size: 13px;'>
                        <td align='center'>Servicio</td>
                        <td align='center'>Costo Base</td>
                        <td align='center'>Panel</td>
                        <td align='center'>Addons</td>
                        <td align='center'>Ciclo de Pago</td>
                        <td align='center'>Descuento</td>
                        <td align='center'>Importe</td>
                    </tr>
                        <?= $body ?>
                </table>

                <table style="width:100%; margin-top:20px; margin-left: 35px;"  >
                    <?= $conditions ?>
                </table>
            </div>
            <!-- FOOTER -->
            <div style="">
                <img style="position: absolute;
    bottom: 0px; left: 0;
width: 105%; padding: 0px;" src="{{ base_path() }}/public/images/pdf/footer_r.jpg">
            </div>
        </div>
        <!-- last new page  -->
        <div class="row">
            <div class="column">
                <p><img style="width: 105%; height: 700px;" src="{{ base_path() }}/public/images/pdf/Cotizador-pag06-01.jpg"></p>
                <br>
                <br>
                <br>
                <p style="margin:0;text-align:center;font-size:1em;"><b> Atentamente</b></p>
                <br>
                <br>
                <br>
                <p style="margin:0;text-align: center;"></p>
                <p style="margin:0;text-align: center;"></p>
                <br>
                <br>
                <br><br>
                <br>
                <img style="position: absolute;
    bottom: 0px; left: 0;
 width: 105%; height: 203px;margin: 0px" src="{{ base_path() }}/public/images/pdf/Cotizador-pag06-02.jpg">
            </div>
        </div>
</body>

</html>
