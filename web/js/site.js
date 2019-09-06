'use strict';

var spApplication = spApplication || {};
spApplication.Config = {};
/**
 *
 */
spApplication.Config.ColorValues = {
    1:  'green',
    2:  'green',
    3:  'green',
    4:  'yellow',
    5:  'yellow',
    6:  'yellow',
    7:  'red',
    8:  'red',
    9:  'black',
    10: 'black'
};
/**
 *
 */
spApplication.Config.Values = {
    Default: 5,
    Min: 1,
    Max: 10,
    Step: 1
};
/**
 *
 */
spApplication.Error = {};
spApplication.Error.errorCodes = {
    emptyFio: 'Не заполнено поле ФИО',
    wrongFio: 'Не корректное поле ФИО',
    emptyEmail: 'Не заполнено поле E-mail',
    wrongEmail: 'Не корректный E-mail',
    existsEmail: 'Данный E-mail уже существует',
    dataSuccess: 'Информация успешно добавлена',
    wrongPostData: 'Не корректный запрос'
};
/**
 *
 */
spApplication.Error.serverErrorCodes = {
    0: spApplication.Error.errorCodes.dataSuccess,
    1: spApplication.Error.errorCodes.emptyFio,
    2: spApplication.Error.errorCodes.wrongFio,
    3: spApplication.Error.errorCodes.emptyEmail,
    4: spApplication.Error.errorCodes.wrongEmail,
    5: spApplication.Error.errorCodes.existsEmail,
    6: spApplication.Error.errorCodes.wrongPostData
};
/**
 *
 */
spApplication.Controllers = {
    /**
     *
     */
    setRangeValues: function (rangeCount) {
        rangeCount = isNaN(rangeCount) ? spApplication.Config.Values.Default : rangeCount;
        var rangeList = $('#rangeList');
        var rangeValue = $('.range-value');
        rangeList.prop({
            min: spApplication.Config.Values.Min,
            max: spApplication.Config.Values.Max,
            step: spApplication.Config.Values.Step,
            value: spApplication.Config.Values.rangeCount
        });
        rangeValue.css({backgroundColor: spApplication.Config.ColorValues[rangeCount]});
    },
    /**
     *
     */
    saveData: function (json, callback) {
        $.post('save-data', {json: json}, function(result) {
            callback(result);
        });
    },
    /**
     *
     */
    alertResult: function (message, alertClass) {
        $("#alert div.alert-message").html(message);
        $("#alert")
            .removeClass('alert-danger').removeClass('alert-success')
            .addClass(alertClass).show();
    }
};
/**
 *
 */
$(function () {
    /**
     *
     */
    spApplication.Controllers.setRangeValues();
    /**
     *
     */
    $('#rangeList').on('change', function () {
        spApplication.Controllers.setRangeValues($(this).val());
    });
    /**
     *
     */
    $('#data-form').on('submit', function () {
        var options = {
            email:     $('#email').val(),
            fio:       $('#fio').val(),
            rangeList: $('#rangeList').val()
        };
        var json = JSON.stringify(options);
        spApplication.Controllers.saveData(json, function (result) {
            var res = JSON.parse(result);
            if(res.error) {
                spApplication.Controllers.alertResult(spApplication.Error.serverErrorCodes[res.data.resultErrorCode], 'alert-danger');
            } else {
                spApplication.Controllers.alertResult(spApplication.Error.serverErrorCodes[res.data.resultErrorCode] + 'Результат процедуры sp_SaveData: ' + res.data.result, 'alert-success');
                $('#email').val('');
                $('#fio').val('');
            }
        });
        return false;
    });

});


