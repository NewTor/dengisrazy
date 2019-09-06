<?php
/* @var $this yii\web\View */
$this->title = 'My Test Application';
?>
<div class="site-index">
    <div class="body-content">
        <form id="data-form">
        <div class="row">
            <div class="col-lg-12">
                <div id="alert" class="alert alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <div class="alert-message"></div>
                </div>
                    <div class="form-group">
                        <label for="rangeList">Количество</label>
                        <input type="range" id="rangeList" min="1" max="10" step="1" value="5" list="rangeList" onchange="document.getElementById('rangeValue').innerHTML = this.value;">
                        <span id="rangeValue">5</span>
                        <div class="range-value"></div>
                    </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6">
                <label for="email">E-mail</label>
                <input class="form-control" type="email" id="email" name="email" placeholder="Введите E-mail">
            </div>
            <div class="col-lg-6">
                <label for="fio">ФИО</label>
                <input class="form-control" type="text" id="fio" name="fio" placeholder="Введите ФИО">
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12" style="padding-top: 20px;">
                <input type="submit" value="Submit">
            </div>
        </div>
        </form>
    </div>
</div>
