<?php
defined('BASEPATH') OR exit('No direct script access allowed');

include "templates/top.php";
?>
    <body>
        <div class="mdl-layout mdl-js-layout mdl-layout--fixed-header">
            <header class="demo-header mdl-layout__header">
                <div class="mdl-layout__header-row">
                <span class="mdl-layout-title">Login</span>
                <div class="mdl-layout-spacer"></div>
                </div>
            </header>
            <main class="mdl-layout__content mdl-color--white-100">
                <?php echo validation_errors(); ?>
                </php echo $status; ?>
                <div class="aligned" style="z-index: 9000">
                    <a href="#" class="shadowLink">
                        <img src='<?=base_url().'assets/images/512B.png';?>' >
                    </a>
                </div>
                <div class="aligned">
                    <img class="xspinner" src='<?=base_url().'assets/images/512Empty.png';?>' >
                </div>
                <div class="aligned" style="top: 55px;">
                    <img src='<?=base_url().'assets/images/handLogo.png';?>' width="90">
                </div>
                <div class="mdl-grid">
                    <div class="mdl-cell mdl-cell--5-col mdl-cell--5-offset-desktop mdl-cell--10-col-tablet">
                        <div style='display:block;height: 200px;width:200px;'></div>
                    </div>
                </div>
                <?php echo form_open('form/login'); ?>
                    <div class="mdl-grid">
                        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label mdl-cell mdl-cell--4-col mdl-cell--4-offset-desktop mdl-cell--10-col-tablet">
                            <input class="mdl-textfield__input" name="username" value="{username}" id='txtUsername' />
                            <label class="mdl-textfield__label" for="txtUsername">Username</label>
                        </div>
                        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label mdl-cell mdl-cell--4-col mdl-cell--4-offset-desktop mdl-cell--10-col-tablet">
                            <input class="mdl-textfield__input" type="password" name="password" value="{password}" id='txtPassword'>
                            <label class="mdl-textfield__label" for="txtPassword">Password</label>
                        </div>
                        <div class="mdl-cell mdl-cell--4-col mdl-cell--4-offset-desktop mdl-cell--10-col-tablet">
                            <input type="submit" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--colored mdl-cell--4-col mdl-cell--4-offset-desktop" value="Login" />
                        </div>

                        <?php if($e == "auth_fail"): ?>
                        <div class="mdl-cell mdl-cell--4-col mdl-cell--4-offset-desktop mdl-cell--10-col-tablet">
                            <p class="mdl-cell--9-col mdl-cell--2-offset-desktop login warn">Bad username/password combination</p>
                        </div>
                        <?php endif;?>

                        <?php if($e == "non_admin"): ?>
                        <div class="mdl-cell mdl-cell--4-col mdl-cell--4-offset-desktop mdl-cell--10-col-tablet">
                            <p class="mdl-cell--9-col mdl-cell--2-offset-desktop login warn">Only admin users can access the web portal</p>
                        </div>
                        <?php endif;?>
                    </div>
                </form>
            </main>
        </div>
        <script src="https://code.getmdl.io/1.3.0/material.min.js"></script>
    </body>
</html>