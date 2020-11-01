<?php
defined('BASEPATH') OR exit('No direct script access allowed');

include "templates/top.php";
?>
  <body>
    <div class="demo-layout mdl-layout mdl-js-layout mdl-layout--fixed-drawer mdl-layout--fixed-header">
      <header class="demo-header mdl-layout__header">
        <div class="mdl-layout__header-row">
          <span class="mdl-layout-title">Attendance</span>
          <div class="mdl-layout-spacer"></div>
        </div>
      </header>
      <?php include 'templates/sidebar.php';?>
      <main class="mdl-layout__content mdl-color--grey-100" style="overflow: scroll">
        <table class="mdl-data-table mdl-js-data-table mdl-cell mdl-cell--12-col mdl-cell--1-col-phone">
          <thead>
              <tr>
                  <!--<th class="mdl-data-table__cell--non-numeric">Table Id</th>-->
                  <th class="mdl-data-table__cell--non-numeric">Full Name</th>
                  <th class="mdl-data-table__cell--non-numeric">Student ID</th>
                  <th class="mdl-data-table__cell--non-numeric">Date</th>
                  <th class="mdl-data-table__cell--non-numeric">Time</th>
              </tr>
          </thead>
          <tbody>
              {data}
                  <tr>
                      <!--<td>{id}</td>-->
                      <td class="mdl-data-table__cell--non-numeric">{fullname}</td>
                      <td class="mdl-data-table__cell--non-numeric">{swinId}</td>
                      <td class="mdl-data-table__cell--non-numeric">{date}</td>
                      <td class="mdl-data-table__cell--non-numeric">{time}</td>
                  </tr>
              {/data}
          </tbody>
        </table>
        <div class="mdl-cell mdl-cell--12-col mdl-cell--12-col-phone">
            {pagination}
        </div>
      </main>
    </div>
    <?php include "templates/bottom.php"; ?>
