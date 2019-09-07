'use strict';

var spApplication = spApplication || {};
spApplication.Config = {};
/**
 * Установки цветов по значениям бегунка
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
 * Дефолтные значения бегунка
 */
spApplication.Config.Values = {
    Default: 5,
    Min: 1,
    Max: 10,
    Step: 1
};
/**
 * Сообщения о результатах ответа
 */
spApplication.Error = {};
spApplication.Error.errorCodes = {
    emptyFio: 'Не заполнено поле ФИО.',
    wrongFio: 'Не корректное поле ФИО.',
    emptyEmail: 'Не заполнено поле E-mail.',
    wrongEmail: 'Не корректный E-mail.',
    existsEmail: 'Данный E-mail уже существует.',
    dataSuccess: 'Информация успешно добавлена.',
    wrongPostData: 'Не корректный запрос.'
};
/**
 * Коды сообщений
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
 * Обработка событий на странице
 */
spApplication.Controllers = {
    /**
     * Установка значений бегунка
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
     * Сохранение данных
     */
    saveData: function (json, callback) {
        $.post('save-data', {json: json}, function(result) {
            callback(result);
        });
    },
    /**
     * Вывод результата ответа сервера
     */
    alertResult: function (message, alertClass) {
        $("#alert div.alert-message").html(message);
        $("#alert")
            .removeClass('alert-danger').removeClass('alert-success')
            .addClass(alertClass).show();
    }
};
/**
 * Действия при загрузке
 */
$(function () {
    /**
     * Установка дефолтных значений
     */
    spApplication.Controllers.setRangeValues();
    /**
     * Установка изменений
     */
    $('#rangeList').on('change', function () {
        spApplication.Controllers.setRangeValues($(this).val());
    });
    /**
     * Заглушка при отправке формы
     */
    $('#data-form').on('submit', function () {
        // Параметры
        var options = {
            email:     $('#email').val(),
            fio:       $('#fio').val(),
            rangeList: $('#rangeList').val()
        };
        var json = JSON.stringify(options);
        // Вызов сохранения данных
        spApplication.Controllers.saveData(json, function (result) {
            var res = JSON.parse(result);
            if(res.error) {
                // Ошибочный результат
                spApplication.Controllers.alertResult(spApplication.Error.serverErrorCodes[res.data.resultErrorCode], 'alert-danger');
            } else {
                // Успешная обработка параметров
                spApplication.Controllers.alertResult(spApplication.Error.serverErrorCodes[res.data.resultErrorCode] + ' Результат процедуры sp_SaveData: ' + res.data.result, 'alert-success');
                $('#email').val('');
                $('#fio').val('');
            }
        });
        return false;
    });

});
