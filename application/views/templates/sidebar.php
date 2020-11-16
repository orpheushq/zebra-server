      <div class="demo-drawer mdl-layout__drawer">
        <header class="demo-drawer-header mdl-color--blue-900 mdl-color-text--deep-purple-50">
          <div class="demo-avatar-dropdown">
            <span><?=$username;?></span>
            <div class="mdl-layout-spacer"></div>
            <button id="accbtn" class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon">
              <i class="material-icons" role="presentation">arrow_drop_down</i>
              <span class="visuallyhidden">Accounts</span>
            </button>
            <ul class="mdl-menu mdl-menu--bottom-right mdl-js-menu mdl-js-ripple-effect" for="accbtn">
              <li class="mdl-menu__item" onClick="(function(){window.location='<?=base_url()?>logout'})();">Logout</li>
            </ul>
          </div>
        </header>
        <nav class="demo-navigation mdl-navigation">

          <a class="mdl-navigation__link" href="<?=base_url()?>attendance"><i class="material-icons" role="presentation">list_alt</i>Attendance</a>
          <a class="mdl-navigation__link" href="<?=base_url()?>student"><i class="material-icons" role="presentation">list_alt</i>Students</a>

          <div class="mdl-layout-spacer"></div>
          <button class="mdl-menu__item mdl-navigation__link" id="btnAbout"><i class="material-icons" role="presentation">help_outline</i><span class="visuallyhidden">About</span>
        </nav>
      </div>