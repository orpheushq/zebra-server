<?php
defined('BASEPATH') OR exit('No direct script access allowed');

include "templates/top.php";
?>
  <body>
    <div class="demo-layout mdl-layout mdl-js-layout mdl-layout--fixed-drawer mdl-layout--fixed-header">
      <header class="demo-header mdl-layout__header">
        <div class="mdl-layout__header-row">
          <span class="mdl-layout-title">Info</span>
          <div class="mdl-layout-spacer"></div>
          <button class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon" id="hdrbtn">
            <i class="material-icons">more_vert</i>
          </button>
          <ul class="mdl-menu mdl-js-menu mdl-js-ripple-effect mdl-menu--bottom-right" for="hdrbtn">
            <li class="mdl-menu__item">About</li>
          </ul>
        </div>
      </header>
      <?php include 'templates/sidebar.php';?>
      <main class="mdl-layout__content mdl-color--grey-100">
        <div class="mdl-cell  mdl-cell--12-col mdl-cell--1-col-phon">
          <?php echo $error; ?>
        </div>
      </main>
    </div>
    <?php include 'templates/bottom.php'; ?>