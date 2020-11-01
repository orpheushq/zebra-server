<?php
defined('BASEPATH') OR exit('No direct script access allowed');

include "templates/top.php";
?>
  <body>
    <div class="demo-layout mdl-layout mdl-js-layout mdl-layout--fixed-drawer mdl-layout--fixed-header">
      <header class="demo-header mdl-layout__header">
        <div class="mdl-layout__header-row">
          <span class="mdl-layout-title">Forms</span>
          <div class="mdl-layout-spacer"></div>
          <button class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon" id="hdrbtn">
            <i class="material-icons">more_vert</i>
          </button>
          <ul class="mdl-menu mdl-js-menu mdl-js-ripple-effect mdl-menu--bottom-right" for="hdrbtn">
            <li class="mdl-menu__item">About</li>
          </ul>
        </div>
        <div class="mdl-layout__tab-bar mdl-js-ripple-effect">
          <a href="#tab-individual-override" class="mdl-layout__tab is-active">Individual OT Override</a>
          <a href="#tab-employee-upload" class="mdl-layout__tab">Data Upload</a>
        </div>
      </header>
      <?php include 'templates/sidebar.php';?>
      <main class="mdl-layout__content mdl-color--grey-100">
        <section class="mdl-layout__tab-panel is-active mdl-grid mdl-grid--no-spacing" id="tab-individual-override">
            <div class="page-content">
              <?php include 'components/individualot_form.php'?>
            </div>
        </section>
        <section class="mdl-layout__tab-panel mdl-grid mdl-grid--no-spacing" id="tab-employee-upload">
            <div class="page-content">
              <?php include 'components/employeeupload_form.php'?>
            </div>
        </section>
      </main>
    </div>
    <script src="https://code.getmdl.io/1.3.0/material.min.js"></script>
    <script src="<?=base_url().'assets/js';?>/mdl-selectfield.min.js"></script>
  </body>
</html>
