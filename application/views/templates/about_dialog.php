<dialog class="mdl-dialog" id="aboutDialog">
    <h4 class="mdl-dialog__title">About App</h4>
    <div class="mdl-dialog__content">
        <div style="z-index: 9000; position: fixed;">
            <a href="https://orpheus.digital" class="shadowLink">
                <img src='<?=base_url().'assets/images/512B.png';?>' >
            </a>
        </div>
        <div style="position: fixed;">
            <img class="xspinner" src='<?=base_url().'assets/images/512Empty.png';?>' >
        </div>
        <div style="position: relative;">
            <img src='<?=base_url().'assets/images/orpheus.png';?>'>
        </div>
        <p> 
            <br/>
            System Designed by Orpheus Digital
        </p>
        <p>
        Version: 1.0.0
        </p>
        <p>
            Copyrights © <a href="https://orpheus.digital" id="aboutLink">Solved by Orpheus</a> 2020
        </p>
    </div>
    <div class="mdl-dialog__actions">
      <button type="button" class="mdl-button close">Close</button>
    </div>
</dialog>

<link rel="stylesheet" href="<?=base_url().'assets/dialog-polyfill/';?>/dialog-polyfill.css">  
<script src="<?=base_url().'assets/dialog-polyfill/';?>/dialog-polyfill.js"></script>

<script>
  (function() {
    'use strict';
    var dialogButton = document.querySelector('#btnAbout');
    var dialog = document.querySelector('#aboutDialog');
    if (! dialog.showModal) {
      dialogPolyfill.registerDialog(dialog);
    }
    dialogButton.addEventListener('click', function() {
       dialog.showModal();
    });
    dialog.querySelector('button:not([disabled])')
    .addEventListener('click', function() {
      dialog.close();
    });
  }());
</script>
<style>
#aboutLink {
    color: #0f9;
    -webkit-transition: all .3s ease-in;
    -ms-transition: all .3s ease-in;
    -moz-transition: all .3s ease-in;
    transition: all .3s ease-in;
}
#aboutLink:hover {
    color: #000;
}
#btnAbout {
    width: 100%;
}
.mdl-dialog {
    border: none;
    box-shadow: 0 9px 46px 8px rgba(0, 0, 0, 0.14), 0 11px 15px -7px rgba(0, 0, 0, 0.12), 0 24px 38px 3px rgba(0, 0, 0, 0.2);
    width: 300px;
}
.mdl-dialog__title {
    padding: 24px 24px 0;
    margin: 0;
    font-size: 2.5rem;
}
.mdl-dialog__actions {
    padding: 8px 8px 8px 24px;
    display: -webkit-flex;
    display: -ms-flexbox;
    display: flex;
    -webkit-flex-direction: row-reverse;
        -ms-flex-direction: row-reverse;
            flex-direction: row-reverse;
    -webkit-flex-wrap: wrap;
        -ms-flex-wrap: wrap;
            flex-wrap: wrap; 
}
.mdl-dialog__actions > * {
    margin-right: 8px;
    height: 36px; 
}
.mdl-dialog__actions > *:first-child {
    margin-right: 0; 
}
.mdl-dialog__actions--full-width {
    padding: 0 0 8px 0;
}
.mdl-dialog__actions--full-width > * {
    height: 48px;
    -webkit-flex: 0 0 100%;
        -ms-flex: 0 0 100%;
        flex: 0 0 100%;
    padding-right: 16px;
    margin-right: 0;
    text-align: right;
}
.mdl-dialog__content {
    padding: 20px 24px 24px 24px;
    color: rgba(0,0,0, 0.54); 
}
</style>

