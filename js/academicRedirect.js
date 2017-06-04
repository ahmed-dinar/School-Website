/**
 * Created by ahmed-dinar on 6/5/17.
 */

$(function() {

    // bind change event to select
    $('#classList').on('change', function() {
        var targetClass = $(this).val();
        var targetGroup = $("#groupList").val();
        redirectTO(targetClass,targetGroup);
    });

    $('#groupList').on('change', function() {
        var targetGroup = $(this).val();
        var targetClass = $("#classList").val();
        redirectTO(targetClass,targetGroup);
    });
});

function redirectTO(targetClass, targetGroup) {
    var url = 'classRoutine.php';
    var isand = false;
    if( targetClass !== ''  ) {
        url += '?class=' + targetClass;
        isand = true;
    }
    if( targetGroup !== '' ) {
        url += isand ? '&' : '?';
        url += 'group=' + targetGroup;
    }
    window.location.replace(url);
}