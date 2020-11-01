<?php
defined('BASEPATH') OR exit('No direct script access allowed');

include "templates/top.php";
?>
  <body>
    <div class="demo-layout mdl-layout mdl-js-layout mdl-layout--fixed-drawer mdl-layout--fixed-header">
      <header class="demo-header mdl-layout__header">
        <div class="mdl-layout__header-row">
          <span class="mdl-layout-title">Sample</span>
          <div class="mdl-layout-spacer"></div>
        </div>
      </header>
      <?php include 'templates/sidebar.php';?>
      <main class="mdl-layout__content mdl-color--grey-100">
      

      </main>
    </div>
    <?php include 'templates/about_dialog.php'; ?>
    <script src="https://code.getmdl.io/1.3.0/material.min.js"></script>
    <script src="<?=base_url().'assets/js';?>/mdl-selectfield.min.js"></script>
  </body>
</html>
