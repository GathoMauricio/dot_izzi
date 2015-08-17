<?php header('Access-Control-Allow-Origin: *'); ?>  

<div data-role="page">
    <div data-role="header" class="header" data-position="fixed" id="menu">
        <h1>Dot Redes Mobile</h1>
        <a href="#panel" id="abre_panel" class="panel-btn"></a>
    </div>

    <div data-role="panel" id="panel" data-position-fixed="true" data-position="left" data-display="overlay">
        <ul data-role="listview">
            <li data-icon="false">
                <a href="#" class="panel_li"  onclick="loadServicios();">
                    <span class="icon-list2"></span>
                    Servicios
                </a>
            </li>
            <li data-icon="false">
                <a href="#" class="panel_li"  onclick="loadPendientes();">
                    <span class="icon-list"></span>
                    Pendientes
                </a>
            </li>
            <li data-icon="false">
                <a href="#" class="panel_li"  onclick="loadUbicacion();">
                    <span class="icon-location2"></span>
                    Mi ubicación
                </a>
            </li>
            <li data-icon="false">
                <a href="#" class="panel_li"  onclick="">
                    <center>
                        <img src="img/logo.png" alt="Logo dot" width="120"/>
                    </center>
                </a>
            </li>
        </ul>
    </div>
</div>

<link rel="stylesheet" type="text/css" href="jquery/jquery.mobile.custom.structure.min.css">
<link rel="stylesheet" type="text/css" href="css/font.css">
<script type="text/javascript" charset="utf-8" src="jquery/jquery.mobile.custom.min.js"></script>