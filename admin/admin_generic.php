<?php
function verpan($val){
    $accepter = $val['accepter'];
    if(!isset($accepter)){ 
        $accepter = "Probably you.";
    }
    echo '<div class="v-panel">
    <div class="image">
        <img src="' . grabshots($val)[0] . '"
            class="ver-img">
    </div>
    <div class="texts">
        <div class="texts-header">
            <h1 class="th-name">' . $val['Version'] . '</h1>
            <p class="th-archive">archived by ' . $val['Archiver'] . '</p>
            <p class="th-accept">accepted by ' . $accepter . '</p>
        </div>
        <div class="texts-middle">
            <p class="tm-date">Version uploaded ' . $val["DateAdded"] . '</p>
        </div>
        <div class="v-actions">
            <a class="pv2button inbut v-action v-action-first">
                <div class="pv2b-line">
                </div>
                <div class="pv2b-text">
                    edit submission
                </div>
            </a>
            <a class="pv2button inbut v-action">
                <div class="pv2b-line">
                </div>
                <div class="pv2b-text">
                    delete submission
                </div>
            </a>
        </div>
    </div>
</div>';
}